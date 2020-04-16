<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Illuminate\Http\Request;

class Notification extends Controller
{
    public function delete($notification_id) {
        $notification = \App\Models\Notification::where('id', $notification_id)->first();
        $transfer_id = $notification->transfer_id;
        $notification->delete();
        return redirect('/transfers/' . $transfer_id);
    }
}
