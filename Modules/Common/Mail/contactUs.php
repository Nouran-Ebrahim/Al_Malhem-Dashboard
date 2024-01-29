<?php

namespace Modules\Common\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class contactUs extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $message;
    public $phone;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $message, $phone)
    {
        $this->email = $email;

        $this->message = $message;
        $this->phone = $phone;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from($this->email)
        ->markdown('common::Email.ContactUs')->with([
            'email' => $this->email,
            'message' => $this->message,
            'phone' => $this->phone
        ]);
    }
}
