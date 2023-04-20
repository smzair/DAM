<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\allocation;
use App\Models\CreativeTimeHash;
use App\Models\ClientActivityLog;
use App\Models\CreativeWrcModel;
use App\Models\CreatLots;
use App\Models\EditorLotModel;
use App\Models\editorSubmission;
use App\Models\Lots;
use App\Models\LotsCatalog;
use App\Models\Skus;
use App\Models\submissions;
use App\Models\uploadraw;
use App\Models\Wrc;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientDashboardController extends Controller
{
    //
    public static function index(){
        $resData = array();
        $resDataShoot =  array();
        $resDataCatlog = array();
        $resDataEditor = array();
        $user_detail = Auth::user();// logged in user detail
        $roledata = getUsersRole($user_detail['id']);
        $role = $roledata != null ? $roledata->role_name : '-';
        $client_id = $user_detail['id'];
        $parent_client_id = $user_detail['parent_client_id'];

        $role_name = "";
        $role_id = "";
        $brand_arr = [];

        if ($roledata != null) {
            $role_id = $roledata->role_id;
            $role_name = $roledata->role_name;
        }
        $brand_arr = DB::table('brands_user')->where('user_id', $client_id)->get()->pluck('brand_id')->toArray();
        $parent_client_id = $user_detail['parent_client_id'];
        // dd($parent_client_id);

        if($role == "Client" || $role == "Sub Client"){
            /* response data to get creative lot information with status start*/
            $resData =  CreatLots::orderBy('creative_lots.id','DESC')
                ->leftJoin('creative_wrc', 'creative_lots.id', 'creative_wrc.lot_id')
                ->leftJoin('users', 'users.id', 'creative_lots.user_id')
                ->leftJoin('brands', 'brands.id', 'creative_lots.brand_id')
                ->leftJoin('creative_allocation', 'creative_allocation.wrc_id','creative_wrc.id')
                ->leftJoin('create_commercial', 'create_commercial.id','creative_wrc.commercial_id')
                ->leftJoin('creative_wrc_batch', function($join){
                    $join->on('creative_wrc_batch.wrc_id', '=', 'creative_wrc.id');
                    // $join->on('creative_wrc_batch.batch_no', '=', 'creative_allocation.batch_no');
                    })
                    ->leftJoin('creative_submissions', function($join){
                        $join->on('creative_submissions.wrc_id', '=', 'creative_allocation.wrc_id');
                        $join->on('creative_submissions.batch_no', '=', 'creative_allocation.batch_no');
                    })
                    ->leftJoin('creative_time_hash', 'creative_time_hash.allocation_id', 'creative_allocation.id')
                ->select('creative_wrc.wrc_number','creative_wrc.qc_status','creative_lots.user_id','creative_lots.brand_id','creative_lots.lot_number','creative_lots.created_at','users.Company as Company_name','brands.name','creative_lots.client_bucket','create_commercial.project_name','create_commercial.kind_of_work','create_commercial.per_qty_value','creative_wrc_batch.work_initiate_date','creative_wrc_batch.work_committed_date','creative_submissions.submission_date','creative_submissions.status as submission_status','creative_allocation.wrc_id as submission_wrc_id','creative_allocation.id as allocation_id','creative_allocation.batch_no as submission_batch_no','creative_wrc_batch.work_initiate_date', 'creative_wrc_batch.work_committed_date','creative_lots.lot_delivery_days','creative_lots.id as lot_id','creative_wrc_batch.wrc_id as batch_wrc_id','creative_wrc_batch.batch_no','creative_time_hash.task_status')
                // ->groupBy('creative_wrc_batch.wrc_id')
                // ->groupBy('creative_wrc_batch.batch_no')
                ->where(function ($query) {
                    $query->where('creative_submissions.status', '!=', 1)
                    ->orWhere('creative_submissions.status', '=', null)
                    ->orWhere('creative_submissions.status', '=', 0);
                })
                ->whereIn('creative_lots.brand_id', $brand_arr)
                ->groupBy('creative_lots.id');
                if ($role_name == 'Sub Client') {
                    $resData =  $resData->where('creative_lots.user_id',$parent_client_id);
                }
                if ($role_name == 'Client') {
                    $resData =  $resData->where('creative_lots.user_id',$client_id);
                }

                    //->groupBy(['creative_wrc_batch.wrc_id','creative_wrc_batch.batch_no'])
                    $resData=  $resData->get();
            foreach($resData as $key => $val){
                
                $lot_status = "--";
                $lot_id = $val['lot_id'];

                $creative_wrc_count = DB::table('creative_wrc')->where('lot_id',$lot_id)->count();
                $lot_status = $creative_wrc_count > 0 ? 'Allocation Pending' : 'Inverd Pending';
                $val['lot_status']  = $lot_status;

                if($lot_status == 'Allocation Pending'){
                    $creative_allocation_count = DB::table('creative_allocation')->where('wrc_id',$val['batch_wrc_id'])->where('batch_no',$val['batch_no'])->count();
                    $lot_status = $creative_allocation_count > 0 ? 'Uploading Pending' : 'Allocation Pending';
                    $val['lot_status']  = $lot_status;
                }

                if($lot_status == 'Uploading Pending'){
                    if($val['qc_status'] == 0){
                        $lot_status = 'Qc Pending';
                        $val['lot_status']  = 'Qc Pending';
                    }
                }

                if($lot_status == 'Qc Pending'){
                    $submission_status = $val['submission_status'];

                    $lot_status = $submission_status  == 0 ? 'Submission Pending' : 'Submitted';
                    $val['lot_status']  = $lot_status;
                }
            }

            /* response data to get catlog lot information with status start*/
            $resDataCatlog = LotsCatalog::orderBy('lots_catalog.id','DESC')
            ->leftJoin('catlog_wrc', 'catlog_wrc.lot_id', 'lots_catalog.id')
            ->leftJoin('catalog_wrc_batches', function($join){
                $join->on('catalog_wrc_batches.wrc_id', '=', 'catlog_wrc.id');
                })
            ->select('lots_catalog.id as lot_id','lots_catalog.created_at', 'lots_catalog.lot_number','catalog_wrc_batches.wrc_id as batch_wrc_id')
            ->whereIn('lots_catalog.brand_id', $brand_arr)
            ->groupBy('lots_catalog.id');
            if ($role_name == 'Sub Client') {
                $resDataCatlog =  $resDataCatlog->where('lots_catalog.user_id',$parent_client_id);
            }
            if ($role_name == 'Client') {
                $resDataCatlog =  $resDataCatlog->where('lots_catalog.user_id',$client_id);
            }
             $resDataCatlog =  $resDataCatlog->get();

            foreach($resDataCatlog as $key => $val){
                // dd($val);
                $lot_status = "--";
                $lot_id = $val['lot_id'];
                $catlog_wrc_count = DB::table('catlog_wrc')->where('lot_id',$lot_id)->count();
                $lot_status = $catlog_wrc_count > 0 ? 'Allocation Pending' : 'Inverd Pending';
                $val['lot_status']  = $lot_status;

                if($lot_status == 'Allocation Pending'){
                    $catlog_allocation_count = DB::table('catalog_allocation')->where('wrc_id',$val['batch_wrc_id'])->count();
                    $lot_status = $catlog_allocation_count > 0 ? 'Uploading Pending' : 'Allocation Pending';
                    $val['lot_status']  = $lot_status;
                }

                $task_status = DB::table('catalog_allocation')->where('wrc_id',$val['batch_wrc_id'])
                    ->leftJoin('catalog_time_hash', 'catalog_time_hash.allocation_id', 'catalog_allocation.id')
                    ->where('catalog_time_hash.task_status', '=', '1')
                    ->select('catalog_time_hash.task_status')
                    ->get();

                if($lot_status == 'Uploading Pending'){

                    if(count($task_status) < 0 ){
                        $lot_status = 'Qc Pending';
                        $val['lot_status']  = 'Qc Pending';
                    }
                }

                $task_status_sum = DB::table('catalog_allocation')->where('wrc_id',$val['batch_wrc_id'])
                    ->leftJoin('catalog_time_hash', 'catalog_time_hash.allocation_id', 'catalog_allocation.id')
                    ->select(DB::raw('sum(catalog_time_hash.task_status) as task_status_sum'))
                    ->get();
                    

                if($lot_status == 'Qc Pending'){
                    // $submission_status = $val['submission_status'];

                    if((count($task_status) * 2) == $task_status_sum[0]->task_status_sum){
                        $lot_status = $submission_status  == 0 ? 'Submission Pending' : 'Submitted';
                        $val['lot_status']  = $lot_status;
                    }
                   
                }
            }

            /* response data to get editor lot information with status start*/
            $resDataEditor = EditorLotModel::orderBy('editor_lots.id','DESC')
            ->leftJoin('editing_wrcs', 'editing_wrcs.lot_id', 'editor_lots.id')
            ->select('editor_lots.id as lot_id', 'editor_lots.created_at','editor_lots.lot_number','editing_wrcs.id as wrc_id')
            ->whereIn('editor_lots.brand_id', $brand_arr)
            ->groupBy('editor_lots.id');
            if ($role_name == 'Sub Client') {
                $resDataEditor = $resDataEditor->where('editor_lots.user_id',$parent_client_id);
            }
            if ($role_name == 'Client') {
                $resDataEditor = $resDataEditor->where('editor_lots.user_id',$client_id);
            }

            $resDataEditor = $resDataEditor->get();

            foreach($resDataEditor as $key => $val){
                // dd($val);
                $lot_status = "--";
                $lot_id = $val['lot_id'];
                $editor_wrc_count = DB::table('editing_wrcs')->where('lot_id',$lot_id)->count();
                $lot_status = $editor_wrc_count > 0 ? 'Allocation Pending' : 'Inverd Pending';
                $val['lot_status']  = $lot_status;
                // dd($lot_status);
                if($lot_status == 'Allocation Pending'){
                    $catlog_allocation_count = DB::table('editing_allocations')->where('wrc_id',$val['wrc_id'])->count();
                    $lot_status = $catlog_allocation_count > 0 ? 'Uploading Pending' : 'Allocation Pending';
                    $val['lot_status']  = $lot_status;
                }

                if($lot_status == 'Uploading Pending'){

                    if(count($task_status) < 0 ){
                        $lot_status = 'Qc Pending';
                        $val['lot_status']  = 'Qc Pending';
                    }
                }

            }


            /* response data to get shoot lot information with status start*/
            $resDataShoot = Lots::orderBy('lots.id','DESC')
            ->select('lots.id as lot_id', 'lots.lot_id as lot_number','lots.created_at')
            ->whereIn('lots.brand_id', $brand_arr)
            ->groupBy('lots.id');
            if ($role_name == 'Sub Client') {
                $resDataShoot = $resDataShoot->where('lots.user_id',$parent_client_id);
            }
            if ($role_name == 'Client') {
                $resDataShoot = $resDataShoot->where('lots.user_id',$client_id);
            }

            $resDataShoot = $resDataShoot->get();

            foreach ($resDataShoot as $key => $val) {
                $lot_status = "--";
                $lot_id = $val['lot_id'];
                // dd($lot_id);
                $shoot_wrc_count = DB::table('wrc')->where('lot_id', $lot_id)->count();
            
                $lot_status = $shoot_wrc_count > 0 ? 'Inverd Done' : '';
                $val['lot_status'] = $lot_status;
            
                if ($lot_status == 'Inverd Done') {
                    $shoot_status = true;
                    $wrc_info = Wrc::where('lot_id', $lot_id)->get(['wrc_id', 'id']);
            
                    foreach ($wrc_info as $wkey => $wval) {
                        $sku_info = Skus::where('wrc_id', $wval['id'])->where('status', 1)->get(['id']);
                        $sku_count = $sku_info->count();
                        foreach ($sku_info as $skey => $sval) {
                            $upload_raw_info = uploadraw::where('sku_id', $sval['id'])->get(['id'])->count();
                            if ($upload_raw_info == 0) {
                                $shoot_status = false;
                                break 2;
                            }
                        }
                    }
                    if ($shoot_status) {
                        $lot_status = 'Shoot Done';
                        $val['lot_status'] = 'Shoot Done';
                    }
                }

                if ($lot_status == 'Shoot Done') {
                    $editing_and_qc_status = true;
                    $wrc_info = Wrc::where('lot_id', $lot_id)->get(['wrc_id', 'id']);
            
                    foreach ($wrc_info as $wkey => $wval) {
                        $sku_info = Skus::where('wrc_id', $wval['id'])->where('status', 1)->get(['id']);
                        $sku_count = $sku_info->count();
                        foreach ($sku_info as $skey => $sval) {
                            $editor_submission_info = editorSubmission::where('sku_id', $sval['id'])->get(['id','qc']);
                            $editor_submission_count = $editor_submission_info->count();
                            // dd($editor_submission_count);

                            if($editor_submission_count == 0){
                                $editing_and_qc_status = false;
                                break 2;
                            }
                            foreach($editor_submission_info as $ekey => $eval){
                                // dd($eval['qc']);
                                if(($eval['qc'] != "1") || ($eval['qc'] != 1)){
                                    $editing_and_qc_status = false;
                                    break 3;
                                }
                            }

                        }
                    }
                    if ($editing_and_qc_status) {
                        $lot_status = 'Editing/Qc Done';
                        $val['lot_status'] = 'Editing/Qc Done';
                    }
                }

                if($lot_status == 'Editing/Qc Done'){
                    $submission_status = true;
                    $wrc_info = Wrc::where('lot_id', $lot_id)->get(['wrc_id', 'id']);
            
                    foreach ($wrc_info as $wkey => $wval) {
                        $submission_info = submissions::where('wrc_id', $wval['id'])->get(['id']);
                        $submission_info_count = $submission_info->count();
                        
                        if ($submission_info_count == 0) {
                            $submission_status = false;
                            break 1;
                        }
                    }
                    if ($submission_status) {
                        $lot_status = 'Submission Done';
                        $val['lot_status'] = 'Submission Done';
                    }
                }

                if($lot_status == 'Submission Done'){
                    $invoice_status = true;
                    $wrc_info = Wrc::where('lot_id', $lot_id)->get(['wrc_id', 'id', 'Invoice_no']);
            
                    foreach ($wrc_info as $wkey => $wval) {
                        $Invoice_no = $wval['Invoice_no'];
                        if ($Invoice_no != null || $Invoice_no != '') {
                            $invoice_status = false;
                            break 1;
                        }
                    }
                    if ($invoice_status) {
                        $lot_status = 'Invoice Done';
                        $val['lot_status'] = 'Invoice Done';
                    }
                }
            }
            /* response data to get shoot lot information with status end*/


            
        }else{
            $resData = array();
            $resDataShoot = array();
            $resDataCatlog = array();
            $resDataEditor = array();
        }
		// return pre($resData);

        // insert into user activity log
        $data_array = array(
            'log_name' => 'Clients Lot Status', 
            'description' => ' Clients Lot Status',
            'event' => 'Clients Lot Status', 
            'subject_type' => 'App\Models\CreatLots', 
            'subject_id' => '0', 
            'properties' => [], 
        );
        // dd($resDataShoot);
        ClientActivityLog::saveClient_activity_logs($data_array);
        // return view('clients.ClientDashboard',compact('resData','resDataShoot', 'resDataCatlog', 'resDataEditor'));
        return view('clients.ClientDashboardDam',compact('resData','resDataShoot', 'resDataCatlog', 'resDataEditor'));
    }

    // clients creative time line detail
    public function clientsCreativelotTimeline(Request $request, $id){
        // LOT Generated details
        $user_detail = Auth::user();// logged in user detail
        $roledata = getUsersRole($user_detail['id']);
        $role = $roledata != null ? $roledata->role_name : '-';
        $client_id = $user_detail['id'];
        //  get lot info based on  $client_id (logged_in user)
        $lot_info_with_wrc = CreatLots::where('creative_lots.id',$id)->leftJoin('creative_wrc', 'creative_wrc.lot_id', 'creative_lots.id')->where('creative_lots.user_id', $client_id);

        // get data for lot generated details
        $lot_generated_detail = $lot_info_with_wrc->select('creative_lots.lot_number', 'creative_lots.created_at', DB::raw('sum(creative_wrc.order_qty) as inward_quantity'))->get();

        // get data for Work Request Code Generated Details
        $wrc_with_order_qty = $lot_info_with_wrc->select('creative_wrc.wrc_number', 'creative_wrc.created_at', 'creative_wrc.order_qty', 'creative_wrc.qc_status')->get();

        $wrc_info = $lot_info_with_wrc->leftJoin('creative_allocation', 'creative_allocation.wrc_id','creative_wrc.id')
        ->where('creative_allocation.wrc_id', '!=', null);

        // get data for allocation to team
        $allocated_wrc_details =  $wrc_info->groupBy('creative_allocation.wrc_id')->select('creative_allocation.wrc_id', 'creative_wrc.wrc_number', DB::raw('sum(creative_allocation.allocated_qty) as allocated_qty'), 'creative_allocation.created_at as allocation_created_at')->get();

        // get data for allocation to team
        $Submission_link_details =  $wrc_info
        ->leftJoin('creative_upload_links', 'creative_upload_links.allocation_id', 'creative_allocation.id')
        ->select('creative_allocation.wrc_id', 'creative_wrc.wrc_number', DB::raw('sum(creative_allocation.allocated_qty) as allocated_qty'), 'creative_wrc.created_at as wrc_created_at', DB::raw('GROUP_CONCAT(creative_upload_links.creative_link) as creative_link_arr') ,DB::raw('GROUP_CONCAT(creative_upload_links.copy_link) as copy_link_arr'))->get();

         // insert into user activity log
         $data_array = array(
            'log_name' => 'Lot Timeline Details', 
            'description' => ' Lot Timeline Details',
            'event' => 'Lot Timeline Details', 
            'subject_type' => 'App\Models\CreatLots', 
            'subject_id' => '0', 
            'properties' => [], 
        );
        // dd($data_array);
        ClientActivityLog::saveClient_activity_logs($data_array);

        // dd($Submission_link_details);
        return view('clients.Timeline.creativeTimeline', compact('lot_generated_detail', 'wrc_with_order_qty', 'allocated_wrc_details', 'Submission_link_details'));
    }

    // clients shoot time line detail
    public function clientsShootlotTimeline(Request $request, $id){

        // LOT Generated details
        $user_detail = Auth::user();// logged in user detail
        $roledata = getUsersRole($user_detail['id']);
        $role = $roledata != null ? $roledata->role_name : '-';
        $client_id = $user_detail['id'];
        $Submission_link_details  = [];
        $allocated_wrc_details = [];
        $wrc_with_order_qty = [];

        //  get lot info based on  $client_id (logged_in user)
        $lot_info_with_wrc = Lots::where('lots.id',$id)->where('lots.user_id', $client_id)->get(['lots.id', 'lots.lot_id as lot_number', 'lots.created_at']);

        foreach($lot_info_with_wrc as $key => $val){

            $wrc_info = Wrc::where('lot_id', $val['id'])->get(['wrc_id', 'id', 'created_at', 'Invoice_no']);
                $tot_sku_count = 0;
                foreach ($wrc_info as $wkey => $wval) {
                    $sku_info = Skus::where('wrc_id', $wval['id'])->where('status', 1)->get(['id']);
                    $sku_count = $sku_info->count();
                    $wval['sku_count'] =  $sku_count;
                    $tot_sku_count += $sku_count;
                }
            $val['inward_quantity'] = $tot_sku_count;
            $val['wrc_with_qty'] = $wrc_info;

            $wrc_info_for_allocation = Wrc::where('lot_id', $val['id'])->get(['wrc_id', 'id', 'created_at']);
            $wrc_data_for_allocation = [];

            foreach ($wrc_info_for_allocation as $wkey => $wval) {
                $sku_info = Skus::where('wrc_id', $wval['id'])->where('status', 1)->get(['id']);
                $sku_count = $sku_info->count();
                $wval['sku_count'] =  $sku_count;
                foreach ($sku_info as $skey => $sval) {
                    $upload_raw_info = uploadraw::where('sku_id', $sval['id'])->get(['id']);
                    foreach ($upload_raw_info as $ukey => $uval) {
                        $allocation = allocation::where('uploadraw_id', $uval['id'])->get(['id']);
                        $allocation_count =  $allocation->count();
                        if ($allocation_count > 0) {
                            // Get data from the Wrc model.
                            $wrc_data = Wrc::where('id', $wval['id'])->first(['wrc_id', 'id', 'created_at']);
                            // Store the data in a new variable.
                            $wrc_data_for_allocation[] = $wrc_data;
                            // Break out of the inner loop since we only need to check one allocation per SKU.
                            break 2;
                        }
                    }
                }
            }

            foreach ($wrc_data_for_allocation as $wkey => $wval) {
                $sku_info = Skus::where('wrc_id', $wval['id'])->where('status', 1)->get(['id']);
                $sku_count = $sku_info->count();
                $wval['sku_count'] =  $sku_count;
            }

            //Allocation to Team
            $val['allocated_wrc_details'] = $wrc_data_for_allocation;


            //Uploading & QC
            $editing_and_qc_status = true;
            $wrc_info_valid = [];

            foreach ($wrc_info as $wkey => $wval) {
                $sku_info = Skus::where('wrc_id', $wval['id'])->where('status', 1)->get(['id']);
                $sku_count = $sku_info->count();
                foreach ($sku_info as $skey => $sval) {
                    $editor_submission_info = editorSubmission::where('sku_id', $sval['id'])->get(['id','qc']);
                    $editor_submission_count = $editor_submission_info->count();

                    if($editor_submission_count == 0){
                        $editing_and_qc_status = false;
                        break 2;
                    }
                    foreach($editor_submission_info as $ekey => $eval){
                        if(($eval['qc'] != "1") || ($eval['qc'] != 1)){
                            $editing_and_qc_status = false;
                            break 3;
                        }
                    }

                }
                
                // Add to the new array only if the $editing_and_qc_status is true
                if ($editing_and_qc_status) {
                    $wval['sku_count'] = $sku_count;
                    $wrc_data = Wrc::where('id', $wval['id'])->first(['wrc_id', 'id', 'created_at']);
                    $wval['wrc_id'] = $wrc_data->wrc_id;
                    $wval['created_at'] = $wrc_data->created_at;
                    $wrc_info_valid[] = $wval;
                }
            }

            // If editing_and_qc_status is false, return an empty array
            if (!$editing_and_qc_status) {
                $wrc_info_valid = [];
            }

            //Editing & QC
            $val['editing_and_qc'] = $wrc_info_valid;

            //Submission (Done)
            $submission_status = true;
            $submission_wrc_info = [];
            $wrc_info_for_deletion = [];

            foreach ($wrc_info as $wkey => $wval) {
                $submission_info = submissions::where('wrc_id', $wval['id'])->get(['id']);
                $submission_info_count = $submission_info->count();
                
                if ($submission_info_count == 0) {
                    $submission_status = false;
                    $wrc_info_for_deletion[] = $wval;
                } else {
                    $submission_wrc_info[] = $wval;
                }
            }

            if ($submission_status) {
                $lot_status = 'Submission Done';
                $val['lot_status'] = 'Submission Done';
            } else {
                $lot_status = 'Submission Pending';
                $val['lot_status'] = 'Submission Pending';
            }
            // Use $submission_wrc_info array for further processing.
            $val['submission_wrc_info'] = $submission_wrc_info;

            //invoice 
            $invoice_wrc_info = [];
            foreach ($wrc_info as $wkey => $wval) {
                $Invoice_no = $wval['Invoice_no'];
                if ($Invoice_no == null || $Invoice_no == '') {
                    $wval['status'] = "Pending";
                } else {
                    $wval['status'] = "Done";
                }
                $invoice_wrc_info[] =  $wval;
            }
            //invoice info
            $val['invoice_wrc_info'] = $invoice_wrc_info;



        }

        //insert data into activity log
         $data_array = array(
            'log_name' => 'Lot Timeline Details', 
            'description' => ' Lot Timeline Details',
            'event' => 'Lot Timeline Details', 
            'subject_type' => 'App\Models\CreatLots', 
            'subject_id' => '0', 
            'properties' => [], 
        );
        ClientActivityLog::saveClient_activity_logs($data_array);

        // $lot_generated_detail = [];
       
        // dd($Submission_link_details);
        return view('clients.Timeline.shootTimeline', compact('allocated_wrc_details', 'Submission_link_details', 'wrc_with_order_qty', 'lot_info_with_wrc'));
    }

    // clients Catlog time line detail
    public function clientsCatloglotTimeline(Request $request, $id){
        // LOT Generated details
        $user_detail = Auth::user();// logged in user detail
        $roledata = getUsersRole($user_detail['id']);
        $role = $roledata != null ? $roledata->role_name : '-';
        $client_id = $user_detail['id'];

        //  get lot info based on  $client_id (logged_in user)
        $lot_info_with_wrc = LotsCatalog::where('lots_catalog.id',$id)->leftJoin('catlog_wrc', 'catlog_wrc.lot_id', 'lots_catalog.id')->where('lots_catalog.user_id', $client_id);

        // get data for lot generated details
        $lot_generated_detail = $lot_info_with_wrc->select('lots_catalog.lot_number', 'lots_catalog.created_at', DB::raw('sum(catlog_wrc.sku_qty) as inward_quantity'))->get();

        // get data for Work Request Code Generated Details
        $wrc_with_order_qty = $lot_info_with_wrc->select('catlog_wrc.wrc_number', 'catlog_wrc.created_at', 'catlog_wrc.sku_qty')->get();

        $wrc_info = $lot_info_with_wrc->leftJoin('catalog_allocation', 'catalog_allocation.wrc_id','catlog_wrc.id')
        ->where('catalog_allocation.wrc_id', '!=', null)
        ->where('catalog_allocation.user_id', '=', $client_id);

        $allocated_wrc_details = $wrc_info->groupBy('catalog_allocation.wrc_id')
        ->leftJoin('catalog_time_hash', 'catalog_time_hash.allocation_id', 'catalog_allocation.id')
        ->select('catalog_allocation.wrc_id', 'catalog_allocation.id', 'catlog_wrc.wrc_number', 
                DB::raw('sum(catalog_allocation.allocated_qty) as allocated_qty'), 
                'catalog_allocation.created_at as allocation_created_at',
                DB::raw('(CASE 
                            WHEN (COUNT(catalog_time_hash.task_status) = SUM(CASE WHEN catalog_time_hash.task_status = 2 THEN 1 ELSE 0 END)) THEN "done"
                            ELSE "pending"
                        END) AS overall_status')
                )
        ->get();




        // get data for allocation to team
        $Submission_link_details =  $wrc_info
        ->leftJoin('catalog_upload_links', 'catalog_upload_links.allocation_id', 'catalog_allocation.id')
        ->select('catalog_allocation.wrc_id', 'catlog_wrc.wrc_number', DB::raw('sum(catalog_allocation.allocated_qty) as allocated_qty'), 'catlog_wrc.created_at as wrc_created_at', DB::raw('GROUP_CONCAT(catalog_upload_links.final_link) as final_link_link_arr') ,DB::raw('GROUP_CONCAT(catalog_upload_links.catalog_link) as catalog_link_arr'))->get();

         // insert into user activity log
         $data_array = array(
            'log_name' => 'Lot Timeline Details', 
            'description' => ' Lot Timeline Details',
            'event' => 'Lot Timeline Details', 
            'subject_type' => 'App\Models\CreatLots', 
            'subject_id' => '0', 
            'properties' => [], 
        );
        // dd($data_array);
        ClientActivityLog::saveClient_activity_logs($data_array);

        // dd($Submission_link_details);
        return view('clients.Timeline.catlogTimeline', compact('lot_generated_detail', 'wrc_with_order_qty', 'allocated_wrc_details', 'Submission_link_details'));
    }

    // clients editor lot time line detail
    public function clientsEditorLotTimeline(Request $request, $id){
        // LOT Generated details
        $user_detail = Auth::user();// logged in user detail
        $roledata = getUsersRole($user_detail['id']);
        $role = $roledata != null ? $roledata->role_name : '-';
        $client_id = $user_detail['id'];
        //  get lot info based on  $client_id (logged_in user)
        $lot_info_with_wrc = EditorLotModel::where('editor_lots.id',$id)->leftJoin('editing_wrcs', 'editing_wrcs.lot_id', 'editor_lots.id')->where('editor_lots.user_id', $client_id);

        // get data for lot generated details
        $lot_generated_detail = $lot_info_with_wrc->select('editor_lots.lot_number', 'editor_lots.created_at', DB::raw('sum(editing_wrcs.imgQty) as inward_quantity'))->get();

        // get data for Work Request Code Generated Details
        $wrc_with_order_qty = $lot_info_with_wrc->select('editing_wrcs.wrc_number', 'editing_wrcs.created_at', 'editing_wrcs.imgQty')->get();

        $wrc_info = $lot_info_with_wrc->leftJoin('editing_allocations', 'editing_allocations.wrc_id','editing_wrcs.id')
        ->where('editing_allocations.wrc_id', '!=', null);

        // get data for allocation to team
        $allocated_wrc_details =  $wrc_info->groupBy('editing_allocations.wrc_id')->select('editing_allocations.wrc_id', 'editing_wrcs.wrc_number', DB::raw('sum(editing_allocations.allocated_qty) as allocated_qty'), 'editing_allocations.created_at as allocation_created_at')->get();

        // get data for allocation to team
        $Submission_link_details =  $wrc_info
        ->leftJoin('editing_upload_links', 'editing_upload_links.allocation_id', 'editing_allocations.id')
        ->select('editing_allocations.wrc_id', 'editing_wrcs.wrc_number', DB::raw('sum(editing_allocations.allocated_qty) as allocated_qty'), 'editing_wrcs.created_at as wrc_created_at', DB::raw('GROUP_CONCAT(editing_upload_links.final_link) as final_link_array') )->get();

         // insert into user activity log
         $data_array = array(
            'log_name' => 'Lot Timeline Details', 
            'description' => ' Lot Timeline Details',
            'event' => 'Lot Timeline Details', 
            'subject_type' => 'App\Models\CreatLots', 
            'subject_id' => '0', 
            'properties' => [], 
        );
        // dd($data_array);
        ClientActivityLog::saveClient_activity_logs($data_array);

        // dd($Submission_link_details);
        return view('clients.Timeline.editorLotTimeline', compact('lot_generated_detail', 'wrc_with_order_qty', 'allocated_wrc_details', 'Submission_link_details'));
    }

    
}
