<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Transfer;
use App\TransferStatusId;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
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

        $closed_status_id = [
            TransferStatusId::Cancelled,
            TransferStatusId::Closed,
            TransferStatusId::ClosedNonPayment,
            TransferStatusId::Rejected,
            TransferStatusId::InDispute
        ];
        $active_transfers = clone $transfers;
        $active_transfers = $active_transfers->whereNotIn('status', $closed_status_id);

        $reflection = new \ReflectionClass('App\TransferStatus');
        $status_map = array('Unable to get Status');
        foreach ($reflection->getConstants() as $value){
            array_push($status_map, $value);
        }

        return view('dashboard', [
            'users' => $users->get(),
            'charities' => $charities->get(),
            'transfers' => $transfers->get(),
            'active_transfers' => $active_transfers->get(),
            'closed_status' => $closed_status_id,
            'volunteer' => !(Auth::User()->volunteer === 0),
            'notificationArr' => Notification::where('user_id', Auth::id())->get(),
            'status_map' => $status_map
        ]);
    }
}
