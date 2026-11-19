<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verification Requests — FoodRescue Hub</title>

    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
    </style>
</head>
<body class="bg-[#f3f6f4] text-[#14281d] font-sans min-h-screen flex flex-col antialiased">

    @include('partials.sidebar')

    <div class="ml-64 flex-1 flex flex-col">

        <!-- TOP HEADER BAR -->
        <header class="h-16 bg-[#ffffff] border-b border-[#d5dfd8] px-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h1 class="text-base font-bold text-[#14281d]">
                    Verification Requests
                </h1>
                <span class="text-[#d5dfd8]">/</span>
                <span class="text-sm text-[#4a5d50]">
                    {{ $status }}
                </span>
            </div>
        </header>

        <!-- MAIN WORKSPACE -->
        <main class="p-8 flex-1">
            <div class="max-w-6xl space-y-6">

                <!-- PAGE SUBTITLE -->
                <div>
                    <h2 class="text-xl font-bold text-[#14281d] tracking-tight text-left">
                        Organization Verification Queue
                    </h2>
                    <p class="text-sm text-[#4a5d50] mt-1 text-left">
                        Review organization registrations, inspect submitted documents, and update verification statuses.
                    </p>
                </div>

                @if (session('success'))
                    <div class="rounded-lg bg-[#e8f5e9] border border-[#2E7D32]/20 px-4 py-3.5 text-sm text-[#2E7D32] font-medium flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        <span>{{ session('success') }}</span>
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
                           class="min-h-10 px-4 py-2 rounded-lg text-sm font-semibold border inline-flex items-center transition-colors {{ $status === $tabValue ? 'bg-[#2E7D32] text-white border-[#2E7D32]' : 'bg-[#ffffff] text-[#4a5d50] border-[#d5dfd8] hover:bg-[#e8efe9] hover:text-[#14281d]' }}">
                            {{ $tabLabel }}
                        </a>
                    @endforeach
                </div>
                <!-- ORGANIZATIONS TABLE -->
                <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#d5dfd8] text-sm text-left">
                            <thead class="bg-[#e8efe9]">
                                <tr>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                        Organization & Representative
                                    </th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                        Role
                                    </th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                        Status
                                    </th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                        Document
                                    </th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-[#4a5d50]">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#d5dfd8] bg-[#ffffff]">
                                @forelse ($pendingUsers as $pendingUser)
                                    <tr class="hover:bg-[#e8efe9]/60 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-[#14281d]">{{ $pendingUser->organization_name }}</div>
                                            <div class="text-xs text-[#4a5d50] mt-0.5">
                                                {{ $pendingUser->first_name }} {{ $pendingUser->last_name }} • {{ $pendingUser->email }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 capitalize text-[#4a5d50] font-medium">
                                            {{ str_replace('_', ' ', $pendingUser->role) }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <x-verification-badge :status="$pendingUser->verification_status" />
                                        </td>

                                        <td class="px-6 py-4">
                                            @if ($pendingUser->verification_document)
                                                <a href="{{ route('admin.verifications.document', $pendingUser->organization_id) }}"
                                                   target="_blank"
                                                   class="min-h-10 inline-flex items-center gap-1.5 text-sm font-semibold text-[#2E7D32] hover:text-[#1B5E20] hover:underline">
                                                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                                        <polyline points="14 2 14 8 20 8" />
                                                    </svg>
                                                    <span>View File</span>
                                                </a>
                                            @else
                                                <span class="text-xs text-[#4a5d50]">No document</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('admin.verifications.show', $pendingUser->organization_id) }}"
                                                   class="min-h-10 px-3.5 py-2 bg-[#ffffff] hover:bg-[#e8efe9] text-[#14281d] border border-[#d5dfd8] rounded-lg text-xs font-semibold inline-flex items-center transition-colors">
                                                    Details
                                                </a>

                                                @if ($pendingUser->verification_status !== 'Verified')
                                                    <form action="{{ route('admin.verifications.updateStatus', $pendingUser->organization_id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        <input type="hidden" name="verification_status" value="Verified">
                                                        <button type="submit"
                                                                onclick="return confirm('Approve {{ addslashes($pendingUser->organization_name) }}?')"
                                                                class="min-h-10 px-3.5 py-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white rounded-lg text-xs font-semibold inline-flex items-center transition-colors cursor-pointer">
                                                            Approve
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-left text-sm text-[#4a5d50]">
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