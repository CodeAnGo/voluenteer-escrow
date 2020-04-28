<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferCreateRequest;
use App\Http\Requests\TransferUpdateRequest;
use App\Http\Requests\TransferUpdateStatusRequest;
use App\Models\Account;
use App\Models\Address;
use App\Models\Transfer;
use App\Jobs\CreateFreshdeskTicket;
use App\Models\TransferEvidence;
use App\Repositories\Interfaces\StripeServiceRepositoryInterface;
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
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransferGenericMail;
use App\Mail\TransferDisputeMail;
use App\Models\TransferFile;


class TransfersController extends Controller
{
    private $stripeServiceRepository;


    /**
     * TransfersController constructor.
     * @param StripeServiceRepositoryInterface $stripeServiceRepository
     */
    public function __construct(StripeServiceRepositoryInterface $stripeServiceRepository)
    {
        $this->stripeServiceRepository = $stripeServiceRepository;
    }


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
        $stripe_account =  $this->stripeServiceRepository->getAccountFromUser(Auth::user());

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

        $paymentIntent = $this->stripeServiceRepository->createPaymentIntentFromUser(Auth::user(), $request->get('transfer_amount'));

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
            'stripe_id' => Auth::user()->account->id,
            'freshdesk_id' => 1,
            'stripe_payment_intent' => $paymentIntent->id,
            'transfer_group' => $paymentIntent->transfer_group
        ]);
        Storage::makeDirectory('/evidence/' . $transfer->id . '/' . Auth::id());
        Storage::makeDirectory('/dispute/' . $transfer->id . '/' . Auth::id());

        $this->dispatch(new CreateFreshdeskTicket($transfer->id));

        app('App\Http\Controllers\TransferFilesController')->store($request, $transfer->id);

        return redirect()->route('transfers.show', ['transfer' => $transfer->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param Transfer $transfer
     * @return Factory|View
     */
    public function show(Transfer $transfer)
    {
        Notification::where('transfer_id', $transfer->id)->where('user_id', Auth::id())->delete();

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
            'charity' => $charity ? $charity->name : 'No Charity Oversight (Not Recommended)',
            'sending_user' => $sending_user,
            'receiving_user' => $receiving_user,
            'closed_status' => $closed_status,
            'transfer_history' => $history->get(),
            'change_users' => $change_users,
            'status_map' => $status_map,
            'transfer_files' => TransferFile::where('transfer_id', $transfer->id)->get(),
            'transferEvidence' => TransferEvidence::where('transfer_id', $transfer->id)->get(),
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
        $sending_user = $transfer->sending_party_id;

        $status_map = $this->getStatusMap();

        if ($transfer->transitionAllowed($statusTransition)) {
            try {
                if ($statusTransition == TransferStatusTransitions::ToAwaitingAcceptance) {
                    $transfer->receiving_party_id = null;
                    if ($transfer->status == TransferStatusId::Declined) {
                      
                    }
                }
                if ($statusTransition == TransferStatusTransitions::ToAccepted) {
                    $transfer->receiving_party_id = Auth::id();
                    //Transfer amount from Senders stripe account to Senders Stripe Connect account
                    $this->stripeServiceRepository->confirmPaymentFromPaymentIntent($transfer->stripe_payment_intent);
                    $this->stripeServiceRepository->capturePaymentFromPaymentIntent($transfer->stripe_payment_intent);
                }

                if ($statusTransition == TransferStatusTransitions::ToRejected) {
                    $transfer->receiving_party_id = Auth::id();
                    $this->stripeServiceRepository->cancelPaymentFromPaymentIntent($transfer->stripe_payment_intent);
                }

                if ($statusTransition == TransferStatusTransitions::ToDeclined) {
                    StripeHelper::refundCustomer($transfer->stripe_payment_intent, $transfer->transfer_amount * 100);
                }

                if ($statusTransition == TransferStatusTransitions::ToApproved) {
                    //Transfer amount from platform account to Volunteers stripe account.
                    $this->stripeServiceRepository->createTransfer($transfer);
                    //Partially refund the sender
                    $refund_amount = ($transfer->transfer_amount - $transfer->actual_amount) * 100;
                    if ($refund_amount > 0) {
                        $this->stripeServiceRepository->refundPartialPaymentFromPaymentIntent($transfer->stripe_payment_intent, $refund_amount);
                    }
                }
                $transfer->transition($statusTransition);
                $transfer->save();
            } catch (Exception $e) {
                // unable to transition
            }
            if ($statusTransition === TransferStatusTransitions::ToInDispute) {
                if ($transfer->receiving_party_id == Auth::id()) {
                    Mail::to($transfer->delivery_email)->send(new TransferDisputeMail($transfer, false));
                } else {
                    Mail::to(\App\User::where('id', $transfer->receiving_party_id)->value('email'))->send(new TransferDisputeMail($transfer, true));
                }
            } else {
                if ($transfer->receiving_party_id == Auth::id()) {
                    Mail::to($transfer->delivery_email)->send(new TransferGenericMail($transfer->sending_party_id, $transfer->id, $status_map[$statusTransition], $transfer->delivery_first_name));
                } else {
                    Mail::to(\App\User::where('id', $transfer->receiving_party_id)->value('email'))->send(new TransferGenericMail($transfer->receiving_party_id, $transfer->id, $status_map[$statusTransition], Auth::user()->first_name));
                }
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
            TransferStatusId::InDispute,
            TransferStatusId::Declined
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
