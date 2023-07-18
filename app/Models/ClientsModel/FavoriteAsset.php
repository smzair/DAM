<?php

namespace App\Models\ClientsModel;

use App\Http\Controllers\ClientsControllers\ClientCommonController;
use App\Models\CatalogSubmission;
use App\Models\CatalogWrcBatch;
use App\Models\CreativeSubmission;
use App\Models\CreativeWrcBatch;
use App\Models\CreatLots;
use App\Models\EditingRawImgUpload;
use App\Models\EditingSubmission;
use App\Models\EditingUploadedImages;
use App\Models\EditingWrc;
use App\Models\EditorLotModel;
use App\Models\editorSubmission;
use App\Models\Lots;
use App\Models\LotsCatalog;
use App\Models\Skus;
use App\Models\submissions;
use App\Models\uploadraw;
use App\Models\Wrc;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteAsset extends Model
{
  use HasFactory;
  protected $table = 'favorite_assets';
  protected $fillable = ['user_id', 'brand_id', 'lot_id', 'wrc_id', 'service', 'module', 'type', 'other_data_id', 'other_data', 'created_by'];

  // Shoot Images
  public static function shoot_images($service_array , $type = '' , $sortByIs = 'DESC')
  {

    $user_data = Auth::user();
    $parent_client_id = $user_id = $user_data->id;
    $roledata = getUsersRole($user_id);
    if ($roledata != null) {
      $role_name = $roledata->role_name;
    }

    if ($role_name == 'Sub Client') {
      $parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
      $parent_client_id = $parent_user_data->parent_client_id;
    }
    $brand_arr = DB::table('brands_user')->where('user_id', $user_id)->get()->pluck('brand_id')->toArray();

    $shoot_raw_query = FavoriteAsset::where('service', $service_array[0])->where('module', 'image')->whereIn('favorite_assets.brand_id', $brand_arr)->where('favorite_assets.user_id', $parent_client_id)->orderBy('favorite_assets.created_at', $sortByIs);

    $shoot_raw_images_count = $shoot_raw_query->count();
    $shoot_images = $shoot_raw_query->get()->toArray();   
    if ($shoot_raw_images_count > 0) {
      foreach ($shoot_images as $img_key => $image_row) {
        $type = $image_row['type'];
        $other_data_id = $image_row['other_data_id'];
        $other_data = json_decode($image_row['other_data'],true);
        $filename = $other_data['filename'];
        $sku_id = $other_data['sku_id'];
        $path = "";
        if($type == 'Raw'){
          $sku_info_query = Skus::
          leftJoin('wrc', 'wrc.id', '=', 'sku.wrc_id')->
          leftJoin('lots', 'wrc.lot_id', '=', 'lots.id')->
          leftJoin('uploadraw', 'uploadraw.sku_id', '=', 'sku.id')->
          where('sku.id', '=' , $sku_id)->where('uploadraw.id', '=' , $other_data_id)->where('sku.status', '=' , '1')->
          select(
            'sku.id as sku_id',
            'sku.sku_code',
            'sku.status',
            'sku.wrc_id',
            'sku.created_at as sku_created_at',
            'wrc.wrc_id as wrc_number','wrc.lot_id' ,'lots.lot_id as lot_number',
            'uploadraw.id as image_id',
            'uploadraw.filename' ,
            'uploadraw.created_at as created_at'
          );
          $skus_count = $sku_info_query->count();
          $skus_files = $sku_info_query->get()->toArray();
          
          if($skus_count > 0){
            $row = $skus_files[0];
            $path=  "raw_img_directory/". date('Y', strtotime($row['created_at'])) . "/" . date('M', strtotime($row['created_at'])) . "/" . $row['lot_number'] . "/" . $row['wrc_number']. "/" .$row['sku_code']. "/" . $row['filename'] ;
          }
        }else{
          $sku_info_query = Skus::
          leftJoin('wrc', 'wrc.id', '=', 'sku.wrc_id')->
          leftJoin('lots', 'wrc.lot_id', '=', 'lots.id')->
          leftJoin('editor_submission', 'editor_submission.sku_id', '=', 'sku.id')->
          where('sku.id', '=' , $sku_id)->where('editor_submission.id', '=' , $other_data_id)->where('sku.status', '=' , '1')->where('editor_submission.qc', '=' , "1")->
          select(
            'sku.id as sku_id',
            'sku.sku_code',
            'sku.status',
            'sku.wrc_id',
            'sku.created_at as sku_created_at',
            'wrc.wrc_id as wrc_number','wrc.lot_id' ,'lots.lot_id as lot_number',
            'editor_submission.id as image_id',
            'editor_submission.adaptation' ,
            'editor_submission.filename' ,
            'editor_submission.created_at as created_at'
          );
          $skus_count = $sku_info_query->count();
          $skus_files = $sku_info_query->get()->toArray();
          if($skus_count > 0){
            $row = $skus_files[0];
            $path=  "edited_img_directory/". date('Y', strtotime($row['created_at'])) . "/" . date('M', strtotime($row['created_at'])) . "/" . $row['lot_number'] . "/" . $row['wrc_number']. "/" . $row['adaptation']. "/" .$row['sku_code']. "/" . $row['filename'] ;
          }
        }
        $shoot_images[$img_key]['img_src'] = $path;
        $shoot_images[$img_key]['img_row'] = $row;
      }
    }
    return $shoot_images;
  }

  // Editing Images
  public static function editing_images($service_array, $type = '' , $sortByIs = 'DESC')
  {
    $user_data = Auth::user();
    $parent_client_id = $user_id = $user_data->id;
    $roledata = getUsersRole($user_id);

    if ($roledata != null) {
      $role_name = $roledata->role_name;
    }

    if ($role_name == 'Sub Client') {
      $parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
      $parent_client_id = $parent_user_data->parent_client_id;
    }
    $brand_arr = DB::table('brands_user')->where('user_id', $user_id)->get()->pluck('brand_id')->toArray();

    $editing_images = array();
      $raw_image_query = FavoriteAsset::where('service', $service_array[1])->where('module', 'image')->whereIn('favorite_assets.brand_id', $brand_arr)->where('favorite_assets.user_id', $parent_client_id)->orderBy('favorite_assets.created_at', $sortByIs);
      if ($type != '') {
        $raw_image_query = $raw_image_query->where('type', $type);
      }
      $raw_images_count = $raw_image_query->count();

      if ($raw_images_count > 0) {
        $editing_images = $raw_image_query->get()->toArray();

        foreach ($editing_images as $key => $row) {
          $type = $row['type'];
          if ($type == 'Raw') {
            $Upload_images = EditingRawImgUpload::where('id', $row['other_data_id'])->first()->toArray();
          } else {
            $Upload_images = EditingUploadedImages::where('id', $row['other_data_id'])->first()->toArray();
          }
          $editing_images[$key]['images'] = $Upload_images;
        }
      }
    return $editing_images;
  }



  public static function shoot_lots($lot_id)
  {

    $lots_query_cataloging = Lots::leftJoin('wrc', 'wrc.lot_id', '=', 'lots.id')->where('lots.id', '=', $lot_id)->whereNotNull('wrc.id')->
    leftjoin('brands' , 'brands.id' , 'lots.brand_id')->select(
      'lots.id as lot_id',
      'lots.lot_id as lot_number',
      'lots.s_type as s_type',
      'lots.created_at as lot_created_at',
      'wrc.id as wrc_id',
      'wrc.wrc_id as wrc_number',
      DB::raw("GROUP_CONCAT(wrc.id) as wrc_ids"),
      DB::raw("GROUP_CONCAT(wrc.wrc_id) as wrc_numbers"),
      DB::raw("COUNT(wrc.id) as wrc_counts"),
      'brands.name as brand_name',
      'brands.short_name as brand_short_name'
    )->groupby('lots.id');
    $shoot_lots = $lots_query_cataloging->get()->toArray();

    $shoot_lots_data = array();
    $skus_sku_id_arr = $skus_sku_code_arr = array();
    foreach ($shoot_lots as $key => $row) {
      $wrc_id_arr = explode(',', $row['wrc_ids']);
      $wrc_counts = $row['wrc_counts'];
      $lot_submission_query = submissions::whereIn('submission.wrc_id', $wrc_id_arr)->select('id as submission_id', 'submission.submission_date');
      $lot_submission_count = $lot_submission_query->count();

      if ($wrc_counts == $lot_submission_count) {
        $submission_array = $lot_submission_query->orderby('submission.created_at', 'DESC')->get()->toArray();

        $sku_info_query = Skus::whereIn('sku.wrc_id', $wrc_id_arr)->where('status', 1)->select('id as sku_id', 'sku_code', 'status');
        $skus_count = $sku_info_query->count();
        $skus_array = $sku_info_query->get()->toArray();

        $file_path = "";
        if ($skus_count > 0) {
          $lot_number = $row['lot_number'];
          $wrc_number = $row['wrc_number'];
          $skus_sku_id_arr = array_column($skus_array, 'sku_id');
          $skus_sku_code_arr = array_column($skus_array, 'sku_code');
          $editor_Submission_data = editorSubmission::wherein('sku_id', $skus_sku_id_arr)->where('qc', '=', '1')->get()->toArray();

          $upload_raw = uploadraw::whereIn('sku_id', $skus_sku_id_arr)->count();

          foreach ($editor_Submission_data as $key_is => $item) {
            if ($file_path != "") {
              break;
            }
            $adaptation = $item['adaptation'];
            $sku_id = $item['sku_id'];
            $sku_code = $skus_sku_code_arr[array_search($sku_id, $skus_sku_id_arr)];

            $path =  "edited_img_directory/" . date('Y', strtotime($item['created_at'])) . "/" . date('M', strtotime($item['created_at'])) . "/" . $lot_number . "/" . $wrc_number . "/" . $adaptation . "/" . $sku_code . "/" . $item['filename'];
            if (file_exists($path)) {
              $file_path = $path;
            }
          }
        }

        array_push($shoot_lots_data, array(
          'lot_id' => $row['lot_id'],
          'brand_name' => $row['brand_name'],
          'lot_number' => $row['lot_number'],
          'lot_created_at' => $row['lot_created_at'],
          'inward_qty' => $skus_count,
          'skus_count' => $skus_count,
          'file_path' => $file_path,
          'raw_images' => $upload_raw,
          'edited_images' => count($editor_Submission_data),
          's_type' => $row['s_type'],
          'wrc_numbers' => $row['wrc_numbers'],
          'skus' => $skus_array,
          'submission_date' => $submission_array[0]['submission_date'],
          'submissions' => $submission_array
        ));
      }
    }

    return $shoot_lots_data;
  }

  // Editing Lots Data
  public static function editing_lots($lot_id)
  {
    $lots_query_cataloging = EditorLotModel::leftJoin('editing_wrcs', 'editing_wrcs.lot_id', '=', 'editor_lots.id')->where('editor_lots.id', '=', $lot_id)->whereNotNull('editing_wrcs.id')->select(
        'editor_lots.id as lot_id',
        'editor_lots.lot_number',
        'editor_lots.created_at as lot_created_at',
        'editing_wrcs.id as wrc_id',
        'editing_wrcs.wrc_number',
        'editing_wrcs.uploaded_img_file_path',
        DB::raw("GROUP_CONCAT(editing_wrcs.id) as wrc_ids"),
        DB::raw("GROUP_CONCAT(editing_wrcs.wrc_number) as wrc_numbers"),
        DB::raw("SUM(editing_wrcs.imgQty) as tot_imgqty"),
        DB::raw("SUM(editing_wrcs.uploaded_img_qty) as tot_uploaded_img_qty"),
        DB::raw("COUNT(editing_wrcs.id) as wrc_counts"),
      )->groupby('editor_lots.id');

    $editor_lots = $lots_query_cataloging->get()->toArray();

    $editor_lots_data = array();
    foreach ($editor_lots as $key => $row) {
      $wrc_id_arr = explode(',', $row['wrc_ids']);
      $wrc_counts = $row['wrc_counts'];
      $uploaded_img_file_path = $row['uploaded_img_file_path'];
      $lot_submission_query = EditingSubmission::whereIn('editing_submissions.wrc_id', $wrc_id_arr)->select('id as submission_id', 'editing_submissions.submission_date');
      $lot_submission_count = $lot_submission_query->count();

      if ($wrc_counts == $lot_submission_count) {
        $submission_array = $lot_submission_query->orderby('editing_submissions.created_at', 'DESC')->get()->toArray();

        $editing_uploaded_images = EditingUploadedImages::whereIn('editing_uploaded_images.wrc_id', $wrc_id_arr)->get()->toArray();
        $file_path = "";

        foreach ($editing_uploaded_images as $key_is => $item) {
          if ($file_path != "") {
            break;
          }
          $path = $item['file_path'] . $item['filename'];
          $path1 = $uploaded_img_file_path . $item['filename'];
          if (file_exists($path)) {
            $file_path = $path;
          } else if (file_exists($path1)) {
            $file_path = $path1;
          }
        }
        array_push($editor_lots_data, array(
          'lot_id' => $row['lot_id'],
          'lot_number' => $row['lot_number'],
          'wrc_numbers' => $row['wrc_numbers'],
          'lot_created_at' => $row['lot_created_at'],
          'inward_qty' => $row['tot_uploaded_img_qty'],
          'tot_imgqty' => $row['tot_imgqty'],
          'submission_date' => $submission_array[0]['submission_date'],
          'file_path' => $file_path,
          'submissions' => $submission_array
        ));
      }
    }
    return $editor_lots_data;
  }

  // Caytaloging Lots Data
  public static function cataloging_lots($lot_id)
  {
		$catalog_lots_query = LotsCatalog::leftjoin('catlog_wrc', 'catlog_wrc.lot_id', 'lots_catalog.id')->where('lots_catalog.id', '=',$lot_id);
		$catalog_lots_query = $catalog_lots_query->select(
			'catlog_wrc.lot_id',
			DB::raw('SUM(catlog_wrc.sku_qty) AS inward_qty'),
			DB::raw('GROUP_CONCAT(catlog_wrc.id) as wrc_ids'),
			DB::raw('GROUP_CONCAT(CONCAT(" ",`catlog_wrc`.`wrc_number`)) as wrc_numbers'),
			'lots_catalog.id',
			'lots_catalog.user_id',
			'lots_catalog.brand_id',
			'lots_catalog.lot_number',
			'lots_catalog.created_at as lot_created_at'
		);
		$catalog_lots = $catalog_lots_query->groupBy('lots_catalog.id');
		$catalog_lots = $catalog_lots_query->get()->toArray();

		foreach ($catalog_lots as $key => $row) {
			$wrc_ids = $row['wrc_ids'];
			$wrc_ids = $row['wrc_ids'];
			$submission_date = "";
			if($wrc_ids != '' && $wrc_ids != null){
				$wrc_id_arr = explode(',',$wrc_ids);

				$catalog_wrc_batches_query = CatalogWrcBatch::wherein('wrc_id', $wrc_id_arr)->orderbydesc('created_at');
				$catalog_wrc_batches_count = $catalog_wrc_batches_query->count();
				
				$catalog_submissions_query = CatalogSubmission::wherein('wrc_id', $wrc_id_arr)->orderbydesc('created_at');
				$catalog_submissions_count = $catalog_submissions_query->count();
				
				if($catalog_wrc_batches_count == $catalog_submissions_count && $catalog_wrc_batches_count > 0){
					$submission_data = $catalog_submissions_query->get()->toArray();
					if($catalog_submissions_count > 0){
						$catalog_submissions = $catalog_submissions_query->first()->toArray();
						$submission_date = $catalog_submissions['submission_date'];
					}
				}
			}
			$catalog_lots[$key]['submission_date'] = $submission_date;
		}
		$catalog_lots_data = $catalog_lots;
    return $catalog_lots_data;
  }

  // Caytaloging Lots Data
  public static function creative_lots($lot_id)
  {
		$lots_query = CreatLots::leftjoin('creative_wrc', 'creative_wrc.lot_id', 'creative_lots.id')->where('creative_lots.id', '=',$lot_id);
		$lots_query = $lots_query->select(
			'creative_wrc.lot_id',
			DB::raw('CASE WHEN creative_wrc.sku_required = 1 THEN creative_wrc.sku_count ELSE creative_wrc.order_qty END AS inward_quantity'),
			DB::raw('SUM(CASE WHEN creative_wrc.sku_required = 1 THEN creative_wrc.sku_count ELSE creative_wrc.order_qty END) AS inward_qty'),
			DB::raw('GROUP_CONCAT(creative_wrc.id) as wrc_ids'),
			DB::raw('GROUP_CONCAT(creative_wrc.sku_required) as sku_requireds'),
			DB::raw('GROUP_CONCAT(CONCAT(" ",`creative_wrc`.`wrc_number`)) as wrc_numbers'),
			'creative_lots.id',
			'creative_lots.user_id',
			'creative_lots.brand_id',
			'creative_lots.lot_number',
			'creative_lots.created_at as lot_created_at'
		);
		$lots = $lots_query->groupBy('creative_lots.id');
		$lots = $lots_query->get()->toArray();

		foreach ($lots as $key => $row) {
			$wrc_ids = $row['wrc_ids'];
			$sku_requireds = $row['sku_requireds'];
			$wrc_ids = $row['wrc_ids'];
			$submission_date = "";
			if($wrc_ids != '' && $wrc_ids != null){
				$wrc_id_arr = explode(',',$wrc_ids);

				$creative_wrc_batch_query = CreativeWrcBatch::wherein('wrc_id', $wrc_id_arr)->orderbydesc('created_at');
				$creative_wrc_batch_count = $creative_wrc_batch_query->count();
				
				$creative_submissions_query = CreativeSubmission::wherein('wrc_id', $wrc_id_arr)->orderbydesc('created_at');
				$creative_submissions_count = $creative_submissions_query->count();
				
				if($creative_wrc_batch_count == $creative_submissions_count && $creative_wrc_batch_count > 0){
					if($creative_submissions_count > 0){
						$creative_submissions = $creative_submissions_query->first()->toArray();
						$submission_date = $creative_submissions['submission_date'];
					}
				}
			}
			$lots[$key]['submission_date'] = $submission_date;
		}
		$creative_lots_data = $lots;
    return $creative_lots_data;
  }

  // sku Data 
  public static function sku_data($sku_id , $other_data, $skus_row){
    $sku_info_query = Skus::leftJoin('wrc', 'wrc.id', '=', 'sku.wrc_id')->
    where('sku.id', '=' , $sku_id)->
    where('sku.status', '=' , '1')->
    select('sku.id as sku_id', 'sku.sku_code','sku.status', 'sku.wrc_id', 'wrc.wrc_id as wrc_number' , 'sku.created_at as sku_created_at');
    $raw_skus_data = $sku_info_query->get()->toArray();

    $wrc_id = $skus_row['wrc_id'];
    $lot_data_arr = Lots::leftJoin('wrc','wrc.lot_id', '=' , 'lots.id')->whereNotNull('lots.id')->
      where('wrc.id', '=', $wrc_id)->get(['lots.lot_id', 'lots.created_at' , 'wrc.wrc_id as wrc_number'])->toArray();
    $lot_data = $lot_data_arr[0];
    $lot_no = $lot_data['lot_id'];
    $wrc_number = $lot_data['wrc_number'];

    $type = $other_data['type'];
   
    $raw_skus = array();
    foreach ($raw_skus_data as $key => $row) {
      $sku_id = $row['sku_id'];
      $sku_code = $row['sku_code'];
      $wrc_id = $row['wrc_id'];

      if($type == 'Raw'){
        $upload_raw_query = uploadraw::where('sku_id', $row['sku_id']);
        $upload_raw_count = $upload_raw_query->count();
        $upload_data = $upload_raw_query->get()->toArray();        
      }else{
        $adaptation = $other_data['adaptation'];
        $upload_data = editorSubmission::where('sku_id' , $sku_id)->where('qc','=','1')->where('adaptation','=',$adaptation)->get()->toArray();
      }
      $file_path = "";

      foreach ($upload_data as $key_is => $item) {
        $created_at = $item['created_at'];
        $filename = $item['filename'];
        if($file_path != ""){
          break;
        }

        if($type == 'Edited'){
          $path=  "edited_img_directory/". date('Y', strtotime($item['created_at'])) . "/" . date('M', strtotime($item['created_at'])) . "/" . $lot_no."/" . $wrc_number."/" . $adaptation. "/" .$sku_code. "/" . $item['filename'];

        }else{
          $path =  "raw_img_directory/" . date('Y', strtotime($created_at)) . "/" . date('M', strtotime($created_at)) . "/" . $lot_no."/" . $wrc_number."/" . $sku_code."/" . $filename;
        }

        if(file_exists($path)){
          $file_path = $path;
        }
      }
      $raw_skus_data[$key]['file_path'] = $file_path;
    }
    return $raw_skus_data[0];
  }

  // Wrc Data 
  public static function wrc_data($wrc_row){
    $wrc_id = $wrc_row['wrc_id'];
    $lot_id = $wrc_row['lot_id'];
    $service = $wrc_row['service'];
    $wrc_data = array();

    if($service == 'SHOOT'){
      $wrc_data = Wrc::leftJoin('lots', 'wrc.lot_id', '=', 'lots.id')->leftJoin('commercial', 'commercial.id', 'wrc.commercial_id')->where('wrc.lot_id',$lot_id)->where('wrc.id',$wrc_id)->select(
        'wrc.id as wrc_id',
        'wrc.wrc_id as wrc_number',
        'wrc.lot_id',
        'wrc.created_at as wrc_created_at',
        'lots.lot_id as lot_number',
        'commercial.product_category',
        'commercial.type_of_shoot',
        'commercial.type_of_clothing',
        'commercial.gender',
        'commercial.adaptation_1 as primary_adaptation',
        'commercial.adaptation_1',
        'commercial.adaptation_2',
        'commercial.adaptation_3',
        'commercial.adaptation_4',
        'commercial.adaptation_5',
        'commercial.commercial_value_per_sku'
      )->get()->toArray();
      foreach ($wrc_data as $key => $value) {
        // adaptation data
        $adaptation_arr = array();
        for($i = 1; $i <= 5 ; $i++){
          $adaptation_key = 'adaptation_'.$i;
          if($value[$adaptation_key] != 'NA' && $value[$adaptation_key] != null){
              array_push($adaptation_arr , $value[$adaptation_key]);
          }
          unset($wrc_data[$key][$adaptation_key]);
        }
        // Setting Svg into addaption
        $adaptation_svg_data_arr = array();

        $clientCommonController = new ClientCommonController();
        if(count($adaptation_arr) > 0){
            $adaptation_svg_data_arr = $clientCommonController->adaptation_svg_data_arr($adaptation_arr);
        }
        $wrc_data[$key]['adaptation_svg_data_arr'] = $adaptation_svg_data_arr;
        $wrc_data[$key]['adaptation'] = $adaptation_arr;

        $lot_number = $value['lot_number'];
        $sku_info_query = Skus::where('wrc_id', $value['wrc_id'])->where('status', 1)->select('id as sku_id', 'sku_code', 'status');
        $skus_count = $sku_info_query->count();
        $skus_array = $sku_info_query->get()->toArray();
        $file_path = "";
        if($skus_count > 0){
          $lot_number = $value['lot_number'];
          $wrc_number = $value['wrc_number'];
          $skus_sku_id_arr = array_column($skus_array , 'sku_id');
          $skus_sku_code_arr = array_column($skus_array , 'sku_code');
          $editor_Submission_data = editorSubmission::wherein('sku_id' , $skus_sku_id_arr)->where('qc','=','1')->get()->toArray();
  
          foreach ($editor_Submission_data as $key_is => $item) {
            if($file_path != ""){
              break;
            }            
            $adaptation = $item['adaptation'];
            $sku_id = $item['sku_id'];
            $sku_code = $skus_sku_code_arr[array_search($sku_id ,$skus_sku_id_arr)];
  
            $path=  "edited_img_directory/". date('Y', strtotime($item['created_at'])) . "/" . date('M', strtotime($item['created_at'])) . "/" . $lot_number."/" . $wrc_number."/" . $adaptation. "/" .$sku_code. "/" . $item['filename'];
            if(file_exists($path)){
              $file_path = $path;
            }
          }
        }
        $wrc_data[$key]['file_path'] = $file_path;
      }
    }else{
      $wrc_data = EditingWrc::leftJoin('editor_lots', 'editing_wrcs.lot_id', '=', 'editor_lots.id')->where('editing_wrcs.id',$wrc_id)->where('editing_wrcs.lot_id',$lot_id)->select(
        'editing_wrcs.id as wrc_id',
        'editing_wrcs.wrc_number',
        'editing_wrcs.lot_id',
        'editing_wrcs.uploaded_img_file_path',
        'editing_wrcs.created_at as wrc_created_at',
        'editor_lots.lot_number',
      )->get()->toArray();  
      
      foreach ($wrc_data as $key => $row) {
        $uploaded_img_file_path = $row['uploaded_img_file_path'];
        $wrc_id_arr = explode(',', $row['wrc_id']);
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
        $wrc_data[$key]['file_path'] = $file_path;
        $wrc_data[$key]['filename'] = $item['filename'];
      }
    }
    return $wrc_data;
  }
}
