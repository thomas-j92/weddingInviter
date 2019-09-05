<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Load Models
use App\People;
use App\Invite;
use App\PlusOne;
use App\InviteGuests;

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
        //
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
}
