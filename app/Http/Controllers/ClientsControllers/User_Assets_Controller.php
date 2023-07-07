<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ClientsControllers\ClientCommonController;
use App\Models\EditingSubmission;
use App\Models\EditingUploadedImages;
use App\Models\EditingWrc;
use App\Models\EditorLotModel;
use App\Models\editorSubmission;
use App\Models\Lots;
use App\Models\Skus;
use App\Models\submissions;
use App\Models\uploadraw;
use App\Models\Wrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User_Assets_Controller extends Controller
{
  public function your_assets_files($service = 'Shoot' ,$sortBy = 'latest')
  {
    $user_data = Auth::user();
    if ($user_data->dam_enable != 1) {
      request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
      return view('clients.ClientUserManagement.dam_not_enable');
      // return redirect()->route('home_new');
    }

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

    // Sorting Changes
    if ($sortBy == 'oldest' || $sortBy == 'old') {
      $sortByIs = 'ASC';
    } else {
      $sortByIs = 'DESC';
    }

    if($service == 'PostProduction'){
      $service_is = 'PostProduction';
    }else{
      $service_is = 'Shoot';
    }

    /** Shoot lots **/
    $shoot_lots_data = array();
    if($service_is == 'Shoot'){
      $lots_query_cataloging = Lots::leftJoin('wrc', 'wrc.lot_id', '=', 'lots.id')->whereIn('lots.brand_id', $brand_arr)->whereNotNull('wrc.id')->
      leftjoin('brands' , 'brands.id' , 'lots.brand_id')->
        select(
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
        )->groupby('lots.id')->orderBy('lots.created_at', $sortByIs);
      $shoot_lots = $lots_query_cataloging->where('lots.user_id', $parent_client_id);
      $shoot_lots = $lots_query_cataloging->get()->toArray();
  
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
          if($skus_count > 0){
            $lot_number = $row['lot_number'];
            $wrc_number = $row['wrc_number'];
            $skus_sku_id_arr = array_column($skus_array , 'sku_id');
            $skus_sku_code_arr = array_column($skus_array , 'sku_code');
            $editor_Submission_data = editorSubmission::wherein('sku_id' , $skus_sku_id_arr)->where('qc','=','1')->get()->toArray();
  
            $upload_raw = uploadraw::whereIn('sku_id', $skus_sku_id_arr)->count();
  
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
    }

    // dd($shoot_lots_data);

    /** Editing lots **/
    $editor_lots_data = array();
    if($service_is == 'PostProduction'){
      $lots_query_cataloging = EditorLotModel::leftJoin('editing_wrcs', 'editing_wrcs.lot_id', '=', 'editor_lots.id')
        ->whereIn('editor_lots.brand_id', $brand_arr)->whereNotNull('editing_wrcs.id')->
        leftjoin('brands' , 'brands.id' , 'editor_lots.brand_id')->
        select(
          'editor_lots.id as lot_id',
          'editor_lots.lot_number',
          'editor_lots.created_at as lot_created_at',
          'editing_wrcs.id as wrc_id',
          'editing_wrcs.wrc_number',
          'editing_wrcs.uploaded_img_file_path',
          DB::raw("GROUP_CONCAT(editing_wrcs.id) as wrc_ids"),
          DB::raw("SUM(editing_wrcs.imgQty) as tot_imgqty"),
          DB::raw("SUM(editing_wrcs.uploaded_img_qty) as tot_uploaded_img_qty"),
          DB::raw("COUNT(editing_wrcs.id) as wrc_counts"),
          'brands.name as brand_name',
          'brands.short_name as brand_short_name'
        )->groupby('editor_lots.id');
  
      $editor_lots = $lots_query_cataloging->where('editor_lots.user_id', $parent_client_id)->orderBy('editor_lots.created_at', $sortByIs);
      $editor_lots = $lots_query_cataloging->get()->toArray();
  
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
  
          array_push($editor_lots_data, array(
            'lot_id' => $row['lot_id'],
            'brand_name' => $row['brand_name'],
            'lot_number' => $row['lot_number'],
            'lot_created_at' => $row['lot_created_at'],
            'inward_qty' => $row['tot_uploaded_img_qty'],
            'tot_imgqty' => $row['tot_imgqty'],
            'submission_date' => $submission_array[0]['submission_date'],
            'file_path' => $file_path,
            'submissions' => $submission_array
          ));
        }
      }
    }
    // dd($editor_lots_data,$shoot_lots_data , $shoot_lots);
    $other_data = array(
      'sortBy' => $sortBy,
      'service_is' => $service_is
    );

    return view('clients.ClientAssets.your_assets_files')->with('shoot_lots', $shoot_lots_data)->with('editor_lots', $editor_lots_data)->with('other_data',$other_data);
  }
  
  // Shoot wrc list
  public function your_assets_shoot_wrcs($lot_id){
    $user_data = Auth::user();
    if ($user_data->dam_enable != 1) {
      request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
      return view('clients.ClientUserManagement.dam_not_enable');
    }
    $wrc_data = Wrc::leftJoin('lots', 'wrc.lot_id', '=', 'lots.id')->leftJoin('commercial', 'commercial.id', 'wrc.commercial_id')->where('wrc.lot_id',$lot_id)->select(
      'wrc.id as wrc_id',
      'wrc.wrc_id as wrc_number',
      'wrc.lot_id',
      'wrc.created_at as wrc_created_at',
      'lots.lot_id as lot_number',
      'wrc.commercial_id',
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
      $lot_number = $value['lot_number'];
      // list of addapations.
      $adaptation_arr = array();
      for($i = 1; $i <= 5 ; $i++){
        $adaptation_key = 'adaptation_'.$i;
        if($value[$adaptation_key] != 'NA' && $value[$adaptation_key] != null){
          array_push($adaptation_arr , trim($value[$adaptation_key]));
        }
        unset($wrc_data[$key][$adaptation_key]);
      }

      // Setting Svg into addaption
      $adaptation_svg_data_arr = array();

      $clientCommonController = new ClientCommonController();
      if(count($adaptation_arr) > 0){
        $adaptation_svg_data_arr = $clientCommonController->adaptation_svg_data_arr($adaptation_arr);
      }

      $wrc_data[$key]['adaptation'] = $adaptation_arr;
      $wrc_data[$key]['adaptation_svg_data_arr'] = $adaptation_svg_data_arr;

      $sku_info_query = Skus::where('wrc_id', $value['wrc_id'])->where('status', 1)->select('id as sku_id', 'sku_code', 'status');
      $skus_count = $sku_info_query->count();
      $skus_array = $sku_info_query->get()->toArray();
      $file_path = "";
      if($skus_count > 0){
        $lot_number = $value['lot_number'];
        $wrc_number = $value['wrc_number'];
        $skus_sku_id_arr = array_column($skus_array , 'sku_id');
        $skus_sku_code_arr = array_column($skus_array , 'sku_code');
        $editor_Submission_data = editorSubmission::wherein('sku_id' , $skus_sku_id_arr)->where('qc','=','1')->where('filename', 'LIKE', '%_1.%')->get()->toArray();

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
    // dd($wrc_data);
    return view('clients.ClientAssets.your_assets_files_wrcs')->with('wrc_data', $wrc_data)->with('service_is' , 'Shoot');
      
  }

  // Editing wrc list
  public function your_assets_editing_wrcs($lot_id){
    $user_data = Auth::user();
    if ($user_data->dam_enable != 1) {
      request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
      return view('clients.ClientUserManagement.dam_not_enable');
    }
    
    $wrc_data = EditingWrc::leftJoin('editor_lots', 'editing_wrcs.lot_id', '=', 'editor_lots.id')->where('editing_wrcs.lot_id',$lot_id)->select(
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
    }
    // dd($wrc_data);
    return view('clients.ClientAssets.your_assets_files_wrcs')->with('wrc_data', $wrc_data)->with('service_is' , 'Editing');

  }

  // Shoot sku list based on wrc id
  public function your_assets_shoot_skus($wrc_id){ 
    $user_data = Auth::user();
    if ($user_data->dam_enable != 1) {
      request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
      return view('clients.ClientUserManagement.dam_not_enable');
    }
    $wrc_id = base64_decode($wrc_id);
    // Edited image skus and adapations
    $wrc_data = Wrc::leftJoin('commercial', 'wrc.commercial_id', '=', 'commercial.id')->leftJoin('lots', 'wrc.lot_id', '=', 'lots.id')->where('wrc.id',$wrc_id)->select(
      'wrc.id as wrc_id',
      'wrc.wrc_id as wrc_number',
      'wrc.lot_id',
      'wrc.created_at as wrc_created_at',
      'lots.lot_id as lot_number',
      'wrc.commercial_id',
      'commercial.adaptation_1',
      'commercial.adaptation_2',
      'commercial.adaptation_3',
      'commercial.adaptation_4',
      'commercial.adaptation_5',
      'commercial.specfic_adaptation',
    )->first()->toArray();

    $adaptation_arr = array();

    for($i = 1; $i <= 5 ; $i++){
      $adaptation_key = 'adaptation_'.$i;
      if($wrc_data[$adaptation_key] != 'NA' && $wrc_data[$adaptation_key] != null){
        $wrc_adaptation_arr = array(
          'adaptation' => $wrc_data[$adaptation_key], 
          'file_path' => "" 
        );
        array_push($adaptation_arr , $wrc_adaptation_arr);
      }else{
        unset($wrc_data[$adaptation_key]);
      }
    }
    $wrc_data['adaptation'] = $adaptation_arr;

    $only_adaptation = true;
    $raw_skus_data = [];
    if(!$only_adaptation){

      // Raw skus List based on Wrc id.
      $sku_info_query = Skus::leftJoin('wrc', 'wrc.id', '=', 'sku.wrc_id')->where('sku.wrc_id', '=' , $wrc_id)->where('sku.status', '=' , '1')->select('sku.id as sku_id', 'sku.sku_code','sku.status', 'sku.wrc_id', 'wrc.wrc_id as wrc_number' , 'sku.created_at as sku_created_at' );
      $skus_count = $sku_info_query->count();
      $raw_skus_data = $sku_info_query->get()->toArray();

      $skus_sku_id_arr = array_column($raw_skus_data , 'sku_id');
      $skus_sku_code_arr = array_column($raw_skus_data , 'sku_code');

      $lot_data_arr = Lots::leftJoin('wrc','wrc.lot_id', '=' , 'lots.id')->whereNotNull('lots.id')->
        where('wrc.id', '=', $wrc_id)->get(['lots.lot_id', 'lots.created_at' , 'wrc.wrc_id as wrc_number'])->toArray();
      $lot_data = $lot_data_arr[0];
      $lot_no = $lot_data['lot_id'];
      $wrc_number = $lot_data['wrc_number'];

      foreach ($wrc_data['adaptation'] as $adaptation_key => $adaptation_arr) {
        $adaptation = $adaptation_arr['adaptation'];
        $editor_Submission_data = editorSubmission::wherein('sku_id' , $skus_sku_id_arr)->where('qc','=','1')->where('adaptation','=',$adaptation)->get()->toArray();
        $file_path = "";

        foreach ($editor_Submission_data as $key_is => $item) {
          if($file_path != ""){
            break;
          }            
          $adaptation = $item['adaptation'];
          $sku_id = $item['sku_id'];
          $sku_code = $skus_sku_code_arr[array_search($sku_id ,$skus_sku_id_arr)];

          $path=  "edited_img_directory/". date('Y', strtotime($item['created_at'])) . "/" . date('M', strtotime($item['created_at'])) . "/" . $lot_no."/" . $wrc_number."/" . $adaptation. "/" .$sku_code. "/" . $item['filename'];
          if(file_exists($path)){
            $file_path = $path;
          }
        }
        $wrc_data['adaptation'][$adaptation_key]['file_path']= $file_path;
      }
      
      $raw_skus = array();
      foreach ($raw_skus_data as $key => $row) {
        $sku_id = $row['sku_id'];
        $sku_code = $row['sku_code'];
        $wrc_id = $row['wrc_id'];

        $upload_raw_query = uploadraw::where('sku_id', $row['sku_id']);
        $upload_raw_count = $upload_raw_query->count();
        $upload_raw_data = $upload_raw_query->get()->toArray();
        $file_path = "";

        if($upload_raw_count > 0){
          foreach ($upload_raw_data as $key_is => $item) {
            $created_at = $item['created_at'];
            $filename = $item['filename'];
            if($file_path != ""){
              break;
            }
            $path =  "raw_img_directory/" . date('Y', strtotime($created_at)) . "/" . date('M', strtotime($created_at)) . "/" . $lot_no."/" . $wrc_number."/" . $sku_code."/" . $filename;

            // dd($row , $lot_data , $upload_raw_data);
            if(file_exists($path)){
              $file_path = $path;
            }
          }
          // $row['uploadraw'] = $upload_raw_query->get()->toArray();
          array_push($raw_skus, $row);
        }
        $raw_skus_data[$key]['file_path'] = $file_path;
        $raw_skus_data[$key]['uploadraw'] = $upload_raw_data;
      }
    }
    // dd($wrc_data);
    // dd($raw_skus , $wrc_data , $raw_skus_data);
    return view('clients.ClientAssets.your_assets_files_skus')->with('wrc_data', $wrc_data)->with('raw_skus' , $raw_skus_data);
  }

  // Shoot sku list based on wrc id and adapdation
  public function your_assets_shoot_adaptation_skus($id , $adaptation){
    $user_data = Auth::user();
    if ($user_data->dam_enable != 1) {
      request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
      return view('clients.ClientUserManagement.dam_not_enable');
    }
    $wrc_id = base64_decode($id);
    $adaptation = base64_decode($adaptation);
    $sku_info_query = Skus::
    leftJoin('wrc', 'wrc.id', '=', 'sku.wrc_id')->
    leftJoin('lots', 'wrc.lot_id', '=', 'lots.id')->
    leftJoin('editor_submission', 'editor_submission.sku_id', '=', 'sku.id')->
    where('sku.wrc_id', '=' , $wrc_id)->where('sku.status', '=' , '1')->where('editor_submission.adaptation', '=' , "$adaptation")->where('editor_submission.qc', '=' , "1")->
    select('sku.id as sku_id', 'sku.sku_code','sku.status', 'sku.wrc_id', 'wrc.wrc_id as wrc_number','wrc.lot_id' ,'lots.lot_id as lot_number', 'editor_submission.id as submission_id', 'editor_submission.adaptation' , 'editor_submission.filename', DB::raw("COUNT(editor_submission.id) as file_count"), 'sku.created_at as sku_created_at' )->groupBy('sku.id');
    $skus_count = $sku_info_query->count();
    $raw_skus_data = $sku_info_query->get()->toArray();
    
    $file_path = "";
    foreach ($raw_skus_data as $key => $row) {
      $sku_id = $row['sku_id'];
      $adaptation = $row['adaptation'];
      $sku_code = $row['sku_code'];
      $lot_number = $row['lot_number'];
      $wrc_number = $row['wrc_number'];

      $editor_Submission_data = editorSubmission::where('sku_id' , $sku_id)->where('qc','=','1')->where('adaptation','=',$adaptation)->get()->toArray();
      $file_path = "";
      
      foreach ($editor_Submission_data as $key_is => $item) {
        if($file_path != ""){
          break;
        }            
        $path=  "edited_img_directory/". date('Y', strtotime($item['created_at'])) . "/" . date('M', strtotime($item['created_at'])) . "/" . $lot_number."/" . $wrc_number."/" . $adaptation. "/" .$sku_code. "/" . $item['filename'];
        if(file_exists($path)){
          $file_path = $path;
        }
      }
      $raw_skus_data[$key]['file_path'] = $file_path;
    }

    // dd(count($raw_skus_data) ,$raw_skus_data);
    return view('clients.ClientAssets.your_assets_shoot_adaptation_skus')->with('raw_skus' , $raw_skus_data);
  }

  public function your_assets_shoot_edited_images($sku_id){
    $user_data = Auth::user();
    if ($user_data->dam_enable != 1) {
      request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
      return view('clients.ClientUserManagement.dam_not_enable');
    }
    $sku_id = base64_decode($sku_id);
    $sku_info_query = Skus::
    leftJoin('wrc', 'wrc.id', '=', 'sku.wrc_id')->
    leftJoin('lots', 'wrc.lot_id', '=', 'lots.id')->
    leftJoin('editor_submission', 'editor_submission.sku_id', '=', 'sku.id')->
    where('sku.id', '=' , $sku_id)->where('sku.status', '=' , '1')->where('editor_submission.qc', '=' , "1")->
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
    $raw_skus_files = $sku_info_query->get()->toArray();
    // dd($raw_skus_files);
    return view('clients.ClientAssets.your_assets_shoot_skus_uploaded_files')->with('raw_skus_files' , $raw_skus_files)->with('service_is', 'edited');

  }

  public function your_assets_files_shoot_raw_images($sku_id){
    $user_data = Auth::user();
    if ($user_data->dam_enable != 1) {
      request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
      return view('clients.ClientUserManagement.dam_not_enable');
    }
    $sku_id = base64_decode($sku_id);
    $sku_info_query = Skus::
    leftJoin('wrc', 'wrc.id', '=', 'sku.wrc_id')->
    leftJoin('lots', 'wrc.lot_id', '=', 'lots.id')->
    leftJoin('uploadraw', 'uploadraw.sku_id', '=', 'sku.id')->
    where('sku.id', '=' , $sku_id)->where('sku.status', '=' , '1')->
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
    $raw_skus_files = $sku_info_query->get()->toArray();
    // dd($raw_skus_files);
    return view('clients.ClientAssets.your_assets_shoot_skus_uploaded_files')->with('raw_skus_files' , $raw_skus_files)->with('service_is', 'raw');
  }

  // Editing Raw images.
  public function your_assets_files_editing_uploaded_images($wrc_id){
    $user_data = Auth::user();
    if ($user_data->dam_enable != 1) {
      request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
      return view('clients.ClientUserManagement.dam_not_enable');
    }
    $wrc_id = base64_decode($wrc_id);
    $wrc_data = EditingWrc::
    where('editing_wrcs.id',$wrc_id)->
    leftJoin('editor_lots', 'editing_wrcs.lot_id', '=', 'editor_lots.id')->select(
      'editing_wrcs.id as wrc_id',
      'editing_wrcs.wrc_number',
      'editing_wrcs.lot_id',
      'editor_lots.lot_number'
    )->first()->toArray();


    // $wrc_raw_query = EditingWrc::
    // where('editing_wrcs.id',$wrc_id)->
    // leftJoin('editor_lots', 'editing_wrcs.lot_id', '=', 'editor_lots.id')->
    // leftJoin('editing_raw_img_uploads', 'editing_wrcs.id', '=', 'editing_raw_img_uploads.wrc_id')->
    // select(
    //   'editing_wrcs.id as wrc_id',
    //   'editing_wrcs.wrc_number',
    //   'editing_wrcs.lot_id',
    //   'editor_lots.lot_number',
    //   'editing_raw_img_uploads.id as upladed_img_id',
    //   'editing_raw_img_uploads.filename',
    //   'editing_raw_img_uploads.file_path',
    //   'editing_raw_img_uploads.created_at'
    // );
    // $wrc_raw_images = $wrc_raw_query->get()->toArray();

    $wrc_raw_images = [];
    
    $wrc_edited_query = EditingWrc::where('editing_wrcs.id',$wrc_id)->
    leftJoin('editor_lots', 'editing_wrcs.lot_id', '=', 'editor_lots.id')->
    leftJoin('editing_uploaded_images', 'editing_wrcs.id', '=', 'editing_uploaded_images.wrc_id')->
    select(
      'editing_wrcs.id as wrc_id',
      'editing_wrcs.wrc_number',
      'editing_wrcs.lot_id',
      'editor_lots.lot_number',
      'editing_uploaded_images.id as upladed_img_id',
      'editing_uploaded_images.filename',
      'editing_uploaded_images.file_path',
      'editing_uploaded_images.created_at'
    );
    $wrc_edited_images = $wrc_edited_query->get()->toArray();
    // dd($wrc_data ,$wrc_raw_images , $wrc_edited_images);
    return view('clients.ClientAssets.your_assets_files_editing_uploaded_images')->with('wrc_data', $wrc_data)->with('wrc_raw_images', $wrc_raw_images)->with('wrc_edited_images', $wrc_edited_images);
    
  }  
    
}
