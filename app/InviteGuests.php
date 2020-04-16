<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Will track all activity for Model
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class InviteGuests extends Model
{
	// Specify what columns to log activity on
	use LogsActivity;
    protected static $logAttributes = ['attending_day', 'attending_night', 'rsvp'];

	protected $table 	= 'invite_guests';
	protected $fillable = ['person_id', 'invite_id', 'type'];

    // used to store where InviteGuest was updated
    public $area        = 'admin';

    public function tapActivity(Activity $activity, string $eventName) {
        // add area to property column
        $activity->properties = $activity->properties->put('area', $this->area)
                                                     ->put('invite_id', "$this->invite_id")
                                                     ->put('item', 'guest');
    }

    public function getDescriptionForEvent(string $eventName): string {
        return $this->person->first_name . " " . $this->person->last_name . " has been {$eventName}";
    }

	public function person() {
    	return $this->belongsTo('App\People', 'person_id');
    }

    public function invite() {
    	return $this->belongsTo('App\Invite', 'invite_id');
    }
}
