<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 col-gap-4 row-gap-4 sm:grid-cols-1 md:grid-cols-3">
        <div class="flex flex-col sm:col-span-1">
            <div class="bg-white shadow-md overflow-hidden sm:rounded-lg h-full">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ __('profile.contact_details') }}
                    </h3>
                </div>
                <div class="px-4 py-3 sm:px-6">
                    <dl class="flex flex-col">
                        <div class="flex flex-row my-1">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" class="w-6 h-6 mr-2 text-gray-600" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="truncate">{{ $user->first_name }} {{ $user->last_name }}</span>
                        </div>
                        <div class="flex flex-row my-1">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" class="w-6 h-6 mr-2 text-gray-600" viewBox="0 0 24 24">
                                <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                            <span class="truncate">{{ $user->email }}</span>
                        </div>
                        <div class="flex flex-row my-1">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" class="w-6 h-6 mr-2 text-gray-600" viewBox="0 0 24 24">
                                <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="truncate">{{ $account->phone ?? '-' }}</span>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
        <div class="flex flex-col sm:col-span-1">
            <div class="bg-white shadow-md overflow-hidden sm:rounded-lg h-full">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ __('addresses.registered_address') }}
                    </h3>
                </div>
                <div class="px-4 py-3 sm:px-6">
                    <div class="flex flex-row my-1">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" class="w-6 h-6 mr-2 text-gray-600" viewBox="0 0 24 24">
                            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <div class="flex flex-col">
                            @isset($account->address->line1)<span class="truncate">{{ $account->address->line1 }}</span>@endisset
                            @isset($account->address->line2)<span class="truncate">{{ $account->address->line2 }}</span>@endisset
                            @isset($account->address->city)<span class="truncate">{{ $account->address->city }}</span>@endisset
                            @isset($account->address->county)<span class="truncate">{{ $account->address->county }}</span>@endisset
                            @isset($account->address->postcode)<span class="truncate">{{ $account->address->postcode }}</span>@endisset
                            @isset($account->address->country)<span class="truncate">{{ $account->address->country }}</span>@endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col sm:col-span-1">
            <div class="bg-white shadow-md overflow-hidden sm:rounded-lg h-full">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ __('profile.charity_details') }}
                    </h3>
                </div>
                <div class="px-4 py-5 sm:px-6">
                    <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-1">
                        <div class="sm:col-span-1">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                {{ __('profile.registered_volunteer') }}
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                {{ $user->volunteer ? 'Yes' : 'No' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                {{ __('profile.your_charities') }}
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                @if($charities->count() === 0)
                                    <i>You have not registered with any charities</i>
                                @else
                                    <ul class="px-4 list-disc">
                                        @foreach ($charities as $charity)
                                            <li class="truncate">{{ $charity->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
