<div class="bg-white shadow overflow-hidden  sm:rounded-lg mt-4">
    <div class="px-4 py-3 border-b border-gray-200 sm:px-6">
        <div class="flex flex-row items-center">
            <div class="flex flex-col">
                <div class="text-lg leading-6 font-medium text-gray-900">
                    {{ __('transfers.transfer_information') }}
                </div>
                <p class="mt-1 text-sm leading-5 text-gray-500">
                    {{ __('transfers.transfer_information_sub_title') }}
                </p>
            </div>
            <div class="text-sm leading-6 font-medium text-gray-900 ml-auto text-center font-semibold rounded-full px-2
                    @if (in_array($transfer->status, $closedStatuses))
                        bg-red-200 text-red-800 tracking-wide font-thin
                        @else
                        bg-green-200 text-green-800 tracking-wide font-thin
                        @endif
                    ">{{$statuses[$transfer->status]}}
            </div>
        </div>
    </div>
    <div class="px-4 py-3 sm:px-6">
        <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-3">
            <div class="sm:col-span-1">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    {{ __('transfers.transfer_information.reason') }}
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900">
                    {{ $transfer->transfer_reason ?? '-' }}
                </dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    {{ __('transfers.transfer_information.amount') }}
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900">
                    £{{ $transfer->transfer_amount ?? '-' }}
                </dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    {{ __('transfers.transfer_information.charity') }}
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900">
                    {{ $charity ?? '-' }}
                </dd>
            </div>
            <div class="sm:col-span-3">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    {{ __('transfers.transfer_information.context') }}
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900">
                    {{ $transfer->transfer_note ?? '-' }}
                </dd>
            </div>
            @if(isset($transfer_files) && $transfer_files->count() != 0)
                <div class="sm:col-span-4">
                    <dt class="text-sm leading-5 font-medium text-gray-500 mb-2">
                        Attached Images
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 flex">
                        @foreach($transfer_files as $transfer_file)
                            <div class="flex-auto mb-2  h-56">
                                <a href="{{Storage::disk('public')->url($transfer_file->path)}}"
                                   target="_blank">
                                    <img class="mr-4 object-contain h-56 w-auto"
                                         src="{{Storage::disk('public')->url($transfer_file->path)}}"
                                         alt="">
                                </a>
                            </div>
                        @endforeach
                    </dd>
                </div>
            @endif
        </dl>
    </div>
</div>