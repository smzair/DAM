<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\equipments;
use App\Models\planDate;
use Carbon\Carbon;
use App\Models\Dayplan;

class equipmentsController extends Controller
{
   public function index(){
    $list = equipments::get();   

     return view('equipments.panel',compact('list'));
   }

   public function save(Request $request){

    $data = new equipments();
    $data->equipment_name = $request->name;
    $data->opt_end_date = $request->opt_end_date;
    $data->opt_start_date = $request->opt_start_date;
    $data->vendor_name = $request->vendorname;
    $data->equipment_cost = $request->equipmentCost;
    $data->save();

    return  $request->session()->put('message', 'Equipments Info Saved Successfully');



   }
}
