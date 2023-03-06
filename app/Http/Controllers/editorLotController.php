<?php

namespace App\Http\Controllers;

use App\Models\EditorLotModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class editorLotController extends Controller
{
    // get data for create lot
    public function index()
    {
        return EditorLotModel::index();
    }

    // store lot data
    public function store(Request $request)
    {
        EditorLotModel::store($request);
        /* send notification start */
            $brand_data = DB::table('brands')->where('id', $request->brand_id)->first(['name']);
            $brand_name =  $brand_data != null ?  $brand_data->name : "";
            $creation_type = 'LotEditor';
            $lot_number_data = EditorLotModel::orderBY('id','DESC')->first(['lot_number']);
            $lot_number = $lot_number_data != null ? $lot_number_data->lot_number : "";
            $data = new stdClass();
            $data->lot_number = strtoupper($lot_number);
            $data->brand_name = $brand_name;
            $this->send_notification($data, $creation_type);
        /******  send notification end*******/
        return $this->index();
    }

    // lot listing data
    public function getEditorLotData()
    {
        return EditorLotModel::getEditorLotData();
    }

    // get lot data for edit
    public function edit(Request $request, $id)
    {
        return EditorLotModel::edit($request, $id);
    }

   // update lot
   public  function update(Request $request)
   {
       $id = $request->id;
       $EditorLots = EditorLotModel::find($id);
       $EditorLots->user_id = $request->user_id;
       $EditorLots->brand_id = $request->brand_id;
       $EditorLots->request_name = $request->request_name;
       $EditorLots->status = 'ready_for_inwarding';
       $EditorLots->update();

       $old_lot_number =  $EditorLots->lot_number;
       $old_lot_number_arr = explode("-", $old_lot_number);
       $id =  $EditorLots->id;
       $s_type =  $request->request_name;
       $request_name_array = explode(" ", $s_type);
       $count = count($request_name_array);
       $request_name = "";
       if($count>0){
           $request_name .= $request_name_array[0][0];
           $request_name .= $request_name_array[$count - 1][0];
       }

       // dd($old_lot_number_arr ,$request_name);
       $lot_number = $old_lot_number_arr[0]. "-" . $request->c_short . $request->short_name .  $request_name . $id;
       //update lot number

       EditorLotModel::where('id', $id)->update(['lot_number' => strtoupper($lot_number)]);
       if ($EditorLots) {
           request()->session()->flash('success', 'Lots Updated Successfully');
       } else {
           request()->session()->flash('error', 'Please try again!!');
       }
       return EditorLotModel::edit($request, $id);
   }
   
}
