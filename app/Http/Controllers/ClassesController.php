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
        //task 7,8
        $data = $request->validate([
             'classname' => 'required|string',
             'capacity' => 'required|numeric|min:2',
             'price'=> 'required|decimal:1',
             'timefrom' => 'required|date_format:H:i', 
             'timeto' => 'required|date_format:H:i|after:timefrom',
             'image'=>'required|mimes:png,jpg,jpeg|max:2048',
            
        ]);
          $file_extension = $request->image->getClientOriginalExtension();
          $file_name = time() . '.' . $file_extension;
          $path = 'assets/images';
          $request->image->move($path, $file_name);
          //store imagename in db
          $data['image']= $file_name;

        $data['isfilled'] = isset($request->isfilled);
        //dd($data);
        Class1 ::create($data);
        return redirect()->route('classes.index');

        //task5
        // $data =[
        //     'classname'=>$request->classname,
        //     'capacity'=>$request->capacity,
        //     'price'=>$request->price,
        //     'isfilled' =>isset($request->isfilled),
        //     'timefrom' =>$request->timefrom, 
        //     'timeto' =>$request->timeto,
        // ];
        //  Class1 ::create($data);
        //  return redirect()->route('classes.index');
          

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
       // dd($class);
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
        //task 8
        $data = $request->validate([
            'classname' => 'required|string',
            'capacity' => 'required|numeric|min:2',
            'price'=> 'required|decimal:1',
            'timefrom' => 'required|date_format:H:i:s', 
            'timeto' => 'required|date_format:H:i:s|after:timefrom',

       ]);
       
       $data['isfilled'] = isset($request->isfilled);
      // dd($data);
       Class1::where('id',$id)->update($data);
       return redirect()->route('classes.index');

      //task 7
    //     $data =[
    //         'classname'=>$request->classname,
    //         'capacity'=>$request->capacity,
    //         'price'=>$request->price,
    //         'isfilled' =>isset($request->isfilled),
    //         'timefrom' =>$request->timefrom, 
    //         'timeto' =>$request->timeto,
    //     ];

    //   class1::where('id',$id)->update($data);
    //   return redirect()->route('classes.index');
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
    public function restore(string $id)
    {
        Class1::where('id',$id)->restore();
        return redirect()->route('classes.index');
    }
    public function forceDelete(string $id)
    {
        Class1::where('id',$id)->forceDelete();
        return redirect()->route('classes.index');
    }

    public function uploadForm(){
        return view('formclass');
    }

    public function upload(Request $request){

    $file_extension = $request->image->getClientOriginalExtension();
    $file_name = time() . '.' . $file_extension;
    $path = 'assets/images';
    $request->image->move($path, $file_name);
    return 'Uploaded';
    }
    
}
