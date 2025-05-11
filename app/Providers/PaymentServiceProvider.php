<?php

namespace App\Providers;

use App\Services\StripePaymentService;
use App\Services\DonationCalculatorService;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(StripePaymentService::class, function ($app) {
            return new StripePaymentService(
                config('services.stripe.secret'),
                config('services.stripe.webhook.secret')
            );
        });

        $this->app->singleton(DonationCalculatorService::class);
    }

    public function boot(): void
    {
        //
    }
}
