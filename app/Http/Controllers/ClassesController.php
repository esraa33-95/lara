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
            'timefrom' =>$request->timefrom, 
            'timeto' =>$request->timeto,
        ];
         Class1 ::create($data);
         return redirect()->route('classes.index');
          

        //  $classname    ='swimming';
        //  $capacity     = 40;
        //  $price        = 400;
        //  $isfilled     = true;
        //  $timefrom = '1:20:30';
        //  $timeto = '3:30:06';

        
        //  Class1::create([
        //      'classname'=> $classname,
        //      'capacity' => $capacity,
        //      'price'    => $price,
        //      'isfilled' => $isfilled,
        //      'timefrom' => $timefrom,
        //      'timeto'    => $timeto,
            
        //  ]);
        
         
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $class = class1::findOrfail($id);
        return view('classes_details',compact('class'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $class = class1::findOrfail($id);
        return view('edit_class',compact('class'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data =[
            'classname'=>$request->classname,
            'capacity'=>$request->capacity,
            'price'=>$request->price,
            'isfilled' =>isset($request->isfilled),
            // 'isfilled' =>($request->isfilled === 'on' )? 1 : 0,
            'timefrom' =>$request->timefrom, 
            'timeto' =>$request->timeto,
        ];

      class1::where('id',$id)->update($data);
      return redirect()->route('classes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        class1::where('id',$id)->delete();
        return redirect()->route('classes.index');
    }

    public function showDeleted(){
        $class = class1::onlyTrashed()->get();
      return view('trashedclass',compact('class'));
    }
}
