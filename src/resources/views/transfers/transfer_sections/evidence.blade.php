<div class="bg-white shadow overflow-hidden  sm:rounded-lg mt-4">
    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Transfer Evidence
        </h3>
    </div>
    <div class="px-4 py-3 sm:px-6">
        <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-3">
            <div class="sm:col-span-1">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Actual Amount
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900">
                    {{ $transfer->actual_amount }}
                </dd>
            </div>
            @if ($transfer->approval_note)
            <div class="sm:col-span-1">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Additional Notes
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900">
                    {{ $transfer->approval_note }}
                </dd>
            </div>
            @endif
            <div class="sm:col-span-4">
                <dt class="text-sm leading-5 font-medium text-gray-500 mb-2">
                    Proof of Purchase
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 flex">
                    @foreach($transferEvidence as $transferPhoto)
                    <div class="flex-auto mb-2  h-56">
                        <a href="{{Storage::disk('public')->url($transferPhoto->path)}}" target="_blank">
                            <img class="mr-4 object-contain h-56 w-auto" src="{{Storage::disk('public')->url($transferPhoto->path)}}" alt="">
                        </a>
                    </div>
                    @endforeach
                </dd>
            </div>
        </dl>
    </div>
</div>
</div>
