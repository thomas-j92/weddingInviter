<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CsvUploadContainer extends Model
{
    public function uploads() {
    	return $this->hasMany('App\CsvUpload', 'container_id');
    }
}
