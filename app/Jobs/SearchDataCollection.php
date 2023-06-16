<?php

namespace App\Jobs;

use App\Models\CreatLots;
use App\Models\EditorLotModel;
use App\Models\Lots;
use App\Models\LotsCatalog;
use App\Models\Skus;
use App\Models\submissions;
use App\Models\uploadraw;
use App\Models\Wrc;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SearchDataCollection implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  private $userData;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($userData)
  {
    $this->userData = $userData;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $roledata = getUsersRole($this->userData->id);
    $roledata != null ? $roledata->role_name : '-';
    $client_id = $this->userData->id;
    $parent_client_id = $this->userData->parent_client_id;

    $lot_status_is = 'all';
    $sortBy = 'latest';
    if ($sortBy == 'oldest' || $sortBy == 'old') {
      $sortByIs = 'ASC';
    } else {
      $sortByIs = 'DESC';
    }

    if ($roledata != null) {
      $role_id = $roledata->role_id;
      $role_name = $roledata->role_name;
    }
    $brand_arr = DB::table('brands_user')->where('user_id', $client_id)->get()->pluck('brand_id')->toArray();

    /****************************** Shoot Data ******************************/
      /***** Lots Data , Wrc Data And SKU data ****/

      $shoot_lot_statusArr = shoot_lot_statusArr();

      $shoot_lots_query = Lots::orderBy('lots.id', $sortByIs)
        ->select('lots.id as lot_id', 'lots.lot_id as lot_number', 'lots.created_at')
        ->whereIn('lots.brand_id', $brand_arr)
        ->groupBy('lots.id');
      if ($role_name == 'Sub Client') {
        $shoot_lots_query = $shoot_lots_query->where('lots.user_id', $parent_client_id);
      }
      if ($role_name == 'Client') {
        $shoot_lots_query = $shoot_lots_query->where('lots.user_id', $client_id);
      }
      $shoot_lots = $shoot_lots_query->get()->toArray();

      $shoot_wrc_data = array();
      $shoot_sku_data = array();
      foreach ($shoot_lots as $key => $val) {
        $LotTimelineData = Lots::LotTimeline($val['lot_id']);
        $lot_detail = $LotTimelineData['lot_detail']; 
        $wrc_detail = $LotTimelineData['wrc_detail'];
        $wrc_detail_new = [];
        foreach ($wrc_detail as $wrc_key => $wrc_row) {

          // Soot sku Datas.
          $sku_info_query = Skus::where('wrc_id', $wrc_row['wrc_id']);
          $sku_info_count = $sku_info_query->count();
          $sku_info = $sku_info_query->get()->toArray();
          foreach ($sku_info as $sky_key => $sku_row) {
            $sku_row['wrc_info'] = $wrc_row;
            array_push($shoot_sku_data, $sku_row);
          }
          $sku_ids = array_column($sku_info , 'id');
          $upload_raw_info = uploadraw::whereIn('sku_id', $sku_ids)->get()->toArray();

          $wrc_detail[$wrc_key]['sku_info_count'] = $sku_info_count;
          $wrc_detail[$wrc_key]['sku_info'] = $sku_info;
          $wrc_detail[$wrc_key]['upload_raw_info'] = $upload_raw_info;
          array_push($shoot_wrc_data, $wrc_detail[$wrc_key]);
        }
        $shoot_lots[$key] = $lot_detail[0];
        $shoot_lots[$key]['service'] = 'SHOOT';
        $shoot_lots[$key]['wrc_detail'] = $wrc_detail;
      }
      // dd($shoot_lots , $shoot_wrc_data);

      // Soot sku Datas.
      // $wrc_ids = array_column($shoot_wrc_data , 'wrc_id');
      
      // $sku_info_query = Skus::whereIn('wrc_id', $wrc_ids);

      // foreach($shoot_wrc_data as $key => $val){
      //   $sku_info_query = Skus::where('wrc_id', $val['wrc_id']);
      //   $sku_info_count = $sku_info_query->count();
      //   $sku_info = $sku_info_query->get()->toArray();
      //   $sku_ids = array_column($sku_info , 'id');
      //   $upload_raw_info = uploadraw::whereIn('sku_id', $sku_ids)->get()->toArray();

      //   $shoot_wrc_data[$key]['sku_info_count'] = $sku_info_count;
      //   $shoot_wrc_data[$key]['sku_info'] = $sku_info;
      //   $shoot_wrc_data[$key]['upload_raw_info'] = $upload_raw_info;
        
      // }

      // $searchTerm = "9341105960617";
      // $result = array();
      // foreach ($shoot_lots as $item) {
      //   $serializedItem = serialize($item);
      //   if (stripos($serializedItem, $searchTerm) !== false) {
      //     $result[] = $item;
      //   }
      // }

    /****************************** Editing Data ******************************/

      $editor_lots = EditorLotModel::orderBy('editor_lots.id', $sortByIs)
        ->leftJoin('editing_wrcs', 'editing_wrcs.lot_id', 'editor_lots.id')
        ->select('editor_lots.id as lot_id', 'editor_lots.created_at', 'editor_lots.lot_number', 'editing_wrcs.id as wrc_id')
        ->whereIn('editor_lots.brand_id', $brand_arr)
        ->groupBy('editor_lots.id');
      if ($role_name == 'Sub Client') {
        $editor_lots = $editor_lots->where('editor_lots.user_id', $parent_client_id);
      }
      if ($role_name == 'Client') {
        $editor_lots = $editor_lots->where('editor_lots.user_id', $client_id);
      }

      $editor_lots = $editor_lots->get()->toArray();
      $Editing_lot_statusArr = Editing_lot_statusArr();
      $editing_wrc_data = array();
      foreach ($editor_lots as $key => $val) {
        $LotTimelineData = EditorLotModel::clientsEditorLotTimeline($val['lot_id']);
        $lot_detail = $LotTimelineData['lot_detail']; 
        $wrc_detail = $LotTimelineData['wrc_detail']; 
        $editor_lots[$key] = $lot_detail[0];
        $editor_lots[$key]['service'] = 'EDITING';
        $editor_lots[$key]['wrc_detail'] = $wrc_detail;
        array_push($editing_wrc_data , $wrc_detail);
      }

    /****************************** Creative Data ******************************/
      $creative_lots =  CreatLots::orderBy('creative_lots.id', $sortByIs)->whereIn('creative_lots.brand_id', $brand_arr);
      if ($role_name == 'Sub Client') {
        $creative_lots =  $creative_lots->where('creative_lots.user_id', $parent_client_id);
      }
      if ($role_name == 'Client') {
        $creative_lots =  $creative_lots->where('creative_lots.user_id', $client_id);
      }
      $creative_lots =  $creative_lots->get()->toArray();
      
      foreach ($creative_lots as $key => $val) {
        $LotTimelineData = CreatLots::LotTimeline($val['id']);
        $lot_detail = $LotTimelineData['lot_detail']; 
        $wrc_detail = $LotTimelineData['wrc_detail']; 
        $creative_lots[$key]['wrc_detail'] = $wrc_detail;
        $creative_lots[$key] = $lot_detail[0];
      }

    /****************************** Catalog Data ******************************/

      $lots_catalog = LotsCatalog::orderBy('lots_catalog.id', $sortByIs)->whereIn('lots_catalog.brand_id', $brand_arr)->groupBy('lots_catalog.id');
      if ($role_name == 'Sub Client') {
        $lots_catalog =  $lots_catalog->where('lots_catalog.user_id', $parent_client_id);
      }
      if ($role_name == 'Client') {
        $lots_catalog =  $lots_catalog->where('lots_catalog.user_id', $client_id);
      }
      $lots_catalog =  $lots_catalog->get()->toArray();

      foreach ($lots_catalog as $key => $val) {
        $LotTimelineData = LotsCatalog::LotTimeline($val['id']);
        $lot_detail = $LotTimelineData['lot_detail']; 
        $wrc_detail = $LotTimelineData['wrc_detail']; 
        $lots_catalog[$key]['wrc_detail'] = $wrc_detail;
        $lots_catalog[$key] = $lot_detail[0];
      }
     // dd($lots_catalog);

    /****************************** End Data ******************************/
    
    $shoot_data = array(
      'lots' => $shoot_lots,
      'wrc' => $shoot_wrc_data,
      'sku' => $shoot_sku_data
    );
    $editing_data = array(
      'lots' => $editor_lots,
      'wrc' => $editing_wrc_data
    );
    $creative_Data = array(
      'lots' => $creative_lots
    );
    $catalog_data = array(
      'lots' => $creative_lots
    );
    
    // Store the data arrays in a session or cache
    Session::put('shoot_data', $shoot_data);
    Session::put('editing_data', $editing_data);
    Session::put('creative_Data', $creative_Data);
    Session::put('catalog_data', $catalog_data);
    // dd($shoot_lots ,$editor_lots , $shoot_lots , $lots_catalog);

  }
}
