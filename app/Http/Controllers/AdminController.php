<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{	
    public function __construct(){
        $this->middleware('auth');
    }

	/**
	 * Main admin view. Will show all people information etc.
	 */
    public function main() {
    	return view('admin.main');
    }

    public function show() {
    	
    }

    public function guests($type = 'all') {
        $all_guests  = \App\People::getAll();

    	$data = array();
    	switch($type) {
    		case 'attending':
    			$data['title']  = 'Attending';
    			$data['guests'] = $all_guests['attending'];
    		break;
    		case 'not_attending':
    			$data['title']  = 'Not Attending';
    			$data['guests'] = $all_guests['not_attending'];
    		break;
    		case 'awaiting_reply':
    			$data['title']  = 'Awaiting Reply';
    			$data['guests'] = $all_guests['not_responded'];
    		break;
            case 'not_invited':
                $data['title']  = 'Not Invited';
                $data['guests'] = $all_guests['not_invited'];
            break;
    	}

    	return view('admin.guests', $data);
    }
}
