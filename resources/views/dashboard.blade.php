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

    // Real counts for Admin KPI row
    $pendingCount = $isAdmin ? \App\Models\Organization::where('verification_status', 'Pending')->count() : 0;
    $verifiedCount = $isAdmin ? \App\Models\Organization::where('verification_status', 'Verified')->count() : 0;
    $totalUsersCount = $isAdmin ? \App\Models\User::count() : 0;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — FoodRescue Hub</title>

    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
    </style>
</head>
<body class="bg-[#f3f6f4] text-[#14281d] font-sans min-h-screen flex flex-col antialiased">

    @include('partials.sidebar')

    <div class="ml-64 flex-1 flex flex-col">

        <!-- TOP HEADER BAR -->
        <header class="h-16 bg-[#ffffff] border-b border-[#d5dfd8] px-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h1 class="text-base font-bold text-[#14281d]">
                    Dashboard
                </h1>
                <span class="text-[#d5dfd8]">/</span>
                <span class="text-sm text-[#4a5d50]">
                    @if ($isAdmin) Administrator
                    @elseif ($isProvider) Food Provider
                    @elseif ($isRecipient) Recipient Organization
                    @else {{ ucfirst($user->role) }}
                    @endif
                </span>
            </div>

            <!-- SINGLE PRIMARY CTA (Von Restorff Effect: Solid #2E7D32) -->
            <div class="flex items-center gap-3">
                @if ($isAdmin)
                    <a href="{{ route('admin.verifications.index') }}"
                       class="min-h-10 px-4 py-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-semibold rounded-lg inline-flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 12l2 2 4-4" />
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                        <span>Review Queue ({{ $pendingCount }})</span>
                    </a>
                @elseif ($isProvider && $isVerified)
                    <a href="#"
                       class="min-h-10 px-4 py-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-semibold rounded-lg inline-flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        <span>Post Surplus Food</span>
                    </a>
                @elseif ($isRecipient && $isVerified)
                    <a href="#"
                       class="min-h-10 px-4 py-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-semibold rounded-lg inline-flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        <span>Browse Available Food</span>
                    </a>
                @elseif ($organization && $organization->verification_document)
                    <a href="{{ route('organization.verification.document') }}"
                       target="_blank"
                       class="min-h-10 px-4 py-2 bg-[#ffffff] hover:bg-[#e8efe9] text-[#14281d] border border-[#d5dfd8] text-sm font-medium rounded-lg inline-flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4 text-[#4a5d50]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                        <span>View Uploaded Proof</span>
                    </a>
                @endif
            </div>
        </header>
        <!-- MAIN WORKSPACE -->
        <main class="p-8 flex-1">
            <div class="max-w-6xl space-y-6">

                <!-- WELCOME HEADER -->
                <div>
                    <h2 class="text-xl font-bold text-[#14281d] tracking-tight text-left">
                        Welcome back, {{ $fullName }}
                    </h2>
                    <p class="text-sm text-[#4a5d50] mt-1 text-left">
                        @if ($isAdmin)
                            Monitor organization verifications, user accounts, and platform activity.
                        @else
                            Manage your organization profile and track your verification status.
                        @endif
                    </p>
                </div>

                <!-- FLASH MESSAGES -->
                @if (session('success'))
                    <div class="rounded-lg bg-[#e8f5e9] border border-[#2E7D32]/20 px-4 py-3.5 text-sm text-[#2E7D32] font-medium flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="rounded-lg bg-[#fee2e2] border border-[#b91c1c]/20 px-4 py-3.5 text-sm text-[#b91c1c] font-medium flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- KPI METRIC ROW -->
                @if ($isAdmin)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl p-6">
                            <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                Pending Verifications
                            </span>
                            <div class="mt-2 flex items-baseline justify-between">
                                <span class="text-3xl font-bold text-[#14281d]">{{ $pendingCount }}</span>
                                <a href="{{ route('admin.verifications.index', ['status' => 'Pending']) }}"
                                   class="text-xs font-semibold text-[#2E7D32] hover:underline">
                                    Open Queue &rarr;
                                </a>
                            </div>
                        </div>

                        <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl p-6">
                            <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                Verified Organizations
                            </span>
                            <div class="mt-2 flex items-baseline justify-between">
                                <span class="text-3xl font-bold text-[#14281d]">{{ $verifiedCount }}</span>
                                <a href="{{ route('admin.verifications.index', ['status' => 'Verified']) }}"
                                   class="text-xs font-medium text-[#4a5d50] hover:text-[#14281d]">
                                    View All
                                </a>
                            </div>
                        </div>

                        <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl p-6">
                            <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                Total Registered Users
                            </span>
                            <div class="mt-2 flex items-baseline justify-between">
                                <span class="text-3xl font-bold text-[#14281d]">{{ $totalUsersCount }}</span>
                                <a href="{{ route('admin.users.index') }}"
                                   class="text-xs font-medium text-[#4a5d50] hover:text-[#14281d]">
                                    Directory
                                </a>
                            </div>
                        </div>
                    </div>

                @elseif ($organization)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl p-6">
                            <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                Verification Status
                            </span>
                            <div class="mt-3">
                                <x-verification-badge :status="$organization->verification_status" />
                            </div>
                        </div>

                        <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl p-6">
                            <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                {{ $isProvider ? 'Active Food Listings' : 'Active Food Requests' }}
                            </span>
                            <div class="mt-2 flex items-baseline gap-2">
                                <span class="text-3xl font-bold text-[#14281d]">0</span>
                                <span class="text-xs text-[#4a5d50]">{{ $isVerified ? 'Ready to create' : 'Locked until verified' }}</span>
                            </div>
                        </div>

                        <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl p-6">
                            <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                Member Since
                            </span>
                            <div class="mt-2">
                                <span class="text-2xl font-bold text-[#14281d]">
                                    {{ $organization->created_at ? $organization->created_at->format('M d, Y') : '—' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- VERIFICATION PROGRESS CONTAINER -->
                    <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl divide-y divide-[#d5dfd8]">
                        <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div>
                                <h3 class="text-base font-bold text-[#14281d] text-left">Verification Progress</h3>
                                <p class="text-xs text-[#4a5d50] mt-0.5 text-left">
                                    Three-step review process required before participating in food redistribution.
                                </p>
                            </div>
                            <x-verification-badge :status="$organization->verification_status" />
                        </div>

                        <!-- 3-STEP HORIZONTAL PROGRESS BAR -->
                        <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-[#d5dfd8]">
                            <div class="p-5 flex items-start gap-3">
                                <span class="w-6 h-6 rounded-full bg-[#e8f5e9] text-[#2E7D32] text-xs font-bold flex items-center justify-center shrink-0">1</span>
                                <div>
                                    <p class="text-sm font-semibold text-[#14281d] text-left">Registration Submitted</p>
                                    <p class="text-xs text-[#4a5d50] mt-0.5 text-left">Account details and proof uploaded.</p>
                                </div>
                            </div>

                            <div class="p-5 flex items-start gap-3">
                                <span class="w-6 h-6 rounded-full text-xs font-bold flex items-center justify-center shrink-0 {{ $isVerified ? 'bg-[#e8f5e9] text-[#2E7D32]' : ($verificationStatus === 'rejected' ? 'bg-[#fee2e2] text-[#b91c1c]' : ($verificationStatus === 'additional information required' ? 'bg-[#fef3c7] text-[#b45309]' : 'bg-[#e8efe9] text-[#4a5d50]')) }}">2</span>
                                <div>
                                    <p class="text-sm font-semibold text-[#14281d] text-left">Administrator Review</p>
                                    <p class="text-xs text-[#4a5d50] mt-0.5 text-left">
                                        @if ($isVerified) Approved by administrator.
                                        @elseif ($verificationStatus === 'additional information required') Action required: see remarks below.
                                        @elseif ($verificationStatus === 'rejected') Application declined.
                                        @else In queue for document verification.
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="p-5 flex items-start gap-3">
                                <span class="w-6 h-6 rounded-full text-xs font-bold flex items-center justify-center shrink-0 {{ $isVerified ? 'bg-[#e8f5e9] text-[#2E7D32]' : 'bg-[#e8efe9] text-[#4a5d50]' }}">3</span>
                                <div>
                                    <p class="text-sm font-semibold text-[#14281d] text-left">Redistribution Access</p>
                                    <p class="text-xs text-[#4a5d50] mt-0.5 text-left">
                                        {{ $isVerified ? 'All platform features unlocked.' : 'Unlocks automatically upon approval.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- STATUS MESSAGE / ACTION SECTION -->
                        <div class="p-6">
                            @if ($isVerified)
                                <p class="text-sm text-[#4a5d50] leading-relaxed text-left">
                                    Your organization is verified and active. Use the navigation menu on the left to manage your food rescue operations.
                                </p>

                            @elseif ($verificationStatus === 'pending')
                                <p class="text-sm text-[#4a5d50] leading-relaxed text-left">
                                    Your verification document is currently under review by an administrator. You may inspect your uploaded file using the button in the top bar while waiting.
                                </p>

                            @elseif ($verificationStatus === 'rejected')
                                <div class="space-y-2">
                                    <p class="text-sm font-semibold text-[#b91c1c] text-left">
                                        Verification Request Rejected
                                    </p>
                                    <p class="text-sm text-[#4a5d50] leading-relaxed text-left">
                                        {{ $organization->verification_remarks ?: 'Your application did not meet the verification requirements. Please contact the administrator for further guidance.' }}
                                    </p>
                                </div>

                            @elseif ($verificationStatus === 'additional information required')
                                <div class="space-y-5">
                                    <div>
                                        <span class="inline-block px-2.5 py-1 rounded-md text-xs font-semibold bg-[#fef3c7] text-[#b45309] mb-2">
                                            Action Required
                                        </span>
                                        <p class="text-sm font-semibold text-[#14281d] text-left">
                                            Administrator Remarks:
                                        </p>
                                        <p class="text-sm text-[#4a5d50] mt-1 leading-relaxed whitespace-pre-line text-left">
                                            {{ $organization->verification_remarks ?: 'Please upload a clearer or updated verification document.' }}
                                        </p>
                                    </div>

                                    <form action="{{ route('organization.verification.resubmit') }}"
                                          method="POST"
                                          enctype="multipart/form-data"
                                          class="pt-4 border-t border-[#d5dfd8] space-y-4 max-w-lg">
                                        @csrf

                                        <div>
                                            <label for="verification_document" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2">
                                                Upload Updated Document (PDF, JPG, PNG • Max 5 MB)
                                            </label>
                                            <input type="file"
                                                   id="verification_document"
                                                   name="verification_document"
                                                   accept=".pdf,.jpg,.jpeg,.png"
                                                   required
                                                   class="block w-full min-h-10 text-sm text-[#14281d] bg-[#e8efe9] border border-[#d5dfd8] rounded-lg px-3 py-2">
                                            @error('verification_document')
                                                <p class="text-xs text-[#b91c1c] mt-1.5 font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <button type="submit"
                                                onclick="return confirm('Submit this updated verification document for review?')"
                                                class="min-h-10 px-4 py-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-semibold rounded-lg transition-colors cursor-pointer">
                                            Submit Updated Document
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- ORGANIZATION DETAILS SECTION (Hairline Key-Value List) -->
                    <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl divide-y divide-[#d5dfd8]">
                        <div class="px-6 py-4">
                            <h3 class="text-base font-bold text-[#14281d] text-left">Organization Details</h3>
                        </div>

                        <dl class="divide-y divide-[#d5dfd8] text-sm">
                            <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Organization Name</dt>
                                <dd class="sm:col-span-2 font-medium text-[#14281d] text-left">{{ $organizationName }}</dd>
                            </div>

                            <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Representative</dt>
                                <dd class="sm:col-span-2 font-medium text-[#14281d] text-left">
                                    {{ $fullName }}
                                    <span class="text-[#4a5d50] font-normal ml-2">({{ $user->email }}{{ $user->phone ? ' • ' . $user->phone : '' }})</span>
                                </dd>
                            </div>

                            <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Address</dt>
                                <dd class="sm:col-span-2 font-medium text-[#14281d] text-left">{{ $organization->organization_address ?? 'Not provided' }}</dd>
                            </div>
                        </dl>
                    </div>
                @endif

            </div>
        </main>

    </div>

</body>
</html>
