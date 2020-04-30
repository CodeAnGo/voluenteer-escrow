<div class="bg-white shadow overflow-hidden sm:rounded-md" wire:poll="rerender">
    <ul>
        @forelse ($transfers as $transfer)
            <li class="border border-2 border-gray-100">
                <a href="/transfers/{{ $transfer->id }}" class="block hover:bg-gray-50 focus:bg-gray-50 transition duration-150 ease-in-out">
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="text-sm leading-5 font-medium text-gray-500 truncate tracking-wider">
                                <span class="text-indigo-600">{{ $transfer->transfer_reason }}</span> by
                                <span class="text-gray-600">
                                    @if($transfer->recievingParty)
                                        {{ $transfer->recievingParty->first_name }} {{ $transfer->recievingParty->last_name }}
                                    @else
                                        Unassigned
                                    @endif
                                </span>
                            </div>
                            <div class="ml-2 flex-shrink-0 flex">
                                <span class="px-2 inline-flex text-xs leading-5 rounded-full tracking-wide font-normal
                                    @if (in_array($transfer->status, $closedStatuses))
                                        bg-red-200 text-red-800 tracking-wide font-thin
                                    @else
                                        bg-green-200 text-green-800 tracking-wide font-thin
                                    @endif
                                    ">{{$statuses[$transfer->status]}}
                                </span>
                            </div>
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between">
                            <div class="sm:flex">
                                <div
                                        class="mt-2 flex items-center text-sm leading-5 text-green-600 tracking-wider font-normal  sm:mt-0">
                                    £{{ number_format($transfer->transfer_amount, 2) }}
                                </div>
                            </div>
                            <div class="mt-2 flex items-center text-sm leading-5 text-gray-600 sm:mt-0 font-thin tracking-wide">
                                <span>
                                    Updated
                                    <time datetime="{{ $transfer->updated_at }}">{{ \Carbon\Carbon::make($transfer->updated_at)->diffForHumans() }}</time>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </li>

        @empty
            <div class="bg-white shadow p-4">
                <div class="flex justify-center">
                    <div class="text-gray-800  font-normal tracking-wider">
                        No Active Transfers
                    </div>
                </div>
            </div>
        @endforelse
    </ul>
</div>