<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VerificationController extends Controller
{
    public function index(): View
    {
        $organizations = User::whereIn('role', [
                'food_provider',
                'recipient_organization',
            ])
            ->where('verification_status', 'pending')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('admin.verifications.index', compact('organizations'));
    }

    public function viewDocument(User $user): StreamedResponse
    {
        $this->ensureOrganization($user);

        abort_if(
            empty($user->verification_document),
            404,
            'No verification document was uploaded.'
        );

        $disk = Storage::disk('local');

        abort_unless(
            $disk->exists($user->verification_document),
            404,
            'Verification document not found.'
        );

        return $disk->download($user->verification_document);
    }

    public function approve(User $user): RedirectResponse
    {
        $this->ensureOrganization($user);

        abort_if(
            $user->verification_status !== 'pending',
            403,
            'This organization is no longer awaiting verification.'
        );

        abort_if(
            empty($user->verification_document)
            || !Storage::disk('local')->exists($user->verification_document),
            422,
            'This organization has no available verification document.'
        );

        $user->update([
            'verification_status' => 'verified',
        ]);

        return redirect()
            ->route('admin.verifications.index')
            ->with('success', $user->organization_name . ' has been approved.');
    }

    public function reject(User $user): RedirectResponse
    {
        $this->ensureOrganization($user);

        abort_if(
            $user->verification_status !== 'pending',
            403,
            'This organization is no longer awaiting verification.'
        );

        $user->update([
            'verification_status' => 'rejected',
        ]);

        return redirect()
            ->route('admin.verifications.index')
            ->with('success', $user->organization_name . ' has been rejected.');
    }

    private function ensureOrganization(User $user): void
    {
        abort_unless(
            in_array($user->role, [
                'food_provider',
                'recipient_organization',
            ], true),
            404
        );
    }
}
