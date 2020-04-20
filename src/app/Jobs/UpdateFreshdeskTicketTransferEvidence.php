<?php

namespace App\Jobs;

use App\Models\Charity;
use App\Models\Transfer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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

        $eol = "\r\n";

        $mime_boundary = md5(time());

        $data = '--' . $mime_boundary . $eol;
        $data .= 'Content-Disposition: form-data; name="body"' . $eol . $eol;
        $data .= "$this->body" . $eol;

        foreach($this->evidence as $file) {
            $path = storage_path('app'.$file);
            $content_type = mime_content_type($path);
            $file_name = explode('/', $file, 2)[1];

            $data .= '--' . $mime_boundary . $eol;
            $data .= 'Content-Disposition: form-data; name="attachments[]"; filename="' . $file_name. '"' . $eol;
            $data .= "Content-Type: $content_type" . $eol . $eol;
            $data .= file_get_contents($path) . $eol;
        }

        $data .= "--" . $mime_boundary . "--" . $eol . $eol;

        $header[] = "Content-type: multipart/form-data; boundary=" . $mime_boundary;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_USERPWD, "$charity->api_key");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);

        if($info['http_code'] == 201) {
            echo "Note added to the ticket, the response is given below \n";
            echo "Response Headers are \n";
            echo $headers."\n";
            echo "Response Body \n";
            echo "$response \n";
        } else {
            if($info['http_code'] == 404) {
                echo "Error, Please check the end point \n";
            } else {
                echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
                echo "Headers are ".$headers."\n";
                echo "Response is ".$response;
            }
        }

        curl_close($ch);
    }
}
