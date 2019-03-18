<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{

	/**
	 * Batch edit multiple fields.
	 * @param  [Array] $updates Fields/values that need updating.
	 * @return [Integer] Number of People that were successfully updated.
	 */
	public function batch_edit($updates) {
		// Store how many edits were successful
		$num_edits = 0;

		// Loop through each update value and call edit function
		foreach($updates as $field_name => $value) {
			$edit_person = $this->edit($field_name, $value);

			// Increment edit count if Person was updated
			if($edit_person) {
				$num_edits++;
			}
		}

		return $num_edits;
	}

	/**
	 * Edit a field concerning a Person.
	 * @param  [String] $field_name Field name.
	 * @param  [String] $value New value.
	 * @return [Boolean] TRUE if edit was successful, otherwise returns FALSE.
	 */
	public function edit($field_name, $value) {
		// Wether edit was successful or not
		$save = false;

		// Only update Person if data is different to whats currently stored in DB
		if($this->$field_name !== $value) {
			// Setup an activity log
			$field_name_formatted = str_replace("_", " ", $field_name);
			$props = array(
				'old' => array(
					$field_name 	=> $this->$field_name
				), 
				'new' => array(
					$field_name 	=> $value
				)
			);
			activity()->performedOn($this)
				   	  ->causedBy(\Auth::user()->id)
				   	  ->withProperties($props)
				   	  ->log("edited");

			// Update Person
			$this->$field_name = $value;
			$save = $this->save();

		}
		
		return $save;
	}
}
