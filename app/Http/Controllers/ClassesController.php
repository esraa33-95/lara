<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Class1;
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

         $validatedData = $request->validate([
            'timefrom' => 'required|date_format:H:i',
            'timeto' => 'required|date_format:H:i',
        ]);
        $timefrom = $validatedData['timefrom'] ?? '10:30'; 
        $timeto = $validatedData['timeto'] ?? '2:30'; 
  
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
