<?php

namespace App\Jobs;

use App\Transfer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateFreshdeskTicket implements ShouldQueue
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
     * @return void
     */
    public function handle($id)
    {
        $transfer = DB::table('transfer')->where('id', $id)->first();
        $charity = DB::table('charities')->where('id',$transfer->charity_id)->first();

        $ticket_data = json_encode(array(

            "description" => $transfer->escrow_link,
            "subject" => "Test Escrow Transfer",
            "email" => "", //don't set this, we don't decide who the ticket is assigned to
            //Todo: Other fields may need populating on the freshdesk ticket.
        ));

        $url = "https://$charity->domain.freshdesk.com/api/v2/tickets";

        $ch = curl_init($url);

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $charity->api_key);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);

        if ($info['http_code'] == 201) {
            $decodedBody = json_decode($response);
            $freshdesk_id = $decodedBody->id;
            //Todo: Capture freshdesk id against transfer record
        } else {
            if ($info['http_code'] == 404) {
                $e = "Error, Please check the end point \n";
            } else {
                $e = "Error, HTTP Status Code : " . $info['http_code'] . "\n";
                $e .= "Header: " . $headers . "\n";
                $e .= "Response: " . $response . "\n";
            }
            //Todo: Throw an error so that job is reattempted
        }
        curl_close($ch);
    }
}
