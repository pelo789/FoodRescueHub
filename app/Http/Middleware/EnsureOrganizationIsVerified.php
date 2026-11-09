<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOrganizationIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isAdministrator()) {
            return $next($request);
        }

        if (
            in_array($user->role, [
                'food_provider',
                'recipient_organization'
            ], true)
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