<?php

namespace App\Http\Middleware;

use App\Transfer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CanViewTransferEvidence
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $transfer_id = $request->route()->parameters()['transfer'];
        $transfer = Transfer::where('id', $transfer_id)->first();
        if ($transfer && (Auth::id() === $transfer->sending_party_id || Auth::id() === $transfer->receiving_party_id)) {
            return $next($request);
        }

        return redirect()->route('transfers.show', $transfer_id);
    }
}
