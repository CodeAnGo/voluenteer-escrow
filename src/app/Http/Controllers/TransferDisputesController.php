<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferUpdateRequest;
use App\Http\Requests\TransferUpdateStatusRequest;
use App\Jobs\UpdateFreshDeskTicketDisputeRejected;
use App\Jobs\UpdateFreshDeskTicketDisputeResolved;
use App\Jobs\UpdateFreshdeskTicketTransferDispute;
use App\Models\Transfer;
use App\Models\TransferDispute;
use App\Models\TransferDisputeEvidence;
use App\Models\TransferEvidence;
use App\Repositories\Interfaces\StripeServiceRepositoryInterface;
use App\TransferStatusId;
use App\TransferStatusTransitions;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;

class TransferDisputesController extends Controller
{
    private $stripeServiceRepository;

    public function __construct(StripeServiceRepositoryInterface $stripeServiceRepository)
    {
        $this->stripeServiceRepository = $stripeServiceRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $transfer_id
     * @return Factory|View
     */
    public function create($transfer_id)
    {
        $transfer = Transfer::where('id', $transfer_id)->first();
        $authorized =
            Auth::id() === $transfer->sending_party_id ||
            Auth::id() === $transfer->receiving_party_id;

        if (!$authorized) {
            return app('App\Http\Controllers\TransfersController')->show($transfer_id);
        }

        return view('transfers.dispute.create', [
            'transfer' => $transfer
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $transfer_id
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request, $transfer_id)
    {
        $validator = request()->validate([
            'dispute_reason' => 'required|between:1,255',
            'evidence.*' => 'image',
        ]);

        $dispute_reason = request('dispute_reason');
        $transfer_dispute = TransferDispute::create([
            'transfer_id' => $transfer_id,
            'user_id' => Auth::id(),
            'dispute_reason' => $dispute_reason,
        ]);

        $paths = [];
        $evidence = (array) $request->files->get('evidence');
        foreach ($evidence as $file) {
            $path = Storage::disk('public')->putFile('transfer_dispute_evidence', new File($file));
            array_push($paths, $path);
        }

        foreach ($paths as $path) {
            TransferDisputeEvidence::create([
                'transfer_id' => $transfer_id,
                'user_id' => Auth::id(),
                'transfer_dispute_id' => $transfer_dispute->id,
                'path' => $path
            ]);
        }

        $eol = "\r\n";
        $user = Auth::user();

        $message = $user->first_name . " " . $user->last_name . " has raised a dispute." . $eol;
        $message .= $eol . "Additional Information: " . $eol;
        $message .= $eol . $dispute_reason;

        dispatch(new UpdateFreshdeskTicketTransferDispute($transfer_id, $paths, $message));

        $transfer_request = new TransferUpdateStatusRequest();
        $transfer_request->setMethod('PUT');

        return app('App\Http\Controllers\TransfersController')
            ->statusUpdate($transfer_request, $transfer_id, TransferStatusTransitions::ToInDispute);
    }

    /**
     * Display the specified resource.
     *
     * @param $transfer_id
     * @return \Illuminate\Http\Response
     */
    public function show(Transfer $transfer, TransferDispute $dispute)
    {
        return view('transfers.dispute.show', [
            'transferDispute' => $dispute,
            'transfer' => $transfer
        ]);
    }

    public function update(Request $request, Transfer $transfer, TransferDispute $dispute)
    {
        $dispute->resolved = true;
        $dispute->save();

        if ($request->get('buttonPressed') === 'accept') {
            // Stripe Payout to individual bank account
            dispatch(new UpdateFreshDeskTicketDisputeResolved($transfer->id));
            $this->stripeServiceRepository->refundFullPaymentFromPaymentIntent($transfer->stripe_payment_intent);
            $transfer->transition(TransferStatusTransitions::ToClosedNonPayment);
            $transfer->save();
        } else {
            dispatch(new UpdateFreshDeskTicketDisputeRejected($transfer->id));
        }

        return app('App\Http\Controllers\TransfersController')->show($transfer);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param $transfer_id
     * @param uuid $id
     * @return RedirectResponse
     */
    public function destroy($transfer_id, $id)
    {
        $transfer_dispute_evidence = TransferDisputeEvidence::where('id', $id)->first();
        Storage::delete($transfer_dispute_evidence->path);
        $transfer_dispute_evidence->delete();
        return app('App\Http\Controllers\TransfersController')->show($transfer_id);
    }
}
