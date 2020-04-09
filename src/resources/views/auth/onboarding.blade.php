
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
                                <label for="item_id" class="block text-sm font-medium leading-5 text-gray-700">
                                    Select charities
                                </label>
                                <select class="form-control" name="item_id">
                                    @foreach($charities_list as $charity)
                                        <option value="{{$charity}}">{{$charity}}</option>
                                    @endforeach
                                </select>
                            </div>
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
