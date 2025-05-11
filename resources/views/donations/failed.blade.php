@extends('layouts.app')

@section('title', 'Payment Failed')

@section('content')

    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <x-message-card
            type="error"
            title="Payment Failed"
            message="We were unable to process your donation at this time."
        >
            @if(isset($error))
                <div class="bg-red-50 border border-red-100 rounded-lg p-4 mb-8">
                    <p class="text-red-800">{{ $error }}</p>
                </div>
            @endif

            <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                <h3 class="text-lg font-medium text-gray-900 mb-4">What can you do?</h3>
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Try the donation process again
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Contact our support team at support@nightbright.org
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Check your payment method and try again
                    </li>
                </ul>
            </div>

            <div class="space-y-4">
                <x-action-button
                    href="/"
                    onClick="window.history.back(); return false;"
                    type="primary"
                >
                    Try Again
                </x-action-button>

                <x-action-button href="/" type="secondary">
                    Return to Homepage
                </x-action-button>
            </div>
        </x-message-card>
    </div>
@endsection
