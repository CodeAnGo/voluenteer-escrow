@extends('layouts.dashing')

@section('title', __('dashboard.index.title'))
@section('content')
    <div class="">
        <div class="max-w-screen-xl mx-auto pt-12 pb-16 sm:pt-16 sm:pb-20 px-4 sm:px-6 lg:pt-20 lg:pb-28 lg:px-8">
            <h2 class="text-3xl leading-9 font-extrabold text-gray-900">
                How to use the Volunteer Payment App
            </h2>
            <div class="mt-6 border-t-2 border-gray-100 pt-10">
                <dl class="md:grid md:grid-cols-2 md:gap-8">
                    <div>
                        <div class="bg-gray-50 rounded-lg border p-4">
                            <dt class="text-lg leading-6 font-medium text-gray-900">
                                What's the best thing about Switzerland?
                            </dt>
                            <dd class="mt-2">
                                <p class="text-base leading-6 text-gray-500">
                                    I don't know, but the flag is a big plus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.
                                </p>
                            </dd>
                        </div>
                        <div class="bg-gray-50 rounded-lg border p-4 mt-6">
                            <dt class="text-lg leading-6 font-medium text-gray-900">
                                How do you make holy water?
                            </dt>
                            <dd class="mt-2">
                                <p class="text-base leading-6 text-gray-500">
                                    You boil the hell out of it. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.
                                </p>
                            </dd>
                        </div>
                        <div class="bg-gray-50 rounded-lg border p-4 mt-6">
                            <dt class="text-lg leading-6 font-medium text-gray-900">
                                What do you call someone with no body and no nose?
                            </dt>
                            <dd class="mt-2">
                                <p class="text-base leading-6 text-gray-500">
                                    Nobody knows. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.
                                </p>
                            </dd>
                        </div>
                    </div>
                    <div class="mt-6 md:mt-0">
                        <div class="bg-gray-50 rounded-lg border p-4">
                            <dt class="text-lg leading-6 font-medium text-gray-900">
                                What is the least spoken language in the world?
                            </dt>
                            <dd class="mt-2">
                                <p class="text-base leading-6 text-gray-500">
                                    Sign language. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.
                                </p>
                            </dd>
                        </div>
                        <div class="bg-gray-50 rounded-lg border p-4 mt-6">
                            <dt class="text-lg leading-6 font-medium text-gray-900">
                                Why can't you hear a pterodactyl go to the bathroom?
                            </dt>
                            <dd class="mt-2">
                                <p class="text-base leading-6 text-gray-500">
                                    Because the pee is silent. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.
                                </p>
                            </dd>
                        </div>
                        <div class="bg-gray-50 rounded-lg border p-4 mt-6">
                            <dt class="text-lg leading-6 font-medium text-gray-900">
                                Why did the invisible man turn down the job offer?
                            </dt>
                            <dd class="mt-2">
                                <p class="text-base leading-6 text-gray-500">
                                    He couldn't see himself doing it. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.
                                </p>
                            </dd>
                        </div>
                    </div>
                </dl>
                @endif
            </div>
        </div>
    </div>
@endsection
