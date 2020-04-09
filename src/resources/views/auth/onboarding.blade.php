
@extends('layouts.base')

@section('title', 'Complete Profile')

@section('content')
    <div class="min-h-screen bg-white flex">
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm">
                <div>

                    <img class="h-12 w-auto justify-center" src="{{ asset('img/netcompany.63c83485.svg') }}" alt="Workflow" />
                    <h2 class="mt-6 text-3xl leading-9 font-thin text-gray-800 tracking-wide">
                        Complete your profile
                    </h2>
                </div>

                <div class="mt-8">
                    <div class="mt-6">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div>
                                <label for="charityselect" class="block text-sm font-medium leading-5 text-gray-700 text-center">
                                    Select charities (Ctrl + Click for multiple)
                                </label>
                                <select class="form-multiselect block w-full mt-1 appearance-none bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-50" name="item_id" multiple>
                                    @foreach($charities_list as $charity)
                                        <option value="{{$charity}}">{{$charity}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="py-5">
                                <label for="photoupload" class="block text-sm font-medium leading-5 text-gray-700 text-center">
                                    Upload your face
                                </label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <input id="photoupload" name="photoupload" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                </div>
                            </div>
                            Blocked until file upload done, needs styling too
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="hidden lg:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full object-cover" src="https://www.netcompany.com/~/media/Netcompany/Contact/Netcompany-sign-updated.ashx" alt="" />
        </div>

    </div>
@endsection
