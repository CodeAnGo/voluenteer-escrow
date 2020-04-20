<div @click.away="open = false" class="relative" x-data="{ open: false }">
    <button value="copy" @click="open = !open" onclick="copyToClipboard('{{ env('APP_URL') . '/transfers/'. $transfer->id }}')" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-indigo-500 hover:border-indigo-700 bg-white hover:bg-indigo-500 text-md font-medium text-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
        <span class="mr-2 hidden md:inline-flex">{{ __('transfers.copy_link') }}</span>
        <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.copy') }}</span>
        <svg fill="currentColor" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z"></path>
        </svg>
    </button>
    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 origin-top-right">
        <div class="rounded-md bg-white shadow-2xl py-1 border border-gray-200">
            <p class="block px-4 py-2 text-sm leading-5 font-medium text-gray-500">The following link has been copied to your clipboard:</p>
            <p class="block px-4 py-2 text-sm leading-5 text-gray-700">{{ env('APP_URL') . '/transfers/'. $transfer->id }}</p>
        </div>
    </div>
</div>
