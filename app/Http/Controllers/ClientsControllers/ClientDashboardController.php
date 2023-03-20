<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\CreativeTimeHash;
use App\Models\ClientActivityLog;
use App\Models\CreativeWrcModel;
use App\Models\CreatLots;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientDashboardController extends Controller
{
    //
    public static function index(){
        $resData = [];
        $user_detail = Auth::user();// logged in user detail
        $roledata = getUsersRole($user_detail['id']);
        $role = $roledata != null ? $roledata->role_name : '-';
        $client_id = $user_detail['id'];
        // dd($user_detail);
        $parent_client_id = $user_detail['parent_client_id'];
        if($role == "Client"){
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
                    
                    
                ->select('creative_wrc.wrc_number','creative_lots.user_id','creative_lots.brand_id','creative_lots.lot_number','users.Company as Company_name','brands.name','creative_lots.client_bucket','create_commercial.project_name','create_commercial.kind_of_work','create_commercial.per_qty_value','creative_wrc_batch.work_initiate_date','creative_wrc_batch.work_committed_date','creative_submissions.submission_date','creative_submissions.status as submission_status','creative_allocation.wrc_id as submission_wrc_id','creative_allocation.id as allocation_id','creative_allocation.batch_no as submission_batch_no','creative_wrc_batch.work_initiate_date', 'creative_wrc_batch.work_committed_date','creative_lots.lot_delivery_days','creative_lots.id as lot_id','creative_wrc_batch.wrc_id as batch_wrc_id','creative_wrc_batch.batch_no','creative_time_hash.task_status')
                // ->groupBy('creative_wrc_batch.wrc_id')
                // ->groupBy('creative_wrc_batch.batch_no')
                ->where(function ($query) {
                    $query->where('creative_submissions.status', '!=', 1)
                    ->orWhere('creative_submissions.status', '=', null)
                    ->orWhere('creative_submissions.status', '=', 0);
                })
                ->groupBy('creative_lots.id')
                ->where('creative_lots.user_id',$client_id)
                    //->groupBy(['creative_wrc_batch.wrc_id','creative_wrc_batch.batch_no'])
            ->get();
                    // dd(pre($resData));
            foreach($resData as $key => $val){

                $task_type_data = DB::table('creative_submissions')->where('wrc_id', $val['submission_wrc_id'])->where('batch_no', $val['submission_batch_no'])->where('Status',1)->first(['wrc_id']);
                $wrc_id = $task_type_data != null ? $task_type_data->wrc_id : 0;
                $sku_order_qty_data = DB::table('creative_wrc')->where('id', $wrc_id)->first(['order_qty', 'sku_count']);
                $order_qty = $sku_order_qty_data != null ? $sku_order_qty_data->order_qty : 0 ; 
                $sku_qty = $sku_order_qty_data != null ? $sku_order_qty_data->sku_count : 0 ; 
                $sku_order_qty = $sku_qty > 0 ? $sku_qty : $order_qty;

                $val['sku_order_qty'] = $sku_order_qty;
                $time_hash_data = CreativeTimeHash::where('id',$val['allocation_id'])->first(['is_rework']);
                $is_rework = $time_hash_data != null ? $time_hash_data->is_rework : 0 ;

                $fta = $is_rework > 0 ? 'NFTA' : 'FTA';
                $val['fta']  = $fta;

                $lot_delivery_days = $val['lot_delivery_days'];
                $work_initiate_date = $val['work_initiate_date'];
                $work_committed_date = $val['work_committed_date'];

                $date1 = new DateTime($work_initiate_date);
                $date2 = new DateTime($work_committed_date);
                $interval = $date1->diff($date2);
                // echo $interval->days;

                $total_days = $interval->days;
                $tat_diff = $lot_delivery_days - $total_days ;
                $tat_status = $tat_diff > 0 ?  'Within TAT' : 'TAT Breached';
                $val['tat_status']  = $tat_status;

                $wrc_created_at = $val['created_at'];
                $today_date = Carbon::now();

                $date11 = new DateTime($wrc_created_at);
                $date22 = new DateTime($today_date);
                $interval1 = $date11->diff($date22);
                
                $ageing = $interval1->days;
                $val['ageing']  = $ageing;
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
        }else{
            $resData = array();
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
        // dd($data_array);
        ClientActivityLog::saveClient_activity_logs($data_array);

        return view('clients.ClientDashboard')->with('resData',$resData);
    }

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
}
