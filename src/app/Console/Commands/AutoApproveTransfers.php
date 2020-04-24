<?php

namespace App\Console\Commands;

use App\Models\Transfer;
use App\TransferStatusTransitions;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\TransferStatusId;

class AutoApproveTransfers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:autoapprove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically approve transfers after 5 days without update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $transfers = Transfer::where('status', TransferStatusId::PendingApproval)->where('updated_at', '<', Carbon::now()->subDays(5))->get();
        foreach ($transfers as $transfer) {
            $transfer->transition(TransferStatusTransitions::ToApproved);
            $transfer->save();
        }
    }
}
