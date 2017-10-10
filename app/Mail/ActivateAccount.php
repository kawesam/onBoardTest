<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivateAccount extends Mailable  {

    use Queueable, SerializesModels;

    /**
     * The link for the user to confirm their account.
     * @var String
     */
    public $link;

    /**
     * Create a new message instance.
     *
     * @param $link
     */
    public function __construct($link)
    {
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(config('app.name').' - Account activation.')
            ->markdown('emails.auth');
    }
}
