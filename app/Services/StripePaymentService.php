<?php

namespace App\Services;

use App\Models\Donation;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;
use Exception;

class StripePaymentService
{
        public function __construct(
        private readonly string $stripeSecretKey,
        private readonly string $webhookSecret
    ) {
        Stripe::setApiKey($this->stripeSecretKey);
    }

    public function createCheckoutSession(Donation $donation): array
    {
        try {
            $lineItems = $this->buildLineItems($donation);
            $sessionConfig = $this->buildSessionConfig($donation, $lineItems);
            $session = Session::create($sessionConfig);

            return ['url' => $session->url];
        } catch (Exception $e) {
            throw new Exception('Error creating checkout session: ' . $e->getMessage());
        }
    }

    private function buildLineItems(Donation $donation): array
    {
        $lineItems = [
            [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Donation to Night Bright',
                    ],
                    'unit_amount' => (int) ($donation->base_amount * 100),
                ],
                'quantity' => 1,
            ],
            [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Processing Fee',
                        'description' => 'Payment processing fee',
                    ],
                    'unit_amount' => (int) ($donation->processing_fee * 100),
                ],
                'quantity' => 1,
            ]
        ];

        if ($donation->tip_percentage > 0) {
            $tipAmount = $donation->base_amount * ($donation->tip_percentage / 100);
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Tip to Night Bright',
                        'description' => sprintf('%.1f%% platform support', $donation->tip_percentage),
                    ],
                    'unit_amount' => (int) ($tipAmount * 100),
                ],
                'quantity' => 1,
            ];
        }

        return $lineItems;
    }

    private function buildSessionConfig(Donation $donation, array $lineItems): array
    {
        return [
            'payment_method_types' => $this->getPaymentMethodTypes($donation->payment_method),
            'line_items' => $lineItems,
            'metadata' => [
                'donation_id' => $donation->id,
                'donor_email' => $donation->donor_email,
                'donation_type' => $donation->donation_type,
                'message' => $donation->message
            ],
            'mode' => $donation->donation_type === 'monthly' ? 'subscription' : 'payment',
            'success_url' => route('donations.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('donations.failed'),
            'customer_email' => $donation->donor_email
        ];
    }

    private function getPaymentMethodTypes(string $method): array
    {
        return match ($method) {
            'amex', 'card' => ['card'],
            'bank' => ['us_bank_account'],
            'cash' => ['cashapp'],
            default => ['card'],
        };
    }

    public function handleWebhook(string $payload, string $sigHeader): void
    {
        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $this->webhookSecret);

            if ($event->type === 'payment_intent.succeeded') {
                $this->handleSuccessfulPayment($event->data->object);
            }
        } catch (Exception $e) {
            throw new Exception('Webhook error: ' . $e->getMessage());
        }
    }

    private function handleSuccessfulPayment($paymentIntent): void
    {
        if (isset($paymentIntent->metadata['donation_id'])) {
            $donation = Donation::find($paymentIntent->metadata['donation_id']);
            if ($donation) {
                $donation->update([
                    'status' => 'completed',
                    'transaction_id' => $paymentIntent->id
                ]);
            }
        }
    }

    public function confirmPayment(string $paymentIntentId): string
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            $this->updateDonationStatus($paymentIntent);
            return $paymentIntent->status;
        } catch (Exception $e) {
            throw new Exception('Error confirming payment: ' . $e->getMessage());
        }
    }

    private function updateDonationStatus($paymentIntent): void
    {
        if (isset($paymentIntent->metadata['donation_id'])) {
            $donation = Donation::find($paymentIntent->metadata['donation_id']);
            if ($donation) {
                $donation->update([
                    'status' => $paymentIntent->status,
                    'transaction_id' => $paymentIntent->id,
                    'payment_method' => $paymentIntent->payment_method_types[0] ?? 'card'
                ]);
            }
        }
    }
}
