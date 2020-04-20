<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Stripe\Stripe;

class OAuthRedirectController extends Controller
{
    public function onboardingResponse(Request $request){
        $receivedAuthorizationCode = $request->get('code');

        Stripe::setApiKey(Config::get('stripe.api_key'));

        $response = \Stripe\OAuth::token([
            'grant_type' => 'authorization_code',
            'code' => $receivedAuthorizationCode,
        ]);

        Account::create([
            'user_id' => Auth::id(),
            'access_token' => $response->access_token,
            'refresh_token' => $response->refresh_token,
            'token_type' => $response->token_type,
            'stripe_publishable_key' => $response->stripe_publishable_key,
            'stripe_user_id' => $response->stripe_user_id,
            'scope' => $response->scope
        ]);

        return redirect('/onboarding');
    }
}
