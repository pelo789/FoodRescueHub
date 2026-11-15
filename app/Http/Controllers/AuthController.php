<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // SHOW REGISTER PAGE
    public function showRegister()
    {
        return view('auth.register');
    }

    // REGISTER USER
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'role' => 'required|in:food_provider,recipient_organization',
            'organization_name' => 'required|string|max:255',
            'organization_address' => 'required|string|max:255',
            'supporting_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        // Handle file upload
        $documentPath = null;
        if ($request->hasFile('supporting_document')) {
            $documentPath = $request->file('supporting_document')->store('verification_documents', 'public');
        }

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'role' => $validated['role'],
            'status' => 'active', 
        ]);

        $orgTypeLabel = $validated['role'] === 'food_provider' 
            ? 'Food Provider' 
            : 'Recipient Organization';

        $organization = Organization::create([
            'user_id' => $user->user_id,
            'organization_name' => $validated['organization_name'],
            'organization_type' => $orgTypeLabel,
            'organization_address' => $validated['organization_address'],
            'verification_status' => 'Pending',
            'verification_document' => $documentPath,
        ]);

        return redirect()->route('login')
            ->with('registration_submitted', true);
    }

    // SHOW LOGIN PAGE
    public function showLogin()
    {
        return view('auth.login');
    }

    // LOGIN USER
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt authentication using email and password only (removing hardcoded status check here)
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Handle Banned / Suspended / Deactivated account statuses
            if ($user->status === 'inactive' || $user->status === 'banned') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withErrors(['email' => 'Your account is inactive or suspended.'])
                    ->onlyInput('email');
            }

            $request->session()->regenerate();

            // Role-based redirection after login
            if ($user->role === 'admin') {
                return redirect()->route('dashboard');
            } elseif ($user->role === 'food_provider') {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }

        return back()
            ->withErrors([
                'email' => 'Invalid credentials.',
            ])
            ->onlyInput('email');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out.');
    }
}