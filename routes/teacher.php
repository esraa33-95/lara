<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', function () {
    return "welcome to teacher route ";
});

//testing with
// (http://127.0.0.1:8000/teacher)
