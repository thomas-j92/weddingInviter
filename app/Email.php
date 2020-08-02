<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
	protected $appends = ['created_at_uk', 'cc_format'];

    public function getCreatedAtUkAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->created_at));
    }

    public function getCCFormatAttribute()
    {
        return unserialize($this->cc);
    }

    public function invite() {
    	return $this->belongsTo('App\Invite', 'invite_id');
    }

    public function save_the_date() {
    	return $this->hasOne('App\SaveTheDate');
    }

    public function attachments() {
        return $this->hasMany('App\EmailAttachment');
    }
}
