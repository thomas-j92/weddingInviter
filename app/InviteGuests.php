<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InviteGuests extends Model
{
	protected $table 	= 'invite_guests';
	protected $fillable = ['person_id', 'invite_id', 'code'];

	public function person() {
    	return $this->hasOne('App\People', 'id', 'person_id');
    }
}
