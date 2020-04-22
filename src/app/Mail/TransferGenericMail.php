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

    protected $status;
    protected  $user_id;
    protected $transfer_id;
    protected $name;

    /**
     * Create a new message instance.
     *
     * @param $email_content
     * @param $status
     */
    public function __construct($user_id, $transfer_id, $status, $name)
    {
        $this->status = $status;
        $this->user_id = $user_id;
        $this->transfer_id = $transfer_id;
        $this->name = $name;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Notification::create([
            'user_id' => $this->user_id,
            'transfer_id' => $this->transfer_id,
            'status' => $this->status
        ]);

        return $this->from(env('SENDING_EMAIL'))->view('emails.transfer.generic')
            ->with([
                'sending_party_name' => $this->name,
                'transfer_id' => $this->transfer_id,
                'status' => $this->status
            ]);
    }
}
