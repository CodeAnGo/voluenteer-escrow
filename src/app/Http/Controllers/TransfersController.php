<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\TransferStatus;
use App\TransferStatusId;
use Illuminate\Foundation\Auth\User;
use App\TransferStatusTransitions;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;
use SM\SMException;
use App\Models\Charity;

class TransfersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $transfer_identifier = (Auth::User()->volunteer === 0 ? 'sending_party_id' : 'receiving_party_id');
        $other_identifier = (Auth::User()->volunteer === 0 ? 'receiving_party_id' : 'sending_party_id');

        $transfers = Transfer::where($transfer_identifier, Auth::id());

        $user_ids = $transfers->get($other_identifier);
        $users = User::whereIn('id', $user_ids);

        $charity_ids = $transfers->get('charity_id');
        $charities = Charity::whereIn('id', $charity_ids);

        $status_map = $this->getStatusMap();
        $closed_status_id = $this->getClosedStatus();
        $active_transfers = clone $transfers;
        $active_transfers = $active_transfers->whereNotIn('status', $closed_status_id);

        return view('dashboard', [
            'users' => $users->get(),
            'charities' => $charities->get(),
            'transfers' => $transfers->get(),
            'active_transfers' => $active_transfers->get(),
            'closed_status' => $closed_status_id,
            'volunteer' => !(Auth::User()->volunteer === 0),
            'status_map' => $status_map
        ]);
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



        $charities = Charities::all();

        /*TODO: need to change the API Key*/

        $cards=\Stripe\Customer::allSources(
            $stripeuserid,
            ['object' => 'card', 'limit' => 3]
        );

        $transfers = Transfer::where('sending_party_id',Auth::user()->id)->orderBy('id', 'desc')->get();

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
        Storage::makeDirectory('/evidence/' . $transfer->id . '/' . Auth::id());

        return redirect()->route('transfer.show');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function show($id)
    {
        $transfer = Transfer::where('id', $id)->first();
        $showDeliveryDetails =
            Auth::id() === $transfer->sending_party_id ||
            Auth::id() === $transfer->receiving_party_id;
        $is_sending_user = Auth::id() === $transfer->sending_party_id;

        $sending_user = User::where('id', $transfer->sending_party_id)->first();
        $receiving_user = User::where('id', $transfer->receiving_party_id)->first();

        $charity = Charity::where('id', $transfer->charity_id)->first();

        $status_map = $this->getStatusMap();
        $closed_status = $this->getClosedStatus();

        return view('pages.dashing.transfers.show', [
            'balance' => 1,
            'transfer' => $transfer,
            'charity' => $charity->name,
            'sending_user' => $sending_user,
            'receiving_user' => $receiving_user,
            'show_delivery_details' => $showDeliveryDetails,
            'is_sending_user' => $is_sending_user,
            'closed_status' => $closed_status,
            'status_map' => $status_map
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  uuid  $id
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
     * @param  uuid  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $transfer = Transfer::where('id', $id)->first();
        $statusTransition = $request->input('statusTransition');
        $isEdit = is_null($statusTransition);
        if ($isEdit) {
            if (Auth::id() === $transfer->sending_party_id and $transfer->status === TransferStatusId::AwaitingAcceptance) {
                //
            }
        } else {
            if ($statusTransition == TransferStatusTransitions::ToAccepted) {
                $transfer->receiving_party_id = Auth::id();
            }
            if ($statusTransition == TransferStatusTransitions::ToAwaitingAcceptance) {
                $transfer->receiving_party_id = null;
            }
            try {
                $transfer->statusStateMachine()->apply($statusTransition);
                $transfer->save();
            } catch (SMException $e) {
                // invalid status transition attempted
            }
        }
        return redirect()->route('transfers.show', [$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  uuid  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function getClosedStatus(){
        return [
            TransferStatusId::Cancelled,
            TransferStatusId::Closed,
            TransferStatusId::ClosedNonPayment,
            TransferStatusId::Rejected,
            TransferStatusId::InDispute
        ];
    }

    public function getStatusMap(){
        $reflection = new \ReflectionClass('App\TransferStatus');
        $status_map = array('Unable to get Status');
        foreach ($reflection->getConstants() as $value){
            array_push($status_map, $value);
        }
        return $status_map;
    }
}
