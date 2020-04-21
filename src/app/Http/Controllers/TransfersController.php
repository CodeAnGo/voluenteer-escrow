<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Address;
use App\Models\Transfer;
use App\Jobs\CreateFreshdeskTicket;
use App\TransferStatus;
use App\TransferStatusId;
use Exception;
use Illuminate\Foundation\Auth\User;
use App\TransferStatusTransitions;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use OwenIt\Auditing\Models\Audit;
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

        return view('transfers.index', [
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
     * @return Factory|View
     */
    public function create()
    {

        \Stripe\Stripe::setApiKey(config('stripe.api_key'));
        $stripeuserid = Account::where('user_id', Auth::id())->value('stripe_user_id');

        $charities = Charity::all();

        $cards = [];

        $transfers = Transfer::where('sending_party_id',Auth::user()->id)->orderBy('id', 'desc')->get();
        $addresses = Address::where('user_id', Auth::id())->get();

        return view('transfers.create', [
            'charities'=>$charities,
            'transfers'=>$transfers,
            'cards'=>$cards,
            'addresses' => $addresses
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->get('user_address_select')) {
            $address = Address::where('id', $request->get('user_address_select'))->first();
            $addressline =  ($address->line2) ? $addressline = $address->line1 . ", " . $address->line2 : $address->line1;

            $transfer = Transfer::create([
                'sending_party_id' => Auth::id(),
                'status' => TransferStatusId::AwaitingAcceptance,
                'delivery_first_name' => $request->get('first_name'),
                'delivery_last_name' => $request->get('last_name'),
                'delivery_email' => $request->get('email_address'),
                'delivery_street' => $addressline,
                'delivery_city' => $address->city,
                'delivery_county' => $address->county,
                'delivery_postcode' => $address->postcode,
                'delivery_country' => $address->country,
                'transfer_amount' => $request->get('transfer_amount'),
                'transfer_reason' => $request->get('transfer_reason'),
                'transfer_note' => $request->get('transfer_note'),
                'charity_id' => $request->get('charity'),
                'stripe_id' => 1,
            ]);
        } else {
            $transfer = Transfer::create([
                'sending_party_id' => Auth::id(),
                'status' => TransferStatusId::AwaitingAcceptance,
                'delivery_first_name' => $request->get('first_name'),
                'delivery_last_name' => $request->get('last_name'),
                'delivery_email' => $request->get('email_address'),
                'delivery_street' => $request->get('street_address'),
                'delivery_city' => $request->get('city'),
                'delivery_county' => $request->get('county'),
                'delivery_postcode' => $request->get('postal_code'),
                'delivery_country' => $request->get('country'),
                'transfer_amount' => $request->get('transfer_amount'),
                'transfer_reason' => $request->get('transfer_reason'),
                'transfer_note' => $request->get('transfer_note'),
                'charity_id' => $request->get('charity'),
                'stripe_id' => 1,
            ]);
        }
        Storage::makeDirectory('/evidence/' . $transfer->id . '/' . Auth::id());

        $this->dispatch(new CreateFreshdeskTicket($transfer->id));

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
        $is_receiving_user = Auth::id() === $transfer->receiving_party_id;

        $sending_user = User::where('id', $transfer->sending_party_id)->first();
        $receiving_user = User::where('id', $transfer->receiving_party_id)->first();

        $charity = Charity::where('id', $transfer->charity_id)->first();

        $status_map = $this->getStatusMap();
        $closed_status = $this->getClosedStatus();
        $history = Audit::where('auditable_type', 'App\Models\Transfer')
            ->where('auditable_id', $transfer->id)
            ->orderBy('created_at', 'desc');

        $user_ids = $history->get('user_id');
        $change_users = User::whereIn('id', $user_ids)->get();

        return view('transfers.show', [
            'balance' => 1,
            'transfer' => $transfer,
            'charity' => $charity->name,
            'sending_user' => $sending_user,
            'receiving_user' => $receiving_user,
            'show_delivery_details' => $showDeliveryDetails,
            'is_sending_user' => $is_sending_user,
            'is_receiving_user' => $is_receiving_user,
            'closed_status' => $closed_status,
            'transfer_history' => $history->get(),
            'change_users' => $change_users,
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
     * @return RedirectResponse
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
            if ($statusTransition == TransferStatusTransitions::ToAwaitingAcceptance) {
                $transfer->receiving_party_id = null;
            }
            if ($statusTransition == TransferStatusTransitions::ToAccepted || $statusTransition == TransferStatusTransitions::ToRejected) {
                $transfer->receiving_party_id = Auth::id();
            }
            if ($transfer->transitionAllowed($statusTransition)) {
                try {
                    $transfer->transition($statusTransition);
                    $transfer->save();
                } catch (Exception $e) {
                    // unable to transition
                }
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
        $reflection = new \ReflectionClass(TransferStatus::class);
        $status_map = array('Unable to get Status');
        foreach ($reflection->getConstants() as $value){
            array_push($status_map, $value);
        }
        return $status_map;
    }
}
