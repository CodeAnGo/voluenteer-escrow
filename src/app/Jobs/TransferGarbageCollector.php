<?php

namespace App\Jobs;

use App\Repositories\Interfaces\StripeServiceRepositoryInterface;
use App\Repositories\Interfaces\TransferRepositoryInterface;
use App\TransferStatusId;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransferGarbageCollector implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param TransferRepositoryInterface $transferRepository
     * @return void
     */
    public function handle(TransferRepositoryInterface $transferRepository, StripeServiceRepositoryInterface $stripeServiceRepository)
    {
        $transfersWithPendingPayouts = $transferRepository->getAllTransfersOfStatus(TransferStatusId::Accepted);
        foreach ($transfersWithPendingPayouts as $pendingPayout){
            $balanceTransaction = $stripeServiceRepository->getBalanceTransactionFromTransfer($pendingPayout);
            if ($balanceTransaction->status == 'available'){
                $pendingPayout->status = TransferStatusId::Closed;
            }
        }
    }
}
