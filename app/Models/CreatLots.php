<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreatLots extends Model
{
  use HasFactory;
  protected $table = 'creative_lots';
  protected $fillable = ['user_id', 'brand_id', 'lot_number', 'project_name', 'verticle', 'client_bucket', 'work_initiate_date', 'Comitted_initiate_date', 'status'];

  // get Creative Lots Wrcs with allocation
  public function getCreativeWrc()
  {
    return $this->hasMany('App\Models\CreativeWrcModel', 'lot_id', 'id')->with('wrcAllocations:id,wrc_id,user_id,allocated_qty,batch_no');
  }

  // clients Creative Lot Timeline
  public static function LotTimeline($id)
  {

    $graphic_designer_ids = DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')->where([['roles.name', '=', 'GD']])->pluck('users.id')->toArray();
    $graphic_designer_id_str = implode(',', $graphic_designer_ids);

    $copy_writer_ids = DB::table('users')->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')->where([['roles.name', '=', 'CW']])->pluck('users.id')->toArray();
    $copy_writer_id_str = implode(',', $copy_writer_ids);

    $lot_info_with_wrc = CreatLots::where('creative_lots.id', $id)->
    leftJoin('creative_wrc', 'creative_wrc.lot_id', 'creative_lots.id')->
    leftJoin('create_commercial', 'create_commercial.id', 'creative_wrc.commercial_id')->
    leftjoin('users' ,'users.id' , 'creative_lots.user_id' )->
    leftjoin('brands' , 'brands.id' , 'creative_lots.brand_id');

    // Lots Details with Wrc data
    $lot_detail = $lot_info_with_wrc->
    select('creative_lots.id as lot_id', 'creative_lots.lot_number', 'creative_lots.created_at','users.Company as company_name',
    'users.c_short as company_c_short',
    'brands.name as brand_name',
    'brands.short_name as brand_short_name', DB::raw('SUM(CASE WHEN sku_required = 1 THEN sku_count ELSE order_qty END) AS inward_quantity'))->get()->toArray();
    // dd($lot_detail);
    $wrc_info  = $wrc_detail_query = $lot_info_with_wrc->leftJoin('creative_allocation', 'creative_allocation.wrc_id', 'creative_wrc.id')->leftJoin('creative_time_hash', 'creative_time_hash.allocation_id', 'creative_allocation.id')->leftJoin('creative_upload_links', 'creative_upload_links.allocation_id', 'creative_allocation.id')->leftJoin(
      'creative_submissions',
      function ($join) {
        $join->on('creative_allocation.wrc_id', '=', 'creative_submissions.wrc_id');
        $join->on('creative_allocation.batch_no', '=', 'creative_submissions.batch_no');
      }
    )->select(
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
      'create_commercial.project_name as commercial_project_name',
      'create_commercial.kind_of_work',
      'create_commercial.per_qty_value',

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
      'creative_submissions.Status as status'
    )->orderBy('creative_wrc.id')->orderBy('creative_allocation.id')->orderBy('creative_time_hash.updated_at')->orderBy('creative_submissions.id');

    $wrc_detail_query = $wrc_detail_query->groupBy('creative_allocation.wrc_id');
    $wrc_detail = $wrc_detail_query->get()->toArray();

    $creative_and_cataloging_lot_statusArr = creative_and_cataloging_lot_statusArr();
    $creative_wrc_count = DB::table('creative_wrc')->where('lot_id', $id)->count();
    $lot_status = $creative_wrc_count > 0 ? $creative_and_cataloging_lot_statusArr[1] : $creative_and_cataloging_lot_statusArr[0];
    $wrc_progress = $creative_wrc_count > 0 ? '20' : '0';
    $overall_progress = $creative_wrc_count > 0 ? '40' : '20';

    $lot_detail[0]['lot_status']  = $lot_status;
    $lot_detail[0]['overall_progress']  = $overall_progress . "%";
    $lot_detail[0]['wrc_progress']  = $wrc_progress . "%";
    $lot_detail[0]['wrc_assign']  = "0%";
    $lot_detail[0]['wrc_qc']  = "0%";
    $lot_detail[0]['wrc_submission']  = "0%";

    $count_wrc = 0;
    $count_qc = 0;
    $count_submission = 0;
    foreach ($wrc_detail as $key => $wrc_row) {
      $lot_detail[0]['wrc_created_at']  = $wrc_row['wrc_created_at'];
      $lot_detail[0]['allocated_created_at']  = $wrc_row['allocated_created_at'];
      $alloacte_to_copy_writer = $wrc_row['alloacte_to_copy_writer'];
      $gd_sum = $wrc_row['gd_sum'];
      $cp_sum = $wrc_row['cp_sum'];
      $sku_count = $wrc_row['wrc_order_qty'];

      $wrc_detail[$key]['qc_status'] = "Pending";
      $wrc_detail[$key]['submission_status'] = "Pending";

      if ($cp_sum > 0 || $gd_sum > 0) {
        $lot_detail[0]['wrc_assign']  = "10%";
        $lot_detail[0]['overall_progress']  = "50%";
        $lot_detail[0]['lot_status']  = $creative_and_cataloging_lot_statusArr[2];
      }

      if (($alloacte_to_copy_writer == 1 && $sku_count == $cp_sum && $sku_count == $gd_sum) || ($alloacte_to_copy_writer == 0 && $sku_count == $gd_sum)) {
        $count_wrc++;
        if ($wrc_row['submissions_id'] > 0 && $wrc_row['status'] == 1) {
          $wrc_detail[$key]['qc_status'] = "Done";
          $wrc_detail[$key]['submission_status'] = "Done";
          $count_qc++;
          $count_submission++;
          $lot_detail[0]['qc_done_at']  = $wrc_row['qc_done_at'];
          $lot_detail[0]['submission_date']  = $wrc_row['submission_date'];
        } else {
          $allocation_ids = $wrc_row['allocation_ids'];
          $allocation_id_arr = explode(",", $allocation_ids);
          $tot_allocation_ids = count($allocation_id_arr);

          $task_status_list = $wrc_row['task_status_list'];
          $task_status_arr = explode(",", $task_status_list);
          $tot_task_status = count($task_status_arr);
          $task_status_sum = array_sum($task_status_arr);

          if ($task_status_sum == (2 * $tot_allocation_ids) && $tot_task_status == $tot_allocation_ids) {
            $wrc_detail[$key]['qc_status'] = "Done";
            $count_qc++;
            $lot_detail[0]['qc_done_at']  = $wrc_row['qc_done_at'];
          }
        }
      }
    }
    if (count($wrc_detail) == $count_wrc && count($wrc_detail) > 0) {
      $lot_detail[0]['wrc_assign']  = "20%";
      $lot_detail[0]['overall_progress']  = "60%";
      $lot_detail[0]['lot_status']  = $creative_and_cataloging_lot_statusArr[2];
      if (count($wrc_detail) == $count_qc) {
        $lot_detail[0]['wrc_qc']  = "20%";
        $lot_detail[0]['overall_progress']  = "80%";
        $lot_detail[0]['lot_status']  = $creative_and_cataloging_lot_statusArr[3];
        if (count($wrc_detail) == $count_submission) {
          $lot_detail[0]['wrc_submission']  = "20%";
          $lot_detail[0]['overall_progress']  = "100%";
          $lot_detail[0]['lot_status']  = $creative_and_cataloging_lot_statusArr[4];
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
    // ClientActivityLog::saveClient_activity_logs($data_array);
    return array(
      'lot_detail' => $lot_detail,
      'wrc_detail' => $wrc_detail,
    );
  }
}
