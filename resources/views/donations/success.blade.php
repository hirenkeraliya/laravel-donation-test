@extends('layouts.app')

@section('title', 'Thank You')

@section('content')
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <x-message-card
            type="success"
            title="Thank You for Your Support!"
            message="Your generous donation will help further our mission to support worldwide missions."
        >
            @if(session('donation'))
                <x-donation.summary :donation="session('donation')" />
            @endif

            <p class="text-sm text-gray-600 mb-8">
                A receipt has been sent to your email address.
            </p>

            <div class="space-y-4">
                <x-action-button href="/" type="primary">
                    Return to Homepage
                </x-action-button>
            </div>
        </x-message-card>
    </div>
@endsection