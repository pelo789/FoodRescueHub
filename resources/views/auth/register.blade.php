<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>

<div class="bg-[linear-gradient(to_bottom,rgba(0,0,0,0.6),rgba(0,0,0,0.6)),url('images/food_distribution.jpeg')] bg-cover bg-center min-h-screen flex items-center justify-center p-4">
  <!-- Your content goes here and stays fully visible -->
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Register</h2>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <!-- First & Last Name -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">First Name</label>
            <input type="text" name="first_name" required class="w-full px-3 py-2 border rounded-md text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Last Name</label>
            <input type="text" name="last_name" required class="w-full px-3 py-2 border rounded-md text-sm">
        </div>
    </div>

    <!-- Email -->
    <div>
        <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Email Address</label>
        <input type="email" name="email" required class="w-full px-3 py-2 border rounded-md text-sm">
    </div>

    <!-- Role Selection (BRD Requirement) -->
    <div>
        <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Organization Role</label>
        <select name="role" required class="w-full px-3 py-2 border rounded-md text-sm bg-white">
            <option value="food_provider">Food Provider</option>
            <option value="recipient_organization">Recipient Organization</option>
        </select>
    </div>

    <!-- Address & Phone -->
    <div>
        <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Organization Address</label>
        <textarea name="address" rows="2" class="w-full px-3 py-2 border rounded-md text-sm"></textarea>
    </div>

    <div>
        <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Contact Number</label>
        <input type="text" name="phone" class="w-full px-3 py-2 border rounded-md text-sm">
    </div>

    <!-- Document Upload for Verification (BRD-M03) -->
    <div>
        <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Supporting Verification Document (PDF/Image)</label>
        <input type="file" name="verification_document" required class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-[#2E7D32] hover:file:bg-green-100">
        <p class="text-[11px] text-gray-400 mt-1">Upload proof of organization legitimacy (e.g., permit, ID, or certificate).</p>
    </div>

    <!-- Passwords -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Password</label>
            <input type="password" name="password" required class="w-full px-3 py-2 border rounded-md text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" required class="w-full px-3 py-2 border rounded-md text-sm">
        </div>
    </div>

    <button type="submit" class="w-full py-2.5 bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-semibold rounded-md text-sm transition-colors">
        Register Organization
    </button>
</form>

    <!-- Footer Links -->
    <div class="mt-6 text-center text-sm text-gray-600">
        Already have an account?
        <a href="{{ route('login') }}" class="text-green-800 font-medium hover:underline">Login</a>
    </div>
</div>
</div>
</div>

</body>
</html>