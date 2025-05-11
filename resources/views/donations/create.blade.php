@extends('layouts.app')

@section('title', 'Donate')

@section('content')
    <!-- Main Content -->
    <main class="pt-20 bg-gray-50 min-h-screen">
        <!-- Back Button -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <button onclick="history.back()" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back
            </button>

            <div class="mt-4 bg-white rounded-lg p-6 shadow-sm">
                <div class="flex justify-between items-center">
                    <x-donation.organization-info />

                    <!-- Donate Button -->
                    <button
                        data-open-overlay
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#B08D57] hover:bg-[#96784A] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#B08D57]"
                    >
                        Donate
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div id="payment-message" class="hidden fixed bottom-4 right-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-md z-50"></div>

        <!-- Donation Overlay -->
        <div id="donationOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity hidden" aria-hidden="true">
            <div class="fixed inset-y-0 left-0 pr-10 max-w-md w-full">
                <div class="bg-white h-full overflow-y-auto">
                    <!-- Main Form -->
                    <div id="mainDonationForm" class="p-6" x-data="{
                        donationType: 'one-time',
                        amount: 25,
                        customAmount: false,
                        tipPercentage: 12,
                        errors: {}
                    }">
                        <!-- Header -->
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-semibold text-[#C4996C]">DONATE</h2>
                            <button data-close-overlay class="text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Donation Type -->
                        <div class="flex rounded-md shadow-sm mb-6">
                            <button
                                @click="donationType = 'one-time'"
                                :class="{ 'bg-[#B08D57] text-white': donationType === 'one-time', 'bg-white text-gray-700': donationType !== 'one-time' }"
                                class="flex-1 px-4 py-2 font-medium rounded-l-md transition-colors"
                            >
                                One-Time
                            </button>
                            <button
                                @click="donationType = 'monthly'"
                                :class="{ 'bg-[#B08D57] text-white': donationType === 'monthly', 'bg-white text-gray-700': donationType !== 'monthly' }"
                                class="flex-1 px-4 py-2 font-medium rounded-r-md border border-gray-300 transition-colors"
                            >
                                Monthly
                            </button>
                        </div>

                        <!-- Donor Information -->
                        <x-donation.donor-info />

                        <!-- Amount Selection -->
                        <x-donation.amount-selector :defaultAmount="25" />

                        <!-- Message Option -->
                        <div class="mt-4">
                            <button @click="showMessage = !showMessage" class="text-[#B08D57] hover:text-[#96784A] text-sm font-medium inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                                Add a message
                            </button>
                            <div x-show="showMessage" class="mt-2">
                                <textarea
                                    x-model="message"
                                    placeholder="Your message (optional)"
                                    rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md resize-none focus:border-[#B08D57] focus:ring-[#B08D57]"
                                ></textarea>
                            </div>
                        </div>

                        <!-- Continue Button -->
                        <button
                            @click="validateAndContinue"
                            class="w-full mt-6 px-4 py-2 bg-[#B08D57] text-white font-medium rounded-md hover:bg-[#96784A] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#B08D57]"
                        >
                            Continue
                        </button>
                    </div>

                    <!-- Final Details Form -->
                    <div id="finalDetailsForm" class="p-6 hidden">
                        <div class="flex items-center mb-8">
                            <button
                                data-back-to-main
                                class="inline-flex items-center text-gray-500 hover:text-gray-700"
                            >
                                <svg class="w-4 h-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm">Final Details</span>
                            </button>
                        </div>

                        <x-donation.donation-summary :baseAmount="25" />

                        <button
                            onclick="handlePayment()"
                            class="w-full mt-6 px-4 py-3 bg-[#B08D57] text-white font-medium rounded-md hover:bg-[#96784A]"
                        >
                            Complete Donation
                        </button>
                    </div>

                    <!-- Loading Overlay -->
                    <x-donation.loading-overlay />
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    @vite(['resources/js/donation-form.js', 'resources/js/donation-overlay.js', 'resources/js/donation-payment.js'])
    <script>
        // Initialize donation modules
        document.addEventListener('DOMContentLoaded', function() {
            const stripeKey = "{{ config('services.stripe.key') }}";
            window.donationPayment.initialize(stripeKey);
        });
    </script>
@endpush
