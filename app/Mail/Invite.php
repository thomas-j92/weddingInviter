<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\People;
use App\Invite as Inviter;

class Invite extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(People $person, Inviter $invite, $code)
    {
        $this->person   = $person;
        $this->invite   = $invite;
        $this->code     = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invite')
                    ->with([
                        'name'     => ($this->person->first_name . ' ' . $this->person->last_name),
                        'code'     => $this->code
                    ]);
    }
}
