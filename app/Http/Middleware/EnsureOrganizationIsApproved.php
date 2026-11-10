<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureOrganizationIsApproved
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check if user is authenticated and has an organization record
        if ($user && $user->role !== 'admin') {
            $organization = $user->organization; // Assuming a hasOne relationship on User model

            // If organization is not approved, block access to redistribution features
            if (!$organization || strtolower($organization->verification_status) !== 'approved') {
                return redirect()->route('dashboard')
                    ->with('error', 'Your organization verification is still pending. You cannot access redistribution features yet.');
            }
        }

        return $next($request);
    }
}