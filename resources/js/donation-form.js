const paymentMethods = {
    amex: 0.0392,
    card: 0.0368,
    bank: 0.0088,
    cash: 0.0444
};

export class DonationFormManager {
    constructor() {
        this.selectedAmount = 25.00;
        this.tipPercentage = 12;
        this.donationType = 'one-time';
        this.selectedPaymentMethod = '';
        this.processingFee = 0;
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        this.initializeAmountButtons();
        this.initializeTipSelect();
        this.initializePaymentMethodSelect();
    }

    initializeAmountButtons() {
        document.querySelectorAll('.amount-btn').forEach(button => {
            button.addEventListener('click', () => this.handleAmountSelection(button));
        });
    }

    initializeTipSelect() {
        const tipSelect = this.getElement('tipSelect');
        if (tipSelect) {
            tipSelect.addEventListener('change', () => {
                this.tipPercentage = parseFloat(tipSelect.value);
                this.updateTotalDisplay();
            });
        }
    }

    initializePaymentMethodSelect() {
        const paymentMethodElement = this.getElement('paymentMethod');
        if (paymentMethodElement) {
            paymentMethodElement.addEventListener('change', () => this.updateProcessingFee());
        }
    }

    handleAmountSelection(button) {
        // Remove active class from all buttons
        document.querySelectorAll('.amount-btn').forEach(btn => {
            this.toggleClass(btn, 'bg-[#B08D57]', false);
            this.toggleClass(btn, 'text-white', false);
            btn.classList.add('border-gray-300', 'hover:border-[#B08D57]');
        });

        // Add active class to clicked button
        button.classList.add('bg-[#B08D57]', 'text-white');
        button.classList.remove('border-gray-300', 'hover:border-[#B08D57]');

        // Update selected amount
        this.selectedAmount = parseFloat(button.dataset.amount);
        this.updateTotalDisplay();
    }

    calculateProcessingFee(amount) {
        const rate = paymentMethods[this.selectedPaymentMethod] || 0;
        return parseFloat((amount * rate).toFixed(2));
    }

    updateProcessingFee() {
        const paymentMethodElement = this.getElement('paymentMethod');
        const processingFeeElement = this.getElement('processingFee');

        if (paymentMethodElement && processingFeeElement) {
            this.selectedPaymentMethod = paymentMethodElement.value;
            this.processingFee = this.calculateProcessingFee(this.selectedAmount);
            processingFeeElement.textContent = `$${this.processingFee.toFixed(2)}`;
            this.updateTotalDisplay();
        }
    }

    calculateTotal() {
        const baseAmount = this.selectedAmount;
        const tipAmount = (baseAmount * this.tipPercentage) / 100;
        return baseAmount + tipAmount + this.processingFee;
    }

    updateTotalDisplay() {
        const totalElement = this.getElement('totalAmount');
        if (totalElement) {
            const total = this.calculateTotal();
            totalElement.textContent = `$${total.toFixed(2)}`;
        }
    }

    getElement(id) {
        const element = document.getElementById(id);
        if (!element) {
            console.warn(`Element with id '${id}' not found`);
        }
        return element;
    }

    toggleClass(element, className, force) {
        if (element && element.classList) {
            element.classList.toggle(className, force);
        }
    }
}

// Initialize when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.donationForm = new DonationFormManager();
});
