<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Class1;
 //use App\Http\controllers\time;
class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add_classes');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         //dd($request);
         $classname    ='swimming';
         $capacity     = 40;
         $price        = 400;
         $isfilled     = true;
         //format time
         $timefrom = date('H:i:s', strtotime('10:02:03'));
         $timeto = date('H:i:s', strtotime('12:50:05'));
         Class1::create([
             'classname'=> $classname,
             'capacity' => $capacity,
             'price'    => $price,
             'isfilled' => $isfilled,
             'timefrom' => $timefrom,
            'timeto'    => $timeto,
            
         ]);
        
         return 'data added successfully';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
