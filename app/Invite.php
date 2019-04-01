<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    public function add() {
    	$this->save();
    }

    public function assignedGuests() {
    	return $this->hasMany('App\InviteGuests', 'invite_id', 'id');
    }
}
