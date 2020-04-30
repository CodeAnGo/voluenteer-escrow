<div class="bg-white shadow overflow-hidden sm:rounded-lg mt-4" wire:poll="rerender">
    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Transfer History
        </h3>
    </div>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul>
            @foreach ($transferHistory as $change)
                @if($change->event=='created' or ($change->event=='updated' and !array_key_exists('freshdesk_id', $change->old_values)))
                    <li class="border border-2 border-gray-100">
                        <div href="/transfers/{{ $transfer->id }}"
                             class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                            <div class="px-4 py-4 sm:px-6">
                                @if(array_key_exists('status', $change->old_values))
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm leading-5 font-medium text-gray-500 truncate tracking-wider">
                                            <span class="text-indigo-600">
                                                Status moved
                                            </span>
                                            to
                                            <span @if (in_array($change->new_values['status'], $closedStatuses))
                                                    class="text-red-600">
                                                                @else
                                                    class="text-green-600">
                                                @endif
                                                {{$statuses[$change->new_values['status']]}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm leading-5 font-medium text-gray-500 tracking-wider">
                                            <span class="text-gray-500">
                                                by
                                            </span>
                                            <span class="text-gray-600">
                                                {{$change->user->first_name}} {{$change->user->last_name}}
                                            </span>
                                        </div>
                                        <div  class="mt-2 flex items-center text-sm leading-5 text-gray-600 sm:mt-0 font-thin tracking-wide">
                                            <span>
                                                Updated
                                                <time datetime="{{ $change->created_at }}">{{ \Carbon\Carbon::make($change->created_at)->diffForHumans() }}</time>
                                            </span>
                                        </div>
                                    </div>
                                @elseif($change->event=='created')
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm leading-5 font-medium text-gray-500 truncate tracking-wider">
                                            <span class="text-indigo-600">
                                                Transfer <span class="text-green-600">Created</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm leading-5 font-medium text-gray-500 tracking-wider">
                                            <span class="text-gray-500">
                                                by
                                            </span>
                                            <span class="text-gray-600">
                                                {{$change->user->first_name}} {{$change->user->last_name}}
                                            </span>
                                        </div>
                                        <div  class="mt-2 flex items-center text-sm leading-5 text-gray-600 sm:mt-0 font-thin tracking-wide">
                                            <span>
                                                Created
                                                <time datetime="{{ $change->created_at }}">{{ \Carbon\Carbon::make($change->created_at)->diffForHumans() }}</time>
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm leading-5 font-medium text-gray-500 truncate tracking-wider">
                                            <span class="text-indigo-600">
                                                Transfer Details Updated
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm leading-5 font-medium text-gray-500 tracking-wider">
                                            <span class="text-gray-500">
                                                by
                                            </span>
                                            <span class="text-gray-600">
                                                {{$change->user->first_name}} {{$change->user->last_name}}
                                            </span>
                                        </div>
                                        <div class="mt-2 flex items-center text-sm leading-5 text-gray-600 sm:mt-0 font-thin tracking-wide">
                                            <span>
                                                Updated
                                                <time datetime="{{ $change->created_at }}">{{ \Carbon\Carbon::make($change->created_at)->diffForHumans() }}</time>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>