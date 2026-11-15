<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOrganizationIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Admins bypass verification check
        if ($user && in_array($user->role, ['admin', 'administrator'], true)) {
            return $next($request);
        }

        // Check if user's organization is verified
        $organization = $user->organization ?? null; // Make sure User model has organization() relation

        if (!$organization || $organization->verification_status !== 'Verified') {
            return redirect()->route('dashboard')
                ->with('error', 'Your organization must be verified by an administrator to perform this action.');
        }

        return $next($request);
    }
}