@extends('layouts.dashing')

@section('title', 'Edit Address')

@section('page_title')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                        Create Address
                    </h2>
                </div>
                <div class="hidden sm:block ml-3 shadow-sm rounded-md">
                    <button type="submit" form="createAddress" class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Save Address
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form action="{{ route('addresses.store') }}" method="POST" id="createAddress">
        @csrf
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="max-w-6xl mx-auto grid grid-cols-1 col-gap-4 row-gap-4 sm:grid-cols-1">
                <div class="flex flex-col sm:col-span-3">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg h-full">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Contact details
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:px-6">
                            <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2 lg:grid-cols-3">
                                <div class="sm:col-span-1">
                                    <div class="w-full">
                                        <dt>
                                            <label for="name" class="text-sm leading-5 font-medium text-gray-500">
                                                Name
                                            </label>
                                        </dt>
                                        <dd>
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <input id="name" name="name" type="text" value="{{ old('name') }}" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                            </div>
                                            @error('name')
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <p class="text-red-600 text-sm tracking-wide font-light">
                                                    {{ $message }}
                                                </p>
                                            </div>
                                            @enderror
                                        </dd>
                                    </div>
                                </div>
                                <div class="sm:col-span-1">
                                    <div class="w-full">
                                        <dt>
                                            <label for="email" class="text-sm leading-5 font-medium text-gray-500">
                                                Email Address
                                            </label>
                                        </dt>
                                        <dd>
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                            </div>
                                            @error('email')
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <p class="text-red-600 text-sm tracking-wide font-light">
                                                    {{ $message }}
                                                </p>
                                            </div>
                                            @enderror
                                        </dd>
                                    </div>
                                </div>
                                <div class="hidden lg:inline-flex lg:col-span-1"></div>
                                <div class="sm:col-span-1">
                                    <div class="w-full">
                                        <dt>
                                            <label for="line1" class="text-sm leading-5 font-medium text-gray-500">
                                                Line 1
                                            </label>
                                        </dt>
                                        <dd>
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <input id="line1" name="line1" type="text" value="{{ old('line1') }}" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                            </div>
                                            @error('line1')
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <p class="text-red-600 text-sm tracking-wide font-light">
                                                    {{ $message }}
                                                </p>
                                            </div>
                                            @enderror
                                        </dd>
                                    </div>
                                </div>
                                <div class="sm:col-span-1">
                                    <div class="w-full">
                                        <dt>
                                            <label for="line2" class="text-sm leading-5 font-medium text-gray-500">
                                                Line 2
                                            </label>
                                        </dt>
                                        <dd>
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <input id="line2" name="line2" type="text" value="{{ old('line2') }}" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                            </div>
                                            @error('line2')
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <p class="text-red-600 text-sm tracking-wide font-light">
                                                    {{ $message }}
                                                </p>
                                            </div>
                                            @enderror
                                        </dd>
                                    </div>
                                </div>
                                <div class="sm:col-span-1">
                                    <div class="w-full">
                                        <dt>
                                            <label for="city" class="text-sm leading-5 font-medium text-gray-500">
                                                City
                                            </label>
                                        </dt>
                                        <dd>
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <input id="city" name="city" type="text" value="{{ old('city') }}" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                            </div>
                                            @error('city')
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <p class="text-red-600 text-sm tracking-wide font-light">
                                                    {{ $message }}
                                                </p>
                                            </div>
                                            @enderror
                                        </dd>
                                    </div>
                                </div>
                                <div class="sm:col-span-1">
                                    <div class="w-full">
                                        <dt>
                                            <label for="county" class="text-sm leading-5 font-medium text-gray-500">
                                                County
                                            </label>
                                        </dt>
                                        <dd>
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <input id="county" name="county" type="text" value="{{ old('county') }}" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                            </div>
                                            @error('county')
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <p class="text-red-600 text-sm tracking-wide font-light">
                                                    {{ $message }}
                                                </p>
                                            </div>
                                            @enderror
                                        </dd>
                                    </div>
                                </div>
                                <div class="sm:col-span-1">
                                    <div class="w-full">
                                        <dt>
                                            <label for="postcode" class="text-sm leading-5 font-medium text-gray-500">
                                                Post Code
                                            </label>
                                        </dt>
                                        <dd>
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <input id="postcode" name="postcode" type="text" value="{{ old('postcode') }}" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                            </div>
                                            @error('postcode')
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <p class="text-red-600 text-sm tracking-wide font-light">
                                                    {{ $message }}
                                                </p>
                                            </div>
                                            @enderror
                                        </dd>
                                    </div>
                                </div>
                                <div class="sm:col-span-1">
                                    <div class="w-full">
                                        <dt>
                                            <label for="country" class="text-sm leading-5 font-medium text-gray-500">
                                                Country
                                            </label>
                                        </dt>
                                        <dd>
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <input id="country" name="country" type="text" value="{{ old('country') }}" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                            </div>
                                            @error('country')
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <p class="text-red-600 text-sm tracking-wide font-light">
                                                    {{ $message }}
                                                </p>
                                            </div>
                                            @enderror
                                        </dd>
                                    </div>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
