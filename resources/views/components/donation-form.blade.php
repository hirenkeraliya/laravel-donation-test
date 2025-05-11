@props(['step' => 1])

<div x-data="{
    step: {{ $step }},
    donationType: 'one-time',
    amount: '',
    customAmount: false,
    tip: '12',
    donorName: '',
    donorEmail: '',
    message: '',
    anonymous: false,
    allowContact: false,
}">
    <!-- Amount Selection -->
    <div class="grid grid-cols-4 gap-2 mb-6">
        <template x-for="amount in ['10$', '25$', '50$', '100$', '250$', '500$', '1000$', 'Other']">
            <button
                @click="customAmount = amount === 'Other'; if(!customAmount) amount = amount.replace('$', '')"
                :class="{'bg-[#C49052] text-white': !customAmount && amount === $el.innerText.replace('$', '')}"
                class="py-2 px-4 rounded border hover:bg-[#C49052] hover:text-white transition-colors"
                x-text="amount"
            ></button>
        </template>
    </div>

    <!-- Custom Amount Input -->
    <div x-show="customAmount" class="mb-6">
        <input
            type="number"
            placeholder="Enter amount"
            x-model="amount"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#C49052] focus:ring-[#C49052]"
        >
    </div>

    <!-- Donor Information -->
    <div class="space-y-4 mb-6">
        <div class="grid grid-cols-2 gap-4">
            <input
                type="text"
                placeholder="Donor's Name"
                x-model="donorName"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#C49052] focus:ring-[#C49052]"
            >
            <input
                type="email"
                placeholder="Donor's Email"
                x-model="donorEmail"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#C49052] focus:ring-[#C49052]"
            >
        </div>
    </div>

    <!-- Message -->
    <div class="mb-6">
        <textarea
            placeholder="+ Add a message"
            x-model="message"
            rows="3"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#C49052] focus:ring-[#C49052]"
        ></textarea>
    </div>

    <!-- Anonymous Toggle -->
    <div class="flex items-center mb-6">
        <input
            type="checkbox"
            id="anonymous"
            x-model="anonymous"
            class="rounded border-gray-300 text-[#C49052] focus:ring-[#C49052]"
        >
        <label for="anonymous" class="ml-2 text-sm text-gray-600">Stay Anonymous</label>
    </div>

    <!-- Contact Permission -->
    <div class="flex items-center mb-6">
        <input
            type="checkbox"
            id="contact-permission"
            x-model="allowContact"
            class="rounded border-gray-300 text-[#C49052] focus:ring-[#C49052]"
        >
        <label for="contact-permission" class="ml-2 text-sm text-gray-600">Allow Night Bright Inc to contact me</label>
    </div>

    <!-- Submit Button -->
    <button
        @click="$dispatch('submit-donation')"
        :disabled="!amount || !donorName || !donorEmail"
        class="w-full py-2 px-4 bg-[#C49052] text-white rounded-md hover:bg-[#B37F3C] focus:outline-none focus:ring-2 focus:ring-[#C49052] focus:ring-offset-2 disabled:opacity-50"
    >
        <span x-text="'Continue ($' + (Number(amount) + (Number(amount) * (Number(tip)/100))).toFixed(2) + ')'"></span>
    </button>
</div>
