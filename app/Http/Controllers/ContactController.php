<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;


class ContactController extends Controller
{
    public function index(){
        return view('contactus');
    }
    public function send(Request $request){

        $data = $request->validate([

            'name'=>'required|string|max:100',
            'email'=>'required|string|max:50',
            'subject'=>'required|string|max:50',
            'message'=>'required|string|max:255',
        ]);
     Mail::to('esraahedia39@gmail.com')->send(new ContactUs($data));
    }
}
