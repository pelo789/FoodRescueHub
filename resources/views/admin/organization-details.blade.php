<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Organization Details — FoodRescue Hub</title>

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
                <a href="{{ route('admin.verifications.index') }}"
                   class="min-h-10 inline-flex items-center gap-1.5 text-sm font-semibold text-[#2E7D32] hover:text-[#1B5E20] hover:underline">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12" />
                        <polyline points="12 19 5 12 12 5" />
                    </svg>
                    <span>Verification Queue</span>
                </a>
                <span class="text-[#d5dfd8]">/</span>
                <span class="text-sm font-semibold text-[#14281d]">
                    {{ $organization->organization_name }}
                </span>
            </div>

            <x-verification-badge :status="$organization->verification_status" />
        </header>

        <!-- MAIN WORKSPACE -->
        <main class="p-8 flex-1">
            <div class="max-w-5xl space-y-6">

                <!-- PAGE SUBTITLE -->
                <div>
                    <h2 class="text-xl font-bold text-[#14281d] tracking-tight text-left">
                        {{ $organization->organization_name }}
                    </h2>
                    <p class="text-sm text-[#4a5d50] mt-1 text-left">
                        Inspect submitted registration profile, verification document, and record an approval decision.
                    </p>
                </div>

                @if (session('success'))
                    <div class="rounded-lg bg-[#e8f5e9] border border-[#2E7D32]/20 px-4 py-3.5 text-sm text-[#2E7D32] font-medium flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- ORGANIZATION & REPRESENTATIVE PROFILE (Hairline Key-Value List) -->
                <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl divide-y divide-[#d5dfd8]">
                    <div class="px-6 py-4">
                        <h3 class="text-base font-bold text-[#14281d] text-left">Organization & Contact Information</h3>
                    </div>

                    <dl class="divide-y divide-[#d5dfd8] text-sm">
                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Organization Name</dt>
                            <dd class="sm:col-span-2 font-semibold text-[#14281d] text-left">{{ $organization->organization_name }}</dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Organization Role</dt>
                            <dd class="sm:col-span-2 font-medium text-[#14281d] capitalize text-left">
                                {{ str_replace('_', ' ', $organization->role) }}
                            </dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Representative</dt>
                            <dd class="sm:col-span-2 font-medium text-[#14281d] text-left">
                                {{ $organization->first_name }} {{ $organization->last_name }}
                                <span class="text-[#4a5d50] font-normal ml-2">({{ $organization->email }}{{ $organization->phone ? ' • ' . $organization->phone : '' }})</span>
                            </dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Address</dt>
                            <dd class="sm:col-span-2 font-medium text-[#14281d] text-left">{{ $organization->organization_address ?? 'Not provided' }}</dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Date Registered</dt>
                            <dd class="sm:col-span-2 font-medium text-[#14281d] text-left">
                                {{ \Carbon\Carbon::parse($organization->created_at)->format('M d, Y • h:i A') }}
                            </dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 items-center">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Verification Document</dt>
                            <dd class="sm:col-span-2 text-left">
                                @if ($organization->verification_document)
                                    <a href="{{ route('admin.verifications.document', $organization->organization_id) }}"
                                       target="_blank"
                                       class="min-h-10 px-4 py-2 bg-[#ffffff] hover:bg-[#e8efe9] text-[#14281d] border border-[#d5dfd8] rounded-lg text-xs font-semibold inline-flex items-center gap-2 transition-colors">
                                        <svg class="w-4 h-4 text-[#2E7D32] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                            <polyline points="14 2 14 8 20 8" />
                                        </svg>
                                        <span>View / Download Uploaded File</span>
                                    </a>
                                @else
                                    <span class="text-xs text-[#4a5d50]">No document uploaded</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
                <!-- VERIFICATION DECISION & REMARKS FORM -->
                <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl divide-y divide-[#d5dfd8]">
                    <div class="px-6 py-4">
                        <h3 class="text-base font-bold text-[#14281d] text-left">Verification Decision</h3>
                        <p class="text-xs text-[#4a5d50] mt-0.5 text-left">
                            Approve the organization, request updated documents with remarks, or reject the application.
                        </p>
                    </div>

                    <form action="{{ route('admin.verifications.updateStatus', $organization->organization_id) }}"
                          method="POST"
                          class="p-6 space-y-5">
                        @csrf

                        <!-- ADMINISTRATOR REMARKS TEXTAREA -->
                        <div>
                            <label for="verification_remarks" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2 text-left">
                                Administrator Remarks <span class="normal-case font-normal">(Required when requesting additional information or rejecting)</span>
                            </label>
                            <textarea
                                id="verification_remarks"
                                name="verification_remarks"
                                rows="3"
                                placeholder="Enter notes, feedback, or missing document details for the organization..."
                                class="w-full rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] p-3 text-sm text-[#14281d] focus:bg-[#ffffff] focus:border-[#2E7D32] focus:outline-none"
                            >{{ old('verification_remarks', $organization->verification_remarks) }}</textarea>

                            @error('verification_remarks')
                                <p class="text-xs text-[#b91c1c] mt-1.5 font-medium text-left">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ACTION BUTTONS (Von Restorff Effect: Single #2E7D32 Primary CTA) -->
                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <!-- Primary CTA: Approve -->
                            <button type="submit"
                                    name="verification_status"
                                    value="Verified"
                                    onclick="return confirm('Approve and verify {{ addslashes($organization->organization_name) }}?')"
                                    class="min-h-10 px-4 py-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-semibold rounded-lg inline-flex items-center gap-2 transition-colors cursor-pointer">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                <span>Approve Organization</span>
                            </button>

                            <!-- Secondary Action: Request Additional Information -->
                            <button type="submit"
                                    name="verification_status"
                                    value="Additional Information Required"
                                    onclick="return confirm('Request additional information from {{ addslashes($organization->organization_name) }}?')"
                                    class="min-h-10 px-4 py-2 bg-[#ffffff] hover:bg-[#e8efe9] text-[#14281d] border border-[#d5dfd8] text-sm font-semibold rounded-lg inline-flex items-center gap-2 transition-colors cursor-pointer">
                                <svg class="w-4 h-4 text-[#b45309] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg>
                                <span>Request Additional Information</span>
                            </button>

                            <!-- Destructive Action: Reject -->
                            <button type="submit"
                                    name="verification_status"
                                    value="Rejected"
                                    onclick="return confirm('Reject {{ addslashes($organization->organization_name) }}?')"
                                    class="min-h-10 px-4 py-2 bg-[#ffffff] hover:bg-[#fee2e2] text-[#b91c1c] border border-[#d5dfd8] hover:border-[#b91c1c]/30 text-sm font-semibold rounded-lg inline-flex items-center gap-2 transition-colors cursor-pointer">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                                <span>Reject Application</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </main>

    </div>

</body>
</html>