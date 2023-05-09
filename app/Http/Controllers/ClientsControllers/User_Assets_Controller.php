<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\EditingSubmission;
use App\Models\EditingWrc;
use App\Models\EditorLotModel;
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
  public function your_assets_files()
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

    /** Shoot lots **/
    $lots_query_cataloging = Lots::leftJoin('wrc', 'wrc.lot_id', '=', 'lots.id')->whereIn('lots.brand_id', $brand_arr)->whereNotNull('wrc.id')->
      select(
        'lots.id as lot_id',
        'lots.lot_id as lot_number',
        'lots.created_at as lot_created_at',
        'wrc.id as wrc_id',
        'wrc.wrc_id as wrc_number',
        DB::raw("GROUP_CONCAT(wrc.id) as wrc_ids"),
        DB::raw("COUNT(wrc.id) as wrc_counts"),
      )->groupby('lots.id');
    $shoot_lots = $lots_query_cataloging->where('lots.user_id', $parent_client_id);
    $shoot_lots = $lots_query_cataloging->get()->toArray();

    $shoot_lots_data = array();
    foreach ($shoot_lots as $key => $row) {
      $wrc_id_arr = explode(',', $row['wrc_ids']);
      $wrc_counts = $row['wrc_counts'];
      $lot_submission_query = submissions::whereIn('submission.wrc_id', $wrc_id_arr)->select('id as submission_id', 'submission.submission_date');
      $lot_submission_count = $lot_submission_query->count();

      if ($wrc_counts == $lot_submission_count) {
        $submission_array = $lot_submission_query->orderby('submission.created_at', 'DESC')->get()->toArray();

        $sku_info_query = Skus::whereIn('sku.wrc_id', $wrc_id_arr)->select('id as sku_id', 'sku_code', 'status');
        $skus_count = $sku_info_query->count();
        $skus_array = $sku_info_query->get()->toArray();

        array_push($shoot_lots_data, array(
          'lot_id' => $row['lot_id'],
          'lot_number' => $row['lot_number'],
          'lot_created_at' => $row['lot_created_at'],
          'inward_qty' => $skus_count,
          'skus' => $skus_array,
          'submission_date' => $submission_array[0]['submission_date'],
          'submissions' => $submission_array
        ));
      }
    }

    /** Editing lots **/
    $lots_query_cataloging = EditorLotModel::leftJoin('editing_wrcs', 'editing_wrcs.lot_id', '=', 'editor_lots.id')
      ->whereIn('editor_lots.brand_id', $brand_arr)->whereNotNull('editing_wrcs.id')->
      select(
        'editor_lots.id as lot_id',
        'editor_lots.lot_number',
        'editor_lots.created_at as lot_created_at',
        'editing_wrcs.id as wrc_id',
        'editing_wrcs.wrc_number',
        DB::raw("GROUP_CONCAT(editing_wrcs.id) as wrc_ids"),
        DB::raw("SUM(editing_wrcs.imgQty) as tot_imgqty"),
        DB::raw("SUM(editing_wrcs.uploaded_img_qty) as tot_uploaded_img_qty"),
        DB::raw("COUNT(editing_wrcs.id) as wrc_counts"),
      )->groupby('editor_lots.id');

    $editor_lots = $lots_query_cataloging->where('editor_lots.user_id', $parent_client_id);
    $editor_lots = $lots_query_cataloging->get()->toArray();

    $editor_lots_data = array();
    foreach ($editor_lots as $key => $row) {
      $wrc_id_arr = explode(',', $row['wrc_ids']);
      $wrc_counts = $row['wrc_counts'];
      $lot_submission_query = EditingSubmission::whereIn('editing_submissions.wrc_id', $wrc_id_arr)->select('id as submission_id', 'editing_submissions.submission_date');
      $lot_submission_count = $lot_submission_query->count();

      if ($wrc_counts == $lot_submission_count) {
        $submission_array = $lot_submission_query->orderby('editing_submissions.created_at', 'DESC')->get()->toArray();
        array_push($editor_lots_data, array(
          'lot_id' => $row['lot_id'],
          'lot_number' => $row['lot_number'],
          'lot_created_at' => $row['lot_created_at'],
          'inward_qty' => $row['tot_uploaded_img_qty'],
          'tot_imgqty' => $row['tot_imgqty'],
          'submission_date' => $submission_array[0]['submission_date'],
          'submissions' => $submission_array
        ));
      }
    }
    return view('clients.ClientAssets.your_assets_files')->with('shoot_lots', $shoot_lots_data)->with('editor_lots', $editor_lots_data);
  }
  
  // Shoot wrc list
  public function your_assets_shoot_wrcs($lot_id){
    $user_data = Auth::user();
    if ($user_data->dam_enable != 1) {
      request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
      return view('clients.ClientUserManagement.dam_not_enable');
    }
    $wrc_data = Wrc::leftJoin('lots', 'wrc.lot_id', '=', 'lots.id')->where('wrc.lot_id',$lot_id)->select(
      'wrc.id as wrc_id',
      'wrc.wrc_id as wrc_number',
      'wrc.lot_id',
      'lots.lot_id as lot_number',
    )->get()->toArray();
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
      'editor_lots.lot_number',
    )->get()->toArray();   
    
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
        array_push($adaptation_arr ,$wrc_data[$adaptation_key] );
      }else{
        unset($wrc_data[$adaptation_key]);
      }
    }
    $wrc_data['adaptation'] = $adaptation_arr;

    // Raw skus List based on Wrc id.
    $sku_info_query = Skus::leftJoin('wrc', 'wrc.id', '=', 'Sku.wrc_id')->where('sku.wrc_id', '=' , $wrc_id)->where('sku.status', '=' , '1')->select('Sku.id as sku_id', 'Sku.sku_code','Sku.status', 'sku.wrc_id', 'wrc.wrc_id as wrc_number' );
    $skus_count = $sku_info_query->count();
    $raw_skus_data = $sku_info_query->get()->toArray();

    $raw_skus = array();
    foreach ($raw_skus_data as $key => $row) {
      $upload_raw_query = uploadraw::where('sku_id', $row['sku_id']);
      $upload_raw_count = $upload_raw_query->count();
      if($upload_raw_count > 0){
        $row['uploadraw'] = $upload_raw_query->get()->toArray();
        array_push($raw_skus, $row);
      }
    }
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
    leftJoin('wrc', 'wrc.id', '=', 'Sku.wrc_id')->
    leftJoin('lots', 'wrc.lot_id', '=', 'lots.id')->
    leftJoin('editor_submission', 'editor_submission.sku_id', '=', 'Sku.id')->
    where('sku.wrc_id', '=' , $wrc_id)->where('sku.status', '=' , '1')->where('editor_submission.adaptation', '=' , "$adaptation")->where('editor_submission.qc', '=' , "1")->
    select('Sku.id as sku_id', 'Sku.sku_code','Sku.status', 'sku.wrc_id', 'wrc.wrc_id as wrc_number','wrc.lot_id' ,'lots.lot_id as lot_number', 'editor_submission.id as submission_id', 'editor_submission.adaptation' , 'editor_submission.filename', DB::raw("COUNT(editor_submission.id) as file_count"))->groupBy('Sku.id');
    $skus_count = $sku_info_query->count();
    $raw_skus_data = $sku_info_query->get()->toArray();
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
    leftJoin('wrc', 'wrc.id', '=', 'Sku.wrc_id')->
    leftJoin('lots', 'wrc.lot_id', '=', 'lots.id')->
    leftJoin('editor_submission', 'editor_submission.sku_id', '=', 'Sku.id')->
    where('sku.id', '=' , $sku_id)->where('sku.status', '=' , '1')->where('editor_submission.qc', '=' , "1")->
    select(
      'Sku.id as sku_id',
      'Sku.sku_code',
      'Sku.status',
      'sku.wrc_id',
      'wrc.wrc_id as wrc_number','wrc.lot_id' ,'lots.lot_id as lot_number',
      'editor_submission.id as submission_id',
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
    leftJoin('wrc', 'wrc.id', '=', 'Sku.wrc_id')->
    leftJoin('lots', 'wrc.lot_id', '=', 'lots.id')->
    leftJoin('uploadraw', 'uploadraw.sku_id', '=', 'Sku.id')->
    where('sku.id', '=' , $sku_id)->where('sku.status', '=' , '1')->
    select(
      'Sku.id as sku_id',
      'Sku.sku_code',
      'Sku.status',
      'sku.wrc_id',
      'wrc.wrc_id as wrc_number','wrc.lot_id' ,'lots.lot_id as lot_number',
      'uploadraw.filename' ,
      'uploadraw.created_at as created_at'
    );
    $raw_skus_files = $sku_info_query->get()->toArray();
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


    $wrc_raw_query = EditingWrc::
    where('editing_wrcs.id',$wrc_id)->
    leftJoin('editor_lots', 'editing_wrcs.lot_id', '=', 'editor_lots.id')->
    leftJoin('editing_raw_img_uploads', 'editing_wrcs.id', '=', 'editing_raw_img_uploads.wrc_id')->
    select(
      'editing_wrcs.id as wrc_id',
      'editing_wrcs.wrc_number',
      'editing_wrcs.lot_id',
      'editor_lots.lot_number',
      'editing_raw_img_uploads.id as upladed_img_id',
      'editing_raw_img_uploads.filename',
      'editing_raw_img_uploads.file_path',
      'editing_raw_img_uploads.created_at'
    );
    $wrc_raw_images = $wrc_raw_query->get()->toArray();
    
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
