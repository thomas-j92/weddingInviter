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
        
    }

    /**
     * Get all active People.
     */
    public function showAll($filter) {
        $people = People::all();

        switch($filter) {
            case 'attending':
                $people = People::whereHas('rsvp_status', function($query) {
                    $query->where('rsvp', '1')
                          ->where('attending', '1');
                })->get();
            break;
            case 'not_attending':
                $people = People::whereHas('rsvp_status', function($query) {
                    $query->where('rsvp', '1')
                          ->where('attending', '0');
                })->get();
            break;
            case 'awaiting_reply':
                $people = People::whereHas('rsvp_status', function($query) {
                    $query->where('rsvp', '0');
                })->get();
            break;
            case 'not_invited':
                $people = People::doesntHave('rsvp_status')->get();
            break;
        }

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
}
