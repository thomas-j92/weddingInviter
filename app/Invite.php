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
		'additional_guests'
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

    /**
     * Send Invite
     */
    public function send() {

        // get main guest of Invite
        $mainGuest = $this->main_guest->person;

        // generate PDF
        $file_path = $this->generatePdf();

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
