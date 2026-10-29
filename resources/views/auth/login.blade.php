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

<body class="flex min-h-screen items-center justify-center bg-[#f4f6f9] p-5 font-sans">
<!-- Container styles -->
    <div class="w-full max-w-100 rounded-lg bg-white p-8 shadow-[0_4px_15px_rgba(0,0,0,0.08)]">
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
            <a href="{{ route('register') }}" class="font-medium text-green-600 hover:underline">Register</a>
        </p>
    </div>
</body>
</html>