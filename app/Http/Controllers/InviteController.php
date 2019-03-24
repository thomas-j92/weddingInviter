<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InviteController extends Controller
{
    public function create($person_id) {
    	// Create new Invite
    	$invite         = \App\Invite::create();
        
        // Create new InviteGuest - links Invite and Person together
        $create_arr     = array(
            'person_id' => $person_id,
            'invite_id' => $invite->id
        );
        $invite_guest   = \App\InviteGuests::create($create_arr);

    	dd($invite->id);

    	
    }

    public function view($invite_id) {
    	// Get main person Invite is concerned with
    	$main_person  = \App\People::find($person_id);
    	$data['person'] = $main_person;

    	// Setup breadcrumbs
    	$full_name = $main_person->first_name . ' ' . $main_person->last_name;
    	$data['breadcrumbs'] = array(
    		"$full_name" 	=> url("People/edit/$person_id"),
    		'Invite'		=> url()->current()
    	);

    	return view('admin.invites.create', $data);
    }
}
