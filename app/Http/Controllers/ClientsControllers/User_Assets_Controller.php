<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\EditingSubmission;
use App\Models\EditingWrc;
use App\Models\EditorLotModel;
use App\Models\Lots;
use App\Models\Skus;
use App\Models\submissions;
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
      return redirect()->route('home');
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
  
  public function your_assets_shoot_wrcs($lot_id){
    $wrc_data = Wrc::leftJoin('lots', 'wrc.lot_id', '=', 'lots.id')->where('wrc.lot_id',$lot_id)->select(
      'wrc.id as wrc_id',
      'wrc.wrc_id as wrc_number',
      'wrc.lot_id',
      'lots.lot_id as lot_number',
    )->get()->toArray();
    return view('clients.ClientAssets.your_assets_files_wrcs')->with('wrc_data', $wrc_data)->with('service_is' , 'Shoot');
      
  }
  public function your_assets_editing_wrcs($lot_id){
    
    $wrc_data = EditingWrc::leftJoin('editor_lots', 'editing_wrcs.lot_id', '=', 'editor_lots.id')->where('editing_wrcs.lot_id',$lot_id)->select(
      'editing_wrcs.id as wrc_id',
      'editing_wrcs.wrc_number',
      'editing_wrcs.lot_id',
      'editor_lots.lot_number',
    )->get()->toArray();   
    
    return view('clients.ClientAssets.your_assets_files_wrcs')->with('wrc_data', $wrc_data)->with('service_is' , 'Editing');

  }
}
