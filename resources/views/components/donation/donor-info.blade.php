@props(['errors' => []])

<div class="space-y-4">
    <div>
        <input
            type="text"
            x-model="donorName"
            placeholder="Donor's Name"
            class="block w-full px-3 py-2 border rounded-md shadow-sm focus:border-[#B08D57] focus:ring-[#B08D57]"
            :class="{ 'border-red-500': errors.donorName }"
        >
        <p x-show="errors.donorName" x-text="errors.donorName" class="mt-1 text-sm text-red-500"></p>
    </div>

    <div>
        <input
            type="email"
            x-model="donorEmail"
            placeholder="Donor's Email"
            class="block w-full px-3 py-2 border rounded-md shadow-sm focus:border-[#B08D57] focus:ring-[#B08D57]"
            :class="{ 'border-red-500': errors.donorEmail }"
        >
        <p x-show="errors.donorEmail" x-text="errors.donorEmail" class="mt-1 text-sm text-red-500"></p>
    </div>

    <div x-data="{ showMessage: false }">
        <button
            @click="showMessage = !showMessage"
            type="button"
            class="text-[#B08D57] hover:text-[#96784A] text-sm font-medium inline-flex items-center"
        >
            <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"/>
            </svg>
            Add a message
        </button>

        <div x-show="showMessage" class="mt-2">
            <textarea
                x-model="message"
                placeholder="Your message (optional)"
                rows="3"
                class="block w-full px-3 py-2 border rounded-md shadow-sm resize-none focus:border-[#B08D57] focus:ring-[#B08D57]"
            ></textarea>
        </div>
    </div>

    <div class="flex items-center space-y-2">
        <input
            type="checkbox"
            x-model="anonymous"
            id="anonymous"
            class="rounded border-gray-300 text-[#B08D57] focus:ring-[#B08D57]"
        >
        <label for="anonymous" class="ml-2 text-sm text-gray-600">
            Stay Anonymous
        </label>
    </div>

    <div class="flex items-center space-y-2">
        <input
            type="checkbox"
            x-model="allowContact"
            id="allowContact"
            class="rounded border-gray-300 text-[#B08D57] focus:ring-[#B08D57]"
        >
        <label for="allowContact" class="ml-2 text-sm text-gray-600">
            Allow Night Bright Inc to contact me
        </label>
    </div>
</div>
