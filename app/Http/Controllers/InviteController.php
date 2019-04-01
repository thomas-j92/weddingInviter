<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InviteController extends Controller
{
    /**
     * Assign Person to new Invite, if already assigned to Invite, redirect to view Invite page.
     * @param  [Integer] $person_id Person ID.
     */
    public function create($person_id) {
        $invite_check   = \App\InviteGuests::where('person_id', $person_id);

        // Only create Invite if not assigned to another Invite
        $invite_id;
        if($invite_check->count() == 0) {
        	// Create new Invite
        	$invite         = \App\Invite::create();
            $invite_id      = $invite_id;
            
            // Create new InviteGuest - links Invite and Person together
            $create_arr     = array(
                'person_id' => $person_id,
                'invite_id' => $invite_id
            );
            $invite_guest   = \App\InviteGuests::create($create_arr);
        } else {
            $invite_id = $invite_check->first()->invite_id;
        }

    	return redirect('Invite/view/'.$invite_id);
    }

    public function view($invite_id) {
    	// Get Invite
    	$data['invite']  = \App\Invite::find($invite_id);

    	return view('admin.invites.view', $data);
    }
}
