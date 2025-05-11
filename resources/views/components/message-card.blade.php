@props([
    'type' => 'success',
    'title',
    'message'
])

<div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
    <div class="text-center">
        <!-- Icon -->
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full mb-6 {{ $type === 'success' ? 'bg-green-100' : 'bg-red-100' }}">
            @if($type === 'success')
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            @else
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            @endif
        </div>

        <!-- Title and Message -->
        <h2 class="text-3xl font-bold text-gray-900 mb-4">
            {{ $title }}
        </h2>
        <p class="text-lg text-gray-600 mb-8">
            {{ $message }}
        </p>

        <!-- Additional Content -->
        {{ $slot }}
    </div>
</div>
