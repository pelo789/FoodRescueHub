<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Organization Details - FoodRescue Hub</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-50 font-sans min-h-screen flex flex-col antialiased">

    @include('partials.sidebar')

    <div class="ml-64 flex-1 flex flex-col">

        <!-- TOP HEADER -->
        <header class="bg-white border-b border-slate-200 px-8 py-4">
            <div class="max-w-5xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <a href="{{ route('admin.verifications.index') }}"
                       class="text-xs font-semibold text-[#2E7D32] hover:underline">
                        &larr; Back to Verification Queue
                    </a>
                    <h1 class="text-lg font-bold text-slate-900 mt-1">
                        {{ $organization->organization_name }}
                    </h1>
                </div>

                <div class="flex items-center gap-2.5 bg-slate-50 px-3.5 py-2 rounded-lg border border-slate-200">
                    <span class="text-xs font-medium text-slate-500">Current Status:</span>
                    <x-verification-badge :status="$organization->verification_status" />
                </div>
            </div>
        </header>

        <!-- MAIN BODY -->
        <main class="p-8 flex-1">
            <div class="max-w-5xl mx-auto space-y-6">

                @if (session('success'))
                    <div class="rounded-xl bg-emerald-100 border border-emerald-200 p-4 text-sm text-emerald-800 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- ORGANIZATION & REPRESENTATIVE DETAILS CARD -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs">
                    <div class="border-b border-slate-100 pb-4 mb-5">
                        <h2 class="text-sm font-bold text-slate-900">Organization & Contact Information</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Submitted registration profile and representative details</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                        <div>
                            <span class="text-slate-500 font-medium block mb-1">Organization Name</span>
                            <span class="text-sm font-semibold text-slate-900">{{ $organization->organization_name }}</span>
                        </div>

                        <div>
                            <span class="text-slate-500 font-medium block mb-1">Organization Role</span>
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200 capitalize">
                                {{ str_replace('_', ' ', $organization->role) }}
                            </span>
                        </div>

                        <div>
                            <span class="text-slate-500 font-medium block mb-1">Representative Name</span>
                            <span class="text-sm font-semibold text-slate-900">
                                {{ $organization->first_name }} {{ $organization->last_name }}
                            </span>
                        </div>

                        <div>
                            <span class="text-slate-500 font-medium block mb-1">Contact Email & Phone</span>
                            <span class="text-sm font-semibold text-slate-900">{{ $organization->email }}</span>
                            <span class="text-slate-500 block mt-0.5">{{ $organization->phone ?? 'No phone number provided' }}</span>
                        </div>

                        <div class="md:col-span-2">
                            <span class="text-slate-500 font-medium block mb-1">Organization Address</span>
                            <span class="text-sm font-semibold text-slate-900">
                                {{ $organization->organization_address ?? 'No address provided' }}
                            </span>
                        </div>

                        <div>
                            <span class="text-slate-500 font-medium block mb-1">Date Registered</span>
                            <span class="text-sm font-semibold text-slate-900">
                                {{ \Carbon\Carbon::parse($organization->created_at)->format('M d, Y • h:i A') }}
                            </span>
                        </div>

                        <div>
                            <span class="text-slate-500 font-medium block mb-1">Verification Document</span>
                            @if ($organization->verification_document)
                                <a href="{{ route('admin.verifications.document', $organization->organization_id) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold rounded-lg border border-slate-300 transition-colors">
                                    View / Download Document &nearr;
                                </a>
                            @else
                                <span class="text-slate-400 italic">No document uploaded</span>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- VERIFICATION DECISION & REMARKS FORM -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs">
                    <div class="border-b border-slate-100 pb-4 mb-5">
                        <h2 class="text-sm font-bold text-slate-900">Verification Decision</h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Approve, request additional information with remarks, or reject this organization.
                        </p>
                    </div>

                    <form action="{{ route('admin.verifications.updateStatus', $organization->organization_id) }}"
                          method="POST"
                          class="space-y-5">
                        @csrf

                        <!-- ADMINISTRATOR REMARKS TEXTAREA -->
                        <div>
                            <label for="verification_remarks" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Administrator Remarks <span class="font-normal text-slate-400">(Required if requesting additional information or rejecting)</span>
                            </label>
                            <textarea
                                id="verification_remarks"
                                name="verification_remarks"
                                rows="3"
                                placeholder="Enter notes, feedback, or missing document details for the organization..."
                                class="w-full rounded-lg border border-slate-300 p-3 text-xs text-slate-800 focus:border-[#2E7D32] focus:outline-none"
                            >{{ old('verification_remarks', $organization->verification_remarks) }}</textarea>

                            @error('verification_remarks')
                                <p class="text-xs text-rose-700 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <!-- Approve -->
                            <button type="submit"
                                    name="verification_status"
                                    value="Verified"
                                    onclick="return confirm('Approve and verify {{ addslashes($organization->organization_name) }}?')"
                                    class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-xs transition-colors cursor-pointer">
                                ✓ Approve Organization
                            </button>

                            <!-- Request Additional Information -->
                            <button type="submit"
                                    name="verification_status"
                                    value="Additional Information Required"
                                    onclick="return confirm('Request additional information from {{ addslashes($organization->organization_name) }}?')"
                                    class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-lg shadow-xs transition-colors cursor-pointer">
                                Request Additional Information
                            </button>

                            <!-- Reject -->
                            <button type="submit"
                                    name="verification_status"
                                    value="Rejected"
                                    onclick="return confirm('Reject {{ addslashes($organization->organization_name) }}? This will deactivate their account.')"
                                    class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-lg shadow-xs transition-colors cursor-pointer">
                                ✕ Reject Application
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </main>

    </div>

</body>
</html>
