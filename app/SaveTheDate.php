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
    	Mail::to($mainGuest->email)->send(new SaveTheDateMail('Save The Date'));
    }
}
