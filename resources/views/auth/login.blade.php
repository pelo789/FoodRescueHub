<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - FoodRescue Hub</title>
    <!-- Tailwind CSS v4 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
        }
    </style>
</head>

<body class="min-h-screen bg-[#f4f6f9] font-sans overflow-x-hidden">

    <!-- FLOATING BRANDING HEADER -->
    <header class="fixed top-0 left-0 w-full md:w-3/5 z-50 px-6 sm:px-10 lg:px-16 py-5 flex items-center gap-3 pointer-events-none">
        
        <!-- Left Side Branding (Over Dark Container) -->
        <div class="hidden md:flex md:w-3/5 px-16 py-6 items-center gap-3">
            <svg class="h-9 w-9 text-white drop-shadow-md shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2C6.5 2 3 7.5 3 13c0 4.5 3.5 8 9 9 5.5-1 9-4.5 9-9 0-5.5-3.5-11-9-11z" />
                <path d="M12 2v20" />
                <path d="M8 9.5a4 4 0 0 0 4 3.5 4 4 0 0 0 4-3.5" />
                <path d="M10 9.5v3" />
                <path d="M14 9.5v3" />
            </svg>
            <span class="text-3xl font-bold text-white tracking-wide drop-shadow-md whitespace-nowrap">FoodRescue Hub</span>
        </div>

        <!-- Mobile Branding -->
        <div class="flex md:hidden w-full px-6 py-4 items-center gap-3">
            <svg class="h-8 w-8 text-[#2E7D32] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2C6.5 2 3 7.5 3 13c0 4.5 3.5 8 9 9 5.5-1 9-4.5 9-9 0-5.5-3.5-11-9-11z" />
                <path d="M12 2v20" />
                <path d="M8 9.5a4 4 0 0 0 4 3.5 4 4 0 0 0 4-3.5" />
                <path d="M10 9.5v3" />
                <path d="M14 9.5v3" />
            </svg>
            <span class="text-2xl font-bold text-gray-900 tracking-wide whitespace-nowrap">FoodRescue Hub</span>
        </div>

    </header>

    <!-- MAIN WRAPPER: Side-by-side layout -->
    <div class="flex flex-col md:flex-row w-full h-screen">
        
        <!-- LEFT CONTAINER: Scrollable Landing Content -->
        <div class="hidden md:block md:w-3/5 h-full overflow-y-auto snap-y snap-mandatory scroll-smooth relative">
            <!-- Background Image -->
            <img src="{{ asset('images/food_distribution.jpeg') }}" 
                alt="Community food sharing" 
                class="fixed top-0 left-0 md:w-3/5 h-full object-cover z-0 pointer-events-none">
            
            <!-- Dark Overlay -->
            <div class="fixed inset-0 md:w-3/5 bg-black/60 z-10 pointer-events-none"></div>

            <div class="relative z-20 px-16 pb-28">
                
                <!-- SECTION 1: HERO -->
                <section class="min-h-[calc(100vh-8rem)] snap-start flex flex-col justify-center max-w-2xl mx-auto text-white pt-28">
                    <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                        Reduce Food Waste. <br>
                        Support Communities.
                    </h1>

                    <p class="text-xl text-green-100 leading-relaxed font-normal">
                        FoodRescue Hub helps organizations manage surplus food and connect with verified community partners through a structured redistribution platform.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <span class="bg-white/15 px-4 py-2.5 rounded-full text-base font-medium">Restaurant</span>
                        <span class="bg-white/15 px-4 py-2.5 rounded-full text-base font-medium">Bakery</span>
                        <span class="bg-white/15 px-4 py-2.5 rounded-full text-base font-medium">Grocery Store</span>
                        <span class="bg-white/15 px-4 py-2.5 rounded-full text-base font-medium">Catering Service</span>
                        <span class="bg-white/15 px-4 py-2.5 rounded-full text-base font-medium">Recipient Organization</span>
                    </div>

                    <div class="mt-8 space-y-3 text-lg font-medium text-green-50">
                        <p>✓ Verified Organizations</p>
                        <p>✓ Pickup Scheduling</p>
                        <p>✓ Redistribution Tracking</p>
                    </div>

                    <div>
                        <a href="#about" class="inline-block mt-8 bg-[#2E7D32] hover:bg-[#1B5E20] px-6 py-3.5 rounded-lg text-white font-semibold text-lg transition-colors shadow-md">
                            Learn More ↓
                        </a>
                    </div>
                </section>

                <!-- SECTION 2: ABOUT -->
                <section id="about" class="min-h-[calc(100vh-8rem)] snap-start flex flex-col justify-center max-w-2xl mx-auto text-white">
                    <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">
                        About FoodRescue Hub
                    </h2>

                    <p class="text-xl text-green-100 leading-relaxed">
                        Many organizations still rely on phone calls, spreadsheets, and social media to coordinate surplus food redistribution. These approaches can make it difficult to monitor available food, manage requests, schedule pickups, and maintain accurate records.
                    </p>

                    <div class="grid md:grid-cols-2 gap-6 mt-10">
                        <div class="bg-white/10 rounded-xl p-6 backdrop-blur-sm border border-white/10">
                            <h3 class="font-semibold text-2xl mb-4">Challenges</h3>
                            <ul class="space-y-3 text-base text-green-100">
                                <li>✓ Limited visibility of available food</li>
                                <li>✓ Manual tracking of requests</li>
                                <li>✓ Difficult pickup coordination</li>
                                <li>✓ Risk of food expiring before use</li>
                            </ul>
                        </div>

                        <div class="bg-white/10 rounded-xl p-6 backdrop-blur-sm border border-white/10">
                            <h3 class="font-semibold text-2xl mb-4">FoodRescue Hub Solution</h3>
                            <ul class="space-y-3 text-base text-green-100">
                                <li>✓ Centralized food listings</li>
                                <li>✓ Request management</li>
                                <li>✓ Pickup scheduling</li>
                                <li>✓ Redistribution tracking</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- SECTION 3: FEATURES -->
                <section class="min-h-[calc(100vh-8rem)] snap-start flex flex-col justify-center max-w-2xl mx-auto text-white">
                    <h2 class="text-4xl lg:text-5xl font-bold text-white mb-10">
                        Why Organizations Join FoodRescue Hub
                    </h2>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                        <div class="bg-white/10 p-6 rounded-xl backdrop-blur-sm border border-white/10">
                            <h3 class="font-semibold text-xl mb-2">Food Listings</h3>
                            <p class="text-base text-green-100">Record and manage available surplus food in one place.</p>
                        </div>

                        <div class="bg-white/10 p-6 rounded-xl backdrop-blur-sm border border-white/10">
                            <h3 class="font-semibold text-xl mb-2">Organization Verification</h3>
                            <p class="text-base text-green-100">Participate through verified and approved accounts.</p>
                        </div>

                        <div class="bg-white/10 p-6 rounded-xl backdrop-blur-sm border border-white/10">
                            <h3 class="font-semibold text-xl mb-2">Request Management</h3>
                            <p class="text-base text-green-100">Coordinate food requests efficiently.</p>
                        </div>

                        <div class="bg-white/10 p-6 rounded-xl backdrop-blur-sm border border-white/10">
                            <h3 class="font-semibold text-xl mb-2">Pickup Scheduling</h3>
                            <p class="text-base text-green-100">Organize food collection schedules.</p>
                        </div>

                        <div class="bg-white/10 p-6 rounded-xl backdrop-blur-sm border border-white/10">
                            <h3 class="font-semibold text-xl mb-2">Redistribution Tracking</h3>
                            <p class="text-base text-green-100">Maintain transparent food distribution records.</p>
                        </div>

                        <div class="bg-white/10 p-6 rounded-xl backdrop-blur-sm border border-white/10">
                            <h3 class="font-semibold text-xl mb-2">Reports & Monitoring</h3>
                            <p class="text-base text-green-100">Review redistribution activities and summaries.</p>
                        </div>
                    </div>
                </section>

            </div>
        </div>

        <!-- RIGHT CONTAINER: Login Form -->
        <div class="w-full md:w-2/5 bg-white p-8 sm:p-16 flex flex-col justify-center items-center h-full z-20">
            <div class="w-full max-w-md">
                <h2 class="text-center text-3xl font-bold text-gray-900">Welcome Back</h2>
                <p class="mt-3 text-center text-base text-gray-600">
                    Sign in to manage food listings, requests, pickup schedules, and redistribution records.
                </p>

                @if (session('success'))
                    <p class="mt-4 text-center text-green-600 font-medium text-base">{{ session('success') }}</p>
                @endif

                @if ($errors->any())
                    <p class="mt-4 text-center text-red-600 font-medium text-base">{{ $errors->first() }}</p>
                @endif

                <form method="POST" action="{{ route('login.submit') }}" class="mt-8">
                    @csrf

                    <label for="email" class="block text-base font-semibold text-gray-800">Email Address</label>
                    <input type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required 
                        placeholder="Enter your email address"
                        class="mt-2 block w-full rounded-md border border-gray-300 p-3.5 text-base text-gray-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">

                    <label for="password" class="mt-5 block text-base font-semibold text-gray-800">Password</label>
                    <input type="password"
                        id="password"
                        name="password"
                        required 
                        placeholder="Enter your password"
                        class="mt-2 block w-full rounded-md border border-gray-300 p-3.5 text-base text-gray-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">

                    <div class="mt-5 rounded-lg bg-green-50 border border-green-200 p-4">
                        <p class="text-base text-green-800 font-medium">
                            Only verified organizations can participate in food redistribution activities.
                        </p>
                    </div>

                    <button type="submit" 
                        class="mt-6 w-full cursor-pointer rounded-md bg-[#2E7D32] p-4 text-lg font-bold text-white transition-colors duration-200 hover:bg-[#1B5E20] shadow-sm">
                        LOGIN
                    </button>
                </form>

                <p class="mt-8 text-center text-base text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-semibold text-green-800 hover:underline">Register</a>
                </p>
            </div>
        </div>

    </div>

    <!-- PINNED FOOTER -->
    <footer class="fixed bottom-0 left-0 w-full z-50 bg-[#1B5E20] text-white py-3.5 px-8 border-t border-green-900">
        <div class="flex flex-col md:flex-row items-center justify-between gap-2 text-sm">
            <div>
                <span class="font-bold text-base">FoodRescue Hub</span>
                <span class="text-green-100 ml-2">Surplus Food Management and Redistribution System</span>
            </div>
            <p class="text-green-100">
                © {{ date('Y') }} FoodRescue Hub
            </p>
        </div>
    </footer>

</body>
</html>