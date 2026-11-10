<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Ensure only admins can access these methods
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role === 'admin') {
                return $next($request);
            }
            abort(403, 'Unauthorized action.');
        });
    }

    // 1. VIEW VERIFICATION QUEUE
    public function index(Request $request)
    {
        $status = $request->get('status', 'Pending');
        
        $organizations = Organization::with('user')
            ->where('verification_status', $status)
            ->latest()
            ->paginate(10);

        return view('admin.verifications.index', compact('organizations', 'status'));
    }

    // 2. VIEW ORGANIZATION DETAILS
    public function show($id)
    {
        $organization = Organization::with('user')->findOrFail($id);

        return view('admin.verifications.show', compact('organization'));
    }

    // 3. UPDATE VERIFICATION STATUS
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'verification_status' => 'required|in:Verified,Rejected,Additional Information Required',
        ]);

        $organization = Organization::findOrFail($id);
        $organization->verification_status = $request->verification_status;
        $organization->save();

        return redirect()->route('admin.verifications', ['status' => $request->verification_status])
            ->with('success', 'Organization verification status updated to ' . $request->verification_status . '.');
    }
}