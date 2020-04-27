<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\{Charity, Transfer};
use Illuminate\Support\Facades\Http;
use App\Helpers\Freshdesk;


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
        $freshdesk = new Freshdesk();
        $update_response = $freshdesk->createTicket($this->id);
        $this->handleResponse($update_response);
    }

    public function handleResponse($response)
    {
        if ($response->successful()) {
            $decodedBody = json_decode($response->getBody());
            Transfer::find($this->id)->update(['freshdesk_id' => $decodedBody->id]);
        } else {
            $this->fail('HTTP Error ' . $response->getStatusCode() . ':' . $response->getReasonPhrase());
        }
    }
}
