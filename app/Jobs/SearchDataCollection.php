<?php

namespace App\Jobs;

use App\Models\CreatLots;
use App\Models\EditingUploadedImages;
use App\Models\EditorLotModel;
use App\Models\editorSubmission;
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
      $shoot_lots_is = $shoot_lots = $shoot_lots_query->get()->toArray();

      $shoot_wrc_data = array();
      $shoot_sku_data = array();
      $shoot_edited_images = [];
      foreach ($shoot_lots as $key => $val) {
        $LotTimelineData = Lots::LotTimeline($val['lot_id']);
        $lot_detail = $LotTimelineData['lot_detail']; 
        $wrc_detail = $LotTimelineData['wrc_detail'];
        $wrc_detail_new = [];
        foreach ($wrc_detail as $wrc_key => $wrc_row) {
          // Soot sku Datas.
          $sku_info_query = Skus::where('wrc_id', $wrc_row['wrc_id'])->leftJoin('editor_submission', 'editor_submission.sku_id', '=', 'sku.id')->orderby('sku.id' , 'ASC')->orderby('editor_submission.filename' , 'DESC')->groupBy('sku.id');
          $sku_info_count = $sku_info_query->count();
          $sku_info = $sku_info_query->select(
            'editor_submission.adaptation',
            'editor_submission.filename',
            'editor_submission.created_at as submission_created_at',
            DB::raw("COUNT(editor_submission.id) as file_count"),
            DB::raw("GROUP_CONCAT(editor_submission.filename) as filename_list"),
            DB::raw("GROUP_CONCAT(editor_submission.adaptation) as adaptation_list"),
            'sku.id as sku_id',
            'sku.*',
            'sku.created_at as sku_created_at'
          )->get()->toArray();
          $lot_number = $wrc_row['lot_number'];
          $wrc_number = $wrc_row['wrc_number'];
          foreach ($sku_info as $sky_key => $sku_row) {
            $file_path = '';
            $file_count = $sku_row['file_count'];
            if($file_count > 0){
              $filename_list = $sku_row['filename_list'];
              $filename_list_arr = explode(',',$filename_list);

              foreach ($filename_list_arr as $img_key => $filename) {
                if($file_path != ""){
                  break;
                }  
                $adaptation = $sku_row['adaptation'];
                $sku_code = $sku_row['sku_code'];
                $path=  "edited_img_directory/". date('Y', strtotime($sku_row['submission_created_at'])) . "/" . date('M', strtotime($sku_row['submission_created_at'])) . "/" . $lot_number."/" . $wrc_number."/" . $adaptation. "/" .$sku_code. "/" . $filename;

                if(file_exists($path)){
                  $file_path = $path;
                }
              }
            }
            $sku_info[$sky_key]['file_path'] = $file_path;
            $sku_info[$sky_key]['wrc_info'] = $wrc_row;
            if($wrc_row['id'] == '3744'){
              // dd($sku_row, $filename_list_arr, $wrc_row );
            }
            array_push($shoot_sku_data, $sku_info[$sky_key]);
          }

          $sku_ids = array_column($sku_info , 'id');
          $sku_codes_with_id = array_column($sku_info , 'sku_code', 'id');
          $upload_raw_info = uploadraw::whereIn('sku_id', $sku_ids)->get()->toArray();
          // Edited uploaded images
          $editor_qc_image_query = editorSubmission::whereIn('sku_id', $sku_ids)->where('editor_submission.qc' , '=' , '1')->select('*')->orderby('editor_submission.created_at' , 'ASC');
          $editor_qc_image_count = $editor_qc_image_query->count();
          $editor_qc_image_info = [];

          $lot_number = $wrc_row['lot_number'];
          $wrc_number = $wrc_row['wrc_number'];
          if($editor_qc_image_count > 0){
            $editor_qc_image_info = $editor_qc_image_query->get()->toArray();
            foreach ($editor_qc_image_info as $img_key => $img_row) {
              $sku_code = $sku_codes_with_id[$img_row['sku_id']];
              $adaptation = $img_row['adaptation'];
              $path=  "edited_img_directory/". date('Y', strtotime($img_row['created_at'])) . "/" . date('M', strtotime($img_row['created_at'])) . "/" . $lot_number."/" . $wrc_number."/" . $adaptation. "/" .$sku_code. "/" . $img_row['filename'];
              if(file_exists($path)){
                $editor_qc_image_info[$img_key]['file_path'] = $path;
                array_push($shoot_edited_images , $editor_qc_image_info[$img_key]);
              }else{
                unset($editor_qc_image_info[$img_key]);
              }
            }
          }

          $wrc_detail[$wrc_key]['sku_info_count'] = $sku_info_count;
          $wrc_detail[$wrc_key]['sku_info'] = $sku_info;
          $wrc_detail[$wrc_key]['upload_raw_info'] = $upload_raw_info;
          $wrc_detail[$wrc_key]['editor_qc_image_info'] = $editor_qc_image_info;
          array_push($shoot_wrc_data, $wrc_detail[$wrc_key]);
        }
        $shoot_lots[$key] = $lot_detail[0];
        $shoot_lots[$key]['service'] = 'SHOOT';
        $shoot_lots[$key]['wrc_detail'] = $wrc_detail;
      }

    /****************************** Editing Data ******************************/

      $editor_lots = EditorLotModel::orderBy('editor_lots.id', $sortByIs)
        ->leftJoin('editing_wrcs', 'editing_wrcs.lot_id', 'editor_lots.id')
        ->select('editor_lots.id','editor_lots.id as lot_id', 'editor_lots.created_at', 'editor_lots.lot_number', 'editing_wrcs.id as wrc_id')
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
        foreach ($wrc_detail as $wrc_key => $wrc_row) {
          
          $uploaded_img_file_path = $wrc_row['uploaded_img_file_path'];
          $wrc_id_arr = explode(',', $wrc_row['wrc_id']);
          $editing_uploaded_images = EditingUploadedImages::whereIn('editing_uploaded_images.wrc_id', $wrc_id_arr)->get()->toArray();
          $file_path = "";

          foreach ($editing_uploaded_images as $key_is => $item) {
            if($file_path != ""){
              break;
            }
            $path= $item['file_path']. $item['filename'];
            $path1 = $uploaded_img_file_path. $item['filename'];
            if(file_exists($path)){
              $file_path = $path;
            }else if(file_exists($path1)){
              $file_path = $path1;
            }
          }
          $wrc_detail[$wrc_key]['file_path']= $file_path;
          array_push($editing_wrc_data , $wrc_detail[$wrc_key]);
        }
        $editor_lots[$key]['wrc_detail'] = $wrc_detail;

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
      $creative_wrc_data = array();
      foreach ($creative_lots as $key => $val) {
        $LotTimelineData = CreatLots::LotTimeline($val['id']);
        $lot_detail = $LotTimelineData['lot_detail']; 
        $wrc_detail = $LotTimelineData['wrc_detail']; 
        foreach ($wrc_detail as $wrc_key => $wrc_row) {
          array_push($creative_wrc_data , $wrc_detail[$wrc_key]);
        }
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

      $catalog_wrc_data = array();
      foreach ($lots_catalog as $key => $val) {
        $LotTimelineData = LotsCatalog::LotTimeline($val['id']);
        $lot_detail = $LotTimelineData['lot_detail']; 
        $wrc_detail = $LotTimelineData['wrc_detail']; 
        foreach ($wrc_detail as $wrc_key => $wrc_row) {
          array_push($catalog_wrc_data , $wrc_detail[$wrc_key]);
        }
        $lots_catalog[$key] = $lot_detail[0];
        $lots_catalog[$key]['wrc_detail'] = $wrc_detail;
      }
     // dd($lots_catalog);

    /****************************** End Data ******************************/
    
    $shoot_data = array(
      'lots' => $shoot_lots,
      'wrc' => $shoot_wrc_data,
      'shoot_edited_images' => $shoot_edited_images,
      'sku' => $shoot_sku_data
    );
    $editing_data = array(
      'lots' => $editor_lots,
      'wrc' => $editing_wrc_data
    );
    $creative_Data = array(
      'lots' => $creative_lots,
      'wrc' => $creative_wrc_data
    );
    $catalog_data = array(
      'lots' => $lots_catalog,
      'wrc' => $catalog_wrc_data
    );
    
    // Store the data arrays in a session or cache
    Session::put('shoot_data', $shoot_data);
    Session::put('editing_data', $editing_data);
    Session::put('creative_Data', $creative_Data);
    Session::put('catalog_data', $catalog_data);
    // dd($shoot_lots ,$editor_lots , $shoot_lots , $lots_catalog);

  }
}
