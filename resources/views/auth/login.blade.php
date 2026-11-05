<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- This links your app.css with all Tailwind utilities compiled -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
        }
    </style>
</head>

<body class="flex min-h-screen bg-[#f4f6f9] font-sans overflow-x-hidden">
    <!-- BRANDING HEADER: Positioned at the top of the entire page, above both sections -->
        <header class="absolute top-0 left-0 w-full z-50 p-6 flex items-center gap-3 bg-white/70 backdrop-blur-md border-b border-gray-200/50 md:bg-transparent md:backdrop-blur-none md:border-none">
        
        <!-- SVG Icon (Placeholder Logo) -->
        <!-- The 'md:text-white' utility class updates the icon color on desktop screens to match the green panel text color -->
        <!-- SYSTEM LOGO: Seamless Fusion of a Leaf and Food (Fork/Plant hybrid) -->
         <!-- Temporary SVG logo for demonstration purposes. This will be replaced with the actual logo image or SVG as needed. -->
        <svg class="h-8 w-8 text-[#2E7D32] md:text-white transition-transform duration-300 hover:scale-105" 
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor" 
            stroke-width="2" 
            stroke-linecap="round" 
            stroke-linejoin="round">
            <!-- Outer Leaf Contour Silhouette -->
            <path d="M12 2C6.5 2 3 7.5 3 13c0 4.5 3.5 8 9 9 5.5-1 9-4.5 9-9 0-5.5-3.5-11-9-11z" />
            
            <!-- Central Leaf Vein acting as the Fork Handle / Stem -->
            <path d="M12 2v20" />
            
            <!-- Left and Right Inner Leaf Detail / Fork Outer Tines -->
            <path d="M8 9.5a4 4 0 0 0 4 3.5 4 4 0 0 0 4-3.5" />
            
            <!-- Central Fork Tine Details branching like micro-veins -->
            <path d="M10 9.5v3" />
            <path d="M14 9.5v3" />
        </svg>
        
        <!-- <img src="/path-to-logo.png" alt="Logo" class="h-8 w-auto"> -->
        
        <!-- System Name: FoodRescue Hub -->
        <span class="text-2xl sm:text-3xl font-bold text-gray-800 md:text-white tracking-wide">FoodRescue Hub</span>
    
        </header>

    <!-- MAIN WRAPPER: Combines both sections side-by-side -->
    <div class="flex w-full min-h-screen">
        <!-- LEFT CONTAINER -->
<div class="hidden md:block md:w-3/5 relative h-screen overflow-hidden">

    <!-- BACKGROUND IMAGE -->
    <img
        src="{{ asset('images/food_distribution.jpeg') }}"
        alt="Community food sharing"
        class="absolute inset-0 w-full h-full object-cover z-0">

    <!-- DARK OVERLAY -->
    <div class="absolute inset-0 bg-black/70 z-10"></div>

    <!-- SCROLLABLE CONTENT -->
    <div
        class="relative z-20 h-screen overflow-y-scroll snap-y snap-mandatory">

        <!-- SECTION 1 -->
        <section class="h-screen snap-start flex items-center">
            <div class="px-16 max-w-2xl">

                <h1 class="text-6xl font-bold text-white leading-tight">
                    Reduce Food Waste.
                    <br>
                    Support Communities.
                </h1>

                <p class="mt-6 text-lg text-green-100">
                    FoodRescue Hub helps organizations manage surplus food
                    and connect with verified community partners through an
                    organized redistribution platform.
                </p>

            </div>
        </section>

        <!-- SECTION 2 -->
        <section class="h-screen snap-start flex items-center">

            <div class="px-16 max-w-2xl">

                <h2 class="text-4xl font-bold text-white mb-6">
                    About FoodRescue Hub
                </h2>

                <p class="text-lg text-green-100 leading-relaxed">
                    Many organizations still rely on phone calls,
                    spreadsheets, and social media to coordinate
                    surplus food distribution.
                </p>

                <p class="mt-4 text-lg text-green-100 leading-relaxed">
                    FoodRescue Hub provides one centralized system where
                    organizations can manage food listings, review requests,
                    schedule pickups, and track completed redistribution
                    activities.
                </p>

            </div>

        </section>

        <!-- SECTION 3 -->
        <section class="h-screen snap-start flex items-center">

            <div class="px-16 max-w-3xl">

                <h2 class="text-4xl font-bold text-white mb-8">
                    How It Works
                </h2>

                <div class="space-y-5">

                    <div class="bg-white/10 backdrop-blur-md rounded-xl p-5">
                        <h3 class="font-semibold text-xl text-white">
                            1. List Available Food
                        </h3>

                        <p class="text-green-100 mt-2">
                            Food providers record surplus food that is
                            available for redistribution.
                        </p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-md rounded-xl p-5">
                        <h3 class="font-semibold text-xl text-white">
                            2. Submit Requests
                        </h3>

                        <p class="text-green-100 mt-2">
                            Verified organizations browse food listings
                            and submit requests.
                        </p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-md rounded-xl p-5">
                        <h3 class="font-semibold text-xl text-white">
                            3. Schedule Pickup
                        </h3>

                        <p class="text-green-100 mt-2">
                            Both organizations coordinate a pickup date,
                            time, and location.
                        </p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-md rounded-xl p-5">
                        <h3 class="font-semibold text-xl text-white">
                            4. Confirm Distribution
                        </h3>

                        <p class="text-green-100 mt-2">
                            Completed transactions are recorded for
                            accountability and transparency.
                        </p>
                    </div>

                </div>

            </div>

        </section>

        <!-- SECTION 4 -->
        <section class="h-screen snap-start flex items-center">

            <div class="px-16 max-w-3xl">

                <h2 class="text-4xl font-bold text-white mb-8">
                    Key Features
                </h2>

                <div class="grid grid-cols-2 gap-4">

                    <div class="bg-white/10 rounded-xl p-5 text-white">
                        ✓ Food Listings
                    </div>

                    <div class="bg-white/10 rounded-xl p-5 text-white">
                        ✓ Expiration Monitoring
                    </div>

                    <div class="bg-white/10 rounded-xl p-5 text-white">
                        ✓ Request Management
                    </div>

                    <div class="bg-white/10 rounded-xl p-5 text-white">
                        ✓ Pickup Scheduling
                    </div>

                    <div class="bg-white/10 rounded-xl p-5 text-white">
                        ✓ Distribution Tracking
                    </div>

                    <div class="bg-white/10 rounded-xl p-5 text-white">
                        ✓ Activity Reports
                    </div>

                </div>

            </div>

        </section>
        
        <!-- FOOTER SECTION -->
        <section class="h-screen snap-start flex items-center">

            <div class="px-16 max-w-3xl">

                <h2 class="text-4xl font-bold text-white mb-6">
                    FoodRescue Hub
                </h2>

                <p class="text-xl text-green-100 leading-relaxed">
                    A centralized platform that helps verified organizations
                    manage surplus food, coordinate redistribution activities,
                    and maintain transparent records of food distribution.
                </p>

                <div class="mt-10 grid grid-cols-2 gap-8">

                    <div>
                        <h3 class="font-semibold text-xl text-white mb-2">
                            Our Mission
                        </h3>

                        <p class="text-green-100">
                            Support the effective use of surplus food through
                            organized inventory management and redistribution.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-xl text-white mb-2">
                            Platform Focus
                        </h3>

                        <p class="text-green-100">
                            Food inventory, request management, pickup
                            coordination, and distribution tracking.
                        </p>
                    </div>

                </div>

                <div class="mt-12 border-t border-white/20 pt-6">

                    <div class="flex flex-wrap gap-3">

                        <span class="bg-white/10 px-4 py-2 rounded-full text-sm">
                            Food Listings
                        </span>

                        <span class="bg-white/10 px-4 py-2 rounded-full text-sm">
                            Organization Verification
                        </span>

                        <span class="bg-white/10 px-4 py-2 rounded-full text-sm">
                            Pickup Scheduling
                        </span>

                        <span class="bg-white/10 px-4 py-2 rounded-full text-sm">
                            Redistribution Tracking
                        </span>

                    </div>

                    <p class="mt-8 text-sm text-green-100">
                        © {{ date('Y') }} FoodRescue Hub. Developed as a
                        Surplus Food Management and Redistribution System.
                    </p>

                </div>

            </div>

        </section>
    </div>

</div>


    <!-- RIGHT CONTAINER: For the login form -->
    <div class="w-full md:w-2/5 bg-white p-8 sm:p-16 flex flex-col justify-center items-center">
        <div class="w-full max-w-md">
            <h2 class="text-center text-2xl font-bold text-gray-800">Welcome Back</h2>
            <p class="mt-2 text-center text-sm text-gray-500">Sign in to manage food listings, requests, pickup schedules, and distribution records.</p>

            @if (session('success'))
                <p class="mt-4 text-center text-green-600 font-medium">{{ session('success') }}</p>
            @endif

            @if ($errors->any())
                <p class="mt-4 text-center text-red-600 font-medium">{{ $errors->first() }}</p>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <label for="email" class="mt-3.75 block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required placeholder="Enter your email address"
                    class="mt-1.5 block w-full rounded-[5px] border border-[#ccc] p-3 text-gray-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">

                <label for="password" class="mt-3.75 block text-sm font-medium text-gray-700">Password</label>
                <input type="password"
                    id="password"
                    name="password"
                    required placeholder="Enter your password"
                    class="mt-1.5 block w-full rounded-[5px] border border-[#ccc] p-3 text-gray-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                <div class="mt-4 rounded-lg bg-green-50 border border-green-200 p-3 text-sm text-green-800">Only verified organizations can participate in food redistribution activities.</div>
                <button type="submit" 
                    class="mt-5 w-full cursor-pointer rounded-[5px] bg-[#2E7D32] p-3 text-base font-semibold text-white transition-colors duration-200 hover:bg-[#66BB6A]">
                    LOGIN
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-medium text-green-800 hover:underline">Register</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>