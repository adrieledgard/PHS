<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestOTP extends Mailable
{
    use Queueable, SerializesModels;
    public $kode_otp;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($kode_otp)
    {
        $this->kode_otp = $kode_otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Request_otp_mail');
    }
}
