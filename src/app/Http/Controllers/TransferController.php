<?php

namespace App\Http\Controllers;

use App\Transfer;
use App\TransferStatus;
use App\TransferStatusTransitions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use SM\SMException;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pages.dashing.transfers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //  'sending_party_id' => Auth::id(),
        $transfer = Transfer::create([

            'sending_party_id' =>12121,
            'status' => TransferStatus::AwaitingAcceptance,
            'charity_id'=>122,
        'delivery_first_name'=> $request->input('first_name'),
        'delivery_last_name'=> $request->input('last_name'),
        'delivery_email'=>$request->input('email_address'),
        'delivery_street'=>$request->input('street_address'),
       'delivery_city'=>$request->input('city'),
       'delivery_town'=>$request->input('state'),
        'delivery_postcode' =>$request->input('postal_code'),
       'delivery_country'=>$request->input('country'),
       'transfer_amount'=>$request->input('transfer_amount'),
        'transfer_reason'=>$request->input('transfer_reason'),
        'transfer_note'=>$request->input('transfer_note'),
       'stripe_id'=>'null',
        'escrow_link'=>'null'


        ]);

        //ToDO: Need to fill stripe_id,charity it
        $transfer->save();

        // TODO: return view
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
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
