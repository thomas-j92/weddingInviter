<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Will track all activity for Model
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class PlusOne extends Model
{
	// Specify what columns to log activity on
	use LogsActivity;
    protected $logFillable = true;

	protected $fillable = ['first_name', 'last_name', 'vegetarian', 'vegan', 'dietary_requirements'];

	// used to store where PlusOne was updated
    public $area        = 'admin';

    public function tapActivity(Activity $activity, string $eventName) {
        // add area to property column
        $activity->properties = $activity->properties->put('area', $this->area)
                                                     ->put('invite_id', "$this->invite_id")
                                                     ->put('item', 'plus one');
    }

    public function getDescriptionForEvent(string $eventName): string {
    	
    	// only show name in log if name was provided
    	$name = 'Plus one ';
    	if($this->first_name != '') {
    		$name = $this->first_name . " ";
    	}
    	if($this->last_name != '') {
    		$name .= $this->last_name . " ";
    	}

        return $name . "has been {$eventName}";
    }

    public function invite() {
    	return $this->belongsTo('App\Invite', 'invite_id');
    }
}
