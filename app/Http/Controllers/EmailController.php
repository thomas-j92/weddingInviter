<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Load models
use App\EmailAttachment;

class EmailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewAttachment($id)
    {
        $attachment = EmailAttachment::find($id);



        return Storage::disk('local')->download($attachment->file_path);

        dd($attachment);
    }
}
