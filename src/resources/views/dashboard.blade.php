@extends('layouts.dashing')

@section('title', __('dashboard.index.title'))
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="max-w-6xl mx-auto">
            <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                        Active Transfers
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl leading-8 font-semibold text-gray-900">
                                            {{ count($active_transfers) }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->volunteer === 0)
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                            Total in Escrow
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl leading-8 font-semibold text-gray-900">
                                                {{ $active_transfers->sum('transfer_amount') }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                            Total Transfers
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl leading-8 font-semibold text-gray-900">
                                                {{ count($transfers) }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (Auth::user()->volunteer === 0)
                    <a href="/transfers/create">
                        <div class="bg-blue-300 hover:bg-blue-200 border-b overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                        <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <div class="text-2xl leading-8 font-semibold text-gray-900">
                                            Create Transfer
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                            Total in Escrow
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl leading-8 font-semibold text-gray-900">
                                                {{ $active_transfers->sum('transfer_amount') }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex flex-col pt-4">
                <h3 class="text-lg leading-6 font-medium text-gray-800 p-4">
                    Active transfers
                </h3>

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
{{--                                                        datetime="{{ $transfer->updated_at }}">{{ \Carbon\Carbon::make($transfer->updated_at)->diffForHumans() }}</time>--}}
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
{{--                                                        datetime="{{ $transfer->updated_at }}">{{ \Carbon\Carbon::make($transfer->updated_at)->diffForHumans() }}</time>--}}
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
