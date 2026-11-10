<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Organization Verifications</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen flex flex-col">
        <!-- Top Navigation Bar -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">FoodRescue Hub — Admin Portal</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Admin: {{ auth()->user()->first_name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:underline">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="max-w-7xl mx-auto px-4 py-8 grow w-full">
            
            <!-- Success / Error Alerts -->
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Pending Organization Verifications</h2>
                        <p class="text-xs text-gray-500">Review pending registrations and approve or reject their access.</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:underline">&larr; Back to Dashboard</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Organization / Name</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Role</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Contact / Address</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Verification Document</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($pendingUsers as $pendingUser)
                                <tr>
                                    <td class="px-4 py-4">
                                        <div class="font-medium text-gray-900">{{ $pendingUser->first_name }} {{ $pendingUser->last_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $pendingUser->email }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-gray-700 capitalize">
                                        <span class="px-2 py-1 text-xs bg-blue-50 text-blue-700 rounded-full">
                                            {{ str_replace('_', ' ', $pendingUser->role) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-xs text-gray-600">
                                        <div>{{ $pendingUser->phone ?? 'No phone' }}</div>
                                        <div class="truncate max-w-xs">{{ $pendingUser->address ?? 'No address' }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        @if($pendingUser->document_path)
                                            <a href="{{ asset('storage/' . $pendingUser->document_path) }}" target="_blank" class="inline-flex items-center text-blue-600 hover:underline text-xs font-semibold">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                View Document
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs italic">No document uploaded</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-right space-x-2">
                                        <!-- Approve Form -->
                                        <form action="{{ route('admin.users.verify', $pendingUser->user_id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <input type="hidden" name="verification_status" value="Verified">
                                            <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-semibold shadow-sm transition-colors">
                                                Approve
                                            </button>
                                        </form>

                                        <!-- Reject Form -->
                                        <form action="{{ route('admin.users.verify', $pendingUser->user_id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <input type="hidden" name="verification_status" value="Rejected">
                                            <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-semibold shadow-sm transition-colors">
                                                Reject
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-400 text-sm">
                                        🎉 All caught up! There are no pending organization verifications at the moment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

</body>
</html>