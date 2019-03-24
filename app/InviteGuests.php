<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InviteGuests extends Model
{
	protected $table 	= 'invite_guests';
	protected $fillable = ['person_id', 'invite_id'];
}
