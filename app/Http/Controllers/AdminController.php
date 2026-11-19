<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    private function ensureAdmin()
    {
        if (!Auth::check() || !Auth::user()->isAdministrator()) {
            abort(403, 'Unauthorized action.');
        }
    }

    // 1. VIEW VERIFICATION QUEUE (INNER JOIN: organizations + users)
    public function index(Request $request)
    {
        $this->ensureAdmin();

        $status = $request->get('status', 'Pending');

        $pendingUsers = DB::table('organizations')
            ->join('users', 'organizations.user_id', '=', 'users.user_id')
            ->select(
                'organizations.organization_id',
                'organizations.organization_name',
                'organizations.organization_address',
                'organizations.verification_document',
                'organizations.verification_status',
                'organizations.verification_remarks',
                'users.user_id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.phone',
                'users.role'
            )
            ->when($status, function ($query, $status) {
                return $query->where('organizations.verification_status', $status);
            })
            ->orderBy('organizations.created_at', 'desc')
            ->get();

        return view('admin.verifications', compact('pendingUsers', 'status'));
    }

        // VIEW SINGLE ORGANIZATION DETAILS (INNER JOIN: organizations + users)
    public function show($organizationId)
    {
        $this->ensureAdmin();

        $organization = DB::table('organizations')
            ->join('users', 'organizations.user_id', '=', 'users.user_id')
            ->select(
                'organizations.*',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.phone',
                'users.role',
                'users.status as user_status',
                'users.created_at as user_created_at'
            )
            ->where('organizations.organization_id', $organizationId)
            ->first();

        abort_if(!$organization, 404, 'Organization not found.');

        return view('admin.organization-details', compact('organization'));
    }


    // 2. VIEW PRIVATE VERIFICATION DOCUMENT
    public function viewDocument($organizationId)
    {
        $this->ensureAdmin();

        $organization = Organization::findOrFail($organizationId);

        abort_unless(
            $organization->verification_document && Storage::disk('local')->exists($organization->verification_document),
            404,
            'Verification document not found.'
        );

        return Storage::disk('local')->response($organization->verification_document);
    }

    // 3. UPDATE VERIFICATION STATUS (DB::transaction across organizations & users)
    public function updateStatus(Request $request, $organizationId)
    {
        $this->ensureAdmin();

        $request->validate([
            'verification_status' => 'required|in:Verified,Rejected,Additional Information Required',
            'verification_remarks' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request, $organizationId) {
            $organization = Organization::findOrFail($organizationId);
            $organization->verification_status = $request->verification_status;
            $organization->verification_remarks = $request->verification_remarks ?? null;
            $organization->save();

            // Sync account status in users table for data consistency
            $userStatus = $request->verification_status === 'Rejected' ? 'inactive' : 'active';
            User::where('user_id', $organization->user_id)->update(['status' => $userStatus]);
        });

        return redirect()->route('admin.verifications.index')
            ->with('success', 'Organization verification status updated to ' . $request->verification_status . '.');
    }

    // 4. VIEW ALL USERS (LEFT JOIN: users + organizations, includes admins)
    public function users()
    {
        $this->ensureAdmin();

        $users = DB::table('users')
            ->leftJoin('organizations', 'users.user_id', '=', 'organizations.user_id')
            ->select(
                'users.user_id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.role',
                'users.status',
                'organizations.organization_name',
                'organizations.verification_status'
            )
            ->orderBy('users.created_at', 'desc')
            ->get();

        return view('admin.users.index', compact('users'));
    }
}
