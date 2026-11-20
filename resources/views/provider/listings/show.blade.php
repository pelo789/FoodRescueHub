
@php
    $listingId = $listing->food_listing_id;
    $userRole = strtolower(str_replace(' ', '_', trim(auth()->user()->role ?? '')));
    $isProvider = $userRole === 'food_provider';
    $expirationDate = $listing->expiration_date
        ? \Carbon\Carbon::parse($listing->expiration_date)->format('M d, Y')
        : '—';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listing Details — FoodRescue Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

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

        <header class="h-16 bg-white border-b border-[#d5dfd8] px-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('food-listings.index') }}"
                   class="min-h-10 inline-flex items-center gap-1.5 text-sm font-semibold text-[#2E7D32] hover:text-[#1B5E20] hover:underline">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <line x1="19" y1="12" x2="5" y2="12" />
                        <polyline points="12 19 5 12 12 5" />
                    </svg>
                    <span>Food Listings</span>
                </a>
                <span class="text-[#d5dfd8]">/</span>
                <span class="text-sm font-semibold">{{ $listing->food_name }}</span>
            </div>

            @if ($isProvider && $listing->status !== 'Withdrawn')
                <a href="{{ route('food-listings.edit', $listingId) }}"
                   class="min-h-10 px-4 py-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-semibold rounded-lg inline-flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    <span>Edit Listing</span>
                </a>
            @endif
        </header>

        <main class="p-8 flex-1">
            <div class="max-w-5xl space-y-6">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <h2 class="text-xl font-bold tracking-tight">{{ $listing->food_name }}</h2>
                        <p class="text-sm text-[#4a5d50] mt-1">
                            Full batch specifications, storage instructions, and redistribution status.
                        </p>
                    </div>

                    <x-listing-status-badge :status="$listing->status ?? 'Available'" />
                </div>

                @if (session('success'))
                    <div class="rounded-lg bg-[#e8f5e9] border border-[#2E7D32]/20 px-4 py-3.5 text-sm text-[#2E7D32] font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="rounded-lg bg-[#fee2e2] border border-[#b91c1c]/20 px-4 py-3.5 text-sm text-[#b91c1c] font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                @php
                    $availQty = $listing->available_quantity ?? 0;
                    $resQty = $listing->reserved_quantity ?? 0;
                    $redistQty = $listing->redistributed_quantity ?? 0;
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white border border-[#d5dfd8] rounded-xl p-6">
                        <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                            Available Stock
                        </span>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="text-3xl font-bold">{{ $availQty }}</span>
                            <span class="text-sm font-medium text-[#2E7D32]">open</span>
                        </div>
                    </div>

                    <div class="bg-white border border-[#d5dfd8] rounded-xl p-6">
                        <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                            Reserved Stock
                        </span>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="text-3xl font-bold">{{ $resQty }}</span>
                            <span class="text-sm font-medium text-[#b45309]">pending pickup</span>
                        </div>
                    </div>

                    <div class="bg-white border border-[#d5dfd8] rounded-xl p-6">
                        <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                            Redistributed Stock
                        </span>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="text-3xl font-bold">{{ $redistQty }}</span>
                            <span class="text-sm font-medium text-[#4a5d50]">completed</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-[#d5dfd8] rounded-xl divide-y divide-[#d5dfd8]">
                    <div class="px-6 py-4">
                        <h3 class="text-base font-bold">Batch Specifications & Handling</h3>
                    </div>

                    <dl class="divide-y divide-[#d5dfd8] text-sm">

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Food Item Name</dt>
                            <dd class="sm:col-span-2 font-semibold">{{ $listing->food_name }}</dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Category</dt>
                            <dd class="sm:col-span-2 font-medium">{{ $listing->category ?? '—' }}</dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Total Quantity</dt>
                            <dd class="sm:col-span-2 font-medium">{{ $listing->quantity }}</dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Storage Requirement</dt>
                            <dd class="sm:col-span-2 font-medium">{{ $listing->storage_requirement ?? '—' }}</dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Food Condition</dt>
                            <dd class="sm:col-span-2 font-medium">{{ $listing->food_condition ?? '—' }}</dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Expiration Date</dt>
                            <dd class="sm:col-span-2 font-medium">{{ $expirationDate }}</dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Allergen Information</dt>
                            <dd class="sm:col-span-2 font-medium whitespace-pre-line">{{ $listing->allergen_information ?: 'No allergen information provided.' }}</dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Pickup Details</dt>
                            <dd class="sm:col-span-2 font-medium whitespace-pre-line">{{ $listing->pickup_details ?: 'No pickup details provided.' }}</dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Description</dt>
                            <dd class="sm:col-span-2 font-normal text-[#4a5d50] leading-relaxed whitespace-pre-line">
                                {{ $listing->description ?: 'No additional description provided.' }}
                            </dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Posted By Organization</dt>
                            <dd class="sm:col-span-2 font-medium">
                                {{ $listing->organization->organization_name ?? 'Food Provider' }}
                            </dd>
                        </div>

                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">Date Posted</dt>
                            <dd class="sm:col-span-2 font-medium">
                                {{ $listing->created_at ? $listing->created_at->format('M d, Y • h:i A') : '—' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-white border border-[#d5dfd8] rounded-xl p-6 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h3 class="text-sm font-bold">Manage Listing Record</h3>

                        @if ($isProvider)
                            <p class="text-xs text-[#4a5d50] mt-0.5">
                                Withdraw this listing if it is no longer available for redistribution. Its record will be retained.
                            </p>
                        @else
                            <p class="text-xs text-[#4a5d50] mt-0.5">
                                View the listing details and return to the available food inventory.
                            </p>
                        @endif
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('food-listings.index') }}"
                           class="min-h-10 px-4 py-2 bg-white hover:bg-[#e8efe9] text-[#14281d] border border-[#d5dfd8] rounded-lg text-sm font-semibold inline-flex items-center transition-colors">
                            Back to Inventory
                        </a>

                        @if ($isProvider && $listing->status !== 'Withdrawn')
                            <form action="{{ route('food-listings.destroy', $listingId) }}"
                                  method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        onclick="return confirm('Withdraw {{ addslashes($listing->food_name) }}? The listing record will be retained, but recipients will no longer see it.')"
                                        class="min-h-10 px-4 py-2 bg-white hover:bg-[#fee2e2] text-[#b91c1c] border border-[#d5dfd8] hover:border-[#b91c1c]/30 rounded-lg text-sm font-semibold inline-flex items-center gap-2 transition-colors cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>
                                    <span>Withdraw Listing</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
