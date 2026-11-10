<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display the admin verification review list.
     */
    public function index()
    {
        // Ensure only administrators can access this view (BRD Rule 5)
        if (auth()->user()->role !== 'administrator') {
            abort(403, 'Unauthorized action.');
        }

        $pendingUsers = User::where('verification_status', 'Pending')->get();

        return view('admin.verifications', compact('pendingUsers'));
    }

    /**
     * Handle administrator decision on organization verification.
     */
    public function updateVerificationStatus(Request $request, $id)
    {
        // 1. Ensure only administrators can perform this action (BRD Rule 5)
        if (auth()->user()->role !== 'administrator') {
            abort(403, 'Unauthorized action.');
        }

        // 2. Validate the requested status
        $request->validate([
            'verification_status' => ['required', 'in:Verified,Rejected,Additional Information Required'],
        ]);

        // 3. Find the user/organization and update their status
        $targetUser = User::findOrFail($id);
        
        $targetUser->update([
            'verification_status' => $request->verification_status,
        ]);

        return back()->with('success', 'Organization verification status updated to ' . $request->verification_status . '.');
    }
}