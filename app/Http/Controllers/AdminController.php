<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private function ensureAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    }

    // 1. VIEW VERIFICATION QUEUE (Uses INNER JOIN)
    public function index(Request $request)
    {
        $this->ensureAdmin();

        $status = $request->get('status', 'Pending');

        // INNER JOIN between organizations and users
        $organizations = Organization::join('users', 'organizations.user_id', '=', 'users.user_id')
            ->select(
                'organizations.*',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.role',
                'users.status as user_status'
            )
            ->when($status, function ($query, $status) {
                return $query->where('organizations.verification_status', $status);
            })
            ->orderBy('organizations.created_at', 'desc')
            ->paginate(10);

        return view('admin.verifications.index', compact('organizations', 'status'));
    }

    // 2. VIEW ORGANIZATION DETAILS (Uses INNER JOIN)
    public function show($id)
    {
        $this->ensureAdmin();

        $organization = Organization::join('users', 'organizations.user_id', '=', 'users.user_id')
            ->select(
                'organizations.*',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.phone',
                'users.role'
            )
            ->where('organizations.organization_id', $id)
            ->firstOrFail();

        return view('admin.verifications.show', compact('organization'));
    }

    // 3. UPDATE VERIFICATION STATUS (Uses DB::transaction across related tables)
    public function updateStatus(Request $request, $id)
    {
        $this->ensureAdmin();

        $request->validate([
            'verification_status' => 'required|in:Verified,Rejected,Additional Information Required',
        ]);

        DB::transaction(function () use ($request, $id) {
            $organization = Organization::findOrFail($id);
            $organization->verification_status = $request->verification_status;
            $organization->save();

            // Keep user account status consistent with verification status
            if ($request->verification_status === 'Verified') {
                User::where('user_id', $organization->user_id)->update(['status' => 'active']);
            }
        });

        return redirect()->route('admin.verifications', ['status' => $request->verification_status])
            ->with('success', 'Organization verification status updated to ' . $request->verification_status . '.');
    }

    // 4. VIEW ALL USERS (Uses LEFT JOIN so admins without an organization still appear)
    public function users()
    {
        $this->ensureAdmin();

        $users = User::leftJoin('organizations', 'users.user_id', '=', 'organizations.user_id')
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
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }
}
