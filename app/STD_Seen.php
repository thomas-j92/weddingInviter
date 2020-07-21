<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class STD_Seen extends Model
{
    protected $table = 'save_the_date_seen';

    public function save_the_date() {
    	return $this->belongsTo('App\SaveTheDate');
    }
}
