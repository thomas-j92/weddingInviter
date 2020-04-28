<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CsvUpload extends Model
{
	public $timestamps = false;
    public function container() {
    	return $this->belongsTo('App\CsvUploadContainer');
    }

    public static function getErrorsAttribute() {
    	// validate 
    }
}
