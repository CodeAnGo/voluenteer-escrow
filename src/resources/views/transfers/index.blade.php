@extends('layouts.dashing')

@section('title', __('dashboard.index.title'))
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="max-w-6xl mx-auto">
                <div class="flex flex-col pt-4">
                    <div class="flex flex-row justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-800 p-4">
                            Active transfers
                        </h3>
                        @if (!$volunteer)

                        <a href="{{ route('transfers.create') }}" class="ml-2 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-green-500 hover:border-green-700 bg-white hover:bg-green-500 text-md font-medium text-green-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                            <span class="mr-2 hidden md:inline-flex">{{ __('transfers.create_transfer') }}</span>
                            <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.create') }}</span>
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                                <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </a>

                        @endif
                    </div>

                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul>

                            @forelse ($active_transfers as $transfer)
                                @if($volunteer) @if($other_party=$users->find($transfer->sending_party_id)) @endif
                                @else @if($other_party=$users->find($transfer->receiving_party_id)) @endif @endif

                                <li class="border border-2 border-gray-100">
                                    <a href="/transfers/{{ $transfer->id }}"
                                       class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                                        <div class="px-4 py-4 sm:px-6">
                                            <div class="flex items-center justify-between">
                                                <div
                                                        class="text-sm leading-5 font-medium text-gray-500 truncate tracking-wider">
                                                    <span class="text-indigo-600">{{ $transfer->transfer_reason }}</span> by
                                                    <span class="text-gray-600">
                                                    @if($other_party)
                                                            {{ $other_party->first_name }} {{ $other_party->last_name }}
                                                        @else
                                                            Unassigned
                                                        @endif
                                                </span>
                                                </div>
                                                <div class="ml-2 flex-shrink-0 flex">
                                                <span
                                                        class="px-2 inline-flex text-xs leading-5 rounded-full tracking-wide font-normal md:text-green-700 md:bg-green-100 text-green-600">
                                                    {{$status_map[$transfer->status]}}
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
                                                <div
                                                        class="mt-2 flex items-center text-sm leading-5 text-gray-600 sm:mt-0 font-thin tracking-wide">
                                                <span>
                                                    Updated
                                                    <time
                                                            datetime="{{ $transfer->updated_at }}">{{ \Carbon\Carbon::make($transfer->updated_at)->diffForHumans() }}</time>
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
                </div>
                <div class="flex flex-col pt-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-800 p-4">
                        All transfers
                    </h3>

                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul>

                            @forelse ($transfers as $transfer)
                                @if($volunteer) @if($other_party=$users->find($transfer->sending_party_id)) @endif
                                @else @if($other_party=$users->find($transfer->receiving_party_id)) @endif @endif

                                <li class="border border-2 border-gray-100">
                                    <a href="/transfers/{{ $transfer->id }}"
                                       class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                                        <div class="px-4 py-4 sm:px-6">
                                            <div class="flex items-center justify-between">
                                                <div
                                                        class="text-sm leading-5 font-medium text-gray-500 truncate tracking-wider">
                                                    <span class="text-indigo-600">{{ $transfer->transfer_reason }}</span> by
                                                    <span class="text-gray-600">
                                                    @if($other_party)
                                                            {{ $other_party->first_name }} {{ $other_party->last_name }}
                                                        @else
                                                            Unassigned
                                                        @endif
                                                </span>
                                                </div>
                                                <div class="ml-2 flex-shrink-0 flex">
                                                <span
                                                        class="px-2 inline-flex text-xs leading-5 rounded-full tracking-wide font-normal
                                                    @if (in_array($transfer->status, $closed_status))
                                                                md:text-red-700 md:bg-red-100 text-red-600">
                                                    @else
                                                        md:text-green-700 md:bg-green-100 text-green-600">
                                                    @endif
                                                    {{$status_map[$transfer->status]}}
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
                                                <div
                                                        class="mt-2 flex items-center text-sm leading-5 text-gray-600 sm:mt-0 font-thin tracking-wide">
                                                <span>
                                                    Updated
                                                    <time
                                                            datetime="{{ $transfer->updated_at }}">{{ \Carbon\Carbon::make($transfer->updated_at)->diffForHumans() }}</time>
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
                </div>
        </div>
@endsection
