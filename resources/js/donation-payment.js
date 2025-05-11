export class DonationPaymentManager {
    constructor() {
        this.stripeInstance = null;
        this.elements = null;
        this.paymentElement = null;
    }

    async initialize(stripeKey, clientSecret) {
        this.stripeInstance = Stripe(stripeKey);

        this.elements = this.stripeInstance.elements({
            clientSecret,
            appearance: {
                theme: 'stripe',
                variables: {
                    colorPrimary: '#B08D57'
                }
            }
        });

        this.paymentElement = this.elements.create('payment');
        const paymentElementContainer = document.getElementById('payment-element');
        if (paymentElementContainer) {
            this.paymentElement.mount(paymentElementContainer);
        }
    }

    async createPaymentIntent(donationData) {
        try {
            const response = await fetch('/donations/create-intent', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(donationData)
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Failed to create payment intent');
            }

            const { clientSecret } = await response.json();
            return clientSecret;
        } catch (error) {
            console.error('Payment Intent Creation Error:', error);
            throw error;
        }
    }

    async handlePayment(donationData) {
        try {
            this.toggleLoadingState(true);

            const clientSecret = await this.createPaymentIntent(donationData);
            await this.initialize(donationData.stripeKey, clientSecret);

            const { error: submitError } = await this.stripeInstance.confirmPayment({
                elements: this.elements,
                confirmParams: {
                    return_url: `${window.location.origin}/donations/confirm`,
                    payment_method_data: {
                        billing_details: {
                            name: donationData.donorName,
                            email: donationData.donorEmail
                        }
                    }
                }
            });

            if (submitError) {
                throw submitError;
            }

            return { success: true };

        } catch (error) {
            this.showMessage(error.message);
            return { success: false, error: error.message };
        } finally {
            this.toggleLoadingState(false);
        }
    }

    showMessage(message, type = 'error') {
        const messageContainer = document.getElementById('payment-message');
        if (messageContainer) {
            messageContainer.textContent = message;
            messageContainer.className = `payment-message ${type}`;
            messageContainer.classList.remove('hidden');

            setTimeout(() => {
                messageContainer.classList.add('hidden');
                messageContainer.textContent = '';
            }, 4000);
        }
    }

    toggleLoadingState(isLoading) {
        const loadingOverlay = document.getElementById('loadingOverlay');
        const submitButton = document.getElementById('submit-payment');

        if (loadingOverlay) {
            loadingOverlay.classList.toggle('hidden', !isLoading);
        }

        if (submitButton) {
            submitButton.disabled = isLoading;
            submitButton.textContent = isLoading ? 'Processing...' : 'Complete Donation';
        }
    }
}

// Initialize when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.donationPayment = new DonationPaymentManager();
});
