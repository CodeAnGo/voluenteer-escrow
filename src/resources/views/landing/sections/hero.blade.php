<div class="relative bg-white overflow-hidden">
    <div class="hidden lg:block lg:absolute lg:inset-0">
        <svg class="absolute top-0 left-1/2 transform translate-x-64 -translate-y-8" width="640" height="784" fill="none" viewBox="0 0 640 784">
            <defs>
                <pattern id="9ebea6f4-a1f5-4d96-8c4e-4c2abf658047" x="118" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                </pattern>
            </defs>
            <rect y="72" width="640" height="640" class="text-gray-50" fill="currentColor" />
            <rect x="118" width="404" height="784" fill="url(#9ebea6f4-a1f5-4d96-8c4e-4c2abf658047)" />
        </svg>
    </div>
    <div class="relative pt-6 pb-16 md:pb-20 lg:pb-24 xl:pb-32" @click.away="open = false" class="relative" x-data="{ open: false }">
        <nav class="relative max-w-screen-xl mx-auto flex items-center justify-between px-4 sm:px-6">
            <div class="flex items-center flex-1">
                <div class="flex items-center justify-between w-full md:w-auto">
                    <a href="#">
                        <img class="h-8 w-auto sm:h-10" src="{{ asset('img/netcompany.63c83485.svg') }}" alt="" />
                    </a>
                    <div @click="open = !open" class="-mr-2 flex items-center md:hidden">
                        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="hidden md:block md:ml-10">
                    <a href="#" class="font-medium text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition duration-150 ease-in-out">Product</a>
                    <a href="#" class="ml-10 font-medium text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition duration-150 ease-in-out">Features</a>
                    <a href="#" class="ml-10 font-medium text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition duration-150 ease-in-out">Marketplace</a>
                    <a href="https://netcompany.com/" class="ml-10 font-medium text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition duration-150 ease-in-out">Company</a>
                </div>
            </div>
            <div class="hidden md:block text-right">
        <span class="inline-flex rounded-md shadow-md">
            <span class="inline-flex rounded-md shadow-xs">
                @if (Auth::check())
                    <a href="/dashboard" class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-blue-900 hover:bg-gray-700 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        My Dashboard
                    </a>
                @else
                    <a href="/login" class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Log in
                    </a>
                @endif
            </span>
        </span>
            </div>
        </nav>

        <!--
          Mobile menu, show/hide based on menu open state.

          Entering: "duration-150 ease-out"
            From: "opacity-0 scale-95"
            To: "opacity-100 scale-100"
          Leaving: "duration-100 ease-in"
            From: "opacity-100 scale-100"
            To: "opacity-0 scale-95"
        -->

{{--        <div @click.away="open = false" class="relative" x-data="{ open: false }">--}}
{{--            <button value="copy" @click="open = !open" onclick="copyToClipboard('{{ env('APP_URL') . '/transfers/'. $transfer->id }}')" class="ml-4 inline-flex items-center justify-center py-2 px-4 rounded shadow-md border-b-2 border-indigo-500 hover:border-indigo-700 focus:border-indigo-700 bg-white hover:bg-indigo-500 focus:bg-indigo-500 text-md font-medium text-indigo-500 hover:text-white focus:text-white transition duration-150 ease-in-out">--}}
{{--                <span class="mr-2 hidden md:inline-flex">{{ __('transfers.copy_link') }}</span>--}}
{{--                <span class="mr-2 sm:inline-flex md:hidden">{{ __('common.copy') }}</span>--}}
{{--                <svg fill="currentColor" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">--}}
{{--                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z"></path>--}}
{{--                </svg>--}}
{{--            </button>--}}
{{--            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 origin-top-right">--}}
{{--                <div class="rounded-md bg-white shadow-2xl py-1 border border-gray-200 w-64 sm:w-96">--}}
{{--                    <p class="block px-4 py-2 text-sm leading-5 font-medium text-gray-500">{{ __('transfers.copy_link_text') }}</p>--}}
{{--                    <p class="block px-4 py-2 text-sm leading-5 text-gray-700 select-all">{{ env('APP_URL') . '/transfers/'. $transfer->id }}</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
            <div class="rounded-lg shadow-md">
                <div class="rounded-lg bg-white shadow-xs overflow-hidden" x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95">
                    <div class="px-5 pt-4 flex items-center justify-between">
                        <div>
                            <img class="h-8 w-auto" src="/img/logos/workflow-mark-on-white.svg" alt="" />
                        </div>
                        <div class="-mr-2">
                            <button type="button" @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="px-2 pt-2 pb-3">
                        <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out">Product</a>
                        <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out">Features</a>
                        <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out">Marketplace</a>
                        <a href="https://netcompany.com/" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out">Company</a>
                    </div>
                    <div>
                        @if (Auth::check())
                            <a href="/dashboard" class="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100 hover:text-indigo-700 focus:outline-none focus:bg-gray-100 focus:text-indigo-700 transition duration-150 ease-in-out">
                                Dashboard
                            </a>
                        @else
                            <a href="/login" class="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100 hover:text-indigo-700 focus:outline-none focus:bg-gray-100 focus:text-indigo-700 transition duration-150 ease-in-out">
                                Log in
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 mx-auto max-w-screen-xl px-4 sm:mt-12 sm:px-6 md:mt-20 xl:mt-24">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                    <div class="text-sm font-semibold uppercase tracking-wide text-gray-500 sm:text-base lg:text-sm xl:text-base">
                        Coming soon
                    </div>
                    <h2 class="mt-1 text-4xl tracking-tight leading-10 font-extrabold text-gray-900 sm:leading-none sm:text-5xl lg:text-4xl xl:text-5xl">
                        Protecting the Vulnerable
                        <br class="hidden md:inline" />
                        <span class="text-blue-900">Empowering Volunteers</span>
                    </h2>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl leading-relaxed">
                        Through digital innovation and specialist knowledge we are laying the foundations for the next generation of volunteers with VolPayments, an escrow-based mobile application.
                        By using cutting edge technology, we are enabling the charitable efforts of those that want to help and supporting the most vulnerable who depend on that help.
                    </p>
                    <div class="mt-5 sm:max-w-lg sm:mx-auto sm:text-center lg:text-left lg:mx-0">
                        <p class="text-base font-medium text-gray-900">
                            Sign up to get notified when it’s ready.
                        </p>
                        <form action="#" method="POST" class="mt-3 sm:flex">
                            <input aria-label="Email" class="appearance-none block w-full px-3 py-3 border border-gray-300 text-base leading-6 rounded-md placeholder-gray-500 shadow-sm focus:outline-none focus:placeholder-gray-400 focus:shadow-outline focus:border-blue-300 transition duration-150 ease-in-out sm:flex-1" placeholder="Enter your email" />
                            <button type="submit" class="mt-3 w-full px-6 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-blue-900 shadow-sm hover:bg-gray-700 focus:outline-none focus:shadow-outline active:bg-gray-900 transition duration-150 ease-in-out sm:mt-0 sm:ml-3 sm:flex-shrink-0 sm:inline-flex sm:items-center sm:w-auto">
                                Notify me
                            </button>
                        </form>
                        <p class="mt-3 text-sm leading-5 text-gray-500">
                            We care about the protection of your data. Read our
                            <a href="#" class="font-medium text-gray-900 underline">Privacy Policy</a>.
                        </p>
                    </div>
                </div>
                <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                    <svg class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-8 scale-75 origin-top sm:scale-100 lg:hidden" width="640" height="784" fill="none" viewBox="0 0 640 784">
                        <defs>
                            <pattern id="4f4f415c-a0e9-44c2-9601-6ded5a34a13e" x="118" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                            </pattern>
                        </defs>
                        <rect y="72" width="640" height="640" class="text-gray-50" fill="currentColor" />
                        <rect x="118" width="404" height="784" fill="url(#4f4f415c-a0e9-44c2-9601-6ded5a34a13e)" />
                    </svg>
                    <div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md">
                        <button class="relative block w-full rounded-lg overflow-hidden focus:outline-none focus:shadow-outline">
                            <img class="w-full" src="https://images.unsplash.com/photo-1556740758-90de374c12ad?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Woman making a sale" />
                            <div class="absolute inset-0 w-full h-full flex items-center justify-center">
                                <svg class="h-20 w-20 text-indigo-500" fill="currentColor" viewBox="0 0 84 84">
                                    <circle opacity="0.9" cx="42" cy="42" r="42" fill="white" />
                                    <path d="M55.5039 40.3359L37.1094 28.0729C35.7803 27.1869 34 28.1396 34 29.737V54.263C34 55.8604 35.7803 56.8131 37.1094 55.9271L55.5038 43.6641C56.6913 42.8725 56.6913 41.1275 55.5039 40.3359Z" />
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
