<?php

namespace App\Http\Controllers\Stripe;

use App\Helpers\StripeHelper;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Stripe\Stripe;
use Illuminate\Foundation\Auth\User;

class OAuthRedirectController extends Controller
{
    public function onboardingResponse(Request $request){
        $receivedAuthorizationCode = $request->get('code');

        Stripe::setApiKey(Config::get('stripe.api_key'));

        $response = \Stripe\OAuth::token([
            'grant_type' => 'authorization_code',
            'code' => $receivedAuthorizationCode,
        ]);
        $email= User::where('id', Auth::id())->value('email');
        $stripe_customerid = StripeHelper::createStripeCustomer($email);

        Account::create([
            'user_id' => Auth::id(),
            'access_token' => $response->access_token,
            'refresh_token' => $response->refresh_token,
            'token_type' => $response->token_type,
            'stripe_publishable_key' => $response->stripe_publishable_key,
            'stripe_user_id' => $response->stripe_user_id,
            'stripe_customer_id'=>$stripe_customerid,
            'scope' => $response->scope
        ]);

        return redirect('/onboarding');
    }
}
