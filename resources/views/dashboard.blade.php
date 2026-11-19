@php
    $user = auth()->user();
    $role = strtolower(str_replace(' ', '_', trim($user->role ?? '')));

    $isAdmin = in_array($role, ['administrator', 'admin'], true);
    $isProvider = $role === 'food_provider';
    $isRecipient = $role === 'recipient_organization';

    $organization = $user->organization;
    $verificationStatus = strtolower(trim($organization->verification_status ?? 'pending'));
    $isVerified = $verificationStatus === 'verified';

    $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: ($user->name ?? 'User');
    $organizationName = $organization->organization_name ?? 'No organization registered';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodRescue Hub - Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
        }
    </style>
</head>

<body class="bg-slate-50 font-sans min-h-screen flex flex-col antialiased">

    {{-- Reusable Sidebar --}}
    @include('partials.sidebar')

    <!-- MAIN CONTENT CONTAINER -->
    <div class="ml-64 flex-1 flex flex-col">

        <!-- HEADER -->
        <header class="bg-white border-b border-slate-200 px-8 py-4">
            <div class="max-w-5xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-lg font-bold text-slate-900">
                        Welcome back, {{ $fullName }}
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Role:
                        <span class="font-semibold text-slate-700">
                            @if ($isAdmin) Administrator
                            @elseif ($isProvider) Food Provider
                            @elseif ($isRecipient) Recipient Organization
                            @else {{ ucfirst($user->role) }}
                            @endif
                        </span>
                    </p>
                </div>

                @if (!$isAdmin && $organization)
                    <div class="flex items-center gap-2.5 bg-slate-50 px-3.5 py-2 rounded-lg border border-slate-200">
                        <span class="text-xs font-medium text-slate-500">Status:</span>
                        <x-verification-badge :status="$organization->verification_status" />
                    </div>
                @endif
            </div>
        </header>
        <!-- MAIN BODY -->
        <main class="p-8 flex-1">
            <div class="max-w-5xl mx-auto space-y-6">

                <!-- FLASH MESSAGES -->
                @if (session('success'))
                    <div class="rounded-xl bg-emerald-100 border border-emerald-200 p-4 text-sm text-emerald-800 font-medium flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="rounded-xl bg-rose-100 border border-rose-200 p-4 text-sm text-rose-800 font-medium flex items-center gap-3">
                        <svg class="w-5 h-5 text-rose-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                <!-- ORGANIZATION VERIFICATION STATUS & PROGRESS -->
                @if (!$isAdmin && $organization)

                    <!-- 3-STEP VERIFICATION TRACKER -->
                    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs">
                        <div class="mb-5">
                            <h2 class="text-sm font-bold text-slate-900">Organization Verification Progress</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Track your organization's approval status to unlock redistribution tools.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Step 1 -->
                            <div class="flex items-start gap-3 p-3.5 rounded-lg bg-emerald-50/70 border border-emerald-200">
                                <span class="w-6 h-6 rounded-full bg-emerald-600 text-white text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">✓</span>
                                <div>
                                    <p class="text-xs font-bold text-emerald-900">1. Registration Submitted</p>
                                    <p class="text-[11px] text-emerald-700 mt-0.5">Account & proof uploaded</p>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="flex items-start gap-3 p-3.5 rounded-lg border {{ $isVerified ? 'bg-emerald-50/70 border-emerald-200' : ($verificationStatus === 'rejected' ? 'bg-rose-50 border-rose-200' : ($verificationStatus === 'additional information required' ? 'bg-amber-50 border-amber-200' : 'bg-slate-100 border-slate-300')) }}">
                                <span class="w-6 h-6 rounded-full text-white text-xs font-bold flex items-center justify-center shrink-0 mt-0.5 {{ $isVerified ? 'bg-emerald-600' : ($verificationStatus === 'rejected' ? 'bg-rose-600' : ($verificationStatus === 'additional information required' ? 'bg-amber-600' : 'bg-slate-600')) }}">
                                    {{ $isVerified ? '✓' : '2' }}
                                </span>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">2. Administrator Review</p>
                                    <p class="text-[11px] text-slate-600 mt-0.5">
                                        @if ($isVerified)
                                            Approved by admin
                                        @elseif ($verificationStatus === 'additional information required')
                                            Action needed from you
                                        @elseif ($verificationStatus === 'rejected')
                                            Application declined
                                        @else
                                            Currently in review queue
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="flex items-start gap-3 p-3.5 rounded-lg border {{ $isVerified ? 'bg-emerald-50/70 border-emerald-200' : 'bg-slate-50 border-slate-200 opacity-70' }}">
                                <span class="w-6 h-6 rounded-full text-xs font-bold flex items-center justify-center shrink-0 mt-0.5 {{ $isVerified ? 'bg-emerald-600 text-white' : 'bg-slate-300 text-slate-700' }}">
                                    {{ $isVerified ? '✓' : '3' }}
                                </span>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">3. Full Platform Access</p>
                                    <p class="text-[11px] text-slate-600 mt-0.5">
                                        {{ $isVerified ? 'All features unlocked' : 'Unlocks once verified' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- SEMANTIC STATUS BANNER -->
                    @if ($isVerified)
                        <div class="rounded-xl bg-emerald-100 border border-emerald-200 p-5">
                            <h3 class="text-sm font-bold text-emerald-800">
                                Organization Verified & Active
                            </h3>
                            <p class="text-xs text-emerald-800/90 mt-1 leading-relaxed">
                                Your organization is verified. You now have full access to {{ $isProvider ? 'create food listings, manage inventory, and schedule pickups' : 'browse available food donations, submit requests, and manage pickups' }} from the sidebar.
                            </p>
                        </div>

                    @elseif ($verificationStatus === 'pending')
                        <div class="rounded-xl bg-slate-100 border border-slate-200 p-5">
                            <h3 class="text-sm font-bold text-slate-700">
                                Verification Pending Review
                            </h3>
                            <p class="text-xs text-slate-700 mt-1 leading-relaxed">
                                Your organization registration is currently in the queue for administrator review. Redistribution features will remain locked until your verification document is approved.
                            </p>
                        </div>

                    @elseif ($verificationStatus === 'rejected')
                        <div class="rounded-xl bg-rose-100 border border-rose-200 p-5">
                            <h3 class="text-sm font-bold text-rose-800">
                                Organization Verification Rejected
                            </h3>
                            <p class="text-xs text-rose-800 mt-1 leading-relaxed">
                                Unfortunately, your organization's verification request was rejected.
                            </p>
                            @if ($organization->verification_remarks)
                                <div class="mt-3 bg-white/80 border border-rose-200 rounded-lg p-3.5">
                                    <span class="block text-[11px] font-bold uppercase tracking-wider text-rose-800 mb-1">Administrator Remarks</span>
                                    <p class="text-xs text-rose-900 whitespace-pre-line">{{ $organization->verification_remarks }}</p>
                                </div>
                            @endif
                        </div>

                    @elseif ($verificationStatus === 'additional information required')
                        <div class="rounded-xl bg-amber-100 border border-amber-200 p-6 space-y-4">
                            <div>
                                <h3 class="text-sm font-bold text-amber-800">
                                    Additional Information Required
                                </h3>
                                <p class="text-xs text-amber-800 mt-1 leading-relaxed">
                                    Please review the administrator's remarks below and upload an updated verification document to continue your review.
                                </p>
                            </div>

                            <!-- ADMINISTRATOR REMARKS -->
                            <div class="bg-white border border-amber-200 rounded-lg p-4">
                                <h4 class="text-xs font-bold text-slate-900 mb-1.5">
                                    Administrator's Remarks
                                </h4>
                                <p class="text-xs text-slate-700 leading-relaxed whitespace-pre-line">
                                    {{ $organization->verification_remarks ?: 'No specific remarks were provided. Please contact the administrator for clarification.' }}
                                </p>
                            </div>

                            <!-- DOCUMENT RESUBMISSION FORM -->
                            <div class="bg-white border border-amber-200 rounded-lg p-4">
                                <h4 class="text-xs font-bold text-slate-900 mb-1">
                                    Submit Updated Verification Document
                                </h4>
                                <p class="text-xs text-slate-500 mb-3">
                                    Accepted formats: PDF, JPG, JPEG, or PNG (Max 5 MB).
                                </p>

                                <form action="{{ route('organization.verification.resubmit') }}"
                                      method="POST"
                                      enctype="multipart/form-data"
                                      class="space-y-3">
                                    @csrf

                                    <input type="file"
                                           id="verification_document"
                                           name="verification_document"
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           required
                                           class="block w-full text-xs text-slate-600 border border-slate-300 rounded-lg p-2">

                                    @error('verification_document')
                                        <p class="text-xs text-rose-700 font-medium">{{ $message }}</p>
                                    @enderror

                                    <button type="submit"
                                            onclick="return confirm('Submit this updated verification document for review?')"
                                            class="px-4 py-2 bg-[#2E7D32] text-white text-xs font-semibold rounded-lg hover:bg-green-800 transition-colors cursor-pointer">
                                        Submit Updated Document
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                    <!-- ORGANIZATION PROFILE CARD -->
                    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs">
                        <div class="border-b border-slate-100 pb-4 mb-5">
                            <h2 class="text-sm font-bold text-slate-900">Organization Profile</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Registered details linked to your account</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                            <div>
                                <span class="text-slate-500 font-medium block mb-1">Organization Name</span>
                                <span class="text-sm font-semibold text-slate-900">{{ $organizationName }}</span>
                            </div>

                            <div>
                                <span class="text-slate-500 font-medium block mb-1">Account Role</span>
                                <span class="text-sm font-semibold text-slate-900">
                                    {{ $isProvider ? 'Food Provider' : 'Recipient Organization' }}
                                </span>
                            </div>

                            <div>
                                <span class="text-slate-500 font-medium block mb-1">Contact Person</span>
                                <span class="text-sm font-semibold text-slate-900">{{ $fullName }}</span>
                                <span class="text-slate-500 block mt-0.5">{{ $user->email }} {{ $user->phone ? '• ' . $user->phone : '' }}</span>
                            </div>

                            <div>
                                <span class="text-slate-500 font-medium block mb-1">Organization Address</span>
                                <span class="text-sm font-semibold text-slate-900">{{ $organization->organization_address ?? 'Not provided' }}</span>
                            </div>
                        </div>
                    </div>

                @elseif ($isAdmin)
                    <!-- ADMIN QUICK OVERVIEW -->
                    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900">Administrator Control Center</h2>
                            <p class="text-xs text-slate-500 mt-1">Review pending organization applications, verify documents, and manage platform users.</p>
                        </div>
                        <a href="{{ route('admin.verifications.index') }}"
                           class="inline-flex items-center justify-center px-4 py-2.5 bg-[#2E7D32] text-white text-xs font-semibold rounded-lg hover:bg-green-800 transition-colors shrink-0">
                            Review Verification Queue &rarr;
                        </a>
                    </div>
                @endif

            </div>
        </main>

    </div>

</body>
</html>
