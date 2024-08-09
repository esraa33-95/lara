<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Common;
use App\Models\Product;


class ProductsController extends Controller
{ 
    use Common;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::get();
         return view('products',compact('products'));
        //task9
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add_product');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'=>'required|string|min:2',
            'price'=>'required|numeric',
            'shortdescription'=>'required|string',
            'image'=>'required|mimes:png,jpg,jpeg|max:2048',

        ]);
        if($request->hasFile('image')){
            $data['image'] = $this->uploadFile($request->image,'assets/images');
            }
        product::create($data);
         return redirect()->route('products.index');
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
       $product = Product::findOrfail($id);
        return view('products_edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title'=>'required|string|min:2',
            'price'=>'required|numeric',
            'shortdescription'=>'required|string',
            'image'=>'sometimes|mimes:png,jpg,jpeg|max:2048',

        ]);
        if($request->hasFile('image')){
            $data['image'] = $this->uploadFile($request->image,'assets/images/products');
            }
        product::where('id',$id)->update($data);
         return redirect()->route('products.index');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
