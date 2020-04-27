@extends('layouts.dashing')

@section('title', 'Transfer Dispute')

@section('header_title')
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
            {{ $transfer->transfer_reason }}
        </h2>
    </div>
@endsection

@section('content')

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
            <div class="max-w-6xl mx-auto">
                <div class="flex flex-col">
                    <div class="hidden sm:block">
                        <div class="sm:py-1 md:py-1 lg:py-5">
                            <div class="border-t border-gray-200"></div>
                        </div>
                    </div>
                    <div class="mt-10 sm:mt-0">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                                        Raised Dispute
                                    </h3>
                                    <p class="mt-1 text-sm leading-5 text-gray-500">
                                        @if ($transferDispute->user_id !== Auth::id())
                                        A dispute has been raised on your transfer, please resolve.
                                            @else
                                            You have raised a dispute on your transfer. You can view this here.
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="px-4 py-5 bg-white sm:p-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div class="col-span-6 sm:col-span-6">
                                                <dt class="text-sm leading-5 font-medium text-gray-800">
                                                    Dispute Reason
                                                </dt>
                                                <dd class="mt-1 text-sm leading-5 text-gray-800">
                                                    {{ $transferDispute->dispute_reason }}
                                                </dd>

                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <dt class="text-sm leading-5 font-medium text-gray-800 mb-2">
                                                    Dispute Evidence
                                                </dt>
                                                <dd class="mt-1 text-sm leading-5 text-gray-900 flex">
                                                    @foreach($transferDispute->transferDisputeEvidence as $transferDisputePhoto)
                                                        <div class="flex-auto mb-2  h-56">
                                                            <a href="{{Storage::disk('public')->url($transferDisputePhoto->path)}}" target="_blank">
                                                                <img class="mr-4 object-contain h-56 w-auto" src="{{Storage::disk('public')->url($transferDisputePhoto->path)}}" alt="">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </dd>
                                            </div>

                                        </div>
                                        @if ($transferDispute->user_id !== Auth::id())
                                        <div class="mt-4">
                                            <p class="text-sm leading-5 font-medium text-gray-600">
                                                Accepting the dispute will close the transfer, and release the funds back to the transfer creator.
                                            </p>
                                            <p class="text-sm leading-5 font-medium text-gray-600 mt-2">
                                                Rejecting the dispute will escalate the matter to your related charity, who will resolve the issue.
                                            </p>
                                        </div>
                                            @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($transferDispute->user_id !== Auth::id())
                    <div class="py-3 text-right">

                        <button type="submit" form="accept" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-green-500 hover:border-green-700 bg-white hover:bg-green-500 text-md font-medium text-green-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                            <span class="mr-2 hidden md:inline-flex">Accept Dispute</span>
                            <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.dispute') }}</span>
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                                <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </button>
                        <form class="hidden" action="{{ route('transfers.dispute.update', ['transfer' => $transfer, 'dispute' => $transferDispute])}}" method="POST" id="accept" name="accept">
                            @csrf
                            @method('PATCH')
                            <input type="text" class="hidden" value="accept" name="buttonPressed">
                        </form>

                        <button type="submit" form="rejectDispute" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md border-b-2 border-red-500 hover:border-red-700 focus:border-red-700 bg-white hover:bg-red-500 focus:bg-red-500 text-md font-medium text-red-500 hover:text-white focus:text-white transition duration-150 ease-in-out">
                            <span class="mr-2 hidden md:inline-flex">Reject Dispute</span>
                            <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.reject') }}</span>
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                                <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </button>
                        <form class="hidden" action="{{ route('transfers.dispute.update', ['transfer' => $transfer, 'dispute' => $transferDispute])}}" method="POST" id="rejectDispute" name="rejectDispute">
                            @csrf
                            @method('PATCH')
                            <input type="text" class="hidden" value="reject" name="buttonPressed">
                        </form>

                    </div>
                    @endif

                </div>
            </div>
        </div>
@endsection
