@props(['selectedMethod' => ''])

<div class="space-y-4">
    <span class="text-gray-600 block">Credit card processing fees</span>
    <div class="flex justify-between items-center">
        <select
            id="paymentMethod"
            onchange="updateProcessingFee()"
            class="w-48 border border-gray-300 rounded-md px-3 py-2 mb-2 text-sm bg-white focus:border-[#B08D57] focus:ring-[#B08D57]"
        >
            <option value="">Select Payment Method</option>
            <option value="amex" @selected($selectedMethod === 'amex')>AMEX Card</option>
            <option value="card" @selected($selectedMethod === 'card')>Visa & Others</option>
            <option value="bank" @selected($selectedMethod === 'bank')>US Bank Account</option>
            <option value="cash" @selected($selectedMethod === 'cash')>Cash App Pay</option>
        </select>
        <span id="processingFee" class="block text-sm font-medium">$0.00</span>
    </div>
    <p class="text-sm text-gray-500">
        You pay the CC fee so 100% of your donation goes to your chosen missionary or cause.
    </p>
</div>
