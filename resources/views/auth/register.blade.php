<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FoodRescue Hub</title>
    <!-- Tailwind CSS v4 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
        }
    </style>
</head>
<body class="min-h-screen bg-[#f4f6f9] font-sans">
    <div class="flex items-center justify-center min-h-screen p-6 sm:p-10">
        <div class="w-full max-w-3xl bg-white rounded-2xl shadow-lg border border-gray-200 p-8 sm:p-12">
            
            <!-- Page Title -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900">Create Organization Account</h1>
                <p class="mt-3 text-base text-gray-600">Register to participate in FoodRescue Hub's food redistribution activities.</p>
            </div>

            <!-- Verification Notice -->
            <div class="mt-6 rounded-lg border border-green-200 bg-green-50 p-4">
                <p class="text-base text-green-800 font-medium">Organizations must undergo verification before participating in food redistribution activities.</p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
            <div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-4">
                <ul class="list-disc list-inside text-base text-red-600 font-medium">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <form method="POST" action="{{ route('register.submit') }}" class="mt-8">
                @csrf

                <!-- Contact Information -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-2">Contact Information</h2>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- First Name -->
                        <div>
                            <label class="block text-base font-semibold text-gray-800 mb-2">First Name</label>
                            <input type="text" 
                                name="first_name" 
                                value="{{ old('first_name') }}" 
                                maxlength="100" 
                                required 
                                placeholder="Enter your first name" 
                                class="w-full rounded-md border border-gray-300 p-3.5 text-base text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                        </div>
                        <!-- Last Name -->
                        <div>
                            <label class="block text-base font-semibold text-gray-800 mb-2">Last Name</label>
                            <input type="text" 
                                name="last_name" 
                                value="{{ old('last_name') }}" 
                                maxlength="100" 
                                required 
                                placeholder="Enter your last name" 
                                class="w-full rounded-md border border-gray-300 p-3.5 text-base text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="mt-5">
                        <label class="block text-base font-semibold text-gray-800 mb-2">Email Address</label>
                        <input type="email"
                            name="email" 
                            value="{{ old('email') }}" 
                            maxlength="150" 
                            required 
                            placeholder="Enter your email address" 
                            class="w-full rounded-md border border-gray-300 p-3.5 text-base text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                    </div>

                    <!-- Contact Number -->
                    <div class="mt-5">
                        <label class="block text-base font-semibold text-gray-800 mb-2">Contact Number</label>
                        <input type="tel"
                            name="phone" 
                            value="{{ old('phone') }}" 
                            maxlength="20" 
                            required 
                            placeholder="Enter your contact number" 
                            class="w-full rounded-md border border-gray-300 p-3.5 text-base text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                    </div>
                </div>

                <!-- Organization Information -->
                <div class="mt-10 pt-8 border-t border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-2">Organization Information</h2>

                    <div class="mt-6">
                        <label class="block text-base font-semibold text-gray-800 mb-2">Organization Name</label>
                        <input type="text"
                            name="organization_name"
                            value="{{ old('organization_name') }}"
                            required
                            placeholder="Enter your organization name"
                            class="w-full rounded-md border border-gray-300 p-3.5 text-base text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                    </div>

                    <div class="mt-5">
                        <label class="block text-base font-semibold text-gray-800 mb-2">Organization Type</label>
                        <select name="organization_type"
                            required
                            class="w-full rounded-md border border-gray-300 p-3.5 text-base text-gray-900 bg-white focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                            <option value="">Select organization type</option>
                            <option value="Restaurant">Restaurant</option>
                            <option value="Bakery">Bakery</option>
                            <option value="Grocery Store">Grocery Store</option>
                            <option value="Catering Service">Catering Service</option>
                            <option value="Recipient Organization">Recipient Organization</option>
                            <option value="Community Organization">Community Organization</option>
                        </select>
                    </div>
                </div>

                <!-- Account Security -->
                <div class="mt-10 pt-8 border-t border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-2">Account Security</h2>

                    <div class="mt-6">
                        <label class="block text-base font-semibold text-gray-800 mb-2">Password</label>
                        <input type="password"
                            name="password"
                            minlength="8"
                            required
                            placeholder="Enter your password"
                            class="w-full rounded-md border border-gray-300 p-3.5 text-base text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                    </div>

                    <div class="mt-5">
                        <label class="block text-base font-semibold text-gray-800 mb-2">Confirm Password</label>
                        <input type="password"
                            name="password_confirmation"
                            minlength="8"
                            required
                            placeholder="Confirm your password"
                            class="w-full rounded-md border border-gray-300 p-3.5 text-base text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                    </div>
                </div>

                <!-- SUBMIT BUTTON -->
                <button type="submit"
                    class="mt-8 w-full cursor-pointer rounded-md bg-[#2E7D32] p-4 text-lg font-bold text-white transition-colors duration-200 hover:bg-[#1B5E20] shadow-sm">
                    REGISTER ORGANIZATION
                </button>
            </form>

            <!-- LOGIN LINK -->
            <p class="mt-8 text-center text-base text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold text-[#2E7D32] hover:underline">
                    Login
                </a>
            </p>

        </div>
    </div>
</body>
</html>