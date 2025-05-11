<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DonationErrorResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'status' => 'error',
            'message' => $this->resource['message'] ?? 'An error occurred while processing the donation',
            'error_details' => $this->when(
                config('app.debug'),
                $this->resource['details'] ?? null
            ),
        ];
    }
}
