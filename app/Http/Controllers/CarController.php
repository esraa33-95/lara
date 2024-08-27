<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Car;
use App\Models\Category;
use App\Traits\Common;


class CarController extends Controller
{
    use Common;   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dd(session('test'));
       $cars = car::with('Category')->get();
      
       return view('cars',compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        session()->put('test','hi lara');
        $categries = Category::select('id','category_name')->get();
        return view('add_car', compact('categries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //image valide
        $data = $request->validate([
            'cartitle'=> 'required|string',
            'description'=>'required|string',
            'price'=>'required|decimal:1',
            'published'=>'boolean',
            'image' =>'required|mimes:png,jpg,jpeg|max:2048',
            'category_id'=>'required|integer|exists:categories,id',
            
          ]);

          if($request->hasFile('image')){

          $data['image'] = $this->uploadFile($request->image,'assets/images/cars');

          }   
           Car::create($data);     
           return redirect()->route('cars1.index');

      
        // $data = $request->validate([
        //     'cartitle'=> 'required|string',
        //     'description'=> 'required|string',
        //     'price'=> 'required|decimal:1',
            
        // ]);
       
       
        // $data['published'] = isset($request->published);
        //dd($data);
        // car::create($data);
        // return redirect()->route('cars1.index');


    //     $data =[
    //         'cartitle' => $request->title,
    //         'description' => $request->description,
    //         'price' => $request->price,
    //         'published' => isset($request->published),
    //     ];
    //   car::create($data);
           
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Car::with('category')->findOrFail($id);
        return view('cars_details',compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      //task11
       $car = car::findorfail($id);
       $categories = Category::select('id','category_name')->get();
        return view('edit_car',compact('car','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {

        //task11
        $data = $request->validate([
            'cartitle'=> 'required|string',
            'description'=>'required|string',
            'price'=> 'required|numeric',
            'published'=>'boolean',
            'image' => 'sometimes|mimes:png,jpg,jpeg|max:2048',  
            'category_id'=>'required|integer|exists:categories,id',
            
        ]);

        if($request->hasFile('image')){

            $data['image'] = $this->uploadFile($request->image,'assets/images/cars');
            }
        
        //dd($data);
        Car::where('id',$id)->update($data);
        return redirect()->route('cars1.index');


        // $data =[
        //     'cartitle' => $request->title,
        //     'description' => $request->description,
        //     'price' => $request->price,
        //     'published' => isset($request->published),
        // ];
        // car::where('id',$id)->update($data);
        
        // return redirect()->route('cars1.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Car::where('id', $id)->delete();    
        return redirect()->route('cars1.index');
  
    }

   public function showDeleted(){

    $cars = car::onlyTrashed()->get();
    return view('trashedcars',compact('cars'));
   }

   public function restore(string $id){

    car::where('id',$id)->restore();
    return redirect()->route('cars1.showDeleted');
   }

   public function forceDelete(string $id)
   {
       
       Car::where('id', $id)->forceDelete();    
       return redirect()->route('cars1.index');
 
   }
   public function uploadForm(){
    return view('form1');
   }

   public function upload(Request $request){
    $file_extension = $request->image->getClientOriginalExtension();
    $file_name = time() . '.' . $file_extension;
    $path = 'assets/images';
    $request->image->move($path, $file_name);
    return 'Uploaded';
}

}
