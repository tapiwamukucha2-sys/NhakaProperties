@props(['id' => 'password', 'name' => 'password'])

<div class="relative" x-data="{ show: false }">
    <input
        {{ $attributes->merge(['id' => $id, 'name' => $name, 'class' => 'border-gray-300 focus:border-[--forest] focus:ring-[--forest] rounded-md shadow-sm pr-10 w-full']) }}
        :type="show ? 'text' : 'password'"
    >
    <button
        type="button"
        @click="show = !show"
        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
        tabindex="-1"
        aria-label="Toggle password visibility"
    >
        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="12" cy="12" r="3"/>
        </svg>
        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a21 21 0 0 1 5.06-6.06M9.9 4.24A10.4 10.4 0 0 1 12 4c7 0 11 8 11 8a21 21 0 0 1-2.61 3.68M14.12 14.12a3 3 0 1 1-4.24-4.24" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M1 1l22 22" stroke-linecap="round"/>
        </svg>
    </button>
</div>
