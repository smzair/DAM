<?php

namespace App\Http\Controllers;

use App\Models\CatalogAllocation;
use App\Models\CatalogTimeHash;
use App\Models\CatalogUploadedMarketplaceCount;
use App\Models\CatalogUploadLinks;
use App\Models\CatalogWrcBatch;
use App\Models\CatlogWrc;
use App\Models\NotificationModel\ClientNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class CatalogAllocationController extends Controller
{
    // List of catalog for allocate it to users
    function index()
    {
        $wrcList = CatlogWrc::getcatalog_allocation_list();
        return view('Allocation.catalog_allocation')->with('wrcList', $wrcList);
    }

    function catalog_re_allocation()
    {
        $wrcList = CatlogWrc::getcatalog_allocation_list();
        return view('Allocation.catalog_re_allocation')->with('wrcList', $wrcList);
    }

    // function for allocate wrc to user (save) batch_no
    function save(Request $request){
        // dd($request->all());
        $user_id = $request->user_id;
        $Cataloguer_Qty = $request->Cataloguer_Qty;
        $copywriter_id = $request->copywriter_id;
        $copywriter_Qty = $request->copywriter_Qty;
        $wrc_id = $request->wrc_id;
        $batch_no = $request->batch_no;
        $wrc_batch_id_is = $request->wrc_batch_id_is;
        $work_initiate_date_is = $request->work_initiate_date_is;
        $work_committed_date_is = $request->work_committed_date_is;
        $allocation_type = $request->allocation_type;

        $res = [];

        // SELECT `id`, `wrc_id`, `user_id`, `user_role`, `allocated_qty`, `created_at`, `updated_at` FROM `catalog_allocation` WHERE 1

        DB::beginTransaction();
        $wrc_data_is = CatlogWrc::where('catalog_wrc_batches.wrc_id', $wrc_id)->where('catalog_wrc_batches.batch_no', $batch_no)->
        leftJoin('catalog_wrc_batches', 'catalog_wrc_batches.wrc_id', 'catlog_wrc.id')->
        leftJoin(
        'catalog_allocation',
        function ($join) {
            $join->on('catalog_allocation.wrc_id', '=', 'catalog_wrc_batches.wrc_id');
            $join->on('catalog_allocation.batch_no', '=', 'catalog_wrc_batches.batch_no');
        })->
        leftJoin('lots_catalog', 'lots_catalog.id', 'catlog_wrc.lot_id')->
        select(
            'catlog_wrc.wrc_number',
            'catlog_wrc.alloacte_to_copy_writer',
            'lots_catalog.user_id',
            'lots_catalog.brand_id',
            'catalog_wrc_batches.wrc_id',
            'catalog_wrc_batches.batch_no',
            'catalog_wrc_batches.sku_count',
            DB::raw('SUM(CASE WHEN user_role = 0 THEN allocated_qty else 0 END)  as cataloger_sum'),
            DB::raw('SUM(CASE WHEN user_role = 1 THEN allocated_qty else 0 END)  as cp_sum')
        )->get()->first()->toArray();


        $res['user'] = '0';
        $res['copywriter'] = '0';
        if($user_id > 0) {
            $CatalogAllocation_list = CatalogAllocation::where([
                ['user_id',  $user_id],
                ['wrc_id',  $wrc_id],
                ['batch_no',  $batch_no],
            ])->get()->toArray();
            $all_cnt = count($CatalogAllocation_list);
            if ($all_cnt > 0) {
                $res[ 'user'] = '3';
                $catalog_allocation_user = CatalogAllocation::where([
                    ['user_id',  $user_id],
                    ['wrc_id',  $wrc_id],
                    ['batch_no',  $batch_no],
                ])->first();
            } else {
                $catalog_allocation_user = new CatalogAllocation();
                $catalog_allocation_user->user_id = $user_id;
                $catalog_allocation_user->wrc_id = $wrc_id;
                $catalog_allocation_user->batch_no = $batch_no;
                $catalog_allocation_user->allocated_qty = $Cataloguer_Qty;
                $catalog_allocation_user->user_role = 0;
                $status = $catalog_allocation_user->save();
                if ($status) {
                    $res['user'] = '1';
                } else {
                    $res['user'] = '2';
                }
            }
        }

        if($copywriter_id > 0) {
            $CatalogAllocation_list = CatalogAllocation::where([
                ['user_id',  $copywriter_id],
                ['wrc_id',  $wrc_id],
                ['batch_no',  $batch_no],
            ])->get()->toArray();

            $all_cnt = count($CatalogAllocation_list);
            if ($all_cnt > 0) {
                $res['copywriter'] = '3';
            } else {
                $catalog_allocation = new CatalogAllocation();
                $catalog_allocation->user_id = $copywriter_id;
                $catalog_allocation->wrc_id = $wrc_id;
                $catalog_allocation->batch_no = $batch_no;
                $catalog_allocation->allocated_qty = $copywriter_Qty;
                $catalog_allocation->user_role = 1;
                $status = $catalog_allocation->save();
                if ($status) {
                    $res['copywriter'] = '1';
                } else {
                    $res['copywriter'] = '2';
                }
            }
        }
        $updateData = CatalogWrcBatch::find($wrc_batch_id_is);

        if ($allocation_type == 1 || $updateData->work_initiate_date == null || $updateData->work_initiate_date == '0000-00-00') {
            $updateData->work_initiate_date = $work_initiate_date_is != null ? $work_initiate_date_is : $updateData->work_initiate_date;
        }
        if($allocation_type == 1 || $updateData->work_initiate_date == null || $updateData->work_initiate_date == '0000-00-00'){
            $updateData->work_committed_date = $work_committed_date_is != null ? $work_committed_date_is : $updateData->work_committed_date;
        }
        $update_status = $updateData->update();
        $res['update_status'] = $update_status;
        if($update_status){
            /* send notification start */
            if($user_id > 0) {
                $catlog_allocation_data = CatalogAllocation::where('id',$catalog_allocation_user->id)->first(['wrc_id','user_id']);
                $wrc_id = $catlog_allocation_data != null ? $catlog_allocation_data->wrc_id : 0;
                $user_id = $catlog_allocation_data != null ? $catlog_allocation_data->user_id : 0;
                $allocated_qty = CatalogAllocation::where('wrc_id',$wrc_id)->where('user_id',$user_id)->sum('allocated_qty');
            }
            // $max_batch_no = CatalogAllocation::where('wrc_id', $wrc_id)->max('batch_no');

            $wrc_data = CatlogWrc::where('id',$wrc_id)->first(['wrc_number']);
            $wrc_number = $wrc_data != null ? $wrc_data->wrc_number : "";

            $cataloger_sum = $wrc_data_is['cataloger_sum'] + $Cataloguer_Qty;
            $cp_sum = $wrc_data_is['cp_sum'] + $copywriter_Qty;
            $sku_count = $wrc_data_is['sku_count'];

            if(($wrc_data_is['alloacte_to_copy_writer'] == 1 && $cataloger_sum == $sku_count && $sku_count == $cp_sum && $res['user'] == 1) || ($wrc_data_is['alloacte_to_copy_writer'] == 0 && $cataloger_sum == $sku_count && $res['user'] == 1 )){
                $batch_is = $wrc_data_is['batch_no'] > 0 ? " Batch No. is ".$wrc_data_is['batch_no'] : "" ;

                $save_ClientNotification_data = array(
                    'user_id' => $wrc_data_is['user_id'],
                    'brand_id' => $wrc_data_is['brand_id'],
                    'wrc_number' => $wrc_data_is['wrc_number'].$batch_is,
                    'service' => 'Cataloging',
                    'subject' => 'Planning',
                );
                $save_status = ClientNotification::save_ClientNotification($save_ClientNotification_data);
            }
            DB::commit();
            if($user_id > 0) {
                $data = new stdClass();
                $data->batch_no = $batch_no;
                $data->wrc_number = $wrc_number;
                $data->allocated_count = $allocated_qty;
                $data->catlogure_user_data = $request->user_id;
                $data->cw_user_data = $request->copywriter_id;
                $creation_type = 'WrcAllocationCatlog';
                $this->send_notification($data, $creation_type);
            }
            /******  send notification end*******/ 
        }
        // echo "user_id => $user_id , Cataloguer_Qty => $Cataloguer_Qty , copywriter_id => $copywriter_id, copywriter_Qty => $copywriter_Qty , wrc_id => $wrc_id";
        echo json_encode($res,true);
        // echo json_encode(array('data' => $res),true);
    }


    function alocated_sku_count(Request $request)
    {
        // dd($request->all());
        $wrc_id = $request->wrc_id;
        $batch_no = $request->batch_no;
        $data = CatalogAllocation::
        where('wrc_id', $wrc_id)->where('batch_no', $batch_no)->
        select(
            'wrc_id',
            DB::raw('SUM(CASE  	WHEN user_role = 0 THEN allocated_qty else 0 END)  as cataloger_sum'),
            DB::raw('SUM(CASE  	WHEN user_role = 1 THEN allocated_qty else 0 END)  as cp_sum')
        )->get()->toArray();

        $cnt_rec = COUNT($data);
        if ($cnt_rec > 0
        ) {
            echo json_encode($data);
        } else {
            echo 0;
        }
    }

    // list/details of allocated users and wrc.
    function details(){

        $catalog_allocated_users_list = CatalogAllocation::catalog_allocated_users_list();
        $catalog_allocation_List_by_lot_numbers = CatalogAllocation::catalog_allocation_List_by_lot_numbers();
        // $allocationList = CatalogAllocation::catalog_allocationList();
        return view('Allocation.catalog_allocation_detail')
        // ->with('allocationList', $allocationList)
            ->with('catalog_allocation_List_by_lot_numbers', $catalog_allocation_List_by_lot_numbers)
        ->with('catalog_allocated_users_list', $catalog_allocated_users_list)
        ;
    }

   
    // show catalog allocation upload blade
    function upload()
    {
        
        $login_user_id_is = Auth::id(); // 26 sahil 29 Prerit 34 Rajesh
        $user_role = 'CW';
        $login_user_id_is = 386; // neetu 7 , ZAIRRQW 8 , 22 SDGB 
        //$login_user_id_is = 7; // neetu 7 , ZAIRRQW 8 , 22 SDGB 
        $user_role = 'Cataloguer';
        
        $allocated_wrc_list_by_user = CatalogAllocation::allocated_wrc_list_by_user($login_user_id_is);

        $allocationList = CatalogAllocation::getcatalog_allocation_list($login_user_id_is);
        
        return view('Allocation.upload_catalog_panel')->with('allocationList', $allocationList)->with('allocated_wrc_list_by_user', $allocated_wrc_list_by_user)->with('user_role', $user_role)->with('login_user_id_is', $login_user_id_is);
    }

    // set_tast_start
    function set_task_start(Request $request){
        $allocation_id = $request->allocation_id;
        $login_user_id_is = $request->login_user_id_is;

        $start_time = date('Y-m-d H:i:s');
        $status = CatalogTimeHash::set_task_start($allocation_id , $start_time , $login_user_id_is);
        
        // dd($login_user_id_is);
        $response = array(
            'status' => $status ,
            'start_time'=> date('Y-m-d h:i:s A',strtotime($start_time))
        );
        echo json_encode($response);
    }

    // set_tast_pause
    function set_task_pause(Request $request)
    {
        $allocation_id = $request->allocation_id;
        $time = date('Y-m-d H:i:s');
        $response = CatalogTimeHash::set_task_pause($allocation_id, $time);
        echo $response;
    }


    // get catalog uploaded link 

    function get_catalog_link(Request $request){
        $allocation_id = $request->allocation_id;
        $response = CatalogUploadLinks::get_catalog_uploaded_link($allocation_id);
        if($response == 0){
            echo $response;
        }
        else{
            echo json_encode($response);
        }
    }


    // upload_catalog_link 
    function upload_catalog_link(Request $request){

        $allocation_id_is = $request->allocation_id_is;
        $catalog_link = $request->catalog_link;
        $copy_link = $request->copy_link;
        $final_link = $request->final_link;
        $action = $request->action;

        $status = CatalogUploadLinks::upload_catalog_link($allocation_id_is, $final_link , $catalog_link, $copy_link, $action );

        $end_time_is = '';
        $up_status = '';

        $storeData = CatalogTimeHash::where('allocation_id', $allocation_id_is)->get()->first();
        $old_spent_time = $storeData->spent_time;
        $is_started = $storeData->is_started;
        $old_spent_time = $old_spent_time == "" ? 0 : (int)$old_spent_time;


        // dd($storeData);
        $spent_time_is = ($old_spent_time != 0 && $old_spent_time != "") ? get_date_time($old_spent_time) : "";

        if ($status != 0 && $action == 'comp') {
            $old_start_time = $storeData->start_time;
            $end_time = date('Y-m-d H:i:s');

            
            
            $ini_start_time = $storeData->ini_start_time;
            $ini_end_time = $storeData->ini_end_time;

            if ($ini_start_time == '' || $ini_start_time == '0000-00-00 00:00:00') {
                $ini_start_time = $old_start_time;
            }

            if ($ini_end_time == '' || $ini_end_time == '0000-00-00 00:00:00') {
                $ini_end_time = $end_time;
            }

            // dd($storeData);
            
            // $new_spent_time = (new Carbon($end_time))->diff(new Carbon($old_start_time))->format('%Y-%m-%d %H:%I:%s');

            $new_spent_time = (new Carbon($end_time))->diffInSeconds(new Carbon($old_start_time));

            if ($is_started == 1) {
                $new_spent_time = 0;
            }
            $tot_spent = $old_spent_time + $new_spent_time;
            
            $up_status = CatalogTimeHash::where('allocation_id', $allocation_id_is)->update([
                'end_time' => $end_time,
                'ini_start_time' => $ini_start_time,
                'ini_end_time' => $ini_end_time,
                'spent_time' => $tot_spent,
                'task_status' => 1,
                'is_rework' => 0,
                'is_started' => 0,
            ]);
            if($up_status){
                $end_time_is = date('Y-m-d h:i:s A', strtotime($end_time));
                $spent_time_is = ($tot_spent != 0 && $tot_spent != "") ? get_date_time($tot_spent) : "";

            }

            /****** send notification start */
            $Catlog_allocation_data = CatalogAllocation::where('id',$allocation_id_is)->first(['wrc_id','user_id']);
            $wrc_id = $Catlog_allocation_data != null ? $Catlog_allocation_data->wrc_id : 0;
            $user_id = $Catlog_allocation_data != null ? $Catlog_allocation_data->user_id : 0;
            $allocated_qty = CatalogAllocation::where('wrc_id',$wrc_id)->where('user_id',$user_id)->sum('allocated_qty');
            $wrc_data = CatlogWrc::where('id',$wrc_id)->first(['wrc_number']);
            $wrc_number = $wrc_data != null ? $wrc_data->wrc_number : "";
            $max_batch_no = CatalogWrcBatch::where('wrc_id', $wrc_id)->max('batch_no');

            $user_id = Auth::id();
            // $user_id = Auth::user()->id;
            $logged_in_user_data = DB::table('users')->where('id', $user_id )->first(['name']);
            $uploaded_by_user_name = $logged_in_user_data != null ? $logged_in_user_data->name : " ";

            $data = new stdClass();
            $data->wrc_number = $wrc_number;
            $data->batch_no = $max_batch_no;
            $data->uploaded_by_user_name = $uploaded_by_user_name;
            $data->uploaded_detail = $final_link != null ? $final_link  : $copy_link;
            $creation_type = 'completeTaskInUploadCatlogFinalLink';
            $this->send_notification($data, $creation_type);
            /****** send notification end*******/
        }
        $response = array(
            'status' => $status,
            'up_status' => $up_status,
            'end_time' => $end_time_is,
            'spent_time_is' => $spent_time_is
        );
        echo json_encode($response);
    }
}
