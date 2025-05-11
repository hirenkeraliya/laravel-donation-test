export class DonationOverlayManager {
    constructor() {
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        // Add event listener for overlay close button
        const closeButton = document.querySelector('[data-close-overlay]');
        if (closeButton) {
            closeButton.addEventListener('click', () => this.closeOverlay());
        }

        // Add event listener for opening overlay
        const openButton = document.querySelector('[data-open-overlay]');
        if (openButton) {
            openButton.addEventListener('click', () => this.openOverlay());
        }
    }

    openOverlay() {
        const overlay = this.getElement('donationOverlay');
        if (overlay) {
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    closeOverlay() {
        const overlay = this.getElement('donationOverlay');
        if (overlay) {
            overlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
            this.showMainForm();
        }
    }

    showMainForm() {
        const mainForm = this.getElement('mainDonationForm');
        const finalForm = this.getElement('finalDetailsForm');

        if (finalForm) finalForm.classList.add('hidden');
        if (mainForm) mainForm.classList.remove('hidden');
    }

    showFinalDetails() {
        if (this.validateDonationForm()) {
            const mainForm = this.getElement('mainDonationForm');
            const finalForm = this.getElement('finalDetailsForm');

            if (mainForm) mainForm.classList.add('hidden');
            if (finalForm) finalForm.classList.remove('hidden');
        }
    }

    validateDonationForm() {
        let isValid = true;
        const errors = {
            donorName: [],
            donorEmail: []
        };

        const donorNameError = this.getElement('donorNameError');
        const donorEmailError = this.getElement('donorEmailError');
        const donorNameInput = this.getElement('donorName');
        const donorEmailInput = this.getElement('donorEmail');

        // Reset previous errors
        [donorNameError, donorEmailError].forEach(error => {
            if (error) error.classList.add('hidden');
        });
        [donorNameInput, donorEmailInput].forEach(input => {
            if (input) input.classList.remove('border-red-500');
        });

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
            this.showValidationErrors(errors, {
                donorNameError,
                donorEmailError,
                donorNameInput,
                donorEmailInput
            });
        }

        return isValid;
    }

    showValidationErrors(errors, elements) {
        const { donorNameError, donorEmailError, donorNameInput, donorEmailInput } = elements;

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

    getElement(id) {
        const element = document.getElementById(id);
        if (!element) {
            console.warn(`Element with id '${id}' not found`);
        }
        return element;
    }
}

// Initialize when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.donationOverlay = new DonationOverlayManager();
});
