<div class="bg-white shadow overflow-hidden mb-4  sm:rounded-lg">
    <div class="px-4 py-3 border-b border-gray-200 sm:px-6">
        <h3 class="text-lg font-medium leading-6 text-red-500">
            Dispute Raised
        </h3>
        <p class="mt-1 text-sm leading-5 text-gray-500">
            @if ($transferDispute->user_id !== Auth::id())
                A dispute has been raised on your transfer. Please review the information and either approve if you agree, or reject if you do not agree with the dispute.
            @else
                You have raised a dispute on your transfer. You can view the information you provided for the dispute below.
            @endif
        </p>
    </div>


    <div class="px-4 py-3 sm:px-6">

        <dl class="grid grid-cols-1 col-gap-4 row-gap-4 sm:grid-cols-3">

            <div class="sm:col-span-4">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Dispute Reason
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900">
                    {{ $transferDispute->dispute_reason }}
                </dd>
            </div>
            <div class="sm:col-span-4">
                <dt class="text-sm leading-5 font-medium text-gray-500 mb-2">
                    Dispute Evidence
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

        @if ($transferDispute->user_id !== Auth::id())
        <p class="text-sm leading-5 font-medium text-red-500 mb-2 mt-2 text-center">
            If you accept the dispute, the funds will be released back to the transfer creator.
        </p>
        <p class="text-sm leading-5 font-medium text-red-500 mb-4 text-center">
            Rejecting the dispute will escalate the matter to your related charity, who will resolve the issue.
        </p>
            @endif

    </div>

</div>
