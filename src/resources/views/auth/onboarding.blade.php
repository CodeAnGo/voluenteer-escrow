
@extends('layouts.base')

@section('title', 'Complete Profile')

@section('content')
    <div class="min-h-screen bg-white flex">
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm">
                <div>

                    <h2 class="mt-6 text-3xl leading-9 font-medium text-gray-700 tracking-wide text-center">
                        Complete your profile
                    </h2>
                </div>

                <div class="mt-8">
                    <div class="mt-6">
                        <form action="{{ route('onboarding.store') }}" method="POST" id="charityForm" name="charityForm">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium leading-5 text-gray-700 text-center">
                                    Select charities
                                </label>
                                @foreach($charities_list as $charity)
                                    <div class="mt-2">
                                    <input type="checkbox" class="form-checkbox" name="{{$charity->name}}" value="{{$charity->id}}">
                                        <span class="ml-2">{{$charity->name}}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="my-2 mt-4">
                                <label class="block text-sm font-medium leading-5 text-gray-700 text-center">
                                    Attach a card
                                </label>
                                <div id="setup-form">
                                    <div id="card-element"></div>
                                </div>
                            </div>
                        </form>
                        <button type="submit" name="card-button" id="card-button" class="mt-6 w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                            Complete profile
                        </button>
                        <label class="block text-xs font-thin leading-5 text-gray-600 text-center">
                            By completing your profile you hereby authorise Netcompany A/S to send instructions to the financial institution that issued my card to take payments from my card account in accordance with the terms of my agreement with you.
                        </label>
                    </div>

                </div>
            </div>
        </div>
        <div class="hidden lg:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full object-cover" src="https://www.netcompany.com/~/media/Netcompany/Contact/Netcompany-sign-updated.ashx" alt="" />
        </div>

    </div>
@endsection

@push('js')
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ env('STRIPE_PUBLIC_KEY', 'pk_test_rTNg2U0zNrU46OQ72vqutnNO00gTut97d5') }}');

    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    var cardButton = document.getElementById('card-button');
    var clientSecret = "{{ $intent->client_secret }}";

    cardButton.addEventListener('click', function(ev) {

        stripe.confirmCardSetup(
            clientSecret,
            {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: "{{ Auth::user()->getName() }}",
                    },
                },
            }
        ).then(function(result) {
            if (result.error) {
                console.log(result.error)
            } else {
                document.getElementById('charityForm').submit();
            }
        });
    });

</script>

@endpush