<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

// Load Mail
use App\Mail\SaveTheDate as SaveTheDateMail;

// Load libaries
use PDF;
use Mail;
use Carbon\Carbon;

class SaveTheDate extends Model
{
    protected $appends = ['created_at_format', 'sent_at_format', 'to_array', 'CC_array'];

	public static function boot() {
        parent::boot();

        static::creating(function (SaveTheDate $item) {
            // generate random code for save the date
            $item->code = str_random(40);

            // $item->send();
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

    public function getSentAtFormatAttribute() {
        return Carbon::parse($this->sent_at)->format('d/m/Y');
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
     * Greeting message for SaveTheDate.
     */
    public function getGreetingAttribute() {
        $greeting = '';
        foreach($this->invite->guests as $i => $guest) {
            $person     = $guest->person;

            $greeting   .= $person->first_name;

            if($i == (count($this->invite->guests)-2)) {
                $greeting .= ' & ';
            } else {
                if($i+1 !== count($this->invite->guests)) {
                    $greeting .= ', ';
                }
            }
        }

        return $greeting;
    }

    /**
     * Generate PDF.
     */
    public function generatePdf($update = true, $testing = false) {

        // Create file
        $data = [
            'greeting' => $this->greeting,
            'code'     => $this->code,
        ];
        $pdf = PDF::loadView('pdfs.saveTheDate', $data);

        if($testing) {
            return $pdf->stream();
        }

        $output = $pdf->output();

        // Get our disk to store the PDF in.
        $disk = Storage::disk('local');

        // Save the file with the PDF output.
        $name = 'save_the_dates/'.$this->invite_id.'/'.$this->id.'/SaveTheDate.pdf';
        if ($disk->put($name, $output)) {
            // File created/stored 
            $filepath = $disk->path($name);

            $this->file_path = $name;
            if($update) {
                $this->save();
            }

            return $name;
        }

        return FALSE;
    }

    /** 
     * Send save the date.
     */
    public function send($email = false) {

    	// send saveTheDate to main guest of Invite
    	$mainGuest     = $this->invite->main_guest->person;

        // all guests
        $guests         = $this->invite->guests;

        // sending email
        $to = $this->to;
        if($email) {
            $to = $email;
        }

        // send saveTheDate
        $saveTheDateMail   = new SaveTheDateMail($guests, $this->code, $this->file_path, $email);
    	$mail              = Mail::to($to);
        if(!$email && $this->CC_format && count($this->CC_format)) {
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

        // make Email attachment
        $emailAttachment            = new EmailAttachment;
        $emailAttachment->file_path = $this->file_path;
        $emailLog->attachments()->save($emailAttachment);
        $emailAttachment->save();

        // update email ID
        $this->email()->associate($emailLog);
    }
}
