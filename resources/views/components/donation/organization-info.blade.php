@props(['organization'])

<div class="flex items-center justify-between">
    <div class="flex items-center space-x-6">
        <!-- Organization Logo -->
        <div class="flex-shrink-0">
            <img src="{{ asset('images/night-bright-logo.svg') }}" alt="Night Bright Logo" class="h-16 w-16">
        </div>

        <!-- Organization Info -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Night Bright</h1>
            <div class="mt-2 flex items-center space-x-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                    North America
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                    United States
                </span>
            </div>
        </div>
    </div>
</div>
