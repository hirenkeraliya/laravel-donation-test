# Laravel Donation System For Test

A modern donation processing system built with Laravel 11, featuring Stripe integration, real-time processing fee calculation, and a beautiful responsive UI.

## Features

- 💳 Stripe Payment Integration
- 🧮 Real-time Processing Fee Calculation
- 📱 Responsive Design
- 🎨 Modern UI with Tailwind CSS

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- MySQL 8.0+
- Stripe Account with API Keys

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd strip.local
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your `.env` file with:
   - Database credentials
   - Stripe API keys (STRIPE_KEY and STRIPE_SECRET)

7. Run database migrations:
```bash
php artisan migrate
```

8. Build assets:
```bash
npm run build
```

9. Start the development server:
```bash
php artisan serve
```

## Usage

1. Visit `http://localhost:8000` in your browser
2. Click on "Donate Now" to start the donation process
3. Fill in the donation form with:
   - Donation amount
   - Donor information
   - Payment details
4. Complete the payment using test card details

## Stripe Test Cards

Use these test card numbers for development:

- Visa: 4242 4242 4242 4242
- Mastercard: 5555 5555 5555 4444
- American Express: 3782 822463 10005

Other test card numbers can be found in the [Stripe documentation](https://stripe.com/docs/testing#cards).