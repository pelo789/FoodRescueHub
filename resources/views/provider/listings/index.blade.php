
@php
    $userRole = strtolower(str_replace(' ', '_', trim(auth()->user()->role ?? '')));
    $isProvider = $userRole === 'food_provider';
    $isRecipient = $userRole === 'recipient_organization';

    $allItems = collect($foodListings ?? []);
    $activeStatus = request('status', 'all');

    $items = $allItems;

    if ($isProvider && $activeStatus !== 'all') {
        $items = $allItems->where('status', $activeStatus);
    }

    $availableCount = $allItems->filter(function ($item) {
        return $item->available_quantity > 0
            && !in_array($item->status, ['Withdrawn', 'Expired']);
    })->count();

    $expiringSoonCount = $allItems->filter(function ($item) {
        if (!$item->expiration_date) {
            return false;
        }

        $daysLeft = now()->startOfDay()->diffInDays(
            \Carbon\Carbon::parse($item->expiration_date)->startOfDay(),
            false
        );

        return $daysLeft >= 0
            && $daysLeft <= 2
            && !in_array($item->status, ['Expired', 'Withdrawn', 'Fully Redistributed']);
    })->count();

    $totalCount = $allItems->count();

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $isProvider ? 'Food Listings & Inventory' : 'Available Food Listings' }} — FoodRescue Hub</title>

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
                <h1 class="text-base font-bold">
                    {{ $isProvider ? 'Food Listings & Inventory' : 'Available Food Listings' }}
                </h1>
                <span class="text-[#d5dfd8]">/</span>
                <span class="text-sm text-[#4a5d50]">
                    {{ $isProvider ? 'Food Provider' : 'Recipient Organization' }}
                </span>
            </div>

            @if ($isProvider)
                <a href="{{ route('food-listings.create') }}"
                   class="min-h-10 px-4 py-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-semibold rounded-lg inline-flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    <span>Post Surplus Food</span>
                </a>
            @endif
        </header>

        <main class="p-8 flex-1">
            <div class="max-w-6xl space-y-6">

                <div>
                    <h2 class="text-xl font-bold tracking-tight">
                        {{ $isProvider ? 'Surplus Food Inventory' : 'Browse Available Surplus Food' }}
                    </h2>
                    <p class="text-sm text-[#4a5d50] mt-1">
                        {{ $isProvider
                            ? 'Monitor available, reserved, and redistributed stock quantities alongside batch expiration dates.'
                            : 'Explore food listings currently available for redistribution from verified food providers.' }}
                    </p>
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

                @if ($isProvider)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white border border-[#d5dfd8] rounded-xl p-6">
                            <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                Available Listings
                            </span>
                            <div class="mt-2 flex items-baseline justify-between">
                                <span class="text-3xl font-bold">{{ $availableCount }}</span>
                                <span class="text-xs font-semibold text-[#2E7D32]">Open for claims</span>
                            </div>
                        </div>

                        <div class="bg-white border border-[#d5dfd8] rounded-xl p-6">
                            <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                Expiring Within 48 Hours
                            </span>
                            <div class="mt-2 flex items-baseline justify-between">
                                <span class="text-3xl font-bold">{{ $expiringSoonCount }}</span>
                                <span class="text-xs font-semibold text-[#b45309]">Priority redistribution</span>
                            </div>
                        </div>

                        <div class="bg-white border border-[#d5dfd8] rounded-xl p-6">
                            <span class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                Total Recorded Batches
                            </span>
                            <div class="mt-2 flex items-baseline justify-between">
                                <span class="text-3xl font-bold">{{ $totalCount }}</span>
                                <span class="text-xs text-[#4a5d50]">All statuses</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @foreach ($statusTabs as $tabValue => $tabLabel)
                            <a href="{{ route('food-listings.index', ['status' => $tabValue]) }}"
                               class="min-h-10 px-3.5 py-2 rounded-lg text-xs font-semibold border inline-flex items-center transition-colors {{ $activeStatus === $tabValue ? 'bg-[#2E7D32] text-white border-[#2E7D32]' : 'bg-white text-[#4a5d50] border-[#d5dfd8] hover:bg-[#e8efe9] hover:text-[#14281d]' }}">
                                {{ $tabLabel }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <div class="bg-white border border-[#d5dfd8] rounded-xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#d5dfd8] text-sm text-left">
                            <thead class="bg-[#e8efe9]">
                                <tr>
                                    <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                        Food Batch & Category
                                    </th>
                                    <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                        Stock Breakdown
                                    </th>
                                    <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                        Expiration & Pickup Details
                                    </th>
                                    @if ($isRecipient)
                                        <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                            Food Provider
                                        </th>
                                    @endif
                                    <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                        Status
                                    </th>
                                    <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-[#d5dfd8] bg-white">
                                @forelse ($items as $listing)
                                    @php
                                        $listingId = $listing->food_listing_id;
                                        $availQty = $listing->available_quantity ?? 0;
                                        $resQty = $listing->reserved_quantity ?? 0;
                                        $redistQty = $listing->redistributed_quantity ?? 0;

                                        $daysToExpiry = $listing->expiration_date
                                            ? now()->startOfDay()->diffInDays(
                                                \Carbon\Carbon::parse($listing->expiration_date)->startOfDay(),
                                                false
                                            )
                                            : null;

                                        $isExpiringSoon = $daysToExpiry !== null
                                            && $daysToExpiry >= 0
                                            && $daysToExpiry <= 2
                                            && !in_array($listing->status, ['Expired', 'Withdrawn', 'Fully Redistributed']);
                                    @endphp

                                    <tr class="hover:bg-[#e8efe9]/60 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-[#14281d]">
                                                {{ $listing->food_name }}
                                            </div>
                                            <div class="text-xs text-[#4a5d50] mt-0.5">
                                                {{ $listing->category }}
                                                @if ($listing->storage_requirement)
                                                    • {{ $listing->storage_requirement }}
                                                @endif
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-[#14281d]">
                                                {{ $availQty }} <span class="font-normal text-[#4a5d50]">available</span>
                                            </div>
                                            <div class="text-xs text-[#4a5d50] mt-0.5">
                                                Total: {{ $listing->quantity }}
                                                • Reserved: {{ $resQty }}
                                                • Redistributed: {{ $redistQty }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="font-medium text-[#14281d]">
                                                    {{ $listing->expiration_date ? \Carbon\Carbon::parse($listing->expiration_date)->format('M d, Y') : '—' }}
                                                </span>

                                                @if ($isExpiringSoon)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-[#fef3c7] text-[#b45309] border border-[#b45309]/20">
                                                        Expiring Soon
                                                    </span>
                                                @endif
                                            </div>

                                            @if ($listing->pickup_details)
                                                <div class="text-xs text-[#4a5d50] mt-1 max-w-xs whitespace-pre-line">
                                                    {{ \Illuminate\Support\Str::limit($listing->pickup_details, 100) }}
                                                </div>
                                            @endif
                                        </td>

                                        @if ($isRecipient)
                                            <td class="px-6 py-4">
                                                <span class="font-medium text-[#14281d]">
                                                    {{ $listing->organization->organization_name ?? 'Food Provider' }}
                                                </span>
                                            </td>
                                        @endif

                                        <td class="px-6 py-4">
                                            <x-listing-status-badge :status="$listing->status ?? 'Available'" />
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('food-listings.show', $listingId) }}"
                                                   class="min-h-10 px-3.5 py-2 bg-white hover:bg-[#e8efe9] text-[#14281d] border border-[#d5dfd8] rounded-lg text-xs font-semibold inline-flex items-center transition-colors">
                                                    View
                                                </a>

                                                @if ($isProvider && $listing->status !== 'Withdrawn')
                                                    <a href="{{ route('food-listings.edit', $listingId) }}"
                                                       class="min-h-10 px-3.5 py-2 bg-white hover:bg-[#e8efe9] text-[#14281d] border border-[#d5dfd8] rounded-lg text-xs font-semibold inline-flex items-center transition-colors">
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('food-listings.destroy', $listingId) }}"
                                                          method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                onclick="return confirm('Withdraw {{ addslashes($listing->food_name) }} from your inventory? This listing will no longer appear to recipient organizations.')"
                                                                class="min-h-10 px-3.5 py-2 bg-white hover:bg-[#fee2e2] text-[#b91c1c] border border-[#d5dfd8] hover:border-[#b91c1c]/30 rounded-lg text-xs font-semibold inline-flex items-center transition-colors cursor-pointer">
                                                            Withdraw
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $isRecipient ? 6 : 5 }}" class="px-6 py-10 text-center text-sm text-[#4a5d50]">
                                            @if ($isProvider)
                                                No food listings found for this status. You can post a new surplus food batch using the button above.
                                            @else
                                                There are currently no available food listings. Please check again later.
                                            @endif
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
