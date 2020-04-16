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
use Illuminate\View\View;
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

        $closed_status_id = [
            TransferStatusId::Cancelled,
            TransferStatusId::Closed,
            TransferStatusId::ClosedNonPayment,
            TransferStatusId::Rejected,
            TransferStatusId::InDispute
        ];
        $active_transfers = clone $transfers;
        $active_transfers = $active_transfers->whereNotIn('status', $closed_status_id);

        $reflection = new \ReflectionClass('App\TransferStatus');
        $status_map = array('Unable to get Status');
        foreach ($reflection->getConstants() as $value){
            array_push($status_map, $value);
        }

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
        //
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

        $reflection = new \ReflectionClass('App\TransferStatus');
        $status_map = array('Unable to get Status');
        foreach ($reflection->getConstants() as $value){
            array_push($status_map, $value);
        }

        $closed_status = [
            TransferStatusId::Cancelled,
            TransferStatusId::Closed,
            TransferStatusId::ClosedNonPayment,
            TransferStatusId::Rejected,
            TransferStatusId::InDispute
        ];

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
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $transfer = Transfer::where('id', $id)->first();
        $charity = Charity::where('id', $transfer->charity_id)->first();
        if(Auth::id() === $transfer->sending_party_id) {
            return view('pages.dashing.transfers.edit', [
                'transfer' => $transfer,
                'charity' => $charity->name
            ]);
        }else{
            return redirect()->route('transfers.show', [$id]);
        }
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
        $isEdit = is_null($statusTransition);
        if ($isEdit) {
            if (Auth::id() === $transfer->sending_party_id and $transfer->status === TransferStatusId::AwaitingAcceptance) {
                $updatedTransfer = $transfer;
                $updatedTransfer->delivery_first_name = request('first_name');
                $updatedTransfer->delivery_last_name = request('last_name');
                $updatedTransfer->delivery_email = request('email_address');
                $updatedTransfer->delivery_street = request('street_address');
                $updatedTransfer->delivery_city = request('city');
                $updatedTransfer->delivery_town = request('state');
                $updatedTransfer->delivery_postcode = request('postal_code');
                $updatedTransfer->delivery_country = request('country');
                $updatedTransfer->transfer_reason = request('transfer_reason');
                $updatedTransfer->transfer_note = request('transfer_note');
                $transfer->save();
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
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
