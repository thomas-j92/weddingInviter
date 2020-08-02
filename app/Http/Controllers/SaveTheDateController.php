<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// Load models
use App\SaveTheDate;
use App\STD_Seen;

// Load libaries
use Auth;

class SaveTheDateController extends Controller
{
    public function form($code) {
    	return view('save_the_dates.seen')->withCode($code);
    }

    /**
     * Verify SaveTheDate has been seen.
     */
    public function verify(Request $request, $code) {
    	// ensure email is always provided
    	$validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        // redirect if no email is provided
        if($validator->fails()) {
	    	return redirect(route('std.seen', $code))->withErrors($validator);
		}

    	// get SaveTheDate from code
    	$std = SaveTheDate::where('code', $code)
    					  ->first();

    	if($std) {
	    	$emailAllowed = false;
	    	foreach($std->invite->guests as $guest) {
	    		if(strtolower($guest->person->email) == strtolower($request->email)) {
	    			$emailAllowed = true;
	    		}
	    	}

		    if(!$emailAllowed) {
		    	// setup flashdata
		    	$request->session()->flash('error', 'Email not assigned to save the date');
		    } else {
		    	// ensure STD_Seen doesn't already exist for email address
		    	$existingLog = $std->seen()->where('email', $request->email);

		    	// save STD_Seen log
		    	if($existingLog->count() == 0) {
			    	$seen = new STD_Seen;
			    	$seen->email = $request->email;
			    	$std->seen()->save($seen);
			    }

		    	// setup flashdata
		    	$request->session()->flash('success', 'Thank you for letting us know');
		    }
	    } else {
	    	// setup flashdata
			$request->session()->flash('error', 'Save the date not found');
	    }

    	return redirect(route('std.seen', $code));
    }

    /**
     * Send preview of STD.
     */
    public function preview($id) {

        // get SaveTheDate
        $std = SaveTheDate::find($id);

        // get logged in User
        $email = Auth::user()->email;

        // send SaveTheDate to logged in User
        $std->send($email);

        return response()->json([
            'success' => true,
            'message'   => 'Save the date has been sent to you'
        ]);
    }
}
