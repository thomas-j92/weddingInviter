<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Validator;
use Session;
use App\Mail\Invite;

use App\Invite as InviteModel;

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

    /**
     * Assign new Person to existing Invite.
     */
    public function assignNewPerson(Request $request) {
        if($request->invite_id) {
            if($request->first_name != '' && $request->last_name != '' && $request->email != '') {
                // Create new Person
                $insert_arr = array(
                    'first_name'    => $request->first_name,
                    'last_name'     => $request->last_name,
                    'email'         => $request->email
                );
                $person_id  = \App\People::insertGetId($insert_arr);
                // Create new InviteGuest - links Invite and Person together
                $create_arr     = array(
                    'person_id' => $person_id,
                    'invite_id' => $request->invite_id
                );
                $invite_guest   = \App\InviteGuests::create($create_arr);

                // Setup flashdata
                $request->session()->flash('success', "$request->first_name $request->last_name added to invite.");
            } else {
                $request->session()->flash('error', "First name, last name & email cannot be empty");
            }
        } else {
            $request->session()->flash('error', "No Invite ID provided");
        }

        return redirect('Invite/view/'.$request->invite_id);
    }

    /**
     * Remove a Person from an Invite.
     * @param  [Integer] $invite_id Invite ID.
     * @param  [Integer] $person_id Person ID.
     */
    public function removeGuestFromInvite($invite_id, $person_id) {
        $affectedRows = \App\InviteGuests::where('invite_id', $invite_id)
                                         ->where('person_id', $person_id)
                                         ->delete();

        if($affectedRows > 0) {
            \Session::flash('success', "Person has been deleted from invite.");
        } else {
            \Session::flash('error', "An error occurred");
        }

        return redirect('Invite/view/'.$invite_id);
    }

    /**
     * Send Invite.
     * @param  [Integer] $invite_id Invite ID.
     */
    public function send($invite_id) {
        $invite_guests = \App\InviteGuests::where('invite_id', $invite_id)
                                          ->get();
        
        // send email to all guests
        foreach($invite_guests as $guest) {
            $person     = \App\People::find($guest->person_id);
            $invite     = \App\Invite::find($invite_id);

            $code       = str_random(40);
            $update     = \App\InviteGuests::find($guest->id)
                                           ->update([
                                                'code' => $code
                                           ]);
            
            Mail::to($person->email)->send(new Invite($person, $invite, $code));
        }

        \Session::flash('success', "Invite sent.");
        return redirect('Invite/view/'.$invite_id);
    }

    public function errorPage() {
        return view('invitation.error');
    }

    public function verify(Request $request, $inviteCode) {
        $parts = explode("/", $request->path());

        return view('invitation.verify')->withCode($parts[1]);
    }

    public function verifySubmit(Request $request) {

        $validator = Validator::make($request->all(), [
            'code'      => 'required',
            'email'     => 'required',
        ]);

        // ensure all required data has been provided
        if(!$validator->fails()) {

            // Find Invite
            $invite = InviteModel::where('code', $request->code);
            if($invite->count() == 1) {
                $invite = $invite->first();

                // Find main guest
                $mainGuest = $invite->main_guest->person;

                // Verified, set session and proceed
                if($mainGuest->email == $request->email) {
                    Session::put('verify', $mainGuest->email);
                    
                    return redirect('invitation/'.$request->code.'/view');
                } else {
                    Session::flash('status', "Oi, Hackerman 5000! Emails don't match up");
                }

                // dd($mainGuest);
            } else {
                Session::flash('status', "Invite couldn't be found. Maybe it got lost in the mail...");
            }

            return redirect('invitation/'.$request->code . '/verify');
        } else {

            if($request->code) {
                Session::flash('status', "If you want free drinks, top being lazy and fill out the form!");

                return redirect('invitation/'.$request->code.'/verify');
            }
        }

        return redirect('invitation');

    }

    public function guestView($section, $code) {

        $invite = \App\Invite::where('code', $code)
                             ->with(['guests.person', 'plus_ones'])
                             ->first();

        return view('invitation.main')->withInvite($invite);

    }
}
