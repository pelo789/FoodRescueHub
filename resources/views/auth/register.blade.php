<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>

<div class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Register
        </h2>


        @if ($errors->any())

            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">

                @foreach ($errors->all() as $error)

                    <p>{{ $error }}</p>

                @endforeach

            </div>

        @endif


        <form method="POST"
              action="{{ route('register.submit') }}"
              class="space-y-4">

            @csrf


            <!-- FIRST NAME -->

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    First Name
                </label>

                <input type="text"
                       name="first_name"
                       value="{{ old('first_name') }}"
                       maxlength="100"
                       required
                       placeholder="Enter your first name"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">

            </div>


            <!-- LAST NAME -->

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Last Name
                </label>

                <input type="text"
                       name="last_name"
                       value="{{ old('last_name') }}"
                       maxlength="100"
                       required
                       placeholder="Enter your last name"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">

            </div>


            <!-- EMAIL -->

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       maxlength="150"
                       required
                       placeholder="Enter your email address"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">

            </div>


            <!-- PHONE -->

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Phone
                </label>

                <input type="tel"
                       name="phone"
                       value="{{ old('phone') }}"
                       maxlength="20"
                       placeholder="Enter your phone number"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">

            </div>


            <!-- ADDRESS -->

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Address
                </label>

                <input type="text"
                       name="address"
                       value="{{ old('address') }}"
                       maxlength="255"
                       placeholder="Enter your address"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">

            </div>


            <!-- ROLE -->

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Role
                </label>

                <select name="role"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">

                    <option value="" disabled
                        {{ old('role') ? '' : 'selected' }}>
                        Select your role
                    </option>

                    <option value="Primary Operator"
                        {{ old('role') == 'Primary Operator' ? 'selected' : '' }}>
                        Primary Operator
                    </option>

                    <option value="Stakeholder"
                        {{ old('role') == 'Stakeholder' ? 'selected' : '' }}>
                        Stakeholder
                    </option>

                    <option value="End Beneficiary"
                        {{ old('role') == 'End Beneficiary' ? 'selected' : '' }}>
                        End Beneficiary
                    </option>

                </select>

            </div>


            <!-- PASSWORD -->

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Password
                </label>

                <input type="password"
                       name="password"
                       minlength="8"
                       required
                       placeholder="Enter your password"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">

            </div>


            <!-- CONFIRM PASSWORD -->

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Confirm Password
                </label>

                <input type="password"
                       name="password_confirmation"
                       minlength="8"
                       required
                       placeholder="Confirm your password"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">

            </div>


            <!-- SUBMIT BUTTON -->

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition-colors duration-200">

                REGISTER

            </button>

        </form>


        <!-- FOOTER LINKS -->

        <div class="mt-6 text-center text-sm text-gray-600">

            Already have an account?

            <a href="{{ route('login') }}"
               class="text-blue-600 font-medium hover:underline">

                Login

            </a>

        </div>

    </div>

</div>

</body>
</html>
```