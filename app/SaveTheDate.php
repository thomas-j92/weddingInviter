<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Load Mail
use App\Mail\SaveTheDate as SaveTheDateMail;

// Load libaries
use Mail;
use Carbon\Carbon;

class SaveTheDate extends Model
{
    protected $appends = ['created_at_format', 'to_array', 'CC_array'];

	public static function boot() {
        parent::boot();

        static::creating(function (SaveTheDate $item) {
            // generate random code for save the date
            $item->code = str_random(40);

            $item->send();
        });
    }

    public function invite() {
    	return $this->belongsTo('App\Invite', 'invite_id');
    }

    public function email() {
        return $this->belongsTo('App\Email');
    }

    public function seen() {
        return $this->hasMany('App\STD_Seen');
    }

    public function getCreatedAtFormatAttribute() {
        return Carbon::parse($this->created_at)->format('d/m/Y H:i:s');
    }

    public function getCCFormatAttribute() {
        return unserialize($this->cc);
    }

    public function getToArrayAttribute() {
        $ccs = unserialize($this->cc);

        // get all emails that have seen SaveTheDate
        $seenEmails = $this->seen->pluck('email')->all();

        return array(
            'email' => $this->to,
            'seen'  => (in_array($this->to, $seenEmails)) ? true : false
        );
    }

    public function getCCArrayAttribute() {
        $ccs = unserialize($this->cc);

        // get all emails that have seen SaveTheDate
        $seenEmails = $this->seen->pluck('email')->all();

        // store emails & if they've seen the SaveTheDate
        $ccArray = array();
        if($ccs && count($ccs) > 0) {
            foreach($ccs as $cc) {
                $ccArray[] = array(
                    'email' => $cc,
                    'seen'  => (in_array($cc, $seenEmails)) ? true : false,
                );
            }
        }

        return $ccArray;
    }

    /** 
     * Send save the date.
     */
    public function send() {

    	// send saveTheDate to main guest of Invite
    	$mainGuest     = $this->invite->main_guest->person;

        // all guests
        $guests         = $this->invite->guests;

        // send saveTheDate
        $saveTheDateMail   = new SaveTheDateMail($guests, $this->code);
    	$mail              = Mail::to($this->to);
        if($this->CC_format && count($this->CC_format)) {
            $mail->cc($this->CC_format);
        }
        $mail->send($saveTheDateMail);

        // html render
        $emailHtml = ($saveTheDateMail)->render();

        // make Email log
        $emailLog                   = new Email();
        $emailLog->subject          = 'Save the date sent';
        $emailLog->html             = $emailHtml;
        $emailLog->email_address    = $mainGuest->email;
        $emailLog->cc               = $this->cc;
        $emailLog->invite_id        = $this->invite_id;
        $emailLog->save();

        // update email ID
        $this->email()->associate($emailLog);
    }
}
