
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Listing Details | FoodRescue Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    @php
        $role = strtolower(str_replace(' ', '_', trim(auth()->user()->role ?? '')));
        $isProvider = $role === 'food_provider';
    @endphp

    <div class="max-w-5xl mx-auto px-6 py-10">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Food Listing Details
                </h1>

                <p class="text-gray-500 mt-2">
                    View complete information about this surplus food listing.
                </p>
            </div>

            <span class="px-4 py-2 rounded-full text-sm font-semibold
                {{ $foodListing->status === 'Available' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                {{ $foodListing->status }}
            </span>

        </div>

        <!-- Success/Error Messages -->
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

        <!-- Main Information -->
        <div class="bg-white rounded-xl shadow-sm p-8">

            <div class="border-b border-gray-200 pb-6 mb-6">

                <p class="text-sm text-gray-500 mb-2">
                    Food Name
                </p>

                <h2 class="text-2xl font-bold text-gray-800">
                    {{ $foodListing->food_name }}
                </h2>

                <p class="text-gray-500 mt-2">
                    Category: {{ $foodListing->category }}
                </p>

            </div>

            <!-- Food Information -->
            <div class="mb-8">

                <h3 class="text-lg font-semibold text-gray-800 mb-5">
                    Food Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <p class="text-sm text-gray-500">Description</p>
                        <p class="font-medium text-gray-800 mt-1">
                            {{ $foodListing->description ?: 'No description provided.' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Expiration Date</p>
                        <p class="font-medium text-gray-800 mt-1">
                            {{ $foodListing->expiration_date
                                ? \Carbon\Carbon::parse($foodListing->expiration_date)->format('F d, Y')
                                : 'Not specified' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Storage Requirement</p>
                        <p class="font-medium text-gray-800 mt-1">
                            {{ $foodListing->storage_requirement ?: 'Not specified' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Food Condition</p>
                        <p class="font-medium text-gray-800 mt-1">
                            {{ $foodListing->food_condition ?: 'Not specified' }}
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Allergen Information</p>
                        <p class="font-medium text-gray-800 mt-1">
                            {{ $foodListing->allergen_information ?: 'No allergen information provided.' }}
                        </p>
                    </div>

                </div>

            </div>

            <!-- Inventory Information -->
            <div class="border-t border-gray-200 pt-6 mb-8">

                <h3 class="text-lg font-semibold text-gray-800 mb-5">
                    Inventory Information
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                    <div class="bg-gray-50 p-5 rounded-lg">
                        <p class="text-sm text-gray-500">
                            Total Quantity
                        </p>

                        <p class="text-2xl font-bold text-gray-800 mt-2">
                            {{ $foodListing->quantity }}
                        </p>
                    </div>

                    <div class="bg-green-50 p-5 rounded-lg">
                        <p class="text-sm text-gray-500">
                            Available Quantity
                        </p>

                        <p class="text-2xl font-bold text-green-700 mt-2">
                            {{ $foodListing->available_quantity }}
                        </p>
                    </div>

                    <div class="bg-blue-50 p-5 rounded-lg">
                        <p class="text-sm text-gray-500">
                            Reserved Quantity
                        </p>

                        <p class="text-2xl font-bold text-blue-700 mt-2">
                            {{ $foodListing->reserved_quantity }}
                        </p>
                    </div>

                </div>

                <div class="mt-4 bg-gray-50 p-5 rounded-lg">
                    <p class="text-sm text-gray-500">
                        Redistributed Quantity
                    </p>

                    <p class="text-2xl font-bold text-gray-800 mt-2">
                        {{ $foodListing->redistributed_quantity }}
                    </p>
                </div>

            </div>

            <!-- Pickup Information -->
            <div class="border-t border-gray-200 pt-6 mb-8">

                <h3 class="text-lg font-semibold text-gray-800 mb-5">
                    Pickup Information
                </h3>

                <div>
                    <p class="text-sm text-gray-500">
                        Pickup Details
                    </p>

                    <p class="font-medium text-gray-800 mt-1">
                        {{ $foodListing->pickup_details ?: 'No pickup details provided.' }}
                    </p>
                </div>

            </div>

            <!-- Listing Metadata -->
            <div class="border-t border-gray-200 pt-6">

                <h3 class="text-lg font-semibold text-gray-800 mb-5">
                    Listing Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <p class="text-sm text-gray-500">
                            Listing ID
                        </p>

                        <p class="font-medium text-gray-800 mt-1">
                            {{ $foodListing->food_listing_id }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Date Created
                        </p>

                        <p class="font-medium text-gray-800 mt-1">
                            {{ $foodListing->created_at
                                ? $foodListing->created_at->format('F d, Y')
                                : 'Not available' }}
                        </p>
                    </div>

                </div>

            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8 border-t border-gray-200 pt-6">

                <a href="{{ route('food-listings.index') }}"
                   class="px-6 py-3 rounded-lg border border-gray-300 text-gray-700 font-medium text-center hover:bg-gray-100">
                    Back to Listings
                </a>

                @if($isProvider && $foodListing->status !== 'Withdrawn')
                    <a href="{{ route('food-listings.edit', $foodListing->food_listing_id) }}"
                       class="px-6 py-3 rounded-lg bg-green-600 hover:bg-green-700 text-white font-medium text-center">
                        Edit Listing
                    </a>
                @endif

            </div>

        </div>

    </div>

</body>
</html>
