<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

// Load libaries
use PDF;
use Mail;

// Mail
use App\Mail\Invite as MailInvite;
use App\Mail\InviteReceipt as MailInviteReceipt;

class Invite extends Model
{
    use SoftDeletes;

	protected $fillable = [
        'day',
        'night',
        'code'
    ];

	protected $appends 	= [
		'main_guest',
		'additional_guests',
        'rsvp',
	];
	
    public function guests() {
    	return $this->hasMany('App\InviteGuests', 'invite_id', 'id');
    }

    public function plus_ones() {
    	return $this->hasMany('App\PlusOne', 'invite_id', 'id');
    }

    public function emails() {
        return $this->hasMany('App\Email', 'invite_id', 'id');
    }

    public function save_the_dates() {
        return $this->hasMany('App\SaveTheDate', 'invite_id', 'id');
    }

    public function getRsvpAttribute() {
        $guests = $this->guests;

        $hasRSVP = true;
        foreach($guests as $guest) {
            if($guest->rsvp == false) {
                $hasRSVP = false;
            }
        }

        return $hasRSVP;
    }

    /**
     * Get main guest assigned to an Invite.
     */
    public function getMainGuestAttribute() {
        // get main guest
        $mainGuest = $this->guests->where('type', 'main')->first();

        $guest = null;
        if($mainGuest) {
            // get InviteGuest with Person details
            $guest      = InviteGuests::with('person')->find($mainGuest->id);
        }

    	return $guest; 
    }

    /**
     * Get additional guests assigned to an Invite.
     */
    public function getAdditionalGuestsAttribute() {
    	 // get additional guests
        $additionalGuests = $this->guests->where('type', 'additional');
        
        $additionalArr = [];        
        foreach($additionalGuests as $guest) {
            // get InviteGuest with Person details
            $additionalArr[] = InviteGuests::with('person')->find($guest->id);
        }

        return $additionalArr;
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
        $pdf = PDF::loadView('pdfs.invite', $data);

        // dd($testing);

        if($testing) {
            return $pdf->stream();
        }

        $output = $pdf->output();

        // Get our disk to store the PDF in.
        $disk = Storage::disk('local');

        // Save the file with the PDF output.
        $name = 'invites/'.$this->invite_id.'/'.$this->id.'/Invite.pdf';
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

    public function sendReceipt() {

        $mainGuest = $this->main_guest->person;

        try{
            // send Invite Receipt
            $emailSubject   = 'RSVP Receipt';
            $emailReceipt   = new MailInviteReceipt($mainGuest, $this, $emailSubject);
            Mail::to('tommy_jinks@hotmail.co.uk')->send($emailReceipt);
        }
        catch(\Exception $e){
            // Never reached
            
            dd($e);
        }

        dd($this->main_guest);

    }

    /**
     * Send Invite
     */
    public function send() {

        // get main guest of Invite
        $mainGuest = $this->main_guest->person;

        // generate PDF
        $file_path = $this->generatePdf(true, true);

        die;

        // send Invite notification
        $emailSubject   = 'Online Invite';
        $emailInvite    = new MailInvite($mainGuest, $this, $emailSubject, $file_path);
        Mail::to($mainGuest->email)->send($emailInvite);

        // html render
        $emailHtml = ($emailInvite)->render();

        // make Email log
        $emailLog                   = new Email();
        $emailLog->subject          = $emailSubject;
        $emailLog->html             = $emailHtml;
        $emailLog->email_address    = $mainGuest->email;
        $emailLog->invite_id        = $this->id;
        $emailLog->save();

        // make Email attachment
        $emailAttachment            = new EmailAttachment;
        $emailAttachment->file_path = $file_path;
        $emailLog->attachments()->save($emailAttachment);
        $emailAttachment->save();
    }
}
