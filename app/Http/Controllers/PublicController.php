<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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
}
