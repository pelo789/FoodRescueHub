<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recipient Dashboard - FoodRescue Hub</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-xl font-bold text-green-800">Recipient Organization Dashboard</h1>
        <p class="text-xs text-gray-600 mt-2">Welcome! Your account is active and your organization verification status is currently <strong>Pending</strong>.</p>
        
        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-600 text-white text-xs rounded hover:bg-red-700">Logout</button>
        </form>
    </div>
</body>
</html>