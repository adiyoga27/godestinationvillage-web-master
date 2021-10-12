<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderHomestayEmail extends Mailable
{
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data, $subject, $message;

    public function __construct($subject, $data, $message)
    {
        $this->subject = $subject;
        $this->data = $data;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->markdown('vendor.mail.html._orderhomestay', [
            'data' => $this->data,
            'message' => $this->message
        ]);
    }
}
