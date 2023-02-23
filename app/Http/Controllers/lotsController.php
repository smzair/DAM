<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Brands;
use App\Models\Lots;
use App\Models\LotsStatus;
use App\Models\WrcStatus;
use App\Models\Skus;
use Illuminate\Support\Facades\DB;
use stdClass;

class lotsController extends Controller
{ 
 public function getarray(){ 
 return genderList();
 }

 public function createlots(Request $request, $id = 0){
  $brands = Brands::latest()->get();
  $lotInfo = '';
  if($id != 0){
    $lotInfo = Lots::getlotInfo(['lot_id' => $id, 'single' => true]);
    $companyListHtml =  $this->companyListHtml($lotInfo->brand_id, $lotInfo->user_id);
    $lotServicesListHtml = $this->lotServicesListHtml($lotInfo->s_type);
    $skus = Skus::where('lot_id' ,'=' ,$id)->get();
    $sku = count($skus);
  }else{
    $companyListHtml = $this->companyListHtml(0, 0);
    $lotServicesListHtml = $this->lotServicesListHtml(0);
    $skus=0;
    $sku = 0;
  }
  
  $sr=1 ;
  return view('Lots.create',compact('id', 'brands', 'lotInfo', 'companyListHtml', 'lotServicesListHtml','sku','skus','sr'));
}

private function companyListHtml($brandId, $selectedUserId){
  $users = User::getUserInfo(['brand_id' => $brandId]);
  return view('Lots.company-list-html',compact('users', 'selectedUserId'));
}

private function lotServicesListHtml($selectedService){
  $serviceList = getLotServiceList();
  return view('Lots.lot-service',compact('serviceList', 'selectedService'));
}

public function getusers(Request $request){
  $brandId = $request->brand_id;
  $companyListHtml =  $this->companyListHtml($brandId, '');
  return $companyListHtml;
  
}

public function getServices(Request $request){
  $serviceListHtml =  $this->lotServicesListHtml(0);
  return $serviceListHtml;
  
}

public function view(){

 $lots= Lots::getlotInfo($filter = []);
 
 
 return view('Lots.Index',compact('lots'));
 
}


public function getskus(Request $request){

$id= 91;

pr($skus,1);
}

public function edit($id){

  $lotsdata = Lots::find($id);
  $brand = Brands::latest()->get();
  return view('Lots.update',['lotsdata'=>$lotsdata],['brand'=>$brand]);
}

public function store(Request $request){
  $id = $request->id;
  if($id == 0){
    $data = new Lots();
  }else{
    $data = Lots::find(['id' => $id])->first();
  }

  $data->user_id=$request->user_id;
  $data->s_type=$request->s_type;
  $data->brand_id=$request->brand_id;
  $data->location=$request->Location; 
  $data->verticleType=$request->verticalType;  
  $data->clientBucket=$request->clientBucket;  
  $data->shoothandoverDate=$request->shoothandoverDate;  
  $data->save();

  $id = $data->id;
  $lotId = 'ODN' . date('dmY') ."-". $request->c_short . $request->short_name .
  $request->s_type . $id;
  $dataObj =  Lots::findOrFail($id);
  $dataObj->id = $id;
  $dataObj->lot_id = $lotId;


  $dataObj->save();

  $Lotstatus = new LotsStatus();
  $Lotstatus->lot_id = $id;
  $Lotstatus->status='Inwarding';
  $Lotstatus->save();

  /* send notification start */
  $brand_data = DB::table('brands')->where('id', $request->brand_id)->first(['name']);
  $brand_name =  $brand_data != null ?  $brand_data->name : "";
  $creation_type = 'LotShoot';

  $data = new stdClass();
  $data->lot_number = strtoupper($lotId);
  $data->brand_name = $brand_name;
  $this->send_notification($data, $creation_type);
/******  send notification end*******/

  return redirect('createlots/' . $id)->with('success'," Welcome The New Lot Generated is  " .$lotId );

}


}



