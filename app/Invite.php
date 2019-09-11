<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
	protected $fillable = ['day', 'night'];

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

    public function getMainGuestAttribute() {
    	return $this->guests->where('type', 'main')->first();
    }

    public function getAdditionalGuestsAttribute() {
    	return $this->guests->where('type', 'additional');
    }
}
