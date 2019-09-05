<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlusOne extends Model
{
    public function invite() {
    	return $this->belongsTo('App\Invite', 'invite_id');
    }
}
