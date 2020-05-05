<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class People extends Model
{
	use SoftDeletes;

	protected $fillable 	= ['first_name', 'last_name', 'status', 'email'];
	protected $appends 		= ['invite_status'];
	protected $attributes 	= [
        'status' => 'active',
    ];

	/**
	 * Get any entires within the invite_guests table that are linked to Person.
	 * @return [Object] Invite_guests entires.
	 */
	public function invite() {
		return $this->hasOne('App\InviteGuests', 'person_id', 'id');
	}
	
	/**
	 * Filter People by active status.
	 */
	public function scopeActive($query) {
		return $query->where('status', 'active');
	}

	/**
	 * Get Invite status.
	 */
	public function getInviteStatusAttribute() {
		$invite = $this->invite;

		if($invite) {
			if($invite->rsvp == 1) {
				if($invite->attending == 1) {
					return 'attending';
				} else {
					return 'not attending';
				}
			} else {
				return 'awaiting_reply';
			}
		}

		return 'not_invited';
	}
}
