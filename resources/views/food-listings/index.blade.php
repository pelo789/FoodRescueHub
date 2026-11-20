
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Listings | FoodRescue Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    @php
        $role = strtolower(str_replace(' ', '_', trim(auth()->user()->role ?? '')));
        $isProvider = $role === 'food_provider';
    @endphp

    <div class="max-w-7xl mx-auto px-6 py-10">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Food Listings</h1>
                <p class="text-gray-500 mt-1">
                    Manage and browse available surplus food.
                </p>
            </div>

            @if($isProvider)
                <a href="{{ route('food-listings.create') }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg font-medium text-center">
                    + Add Food Listing
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 border border-green-200 p-4 rounded-lg mb-5">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-800 border border-red-200 p-4 rounded-lg mb-5">
                {{ session('error') }}
            </div>
        @endif

        @if($foodListings->isEmpty())
            <div class="bg-white rounded-xl shadow-sm p-10 text-center">
                <h2 class="text-xl font-semibold text-gray-700">
                    No Food Listings Found
                </h2>
                <p class="text-gray-500 mt-2">
                    There are currently no food listings to display.
                </p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Food Name</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Category</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Quantity</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Available</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Expiration</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach($foodListings as $listing)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $listing->food_name }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $listing->category }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $listing->quantity }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $listing->available_quantity }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $listing->expiration_date->format('M d, Y') }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $listing->status === 'Available' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $listing->status }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <a href="{{ route('food-listings.show', $listing->food_listing_id) }}"
                                           class="text-blue-600 hover:underline">
                                            View
                                        </a>

                                        @if($isProvider)
                                            <a href="{{ route('food-listings.edit', $listing->food_listing_id) }}"
                                               class="text-green-600 hover:underline">
                                                Edit
                                            </a>

                                            @if($listing->status !== 'Withdrawn')
                                                <form action="{{ route('food-listings.destroy', $listing->food_listing_id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to withdraw this listing?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="text-red-600 hover:underline">
                                                        Withdraw
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="mt-8">
            <a href="{{ route('dashboard') }}"
               class="text-gray-600 hover:text-gray-900">
                ← Back to Dashboard
            </a>
        </div>

    </div>

</body>
</html>
