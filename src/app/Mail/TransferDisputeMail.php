<?php

namespace App\Mail;

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
        if($this->bool) {
            return $this->from('AWS_EMAIL')->view('emails.transfer.dispute')
                ->with([
                    'disputer' => $this->email_content['delivery_first_name'],
                    'disputee' => User::where('id', $this->email_content['receiving_party_id'])->pluck('first_name')
                ]);
        } else {
            // NEEDS AWS_EMAIL
            return $this->from('AWS_EMAIL')->view('emails.transfer.dispute')
                ->with([
                    'disputer' => User::where('id', $this->email_content['receiving_party_id'])->pluck('first_name'),
                    'disputee' => $this->email_content['delivery_first_name']
                ]);
        }
    }
}
