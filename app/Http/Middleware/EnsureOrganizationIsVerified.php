<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOrganizationIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Check if user is logged in and NOT verified
        if ($user && $user->verification_status !== 'Verified') {
            // Administrators are exempt from this restriction
            if ($user->role !== 'administrator') {
                return redirect()->route('dashboard')
                    ->with('error', 'Your organization verification status is currently "' . $user->verification_status . '". You must be verified by an administrator to perform this action.');
            }
        }

        return $next($request);
    }
}