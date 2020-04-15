@extends('layouts.dashing')

@section('title', 'Profile')

@section('page_title')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                        Profile
                    </h2>
                </div>
                <div class="ml-3 shadow-sm rounded-md">
                    <a href="{{ route('profile.edit') }}" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="max-w-6xl mx-auto grid grid-cols-1 col-gap-4 row-gap-4 sm:grid-cols-1 md:grid-cols-2">
            <div class="flex flex-col sm:col-span-1">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg h-full">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Contact details
                        </h3>
                    </div>
                    <div class="px-4 py-5 sm:px-6">
                        <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Full Name
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Email Address
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ $user->email }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Phone Number
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
                            Charity details
                        </h3>
                    </div>
                    <div class="px-4 py-5 sm:px-6">
                        <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Your Charities
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
                                    Registered Volunteer
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
@endsection
