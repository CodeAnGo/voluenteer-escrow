<?php

namespace App\Jobs;

use App\FreshdeskTicketStatus;
use App\Helpers\Freshdesk;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateFreshdeskTicketTransferDispute implements ShouldQueue
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
     * Create a new job instance.
     *
     * @param uuid $transfer_id
     * @param array $evidence
     * @param string $body
     */
    public function handle()
    {
        $freshdesk = new Freshdesk();
        $update_response = $freshdesk->updateTicket($this->transfer_id, [
            'priority' => FreshdeskTicketStatus::Urgent,
            'tags'=> ['Dispute']
        ]);
        $this->handleResponse($update_response);

        $add_note_response = $freshdesk->addNote($this->transfer_id, $this->body, $this->evidence);
        $this->handleResponse($add_note_response);
    }

    public function handleResponse($response)
    {
        if (!$response->successful()) {
            $this->fail('HTTP Error ' . $response->getStatusCode() . ':' . $response->getReasonPhrase());
        }
    }
}
