<?php

namespace App\Http\Controllers;

use App\Models\CatalogAllocation;
use App\Models\CatalogTimeHash;
use App\Models\CatalogWrcBatch;
use App\Models\CatlaogQc;
use App\Models\CatlogWrc;
use Google\Service\DataCatalog\Resource\Catalog;
use Illuminate\Http\Request;
use stdClass;

class CatlaogQcController extends Controller
{
    /*** Display a listing of the resource. */
    public function index()
    {
        $get_catalog_allocated_wrc_list = CatlaogQc::get_catalog_allocated_wrc_list();
        return view('Qc.qc-catalog')->with('get_catalog_allocated_wrc_list', $get_catalog_allocated_wrc_list);
    }


    // userlist for qc

    public function userlist(Request $request){
        $wrc_id = $request->wrc_id;
        $batch_no = $request->batch_no;
        $role_id_is = $request->role_id_is;
        $get_userlist = CatlaogQc::get_userlist($wrc_id, $role_id_is , $batch_no);
        echo $get_userlist;
    }


    // set_qc_rework

    public function set_qc_rework(Request $request){
        $wrc_id = $request->wrc_id;
        $role_id_is = $request->role_id_is;
        $comments = $request->comments;
        $catalog_allocation_id = $request->catalog_allocation_id;  
        $status = CatlaogQc::set_qc_rework($wrc_id, $role_id_is, $catalog_allocation_id , $comments);
        echo $status;
    }


    public function completed_qc_wrc(Request $request){
        $wrc_id = $request->wrc_id;
        $allocation_ids = $request->allocation_ids;
        $market_place_id_arr = explode(',', $allocation_ids);
        $all_catalog_allocation = CatalogAllocation::where('wrc_id', $wrc_id)->
        whereIn('catalog_allocation.id', $market_place_id_arr)->
        leftJoin('catalog_time_hash', 'catalog_time_hash.allocation_id', 'catalog_allocation.id')
            ->select('catalog_time_hash.task_status', 'catalog_time_hash.allocation_id')
            ->get()->toArray();
        $check = 1;
        $response = 0;

        foreach ($all_catalog_allocation as $key => $val) {
            $check_task_status = $val['task_status'];
            if ($check_task_status != 1) {
                $check = 0;
            }
        }
        // dd($all_catalog_allocation , $check);
        if ($check == 1) {
            $res_arr = array();
            foreach ($all_catalog_allocation as $key => $val) {
                $allocation_id = $val['allocation_id'];
                $up_status = CatalogTimeHash::where('allocation_id', $allocation_id)->update(['task_status' => 2]);
                array_push($res_arr , $up_status);
            }
            /* send notification start */
            $wrc_data = CatlogWrc::where('id',$wrc_id)->first(['wrc_number']);
            $wrc_number = $wrc_data != null ? $wrc_data->wrc_number : "";
            $max_batch_no = CatalogWrcBatch::where('wrc_id', $wrc_id)->max('batch_no');
            $catlog_time_hash_data = CatalogTimeHash::where('allocation_id',$allocation_ids)->first(['task_status','is_rework']);
            $is_rework = $catlog_time_hash_data != null ? $catlog_time_hash_data->is_rework : "";
            $task_status = $catlog_time_hash_data != null ? $catlog_time_hash_data->task_status : "";
            $batch_no = "";
            $data = new stdClass();
            $data->batch_no = $batch_no;
            $data->wrc_number = $wrc_number;
            $data->batch_no = $max_batch_no == 0 ? 'None' : $max_batch_no;
            $data->qc_status = $is_rework == 1 ? 'Rework' : ( $task_status == 2 ? "Completed" : "Pending");
            $creation_type = 'QcCatlog';
            $this->send_notification($data, $creation_type);
            /******  send notification end*******/

            if(count($res_arr) == array_sum($res_arr) && array_sum($res_arr) ==  count($all_catalog_allocation)){
                $response = 1;
            }else{
                $response = 0;
            }
        }
        echo $response;
    }

    // set_wrc_qc_pending
    public function set_wrc_qc_pending(Request $request)
    {
        $wrc_id = $request->wrc_id;
        $allocation_ids = $request->allocation_ids;
        $market_place_id_arr = explode(',', $allocation_ids);
        $all_catalog_allocation = CatalogAllocation::where('wrc_id', $wrc_id)->whereIn('catalog_allocation.id', $market_place_id_arr)->leftJoin('catalog_time_hash', 'catalog_time_hash.allocation_id', 'catalog_allocation.id')
            ->select('catalog_time_hash.task_status', 'catalog_time_hash.allocation_id')
            ->get()->toArray();
        $check = 1;
        $response = 0;

        foreach ($all_catalog_allocation as $key => $val) {
            $check_task_status = $val['task_status'];
            if ($check_task_status != 2) {
                $check = 0;
            }
        }
        // dd($all_catalog_allocation , $check);
        if ($check == 1) {
            $res_arr = array();
            foreach ($all_catalog_allocation as $key => $val) {
                $allocation_id = $val['allocation_id'];
                $up_status = CatalogTimeHash::where('allocation_id', $allocation_id)->update(['task_status' => 1]);
                array_push($res_arr, $up_status);
            }

            if (count($res_arr) == array_sum($res_arr) && array_sum($res_arr) ==  count($all_catalog_allocation)
            ) {
                $response = 1;
            } else {
                $response = 0;
            }
        }
        echo $response;
    }

    /** * Show the form for creating a new resource. */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage. */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.*/
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.*/
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage. */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage. */
    public function destroy($id)
    {
        //
    }
}
