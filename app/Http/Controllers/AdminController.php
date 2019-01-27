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
}
