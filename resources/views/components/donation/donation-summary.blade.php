@props(['baseAmount', 'processingFee' => 0, 'tipPercentage' => 12])

<div class="space-y-6">
    <div class="flex justify-between items-center">
        <span class="text-gray-600">Donation</span>
        <span class="font-medium">${{ number_format($baseAmount, 2) }}</span>
    </div>

    <x-donation.payment-selector />

    <!-- Tip Section -->
    <x-donation.tip-section :rate="$tipPercentage" />

    <!-- Total -->
    <div class="border-t pt-4 space-y-2">
        <div class="flex justify-between">
            <span>Base Amount:</span>
            <span>${{ number_format($baseAmount, 2) }}</span>
        </div>
        <div class="flex justify-between">
            <span>Processing Fee:</span>
            <span>${{ number_format($processingFee, 2) }}</span>
        </div>
        @if($tipPercentage > 0)
            <div class="flex justify-between">
                <span>Tip ({{ $tipPercentage }}%):</span>
                <span>${{ number_format($baseAmount * $tipPercentage / 100, 2) }}</span>
            </div>
        @endif
        <div class="flex justify-between font-semibold">
            <span>Total:</span>
            <span>${{ number_format($baseAmount + $processingFee + ($baseAmount * $tipPercentage / 100), 2) }}</span>
        </div>
    </div>
</div>
