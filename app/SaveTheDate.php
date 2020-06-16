<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Load Mail
use App\Mail\SaveTheDate as SaveTheDateMail;

// Load libaries
use Mail;

class SaveTheDate extends Model
{

	public static function boot() {
        parent::boot();

        static::creating(function (SaveTheDate $item) {
            $item->send();
        });
    }

    public function invite() {
    	return $this->belongsTo('App\Invite', 'invite_id');
    }

    /** 
     * Send save the date.
     */
    public function send() {

    	// send saveTheDate to main guest of Invite
    	$mainGuest = $this->invite->main_guest->person;

        // send saveTheDate
        $saveTheDateMail = new SaveTheDateMail('Save The Date');
    	Mail::to($mainGuest->email)->send($saveTheDateMail);

        // html render
        $emailHtml = ($saveTheDateMail)->render();

        // make Email log
        $emailLog                   = new Email();
        $emailLog->subject          = 'Save the date sent';
        $emailLog->html             = $emailHtml;
        $emailLog->email_address    = $mainGuest->email;
        $emailLog->invite_id        = $this->invite_id;
        $emailLog->save();
    }
}
