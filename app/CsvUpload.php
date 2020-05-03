<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CsvUpload extends Model
{
	public $timestamps = false;
	protected $appends = ['errors'];

    public function container() {
    	return $this->belongsTo('App\CsvUploadContainer');
    }

    public function getErrorsAttribute() {
    	// default response
    	$response = array(
    		'success'	=> true,
    		'errors'	=> array()
    	);

    	if(strlen($this->first_name) < 2) {
    		$response['success']	= false;
    		$response['message'][] 	= 'The first name must be at least 2 characters long';
    	}

    	if(strlen($this->last_name) < 2) {
    		$response['success']	= false;
    		$response['message'][] 	= 'The last name must be at least 2 characters long';
    	}

    	return $response;

    }
}
