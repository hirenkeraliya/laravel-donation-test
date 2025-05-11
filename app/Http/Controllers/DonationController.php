<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Services\StripePaymentService;
use App\Services\DonationCalculatorService;
use App\Http\Requests\StoreDonationRequest;
use App\Http\Requests\CompleteDonationRequest;
use App\Http\Resources\DonationResource;
use App\Http\Resources\DonationSuccessResource;
use App\Http\Resources\DonationErrorResource;
use App\DTOs\DonationData;
use App\Http\Responses\DonationCheckoutResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function __construct(
        private readonly StripePaymentService $stripeService,
        private readonly DonationCalculatorService $calculatorService
    ) {}


    public function store(StoreDonationRequest $request): JsonResponse|DonationCheckoutResponse
    {
        try {
            $donationData = DonationData::fromRequest($request->validated());

            $donation = new Donation();
            $donation->fill($donationData->toArray());
            $donation->status = Donation::STATUS_PENDING;
            $donation->currency = 'USD';
            $donation->save();

            $result = $this->stripeService->createCheckoutSession($donation);

            return new DonationCheckoutResponse($result['url'], [
                'donation_id' => $donation->id,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                new DonationErrorResource(['message' => $e->getMessage(), 'details' => $e]),
                500
            );
        }
    }

    public function success(): View
    {
        return view('donations.success');
    }

    public function webhook(Request $request): JsonResponse
    {
        try {
            $this->stripeService->handleWebhook(
                $request->getContent(),
                $request->header('Stripe-Signature')
            );
            return response()->json(new DonationSuccessResource(null));
        } catch (\Exception $e) {
            return response()->json(
                new DonationErrorResource(['message' => $e->getMessage()]),
                400
            );
        }
    }


    public function complete(CompleteDonationRequest $request): View
    {
        try {
            $status = $this->stripeService->confirmPayment($request->payment_intent);

            if ($status === 'succeeded') {
                $donation = Donation::where('transaction_id', $request->payment_intent)->firstOrFail();
                session(['donation' => new DonationResource($donation)]);
                return view('donations.success');
            }

            return view('donations.failed');
        } catch (\Exception $e) {
            return view('donations.failed')->with('error', $e->getMessage());
        }
    }

    public function failed(): View
    {
        return view('donations.failed');
    }
}
