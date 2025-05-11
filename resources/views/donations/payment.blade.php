<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Donation</title>
    <script src="https://js.stripe.com/v3/"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-xl shadow-lg">
            <div class="text-center">
                <img src="/images/heart-icon.svg" alt="Heart Icon" class="mx-auto h-12 w-12">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Complete Your Donation</h2>
                <p class="mt-2 text-sm text-gray-600">Amount: ${{ number_format($donation->amount, 2) }}</p>
            </div>

            <div class="mt-8">
                <form id="payment-form" class="space-y-6">
                    <div>
                        <label for="card-element" class="block text-sm font-medium text-gray-700">
                            Credit or debit card
                        </label>
                        <div id="card-element" class="mt-1 p-3 border border-gray-300 rounded-md">
                            <!-- Stripe Elements will be inserted here -->
                        </div>
                        <div id="card-errors" class="mt-2 text-sm text-red-600" role="alert"></div>
                    </div>

                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Complete Donation
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const stripe = Stripe('{{ $stripeKey }}');
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        const form = document.getElementById('payment-form');
        const errorElement = document.getElementById('card-errors');

        card.addEventListener('change', function(event) {
            if (event.error) {
                errorElement.textContent = event.error.message;
            } else {
                errorElement.textContent = '';
            }
        });

        form.addEventListener('submit', async function(event) {
            event.preventDefault();
            const button = form.querySelector('button');
            button.disabled = true;
            button.textContent = 'Processing...';

            try {
                const { paymentIntent, error } = await stripe.confirmCardPayment('{{ $clientSecret }}', {
                    payment_method: {
                        card: card,
                        billing_details: {
                            name: '{{ $donation->donor_name }}',
                            email: '{{ $donation->donor_email }}'
                        }
                    }
                });

                if (error) {
                    errorElement.textContent = error.message;
                    button.disabled = false;
                    button.textContent = 'Complete Donation';
                } else if (paymentIntent.status === 'succeeded') {
                    window.location.href = '{{ route('donations.success') }}';
                }
            } catch (err) {
                errorElement.textContent = 'An unexpected error occurred. Please try again.';
                button.disabled = false;
                button.textContent = 'Complete Donation';
            }
        });
    </script>
</body>
</html>