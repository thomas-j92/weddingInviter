<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlusOne extends Model
{

	protected $fillable = ['first_name', 'last_name', 'vegetarian', 'vegan', 'dietary_requirements'];

    public function invite() {
    	return $this->belongsTo('App\Invite', 'invite_id');
    }
}
