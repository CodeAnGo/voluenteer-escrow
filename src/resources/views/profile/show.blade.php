<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 col-gap-4 row-gap-4 sm:grid-cols-1 md:grid-cols-2">
        <div class="flex flex-col sm:col-span-1">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg h-full">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ __('profile.contact_details') }}
                    </h3>
                </div>
                <div class="px-4 py-5 sm:px-6">
                    <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                {{ __('common.full_name') }}
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                {{ __('common.email_address') }}
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                {{ $user->email }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                {{ __('common.phone_number') }}
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                {{ $account->phone ?? '-' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
        <div class="flex flex-col sm:col-span-1">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg h-full">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ __('profile.charity_details') }}
                    </h3>
                </div>
                <div class="px-4 py-5 sm:px-6">
                    <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                {{ __('profile.your_charities') }}
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                <ul class="px-4 list-disc">
                                    @foreach ($charities as $charity)
                                        <li>{{ $charity->name }}</li>
                                    @endforeach
                                </ul>
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                {{ __('profile.registered_volunteer') }}
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900">
                                {{ $user->volunteer ? 'Yes' : 'No' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@include('addresses.show', ['address' =>$account])
