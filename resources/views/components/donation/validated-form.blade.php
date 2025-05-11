@props(['paymentTypes', 'donationTypes'])

<div x-data="donationFormValidation()" x-init="initializeForm">
    <!-- Step indicators -->
    <div class="mb-6">
        <div class="flex items-center">
            <div class="flex-1">
                <div class="h-1 bg-gray-200 rounded-full">
                    <div class="h-1 bg-[#B08D57] rounded-full" :style="{ width: step === 1 ? '50%' : '100%' }"></div>
                </div>
            </div>
            <span class="mx-4 text-sm text-gray-500" x-text="'Step ' + step + ' of 2'"></span>
        </div>
    </div>

    <!-- Step 1: Initial Form -->
    <div x-show="step === 1">
        <h2 class="text-xl font-semibold mb-6">Make a Donation</h2>

        <!-- Donation Type -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Donation Type</label>
            <x-donation.type-selector :types="$donationTypes" />
        </div>

        <!-- Amount -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Amount</label>
            <x-donation.amount-selector />
        </div>

        <!-- Donor Information -->
        <div class="space-y-4 mb-6">
            <x-donation.donor-info />
        </div>

        <!-- Continue Button -->
        <x-donation.continue-button />
    </div>

    <!-- Step 2: Payment Details -->
    <div x-show="step === 2">
        <x-donation.payment-details :payment-types="$paymentTypes" />
    </div>
</div>

@push('scripts')
<script>
function donationFormValidation() {
    return {
        step: 1,
        errors: {},
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

        validateStep1() {
            this.errors = {};

            if (!this.donorName.trim()) {
                this.errors.donorName = 'Donor name is required';
            }

            if (!this.donorEmail.trim()) {
                this.errors.donorEmail = 'Email is required';
            } else if (!this.isValidEmail(this.donorEmail)) {
                this.errors.donorEmail = 'Please enter a valid email';
            }

            if (!this.amount) {
                this.errors.amount = 'Please select or enter an amount';
            }

            return Object.keys(this.errors).length === 0;
        },

        isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        },

        goToStep2() {
            if (this.validateStep1()) {
                this.step = 2;
            }
        },

        async submitDonation() {
            if (!this.paymentMethod) {
                this.errors.paymentMethod = 'Please select a payment method';
                return;
            }

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

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Failed to process donation');
                }

                if (data.url) {
                    window.location.href = data.url;
                }
            } catch (error) {
                console.error('Error:', error);
                this.errors.submission = error.message;
            }
        }
    }
}
</script>
@endpush
