<?php

namespace App\Jobs;

use App\Helpers\Freshdesk;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateFreshDeskTicketDisputeRejected implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $transfer_id;

    /**
     * Create a new job instance.
     *
     * @param uuid $transfer_id
     * @param array $evidence
     * @param string $body
     */
    public function __construct($transfer_id)
    {
        $this->transfer_id = $transfer_id;
    }
        /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $freshdesk = new Freshdesk();
        $add_note_response = $freshdesk->addNote($this->transfer_id, "Volunteer has rejected the dispute, so this ticket will need resolving manually.");
        $this->handleResponse($add_note_response);
    }

    public function handleResponse($response)
    {
        if (!$response->successful()) {
            $this->fail('HTTP Error ' . $response->getStatusCode() . ':' . $response->getReasonPhrase());
        }
    }
}
