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
    	switch($type) {
    		case 'attending':
    			// $guests = App\People::attending();
    			// var_dump($guests);
    		break;
    	}
    }
}
