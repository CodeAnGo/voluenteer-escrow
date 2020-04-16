<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\TransferStatus;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\User;
use App\Models\Charity;
use ReflectionException;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     * @throws ReflectionException
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
}
