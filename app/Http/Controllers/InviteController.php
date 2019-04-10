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

    /**
     * View details concerning an Invite.
     * @param  [Integer] $invite_id Invite ID.
     */
    public function view($invite_id) {
        // Get Invite
        $invite             = \App\Invite::find($invite_id);
        $data['invite']     = $invite;

    	return view('admin.invites.view', $data);
    }

    /**
     * Assign existing Person to Invite.
     */
    public function assignToInvite(Request $request) {

        // If Person ID & Invite ID have been posted
        if($request->invite_id && $request->person_id) {
            // Create new InviteGuest - links Invite and Person together
            $create_arr     = array(
                'person_id' => $request->person_id,
                'invite_id' => $request->invite_id
            );
            $invite_guest   = \App\InviteGuests::create($create_arr);

            if($invite_guest) {
                $request->session()->flash('success', 'Person assigned to invite.');
            } else {
                $request->session()->flash('error', "Person couldn't be assigned to invite");
            }
        }
        
        return redirect('Invite/view/'.$request->invite_id);
    }

    public function assignNewPerson(Request $request) {
        if($request->invite_id) {
            if($request->first_name != '' && $request->last_name != '' && $request->email != '') {
                // Create new Person
                $insert_arr = array(
                    'first_name'    => $request->first_name,
                    'last_name'     => $request->last_name,
                    'email'         => $request->email
                );
                $p  = \App\People::insert($insert_arr);

                die;
            } else {
                $request->session()->flash('error', "First name, last name & email cannot be empty");
            }
        } else {
            $request->session()->flash('error', "No Invite ID provided");
        }
    }
}
