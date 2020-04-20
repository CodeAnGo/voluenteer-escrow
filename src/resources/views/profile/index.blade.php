@extends('layouts.dashing')

@section('title', __('profile.index.title'))
@section('header_title', __('profile.index.title'))
@section('header_buttons')
    <a href="{{ route('profile.edit') }}" class="float-right ml-4 inline-flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
        {{ __('profile.edit_profile') }}
    </a>
@endsection

@section('content')
    @include('profile.show')
@endsection
