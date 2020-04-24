<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoRefundDisputes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:autorefund';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically refund disputes after 90 days';

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
        $transfers = Transfer::where('status', TransferStatusId::InDispute)->where('updated_at', '<', Carbon::now()->subDays(90))->get();
        foreach ($transfers as $transfer) {
            $transfer->transition(TransferStatusTransitions::ToClosedNonPayment);
            $transfer->save();
        }
    }
}
