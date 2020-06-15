<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveTheDate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject)
    {
        $this->subject  = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->subject($this->subject)
                    ->markdown('emails.saveTheDate');
                    // ->with(['message' => $this]);
                    // ->with([
                    //     'name'     => ($this->person->first_name . ' ' . $this->person->last_name),
                    //     'code'     => $this->invite->code
                    // ]);
    }
}
