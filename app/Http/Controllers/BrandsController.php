<?php

namespace App\Http\Controllers;
use App\Models\Brands;

use Illuminate\Http\Request;

class BrandsController extends Controller


{
    public function index()
    {
        $brands=$this->brands::all();
        return view("brands.index",['brands' => $brands]);
    }
    public function create()
    {
      
        return view("brands.add");
 
    }

    public function delete($id)
    {

     $brand=Brands::findOrfail($id);
     $brand->delete();
     
     return redirect()->route('brands.index')->with('success','Brand Deleted Successfully');

    }

    public function users()
    {
    
    
       return $this->hasMany(User::Class);
    }
    

    public function store(Request $request){

        $brand = new Brands ();
        
        $brand->name = $request->name ;
        $brand->short_name=$request->short_name;
        $brand->save();
        return redirect('/savebrands')->with('success','Brand has Been Added');
    }
  
    public function getAll(){
        $brand=Brands::latest()->get();
       
        return view("brands.index",['brands'=> $brand]);
         return response() ->json([
          'brands' => $brand
        ], 200);
          }  

          public function All(){
            $brands=Brands::latest()->get();
             return response() ->json([
              'brands' => $brands
            ], 200);
              }  
}
