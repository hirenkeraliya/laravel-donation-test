<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Night Bright - Donate</title>
        <!-- Fonts -->

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        <script src="https://js.stripe.com/v3/"></script>
    </head>
    <body class="font-sans antialiased">
        <!-- Navigation -->
        <nav class="z-50 bg-black border-b border-gray-800 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/night-bright-logo.svg') }}" alt="Night Bright" class="h-8 w-auto">
                    </div>

                    <!-- Navigation Links -->
                    <div class="flex space-x-8">
                        <a href="#" class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white px-3 py-2 text-sm font-medium">Find</a>
                        <a href="#" class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white px-3 py-2 text-sm font-medium">Become</a>
                        <a href="#" class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white px-3 py-2 text-sm font-medium">Forum</a>
                        <a href="#" class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white px-3 py-2 text-sm font-medium">About</a>
                        <a href="#" class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white px-3 py-2 text-sm font-medium">Sign In</a>
                    </div>

                    <!-- Auth Links -->
                    <div class="flex items-center space-x-4">
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="pt-20 bg-gray-50 min-h-screen"> <!-- Increased top padding -->
            <!-- Back Button -->
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8"> <!-- Added margin bottom -->
                <button onclick="history.back()" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back
                </button>
            </div>

            <div class="max-w-6xl mx-auto my-auto px-4 sm:px-6 lg:px-8 mt-8">
                <!-- Organization Card -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-6">
                                <!-- Organization Logo -->
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('images/night-bright-logo.svg') }}" alt="Night Bright Logo" class="h-16 w-16">
                                </div>

                                <!-- Organization Info -->
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">Night Bright</h1>
                                    <div class="mt-2 flex items-center space-x-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            North America
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            United States
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Donate Button -->
                            <div>
                                <button onclick="openDonationOverlay()" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#B08D57] hover:bg-[#96784A] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#B08D57]">
                                    Donate
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Organization Description -->
                        <div class="mt-8 text-gray-600">
                            <p class="text-lg leading-relaxed">
                                Night Bright is a non-profit 501(c)3. We strive to make donating to your favorite causes an enjoyable experience that leads to a deeper connection with the thousands of beautiful people spreading the love of God throughout the globe. Please join us in making it easier to find, fund, and resource missions worldwide.
                            </p>
                        </div>
                    </div>
                </div>
                <div id="payment-message" class="hidden fixed bottom-4 right-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-md z-50"></div>
            </div>

            <!-- Donation Side Overlay -->
            <div id="donationOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity hidden" aria-hidden="true">
                <div class="fixed inset-y-0 left-0 pr-10 max-w-md w-full">
                    <div class="bg-white h-full overflow-y-auto">
                        <!-- Main Donation Form -->
                        <div id="mainDonationForm" class="p-6" x-data="{
                            donationType: 'one-time',
                            amount: '',
                            customAmount: false,
                            tipPercentage: 12,
                            donorName: '',
                            donorEmail: '',
                            message: '',
                            anonymous: false,
                            allowContact: false,
                            paymentMethod: '',
                            processingFee: 0,
                            errors: {}
                        }">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-semibold text-[#C4996C]">DONATE</h2>
                                <button onclick="closeDonationOverlay()" class="text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Donation Form -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium">Missionary Donation</h3>

                                <!-- Donation Type Toggle -->
                                <div class="flex rounded-md shadow-sm">
                                    <button
                                        @click="donationType = 'one-time'"
                                        :class="{ 'bg-[#B08D57] text-white': donationType === 'one-time', 'bg-white text-gray-700': donationType !== 'one-time' }"
                                        class="flex-1 px-4 py-2 font-medium rounded-l-md transition-colors">
                                        One-Time
                                    </button>
                                    <button
                                        @click="donationType = 'monthly'"
                                        :class="{ 'bg-[#B08D57] text-white': donationType === 'monthly', 'bg-white text-gray-700': donationType !== 'monthly' }"
                                        class="flex-1 px-4 py-2 font-medium rounded-r-md border border-gray-300 transition-colors">
                                        Monthly
                                    </button>
                                </div>

                                <!-- Donor Information -->
                                <div class="space-y-4">
                                    <div>
                                        <input type="text" placeholder="Donor's Name" id="donorName" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                        <p class="text-red-500 text-sm mt-1 hidden" id="donorNameError"></p>
                                    </div>
                                    <div>
                                        <input type="email" placeholder="Donor's Email" id="donorEmail" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                        <p class="text-red-500 text-sm mt-1 hidden" id="donorEmailError"></p>
                                    </div>
                                    <div>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white">
                                            <option value="">Night Bright</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Amount Options -->
                                <div class="grid grid-cols-4 gap-2">
                                    <button class="amount-btn px-4 py-2 border border-gray-300 rounded-md hover:border-[#B08D57]" data-amount="10">10$</button>
                                    <button class="amount-btn px-4 py-2 bg-[#B08D57] text-white rounded-md" data-amount="25">25$</button>
                                    <button class="amount-btn px-4 py-2 border border-gray-300 rounded-md hover:border-[#B08D57]" data-amount="50">50$</button>
                                    <button class="amount-btn px-4 py-2 border border-gray-300 rounded-md hover:border-[#B08D57]" data-amount="100">100$</button>
                                    <button class="amount-btn px-4 py-2 border border-gray-300 rounded-md hover:border-[#B08D57]" data-amount="250">250$</button>
                                    <button class="amount-btn px-4 py-2 border border-gray-300 rounded-md hover:border-[#B08D57]" data-amount="500">500$</button>
                                    <button class="amount-btn px-4 py-2 border border-gray-300 rounded-md hover:border-[#B08D57]" data-amount="1000">1000$</button>
                                    <button class="amount-btn px-4 py-2 border border-gray-300 rounded-md hover:border-[#B08D57]" data-amount="0">Other</button>
                                </div>

                                <!-- Message Option -->
                                <div>
                                    <button onclick="toggleMessage()" class="text-[#B08D57] hover:text-[#96784A] text-sm font-medium inline-flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                        </svg>
                                        Add a message
                                    </button>
                                    <div id="messageContainer" class="mt-2 hidden">
                                        <textarea id="donationMessage" placeholder="Your message (optional)" class="w-full px-3 py-2 border border-gray-300 rounded-md resize-none h-24"></textarea>
                                    </div>
                                </div>

                                <!-- Stay Anonymous -->
                                <div class="flex items-center">
                                    <input type="checkbox" id="anonymous" class="h-4 w-4 text-[#B08D57] border-gray-300 rounded">
                                    <label for="anonymous" class="ml-2 text-sm text-gray-600">Stay Anonymous</label>
                                </div>

                                <!-- Continue Button -->
                                <button onclick="showFinalDetails()" class="w-full px-4 py-2 bg-[#B08D57] text-white font-medium rounded-md hover:bg-[#96784A] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#B08D57]">
                                    Continue
                                </button>
                            </div>
                        </div>

                        <!-- Final Details Form -->
                        <div id="finalDetailsForm" class="p-6 hidden">
                            <!-- Header with Back Button -->
                            <div class="flex items-center mb-8">
                                <button onclick="showMainForm()" class="inline-flex items-center text-gray-500 hover:text-gray-700">
                                    <svg class="w-4 h-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm">Final Details</span>
                                </button>
                            </div>

                            <!-- Donation Summary -->
                            <div class="space-y-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Donation</span>
                                    <span class="font-medium">$25</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 block">Credit card processing fees</span>
                                    <div class="flex justify-between items-center">
                                        <select id="paymentMethod" onchange="updateProcessingFee()" class="w-48 border border-gray-300 rounded-md px-3 py-2 mb-2 text-sm bg-white">
                                            <option value="">Select Payment Method</option>
                                            <option value="amex">AMEX Card</option>
                                            <option value="card">Visa & Others</option>
                                            <option value="bank">US Bank Account</option>
                                            <option value="cash">Cash App Pay</option>
                                        </select>
                                        <span id="processingFee" class="block text-sm font-medium">$0.00</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500">
                                    You pay the CC fee so 100% of your donation goes to your chosen missionary or cause.
                                </p>

                                <!-- Tip Section -->
                                <div class="bg-[#FFF9E5] p-4 rounded-lg">
                                    <div class="flex justify-between items-center mb-2">
                                        <div class="text-sm">
                                            <p class="text-gray-700">Add a tip to support Night Bright</p>
                                            <p class="text-[#B08D57] text-xs mt-1 font-medium">Why Tip?</p>
                                            <p class="text-xs text-gray-500">Night Bright does not charge any platform fees and relies on your generosity to support this free service.</p>
                                        </div>

                                        <select id="tipSelect" class="w-32 border border-gray-300 rounded-md px-3 py-2 text-sm bg-white">
                                            <option value="0">0%</                                            <option value="5">5%</option>
                                            <option value="10">10%</option>
                                            <option value="12" selected>12%</option>
                                            <option value="15">15%</option>
                                            <option value="20">20%</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Contact Permission -->
                                <div class="flex items-center space-x-2 py-2">
                                    <input type="checkbox" id="allowContact" class="h-4 w-4 text-[#B08D57] border-gray-300 rounded">
                                    <label for="allowContact" class="text-sm text-gray-600">
                                        Allow Night Bright Inc to contact me
                                    </label>
                                </div>

                                <!-- Finish Button -->
                                <button onclick="handlePayment()" class="w-full px-4 py-3 bg-[#B08D57] text-white font-medium rounded-md hover:bg-[#96784A]">
                                    Finish (<span id="totalAmount">$28.00</span>)
                                </button>
                            </div>
                        </div>

                        <!-- Loading Overlay -->
                        <div id="loadingOverlay" class="absolute inset-0 bg-white bg-opacity-95 z-50 hidden flex flex-col items-center justify-center">
                            <div class="text-center">
                                <div class="flex items-center justify-center mb-4">
                                    <div class="animate-bounce mx-1 h-3 w-3 bg-[#B08D57] rounded-full"></div>
                                    <div class="animate-bounce mx-1 h-3 w-3 bg-[#B08D57] rounded-full" style="animation-delay: 0.2s"></div>
                                    <div class="animate-bounce mx-1 h-3 w-3 bg-[#B08D57] rounded-full" style="animation-delay: 0.4s"></div>
                                </div>
                                <span class="text-xl font-medium text-gray-700">LOADING</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let paymentIntent = null;
                let selectedAmount = 25.00; // Default amount
                let tipPercentage = 12; // Default tip percentage
                let donationType = 'one-time'; // Default donation type
                const stripe = Stripe("{{ config('services.stripe.key') }}");
                let elements;
                let selectedPaymentMethod = '';

                function safelyGetElement(id) {
                    const element = document.getElementById(id);
                    if (!element) {
                        console.warn(`Element with id '${id}' not found`);
                    }
                    return element;
                }

                function safelyToggleClass(element, className, force) {
                    if (element && element.classList) {
                        element.classList.toggle(className, force);
                    }
                }

                function calculateProcessingFee(amount) {
                    switch (selectedPaymentMethod) {
                        case 'amex':
                            return parseFloat((amount * 0.0392).toFixed(2));
                        case 'card':
                            return parseFloat((amount * 0.0368).toFixed(2));
                        case 'bank':
                            return parseFloat((amount * 0.0088).toFixed(2));
                        case 'cash':
                            return parseFloat((amount * 0.0444).toFixed(2));
                        default:
                            return 0;
                    }
                }

                function updateProcessingFee() {
                    const paymentMethodElement = safelyGetElement('paymentMethod');
                    const processingFeeElement = safelyGetElement('processingFee');

                    if (paymentMethodElement && processingFeeElement) {
                        selectedPaymentMethod = paymentMethodElement.value;
                        const processingFee = calculateProcessingFee(selectedAmount);
                        processingFeeElement.textContent = `$${processingFee.toFixed(2)}`;
                        updateTotalDisplay();
                    }
                }

                function calculateTotal() {
                    const baseAmount = selectedAmount;
                    const tipAmount = (baseAmount * tipPercentage) / 100;
                    const processingFee = calculateProcessingFee(baseAmount);
                    return baseAmount + tipAmount + processingFee;
                }

                function updateTotalDisplay() {
                    const totalElement = safelyGetElement('totalAmount');
                    if (totalElement) {
                        const total = calculateTotal();
                        totalElement.textContent = `$${total.toFixed(2)}`;
                    }
                }

                // Initialize amount buttons
                document.querySelectorAll('.amount-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        // Remove active class from all buttons
                        document.querySelectorAll('.amount-btn').forEach(btn => {
                            safelyToggleClass(btn, 'bg-[#B08D57]', false);
                            safelyToggleClass(btn, 'text-white', false);
                            btn.classList.add('border-gray-300', 'hover:border-[#B08D57]');
                        });

                        // Add active class to clicked button
                        this.classList.add('bg-[#B08D57]', 'text-white');
                        this.classList.remove('border-gray-300', 'hover:border-[#B08D57]');

                        // Update selected amount
                        selectedAmount = parseFloat(this.dataset.amount);
                        updateTotalDisplay();
                    });
                });

                // Initialize tip select
                const tipSelect = safelyGetElement('tipSelect');
                if (tipSelect) {
                    tipSelect.addEventListener('change', function() {
                        tipPercentage = parseFloat(this.value);
                        updateTotalDisplay();
                    });
                }

                function showMessage(messageText) {
                    const messageContainer = safelyGetElement('payment-message');
                    if (messageContainer) {
                        messageContainer.classList.remove('hidden');
                        messageContainer.textContent = messageText;

                        setTimeout(() => {
                            messageContainer.classList.add('hidden');
                            messageContainer.textContent = '';
                        }, 4000);
                    }
                }

                function setLoading(isLoading) {
                    const submitButton = safelyGetElement('submit-button');
                    const spinner = safelyGetElement('spinner');
                    const buttonText = safelyGetElement('button-text');

                    if (submitButton) {
                        submitButton.disabled = isLoading;
                    }
                    if (spinner) {
                        safelyToggleClass(spinner, 'hidden', !isLoading);
                    }
                    if (buttonText) {
                        safelyToggleClass(buttonText, 'hidden', isLoading);
                    }
                }

                function toggleMessage() {
                    const messageContainer = safelyGetElement('messageContainer');
                    if (messageContainer) {
                        safelyToggleClass(messageContainer, 'hidden');
                    }
                }

                function openDonationOverlay() {
                    const overlay = safelyGetElement('donationOverlay');
                    if (overlay) {
                        overlay.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }
                }

                function closeDonationOverlay() {
                    const overlay = safelyGetElement('donationOverlay');
                    if (overlay) {
                        overlay.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                        showMainForm();
                    }
                }

                function validateFinalDetails() {
                    const paymentMethod = safelyGetElement('paymentMethod');
                    if (!paymentMethod || !paymentMethod.value) {
                        showMessage('Please select a payment method');
                        safelyToggleClass(paymentMethod, 'border-red-500', true);
                        return false;
                    }
                    safelyToggleClass(paymentMethod, 'border-red-500', false);
                    return true;
                }

                function validateDonationForm() {
                    let isValid = true;
                    const errors = {
                        donorName: [],
                        donorEmail: []
                    };

                    const donorNameError = safelyGetElement('donorNameError');
                    const donorEmailError = safelyGetElement('donorEmailError');
                    const donorNameInput = safelyGetElement('donorName');
                    const donorEmailInput = safelyGetElement('donorEmail');

                    // Reset previous errors
                    if (donorNameError) donorNameError.classList.add('hidden');
                    if (donorEmailError) donorEmailError.classList.add('hidden');
                    if (donorNameInput) donorNameInput.classList.remove('border-red-500');
                    if (donorEmailInput) donorEmailInput.classList.remove('border-red-500');

                    // Validate donor name
                    const donorName = donorNameInput ? donorNameInput.value.trim() : '';
                    if (!donorName) {
                        errors.donorName.push('Donor name is required');
                        isValid = false;
                    } else if (donorName.length < 2) {
                        errors.donorName.push('Donor name must be at least 2 characters long');
                        isValid = false;
                    }

                    // Validate donor email
                    const donorEmail = donorEmailInput ? donorEmailInput.value.trim() : '';
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!donorEmail) {
                        errors.donorEmail.push('Email address is required');
                        isValid = false;
                    } else if (!emailRegex.test(donorEmail)) {
                        errors.donorEmail.push('Please enter a valid email address');
                        isValid = false;
                    }

                    // Display errors if any
                    if (!isValid) {
                        if (errors.donorName.length > 0 && donorNameError && donorNameInput) {
                            donorNameError.textContent = errors.donorName[0];
                            donorNameError.classList.remove('hidden');
                            donorNameInput.classList.add('border-red-500');
                        }
                        if (errors.donorEmail.length > 0 && donorEmailError && donorEmailInput) {
                            donorEmailError.textContent = errors.donorEmail[0];
                            donorEmailError.classList.remove('hidden');
                            donorEmailInput.classList.add('border-red-500');
                        }
                    }

                    return isValid;
                }

                function showFinalDetails() {
                    if (validateDonationForm()) {
                        const mainForm = safelyGetElement('mainDonationForm');
                        const finalForm = safelyGetElement('finalDetailsForm');

                        if (mainForm) mainForm.classList.add('hidden');
                        if (finalForm) finalForm.classList.remove('hidden');
                    }
                }

                function showMainForm() {
                    const mainForm = safelyGetElement('mainDonationForm');
                    const finalForm = safelyGetElement('finalDetailsForm');

                    if (finalForm) finalForm.classList.add('hidden');
                    if (mainForm) mainForm.classList.remove('hidden');
                }

                async function handlePayment() {
                    if (!validateFinalDetails()) {
                        return;
                    }

                    showLoading(); // Show loading overlay

                    const total = calculateTotal();
                    const processingFee = calculateProcessingFee(selectedAmount);
                    const tipAmount = (selectedAmount * tipPercentage) / 100;

                    const donationData = {
                        amount: parseFloat(total.toFixed(2)),
                        base_amount: parseFloat(selectedAmount.toFixed(2)),
                        tip_percentage: parseFloat(tipPercentage.toFixed(2)),
                        donor_name: safelyGetElement('donorName')?.value || '',
                        donor_email: safelyGetElement('donorEmail')?.value || '',
                        anonymous: safelyGetElement('anonymous')?.checked || false,
                        allowContact: safelyGetElement('allowContact')?.checked || false,
                        donation_type: donationType,
                        message: safelyGetElement('donationMessage')?.value || '',
                        payment_method: selectedPaymentMethod, // Add the payment method
                        processing_fee: processingFee // Add the processing fee amount
                    };

                    try {
                        const response = await fetch('/donations', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(donationData)
                        });

                        if (!response.ok) {
                            hideLoading(); // Hide loading on error
                            const errorData = await response.json();
                            throw new Error(errorData.errors ? Object.values(errorData.errors).join('\n') : 'Failed to process donation');
                        }

                        const data = await response.json();

                        if (data.url) {
                            window.location.href = data.url;
                        } else {
                            hideLoading(); // Hide loading if no URL
                            throw new Error('No checkout URL received from the server');
                        }
                    } catch (error) {
                        hideLoading(); // Hide loading on any error
                        console.error('Error:', error);
                        showMessage(error.message || 'An unexpected error occurred. Please try again.');
                    }
                }

                function showLoading() {
                    const loadingOverlay = document.getElementById('loadingOverlay');
                    if (loadingOverlay) {
                        loadingOverlay.classList.remove('hidden');
                    }
                }

                function hideLoading() {
                    const loadingOverlay = document.getElementById('loadingOverlay');
                    if (loadingOverlay) {
                        loadingOverlay.classList.add('hidden');
                    }
                }

                // Handle form submission
                const finalForm = document.getElementById('finalForm');
                if (finalForm) {
                    finalForm.addEventListener('submit', async function(e) {
                        e.preventDefault();
                        showLoading();

                        try {
                            // ... existing payment processing code ...

                            if (response.url) {
                                window.location.href = response.url;
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('An error occurred while processing your payment. Please try again.');
                        } finally {
                            hideLoading();
                        }
                    });
                }

                // Set up global function references
                window.openDonationOverlay = openDonationOverlay;
                window.closeDonationOverlay = closeDonationOverlay;
                window.showFinalDetails = showFinalDetails;
                window.showMainForm = showMainForm;
                window.handlePayment = handlePayment;
                window.toggleMessage = toggleMessage;
                window.updateProcessingFee = updateProcessingFee;
            });
        </script>
    </body>
</html>
