<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferCreateRequest;
use App\Http\Requests\TransferUpdateRequest;
use App\Http\Requests\TransferUpdateStatusRequest;
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
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use OwenIt\Auditing\Models\Audit;
use Ramsey\Uuid\Uuid;
use App\Models\Charity;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use App\Helpers\StripeHelper;

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
     * @throws ApiErrorException
     */
    public function create()
    {
        Stripe::setApiKey(Config::get('stripe.api_key'));

        $account = Account::where('user_id', Auth::id())->first();

        $stripe_account =  \Stripe\Account::retrieve($account->stripe_user_id);

        $charities = Charity::where('active', true)->orderBy('name', 'asc')->get();
        $cards = [];

        $addresses = Address::where('user_id', Auth::id())->get();

        //Lists all existing cards stored in Stripe
        //$cards= StripeHelper::listAllCards(Auth::user()->id);


        return view('transfers.create',[
            'charities' => $charities,
            'cards' => $cards,
            'addresses' => $addresses,
            'phone' => $stripe_account->business_profile->support_phone ?? '',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TransferCreateRequest $request
     * @return RedirectResponse
     */
    public function store(TransferCreateRequest $request)
    {
        $request->validated();

        $address = Address::where('id', $request->get('user_address_select'))->first();

        //Stripe accepts the amount in integer
        $amount=($request->input('transfer_amount'))*100;
        // Creates a Payment Intent to transfer amount from Senders Card to Senders Stripe Account
        $paymentIntent=StripeHelper::createPaymentIntent($amount,Auth::id());

        $transfer = Transfer::create([
            'sending_party_id' => Auth::id(),
            'status' => TransferStatusId::AwaitingAcceptance,
            'delivery_first_name' => $request->get('delivery_first_name'),
            'delivery_last_name' => $request->get('delivery_last_name'),
            'delivery_email' => $request->get('delivery_email'),
            'delivery_phone' => $request->get('delivery_phone'),
            'delivery_street_1' => $address->line1,
            'delivery_street_2' => $address->line2,
            'delivery_city' => $address->city,
            'delivery_county' => $address->county,
            'delivery_postcode' => $address->postcode,
            'delivery_country' => $address->country,
            'transfer_amount' => $request->get('transfer_amount'),
            'transfer_reason' => $request->get('transfer_reason'),
            'transfer_note' => $request->get('transfer_note'),
            'charity_id' => $request->get('charity_id'),
            'stripe_id' => 1,
            'freshdesk_id' => 1,
            'stripe_payment_intent'=>$paymentIntent,
            'transfer_group'=>now()->format('Ymd His')
        ]);
        Storage::makeDirectory('/evidence/' . $transfer->id . '/' . Auth::id());
        Storage::makeDirectory('/dispute/' . $transfer->id . '/' . Auth::id());

        $this->dispatch(new CreateFreshdeskTicket($transfer->id));
        return redirect()->route('transfers.show', ['transfer' => $transfer->id]);
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

        $sending_user = User::where('id', $transfer->sending_party_id)->first();
        $receiving_user = User::where('id', $transfer->receiving_party_id)->first();

        $charity = Charity::where('id', $transfer->charity_id)->first();

        $status_map = $this->getStatusMap();
        $closed_status = $this->getClosedStatus();
        $history = Audit::where('auditable_type', Transfer::class)
            ->where('auditable_id', $transfer->id)
            ->orderBy('created_at', 'desc');

        $user_ids = $history->get('user_id');
        $change_users = User::whereIn('id', $user_ids)->get();

        return view('transfers.show', [
            'transfer' => $transfer,
            'charity' => $charity ? $charity->name : '-',
            'sending_user' => $sending_user,
            'receiving_user' => $receiving_user,
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
     * @return Factory|RedirectResponse|View
     */
    public function edit($id)
    {
        $transfer = Transfer::where('id', $id)->first();

        if (!isset($transfer) || $transfer->sending_party_id !== Auth::id()) {
            return redirect()->route('transfers.index');
        }

        $charity = Charity::where('id', $transfer->charity_id)->first();

        return view('transfers.edit', [
            'transfer' => $transfer,
            'charity' => $charity ? $charity->name : '-',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TransferUpdateRequest $request
     * @param uuid $id
     * @return RedirectResponse
     */
    public function update(TransferUpdateRequest $request, $id)
    {
        $request->validated();

        $transfer = Transfer::where('id', $id)->first();
        if ($transfer->status === TransferStatusId::AwaitingAcceptance || $transfer->status === TransferStatusId::Rejected) {
            $transfer->delivery_first_name = $request->get('delivery_first_name');
            $transfer->delivery_last_name = $request->get('delivery_last_name');
            $transfer->delivery_email = $request->get('delivery_email');
            $transfer->delivery_phone = $request->get('delivery_phone');
            $transfer->delivery_street_1 = $request->get('delivery_street_1');
            $transfer->delivery_street_2 = $request->get('delivery_street_2');
            $transfer->delivery_city = $request->get('delivery_city');
            $transfer->delivery_county = $request->get('delivery_county');
            $transfer->delivery_postcode = $request->get('delivery_postcode');
            $transfer->delivery_country = $request->get('delivery_country');
            $transfer->transfer_reason = $request->get('transfer_reason');
            $transfer->transfer_note = $request->get('transfer_note');
            $transfer->save();
        }
        return redirect()->route('transfers.show', [$id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TransferUpdateStatusRequest $request
     * @param uuid $id
     * @param int $statusTransition
     * @return RedirectResponse
     */
    public function statusUpdate(TransferUpdateStatusRequest $request, $id, $statusTransition)
    {
        $transfer = Transfer::where('id', $id)->first();
        $sending_user =  $transfer->sending_party_id;

        if ($statusTransition == TransferStatusTransitions::ToAwaitingAcceptance) {
            $transfer->receiving_party_id = null;
        }
        if ($statusTransition == TransferStatusTransitions::ToAccepted ) {
            $transfer->receiving_party_id = Auth::id();
            //Transfer amount from Senders stripe account to Platform account
            StripeHelper::createTransfertoPlatform(round($transfer->transfer_amount)*100,$sending_user,$transfer->transfer_group);
        }

        if ( $statusTransition == TransferStatusTransitions::ToRejected) {
            $transfer->receiving_party_id = Auth::id();
        }

        if ( $statusTransition == TransferStatusTransitions::ToApproved) {
            //Transfer amount from platform account to Volunteers stripe account.
            StripeHelper::createTransfer(round($transfer->actual_amount)*100, $transfer->receiving_party_id,$transfer->transfer_group);
        }

        if ($transfer->transitionAllowed($statusTransition)) {
            try {
                $transfer->transition($statusTransition);
                $transfer->save();
            } catch (Exception $e) {
                // unable to transition
            }
        }

        return redirect()->route('transfers.show', $id);
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
