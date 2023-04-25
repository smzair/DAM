<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\ClientActivityLog;
use App\Models\CreatLots;
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
    )->groupBy('catalog_allocation.wrc_id');
    // $wrc_detail = $wrc_detail_query->toSql();
    $wrc_detail = $wrc_detail_query->get()->toArray();

    foreach($wrc_detail as $key => $wrc_row){
      $alloacte_to_copy_writer = $wrc_row['alloacte_to_copy_writer'];
      $copy_sum = $wrc_row['copy_sum'];
      $cata_sum = $wrc_row['cata_sum'];
      $sku_count = $wrc_row['wrc_order_qty'];

      $wrc_detail[$key]['qc_status'] = "Pending";
      $wrc_detail[$key]['submission_status'] = "Pending";

      if(($alloacte_to_copy_writer == 1 && $sku_count == $copy_sum && $sku_count == $cata_sum) || ($alloacte_to_copy_writer == 0 && $sku_count == $cata_sum) ){

        if($wrc_row['submissions_id'] > 0){
          $wrc_detail[$key]['qc_status'] = "Done";
          $wrc_detail[$key]['submission_status'] = "Done";
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
          }else if($task_status_sum == (3*$tot_allocation_ids) && $tot_task_status == $tot_allocation_ids){
            $wrc_detail[$key]['qc_status'] = "Done";
            $wrc_detail[$key]['submission_status'] = "Done";
          }
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
    ClientActivityLog::saveClient_activity_logs($data_array);
    // dd($lot_detail, $wrc_detail_query->toSql(), $wrc_detail);
    return view('clients.Timeline.catlogTimeline_New')->with('lot_detail', $lot_detail)->with('wrc_detail', $wrc_detail);
  }

  
}
