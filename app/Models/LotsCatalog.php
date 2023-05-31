<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LotsCatalog extends Model
{
  use HasFactory;
  protected $table = 'lots_catalog';

  protected $fillable = [
    'id', 'user_id', 'brand_id', 'lot_number', 'serviceType', 'requestType', 'reqReceviedDate', 'reqReceviedDate'
  ];

  // get Creative Lots Wrcs with allocation
  public function WrcListWithAllocation()
  {
    return $this->hasMany('App\Models\CatlogWrc', 'lot_id', 'id')->with('WrcAllocationList:*');
  }

  // clients Creative Lot Timeline
  public static function LotTimeline($id)
  {
    // LOT Generated details
    $user_detail = Auth::user(); // logged in user detail
    $roledata = getUsersRole($user_detail['id']);

    $lot_info_with_wrc_query = LotsCatalog::where('lots_catalog.id', $id)->
    leftJoin('catlog_wrc', 'catlog_wrc.lot_id', 'lots_catalog.id')->
    leftJoin('create_commercial_catalog', 'create_commercial_catalog.id', 'catlog_wrc.commercial_id')->
    leftjoin('users' ,'users.id' , 'lots_catalog.user_id' )->
    leftjoin('brands' , 'brands.id' , 'lots_catalog.brand_id');

    // get data for lot generated details
    $lot_detail = $lot_info_with_wrc_query->select('lots_catalog.id as lot_id', 'lots_catalog.lot_number', 'lots_catalog.created_at','users.Company as company_name',
    'users.c_short as company_c_short',
    'brands.name as brand_name',
    'brands.short_name as brand_short_name', DB::raw('sum(catlog_wrc.sku_qty) as inward_quantity'))->get()->toArray();

    // Lots Details with Wrc data
    $wrc_detail_query = $lot_info_with_wrc_query->leftJoin(
      'catalog_allocation',
      function ($join) {
        $join->on('catlog_wrc.id', '=', 'catalog_allocation.wrc_id');
        // $join->on('catalog_wrc_batches.batch_no', '=', 'catalog_allocation.batch_no');
      }
    )->leftJoin('catalog_upload_links', 'catalog_upload_links.allocation_id', 'catalog_allocation.id')->leftJoin('catalog_time_hash', 'catalog_time_hash.allocation_id', 'catalog_allocation.id')->leftJoin('catalog_submissions', 'catalog_submissions.wrc_id', 'catlog_wrc.id')->select(
        'catlog_wrc.id as wrc_id',
        'catlog_wrc.wrc_number',
        'catlog_wrc.alloacte_to_copy_writer',
        'catlog_wrc.created_at as wrc_created_at',
        'catlog_wrc.sku_qty',
        'catlog_wrc.sku_qty as wrc_order_qty',
        'catlog_wrc.modeOfDelivary',
        'create_commercial_catalog.type_of_service',
        'create_commercial_catalog.market_place',
        'create_commercial_catalog.CommercialSKU',
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

    $creative_and_cataloging_lot_statusArr = creative_and_cataloging_lot_statusArr();
    $cataloging_wrc_count = DB::table('catlog_wrc')->where('lot_id', $id)->count();
    $lot_status = $cataloging_wrc_count > 0 ? $creative_and_cataloging_lot_statusArr[1] : $creative_and_cataloging_lot_statusArr[0];
    
    $wrc_progress = $cataloging_wrc_count > 0 ? '20' : '0';
    $overall_progress = $cataloging_wrc_count > 0 ? '40' : '20';

    $lot_detail[0]['lot_status']  = $lot_status;
    $lot_detail[0]['overall_progress']  = $overall_progress . "%";
    $lot_detail[0]['wrc_progress']  = $wrc_progress . "%";
    $lot_detail[0]['wrc_assign']  = "0%";
    $lot_detail[0]['wrc_qc']  = "0%";
    $lot_detail[0]['wrc_submission']  = "0%";

    $count_wrc = 0;
    $count_qc = 0;
    $count_submission = 0;
    $MarketPlaces = getMarketPlace();
    $market_place_arr = array_column($MarketPlaces, 'marketPlace_name', 'id');

    foreach ($wrc_detail as $key => $wrc_row) {
      $lot_detail[0]['wrc_created_at']  = $wrc_row['wrc_created_at'];
      $lot_detail[0]['allocated_created_at']  = $wrc_row['allocated_created_at'];
      $alloacte_to_copy_writer = $wrc_row['alloacte_to_copy_writer'];
      $copy_sum = $wrc_row['copy_sum'];
      $cata_sum = $wrc_row['cata_sum'];
      $sku_count = $wrc_row['wrc_order_qty'];
      $market_place = $wrc_row['market_place'];
      $market_place_ids = explode(',',$market_place);
      $market_place_array = array();
      foreach ($market_place_ids as $id) {
        if (array_key_exists($id, $market_place_arr)) {
          $market_place = $market_place_arr[$id];
          array_push($market_place_array ,$market_place);
        } 
      }
      $wrc_detail[$key]['market_place_array'] = $market_place_array;
      // dd($market_place_arr ,$market_place_ids);

      $wrc_detail[$key]['qc_status'] = "Pending";
      $wrc_detail[$key]['submission_status'] = "Pending";

      if ($copy_sum > 0 || $cata_sum > 0) {
        $lot_detail[0]['wrc_assign']  = "10%";
        $lot_detail[0]['overall_progress']  = "50%";
        $lot_detail[0]['lot_status']  = $creative_and_cataloging_lot_statusArr[2];
      }

      if (($alloacte_to_copy_writer == 1 && $sku_count == $copy_sum && $sku_count == $cata_sum) || ($alloacte_to_copy_writer == 0 && $sku_count == $cata_sum)) {
        $count_wrc++;
        if ($wrc_row['submissions_id'] > 0) {
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
          } else if ($task_status_sum == (3 * $tot_allocation_ids) && $tot_task_status == $tot_allocation_ids) {
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
