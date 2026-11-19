@php
    $user = auth()->user();
    $role = strtolower(str_replace(' ', '_', trim($user->role ?? '')));

    $isAdmin = in_array($role, ['administrator', 'admin'], true);
    $isProvider = $role === 'food_provider';
    $isRecipient = $role === 'recipient_organization';

    $isVerified = strtolower(trim($user->organization?->verification_status ?? 'pending')) === 'verified';
    $canAccessFeatures = $isAdmin || (($isProvider || $isRecipient) && $isVerified);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodRescue Hub - Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
        }
    </style>
</head>
<aside class="w-64 bg-white fixed inset-y-0 left-0 border-r border-slate-200 p-5 flex flex-col justify-between z-10">

    <div>
        <!-- BRANDING -->
        <div class="flex items-center gap-2 mb-8 px-2">
            <svg class="h-6 w-6 text-[#2E7D32] shrink-0"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M12 2C6.5 2 3 7.5 3 13c0 4.5 3.5 8 9 9 5.5-1 9-4.5 9-9 0-5.5-3.5-11-9-11z" />
                <path d="M12 2v20" />
                <path d="M8 9.5a4 4 0 0 0 4 3.5 4 4 0 0 0 4-3.5" />
                <path d="M10 9.5v3" />
                <path d="M14 9.5v3" />
            </svg>

            <span class="text-base font-bold text-slate-900 tracking-wide">
                FoodRescue Hub
            </span>
        </div>

        <!-- NAVIGATION LINKS -->
        <nav class="space-y-1">
            <a href="{{ route('dashboard') }}"
               class="block px-3 py-2 rounded-md text-xs font-semibold transition-colors {{ request()->routeIs('dashboard') ? 'text-slate-900 bg-slate-100' : 'text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32]' }}">
                Dashboard
            </a>

            @if ($canAccessFeatures)

                @if ($isAdmin)
                    <a href="{{ route('admin.verifications.index') }}"
                       class="block px-3 py-2 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.verifications.*') ? 'text-slate-900 bg-slate-100 font-semibold' : 'text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32]' }}">
                        Verification Requests
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                       class="block px-3 py-2 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'text-slate-900 bg-slate-100 font-semibold' : 'text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32]' }}">
                        User Management
                    </a>
                    <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32] transition-colors">
                        Reports
                    </a>
                    <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32] transition-colors">
                        Audit Logs
                    </a>

                @elseif ($isProvider)
                    <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32] transition-colors">
                        Food Listings
                    </a>
                    <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32] transition-colors">
                        Inventory Management
                    </a>
                    <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32] transition-colors">
                        Food Requests
                    </a>
                    <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32] transition-colors">
                        Pickup Schedules
                    </a>
                    <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32] transition-colors">
                        Redistribution History
                    </a>

                @elseif ($isRecipient)
                    <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32] transition-colors">
                        Browse Available Food
                    </a>
                    <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32] transition-colors">
                        My Requests
                    </a>
                    <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32] transition-colors">
                        Pickup Schedules
                    </a>
                    <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32] transition-colors">
                        Received Food
                    </a>
                @endif

                <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32] transition-colors">
                    My Profile
                </a>

            @else
                <div class="mt-4 rounded-lg bg-amber-100 border border-amber-200 p-3">
                    <strong class="block text-xs font-semibold text-amber-800 mb-1">
                        Restricted Access
                    </strong>
                    <p class="text-[11px] text-amber-800 leading-relaxed">
                        Your organization must be verified before you can access other system features.
                    </p>
                </div>
            @endif
        </nav>
    </div>

    <!-- LOGOUT FORM -->
    <form method="POST" action="{{ route('logout') }}" class="pt-4 border-t border-slate-200">
        @csrf
        <button type="submit"
                class="w-full px-3 py-2 text-left text-xs font-semibold text-rose-700 hover:bg-rose-50 rounded-md transition-colors cursor-pointer">
            Logout
        </button>
    </form>

</aside>