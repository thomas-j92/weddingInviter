<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Load Models
use App\SaveTheDate;

class TestController extends Controller
{	
    public function __construct(){
        $this->middleware('auth');
    }

    public function stdPreview($id) {

        $saveTheDate = SaveTheDate::find($id);
        $saveTheDate->generatePdf(false, true);

    }
}
