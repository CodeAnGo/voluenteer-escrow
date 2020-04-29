@extends('layouts.dashing')

@section('title', __('profile.edit.title'))
@section('header_title', __('profile.edit.title'))

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
                                {{ __('profile.contact_details') }}
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:px-6">
                            <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    @include('layouts.input_with_label', [
                                        'label' => __('common.first_name'),
                                        'value' => $user->first_name,
                                        'input_id' => 'first_name',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="sm:col-span-1">
                                    <div class="w-full">
                                        <dt>
                                            <label for="last_name" class="text-sm leading-5 font-medium text-gray-500">
                                                {{ __('common.last_name') }}
                                            </label>
                                        </dt>
                                        <dd>
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <input id="last_name" name="last_name" type="text" value="{{ $user->last_name }}" required class="@error('last_name') border-red-500 @enderror appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
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
                                                {{ __('common.email_address') }}
                                            </label>
                                        </dt>
                                        <dd>
                                            <div class="mt-1 rounded-md shadow-sm">
                                                <input id="email" name="email" type="email" value="{{ $user->email }}" required class="@error('email') border-red-500 @enderror appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
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
                                {{ __('profile.charity_details') }}
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:px-6 text-gray-900">
                            <label class="text-sm leading-5 font-medium text-gray-500">
                                {{ __('profile.your_charities') }}
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

@section('footer_buttons')
    <a href="{{ route('profile.index') }}" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg bg-white hover:bg-red-500 text-md font-medium text-red-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
        <span class="inline-flex">{{ __('common.cancel') }}</span>
    </a>
    <button type="submit" form="editProfile" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md hover:shadow-lg border-b-2 border-green-500 hover:border-green-700 bg-white hover:bg-green-500 text-md font-medium text-green-500 hover:text-white focus:outline-none transition duration-150 ease-in-out">
        <span class="mr-2 hidden md:inline-flex">{{ __('profile.save_profile') }}</span>
        <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.save') }}</span>
        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </button>
@endsection
