<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Response;
use \App\People;

class PeopleController extends Controller
{
	
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
		$update = DB::table('people')
            		->where('id', $request->where)
            		->update($request->updates);

        $response['success'] = FALSE;
        if($update > 0) {
        	$response['success'] = TRUE;
        }

       	return Response::json($response);
	}

}
