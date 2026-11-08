@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
    $role = strtolower(str_replace(' ', '_', trim($user->role ?? '')));
    $isAdmin = $role === 'administrator';
    $isProvider = $role === 'food_provider';
    $isRecipient = $role === 'recipient_organization';
    $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
    if ($fullName === '') { $fullName = $user->name ?? 'User'; }
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodRescue Hub - Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-[#f4f6f9] font-sans flex flex-col md:flex-row antialiased text-gray-900">

    <!-- INCLUDE SEPARATE SIDEBAR -->
    @include('components.sidebar')

    <!-- MAIN DASHBOARD CONTENT -->
    <main class="flex-1 p-6 lg:p-10 max-w-7xl mx-auto w-full flex flex-col gap-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200/60">
            <div>
                <span class="text-[11px] font-semibold text-[#2E7D32] uppercase tracking-wider">Dashboard Portal</span>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Welcome back, {{ $fullName }}</h1>
            </div>

            <div>
                @if ($isProvider)
                    <a href="#" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-md bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-xs font-semibold shadow-xs transition-colors">+ New Food Listing</a>
                @elseif ($isRecipient)
                    <a href="#" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-md bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-xs font-semibold shadow-xs transition-colors">Browse Available Food</a>
                @endif
            </div>
        </div>

        {{-- ADMINISTRATOR VIEW --}}
        @if ($isAdmin)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg border border-gray-200/80 p-4 border-l-4 border-l-[#2E7D32]">
                    <span class="text-[11px] font-medium text-gray-500 uppercase">Total Organizations</span>
                    <p class="text-xl font-bold text-gray-900 mt-1">{{ $totalOrganizations ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200/80 p-4 border-l-4 border-l-amber-500">
                    <span class="text-[11px] font-medium text-gray-500 uppercase">Pending Verifications</span>
                    <p class="text-xl font-bold text-amber-600 mt-1">{{ $pendingVerifications ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200/80 p-4 border-l-4 border-l-emerald-500">
                    <span class="text-[11px] font-medium text-gray-500 uppercase">Active Food Listings</span>
                    <p class="text-xl font-bold text-[#2E7D32] mt-1">{{ $activeListings ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200/80 p-4 border-l-4 border-l-blue-500">
                    <span class="text-[11px] font-medium text-gray-500 uppercase">Completed Redistributions</span>
                    <p class="text-xl font-bold text-blue-600 mt-1">{{ $completedRedistributions ?? 0 }}</p>
                </div>
            </div>

        {{-- FOOD PROVIDER VIEW --}}
        @elseif ($isProvider)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg border border-gray-200/80 p-4 border-l-4 border-l-[#2E7D32]">
                    <span class="text-[11px] font-medium text-gray-500 uppercase">Active Listings</span>
                    <p class="text-xl font-bold text-[#2E7D32] mt-1">{{ $activeListings ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200/80 p-4 border-l-4 border-l-blue-500">
                    <span class="text-[11px] font-medium text-gray-500 uppercase">Pending Requests</span>
                    <p class="text-xl font-bold text-blue-600 mt-1">{{ $pendingRequests ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200/80 p-4 border-l-4 border-l-red-500">
                    <span class="text-[11px] font-medium text-gray-500 uppercase">Expiring Soon</span>
                    <p class="text-xl font-bold text-red-600 mt-1">{{ $expiringListings ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200/80 p-4 border-l-4 border-l-amber-500">
                    <span class="text-[11px] font-medium text-gray-500 uppercase">Upcoming Pickups</span>
                    <p class="text-xl font-bold text-amber-600 mt-1">{{ $upcomingPickups ?? 0 }}</p>
                </div>
            </div>

        {{-- RECIPIENT ORGANIZATION VIEW --}}
        @elseif ($isRecipient)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg border border-gray-200/80 p-4 border-l-4 border-l-[#2E7D32]">
                    <span class="text-[11px] font-medium text-gray-500 uppercase">Available Food</span>
                    <p class="text-xl font-bold text-[#2E7D32] mt-1">{{ $availableListings ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200/80 p-4 border-l-4 border-l-blue-500">
                    <span class="text-[11px] font-medium text-gray-500 uppercase">Submitted Requests</span>
                    <p class="text-xl font-bold text-blue-600 mt-1">{{ $myRequests ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200/80 p-4 border-l-4 border-l-emerald-500">
                    <span class="text-[11px] font-medium text-gray-500 uppercase">Approved Requests</span>
                    <p class="text-xl font-bold text-emerald-600 mt-1">{{ $approvedRequests ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200/80 p-4 border-l-4 border-l-amber-500">
                    <span class="text-[11px] font-medium text-gray-500 uppercase">Scheduled Pickups</span>
                    <p class="text-xl font-bold text-amber-600 mt-1">{{ $upcomingPickups ?? 0 }}</p>
                </div>
            </div>
        @endif

    </main>

</body>
</html>