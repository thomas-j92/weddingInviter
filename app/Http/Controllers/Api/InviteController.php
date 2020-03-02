<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Load Models
use App\People;
use App\Invite;
use App\PlusOne;
use App\InviteGuests;
use App\Email;

// Load Mail
use Mail;
use App\Mail\Invite as MailInvite;

// Load libaries 
use Validator;

class InviteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get main guest of Invite
        $mainGuest = People::find($request['person']['id']);

        // new Invite
        $newInvite = new Invite([
            'day'       => $request['type']['day'],
            'night'     => $request['type']['night'],
            'code'      => str_random(40),
        ]);  
        $newInvite->save();
        
        // new main InviteGuest
        $newInviteGuest = new InviteGuests();
        $newInviteGuest->type = 'main';
        $newInviteGuest->person()->associate($mainGuest);

        // assign main Person to Invite
        $newInvite->guests()->save($newInviteGuest);

        // assign additional guests to invite
        if($request['additionalGuests']) {
            foreach($request['additionalGuests'] as $additionalGuestId) {
                $guest = People::find($additionalGuestId);

                if($guest) {
                    // new additional InviteGuest
                    $newInviteGuest = new InviteGuests();
                    $newInviteGuest->type = 'additional';
                    $newInviteGuest->person()->associate($guest);

                    // assign additional guest to Invite
                    $newInvite->guests()->save($newInviteGuest);
                }
            }
        }

        // assign plus ones to invite
        if($request['plusOnes']) {
            foreach($request['plusOnes'] as $plusOne) {
                $newPlusOne                 = new PlusOne();

                // only update first name if value is provided
                if(isset($plusOne['first_name'])) {
                    $newPlusOne->first_name = $plusOne['first_name'];
                }
                // only update last name if value is provided
                if(isset($plusOne['last_name'])) {
                    $newPlusOne->last_name = $plusOne['last_name'];
                }
                // only update vegetarian if value is provided
                if(isset($plusOne['vegetarian'])) {
                    $newPlusOne->vegetarian = $plusOne['vegetarian'];
                }
                // only update vegan if value is provided
                if(isset($plusOne['vegan'])) {
                    $newPlusOne->vegan = $plusOne['vegan'];
                }
                // only update requirements if value is provided
                if(isset($plusOne['requirements'])) {
                    $newPlusOne->dietary_requirements = $plusOne['requirements'];
                }

                // assign plus one to Invite
                $newInvite->plus_ones()->save($newPlusOne);
            }
        }

        return response()->json($newInvite);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invite = Invite::with(['plus_ones'])
                        ->find($id);

        return response()->json($invite);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function send($id) {
        // get Invite
        $invite = Invite::find($id);

        // get main guest of Invite
        $mainGuest = $invite->main_guest->person;

        // send Invite notification
        $emailSubject   = 'Online Invite';
        $emailInvite    = new MailInvite($mainGuest, $invite, $emailSubject);
        Mail::to($mainGuest->email)->send($emailInvite);

        // html render
        $emailHtml = ($emailInvite)->render();

        // make Email log
        $emailLog                   = new Email();
        $emailLog->subject          = $emailSubject;
        $emailLog->html             = $emailHtml;
        $emailLog->email_address    = $mainGuest->email;
        $emailLog->invite_id        = $id;
        $emailLog->save();

        return response()->json([
            'success' => true
        ]);
        
    }

    /**
     * Handles when an Invite has been completed via the web form.
     */
    public function webCreate(Request $request) {
        $validator = Validator::make($request->all(), [
            'formData'      => 'required',
            'code'          => 'required',
        ]);

        // ensure all required data has been provided
        $message    = 'An error occurred';
        $success    = false;
        if(!$validator->fails()) {

            // get Invite from code
            $inviteCode = $request->code;
            $invite     = Invite::where('code', $inviteCode)->first();
            $inviteId   = $invite->id;

            // loop through guest details
            foreach($request->formData as $data) {
                if(isset($data['id']) && !is_null($data['id'])) {

                    // update rsvp details
                    $guest = InviteGuests::where('invite_id', $inviteId)->where('person_id', $data['id'])->first();
                    $guest->rsvp            = true;
                    $guest->attending_day   = ($data['rsvp']['day'] == 'true') ? 1 : 0;
                    $guest->attending_night = ($data['rsvp']['night'] == 'true') ? 1 : 0; 
                    $guest->save();

                    // update dietary requirements
                    $guest                          = People::find($data['id']);
                    $guest->vegetarian              = ($data['diet']['requirement'] == 'vegetarian') ? 1 : 0;
                    $guest->vegan                   = ($data['diet']['requirement'] == 'vegan') ? 1 : 0;
                    $guest->dietary_requirements    = $data['diet']['details'];
                    $guest->save();

                    // brand the request as a success
                    $success = true;
                    $message = 'Thank you, this has been submitted';
                }
            }
        } 

        return response()->json(array(
            'success'   => $success,
            'message'   => $message
        ));
    }

    /**
     * Get all emails assigned to an Invite.
     * @param  [Integer] $invite_id Invite ID.
     */
    public function getEmails($invite_id) {

        // get Invite
        $invite     = Invite::find($invite_id);

        // get Emails assigned to Invite
        $emails     = $invite->emails()->get();

        return response()->json($emails);

    }

    /**
     * Add additional guests to Invite.
     */
    public function addAdditionalGuests(Request $request) {

        $numAdded = 0;
        foreach($request->guests as $guestId) {
            if(!is_null($guestId)) {
                InviteGuests::create([
                    'invite_id' => $request->inviteId,
                    'person_id' => $guestId,
                    'type'      => 'additional'
                ]);

                $numAdded++;
            }

        }

        return response()->json([
            'numAdded' => $numAdded
        ]);

    }

    /**
     * Delete additional guests.
     * @param [Integer] $guest_id ID.
     */
    public function deleteAdditionalGuest($guest_id) {

        // delete additional guest
        $guest = InviteGuests::find($guest_id);
        $guest->delete();

        return response()->json([
            'success' => true
        ]);

    }

    /**
     * Add plus one to Invite.
     */
    public function addPlusOne(Request $request) {

        // get Invite
        $invite = Invite::find($request['inviteId']);

        // add PlusOne
        $invite->plus_ones()->create([
            'first_name'                => $request['data']['first_name'],
            'last_name'                 => $request['data']['last_name'],
            'vegetarian'                => ($request['data']['dietary_requirements'] == 'vegetarian') ? true : false,
            'vegan'                     => ($request['data']['dietary_requirements'] == 'vegan') ? true : false,
            'dietary_requirements'      => $request['data']['details'],
        ]);

        return response()->json([
            'success' => true
        ]);

    }

    /**
     * Delete plus one.
     */
    public function deletePlusOne($plus_one_id) {

        // delete plus one
        $plus_one = PlusOne::find($plus_one_id);
        $plus_one->delete();

        return response()->json([
            'success' => true
        ]);

    }
}
