<?php

namespace App\Jobs;

use App\Models\Charity;
use App\Models\Transfer;
use App\TransferStatusTransitions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GetFreshdeskResolution implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;
    private $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $transfer = Transfer::where('id', $this->id)->first();
        $charity = Charity::where('id', $transfer->charity_id)->first();
        $url = "https://$charity->domain.freshdesk.com/api/v2/tickets/$transfer->freshdesk_id";
        $response = Http::withBasicAuth($charity->api_key, '')->get($url);
        if ($response->successful()) {
            $decodedBody = json_decode($response->getBody());
            print_r($decodedBody);
            if($decodedBody->status == '3'){
                $transfer->actual_amount = $decodedBody->custom_fields->cf_actual_amount;
                $transfer->save();
                $transfer->transition(TransferStatusTransitions::ToApproved);
                $transfer->save();
            }
        } else {
            $this->fail('HTTP Error ' . $response->getStatusCode() . ':' . $response->getReasonPhrase());
        }
    }
}
