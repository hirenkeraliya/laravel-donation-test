@props(['stripeKey'])

<div x-data="{
    stripeInstance: null,
    amount: 0,
    customAmount: false,
    tipPercentage: 12,
    processing: false,
}" x-init="
    stripeInstance = Stripe('{{ $stripeKey }}');
">
    <div
        id="donationOverlay"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity hidden"
        aria-hidden="true">
        <div class="fixed inset-y-0 left-0 pr-10 max-w-md w-full">
            <div class="bg-white h-full overflow-y-auto">
                <x-donation.form />
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div
        id="loadingOverlay"
        class="absolute inset-0 bg-white bg-opacity-95 z-50 hidden flex flex-col items-center justify-center">
        <div class="text-center">
            <x-donation.loading-spinner />
            <span class="text-xl font-medium text-gray-700">LOADING</span>
        </div>
    </div>

    <!-- Error Message -->
    <div
        id="payment-message"
        class="hidden fixed bottom-4 right-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-md z-50">
    </div>
</div>

@push('scripts')
    @include('partials.donation-scripts')
@endpush
