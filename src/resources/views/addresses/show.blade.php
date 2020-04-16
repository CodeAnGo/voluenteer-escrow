<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 col-gap-4 row-gap-4 sm:grid-cols-1">
        <div class="flex flex-col sm:col-span-1">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg h-full">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ $address->name ?? __('addresses.registered_address') }}
                        </h3>
                        @if (isset($address->email))
                            <div class="flex items-center text-sm leading-5 text-gray-600 sm:mr-6">
                                {{ $address->email }}
                            </div>
                        @endif
                    </div>
                    @if (isset($address->id))
                        <div class="ml-3 shadow-sm rounded-md">
                            <a href="{{ route('addresses.edit', $address->id) }}" class="inline-flex items-center justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                <span class="hidden md:inline-flex">{{ __('addresses.edit_address') }}</span>
                                <span class="sm:inline-flex md:hidden">{{ __('common.edit') }}</span>
                            </a>
                            <button type="submit" form="deleteAddress" class="inline-flex items-center justify-center ml-2 py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition duration-150 ease-in-out">
                                <span class="hidden md:inline-flex">{{ __('addresses.delete_address') }}</span>
                                <span class="sm:inline-flex md:hidden">{{ __('common.delete') }}</span>
                            </button>
                            <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" id="deleteAddress" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    @endif
                </div>
                <div class="px-4 py-5 sm:px-6">
                    <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="sm:col-span-1">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                {{ __('common.line1') }}
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                {{ $address->line1 ?? '-' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                {{ __('common.line2') }}
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                {{ $address->line2 ?? '-' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                {{ __('common.city') }}
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                {{ $address->city ?? '-' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                {{ __('common.county') }}
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                {{ $address->county ?? '-' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                {{ __('common.postcode') }}
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                {{ $address->postcode ?? '-' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                {{ __('common.country') }}
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                {{ $address->country ?? '-' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
