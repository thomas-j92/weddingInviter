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

	/**
	 * Get any entires within the invite_guests table that are linked to Person.
	 * @return [Object] Invite_guests entires.
	 */
	public function rsvp_status() {
		return $this->hasOne('App\InviteGuests', 'person_id', 'id');
	}

	/**
	 * Loop through all People and index into array based on specific criteria.
	 * @return [Array] All People, indexed accordingly.
	 */
	public function scopeGetAll() {
		// Get all guests
		$all_guests = $this->all();

		// Loop through guests & assign into array based on specific criteria
		$guests_arr = array(
			'attending' 		=> array(),
			'not_attending' 	=> array(),
			'not_responded' 	=> array(),
			'not_invited' 		=> array(),
		);
		foreach($all_guests as $guest) {
			// If Person is assigned to an Invite
			if($guest->rsvp_status) {
				// If Person has responded to Invite
				if($guest->rsvp_status->rsvp == 1) {
					// If Person is attending
					if($guest->rsvp_status->attending == 1) {
						$guests_arr['attending'][] = $guest;
					}
					// If Person is not attending
					if($guest->rsvp_status->attending == 0) {
						$guests_arr['not_attending'][] = $guest;
					}
				} else {
					$guests_arr['not_responded'][] = $guest;
				}
			} else {
				// Person isn't currently assigned to an Invite
				$guests_arr['not_invited'][] = $guest;
			}
		}

		return $guests_arr;
	}
}
