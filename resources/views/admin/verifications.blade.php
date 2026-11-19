<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Organization Verifications - FoodRescue Hub</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-50 font-sans min-h-screen flex flex-col antialiased">

    @include('partials.sidebar')

    <div class="ml-64 flex-1 flex flex-col">

        <!-- HEADER -->
        <header class="bg-white border-b border-slate-200 px-8 py-4">
            <div class="max-w-5xl mx-auto">
                <h1 class="text-lg font-bold text-slate-900">Organization Verifications</h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Review organization registrations, inspect documents, and manage verification statuses.
                </p>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="p-8 flex-1">
            <div class="max-w-5xl mx-auto space-y-6">

                @if (session('success'))
                    <div class="rounded-xl bg-emerald-100 border border-emerald-200 p-4 text-sm text-emerald-800 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- STATUS FILTER TABS -->
                @php
                    $tabs = [
                        'Pending' => 'Pending Review',
                        'Additional Information Required' => 'Additional Info Required',
                        'Verified' => 'Verified',
                        'Rejected' => 'Rejected',
                    ];
                @endphp

                <div class="flex flex-wrap gap-2">
                    @foreach ($tabs as $tabValue => $tabLabel)
                        <a href="{{ route('admin.verifications.index', ['status' => $tabValue]) }}"
                           class="px-3.5 py-2 rounded-lg text-xs font-semibold border transition-colors {{ $status === $tabValue ? 'bg-[#2E7D32] text-white border-[#2E7D32]' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-100' }}">
                            {{ $tabLabel }}
                        </a>
                    @endforeach
                </div>
                <!-- ORGANIZATIONS TABLE -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 text-xs">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3.5 text-left font-semibold text-slate-600">Organization / Contact</th>
                                    <th class="px-4 py-3.5 text-left font-semibold text-slate-600">Role</th>
                                    <th class="px-4 py-3.5 text-left font-semibold text-slate-600">Status</th>
                                    <th class="px-4 py-3.5 text-left font-semibold text-slate-600">Document</th>
                                    <th class="px-4 py-3.5 text-right font-semibold text-slate-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @forelse ($pendingUsers as $pendingUser)
                                    <tr class="hover:bg-slate-50/70 transition-colors">
                                        <td class="px-4 py-4">
                                            <div class="font-bold text-slate-900 text-sm">{{ $pendingUser->organization_name }}</div>
                                            <div class="text-slate-600 mt-0.5">{{ $pendingUser->first_name }} {{ $pendingUser->last_name }} • {{ $pendingUser->email }}</div>
                                        </td>

                                        <td class="px-4 py-4 capitalize text-slate-700 font-medium">
                                            {{ str_replace('_', ' ', $pendingUser->role) }}
                                        </td>

                                        <td class="px-4 py-4">
                                            <x-verification-badge :status="$pendingUser->verification_status" />
                                        </td>

                                        <td class="px-4 py-4">
                                            @if ($pendingUser->verification_document)
                                                <a href="{{ route('admin.verifications.document', $pendingUser->organization_id) }}"
                                                   target="_blank"
                                                   class="text-[#2E7D32] hover:underline font-semibold">
                                                    View File &nearr;
                                                </a>
                                            @else
                                                <span class="text-slate-400 italic">None</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-4 text-right space-x-1.5 whitespace-nowrap">
                                            <a href="{{ route('admin.verifications.show', $pendingUser->organization_id) }}"
                                               class="inline-block px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-300 rounded-lg font-semibold transition-colors">
                                                Details
                                            </a>

                                            @if ($pendingUser->verification_status !== 'Verified')
                                                <form action="{{ route('admin.verifications.updateStatus', $pendingUser->organization_id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <input type="hidden" name="verification_status" value="Verified">
                                                    <button type="submit"
                                                            onclick="return confirm('Approve {{ addslashes($pendingUser->organization_name) }}?')"
                                                            class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold transition-colors cursor-pointer">
                                                        Approve
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-10 text-center text-slate-400">
                                            No organizations found under <strong>{{ $status }}</strong>.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>

    </div>

</body>
</html>