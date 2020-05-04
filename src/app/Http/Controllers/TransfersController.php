<?php

namespace App\Http\Controllers;

use App\Helpers\StatusHelper;
use App\Http\Requests\TransferCreateRequest;
use App\Http\Requests\TransferUpdateRequest;
use App\Http\Requests\TransferUpdateStatusRequest;
use App\Mail\TransferDisputeMail;
use App\Models\Account;
use App\Models\Address;
use App\Models\Transfer;
use App\Jobs\CreateFreshdeskTicket;
use App\Models\TransferDispute;
use App\Models\TransferDisputeEvidence;
use App\Models\TransferEvidence;
use App\Repositories\Interfaces\AddressRepositoryInterface;
use App\Repositories\Interfaces\CharityRepositoryInterface;
use App\Repositories\Interfaces\StripeServiceRepositoryInterface;
use App\Repositories\Interfaces\TransferRepositoryInterface;
use App\TransferStatusId;
use Exception;
use Illuminate\Foundation\Auth\User;
use App\TransferStatusTransitions;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use OwenIt\Auditing\Models\Audit;
use Ramsey\Uuid\Uuid;
use App\Models\Charity;
use Stripe\Exception\ApiErrorException;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransferGenericMail;
use App\Models\TransferFile;


class TransfersController extends Controller
{
    use StatusHelper;

    private $stripeServiceRepository;
    private $transferRepository;
    private $charityRepository;
    private $addressRepository;


    /**
     * TransfersController constructor.
     * @param StripeServiceRepositoryInterface $stripeServiceRepository
     * @param TransferRepositoryInterface $transferRepository
     * @param CharityRepositoryInterface $charityRepository
     * @param AddressRepositoryInterface $addressRepository
     */
    public function __construct(StripeServiceRepositoryInterface $stripeServiceRepository, TransferRepositoryInterface $transferRepository, CharityRepositoryInterface $charityRepository, AddressRepositoryInterface $addressRepository)
    {
        $this->stripeServiceRepository = $stripeServiceRepository;
        $this->transferRepository = $transferRepository;
        $this->charityRepository = $charityRepository;
        $this->addressRepository = $addressRepository;
    }


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
     * @return Factory|View
     * @throws ApiErrorException
     */
    public function create()
    {
        return view('transfers.create',[
            'charities' => $this->charityRepository->getAllActiveCharities(),
            'cards' => [],
            'phone' => $this->stripeServiceRepository->getAccountFromUser(Auth::user())->business_profile->support_phone ?? '',
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

        $address = $this->addressRepository->getAddressFromId($request->get('user_address_select'));
        $paymentIntent = $this->stripeServiceRepository->createPaymentIntentFromUser(Auth::user(), $request->get('transfer_amount'));
        $transfer = $this->transferRepository->createTransfer(
            Auth::user(),
            $this->charityRepository->getCharityFromId($request->get('charity_id')),
            $request->get('delivery_first_name'),
            $request->get('delivery_last_name'),
            $request->get('delivery_email'),
            $request->get('delivery_phone'),
            $address->line1,
            $address->city,
            $address->postcode,
            $address->country,
            $request->get('transfer_amount'),
            $request->get('transfer_reason'),
            TransferStatusId::AwaitingAcceptance,
            $request->get('transfer_note'),
            $paymentIntent->id,
            null,
            null,
            Auth::user()->account->id,
            1,
            $paymentIntent->transfer_group,
            $address->line2,
            $address->county,
            null,
            null
        );

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

        return view('transfers.show', [
            'transfer' => $transfer,
            'charity' => $transfer->charity ? $transfer->charity->name : 'No Charity Oversight (Not Recommended)',
            'sending_user' => $transfer->sendingParty,
            'receiving_user' => $transfer->receivingParty,
            'transfer_files' => TransferFile::where('transfer_id', $transfer->id)->get(),
            'transferEvidence' => TransferEvidence::where('transfer_id', $transfer->id)->get(),
            'transferDispute' => TransferDispute::where('transfer_id', $transfer->id)->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Transfer $transfer
     * @return Factory|RedirectResponse|View
     */
    public function edit(Transfer $transfer)
    {
        if (!isset($transfer) || $transfer->sendingParty != Auth::user()) {
            return redirect()->route('transfers.index');
        }

        return view('transfers.edit', [
            'transfer' => $transfer,
            'charity' => $transfer->charity ? $transfer->charity->name : '-',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TransferUpdateRequest $request
     * @param Transfer $transfer
     * @return RedirectResponse
     */
    public function update(TransferUpdateRequest $request, Transfer $transfer)
    {
        $request->validated();

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
        return redirect()->route('transfers.show', [$transfer->id]);
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
        $transfer = $this->transferRepository->getTransferFromID($id);

        $status_map = $this->getStatusMap();

        if ($transfer->transitionAllowed($statusTransition)) {
            try {
                if ($statusTransition == TransferStatusTransitions::ToAwaitingAcceptance) {
                    $transfer->receiving_party_id = null;
                    if ($transfer->status == TransferStatusId::Declined || $transfer->status == TransferStatusId::Rejected) {
                        $paymentIntent = $this->stripeServiceRepository->createPaymentIntentFromUser(Auth::user(), $transfer->transfer_amount);
                        $transfer->stripe_payment_intent = $paymentIntent->id;
                        $transfer->save();
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

                if ($statusTransition == TransferStatusTransitions::ToCancelled) {
                    $this->stripeServiceRepository->cancelPaymentFromPaymentIntent($transfer->stripe_payment_intent);
                }

                if ($statusTransition == TransferStatusTransitions::ToDeclined) {
                    $this->stripeServiceRepository->refundFullPaymentFromPaymentIntent($transfer->stripe_payment_intent);
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
}
