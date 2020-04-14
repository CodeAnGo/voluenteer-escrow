<?php

namespace App\Http\Controllers;

use App\TransferEvidence;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;

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
        return view('transfers.evidence.create', ['transfer_id' => $transfer_id]);
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
        ]);

        $paths = [];
        foreach ($request->files->get('evidence') as $file) {
            $path = Storage::putFile('/evidence/' . $transfer_id . '/' . Auth::id(), new File($file));
            array_push($paths, $path);
        }

        foreach ($paths as $path) {
            TransferEvidence::create([
                'transfer_id' => $transfer_id,
                'user_id' => Auth::id(),
                'path' => $path,
            ]);
        }

        return redirect()->route('transfers.evidence.index', $transfer_id);
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
