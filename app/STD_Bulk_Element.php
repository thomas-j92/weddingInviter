<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class STD_Bulk_Element extends Model
{
    protected $table 	= 'save_the_dates_bulk_send_elements';
    protected $fillable = ['status', 'invite_id'];

    public function container() {
    	return $this->belongsTo('App/STD_Bulk_Container', 'container_id', 'id');
    }
}
