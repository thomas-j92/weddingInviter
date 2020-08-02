<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailAttachment extends Model
{
	public $timestamps = false;
	
    public function email() {
    	return $this->belongsTo('App\Email');
    }
}
