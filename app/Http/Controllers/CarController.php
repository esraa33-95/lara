<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Car;
class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $cars = car::get();
       return view('cars',compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add_car');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data =[
            'cartitle' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'published' => isset($request->published),
        ];
      car::create($data);
        
       
      return redirect()->route('cars1.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = car::findOrfail($id);
        return view('cars_details',compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $car = car::findorfail($id);
        return view('edit_car',compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data =[
            'cartitle' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'published' => isset($request->published),
        ];
        car::where('id',$id)->update($data);
        
       
        return redirect()->route('cars1.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //  car::where('id',$id)->delete();
        //return 'data deleted successfully';

        $id = $request->id;
        Car::where('id', $id)->delete();    
        return redirect()->route('cars1.index');
  
    }
   public function showDeleted(){

    $cars = car::onlyTrashed()->get();
    return view('trashedcars',compact('cars'));
   }


}
