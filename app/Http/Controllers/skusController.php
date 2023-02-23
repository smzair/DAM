<?php

namespace App\Http\Controllers;
use App\Models\Brands;
use App\Models\User;
use App\Models\Lots;
use App\Models\Wrc;
use App\Models\Skus;
use App\Models\skusStatus;

use Illuminate\Http\Request;

class skusController extends Controller
{
  public function index(){

$skus=Skus:: getskuInfo($filter = []) ;

   return view('Uploadsku.addviewsku',compact('skus'));

 }


 public function upload(){

  $brand = Brands::latest()->get(); 

  return view('Uploadsku.create',compact('brand'));
}
public function getCompany(Request $request, $id){

  $users = User::getUserInfo(['brand_id' => $id]);
  $html = '<option value = "">Select Company</option>';


  foreach ($users as $user) {
    $html .= '<option value="'.$user->id.'" >'.$user->Company.'</option>';
  }
  

  return response()->json(['html' => $html]);
}



public function getLot(Request $request){

  $user_id=$request->user_id;
  $brand_id=$request->brand_id;
  
  $lots=Lots::getlotinfo(['user_id' => $user_id ,'brand_id' => $brand_id]);

  $html = '<option value = "">Please Select</option>';

  foreach ($lots as $lot) {
    $html .= '<option value="'.$lot->id.'" >'.$lot->lot_id.'</option>';
  }
  return response()->json(['html' => $html]);
}



public function getwrc(Request $request){ 
  $lot_id=$request->lot_id;


  $wrcs  = Wrc::where(['lot_id' => $lot_id])->get();
  $html = '<option value = "">Please Select</option>';

  foreach ($wrcs as $wrc) {
    $html .= '<option value="'.$wrc->id.'" >'.$wrc->wrc_id.'</option>';
  }
  return response()->json(['html' => $html]);
}


    public function uploadsku(Request $request) {
        $lot_id = $request->lot_id;
        $lotInfo = Lots::getlotInfo(['lot_id' => $lot_id, 'single' => true]);
        $user_id = $lotInfo->user_id;
        $brand_id = $lotInfo->brand_id;
        $handle = fopen($_FILES['skusheet']['tmp_name'], "r");
        $header = true;
        while ($csvLine = fgetcsv($handle, 1000, ",")) {
            if ($header) {
                $header = false;
            } else {
                $skuExist = Skus::where('lot_id', '=', $request->lot_id)->where('sku_code', '=', $csvLine[0])->count();
                if ($skuExist == 0 && $csvLine[0]!="") {
                    $skuObj = [];
                    $skuObj = new Skus();
                    $skuObj->user_id = $user_id;
                    $skuObj->brand_id = $brand_id;
                    $skuObj->lot_id = $request->lot_id;
                    $skuObj->sku_code = $csvLine[0];
                    $skuObj->brand = $csvLine[1];
                    $skuObj->gender = $csvLine[2];
                    $skuObj->category = $csvLine[3];
                    $skuObj->type_of_clothing = $csvLine[4];
                    $skuObj->current_status = 'ready_for_inwardng';
                    $skuObj->save();

                    $skuId = $skuObj->id;
                    $statusEngine = new skusStatus();
                    $statusEngine->sku_id = $skuId;
                    $statusEngine->status = 'ready_for_inwardng';
                    $statusEngine->save();
                }
            }
        }
    }




}
