<?php

namespace App\Mail;

use App\Notification;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransferDisputeMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email_content;
    protected $bool;

    /**
     * Create a new message instance.
     *
     * @param $email_content
     * @param $bool
     */
    public function __construct($email_content, $bool)
    {
        $this->email_content = $email_content;
        $this->bool = $bool;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // NEEDS AWS_EMAIL
        if($this->bool) {

            $this->createNotification($this->email_content['receiving_party_id'], $this->email_content['id']);

            return $this->from('AWS_EMAIL')->view('emails.transfer.dispute')
                ->with([
                    'disputer' => $this->email_content['delivery_first_name'],
                    'disputee' => User::where('id', $this->email_content['receiving_party_id'])->pluck('first_name'),
                    'transfer_id' => $this->email_content['id']
                ]);
        } else {

            $this->createNotification($this->email_content['sending_party_id'], $this->email_content['id']);

            return $this->from('AWS_EMAIL')->view('emails.transfer.dispute')
                ->with([
                    'disputer' => User::where('id', $this->email_content['receiving_party_id'])->pluck('first_name'),
                    'disputee' => $this->email_content['delivery_first_name'],
                    'transfer_id' => $this->email_content['id']
                ]);
        }

    }

    public function createNotification($user_id, $transfer_id) {
        Notification::create([
            'user_id' => $user_id,
            'transfer_id' => $transfer_id
        ]);
    }
}
