<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$products = Product::all();
        $sections = Section::all();
        $products = Product::all();
        return view('products.products' , [
            //'products' =>$products   , 
            'sections' => $sections , 
            'products' => $products , 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     //  return $request;
      $data = $request->all();
       $product = Product::create($data);
       return redirect()->route('product.list')
       ->with('success' , 'Product Success Added');
     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = Section::where('section_name', $request->section_name)->first()->id;

        $Products = Product::findOrFail($request->pro_id);
 
        
        
        $data = $request->except(['section_name']);
        $data['section_id'] = $id;
         
        
        $Products->update($data);
        

          
        /*
        $Products->update([
        'product_name' => $request->product_name,
        'description' => $request->description,
        'section_id' => $id,
        ]);
        */
        
       
          
        return redirect()->route('product.list')->
               with('success' , 'Product Are Updated');
          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
         $product = Product::findOrFail($request->pro_id);
        // return $request;
         
         $product->delete();
         return redirect()->route('product.list')->
         with('success' , 'Product Are Deleted');
         
    }
}
