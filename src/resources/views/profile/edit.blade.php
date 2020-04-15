@extends('layouts.dashing')

@section('title', 'Edit Profile')

@section('page_title')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                        Edit Profile
                    </h2>
                </div>
                <div class="hidden sm:block ml-3 shadow-sm rounded-md">
                    <button type="submit" form="editProfile" class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form action="{{ route('profile.update') }}" method="POST" id="editProfile">
        @csrf
        @method('PUT')
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
                                <div class="sm:col-span-1">
                                    <div class="w-full">
                                        <dt>
                                            <label for="first_name" class="text-sm leading-5 font-medium text-gray-500">
                                                First Name
                                            </label>
                                        </dt>
                                        <dd>
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <input id="first_name" name="first_name" type="text" value="{{ $user->first_name }}" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                            </div>
                                            @error('first_name')
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
                                            <label for="last_name" class="text-sm leading-5 font-medium text-gray-500">
                                                Last Name
                                            </label>
                                        </dt>
                                        <dd>
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <input id="last_name" name="last_name" type="text" value="{{ $user->last_name }}" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                            </div>
                                            @error('last_name')
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
                                                <input id="email" name="email" type="email" value="{{ $user->email }}" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
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
                        <div class="px-4 py-5 sm:px-6 text-gray-900">
                            <label class="text-sm leading-5 font-medium text-gray-500">
                                Your Charities
                            </label>
                            @foreach($charities as $charity)
                                <div class="mt-2">
                                    <input type="checkbox" class="form-checkbox" name="charity_checkbox_{{$charity->name}}" value="{{$charity->id}}" @if($charity->checked) checked @endif>
                                    <span class="ml-2 text-sm">{{$charity->name}}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
