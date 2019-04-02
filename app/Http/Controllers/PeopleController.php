<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Response;
use \App\People;

class PeopleController extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }
	
	/**
	 * Get all people in DB.
	 * @return [Object] All people records in DB.
	 */
	public function get_all() {
		$people = People::all();

		return $people;
	}

	/**
	 * Get a specific person by ID.
	 * @param  [Integer] $id ID of person.
	 * @return [Object] Results of DB query.
	 */
	public function get($id) {
		$person = People::find($id);

		return $person;
	}

	/**
	 * Get a specific person by ID, returned JSON encoded.
	 * @param  [Integer] $id ID of person.
	 * @return [Object] Results of DB query, JSON encoded.
	 */
	public function get_ajax($id) {
		$person = People::find($id);

		return json_encode($person);
	}

	/**
	 * Edits a persons basic details.
	 * @param  Request $request [description]
	 * @return [JSON] Contains feedback to wether update took place.
	 */
	public function quick_edit(Request $request) {
		if(isset($request->id)) {

			// Store all values that potentially need editting in an array.
			$update_arr = array(
				'first_name' 	=> $request->first_name,
				'last_name' 	=> $request->last_name,
				'email' 		=> $request->email,
			);
			$update = People::find($request->id)->batch_edit($update_arr);

			// Use $success variable to calculate wether update was successful (show relevant messages) 
	        $success = FALSE;
	        if($update > 0) {
	        	$success = TRUE;
	        }

	        // Set up flashdata
	        if($success) {
	        	$request->session()->flash('success', 'Individual was updated successfully');
	        } else {
	        	$request->session()->flash('error', "Individual couldn't be updated");
	        }
	    }

	    // Redirect back to page request was made.
       	return redirect()->back();
	}

	/**
	 * Show edit page.
	 * @param  [Integer] $id Person ID.
	 */
	public function edit($id) {
		$people_model = new People;

		// get person details
		$data['person'] 	= $this->get($id);

    	// store ID
    	$data['person_id'] 	= $id;

    	// get Invite (if any) 
    	$invite 			= \App\InviteGuests::where('person_id', $id);
    	$data['invite']  	= ($invite->count() > 0) ? $invite->first() : null;

		return view('admin.edit_person', $data);
	}

	/**
	 * Edit a Person's details.
	 */
	public function edit_submit(Request $request) {
		// ensure person ID is always passed
		if(isset($request->person_id)) {
			// Store all values that potentially need editting in an array.
			$update_arr = array(
				'first_name' 	=> $request->first_name,
				'last_name' 	=> $request->last_name,
				'email' 		=> $request->email,
			);
			$update = People::find($request->person_id)->batch_edit($update_arr);

			// Use $success variable to calculate wether update was successful (show relevant messages) 
	        $success = FALSE;
	        if($update > 0) {
	        	$success = TRUE;
	        }

	        // Set up flashdata
	        if($success) {
	        	$request->session()->flash('success', 'Individual was updated successfully');
	        } else {
	        	$request->session()->flash('error', "Individual couldn't be updated");
	        }
		}
		
		// Redirect back to page request was made.
       	return redirect()->back();
	}

	/**
	 * AJAX search for People.
	 * @return [String] JSON encoded array.
	 */
	public function ajax_search(Request $request) {
		$search = $request->search_string;
		
		// Search first name, last name & email for search string
		$people = \App\People::where('first_name', 'like', '%'.$search.'%')
							 ->orWhere('last_name', 'like', '%'.$search.'%')
							 ->orWhere('email', 'like', '%'.$search.'%')
							 ->limit(5)
							 ->get();

		return json_encode($people);
	}
}
