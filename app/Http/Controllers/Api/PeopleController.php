<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;

// Load models
use App\People;

// Load libaries 
use Validator;

class PeopleController extends Controller
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
            'firstName'     => 'required',
            'lastName'      => 'required',
            'email'         => 'required',
        ]);

        $response = array(
            'response'  => false,
            'message'   => 'An error occurred'
        );

        // ensure all required data has been provided
        if(!$validator->fails()) {
            // create People element
            $insert = People::create([
                'first_name'    => $request->firstName,
                'last_name'     => $request->lastName,
                'email'         => $request->email,
                'status'        => 'active'
            ]);
            if($insert) {
                $response['response']   = true;
                $response['message']    = 'New guest added';
            }
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
        $people = People::find($id);

        return response()->json($people);
    }

    /**
     * Get all active People.
     */
    public function showAll($filter) {
        $people = People::active();

        switch($filter) {
            case 'day_guests':
                $people = People::whereHas('invite', function($query) {
                    $query->where('rsvp', '1')
                          ->where('attending_day', '1');
                })->active();
            break;
            case 'night_guests':
                $people = People::whereHas('invite', function($query) {
                    $query->where('rsvp', '1')
                          ->where('attending_night', '1');
                })->active();
            break;
            case 'not_attending':
                $people = People::whereHas('invite', function($query) {
                    $query->where('rsvp', '1')
                          ->where('attending_day', '0')
                          ->where('attending_night', '0');
                })->active();
            break;
            case 'awaiting_reply':
                $people = People::whereHas('invite', function($query) {
                    $query->where('rsvp', '0');
                })->active();
            break;
            case 'not_invited':
                $people = People::doesntHave('invite')->active();
            break;
        }

        // get results
        $people = $people->get();

        return response()->json($people);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        // find Person
        $person = People::find($id);

        $response = array(
            'response'  => false,
            'message'   => 'An error occursed'
        );

        // update Person
        $updated = $person->update([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
        ]);
        // if updated, display message
        if($updated) {
            $response['response']   = true;
            $response['message']    = 'Guest updated';
        }

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
        $person = People::find($id);


        $response = array(
            'response'  => false
        );
        if($person) {
            $updated = $person->update([
                'status'    => 'disabled'
            ]);

            if($updated) {
                $response['response']   = true;
                $response['message']    = 'Guest has been removed';
            }
        }

        return response()->json($response);
    }

    /**
     * Get all People.
     */
    public function get_all() {

        // get all People
        $people = People::all();

        return response()->json($people);

    }
}
