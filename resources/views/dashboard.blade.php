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
    <!-- Tailwind CSS v4 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-[#f4f6f9] font-sans flex flex-col md:flex-row antialiased text-gray-900">

    <!-- INCLUDE SEPARATE SIDEBAR COMPONENT -->
    @include('components.sidebar')

    <!-- MAIN DASHBOARD CONTENT -->
    <main class="flex-1 p-6 lg:p-10 max-w-7xl mx-auto w-full flex flex-col gap-6">

        <!-- HEADER BANNER & QUICK ACTIONS -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200/60">
            <div>
                <span class="text-[11px] font-semibold text-[#2E7D32] uppercase tracking-wider">Dashboard Portal</span>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Welcome back, {{ $fullName }}! 👋</h1>
            </div>

            <div>
                @if ($isProvider)
                    <a href="#" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-md bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-xs font-semibold shadow-xs transition-colors">+ New Food Listing</a>
                @elseif ($isRecipient)
                    <a href="#" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-md bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-xs font-semibold shadow-xs transition-colors">Browse Available Food</a>
                @elseif ($isAdmin)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-green-50 border border-green-200 text-xs font-semibold text-[#2E7D32]">System Admin Active</span>
                @endif
            </div>
        </div>

        {{-- ADMINISTRATOR DASHBOARD SUMMARIES (BRD-M21, BRD-M22) --}}
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

            <div class="bg-white rounded-xl border border-gray-200/80 p-6 shadow-xs">
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Recent System Activity Logs</h2>
                <div class="divide-y divide-gray-100 text-xs">
                    @isset($recentActivities)
                        @forelse($recentActivities as $activity)
                            <div class="py-3 flex items-center justify-between">
                                <span class="font-medium text-gray-800">{{ $activity->description ?? $activity->action }}</span>
                                <span class="text-gray-400 font-mono">{{ $activity->created_at }}</span>
                            </div>
                        @empty
                            <p class="py-4 text-gray-400 text-center">No recent activities recorded.</p>
                        @endforelse
                    @else
                        <p class="py-4 text-gray-400 text-center">No recent activities recorded.</p>
                    @endisset
                </div>
            </div>

        {{-- FOOD PROVIDER DASHBOARD SUMMARIES (BRD-M07, BRD-M10, BRD-M16) --}}
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

            <div class="bg-white rounded-xl border border-gray-200/80 p-6 shadow-xs">
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Recent Food Inventory Listings</h2>
                <div class="divide-y divide-gray-100 text-xs">
                    @isset($recentListings)
                        @forelse($recentListings as $listing)
                            <div class="py-3 flex items-center justify-between">
                                <div>
                                    <span class="font-semibold text-gray-900 block">{{ $listing->name }}</span>
                                    <span class="text-gray-500">Quantity: {{ $listing->quantity }} units</span>
                                </div>
                                <span class="px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 font-medium">Exp: {{ $listing->expiration_date }}</span>
                            </div>
                        @empty
                            <p class="py-4 text-gray-400 text-center">No active food listings found.</p>
                        @endforelse
                    @else
                        <p class="py-4 text-gray-400 text-center">No active food listings found.</p>
                    @endisset
                </div>
            </div>

        {{-- RECIPIENT ORGANIZATION DASHBOARD SUMMARIES (BRD-M11, BRD-S05) --}}
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

            <div class="bg-white rounded-xl border border-gray-200/80 p-6 shadow-xs">
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Recent Request Status</h2>
                <div class="divide-y divide-gray-100 text-xs">
                    @isset($recentRequests)
                        @forelse($recentRequests as $request)
                            <div class="py-3 flex items-center justify-between">
                                <span class="font-semibold text-gray-900">Request #{{ $request->id }}</span>
                                <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-700 font-semibold">{{ $request->status }}</span>
                            </div>
                        @empty
                            <p class="py-4 text-gray-400 text-center">No requests submitted yet.</p>
                        @endforelse
                    @else
                        <p class="py-4 text-gray-400 text-center">No requests submitted yet.</p>
                    @endisset
                </div>
            </div>
        @endif

    </main>

</body>
</html>