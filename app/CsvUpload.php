<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CsvUpload extends Model
{
	public $timestamps     = false;
	protected $appends     = ['errors'];
    protected $attributes  = [
        'status' => 'pending',
    ];

    public function container() {
    	return $this->belongsTo('App\CsvUploadContainer', 'container_id');
    }

    public function getErrorsAttribute() {
    	// default response
    	$response = array(
    		'success'	=> true,
    		'errors'	=> array()
    	);

    	if(strlen($this->first_name) < 2) {
    		$response['success']	= false;
    		$response['errors'][] 	= 'The first name must be at least 2 characters long';
    	}

    	if(strlen($this->last_name) < 2) {
    		$response['success']	= false;
    		$response['errors'][] 	= 'The last name must be at least 2 characters long';
    	}

        if(is_null($this->email)) {
            $response['success']    = false;
            $response['errors'][]   = 'Email address must be entered'; 
        }

        // $person = People::where('email', $this->email);
        // if($person->count() > 0) {
        //     $response['success']    = false;
        //     $response['errors'][]  = 'Email address already exists';
        // }

        $rsvpValues = array('1', '0', 'true', 'false', 'yes', 'no');
        if($this->day_guest != '' && !in_array($this->day_guest, $rsvpValues)) {
            $response['success']    = false;
            $response['errors'][]  = 'Day guest - must be ' . implode(", ", $rsvpValues);
        }
        if($this->night_guest != '' && !in_array($this->night_guest, $rsvpValues)) {
            $response['success']    = false;
            $response['errors'][]  = 'Night guest - must be ' . implode(", ", $rsvpValues);
        }
        if($this->rsvp_day != '' && !in_array($this->rsvp_day, $rsvpValues)) {
            $response['success']    = false;
            $response['errors'][]  = 'RSVP day - must be ' . implode(", ", $rsvpValues);
        }
        if($this->rsvp_night != '' && !in_array($this->rsvp_night, $rsvpValues)) {
            $response['success']    = false;
            $response['errors'][]  = 'RSVP night - must be ' . implode(", ", $rsvpValues);
        }
        if($this->wedding_venue != '' && !in_array($this->wedding_venue, $rsvpValues)) {
            $response['success']    = false;
            $response['errors'][]  = 'Wedding venue - must be ' . implode(", ", $rsvpValues);
        }

    	return $response;

    }
}
