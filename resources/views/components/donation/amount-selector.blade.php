@props(['defaultAmount' => 25])

<div
    x-data="{
        selectedAmount: {{ $defaultAmount }},
        customAmount: false,
        updateAmount(amount) {
            this.selectedAmount = amount;
            this.customAmount = false;
            this.$dispatch('amount-changed', { amount });
        }
    }"
    class="space-y-4"
>
    <div class="grid grid-cols-4 gap-2">
        @foreach ([10, 25, 50, 100, 250, 500, 1000] as $amount)
            <button
                type="button"
                @click="updateAmount({{ $amount }})"
                x-bind:class="{
                    'bg-[#B08D57] text-white': selectedAmount === {{ $amount }} && !customAmount,
                    'border-gray-300 hover:border-[#B08D57]': selectedAmount !== {{ $amount }} || customAmount
                }"
                class="px-4 py-2 border rounded-md transition-colors"
                data-amount="{{ $amount }}"
            >
                ${{ number_format($amount) }}
            </button>
        @endforeach
        <button
            type="button"
            @click="customAmount = true; selectedAmount = ''"
            x-bind:class="{
                'bg-[#B08D57] text-white': customAmount,
                'border-gray-300 hover:border-[#B08D57]': !customAmount
            }"
            class="px-4 py-2 border rounded-md transition-colors"
        >
            Other
        </button>
    </div>

    <div x-show="customAmount" class="mt-4">
        <input
            type="number"
            x-model="selectedAmount"
            @input="$dispatch('amount-changed', { amount: $event.target.value })"
            placeholder="Enter custom amount"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:border-[#B08D57] focus:ring-[#B08D57]"
            min="1"
            step="0.01"
            :class="{'border-red-500': $parent.errors && $parent.errors.amount}"
        >
        <p
            x-show="$parent.errors && $parent.errors.amount"
            x-text="$parent.errors.amount"
            class="mt-1 text-sm text-red-500"
        ></p>
    </div>
</div>
