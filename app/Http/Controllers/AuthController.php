<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'organization_name' => 'required|string|max:150',
            'role' => 'required|in:food_provider,recipient_organization',
            'email' => 'required|email|max:150|unique:users,email',

            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],

            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',

            'verification_document' =>
                'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Store the document on Laravel's private local disk.
        $documentPath = $validated['verification_document']
            ->store('verification-documents', 'local');

        User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'organization_name' => $validated['organization_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,

            'role' => $validated['role'],
            'status' => 'active',
            'verification_status' => 'pending',
            'verification_document' => $documentPath,
        ]);

        return redirect()->route('login')
            ->with(
                'success',
                'Registration successful! Your organization is awaiting verification. You may log in, but redistribution features will remain unavailable until approval.'
            );
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials['status'] = 'active';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'Invalid credentials or your account is inactive.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out.');
    }
}
