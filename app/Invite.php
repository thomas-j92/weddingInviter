<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
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

    /**
     * Get main guest assigned to an Invite.
     */
    public function getMainGuestAttribute() {
        // get main guest
        $mainGuest = $this->guests->where('type', 'main')->first();

        // get InviteGuest with Person details
        $guest      = InviteGuests::with('person')->find($mainGuest->id);

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
}
