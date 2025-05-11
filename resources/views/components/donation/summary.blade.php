@props(['donation'])

<div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Donation Details</h3>
    <dl class="space-y-3">
        <div class="flex justify-between">
            <dt class="text-gray-600">Amount:</dt>
            <dd class="font-medium text-gray-900">${{ $donation->getFormattedAmount() }}</dd>
        </div>
        <div class="flex justify-between">
            <dt class="text-gray-600">Processing Fee:</dt>
            <dd class="font-medium text-gray-900">${{ number_format($donation->processing_fee, 2) }}</dd>
        </div>
        @if($donation->tip_percentage > 0)
            <div class="flex justify-between">
                <dt class="text-gray-600">Platform Support ({{ $donation->getFormattedTipPercentage() }}%):</dt>
                <dd class="font-medium text-gray-900">${{ number_format($donation->amount - $donation->base_amount - $donation->processing_fee, 2) }}</dd>
            </div>
        @endif
        <div class="flex justify-between">
            <dt class="text-gray-600">Date:</dt>
            <dd class="font-medium text-gray-900">{{ $donation->created_at->format('F j, Y') }}</dd>
        </div>
        <div class="flex justify-between">
            <dt class="text-gray-600">Transaction ID:</dt>
            <dd class="font-medium text-gray-900">{{ $donation->transaction_id ?? 'Pending' }}</dd>
        </div>
        @if(!$donation->anonymous)
            <div class="flex justify-between">
                <dt class="text-gray-600">Donor:</dt>
                <dd class="font-medium text-gray-900">{{ $donation->donor_name }}</dd>
            </div>
        @endif
    </dl>
</div>
