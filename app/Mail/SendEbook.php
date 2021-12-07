<?php

namespace App\Mail;

use App\ebook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEbook extends Mailable
{
    use Queueable, SerializesModels;

    public $ebook_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ebook_id)
    {
        $this->ebook_id = $ebook_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $ebook = ebook::find($this->ebook_id);
        return $this->view('Ebook_send')->attach("Uploads/Ebook/$ebook->Pdf_file");
    }
}
