<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <!-- Tailwind CSS CDN for styling classes -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased p-8">

    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Header / Logout Bar -->
        <div class="flex justify-between items-center bg-white shadow rounded-lg p-6">
            <h1 class="text-xl font-bold text-gray-800">FoodRescue Hub Dashboard</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md text-xs font-semibold hover:bg-red-700 transition-colors">
                    Logout
                </button>
            </form>
        </div>

        <!-- Verification Status Card -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-bold text-gray-800">Welcome, {{ auth()->user()->first_name }}!</h2>
            <p class="text-sm text-gray-600 mt-1">Role: <span class="font-semibold capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</span></p>
            
            <!-- Dynamic BRD Status Badge -->
            <div class="mt-4 inline-flex items-center px-3 py-1.5 rounded-md text-xs font-semibold
                @if(auth()->user()->verification_status === 'Verified') bg-green-100 text-green-800
                @elseif(auth()->user()->verification_status === 'Pending') bg-yellow-100 text-yellow-800
                @else bg-red-100 text-red-800 @endif">
                Verification Status: {{ auth()->user()->verification_status }}
            </div>

            @if(auth()->user()->verification_status === 'Pending')
                <p class="text-xs text-gray-500 mt-2">Your organization documents are currently under review by an administrator. You will gain access to food listing and request features once verified.</p>
            @endif

            <!-- Admin Review Button (Only visible if user is an administrator) -->
            @if(auth()->user()->role === 'administrator')
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.verifications') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-md shadow-sm transition-colors">
                        Review Pending Organizations &rarr;
                    </a>
                </div>
            @endif
        </div>

    </div>

</body>
</html>