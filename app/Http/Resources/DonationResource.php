<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'base_amount' => $this->base_amount,
            'tip_percentage' => $this->tip_percentage,
            'currency' => $this->currency,
            'donor_name' => $this->when(!$this->anonymous, $this->donor_name),
            'donor_email' => $this->when(!$this->anonymous, $this->donor_email),
            'anonymous' => $this->anonymous,
            'allow_contact' => $this->allow_contact,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'transaction_id' => $this->transaction_id,
            'message' => $this->message,
            'donation_type' => $this->donation_type,
            'processing_fee' => $this->processing_fee,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
