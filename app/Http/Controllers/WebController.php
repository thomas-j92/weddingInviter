<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function under_construction() {
    	return view('web.under_construction');
    }
}
