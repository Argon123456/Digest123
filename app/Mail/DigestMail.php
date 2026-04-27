<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DigestMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $html;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($html)
    {
        $this->html = $html;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->markdown('emails.digest');
        $this->from('news@vds.by', 'Компания VDS')
            ->view('emails.digest')
            ->with(['html'=> $this->html]);
    }
}
