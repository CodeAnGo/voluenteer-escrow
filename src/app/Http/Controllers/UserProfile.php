<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Address;
use App\Models\Charity;
use App\Models\UserCharity;
use App\Models\StripeAccount;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;
use Stripe\Stripe;

class UserProfile extends Controller
{
    /**
     * Display the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $user = User::where('id', Auth::id())->first();

        $charities = Charity::join('user_charities', 'charities.id', '=', 'user_charities.charity_id')
            ->select('charities.name')
            ->where('user_charities.user_id', Auth::id())
            ->where('charities.active','=',true)
            ->get();

        $account = $this->getStripeAccountDetails(Auth::id());

        $addresses = Address::where('user_id', Auth::id())->get();

        return view('profile.index', [
            'user' => $user,
            'charities' => $charities,
            'account' => $account,
            'addresses' => $addresses
        ]);
    }

    /**
     * Show the form for editing the resource.
     *
     * @return Factory|View
     */
    public function edit()
    {
        $user = User::where('id', Auth::id())->first();
        $user_charities = UserCharity::where('user_id', Auth::id())->get();
        $charities = Charity::all();

        foreach ($charities as $charity) {
            $charity->checked = $user_charities->where('charity_id', $charity->id)->count() > 0;
        }

        $account = $this->getStripeAccountDetails(Auth::id());

        return view('profile.edit', [
            'user' => $user,
            'charities' => $charities,
            'user_charities' => $user_charities,
            'account' => $account,
        ]);
    }

    /**
     * Update the resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|between:1,255',
            'last_name' => 'required|between:1,255',
            'email' => 'required|between:1,255|email',
        ]);

        $user = User::where('id', Auth::id())->first();
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->save();

        $selected_charity_ids = [];
        foreach($request->input() as $key => $value) {
            if (substr($key, 0, strlen('charity_checkbox_')) === 'charity_checkbox_') {
                array_push($selected_charity_ids, $value);
            }
        }
        $existing_user_charities = UserCharity::where('user_id', Auth::id())->get();
        $existing_user_charity_ids = $existing_user_charities->map(function ($user_charity) {
            return $user_charity->charity_id;
        })->toArray();
        $user_charities_to_create = array_diff($selected_charity_ids, $existing_user_charity_ids);
        foreach($existing_user_charities->whereNotIn('charity_id', $selected_charity_ids) as $user_charity) {
            $user_charity->delete();
        }
        foreach($user_charities_to_create as $user_charity_id) {
            UserCharity::create([
                'user_id' => Auth::id(),
                'charity_id' => $user_charity_id
            ]);
        }

        return redirect()->route('profile.index');
    }

    private function getStripeAccountDetails($user_id) {
        $account = Account::where('user_id', $user_id)->first();
        Stripe::setApiKey(Config::get('stripe.api_key'));
        $stripe_account =  \Stripe\Account::retrieve($account->stripe_user_id);

        $address = new Address();
        $address->line1 = $stripe_account->business_profile->support_address->line1 ?? null;
        $address->line2 = $stripe_account->business_profile->support_address->line2 ?? null;
        $address->city = $stripe_account->business_profile->support_address->city ?? null;
        $address->county = $stripe_account->business_profile->support_address->state ?? null;
        $address->postcode = $stripe_account->business_profile->support_address->postal_code ?? null;
        $address->country = $stripe_account->business_profile->support_address->country ?? null;

        $account = new StripeAccount();
        $account->address = $address;
        $account->phone = $stripe_account->business_profile->support_phone ?? null;

        return $account;
    }
}
