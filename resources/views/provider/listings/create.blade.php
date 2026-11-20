
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Post Surplus Food — FoodRescue Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

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

        <header class="h-16 bg-white border-b border-[#d5dfd8] px-8 flex items-center">
            <div class="flex items-center gap-3">
                <a href="{{ route('food-listings.index') }}"
                   class="min-h-10 inline-flex items-center gap-1.5 text-sm font-semibold text-[#2E7D32] hover:text-[#1B5E20] hover:underline">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12" />
                        <polyline points="12 19 5 12 12 5" />
                    </svg>
                    <span>Food Listings</span>
                </a>
                <span class="text-[#d5dfd8]">/</span>
                <span class="text-sm font-semibold">Post Surplus Food</span>
            </div>
        </header>

        <main class="p-8 flex-1">
            <div class="max-w-4xl space-y-6">

                <div>
                    <h2 class="text-xl font-bold tracking-tight">Create Surplus Food Listing</h2>
                    <p class="text-sm text-[#4a5d50] mt-1">
                        Enter batch details, quantity, and pickup instructions so verified recipient organizations can claim this food.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="rounded-lg bg-[#fee2e2] border border-[#b91c1c]/20 px-4 py-3.5 text-sm text-[#b91c1c] font-medium">
                        Please review the highlighted fields below before submitting.
                        <ul class="list-disc pl-5 mt-2 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="rounded-lg bg-[#fee2e2] border border-[#b91c1c]/20 px-4 py-3.5 text-sm text-[#b91c1c] font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white border border-[#d5dfd8] rounded-xl divide-y divide-[#d5dfd8]">
                    <div class="px-6 py-4">
                        <h3 class="text-base font-bold">Food Batch Information</h3>
                    </div>

                    <form action="{{ route('food-listings.store') }}" method="POST" class="p-6 space-y-6">
                        @csrf

                        <div>
                            <label for="food_name" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2">
                                Food Item Name *
                            </label>
                            <input type="text" id="food_name" name="food_name"
                                   value="{{ old('food_name') }}"
                                   placeholder="e.g., Freshly Baked Pandesal Packs"
                                   required maxlength="150"
                                   class="w-full min-h-10 rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] px-3.5 py-2 text-sm focus:bg-white focus:border-[#2E7D32] focus:outline-none">
                            @error('food_name')
                                <p class="text-xs text-[#b91c1c] mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="category" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2">
                                    Food Category *
                                </label>
                                <select id="category" name="category" required
                                        class="w-full min-h-10 rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] px-3.5 py-2 text-sm focus:bg-white focus:border-[#2E7D32] focus:outline-none">
                                    <option value="">Select category</option>
                                    @foreach (['Baked Goods', 'Fresh Produce', 'Prepared Meals', 'Dairy & Eggs', 'Canned & Dry Goods', 'Beverages', 'Other'] as $cat)
                                        <option value="{{ $cat }}" @selected(old('category') === $cat)>{{ $cat }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <p class="text-xs text-[#b91c1c] mt-1.5 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="storage_requirement" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2">
                                    Storage Requirement *
                                </label>
                                <select id="storage_requirement" name="storage_requirement" required
                                        class="w-full min-h-10 rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] px-3.5 py-2 text-sm focus:bg-white focus:border-[#2E7D32] focus:outline-none">
                                    <option value="">Select storage requirement</option>
                                    @foreach (['Room Temperature', 'Refrigerated', 'Frozen'] as $storage)
                                        <option value="{{ $storage }}" @selected(old('storage_requirement', 'Room Temperature') === $storage)>{{ $storage }}</option>
                                    @endforeach
                                </select>
                                @error('storage_requirement')
                                    <p class="text-xs text-[#b91c1c] mt-1.5 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="quantity" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2">
                                    Total Quantity *
                                </label>
                                <input type="number" id="quantity" name="quantity"
                                       min="1" step="1" value="{{ old('quantity') }}"
                                       placeholder="e.g., 25" required
                                       class="w-full min-h-10 rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] px-3.5 py-2 text-sm focus:bg-white focus:border-[#2E7D32] focus:outline-none">
                                <p class="text-xs text-[#4a5d50] mt-1">Enter the total number of food units in this batch.</p>
                                @error('quantity')
                                    <p class="text-xs text-[#b91c1c] mt-1.5 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="expiration_date" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2">
                                    Expiration / Best-Before Date *
                                </label>
                                <input type="date" id="expiration_date" name="expiration_date"
                                       value="{{ old('expiration_date') }}"
                                       min="{{ now()->toDateString() }}" required
                                       class="w-full min-h-10 rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] px-3.5 py-2 text-sm focus:bg-white focus:border-[#2E7D32] focus:outline-none">
                                @error('expiration_date')
                                    <p class="text-xs text-[#b91c1c] mt-1.5 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="food_condition" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2">
                                Food Condition *
                            </label>
                            <input type="text" id="food_condition" name="food_condition"
                                   value="{{ old('food_condition') }}"
                                   placeholder="e.g., Fresh, properly sealed"
                                   required maxlength="100"
                                   class="w-full min-h-10 rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] px-3.5 py-2 text-sm focus:bg-white focus:border-[#2E7D32] focus:outline-none">
                            @error('food_condition')
                                <p class="text-xs text-[#b91c1c] mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2">
                                Description
                            </label>
                            <textarea id="description" name="description" rows="3"
                                      placeholder="Describe the food batch..."
                                      class="w-full rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] p-3.5 text-sm focus:bg-white focus:border-[#2E7D32] focus:outline-none">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-xs text-[#b91c1c] mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="allergen_information" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2">
                                Allergen Information
                            </label>
                            <textarea id="allergen_information" name="allergen_information" rows="2"
                                      placeholder="List known allergens, or enter N/A..."
                                      class="w-full rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] p-3.5 text-sm focus:bg-white focus:border-[#2E7D32] focus:outline-none">{{ old('allergen_information') }}</textarea>
                            @error('allergen_information')
                                <p class="text-xs text-[#b91c1c] mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="pickup_details" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2">
                                Pickup Details
                            </label>
                            <textarea id="pickup_details" name="pickup_details" rows="3"
                                      placeholder="Provide pickup location, available arrangements, and instructions..."
                                      class="w-full rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] p-3.5 text-sm focus:bg-white focus:border-[#2E7D32] focus:outline-none">{{ old('pickup_details') }}</textarea>
                            @error('pickup_details')
                                <p class="text-xs text-[#b91c1c] mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4 border-t border-[#d5dfd8] flex items-center gap-3">
                            <button type="submit"
                                    class="min-h-10 px-5 py-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-semibold rounded-lg inline-flex items-center gap-2 transition-colors cursor-pointer">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                <span>Publish Surplus Listing</span>
                            </button>

                            <a href="{{ route('food-listings.index') }}"
                               class="min-h-10 px-4 py-2 bg-white hover:bg-[#e8efe9] border border-[#d5dfd8] text-sm font-semibold rounded-lg inline-flex items-center transition-colors">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
