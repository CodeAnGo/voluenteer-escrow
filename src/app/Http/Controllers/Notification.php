<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Illuminate\Http\Request;

class Notification extends Controller
{
    public function delete($transfer_id) {
        \App\Models\Notification::where('transfer_id', $transfer_id)->delete();
        return redirect('/transfers/' . $transfer_id);
    }
}
