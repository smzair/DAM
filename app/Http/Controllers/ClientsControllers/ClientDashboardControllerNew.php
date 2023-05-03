<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\ClientActivityLog;
use App\Models\CreatLots;
use App\Models\EditorLotModel;
use App\Models\editorSubmission;
use App\Models\Lots;
use App\Models\LotsCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientDashboardControllerNew extends Controller
{

  public static function index($lotStatus = 'all')
  {
    $creative_lots = array();
    $shoot_lots =  array();
    $lots_catalog = array();
    $editor_lots = array();
    $user_detail = Auth::user(); // logged in user detail
    $roledata = getUsersRole($user_detail['id']);
    $role = $roledata != null ? $roledata->role_name : '-';
    $client_id = $user_detail['id'];
    $parent_client_id = $user_detail['parent_client_id'];

    $role_name = "";
    $role_id = "";
    $brand_arr = [];

    if ($roledata != null) {
      $role_id = $roledata->role_id;
      $role_name = $roledata->role_name;
    }

    $brand_arr = DB::table('brands_user')->where('user_id', $client_id)->get()->pluck('brand_id')->toArray();
    $parent_client_id = $user_detail['parent_client_id'];

    if ($role == "Client" || $role == "Sub Client") {
      $creative_and_cataloging_lot_statusArr = creative_and_cataloging_lot_statusArr();

      /* response data to get Creative lot information with status start*/
      $creative_lots =  CreatLots::orderBy('creative_lots.id', 'DESC')->whereIn('creative_lots.brand_id', $brand_arr);
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
        $creative_lots[$key] = $lot_detail[0];
        if($lotStatus == 'active'){
          if ($creative_lots[$key]['lot_status'] == $creative_and_cataloging_lot_statusArr[4]) {
            unset($creative_lots[$key]);
          }
        }elseif($lotStatus == 'completed'){
          if ($creative_lots[$key]['lot_status'] != $creative_and_cataloging_lot_statusArr[4]) {
            unset($creative_lots[$key]);
          }
        }        
      }

      /* response data to get catlog lot information with status start*/
      $lots_catalog = LotsCatalog::orderBy('lots_catalog.id', 'DESC')->whereIn('lots_catalog.brand_id', $brand_arr)->groupBy('lots_catalog.id');

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
        $lots_catalog[$key] = $lot_detail[0];
        if($lotStatus == 'active'){
          if ($lots_catalog[$key]['lot_status'] == $creative_and_cataloging_lot_statusArr[4]) {
            unset($lots_catalog[$key]);
          }
        }elseif($lotStatus == 'completed'){
          if ($lots_catalog[$key]['lot_status'] != $creative_and_cataloging_lot_statusArr[4]) {
            unset($lots_catalog[$key]);
          }
        }

      }

      /* response data to get editor lot information with status start*/
      $editor_lots = EditorLotModel::orderBy('editor_lots.id', 'DESC')
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
      
      foreach ($editor_lots as $key => $val) {
        $LotTimelineData = EditorLotModel::clientsEditorLotTimeline($val['lot_id']);
        $lot_detail = $LotTimelineData['lot_detail']; 
        $editor_lots[$key] = $lot_detail[0];
        if($lotStatus == 'active'){
          if ($editor_lots[$key]['lot_status'] == $creative_and_cataloging_lot_statusArr[4]) {
            unset($editor_lots[$key]);
          }
        }elseif($lotStatus == 'completed'){
          if ($editor_lots[$key]['lot_status'] != $creative_and_cataloging_lot_statusArr[4]) {
            unset($editor_lots[$key]);
          }
        }        
      }
      // dd($editor_lots);

      /* response data to get shoot lot information with status start*/
      $shoot_lots = Lots::orderBy('lots.id', 'DESC')
        ->select('lots.id as lot_id', 'lots.lot_id as lot_number', 'lots.created_at')
        ->whereIn('lots.brand_id', $brand_arr)
        ->groupBy('lots.id');
      if ($role_name == 'Sub Client') {
        $shoot_lots = $shoot_lots->where('lots.user_id', $parent_client_id);
      }
      if ($role_name == 'Client') {
        $shoot_lots = $shoot_lots->where('lots.user_id', $client_id);
      }

      $shoot_lots = $shoot_lots->get()->toArray();
      $shoot_lot_statusArr = shoot_lot_statusArr();

      foreach ($shoot_lots as $key => $val) {
        $LotTimelineData = Lots::LotTimeline($val['lot_id']);
        $lot_detail = $LotTimelineData['lot_detail']; 
        $wrc_detail = $LotTimelineData['wrc_detail'];
        $shoot_lots[$key] = $lot_detail[0];
        if($lotStatus == 'active'){
          if ($shoot_lots[$key]['lot_status'] == $shoot_lot_statusArr[4]) {
            unset($shoot_lots[$key]);
          }
        }elseif($lotStatus == 'completed'){
          if ($shoot_lots[$key]['lot_status'] != $shoot_lot_statusArr[4]) {
            unset($shoot_lots[$key]);
          }
        }
      }
      /* response data to get shoot lot information with status end*/
    } else {
      $creative_lots = array();
      $shoot_lots = array();
      $lots_catalog = array();
      $editor_lots = array();
    }
    // return pre($creative_lots);

    // insert into user activity log
    $data_array = array(
      'log_name' => 'Clients Lot Status',
      'description' => ' Clients Lot Status',
      'event' => 'Clients Lot Status',
      'subject_type' => 'App\Models\CreatLots',
      'subject_id' => '0',
      'properties' => [],
    );
    // ClientActivityLog::saveClient_activity_logs($data_array);
    // dd($creative_lots);
    $other_data = array(
      'search_query' => '',
      'lot_status' => $lotStatus
    );
    return view('clients.ClientDashboardDam', compact('creative_lots', 'shoot_lots', 'lots_catalog', 'editor_lots'))->with('other_data',$other_data);
    
  }

  // clients Catlog time line detail
  public function clientsCatloglotTimeline(Request $request, $id)
  {
    $LotTimelineData = LotsCatalog::LotTimeline($id);
    $lot_detail = $LotTimelineData['lot_detail']; 
    $wrc_detail = $LotTimelineData['wrc_detail']; 
    // dd($lot_detail, $wrc_detail);
    
    return view('clients.Timeline.catlogTimeline_New')->with('lot_detail', $lot_detail)->with('wrc_detail', $wrc_detail);
  }

  // clients Creative Lot Timeline
  public function clientsCreativelotTimelineNew(Request $request, $id)
  {
    $LotTimelineData = CreatLots::LotTimeline($id);
    $lot_detail = $LotTimelineData['lot_detail']; 
    $wrc_detail = $LotTimelineData['wrc_detail']; 
    // dd($lot_detail, $wrc_detail);
    
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

  // clients editor lot time line detail
  public function clientsShootlotTimelineNew(Request $request, $id)
  {
    $LotTimelineData = Lots::LotTimeline($id);
    $lot_detail = $LotTimelineData['lot_detail']; 
    $wrc_detail = $LotTimelineData['wrc_detail']; 
    // dd($lot_detail, $wrc_detail);
    return view('clients.Timeline.editorShootTimeline_New')->with('lot_detail', $lot_detail)->with('wrc_detail', $wrc_detail);
  }



}
