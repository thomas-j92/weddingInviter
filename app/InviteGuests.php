<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InviteGuests extends Model
{
	protected $table 	= 'invite_guests';
	protected $fillable = ['person_id', 'invite_id', 'code', 'type'];

	public function person() {
    	return $this->belongsTo('App\People', 'person_id');
    }

    public function invite() {
    	return $this->belongsTo('App\Invite', 'invite_id');
    }
}
