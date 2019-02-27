<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    
    /**
     * Pass data to a message component view & return the outcome. 
     * @return [String] HTML of view.
     */
	public function returnMessageCode(Request $request) {
		// Structure data that is passed to view.
		$view_arr = array(
			'message'	=> $request->message,
			'type' 		=> $request->type
		);

		return view('components.messages', $view_arr);
	}

}
