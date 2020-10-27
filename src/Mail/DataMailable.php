<?php

namespace Rokasma\Esa\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DataMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $info = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->info = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('esa.email_subject'))->view('esa::emails.data', [
            'info' => $this->info
        ]);
    }
}