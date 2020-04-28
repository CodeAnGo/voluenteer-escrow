<?php

namespace App\Console\Commands;

use App\Jobs\GetFreshdeskResolution;
use App\Models\Transfer;
use App\TransferStatusId;
use Illuminate\Console\Command;

class GetDisputeResolutions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:resolve-dispute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create jobs to pull dispute resolutions from freshdesk';

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
        $transfers = Transfer::where('status', TransferStatusId::InDispute)->get();
        foreach ($transfers as $transfer) {
            GetFreshdeskResolution::dispatch($transfer->id);
        }
    }
}
