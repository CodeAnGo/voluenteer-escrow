<?php


namespace App\Helpers;

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
            $first_path = storage_path('app'.$attachments[0]);
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
                $path = storage_path('app'.$attachments[$i]);
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
}
