<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Notification;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransferGenericMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email_content;
    protected $status;

    /**
     * Create a new message instance.
     *
     * @param $email_content
     * @param $status
     */
    public function __construct($email_content, $status)
    {
        $this->email_content = $email_content;
        $this->status = $status;
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
            'transfer_id' => $this->email_content['id'],
            'status' => $this->status
        ]);

        return $this->from(env('SENDING_EMAIL'))->view('emails.transfer.generic')
            ->with([
                'sending_party_name' => $this->email_content['delivery_first_name'],
                'transfer_id' => $this->email_content['id'],
                'status' => $this->status
            ]);
    }
}
