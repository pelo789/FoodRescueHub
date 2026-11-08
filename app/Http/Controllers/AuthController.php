<?php

namespace App\Http\Controllers; // KEEP THIS AT THE TOP

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller // (Note: your class name might be LoginController or something similar)
{
    // Put your login method INSIDE these class brackets
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

            // Note: Pending users are intentionally allowed to pass through here 
            // to view their dashboard and check verification status (BRD Rule 8).

            return redirect()->intended('dashboard');
        }

        // 4. If credentials fail
        return back()->withErrors([
            'email' => __('auth.failed'),
        ])->onlyInput('email');
    }

    // Any other methods you have go here...
}