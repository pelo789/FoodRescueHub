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
        
        <!-- System Name: FoodRescueHub -->
        <span class="text-2xl sm:text-3xl font-bold text-gray-800 md:text-white tracking-wide">FoodRescueHub</span>
    
        </header>
    <!-- MAIN WRAPPER: Combines both sections side-by-side -->
    <div class="flex w-full min-h-screen">
        <!-- LEFT CONTAINER: This section takes up 3/5ths of the screen on desktop and is hidden on mobile -->
<div class="hidden md:flex md:w-3/5 p-16 flex-col justify-center text-white relative overflow-hidden">
    
    <!-- This image is pinned STRICTLY inside this left box and won't bleed to the right side -->
    <img src="{{ asset('images/food_distribution.jpeg') }}" 
         alt="Community food sharing" 
         class="absolute inset-0 h-full w-full object-cover z-0">
    
    <!-- Translucent sheet that darkens ONLY the left side photo -->
    <div class="absolute inset-0 bg-black/60 z-10"></div>

    <!-- Welcome text floating safely over the left image -->
    <div class="max-w-md mx-auto relative z-20">
        <h1 class="text-4xl font-bold mb-4">Welcome to Our Platform</h1>
        <p class="text-lg text-green-100">Manage your projects, connect with teams, and streamline your workflow effortlessly.</p>
    </div>
</div>

    <!-- RIGHT CONTAINER: For the login form -->
    <div class="w-full md:w-2/5 bg-white p-8 sm:p-16 flex flex-col justify-center items-center">
        <div class="w-full max-w-md">
            <h2 class="text-center text-2xl font-bold text-gray-800">Login</h2>

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