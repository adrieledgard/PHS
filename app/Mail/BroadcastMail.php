<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BroadcastMail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $subject;
    public $link_product;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $content, $link_product)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->link_product = $link_product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Broadcast_mail')
                    ->subject($this->subject);
    }
}
