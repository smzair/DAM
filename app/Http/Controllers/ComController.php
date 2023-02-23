<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Commercials;


class ComController extends Controller
{
   public function __construct(){
       
   }

   public function create()
   {
    $users = User::latest()->get();
    $typeOfShootList = getTypeOfShootList();
    $getProductList =  getProductList();
    $getAdaptationsList = getAdaptationsList();
    $id = 0;
    return view('commercial.create',compact('users', 'typeOfShootList','getProductList','getAdaptationsList','id'));

}

public function getbrand(Request $request){
  
    $brands = User::getUserInfo(['user_id' => $request->user_id]);
    $html = '<option value = "">Please Select</option>';

    foreach ($brands as $brand) {
        $html .= '<option value="'.$brand->brand_id.'" >'.$brand->brand_name. '</option>';
    }


    return response()->json(['html' => $html]);
    

}
public function editcom(Request $request){

    $id = $request->id;
    $users = User::latest()->get();
    $typeOfShootList = getTypeOfShootList();
    $getProductList =  getProductList();
    $getAdaptationsList = getAdaptationsList();
    $com= Commercials::getComInfo(['commercial' => $id , 'single' => true ]);
    $id = $com->id;
 return view('commercial.create',compact('users', 'typeOfShootList','getProductList','getAdaptationsList','com','id'));


}

public function saveCom(Request $request){
   
 $flat_shot = $request->flat_shot;
 $extra_mood_shot = $request->extra_mood_shot; 
 
    $com = new Commercials;
    $com->user_id = $request->user_id;
    $com->brand_id = $request->brand_id;
   
if($flat_shot != null){
    $com->flat_shot=$flat_shot;}
    $com->product_category = $request->product_category;
    $com->type_of_shoot = $request->type_of_shoot;
    $com->type_of_clothing=$request->type_of_clothing;
    $com->gender = $request->gender;
    $com->adaptation_1 = $request->adaptation_1;
    $com->adaptation_2= $request->adaptation_2;
    $com->adaptation_3 = $request->adaptation_3;
    $com->adaptation_4=$request->adaptation_4 ;
    $com->adaptation_5=$request->adaptation_5; 
    $com->commercial_value_per_sku=$request->commercial_value_per_sku;
    $com->save();
    $request->session()->put('message', 'Welcome The New Commercial has been Successfully saved');

}

public function dataeditCom(Request $request){

    $id= $request->user_id;
    $com = Commercials::find($id);
    $com->user_id = $request->user_id;
    $com->brand_id = $request->brand_id;
    $com->product_category = $request->product_category;
    $com->type_of_shoot = $request->type_of_shoot;
    $com->type_of_clothing=$request->type_of_clothing;
    $com->gender = $request->gender;
    $com->adaptation_1 = $request->adaptation_1;
    $com->adaptation_2= $request->adaptation_2;
    $com->adaptation_3 = $request->adaptation_3;
    $com->adaptation_4=$request->adaptation_4 ;
    $com->adaptation_5=$request->adaptation_5; 
    $com->commercial_value_per_sku=$request->commercial_value_per_sku;
    $com->update();

return "ok";
    $request->session()->put('message', 'Welcome The Commercial has been Updated successfully saved');
}

public function getCom(Request $request){
 
    $com= Commercials::getComInfo($filter = []);
   
    return view('commercial.view',compact('com'));

}
}
