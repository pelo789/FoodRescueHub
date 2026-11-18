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

        // Redirect unauthenticated users to login.
        if (!$user) {
            return redirect()->route('login');
        }

        // Administrators are exempt from organization verification.
        if ($user->isAdministrator()) {
            return $next($request);
        }

        // Only food providers and recipient organizations
        // require verification before redistribution activities.
        if (
            in_array(
                $user->role,
                ['food_provider', 'recipient_organization'],
                true
            )
            && !$user->isOrganizationVerified()
        ) {
            return redirect()->route('dashboard')
                ->with(
                    'error',
                    'Your organization must be verified before participating in redistribution activities.'
                );
        }

        return $next($request);
    }
}
