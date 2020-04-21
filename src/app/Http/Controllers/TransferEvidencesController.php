<?php

namespace App\Http\Controllers;

use App\Models\Charity;
use App\Models\Transfer;
use App\Models\TransferEvidence;
use App\TransferStatusId;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;
use App\Jobs\UpdateFreshdeskTicketTransferEvidence;
use App\User;

class TransferEvidencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $transfer_id
     * @return Factory|View
     */
    public function index($transfer_id)
    {
        $transfer_evidences = TransferEvidence::where('transfer_id', $transfer_id)->get();
        return view('transfers.evidence.index', ['transfer_id' => $transfer_id, 'transfer_evidences' => $transfer_evidences]);
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
        $authorized = Auth::user()->id == $transfer->receiving_party_id;

        if(!$authorized){
            return app('App\Http\Controllers\TransfersController')->show($transfer_id);
        }

        $showDeliveryDetails =
            Auth::id() === $transfer->sending_party_id ||
            Auth::id() === $transfer->receiving_party_id;
        $is_sending_user = Auth::id() === $transfer->sending_party_id;

        $sending_user = User::where('id', $transfer->sending_party_id)->first();
        $receiving_user = User::where('id', $transfer->receiving_party_id)->first();

        $charity = Charity::where('id', $transfer->charity_id)->first();

        return view('transfers.evidence.create', [
            'balance' => 1,
            'transfer' => $transfer,
            'charity' => $charity->name,
            'sending_user' => $sending_user,
            'receiving_user' => $receiving_user,
            'show_delivery_details' => $showDeliveryDetails,
            'is_sending_user' => $is_sending_user
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
            'evidence' => 'required',
            'evidence.*' => 'image',
            'actual_amount' => 'required|numeric|min:0',
        ]);

        $paths = [];
        foreach ($request->files->get('evidence') as $file) {
            $path = Storage::putFile('\\evidence\\' . $transfer_id . '\\' . Auth::id(), new File($file));
            array_push($paths, $path);
        }

        foreach ($paths as $path) {
            TransferEvidence::create([
                'transfer_id' => $transfer_id,
                'user_id' => Auth::id(),
                'path' => $path,
            ]);
        }

        $actual_amount = request('actual_amount');
        $approval_note = request('transfer_note');

        $transfer = Transfer::where('id', $transfer_id)->first();
        $transfer->actual_amount = $actual_amount;
        $transfer->approval_note = $approval_note;
        $transfer->save();

        $eol = "\r\n";
        $user = Auth::user();

        $message = $user->first_name . " " . $user->last_name . " has submitted the transfer for approval." . $eol;
        $message .= "The actual amount for the service was £" . number_format($actual_amount, 2) . ".";
        if ($approval_note) {
            $message .= $eol."Additional Information: ".$eol;
            $message .= $eol.$approval_note;
        }

        dispatch(new UpdateFreshdeskTicketTransferEvidence($transfer_id, $paths, $message));

        $request['statusTransition'] = TransferStatusId::PendingApproval;
        $request->setMethod('PUT');

        return app('App\Http\Controllers\TransfersController')->update($request, $transfer_id);
    }

    /**
     * Display the specified resource.
     *
     * @param $transfer_id
     * @param uuid $id
     * @return Factory|View
     */
    public function show($transfer_id, $id)
    {
        $transfer_evidence = TransferEvidence::where('id', $id)->first();
        $evidence = Storage::get(storage_path('app/' . $transfer_evidence->path));
        return view('transfers.evidence.show', ['evidence' => $evidence]);
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
        $transfer_evidence = TransferEvidence::where('id', $id)->first();
        Storage::delete($transfer_evidence->path);
        $transfer_evidence->delete();
        return redirect()->route('transfers.evidence.index', $transfer_id);
    }
}
