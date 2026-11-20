
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Food Listing | FoodRescue Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="max-w-4xl mx-auto px-6 py-10">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                Edit Food Listing
            </h1>

            <p class="text-gray-500 mt-2">
                Update the information and availability of your surplus food.
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-8">

            <!-- Form -->
            <form action="{{ route('food-listings.update', $foodListing->food_listing_id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <!-- Validation Errors -->
                @if($errors->any())
                    <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-lg mb-6">
                        <p class="font-semibold mb-2">
                            Please correct the following errors:
                        </p>

                        <ul class="list-disc pl-5 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Food Information -->
                <h2 class="text-lg font-semibold text-gray-800 mb-5">
                    Food Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- Food Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Food Name *
                        </label>

                        <input type="text"
                               name="food_name"
                               value="{{ old('food_name', $foodListing->food_name) }}"
                               required
                               maxlength="150"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">

                        @error('food_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Food Category *
                        </label>

                        <input type="text"
                               name="category"
                               value="{{ old('category', $foodListing->category) }}"
                               required
                               maxlength="100"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">

                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>

                        <textarea name="description"
                                  rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('description', $foodListing->description) }}</textarea>

                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Total Quantity -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Total Quantity *
                        </label>

                        <input type="number"
                               name="quantity"
                               value="{{ old('quantity', $foodListing->quantity) }}"
                               min="1"
                               required
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">

                        @error('quantity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Expiration Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Expiration Date *
                        </label>

                        <input type="date"
                               name="expiration_date"
                               value="{{ old('expiration_date', $foodListing->expiration_date ? \Carbon\Carbon::parse($foodListing->expiration_date)->format('Y-m-d') : '') }}"
                               required
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">

                        @error('expiration_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Storage and Condition -->
                <div class="border-t border-gray-200 mt-8 pt-6">

                    <h2 class="text-lg font-semibold text-gray-800 mb-5">
                        Storage and Food Condition
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <!-- Storage Requirement -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Storage Requirement *
                            </label>

                            <input type="text"
                                   name="storage_requirement"
                                   value="{{ old('storage_requirement', $foodListing->storage_requirement) }}"
                                   required
                                   maxlength="150"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">

                            @error('storage_requirement')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Food Condition -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Food Condition *
                            </label>

                            <input type="text"
                                   name="food_condition"
                                   value="{{ old('food_condition', $foodListing->food_condition) }}"
                                   required
                                   maxlength="100"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">

                            @error('food_condition')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Allergen Information -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Allergen Information
                            </label>

                            <textarea name="allergen_information"
                                      rows="2"
                                      class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('allergen_information', $foodListing->allergen_information) }}</textarea>

                            @error('allergen_information')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                </div>

                <!-- Pickup Information -->
                <div class="border-t border-gray-200 mt-8 pt-6">

                    <h2 class="text-lg font-semibold text-gray-800 mb-5">
                        Pickup Information
                    </h2>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Pickup Details
                        </label>

                        <textarea name="pickup_details"
                                  rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('pickup_details', $foodListing->pickup_details) }}</textarea>

                        @error('pickup_details')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Current Inventory Information -->
                <div class="border-t border-gray-200 mt-8 pt-6">

                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Current Inventory
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Total Quantity</p>
                            <p class="text-xl font-bold text-gray-800">
                                {{ $foodListing->quantity }}
                            </p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Available Quantity</p>
                            <p class="text-xl font-bold text-green-600">
                                {{ $foodListing->available_quantity }}
                            </p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="text-xl font-bold text-gray-800">
                                {{ $foodListing->status }}
                            </p>
                        </div>

                    </div>

                    <p class="text-sm text-gray-500 mt-3">
                        Inventory quantities are managed separately to preserve existing reservations and redistribution records.
                    </p>

                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8 border-t border-gray-200 pt-6">

                    <a href="{{ route('food-listings.index') }}"
                       class="px-6 py-3 rounded-lg border border-gray-300 text-gray-700 font-medium text-center hover:bg-gray-100">
                        Cancel
                    </a>

                    <button type="submit"
                            class="px-6 py-3 rounded-lg bg-green-600 hover:bg-green-700 text-white font-medium">
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>

</body>
</html>
