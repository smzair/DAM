<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\ClientActivityLog;
use App\Models\CreatLots;
use App\Models\EditorLotModel;
use App\Models\editorSubmission;
use App\Models\Lots;
use App\Models\LotsCatalog;
use App\Models\Skus;
use App\Models\submissions;
use App\Models\uploadraw;
use App\Models\Wrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientDashboardControllerNew extends Controller
{

  public static function index()
  {
    $resData = array();
    $resDataShoot =  array();
    $resDataCatlog = array();
    $resDataEditor = array();
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

      /* response data to get Creative lot information with status start*/
      $resData =  CreatLots::orderBy('creative_lots.id', 'DESC')->whereIn('creative_lots.brand_id', $brand_arr);
      if ($role_name == 'Sub Client') {
        $resData =  $resData->where('creative_lots.user_id', $parent_client_id);
      }
      if ($role_name == 'Client') {
        $resData =  $resData->where('creative_lots.user_id', $client_id);
      }
      $resData =  $resData->get()->toArray();
      
      foreach ($resData as $key => $val) {
        $LotTimelineData = CreatLots::LotTimeline($val['id']);
        $lot_detail = $LotTimelineData['lot_detail']; 
        $resData[$key] = $lot_detail[0];
      }

      /* response data to get catlog lot information with status start*/
      $resDataCatlog = LotsCatalog::orderBy('lots_catalog.id', 'DESC')->whereIn('lots_catalog.brand_id', $brand_arr)->groupBy('lots_catalog.id');

      if ($role_name == 'Sub Client') {
        $resDataCatlog =  $resDataCatlog->where('lots_catalog.user_id', $parent_client_id);
      }
      if ($role_name == 'Client') {
        $resDataCatlog =  $resDataCatlog->where('lots_catalog.user_id', $client_id);
      }
      $resDataCatlog =  $resDataCatlog->get()->toArray();

      foreach ($resDataCatlog as $key => $val) {
        $LotTimelineData = LotsCatalog::LotTimeline($val['id']);
        $lot_detail = $LotTimelineData['lot_detail']; 
        $resDataCatlog[$key] = $lot_detail[0];
        
      }

      /* response data to get editor lot information with status start*/
      $resDataEditor = EditorLotModel::orderBy('editor_lots.id', 'DESC')
        ->leftJoin('editing_wrcs', 'editing_wrcs.lot_id', 'editor_lots.id')
        ->select('editor_lots.id as lot_id', 'editor_lots.created_at', 'editor_lots.lot_number', 'editing_wrcs.id as wrc_id')
        ->whereIn('editor_lots.brand_id', $brand_arr)
        ->groupBy('editor_lots.id');
      if ($role_name == 'Sub Client') {
        $resDataEditor = $resDataEditor->where('editor_lots.user_id', $parent_client_id);
      }
      if ($role_name == 'Client') {
        $resDataEditor = $resDataEditor->where('editor_lots.user_id', $client_id);
      }

      $resDataEditor = $resDataEditor->get()->toArray();
      
      foreach ($resDataEditor as $key => $val) {
        $LotTimelineData = EditorLotModel::clientsEditorLotTimeline($val['lot_id']);
        $lot_detail = $LotTimelineData['lot_detail']; 
        $resDataEditor[$key] = $lot_detail[0];
      }
      // dd($resDataEditor);

      /* response data to get shoot lot information with status start*/
      $resDataShoot = Lots::orderBy('lots.id', 'DESC')
        ->select('lots.id as lot_id', 'lots.lot_id as lot_number', 'lots.created_at')
        ->whereIn('lots.brand_id', $brand_arr)
        ->groupBy('lots.id');
      if ($role_name == 'Sub Client') {
        $resDataShoot = $resDataShoot->where('lots.user_id', $parent_client_id);
      }
      if ($role_name == 'Client') {
        $resDataShoot = $resDataShoot->where('lots.user_id', $client_id);
      }

      $resDataShoot = $resDataShoot->get()->toArray();

      foreach ($resDataShoot as $key => $val) {
        $LotTimelineData = Lots::LotTimeline($val['lot_id']);
        $lot_detail = $LotTimelineData['lot_detail']; 
        $wrc_detail = $LotTimelineData['wrc_detail'];
        $resDataShoot[$key] = $lot_detail[0];
      }
      /* response data to get shoot lot information with status end*/
    } else {
      $resData = array();
      $resDataShoot = array();
      $resDataCatlog = array();
      $resDataEditor = array();
    }
    // return pre($resData);

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
    // dd($resData);
    
    return view('clients.ClientDashboardDam', compact('resData', 'resDataShoot', 'resDataCatlog', 'resDataEditor'));
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
