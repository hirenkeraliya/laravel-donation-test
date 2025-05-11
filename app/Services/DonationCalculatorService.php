<?php

namespace App\Services;

use App\Models\Donation;
use App\Enums\PaymentType;

class DonationCalculatorService
{
    public function calculateProcessingFee(float $amount, PaymentType $paymentType): float
    {
        $percentage = PaymentType::getProcessingFeePercentage($paymentType);
        $flatFee = PaymentType::getFlatFee($paymentType);

        return ($amount * ($percentage / 100)) + $flatFee;
    }

    public function calculateTipAmount(float $baseAmount, float $tipPercentage): float
    {
        return $baseAmount * ($tipPercentage / 100);
    }

    public function calculateTotalAmount(float $baseAmount, float $processingFee, float $tipPercentage): float
    {
        $tipAmount = $this->calculateTipAmount($baseAmount, $tipPercentage);
        return $baseAmount + $processingFee + $tipAmount;
    }

    public function calculateDonationBreakdown(float $baseAmount, float $tipPercentage, PaymentType $paymentType): array
    {
        $processingFee = $this->calculateProcessingFee($baseAmount, $paymentType);
        $tipAmount = $this->calculateTipAmount($baseAmount, $tipPercentage);
        $totalAmount = $this->calculateTotalAmount($baseAmount, $processingFee, $tipPercentage);

        return [
            'base_amount' => $baseAmount,
            'processing_fee' => $processingFee,
            'tip_amount' => $tipAmount,
            'total_amount' => $totalAmount,
            'tip_percentage' => $tipPercentage,
        ];
    }
}
