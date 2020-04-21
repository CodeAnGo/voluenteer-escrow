<div class="flex flex-col justify-between bg-white shadow-md overflow-hidden sm:rounded-lg h-full text-gray-900">
    <div class="flex flex-col">
        <div class="flex flex-col p-4 lg:py-6 lg:px-6">
            @isset($address->line1)<span class="truncate">{{ $address->line1 }}</span>@endisset
            @isset($address->line2)<span class="truncate">{{ $address->line2 }}</span>@endisset
            @isset($address->city)<span class="truncate">{{ $address->city }}</span>@endisset
            @isset($address->county)<span class="truncate">{{ $address->county }}</span>@endisset
            @isset($address->postcode)<span class="truncate">{{ $address->postcode }}</span>@endisset
            @isset($address->country)<span class="truncate">{{ $address->country }}</span>@endisset
        </div>
    </div>
    <div class="mb-2 mr-2 flex justify-end">
        @if (isset($address->id))
            <div class="ml-3 rounded-md flex flex-row items-center ">
                <a href="{{ route('addresses.edit', $address->id) }}" class="ml-2 inline-flex items-center justify-center py-2 px-4 rounded bg-transparent text-md font-medium text-indigo-500 hover:text-indigo-700 focus:text-indigo-700 transition duration-150 ease-in-out">
                    <span class="mr-2 inline-flex">{{ __('common.edit') }}</span>
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </a>
                <button type="submit" form="deleteAddress" class="ml-2 inline-flex items-center justify-center py-2 px-4 rounded bg-transparent text-md font-medium text-red-500 hover:text-red-700 focus:text-red-700 transition duration-150 ease-in-out">
                    <span class="mr-2 inline-flex">{{ __('common.delete') }}</span>
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
                <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" id="deleteAddress" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        @endif
    </div>
</div>
