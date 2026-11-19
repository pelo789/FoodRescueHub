<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Post Surplus Food — FoodRescue Hub</title>

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
                <a href="{{ Route::has('provider.listings.index') ? route('provider.listings.index') : '#' }}"
                   class="min-h-10 inline-flex items-center gap-1.5 text-sm font-semibold text-[#2E7D32] hover:text-[#1B5E20] hover:underline">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12" />
                        <polyline points="12 19 5 12 12 5" />
                    </svg>
                    <span>Food Listings</span>
                </a>
                <span class="text-[#d5dfd8]">/</span>
                <span class="text-sm font-semibold text-[#14281d]">
                    Post Surplus Food
                </span>
            </div>
        </header>

        <!-- MAIN WORKSPACE -->
        <main class="p-8 flex-1">
            <div class="max-w-4xl space-y-6">

                <!-- PAGE SUBTITLE -->
                <div>
                    <h2 class="text-xl font-bold text-[#14281d] tracking-tight text-left">
                        Create Surplus Food Listing
                    </h2>
                    <p class="text-sm text-[#4a5d50] mt-1 text-left">
                        Enter batch details, quantity, and pickup availability so verified recipient organizations can claim this food.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="rounded-lg bg-[#fee2e2] border border-[#b91c1c]/20 px-4 py-3.5 text-sm text-[#b91c1c] font-medium">
                        Please review the highlighted fields below before submitting.
                    </div>
                @endif

                <!-- CREATE FORM CONTAINER -->
                <div class="bg-[#ffffff] border border-[#d5dfd8] rounded-xl divide-y divide-[#d5dfd8]">
                    <div class="px-6 py-4">
                        <h3 class="text-base font-bold text-[#14281d] text-left">Food Batch Information</h3>
                    </div>

                    <form action="{{ Route::has('provider.listings.store') ? route('provider.listings.store') : '#' }}"
                          method="POST"
                          class="p-6 space-y-6">
                        @csrf

                        <!-- FOOD NAME -->
                        <div>
                            <label for="food_name" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2 text-left">
                                Food Item Name *
                            </label>
                            <input type="text"
                                   id="food_name"
                                   name="food_name"
                                   value="{{ old('food_name') }}"
                                   placeholder="e.g., Freshly Baked Pandesal Packs, Assorted Leafy Vegetables"
                                   required
                                   class="w-full min-h-10 rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] px-3.5 py-2 text-sm text-[#14281d] focus:bg-[#ffffff] focus:border-[#2E7D32] focus:outline-none">
                            @error('food_name')
                                <p class="text-xs text-[#b91c1c] mt-1.5 font-medium text-left">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- CATEGORY & STORAGE CONDITION -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="category" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2 text-left">
                                    Food Category *
                                </label>
                                <select id="category"
                                        name="category"
                                        required
                                        class="w-full min-h-10 rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] px-3.5 py-2 text-sm text-[#14281d] focus:bg-[#ffffff] focus:border-[#2E7D32] focus:outline-none">
                                    <option value="">Select category</option>
                                    @foreach (['Baked Goods', 'Fresh Produce', 'Prepared Meals', 'Dairy & Eggs', 'Canned & Dry Goods', 'Beverages'] as $cat)
                                        <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <p class="text-xs text-[#b91c1c] mt-1.5 font-medium text-left">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="storage_condition" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2 text-left">
                                    Storage Requirement *
                                </label>
                                <select id="storage_condition"
                                        name="storage_condition"
                                        required
                                        class="w-full min-h-10 rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] px-3.5 py-2 text-sm text-[#14281d] focus:bg-[#ffffff] focus:border-[#2E7D32] focus:outline-none">
                                    @foreach (['Room Temperature', 'Refrigerated', 'Frozen'] as $storage)
                                        <option value="{{ $storage }}" {{ old('storage_condition', 'Room Temperature') === $storage ? 'selected' : '' }}>{{ $storage }}</option>
                                    @endforeach
                                </select>
                                @error('storage_condition')
                                    <p class="text-xs text-[#b91c1c] mt-1.5 font-medium text-left">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- DESCRIPTION / HANDLING NOTES -->
                        <div>
                            <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2 text-left">
                                Description & Handling Notes
                            </label>
                            <textarea id="description"
                                      name="description"
                                      rows="3"
                                      placeholder="Include packaging details, allergens, or special handling instructions..."
                                      class="w-full rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] p-3.5 text-sm text-[#14281d] focus:bg-[#ffffff] focus:border-[#2E7D32] focus:outline-none">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-xs text-[#b91c1c] mt-1.5 font-medium text-left">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- QUANTITY, UNIT & EXPIRY DATE -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div>
                                <label for="quantity" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2 text-left">
                                    Quantity *
                                </label>
                                <input type="number"
                                       id="quantity"
                                       name="quantity"
                                       min="1"
                                       step="0.01"
                                       value="{{ old('quantity') }}"
                                       placeholder="e.g., 25"
                                       required
                                       class="w-full min-h-10 rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] px-3.5 py-2 text-sm text-[#14281d] focus:bg-[#ffffff] focus:border-[#2E7D32] focus:outline-none">
                                @error('quantity')
                                    <p class="text-xs text-[#b91c1c] mt-1.5 font-medium text-left">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="unit" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2 text-left">
                                    Unit *
                                </label>
                                <select id="unit"
                                        name="unit"
                                        required
                                        class="w-full min-h-10 rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] px-3.5 py-2 text-sm text-[#14281d] focus:bg-[#ffffff] focus:border-[#2E7D32] focus:outline-none">
                                    @foreach (['pcs', 'kg', 'trays', 'packs', 'boxes', 'liters'] as $unitOption)
                                        <option value="{{ $unitOption }}" {{ old('unit', 'pcs') === $unitOption ? 'selected' : '' }}>{{ $unitOption }}</option>
                                    @endforeach
                                </select>
                                @error('unit')
                                    <p class="text-xs text-[#b91c1c] mt-1.5 font-medium text-left">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="expiry_date" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2 text-left">
                                    Expiration / Best-Before Date *
                                </label>
                                <input type="date"
                                       id="expiry_date"
                                       name="expiry_date"
                                       value="{{ old('expiry_date') }}"
                                       required
                                       class="w-full min-h-10 rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] px-3.5 py-2 text-sm text-[#14281d] focus:bg-[#ffffff] focus:border-[#2E7D32] focus:outline-none">
                                @error('expiry_date')
                                    <p class="text-xs text-[#b91c1c] mt-1.5 font-medium text-left">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- PICKUP TIME WINDOW -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="pickup_start" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2 text-left">
                                    Pickup Window Start *
                                </label>
                                <input type="time"
                                       id="pickup_start"
                                       name="pickup_start"
                                       value="{{ old('pickup_start', '08:00') }}"
                                       required
                                       class="w-full min-h-10 rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] px-3.5 py-2 text-sm text-[#14281d] focus:bg-[#ffffff] focus:border-[#2E7D32] focus:outline-none">
                                @error('pickup_start')
                                    <p class="text-xs text-[#b91c1c] mt-1.5 font-medium text-left">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="pickup_end" class="block text-xs font-semibold uppercase tracking-wider text-[#4a5d50] mb-2 text-left">
                                    Pickup Window End *
                                </label>
                                <input type="time"
                                       id="pickup_end"
                                       name="pickup_end"
                                       value="{{ old('pickup_end', '17:00') }}"
                                       required
                                       class="w-full min-h-10 rounded-lg bg-[#e8efe9]/50 border border-[#d5dfd8] px-3.5 py-2 text-sm text-[#14281d] focus:bg-[#ffffff] focus:border-[#2E7D32] focus:outline-none">
                                @error('pickup_end')
                                    <p class="text-xs text-[#b91c1c] mt-1.5 font-medium text-left">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- FORM ACTIONS (Von Restorff Effect: Single #2E7D32 Primary CTA) -->
                        <div class="pt-4 border-t border-[#d5dfd8] flex items-center gap-3">
                            <button type="submit"
                                    class="min-h-10 px-5 py-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-semibold rounded-lg inline-flex items-center gap-2 transition-colors cursor-pointer">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                <span>Publish Surplus Listing</span>
                            </button>

                            <a href="{{ Route::has('provider.listings.index') ? route('provider.listings.index') : '#' }}"
                               class="min-h-10 px-4 py-2 bg-[#ffffff] hover:bg-[#e8efe9] text-[#14281d] border border-[#d5dfd8] text-sm font-semibold rounded-lg inline-flex items-center transition-colors">
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
