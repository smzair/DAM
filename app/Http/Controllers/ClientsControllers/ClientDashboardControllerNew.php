<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\ClientActivityLog;
use App\Models\CreatLots;
use App\Models\EditorLotModel;
use App\Models\LotsCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientDashboardControllerNew extends Controller
{

  // clients Catlog time line detail
  public function clientsCatloglotTimeline(Request $request, $id)
  {
    // LOT Generated details
    $user_detail = Auth::user(); // logged in user detail
    $roledata = getUsersRole($user_detail['id']);
    $role = $roledata != null ? $roledata->role_name : '-';
    $client_id = $user_detail['id'];

    $lot_info_with_wrc_query = LotsCatalog::where('lots_catalog.id', $id)->leftJoin('catlog_wrc', 'catlog_wrc.lot_id', 'lots_catalog.id');

    // get data for lot generated details
    $lot_detail = $lot_info_with_wrc_query->select('lots_catalog.id as lot_id', 'lots_catalog.lot_number', 'lots_catalog.created_at', DB::raw('sum(catlog_wrc.sku_qty) as inward_quantity'))->get()->toArray();

    // Lots Details with Wrc data
    $wrc_detail_query = $lot_info_with_wrc_query->leftJoin('catalog_allocation',
      function ($join){
        $join->on('catlog_wrc.id', '=', 'catalog_allocation.wrc_id');
        // $join->on('catalog_wrc_batches.batch_no', '=', 'catalog_allocation.batch_no');
      }
    )->
    leftJoin('catalog_upload_links', 'catalog_upload_links.allocation_id', 'catalog_allocation.id')->
    leftJoin('catalog_time_hash', 'catalog_time_hash.allocation_id', 'catalog_allocation.id')->
    leftJoin('catalog_submissions', 'catalog_submissions.wrc_id', 'catlog_wrc.id')->    
    select(
      'catlog_wrc.id as wrc_id',
      'catlog_wrc.wrc_number',
      'catlog_wrc.alloacte_to_copy_writer',
      'catlog_wrc.created_at as wrc_created_at',
      'catlog_wrc.sku_qty',
      'catlog_wrc.sku_qty as wrc_order_qty',
      'lots_catalog.id as lot_id',
      'lots_catalog.lot_number',
      'lots_catalog.created_at as lot_created_at',
      'catalog_allocation.created_at as allocated_created_at',
      'catalog_time_hash.updated_at as qc_done_at',
      DB::raw('GROUP_CONCAT(catalog_allocation.id) as allocation_ids'),
      DB::raw('GROUP_CONCAT(catalog_allocation.user_id) as ass_cataloger'),
      DB::raw('GROUP_CONCAT(catalog_allocation.user_role) as user_roles'),
      DB::raw('GROUP_CONCAT(catalog_allocation.allocated_qty) as tot_allocated_qty_list'),
      DB::raw('SUM(CASE WHEN catalog_allocation.user_role = 1 THEN catalog_allocation.allocated_qty else 0 END)  as copy_sum'),
      DB::raw('SUM(CASE WHEN catalog_allocation.user_role = 0 THEN catalog_allocation.allocated_qty else 0 END)  as cata_sum'),
      DB::raw('GROUP_CONCAT(catalog_upload_links.id) as uploaded_links_ids'),
      DB::raw('GROUP_CONCAT(catalog_upload_links.final_link) as final_links'),
      DB::raw('GROUP_CONCAT(catalog_time_hash.id) as time_hash_ids'),
      DB::raw('GROUP_CONCAT(catalog_time_hash.task_status) as task_status_list'),
      'catalog_submissions.id as submissions_id',
      'catalog_submissions.submission_date',
      'catalog_submissions.ar_status',
      'catalog_submissions.invoiceNumber',
      'catalog_submissions.action_date',
    )->orderBy('catlog_wrc.id')->orderBy('catalog_allocation.id')->orderBy('catalog_time_hash.updated_at')->orderBy('catalog_submissions.id');
    $wrc_detail_query = $wrc_detail_query->groupBy('catalog_allocation.wrc_id');
    $wrc_detail = $wrc_detail_query->get()->toArray();
    // dd($lot_detail, $wrc_detail_query->toSql(), $wrc_detail);

    $cataloging_wrc_count = DB::table('catlog_wrc')->where('lot_id',$id)->count();
    $lot_status = $cataloging_wrc_count > 0 ? 'WRC Generated' : 'Inward';
    $wrc_progress = $cataloging_wrc_count > 0 ? '20' : '0';
    $overall_progress = $cataloging_wrc_count > 0 ? '40' : '20';

    $lot_detail[0]['lot_status']  = $lot_status;
    $lot_detail[0]['overall_progress']  = $overall_progress."%";
    $lot_detail[0]['wrc_progress']  = $wrc_progress."%";
    $lot_detail[0]['wrc_assign']  = "0%";
    $lot_detail[0]['wrc_qc']  = "0%";
    $lot_detail[0]['wrc_submission']  = "0%";
    
    $count_wrc = 0;
    $count_qc = 0;
    $count_submission = 0;
    
    foreach($wrc_detail as $key => $wrc_row){
      $lot_detail[0]['wrc_created_at']  = $wrc_row['wrc_created_at'];
      $lot_detail[0]['allocated_created_at']  = $wrc_row['allocated_created_at'];
      $alloacte_to_copy_writer = $wrc_row['alloacte_to_copy_writer'];
      $copy_sum = $wrc_row['copy_sum'];
      $cata_sum = $wrc_row['cata_sum'];
      $sku_count = $wrc_row['wrc_order_qty'];
      
      $wrc_detail[$key]['qc_status'] = "Pending";
      $wrc_detail[$key]['submission_status'] = "Pending";

      if($copy_sum > 0 || $cata_sum > 0){
        $lot_detail[0]['wrc_assign']  = "10%";
        $lot_detail[0]['overall_progress']  = "50%";
      }
      
      if(($alloacte_to_copy_writer == 1 && $sku_count == $copy_sum && $sku_count == $cata_sum) || ($alloacte_to_copy_writer == 0 && $sku_count == $cata_sum) ){
        $count_wrc++;
        if($wrc_row['submissions_id'] > 0){
          $wrc_detail[$key]['qc_status'] = "Done";
          $wrc_detail[$key]['submission_status'] = "Done";
          $count_qc++;
          $count_submission++;
          $lot_detail[0]['qc_done_at']  = $wrc_row['qc_done_at'];
          $lot_detail[0]['submission_date']  = $wrc_row['submission_date'];
        }else{
          $allocation_ids = $wrc_row['allocation_ids'];
          $allocation_id_arr = explode(",",$allocation_ids);                                
          $tot_allocation_ids = count($allocation_id_arr);
          
          $task_status_list = $wrc_row['task_status_list'];
          $task_status_arr = explode(",",$task_status_list);
          $tot_task_status = count($task_status_arr);
          $task_status_sum = array_sum($task_status_arr);
  
          if($task_status_sum == (2*$tot_allocation_ids) && $tot_task_status == $tot_allocation_ids){
            $wrc_detail[$key]['qc_status'] = "Done";
            $count_qc++;
            $lot_detail[0]['qc_done_at']  = $wrc_row['qc_done_at'];

          }else if($task_status_sum == (3*$tot_allocation_ids) && $tot_task_status == $tot_allocation_ids){
            $wrc_detail[$key]['qc_status'] = "Done";
            $wrc_detail[$key]['submission_status'] = "Done";
            $count_qc++;
            $count_submission++;
            $lot_detail[0]['qc_done_at']  = $wrc_row['qc_done_at'];
            $lot_detail[0]['submission_date']  = $wrc_row['submission_date'];
          }
        }
      }
    }
    if(count($wrc_detail) == $count_wrc && count($wrc_detail) > 0){
      $lot_detail[0]['wrc_assign']  = "20%";
      $lot_detail[0]['overall_progress']  = "60%";
      if(count($wrc_detail) == $count_qc){
        $lot_detail[0]['wrc_qc']  = "20%";
        $lot_detail[0]['overall_progress']  = "80%";
        if(count($wrc_detail) == $count_submission){
          $lot_detail[0]['wrc_submission']  = "20%";
          $lot_detail[0]['overall_progress']  = "100%";
        }
      }
    }
    // insert into user activity log
    $data_array = array(
      'log_name' => 'Lot Timeline Details',
      'description' => ' Lot Timeline Details',
      'event' => 'Lot Timeline Details',
      'subject_type' => 'App\Models\CreatLots',
      'subject_id' => '0',
      'properties' => [],
    );
    // dd($lot_detail, $wrc_detail_query->toSql(), $wrc_detail);
    ClientActivityLog::saveClient_activity_logs($data_array);
    return view('clients.Timeline.catlogTimeline_New')->with('lot_detail', $lot_detail)->with('wrc_detail', $wrc_detail);
  }

  // clients creative time line detail
  public function clientsCreativelotTimelineNew(Request $request, $id)
  {
    // LOT Generated details
    $user_detail = Auth::user(); // logged in user detail
    $roledata = getUsersRole($user_detail['id']);
    $role = $roledata != null ? $roledata->role_name : '-';
    $client_id = $user_detail['id'];
    $parent_client_id = $user_detail['parent_client_id'];

    $graphic_designer_ids = DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')->where([ ['roles.name','=', 'GD']])->pluck('users.id')->toArray();
    $graphic_designer_id_str = implode(',',$graphic_designer_ids);
    $copy_writer_ids = DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')->where([ ['roles.name','=', 'CW']])->pluck('users.id')->toArray();
    $copy_writer_id_str = implode(',',$copy_writer_ids);

    $lot_info_with_wrc = CreatLots::where('creative_lots.id', $id)->leftJoin('creative_wrc', 'creative_wrc.lot_id', 'creative_lots.id');

    // Lots Details with Wrc data
    $lot_detail = $lot_info_with_wrc->select('creative_lots.id as lot_id','creative_lots.lot_number', 'creative_lots.created_at', DB::raw('SUM(CASE WHEN sku_required = 1 THEN sku_count ELSE order_qty END) AS inward_quantity'))->get()->toArray();

    $wrc_info  = $wrc_detail_query = $lot_info_with_wrc->leftJoin('creative_allocation', 'creative_allocation.wrc_id', 'creative_wrc.id')->
    leftJoin('creative_time_hash', 'creative_time_hash.allocation_id', 'creative_allocation.id')->
    leftJoin('creative_upload_links', 'creative_upload_links.allocation_id', 'creative_allocation.id')->
    leftJoin('creative_submissions',
      function ($join){
        $join->on('creative_allocation.wrc_id', '=', 'creative_submissions.wrc_id');
        $join->on('creative_allocation.batch_no', '=', 'creative_submissions.batch_no');
      }
    )->
    select(
      'creative_wrc.id as wrc_id',
      'creative_wrc.wrc_number',
      'creative_wrc.commercial_id',
      'creative_wrc.created_at as wrc_created_at',
      'creative_wrc.sku_required',
      'creative_wrc.sku_count',
      'creative_wrc.order_qty',
      DB::raw('CASE WHEN creative_wrc.sku_required = 1 THEN creative_wrc.sku_count ELSE creative_wrc.order_qty END AS wrc_order_qty'),
      'creative_wrc.cw_qc_status',
      'creative_wrc.alloacte_to_copy_writer',

      'creative_lots.id as lot_id',
      'creative_lots.lot_number',
      'creative_lots.project_name',
      'creative_lots.verticle',
      'creative_lots.created_at as lot_created_at',
      
      'creative_allocation.id as allocation_id',
      'creative_allocation.user_id',
      'creative_allocation.allocated_qty',
      'creative_allocation.created_at as allocated_created_at',
      'creative_time_hash.updated_at as qc_done_at',
      DB::raw("CASE WHEN creative_allocation.user_id IN ($graphic_designer_id_str) THEN 'GD' ELSE 'CW' END AS role"),
      DB::raw('GROUP_CONCAT(creative_allocation.id) as allocation_ids'),
      DB::raw('GROUP_CONCAT(creative_allocation.user_id) as ass_cataloger'),
      DB::raw("GROUP_CONCAT(CASE WHEN creative_allocation.user_id IN ($graphic_designer_id_str) THEN '1' ELSE '0' END) as user_roles"),
      DB::raw("SUM(CASE WHEN creative_allocation.user_id IN ($graphic_designer_id_str) THEN creative_allocation.allocated_qty ELSE 0 END) AS gd_sum"),
      DB::raw("SUM(CASE WHEN creative_allocation.user_id IN ($copy_writer_id_str) THEN creative_allocation.allocated_qty ELSE 0 END) AS cp_sum"),
      
      'creative_time_hash.id as time_hash_id',
      'creative_time_hash.task_status',
      DB::raw('GROUP_CONCAT(creative_time_hash.id) as time_hash_ids'),
      DB::raw('GROUP_CONCAT(creative_time_hash.task_status) as task_status_list'),
      
      'creative_upload_links.id as upload_links_id',
      'creative_upload_links.creative_link',
      'creative_upload_links.copy_link',
      DB::raw('GROUP_CONCAT(creative_upload_links.id) as uploaded_links_ids'),
      DB::raw('GROUP_CONCAT(creative_upload_links.creative_link) as creative_links'),
      DB::raw('GROUP_CONCAT(creative_upload_links.copy_link) as copy_links'),
      'creative_submissions.id as submissions_id',
      'creative_submissions.submission_date as submission_date',
      'creative_submissions.Status as status',
    )->orderBy('creative_wrc.id')->orderBy('creative_allocation.id')->orderBy('creative_time_hash.updated_at')->orderBy('creative_submissions.id');
    
    $wrc_detail_query= $wrc_detail_query->groupBy('creative_allocation.wrc_id');
    $wrc_detail = $wrc_detail_query->get()->toArray();

    $creative_wrc_count = DB::table('creative_wrc')->where('lot_id',$id)->count();
    $lot_status = $creative_wrc_count > 0 ? 'WRC Generated' : 'Inward';
    $wrc_progress = $creative_wrc_count > 0 ? '20' : '0';
    $overall_progress = $creative_wrc_count > 0 ? '40' : '20';

    $lot_detail[0]['lot_status']  = $lot_status;
    $lot_detail[0]['overall_progress']  = $overall_progress."%";
    $lot_detail[0]['wrc_progress']  = $wrc_progress."%";
    $lot_detail[0]['wrc_assign']  = "0%";
    $lot_detail[0]['wrc_qc']  = "0%";
    $lot_detail[0]['wrc_submission']  = "0%";

    $count_wrc = 0;
    $count_qc = 0;
    $count_submission = 0;
    foreach($wrc_detail as $key => $wrc_row){
      $lot_detail[0]['wrc_created_at']  = $wrc_row['wrc_created_at'];
      $lot_detail[0]['allocated_created_at']  = $wrc_row['allocated_created_at'];
      $alloacte_to_copy_writer = $wrc_row['alloacte_to_copy_writer'];
      $gd_sum = $wrc_row['gd_sum'];
      $cp_sum = $wrc_row['cp_sum'];
      $sku_count = $wrc_row['wrc_order_qty'];

      $wrc_detail[$key]['qc_status'] = "Pending";
      $wrc_detail[$key]['submission_status'] = "Pending";

      if($cp_sum > 0 || $gd_sum > 0){
        $lot_detail[0]['wrc_assign']  = "10%";
        $lot_detail[0]['overall_progress']  = "50%";
      }

      if(($alloacte_to_copy_writer == 1 && $sku_count == $cp_sum && $sku_count == $gd_sum) || ($alloacte_to_copy_writer == 0 && $sku_count == $gd_sum) ){
        $count_wrc++;
        if($wrc_row['submissions_id'] > 0 && $wrc_row['status'] == 1){
          $wrc_detail[$key]['qc_status'] = "Done";
          $wrc_detail[$key]['submission_status'] = "Done";
          $count_qc++;
          $count_submission++;
          $lot_detail[0]['qc_done_at']  = $wrc_row['qc_done_at'];
          $lot_detail[0]['submission_date']  = $wrc_row['submission_date'];
        }else{
          $allocation_ids = $wrc_row['allocation_ids'];
          $allocation_id_arr = explode(",",$allocation_ids);                                
          $tot_allocation_ids = count($allocation_id_arr);
          
          $task_status_list = $wrc_row['task_status_list'];
          $task_status_arr = explode(",",$task_status_list);
          $tot_task_status = count($task_status_arr);
          $task_status_sum = array_sum($task_status_arr);
          
          if($task_status_sum == (2*$tot_allocation_ids) && $tot_task_status == $tot_allocation_ids){
            $wrc_detail[$key]['qc_status'] = "Done";            
            $count_qc++;
            $lot_detail[0]['qc_done_at']  = $wrc_row['qc_done_at'];
          } 
        }        
      }
    }
    if(count($wrc_detail) == $count_wrc && count($wrc_detail) > 0){
      $lot_detail[0]['wrc_assign']  = "20%";
      $lot_detail[0]['overall_progress']  = "60%";
      if(count($wrc_detail) == $count_qc){
        $lot_detail[0]['wrc_qc']  = "20%";
        $lot_detail[0]['overall_progress']  = "80%";
        if(count($wrc_detail) == $count_submission){
          $lot_detail[0]['wrc_submission']  = "20%";
          $lot_detail[0]['overall_progress']  = "100%";
        }
      }
    }
    // dd($lot_detail,$wrc_detail, count($wrc_detail) , $count_wrc);
    
    // insert into user activity log
    $data_array = array(
      'log_name' => 'Lot Timeline Details',
      'description' => ' Lot Timeline Details',
      'event' => 'Lot Timeline Details',
      'subject_type' => 'App\Models\CreatLots',
      'subject_id' => '0',
      'properties' => [],
    );
    ClientActivityLog::saveClient_activity_logs($data_array);
    return view('clients.Timeline.creativeTimeline_New')->with('lot_detail', $lot_detail)->with('wrc_detail', $wrc_detail);   
  }

  // clients editor lot time line detail
  public function clientsEditorLotTimelineNew(Request $request, $id)
  {
    $LotTimelineData = EditorLotModel::clientsEditorLotTimeline($id);
    $lot_detail = $LotTimelineData['lot_detail']; 
    $wrc_detail = $LotTimelineData['wrc_detail']; 
    return view('clients.Timeline.editorLotTimeline_New')->with('lot_detail', $lot_detail)->with('wrc_detail', $wrc_detail);
  }

}
