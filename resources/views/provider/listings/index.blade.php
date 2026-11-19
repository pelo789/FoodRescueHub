<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Food Listings & Inventory — FoodRescue Hub</title>

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
                    Food Listings & Inventory
                </h1>
                <span class="text-[#d5dfd8]">/</span>
                <span class="text-sm text-[#4a5d50]">
                    Food Provider
                </span>
            </div>

            <!-- SINGLE PRIMARY CTA (Von Restorff Effect) -->
            <a href="{{ Route::has('provider.listings.create') ? route('provider.listings.create') : '#' }}"
               class="min-h-10 px-4 py-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-semibold rounded-lg inline-flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                <span>Post Surplus Food</span>
            </a>
        </header>

        <!-- MAIN WORKSPACE -->
        <main class="p-8 flex-1">
            <div class="max-w-6xl space-y-6">

                <!-- PAGE SUBTITLE -->
                <div>
                    <h2 class="text-xl font-bold text-[#14281d] tracking-tight text-left">
                        Surplus Food Inventory
                    </h2>
                    <p class="text-sm text-[#4a5d50] mt-1 text-left">
                        Monitor available, reserved, and redistributed stock quantities alongside batch expiration dates.
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

                @php
                    $items = collect($listings ?? []);
                    $activeStatus = $status ?? request('status', 'all');
                    $expiringSoonCount = $expiringCount ?? $items->filter(function ($item) {
                        if (empty($item->expiry_date)) return false;
                        $daysLeft = \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($item->expiry_date)->startOfDay(), false);
                        return $daysLeft >= 0 && $daysLeft <= 2 && !in_array($item->status ?? '', ['Expired', 'Withdrawn', 'Fully Redistributed']);
                    })->count();
                @endphp

                <!-- INVENTORY KPI METRIC ROW -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl p-6">
                        <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                            Available Listings
                        </span>
                        <div class="mt-2 flex items-baseline justify-between">
                            <span class="text-3xl font-bold text-[#14281d]">
                                {{ $availableCount ?? $items->where('status', 'Available')->count() }}
                            </span>
                            <span class="text-xs font-semibold text-[#2E7D32]">Open for claims</span>
                        </div>
                    </div>

                    <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl p-6">
                        <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                            Expiring Within 48 Hours
                        </span>
                        <div class="mt-2 flex items-baseline justify-between">
                            <span class="text-3xl font-bold text-[#14281d]">
                                {{ $expiringSoonCount }}
                            </span>
                            <span class="text-xs font-semibold text-[#b45309]">Priority redistribution</span>
                        </div>
                    </div>

                    <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl p-6">
                        <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                            Total Recorded Batches
                        </span>
                        <div class="mt-2 flex items-baseline justify-between">
                            <span class="text-3xl font-bold text-[#14281d]">
                                {{ $totalCount ?? $items->count() }}
                            </span>
                            <span class="text-xs text-[#4a5d50]">All BRD statuses</span>
                        </div>
                    </div>
                </div>
                <!-- BRD STATUS FILTER TABS (Section 5.5) -->
                @php
                    $statusTabs = [
                        'all' => 'All',
                        'Available' => 'Available',
                        'Partially Reserved' => 'Partially Reserved',
                        'Fully Reserved' => 'Fully Reserved',
                        'Partially Redistributed' => 'Partially Redistributed',
                        'Fully Redistributed' => 'Fully Redistributed',
                        'Expired' => 'Expired',
                        'Withdrawn' => 'Withdrawn',
                    ];
                @endphp

                <div class="flex flex-wrap gap-2">
                    @foreach ($statusTabs as $tabValue => $tabLabel)
                        <a href="{{ Route::has('provider.listings.index') ? route('provider.listings.index', ['status' => $tabValue]) : '#' }}"
                           class="min-h-10 px-3.5 py-2 rounded-lg text-xs font-semibold border inline-flex items-center transition-colors {{ $activeStatus === $tabValue ? 'bg-[#2E7D32] text-white border-[#2E7D32]' : 'bg-[#ffffff] text-[#4a5d50] border-[#d5dfd8] hover:bg-[#e8efe9] hover:text-[#14281d]' }}">
                            {{ $tabLabel }}
                        </a>
                    @endforeach
                </div>

                <!-- INVENTORY DATA TABLE -->
                <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#d5dfd8] text-sm text-left">
                            <thead class="bg-[#e8efe9]">
                                <tr>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                        Food Batch & Category
                                    </th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                        Stock Breakdown (BR-M10)
                                    </th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                        Expiration & Pickup Window
                                    </th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                        Status
                                    </th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#d5dfd8] bg-[#ffffff]">
                                @forelse ($items as $listing)
                                    @php
                                        $listingId = $listing->food_listing_id ?? $listing->id ?? 0;
                                        $unitLabel = $listing->unit ?? 'pcs';
                                        $availQty = $listing->available_quantity ?? $listing->quantity ?? 0;
                                        $resQty = $listing->reserved_quantity ?? 0;
                                        $redistQty = $listing->redistributed_quantity ?? 0;
                                        $daysToExpiry = !empty($listing->expiry_date)
                                            ? \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($listing->expiry_date)->startOfDay(), false)
                                            : null;
                                        $isExpiringSoon = $daysToExpiry !== null && $daysToExpiry >= 0 && $daysToExpiry <= 2 && !in_array($listing->status ?? '', ['Expired', 'Withdrawn', 'Fully Redistributed']);
                                    @endphp
                                    <tr class="hover:bg-[#e8efe9]/60 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-[#14281d]">
                                                {{ $listing->food_name }}
                                            </div>
                                            <div class="text-xs text-[#4a5d50] mt-0.5">
                                                {{ $listing->category ?? 'General Surplus' }}{{ !empty($listing->storage_condition) ? ' • ' . $listing->storage_condition : '' }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-[#14281d]">
                                                {{ $availQty }} {{ $unitLabel }} <span class="font-normal text-[#4a5d50]">available</span>
                                            </div>
                                            <div class="text-xs text-[#4a5d50] mt-0.5">
                                                Reserved: {{ $resQty }} {{ $unitLabel }} • Redistributed: {{ $redistQty }} {{ $unitLabel }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="font-medium text-[#14281d]">
                                                    {{ !empty($listing->expiry_date) ? \Carbon\Carbon::parse($listing->expiry_date)->format('M d, Y') : '—' }}
                                                </span>
                                                @if ($isExpiringSoon)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-[#fef3c7] text-[#b45309] border border-[#b45309]/20">
                                                        Expiring Soon
                                                    </span>
                                                @endif
                                            </div>
                                            @if (!empty($listing->pickup_start) || !empty($listing->pickup_end))
                                                <div class="text-xs text-[#4a5d50] mt-0.5">
                                                    Pickup: {{ $listing->pickup_start ?? '' }} – {{ $listing->pickup_end ?? '' }}
                                                </div>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4">
                                            <x-listing-status-badge :status="$listing->status ?? 'Available'" />
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ Route::has('provider.listings.show') ? route('provider.listings.show', $listingId) : '#' }}"
                                                   class="min-h-10 px-3.5 py-2 bg-[#ffffff] hover:bg-[#e8efe9] text-[#14281d] border border-[#d5dfd8] rounded-lg text-xs font-semibold inline-flex items-center transition-colors">
                                                    View
                                                </a>

                                                <a href="{{ Route::has('provider.listings.edit') ? route('provider.listings.edit', $listingId) : '#' }}"
                                                   class="min-h-10 px-3.5 py-2 bg-[#ffffff] hover:bg-[#e8efe9] text-[#14281d] border border-[#d5dfd8] rounded-lg text-xs font-semibold inline-flex items-center transition-colors">
                                                    Edit
                                                </a>

                                                <form action="{{ Route::has('provider.listings.destroy') ? route('provider.listings.destroy', $listingId) : '#' }}"
                                                      method="POST"
                                                      class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            onclick="return confirm('Delete {{ addslashes($listing->food_name) }} from your inventory?')"
                                                            class="min-h-10 px-3.5 py-2 bg-[#ffffff] hover:bg-[#fee2e2] text-[#b91c1c] border border-[#d5dfd8] hover:border-[#b91c1c]/30 rounded-lg text-xs font-semibold inline-flex items-center transition-colors cursor-pointer">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-left text-sm text-[#4a5d50]">
                                            No surplus food listings recorded yet. Click <strong>Post Surplus Food</strong> in the top right to add your first batch.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>

    </div>

</body>
</html>
