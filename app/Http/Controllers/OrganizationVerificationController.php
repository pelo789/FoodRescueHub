<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class OrganizationVerificationController extends Controller
{
    public function viewOwnDocument(Request $request)
    {
        $organization = $request->user()->organization;

        abort_unless(
            $organization && $organization->verification_document && Storage::disk('local')->exists($organization->verification_document),
            404,
            'Verification document not found.'
        );

        return Storage::disk('local')->response($organization->verification_document);
    }
    /**
     * Resubmit an organization's verification document.
     */
    public function resubmit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'verification_document' =>
                'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $user = $request->user();

        $organization = $user->organization;

        abort_if(
            !$organization,
            404,
            'Organization record not found.'
        );

        abort_unless(
            in_array($user->role, [
                'food_provider',
                'recipient_organization',
            ], true),
            403,
            'Only organizations can resubmit verification documents.'
        );

        abort_if(
            strtolower(trim($organization->verification_status))
                !== 'additional information required',
            403,
            'Your organization is not currently required to resubmit information.'
        );

        // Save the replacement document.
        $newDocumentPath = $validated['verification_document']
            ->store('verification-documents', 'local');

        // Keep the old document path temporarily.
        $oldDocumentPath = $organization->verification_document;

        // Update the organization verification record.
        $organization->verification_document = $newDocumentPath;
        $organization->verification_status = 'Pending';
        $organization->verification_remarks = null;

        $organization->save();

        // Delete the old document after the new one is saved.
        if (
            $oldDocumentPath &&
            $oldDocumentPath !== $newDocumentPath &&
            Storage::disk('local')->exists($oldDocumentPath)
        ) {
            Storage::disk('local')->delete($oldDocumentPath);
        }

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Your updated verification document has been submitted successfully. Your organization is now awaiting administrator review.'
            );
    }
}
