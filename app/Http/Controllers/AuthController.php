<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    public function showRegister()
    {
        return view('auth.register');
    }
    /**
     * Handle user login attempts and enforce BRD account statuses.
     */
    public function login(Request $request)
    {
        // 1. Validate form inputs
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Attempt to log the user in using Auth::attempt
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // 3. BRD CHECK: Block Suspended or Deactivated accounts
            if (in_array($user->account_status, ['Suspended', 'Deactivated'])) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Your account has been ' . strtolower($user->account_status) . '. Please contact the system administrator.',
                ])->onlyInput('email');
            }

            return redirect()->intended('dashboard');
        }

        // 4. If credentials fail
        return back()->withErrors([
            'email' => __('auth.failed'),
        ])->onlyInput('email');
    }

    /**
     * Handle organization registration, document upload, and BRD defaults.
     */
    public function register(Request $request)
    {
        // 1. Validate inputs including organization details and document upload
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:food_provider,recipient_organization'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            // Verification document upload validation (PDF, JPG, PNG)
            'verification_document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        // 2. Handle file upload for verification document
        $documentPath = null;
        if ($request->hasFile('verification_document')) {
            $documentPath = $request->file('verification_document')->store('verification_documents', 'public');
        }

        // 3. Create user with BRD-mandated defaults
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
            'verification_status' => 'Pending', // BRD Rule: defaults to Pending[cite: 3, 6]
            'account_status' => 'Active',       // BRD Rule: defaults to Active[cite: 3, 9]
            'document_path' => $documentPath,    // Store verification document path
        ]);

        // 4. Log the user in and redirect to dashboard
        auth()->login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Registration successful! Your account is currently Pending administrator verification.');
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}