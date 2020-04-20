<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\{Charity, Transfer};
use Illuminate\Support\Facades\Http;


class CreateFreshdeskTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;//number of times to attempt (doesn't work)
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
        $url = "https://$charity->domain.freshdesk.com/api/v2/tickets";

        $ticket_data = array(

            "description" => "escrow linky",//will be $transfer->escrow_link
            "subject" => "Volunteer Escrow Transfer",
            "email" => "beatt@netcompany.com", //this should be the same as the email associated with the charity freshdesk, or a standard email shared between the accounts.
            "priority" => 1,
            "status" => 2,
            "unique_external_id" => "transfer-" . $this->id,
            "custom_fields" => array(
                "cf_charity" => $charity->name,
                "cf_transfer_amount" => $transfer->transfer_amount),
        );

        $response = Http::withBasicAuth($charity->api_key, '')->post($url, $ticket_data);
//        $response = Http::withBasicAuth('', $charity->api_key)->withHeader(["Content-type: application/json"])->post($url, $ticket_data);

        if ($response->successful()) {
            $decodedBody = json_decode($response->getBody());
            Transfer::find($this->id)->update(['freshdesk_id' => $decodedBody->id]);
        } else {
            echo $response->getBody();
            $response->throw();
        }
    }
}
