@php
    $user = auth()->user();
    $role = strtolower(str_replace(' ', '_', trim($user->role ?? '')));

    $isAdmin = in_array($role, ['administrator', 'admin'], true);
    $isProvider = $role === 'food_provider';
    $isRecipient = $role === 'recipient_organization';

    $isVerified = strtolower(trim($user->organization?->verification_status ?? 'pending')) === 'verified';
    $canAccessFeatures = $isAdmin || (($isProvider || $isRecipient) && $isVerified);
@endphp

<aside class="w-64 bg-[#1b3b24] text-[#e8f5e9] fixed inset-y-0 left-0 border-r border-white/10 flex flex-col justify-between z-10">

    <div>
        <!-- BRANDING -->
        <div class="h-16 px-6 border-b border-white/10 flex items-center gap-3">
            <svg class="w-5 h-5 text-[#e8f5e9] shrink-0"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.75"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M12 2C6.5 2 3 7.5 3 13c0 4.5 3.5 8 9 9 5.5-1 9-4.5 9-9 0-5.5-3.5-11-9-11z" />
                <path d="M12 2v20" />
                <path d="M8 9.5a4 4 0 0 0 4 3.5 4 4 0 0 0 4-3.5" />
                <path d="M10 9.5v3" />
                <path d="M14 9.5v3" />
            </svg>

            <span class="text-base font-bold text-white tracking-tight">
                FoodRescue Hub
            </span>
        </div>
        <!-- NAVIGATION LINKS -->
        <div class="p-4 space-y-6">
            <div>
                <p class="px-3 text-[11px] font-semibold uppercase tracking-wider text-[#e8f5e9]/60 mb-2">
                    Overview
                </p>
                <a href="{{ route('dashboard') }}"
                   class="min-h-10 px-3 py-2 rounded-lg text-sm flex items-center gap-3 transition-colors {{ request()->routeIs('dashboard') ? 'bg-[#2E7D32] text-white font-semibold' : 'text-[#e8f5e9]/85 font-medium hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>

            @if ($canAccessFeatures)
                <div>
                    <p class="px-3 text-[11px] font-semibold uppercase tracking-wider text-[#e8f5e9]/60 mb-2">
                        {{ $isAdmin ? 'Administration' : 'Operations' }}
                    </p>
                    <nav class="space-y-1">
                        @if ($isAdmin)
                            <a href="{{ route('admin.verifications.index') }}"
                               class="min-h-10 px-3 py-2 rounded-lg text-sm flex items-center gap-3 transition-colors {{ request()->routeIs('admin.verifications.*') ? 'bg-[#2E7D32] text-white font-semibold' : 'text-[#e8f5e9]/85 font-medium hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 12l2 2 4-4" />
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                </svg>
                                <span>Verification Requests</span>
                            </a>
                            <a href="{{ route('admin.users.index') }}"
                               class="min-h-10 px-3 py-2 rounded-lg text-sm flex items-center gap-3 transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-[#2E7D32] text-white font-semibold' : 'text-[#e8f5e9]/85 font-medium hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                                <span>User Management</span>
                            </a>
                            <a href="#" class="min-h-10 px-3 py-2 rounded-lg text-sm flex items-center gap-3 text-[#e8f5e9]/85 font-medium hover:bg-white/10 hover:text-white transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="20" x2="18" y2="10" />
                                    <line x1="12" y1="20" x2="12" y2="4" />
                                    <line x1="6" y1="20" x2="6" y2="14" />
                                </svg>
                                <span>Reports</span>
                            </a>
                            <a href="#" class="min-h-10 px-3 py-2 rounded-lg text-sm flex items-center gap-3 text-[#e8f5e9]/85 font-medium hover:bg-white/10 hover:text-white transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                                <span>Audit Logs</span>
                            </a>

                        @elseif ($isProvider)
                            <a href="#" class="min-h-10 px-3 py-2 rounded-lg text-sm flex items-center gap-3 text-[#e8f5e9]/85 font-medium hover:bg-white/10 hover:text-white transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                </svg>
                                <span>Food Listings</span>
                            </a>
                            <a href="#" class="min-h-10 px-3 py-2 rounded-lg text-sm flex items-center gap-3 text-[#e8f5e9]/85 font-medium hover:bg-white/10 hover:text-white transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="8" y1="6" x2="21" y2="6" />
                                    <line x1="8" y1="12" x2="21" y2="12" />
                                    <line x1="8" y1="18" x2="21" y2="18" />
                                    <line x1="3" y1="6" x2="3.01" y2="6" />
                                    <line x1="3" y1="12" x2="3.01" y2="12" />
                                    <line x1="3" y1="18" x2="3.01" y2="18" />
                                </svg>
                                <span>Inventory Management</span>
                            </a>
                            <a href="#" class="min-h-10 px-3 py-2 rounded-lg text-sm flex items-center gap-3 text-[#e8f5e9]/85 font-medium hover:bg-white/10 hover:text-white transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="22 12 16 12 14 15 10 15 8 12 2 12" />
                                    <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z" />
                                </svg>
                                <span>Food Requests</span>
                            </a>
                            <a href="#" class="min-h-10 px-3 py-2 rounded-lg text-sm flex items-center gap-3 text-[#e8f5e9]/85 font-medium hover:bg-white/10 hover:text-white transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                                <span>Pickup Schedules</span>
                            </a>
                            <a href="#" class="min-h-10 px-3 py-2 rounded-lg text-sm flex items-center gap-3 text-[#e8f5e9]/85 font-medium hover:bg-white/10 hover:text-white transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                <span>Redistribution History</span>
                            </a>
                        @elseif ($isRecipient)
                            <a href="#" class="min-h-10 px-3 py-2 rounded-lg text-sm flex items-center gap-3 text-[#e8f5e9]/85 font-medium hover:bg-white/10 hover:text-white transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                </svg>
                                <span>Browse Available Food</span>
                            </a>
                            <a href="#" class="min-h-10 px-3 py-2 rounded-lg text-sm flex items-center gap-3 text-[#e8f5e9]/85 font-medium hover:bg-white/10 hover:text-white transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                                <span>My Requests</span>
                            </a>
                            <a href="#" class="min-h-10 px-3 py-2 rounded-lg text-sm flex items-center gap-3 text-[#e8f5e9]/85 font-medium hover:bg-white/10 hover:text-white transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                                <span>Pickup Schedules</span>
                            </a>
                            <a href="#" class="min-h-10 px-3 py-2 rounded-lg text-sm flex items-center gap-3 text-[#e8f5e9]/85 font-medium hover:bg-white/10 hover:text-white transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                                <span>Received Food</span>
                            </a>
                        @endif

                        <a href="#" class="min-h-10 px-3 py-2 rounded-lg text-sm flex items-center gap-3 text-[#e8f5e9]/85 font-medium hover:bg-white/10 hover:text-white transition-colors">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            <span>My Profile</span>
                        </a>
                    </nav>
                </div>
            @else
                <div class="p-3.5 rounded-lg bg-white/10 border border-white/10">
                    <p class="text-xs font-semibold text-white mb-1">
                        Restricted Access
                    </p>
                    <p class="text-xs text-[#e8f5e9]/80 leading-relaxed text-left">
                        Your organization must be verified before you can access other system features.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-white/10">
        @csrf
        <button type="submit"
                class="w-full min-h-10 px-3 py-2 text-left text-sm font-semibold text-rose-200 hover:bg-[#b91c1c] hover:text-white rounded-lg flex items-center gap-3 transition-colors cursor-pointer">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                <polyline points="16 17 21 12 16 7" />
                <line x1="21" y1="12" x2="9" y2="12" />
            </svg>
            <span>Logout</span>
        </button>
    </form>

</aside>
