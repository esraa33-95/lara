<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class xcontroller extends Controller
{
    public function my_data(Request $request){
        $name      =$request->input('name');
        $email     =$request->input('email');
        $message   =$request->input('msg');
        $subject   =$request->input('subject');
    
    return 'name : '.$name .' <br>'.'email: '.$email .'<br>'.'subject : '.$subject .'<br>'.'message: '.$message;
    }
}
