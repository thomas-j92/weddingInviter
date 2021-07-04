<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Load Models
use App\SaveTheDate;
use App\Invite;

class TestController extends Controller
{	
    public function __construct(){
        $this->middleware('auth');
    }

    public function stdPreview($id) {

        $saveTheDate = SaveTheDate::find($id);
        $saveTheDate->generatePdf(false, true);

    }

    public function inviteGenerate($id) {

        $invite = Invite::find($id);
        $invite->generatePdf(false, true);

    }

    public function inviteReceipt($id) {

        $invite = Invite::find($id);
        $invite->sendReceipt();

    }
}
