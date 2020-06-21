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
    public function __construct($guests)
    {
        $this->subject      = 'Save The Date';
        $this->guests       = $guests;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // calculate greeting 
        $greeting = '';
        foreach($this->guests as $i => $guest) {
            $person     = $guest->person;

            $greeting   .= $person->first_name;

            if($i == (count($this->guests)-2)) {
                $greeting .= ' & ';
            } else {
                if($i+1 !== count($this->guests)) {
                    $greeting .= ', ';
                }
            }
        }

        return $this->subject($this->subject)
                    ->markdown('emails.saveTheDate')
                    ->with([
                        'greeting' => $greeting
                    ]);
                    // ->with([
                    //     'name'     => ($this->person->first_name . ' ' . $this->person->last_name),
                    //     'code'     => $this->invite->code
                    // ]);
    }
}
