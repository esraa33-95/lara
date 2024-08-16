<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Student;
use App\Models\Phone;
class PublicController extends Controller
{
    //task10
    public function index()
    {
     $products = Product::latest()->take(3)->get();
        return view('index',compact('products'));
    }
    public function about(){
        return view('about');

    }    

       public function test(){

        //dd(Student::find(2)?->phone);
        //dd(Phone::find(5));

      dd( DB::table('students')
       ->join('phones', 'phones.id', '=', 'students.phone_id')
       ->where('students.id', '=', 1)
       ->first()
       );
   }
                    
}
