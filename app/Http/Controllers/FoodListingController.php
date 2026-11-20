<?php

namespace App\Http\Controllers;

use App\Models\FoodListing;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodListingController extends Controller
{
    /**
     * Display food listings.
     */
    public function index()
    {
        $user = Auth::user();
        $role = strtolower(str_replace(' ', '_', trim($user->role ?? '')));

        if ($role === 'food_provider') {
            $organization = $this->getUserOrganization();

            $foodListings = FoodListing::where(
                'organization_id',
                $organization->organization_id
            )
                ->latest()
                ->get();
        } elseif ($role === 'recipient_organization') {
            $foodListings = FoodListing::with('organization')
                ->where('available_quantity', '>', 0)
                ->where('status', '!=', 'Withdrawn')
                ->whereDate('expiration_date', '>=', today())
                ->latest()
                ->get();
        } else {
            abort(403, 'You are not authorized to view food listings.');
        }

        return view('food-listings.index', compact('foodListings'));
    }

    /**
     * Show the create listing form.
     */
    public function create()
    {
        $this->ensureFoodProvider();

        return view('food-listings.create');
    }

    /**
     * Store a newly created food listing.
     */
    public function store(Request $request)
    {
        $this->ensureFoodProvider();

        $organization = $this->getUserOrganization();

        $validated = $request->validate([
            'food_name' => 'required|string|max:150',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'expiration_date' => 'required|date|after_or_equal:today',
            'storage_requirement' => 'required|string|max:150',
            'food_condition' => 'required|string|max:100',
            'allergen_information' => 'nullable|string',
            'pickup_details' => 'nullable|string',
        ]);

        FoodListing::create([
            'organization_id' => $organization->organization_id,
            'food_name' => $validated['food_name'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,

            'quantity' => $validated['quantity'],
            'available_quantity' => $validated['quantity'],
            'reserved_quantity' => 0,
            'redistributed_quantity' => 0,

            'expiration_date' => $validated['expiration_date'],
            'storage_requirement' => $validated['storage_requirement'],
            'food_condition' => $validated['food_condition'],
            'allergen_information' => $validated['allergen_information'] ?? null,
            'pickup_details' => $validated['pickup_details'] ?? null,

            'status' => 'Available',
        ]);

        return redirect()
            ->route('food-listings.index')
            ->with('success', 'Food listing created successfully.');
    }

    /**
     * Display a specific food listing.
     */
    public function show($food_listing)
    {
        $user = Auth::user();
        $role = strtolower(str_replace(' ', '_', trim($user->role ?? '')));

        $foodListing = FoodListing::with('organization')
            ->findOrFail($food_listing);

        if ($role === 'food_provider') {
            $organization = $this->getUserOrganization();

            abort_unless(
                $foodListing->organization_id === $organization->organization_id,
                403,
                'You cannot view another organization\'s listing.'
            );
        } elseif ($role === 'recipient_organization') {
            abort_if(
                $foodListing->status === 'Withdrawn' ||
                $foodListing->available_quantity <= 0 ||
                $foodListing->expiration_date->isBefore(today()),
                404,
                'This food listing is no longer available.'
            );
        } else {
            abort(403, 'You are not authorized to view this listing.');
        }

        return view('food-listings.show', compact('foodListing'));
    }

    /**
     * Show the edit listing form.
     */
    public function edit($food_listing)
    {
        $this->ensureFoodProvider();

        $foodListing = $this->getProviderListing($food_listing);

        abort_if(
            $foodListing->status === 'Withdrawn',
            403,
            'Withdrawn listings cannot be edited.'
        );

        return view('food-listings.edit', compact('foodListing'));
    }

    /**
     * Update an existing food listing.
     */
    public function update(Request $request, $food_listing)
    {
        $this->ensureFoodProvider();

        $foodListing = $this->getProviderListing($food_listing);

        abort_if(
            $foodListing->status === 'Withdrawn',
            403,
            'Withdrawn listings cannot be edited.'
        );

        $validated = $request->validate([
            'food_name' => 'required|string|max:150',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'expiration_date' => 'required|date|after_or_equal:today',
            'storage_requirement' => 'required|string|max:150',
            'food_condition' => 'required|string|max:100',
            'allergen_information' => 'nullable|string',
            'pickup_details' => 'nullable|string',
        ]);

        $alreadyAllocated = $foodListing->reserved_quantity
            + $foodListing->redistributed_quantity;

        if ($validated['quantity'] < $alreadyAllocated) {
            return back()
                ->withInput()
                ->withErrors([
                    'quantity' => 'The total quantity cannot be less than the reserved and redistributed quantities combined.',
                ]);
        }

        $foodListing->food_name = $validated['food_name'];
        $foodListing->category = $validated['category'];
        $foodListing->description = $validated['description'] ?? null;

        $foodListing->quantity = $validated['quantity'];

        // Preserve reserved and redistributed quantities.
        $foodListing->available_quantity =
            $validated['quantity'] - $alreadyAllocated;

        $foodListing->expiration_date = $validated['expiration_date'];
        $foodListing->storage_requirement = $validated['storage_requirement'];
        $foodListing->food_condition = $validated['food_condition'];
        $foodListing->allergen_information =
            $validated['allergen_information'] ?? null;
        $foodListing->pickup_details =
            $validated['pickup_details'] ?? null;

        $foodListing->status = $this->calculateStatus($foodListing);

        $foodListing->save();

        return redirect()
            ->route('food-listings.index')
            ->with('success', 'Food listing updated successfully.');
    }

    /**
     * Withdraw a food listing instead of permanently deleting it.
     */
    public function destroy($food_listing)
    {
        $this->ensureFoodProvider();

        $foodListing = $this->getProviderListing($food_listing);

        if ($foodListing->reserved_quantity > 0) {
            return back()->with(
                'error',
                'This listing cannot be withdrawn while it has reserved food.'
            );
        }

        $foodListing->status = 'Withdrawn';
        $foodListing->save();

        return redirect()
            ->route('food-listings.index')
            ->with('success', 'Food listing withdrawn successfully.');
    }

    /**
     * Get the authenticated user's organization.
     */
    private function getUserOrganization(): Organization
    {
        return Organization::where('user_id', Auth::id())
            ->firstOrFail();
    }

    /**
     * Ensure that the authenticated user is a food provider.
     */
    private function ensureFoodProvider(): void
    {
        $role = strtolower(
            str_replace(' ', '_', trim(Auth::user()->role ?? ''))
        );

        abort_unless(
            $role === 'food_provider',
            403,
            'Only food providers can perform this action.'
        );
    }

    /**
     * Retrieve a listing owned by the authenticated provider.
     */
    private function getProviderListing($food_listing): FoodListing
    {
        $organization = $this->getUserOrganization();

        return FoodListing::where(
            'organization_id',
            $organization->organization_id
        )
            ->findOrFail($food_listing);
    }

    /**
     * Calculate the listing status based on inventory quantities.
     */
    private function calculateStatus(FoodListing $foodListing): string
    {
        if ($foodListing->expiration_date->isBefore(today())) {
            return 'Expired';
        }

        if (
            $foodListing->available_quantity === 0 &&
            $foodListing->reserved_quantity > 0
        ) {
            return 'Fully Reserved';
        }

        if (
            $foodListing->available_quantity === 0 &&
            $foodListing->redistributed_quantity > 0
        ) {
            return 'Fully Redistributed';
        }

        if ($foodListing->redistributed_quantity > 0) {
            return 'Partially Redistributed';
        }

        if ($foodListing->reserved_quantity > 0) {
            return 'Partially Reserved';
        }

        return 'Available';
    }
}