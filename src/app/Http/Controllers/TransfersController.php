<?php

namespace App\Http\Controllers;

use App\Jobs\CreateFreshdeskTicket;
use App\Transfer;
use App\TransferStatus;
use App\TransferStatusTransitions;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\User;
use App\Charity;
use Ramsey\Uuid\Uuid;
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
        $transfer_identifier = (Auth::User()->volunteer === 0 ? 'sending_party_id' : 'receiving_party_id');
        $other_identifier = (Auth::User()->volunteer === 0 ? 'receiving_party_id' : 'sending_party_id');

        $transfers = Transfer::where($transfer_identifier, Auth::id());

        $user_ids = $transfers->get($other_identifier);
        $users = User::whereIn('id', $user_ids);

        $charity_ids = $transfers->get('charity_id');
        $charities = Charity::whereIn('id', $charity_ids);

        $reflection = new \ReflectionClass('App\TransferStatus');
        $status_map = array_flip($reflection->getConstants());

        $closed_status = [
            TransferStatus::Cancelled,
            TransferStatus::Closed,
            TransferStatus::ClosedNonPayment
        ];
        $active_transfers = clone $transfers;
        $active_transfers = $active_transfers->whereNotIn('status', $closed_status);

        return view('dashboard', [
            'status_map' => $status_map,
            'users' => $users->get(),
            'charities' => $charities->get(),
            'transfers' => $transfers->get(),
            'active_transfers' => $active_transfers->get(),
            'closed_status' => $closed_status,
            'volunteer' => !(Auth::User()->volunteer === 0),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $transfer_id = 1;
        $this->dispatch(new CreateFreshdeskTicket($transfer_id));
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
            Auth::id() === $transfer->sending_party_id;
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
