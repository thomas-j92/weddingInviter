<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

	public function get($id) {
		$person = People::find($id);

		return $person;
	}

}
