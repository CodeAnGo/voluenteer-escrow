<?php

namespace App\Mail;

use App\Models\Customer;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransferAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email_content;

    /**
     * Create a new message instance.
     *
     * @param $email_content
     * @param $status
     */
    public function __construct($email_content)
    {
        $this->email_content = $email_content;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // NEEDS AWS EMAIL
        return $this->from('AWS_EMAIL')->view('emails.transfer.accepted')
            ->with([
                'sending_party_name' => $this->email_content['delivery_first_name'],
                'receiving_party_name' => User::where('id', $this->email_content['receiving_party_id'])->pluck('first_name')
            ]);
    }
}
