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

        'organization_name' => 'required|string|max:255',

        'organization_type' => 'required|string|max:100',
        ]);

        $user = User::create([
        'first_name' => $validated['first_name'],
        'last_name' => $validated['last_name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'phone' => $validated['phone'],
        'address' => $validated['address'],

        'role' => 'organization', // Default role for new users
        'status' => 'active', // Default status for new users
        ]);

        $organization = Organization::create([
            'user_id' => $user->user_id,
            'organization_name' => $validated['organization_name'],
            'organization_type' => $validated['organization_type'],
            'verification_status' => 'pending',
        ]);

        return redirect()->route('login')
            ->with('success', 'Registration successful! Please login.');
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

        $credentials['status'] = 'active';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'Invalid credentials or account is inactive.',
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