@props(['paymentTypes', 'donationTypes', 'stripeKey'])

<div x-data="{
    step: 1,
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
    errors: {},

    async submitDonation() {
        if (this.validateForm()) {
            const donationData = {
                stripeKey: '{{ $stripeKey }}',
                donationType: this.donationType,
                amount: this.customAmount ? this.amount : this.selectedAmount,
                tipPercentage: this.tipPercentage,
                donorName: this.donorName,
                donorEmail: this.donorEmail,
                message: this.message,
                anonymous: this.anonymous,
                allowContact: this.allowContact,
                paymentMethod: this.paymentMethod,
                processingFee: this.processingFee
            };

            const result = await window.donationPayment.handlePayment(donationData);

            if (result.success) {
                this.step = 3; // Success step
            } else {
                // Handle error
                this.errors = { payment: result.error };
            }
        }
    },

    validateForm() {
        this.errors = {};
        let isValid = true;

        if (!this.donorName) {
            this.errors.donorName = 'Donor name is required';
            isValid = false;
        }

        if (!this.donorEmail) {
            this.errors.donorEmail = 'Email is required';
            isValid = false;
        } else if (!this.donorEmail.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            this.errors.donorEmail = 'Please enter a valid email address';
            isValid = false;
        }

        if (!this.amount && !this.selectedAmount) {
            this.errors.amount = 'Please select or enter a donation amount';
            isValid = false;
        }

        if (!this.paymentMethod) {
            this.errors.paymentMethod = 'Please select a payment method';
            isValid = false;
        }

        return isValid;
    }
}"
x-init="
    $watch('paymentMethod', value => {
        if (value && amount) {
            updateProcessingFee();
        }
    });
    $watch('amount', value => {
        if (value && paymentMethod) {
            updateProcessingFee();
        }
    });"
>
    <!-- Step 1: Initial Form -->
    <div x-show="step === 1" class="space-y-6">
        <h2 class="text-xl font-semibold mb-6">Make a Donation</h2>

        <!-- Donation Type Toggle -->
        <div class="flex rounded-md shadow-sm mb-6">
            @foreach($donationTypes as $type)
                <button
                    type="button"
                    @click="donationType = '{{ $type->value }}'"
                    x-bind:class="{
                        'bg-[#B08D57] text-white': donationType === '{{ $type->value }}',
                        'bg-white text-gray-700': donationType !== '{{ $type->value }}'
                    }"
                    class="flex-1 px-4 py-2 border transition-colors"
                    :class="{'rounded-l-md': $first, 'rounded-r-md': $last}"
                >
                    {{ \App\Enums\DonationType::getLabel($type) }}
                </button>
            @endforeach
        </div>

        <!-- Amount Selection -->
        <x-donation.amount-selector />

        <!-- Donor Information -->
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <input
                        type="text"
                        x-model="donorName"
                        placeholder="Donor's Name"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#C49052] focus:ring-[#C49052]"
                        :class="{'border-red-500': errors.donorName}"
                    >
                    <p x-show="errors.donorName" x-text="errors.donorName" class="mt-1 text-sm text-red-500"></p>
                </div>
                <div>
                    <input
                        type="email"
                        x-model="donorEmail"
                        placeholder="Donor's Email"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#C49052] focus:ring-[#C49052]"
                        :class="{'border-red-500': errors.donorEmail}"
                    >
                    <p x-show="errors.donorEmail" x-text="errors.donorEmail" class="mt-1 text-sm text-red-500"></p>
                </div>
            </div>
        </div>

        <!-- Message -->
        <div class="mb-6">
            <textarea
                x-model="message"
                placeholder="Add a message (optional)"
                rows="3"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#C49052] focus:ring-[#C49052]"
            ></textarea>
        </div>

        <div class="flex justify-between items-center">
            <button
                type="button"
                @click="step = 2"
                class="px-6 py-2 bg-[#B08D57] text-white rounded-md hover:bg-[#C49052] transition-colors"
            >
                Continue to Payment
            </button>
        </div>
    </div>

    <!-- Step 2: Payment -->
    <div x-show="step === 2" class="space-y-6">
        <h2 class="text-xl font-semibold mb-6">Payment Details</h2>

        <!-- Payment Element will be mounted here -->
        <div id="payment-element" class="mb-6"></div>

        <!-- Error Message -->
        <div
            id="payment-message"
            class="hidden p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg"
            role="alert"
        ></div>

        <!-- Loading Overlay -->
        <div
            id="loadingOverlay"
            class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
        >
            <div class="bg-white p-4 rounded-lg">
                Processing your donation...
            </div>
        </div>

        <div class="flex justify-between items-center">
            <button
                type="button"
                @click="step = 1"
                class="px-6 py-2 border border-gray-300 rounded-md hover:border-[#B08D57] transition-colors"
            >
                Back
            </button>
            <button
                type="button"
                @click="submitDonation"
                id="submit-payment"
                class="px-6 py-2 bg-[#B08D57] text-white rounded-md hover:bg-[#C49052] transition-colors"
            >
                Complete Donation
            </button>
        </div>
    </div>

    <!-- Step 3: Success -->
    <div x-show="step === 3" class="text-center space-y-6">
        <div class="text-green-600 mb-4">
            <svg class="w-16 h-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-semibold text-gray-900">Thank You for Your Donation!</h2>
        <p class="text-gray-600">
            We've sent a confirmation email to {{ '<span x-text="donorEmail"></span>' }}
        </p>
        <button
            type="button"
            @click="window.location.reload()"
            class="px-6 py-2 bg-[#B08D57] text-white rounded-md hover:bg-[#C49052] transition-colors"
        >
            Make Another Donation
        </button>
    </div>
</div>

@push('scripts')
<script>
    function updateProcessingFee() {
        const amount = Number(this.amount);
        const paymentMethod = this.paymentMethod;

        if (amount && paymentMethod) {
            fetch(`/api/calculate-fees?amount=${amount}&payment_method=${paymentMethod}`)
                .then(response => response.json())
                .then(data => {
                    this.processingFee = data.processing_fee;
                });
        }
    }

    async function submitDonation() {
        try {
            const response = await fetch('/donations', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    amount: this.amount,
                    base_amount: this.amount,
                    tip_percentage: this.tipPercentage,
                    processing_fee: this.processingFee,
                    donor_name: this.donorName,
                    donor_email: this.donorEmail,
                    anonymous: this.anonymous,
                    allow_contact: this.allowContact,
                    payment_method: this.paymentMethod,
                    donation_type: this.donationType,
                    message: this.message
                })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Something went wrong');
            }

            const data = await response.json();
            if (data.url) {
                window.location.href = data.url;
            }
        } catch (error) {
            alert(error.message || 'An error occurred. Please try again.');
        }
    }
</script>
@endpush
