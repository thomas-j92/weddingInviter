<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
	protected $fillable = ['day', 'night'];
	
    public function guests() {
    	return $this->hasMany('App\InviteGuests', 'invite_id', 'id');
    }

    public function plus_ones() {
    	return $this->hasMany('App\PlusOne', 'invite_id', 'id');
    }
}
