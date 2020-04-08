
@extends('layouts.base')

@section('title', 'Register')

@section('content')
    <div class="min-h-screen bg-white flex">
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm">
                <div>

                    <img class="h-12 w-auto justify-center" src="{{ asset('img/netcompany.63c83485.svg') }}" alt="Workflow" />
                    <h2 class="mt-6 text-3xl leading-9 font-thin text-gray-800 tracking-wide">
                        Register your account
                    </h2>
                </div>
                <div class="mt-8">
                    <div class="mt-6">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div>
                                <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                                    Email address
                                </label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <input id="email" name="email" type="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                </div>
                                @error('email')
                                <div class="mt-1 rounded-md shadow-sm">
                                    <p class="text-red-600 text-sm tracking-wide font-light">
                                        {{ $message }}
                                    </p>
                                </div>
                                @enderror
                            </div>
                            <div class="mt-6 flex flex-row">
                                <div class="w-full">
                                    <label for="fname" class="block text-sm font-medium leading-5 text-gray-700">
                                        First Name
                                    </label>
                                    <div class="mt-1 rounded-md shadow-sm mr-3">
                                        <input id="fname" name="fname" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>
                                    @error('fname')
                                    <div class="mt-1 rounded-md shadow-sm">
                                        <p class="text-red-600 text-sm tracking-wide font-light">
                                            {{ $message }}
                                        </p>
                                    </div>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label for="lname" class="block text-sm font-medium leading-5 text-gray-700">
                                        Last Name
                                    </label>
                                    <div class="mt-1 rounded-md shadow-sm">
                                        <input id="lname" name="lname" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>
                                    @error('lname')
                                    <div class="mt-1 rounded-md shadow-sm">
                                        <p class="text-red-600 text-sm tracking-wide font-light">
                                            {{ $message }}
                                        </p>
                                    </div>
                                    @enderror
                                </div>

                            </div>

                            <div class="mt-6">
                                <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
                                    Password
                                </label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <input id="password" name="password" type="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                </div>
                                @error('password')
                                <div class="mt-1 rounded-md shadow-sm">
                                    <p class="text-red-600 text-sm tracking-wide font-light">
                                        {{ $message }}
                                    </p>
                                </div>
                                @enderror
                            </div>
                            <div class="mt-6">
                                <label for="password-confirm" class="block text-sm font-medium leading-5 text-gray-700">
                                    Confirm Password
                                </label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                </div>
                                @error('password')
                                <div class="mt-1 rounded-md shadow-sm">
                                    <p class="text-red-600 text-sm tracking-wide font-light">
                                        {{ $message }}
                                    </p>
                                </div>
                                @enderror
                            </div>
                            <div class="mt-6">
                                <span class="block w-full rounded-md shadow-sm">
                                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                        Register
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="mt-6">
                        <a href="{{route('login')}}" class="block text-sm font-medium leading-5 text-indigo-600 hover:text-indigo-500 text-center">
                            Already have an account? Login here
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="hidden lg:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1505904267569-f02eaeb45a4c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80" alt="" />
        </div>
    </div>
@endsection
