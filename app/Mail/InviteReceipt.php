<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\People;
use App\Invite as Inviter;

class InviteReceipt extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(People $person, Inviter $invite, $subject)
    {
        $this->person       = $person;
        $this->invite       = $invite;
        $this->subject      = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {  
        return $this->subject($this->subject)
                    ->markdown('emails.receipt')
                    ->with([
                        'name'     => ($this->person->first_name . ' ' . $this->person->last_name),
                        'guests'     => $this->invite->guests
                    ]);
    }
}
