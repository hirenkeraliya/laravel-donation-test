import './bootstrap';
import Alpine from 'alpinejs';

import { DonationFormManager } from './donation-form';
import { DonationOverlayManager } from './donation-overlay';
import { DonationPaymentManager } from './donation-payment';

window.Alpine = Alpine;
Alpine.start();

// Initialize donation modules
window.donationForm = new DonationFormManager();
window.donationOverlay = new DonationOverlayManager();
window.donationPayment = new DonationPaymentManager();
