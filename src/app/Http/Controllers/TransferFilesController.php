<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferUpdateRequest;
use App\Http\Requests\TransferUpdateStatusRequest;
use App\Models\Charity;
use App\Models\Transfer;
use App\Models\TransferEvidence;
use App\Models\TransferFile;
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
use App\Jobs\UpdateFreshdeskTicketTransferEvidence;
use App\User;

class TransferFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $transfer_id
     * @return Factory|View
     */
    public function index($transfer_id)
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
        //
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
        $paths = [];
        $images = (array)$request->files->get('images');
        foreach ($images as $file) {
            $path = Storage::disk('public')->putFile('transfer_file', new File($file));
            array_push($paths, $path);
        }

        foreach ($paths as $path) {
            TransferFile::create([
                'transfer_id' => $transfer_id,
                'user_id' => Auth::id(),
                'path' => $path,
            ]);
        }

        $body = 'The following images have been attached to the transfer:';
        if (!empty($paths)) {
            $this->dispatch(new UpdateFreshdeskTicketTransferEvidence($transfer_id, $paths, $body));
        }
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
        //
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
        $transfer_file = TransferFile::where('id', $id)->first();
        Storage::delete($transfer_file->path);
        $transfer_file->delete();
        return redirect()->route('transfers.show', $transfer_id);
    }
}
