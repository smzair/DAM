<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\CreatLots;
use App\Jobs\SearchDataCollection;
use App\Models\EditorLotModel;
use App\Models\Lots;
use App\Models\LotsCatalog;
use App\Models\Skus;
use App\Models\uploadraw;
use App\Models\User;
use App\Models\Wrc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ClientCommonController extends Controller
{
  // Send otp for emailVerifyOtp And phoneVerifyOtp
  public function sendOtp(Request $request)
  {
    $otpfor = $request->otpfor;
    if ($request->otpfor == 1) {
      $sendOtpFor = "emailVerifyOtp";
      $OtpExpires_at = "emailVerifyOtpExpireAt";
    } else {
      $sendOtpFor = "phoneVerifyOtp";
      $OtpExpires_at = "phoneVerifyOtpExpireAt";
    }

    // OTP has expired, remove it from session
    if ($request->resend == 1 || Carbon::now()->greaterThanOrEqualTo(Session::get($OtpExpires_at))) {
      Session::forget($sendOtpFor);
      Session::forget($OtpExpires_at);
    }

    $SessionOtp = Session::get($sendOtpFor);
    $user_data = Auth::user();
    $massage = 'OTP sent!';
    if ($SessionOtp !== null && $SessionOtp !== '') {
      $otp = $SessionOtp;
    } else {
      $otp = strval(mt_rand(1000, 9999));
      $other_data = array(
        'otp' => $otp,
        'sendOtpFor' => $sendOtpFor,
        'otpfor' => $request->otpfor
      );

      if (($user_data->email_verified == 0 && $otpfor == 1) || ($user_data->phone_verified == 0 && $otpfor == 2)) {
        Session::put($sendOtpFor, $otp);
        Session::put($OtpExpires_at, Carbon::now()->addSeconds(300));
        $this->sent_otp_to_mail($user_data, $other_data);
        $massage = 'OTP sent!';
      } else {
        $massage = 'Already vairified!!';
      }
    }

    $response = array(
      'massage' => $massage,
      'email' => $user_data->email,
    );
    echo json_encode($response);
  }

  // verify otp for email And phone
  public function verifyOtp(Request $request)
  {
    $final_otp = $request->final_otp;
    $otpfor = $request->otpfor;

    if ($otpfor == 1) {
      $sendOtpFor = "emailVerifyOtp";
      $OtpExpires_at = "emailVerifyOtpExpireAt";
    } else {
      $sendOtpFor = "phoneVerifyOtp";
      $OtpExpires_at = "phoneVerifyOtpExpireAt";
    }

    $is_OtpExpired = false;
    if (Carbon::now()->greaterThanOrEqualTo(Session::get($OtpExpires_at))) {
      $is_OtpExpired = true;
    }

    $status = false;
    if (!$is_OtpExpired) {
      $SessionOtp = Session::get($sendOtpFor);
      if ($SessionOtp == $final_otp) {
        $user_data = User::find(Auth::id());
        if ($otpfor == 1) {
          $user_data->email_verified = 1;
          $user_data->email_verified_at = date('Y-m-d H:i:s');
        } else {
          $user_data->phone_verified = 1;
        }
        $status = $user_data->update();
        if ($status) {
          Session::forget($sendOtpFor);
          Session::forget($OtpExpires_at);
          $massage = "Success";
        } else {
          $massage = "Somthing went wrong";
        }
      } else {
        $massage = "Otp not matched";
      }
    } else {
      $massage = "Otp expired";
    }
    echo json_encode(array(
      'status' => $status,
      'massage' => $massage
    ));
  }

  public function gloableSearch(Request $request)
  {
    $user_data = Auth::user();
    if ($user_data->dam_enable != 1) {
      request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
      return redirect()->route('home');
    }

    $parent_client_id = $user_id = $user_data->id;
    $roledata = getUsersRole($user_id);

    if ($roledata != null) {
      $role_id = $roledata->role_id;
      $role_name = $roledata->role_name;
    }

    if ($role_name == 'Sub Client') {
      $parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
      $parent_client_id = $parent_user_data->parent_client_id;
    }
    // $parent_client_id = 6666;
    $brand_arr = DB::table('brands_user')->where('user_id', $user_id)->get()->pluck('brand_id')->toArray();

    $searchValue = $request['search_query'];
    $other_data = array(
      'search_query' => $searchValue,
      'lot_status' => 'Search'
    );

    /* Gloable search data for creative */

    $lots_query_creative = CreatLots::leftJoin('creative_wrc', 'creative_wrc.lot_id', '=', 'creative_lots.id')
      ->whereIn('creative_lots.brand_id', $brand_arr)
      ->where(function ($query) use ($searchValue) {
        $query->where('creative_lots.lot_number', 'like', '%' . $searchValue . '%')->orWhere('creative_wrc.wrc_number', 'like', '%' . $searchValue . '%');
      })->select(
        'creative_lots.id as lot_id',
        'creative_lots.lot_number',
        'creative_wrc.id as wrc_id',
        'creative_wrc.wrc_number'
      )->groupby('creative_lots.id');

    $creative_lots = $lots_query_creative->where('creative_lots.user_id', $parent_client_id);
    $creative_lots = $lots_query_creative->get()->toArray();

    foreach ($creative_lots as $key => $val) {
      $LotTimelineData = CreatLots::LotTimeline($val['lot_id']);
      $lot_detail = $LotTimelineData['lot_detail'];
      $wrc_detail = $LotTimelineData['wrc_detail'];
      $creative_lots[$key] = $lot_detail[0];
      $creative_lots[$key]['wrc_detail'] = $wrc_detail;
    }

    /* Gloable search data for Cataloging */
    $lots_query_cataloging = LotsCatalog::leftJoin('catlog_wrc', 'catlog_wrc.lot_id', '=', 'lots_catalog.id')
      ->whereIn('lots_catalog.brand_id', $brand_arr)
      ->where(function ($query) use ($searchValue) {
        $query->where('lots_catalog.lot_number', 'like', '%' . $searchValue . '%')->orWhere('catlog_wrc.wrc_number', 'like', '%' . $searchValue . '%');
      })->select(
        'lots_catalog.id as lot_id',
        'lots_catalog.lot_number',
        'catlog_wrc.id as wrc_id',
        'catlog_wrc.wrc_number'
      )->groupby('lots_catalog.id');

    $lots_catalog = $lots_query_cataloging->where('lots_catalog.user_id', $parent_client_id);
    $lots_catalog = $lots_query_cataloging->get()->toArray();

    foreach ($lots_catalog as $key => $val) {
      $LotTimelineData = LotsCatalog::LotTimeline($val['lot_id']);
      $lot_detail = $LotTimelineData['lot_detail'];
      $wrc_detail = $LotTimelineData['wrc_detail'];
      $lots_catalog[$key] = $lot_detail[0];
      $lots_catalog[$key]['wrc_detail'] = $wrc_detail;
    }

    /* Gloable search data for Editing */
    $lots_query_cataloging = EditorLotModel::leftJoin('editing_wrcs', 'editing_wrcs.lot_id', '=', 'editor_lots.id')
      ->whereIn('editor_lots.brand_id', $brand_arr)
      ->where(function ($query) use ($searchValue) {
        $query->where('editor_lots.lot_number', 'like', '%' . $searchValue . '%')->orWhere('editing_wrcs.wrc_number', 'like', '%' . $searchValue . '%');
      })->select(
        'editor_lots.id as lot_id',
        'editor_lots.lot_number',
        'editing_wrcs.id as wrc_id',
        'editing_wrcs.wrc_number'
      )->groupby('editor_lots.id');

    $editor_lots = $lots_query_cataloging->where('editor_lots.user_id', $parent_client_id);
    $editor_lots = $lots_query_cataloging->get()->toArray();
    foreach ($editor_lots as $key => $val) {
      $LotTimelineData = EditorLotModel::clientsEditorLotTimeline($val['lot_id']);
      $lot_detail = $LotTimelineData['lot_detail'];
      $wrc_detail = $LotTimelineData['wrc_detail'];
      $editor_lots[$key] = $lot_detail[0];
      $editor_lots[$key]['wrc_detail'] = $wrc_detail;
    }

    /* Gloable search data for Editing */
    $lots_query_cataloging = Lots::leftJoin('wrc', 'wrc.lot_id', '=', 'lots.id')
      ->whereIn('lots.brand_id', $brand_arr)
      ->where(function ($query) use ($searchValue) {
        $query->where('lots.lot_id', 'like', '%' . $searchValue . '%')->orWhere('wrc.wrc_id', 'like', '%' . $searchValue . '%');
      })->select(
        'lots.id as lot_id',
        'lots.lot_id as lot_number',
        'wrc.id as wrc_id',
        'wrc.wrc_id as wrc_number'
      )->groupby('lots.id');
    $shoot_lots = $lots_query_cataloging->where('lots.user_id', $parent_client_id);
    $shoot_lots = $lots_query_cataloging->get()->toArray();

    foreach ($shoot_lots as $key => $val) {
      $LotTimelineData = Lots::LotTimeline($val['lot_id']);
      $lot_detail = $LotTimelineData['lot_detail'];
      $wrc_detail = $LotTimelineData['wrc_detail'];
      $shoot_lots[$key] = $lot_detail[0];
      $shoot_lots[$key]['wrc_detail'] = $wrc_detail;
    }
    // dd($other_data , $creative_lots , $lots_catalog , $editor_lots , $shoot_lots , $request['search_query']);
    return view('clients.ClientDashboardDam', compact('creative_lots', 'shoot_lots', 'lots_catalog', 'editor_lots'))->with('other_data', $other_data);
  }

  public function gloableSearchNew(Request $request)
  {
    $searchTerm = $searchValue = trim($request['search_query']);
    if ($searchValue == '') {
      return ClientDashboardControllerNew::index();
    }

    $other_data = array(
      'search_query' => $searchValue,
      'lot_status' => 'Search'
    );

    $user_data = Auth::user();
    if ($user_data->dam_enable != 1) {
      request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
      return redirect()->route('home');
    }


    // Data set from app\Jobs\SearchDataCollection.php
    /********************************* Shoot search data *******************************************/
      $shootLots = [];
      $shootWrcData = [];
      $shootSkuData = [];
      $shoot_edited_images_list = [];

      if (Session::has('shoot_data')) {
        $shoot_data = Session::get('shoot_data');
        if (isset($shoot_data['lots'])) {
          $shootLots = $shoot_data['lots'];
        }
        if (isset($shoot_data['wrc'])) {
          $shootWrcData = $shoot_data['wrc'];
        }
        if (isset($shoot_data['sku'])) {
          $shootSkuData = $shoot_data['sku'];
        }
        if (isset($shoot_data['shoot_edited_images'])) {
          $shoot_edited_images_list = $shoot_data['shoot_edited_images'];
        }
        // dd($shoot_data);
      }

      $data_array = [];
      // Lot data
      $searchData_shoot_lot = array();
      // dd($shootLots);

      foreach ($shootLots as $item) {
        $serializedItem = serialize($item);
        if (stripos($serializedItem, $searchTerm) !== false) {
          $searchData_shoot_lot[] = $item;
        }
      }

      $data_array['searchData_shoot_lot'] = $searchData_shoot_lot;
      // Wrc Data.
      $searchData_shoot_wrc = array();
      foreach ($shootWrcData as $item) {
        $serializedItem = serialize($item);
        if (stripos($serializedItem, $searchTerm) !== false) {
          $searchData_shoot_wrc[] = $item;
        }
      }
      $data_array['searchData_shoot_wrc'] = $searchData_shoot_wrc;

      // Sku Data
      $searchData_shoot_sku = array();
      foreach ($shootSkuData as $item) {
        $serializedItem = serialize($item);
        if (stripos($serializedItem, $searchTerm) !== false) {
          $searchData_shoot_sku[] = $item;
        }
      }
      $data_array['searchData_shoot_sku'] = $searchData_shoot_sku;

      // Sku Data
      $searchData_shoot_edited_images = array();
      foreach ($shoot_edited_images_list as $item) {
        $serializedItem = serialize($item);
        if (stripos($serializedItem, $searchTerm) !== false) {
          $searchData_shoot_edited_images[] = $item;
        }
      }
      $data_array['searchData_shoot_edited_images'] = $searchData_shoot_edited_images;


    /********************************* Editing search data *******************************************/
      $editingLots = [];
      $editingWrcData = [];
      $editingLots = [];
      if (Session::has('editing_data')) {
        $editing_data = Session::get('editing_data');
        if (isset($editing_data['lots'])) {
          $editingLots = $editing_data['lots'];
        }
        if (isset($editing_data['wrc'])) {
          $editingWrcData = $editing_data['wrc'];
        }
      }
      // dd('ClientCommonController' , $editing_data);
      // Lot data
      $searchData_editing_lot = array();
      foreach ($editingLots as $item) {
        $serializedItem = serialize($item);
        if (stripos($serializedItem, $searchTerm) !== false) {
          $searchData_editing_lot[] = $item;
        }
      }
      // Wrc Data
      $searchData_editing_wrc = array();
      foreach ($editingWrcData as $item) {
        $serializedItem = serialize($item);
        if (stripos($serializedItem, $searchTerm) !== false) {
          $searchData_editing_wrc[] = $item;
        }
      }
      $data_array['searchData_editing_lot'] = $searchData_editing_lot;
      $data_array['searchData_editing_wrc'] = $searchData_editing_wrc;

      // dd('ClientCommonController' , $searchData_editing_lot , $searchData_editing_wrc);
    /********************************* Creative search data *******************************************/
      $creativeLots = [];
      $creativeWrcData = [];


      if (Session::has('creative_Data')) {
        $creative_Data = Session::get('creative_Data');
        if (isset($creative_Data['lots'])) {
          $creativeLots = $creative_Data['lots'];
        }
        if (isset($creative_Data['wrc'])) {
          $creativeWrcData = $creative_Data['wrc'];
        }
      }

      // Lot data
      $searchData_creative_lot = array();
      foreach ($creativeLots as $item) {
        $serializedItem = serialize($item);
        if (stripos($serializedItem, $searchTerm) !== false) {
          $searchData_creative_lot[] = $item;
        }
      }

      // Wrc Data
      $searchData_creative_wrc = array();
      foreach ($creativeWrcData as $item) {
        $serializedItem = serialize($item);
        if (stripos($serializedItem, $searchTerm) !== false) {
          $searchData_creative_wrc[] = $item;
        }
      }

      $data_array['searchData_creative_lot'] = $searchData_creative_lot;
      $data_array['searchData_creative_wrc'] = $searchData_creative_wrc;
      // dd($creative_Data);
      
    /********************************* Catalog search data *******************************************/
      $catalogLots = [];
      $catalogWrcData = [];

      if (Session::has('catalog_data')) {
        $catalog_data = Session::get('catalog_data');
        if (isset($catalog_data['lots'])) {
          $catalogLots = $catalog_data['lots'];
        }
        if (isset($catalog_data['wrc'])) {
          $catalogWrcData = $catalog_data['wrc'];
        }
      }

      // Catalog Lot data
      $searchData_catalog_lot = array();
      foreach ($catalogLots as $item) {
        $serializedItem = serialize($item);
        if (stripos($serializedItem, $searchTerm) !== false) {
          $searchData_catalog_lot[] = $item;
        }
      }

      // Wrc Data
      $searchData_catalog_wrc = array();
      foreach ($catalogWrcData as $item) {
        $serializedItem = serialize($item);
        if (stripos($serializedItem, $searchTerm) !== false) {
          $searchData_catalog_wrc[] = $item;
        }
      }
      $data_array['searchData_catalog_lot'] = $searchData_catalog_lot;
      $data_array['searchData_catalog_wrc'] = $searchData_catalog_wrc;

    return view('clients.gloableSearchNew')->with('data_array', $data_array)->with('other_data', $other_data);
  }
}
