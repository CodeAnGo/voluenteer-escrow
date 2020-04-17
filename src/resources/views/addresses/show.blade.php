<div class="flex flex-col justify-between bg-white shadow-md overflow-hidden sm:rounded-lg h-full text-gray-900">
    <div class="px-4 py-3">
        <dl class="flex flex-col">
            @isset($address->name)
            <div class="flex flex-row my-1">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" class="w-6 h-6 mr-2 text-gray-600" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="truncate">{{ $address->name }}</span>
            </div>
            @endisset
            @isset($address->email)
                <div class="flex flex-row my-1">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" class="w-6 h-6 mr-2 text-gray-600" viewBox="0 0 24 24">
                            <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                    <span class="truncate">{{ $address->email }}</span>
                </div>
            @endisset
            <div class="flex flex-row my-1">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" class="w-6 h-6 mr-2 text-gray-600" viewBox="0 0 24 24">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <div class="flex flex-col">
                    @isset($address->line1)<span class="truncate">{{ $address->line1 }}</span>@endisset
                    @isset($address->line2)<span class="truncate">{{ $address->line2 }}</span>@endisset
                    @isset($address->city)<span class="truncate">{{ $address->city }}</span>@endisset
                    @isset($address->county)<span class="truncate">{{ $address->county }}</span>@endisset
                    @isset($address->postcode)<span class="truncate">{{ $address->postcode }}</span>@endisset
                    @isset($address->country)<span class="truncate">{{ $address->country }}</span>@endisset
                </div>
            </div>
        </dl>
    </div>
    <div class="mb-2 mr-2 flex justify-end">
        @if (isset($address->id))
            <div class="ml-3 rounded-md flex flex-row items-center ">
                <a href="{{ route('addresses.edit', $address->id) }}" class="ml-2 inline-flex items-center justify-center py-2 px-4 rounded bg-transparent text-md font-medium text-indigo-500 hover:text-indigo-700 focus:outline-none transition duration-150 ease-in-out">
                    <span class="mr-2 inline-flex">{{ __('common.edit') }}</span>
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </a>
                <button type="submit" form="deleteAddress" class="ml-2 inline-flex items-center justify-center py-2 px-4 rounded bg-transparent text-md font-medium text-red-500 hover:text-red-700 focus:outline-none transition duration-150 ease-in-out">
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
