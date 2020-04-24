<?php

namespace App\Jobs;

use App\Models\Charity;
use App\Models\Transfer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UpdateFreshdeskTicketTransferEvidence implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $transfer_id;
    private $evidence;
    private $body;

    /**
     * Create a new job instance.
     *
     * @param uuid $transfer_id
     * @param array $evidence
     * @param string $body
     */
    public function __construct($transfer_id, array $evidence, string $body)
    {
        $this->transfer_id = $transfer_id;
        $this->evidence = $evidence;
        $this->body = $body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $transfer = Transfer::where('id', $this->transfer_id)->first();
        $charity = Charity::where('id', $transfer->charity_id)->first();

        $ticket_id = $transfer->freshdesk_id;
        $url = "https://$charity->domain.freshdesk.com/api/v2/tickets/$ticket_id/notes";

        //attach image to create Multi-part request

        $first_path = Storage::disk('public')->url($this->evidence[0]);

        $first_photo = fopen($first_path, 'r');
        $file_name = explode('/', $first_path, 2)[1];
        $request = Http::attach('attachments[]', $first_photo, $file_name);
        $request = $request->withBasicAuth($charity->api_key, '');

        $ticket_data = array(
            'body'=>[
                'contents'=>$this->body,
                'name'=>"body"
            ],
        );

        //include additional images
        $i = 1;
        while($i < count($this->evidence)){
            $path = storage_path('app'.$this->evidence[$i]);
            $photo = fopen($path, 'r');
            $ticket_data['attachment'.$i] = [
                'contents'=>$photo,
                'name'=>"attachments[]"
            ];
            $i++;
        }

        $response = $request->post($url, $ticket_data);
        if ($response->successful()) {
            $decodedBody = json_decode($response->getBody());
            //
        } else {
            $this->fail('HTTP Error ' . $response->getStatusCode() . ':' . $response->getReasonPhrase());
        }
    }
}
