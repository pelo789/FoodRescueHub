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

<aside class="w-full md:w-64 bg-white border-r border-gray-200/80 flex flex-col justify-between p-6 shrink-0 md:h-screen md:sticky md:top-0 z-20">
    <div>
        <!-- ORIGINAL LOGO RESTORED -->
        <div class="flex items-center gap-2.5 mb-10">
            <svg class="h-6 w-6 text-[#2E7D32] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2C6.5 2 3 7.5 3 13c0 4.5 3.5 8 9 9 5.5-1 9-4.5 9-9 0-5.5-3.5-11-9-11z" />
                <path d="M12 2v20" />
                <path d="M8 9.5a4 4 0 0 0 4 3.5 4 4 0 0 0 4-3.5" />
                <path d="M10 9.5v3" />
                <path d="M14 9.5v3" />
            </svg>
            <span class="text-lg font-bold text-gray-900 tracking-wide whitespace-nowrap">FoodRescue Hub</span>
        </div>

        <!-- NAVIGATION -->
        <nav class="space-y-1 text-xs font-medium">
            <p class="px-3 pb-2 text-[10px] font-semibold uppercase tracking-wider text-gray-400">Main Menu</p>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-md bg-[#2E7D32] text-white font-medium transition-colors shadow-xs">
                Overview
            </a>

            @if ($isAdmin)
                <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">Organizations</a>
                <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">Verification Requests</a>
                <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">User Accounts</a>
                <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">System Reports</a>
            @elseif ($isProvider)
                <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">Food Listings</a>
                <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">Inventory Status</a>
                <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">Incoming Requests</a>
            @elseif ($isRecipient)
                <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">Browse Marketplace</a>
                <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">My Active Requests</a>
            @endif
        </nav>
    </div>

    <!-- PROFILE & LOGOUT -->
    <div class="pt-4 border-t border-gray-100">
        <div class="mb-3 px-1">
            <p class="text-xs font-semibold text-gray-900 truncate">{{ $fullName }}</p>
            <p class="text-[10px] text-gray-500 capitalize">{{ str_replace('_', ' ', $role) }}</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-md bg-gray-50 hover:bg-red-50 text-gray-600 hover:text-red-600 text-xs font-medium transition-colors cursor-pointer border border-gray-200/60 hover:border-red-200">
                Sign Out
            </button>
        </form>
    </div>
</aside>