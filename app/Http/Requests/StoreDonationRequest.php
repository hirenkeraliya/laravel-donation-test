<?php

namespace App\Http\Requests;

use App\Enums\PaymentType;
use App\Enums\DonationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreDonationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:1',
            'base_amount' => 'required|numeric|min:1',
            'tip_percentage' => 'nullable|numeric|min:0|max:100',
            'processing_fee' => 'required|numeric|min:0',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email',
            'anonymous' => 'boolean',
            'allow_contact' => 'boolean',
            'payment_method' => ['required', new Enum(PaymentType::class)],
            'donation_type' => ['required', new Enum(DonationType::class)],
            'message' => 'nullable|string|max:1000',
        ];
    }
}
