<div class="bg-white shadow overflow-hidden  sm:rounded-lg">
    <div class="px-4 py-3 border-b border-gray-200 sm:px-6">
        <div class="flex flex-col">
            <div class="text-lg leading-6 font-medium text-gray-900">
                {{ __('transfers.delivery_information') }}
            </div>
            <p class="mt-1 text-sm leading-5 text-gray-500">
                {{ __('transfers.delivery_information_sub_title') }}
            </p>
        </div>
    </div>
    <div class="px-4 py-5 sm:px-6">
        <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <div class="sm:col-span-1">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    {{ __('common.full_name') }}
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900">
                    {{ $transfer->delivery_first_name }} {{ $transfer->delivery_last_name }}
                </dd>
            </div>
            @if(Auth::id() === $transfer->sending_party_id || Auth::id() === $transfer->receiving_party_id)
                <div class="sm:col-span-1">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        {{ __('common.email_address') }}
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900">
                        {{ $transfer->delivery_email ?? '-' }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        {{ __('common.phone_number') }}
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900">
                        {{ $transfer->delivery_phone ?? '-' }}
                    </dd>
                </div>
                <div class="hidden col-span-1 sm:inline-flex lg:hidden"></div>
                <div class="sm:col-span-1">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        {{ __('common.line1') }}
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900">
                        {{ $transfer->delivery_street_1 ?? '-' }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        {{ __('common.line2') }}
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900">
                        {{ $transfer->delivery_street_2 ?? '-' }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        {{ __('common.city') }}
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900">
                        {{ $transfer->delivery_city ?? '-' }}
                    </dd>
                </div>
            @else
                <div class="hidden lg:inline-flex lg:col-span-2"></div>
            @endif
            <div class="sm:col-span-1">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    {{ __('common.county') }}
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900">
                    {{ $transfer->delivery_county ?? '-' }}
                </dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    {{ __('common.postcode') }}
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900">
                    {{ $transfer->delivery_postcode ?? '-' }}
                </dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    {{ __('common.country') }}
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900">
                    {{ $transfer->delivery_country ?? '-' }}
                </dd>
            </div>
        </dl>
    </div>
</div>