<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;

// Load models
use App\People;
use App\CsvUploadContainer;
use App\CsvUpload;

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
        
    }

    /**
     * Get all People.
     */
    public function get_all() {

        // get all People
        $people = People::with(['invite'])->get();

        return response()->json($people);

    }

    /**
     * Delete Person.
     */
    public function deletePerson($id, Request $request) {

        // get Person
        $person     = People::find($id);

        // response message
        $response    = array(
            'message'   => 'Person deleted',
            'success'   => true
        );

        // if Person is assigned to Invite
        if($person->invite()->count() > 0) {
            // get InviteGuest that Person is assigned to 
            $inviteGuest    = $person->invite()->first();

            // get Invite that Person is assigned to 
            $invite         = $inviteGuest->invite()->first();

            // if attempting to delete a main Guest
            if($request['type'] == 'main') {
                // loop though all InviteGuest's assigned to Invite and delete them
                foreach($invite->guests()->get() as $g) {
                    $g->delete();
                }

                // delete Invite
                $invite->delete();

                // update response message
                $response['message'] = 'Person & Invite deleted';
            }

            // if attempting to delete an additional Guest
            if($request['type'] == 'additional') {
                // unassign guest or delete invite based off input
                switch($request['option']) {
                    case 'unassign_guest':
                        $inviteGuest->delete();

                        // update response message
                        $response['message'] = 'Person deleted & unassigned from Invite';
                    break;

                    case 'delete_invite':
                        // loop though all InviteGuest's assigned to Invite and delete them
                        foreach($invite->guests()->get() as $g) {
                            $g->delete();
                        }

                        // delete Invite
                        $invite->delete();

                        // update response message
                        $response['message'] = 'Person & Invite deleted';
                    break;
                }
            }
        }

        // delete Person
        $person->delete();

        return response()->json($response);

    }

    public function upload(Request $request) {

      // ensure file has been provided
      $validator = Validator::make($request->all(), [
          'file'     => 'required|mimes:csv',
      ]);

      // default response
      $response = array(
          'success'   => false,
          'message'   => 'An error occurred'
      );

      // read CSV file line-by-line
      $file_handle = fopen($request['file'], 'r');
      $dataArr    = array();
      $headersArr = array();
      while (!feof($file_handle)) {
        if(count($headersArr) == 0) {
          $headersArr[] = fgetcsv($file_handle, 0, ',');
        } else {
          $dataArr[] = fgetcsv($file_handle, 0, ',');
        }
      }
      fclose($file_handle);

      $numUploaded = count($dataArr);
      foreach($dataArr as $d) {
        $firstName    = $d[0];
        $lastName     = $d[1];
        $email        = $d[2];
        $dayGuest     = $d[3];
        $nightGuest   = $d[4];
        $rsvpDay      = $d[5];
        $rsvpNight    = $d[6];
        $weddingVenue = $d[7];

        // create CsvUploadContainer
        $csvUploadContainer           = new CsvUploadContainer;
        $csvUploadContainer->status   = 'pending';
        $csvUploadContainer->save();

        // create CsvUpload
        $csvUpload                = new CsvUpload;
        $csvUpload->first_name    = ($firstName !== '') ? $firstName : null;
        $csvUpload->last_name     = ($lastName !== '') ? $lastName : null;
        $csvUpload->email         = ($email !== '') ? $email : null;
        $csvUpload->day_guest     = ($dayGuest !== '') ? $dayGuest : null;
        $csvUpload->night_guest   = ($nightGuest !== '') ? $nightGuest : null;
        $csvUpload->rsvp_day      = ($rsvpDay !== '') ? $rsvpDay : null;
        $csvUpload->rsvp_night    = ($rsvpNight !== '') ? $rsvpNight : null;
        $csvUpload->wedding_venue = ($weddingVenue !== '') ? $weddingVenue : null;

        // validate update
        $csvUpload->validate();

        // save 
        $csvUploadContainer->uploads()->save($csvUpload);
      }

      if($numUploaded > 0) {
        $response = array(
          'success'   => true,
          'message'   => 'Upload started',
          'id'        => $csvUploadContainer->id
        );
      }

      return response()->json($response);
    }
}
