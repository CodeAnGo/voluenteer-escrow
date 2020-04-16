<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\TransferStatus;
use App\TransferStatusTransitions;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use SM\SMException;

class TransfersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('transfers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        \Stripe\Stripe::setApiKey('sk_test_CpMtZaazIi49jN69Efg6Nmfg00ZmtTLqVg');
        $stripeuserid = DB::table('accounts')->where('user_id',1)->value('stripe_user_id');


        //storing a card
        /* $customer = \Stripe\Customer::create([
             'email' => 'madhu.pasumarthi@netcompany.com',
             'source' => 'tok_mastercard',
         ]);*/



        //create a Payment Method
        $paymentMethod= \Stripe\PaymentMethod::create([
            'type' => 'card',
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => 5,
                'exp_year' => 2022,
                'cvc' => '314',
            ],
        ]);


        //attach a payment method to customer
        /* $paymentMethod->attach([
             'customer' => 'cus_H6j2ch993HJ1V0',
         ]);*/

        //Get all payment methods
        /*$test=\Stripe\PaymentMethod::all([
               'customer' => 'cus_H6j2ch993HJ1V0',
               'type' => 'card'
           ]);*/



        /*  $token = \Stripe\Token::create([
               'customer' => 'cus_H6j2ch993HJ1V0'
           ], [
               'stripe_account' => 'acct_1GY8DHKRhsQ7vJ1Q',
           ]);*/


        // Create a PaymentIntent:
//        $paymentIntent = \Stripe\PaymentIntent::create([
//            'payment_method_types' => ['card'],
//            'amount' => 1000,
//            'currency' => 'gbp',
//            'transfer_data' => [
//                'destination' => 'acct_1GY8DHKRhsQ7vJ1Q'
//            ]
//        ]);
//
//         $paymentIntent->confirm([
//            'payment_method' => 'pm_card_visa',
//        ]);
// Bal before £1343.66
        /*  $transfer = \Stripe\Transfer::create([
             'amount' => 1000,
             'currency' => 'gbp',
             'source_transaction' => 'ch_1GYYpBFr4BzKbeoHkGkkzUoL',
             'destination' => 'acct_1GY8DHKRhsQ7vJ1Q'
          ]);*/



        // Create a Transfer to a connected account (later):
//        $transfer = \Stripe\Transfer::create([
//            'amount' => 100,
//            'currency' => 'gbp',
//            'destination' => 'acct_1GYYTCEc7FISZ7Zp',
//            'transfer_group' => 'foo'
//        ]);



        $charities = DB::table('charities')->get();


        /*TODO: need to change the API Key*/

        $cards=\Stripe\Customer::allSources(
            $stripeuserid,
            ['object' => 'card', 'limit' => 3]
        );

        $transfers= DB::table('transfers')->where('sending_party_id',1) ->orderByRaw('id DESC')->get();
        return view('pages.dashing.transfers.create',['charities'=>$charities,'transfers'=>$transfers,'cards'=>$cards]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $transfer = Transfer::create([
            'sending_party_id' => Auth::id(),
            'status' => TransferStatus::AwaitingAcceptance,
        ]); // TODO: add attributes from transfer creation form in here

        return redirect()->route('transfer.show');
    }

    /**
     * Display the specified resource.
     *
     * @param Transfer $transfer
     * @return Factory|View
     */
    public function show(Transfer $transfer)
    {
        $showDeliveryDetails =
            Auth::id() === $transfer->sending_party_id ||
            Auth::id() === $transfer->receiving_party_id;

        // return view('transfer', ['showDeliveryDetails' => $showDeliveryDetails]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $transfer = Transfer::where('id', $id)->first();
        $statusTransition = $request->input('statusTransition');

        if (!is_null($statusTransition)) // update should always have statusTransition EXCEPT when Sending Party is editing an Awaiting Acceptance transfer
        {
            if ($request->input('statusTransition') === TransferStatusTransitions::ToAccepted) {
                $transfer->receiving_party_id = $request.auth()->id();
            }
            try {
                $transfer->statusStateMachine()->apply($statusTransition);
                $transfer->save();
            } catch (SMException $e) {
                // invalid status transition attempted
            }
        } else {
            if ($transfer->status === TransferStatus::AwaitingAcceptance) {
                $transfer->fill($request->all());
                $transfer->save();
            }
        }

        // TODO: return view
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
