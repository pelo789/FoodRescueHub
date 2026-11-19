@php
    $listingId = $listing->food_listing_id ?? $listing->id ?? 0;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listing Details — FoodRescue Hub</title>

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
                <a href="{{ Route::has('provider.listings.index') ? route('provider.listings.index') : '#' }}"
                   class="min-h-10 inline-flex items-center gap-1.5 text-sm font-semibold text-[#2E7D32] hover:text-[#1B5E20] hover:underline">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12" />
                        <polyline points="12 19 5 12 12 5" />
                    </svg>
                    <span>Food Listings</span>
                </a>
                <span class="text-[#d5dfd8]">/</span>
                <span class="text-sm font-semibold text-[#14281d]">
                    {{ $listing->food_name ?? 'Listing Details' }}
                </span>
            </div>

            <!-- SINGLE PRIMARY CTA (Von Restorff Effect) -->
            <a href="{{ Route::has('provider.listings.edit') ? route('provider.listings.edit', $listingId) : '#' }}"
               class="min-h-10 px-4 py-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-semibold rounded-lg inline-flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>
                <span>Edit Listing</span>
            </a>
        </header>

        <!-- MAIN WORKSPACE -->
        <main class="p-8 flex-1">
            <div class="max-w-5xl space-y-6">

                <!-- PAGE SUBTITLE -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <h2 class="text-xl font-bold text-[#14281d] tracking-tight text-left">
                            {{ $listing->food_name ?? 'Surplus Food Batch' }}
                        </h2>
                        <p class="text-sm text-[#4a5d50] mt-1 text-left">
                            Full batch specifications, storage instructions, and redistribution status.
                        </p>
                    </div>
                    <x-listing-status-badge :status="$listing->status ?? 'Available'" />
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

                                <!-- BATCH KPI SUMMARY ROW (BR-M10 Quantity Breakdown) -->
                @php
                    $unitLabel = $listing->unit ?? 'pcs';
                    $availQty = $listing->available_quantity ?? $listing->quantity ?? 0;
                    $resQty = $listing->reserved_quantity ?? 0;
                    $redistQty = $listing->redistributed_quantity ?? 0;
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl p-6">
                        <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                            Available Stock
                        </span>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="text-3xl font-bold text-[#14281d]">{{ $availQty }}</span>
                            <span class="text-sm font-medium text-[#2E7D32]">{{ $unitLabel }} open</span>
                        </div>
                    </div>

                    <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl p-6">
                        <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                            Reserved Stock
                        </span>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="text-3xl font-bold text-[#14281d]">{{ $resQty }}</span>
                            <span class="text-sm font-medium text-[#b45309]">{{ $unitLabel }} pending pickup</span>
                        </div>
                    </div>

                    <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl p-6">
                        <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                            Redistributed Stock
                        </span>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="text-3xl font-bold text-[#14281d]">{{ $redistQty }}</span>
                            <span class="text-sm font-medium text-[#4a5d50]">{{ $unitLabel }} completed</span>
                        </div>
                    </div>
                </div>

                <!-- BATCH SPECIFICATION DETAILS (Hairline Key-Value List) -->
                <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl divide-y divide-[#d5dfd8]">
                    <div class="px-6 py-4">
                        <h3 class="text-base font-bold text-[#14281d] text-left">Batch Specifications & Handling</h3>
                    </div>

                    <dl class="divide-y divide-[#d5dfd8] text-sm">
                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Food Item Name</dt>
                            <dd class="sm:col-span-2 font-semibold text-[#14281d] text-left">{{ $listing->food_name ?? '—' }}</dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Category</dt>
                            <dd class="sm:col-span-2 font-medium text-[#14281d] text-left">{{ $listing->category ?? 'General Surplus' }}</dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Storage Requirement</dt>
                            <dd class="sm:col-span-2 font-medium text-[#14281d] text-left">{{ $listing->storage_condition ?? 'Room Temperature' }}</dd>
                        </div>

                                                <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Expiration Date</dt>
                            <dd class="sm:col-span-2 font-medium text-[#14281d] text-left">
                                {{ !empty($listing->expiry_date) ? \Carbon\Carbon::parse($listing->expiry_date)->format('M d, Y') : '—' }}
                            </dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Pickup Window</dt>
                            <dd class="sm:col-span-2 font-medium text-[#14281d] text-left">
                                {{ ($listing->pickup_start ?? '08:00') . ' – ' . ($listing->pickup_end ?? '17:00') }}
                            </dd>
                        </div>


                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Description & Notes</dt>
                            <dd class="sm:col-span-2 font-normal text-[#4a5d50] leading-relaxed whitespace-pre-line text-left">
                                {{ $listing->description ?: 'No additional handling instructions provided.' }}
                            </dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Posted By Organization</dt>
                            <dd class="sm:col-span-2 font-medium text-[#14281d] text-left">
                                {{ $listing->organization->organization_name ?? auth()->user()->organization?->organization_name ?? 'Your Organization' }}
                            </dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Date Posted</dt>
                            <dd class="sm:col-span-2 font-medium text-[#14281d] text-left">
                                {{ !empty($listing->created_at) ? \Carbon\Carbon::parse($listing->created_at)->format('M d, Y • h:i A') : '—' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- RECORD ACTIONS (Secondary & Destructive Separated) -->
                <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl p-6 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h3 class="text-sm font-bold text-[#14281d] text-left">Manage Listing Record</h3>
                        <p class="text-xs text-[#4a5d50] mt-0.5 text-left">
                            Remove this surplus batch permanently if it is no longer available for redistribution.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ Route::has('provider.listings.index') ? route('provider.listings.index') : '#' }}"
                           class="min-h-10 px-4 py-2 bg-[#ffffff] hover:bg-[#e8efe9] text-[#14281d] border border-[#d5dfd8] rounded-lg text-sm font-semibold inline-flex items-center transition-colors">
                            Back to Inventory
                        </a>

                        <form action="{{ Route::has('provider.listings.destroy') ? route('provider.listings.destroy', $listingId) : '#' }}"
                              method="POST"
                              class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Permanently delete {{ addslashes($listing->food_name ?? 'this listing') }}?')"
                                    class="min-h-10 px-4 py-2 bg-[#ffffff] hover:bg-[#fee2e2] text-[#b91c1c] border border-[#d5dfd8] hover:border-[#b91c1c]/30 rounded-lg text-sm font-semibold inline-flex items-center gap-2 transition-colors cursor-pointer">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                </svg>
                                <span>Delete Listing</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </main>

    </div>

</body>
</html>
