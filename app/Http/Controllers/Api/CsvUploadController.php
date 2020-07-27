<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Load libaries
use App\CsvUploadContainer;
use App\CsvUpload;
use App\People;
use App\Invite;
use App\InviteGuests;

class CsvUploadController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $csvUpload = CsvUploadContainer::with(['uploads'])
                                       ->find($id);

        return response()->json($csvUpload);
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
        // update CsvUpload values
        $csvUpload                = CsvUpload::find($id);
        $csvUpload->first_name    = ($request['first_name'] !== '') ? $request['first_name'] : null;
        $csvUpload->last_name     = ($request['last_name'] !== '') ? $request['last_name'] : null;
        $csvUpload->email         = ($request['email'] !== '') ? $request['email'] : null;
        $csvUpload->day_guest     = ($request['day_guest'] !== '') ? $request['day_guest'] : null;
        $csvUpload->night_guest   = ($request['night_guest'] !== '') ? $request['night_guest'] : null;
        $csvUpload->rsvp_day      = ($request['rsvp_day'] !== '') ? $request['rsvp_day'] : null;
        $csvUpload->rsvp_night    = ($request['rsvp_night'] !== '') ? $request['rsvp_night'] : null;

        // store errors concerning CsvUpload
        $errors                   = $csvUpload->errors;

        if($errors['success']) {
            // update status
            $csvUpload->status = 'success';

            // create People from CsvUpload
            $person               = new People;
            $person->first_name   = $csvUpload->first_name;
            $person->last_name    = $csvUpload->last_name;
            $person->email        = $csvUpload->email;

            // ensure email isn't null or a duplicate
            // $checkEmail = People::where('email', $person->email);
            // if(!is_null($csvUpload->email) && $checkEmail->count() == 0) {
                // if day/night guest info provided, make Invite
                if($csvUpload->day_guest || $csvUpload->night_guest) {
                  $yesValues = array('1', 'true', 'yes');

                  // make invite 
                  $invite         = new Invite;
                  $invite->day    = (in_array($csvUpload->day_guest, $yesValues)) ? true : false;
                  $invite->night  = (in_array($csvUpload->night_guest, $yesValues)) ? true : false;

                  // assign Person to Invite
                  $inviteGuest                    = new InviteGuests;
                  $inviteGuest->rsvp              = ($csvUpload->rsvp_day || $csvUpload->rsvp_night) ? true : false;
                  $inviteGuest->attending_day     = (in_array($csvUpload->rsvp_day, $yesValues)) ? true : false;
                  $inviteGuest->attending_night   = (in_array($csvUpload->rsvp_night, $yesValues)) ? true : false;
                  $inviteGuest->invite()->associate($invite);
                  $inviteGuest->person()->associate($person);
                }

                // create Person
                $person->save();
            // }
          }

          // update csv values
          $csvUpload->save();

          // loop through container and check if all uploads are now successful
          $csvContainer             = $csvUpload->container;
          $csvContainerUploads      = $csvContainer->uploads;
          $isUploaded               = true;
          foreach($csvContainerUploads as $upload) {
              if($upload['status'] != 'success') {
                $isUploaded = false;
              }
          }
          // update CsvContainer status if all uploads have been uploaded successfully
          if($isUploaded){
            $csvContainer->status = 'success';
            $csvContainer->save();
          }

          // response
          return response()->json($errors);
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
     * Get all pending uploads.
     */
    public function getAll() {

        // get all CsvUploads
        $uploads = CsvUploadContainer::where('status', '!=', 'success')
                                     ->get();

        return response()->json($uploads);
        
    }
}
