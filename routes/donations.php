<?php

use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Route;

Route::prefix('donations')->name('donations.')->group(function () {
    Route::post('/', [DonationController::class, 'store'])->name('store');
    Route::get('/success', [DonationController::class, 'success'])->name('success');
    Route::get('/failed', [DonationController::class, 'failed'])->name('failed');
    Route::get('/complete', [DonationController::class, 'complete'])->name('complete');
});

Route::post('/webhook/stripe', [DonationController::class, 'webhook'])->name('stripe.webhook');
