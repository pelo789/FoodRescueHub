
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Verification | FoodRescue Hub</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="max-w-7xl mx-auto px-6 py-10">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Organization Verification
                </h1>

                <p class="text-gray-500 mt-1">
                    Review organization details and submitted documents.
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
                class="text-green-700 hover:text-green-800 font-medium">
                Back to Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-6">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">

            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">
                    Pending Organizations
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Organizations waiting for administrator approval.
                </p>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="bg-gray-50 text-gray-600 text-sm">
                        <tr>
                            <th class="px-6 py-4">Organization</th>
                            <th class="px-6 py-4">Representative</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Document</th>
                            <th class="px-6 py-4">Date Registered</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($organizations as $organization)

                            <tr class="hover:bg-gray-50">

                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $organization->organization_name }}
                                </td>

                                <td class="px-6 py-4 text-gray-700">
                                    {{ $organization->first_name }}
                                    {{ $organization->last_name }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $organization->email }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $organization->role === 'food_provider'
                                        ? 'Food Provider'
                                        : 'Recipient Organization' }}
                                </td>

                                <td class="px-6 py-4">
                                    @if($organization->verification_document)
                                        <a href="{{ route('admin.verifications.document', $organization->user_id) }}"
                                           class="text-blue-600 hover:underline font-medium"
                                           target="_blank">
                                            View Document
                                        </a>
                                    @else
                                        <span class="text-red-500 text-sm">
                                            Not uploaded
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $organization->created_at->format('M d, Y') }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-2">

                                        <form method="POST"
                                            action="{{ route('admin.verifications.approve', $organization->user_id) }}"
                                            onsubmit="return confirm('Approve this organization?')">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white text-sm px-3 py-2 rounded-lg">
                                                Approve
                                            </button>
                                        </form>

                                        <form method="POST"
                                            action="{{ route('admin.verifications.reject', $organization->user_id) }}"
                                            onsubmit="return confirm('Reject this organization?')">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-2 rounded-lg">
                                                Reject
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7"
                                    class="px-6 py-10 text-center text-gray-500">
                                    No organizations are currently awaiting verification.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="p-6 border-t border-gray-200">
                {{ $organizations->links() }}
            </div>

        </div>

    </div>

</body>
</html>
