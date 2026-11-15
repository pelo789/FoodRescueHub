<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Verification Queue - FoodRescue Hub</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
        <h1 class="text-lg font-bold text-gray-900">Admin Control Center — Organization Verification</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-xs font-semibold rounded hover:bg-red-700">Logout</button>
        </form>
    </header>

    <!-- MAIN CONTENT -->
    <main class="grow max-w-7xl w-full mx-auto p-6">

        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 text-xs p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- STATUS TABS -->
        <div class="flex gap-2 mb-6 border-b border-gray-200 pb-3">
            @php $currentStatus = $status ?? request('status', 'Pending'); @endphp
            @foreach(['Pending', 'Verified', 'Rejected', 'Additional Information Required'] as $tabStatus)
                <a href="{{ route('admin.verifications', ['status' => $tabStatus]) }}" 
                   class="px-4 py-2 text-xs font-semibold rounded-md transition-colors {{ $currentStatus === $tabStatus ? 'bg-[#2E7D32] text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
                    {{ $tabStatus }}
                </a>
            @endforeach
        </div>

        <!-- ORGANIZATIONS TABLE -->
        <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 uppercase">
                        <th class="p-3">Organization Name</th>
                        <th class="p-3">Type</th>
                        <th class="p-3">Representative</th>
                        <th class="p-3">Email / Phone</th>
                        <th class="p-3">Document</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
    @if(isset($organizations) && count($organizations) > 0)
        @foreach($organizations as $org)
            <tr class="hover:bg-gray-50">
                <td class="p-3 font-semibold text-gray-900">{{ $org->organization_name }}</td>
                <td class="p-3 text-gray-600">{{ $org->organization_type }}</td>
                <td class="p-3 text-gray-800">{{ optional($org->user)->first_name }} {{ optional($org->user)->last_name }}</td>
                <td class="p-3 text-gray-600">
                    <div>{{ optional($org->user)->email }}</div>
                    <div class="text-[10px] text-gray-400">{{ optional($org->user)->phone }}</div>
                </td>
                <td class="p-3">
                    @if($org->verification_document)
                        <a href="{{ asset('storage/' . $org->verification_document) }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                            View File 📄
                        </a>
                    @else
                        <span class="text-gray-400">No file</span>
                    @endif
                </td>
                <td class="p-3 text-right space-x-2">
                    <form action="{{ route('admin.verifications.update', $org->organization_id) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="verification_status" value="Verified">
                        <button type="submit" class="px-2.5 py-1 bg-green-600 text-white rounded hover:bg-green-700 font-medium">Approve</button>
                    </form>

                    <form action="{{ route('admin.verifications.update', $org->organization_id) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="verification_status" value="Additional Information Required">
                        <button type="submit" class="px-2.5 py-1 bg-amber-500 text-white rounded hover:bg-amber-600 font-medium">Request Info</button>
                    </form>

                    <form action="{{ route('admin.verifications.update', $org->organization_id) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="verification_status" value="Rejected">
                        <button type="submit" class="px-2.5 py-1 bg-red-600 text-white rounded hover:bg-red-700 font-medium">Reject</button>
                    </form>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="p-6 text-center text-gray-500">No organizations found under this status.</td>
        </tr>
    @endif
</tbody>
            </table>
        </div>

        <div class="mt-4">
            @if(isset($organizations) && method_exists($organizations, 'links'))
                {{ $organizations->links() }}
            @endif
        </div>

    </main>

</body>
</html>