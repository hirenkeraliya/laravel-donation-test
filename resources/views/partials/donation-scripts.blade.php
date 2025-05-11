// Stripe Initialize
const stripe = Stripe("{{ config('services.stripe.key') }}");

// Helper Functions
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
    const rates = {
        amex: 0.0392,
        card: 0.0368,
        bank: 0.0088,
        cash: 0.0444
    };
    const rate = rates[selectedPaymentMethod] || 0;
    return parseFloat((amount * rate).toFixed(2));
}

// Loading State Management
function showLoading() {
    const loadingOverlay = safelyGetElement('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.classList.remove('hidden');
    }
}

function hideLoading() {
    const loadingOverlay = safelyGetElement('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.classList.add('hidden');
    }
}

// Message Display
function showMessage(message, type = 'error') {
    const messageContainer = safelyGetElement('payment-message');
    if (messageContainer) {
        messageContainer.textContent = message;
        messageContainer.classList.remove('hidden');

        setTimeout(() => {
            messageContainer.classList.add('hidden');
            messageContainer.textContent = '';
        }, 4000);
    }
}

// Form State Management
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
