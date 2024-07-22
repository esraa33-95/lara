<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\class1;

 
class ClassesController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = class1::get();
      return view('classes',compact('classes'));
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
        //task5
        $data =[
            'classname'=>$request->classname,
            'capacity'=>$request->capacity,
            'price'=>$request->price,
            'isfilled' =>isset($request->isfilled),
            // 'isfilled' =>($request->isfilled === 'on' )? 1 : 0,
            'timefrom' => date($request->timefrom, time()), 
            'timeto' => date($request->timeto, time()),
        ];
         Class1 ::create($data);
         
          

        //  $classname    ='swimming';
        //  $capacity     = 40;
        //  $price        = 400;
        //  $isfilled     = true;
        //  $timefrom = '1:20:30';
        //  $timeto = '3:30:06';
        // //  $timefrom = date('H:i:s', strtotime('10:02:03'));
        // //  $timeto = date('H:i:s', strtotime('12:50:05'));
        //  Class1::create([
        //      'classname'=> $classname,
        //      'capacity' => $capacity,
        //      'price'    => $price,
        //      'isfilled' => $isfilled,
        //      'timefrom' => $timefrom,
        //      'timeto'    => $timeto,
            
        //  ]);
        
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
        $class = class1::findorfail($id);
        return view('edit_class',compact('class'));
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
