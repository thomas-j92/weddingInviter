<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Load models
use App\People;
use App\Invite;
use App\SaveTheDate;
use App\STD_Bulk_Container;
use App\STD_Bulk_Element;

// Load libaries 
use Validator;

class SaveTheDateController extends Controller
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
        $validator = Validator::make($request->all(), [
            'inviteId'     => 'required',
        ]);

        $response = array(
            'response'  => false,
            'message'   => 'An error occurred'
        );

        // ensure all required data has been provided
        if(!$validator->fails()) {

            // find Invite
            $invite = Invite::find($request->inviteId);

            // create SaveTheDate
            $saveTheDate = new SaveTheDate;
            $saveTheDate->to = $invite->main_guest->person->email;

            // get all additional guest emails for any that need save the date sending to 
            if($request->additional) {
                $additionalGuestsArr = array();
                foreach($request->additional as $person_id => $add) {
                    if($add == '1') {
                        $person = People::find($person_id);

                        if($person) {
                            $additionalGuestsArr[] = $person->email;
                        }
                    }
                }
                $saveTheDate->cc = serialize($additionalGuestsArr);
            }

            $saveTheDate->invite()->associate($invite);
            $saveTheDate->save();

            // update response
            $response = array(
                'response'  => true,
                'message'   => 'Save the date sent'
            );
        }

        return response()->json($response);
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

    /**
     * Get all save the date records.
     */
    public function getAll() {

        // get all SaveTheDates
        $stds = SaveTheDate::all();

        // get Invites with no sent SaveTheDates
        $no_stds = Invite::doesntHave('save_the_dates')->get();

        return response()->json([
            'sent'      => $stds,
            'not_sent'  => $no_stds
        ]);

    }

    /**
     * Get all pending bulk STD requests.
     */
    public function getBulkRequests() {

        // get all pending bulk requests for STDs
        $bulkRequests = STD_Bulk_Container::where('status', 'pending')
                                          ->orderBy('created_at', 'DESC')
                                          ->get();

        return response()->json($bulkRequests);

    }

    /**
     * Save all STD's under one container so they can be sent at once.
     */
    public function saveBulkSend(Request $request) {

        // make bulk container
        $container = STD_Bulk_Container::create([
            'status'    => 'pending'
        ]);

        foreach($request->all() as $r) {
            $container->elements()->create([
                'status'    => 'pending',
                'invite_id' => $r,
            ]);
        }
        dd($request);
    }

    /**
     * Get a specific STD bulk container.
     */
    public function getBulkSend($id) {

        // get STD_Bulk_Container
        $container = STD_Bulk_Container::with(['elements'])
                                       ->find($id);

        return response()->json($container);
        
    }
}
