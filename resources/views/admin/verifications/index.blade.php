
@php
    $currentStatus = strtolower(request('status', 'pending'));

    $statuses = [
        'pending' => 'Pending',
        'verified' => 'Verified',
        'rejected' => 'Rejected',
        'additional information required' => 'Additional Information Required',
    ];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Verification Queue - FoodRescue Hub</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 font-sans min-h-screen">

    <!-- HEADER -->
    <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
        <div>
            <h1 class="text-lg font-bold text-gray-900">
                Admin Control Center — Organization Verification
            </h1>

            <p class="text-xs text-gray-500 mt-1">
                Review and manage organization verification requests.
            </p>
        </div>

        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}"
               class="text-xs font-semibold text-green-700 hover:text-green-800">
                Dashboard
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit"
                        class="px-3 py-1.5 bg-red-600 text-white text-xs font-semibold rounded hover:bg-red-700">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="max-w-7xl w-full mx-auto p-6">

        <!-- SUCCESS MESSAGE -->
        @if (session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 text-xs p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- ERROR MESSAGE -->
        @if (session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 text-xs p-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- VALIDATION ERRORS -->
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 text-xs p-3 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- PAGE DESCRIPTION -->
        <div class="mb-6">
            <h2 class="text-base font-bold text-gray-900">
                Organization Verification Queue
            </h2>

            <p class="text-xs text-gray-500 mt-1">
                Review organization information and submitted verification documents.
            </p>
        </div>

        <!-- STATUS TABS -->
        <div class="flex flex-wrap gap-2 mb-6 border-b border-gray-200 pb-3">

            @foreach ($statuses as $statusValue => $statusLabel)

                <a href="{{ route('admin.verifications.index', ['status' => $statusValue]) }}"
                   class="px-4 py-2 text-xs font-semibold rounded-md transition-colors
                   {{ $currentStatus === $statusValue
                        ? 'bg-[#2E7D32] text-white'
                        : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">

                    {{ $statusLabel }}

                </a>

            @endforeach

        </div>

        <!-- ORGANIZATIONS TABLE -->
        <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">

            <div class="p-5 border-b border-gray-200">
                <h3 class="text-sm font-bold text-gray-900">
                    {{ $statuses[$currentStatus] ?? 'Organization Requests' }}
                </h3>

                <p class="text-xs text-gray-500 mt-1">
                    Organization accounts matching the selected verification status.
                </p>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse text-xs">

                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 uppercase">
                            <th class="p-3">Organization Name</th>
                            <th class="p-3">Type</th>
                            <th class="p-3">Representative</th>
                            <th class="p-3">Email / Phone</th>
                            <th class="p-3">Document</th>
                            <th class="p-3">Date Registered</th>
                            <th class="p-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @forelse ($organizations as $organization)

                            <tr class="hover:bg-gray-50">

                                <!-- ORGANIZATION NAME -->
                                <td class="p-3 font-semibold text-gray-900">
                                    {{ $organization->organization_name ?? 'Not provided' }}
                                </td>

                                <!-- ORGANIZATION TYPE -->
                                <td class="p-3 text-gray-600">
                                    @if ($organization->role === 'food_provider')
                                        Food Provider
                                    @elseif ($organization->role === 'recipient_organization')
                                        Recipient Organization
                                    @else
                                        {{ $organization->role }}
                                    @endif
                                </td>

                                <!-- REPRESENTATIVE -->
                                <td class="p-3 text-gray-800">
                                    {{ $organization->first_name }}
                                    {{ $organization->last_name }}
                                </td>

                                <!-- CONTACT INFORMATION -->
                                <td class="p-3 text-gray-600">
                                    <div>{{ $organization->email }}</div>

                                    <div class="text-[10px] text-gray-400">
                                        {{ $organization->phone ?? 'No phone provided' }}
                                    </div>
                                </td>

                                <!-- VERIFICATION DOCUMENT -->
                                <td class="p-3">

                                    @if ($organization->verification_document)

                                        <a href="{{ route('admin.verifications.document', $organization->user_id) }}"
                                           target="_blank"
                                           class="text-blue-600 hover:underline font-medium">
                                            View Document
                                        </a>

                                    @else

                                        <span class="text-red-500">
                                            No document
                                        </span>

                                    @endif

                                </td>

                                <!-- DATE REGISTERED -->
                                <td class="p-3 text-gray-600">
                                    {{ $organization->created_at?->format('M d, Y') ?? 'N/A' }}
                                </td>

                                <!-- ACTIONS -->
                                <td class="p-3 text-right">

                                    @if (strtolower($organization->verification_status ?? 'pending') === 'pending')

                                        <div class="flex flex-wrap justify-end gap-2">

                                            <!-- APPROVE -->
                                            <form method="POST"
                                                  action="{{ route('admin.verifications.approve', $organization->user_id) }}"
                                                  onsubmit="return confirm('Approve this organization?')">

                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="px-2.5 py-1 bg-green-600 text-white rounded hover:bg-green-700 font-medium">
                                                    Approve
                                                </button>

                                            </form>

                                            <!-- REJECT -->
                                            <form method="POST"
                                                  action="{{ route('admin.verifications.reject', $organization->user_id) }}"
                                                  onsubmit="return confirm('Reject this organization?')">

                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="px-2.5 py-1 bg-red-600 text-white rounded hover:bg-red-700 font-medium">
                                                    Reject
                                                </button>

                                            </form>

                                        </div>

                                    @else

                                        <span class="text-gray-400">
                                            No actions available
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="p-6 text-center text-gray-500">
                                    No organizations found under this verification status.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- PAGINATION -->
            @if (method_exists($organizations, 'links'))
                <div class="p-4 border-t border-gray-200">
                    {{ $organizations->appends(request()->query())->links() }}
                </div>
            @endif

        </div>

    </main>

</body>
</html>
