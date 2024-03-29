@extends('layouts.base')

@section('title', 'Login')

@section('content')
    <div class="min-h-screen bg-white flex">
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm">
                <div>
                    <h2 class="mt-6 text-3xl leading-9 font-medium text-gray-700 tracking-wide">
                        Reset your password
                    </h2>
                </div>

                <div class="mt-8">
                    <div class="mt-6">
                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div>
                                @error('email')
                                <p class="text-red-500 text-xs italic mt-4 py-2">
                                    {{ $message }}
                                </p>
                                @enderror
                                <label for="email" class="block text-sm font-medium leading-5 text-gray-700 text-center">
                                    Email address
                                </label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <input id="email" name="email" type="email" required class="text-center appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                </div>
                            </div>


                            <div class="mt-6">
              <span class="block w-full rounded-md shadow-sm">
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                  Send Password Reset Link
                </button>
              </span>
                            </div>
                        </form>
                    </div>

                    @if (Route::has('register'))
                        <div class="mt-6">
                            <a href="{{route('login')}}" class="block text-sm font-medium leading-5 text-indigo-600 hover:text-indigo-500 text-center focus:outline-none transition ease-in-out duration-150">
                                Back to login
                            </a>
                        </div>
                    @endif


                </div>
            </div>
        </div>
        <div class="hidden lg:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full object-cover" src="https://www.netcompany.com/~/media/Netcompany/Contact/Netcompany-sign-updated.ashx" alt="" />
        </div>
    </div>
@endsection

