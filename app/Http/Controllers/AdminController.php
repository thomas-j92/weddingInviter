<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{	
	/**
	 * Main admin view. Will show all people information etc.
	 */
    public function index() {
    	return view('admin.main');
    }

    public function show() {
    	
    }

    public function guests($type = 'all') {
    	$people_model = new \App\People;

    	$data = array();
    	switch($type) {
    		case 'attending':
    			$data['title']  = 'Attending';
    			$data['guests'] = $people_model::where('attending', 1)
    										   ->get();
    		break;
    		case 'not_attending':
    			$data['title']  = 'Not Attending';
    			$data['guests'] = $people_model::where('attending', 0)
    										   ->where('rsvp', 1)
    										   ->get();
    		break;
    		case 'awaiting_reply':
    			$data['title']  = 'Awaiting Reply';
    			$data['guests'] = $people_model::where('rsvp', 0)
    										   ->get();
    		break;
    	}

    	return view('admin.guests', $data);
    }
}
