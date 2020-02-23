<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
	protected $appends = ['created_at_uk'];

    public function getCreatedAtUkAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->created_at));
    }

    public function invite() {
    	return $this->belongsTo('App\Invite', 'invite_id');
    }
}