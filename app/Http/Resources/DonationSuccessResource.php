<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DonationSuccessResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'status' => 'success',
            'donation' => new DonationResource($this->resource),
            'message' => 'Donation processed successfully',
        ];
    }
}
