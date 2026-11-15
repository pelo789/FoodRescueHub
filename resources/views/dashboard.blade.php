@php
    $user = auth()->user();

    $role = strtolower(str_replace(' ', '_', trim($user->role ?? '')));

    $isAdmin = in_array($role, ['administrator', 'admin'], true);
    $isProvider = $role === 'food_provider';
    $isRecipient = $role === 'recipient_organization';

    // Pull verification_status from the related Organization record
    $org = $user->organization;
    $verificationStatus = strtolower($org->verification_status ?? 'pending');
    $isVerified = $verificationStatus === 'verified';

    // Only administrators and verified organizations can see system tabs
    $canAccessFeatures = $isAdmin || $isVerified;

    $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
    if ($fullName === '') {
        $fullName = $user->name ?? 'User';
    }
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
<body class="bg-gray-100 font-sans min-h-screen flex flex-col antialiased">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white fixed inset-y-0 left-0 border-r border-gray-200 p-5 flex flex-col justify-between z-10">
        <div>
            <!-- BRANDING -->
            <div class="flex items-center gap-2 mb-8 px-2">
                <svg class="h-6 w-6 text-[#2E7D32] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2C6.5 2 3 7.5 3 13c0 4.5 3.5 8 9 9 5.5-1 9-4.5 9-9 0-5.5-3.5-11-9-11z" />
                    <path d="M12 2v20" />
                    <path d="M8 9.5a4 4 0 0 0 4 3.5 4 4 0 0 0 4-3.5" />
                    <path d="M10 9.5v3" />
                    <path d="M14 9.5v3" />
                </svg>
                <span class="text-base font-bold text-gray-900 tracking-wide">FoodRescue Hub</span>
            </div>

            <!-- NAVIGATION LINKS -->
            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">Dashboard</a>

                @if ($canAccessFeatures)
                    @if ($isAdmin)
                        <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">Organizations</a>
                        <a href="{{ route('admin.verifications') }}" class="block px-3 py-2 rounded-md text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">Verification Requests</a>
                        <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">User Management</a>
                        <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">Reports</a>
                        <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">Audit Logs</a>
                    @elseif ($isProvider)
                        <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">Food Listings</a>
                        <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">Inventory Management</a>
                        <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">Food Requests</a>
                        <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">Pickup Schedules</a>
                        <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">Redistribution History</a>
                    @elseif ($isRecipient)
                        <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">Browse Available Food</a>
                        <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">My Requests</a>
                        <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">Pickup Schedules</a>
                        <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">Received Food</a>
                    @endif

                    <a href="#" class="block px-3 py-2 rounded-md text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-[#2E7D32] transition-colors">My Profile</a>
                @else
                    <div class="mt-4 rounded-lg bg-amber-50 border border-amber-200 p-3">
                        <strong class="block text-xs font-semibold text-amber-800 mb-1">Restricted Access</strong>
                        <p class="text-[11px] text-amber-700 leading-relaxed">Your organization must be verified before you can access other system features.</p>
                    </div>
                @endif
            </nav>
        </div>

        <!-- LOGOUT FORM -->
        <form method="POST" action="{{ route('logout') }}" class="pt-4 border-t border-gray-200">
            @csrf
            <button type="submit" class="w-full px-3 py-2 text-left text-xs font-semibold text-red-600 hover:bg-red-50 rounded-md transition-colors cursor-pointer">
                Logout
            </button>
        </form>
    </aside>

    <!-- MAIN CONTENT CONTAINER -->
    <div class="ml-64 flex-1 flex flex-col">

        <!-- HEADER -->
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-base font-bold text-gray-900">Welcome, {{ $fullName }}!</h1>
                <p class="text-xs text-gray-500 mt-0.5">
                    Role: 
                    <span class="font-medium text-gray-700">
                        @if ($isAdmin) Administrator
                        @elseif ($isProvider) Food Provider
                        @elseif ($isRecipient) Recipient Organization
                        @else Unknown Role ({{ $user->role }})
                        @endif
                    </span>
                </p>
            </div>
        </header>

        <!-- MAIN BODY -->
        <main class="p-8 space-y-6">

            <!-- FLASH ERROR FROM MIDDLEWARE -->
            @if (session('error'))
                <div class="rounded-lg bg-red-50 border border-red-200 p-4 shadow-xs text-xs text-red-800 font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <!-- VERIFICATION STATUS NOTICE -->
            @if (!$isAdmin && !$isVerified)
                @if ($verificationStatus === 'pending')
                    <div class="rounded-lg bg-amber-50 border border-amber-200 p-4 shadow-xs">
                        <h3 class="text-xs font-bold text-amber-900 uppercase tracking-wider mb-1">Account Verification Pending</h3>
                        <p class="text-xs text-amber-800 leading-relaxed">
                            Your organization registration is currently being reviewed by the administrator. You can access your dashboard, but other system features will remain unavailable until your organization has been verified.
                        </p>
                    </div>
                @elseif ($verificationStatus === 'rejected')
                    <div class="rounded-lg bg-red-50 border border-red-200 p-4 shadow-xs">
                        <h3 class="text-xs font-bold text-red-900 uppercase tracking-wider mb-1">Organization Verification Rejected</h3>
                        <p class="text-xs text-red-800 leading-relaxed mb-1">
                            Unfortunately, your organization's verification request has been rejected.
                        </p>
                        <p class="text-xs text-red-800 leading-relaxed">
                            Please contact the administrator for more information and guidance on the next steps.
                        </p>
                    </div>
                @elseif ($verificationStatus === 'additional information required')
                    <div class="rounded-lg bg-amber-50 border border-amber-200 p-4 shadow-xs">
                        <h3 class="text-xs font-bold text-amber-900 uppercase tracking-wider mb-1">Additional Information Required</h3>
                        <p class="text-xs text-amber-800 leading-relaxed">
                            The administrator requested additional documentation or clarification for your organization before approving verification.
                        </p>
                    </div>
                @else
                    <div class="rounded-lg bg-amber-50 border border-amber-200 p-4 shadow-xs">
                        <h3 class="text-xs font-bold text-amber-900 uppercase tracking-wider mb-1">Organization Not Yet Verified</h3>
                        <p class="text-xs text-amber-800 leading-relaxed">
                            Your organization must be verified before you can access other system features.
                        </p>
                    </div>
                @endif
            @endif

            <!-- ADMINISTRATOR DASHBOARD -->
            @if ($isAdmin)
                <div>
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Administrator Overview</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-xs">
                            <h3 class="text-xs font-medium text-gray-500">Total Organizations</h3>
                            <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-xs">
                            <h3 class="text-xs font-medium text-gray-500">Pending Verifications</h3>
                            <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-xs">
                            <h3 class="text-xs font-medium text-gray-500">Active Food Listings</h3>
                            <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-xs">
                            <h3 class="text-xs font-medium text-gray-500">Completed Redistributions</h3>
                            <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-xs">
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Recent System Activities</h3>
                    <p class="text-xs text-gray-500">No recent activities available.</p>
                </div>

            <!-- FOOD PROVIDER DASHBOARD -->
            @elseif ($isProvider)
                <div>
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Food Provider Overview</h2>
                    @if ($isVerified)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-xs">
                                <h3 class="text-xs font-medium text-gray-500">Active Food Listings</h3>
                                <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-xs">
                                <h3 class="text-xs font-medium text-gray-500">Pending Requests</h3>
                                <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-xs">
                                <h3 class="text-xs font-medium text-gray-500">Food Nearing Expiration</h3>
                                <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-xs">
                                <h3 class="text-xs font-medium text-gray-500">Upcoming Pickups</h3>
                                <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-xs">
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Recent Food Listings</h3>
                            <p class="text-xs text-gray-500">No food listings available.</p>
                        </div>
                    @else
                        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-xs">
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Dashboard Overview</h3>
                            <p class="text-xs text-gray-600 mb-1">Your organization dashboard is available.</p>
                            <p class="text-xs text-gray-500">System features will become accessible after verification.</p>
                        </div>
                    @endif
                </div>

            <!-- RECIPIENT ORGANIZATION DASHBOARD -->
            @elseif ($isRecipient)
                <div>
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Recipient Organization Overview</h2>
                    @if ($isVerified)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-xs">
                                <h3 class="text-xs font-medium text-gray-500">Available Food Listings</h3>
                                <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-xs">
                                <h3 class="text-xs font-medium text-gray-500">My Submitted Requests</h3>
                                <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-xs">
                                <h3 class="text-xs font-medium text-gray-500">Approved Requests</h3>
                                <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-xs">
                                <h3 class="text-xs font-medium text-gray-500">Upcoming Pickups</h3>
                                <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-xs">
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Recent Requests</h3>
                            <p class="text-xs text-gray-500">No requests available.</p>
                        </div>
                    @else
                        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-xs">
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Dashboard Overview</h3>
                            <p class="text-xs text-gray-600 mb-1">Your organization dashboard is available.</p>
                            <p class="text-xs text-gray-500">System features will become accessible after verification.</p>
                        </div>
                    @endif
                </div>

            @else
                <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-xs">
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Access Restricted</h3>
                    <p class="text-xs text-gray-600 mb-1">Your account does not have a recognized FoodRescue Hub role.</p>
                    <p class="text-xs text-gray-500">Please contact the administrator.</p>
                </div>
            @endif

        </main>
    </div>

</body>
</html>