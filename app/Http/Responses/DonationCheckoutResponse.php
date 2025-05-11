<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class DonationCheckoutResponse implements Responsable
{
    public function __construct(
        private readonly string $checkoutUrl,
        private readonly array $additionalData = []
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'url' => $this->checkoutUrl,
            ...$this->additionalData
        ]);
    }
}
