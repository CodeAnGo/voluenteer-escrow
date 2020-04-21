<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressCreateRequest;
use App\Http\Requests\UserAddressUpdateRequest;
use App\Http\Requests\UserProfileUpdateRequest;
use App\Models\Address;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;

class UserAddress extends Controller
{
    /**
     * Display the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())->get();

        return view('addresses.index', [
            'addresses' => $addresses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('addresses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserAddressCreateRequest $request
     * @return RedirectResponse
     */
    public function store(UserAddressCreateRequest $request)
    {
        $request->validated();

        Address::create([
            'user_id' => Auth::id(),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'line1' => $request->get('line1'),
            'line2' => $request->get('line2'),
            'city' => $request->get('city'),
            'county' => $request->get('county'),
            'postcode' => $request->get('postcode'),
            'country' => $request->get('country'),
        ]);

        return redirect()->route('addresses.index');
    }

    /**
     * Show the form for editing the resource.
     *
     * @param uuid $id
     * @return Factory|RedirectResponse|View
     */
    public function edit($id)
    {
        $address = Address::where('id', $id)->first();

        if (!isset($address) || $address->user_id !== Auth::id()) {
            return redirect()->route('address.index');
        }

        return view('addresses.edit', ['address' => $address]);
    }

    /**
     * Update the resource in storage.
     *
     * @param UserAddressUpdateRequest $request
     * @param uuid $id
     * @return Factory|RedirectResponse|View
     */
    public function update(UserAddressUpdateRequest $request, $id)
    {
        $request->validated();

        $address = Address::where('id', $id)->first();
        $address->first_name = $request->get('first_name');
        $address->last_name = $request->get('last_name');
        $address->email = $request->get('email');
        $address->phone = $request->get('phone');
        $address->line1 = $request->get('line1');
        $address->line2 = $request->get('line2');
        $address->city = $request->get('city');
        $address->county = $request->get('county');
        $address->postcode = $request->get('postcode');
        $address->country = $request->get('country');
        $address->save();

        return redirect()->route('addresses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  uuid $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $address = Address::where('id', $id)->first();
        if ($address->user_id === Auth::id()) {
            $address->delete();
        }

        return redirect()->route('addresses.index');
    }
}
