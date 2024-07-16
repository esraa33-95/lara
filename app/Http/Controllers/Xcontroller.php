<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class XController extends Controller
{

    public function my_data(Request $request){
        $name      =$request['name'];
        $email     =$request['email'];
        $message   =$request['msg'];
        $subject   =$request['subject'];
    
    return 'name : '.$name .' <br>'.'email: '.$email .'<br>'.'subject : '.$subject .'<br>'.'message: '.$message;
    }
}
