<?php

namespace App\Jobs;

use App\Transfer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use mysql_xdevapi\Exception;
use DB;


class CreateFreshdeskTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $transfer = DB::table('transfers')->where('id', $this->id)->first();
        $charity = DB::table('charities')->where('id',$transfer->charity_id)->first();

        $ticket_data = json_encode(array(

            "description" => "escrow stuff",//will be $transfer->escrow_link
            "subject" => "Volunteer Escrow Transfer",
            "email" => "beatt@netcompany.com", //this should be the same as the email associated with the charity freshdesk, or a standard email shared between the accounts.
            "priority" => 1,
            "status" => 2,
            "unique_external_id" => "transfer".$this->id,
            //Todo: Confirm other fields that need populating on the freshdesk ticket
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
            Transfer::find($this->id)->update(['freshdesk_id' => $decodedBody->id]);
        } else {
            if ($info['http_code'] == 404) {
                $e = "Error, Please check the end point \n";
            } else {
                $e = "Error, HTTP Status Code : " . $info['http_code'] . "\n";
                $e .= "Header: " . $headers . "\n";
                $e .= "Response: " . $response . "\n";
                echo $response;
            }
            throw new \Exception($e);
        }
        curl_close($ch);
}
}
