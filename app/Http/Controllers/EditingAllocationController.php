<?php

namespace App\Http\Controllers;

use App\Models\EditingAllocation as ModelsCatalogAllocation;
use App\Models\EditingAllocation;
use App\Models\EditingWrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class EditingAllocationController extends Controller
{
    function index()
    {
        $allocation_type = 1;
        $wrcList = EditingAllocation::get_wrc_list_for_allocation($allocation_type);
        return view('Allocation.Editing_allocation')->with('wrcList', $wrcList)->with('allocation_type', $allocation_type);
    }

    function Editing_Re_Allocation()
    {
        $allocation_type = 2;
        $wrcList = EditingAllocation::get_wrc_list_for_allocation($allocation_type);
        return view('Allocation.Editing_allocation')->with('wrcList', $wrcList)->with('allocation_type', $allocation_type);
    }


    function Editing_alocated_sku_count(Request $request)
    {
        // dd($request->all());
        $wrc_id = $request->wrc_id;
        $batch_no = $request->batch_no;
        $data = ModelsCatalogAllocation::where('wrc_id', $wrc_id)->where('batch_no', $batch_no)->select(
                'wrc_id',
                DB::raw('SUM(CASE  	WHEN user_role = 0 THEN allocated_qty else 0 END)  as cataloger_sum'),
                DB::raw('SUM(CASE  	WHEN user_role = 1 THEN allocated_qty else 0 END)  as cp_sum'),
            )->get()->toArray();

        $cnt_rec = COUNT($data);
        if (
            $cnt_rec > 0
        ) {
            echo json_encode($data);
        } else {
            echo 0;
        }
    }

    // save Editing Allocation users 
    function save(Request $request){
        $res = EditingAllocation::saveEditingAllocation($request);
        $check_create = json_decode(json_encode($res, true));
        /* send notification start */
        if($check_create->user == 1){
            $allocated_qty = $request->editor_Qty;
            // $max_batch_no = Editor::where('wrc_id', $wrc_id)->max('batch_no');
            $wrc_data = EditingWrc::where('id',$request->wrc_id)->first(['wrc_number']);
            $wrc_number = $wrc_data != null ? $wrc_data->wrc_number : "";
    
            $data = new stdClass();
            $data->wrc_number = $wrc_number;
            $data->allocated_count = $allocated_qty;
            $data->allocate_editor_id = $request->user_id;
            $creation_type = 'WrcAllocationEditor';
            $this->send_notification($data, $creation_type);
        }
        /******  send notification end*******/
        echo json_encode($res, true);
    }

    // Wrc allocated usrs and wrc Details
    function Editing_Allocation_Details(Request $request)
    {
        // Allocated Editors list
        $editing_allocated_Editors_list = EditingAllocation::editing_allocated_Editors_list();

        //Lot wise Editing allocated user and Wrc List
        $editing_allocation_List_by_lot_numbers = EditingAllocation::editing_allocation_List_by_lot_numbers();

        return view('Allocation.editing_allocation_detail')->with('editing_allocation_List_by_lot_numbers', $editing_allocation_List_by_lot_numbers)->with('editing_allocated_Editors_list', $editing_allocated_Editors_list);
    }
    

    
}
