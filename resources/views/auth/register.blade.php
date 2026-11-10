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

<body class="h-screen bg-linear-to-br from-green-50 via-[#f4f6f9] to-emerald-100 font-sans flex flex-col justify-between overflow-hidden relative">

    <!-- DECORATIVE ECO WATERMARKS (OPTION 2: AMBIENT BACKGROUND PATTERN) -->
    <!-- Top-Left Watermark Motif -->
    <div class="absolute -top-16 -left-16 pointer-events-none opacity-[0.07] text-[#2E7D32] z-0">
        <svg class="w-96 h-96" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17 8C8 10 59 16.17 3.82 21.34L5.23 22.76C10.4 17.58 17 8 17 8Z" />
            <path d="M12 2C6.5 2 3 7.5 3 13c0 4.5 3.5 8 9 9 5.5-1 9-4.5 9-9 0-5.5-3.5-11-9-11z" />
        </svg>
    </div>

    <!-- BRANDING HEADER -->
    <header class="w-full px-6 py-3 flex items-center justify-between shrink-0 z-10">
        <a href="/" class="flex items-center gap-2">
            <svg class="h-6 w-6 text-[#2E7D32] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2C6.5 2 3 7.5 3 13c0 4.5 3.5 8 9 9 5.5-1 9-4.5 9-9 0-5.5-3.5-11-9-11z" />
                <path d="M12 2v20" />
                <path d="M8 9.5a4 4 0 0 0 4 3.5 4 4 0 0 0 4-3.5" />
                <path d="M10 9.5v3" />
                <path d="M14 9.5v3" />
            </svg>
            <span class="text-lg font-bold text-gray-900 tracking-wide whitespace-nowrap">FoodRescue Hub</span>
            <span class="hidden lg:block text-xs text-gray-500 ml-2">Reducing food waste through verified community partnerships.</span>
        </a>
    </header>

    <!-- FORM WRAPPER (CONTAINED TO FIT VIEWPORT WITHOUT SCROLLING) -->
    <main class="grow flex items-center justify-center px-4 py-2 overflow-y-auto z-10">
        <div class="w-full max-w-lg bg-white rounded-xl shadow-sm border border-gray-200 px-6 py-5 sm:px-8 sm:py-6">

            <!-- SUCCESS STATE -->
            @if (session('registration_submitted'))
                <div class="text-center py-4">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                        <svg class="h-6 w-6 text-[#2E7D32]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">Registration Submitted</h2>
                    <p class="mt-2 text-xs text-gray-600 leading-relaxed max-w-sm mx-auto">
                        Your organization application has been received and is currently under review. You will be notified once verification is completed.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('login') }}" class="inline-block bg-[#2E7D32] hover:bg-[#1B5E20] px-5 py-2 rounded-md text-xs font-semibold text-white transition-colors">
                            Return to Login
                        </a>
                    </div>
                </div>
            @else

                <!-- PROGRESS INDICATOR STEPPER -->
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-1.5">
                        <span id="step-label" class="text-[11px] font-bold uppercase tracking-wider text-[#2E7D32]">Step 1 of 2</span>
                        <span id="step-title-badge" class="text-[11px] font-semibold text-gray-500">Account Credentials</span>
                    </div>
                    <div class="w-full bg-gray-200 h-1.5 rounded-full overflow-hidden">
                        <div id="progress-bar" class="bg-[#2E7D32] h-full w-1/2 transition-all duration-300 ease-in-out"></div>
                    </div>
                </div>
                
                <!-- GLOBAL VALIDATION ERRORS -->
                @if ($errors->any())
                    <div class="mb-3 rounded-md border border-red-200 bg-red-50 p-2.5">
                        <ul class="list-disc list-inside text-xs text-red-600 font-medium space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="registration-form" method="POST" action="{{ route('register.submit') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- STEP 1: ACCOUNT INFORMATION -->
                    <div id="step-1" class="space-y-2">
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Join FoodRescue Hub</h1>
                            <p class="mt-2 text-xs text-gray-500">Food providers and recipient organizations can apply to participate in surplus food  redistribution through FoodRescue Hub.</p>
                        </div>

                        <div>
                            <label for="first_name" class="block text-xs font-medium text-gray-700">First Name</label>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required placeholder="e.g., Juan"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-1.5 text-xs text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                        </div>

                        <div>
                            <label for="last_name" class="block text-xs font-medium text-gray-700">Last Name</label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required placeholder="e.g., dela Cruz"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-1.5 text-xs text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-medium text-gray-700">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="email@organization.org"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-1.5 text-xs text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                        </div>

                        <div>
                            <label for="phone" class="block text-xs font-medium text-gray-700">Contact Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="e.g., +63 912 345 6789"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-1.5 text-xs text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                        </div>
                        <div>
                        <label for="address" class="block text-xs font-medium text-gray-700">
                            Residential Address
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="2"
                            required
                            placeholder="Enter your residential address"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-1.5 text-xs text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">{{ old('address') }}</textarea>
                    </div>

                        <div>
                            <label for="password" class="block text-xs font-medium text-gray-700">Password</label>
                            <input type="password" id="password" name="password" required placeholder="At least 8 characters"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-1.5 text-xs text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-medium text-gray-700">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Re-enter password"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-1.5 text-xs text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="button" id="btn-next" onclick="goToStep(2)"
                                class="w-full sm:w-auto px-5 py-2 rounded-md bg-[#2E7D32] hover:bg-[#1B5E20] text-xs font-bold text-white transition-colors cursor-pointer shadow-sm">
                                Continue →
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2: ORGANIZATION VERIFICATION -->
                    <div id="step-2" class="hidden space-y-3">
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Organization Details</h1>
                            <p class="text-xs text-gray-600 mt-0.5">Provide business details and verification documents.</p>
                        </div>

                        <!-- VERIFICATION NOTICE -->
                        <div class="rounded-lg bg-green-50 border border-green-200 p-2.5">
                            <p class="text-xs text-green-800 font-medium leading-relaxed">
                                Organizations must undergo administrator review before participating in food redistribution activities.
                            </p>
                        </div>

                        <div>
                            <label for="organization_name" class="block text-xs font-medium text-gray-700">Organization Name</label>
                            <input type="text" id="organization_name" name="organization_name" value="{{ old('organization_name') }}" required placeholder="Registered business or NGO name"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-1.5 text-xs text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                        </div>

                        <div>
                            <label for="organization_type" class="block text-xs font-medium text-gray-700">Organization Type</label>
                            <select id="organization_type" name="organization_type" required
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-1.5 text-xs text-gray-900 bg-white focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">
                                <option value="">Select organization category</option>
                                <option value="Restaurant" {{ old('organization_type') == 'Restaurant' ? 'selected' : '' }}>Restaurant</option>
                                <option value="Bakery" {{ old('organization_type') == 'Bakery' ? 'selected' : '' }}>Bakery</option>
                                <option value="Grocery Store" {{ old('organization_type') == 'Grocery Store' ? 'selected' : '' }}>Grocery Store</option>
                                <option value="Catering Service" {{ old('organization_type') == 'Catering Service' ? 'selected' : '' }}>Catering Service</option>
                                <option value="Recipient Organization" {{ old('organization_type') == 'Recipient Organization' ? 'selected' : '' }}>Recipient Organization</option>
                                <option value="Community Organization" {{ old('organization_type') == 'Community Organization' ? 'selected' : '' }}>Community Organization</option>
                            </select>
                        </div>

                        <div>
                            <label for="organization_address" class="block text-xs font-medium text-gray-700">Organization Address</label>
                            <textarea id="organization_address" name="organization_address" rows="2" required placeholder="Full physical address for pickup/delivery routing"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-1.5 text-xs text-gray-900 focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] focus:outline-none">{{ old('organization_address') }}</textarea>
                        </div>

                        <!-- DROP ZONE UPLOAD AREA -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Supporting Document Upload</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-3 text-center hover:border-[#2E7D32] transition-colors bg-gray-50/50">
                                <input type="file" id="supporting_document" name="supporting_document" accept=".pdf,.jpg,.jpeg,.png" required
                                    onchange="updateFileName(this)"
                                    class="block w-full text-xs text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-[11px] file:font-semibold file:bg-green-50 file:text-[#2E7D32] hover:file:bg-green-100 cursor-pointer">
                                <p id="file-feedback" class="mt-1 text-[11px] text-gray-500">Business Permit, Registration Certificate, or Proof of Org (PDF, JPG, PNG up to 5MB).</p>
                            </div>
                        </div>

                        <!-- BUTTON HIERARCHY -->
                        <div class="pt-3 flex items-center justify-between gap-3 border-t border-gray-100">
                            <button type="button" onclick="goToStep(1)"
                                class="px-4 py-2 rounded-md text-xs font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors cursor-pointer">
                                ← Back
                            </button>
                            <button type="submit"
                                class="px-6 py-2 rounded-md bg-[#2E7D32] hover:bg-[#1B5E20] text-xs font-bold text-white shadow-sm transition-all duration-200 cursor-pointer">
                                Submit Registration
                            </button>
                        </div>
                    </div>

                </form>

            @endif

            <!-- LOGIN LINK -->
            @unless(session('registration_submitted'))
                <p class="mt-4 text-center text-xs text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-semibold text-[#2E7D32] hover:underline">Sign In</a>
                </p>
            @endunless

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="w-full bg-[#1B5E20] text-white py-2.5 px-8 border-t border-green-900 shrink-0 z-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-1 text-[11px]">
            <div>
                <span class="font-bold text-xs">FoodRescue Hub</span>
                <span class="text-green-100 ml-2">Surplus Food Management and Redistribution System</span>
            </div>
            <p class="text-green-100">
                © {{ date('Y') }} FoodRescue Hub
            </p>
        </div>
    </footer>

    <!-- STEP TOGGLE AND VALIDATION SCRIPT -->
    <script>
        function goToStep(stepNumber) {
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            const progressBar = document.getElementById('progress-bar');
            const stepLabel = document.getElementById('step-label');
            const stepTitleBadge = document.getElementById('step-title-badge');

            if (stepNumber === 2) {
                // Client-side required field check for Step 1
                const step1Inputs = step1.querySelectorAll('input[required]');
                let valid = true;
                step1Inputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.reportValidity();
                        valid = false;
                        return false;
                    }
                });

                if (!valid) return;

                // Client-side Password Match check
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirmation').value;
                if (password !== confirmPassword) {
                    alert("Passwords do not match. Please verify.");
                    document.getElementById('password_confirmation').focus();
                    return;
                }

                step1.classList.add('hidden');
                step2.classList.remove('hidden');
                progressBar.style.width = '100%';
                stepLabel.textContent = 'Step 2 of 2';
                stepTitleBadge.textContent = 'Organization Verification';
            } else {
                step2.classList.add('hidden');
                step1.classList.remove('hidden');
                progressBar.style.width = '50%';
                stepLabel.textContent = 'Step 1 of 2';
                stepTitleBadge.textContent = 'Account Credentials';
            }
        }

        // Dynamic file name feedback state
        function updateFileName(input) {
            const feedback = document.getElementById('file-feedback');
            if (input.files && input.files[0]) {
                feedback.textContent = "Selected file: " + input.files[0].name;
                feedback.classList.add("text-[#2E7D32]", "font-semibold");
            } else {
                feedback.textContent = "Business Permit, Registration Certificate, or Proof of Org (PDF, JPG, PNG up to 5MB).";
                feedback.classList.remove("text-[#2E7D32]", "font-semibold");
            }
        }

        // Auto-open Step 2 if backend returned validation errors for Step 2
        @if ($errors->has('organization_name') || $errors->has('organization_type') || $errors->has('organization_address') || $errors->has('supporting_document'))
            goToStep(2);
        @endif
    </script>
</body>
</html>