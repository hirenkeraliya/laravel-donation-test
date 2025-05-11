@props(['show' => false])

<div
    id="loadingOverlay"
    class="absolute inset-0 bg-white bg-opacity-95 z-50 flex flex-col items-center justify-center {{ $show ? '' : 'hidden' }}"
>
    <div class="text-center">
        <div class="flex items-center justify-center mb-4">
            <div class="animate-bounce mx-1 h-3 w-3 bg-[#B08D57] rounded-full"></div>
            <div class="animate-bounce mx-1 h-3 w-3 bg-[#B08D57] rounded-full" style="animation-delay: 0.2s"></div>
            <div class="animate-bounce mx-1 h-3 w-3 bg-[#B08D57] rounded-full" style="animation-delay: 0.4s"></div>
        </div>
        <span class="text-xl font-medium text-gray-700">LOADING</span>
    </div>
</div>
