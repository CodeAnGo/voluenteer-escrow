<?php


namespace App\Helpers;

use App\FreshdeskTicketPriority;
use App\FreshdeskTicketStatus;
use App\Models\Transfer;
use App\Models\Charity;
use Illuminate\Support\Facades\Http;

class Freshdesk
{
    public function addNote($transfer_id, $body, $attachments = [])
    {
        $transfer = Transfer::where('id', $transfer_id)->first();
        $charity = Charity::where('id', $transfer->charity_id)->first();

        $ticket_id = $transfer->freshdesk_id;
        $url = "https://$charity->domain.freshdesk.com/api/v2/tickets/$ticket_id/notes";

        if (empty($attachments)) {
            $request = Http::withBasicAuth($charity->api_key, '');
            $ticket_data = array(
                'body'=>$body
            );
        } else {
            $first_path = storage_path('app/public/' .$attachments[0]);
            $first_photo = fopen($first_path, 'r');
            $file_name = explode('/', $first_path, 2)[1];
            $request = Http::attach('attachments[]', $first_photo, $file_name);
            $request = $request->withBasicAuth($charity->api_key, '');

            $ticket_data = array(
                'body'=>[
                    'contents'=> $body,
                    'name'=>"body"
                ],
            );

            //include additional images
            $i = 1;
            while($i < count($attachments)){
                $path = storage_path('app/public/' .$attachments[$i]);
                $photo = fopen($path, 'r');
                $ticket_data['attachment'.$i] = [
                    'contents'=>$photo,
                    'name'=>"attachments[]"
                ];
                $i++;
            }
        }
        return $request->post($url, $ticket_data);
    }

    public function updateTicket($transfer_id, $data)
    {
        $transfer = Transfer::where('id', $transfer_id)->first();
        $charity = Charity::where('id', $transfer->charity_id)->first();

        $ticket_id = $transfer->freshdesk_id;
        $url = "https://$charity->domain.freshdesk.com/api/v2/tickets/$ticket_id";

        $request = Http::withBasicAuth($charity->api_key, '');
        return $request->put($url, $data);
    }


    public function createTicket($transfer_id)
    {
        $transfer = Transfer::where('id', $transfer_id)->first();
        $charity = Charity::where('id', $transfer->charity_id)->first();

        $url = "https://$charity->domain.freshdesk.com/api/v2/tickets";

        $ticket_data = array(
            "description" => env('APP_URL') . '/transfers/'. $transfer->id,
            "subject" => "Escrow Transfer",
            "priority" => FreshdeskTicketPriority::Low,
            "status" => FreshdeskTicketStatus::Open,
            "unique_external_id" => "transfer-" . $transfer_id,
            "custom_fields" => array(
                "cf_transfer_amount" => $transfer->transfer_amount),
        );

        $request = Http::withBasicAuth($charity->api_key, '');
        return $request->post($url, $ticket_data);
    }

}
