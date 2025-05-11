<?php

namespace App\DTOs;

use App\Enums\PaymentType;
use App\Enums\DonationType;

class DonationData
{
    public function __construct(
        public readonly float $amount,
        public readonly float $baseAmount,
        public readonly float $tipPercentage,
        public readonly float $processingFee,
        public readonly string $donorName,
        public readonly string $donorEmail,
        public readonly bool $anonymous,
        public readonly bool $allowContact,
        public readonly PaymentType $paymentMethod,
        public readonly DonationType $donationType,
        public readonly ?string $message = null,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            amount: (float) $data['amount'],
            baseAmount: (float) $data['base_amount'],
            tipPercentage: (float) ($data['tip_percentage'] ?? 0),
            processingFee: (float) $data['processing_fee'],
            donorName: $data['donor_name'],
            donorEmail: $data['donor_email'],
            anonymous: (bool) ($data['anonymous'] ?? false),
            allowContact: (bool) ($data['allow_contact'] ?? false),
            paymentMethod: PaymentType::from($data['payment_method']),
            donationType: DonationType::from($data['donation_type']),
            message: $data['message'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'base_amount' => $this->baseAmount,
            'tip_percentage' => $this->tipPercentage,
            'processing_fee' => $this->processingFee,
            'donor_name' => $this->donorName,
            'donor_email' => $this->donorEmail,
            'anonymous' => $this->anonymous,
            'allow_contact' => $this->allowContact,
            'payment_method' => $this->paymentMethod->value,
            'donation_type' => $this->donationType->value,
            'message' => $this->message,
        ];
    }
}
