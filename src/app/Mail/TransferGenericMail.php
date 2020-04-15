<?php

namespace App\Mail;

use App\Models\Customer;
use App\Notification;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransferGenericMail extends Mailable
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
        Notification::create([
           'user_id' => $this->email_content['sending_party_id'],
            'transfer_id' => $this->email_content['id']
        ]);

        // NEEDS AWS EMAIL
        return $this->from('AWS_EMAIL')->view('emails.transfer.accepted')
            ->with([
                'sending_party_name' => $this->email_content['delivery_first_name'],
                'transfer_id' => $this->email_content['id']
            ]);
    }
}
