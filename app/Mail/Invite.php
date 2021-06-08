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
    public function __construct(People $person, Inviter $invite, $subject, $file_path)
    {
        $this->person       = $person;
        $this->invite       = $invite;
        $this->subject      = $subject;
        $this->file_path    = $file_path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // attach file if one can be found
        if($this->file_path) {
             $this->attachFromStorageDisk('local', $this->file_path);
        }
        
        return $this->subject($this->subject)
                    ->markdown('emails.invite')
                    ->with([
                        'name'     => ($this->person->first_name . ' ' . $this->person->last_name),
                        'code'     => $this->invite->code
                    ]);
    }
}
