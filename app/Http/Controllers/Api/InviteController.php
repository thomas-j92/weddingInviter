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

// Load libaries 
use Carbon\Carbon;
use Validator;
use Spatie\Activitylog\Models\Activity;

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
        $invite = Invite::with(['plus_ones', 'save_the_dates' => function($query) {
                            $query->orderBy('created_at', 'DESC');
                        }])
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

        // find Invite
        $invite = Invite::find($id);

        // default response
        $response = array(
            'success'   => false,
            'message'   => 'An error occurred'
        );

        // only update Invite elements that are within $request
        if(isset($request['day'])) {
            $invite['day'] = ($request['day'] == 'true') ? true : false;

            // mark as successful
            $response['success']    = true;
            $response['message']    = 'Invite has been updated';
        }
        if(isset($request['night'])) {
            $invite['night'] = ($request['night'] == 'true') ? true : false;

            // mark as successful
            $response['success'] = true;
            $response['message']    = 'Invite has been updated';
        }

        // save updates
        $invite->save();

        return response()->json($response);

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

        // Send Invite
        $invite->send();

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

                    if($data['type'] == 'guest') {
                        // update rsvp details
                        $guest = InviteGuests::where('invite_id', $inviteId)->where('person_id', $data['id'])->first();
                        $guest->rsvp            = true;
                        $guest->attending_day   = ($data['rsvp']['day'] == 'true') ? 1 : 0;
                        $guest->attending_night = ($data['rsvp']['night'] == 'true') ? 1 : 0; 
                        $guest->area            = 'web'; // used for activity logging
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
                    } elseif($data['type'] == 'plus_one') {
                        $plus_one                           = PlusOne::find($data['id']);
                        $plus_one->rsvp                     = true;
                        $plus_one->first_name               = $data['first_name'];
                        $plus_one->last_name                = $data['last_name'];
                        $plus_one->vegetarian               = ($data['dietary_requirement'] == 'vegetarian') ? 1 : 0;
                        $plus_one->vegan                    = ($data['dietary_requirement'] == 'vegan') ? 1 : 0;
                        $plus_one->dietary_requirements     = $data['dietary_details'];
                        $plus_one->area                     = 'web'; // used for activity logging
                        $plus_one->save();

                        // brand the request as a success
                        $success = true;
                        $message = 'Thank you, this has been submitted';
                    }
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
        $emails     = $invite->emails()
                             ->orderBy('created_at', 'DESC')
                             ->get();

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

    /**
     * Update RSVP details for a guest (can be a main guest or a plus one).
     */
    public function updateRsvp(Request $request) {

        // message that will be included in response
        $message    = 'An error occurred';

        // whether rsvp update was a success
        $success    = false;

        // handle request differently based off what type of guest they are
        switch($request['guestType']) {
            case 'main':
            case 'secondary':
                // find guest
                $guest = InviteGuests::find($request['selected']['id']);

                // update main guest RSVP details
                $guest->attending_day       = $request['selected']['attending_day'];
                $guest->attending_night     = $request['selected']['attending_night'];
                $guest->rsvp                = 1;
                $guest->save();

                // update response message
                $message    = ucwords($request['guestType']) . ' guest RSVP updated';

                // update to success
                $success    = true;
            break;
            case 'plus_one':
                // find plus one
                $plusOne = PlusOne::find($request['selected']['id']);

                // update plus one RSVP details
                $plusOne->attending_day       = $request['selected']['attending_day'];
                $plusOne->attending_night     = $request['selected']['attending_night'];
                $plusOne->rsvp                = 1;
                $plusOne->save();

                // update response message
                $message    = 'Plus one RSVP updated';

                // update to success
                $success    = true;
            break;
        }

        // send response
        return response()->json([
            'success'   => $success,
            'message'   => $message
        ]);

    }

    /**
     * Get all activity for Invite.
     * @param  [Integer] $id Invite ID.
     * @return [Object] Collection of all activity.
     */
    public function getActivity($id) {

        // get Invite
        $invite = Invite::find($id);

        // used to store all Activity
        $collection = collect([]);

        // data to be sent back as response
        $response_data = false;

        // get Invite Guest activity
        $activity = Activity::all()->last();
        if($activity) {
            $activity = $activity->where('properties', 'like', '%"invite_id":"'.$id.'"%')
                                 ->orderBy('created_at', 'DESC')
                                 ->get();

            // loop through Activity and store formatted date
            foreach($activity->all() as $a) {
                $createdAt = Carbon::createFromFormat('Y-m-d H:i:s', $a->created_at);
                $createdAt = $createdAt->format('d/m/Y H:i:s');

                $a->created_at_format = $createdAt;
            }
           
           $response_data = $activity->all();
       }

       return response()->json($response_data);
    }

    /**
     * Get all Invites.
     */
    public function getAll() {

        $invites = Invite::with(['plus_ones'])
                         ->get();

        return response()->json($invites);

    }

    /**
     * Get Invite By Code.
     */
    public function getByCode($code) {

        $invite = Invite::with(['plus_ones', 'guests.person'])
                        ->where('code', $code)
                        ->first();

        return response()->json($invite);

    }

    /**
     * RSVP via web.
     */
    public function webRsvp(Request $request, $id) {

        switch($request->guest_type) {
            case 'main':
            case 'additional':
                // Find Guest
                $guest = InviteGuests::find($request->id);

            break;
        }

        // Update RSVP details
        $guest->attending_day   = ($request['rsvp']['day'] == 'true') ? true : false;
        $guest->attending_night = ($request['rsvp']['night'] == 'true') ? true : false;
        $guest->rsvp            = true;
        $guest->save();

        // Update diet details
        $person                         = $guest->person;
        $person->vegetarian             = ($request['diet']['requirement'] == 'vegetarian') ? true : false;
        $person->vegan                  = ($request['diet']['requirement'] == 'vegan') ? true : false;
        if($request['diet']['requirement'] == 'other') {
            $person->dietary_requirements =  $request['diet']['details'];
        }
        $person->save();

        return response()->json([
            'success'   => true,
            'feedback'  => "Guest has RSVP'ed"
        ]);
    }
}
