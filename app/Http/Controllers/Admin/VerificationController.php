<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VerificationController extends Controller
{
    /**
     * Display organization verification requests.
     */
    public function index(Request $request): View
    {
        $allowedStatuses = [
            'pending',
            'verified',
            'rejected',
            'additional information required',
        ];

        $status = strtolower(trim($request->query('status', 'pending')));

        if (!in_array($status, $allowedStatuses, true)) {
            $status = 'pending';
        }

        $databaseStatus = match ($status) {
            'pending' => 'Pending',
            'verified' => 'Verified',
            'rejected' => 'Rejected',
            'additional information required' => 'Additional Information Required',
        };

        $organizations = Organization::with('user')
            ->where('verification_status', $databaseStatus)
            ->whereHas('user', function ($query) {
                $query->whereIn('role', [
                    'food_provider',
                    'recipient_organization',
                ]);
            })
            ->orderBy('created_at', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.verifications.index', compact(
            'organizations',
            'status'
        ));
    }

    /**
     * View or download an organization's verification document.
     */
    public function viewDocument(User $user): StreamedResponse
    {
        $organization = $this->getOrganization($user);

        abort_if(
            empty($organization->verification_document),
            404,
            'No verification document was uploaded.'
        );

        $disk = Storage::disk('local');

        abort_unless(
            $disk->exists($organization->verification_document),
            404,
            'Verification document not found.'
        );

        return $disk->download(
            $organization->verification_document
        );
    }

    /**
     * Approve an organization.
     */
    public function approve(User $user): RedirectResponse
    {
        $organization = $this->getOrganization($user);

        abort_if(
            strtolower($organization->verification_status) !== 'pending',
            403,
            'This organization is no longer awaiting verification.'
        );

        abort_if(
            empty($organization->verification_document)
            || !Storage::disk('local')->exists(
                $organization->verification_document
            ),
            422,
            'This organization has no available verification document.'
        );

        $organization->verification_status = 'Verified';
        $organization->verification_remarks = null;
        $organization->save();

        return redirect()
            ->route('admin.verifications.index')
            ->with(
                'success',
                $organization->organization_name . ' has been approved.'
            );
    }

    /**
     * Reject an organization.
     */
    public function reject(User $user): RedirectResponse
    {
        $organization = $this->getOrganization($user);

        abort_if(
            strtolower($organization->verification_status) !== 'pending',
            403,
            'This organization is no longer awaiting verification.'
        );

        $organization->verification_status = 'Rejected';
        $organization->verification_remarks = null;
        $organization->save();

        return redirect()
            ->route('admin.verifications.index')
            ->with(
                'success',
                $organization->organization_name . ' has been rejected.'
            );
    }

    /**
     * Request additional information from an organization.
     */
    public function requestAdditionalInformation(
        Request $request,
        User $user
    ): RedirectResponse {
        $validated = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $organization = $this->getOrganization($user);

        abort_if(
            strtolower(trim($organization->verification_status)) !== 'pending',
            403,
            'This organization is no longer awaiting verification.'
        );

        $organization->verification_status =
            'Additional Information Required';

        $organization->verification_remarks = $validated['reason'];

        $organization->save();

        return redirect()
            ->route('admin.verifications.index', [
                'status' => 'additional information required',
            ])
            ->with(
                'success',
                'Additional information requested from '
                . $organization->organization_name . '.'
            );
    }

    /**
     * Find the organization belonging to the selected user.
     */
    private function getOrganization(User $user): Organization
    {
        abort_unless(
            in_array($user->role, [
                'food_provider',
                'recipient_organization',
            ], true),
            404
        );

        $organization = Organization::where(
            'user_id',
            $user->user_id
        )->first();

        abort_if(
            !$organization,
            404,
            'Organization record not found.'
        );

        return $organization;
    }
}
