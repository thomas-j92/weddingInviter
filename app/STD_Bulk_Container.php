<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Load libaries
use Carbon\Carbon;

class STD_Bulk_Container extends Model
{
    protected $table 	= 'save_the_dates_bulk_send_containers';
    protected $fillable = ['status'];
    protected $appends 	= ['created_at_format'];

    public function getCreatedAtFormatAttribute() {
        return Carbon::parse($this->created_at)->format('d/m/Y H:i:s');
    }

    public function elements() {
    	return $this->hasMany('App\STD_Bulk_Element', 'container_id', 'id');
    }
}
