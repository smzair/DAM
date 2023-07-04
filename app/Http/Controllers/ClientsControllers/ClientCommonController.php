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

  // wrc adaptation svg data
  public function adaptation_svg_data_arr($adaptation_arr){
    if (in_array('Brand-Site', $adaptation_arr)) {
      $brand_site_key = array_search('Brand-Site', $adaptation_arr);
      unset($adaptation_arr[$brand_site_key]);
      $adaptation_arr[] = 'Brand-Site';
    }

    $adaptation_data_arr = array();
    foreach ($adaptation_arr as $adaptation) {
      switch ($adaptation) {
        case 'Noon':
        case 'Noon-Athletiq':
        case 'Noon-DRIP':
        case 'Noon-QUWA':
        case 'Noon-OFFROAD':
        case 'Noon-AILA':
        case 'Noon-NEON':
        case 'Noon-SHIVCRAFT':
        case 'Noon-ZARAFA':            
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.7325 6.4049C16.9765 6.1019 16.1575 5.9519 15.3415 5.9519C14.8585 5.9519 14.3725 6.0119 13.8895 6.1019L11.9365 9.4619C12.7375 9.0239 13.6315 8.8109 14.5555 8.8259C15.1165 8.8259 15.6595 8.9009 16.1905 9.0539L17.7355 6.4049H17.7325Z" fill="white"/>
                <path d="M6.00014 15.4379C6.00014 20.2799 10.1191 24.0479 14.9161 24.0479C19.7131 24.0479 24.0001 19.9919 24.0001 15.0599C24.0001 12.1709 22.6081 9.62688 20.5321 7.93188L19.0171 10.5509C20.3491 11.6849 21.1201 13.3499 21.1201 15.1049C21.1201 18.4649 18.3331 21.2189 14.9131 21.2189C11.4931 21.2189 8.72114 18.4499 8.72114 15.0299V15.0149C8.72114 14.6069 8.75114 14.1989 8.82614 13.8029L5.99414 15.4379H6.00014Z" fill="white"/>
                <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
            </svg>';
          break;

        case 'Amazon':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M21.4321 22.0289C19.6891 23.3159 17.1601 23.9999 14.9851 23.9999C12.0751 24.0149 9.2671 22.9439 7.1071 20.9939C6.9451 20.8469 7.0891 20.6459 7.2871 20.7599C9.6871 22.1339 12.4051 22.8539 15.1681 22.8509C17.2321 22.8419 19.2781 22.4219 21.1801 21.6209C21.4741 21.4979 21.7231 21.8159 21.4321 22.0289Z" fill="#FF9900"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M22.1576 21.201C21.9356 20.916 20.6816 21.066 20.1206 21.132C19.9496 21.153 19.9226 21.003 20.0786 20.895C21.0776 20.193 22.7126 20.397 22.9016 20.631C23.0906 20.865 22.8506 22.509 21.9176 23.289C21.7736 23.409 21.6356 23.346 21.7016 23.184C21.9116 22.662 22.3826 21.486 22.1606 21.198L22.1576 21.201Z" fill="#FF9900"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3141 13.5119C16.3141 14.4299 16.3351 15.1949 15.8731 16.0079C15.5671 16.6349 14.9431 17.0429 14.2441 17.0759C13.3381 17.0759 12.8131 16.3859 12.8131 15.3689C12.8131 13.3649 14.6101 12.9989 16.3111 12.9989V13.5119H16.3141ZM18.6871 19.2479C18.5311 19.3829 18.3091 19.4039 18.1291 19.3049C17.5861 18.8699 17.1271 18.3419 16.7761 17.7449C15.4831 19.0619 14.5681 19.4549 12.8971 19.4549C10.9141 19.4459 9.37513 18.2249 9.37513 15.7799C9.32113 14.0969 10.3231 12.5609 11.8831 11.9339C13.1581 11.3729 14.9431 11.2709 16.3081 11.1209V10.8059C16.3081 10.2449 16.3501 9.58193 16.0231 9.09893C15.7081 8.69993 15.2221 8.47493 14.7121 8.49893C13.8151 8.49893 13.0171 8.95793 12.8191 9.91493C12.7951 10.1339 12.6271 10.3109 12.4111 10.3469L10.1221 10.0979C9.89713 10.0709 9.73813 9.86393 9.76513 9.63893C9.76513 9.62693 9.76813 9.61793 9.77113 9.60593C10.2931 6.83693 12.7921 6.00293 15.0331 6.00293C16.1791 6.00293 17.6761 6.30593 18.5791 7.17593C19.7251 8.24393 19.6141 9.67193 19.6141 11.2259V14.8919C19.6141 15.9929 20.0701 16.4759 20.5021 17.0729C20.6731 17.2469 20.6731 17.5259 20.5021 17.6969C20.0221 18.0989 19.1671 18.8429 18.6991 19.2569L18.6901 19.2509L18.6871 19.2479Z" fill="white"/>
            <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;

        case 'Flipkart':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M22.5544 10.0979C22.5484 10.0769 22.5424 10.0559 22.5334 10.0349C17.5084 10.0349 12.4864 10.0349 7.46736 10.0349C7.45536 10.0499 7.44636 10.0649 7.44336 10.0829C7.44336 13.9799 7.44336 17.8709 7.44336 21.7679C7.47636 21.9749 7.59036 22.1639 7.74336 22.3079C7.74936 22.3079 7.76436 22.3109 7.77036 22.3139C7.84836 22.3979 7.96236 22.4369 8.06736 22.4759C8.14536 22.4699 8.22336 22.5059 8.30136 22.4969H14.5354C14.5954 22.4969 14.6554 22.5059 14.7124 22.4819C14.7124 22.4729 14.7184 22.4579 14.7184 22.4489C14.7184 22.4399 14.7214 22.4159 14.7244 22.4039C14.8594 21.6569 14.9884 20.9099 15.1294 20.1629C15.1354 20.1299 15.1384 20.0999 15.1414 20.0669C14.5654 20.0669 13.9864 20.0669 13.4074 20.0669C13.2664 20.0609 13.1224 20.0669 12.9844 20.0489C12.7444 20.0399 12.5044 20.0489 12.2644 20.0249C11.9674 20.0249 11.6734 19.9979 11.3764 19.9979C11.1424 19.9739 10.9084 19.9829 10.6714 19.9709C10.5184 19.9529 10.3624 19.9619 10.2064 19.9529C9.95436 19.9259 9.69636 19.9439 9.44436 19.9169C9.17736 19.9169 8.91036 19.8959 8.64336 19.8899C8.64336 19.8899 8.64636 19.8809 8.64636 19.8779C8.73636 19.8779 8.82336 19.8719 8.91036 19.8719C9.10836 19.8479 9.30636 19.8629 9.50436 19.8359C9.71136 19.8359 9.91236 19.8089 10.1194 19.8089C10.3024 19.7819 10.4854 19.7999 10.6684 19.7729C10.8814 19.7729 11.0914 19.7459 11.3074 19.7429C11.4844 19.7189 11.6614 19.7339 11.8384 19.7099C12.0454 19.7099 12.2464 19.6799 12.4534 19.6829C12.6544 19.6589 12.8614 19.6649 13.0624 19.6439C13.0444 19.5659 13.0294 19.4879 13.0114 19.4099C12.9964 19.3619 12.9364 19.3709 12.9004 19.3649C12.4384 19.2989 11.9824 19.2329 11.5234 19.1699C11.5534 19.1459 11.5924 19.1579 11.6284 19.1519C11.9854 19.1249 12.3394 19.0919 12.6964 19.0679C12.7774 19.0619 12.8554 19.0499 12.9364 19.0469C12.9004 18.9359 12.8794 18.8159 12.8314 18.7139C12.0694 18.5969 11.3104 18.4919 10.5484 18.3689C10.7464 18.3359 10.9444 18.3239 11.1424 18.2999L11.1604 18.2939C11.7904 18.2279 12.4234 18.1529 13.0534 18.0929C13.8544 18.0899 14.6494 18.0929 15.4504 18.0929C15.4744 18.0899 15.5194 18.1019 15.5254 18.0659C15.5914 17.7209 15.6544 17.3789 15.7204 17.0339C15.8104 16.5569 15.9544 16.0859 16.1794 15.6509C16.5304 14.9519 17.0824 14.3579 17.7574 13.9619C18.3874 13.5929 19.1164 13.4159 19.8424 13.3799C20.0764 13.3589 20.3164 13.3649 20.5474 13.3949C20.7004 13.4309 20.8564 13.4729 20.9764 13.5779C21.0754 13.6589 21.1354 13.7759 21.1804 13.8959C21.2764 14.1779 21.3334 14.4719 21.3784 14.7659C21.3784 14.8859 21.4024 15.0179 21.3394 15.1259C21.2794 15.2309 21.1624 15.2819 21.0484 15.3149C20.6374 15.4199 20.2114 15.3209 19.8004 15.4199C19.4644 15.4919 19.1494 15.6779 18.9364 15.9479C18.6844 16.2599 18.5494 16.6529 18.4744 17.0429C18.4174 17.3909 18.3454 17.7389 18.2884 18.0899C18.6904 18.0899 19.0954 18.0899 19.5004 18.0899C19.6624 18.0899 19.8274 18.1799 19.8934 18.3329C19.9774 18.5279 19.9594 18.7499 19.9324 18.9539C19.8994 19.1849 19.8424 19.4159 19.7404 19.6259C19.6534 19.8059 19.5094 19.9709 19.3114 20.0369C19.2094 20.0789 19.0984 20.0699 18.9904 20.0699C18.6334 20.0699 18.2764 20.0759 17.9224 20.0699C17.8654 20.3309 17.8264 20.5979 17.7754 20.8619C17.6824 21.3779 17.5924 21.8939 17.4964 22.4129C17.4964 22.4309 17.4934 22.4669 17.4934 22.4849C17.6614 22.4939 17.8294 22.4849 17.9944 22.4909C19.2364 22.4909 20.4814 22.4909 21.7264 22.4909C21.8614 22.4969 21.9964 22.4639 22.1134 22.3979C22.1824 22.3739 22.2244 22.3109 22.2874 22.2779C22.3474 22.2449 22.3624 22.1729 22.4134 22.1309C22.4674 22.0349 22.5244 21.9329 22.5304 21.8159C22.5364 21.8159 22.5544 21.8159 22.5634 21.8129C22.5574 17.9099 22.5634 14.0099 22.5574 10.1069L22.5544 10.0979Z" fill="url(#paint0_linear_2107_18212)" stroke="#FCD109" stroke-width="0.09"/>
              <path d="M9.42021 7.533C9.60021 7.476 9.78921 7.515 9.97221 7.5C13.4342 7.5 16.8992 7.5 20.3612 7.5C20.5682 7.491 20.7482 7.608 20.9372 7.668C21.0902 7.728 21.2492 7.779 21.4022 7.845C21.4352 7.857 21.4562 7.884 21.4802 7.908C21.4802 8.187 21.4802 8.469 21.4802 8.751C21.4802 8.826 21.4712 8.901 21.4952 8.973C21.5402 8.979 21.5642 9.012 21.5912 9.042C21.7322 9.105 21.8492 9.21 21.9782 9.294C22.1702 9.429 22.3742 9.549 22.5602 9.687C22.5692 9.741 22.5602 9.798 22.5452 9.849C22.5272 9.909 22.5392 9.972 22.5332 10.032C17.5082 10.032 12.4862 10.032 7.46721 10.032C7.45821 9.963 7.47621 9.891 7.44621 9.825C7.44021 9.771 7.42221 9.699 7.47621 9.66C7.68921 9.513 7.91421 9.378 8.12121 9.222C8.25021 9.138 8.37621 9.054 8.50221 8.97C8.52921 8.928 8.52021 8.874 8.52021 8.829C8.52021 8.52 8.52021 8.214 8.52021 7.908C8.59221 7.815 8.71821 7.803 8.81721 7.758C9.01821 7.683 9.22221 7.608 9.42021 7.53M9.43221 7.566C9.15921 7.671 8.88621 7.77 8.61621 7.875C8.58021 7.881 8.56221 7.914 8.54121 7.941C8.54121 7.959 8.54421 7.986 8.54421 8.004C8.54421 8.259 8.54421 8.514 8.54421 8.769C8.54421 8.832 8.53821 8.895 8.56221 8.952C8.53521 8.979 8.50521 9.006 8.47221 9.027C8.16321 9.225 7.86921 9.441 7.56021 9.639C7.50621 9.672 7.44921 9.714 7.46421 9.783C7.45521 9.822 7.47321 9.852 7.51221 9.843C8.17821 9.837 8.84121 9.849 9.50721 9.837C10.4972 9.837 11.4872 9.837 12.4772 9.837L12.4922 9.831C12.5372 9.84 12.5822 9.837 12.6272 9.837C14.4212 9.837 16.2152 9.837 18.0122 9.837C18.5762 9.837 19.1432 9.837 19.7072 9.837C20.6402 9.837 21.5762 9.846 22.5092 9.843C22.5362 9.837 22.5452 9.819 22.5362 9.783C22.5362 9.75 22.5452 9.702 22.5092 9.681C22.3622 9.612 22.2332 9.504 22.0922 9.417C22.0412 9.375 21.9752 9.351 21.9362 9.294C21.7892 9.21 21.6542 9.111 21.5102 9.018C21.4832 9 21.4622 8.973 21.4382 8.949C21.4502 8.904 21.4562 8.856 21.4562 8.808C21.4562 8.538 21.4562 8.268 21.4562 8.001C21.4622 7.959 21.4592 7.911 21.4232 7.881C21.1682 7.791 20.9162 7.692 20.6642 7.599C20.5862 7.56 20.4992 7.539 20.4152 7.527H9.56721C9.52221 7.527 9.47721 7.554 9.42921 7.563L9.43221 7.566Z" fill="#F8F3B5"/>
              <path d="M9.42021 7.533C9.60021 7.476 9.78921 7.515 9.97221 7.5C13.4342 7.5 16.8992 7.5 20.3612 7.5C20.5682 7.491 20.7482 7.608 20.9372 7.668C21.0902 7.728 21.2492 7.779 21.4022 7.845C21.4352 7.857 21.4562 7.884 21.4802 7.908C21.4802 8.187 21.4802 8.469 21.4802 8.751C21.4802 8.826 21.4712 8.901 21.4952 8.973C21.5402 8.979 21.5642 9.012 21.5912 9.042C21.7322 9.105 21.8492 9.21 21.9782 9.294C22.1702 9.429 22.3742 9.549 22.5602 9.687C22.5692 9.741 22.5602 9.798 22.5452 9.849C22.5272 9.909 22.5392 9.972 22.5332 10.032C17.5082 10.032 12.4862 10.032 7.46721 10.032C7.45821 9.963 7.47621 9.891 7.44621 9.825C7.44021 9.771 7.42221 9.699 7.47621 9.66C7.68921 9.513 7.91421 9.378 8.12121 9.222C8.25021 9.138 8.37621 9.054 8.50221 8.97C8.52921 8.928 8.52021 8.874 8.52021 8.829C8.52021 8.52 8.52021 8.214 8.52021 7.908C8.59221 7.815 8.71821 7.803 8.81721 7.758C9.01821 7.683 9.22221 7.608 9.42021 7.53M9.43221 7.566C9.15921 7.671 8.88621 7.77 8.61621 7.875C8.58021 7.881 8.56221 7.914 8.54121 7.941C8.54121 7.959 8.54421 7.986 8.54421 8.004C8.54421 8.259 8.54421 8.514 8.54421 8.769C8.54421 8.832 8.53821 8.895 8.56221 8.952C8.53521 8.979 8.50521 9.006 8.47221 9.027C8.16321 9.225 7.86921 9.441 7.56021 9.639C7.50621 9.672 7.44921 9.714 7.46421 9.783C7.45521 9.822 7.47321 9.852 7.51221 9.843C8.17821 9.837 8.84121 9.849 9.50721 9.837C10.4972 9.837 11.4872 9.837 12.4772 9.837L12.4922 9.831C12.5372 9.84 12.5822 9.837 12.6272 9.837C14.4212 9.837 16.2152 9.837 18.0122 9.837C18.5762 9.837 19.1432 9.837 19.7072 9.837C20.6402 9.837 21.5762 9.846 22.5092 9.843C22.5362 9.837 22.5452 9.819 22.5362 9.783C22.5362 9.75 22.5452 9.702 22.5092 9.681C22.3622 9.612 22.2332 9.504 22.0922 9.417C22.0412 9.375 21.9752 9.351 21.9362 9.294C21.7892 9.21 21.6542 9.111 21.5102 9.018C21.4832 9 21.4622 8.973 21.4382 8.949C21.4502 8.904 21.4562 8.856 21.4562 8.808C21.4562 8.538 21.4562 8.268 21.4562 8.001C21.4622 7.959 21.4592 7.911 21.4232 7.881C21.1682 7.791 20.9162 7.692 20.6642 7.599C20.5862 7.56 20.4992 7.539 20.4152 7.527H9.56721C9.52221 7.527 9.47721 7.554 9.42921 7.563L9.43221 7.566Z" stroke="#F8F3B5" stroke-width="0.09"/>
              <path d="M8.54402 8.00708C8.73002 8.08508 8.93102 8.13008 9.12002 8.20508C9.22202 8.24408 9.25502 8.35508 9.29702 8.44508C9.25202 8.49008 9.20102 8.52608 9.14702 8.55908C8.95202 8.69108 8.75402 8.81708 8.55902 8.95508C8.53502 8.89808 8.54402 8.83508 8.54102 8.77208C8.54102 8.51708 8.54102 8.26208 8.54102 8.00708H8.54402Z" fill="#F7B402" stroke="#F7B402" stroke-width="0.09"/>
              <path d="M20.8773 8.20508C21.0663 8.13008 21.2643 8.07908 21.4533 8.00708C21.4533 8.27708 21.4533 8.54708 21.4533 8.81408C21.4533 8.85908 21.4473 8.91008 21.4353 8.95508C21.2703 8.84108 21.1023 8.73308 20.9373 8.61908C20.8563 8.55908 20.7663 8.51408 20.6943 8.44208C20.7393 8.35208 20.7723 8.24408 20.8743 8.20508H20.8773Z" fill="#F7B402" stroke="#F7B402" stroke-width="0.09"/>
              <path d="M11.7814 8.29209C12.0154 8.23809 12.2764 8.44509 12.2554 8.68809C12.2554 8.92809 12.0064 9.12309 11.7754 9.06909C11.6824 9.03609 11.5924 8.98809 11.5354 8.90709C11.4604 8.79609 11.4454 8.64309 11.5024 8.52009C11.5444 8.40009 11.6584 8.32209 11.7814 8.29209Z" fill="#BDA727" stroke="#BDA727" stroke-width="0.09"/>
              <path d="M17.8324 8.42707C17.9284 8.31907 18.0844 8.25607 18.2284 8.29507C18.3364 8.32807 18.4414 8.39707 18.4894 8.50207C18.5824 8.68507 18.5104 8.93107 18.3274 9.02707C18.1654 9.11707 17.9614 9.07207 17.8384 8.94307C17.7124 8.80207 17.7034 8.56807 17.8294 8.42707H17.8324Z" fill="#BDA727" stroke="#BDA727" stroke-width="0.09"/>
              <path d="M9.14727 8.55907C9.20127 8.52607 9.25227 8.49007 9.29727 8.44507L9.31227 8.46007C9.32727 8.57107 9.31827 8.68207 9.32127 8.79307C9.31527 9.12307 9.32727 9.45607 9.31227 9.78907C8.69427 9.78907 8.07927 9.78307 7.46127 9.78907C7.44327 9.72007 7.50327 9.67807 7.55727 9.64507C7.86627 9.44707 8.16027 9.23107 8.46927 9.03307C8.50227 9.01207 8.53227 8.98507 8.55927 8.95807C8.75127 8.82307 8.95227 8.69407 9.14727 8.56207V8.55907Z" fill="#F7E62D" stroke="#F7E62D" stroke-width="0.09"/>
              <path d="M20.6758 8.51689C20.6758 8.48989 20.6818 8.46589 20.6968 8.44189C20.7688 8.51389 20.8588 8.55889 20.9398 8.61889C21.1048 8.72989 21.2728 8.8409 21.4378 8.9549C21.4618 8.9789 21.4828 9.00589 21.5098 9.02389C21.6538 9.11389 21.7888 9.2159 21.9358 9.2999C21.9748 9.3569 22.0408 9.3809 22.0918 9.4229C22.2328 9.5069 22.3618 9.6149 22.5088 9.6869C22.5448 9.7079 22.5328 9.7559 22.5358 9.7889C21.9178 9.7889 21.3028 9.7889 20.6878 9.7889C20.6788 9.7049 20.6818 9.6179 20.6818 9.5369C20.6818 9.1979 20.6788 8.85889 20.6818 8.51989L20.6758 8.51689Z" fill="#F7E62D" stroke="#F7E62D" stroke-width="0.09"/>
              <path d="M22.5334 9.78596C21.9154 9.78596 21.3004 9.78596 20.6854 9.78596C20.6734 9.70196 20.6794 9.61496 20.6794 9.53396C20.6794 9.19496 20.6734 8.85596 20.6794 8.51696C20.6794 8.48996 20.6854 8.46596 20.7004 8.44196C20.7454 8.35196 20.7784 8.24396 20.8804 8.20496C21.0694 8.12996 21.2674 8.07896 21.4564 8.00696C21.4624 7.96496 21.4594 7.91696 21.4234 7.88696C21.1684 7.79696 20.9164 7.69796 20.6644 7.60496C20.5864 7.56596 20.4994 7.54496 20.4154 7.53296H9.57038C9.52538 7.53296 9.48038 7.55996 9.43238 7.56896C9.15938 7.67396 8.88638 7.77296 8.61638 7.87796C8.58038 7.88396 8.56238 7.91696 8.54138 7.94396C8.54138 7.96196 8.54438 7.98896 8.54438 8.00696C8.73038 8.08496 8.93138 8.12996 9.12038 8.20496C9.22238 8.24396 9.25538 8.35496 9.29738 8.44496L9.31238 8.45996C9.32738 8.57096 9.31838 8.68196 9.32138 8.79296C9.31538 9.12296 9.32738 9.45596 9.31238 9.78896C8.69438 9.78896 8.07938 9.78296 7.46138 9.78896C7.44938 9.82796 7.47038 9.85796 7.50938 9.84896C8.17538 9.84296 8.83838 9.85496 9.50438 9.84296C10.4944 9.84296 11.4814 9.84296 12.4744 9.84296L12.4894 9.83696C12.5344 9.84596 12.5794 9.84296 12.6244 9.84296C14.4184 9.84296 16.2124 9.84296 18.0094 9.84296C18.5734 9.84296 19.1404 9.84296 19.7044 9.84296C20.6374 9.84296 21.5734 9.85196 22.5064 9.84896C22.5334 9.84296 22.5424 9.82496 22.5334 9.78896V9.78596ZM11.5024 8.51996C11.5444 8.39996 11.6584 8.32196 11.7814 8.29196C12.0154 8.23796 12.2764 8.44496 12.2554 8.68796C12.2554 8.92796 12.0064 9.12296 11.7754 9.06896C11.6824 9.03596 11.5924 8.98796 11.5354 8.90696C11.4604 8.79596 11.4454 8.64296 11.5024 8.51996ZM17.8294 8.42696C17.9254 8.31896 18.0814 8.25596 18.2254 8.29496C18.3334 8.32796 18.4384 8.39696 18.4864 8.50196C18.5794 8.68496 18.5074 8.93096 18.3244 9.02696C18.1624 9.11696 17.9584 9.07196 17.8354 8.94296C17.7094 8.80196 17.7004 8.56796 17.8264 8.42696H17.8294Z" fill="url(#paint1_radial_2107_18212)" stroke="#FCD109" stroke-width="0.09"/>
              <path d="M18.3717 10.716C18.4017 10.722 18.2157 10.539 18.2517 10.53C18.2847 10.536 18.4137 10.434 18.5697 10.515C18.7257 10.596 18.6867 10.788 18.6687 10.857C18.6477 10.941 18.5937 10.995 18.5517 11.037C18.5277 11.055 18.4767 11.085 18.4437 11.082C18.4617 10.977 18.4017 10.962 18.3987 10.854L18.3717 10.71V10.716Z" fill="url(#paint2_linear_2107_18212)" stroke="#FCD109" stroke-width="0.09"/>
              <path d="M11.5916 10.8331C11.5856 10.9381 11.5256 10.9561 11.5466 11.0611C11.5136 11.0611 11.4626 11.0341 11.4386 11.0161C11.3966 10.9741 11.3426 10.9201 11.3216 10.8361C11.3036 10.7641 11.2646 10.5751 11.4206 10.4941C11.5766 10.4131 11.7056 10.5121 11.7386 10.5091C11.7746 10.5181 11.5916 10.7011 11.6186 10.6951L11.5916 10.8391V10.8331Z" fill="url(#paint3_linear_2107_18212)" stroke="#FCD109" stroke-width="0.09"/>
              <path d="M18.0959 12.0751C18.1289 12.0481 18.1499 12.0481 18.1919 12.0481C17.9369 12.6001 17.6399 13.1521 17.1929 13.5811C17.1449 13.6231 17.0969 13.6621 17.0429 13.6981C16.9919 13.7341 16.9409 13.7701 16.8929 13.8061C16.8449 13.8391 16.7969 13.8751 16.7489 13.9081C16.6289 13.9741 16.5209 14.0641 16.3889 14.1061C16.1459 14.2231 15.8819 14.3011 15.6179 14.3551C15.5129 14.3731 15.4079 14.3971 15.3029 14.4001C15.1709 14.4391 15.0299 14.4121 14.8979 14.4181C14.8229 14.4301 14.7569 14.3881 14.6849 14.3971C14.6219 14.3881 14.5589 14.3791 14.4989 14.3641C14.4359 14.3521 14.3729 14.3371 14.3099 14.3191C13.3379 14.0161 12.3839 13.2721 12.1049 12.2701C12.0929 12.2041 12.0869 12.1351 12.0869 12.0661C12.1169 12.1261 12.1469 12.1831 12.1799 12.2431C12.5759 13.1041 13.3589 13.7851 14.2859 13.9891C14.3609 14.0221 14.4419 14.0131 14.5139 14.0401C14.5799 14.0401 14.6429 14.0401 14.7059 14.0581C14.9249 14.0641 15.1439 14.0581 15.3599 14.0581C15.3899 14.0581 15.4169 14.0461 15.4469 14.0401C15.8099 14.0281 16.1669 13.9291 16.4999 13.7761C16.5659 13.7461 16.6319 13.7131 16.6949 13.6801C16.7519 13.6501 16.8059 13.6171 16.8599 13.5841C16.9139 13.5511 16.9649 13.5151 17.0129 13.4761C17.4059 13.1641 17.7449 12.7621 17.9759 12.3001C18.0209 12.2161 18.0599 12.1381 18.0959 12.0691V12.0751Z" fill="#BDA727" stroke="#BDA727" stroke-width="0.09"/>
              <path d="M17.7479 13.9621C18.3779 13.5931 19.1069 13.4161 19.8329 13.3801C20.0669 13.3591 20.3069 13.3651 20.5379 13.3951C20.6909 13.4311 20.8469 13.4731 20.9669 13.5781C20.9069 13.5841 20.8469 13.5541 20.7839 13.5451C20.6099 13.5121 20.4299 13.5241 20.2529 13.5211C19.7399 13.5211 19.2269 13.5601 18.7319 13.7011C18.4739 13.7791 18.2159 13.8721 17.9789 14.0071C17.5709 14.2321 17.2049 14.5291 16.9079 14.8861C16.3769 15.4951 16.0649 16.2661 15.9149 17.0521C15.8429 17.4751 15.7589 17.8951 15.6929 18.3181C15.5879 18.3271 15.4799 18.3241 15.3719 18.3241C14.9069 18.3241 14.4389 18.3181 13.9709 18.3151C13.8719 18.3211 13.7729 18.2971 13.6739 18.3031C12.8249 18.3091 11.9789 18.3031 11.1299 18.3031L11.1479 18.2971C11.7779 18.2311 12.4109 18.1561 13.0409 18.0961C13.8419 18.0931 14.6369 18.0961 15.4379 18.0961C15.4619 18.0931 15.5069 18.1051 15.5129 18.0691C15.5789 17.7271 15.6419 17.3821 15.7079 17.0371C15.8009 16.5601 15.9419 16.0891 16.1669 15.6541C16.5179 14.9551 17.0699 14.3611 17.7449 13.9651L17.7479 13.9621Z" fill="#0D69B3" stroke="#0D69B3" stroke-width="0.09"/>
              <path d="M18.7376 13.701C19.2326 13.56 19.7456 13.521 20.2586 13.521C20.4356 13.527 20.6156 13.512 20.7896 13.545C20.8496 13.554 20.9096 13.581 20.9726 13.578C21.0716 13.659 21.1316 13.776 21.1766 13.896C21.2726 14.178 21.3296 14.472 21.3746 14.766C21.3746 14.886 21.3986 15.018 21.3356 15.126C21.2756 15.231 21.1586 15.282 21.0446 15.315C20.6336 15.42 20.2076 15.321 19.7966 15.42C19.4606 15.492 19.1456 15.678 18.9296 15.948C18.6776 16.26 18.5426 16.653 18.4676 17.043C18.4106 17.391 18.3386 17.739 18.2816 18.09C18.2546 18.168 18.2426 18.252 18.2276 18.336C18.6296 18.342 19.0286 18.336 19.4306 18.342C19.5836 18.336 19.7366 18.348 19.8896 18.336C19.9736 18.531 19.9556 18.753 19.9286 18.957C19.8956 19.188 19.8386 19.416 19.7366 19.629C19.6496 19.809 19.5056 19.974 19.3076 20.04C19.2056 20.079 19.0946 20.073 18.9866 20.073C18.6296 20.073 18.2726 20.076 17.9186 20.073C17.8616 20.334 17.8226 20.601 17.7716 20.865C17.6786 21.381 17.5886 21.897 17.4926 22.416C17.4926 22.434 17.4896 22.47 17.4896 22.488C16.5626 22.488 15.6386 22.491 14.7116 22.488C14.7116 22.479 14.7176 22.464 14.7176 22.455C14.7176 22.446 14.7206 22.422 14.7236 22.41C14.7236 22.428 14.7266 22.458 14.7296 22.473C14.7866 22.479 14.8916 22.509 14.9066 22.428C15.0506 21.648 15.1856 20.862 15.3326 20.082C15.2756 20.07 15.2156 20.07 15.1556 20.082C15.1466 20.112 15.1376 20.142 15.1286 20.172C15.1316 20.139 15.1376 20.109 15.1406 20.076C14.5646 20.076 13.9856 20.076 13.4066 20.076C13.2656 20.073 13.1216 20.076 12.9836 20.058C12.7436 20.049 12.5036 20.058 12.2636 20.031C11.9666 20.031 11.6726 20.004 11.3756 20.004C11.1416 19.98 10.9076 19.989 10.6706 19.98C10.5176 19.962 10.3616 19.968 10.2056 19.962C9.95358 19.935 9.69558 19.953 9.44358 19.926C9.17658 19.926 8.90958 19.905 8.64258 19.899L8.64558 19.887C8.73558 19.887 8.82258 19.881 8.90958 19.881C9.10758 19.857 9.30558 19.872 9.50358 19.845C9.71058 19.845 9.91458 19.818 10.1186 19.818C10.3016 19.794 10.4846 19.809 10.6676 19.782C10.8806 19.782 11.0906 19.755 11.3066 19.752C11.4836 19.728 11.6606 19.743 11.8376 19.719C12.0446 19.719 12.2456 19.689 12.4526 19.692C12.6536 19.668 12.8606 19.674 13.0616 19.653C13.0436 19.575 13.0286 19.497 13.0106 19.419C12.9956 19.371 12.9356 19.38 12.8996 19.374C12.4376 19.308 11.9816 19.242 11.5226 19.179C11.5526 19.155 11.5916 19.167 11.6276 19.161C11.9846 19.134 12.3386 19.101 12.6956 19.077C12.7766 19.071 12.8546 19.059 12.9356 19.056C12.8996 18.945 12.8786 18.825 12.8306 18.723C12.0686 18.606 11.3096 18.501 10.5476 18.378C10.7456 18.345 10.9436 18.333 11.1416 18.309C11.9906 18.309 12.8366 18.315 13.6856 18.309C13.7846 18.303 13.8836 18.327 13.9826 18.321C14.4476 18.327 14.9156 18.327 15.3836 18.33C15.4886 18.33 15.5966 18.336 15.7046 18.324C15.7706 17.901 15.8516 17.481 15.9266 17.058C16.0766 16.272 16.3886 15.498 16.9196 14.892C17.2166 14.535 17.5826 14.238 17.9906 14.013C18.2246 13.878 18.4856 13.788 18.7436 13.707L18.7376 13.701Z" fill="#107BD4" stroke="#107BD4" stroke-width="0.09"/>
              <path d="M18.2816 18.087C18.6836 18.087 19.0886 18.087 19.4936 18.087C19.6556 18.087 19.8206 18.177 19.8866 18.33C19.7336 18.342 19.5806 18.33 19.4276 18.336C19.0256 18.33 18.6266 18.336 18.2246 18.33C18.2396 18.246 18.2546 18.162 18.2786 18.084L18.2816 18.087Z" fill="#0D69B3" stroke="#0D69B3" stroke-width="0.09"/>
              <path d="M15.1556 20.0759C15.2156 20.0639 15.2756 20.0639 15.3326 20.0759C15.1856 20.8559 15.0506 21.6419 14.9066 22.4219C14.8916 22.5059 14.7866 22.4759 14.7296 22.4669C14.7296 22.4519 14.7266 22.4219 14.7236 22.4039C14.8586 21.6569 14.9876 20.9099 15.1286 20.1629C15.1406 20.1329 15.1466 20.1029 15.1556 20.0729V20.0759Z" fill="#0D69B3" stroke="#0D69B3" stroke-width="0.09"/>
              <path d="M18.4676 10.7759C18.4496 10.7429 18.4496 10.707 18.4496 10.671H18.4316C18.4046 10.578 18.3266 10.4909 18.2246 10.4879C18.1496 10.4819 18.0536 10.4819 18.0086 10.5569C17.9246 10.6709 17.9636 10.818 17.9606 10.947C17.9606 10.956 17.9606 10.9709 17.9606 10.9799C17.9606 11.0669 17.9486 11.1509 17.9336 11.2379C17.9216 11.2619 17.9156 11.292 17.9156 11.322C17.8796 11.52 17.8076 11.718 17.7086 11.898C17.6906 11.922 17.6756 11.9519 17.6696 11.9819C17.6066 12.0929 17.5286 12.1949 17.4506 12.2939C17.4386 12.3059 17.4266 12.3179 17.4176 12.3299C17.3636 12.3989 17.3036 12.4559 17.2406 12.5129C17.2256 12.5219 17.2166 12.5309 17.2016 12.5399C17.1296 12.6089 17.0486 12.675 16.9616 12.729C16.9526 12.735 16.9406 12.7439 16.9286 12.7529C16.3856 13.1129 15.7256 13.26 15.0836 13.266C14.5376 13.284 13.9886 13.1669 13.4966 12.9299C13.4876 12.9239 13.4666 12.918 13.4576 12.912C13.3736 12.867 13.2896 12.828 13.2146 12.774C13.1966 12.765 13.1816 12.756 13.1606 12.747C13.0826 12.702 13.0076 12.651 12.9386 12.591C12.9146 12.57 12.8906 12.5519 12.8636 12.5339C12.7856 12.4739 12.7076 12.408 12.6416 12.333C12.6236 12.315 12.6086 12.297 12.5906 12.279C12.3596 12.039 12.1796 11.7479 12.0836 11.4299C11.9936 11.1779 12.0056 10.9019 11.9936 10.6379C11.9156 10.5209 11.7566 10.455 11.6276 10.527C11.5736 10.566 11.5676 10.635 11.5286 10.683C11.4626 11.382 11.7626 12.081 12.2396 12.585C12.2396 12.603 12.2486 12.612 12.2636 12.618C12.3476 12.696 12.4316 12.777 12.5156 12.852C12.5306 12.867 12.5486 12.8819 12.5666 12.8939C12.6506 12.9629 12.7436 13.0289 12.8306 13.0919C12.8486 13.1039 12.8636 13.116 12.8846 13.125C13.0016 13.194 13.1126 13.272 13.2356 13.32C13.2446 13.326 13.2596 13.338 13.2686 13.341C13.6706 13.533 14.1056 13.6649 14.5526 13.7069C14.6006 13.7069 14.6486 13.713 14.6996 13.722C14.9126 13.734 15.1226 13.728 15.3356 13.722C15.9896 13.665 16.6676 13.5059 17.2136 13.1189L17.2196 13.1279C17.2376 13.1129 17.2526 13.101 17.2676 13.089C17.3546 13.026 17.4386 12.9569 17.5256 12.8879C17.5436 12.8729 17.5646 12.855 17.5856 12.837C17.6786 12.735 17.7866 12.642 17.8646 12.525L17.8766 12.531C17.8766 12.531 17.8946 12.498 17.9006 12.489C17.9726 12.393 18.0386 12.291 18.1016 12.189C18.1046 12.183 18.1166 12.1709 18.1196 12.1649L18.1106 12.156C18.1106 12.156 18.1316 12.132 18.1376 12.123C18.2546 11.886 18.3596 11.637 18.3956 11.373C18.4106 11.367 18.4196 11.3549 18.4196 11.3399C18.4196 11.2559 18.4526 11.175 18.4436 11.091C18.4616 10.986 18.4646 10.8809 18.4616 10.7759H18.4676Z" fill="white" stroke="white" stroke-width="0.09"/>
              <mask id="mask0_2107_18212" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="11" y="10" width="8" height="4">
              <path d="M18.4676 10.7759C18.4496 10.7429 18.4496 10.707 18.4496 10.671H18.4316C18.4046 10.578 18.3266 10.4909 18.2246 10.4879C18.1496 10.4819 18.0536 10.4819 18.0086 10.5569C17.9246 10.6709 17.9636 10.818 17.9606 10.947C17.9606 10.956 17.9606 10.9709 17.9606 10.9799C17.9606 11.0669 17.9486 11.1509 17.9336 11.2379C17.9216 11.2619 17.9156 11.292 17.9156 11.322C17.8796 11.52 17.8076 11.718 17.7086 11.898C17.6906 11.922 17.6756 11.9519 17.6696 11.9819C17.6066 12.0929 17.5286 12.1949 17.4506 12.2939C17.4386 12.3059 17.4266 12.3179 17.4176 12.3299C17.3636 12.3989 17.3036 12.4559 17.2406 12.5129C17.2256 12.5219 17.2166 12.5309 17.2016 12.5399C17.1296 12.6089 17.0486 12.675 16.9616 12.729C16.9526 12.735 16.9406 12.7439 16.9286 12.7529C16.3856 13.1129 15.7256 13.26 15.0836 13.266C14.5376 13.284 13.9886 13.1669 13.4966 12.9299C13.4876 12.9239 13.4666 12.918 13.4576 12.912C13.3736 12.867 13.2896 12.828 13.2146 12.774C13.1966 12.765 13.1816 12.756 13.1606 12.747C13.0826 12.702 13.0076 12.651 12.9386 12.591C12.9146 12.57 12.8906 12.5519 12.8636 12.5339C12.7856 12.4739 12.7076 12.408 12.6416 12.333C12.6236 12.315 12.6086 12.297 12.5906 12.279C12.3596 12.039 12.1796 11.7479 12.0836 11.4299C11.9936 11.1779 12.0056 10.9019 11.9936 10.6379C11.9156 10.5209 11.7566 10.455 11.6276 10.527C11.5736 10.566 11.5676 10.635 11.5286 10.683C11.4626 11.382 11.7626 12.081 12.2396 12.585C12.2396 12.603 12.2486 12.612 12.2636 12.618C12.3476 12.696 12.4316 12.777 12.5156 12.852C12.5306 12.867 12.5486 12.8819 12.5666 12.8939C12.6506 12.9629 12.7436 13.0289 12.8306 13.0919C12.8486 13.1039 12.8636 13.116 12.8846 13.125C13.0016 13.194 13.1126 13.272 13.2356 13.32C13.2446 13.326 13.2596 13.338 13.2686 13.341C13.6706 13.533 14.1056 13.6649 14.5526 13.7069C14.6006 13.7069 14.6486 13.713 14.6996 13.722C14.9126 13.734 15.1226 13.728 15.3356 13.722C15.9896 13.665 16.6676 13.5059 17.2136 13.1189L17.2196 13.1279C17.2376 13.1129 17.2526 13.101 17.2676 13.089C17.3546 13.026 17.4386 12.9569 17.5256 12.8879C17.5436 12.8729 17.5646 12.855 17.5856 12.837C17.6786 12.735 17.7866 12.642 17.8646 12.525L17.8766 12.531C17.8766 12.531 17.8946 12.498 17.9006 12.489C17.9726 12.393 18.0386 12.291 18.1016 12.189C18.1046 12.183 18.1166 12.1709 18.1196 12.1649L18.1106 12.156C18.1106 12.156 18.1316 12.132 18.1376 12.123C18.2546 11.886 18.3596 11.637 18.3956 11.373C18.4106 11.367 18.4196 11.3549 18.4196 11.3399C18.4196 11.2559 18.4526 11.175 18.4436 11.091C18.4616 10.986 18.4646 10.8809 18.4616 10.7759H18.4676Z" fill="white"/>
              </mask>
              <g mask="url(#mask0_2107_18212)">
              <path d="M11.376 10.7039C11.547 10.7579 11.943 10.6229 12.054 10.7459" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M11.4746 11.229C11.6396 11.172 11.9936 11.037 12.1376 11.115" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M11.6455 11.7508C11.7235 11.7778 11.8825 11.6368 11.9605 11.5948C12.0775 11.5348 12.1945 11.4868 12.3235 11.4658" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M11.8984 12.3028C11.9794 12.1858 12.0784 12.0898 12.1984 12.0058C12.3154 11.9248 12.6364 11.7028 12.7744 11.7808" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M12.1377 12.6988C12.2307 12.6238 12.2697 12.4948 12.3657 12.4168C12.4857 12.3238 12.6657 12.3058 12.7857 12.2488" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M12.54 12.9928C12.567 12.7888 12.777 12.5398 12.975 12.5578" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M12.8457 13.2779C12.9507 13.2689 13.0407 13.0319 13.1097 12.9539C13.2147 12.8339 13.3257 12.7979 13.4667 12.7559" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M13.4552 13.533C13.4492 13.386 13.6022 12.96 13.7792 12.981" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M13.9046 13.6739C13.8986 13.4999 13.9886 12.9719 14.2016 12.9539" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M14.3733 13.956C14.3313 13.71 14.3343 13.356 14.5293 13.179" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M14.9515 14.0128C14.9305 13.8088 14.7265 13.3948 14.9515 13.2358" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M15.5756 13.8718C15.4796 13.7608 15.4226 13.3168 15.4616 13.1938" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M16.1667 13.773C16.0917 13.638 15.9987 13.509 15.9717 13.353C15.9537 13.26 15.9837 13.125 15.9717 13.053" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M16.6623 13.56C16.5003 13.455 16.4553 13.065 16.5063 12.897" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M17.1453 13.347C17.0313 13.098 16.9083 12.909 16.9053 12.627" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M17.6098 12.8969C17.4298 12.7769 17.2018 12.5579 17.2288 12.3179" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M18.1048 12.513C17.8318 12.453 17.5048 12.21 17.3428 11.991" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M18.3331 12.0478C18.1351 12.0058 17.4871 11.7538 17.5261 11.4958" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M18.5433 11.5529C18.2703 11.4509 17.8713 11.3639 17.6523 11.1719" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M18.6844 11.0999C18.5134 11.1149 18.2644 11.0309 18.0904 11.0009C17.8954 10.9679 17.7154 10.9019 17.5264 10.8599" stroke="#D1D1D1" stroke-width="2"/>
              <path d="M18.5164 10.6619C18.1834 10.6829 17.8714 10.5689 17.5684 10.4639" stroke="#D1D1D1" stroke-width="2"/>
              </g>
              <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
              <defs>
              <linearGradient id="paint0_linear_2107_18212" x1="15.0004" y1="10.0349" x2="15.0004" y2="22.4999" gradientUnits="userSpaceOnUse">
              <stop stop-color="#F7E830"/>
              <stop offset="1" stop-color="#FDCB06"/>
              </linearGradient>
              <radialGradient id="paint1_radial_2107_18212" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(14.9919 16.0864) scale(10.1697 10.1697)">
              <stop offset="0.6" stop-color="#F29405"/>
              <stop offset="0.74" stop-color="#F7D01E"/>
              <stop offset="1" stop-color="#FDCB06"/>
              </radialGradient>
              <linearGradient id="paint2_linear_2107_18212" x1="18.4677" y1="10.485" x2="18.4707" y2="11.076" gradientUnits="userSpaceOnUse">
              <stop stop-color="#FADA1C"/>
              <stop offset="1" stop-color="#FDCB06"/>
              </linearGradient>
              <linearGradient id="paint3_linear_2107_18212" x1="11.5256" y1="10.4581" x2="11.5226" y2="11.0461" gradientUnits="userSpaceOnUse">
              <stop stop-color="#FADA1C"/>
              <stop offset="1" stop-color="#FDCB06"/>
              </linearGradient>
              </defs>
          </svg>';
          break;

        case 'Myntra':
        case 'Myntra Premium':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M9.31817 9.45302C9.70517 8.99102 10.1282 8.49302 10.7192 8.30102C11.3852 8.12702 11.9522 8.64902 12.3782 9.09902C13.4822 10.359 14.2802 11.841 15.0212 13.332C15.4262 12.429 15.9242 11.568 16.4492 10.728C16.9472 9.96902 17.4602 9.19502 18.1742 8.61602C18.5042 8.36102 18.9662 8.12402 19.3772 8.33702C19.9622 8.64902 20.4062 9.15902 20.8172 9.66302C21.6962 10.791 22.3892 12.057 23.0042 13.341C23.7842 15 24.4562 16.725 24.7382 18.54C24.8252 19.38 24.9002 20.322 24.3902 21.057C23.9972 21.63 23.2502 21.831 22.5962 21.717C22.0232 21.519 21.5192 21.138 21.1442 20.664C20.2532 19.56 19.7222 18.222 19.2242 16.905C19.1492 16.674 19.0622 16.449 18.9872 16.218C18.9362 16.455 18.8702 16.68 18.7952 16.911C18.2912 18.246 17.7542 19.611 16.8332 20.718C16.4642 21.174 15.9782 21.522 15.4262 21.714C14.6282 21.882 13.8632 21.465 13.3502 20.886C12.3482 19.788 11.7872 18.381 11.2742 17.01C11.1752 16.731 11.0762 16.443 11.0012 16.155C10.9202 16.449 10.8212 16.74 10.7132 17.022C10.2512 18.288 9.72317 19.557 8.88017 20.625C8.42417 21.174 7.82717 21.708 7.08017 21.747C6.39317 21.81 5.72117 21.36 5.46017 20.73C5.08517 19.857 5.19317 18.873 5.36117 17.964C5.71517 16.224 6.38417 14.568 7.16117 12.978C7.78517 11.739 8.46917 10.536 9.32417 9.45602M9.71717 9.83702C8.86817 10.929 8.19617 12.138 7.58717 13.371C6.82817 14.967 6.14717 16.623 5.85317 18.375C5.75417 18.861 5.74817 19.365 5.80217 19.851C5.85917 20.313 6.04517 20.811 6.46817 21.054C6.87317 21.291 7.39817 21.198 7.77017 20.937C8.43617 20.475 8.87417 19.764 9.25217 19.068C10.0682 17.505 10.6052 15.816 11.0102 14.106C11.4392 15.858 11.9822 17.601 12.8432 19.191C13.1852 19.782 13.5482 20.394 14.1032 20.799C14.3822 21.048 14.7572 21.228 15.1382 21.186C15.5672 21.141 15.9302 20.868 16.2302 20.574C16.7462 20.043 17.1212 19.395 17.4512 18.741C18.1562 17.295 18.6422 15.75 19.0292 14.193C19.5032 16.08 20.0942 17.976 21.1052 19.647C21.4862 20.232 21.9332 20.844 22.6022 21.111C23.0762 21.303 23.6672 21.135 23.9372 20.694C24.2612 20.169 24.2852 19.521 24.2372 18.924C24.1682 17.958 23.8892 17.016 23.5772 16.107C22.9592 14.337 22.1492 12.642 21.1592 11.052C20.6972 10.341 20.2232 9.63002 19.5872 9.06902C19.3622 8.87102 19.0262 8.67602 18.7382 8.87702C18.1892 9.21302 17.8022 9.75002 17.4242 10.26C16.4822 11.601 15.7112 13.053 15.0752 14.553C15.0572 14.577 15.0182 14.622 15.0002 14.64C14.9432 14.472 14.8892 14.304 14.8142 14.142C14.1662 12.735 13.4372 11.349 12.5222 10.098C12.2042 9.68702 11.8862 9.26402 11.4572 8.95802C11.2772 8.82602 11.0342 8.71502 10.8152 8.82602C10.3652 9.04502 10.0412 9.46202 9.72317 9.83702" fill="#FEFEFE"/>
          <path d="M9.71054 9.83409C10.0285 9.45309 10.3465 9.04209 10.8085 8.83209C11.0275 8.72109 11.2705 8.83209 11.4505 8.96409C11.8735 9.27009 12.1975 9.69309 12.5155 10.1041C13.4305 11.3581 14.1595 12.7411 14.8075 14.1481C14.8825 14.3101 14.9395 14.4781 14.9935 14.6461C14.1445 13.2061 13.3735 11.7121 12.3145 10.4071C12.0025 10.0471 11.6785 9.66009 11.2315 9.45909C10.9765 9.35409 10.7155 9.49509 10.5085 9.63309C9.74954 10.2691 9.18854 11.1031 8.65754 11.9341C7.41254 13.9231 6.47054 16.1041 5.85254 18.3661C6.14654 16.6141 6.82454 14.9581 7.58654 13.3621C8.19254 12.1351 8.86454 10.9261 9.71054 9.83409Z" fill="#9E242E"/>
          <path d="M18.7354 8.8799C19.0234 8.6819 19.3594 8.8739 19.5844 9.0719C20.2264 9.6329 20.7004 10.3439 21.1564 11.0549C22.1464 12.6449 22.9624 14.3399 23.5744 16.1099C23.8864 17.0249 24.1654 17.9609 24.2344 18.9269C24.1294 18.2549 23.9554 17.5919 23.7244 16.9499C23.1394 15.1859 22.3294 13.5029 21.3424 11.9279C20.9134 11.2559 20.4574 10.5869 19.9024 10.0079C19.6774 9.7889 19.4404 9.5579 19.1434 9.4589C18.9064 9.3839 18.6874 9.5519 18.5014 9.67191C17.9914 10.0709 17.5924 10.5929 17.2114 11.1179C16.5394 12.0719 15.9394 13.0739 15.3904 14.1089C15.3034 14.2769 15.1924 14.4269 15.0664 14.5709C15.7024 13.0619 16.4734 11.6099 17.4154 10.2779C17.8024 9.7559 18.1894 9.2189 18.7354 8.8829" fill="#9E242E"/>
          <path d="M10.5092 9.64194C10.7222 9.50394 10.9772 9.36294 11.2322 9.46794C11.6822 9.65994 12.0062 10.0469 12.3152 10.4159C13.3742 11.7179 14.1542 13.2149 14.9942 14.6549C14.4632 16.1579 13.8362 17.6789 13.7972 19.2929C13.7732 19.8179 13.9082 20.3219 14.1032 20.8019C13.5422 20.3969 13.1822 19.7789 12.8432 19.1939C11.9822 17.5979 11.4422 15.8609 11.0102 14.1089C10.6922 12.6389 10.4042 11.1479 10.5062 9.64794" fill="#FF912E"/>
          <path d="M18.498 9.66603C18.69 9.54903 18.903 9.38703 19.14 9.45303C19.446 9.55203 19.683 9.78303 19.899 10.002C20.454 10.581 20.91 11.241 21.339 11.922C22.323 13.494 23.133 15.18 23.721 16.944C23.952 17.586 24.126 18.246 24.231 18.921C24.282 19.518 24.255 20.166 23.931 20.691C23.664 21.132 23.07 21.303 22.596 21.108C21.93 20.835 21.48 20.229 21.099 19.644C20.082 17.967 19.497 16.08 19.017 14.19C18.693 12.702 18.399 11.187 18.492 9.66603" fill="#F41CB2"/>
          <path d="M8.65776 11.9399C9.18876 11.1119 9.74976 10.2749 10.5088 9.63892C10.4098 11.1419 10.6948 12.6299 11.0068 14.0939C10.6018 15.8009 10.0648 17.4959 9.24876 19.0559C8.86776 19.7549 8.42676 20.4629 7.76676 20.9249C7.39176 21.1859 6.86976 21.2849 6.46476 21.0419C6.04176 20.8049 5.85276 20.3069 5.79876 19.8389C5.74176 19.3469 5.74776 18.8429 5.84976 18.3629C6.47376 16.1069 7.41276 13.9259 8.66076 11.9369" fill="#F41CB2"/>
          <path d="M17.2078 11.1059C17.5888 10.5809 17.9878 10.0649 18.4978 9.65991C18.3988 11.1869 18.6958 12.7019 19.0228 14.1779C18.6418 15.7349 18.1498 17.2829 17.4448 18.7259C17.1148 19.3799 16.7398 20.0279 16.2238 20.5589C15.9238 20.8529 15.5638 21.1259 15.1318 21.1709C14.7448 21.2159 14.3728 21.0329 14.0968 20.7839C13.9048 20.3039 13.7668 19.7999 13.7908 19.2749C13.8268 17.6549 14.4568 16.1399 14.9878 14.6369C15.0058 14.6129 15.0448 14.5679 15.0628 14.5499C15.1888 14.4059 15.2998 14.2559 15.3868 14.0879C15.9358 13.0649 16.5328 12.0569 17.2078 11.1029" fill="#F25511"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Nykaa':
        case 'Nykaa Fashion':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M22.128 7.67996C22.665 6.64796 20.922 6.93896 20.922 6.93896C20.298 6.93896 20.019 7.69196 19.89 7.90796L18.006 11.619C17.652 12.231 16.479 14.859 16.092 15.438C16.059 14.847 16.104 13.662 16.113 13.383C16.188 12.264 16.263 11.415 16.383 10.392C16.47 9.59696 16.641 8.70296 16.479 7.90496C16.371 7.40996 16.209 7.37696 15.501 7.30196C14.76 7.22696 14.253 8.30396 14.004 8.80796C13.101 10.68 12.09 12.51 11.283 14.424C11.046 14.985 10.755 15.543 10.509 16.092C10.218 16.758 9.94804 17.415 9.63604 18.072C9.30304 18.762 8.25904 21.021 7.96804 21.729C7.64404 22.503 7.58104 23.127 8.87104 23.094C9.07504 23.094 9.52804 23.136 10.086 22.533C10.527 22.059 10.614 21.618 10.872 20.961C11.796 18.636 12.453 17.097 13.464 14.796C13.56 14.571 13.788 13.914 14.013 13.407C14.001 14.127 13.884 14.988 13.83 15.558C13.659 17.646 13.539 19.656 13.356 21.723C13.335 22.002 13.26 22.335 13.389 22.596C13.518 22.857 13.842 22.92 14.1 22.95C15.132 23.079 15.24 22.563 15.564 21.852C15.855 21.216 16.026 20.7 16.284 20.055C17.079 18.063 17.919 16.095 18.846 14.16C19.083 13.665 19.32 13.182 19.578 12.696C20.052 11.802 20.439 10.965 20.955 9.97496C21.342 9.26396 21.72 8.45696 22.128 7.67096V7.67996Z" fill="#FC2779"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Tata Cliq':
        case 'Tata Cliq luxury':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M23.577 21.5551L21.639 19.6111L21.975 19.0561C22.413 18.3241 22.743 17.5321 22.95 16.7041C23.193 15.6631 23.262 14.5891 23.139 13.5301C23.097 13.1581 23.028 12.8101 22.944 12.4831C22.737 11.6671 22.407 10.8811 21.963 10.1491C21.873 9.98411 21.762 9.81311 21.627 9.62411C20.541 8.08811 18.981 6.94811 17.184 6.37511L17.154 6.36911C17.076 6.34511 16.989 6.32111 16.899 6.29711L16.875 6.29111C15.741 5.98511 14.559 5.91911 13.401 6.09611C12.699 6.20711 12.018 6.40211 11.367 6.66911C10.953 6.84011 10.557 7.04711 10.185 7.27811C9.222 7.85711 8.388 8.61911 7.716 9.51311C7.044 10.4071 6.552 11.4211 6.267 12.4981C6.09 13.1881 6 13.8931 6 14.6071C6 14.9911 6.03 15.3691 6.078 15.7471L6.096 15.8881L6.114 15.9781L6.126 16.0561C6.255 16.8421 6.498 17.6101 6.84 18.3301C6.969 18.5911 7.107 18.8431 7.26 19.0861C7.839 20.0371 8.601 20.8651 9.504 21.5161C10.407 22.1731 11.418 22.6561 12.495 22.9411C13.197 23.1121 13.914 23.2021 14.64 23.2021C15.072 23.2021 15.51 23.1661 15.939 23.0971C16.89 22.9441 17.811 22.6411 18.663 22.2001L18.711 22.1761C18.834 22.1161 18.948 22.0471 19.065 21.9751L19.626 21.6331L21.558 23.5711C21.825 23.8381 22.185 23.9911 22.569 23.9911C22.953 23.9911 23.313 23.8381 23.58 23.5771C24.147 23.0101 24.147 22.1131 23.58 21.5491L23.577 21.5551ZM20.67 16.1071C20.469 16.9171 20.127 17.6491 19.659 18.2701C18.996 19.1971 18.093 19.9141 17.046 20.3551C15.006 21.2011 12.672 20.9101 10.902 19.5871C10.251 19.1191 9.684 18.5071 9.27 17.8261C8.832 17.1241 8.55 16.3771 8.424 15.5221C8.289 14.7181 8.34 13.8901 8.559 13.1041C8.754 12.3181 9.114 11.5741 9.606 10.9291C10.08 10.2901 10.659 9.75311 11.379 9.29111L11.397 9.27911C12.123 8.84711 12.927 8.55311 13.767 8.42711C14.085 8.37911 14.394 8.35511 14.712 8.35511C16.035 8.35511 17.313 8.78111 18.369 9.57311C19.668 10.5481 20.526 11.9971 20.793 13.6621C20.91 14.4661 20.865 15.2881 20.67 16.1131V16.1071Z" fill="#FF1744"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Ajio':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M17.2865 17.442L14.8175 12.696L12.8195 17.442H17.2895H17.2865ZM7.14648 22.299V22.623L10.1735 22.716L11.3585 20.097L18.7595 20.124L19.8875 22.797L22.8575 22.593L14.9375 7.19702L7.14648 22.296V22.299Z" fill="white"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Purple':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
          <rect x="6" y="6" width="17.928" height="17.928" fill="url(#pattern0)"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          <defs>
          <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
          <use xlink:href="#image0_2107_18216" transform="scale(0.0119048)"/>
          </pattern>
          <image id="image0_2107_18216" width="84" height="84" xlink:href="data:image/png;base64,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"/>
          </defs>
          </svg>';
          break;
       
        case 'bigbasket':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M14.859 17.1511C14.859 16.6741 14.793 16.2001 14.658 15.7441C14.529 15.3511 14.304 14.9971 14.004 14.7121C13.692 14.4571 13.302 14.3251 12.897 14.3341C12.474 14.3221 12.063 14.4631 11.742 14.7361C11.403 15.0001 11.151 15.3601 11.013 15.7681C10.851 16.2121 10.767 16.6801 10.761 17.1511C10.767 17.6131 10.851 18.0751 11.013 18.5071C11.157 18.9181 11.409 19.2811 11.742 19.5631C12.072 19.8181 12.48 19.9501 12.897 19.9411C13.497 19.9771 14.064 19.6651 14.355 19.1371C14.706 18.5371 14.88 17.8471 14.856 17.1511H14.859ZM14.859 17.1511C14.859 16.6741 14.793 16.2001 14.658 15.7441C14.529 15.3511 14.304 14.9971 14.004 14.7121C13.692 14.4571 13.302 14.3251 12.897 14.3341C12.474 14.3221 12.063 14.4631 11.742 14.7361C11.403 15.0001 11.151 15.3601 11.013 15.7681C10.851 16.2121 10.767 16.6801 10.761 17.1511C10.767 17.6131 10.851 18.0751 11.013 18.5071C11.157 18.9181 11.409 19.2811 11.742 19.5631C12.072 19.8181 12.48 19.9501 12.897 19.9411C13.497 19.9771 14.064 19.6651 14.355 19.1371C14.706 18.5371 14.88 17.8471 14.856 17.1511H14.859ZM14.859 17.1511C14.859 16.6741 14.793 16.2001 14.658 15.7441C14.529 15.3511 14.304 14.9971 14.004 14.7121C13.692 14.4571 13.302 14.3251 12.897 14.3341C12.474 14.3221 12.063 14.4631 11.742 14.7361C11.403 15.0001 11.151 15.3601 11.013 15.7681C10.851 16.2121 10.767 16.6801 10.761 17.1511C10.767 17.6131 10.851 18.0751 11.013 18.5071C11.157 18.9181 11.409 19.2811 11.742 19.5631C12.072 19.8181 12.48 19.9501 12.897 19.9411C13.497 19.9771 14.064 19.6651 14.355 19.1371C14.706 18.5371 14.88 17.8471 14.856 17.1511H14.859ZM14.859 17.1511C14.859 16.6741 14.793 16.2001 14.658 15.7441C14.529 15.3511 14.304 14.9971 14.004 14.7121C13.692 14.4571 13.302 14.3251 12.897 14.3341C12.474 14.3221 12.063 14.4631 11.742 14.7361C11.403 15.0001 11.151 15.3601 11.013 15.7681C10.851 16.2121 10.767 16.6801 10.761 17.1511C10.767 17.6131 10.851 18.0751 11.013 18.5071C11.157 18.9181 11.409 19.2811 11.742 19.5631C12.072 19.8181 12.48 19.9501 12.897 19.9411C13.497 19.9771 14.064 19.6651 14.355 19.1371C14.706 18.5371 14.88 17.8471 14.856 17.1511H14.859ZM14.859 17.1511C14.859 16.6741 14.793 16.2001 14.658 15.7441C14.529 15.3511 14.304 14.9971 14.004 14.7121C13.692 14.4571 13.302 14.3251 12.897 14.3341C12.474 14.3221 12.063 14.4631 11.742 14.7361C11.403 15.0001 11.151 15.3601 11.013 15.7681C10.851 16.2121 10.767 16.6801 10.761 17.1511C10.767 17.6131 10.851 18.0751 11.013 18.5071C11.157 18.9181 11.409 19.2811 11.742 19.5631C12.072 19.8181 12.48 19.9501 12.897 19.9411C13.497 19.9771 14.064 19.6651 14.355 19.1371C14.706 18.5371 14.88 17.8471 14.856 17.1511H14.859ZM14.859 17.1511C14.859 16.6741 14.793 16.2001 14.658 15.7441C14.529 15.3511 14.304 14.9971 14.004 14.7121C13.692 14.4571 13.302 14.3251 12.897 14.3341C12.474 14.3221 12.063 14.4631 11.742 14.7361C11.403 15.0001 11.151 15.3601 11.013 15.7681C10.851 16.2121 10.767 16.6801 10.761 17.1511C10.767 17.6131 10.851 18.0751 11.013 18.5071C11.157 18.9181 11.409 19.2811 11.742 19.5631C12.072 19.8181 12.48 19.9501 12.897 19.9411C13.497 19.9771 14.064 19.6651 14.355 19.1371C14.706 18.5371 14.88 17.8471 14.856 17.1511H14.859ZM14.859 17.1511C14.859 16.6741 14.793 16.2001 14.658 15.7441C14.529 15.3511 14.304 14.9971 14.004 14.7121C13.692 14.4571 13.302 14.3251 12.897 14.3341C12.474 14.3221 12.063 14.4631 11.742 14.7361C11.403 15.0001 11.151 15.3601 11.013 15.7681C10.851 16.2121 10.767 16.6801 10.761 17.1511C10.767 17.6131 10.851 18.0751 11.013 18.5071C11.157 18.9181 11.409 19.2811 11.742 19.5631C12.072 19.8181 12.48 19.9501 12.897 19.9411C13.497 19.9771 14.064 19.6651 14.355 19.1371C14.706 18.5371 14.88 17.8471 14.856 17.1511H14.859ZM21.288 6.02711H8.691C7.215 6.02711 6.012 7.21511 6 8.69111V21.2851C6 22.7701 7.206 23.9731 8.691 23.9731H21.285C22.773 23.9731 23.985 22.7731 24 21.2851V8.69111C23.973 7.20911 22.767 6.02411 21.285 6.02711H21.288ZM13.983 8.27711H15.417V12.5851C14.994 12.3001 14.493 12.1471 13.983 12.1471V8.27711ZM13.653 21.7231C13.071 21.7501 12.489 21.6571 11.946 21.4471C11.613 21.3091 11.316 21.1021 11.067 20.8441C10.974 20.7151 10.89 20.5831 10.815 20.4421L10.791 20.3401V20.5681C10.716 21.9511 8.556 21.6991 8.556 21.6991V8.27711H10.917V13.8601H10.944C11.229 13.4311 11.628 13.0921 12.099 12.8791C12.588 12.6541 13.122 12.5431 13.659 12.5521C14.376 12.5371 15.078 12.7681 15.648 13.2061C16.215 13.6501 16.65 14.2411 16.905 14.9131C17.043 15.2701 17.151 15.6391 17.22 16.0111C17.292 16.3861 17.331 16.7671 17.331 17.1511C17.325 17.9161 17.181 18.6751 16.905 19.3891C16.644 20.0581 16.209 20.6461 15.648 21.0961C15.078 21.5251 14.376 21.7501 13.659 21.7231H13.653ZM21.024 19.3891C20.763 20.0581 20.328 20.6461 19.767 21.0961C19.197 21.5251 18.495 21.7501 17.781 21.7231C17.199 21.7501 16.617 21.6571 16.071 21.4471C15.978 21.4051 15.888 21.3571 15.798 21.3091C16.131 21.0361 16.425 20.7241 16.674 20.3761C16.938 20.4721 17.22 20.5171 17.499 20.5141C19.284 20.5141 19.86 18.6391 19.86 17.1511C19.86 15.6631 19.32 13.7581 17.499 13.7581C17.238 13.7581 16.98 13.7971 16.734 13.8811C16.515 13.5601 16.26 13.2661 15.969 13.0081C16.05 12.9601 16.134 12.9151 16.218 12.8761C17.997 12.0661 20.097 12.8521 20.907 14.6311C20.949 14.7241 20.988 14.8171 21.021 14.9131C21.3 15.6271 21.444 16.3861 21.45 17.1541C21.444 17.9191 21.3 18.6781 21.021 19.3921L21.024 19.3891ZM14.658 15.7411C14.529 15.3481 14.304 14.9941 14.004 14.7091C13.692 14.4541 13.302 14.3221 12.897 14.3311C12.474 14.3191 12.063 14.4601 11.742 14.7331C11.403 14.9971 11.151 15.3571 11.013 15.7651C10.851 16.2091 10.767 16.6771 10.761 17.1481C10.767 17.6101 10.851 18.0721 11.013 18.5041C11.157 18.9151 11.409 19.2781 11.742 19.5601C12.072 19.8151 12.48 19.9471 12.897 19.9381C13.497 19.9741 14.064 19.6621 14.355 19.1341C14.706 18.5341 14.88 17.8441 14.856 17.1481C14.856 16.6711 14.79 16.1971 14.655 15.7411H14.658ZM14.859 17.1481C14.859 16.6711 14.793 16.1971 14.658 15.7411C14.529 15.3481 14.304 14.9941 14.004 14.7091C13.692 14.4541 13.302 14.3221 12.897 14.3311C12.474 14.3191 12.063 14.4601 11.742 14.7331C11.403 14.9971 11.151 15.3571 11.013 15.7651C10.851 16.2091 10.767 16.6771 10.761 17.1481C10.767 17.6101 10.851 18.0721 11.013 18.5041C11.157 18.9151 11.409 19.2781 11.742 19.5601C12.072 19.8151 12.48 19.9471 12.897 19.9381C13.497 19.9741 14.064 19.6621 14.355 19.1341C14.706 18.5341 14.88 17.8441 14.856 17.1481H14.859ZM14.859 17.1481C14.859 16.6711 14.793 16.1971 14.658 15.7411C14.529 15.3481 14.304 14.9941 14.004 14.7091C13.692 14.4541 13.302 14.3221 12.897 14.3311C12.474 14.3191 12.063 14.4601 11.742 14.7331C11.403 14.9971 11.151 15.3571 11.013 15.7651C10.851 16.2091 10.767 16.6771 10.761 17.1481C10.767 17.6101 10.851 18.0721 11.013 18.5041C11.157 18.9151 11.409 19.2781 11.742 19.5601C12.072 19.8151 12.48 19.9471 12.897 19.9381C13.497 19.9741 14.064 19.6621 14.355 19.1341C14.706 18.5341 14.88 17.8441 14.856 17.1481H14.859ZM14.859 17.1481C14.859 16.6711 14.793 16.1971 14.658 15.7411C14.529 15.3481 14.304 14.9941 14.004 14.7091C13.692 14.4541 13.302 14.3221 12.897 14.3311C12.474 14.3191 12.063 14.4601 11.742 14.7331C11.403 14.9971 11.151 15.3571 11.013 15.7651C10.851 16.2091 10.767 16.6771 10.761 17.1481C10.767 17.6101 10.851 18.0721 11.013 18.5041C11.157 18.9151 11.409 19.2781 11.742 19.5601C12.072 19.8151 12.48 19.9471 12.897 19.9381C13.497 19.9741 14.064 19.6621 14.355 19.1341C14.706 18.5341 14.88 17.8441 14.856 17.1481H14.859ZM14.859 17.1481C14.859 16.6711 14.793 16.1971 14.658 15.7411C14.529 15.3481 14.304 14.9941 14.004 14.7091C13.692 14.4541 13.302 14.3221 12.897 14.3311C12.474 14.3191 12.063 14.4601 11.742 14.7331C11.403 14.9971 11.151 15.3571 11.013 15.7651C10.851 16.2091 10.767 16.6771 10.761 17.1481C10.767 17.6101 10.851 18.0721 11.013 18.5041C11.157 18.9151 11.409 19.2781 11.742 19.5601C12.072 19.8151 12.48 19.9471 12.897 19.9381C13.497 19.9741 14.064 19.6621 14.355 19.1341C14.706 18.5341 14.88 17.8441 14.856 17.1481H14.859ZM14.859 17.1481C14.859 16.6711 14.793 16.1971 14.658 15.7411C14.529 15.3481 14.304 14.9941 14.004 14.7091C13.692 14.4541 13.302 14.3221 12.897 14.3311C12.474 14.3191 12.063 14.4601 11.742 14.7331C11.403 14.9971 11.151 15.3571 11.013 15.7651C10.851 16.2091 10.767 16.6771 10.761 17.1481C10.767 17.6101 10.851 18.0721 11.013 18.5041C11.157 18.9151 11.409 19.2781 11.742 19.5601C12.072 19.8151 12.48 19.9471 12.897 19.9381C13.497 19.9741 14.064 19.6621 14.355 19.1341C14.706 18.5341 14.88 17.8441 14.856 17.1481H14.859Z" fill="#A5CD3A"/>
          <path d="M21.4499 17.154C21.4439 17.919 21.2999 18.678 21.0209 19.392C20.7599 20.061 20.3249 20.649 19.7639 21.099C19.1939 21.528 18.4919 21.753 17.7779 21.726C17.1959 21.753 16.6139 21.66 16.0679 21.45C15.9749 21.408 15.8849 21.36 15.7949 21.312C16.1279 21.039 16.4219 20.727 16.6709 20.379C16.9349 20.475 17.2169 20.52 17.4959 20.517C19.2809 20.517 19.8569 18.642 19.8569 17.154C19.8569 15.666 19.3169 13.761 17.4959 13.761C17.2349 13.761 16.9769 13.8 16.7309 13.884C16.5119 13.563 16.2569 13.269 15.9659 13.011C16.0469 12.963 16.1309 12.918 16.2149 12.879C17.9939 12.069 20.0939 12.855 20.9039 14.634C20.9459 14.727 20.9849 14.82 21.0179 14.916C21.2969 15.63 21.4409 16.389 21.4469 17.157L21.4499 17.154Z" fill="black"/>
          <path d="M15.4145 8.2771V12.5851C14.9915 12.3001 14.4905 12.1471 13.9805 12.1471V8.2771H15.4145Z" fill="black"/>
          <path d="M17.2138 16.0111C17.1448 15.6361 17.0368 15.2671 16.8988 14.9131C16.6438 14.2381 16.2088 13.6471 15.6418 13.2061C15.0718 12.7681 14.3728 12.5371 13.6528 12.5521C13.1158 12.5431 12.5818 12.6541 12.0928 12.8791C11.6218 13.0921 11.2228 13.4311 10.9378 13.8601H10.9108V8.2771H8.5498V21.6991C8.5498 21.6991 10.7098 21.9511 10.7848 20.5681V20.3401L10.8088 20.4421C10.8838 20.5801 10.9678 20.7151 11.0608 20.8441C11.3098 21.1051 11.6098 21.3091 11.9398 21.4471C12.4858 21.6571 13.0648 21.7501 13.6468 21.7231C14.3608 21.7471 15.0628 21.5251 15.6358 21.0961C16.1968 20.6461 16.6318 20.0581 16.8928 19.3891C17.1688 18.6751 17.3158 17.9161 17.3188 17.1511C17.3188 16.7671 17.2798 16.3861 17.2078 16.0111H17.2138ZM14.3578 19.1371C14.0668 19.6651 13.4998 19.9771 12.8998 19.9411C12.4828 19.9501 12.0748 19.8181 11.7448 19.5631C11.4118 19.2841 11.1598 18.9211 11.0158 18.5071C10.8538 18.0721 10.7698 17.6131 10.7638 17.1511C10.7698 16.6771 10.8538 16.2091 11.0158 15.7681C11.1538 15.3601 11.4058 15.0031 11.7448 14.7361C12.0658 14.4631 12.4768 14.3191 12.8998 14.3341C13.3018 14.3251 13.6918 14.4571 14.0068 14.7121C14.3068 14.9971 14.5288 15.3511 14.6608 15.7441C14.7958 16.2001 14.8648 16.6741 14.8618 17.1511C14.8858 17.8471 14.7118 18.5371 14.3608 19.1371H14.3578Z" fill="#EC1D23"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Blinkit':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20.193 6H9.807C7.70445 6 6 7.70445 6 9.807V20.193C6 22.2955 7.70445 24 9.807 24H20.193C22.2955 24 24 22.2955 24 20.193V9.807C24 7.70445 22.2955 6 20.193 6Z" fill="#F8CB46"/>
          <path d="M9.42871 13.9769C9.68071 13.9769 9.90571 14.0399 10.1037 14.1659C10.3047 14.2889 10.4607 14.4659 10.5717 14.6939C10.6827 14.9129 10.7367 15.1709 10.7367 15.4679C10.7367 15.7649 10.6827 16.0139 10.5717 16.2389C10.4607 16.4639 10.3077 16.6439 10.1067 16.7699C9.90571 16.8989 9.67771 16.9649 9.42571 16.9649C9.24271 16.9649 9.06871 16.9259 8.90671 16.8509C8.74471 16.7759 8.60671 16.6679 8.49271 16.5329V16.8959H7.55371V13.0349H8.49271V14.4059C8.60671 14.2679 8.74771 14.1629 8.90671 14.0909C9.06871 14.0159 9.23971 13.9769 9.42571 13.9769H9.42871ZM9.14671 16.1849C9.27871 16.1849 9.39871 16.1549 9.50371 16.0919C9.60871 16.0319 9.68971 15.9449 9.74971 15.8369C9.80971 15.7289 9.83971 15.6059 9.83971 15.4679C9.83971 15.3299 9.80971 15.2099 9.74971 15.1019C9.68971 14.9909 9.60871 14.9069 9.50371 14.8469C9.39871 14.7869 9.28171 14.7539 9.14671 14.7539C9.02071 14.7539 8.90971 14.7839 8.81071 14.8469C8.71171 14.9069 8.63371 14.9909 8.57971 15.0989C8.52271 15.2099 8.49571 15.3329 8.49571 15.4709C8.49571 15.6089 8.52271 15.7319 8.57971 15.8429C8.63671 15.9509 8.71171 16.0349 8.81071 16.0949C8.90971 16.1549 9.02071 16.1879 9.14671 16.1879V16.1849Z" fill="#1C1C1C"/>
          <path d="M10.8662 16.8959V13.0349H11.8052V16.8959H10.8662Z" fill="#1C1C1C"/>
          <path d="M12.0723 16.896V14.04H13.0053V16.896H12.0723Z" fill="#1C1C1C"/>
          <path d="M15.0327 13.9769C15.2337 13.9769 15.4107 14.0249 15.5727 14.1179C15.7317 14.2109 15.8577 14.3399 15.9507 14.5049C16.0377 14.6729 16.0827 14.8649 16.0827 15.0779V16.8929H15.1887V15.2879C15.1887 15.1829 15.1677 15.0899 15.1257 15.0089C15.0867 14.9249 15.0297 14.8619 14.9547 14.8169C14.8827 14.7719 14.7987 14.7509 14.7027 14.7509C14.6097 14.7509 14.5257 14.7719 14.4477 14.8169C14.3697 14.8589 14.3097 14.9189 14.2677 14.9939C14.2227 15.0659 14.2017 15.1499 14.2017 15.2459L14.1957 16.8899H13.2627V14.0339H14.1957V14.3609C14.2827 14.2379 14.4027 14.1419 14.5497 14.0759C14.6967 14.0069 14.8587 13.9709 15.0357 13.9709L15.0327 13.9769Z" fill="#1C1C1C"/>
          <path d="M18.1438 15.2909L19.2028 16.8959H18.1438L17.5258 15.8849L17.2408 16.2179V16.8959H16.3018V13.0349H17.2408V15.1679L18.1438 14.0399H19.2028L18.1468 15.2909H18.1438Z" fill="#1C1C1C"/>
          <path d="M12.0723 13.0349H13.0083V13.7669H12.0723V13.0349Z" fill="#1C1C1C"/>
          <path d="M19.3438 16.896V14.04H20.2797V16.896H19.3438Z" fill="#0C831F"/>
          <path d="M22.2599 16.0829L22.4459 16.6829C22.3619 16.7639 22.2539 16.8299 22.1249 16.8809C21.9959 16.9319 21.8729 16.9559 21.7499 16.9559C21.5729 16.9559 21.4169 16.9169 21.2789 16.8389C21.1409 16.7609 21.0329 16.6499 20.9549 16.5089C20.8769 16.3709 20.8379 16.2149 20.8379 16.0379V14.7779H20.4629V14.0399H20.8379V13.0349H21.7319V14.0399H22.3229V14.7779H21.7319V15.8639C21.7319 15.9569 21.7559 16.0289 21.8039 16.0889C21.8519 16.1459 21.9149 16.1759 21.9899 16.1759C22.0439 16.1759 22.0949 16.1669 22.1399 16.1519C22.1879 16.1369 22.2239 16.1129 22.2569 16.0829H22.2599Z" fill="#0C831F"/>
          <path d="M19.3438 13.0349H20.2797V13.7669H19.3438V13.0349Z" fill="#0C831F"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Facebook':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15 6C10.029 6 6 10.029 6 15C6 19.971 10.029 24 15 24C19.971 24 24 19.971 24 15C24 10.029 19.971 6 15 6Z" fill="url(#paint0_linear_2107_18221)"/>
          <path d="M16.2177 17.385H18.5457L18.9117 15.018H16.2177V13.725C16.2177 12.741 16.5387 11.871 17.4597 11.871H18.9357V9.80704C18.6747 9.77104 18.1257 9.69604 17.0907 9.69604C14.9247 9.69604 13.6557 10.839 13.6557 13.446V15.021H11.4297V17.388H13.6557V23.892C14.0967 23.958 14.5437 24.003 15.0027 24.003C15.4167 24.003 15.8217 23.964 16.2207 23.91V17.388L16.2177 17.385Z" fill="white"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          <defs>
          <linearGradient id="paint0_linear_2107_18221" x1="8.7" y1="8.7" x2="22.47" y2="22.47" gradientUnits="userSpaceOnUse">
          <stop stop-color="#2AA4F4"/>
          <stop offset="1" stop-color="#007AD9"/>
          </linearGradient>
          </defs>
          </svg>';
          break;
       
        case 'First Cry':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M22.104 6H7.896C6.84887 6 6 6.84887 6 7.896V22.104C6 23.1511 6.84887 24 7.896 24H22.104C23.1511 24 24 23.1511 24 22.104V7.896C24 6.84887 23.1511 6 22.104 6Z" fill="#C1539C"/>
          <path d="M16.1972 13.02C16.9892 12.45 17.6702 12.186 18.7022 12.309C19.4102 12.51 20.1362 12.66 20.4572 13.389C20.5052 13.893 20.1272 14.0789 19.4912 14.1509C18.8252 14.1719 18.6032 13.7669 18.2312 13.4279C17.4482 13.0979 17.0072 13.257 16.4462 13.902C15.7502 14.658 16.4282 17.439 17.4692 18.198C18.0812 18.687 18.7262 18.7319 19.3502 18.5759C19.6202 18.5069 19.8452 18.306 19.9112 18.012C19.9862 17.553 20.4032 17.493 20.6462 17.652C21.1412 18.066 21.1622 18.8369 20.6192 19.1879C20.1782 19.4759 19.6142 19.533 19.1132 19.554C17.7392 19.662 16.9382 19.014 16.2152 18.258C15.3392 16.818 14.7422 14.307 16.1972 13.02Z" fill="white"/>
          <path d="M11.8828 9.285C12.0898 8.796 12.4558 8.292 13.3888 7.866C13.8178 7.695 14.3038 7.68 14.7838 7.719C15.0898 7.767 15.3748 7.83 15.6658 8.052C15.8728 8.214 16.1278 8.463 16.2058 8.889C16.2088 8.943 16.0678 8.922 16.0198 8.916C15.8008 8.889 15.6868 8.991 15.5038 9.099C15.4528 9.129 15.3658 9.165 15.2998 9.114C15.1378 8.937 15.0088 8.808 14.8468 8.628C14.4418 8.283 13.8478 8.43 13.4188 8.742C12.9238 9.162 12.7078 9.561 12.5548 9.954C12.4018 10.38 12.3388 10.806 12.2548 11.229C12.1798 11.916 12.1738 12.576 12.1768 13.245C12.1798 13.584 12.1948 13.926 12.2668 14.25C12.3778 14.487 12.5338 14.688 12.8428 14.766C13.1698 14.805 13.4968 14.844 13.8238 14.883C14.0008 14.91 14.1388 14.991 14.2228 15.165C14.2588 15.381 14.2108 15.519 14.0968 15.543C13.7308 15.537 13.3558 15.54 12.9868 15.561C12.5158 15.669 12.5848 16.047 12.5488 16.353C12.8218 18.18 13.0618 19.989 13.2568 21.834C13.2418 22.188 13.1308 22.245 12.9628 22.278C12.9058 22.335 12.7108 22.302 12.5518 22.08C12.1528 19.863 11.8378 17.619 11.3878 15.396C11.3518 15.141 11.2258 15.009 11.0128 14.991C10.5118 14.967 10.0108 14.946 9.50975 14.922C9.28475 14.886 9.11375 14.811 9.04175 14.664C8.94875 14.364 8.96975 14.043 9.20375 13.788C9.32075 13.671 9.41075 13.563 9.73475 13.596C9.95075 13.653 10.1128 13.77 10.3138 14.019C10.4908 14.166 10.8238 14.184 11.1298 14.112C11.2648 14.076 11.3698 13.956 11.3218 13.668C11.2318 12.966 11.2288 12.36 11.2678 11.691C11.3488 10.794 11.5138 10.095 11.8918 9.282" fill="white"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Instagram':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15.0029 6.00293C11.2469 6.00293 10.1459 6.00593 9.93293 6.02393C9.16193 6.08693 8.68193 6.20993 8.15993 6.47093C7.75793 6.67193 7.43993 6.90293 7.12493 7.22693C6.55493 7.82093 6.20693 8.54993 6.08393 9.41693C6.02393 9.83693 6.00593 9.92393 6.00293 12.0719C6.00293 12.7889 6.00293 13.7309 6.00293 14.9969C6.00293 18.7499 6.00593 19.8479 6.02393 20.0609C6.08693 20.8109 6.20393 21.2819 6.45293 21.8009C6.92993 22.7879 7.83893 23.5319 8.90993 23.8079C9.28193 23.9039 9.68993 23.9549 10.2179 23.9819C10.4399 23.9909 12.7139 23.9999 14.9849 23.9999C17.2559 23.9999 19.5299 23.9999 19.7489 23.9849C20.3579 23.9549 20.7119 23.9099 21.1019 23.8079C22.1789 23.5289 23.0729 22.7999 23.5589 21.7979C23.8019 21.2939 23.9279 20.8049 23.9819 20.0939C23.9939 19.9379 23.9999 17.4659 23.9999 14.9969C23.9999 12.5279 23.9939 10.0589 23.9819 9.90593C23.9249 9.18293 23.8019 8.69693 23.5499 8.18393C23.3429 7.76393 23.1119 7.44893 22.7789 7.12793C22.1849 6.55793 21.4559 6.21293 20.5889 6.08693C20.1689 6.02693 20.0849 6.00893 17.9339 6.00293H15.0059H15.0029Z" fill="url(#paint0_radial_2107_18224)"/>
          <path d="M15.0029 6.00293C11.2469 6.00293 10.1459 6.00593 9.93293 6.02393C9.16193 6.08693 8.68193 6.20993 8.15993 6.47093C7.75793 6.67193 7.43993 6.90293 7.12493 7.22693C6.55493 7.82093 6.20693 8.54993 6.08393 9.41693C6.02393 9.83693 6.00593 9.92393 6.00293 12.0719C6.00293 12.7889 6.00293 13.7309 6.00293 14.9969C6.00293 18.7499 6.00593 19.8479 6.02393 20.0609C6.08693 20.8109 6.20393 21.2819 6.45293 21.8009C6.92993 22.7879 7.83893 23.5319 8.90993 23.8079C9.28193 23.9039 9.68993 23.9549 10.2179 23.9819C10.4399 23.9909 12.7139 23.9999 14.9849 23.9999C17.2559 23.9999 19.5299 23.9999 19.7489 23.9849C20.3579 23.9549 20.7119 23.9099 21.1019 23.8079C22.1789 23.5289 23.0729 22.7999 23.5589 21.7979C23.8019 21.2939 23.9279 20.8049 23.9819 20.0939C23.9939 19.9379 23.9999 17.4659 23.9999 14.9969C23.9999 12.5279 23.9939 10.0589 23.9819 9.90593C23.9249 9.18293 23.8019 8.69693 23.5499 8.18393C23.3429 7.76393 23.1119 7.44893 22.7789 7.12793C22.1849 6.55793 21.4559 6.21293 20.5889 6.08693C20.1689 6.02693 20.0849 6.00893 17.9339 6.00293H15.0059H15.0029Z" fill="url(#paint1_radial_2107_18224)"/>
          <path d="M15.0005 8.35498C13.1945 8.35498 12.9695 8.36398 12.2615 8.39398C11.5535 8.42698 11.0705 8.53798 10.6475 8.70298C10.2095 8.87398 9.84047 9.09898 9.47147 9.46798C9.10247 9.83698 8.87447 10.209 8.70347 10.644C8.53847 11.067 8.42747 11.55 8.39447 12.258C8.36147 12.966 8.35547 13.194 8.35547 14.997C8.35547 16.8 8.36447 17.028 8.39447 17.736C8.42747 18.444 8.53847 18.927 8.70347 19.35C8.87447 19.788 9.09947 20.157 9.46847 20.526C9.83747 20.895 10.2095 21.123 10.6445 21.294C11.0675 21.459 11.5505 21.57 12.2585 21.603C12.9665 21.636 13.1945 21.642 14.9975 21.642C16.8005 21.642 17.0285 21.633 17.7365 21.603C18.4445 21.57 18.9275 21.459 19.3505 21.294C19.7885 21.123 20.1575 20.898 20.5265 20.526C20.8955 20.157 21.1235 19.785 21.2945 19.35C21.4565 18.927 21.5705 18.444 21.6035 17.736C21.6365 17.028 21.6425 16.8 21.6425 14.997C21.6425 13.194 21.6335 12.966 21.6035 12.258C21.5705 11.55 21.4595 11.067 21.2945 10.644C21.1235 10.206 20.8985 9.83698 20.5265 9.46798C20.1575 9.09898 19.7885 8.87098 19.3505 8.70298C18.9275 8.53798 18.4445 8.42698 17.7365 8.39398C17.0285 8.36098 16.8035 8.35498 14.9975 8.35498H15.0005ZM14.4035 9.55198C14.5805 9.55198 14.7785 9.55198 15.0005 9.55198C16.7735 9.55198 16.9835 9.55798 17.6855 9.59098C18.3335 9.62098 18.6845 9.72898 18.9185 9.81898C19.2275 9.93898 19.4495 10.083 19.6835 10.317C19.9175 10.551 20.0615 10.77 20.1815 11.082C20.2715 11.316 20.3795 11.667 20.4095 12.315C20.4425 13.014 20.4485 13.227 20.4485 15C20.4485 16.773 20.4425 16.983 20.4095 17.685C20.3795 18.333 20.2715 18.684 20.1815 18.918C20.0615 19.227 19.9175 19.449 19.6835 19.68C19.4495 19.914 19.2305 20.058 18.9185 20.178C18.6845 20.268 18.3335 20.376 17.6855 20.406C16.9865 20.439 16.7735 20.445 15.0005 20.445C13.2275 20.445 13.0145 20.439 12.3155 20.406C11.6675 20.376 11.3165 20.268 11.0825 20.178C10.7735 20.058 10.5515 19.914 10.3175 19.68C10.0835 19.446 9.93947 19.227 9.81947 18.915C9.72947 18.681 9.62147 18.33 9.59147 17.682C9.55847 16.983 9.55247 16.77 9.55247 14.997C9.55247 13.224 9.55847 13.014 9.59147 12.312C9.62147 11.664 9.72947 11.313 9.81947 11.079C9.93947 10.77 10.0835 10.548 10.3175 10.314C10.5515 10.08 10.7705 9.93598 11.0825 9.81598C11.3165 9.72598 11.6675 9.61798 12.3155 9.58798C12.9275 9.56098 13.1675 9.55198 14.4035 9.55198ZM18.5465 10.656C18.1055 10.656 17.7485 11.013 17.7485 11.454C17.7485 11.895 18.1055 12.252 18.5465 12.252C18.9875 12.252 19.3445 11.895 19.3445 11.454C19.3445 11.013 18.9875 10.656 18.5465 10.656ZM15.0005 11.589C13.1165 11.589 11.5895 13.116 11.5895 15C11.5895 16.884 13.1165 18.411 15.0005 18.411C16.8845 18.411 18.4115 16.884 18.4115 15C18.4115 13.116 16.8845 11.589 15.0005 11.589ZM15.0005 12.786C16.2245 12.786 17.2145 13.779 17.2145 15C17.2145 16.221 16.2215 17.214 15.0005 17.214C13.7795 17.214 12.7865 16.221 12.7865 15C12.7865 13.779 13.7795 12.786 15.0005 12.786Z" fill="white"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          <defs>
          <radialGradient id="paint0_radial_2107_18224" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(10.5506 25.452) rotate(-90) scale(17.8141 16.5545)">
          <stop stop-color="#FFDD55"/>
          <stop offset="0.1" stop-color="#FFDD55"/>
          <stop offset="0.5" stop-color="#FF543E"/>
          <stop offset="1" stop-color="#C837AB"/>
          </radialGradient>
          <radialGradient id="paint1_radial_2107_18224" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(3.00955 7.37538) rotate(78.68) scale(8.00733 32.8391)">
          <stop stop-color="#3771C8"/>
          <stop offset="0.13" stop-color="#3771C8"/>
          <stop offset="1" stop-color="#6600FF" stop-opacity="0"/>
          </radialGradient>
          </defs>
          </svg>';
          break;
       
        case 'Limeroad':
        case 'Lime road':
        case 'Lime-road':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
          <path d="M22.104 6H7.896C6.84887 6 6 6.84887 6 7.896V22.104C6 23.1511 6.84887 24 7.896 24H22.104C23.1511 24 24 23.1511 24 22.104V7.896C24 6.84887 23.1511 6 22.104 6Z" fill="url(#paint0_linear_2107_18225)"/>
          <rect x="7.40723" y="10.833" width="15.162" height="8.322" fill="url(#pattern0)"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          <defs>
          <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
          <use xlink:href="#image0_2107_18225" transform="scale(0.0075188 0.0140845)"/>
          </pattern>
          <linearGradient id="paint0_linear_2107_18225" x1="15" y1="24" x2="15" y2="6" gradientUnits="userSpaceOnUse">
          <stop stop-color="#6FCA35"/>
          <stop offset="1" stop-color="#AFE058"/>
          </linearGradient>
          <image id="image0_2107_18225" width="133" height="71" xlink:href="data:image/png;base64,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"/>
          </defs>
          </svg>';
          break;
       
        case 'Meesho':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M24 6H6V24H24V6Z" fill="#5A0949"/>
          <path d="M17.8619 10.107C18.9509 10.122 19.8599 10.494 20.6189 11.238C21.3779 11.982 21.7499 12.864 21.7499 13.926L21.7229 18.861C21.7229 19.455 21.2279 19.923 20.6069 19.923C19.9859 19.923 19.5029 19.44 19.5179 18.849L19.5449 13.914C19.5599 13.473 19.3799 13.044 19.0499 12.741C18.7319 12.423 18.3329 12.258 17.8499 12.258C17.3819 12.243 16.9259 12.438 16.6079 12.768C16.2899 13.086 16.1399 13.512 16.1399 13.953L16.1129 18.819C16.1129 19.413 15.6029 19.893 14.9819 19.893C14.3609 19.893 13.8659 19.398 13.8659 18.804L13.8929 13.911C13.9079 13.485 13.7399 13.056 13.4369 12.753C13.1069 12.408 12.6929 12.243 12.1949 12.228C11.7389 12.213 11.3129 12.381 10.9949 12.696C10.6649 13.014 10.4999 13.398 10.4999 13.854L10.4729 18.777C10.4729 19.371 9.97793 19.851 9.35693 19.839C8.75093 19.839 8.25293 19.356 8.25293 18.765L8.27993 13.857C8.27993 12.933 8.62493 12.051 9.24593 11.376C10.0589 10.506 11.0519 10.065 12.2099 10.08C13.3139 10.095 14.2649 10.479 15.0209 11.253C15.8219 10.482 16.7579 10.11 17.8619 10.11V10.107Z" fill="#FB9D05"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Namashi':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M24 6H6V24H24V6Z" fill="black"/>
          <path d="M11.6248 12.1951L18.7018 21.5971L20.5798 21.6091L20.6158 8.41511H18.3988L18.3748 17.5261L11.5048 8.39111H9.41979L9.38379 21.5731L11.6008 21.5851L11.6248 12.1951Z" fill="white"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Netmeds':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M19.9408 9.81602L14.9248 8.16602V13.374H9.9088L9.7168 18.837L14.9248 21.948C17.6548 22.455 19.3078 22.584 19.9408 22.455C20.8948 22.2 24.1948 19.725 24.6418 18.264C25.0888 16.803 24.9598 14.58 24.3868 13.437C24.0058 12.675 22.4818 11.469 19.9408 9.81602Z" fill="white"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M24.6417 18.1979C23.8797 20.3579 22.0377 21.8819 19.9407 22.4519V18.1979H24.6417ZM5.52574 11.7839C6.79474 8.48089 10.5417 6.70189 14.0367 7.84489L14.9247 8.16289V13.4339H9.90874V18.2609H14.9247V21.9449L11.4327 20.8019L9.65374 20.1659C6.16174 19.0229 4.31974 15.4019 5.39974 12.0359L5.52574 11.7809V11.7839ZM19.8777 9.81589L20.3847 10.0079C22.2267 10.5809 23.6247 11.9129 24.3237 13.4369H19.8777V9.81589Z" fill="#84BE52"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Pinterest':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M6 15C6 18.684 8.217 21.852 11.388 23.244C11.364 22.617 11.382 21.861 11.544 21.177C11.718 20.445 12.702 16.272 12.702 16.272C12.702 16.272 12.414 15.696 12.414 14.847C12.414 13.512 13.188 12.516 14.151 12.516C14.97 12.516 15.366 13.131 15.366 13.866C15.366 14.688 14.841 15.921 14.571 17.061C14.346 18.015 15.051 18.795 15.993 18.795C17.697 18.795 18.846 16.605 18.846 14.01C18.846 12.036 17.517 10.56 15.102 10.56C12.372 10.56 10.671 12.597 10.671 14.871C10.671 15.654 10.902 16.209 11.265 16.635C11.43 16.833 11.454 16.911 11.394 17.136C11.352 17.301 11.253 17.7 11.211 17.859C11.151 18.087 10.965 18.168 10.761 18.084C9.504 17.571 8.919 16.194 8.919 14.646C8.919 12.09 11.076 9.024 15.351 9.024C18.786 9.024 21.048 11.511 21.048 14.181C21.048 17.712 19.086 20.349 16.191 20.349C15.219 20.349 14.304 19.824 13.992 19.227C13.992 19.227 13.47 21.3 13.359 21.702C13.167 22.395 12.795 23.088 12.453 23.631C13.263 23.871 14.118 24 15.003 24C19.974 24 24.003 19.971 24.003 15C24.003 10.029 19.974 6 15.003 6C10.032 6 6.003 10.029 6.003 15H6Z" fill="#CB1F27"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Snapdeal':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M9.75572 22.836C9.94772 23.163 10.1577 23.283 10.5387 23.283H17.6787C18.0627 23.283 18.2697 23.181 18.5157 22.869L23.9157 15.996C24.0387 15.84 23.8977 15.585 23.7057 15.585H15.0507C14.6667 15.585 14.4597 15.465 14.2677 15.138L9.91472 7.71303C9.80972 7.54203 9.53072 7.57503 9.46172 7.74603L6.10172 15.771C5.94572 16.131 5.97872 16.374 6.17072 16.698L9.75872 22.833L9.75572 22.836Z" fill="#E40046"/>
          <path d="M18.7415 13.968C18.9335 14.295 19.1435 14.415 19.5245 14.415H23.7035C23.9135 14.415 24.0695 14.157 23.9645 13.968L19.9775 7.16404C19.7855 6.83704 19.5755 6.71704 19.1945 6.71704H11.2175C11.0075 6.71704 10.8515 6.97504 10.9565 7.16404L13.0295 10.704C13.2215 11.031 13.4285 11.151 13.8125 11.151H17.1035L18.7415 13.968Z" fill="#E40046"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Swiggy-Instamart':
        case 'Swiggy':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15.0274 23.9999C15.0274 23.9999 15.0034 23.9819 14.9884 23.9699C14.7724 23.6999 13.4314 22.0199 12.0634 19.8659C11.6524 19.1789 11.3884 18.6449 11.4394 18.5039C11.5744 18.1439 13.9564 17.9459 14.6884 18.2729C14.9104 18.3719 14.9074 18.5039 14.9074 18.5789C14.9074 18.9089 14.8924 19.7939 14.8924 19.7939C14.8924 19.9769 15.0424 20.1239 15.2254 20.1239C15.4084 20.1239 15.5554 19.9739 15.5554 19.7909V17.5859H15.5524C15.5524 17.3939 15.3424 17.3459 15.3034 17.3399C14.9194 17.3399 14.1424 17.3339 13.3084 17.3339C11.4664 17.3339 11.0554 17.4089 10.7404 17.2049C10.0624 16.7609 8.95241 13.7729 8.92841 12.0899C8.89241 9.7169 10.2964 7.6649 12.2764 6.6449C13.1044 6.2279 14.0374 5.9939 15.0244 5.9939C18.1564 5.9939 20.7364 8.3579 21.0814 11.3999C21.0814 11.3999 21.0814 11.4059 21.0814 11.4089C21.1444 12.1439 17.0914 12.2999 16.2874 12.0869C16.1644 12.0539 16.1344 11.9279 16.1344 11.8739C16.1344 11.3159 16.1284 9.7409 16.1284 9.7409C16.1284 9.5579 15.9784 9.4109 15.7954 9.4109C15.6124 9.4109 15.4654 9.5609 15.4654 9.7439L15.4714 12.6419C15.4774 12.8249 15.6304 12.8729 15.6724 12.8819C16.1284 12.8819 17.1934 12.8819 18.1894 12.8819C19.5304 12.8819 20.0944 13.0379 20.4694 13.3229C20.7184 13.5119 20.8144 13.8779 20.7304 14.3519C19.9774 18.5609 15.2074 23.7779 15.0274 23.9969V23.9999Z" fill="#FC8019"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Youtube':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M23.6281 10.671C23.4211 9.90002 22.8121 9.29102 22.0411 9.08402C20.6311 8.69702 14.9971 8.69702 14.9971 8.69702C14.9971 8.69702 9.36314 8.69702 7.95314 9.06902C7.19714 9.27602 6.57314 9.90002 6.36614 10.671C5.99414 12.081 5.99414 15 5.99414 15C5.99414 15 5.99414 17.937 6.36614 19.329C6.57314 20.1 7.18214 20.709 7.95314 20.916C9.37514 21.303 14.9971 21.303 14.9971 21.303C14.9971 21.303 20.6311 21.303 22.0411 20.931C22.8121 20.724 23.4211 20.115 23.6281 19.344C24.0001 17.934 24.0001 15.015 24.0001 15.015C24.0001 15.015 24.0151 12.078 23.6281 10.671Z" fill="#FF0000"/>
          <path d="M13.2061 12.3001V17.6971L17.8921 14.9971L13.2061 12.2971V12.3001Z" fill="white"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'zalando':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M23.076 12.9571C21.747 11.2891 19.902 9.6751 17.472 8.2141L17.463 8.2051C15.027 6.7771 12.729 5.9461 10.656 5.6041C9.369 5.3881 8.748 5.6341 8.469 5.8051C8.19 5.9671 7.668 6.3961 7.203 7.6441C6.459 9.6541 6.024 12.1081 6 14.9851V14.9941C6.015 17.8741 6.459 20.3341 7.203 22.3441C7.668 23.6011 8.19 24.0211 8.469 24.1921C8.748 24.3541 9.369 24.6121 10.656 24.3931C12.729 24.0511 15.018 23.2141 17.463 21.7861L17.472 21.7771C19.902 20.3161 21.75 18.7051 23.076 17.0341C23.898 15.9931 24 15.3181 24 14.9941C24 14.6701 23.907 13.9951 23.076 12.9541" fill="#FF6900"/>
          <path d="M16.9532 19.656H10.3502C10.1282 19.656 9.96319 19.485 9.96319 19.257V18.432C9.95719 18.228 10.0202 18.141 10.1462 17.982L15.4022 11.727H10.2542C10.0322 11.727 9.86719 11.556 9.86719 11.328V10.743C9.86719 10.521 10.0322 10.344 10.2542 10.344H16.9202C17.1422 10.344 17.3072 10.515 17.3072 10.743V11.586C17.3072 11.739 17.2562 11.865 17.1422 12.006L11.8802 18.279H16.9592C17.1812 18.279 17.3462 18.45 17.3462 18.678V19.263C17.3402 19.485 17.1752 19.656 16.9532 19.656Z" fill="black"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Zepto':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M21.876 6H8.124C6.95095 6 6 6.95095 6 8.124V21.876C6 23.0491 6.95095 24 8.124 24H21.876C23.0491 24 24 23.0491 24 21.876V8.124C24 6.95095 23.0491 6 21.876 6Z" fill="black"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M16.4097 11.4601H11.3277C11.0187 11.4601 10.7217 11.3341 10.4997 11.1121C10.2807 10.8901 10.1577 10.5931 10.1547 10.2811C10.1547 10.1251 10.1817 9.97205 10.2417 9.82805C10.2987 9.68405 10.3857 9.55505 10.4967 9.44405C10.6047 9.33305 10.7367 9.24605 10.8777 9.18905C11.0217 9.12905 11.1747 9.10205 11.3277 9.10205H18.9387C19.0917 9.10205 19.2477 9.12905 19.3887 9.18905C19.5327 9.24905 19.6617 9.33305 19.7697 9.44405C19.8777 9.55505 19.9647 9.68405 20.0247 9.82805C20.0817 9.97205 20.1117 10.1251 20.1117 10.2811C20.0997 10.5961 19.9677 10.8931 19.7457 11.1121L13.5597 18.5371H18.9417C19.0947 18.5371 19.2507 18.5641 19.3917 18.6241C19.5357 18.6841 19.6647 18.7681 19.7727 18.8791C19.8807 18.9901 19.9677 19.1191 20.0277 19.2631C20.0847 19.4071 20.1147 19.5601 20.1147 19.7161C20.1147 20.0281 19.9887 20.328 19.7697 20.547C19.5507 20.769 19.2537 20.8921 18.9417 20.8951H11.0637C10.7487 20.8921 10.4517 20.7631 10.2297 20.538C10.0107 20.313 9.88768 20.0101 9.89068 19.6951C9.89968 19.3831 10.0227 19.0861 10.2357 18.861L16.4127 11.4601H16.4097Z" fill="url(#paint0_linear_2107_18238)"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          <defs>
          <linearGradient id="paint0_linear_2107_18238" x1="14.4717" y1="18.8611" x2="16.3437" y2="7.90805" gradientUnits="userSpaceOnUse">
          <stop stop-color="#FF3269"/>
          <stop offset="1" stop-color="#FF794D"/>
          </linearGradient>
          </defs>
          </svg>';
          break;
       
        case 'Brandsite':
        case 'Brand-Site':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15 24C19.9707 24 24 19.9707 24 15C24 10.0293 19.9707 6 15 6C10.0293 6 6 10.0293 6 15C6 19.9707 10.0293 24 15 24Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M11.5038 6.8999H12.3777C10.6736 12.1573 10.6736 17.8425 12.3777 23.0999H11.5038M17.6215 6.8999C19.3257 12.1573 19.3257 17.8425 17.6215 23.0999" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M6.90039 18.4959V17.622C12.1578 19.3261 17.843 19.3261 23.1004 17.622V18.4959M6.90039 12.3782C12.1578 10.6741 17.843 10.6741 23.1004 12.3782" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#4D4D4D"/>
          </svg>';
          break;
       
        case 'High Resolution':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M14.32 10.228V20H12.36V15.842H8.17405V20H6.21405V10.228H8.17405V14.246H12.36V10.228H14.32ZM21.7892 20L19.6332 16.192H18.7092V20H16.7492V10.228H20.4172C21.1732 10.228 21.8172 10.3633 22.3492 10.634C22.8812 10.8953 23.2779 11.2547 23.5392 11.712C23.8099 12.16 23.9452 12.664 23.9452 13.224C23.9452 13.868 23.7585 14.4513 23.3852 14.974C23.0119 15.4873 22.4565 15.842 21.7192 16.038L24.0572 20H21.7892ZM18.7092 14.722H20.3472C20.8792 14.722 21.2759 14.596 21.5372 14.344C21.7985 14.0827 21.9292 13.7233 21.9292 13.266C21.9292 12.818 21.7985 12.4727 21.5372 12.23C21.2759 11.978 20.8792 11.852 20.3472 11.852H18.7092V14.722Z" fill="white"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Low Grey':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M7.13006 10.228H9.09006V18.446H12.3101V20H7.13006V10.228ZM18.5638 10.102C20.7478 10.102 22.4838 11.208 23.1138 13.168H20.8598C20.4118 12.342 19.5998 11.908 18.5638 11.908C16.8138 11.908 15.5958 13.154 15.5958 15.1C15.5958 17.088 16.8278 18.32 18.6478 18.32C20.1598 18.32 21.1258 17.452 21.4198 16.066H18.0598V14.568H23.3518V16.276C22.9598 18.264 21.1818 20.084 18.5778 20.084C15.7358 20.084 13.5798 18.026 13.5798 15.1C13.5798 12.174 15.7358 10.102 18.5638 10.102Z" fill="white"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        case 'Low White':
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5.33221 10.228H7.29221V18.446H10.5122V20H5.33221V10.228ZM14.232 20.014L11.6 10.228H13.7L15.422 17.816L17.41 10.228H19.594L21.47 17.774L23.206 10.228H25.32L22.59 20H20.28L18.446 13.042L16.528 20L14.232 20.014Z" fill="white"/>
          <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#666666"/>
          </svg>';
          break;
       
        default:
          $svg_is = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 24C19.9707 24 24 19.9707 24 15C24 10.0293 19.9707 6 15 6C10.0293 6 6 10.0293 6 15C6 19.9707 10.0293 24 15 24Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M11.5042 6.8999H12.3781C10.674 12.1573 10.674 17.8425 12.3781 23.0999H11.5042M17.6219 6.8999C19.326 12.1573 19.326 17.8425 17.6219 23.0999" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M6.9 18.4959V17.622C12.1574 19.3261 17.8426 19.3261 23.1 17.622V18.4959M6.9 12.3782C12.1574 10.6741 17.8426 10.6741 23.1 12.3782" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <rect x="0.5" y="0.5" width="29" height="29" rx="14.5" stroke="#4D4D4D" />
          </svg>';
          break;
      }
      $adaptation_data_arr[$adaptation] = trim($svg_is);
    }
    return $adaptation_data_arr;
  }

  // wrc track lot adaptation svg data
  public function track_lot_adaptation_svg_data_arr($adaptation_arr){
    if (in_array('Brand-Site', $adaptation_arr)) {
      $brand_site_key = array_search('Brand-Site', $adaptation_arr);
      unset($adaptation_arr[$brand_site_key]);
      $adaptation_arr[] = 'Brand-Site';
    }

    $adaptation_data_arr = array();
    foreach ($adaptation_arr as $adaptation) {
      switch ($adaptation) {
        case 'Noon':
        case 'Noon-Athletiq':
        case 'Noon-DRIP':
        case 'Noon-QUWA':
        case 'Noon-OFFROAD':
        case 'Noon-AILA':
        case 'Noon-NEON':
        case 'Noon-SHIVCRAFT':
        case 'Noon-ZARAFA':            
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M23.644 8.54004C22.636 8.13604 21.544 7.93604 20.456 7.93604C19.812 7.93604 19.164 8.01604 18.52 8.13604L15.916 12.616C16.984 12.032 18.176 11.748 19.408 11.768C20.156 11.768 20.88 11.868 21.588 12.072L23.648 8.54004H23.644Z" fill="white"/>
          <path d="M8.00019 20.5839C8.00019 27.0399 13.4922 32.0639 19.8882 32.0639C26.2842 32.0639 32.0002 26.6559 32.0002 20.0799C32.0002 16.2279 30.1442 12.8359 27.3762 10.5759L25.3562 14.0679C27.1322 15.5799 28.1602 17.7999 28.1602 20.1399C28.1602 24.6199 24.4442 28.2919 19.8842 28.2919C15.3242 28.2919 11.6282 24.5999 11.6282 20.0399V20.0199C11.6282 19.4759 11.6682 18.9319 11.7682 18.4039L7.99219 20.5839H8.00019Z" fill="white"/>
          </svg>';
          break;

        case 'Amazon':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M28.5761 29.372C26.2521 31.088 22.8801 32 19.9801 32C16.1001 32.02 12.3561 30.592 9.47613 27.992C9.26013 27.796 9.45213 27.528 9.71613 27.68C12.9161 29.512 16.5401 30.472 20.2241 30.468C22.9761 30.456 25.7041 29.896 28.2401 28.828C28.6321 28.664 28.9641 29.088 28.5761 29.372Z" fill="#FF9900"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M29.5441 28.2681C29.2481 27.8881 27.5761 28.0881 26.8281 28.1761C26.6001 28.2041 26.5641 28.0041 26.7721 27.8601C28.1041 26.9241 30.2841 27.1961 30.5361 27.5081C30.7881 27.8201 30.4681 30.0121 29.2241 31.0521C29.0321 31.2121 28.8481 31.1281 28.9361 30.9121C29.2161 30.2161 29.8441 28.6481 29.5481 28.2641L29.5441 28.2681Z" fill="#FF9900"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M21.7518 18.0159C21.7518 19.2399 21.7798 20.2599 21.1638 21.3439C20.7558 22.1799 19.9238 22.7239 18.9918 22.7679C17.7838 22.7679 17.0838 21.8479 17.0838 20.4919C17.0838 17.8199 19.4798 17.3319 21.7478 17.3319V18.0159H21.7518ZM24.9158 25.6639C24.7078 25.8439 24.4118 25.8719 24.1718 25.7399C23.4478 25.1599 22.8358 24.4559 22.3678 23.6599C20.6438 25.4159 19.4238 25.9399 17.1958 25.9399C14.5518 25.9279 12.4998 24.2999 12.4998 21.0399C12.4278 18.7959 13.7638 16.7479 15.8438 15.9119C17.5438 15.1639 19.9238 15.0279 21.7438 14.8279V14.4079C21.7438 13.6599 21.7998 12.7759 21.3638 12.1319C20.9438 11.5999 20.2958 11.2999 19.6158 11.3319C18.4198 11.3319 17.3558 11.9439 17.0918 13.2199C17.0598 13.5119 16.8358 13.7479 16.5478 13.7959L13.4958 13.4639C13.1958 13.4279 12.9838 13.1519 13.0198 12.8519C13.0198 12.8359 13.0238 12.8239 13.0278 12.8079C13.7238 9.11591 17.0558 8.00391 20.0438 8.00391C21.5718 8.00391 23.5678 8.40791 24.7718 9.56791C26.2998 10.9919 26.1518 12.8959 26.1518 14.9679V19.8559C26.1518 21.3239 26.7598 21.9679 27.3358 22.7639C27.5638 22.9959 27.5638 23.3679 27.3358 23.5959C26.6958 24.1319 25.5558 25.1239 24.9318 25.6759L24.9198 25.6679L24.9158 25.6639Z" fill="white"/>
          </svg>';
          break;

        case 'Flipkart':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M30.0718 13.4639C30.0638 13.4359 30.0558 13.4079 30.0438 13.3799C23.3438 13.3799 16.6478 13.3799 9.95583 13.3799C9.93983 13.3999 9.92783 13.4199 9.92383 13.4439C9.92383 18.6399 9.92383 23.8279 9.92383 29.0239C9.96783 29.2999 10.1198 29.5519 10.3238 29.7439C10.3318 29.7439 10.3518 29.7479 10.3598 29.7519C10.4638 29.8639 10.6158 29.9159 10.7558 29.9679C10.8598 29.9599 10.9638 30.0079 11.0678 29.9959H19.3798C19.4598 29.9959 19.5398 30.0079 19.6158 29.9759C19.6158 29.9639 19.6238 29.9439 19.6238 29.9319C19.6238 29.9199 19.6278 29.8879 19.6318 29.8719C19.8118 28.8759 19.9838 27.8799 20.1718 26.8839C20.1798 26.8399 20.1838 26.7999 20.1878 26.7559C19.4198 26.7559 18.6478 26.7559 17.8758 26.7559C17.6878 26.7479 17.4958 26.7559 17.3118 26.7319C16.9918 26.7199 16.6718 26.7319 16.3518 26.6999C15.9558 26.6999 15.5638 26.6639 15.1678 26.6639C14.8558 26.6319 14.5438 26.6439 14.2278 26.6279C14.0238 26.6039 13.8158 26.6159 13.6078 26.6039C13.2718 26.5679 12.9278 26.5919 12.5918 26.5559C12.2358 26.5559 11.8798 26.5279 11.5238 26.5199C11.5238 26.5199 11.5278 26.5079 11.5278 26.5039C11.6478 26.5039 11.7638 26.4959 11.8798 26.4959C12.1438 26.4639 12.4078 26.4839 12.6718 26.4479C12.9478 26.4479 13.2158 26.4119 13.4918 26.4119C13.7358 26.3759 13.9798 26.3999 14.2238 26.3639C14.5078 26.3639 14.7878 26.3279 15.0758 26.3239C15.3118 26.2919 15.5478 26.3119 15.7838 26.2799C16.0598 26.2799 16.3278 26.2399 16.6038 26.2439C16.8718 26.2119 17.1478 26.2199 17.4158 26.1919C17.3918 26.0879 17.3718 25.9839 17.3478 25.8799C17.3278 25.8159 17.2478 25.8279 17.1998 25.8199C16.5838 25.7319 15.9758 25.6439 15.3638 25.5599C15.4038 25.5279 15.4558 25.5439 15.5038 25.5359C15.9798 25.4999 16.4518 25.4559 16.9278 25.4239C17.0358 25.4159 17.1398 25.3999 17.2478 25.3959C17.1998 25.2479 17.1718 25.0879 17.1078 24.9519C16.0918 24.7959 15.0798 24.6559 14.0638 24.4919C14.3278 24.4479 14.5918 24.4319 14.8558 24.3999L14.8798 24.3919C15.7198 24.3039 16.5638 24.2039 17.4038 24.1239C18.4718 24.1199 19.5318 24.1239 20.5998 24.1239C20.6318 24.1199 20.6918 24.1359 20.6998 24.0879C20.7878 23.6279 20.8718 23.1719 20.9598 22.7119C21.0798 22.0759 21.2718 21.4479 21.5718 20.8679C22.0398 19.9359 22.7758 19.1439 23.6758 18.6159C24.5158 18.1239 25.4878 17.8879 26.4558 17.8399C26.7678 17.8119 27.0878 17.8199 27.3958 17.8599C27.5998 17.9079 27.8078 17.9639 27.9678 18.1039C28.0998 18.2119 28.1798 18.3679 28.2398 18.5279C28.3678 18.9039 28.4438 19.2959 28.5038 19.6879C28.5038 19.8479 28.5358 20.0239 28.4518 20.1679C28.3718 20.3079 28.2158 20.3759 28.0638 20.4199C27.5158 20.5599 26.9478 20.4279 26.3998 20.5599C25.9518 20.6559 25.5318 20.9039 25.2478 21.2639C24.9118 21.6799 24.7318 22.2039 24.6318 22.7239C24.5558 23.1879 24.4598 23.6519 24.3838 24.1199C24.9198 24.1199 25.4598 24.1199 25.9998 24.1199C26.2158 24.1199 26.4358 24.2399 26.5238 24.4439C26.6358 24.7039 26.6118 24.9999 26.5758 25.2719C26.5318 25.5799 26.4558 25.8879 26.3198 26.1679C26.2038 26.4079 26.0118 26.6279 25.7478 26.7159C25.6118 26.7719 25.4638 26.7599 25.3198 26.7599C24.8438 26.7599 24.3678 26.7679 23.8958 26.7599C23.8198 27.1079 23.7678 27.4639 23.6998 27.8159C23.5758 28.5039 23.4558 29.1919 23.3278 29.8839C23.3278 29.9079 23.3238 29.9559 23.3238 29.9799C23.5478 29.9919 23.7718 29.9799 23.9918 29.9879C25.6478 29.9879 27.3078 29.9879 28.9678 29.9879C29.1478 29.9959 29.3278 29.9519 29.4838 29.8639C29.5758 29.8319 29.6318 29.7479 29.7158 29.7039C29.7958 29.6599 29.8158 29.5639 29.8838 29.5079C29.9558 29.3799 30.0318 29.2439 30.0398 29.0879C30.0478 29.0879 30.0718 29.0879 30.0838 29.0839C30.0758 23.8799 30.0838 18.6799 30.0758 13.4759L30.0718 13.4639Z" fill="url(#paint0_linear_2107_18585)" stroke="#FCD109" stroke-width="0.09"/>
          <path d="M12.5603 10.0439C12.8003 9.96792 13.0523 10.0199 13.2963 9.99992C17.9123 9.99992 22.5323 9.99992 27.1483 9.99992C27.4243 9.98792 27.6643 10.1439 27.9163 10.2239C28.1203 10.3039 28.3323 10.3719 28.5363 10.4599C28.5803 10.4759 28.6083 10.5119 28.6403 10.5439C28.6403 10.9159 28.6403 11.2919 28.6403 11.6679C28.6403 11.7679 28.6283 11.8679 28.6603 11.9639C28.7203 11.9719 28.7523 12.0159 28.7883 12.0559C28.9763 12.1399 29.1323 12.2799 29.3043 12.3919C29.5603 12.5719 29.8323 12.7319 30.0803 12.9159C30.0923 12.9879 30.0803 13.0639 30.0603 13.1319C30.0363 13.2119 30.0523 13.2959 30.0443 13.3759C23.3443 13.3759 16.6483 13.3759 9.95628 13.3759C9.94428 13.2839 9.96828 13.1879 9.92828 13.0999C9.92028 13.0279 9.89628 12.9319 9.96828 12.8799C10.2523 12.6839 10.5523 12.5039 10.8283 12.2959C11.0003 12.1839 11.1683 12.0719 11.3363 11.9599C11.3723 11.9039 11.3603 11.8319 11.3603 11.7719C11.3603 11.3599 11.3603 10.9519 11.3603 10.5439C11.4563 10.4199 11.6243 10.4039 11.7563 10.3439C12.0243 10.2439 12.2963 10.1439 12.5603 10.0399M12.5763 10.0879C12.2123 10.2279 11.8483 10.3599 11.4883 10.4999C11.4403 10.5079 11.4163 10.5519 11.3883 10.5879C11.3883 10.6119 11.3923 10.6479 11.3923 10.6719C11.3923 11.0119 11.3923 11.3519 11.3923 11.6919C11.3923 11.7759 11.3843 11.8599 11.4163 11.9359C11.3803 11.9719 11.3403 12.0079 11.2963 12.0359C10.8843 12.2999 10.4923 12.5879 10.0803 12.8519C10.0083 12.8959 9.93228 12.9519 9.95228 13.0439C9.94028 13.0959 9.96428 13.1359 10.0163 13.1239C10.9043 13.1159 11.7883 13.1319 12.6763 13.1159C13.9963 13.1159 15.3163 13.1159 16.6363 13.1159L16.6563 13.1079C16.7163 13.1199 16.7763 13.1159 16.8363 13.1159C19.2283 13.1159 21.6203 13.1159 24.0163 13.1159C24.7683 13.1159 25.5243 13.1159 26.2763 13.1159C27.5203 13.1159 28.7683 13.1279 30.0123 13.1239C30.0483 13.1159 30.0603 13.0919 30.0483 13.0439C30.0483 12.9999 30.0603 12.9359 30.0123 12.9079C29.8163 12.8159 29.6443 12.6719 29.4563 12.5559C29.3883 12.4999 29.3003 12.4679 29.2483 12.3919C29.0523 12.2799 28.8723 12.1479 28.6803 12.0239C28.6443 11.9999 28.6163 11.9639 28.5843 11.9319C28.6003 11.8719 28.6083 11.8079 28.6083 11.7439C28.6083 11.3839 28.6083 11.0239 28.6083 10.6679C28.6163 10.6119 28.6123 10.5479 28.5643 10.5079C28.2243 10.3879 27.8883 10.2559 27.5523 10.1319C27.4483 10.0799 27.3323 10.0519 27.2203 10.0359H12.7563C12.6963 10.0359 12.6363 10.0719 12.5723 10.0839L12.5763 10.0879Z" fill="#F8F3B5"/>
          <path d="M12.5603 10.0439C12.8003 9.96792 13.0523 10.0199 13.2963 9.99992C17.9123 9.99992 22.5323 9.99992 27.1483 9.99992C27.4243 9.98792 27.6643 10.1439 27.9163 10.2239C28.1203 10.3039 28.3323 10.3719 28.5363 10.4599C28.5803 10.4759 28.6083 10.5119 28.6403 10.5439C28.6403 10.9159 28.6403 11.2919 28.6403 11.6679C28.6403 11.7679 28.6283 11.8679 28.6603 11.9639C28.7203 11.9719 28.7523 12.0159 28.7883 12.0559C28.9763 12.1399 29.1323 12.2799 29.3043 12.3919C29.5603 12.5719 29.8323 12.7319 30.0803 12.9159C30.0923 12.9879 30.0803 13.0639 30.0603 13.1319C30.0363 13.2119 30.0523 13.2959 30.0443 13.3759C23.3443 13.3759 16.6483 13.3759 9.95628 13.3759C9.94428 13.2839 9.96828 13.1879 9.92828 13.0999C9.92028 13.0279 9.89628 12.9319 9.96828 12.8799C10.2523 12.6839 10.5523 12.5039 10.8283 12.2959C11.0003 12.1839 11.1683 12.0719 11.3363 11.9599C11.3723 11.9039 11.3603 11.8319 11.3603 11.7719C11.3603 11.3599 11.3603 10.9519 11.3603 10.5439C11.4563 10.4199 11.6243 10.4039 11.7563 10.3439C12.0243 10.2439 12.2963 10.1439 12.5603 10.0399M12.5763 10.0879C12.2123 10.2279 11.8483 10.3599 11.4883 10.4999C11.4403 10.5079 11.4163 10.5519 11.3883 10.5879C11.3883 10.6119 11.3923 10.6479 11.3923 10.6719C11.3923 11.0119 11.3923 11.3519 11.3923 11.6919C11.3923 11.7759 11.3843 11.8599 11.4163 11.9359C11.3803 11.9719 11.3403 12.0079 11.2963 12.0359C10.8843 12.2999 10.4923 12.5879 10.0803 12.8519C10.0083 12.8959 9.93228 12.9519 9.95228 13.0439C9.94028 13.0959 9.96428 13.1359 10.0163 13.1239C10.9043 13.1159 11.7883 13.1319 12.6763 13.1159C13.9963 13.1159 15.3163 13.1159 16.6363 13.1159L16.6563 13.1079C16.7163 13.1199 16.7763 13.1159 16.8363 13.1159C19.2283 13.1159 21.6203 13.1159 24.0163 13.1159C24.7683 13.1159 25.5243 13.1159 26.2763 13.1159C27.5203 13.1159 28.7683 13.1279 30.0123 13.1239C30.0483 13.1159 30.0603 13.0919 30.0483 13.0439C30.0483 12.9999 30.0603 12.9359 30.0123 12.9079C29.8163 12.8159 29.6443 12.6719 29.4563 12.5559C29.3883 12.4999 29.3003 12.4679 29.2483 12.3919C29.0523 12.2799 28.8723 12.1479 28.6803 12.0239C28.6443 11.9999 28.6163 11.9639 28.5843 11.9319C28.6003 11.8719 28.6083 11.8079 28.6083 11.7439C28.6083 11.3839 28.6083 11.0239 28.6083 10.6679C28.6163 10.6119 28.6123 10.5479 28.5643 10.5079C28.2243 10.3879 27.8883 10.2559 27.5523 10.1319C27.4483 10.0799 27.3323 10.0519 27.2203 10.0359H12.7563C12.6963 10.0359 12.6363 10.0719 12.5723 10.0839L12.5763 10.0879Z" stroke="#F8F3B5" stroke-width="0.09"/>
          <path d="M11.3917 10.676C11.6397 10.78 11.9077 10.84 12.1597 10.94C12.2957 10.992 12.3397 11.14 12.3957 11.26C12.3357 11.32 12.2677 11.368 12.1957 11.412C11.9357 11.588 11.6717 11.756 11.4117 11.94C11.3797 11.864 11.3917 11.78 11.3877 11.696C11.3877 11.356 11.3877 11.016 11.3877 10.676H11.3917Z" fill="#F7B402" stroke="#F7B402" stroke-width="0.09"/>
          <path d="M27.8358 10.94C28.0878 10.84 28.3518 10.772 28.6038 10.676C28.6038 11.036 28.6038 11.396 28.6038 11.752C28.6038 11.812 28.5958 11.88 28.5798 11.94C28.3598 11.788 28.1358 11.644 27.9158 11.492C27.8078 11.412 27.6878 11.352 27.5918 11.256C27.6518 11.136 27.6958 10.992 27.8318 10.94H27.8358Z" fill="#F7B402" stroke="#F7B402" stroke-width="0.09"/>
          <path d="M15.7082 11.056C16.0202 10.984 16.3682 11.26 16.3402 11.584C16.3402 11.904 16.0082 12.164 15.7002 12.092C15.5762 12.048 15.4562 11.984 15.3802 11.876C15.2802 11.728 15.2602 11.524 15.3362 11.36C15.3922 11.2 15.5442 11.096 15.7082 11.056Z" fill="#BDA727" stroke="#BDA727" stroke-width="0.09"/>
          <path d="M23.7755 11.2359C23.9035 11.0919 24.1115 11.0079 24.3035 11.0599C24.4475 11.1039 24.5875 11.1959 24.6515 11.3359C24.7755 11.5799 24.6795 11.9079 24.4355 12.0359C24.2195 12.1559 23.9475 12.0959 23.7835 11.9239C23.6155 11.7359 23.6035 11.4239 23.7715 11.2359H23.7755Z" fill="#BDA727" stroke="#BDA727" stroke-width="0.09"/>
          <path d="M12.1957 11.412C12.2677 11.368 12.3357 11.32 12.3957 11.26L12.4157 11.28C12.4357 11.428 12.4237 11.576 12.4277 11.724C12.4197 12.164 12.4357 12.608 12.4157 13.052C11.5917 13.052 10.7717 13.044 9.9477 13.052C9.9237 12.96 10.0037 12.904 10.0757 12.86C10.4877 12.596 10.8797 12.308 11.2917 12.044C11.3357 12.016 11.3757 11.98 11.4117 11.944C11.6677 11.764 11.9357 11.592 12.1957 11.416V11.412Z" fill="#F7E62D" stroke="#F7E62D" stroke-width="0.09"/>
          <path d="M27.5684 11.3561C27.5684 11.3201 27.5764 11.2881 27.5964 11.2561C27.6924 11.3521 27.8124 11.4121 27.9204 11.4921C28.1404 11.6401 28.3644 11.7881 28.5844 11.9401C28.6164 11.9721 28.6444 12.0081 28.6804 12.0321C28.8724 12.1521 29.0524 12.2881 29.2484 12.4001C29.3004 12.4761 29.3884 12.5081 29.4564 12.5641C29.6444 12.6761 29.8164 12.8201 30.0124 12.9161C30.0604 12.9441 30.0444 13.0081 30.0484 13.0521C29.2244 13.0521 28.4044 13.0521 27.5844 13.0521C27.5724 12.9401 27.5764 12.8241 27.5764 12.7161C27.5764 12.2641 27.5724 11.8121 27.5764 11.3601L27.5684 11.3561Z" fill="#F7E62D" stroke="#F7E62D" stroke-width="0.09"/>
          <path d="M30.0439 13.0479C29.2199 13.0479 28.3998 13.0479 27.5798 13.0479C27.5639 12.9359 27.5719 12.8199 27.5719 12.7119C27.5719 12.2599 27.5639 11.8079 27.5719 11.3559C27.5719 11.3199 27.5799 11.2879 27.5999 11.2559C27.6599 11.1359 27.7038 10.9919 27.8398 10.9399C28.0919 10.8399 28.3559 10.7719 28.6078 10.6759C28.6158 10.6199 28.6119 10.5559 28.5639 10.5159C28.2239 10.3959 27.8878 10.2639 27.5518 10.1399C27.4478 10.0879 27.3319 10.0599 27.2199 10.0439H12.7599C12.6999 10.0439 12.6399 10.0799 12.5759 10.0919C12.2119 10.2319 11.8479 10.3639 11.4879 10.5039C11.4399 10.5119 11.4159 10.5559 11.3879 10.5919C11.3879 10.6159 11.3919 10.6519 11.3919 10.6759C11.6399 10.7799 11.9079 10.8399 12.1599 10.9399C12.2959 10.9919 12.3399 11.1399 12.3959 11.2599L12.4159 11.2799C12.4359 11.4279 12.4239 11.5759 12.4279 11.7239C12.4199 12.1639 12.4359 12.6079 12.4159 13.0519C11.5919 13.0519 10.7719 13.0439 9.94785 13.0519C9.93185 13.1039 9.95985 13.1439 10.0119 13.1319C10.8999 13.1239 11.7839 13.1399 12.6719 13.1239C13.9919 13.1239 15.3079 13.1239 16.6319 13.1239L16.6519 13.1159C16.7119 13.1279 16.7719 13.1239 16.8319 13.1239C19.2239 13.1239 21.6159 13.1239 24.0119 13.1239C24.7639 13.1239 25.5199 13.1239 26.2719 13.1239C27.5159 13.1239 28.7638 13.1359 30.0078 13.1319C30.0438 13.1239 30.0559 13.0999 30.0439 13.0519V13.0479ZM15.3359 11.3599C15.3919 11.1999 15.5439 11.0959 15.7079 11.0559C16.0199 10.9839 16.3679 11.2599 16.3399 11.5839C16.3399 11.9039 16.0079 12.1639 15.6999 12.0919C15.5759 12.0479 15.4559 11.9839 15.3799 11.8759C15.2799 11.7279 15.2599 11.5239 15.3359 11.3599ZM23.7719 11.2359C23.8999 11.0919 24.1079 11.0079 24.2999 11.0599C24.4439 11.1039 24.5838 11.1959 24.6479 11.3359C24.7719 11.5799 24.6759 11.9079 24.4319 12.0359C24.2159 12.1559 23.9439 12.0959 23.7799 11.9239C23.6119 11.7359 23.5998 11.4239 23.7678 11.2359H23.7719Z" fill="url(#paint1_radial_2107_18585)" stroke="#FCD109" stroke-width="0.09"/>
          <path d="M24.4963 14.2879C24.5363 14.2959 24.2883 14.0519 24.3363 14.0399C24.3803 14.0479 24.5523 13.9119 24.7603 14.0199C24.9683 14.1279 24.9163 14.3839 24.8923 14.4759C24.8643 14.5879 24.7923 14.6599 24.7363 14.7159C24.7043 14.7399 24.6363 14.7799 24.5923 14.7759C24.6163 14.6359 24.5363 14.6159 24.5323 14.4719L24.4963 14.2799V14.2879Z" fill="url(#paint2_linear_2107_18585)" stroke="#FCD109" stroke-width="0.09"/>
          <path d="M15.4561 14.444C15.4481 14.584 15.3681 14.608 15.3961 14.748C15.3521 14.748 15.2841 14.712 15.2521 14.688C15.1961 14.632 15.1241 14.56 15.0961 14.448C15.0721 14.352 15.0201 14.1 15.2281 13.992C15.4361 13.884 15.6081 14.016 15.6521 14.012C15.7001 14.024 15.4561 14.268 15.4921 14.26L15.4561 14.452V14.444Z" fill="url(#paint3_linear_2107_18585)" stroke="#FCD109" stroke-width="0.09"/>
          <path d="M24.1282 16.1C24.1722 16.064 24.2002 16.064 24.2562 16.064C23.9162 16.8 23.5202 17.536 22.9242 18.108C22.8602 18.164 22.7962 18.216 22.7242 18.264C22.6562 18.312 22.5882 18.36 22.5242 18.408C22.4602 18.452 22.3962 18.5 22.3322 18.544C22.1722 18.632 22.0282 18.752 21.8522 18.808C21.5282 18.964 21.1762 19.068 20.8242 19.14C20.6842 19.164 20.5442 19.196 20.4042 19.2C20.2282 19.252 20.0402 19.216 19.8642 19.224C19.7642 19.24 19.6762 19.184 19.5802 19.196C19.4962 19.184 19.4122 19.172 19.3322 19.152C19.2482 19.136 19.1642 19.116 19.0802 19.092C17.7842 18.688 16.5122 17.696 16.1402 16.36C16.1242 16.272 16.1162 16.18 16.1162 16.088C16.1562 16.168 16.1962 16.244 16.2402 16.324C16.7682 17.472 17.8122 18.38 19.0482 18.652C19.1482 18.696 19.2562 18.684 19.3522 18.72C19.4402 18.72 19.5242 18.72 19.6082 18.744C19.9002 18.752 20.1922 18.744 20.4802 18.744C20.5202 18.744 20.5562 18.728 20.5962 18.72C21.0802 18.704 21.5562 18.572 22.0002 18.368C22.0882 18.328 22.1762 18.284 22.2602 18.24C22.3362 18.2 22.4082 18.156 22.4802 18.112C22.5522 18.068 22.6202 18.02 22.6842 17.968C23.2082 17.552 23.6602 17.016 23.9682 16.4C24.0282 16.288 24.0802 16.184 24.1282 16.092V16.1Z" fill="#BDA727" stroke="#BDA727" stroke-width="0.09"/>
          <path d="M23.6638 18.6161C24.5038 18.1241 25.4758 17.8881 26.4438 17.8401C26.7558 17.8121 27.0758 17.8201 27.3838 17.8601C27.5878 17.9081 27.7958 17.9641 27.9558 18.1041C27.8758 18.1121 27.7958 18.0721 27.7118 18.0601C27.4798 18.0161 27.2398 18.0321 27.0038 18.0281C26.3198 18.0281 25.6358 18.0801 24.9758 18.2681C24.6318 18.3721 24.2878 18.4961 23.9718 18.6761C23.4278 18.9761 22.9398 19.3721 22.5438 19.8481C21.8358 20.6601 21.4198 21.6881 21.2198 22.7361C21.1238 23.3001 21.0118 23.8601 20.9238 24.4241C20.7838 24.4361 20.6398 24.4321 20.4958 24.4321C19.8758 24.4321 19.2518 24.4241 18.6278 24.4201C18.4958 24.4281 18.3638 24.3961 18.2318 24.4041C17.0998 24.4121 15.9718 24.4041 14.8398 24.4041L14.8638 24.3961C15.7038 24.3081 16.5478 24.2081 17.3878 24.1281C18.4558 24.1241 19.5158 24.1281 20.5838 24.1281C20.6158 24.1241 20.6758 24.1401 20.6838 24.0921C20.7718 23.6361 20.8558 23.1761 20.9438 22.7161C21.0678 22.0801 21.2558 21.4521 21.5558 20.8721C22.0238 19.9401 22.7598 19.1481 23.6598 18.6201L23.6638 18.6161Z" fill="#0D69B3" stroke="#0D69B3" stroke-width="0.09"/>
          <path d="M24.9844 18.2681C25.6444 18.0801 26.3284 18.0281 27.0124 18.0281C27.2484 18.0361 27.4884 18.0161 27.7204 18.0601C27.8004 18.0721 27.8804 18.1081 27.9644 18.1041C28.0964 18.2121 28.1764 18.3681 28.2364 18.5281C28.3644 18.9041 28.4404 19.2961 28.5004 19.6881C28.5004 19.8481 28.5324 20.0241 28.4484 20.1681C28.3684 20.3081 28.2124 20.3761 28.0604 20.4201C27.5124 20.5601 26.9444 20.4281 26.3964 20.5601C25.9484 20.6561 25.5284 20.9041 25.2404 21.2641C24.9044 21.6801 24.7244 22.2041 24.6244 22.7241C24.5484 23.1881 24.4524 23.6521 24.3764 24.1201C24.3404 24.2241 24.3244 24.3361 24.3044 24.4481C24.8404 24.4561 25.3724 24.4481 25.9084 24.4561C26.1124 24.4481 26.3164 24.4641 26.5204 24.4481C26.6324 24.7081 26.6084 25.0041 26.5724 25.2761C26.5284 25.5841 26.4524 25.8881 26.3164 26.1721C26.2004 26.4121 26.0084 26.6321 25.7444 26.7201C25.6084 26.7721 25.4604 26.7641 25.3164 26.7641C24.8404 26.7641 24.3644 26.7681 23.8924 26.7641C23.8164 27.1121 23.7644 27.4681 23.6964 27.8201C23.5724 28.5081 23.4524 29.1961 23.3244 29.8881C23.3244 29.9121 23.3204 29.9601 23.3204 29.9841C22.0844 29.9841 20.8524 29.9881 19.6164 29.9841C19.6164 29.9721 19.6244 29.9521 19.6244 29.9401C19.6244 29.9281 19.6284 29.8961 19.6324 29.8801C19.6324 29.9041 19.6364 29.9441 19.6404 29.9641C19.7164 29.9721 19.8564 30.0121 19.8764 29.9041C20.0684 28.8641 20.2484 27.8161 20.4444 26.7761C20.3684 26.7601 20.2884 26.7601 20.2084 26.7761C20.1964 26.8161 20.1844 26.8561 20.1724 26.8961C20.1764 26.8521 20.1844 26.8121 20.1884 26.7681C19.4204 26.7681 18.6484 26.7681 17.8764 26.7681C17.6884 26.7641 17.4964 26.7681 17.3124 26.7441C16.9924 26.7321 16.6724 26.7441 16.3524 26.7081C15.9564 26.7081 15.5644 26.6721 15.1684 26.6721C14.8564 26.6401 14.5444 26.6521 14.2284 26.6401C14.0244 26.6161 13.8164 26.6241 13.6084 26.6161C13.2724 26.5801 12.9284 26.6041 12.5924 26.5681C12.2364 26.5681 11.8804 26.5401 11.5244 26.5321L11.5284 26.5161C11.6484 26.5161 11.7644 26.5081 11.8804 26.5081C12.1444 26.4761 12.4084 26.4961 12.6724 26.4601C12.9484 26.4601 13.2204 26.4241 13.4924 26.4241C13.7364 26.3921 13.9804 26.4121 14.2244 26.3761C14.5084 26.3761 14.7884 26.3401 15.0764 26.3361C15.3124 26.3041 15.5484 26.3241 15.7844 26.2921C16.0604 26.2921 16.3284 26.2521 16.6044 26.2561C16.8724 26.2241 17.1484 26.2321 17.4164 26.2041C17.3924 26.1001 17.3724 25.9961 17.3484 25.8921C17.3284 25.8281 17.2484 25.8401 17.2004 25.8321C16.5844 25.7441 15.9764 25.6561 15.3644 25.5721C15.4044 25.5401 15.4564 25.5561 15.5044 25.5481C15.9804 25.5121 16.4524 25.4681 16.9284 25.4361C17.0364 25.4281 17.1404 25.4121 17.2484 25.4081C17.2004 25.2601 17.1724 25.1001 17.1084 24.9641C16.0924 24.8081 15.0804 24.6681 14.0644 24.5041C14.3284 24.4601 14.5924 24.4441 14.8564 24.4121C15.9884 24.4121 17.1164 24.4201 18.2484 24.4121C18.3804 24.4041 18.5124 24.4361 18.6444 24.4281C19.2644 24.4361 19.8884 24.4361 20.5124 24.4401C20.6524 24.4401 20.7964 24.4481 20.9404 24.4321C21.0284 23.8681 21.1364 23.3081 21.2364 22.7441C21.4364 21.6961 21.8524 20.6641 22.5604 19.8561C22.9564 19.3801 23.4444 18.9841 23.9884 18.6841C24.3004 18.5041 24.6484 18.3841 24.9924 18.2761L24.9844 18.2681Z" fill="#107BD4" stroke="#107BD4" stroke-width="0.09"/>
          <path d="M24.3758 24.1161C24.9118 24.1161 25.4518 24.1161 25.9918 24.1161C26.2078 24.1161 26.4278 24.2361 26.5158 24.4401C26.3118 24.4561 26.1078 24.4401 25.9038 24.4481C25.3678 24.4401 24.8358 24.4481 24.2998 24.4401C24.3198 24.3281 24.3398 24.2161 24.3718 24.1121L24.3758 24.1161Z" fill="#0D69B3" stroke="#0D69B3" stroke-width="0.09"/>
          <path d="M20.2078 26.7681C20.2878 26.7521 20.3678 26.7521 20.4438 26.7681C20.2478 27.8081 20.0678 28.8561 19.8758 29.8961C19.8558 30.0081 19.7158 29.9681 19.6398 29.9561C19.6398 29.9361 19.6358 29.8961 19.6318 29.8721C19.8118 28.8761 19.9838 27.8801 20.1718 26.8841C20.1878 26.8441 20.1958 26.8041 20.2078 26.7641V26.7681Z" fill="#0D69B3" stroke="#0D69B3" stroke-width="0.09"/>
          <path d="M24.6244 14.3681C24.6004 14.3241 24.6004 14.2761 24.6004 14.2281H24.5764C24.5404 14.1041 24.4364 13.9881 24.3004 13.9841C24.2004 13.9761 24.0724 13.9761 24.0124 14.0761C23.9004 14.2281 23.9524 14.4241 23.9484 14.5961C23.9484 14.6081 23.9484 14.6281 23.9484 14.6401C23.9484 14.7561 23.9324 14.8681 23.9124 14.9841C23.8964 15.0161 23.8884 15.0561 23.8884 15.0961C23.8404 15.3601 23.7444 15.6241 23.6124 15.8641C23.5884 15.8961 23.5684 15.9361 23.5604 15.9761C23.4764 16.1241 23.3724 16.2601 23.2684 16.3921C23.2524 16.4081 23.2364 16.4241 23.2244 16.4401C23.1524 16.5321 23.0724 16.6081 22.9884 16.6841C22.9684 16.6961 22.9564 16.7081 22.9364 16.7201C22.8404 16.8121 22.7324 16.9001 22.6164 16.9721C22.6044 16.9801 22.5884 16.9921 22.5724 17.0041C21.8484 17.4841 20.9684 17.6801 20.1124 17.6881C19.3844 17.7121 18.6524 17.5561 17.9964 17.2401C17.9844 17.2321 17.9564 17.2241 17.9444 17.2161C17.8324 17.1561 17.7204 17.1041 17.6204 17.0321C17.5964 17.0201 17.5764 17.0081 17.5484 16.9961C17.4444 16.9361 17.3444 16.8681 17.2524 16.7881C17.2204 16.7601 17.1884 16.7361 17.1524 16.7121C17.0484 16.6321 16.9444 16.5441 16.8564 16.4441C16.8324 16.4201 16.8124 16.3961 16.7884 16.3721C16.4804 16.0521 16.2404 15.6641 16.1124 15.2401C15.9924 14.9041 16.0084 14.5361 15.9924 14.1841C15.8884 14.0281 15.6764 13.9401 15.5044 14.0361C15.4324 14.0881 15.4244 14.1801 15.3724 14.2441C15.2844 15.1761 15.6844 16.1081 16.3204 16.7801C16.3204 16.8041 16.3324 16.8161 16.3524 16.8241C16.4644 16.9281 16.5764 17.0361 16.6884 17.1361C16.7084 17.1561 16.7324 17.1761 16.7564 17.1921C16.8684 17.2841 16.9924 17.3721 17.1084 17.4561C17.1324 17.4721 17.1524 17.4881 17.1804 17.5001C17.3364 17.5921 17.4844 17.6961 17.6484 17.7601C17.6604 17.7681 17.6804 17.7841 17.6924 17.7881C18.2284 18.0441 18.8084 18.2201 19.4044 18.2761C19.4684 18.2761 19.5324 18.2841 19.6004 18.2961C19.8844 18.3121 20.1644 18.3041 20.4484 18.2961C21.3204 18.2201 22.2244 18.0081 22.9524 17.4921L22.9604 17.5041C22.9844 17.4841 23.0044 17.4681 23.0244 17.4521C23.1404 17.3681 23.2524 17.2761 23.3684 17.1841C23.3924 17.1641 23.4204 17.1401 23.4484 17.1161C23.5724 16.9801 23.7164 16.8561 23.8204 16.7001L23.8364 16.7081C23.8364 16.7081 23.8604 16.6641 23.8684 16.6521C23.9644 16.5241 24.0524 16.3881 24.1364 16.2521C24.1404 16.2441 24.1564 16.2281 24.1604 16.2201L24.1484 16.2081C24.1484 16.2081 24.1764 16.1761 24.1844 16.1641C24.3404 15.8481 24.4804 15.5161 24.5284 15.1641C24.5484 15.1561 24.5604 15.1401 24.5604 15.1201C24.5604 15.0081 24.6044 14.9001 24.5924 14.7881C24.6164 14.6481 24.6204 14.5081 24.6164 14.3681H24.6244Z" fill="white" stroke="white" stroke-width="0.09"/>
          <mask id="mask0_2107_18585" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="15" y="13" width="10" height="6">
          <path d="M24.6244 14.3681C24.6004 14.3241 24.6004 14.2761 24.6004 14.2281H24.5764C24.5404 14.1041 24.4364 13.9881 24.3004 13.9841C24.2004 13.9761 24.0724 13.9761 24.0124 14.0761C23.9004 14.2281 23.9524 14.4241 23.9484 14.5961C23.9484 14.6081 23.9484 14.6281 23.9484 14.6401C23.9484 14.7561 23.9324 14.8681 23.9124 14.9841C23.8964 15.0161 23.8884 15.0561 23.8884 15.0961C23.8404 15.3601 23.7444 15.6241 23.6124 15.8641C23.5884 15.8961 23.5684 15.9361 23.5604 15.9761C23.4764 16.1241 23.3724 16.2601 23.2684 16.3921C23.2524 16.4081 23.2364 16.4241 23.2244 16.4401C23.1524 16.5321 23.0724 16.6081 22.9884 16.6841C22.9684 16.6961 22.9564 16.7081 22.9364 16.7201C22.8404 16.8121 22.7324 16.9001 22.6164 16.9721C22.6044 16.9801 22.5884 16.9921 22.5724 17.0041C21.8484 17.4841 20.9684 17.6801 20.1124 17.6881C19.3844 17.7121 18.6524 17.5561 17.9964 17.2401C17.9844 17.2321 17.9564 17.2241 17.9444 17.2161C17.8324 17.1561 17.7204 17.1041 17.6204 17.0321C17.5964 17.0201 17.5764 17.0081 17.5484 16.9961C17.4444 16.9361 17.3444 16.8681 17.2524 16.7881C17.2204 16.7601 17.1884 16.7361 17.1524 16.7121C17.0484 16.6321 16.9444 16.5441 16.8564 16.4441C16.8324 16.4201 16.8124 16.3961 16.7884 16.3721C16.4804 16.0521 16.2404 15.6641 16.1124 15.2401C15.9924 14.9041 16.0084 14.5361 15.9924 14.1841C15.8884 14.0281 15.6764 13.9401 15.5044 14.0361C15.4324 14.0881 15.4244 14.1801 15.3724 14.2441C15.2844 15.1761 15.6844 16.1081 16.3204 16.7801C16.3204 16.8041 16.3324 16.8161 16.3524 16.8241C16.4644 16.9281 16.5764 17.0361 16.6884 17.1361C16.7084 17.1561 16.7324 17.1761 16.7564 17.1921C16.8684 17.2841 16.9924 17.3721 17.1084 17.4561C17.1324 17.4721 17.1524 17.4881 17.1804 17.5001C17.3364 17.5921 17.4844 17.6961 17.6484 17.7601C17.6604 17.7681 17.6804 17.7841 17.6924 17.7881C18.2284 18.0441 18.8084 18.2201 19.4044 18.2761C19.4684 18.2761 19.5324 18.2841 19.6004 18.2961C19.8844 18.3121 20.1644 18.3041 20.4484 18.2961C21.3204 18.2201 22.2244 18.0081 22.9524 17.4921L22.9604 17.5041C22.9844 17.4841 23.0044 17.4681 23.0244 17.4521C23.1404 17.3681 23.2524 17.2761 23.3684 17.1841C23.3924 17.1641 23.4204 17.1401 23.4484 17.1161C23.5724 16.9801 23.7164 16.8561 23.8204 16.7001L23.8364 16.7081C23.8364 16.7081 23.8604 16.6641 23.8684 16.6521C23.9644 16.5241 24.0524 16.3881 24.1364 16.2521C24.1404 16.2441 24.1564 16.2281 24.1604 16.2201L24.1484 16.2081C24.1484 16.2081 24.1764 16.1761 24.1844 16.1641C24.3404 15.8481 24.4804 15.5161 24.5284 15.1641C24.5484 15.1561 24.5604 15.1401 24.5604 15.1201C24.5604 15.0081 24.6044 14.9001 24.5924 14.7881C24.6164 14.6481 24.6204 14.5081 24.6164 14.3681H24.6244Z" fill="white"/>
          </mask>
          <g mask="url(#mask0_2107_18585)">
          <path d="M15.168 14.2722C15.396 14.3442 15.924 14.1642 16.072 14.3282" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M15.2998 14.9721C15.5198 14.8961 15.9918 14.7161 16.1838 14.8201" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M15.5283 15.6681C15.6323 15.7041 15.8443 15.5161 15.9483 15.4601C16.1043 15.3801 16.2603 15.3161 16.4323 15.2881" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M15.8643 16.4041C15.9723 16.2481 16.1043 16.1201 16.2643 16.0081C16.4203 15.9001 16.8483 15.6041 17.0323 15.7081" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M16.1836 16.932C16.3076 16.832 16.3596 16.66 16.4876 16.556C16.6476 16.432 16.8876 16.408 17.0476 16.332" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M16.7197 17.3242C16.7557 17.0522 17.0357 16.7201 17.2997 16.7441" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M17.1279 17.7041C17.2679 17.6921 17.3879 17.3761 17.4799 17.2721C17.6199 17.1121 17.7679 17.0641 17.9559 17.0081" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M17.9397 18.0441C17.9317 17.8481 18.1357 17.2801 18.3717 17.3081" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M18.5404 18.2322C18.5324 18.0002 18.6524 17.2962 18.9364 17.2722" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M19.1637 18.6083C19.1077 18.2803 19.1117 17.8083 19.3717 17.5723" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M19.9357 18.6842C19.9077 18.4122 19.6357 17.8602 19.9357 17.6482" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M20.7682 18.496C20.6402 18.348 20.5642 17.756 20.6162 17.592" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M21.556 18.3641C21.456 18.1841 21.332 18.0121 21.296 17.8041C21.272 17.6801 21.312 17.5001 21.296 17.4041" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M22.216 18.08C22 17.94 21.94 17.42 22.008 17.196" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M22.86 17.7962C22.708 17.4642 22.544 17.2122 22.54 16.8362" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M23.4797 17.1961C23.2397 17.0361 22.9357 16.7441 22.9717 16.4241" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M24.14 16.684C23.776 16.604 23.34 16.28 23.124 15.988" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M24.4435 16.0641C24.1795 16.0081 23.3155 15.6721 23.3675 15.3281" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M24.7241 15.4042C24.3601 15.2682 23.8281 15.1522 23.5361 14.8962" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M24.9122 14.8002C24.6842 14.8202 24.3522 14.7082 24.1202 14.6682C23.8602 14.6242 23.6202 14.5362 23.3682 14.4802" stroke="#D1D1D1" stroke-width="2"/>
          <path d="M24.6878 14.2161C24.2438 14.2441 23.8278 14.0921 23.4238 13.9521" stroke="#D1D1D1" stroke-width="2"/>
          </g>
          <defs>
          <linearGradient id="paint0_linear_2107_18585" x1="19.9998" y1="13.3799" x2="19.9998" y2="29.9999" gradientUnits="userSpaceOnUse">
          <stop stop-color="#F7E830"/>
            <stop offset="1" stop-color="#FDCB06"/>
            </linearGradient>
            <radialGradient id="paint1_radial_2107_18585" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(19.9886 21.4485) scale(13.5596 13.5596)">
            <stop offset="0.6" stop-color="#F29405"/>
            <stop offset="0.74" stop-color="#F7D01E"/>
            <stop offset="1" stop-color="#FDCB06"/>
            </radialGradient>
            <linearGradient id="paint2_linear_2107_18585" x1="24.6243" y1="13.9799" x2="24.6283" y2="14.7679" gradientUnits="userSpaceOnUse">
            <stop stop-color="#FADA1C"/>
            <stop offset="1" stop-color="#FDCB06"/>
            </linearGradient>
            <linearGradient id="paint3_linear_2107_18585" x1="15.3681" y1="13.944" x2="15.3641" y2="14.728" gradientUnits="userSpaceOnUse">
            <stop stop-color="#FADA1C"/>
            <stop offset="1" stop-color="#FDCB06"/>
            </linearGradient>
            </defs>
          </svg>';
          break;

        case 'Myntra':
        case 'Myntra Premium':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M12.4239 12.604C12.9399 11.988 13.5039 11.324 14.2919 11.068C15.1799 10.836 15.9359 11.532 16.5039 12.132C17.9759 13.812 19.0399 15.788 20.0279 17.776C20.5679 16.572 21.2319 15.424 21.9319 14.304C22.5959 13.292 23.2799 12.26 24.2319 11.488C24.6719 11.148 25.2879 10.832 25.8359 11.116C26.6159 11.532 27.2079 12.212 27.7559 12.884C28.9279 14.388 29.8519 16.076 30.6719 17.788C31.7119 20 32.6079 22.3 32.9839 24.72C33.0999 25.84 33.1999 27.096 32.5199 28.076C31.9959 28.84 30.9999 29.108 30.1279 28.956C29.3639 28.692 28.6919 28.184 28.1919 27.552C27.0039 26.08 26.2959 24.296 25.6319 22.54C25.5319 22.232 25.4159 21.932 25.3159 21.624C25.2479 21.94 25.1599 22.24 25.0599 22.548C24.3879 24.328 23.6719 26.148 22.4439 27.624C21.9519 28.232 21.3039 28.696 20.5679 28.952C19.5039 29.176 18.4839 28.62 17.7999 27.848C16.4639 26.384 15.7159 24.508 15.0319 22.68C14.8999 22.308 14.7679 21.924 14.6679 21.54C14.5599 21.932 14.4279 22.32 14.2839 22.696C13.6679 24.384 12.9639 26.076 11.8399 27.5C11.2319 28.232 10.4359 28.944 9.4399 28.996C8.5239 29.08 7.6279 28.48 7.2799 27.64C6.7799 26.476 6.9239 25.164 7.1479 23.952C7.6199 21.632 8.5119 19.424 9.5479 17.304C10.3799 15.652 11.2919 14.048 12.4319 12.608M12.9559 13.116C11.8239 14.572 10.9279 16.184 10.1159 17.828C9.1039 19.956 8.1959 22.164 7.8039 24.5C7.6719 25.148 7.6639 25.82 7.7359 26.468C7.8119 27.084 8.0599 27.748 8.6239 28.072C9.1639 28.388 9.8639 28.264 10.3599 27.916C11.2479 27.3 11.8319 26.352 12.3359 25.424C13.4239 23.34 14.1399 21.088 14.6799 18.808C15.2519 21.144 15.9759 23.468 17.1239 25.588C17.5799 26.376 18.0639 27.192 18.8039 27.732C19.1759 28.064 19.6759 28.304 20.1839 28.248C20.7559 28.188 21.2399 27.824 21.6399 27.432C22.3279 26.724 22.8279 25.86 23.2679 24.988C24.2079 23.06 24.8559 21 25.3719 18.924C26.0039 21.44 26.7919 23.968 28.1399 26.196C28.6479 26.976 29.2439 27.792 30.1359 28.148C30.7679 28.404 31.5559 28.18 31.9159 27.592C32.3479 26.892 32.3799 26.028 32.3159 25.232C32.2239 23.944 31.8519 22.688 31.4359 21.476C30.6119 19.116 29.5319 16.856 28.2119 14.736C27.5959 13.788 26.9639 12.84 26.1159 12.092C25.8159 11.828 25.3679 11.568 24.9839 11.836C24.2519 12.284 23.7359 13 23.2319 13.68C21.9759 15.468 20.9479 17.404 20.0999 19.404C20.0759 19.436 20.0239 19.496 19.9999 19.52C19.9239 19.296 19.8519 19.072 19.7519 18.856C18.8879 16.98 17.9159 15.132 16.6959 13.464C16.2719 12.916 15.8479 12.352 15.2759 11.944C15.0359 11.768 14.7119 11.62 14.4199 11.768C13.8199 12.06 13.3879 12.616 12.9639 13.116" fill="#FEFEFE"/>
          <path d="M12.9477 13.112C13.3717 12.604 13.7957 12.056 14.4117 11.776C14.7037 11.628 15.0277 11.776 15.2677 11.952C15.8317 12.36 16.2637 12.924 16.6877 13.472C17.9077 15.144 18.8797 16.988 19.7437 18.864C19.8437 19.08 19.9197 19.304 19.9917 19.528C18.8597 17.608 17.8317 15.616 16.4197 13.876C16.0037 13.396 15.5717 12.88 14.9757 12.612C14.6357 12.472 14.2877 12.66 14.0117 12.844C12.9997 13.692 12.2517 14.804 11.5437 15.912C9.88371 18.564 8.62771 21.472 7.80371 24.488C8.19571 22.152 9.09971 19.944 10.1157 17.816C10.9237 16.18 11.8197 14.568 12.9477 13.112Z" fill="#9E242E"/>
          <path d="M24.9799 11.84C25.3639 11.576 25.8119 11.832 26.1119 12.096C26.9679 12.844 27.5999 13.792 28.2079 14.74C29.5279 16.86 30.6159 19.12 31.4319 21.48C31.8479 22.7 32.2199 23.948 32.3119 25.236C32.1719 24.34 31.9399 23.456 31.6319 22.6C30.8519 20.248 29.7719 18.004 28.4559 15.904C27.8839 15.008 27.2759 14.116 26.5359 13.344C26.2359 13.052 25.9199 12.744 25.5239 12.612C25.2079 12.512 24.9159 12.736 24.6679 12.896C23.9879 13.428 23.4559 14.124 22.9479 14.824C22.0519 16.096 21.2519 17.432 20.5199 18.812C20.4039 19.036 20.2559 19.236 20.0879 19.428C20.9359 17.416 21.9639 15.48 23.2199 13.704C23.7359 13.008 24.2519 12.292 24.9799 11.844" fill="#9E242E"/>
          <path d="M14.0123 12.8559C14.2963 12.6719 14.6363 12.4839 14.9763 12.6239C15.5763 12.8799 16.0083 13.3959 16.4203 13.8879C17.8323 15.6239 18.8723 17.6199 19.9923 19.5399C19.2843 21.5439 18.4483 23.5719 18.3963 25.7239C18.3643 26.4239 18.5443 27.0959 18.8043 27.7359C18.0563 27.1959 17.5763 26.3719 17.1243 25.5919C15.9763 23.4639 15.2563 21.1479 14.6803 18.8119C14.2563 16.8519 13.8723 14.8639 14.0083 12.8639" fill="#FF912E"/>
          <path d="M24.6641 12.8879C24.9201 12.7319 25.2041 12.5159 25.5201 12.6039C25.9281 12.7359 26.2441 13.0439 26.5321 13.3359C27.2721 14.1079 27.8801 14.9879 28.4521 15.8959C29.7641 17.9919 30.8441 20.2399 31.6281 22.5919C31.9361 23.4479 32.1681 24.3279 32.3081 25.2279C32.3761 26.0239 32.3401 26.8879 31.9081 27.5879C31.5521 28.1759 30.7601 28.4039 30.1281 28.1439C29.2401 27.7799 28.6401 26.9719 28.1321 26.1919C26.7761 23.9559 25.9961 21.4399 25.3561 18.9199C24.9241 16.9359 24.5321 14.9159 24.6561 12.8879" fill="#F41CB2"/>
          <path d="M11.5437 15.92C12.2517 14.816 12.9997 13.7001 14.0117 12.8521C13.8797 14.8561 14.2597 16.84 14.6757 18.792C14.1357 21.068 13.4197 23.328 12.3317 25.408C11.8237 26.34 11.2357 27.284 10.3557 27.9C9.85568 28.248 9.15968 28.38 8.61968 28.056C8.05568 27.74 7.80368 27.076 7.73168 26.452C7.65568 25.796 7.66368 25.124 7.79968 24.484C8.63168 21.476 9.88368 18.5681 11.5477 15.9161" fill="#F41CB2"/>
          <path d="M22.9444 14.8079C23.4524 14.1079 23.9844 13.4199 24.6644 12.8799C24.5324 14.9159 24.9284 16.9359 25.3644 18.9039C24.8564 20.9799 24.2004 23.0439 23.2604 24.9679C22.8204 25.8399 22.3204 26.7039 21.6324 27.4119C21.2324 27.8039 20.7524 28.1679 20.1764 28.2279C19.6604 28.2879 19.1644 28.0439 18.7964 27.7119C18.5404 27.0719 18.3564 26.3999 18.3884 25.6999C18.4364 23.5399 19.2764 21.5199 19.9844 19.5159C20.0084 19.4839 20.0604 19.4239 20.0844 19.3999C20.2524 19.2079 20.4004 19.0079 20.5164 18.7839C21.2484 17.4199 22.0444 16.0759 22.9444 14.8039" fill="#F25511"/>
          </svg>';
          break;
       
        case 'Nykaa':
        case 'Nykaa Fashion':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M29.5037 10.2401C30.2197 8.86411 27.8957 9.25211 27.8957 9.25211C27.0637 9.25211 26.6917 10.2561 26.5197 10.5441L24.0077 15.4921C23.5357 16.3081 21.9717 19.8121 21.4557 20.5841C21.4117 19.7961 21.4717 18.2161 21.4837 17.8441C21.5837 16.3521 21.6837 15.2201 21.8437 13.8561C21.9597 12.7961 22.1877 11.6041 21.9717 10.5401C21.8277 9.88011 21.6117 9.83611 20.6677 9.73611C19.6797 9.63611 19.0037 11.0721 18.6717 11.7441C17.4677 14.2401 16.1197 16.6801 15.0437 19.2321C14.7277 19.9801 14.3397 20.7241 14.0117 21.4561C13.6237 22.3441 13.2637 23.2201 12.8477 24.0961C12.4037 25.0161 11.0117 28.0281 10.6237 28.9721C10.1917 30.0041 10.1077 30.8361 11.8277 30.7921C12.0997 30.7921 12.7037 30.8481 13.4477 30.0441C14.0357 29.4121 14.1517 28.8241 14.4957 27.9481C15.7277 24.8481 16.6037 22.7961 17.9517 19.7281C18.0797 19.4281 18.3837 18.5521 18.6837 17.8761C18.6677 18.8361 18.5117 19.9841 18.4397 20.7441C18.2117 23.5281 18.0517 26.2081 17.8077 28.9641C17.7797 29.3361 17.6797 29.7801 17.8517 30.1281C18.0237 30.4761 18.4557 30.5601 18.7997 30.6001C20.1757 30.7721 20.3197 30.0841 20.7517 29.1361C21.1397 28.2881 21.3677 27.6001 21.7117 26.7401C22.7717 24.0841 23.8917 21.4601 25.1277 18.8801C25.4437 18.2201 25.7597 17.5761 26.1037 16.9281C26.7357 15.7361 27.2517 14.6201 27.9397 13.3001C28.4557 12.3521 28.9597 11.2761 29.5037 10.2281V10.2401Z" fill="#FC2779"/>
          </svg>';
          break;
       
        case 'Tata Cliq':
        case 'Tata Cliq luxury':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M31.436 28.7399L28.852 26.1479L29.3 25.4079C29.884 24.4319 30.324 23.3759 30.6 22.2719C30.924 20.8839 31.016 19.4519 30.852 18.0399C30.796 17.5439 30.704 17.0799 30.592 16.6439C30.316 15.5559 29.876 14.5079 29.284 13.5319C29.164 13.3119 29.016 13.0839 28.836 12.8319C27.388 10.7839 25.308 9.2639 22.912 8.4999L22.872 8.4919C22.768 8.4599 22.652 8.4279 22.532 8.3959L22.5 8.3879C20.988 7.9799 19.412 7.8919 17.868 8.1279C16.932 8.2759 16.024 8.5359 15.156 8.8919C14.604 9.1199 14.076 9.3959 13.58 9.7039C12.296 10.4759 11.184 11.4919 10.288 12.6839C9.392 13.8759 8.736 15.2279 8.356 16.6639C8.12 17.5839 8 18.5239 8 19.4759C8 19.9879 8.04 20.4919 8.104 20.9959L8.128 21.1839L8.152 21.3039L8.168 21.4079C8.34 22.4559 8.664 23.4799 9.12 24.4399C9.292 24.7879 9.476 25.1239 9.68 25.4479C10.452 26.7159 11.468 27.8199 12.672 28.6879C13.876 29.5639 15.224 30.2079 16.66 30.5879C17.596 30.8159 18.552 30.9359 19.52 30.9359C20.096 30.9359 20.68 30.8879 21.252 30.7959C22.52 30.5919 23.748 30.1879 24.884 29.5999L24.948 29.5679C25.112 29.4879 25.264 29.3959 25.42 29.2999L26.168 28.8439L28.744 31.4279C29.1 31.7839 29.58 31.9879 30.092 31.9879C30.604 31.9879 31.084 31.7839 31.44 31.4359C32.196 30.6799 32.196 29.4839 31.44 28.7319L31.436 28.7399ZM27.56 21.4759C27.292 22.5559 26.836 23.5319 26.212 24.3599C25.328 25.5959 24.124 26.5519 22.728 27.1399C20.008 28.2679 16.896 27.8799 14.536 26.1159C13.668 25.4919 12.912 24.6759 12.36 23.7679C11.776 22.8319 11.4 21.8359 11.232 20.6959C11.052 19.6239 11.12 18.5199 11.412 17.4719C11.672 16.4239 12.152 15.4319 12.808 14.5719C13.44 13.7199 14.212 13.0039 15.172 12.3879L15.196 12.3719C16.164 11.7959 17.236 11.4039 18.356 11.2359C18.78 11.1719 19.192 11.1399 19.616 11.1399C21.38 11.1399 23.084 11.7079 24.492 12.7639C26.224 14.0639 27.368 15.9959 27.724 18.2159C27.88 19.2879 27.82 20.3839 27.56 21.4839V21.4759Z" fill="#FF1744"/>
         </svg>';
          break;
       
        case 'Ajio':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M23.0483 23.2559L19.7563 16.9279L17.0923 23.2559H23.0523H23.0483ZM9.52832 29.7319V30.1639L13.5643 30.2879L15.1443 26.7959L25.0123 26.8319L26.5163 30.3959L30.4763 30.1239L19.9163 9.59595L9.52832 29.7279V29.7319Z" fill="white"/>
          </svg>';
          break;
       
        case 'Purple':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <rect x="8" y="8" width="23.904" height="23.904" fill="url(#pattern0)"/>
          <defs>
          <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
          <use xlink:href="#image0_2107_18590" transform="scale(0.0119048)"/>
          </pattern>
          <image id="image0_2107_18590" width="84" height="84" xlink:href="data:image/png;base64,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"/>
          </defs>
          </svg>';
          break;
       
        case 'bigbasket':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M19.812 22.8679C19.812 22.2319 19.724 21.5999 19.544 20.9919C19.372 20.4679 19.072 19.9959 18.672 19.6159C18.256 19.2759 17.736 19.0999 17.196 19.1119C16.632 19.0959 16.084 19.2839 15.656 19.6479C15.204 19.9999 14.868 20.4799 14.684 21.0239C14.468 21.6159 14.356 22.2399 14.348 22.8679C14.356 23.4839 14.468 24.0999 14.684 24.6759C14.876 25.2239 15.212 25.7079 15.656 26.0839C16.096 26.4239 16.64 26.5999 17.196 26.5879C17.996 26.6359 18.752 26.2199 19.14 25.5159C19.608 24.7159 19.84 23.7959 19.808 22.8679H19.812ZM19.812 22.8679C19.812 22.2319 19.724 21.5999 19.544 20.9919C19.372 20.4679 19.072 19.9959 18.672 19.6159C18.256 19.2759 17.736 19.0999 17.196 19.1119C16.632 19.0959 16.084 19.2839 15.656 19.6479C15.204 19.9999 14.868 20.4799 14.684 21.0239C14.468 21.6159 14.356 22.2399 14.348 22.8679C14.356 23.4839 14.468 24.0999 14.684 24.6759C14.876 25.2239 15.212 25.7079 15.656 26.0839C16.096 26.4239 16.64 26.5999 17.196 26.5879C17.996 26.6359 18.752 26.2199 19.14 25.5159C19.608 24.7159 19.84 23.7959 19.808 22.8679H19.812ZM19.812 22.8679C19.812 22.2319 19.724 21.5999 19.544 20.9919C19.372 20.4679 19.072 19.9959 18.672 19.6159C18.256 19.2759 17.736 19.0999 17.196 19.1119C16.632 19.0959 16.084 19.2839 15.656 19.6479C15.204 19.9999 14.868 20.4799 14.684 21.0239C14.468 21.6159 14.356 22.2399 14.348 22.8679C14.356 23.4839 14.468 24.0999 14.684 24.6759C14.876 25.2239 15.212 25.7079 15.656 26.0839C16.096 26.4239 16.64 26.5999 17.196 26.5879C17.996 26.6359 18.752 26.2199 19.14 25.5159C19.608 24.7159 19.84 23.7959 19.808 22.8679H19.812ZM19.812 22.8679C19.812 22.2319 19.724 21.5999 19.544 20.9919C19.372 20.4679 19.072 19.9959 18.672 19.6159C18.256 19.2759 17.736 19.0999 17.196 19.1119C16.632 19.0959 16.084 19.2839 15.656 19.6479C15.204 19.9999 14.868 20.4799 14.684 21.0239C14.468 21.6159 14.356 22.2399 14.348 22.8679C14.356 23.4839 14.468 24.0999 14.684 24.6759C14.876 25.2239 15.212 25.7079 15.656 26.0839C16.096 26.4239 16.64 26.5999 17.196 26.5879C17.996 26.6359 18.752 26.2199 19.14 25.5159C19.608 24.7159 19.84 23.7959 19.808 22.8679H19.812ZM19.812 22.8679C19.812 22.2319 19.724 21.5999 19.544 20.9919C19.372 20.4679 19.072 19.9959 18.672 19.6159C18.256 19.2759 17.736 19.0999 17.196 19.1119C16.632 19.0959 16.084 19.2839 15.656 19.6479C15.204 19.9999 14.868 20.4799 14.684 21.0239C14.468 21.6159 14.356 22.2399 14.348 22.8679C14.356 23.4839 14.468 24.0999 14.684 24.6759C14.876 25.2239 15.212 25.7079 15.656 26.0839C16.096 26.4239 16.64 26.5999 17.196 26.5879C17.996 26.6359 18.752 26.2199 19.14 25.5159C19.608 24.7159 19.84 23.7959 19.808 22.8679H19.812ZM19.812 22.8679C19.812 22.2319 19.724 21.5999 19.544 20.9919C19.372 20.4679 19.072 19.9959 18.672 19.6159C18.256 19.2759 17.736 19.0999 17.196 19.1119C16.632 19.0959 16.084 19.2839 15.656 19.6479C15.204 19.9999 14.868 20.4799 14.684 21.0239C14.468 21.6159 14.356 22.2399 14.348 22.8679C14.356 23.4839 14.468 24.0999 14.684 24.6759C14.876 25.2239 15.212 25.7079 15.656 26.0839C16.096 26.4239 16.64 26.5999 17.196 26.5879C17.996 26.6359 18.752 26.2199 19.14 25.5159C19.608 24.7159 19.84 23.7959 19.808 22.8679H19.812ZM19.812 22.8679C19.812 22.2319 19.724 21.5999 19.544 20.9919C19.372 20.4679 19.072 19.9959 18.672 19.6159C18.256 19.2759 17.736 19.0999 17.196 19.1119C16.632 19.0959 16.084 19.2839 15.656 19.6479C15.204 19.9999 14.868 20.4799 14.684 21.0239C14.468 21.6159 14.356 22.2399 14.348 22.8679C14.356 23.4839 14.468 24.0999 14.684 24.6759C14.876 25.2239 15.212 25.7079 15.656 26.0839C16.096 26.4239 16.64 26.5999 17.196 26.5879C17.996 26.6359 18.752 26.2199 19.14 25.5159C19.608 24.7159 19.84 23.7959 19.808 22.8679H19.812ZM28.384 8.0359H11.588C9.62 8.0359 8.016 9.6199 8 11.5879V28.3799C8 30.3599 9.608 31.9639 11.588 31.9639H28.38C30.364 31.9639 31.98 30.3639 32 28.3799V11.5879C31.964 9.6119 30.356 8.0319 28.38 8.0359H28.384ZM18.644 11.0359H20.556V16.7799C19.992 16.3999 19.324 16.1959 18.644 16.1959V11.0359ZM18.204 28.9639C17.428 28.9999 16.652 28.8759 15.928 28.5959C15.484 28.4119 15.088 28.1359 14.756 27.7919C14.632 27.6199 14.52 27.4439 14.42 27.2559L14.388 27.1199V27.4239C14.288 29.2679 11.408 28.9319 11.408 28.9319V11.0359H14.556V18.4799H14.592C14.972 17.9079 15.504 17.4559 16.132 17.1719C16.784 16.8719 17.496 16.7239 18.212 16.7359C19.168 16.7159 20.104 17.0239 20.864 17.6079C21.62 18.1999 22.2 18.9879 22.54 19.8839C22.724 20.3599 22.868 20.8519 22.96 21.3479C23.056 21.8479 23.108 22.3559 23.108 22.8679C23.1 23.8879 22.908 24.8999 22.54 25.8519C22.192 26.7439 21.612 27.5279 20.864 28.1279C20.104 28.6999 19.168 28.9999 18.212 28.9639H18.204ZM28.032 25.8519C27.684 26.7439 27.104 27.5279 26.356 28.1279C25.596 28.6999 24.66 28.9999 23.708 28.9639C22.932 28.9999 22.156 28.8759 21.428 28.5959C21.304 28.5399 21.184 28.4759 21.064 28.4119C21.508 28.0479 21.9 27.6319 22.232 27.1679C22.584 27.2959 22.96 27.3559 23.332 27.3519C25.712 27.3519 26.48 24.8519 26.48 22.8679C26.48 20.8839 25.76 18.3439 23.332 18.3439C22.984 18.3439 22.64 18.3959 22.312 18.5079C22.02 18.0799 21.68 17.6879 21.292 17.3439C21.4 17.2799 21.512 17.2199 21.624 17.1679C23.996 16.0879 26.796 17.1359 27.876 19.5079C27.932 19.6319 27.984 19.7559 28.028 19.8839C28.4 20.8359 28.592 21.8479 28.6 22.8719C28.592 23.8919 28.4 24.9039 28.028 25.8559L28.032 25.8519ZM19.544 20.9879C19.372 20.4639 19.072 19.9919 18.672 19.6119C18.256 19.2719 17.736 19.0959 17.196 19.1079C16.632 19.0919 16.084 19.2799 15.656 19.6439C15.204 19.9959 14.868 20.4759 14.684 21.0199C14.468 21.6119 14.356 22.2359 14.348 22.8639C14.356 23.4799 14.468 24.0959 14.684 24.6719C14.876 25.2199 15.212 25.7039 15.656 26.0799C16.096 26.4199 16.64 26.5959 17.196 26.5839C17.996 26.6319 18.752 26.2159 19.14 25.5119C19.608 24.7119 19.84 23.7919 19.808 22.8639C19.808 22.2279 19.72 21.5959 19.54 20.9879H19.544ZM19.812 22.8639C19.812 22.2279 19.724 21.5959 19.544 20.9879C19.372 20.4639 19.072 19.9919 18.672 19.6119C18.256 19.2719 17.736 19.0959 17.196 19.1079C16.632 19.0919 16.084 19.2799 15.656 19.6439C15.204 19.9959 14.868 20.4759 14.684 21.0199C14.468 21.6119 14.356 22.2359 14.348 22.8639C14.356 23.4799 14.468 24.0959 14.684 24.6719C14.876 25.2199 15.212 25.7039 15.656 26.0799C16.096 26.4199 16.64 26.5959 17.196 26.5839C17.996 26.6319 18.752 26.2159 19.14 25.5119C19.608 24.7119 19.84 23.7919 19.808 22.8639H19.812ZM19.812 22.8639C19.812 22.2279 19.724 21.5959 19.544 20.9879C19.372 20.4639 19.072 19.9919 18.672 19.6119C18.256 19.2719 17.736 19.0959 17.196 19.1079C16.632 19.0919 16.084 19.2799 15.656 19.6439C15.204 19.9959 14.868 20.4759 14.684 21.0199C14.468 21.6119 14.356 22.2359 14.348 22.8639C14.356 23.4799 14.468 24.0959 14.684 24.6719C14.876 25.2199 15.212 25.7039 15.656 26.0799C16.096 26.4199 16.64 26.5959 17.196 26.5839C17.996 26.6319 18.752 26.2159 19.14 25.5119C19.608 24.7119 19.84 23.7919 19.808 22.8639H19.812ZM19.812 22.8639C19.812 22.2279 19.724 21.5959 19.544 20.9879C19.372 20.4639 19.072 19.9919 18.672 19.6119C18.256 19.2719 17.736 19.0959 17.196 19.1079C16.632 19.0919 16.084 19.2799 15.656 19.6439C15.204 19.9959 14.868 20.4759 14.684 21.0199C14.468 21.6119 14.356 22.2359 14.348 22.8639C14.356 23.4799 14.468 24.0959 14.684 24.6719C14.876 25.2199 15.212 25.7039 15.656 26.0799C16.096 26.4199 16.64 26.5959 17.196 26.5839C17.996 26.6319 18.752 26.2159 19.14 25.5119C19.608 24.7119 19.84 23.7919 19.808 22.8639H19.812ZM19.812 22.8639C19.812 22.2279 19.724 21.5959 19.544 20.9879C19.372 20.4639 19.072 19.9919 18.672 19.6119C18.256 19.2719 17.736 19.0959 17.196 19.1079C16.632 19.0919 16.084 19.2799 15.656 19.6439C15.204 19.9959 14.868 20.4759 14.684 21.0199C14.468 21.6119 14.356 22.2359 14.348 22.8639C14.356 23.4799 14.468 24.0959 14.684 24.6719C14.876 25.2199 15.212 25.7039 15.656 26.0799C16.096 26.4199 16.64 26.5959 17.196 26.5839C17.996 26.6319 18.752 26.2159 19.14 25.5119C19.608 24.7119 19.84 23.7919 19.808 22.8639H19.812ZM19.812 22.8639C19.812 22.2279 19.724 21.5959 19.544 20.9879C19.372 20.4639 19.072 19.9919 18.672 19.6119C18.256 19.2719 17.736 19.0959 17.196 19.1079C16.632 19.0919 16.084 19.2799 15.656 19.6439C15.204 19.9959 14.868 20.4759 14.684 21.0199C14.468 21.6119 14.356 22.2359 14.348 22.8639C14.356 23.4799 14.468 24.0959 14.684 24.6719C14.876 25.2199 15.212 25.7039 15.656 26.0799C16.096 26.4199 16.64 26.5959 17.196 26.5839C17.996 26.6319 18.752 26.2159 19.14 25.5119C19.608 24.7119 19.84 23.7919 19.808 22.8639H19.812Z" fill="#A5CD3A"/>
          <path d="M28.5996 22.8721C28.5916 23.8921 28.3996 24.9041 28.0276 25.8561C27.6796 26.7481 27.0996 27.5321 26.3516 28.1321C25.5916 28.7041 24.6556 29.0041 23.7036 28.9681C22.9276 29.0041 22.1516 28.8801 21.4236 28.6001C21.2996 28.5441 21.1796 28.4801 21.0596 28.4161C21.5036 28.0521 21.8956 27.6361 22.2276 27.1721C22.5796 27.3001 22.9556 27.3601 23.3276 27.3561C25.7076 27.3561 26.4756 24.8561 26.4756 22.8721C26.4756 20.8881 25.7556 18.3481 23.3276 18.3481C22.9796 18.3481 22.6356 18.4001 22.3076 18.5121C22.0156 18.0841 21.6756 17.6921 21.2876 17.3481C21.3956 17.2841 21.5076 17.2241 21.6196 17.1721C23.9916 16.0921 26.7916 17.1401 27.8716 19.5121C27.9276 19.6361 27.9796 19.7601 28.0236 19.8881C28.3956 20.8401 28.5876 21.8521 28.5956 22.8761L28.5996 22.8721Z" fill="black"/>
          <path d="M20.5516 11.0359V16.7799C19.9876 16.3999 19.3196 16.1959 18.6396 16.1959V11.0359H20.5516Z" fill="black"/>
          <path d="M22.9524 21.3479C22.8604 20.8479 22.7164 20.3559 22.5324 19.8839C22.1924 18.9839 21.6124 18.1959 20.8564 17.6079C20.0964 17.0239 19.1644 16.7159 18.2044 16.7359C17.4884 16.7239 16.7764 16.8719 16.1244 17.1719C15.4964 17.4559 14.9644 17.9079 14.5844 18.4799H14.5484V11.0359H11.4004V28.9319C11.4004 28.9319 14.2804 29.2679 14.3804 27.4239V27.1199L14.4124 27.2559C14.5124 27.4399 14.6244 27.6199 14.7484 27.7919C15.0804 28.1399 15.4804 28.4119 15.9204 28.5959C16.6484 28.8759 17.4204 28.9999 18.1964 28.9639C19.1484 28.9959 20.0844 28.6999 20.8484 28.1279C21.5964 27.5279 22.1764 26.7439 22.5244 25.8519C22.8924 24.8999 23.0884 23.8879 23.0924 22.8679C23.0924 22.3559 23.0404 21.8479 22.9444 21.3479H22.9524ZM19.1444 25.5159C18.7564 26.2199 18.0004 26.6359 17.2004 26.5879C16.6444 26.5999 16.1004 26.4239 15.6604 26.0839C15.2164 25.7119 14.8804 25.2279 14.6884 24.6759C14.4724 24.0959 14.3604 23.4839 14.3524 22.8679C14.3604 22.2359 14.4724 21.6119 14.6884 21.0239C14.8724 20.4799 15.2084 20.0039 15.6604 19.6479C16.0884 19.2839 16.6364 19.0919 17.2004 19.1119C17.7364 19.0999 18.2564 19.2759 18.6764 19.6159C19.0764 19.9959 19.3724 20.4679 19.5484 20.9919C19.7284 21.5999 19.8204 22.2319 19.8164 22.8679C19.8484 23.7959 19.6164 24.7159 19.1484 25.5159H19.1444Z" fill="#EC1D23"/>
          </svg>';
          break;
       
        case 'Blinkit':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M26.924 8H13.076C10.2726 8 8 10.2726 8 13.076V26.924C8 29.7274 10.2726 32 13.076 32H26.924C29.7274 32 32 29.7274 32 26.924V13.076C32 10.2726 29.7274 8 26.924 8Z" fill="#F8CB46"/>
          <path d="M12.5723 18.6359C12.9083 18.6359 13.2083 18.7199 13.4723 18.8879C13.7403 19.0519 13.9483 19.2879 14.0963 19.5919C14.2443 19.8839 14.3163 20.2279 14.3163 20.6239C14.3163 21.0199 14.2443 21.3519 14.0963 21.6519C13.9483 21.9519 13.7443 22.1919 13.4763 22.3599C13.2083 22.5319 12.9043 22.6199 12.5683 22.6199C12.3243 22.6199 12.0923 22.5679 11.8763 22.4679C11.6603 22.3679 11.4763 22.2239 11.3243 22.0439V22.5279H10.0723V17.3799H11.3243V19.2079C11.4763 19.0239 11.6643 18.8839 11.8763 18.7879C12.0923 18.6879 12.3203 18.6359 12.5683 18.6359H12.5723ZM12.1963 21.5799C12.3723 21.5799 12.5323 21.5399 12.6723 21.4559C12.8123 21.3759 12.9203 21.2599 13.0003 21.1159C13.0803 20.9719 13.1203 20.8079 13.1203 20.6239C13.1203 20.4399 13.0803 20.2799 13.0003 20.1359C12.9203 19.9879 12.8123 19.8759 12.6723 19.7959C12.5323 19.7159 12.3763 19.6719 12.1963 19.6719C12.0283 19.6719 11.8803 19.7119 11.7483 19.7959C11.6163 19.8759 11.5123 19.9879 11.4403 20.1319C11.3643 20.2799 11.3283 20.4439 11.3283 20.6279C11.3283 20.8119 11.3643 20.9759 11.4403 21.1239C11.5163 21.2679 11.6163 21.3799 11.7483 21.4599C11.8803 21.5399 12.0283 21.5839 12.1963 21.5839V21.5799Z" fill="#1C1C1C"/>
          <path d="M14.4883 22.5279V17.3799H15.7403V22.5279H14.4883Z" fill="#1C1C1C"/>
          <path d="M16.0957 22.528V18.72H17.3397V22.528H16.0957Z" fill="#1C1C1C"/>
          <path d="M20.0436 18.6359C20.3116 18.6359 20.5476 18.6999 20.7636 18.8239C20.9756 18.9479 21.1436 19.1199 21.2676 19.3399C21.3836 19.5639 21.4436 19.8199 21.4436 20.1039V22.5239H20.2516V20.3839C20.2516 20.2439 20.2236 20.1199 20.1676 20.0119C20.1156 19.8999 20.0396 19.8159 19.9396 19.7559C19.8436 19.6959 19.7316 19.6679 19.6036 19.6679C19.4796 19.6679 19.3676 19.6959 19.2636 19.7559C19.1596 19.8119 19.0796 19.8919 19.0236 19.9919C18.9636 20.0879 18.9356 20.1999 18.9356 20.3279L18.9276 22.5199H17.6836V18.7119H18.9276V19.1479C19.0436 18.9839 19.2036 18.8559 19.3996 18.7679C19.5956 18.6759 19.8116 18.6279 20.0476 18.6279L20.0436 18.6359Z" fill="#1C1C1C"/>
          <path d="M24.1923 20.3879L25.6043 22.5279H24.1923L23.3683 21.1799L22.9883 21.6239V22.5279H21.7363V17.3799H22.9883V20.2239L24.1923 18.7199H25.6043L24.1963 20.3879H24.1923Z" fill="#1C1C1C"/>
          <path d="M16.0957 17.3799H17.3437V18.3559H16.0957V17.3799Z" fill="#1C1C1C"/>
          <path d="M25.792 22.528V18.72H27.04V22.528H25.792Z" fill="#0C831F"/>
          <path d="M29.6802 21.4439L29.9282 22.2439C29.8162 22.3519 29.6722 22.4399 29.5002 22.5079C29.3282 22.5759 29.1642 22.6079 29.0002 22.6079C28.7642 22.6079 28.5562 22.5559 28.3722 22.4519C28.1882 22.3479 28.0442 22.1999 27.9402 22.0119C27.8362 21.8279 27.7842 21.6199 27.7842 21.3839V19.7039H27.2842V18.7199H27.7842V17.3799H28.9762V18.7199H29.7642V19.7039H28.9762V21.1519C28.9762 21.2759 29.0082 21.3719 29.0722 21.4519C29.1362 21.5279 29.2202 21.5679 29.3202 21.5679C29.3922 21.5679 29.4602 21.5559 29.5202 21.5359C29.5842 21.5159 29.6322 21.4839 29.6762 21.4439H29.6802Z" fill="#0C831F"/>
          <path d="M25.792 17.3799H27.04V18.3559H25.792V17.3799Z" fill="#0C831F"/>
          </svg>';
          break;
       
        case 'Facebook':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M20 8C13.372 8 8 13.372 8 20C8 26.628 13.372 32 20 32C26.628 32 32 26.628 32 20C32 13.372 26.628 8 20 8Z" fill="url(#paint0_linear_2107_18595)"/>
          <path d="M21.6242 23.18H24.7282L25.2162 20.024H21.6242V18.3C21.6242 16.988 22.0522 15.828 23.2802 15.828H25.2482V13.076C24.9002 13.028 24.1682 12.928 22.7882 12.928C19.9002 12.928 18.2082 14.452 18.2082 17.928V20.028H15.2402V23.184H18.2082V31.856C18.7962 31.944 19.3922 32.004 20.0042 32.004C20.5562 32.004 21.0962 31.952 21.6282 31.88V23.184L21.6242 23.18Z" fill="white"/>
          <defs>
          <linearGradient id="paint0_linear_2107_18595" x1="11.6" y1="11.6" x2="29.96" y2="29.96" gradientUnits="userSpaceOnUse">
          <stop stop-color="#2AA4F4"/>
          <stop offset="1" stop-color="#007AD9"/>
          </linearGradient>
          </defs>
          </svg>';
          break;
       
        case 'First Cry':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M29.472 8H10.528C9.13182 8 8 9.13182 8 10.528V29.472C8 30.8682 9.13182 32 10.528 32H29.472C30.8682 32 32 30.8682 32 29.472V10.528C32 9.13182 30.8682 8 29.472 8Z" fill="#C1539C"/>
          <path d="M21.596 17.3601C22.652 16.6001 23.56 16.2481 24.936 16.4121C25.88 16.6801 26.848 16.8801 27.276 17.8521C27.34 18.5241 26.836 18.7721 25.988 18.8681C25.1 18.8961 24.804 18.3561 24.308 17.9041C23.264 17.4641 22.676 17.6761 21.928 18.5361C21 19.5441 21.904 23.2521 23.292 24.2641C24.108 24.9161 24.968 24.9761 25.8 24.7681C26.16 24.6761 26.46 24.4081 26.548 24.0161C26.648 23.4041 27.204 23.3241 27.528 23.5361C28.188 24.0881 28.216 25.1161 27.492 25.5841C26.904 25.9681 26.152 26.0441 25.484 26.0721C23.652 26.2161 22.584 25.3521 21.62 24.3441C20.452 22.4241 19.656 19.0761 21.596 17.3601Z" fill="white"/>
          <path d="M15.844 12.3801C16.12 11.7281 16.608 11.0561 17.852 10.4881C18.424 10.2601 19.072 10.2401 19.712 10.2921C20.12 10.3561 20.5 10.4401 20.888 10.7361C21.164 10.9521 21.504 11.2841 21.608 11.8521C21.612 11.9241 21.424 11.8961 21.36 11.8881C21.068 11.8521 20.916 11.9881 20.672 12.1321C20.604 12.1721 20.488 12.2201 20.4 12.1521C20.184 11.9161 20.012 11.7441 19.796 11.5041C19.256 11.0441 18.464 11.2401 17.892 11.6561C17.232 12.2161 16.944 12.7481 16.74 13.2721C16.536 13.8401 16.452 14.4081 16.34 14.9721C16.24 15.8881 16.232 16.7681 16.236 17.6601C16.24 18.1121 16.26 18.5681 16.356 19.0001C16.504 19.3161 16.712 19.5841 17.124 19.6881C17.56 19.7401 17.996 19.7921 18.432 19.8441C18.668 19.8801 18.852 19.9881 18.964 20.2201C19.012 20.5081 18.948 20.6921 18.796 20.7241C18.308 20.7161 17.808 20.7201 17.316 20.7481C16.688 20.8921 16.78 21.3961 16.732 21.8041C17.096 24.2401 17.416 26.6521 17.676 29.1121C17.656 29.5841 17.508 29.6601 17.284 29.7041C17.208 29.7801 16.948 29.7361 16.736 29.4401C16.204 26.4841 15.784 23.4921 15.184 20.5281C15.136 20.1881 14.968 20.0121 14.684 19.9881C14.016 19.9561 13.348 19.9281 12.68 19.8961C12.38 19.8481 12.152 19.7481 12.056 19.5521C11.932 19.1521 11.96 18.7241 12.272 18.3841C12.428 18.2281 12.548 18.0841 12.98 18.1281C13.268 18.2041 13.484 18.3601 13.752 18.6921C13.988 18.8881 14.432 18.9121 14.84 18.8161C15.02 18.7681 15.16 18.6081 15.096 18.2241C14.976 17.2881 14.972 16.4801 15.024 15.5881C15.132 14.3921 15.352 13.4601 15.856 12.3761" fill="white"/>
          </svg>';
          break;
       
        case 'Instagram':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M20.0039 8.00391C14.9959 8.00391 13.5279 8.00791 13.2439 8.03191C12.2159 8.11591 11.5759 8.27991 10.8799 8.62791C10.3439 8.89591 9.91991 9.20391 9.49991 9.63591C8.73991 10.4279 8.27591 11.3999 8.11191 12.5559C8.03191 13.1159 8.00791 13.2319 8.00391 16.0959C8.00391 17.0519 8.00391 18.3079 8.00391 19.9959C8.00391 24.9999 8.00791 26.4639 8.03191 26.7479C8.11591 27.7479 8.27191 28.3759 8.60391 29.0679C9.23991 30.3839 10.4519 31.3759 11.8799 31.7439C12.3759 31.8719 12.9199 31.9399 13.6239 31.9759C13.9199 31.9879 16.9519 31.9999 19.9799 31.9999C23.0079 31.9999 26.0399 31.9999 26.3319 31.9799C27.1439 31.9399 27.6159 31.8799 28.1359 31.7439C29.5719 31.3719 30.7639 30.3999 31.4119 29.0639C31.7359 28.3919 31.9039 27.7399 31.9759 26.7919C31.9919 26.5839 31.9999 23.2879 31.9999 19.9959C31.9999 16.7039 31.9919 13.4119 31.9759 13.2079C31.8999 12.2439 31.7359 11.5959 31.3999 10.9119C31.1239 10.3519 30.8159 9.93191 30.3719 9.50391C29.5799 8.74391 28.6079 8.28391 27.4519 8.11591C26.8919 8.03591 26.7799 8.01191 23.9119 8.00391H20.0079H20.0039Z" fill="url(#paint0_radial_2107_18598)"/>
          <path d="M20.0039 8.00391C14.9959 8.00391 13.5279 8.00791 13.2439 8.03191C12.2159 8.11591 11.5759 8.27991 10.8799 8.62791C10.3439 8.89591 9.91991 9.20391 9.49991 9.63591C8.73991 10.4279 8.27591 11.3999 8.11191 12.5559C8.03191 13.1159 8.00791 13.2319 8.00391 16.0959C8.00391 17.0519 8.00391 18.3079 8.00391 19.9959C8.00391 24.9999 8.00791 26.4639 8.03191 26.7479C8.11591 27.7479 8.27191 28.3759 8.60391 29.0679C9.23991 30.3839 10.4519 31.3759 11.8799 31.7439C12.3759 31.8719 12.9199 31.9399 13.6239 31.9759C13.9199 31.9879 16.9519 31.9999 19.9799 31.9999C23.0079 31.9999 26.0399 31.9999 26.3319 31.9799C27.1439 31.9399 27.6159 31.8799 28.1359 31.7439C29.5719 31.3719 30.7639 30.3999 31.4119 29.0639C31.7359 28.3919 31.9039 27.7399 31.9759 26.7919C31.9919 26.5839 31.9999 23.2879 31.9999 19.9959C31.9999 16.7039 31.9919 13.4119 31.9759 13.2079C31.8999 12.2439 31.7359 11.5959 31.3999 10.9119C31.1239 10.3519 30.8159 9.93191 30.3719 9.50391C29.5799 8.74391 28.6079 8.28391 27.4519 8.11591C26.8919 8.03591 26.7799 8.01191 23.9119 8.00391H20.0079H20.0039Z" fill="url(#paint1_radial_2107_18598)"/>
          <path d="M19.9996 11.1399C17.5916 11.1399 17.2916 11.1519 16.3476 11.1919C15.4036 11.2359 14.7596 11.3839 14.1956 11.6039C13.6116 11.8319 13.1196 12.1319 12.6276 12.6239C12.1356 13.1159 11.8316 13.6119 11.6036 14.1919C11.3836 14.7559 11.2356 15.3999 11.1916 16.3439C11.1476 17.2879 11.1396 17.5919 11.1396 19.9959C11.1396 22.3999 11.1516 22.7039 11.1916 23.6479C11.2356 24.5919 11.3836 25.2359 11.6036 25.7999C11.8316 26.3839 12.1316 26.8759 12.6236 27.3679C13.1156 27.8599 13.6116 28.1639 14.1916 28.3919C14.7556 28.6119 15.3996 28.7599 16.3436 28.8039C17.2876 28.8479 17.5916 28.8559 19.9956 28.8559C22.3996 28.8559 22.7036 28.8439 23.6476 28.8039C24.5916 28.7599 25.2356 28.6119 25.7996 28.3919C26.3836 28.1639 26.8756 27.8639 27.3676 27.3679C27.8596 26.8759 28.1636 26.3799 28.3916 25.7999C28.6076 25.2359 28.7596 24.5919 28.8036 23.6479C28.8476 22.7039 28.8556 22.3999 28.8556 19.9959C28.8556 17.5919 28.8436 17.2879 28.8036 16.3439C28.7596 15.3999 28.6116 14.7559 28.3916 14.1919C28.1636 13.6079 27.8636 13.1159 27.3676 12.6239C26.8756 12.1319 26.3836 11.8279 25.7996 11.6039C25.2356 11.3839 24.5916 11.2359 23.6476 11.1919C22.7036 11.1479 22.4036 11.1399 19.9956 11.1399H19.9996ZM19.2036 12.7359C19.4396 12.7359 19.7036 12.7359 19.9996 12.7359C22.3636 12.7359 22.6436 12.7439 23.5796 12.7879C24.4436 12.8279 24.9116 12.9719 25.2236 13.0919C25.6356 13.2519 25.9316 13.4439 26.2436 13.7559C26.5556 14.0679 26.7476 14.3599 26.9076 14.7759C27.0276 15.0879 27.1716 15.5559 27.2116 16.4199C27.2556 17.3519 27.2636 17.6359 27.2636 19.9999C27.2636 22.3639 27.2556 22.6439 27.2116 23.5799C27.1716 24.4439 27.0276 24.9119 26.9076 25.2239C26.7476 25.6359 26.5556 25.9319 26.2436 26.2399C25.9316 26.5519 25.6396 26.7439 25.2236 26.9039C24.9116 27.0239 24.4436 27.1679 23.5796 27.2079C22.6476 27.2519 22.3636 27.2599 19.9996 27.2599C17.6356 27.2599 17.3516 27.2519 16.4196 27.2079C15.5556 27.1679 15.0876 27.0239 14.7756 26.9039C14.3636 26.7439 14.0676 26.5519 13.7556 26.2399C13.4436 25.9279 13.2516 25.6359 13.0916 25.2199C12.9716 24.9079 12.8276 24.4399 12.7876 23.5759C12.7436 22.6439 12.7356 22.3599 12.7356 19.9959C12.7356 17.6319 12.7436 17.3519 12.7876 16.4159C12.8276 15.5519 12.9716 15.0839 13.0916 14.7719C13.2516 14.3599 13.4436 14.0639 13.7556 13.7519C14.0676 13.4399 14.3596 13.2479 14.7756 13.0879C15.0876 12.9679 15.5556 12.8239 16.4196 12.7839C17.2356 12.7479 17.5556 12.7359 19.2036 12.7359ZM24.7276 14.2079C24.1396 14.2079 23.6636 14.6839 23.6636 15.2719C23.6636 15.8599 24.1396 16.3359 24.7276 16.3359C25.3156 16.3359 25.7916 15.8599 25.7916 15.2719C25.7916 14.6839 25.3156 14.2079 24.7276 14.2079ZM19.9996 15.4519C17.4876 15.4519 15.4516 17.4879 15.4516 19.9999C15.4516 22.5119 17.4876 24.5479 19.9996 24.5479C22.5116 24.5479 24.5476 22.5119 24.5476 19.9999C24.5476 17.4879 22.5116 15.4519 19.9996 15.4519ZM19.9996 17.0479C21.6316 17.0479 22.9516 18.3719 22.9516 19.9999C22.9516 21.6279 21.6276 22.9519 19.9996 22.9519C18.3716 22.9519 17.0476 21.6279 17.0476 19.9999C17.0476 18.3719 18.3716 17.0479 19.9996 17.0479Z" fill="white"/>
          <defs>
          <radialGradient id="paint0_radial_2107_18598" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(14.0674 33.9361) rotate(-90) scale(23.7521 22.0726)">
          <stop stop-color="#FFDD55"/>
          <stop offset="0.1" stop-color="#FFDD55"/>
          <stop offset="0.5" stop-color="#FF543E"/>
          <stop offset="1" stop-color="#C837AB"/>
          </radialGradient>
          <radialGradient id="paint1_radial_2107_18598" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(4.01274 9.83384) rotate(78.68) scale(10.6764 43.7854)">
          <stop stop-color="#3771C8"/>
          <stop offset="0.13" stop-color="#3771C8"/>
          <stop offset="1" stop-color="#6600FF" stop-opacity="0"/>
          </radialGradient>
          </defs>
          </svg>';
          break;
       
        case 'Limeroad':
        case 'Lime road':
        case 'Lime-road':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M29.472 8H10.528C9.13182 8 8 9.13182 8 10.528V29.472C8 30.8682 9.13182 32 10.528 32H29.472C30.8682 32 32 30.8682 32 29.472V10.528C32 9.13182 30.8682 8 29.472 8Z" fill="url(#paint0_linear_2107_18599)"/>
          <rect x="9.87598" y="14.4441" width="20.216" height="11.096" fill="url(#pattern0)"/>
          <defs>
          <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
          <use xlink:href="#image0_2107_18599" transform="scale(0.0075188 0.0140845)"/>
          </pattern>
          <linearGradient id="paint0_linear_2107_18599" x1="20" y1="32" x2="20" y2="8" gradientUnits="userSpaceOnUse">
          <stop stop-color="#6FCA35"/>
          <stop offset="1" stop-color="#AFE058"/>
          </linearGradient>
          <image id="image0_2107_18599" width="133" height="71" xlink:href="data:image/png;base64,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"/>
          </defs>
          </svg>';
          break;
       
        case 'Meesho':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M32 8H8V32H32V8Z" fill="#5A0949"/>
          <path d="M23.8159 13.4759C25.2679 13.4959 26.4799 13.9919 27.4919 14.9839C28.5039 15.9759 28.9999 17.1519 28.9999 18.5679L28.9639 25.1479C28.9639 25.9399 28.3039 26.5639 27.4759 26.5639C26.6479 26.5639 26.0039 25.9199 26.0239 25.1319L26.0599 18.5519C26.0799 17.9639 25.8399 17.3919 25.3999 16.9879C24.9759 16.5639 24.4439 16.3439 23.7999 16.3439C23.1759 16.3239 22.5679 16.5839 22.1439 17.0239C21.7199 17.4479 21.5199 18.0159 21.5199 18.6039L21.4839 25.0919C21.4839 25.8839 20.8039 26.5239 19.9759 26.5239C19.1479 26.5239 18.4879 25.8639 18.4879 25.0719L18.5239 18.5479C18.5439 17.9799 18.3199 17.4079 17.9159 17.0039C17.4759 16.5439 16.9239 16.3239 16.2599 16.3039C15.6519 16.2839 15.0839 16.5079 14.6599 16.9279C14.2199 17.3519 13.9999 17.8639 13.9999 18.4719L13.9639 25.0359C13.9639 25.8279 13.3039 26.4679 12.4759 26.4519C11.6679 26.4519 11.0039 25.8079 11.0039 25.0199L11.0399 18.4759C11.0399 17.2439 11.4999 16.0679 12.3279 15.1679C13.4119 14.0079 14.7359 13.4199 16.2799 13.4399C17.7519 13.4599 19.0199 13.9719 20.0279 15.0039C21.0959 13.9759 22.3439 13.4799 23.8159 13.4799V13.4759Z" fill="#FB9D05"/>
          </svg>';
          break;
       
        case 'Namashi':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M32 8H8V32H32V8Z" fill="black"/>
          <path d="M15.4997 16.26L24.9357 28.796L27.4397 28.812L27.4877 11.22H24.5317L24.4997 23.368L15.3397 11.188H12.5597L12.5117 28.764L15.4677 28.78L15.4997 16.26Z" fill="white"/>
          </svg>';
          break;
       
        case 'Netmeds':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M26.5881 13.0879L19.9001 10.8879V17.8319H13.2121L12.9561 25.1159L19.9001 29.2639C23.5401 29.9399 25.7441 30.1119 26.5881 29.9399C27.8601 29.5999 32.2601 26.2999 32.8561 24.3519C33.4521 22.4039 33.2801 19.4399 32.5161 17.9159C32.0081 16.8999 29.9761 15.2919 26.5881 13.0879Z" fill="white"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M32.8556 24.2639C31.8396 27.1439 29.3836 29.1759 26.5876 29.9359V24.2639H32.8556ZM7.36765 15.7119C9.05965 11.3079 14.0556 8.93594 18.7156 10.4599L19.8996 10.8839V17.9119H13.2116V24.3479H19.8996V29.2599L15.2436 27.7359L12.8716 26.8879C8.21565 25.3639 5.75965 20.5359 7.19965 16.0479L7.36765 15.7079V15.7119ZM26.5036 13.0879L27.1796 13.3439C29.6356 14.1079 31.4996 15.8839 32.4316 17.9159H26.5036V13.0879Z" fill="#84BE52"/>
          </svg>';
          break;
       
        case 'Pinterest':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M8 20C8 24.912 10.956 29.136 15.184 30.992C15.152 30.156 15.176 29.148 15.392 28.236C15.624 27.26 16.936 21.696 16.936 21.696C16.936 21.696 16.552 20.928 16.552 19.796C16.552 18.016 17.584 16.688 18.868 16.688C19.96 16.688 20.488 17.508 20.488 18.488C20.488 19.584 19.788 21.228 19.428 22.748C19.128 24.02 20.068 25.06 21.324 25.06C23.596 25.06 25.128 22.14 25.128 18.68C25.128 16.048 23.356 14.08 20.136 14.08C16.496 14.08 14.228 16.796 14.228 19.828C14.228 20.872 14.536 21.612 15.02 22.18C15.24 22.444 15.272 22.548 15.192 22.848C15.136 23.068 15.004 23.6 14.948 23.812C14.868 24.116 14.62 24.224 14.348 24.112C12.672 23.428 11.892 21.592 11.892 19.528C11.892 16.12 14.768 12.032 20.468 12.032C25.048 12.032 28.064 15.348 28.064 18.908C28.064 23.616 25.448 27.132 21.588 27.132C20.292 27.132 19.072 26.432 18.656 25.636C18.656 25.636 17.96 28.4 17.812 28.936C17.556 29.86 17.06 30.784 16.604 31.508C17.684 31.828 18.824 32 20.004 32C26.632 32 32.004 26.628 32.004 20C32.004 13.372 26.632 8 20.004 8C13.376 8 8.004 13.372 8.004 20H8Z" fill="#CB1F27"/>
          </svg>';
          break;
       
        case 'Snapdeal':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M13.0076 30.4479C13.2636 30.8839 13.5436 31.0439 14.0516 31.0439H23.5716C24.0836 31.0439 24.3596 30.9079 24.6876 30.4919L31.8876 21.3279C32.0516 21.1199 31.8636 20.7799 31.6076 20.7799H20.0676C19.5556 20.7799 19.2796 20.6199 19.0236 20.1839L13.2196 10.2839C13.0796 10.0559 12.7076 10.0999 12.6156 10.3279L8.13563 21.0279C7.92763 21.5079 7.97163 21.8319 8.22763 22.2639L13.0116 30.4439L13.0076 30.4479Z" fill="#E40046"/>
          <path d="M24.9883 18.6241C25.2443 19.0601 25.5243 19.2201 26.0323 19.2201H31.6043C31.8843 19.2201 32.0923 18.8761 31.9523 18.6241L26.6363 9.55205C26.3803 9.11605 26.1003 8.95605 25.5923 8.95605H14.9563C14.6763 8.95605 14.4683 9.30005 14.6083 9.55205L17.3723 14.2721C17.6283 14.7081 17.9043 14.8681 18.4163 14.8681H22.8043L24.9883 18.6241Z" fill="#E40046"/>
          </svg>';
          break;
       
        case 'Swiggy-Instamart':
        case 'Swiggy':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M20.0362 31.9999C20.0362 31.9999 20.0042 31.9759 19.9842 31.9599C19.6962 31.5999 17.9082 29.3599 16.0842 26.4879C15.5362 25.5719 15.1842 24.8599 15.2522 24.6719C15.4322 24.1919 18.6082 23.9279 19.5842 24.3639C19.8802 24.4959 19.8762 24.6719 19.8762 24.7719C19.8762 25.2119 19.8562 26.3919 19.8562 26.3919C19.8562 26.6359 20.0562 26.8319 20.3002 26.8319C20.5442 26.8319 20.7402 26.6319 20.7402 26.3879V23.4479H20.7362C20.7362 23.1919 20.4562 23.1279 20.4042 23.1199C19.8922 23.1199 18.8562 23.1119 17.7442 23.1119C15.2882 23.1119 14.7402 23.2119 14.3202 22.9399C13.4162 22.3479 11.9362 18.3639 11.9042 16.1199C11.8562 12.9559 13.7282 10.2199 16.3682 8.85994C17.4722 8.30394 18.7162 7.99194 20.0322 7.99194C24.2082 7.99194 27.6482 11.1439 28.1082 15.1999C28.1082 15.1999 28.1082 15.2079 28.1082 15.2119C28.1922 16.1919 22.7882 16.3999 21.7162 16.1159C21.5522 16.0719 21.5122 15.9039 21.5122 15.8319C21.5122 15.0879 21.5042 12.9879 21.5042 12.9879C21.5042 12.7439 21.3042 12.5479 21.0602 12.5479C20.8162 12.5479 20.6202 12.7479 20.6202 12.9919L20.6282 16.8559C20.6362 17.0999 20.8402 17.1639 20.8962 17.1759C21.5042 17.1759 22.9242 17.1759 24.2522 17.1759C26.0402 17.1759 26.7922 17.3839 27.2922 17.7639C27.6242 18.0159 27.7522 18.5039 27.6402 19.1359C26.6362 24.7479 20.2762 31.7039 20.0362 31.9959V31.9999Z" fill="#FC8019"/>
          </svg>';
          break;
       
        case 'Youtube':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M31.5042 14.2279C31.2282 13.1999 30.4162 12.3879 29.3882 12.1119C27.5082 11.5959 19.9962 11.5959 19.9962 11.5959C19.9962 11.5959 12.4842 11.5959 10.6042 12.0919C9.59619 12.3679 8.76419 13.1999 8.48819 14.2279C7.99219 16.1079 7.99219 19.9999 7.99219 19.9999C7.99219 19.9999 7.99219 23.9159 8.48819 25.7719C8.76419 26.7999 9.57619 27.6119 10.6042 27.8879C12.5002 28.4039 19.9962 28.4039 19.9962 28.4039C19.9962 28.4039 27.5082 28.4039 29.3882 27.9079C30.4162 27.6319 31.2282 26.82 31.5042 25.7919C32.0002 23.912 32.0002 20.0199 32.0002 20.0199C32.0002 20.0199 32.0202 16.1039 31.5042 14.2279Z" fill="#FF0000"/>
          <path d="M17.6084 16.4V23.596L23.8564 19.996L17.6084 16.396V16.4Z" fill="white"/>
          </svg>';
          break;
       
        case 'zalando':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M30.768 17.2759C28.996 15.0519 26.536 12.8999 23.296 10.9519L23.284 10.9399C20.036 9.03589 16.972 7.92789 14.208 7.47189C12.492 7.18389 11.664 7.51189 11.292 7.73989C10.92 7.95589 10.224 8.52789 9.604 10.1919C8.612 12.8719 8.032 16.1439 8 19.9799V19.9919C8.02 23.8319 8.612 27.1119 9.604 29.7919C10.224 31.4679 10.92 32.0279 11.292 32.2559C11.664 32.4719 12.492 32.8159 14.208 32.5239C16.972 32.0679 20.024 30.9519 23.284 29.0479L23.296 29.0359C26.536 27.0879 29 24.9399 30.768 22.7119C31.864 21.3239 32 20.4239 32 19.9919C32 19.5599 31.876 18.6599 30.768 17.2719" fill="#FF6900"/>
          <path d="M22.6042 26.208H13.8003C13.5043 26.208 13.2842 25.98 13.2842 25.676V24.576C13.2762 24.304 13.3603 24.188 13.5283 23.976L20.5363 15.636H13.6723C13.3763 15.636 13.1562 15.408 13.1562 15.104V14.324C13.1562 14.028 13.3763 13.792 13.6723 13.792H22.5603C22.8563 13.792 23.0763 14.02 23.0763 14.324V15.448C23.0763 15.652 23.0083 15.82 22.8562 16.008L15.8402 24.372H22.6123C22.9082 24.372 23.1283 24.6 23.1283 24.904V25.684C23.1203 25.98 22.9002 26.208 22.6042 26.208Z" fill="black"/>
          </svg>';
          break;
       
        case 'Zepto':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M29.168 8H10.832C9.26793 8 8 9.26793 8 10.832V29.168C8 30.7321 9.26793 32 10.832 32H29.168C30.7321 32 32 30.7321 32 29.168V10.832C32 9.26793 30.7321 8 29.168 8Z" fill="black"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M21.8796 15.28H15.1036C14.6916 15.28 14.2956 15.112 13.9996 14.816C13.7076 14.52 13.5436 14.124 13.5396 13.708C13.5396 13.5 13.5756 13.296 13.6556 13.104C13.7316 12.912 13.8476 12.74 13.9956 12.592C14.1396 12.444 14.3156 12.328 14.5036 12.252C14.6956 12.172 14.8996 12.136 15.1036 12.136H25.2516C25.4556 12.136 25.6636 12.172 25.8516 12.252C26.0436 12.332 26.2156 12.444 26.3596 12.592C26.5036 12.74 26.6196 12.912 26.6996 13.104C26.7756 13.296 26.8156 13.5 26.8156 13.708C26.7996 14.128 26.6236 14.524 26.3276 14.816L18.0796 24.716H25.2556C25.4596 24.716 25.6676 24.752 25.8556 24.832C26.0476 24.912 26.2196 25.024 26.3636 25.172C26.5076 25.32 26.6236 25.492 26.7036 25.684C26.7796 25.876 26.8196 26.08 26.8196 26.288C26.8196 26.704 26.6516 27.104 26.3596 27.396C26.0676 27.692 25.6716 27.856 25.2556 27.86H14.7516C14.3316 27.856 13.9356 27.684 13.6396 27.384C13.3476 27.084 13.1836 26.68 13.1876 26.26C13.1996 25.844 13.3636 25.448 13.6476 25.148L21.8836 15.28H21.8796Z" fill="url(#paint0_linear_2107_18612)"/>
          <defs>
          <linearGradient id="paint0_linear_2107_18612" x1="19.2956" y1="25.148" x2="21.7916" y2="10.544" gradientUnits="userSpaceOnUse">
          <stop stop-color="#FF3269"/>
          <stop offset="1" stop-color="#FF794D"/>
          </linearGradient>
          </defs>
          </svg>';
          break;
       
        case 'Brandsite':
        case 'Brand-Site':
        case 'Brand Site':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M20 32C26.6276 32 32 26.6276 32 20C32 13.3724 26.6276 8 20 8C13.3724 8 8 13.3724 8 20C8 26.6276 13.3724 32 20 32Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M15.3387 9.19995H16.504C14.2317 16.2098 14.2317 23.7901 16.504 30.8H15.3387M23.4956 9.19995C25.7679 16.2098 25.7679 23.7901 23.4956 30.8" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M9.2002 24.6611V23.4959C16.2101 25.7681 23.7903 25.7681 30.8002 23.4959V24.6611M9.2002 16.5042C16.2101 14.232 23.7903 14.232 30.8002 16.5042" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>';
          break;
       
        case 'High Resolution':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M17.36 25V20.842H13.174V25H11.214V15.228H13.174V19.246H17.36V15.228H19.32V25H17.36ZM26.9292 18.266C26.9292 17.398 26.4392 16.852 25.3472 16.852H23.7092V19.722H25.3472C26.4392 19.722 26.9292 19.148 26.9292 18.266ZM21.7492 15.228H25.4172C27.7692 15.228 28.9452 16.586 28.9452 18.224C28.9452 19.414 28.2872 20.618 26.7192 21.038L29.0572 25H26.7892L24.6332 21.192H23.7092V25H21.7492V15.228Z" fill="white"/>
          </svg>';
          break;
       
        case 'Low Grey':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M12.1301 15.228H14.0901V23.446H17.3101V25H12.1301V15.228ZM23.5638 15.102C25.7478 15.102 27.4838 16.208 28.1138 18.168H25.8598C25.4118 17.342 24.5998 16.908 23.5638 16.908C21.8138 16.908 20.5958 18.154 20.5958 20.1C20.5958 22.088 21.8278 23.32 23.6478 23.32C25.1598 23.32 26.1258 22.452 26.4198 21.066H23.0598V19.568H28.3518V21.276C27.9598 23.264 26.1818 25.084 23.5778 25.084C20.7358 25.084 18.5798 23.026 18.5798 20.1C18.5798 17.174 20.7358 15.102 23.5638 15.102Z" fill="white"/>
          </svg>';
          break;
       
        case 'Low White':
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M10.3322 15.228H12.2922V23.446H15.5122V25H10.3322V15.228ZM19.232 25.014L16.6 15.228H18.7L20.422 22.816L22.41 15.228H24.594L26.47 22.774L28.206 15.228H30.32L27.59 25H25.28L23.446 18.042L21.528 25L19.232 25.014Z" fill="white"/>
          </svg>';
          break;
       
        default:
          $svg_is = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="20" fill="#1A1A1A"/>
          <path d="M20 32C26.6276 32 32 26.6276 32 20C32 13.3724 26.6276 8 20 8C13.3724 8 8 13.3724 8 20C8 26.6276 13.3724 32 20 32Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M15.3387 9.19995H16.504C14.2317 16.2098 14.2317 23.7901 16.504 30.8H15.3387M23.4956 9.19995C25.7679 16.2098 25.7679 23.7901 23.4956 30.8" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M9.2002 24.6611V23.4959C16.2101 25.7681 23.7903 25.7681 30.8002 23.4959V24.6611M9.2002 16.5042C16.2101 14.232 23.7903 14.232 30.8002 16.5042" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>';
          break;
      }
      $adaptation_data_arr[$adaptation] = trim($svg_is);
    }
    return $adaptation_data_arr;
  }

  // Side bar menu your assets  link show hide data
  public function your_assets_sidebar(){
    $parent_client_id = $user_id = Auth::id();
		if (Auth::user()->dam_enable != 1) {
			request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
			return redirect()->route('home');
		}
		$roledata = getUsersRole($user_id);
		$role_name = "";
		$role_id = "";

		if ($roledata != null) {
			$role_id = $roledata->role_id;
			$role_name = $roledata->role_name;
		}
		$brand_arr = DB::table('brands_user')->where('user_id', $user_id)->get()->pluck('brand_id')->toArray();
		if ($role_name == 'Sub Client') {
			$parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
			$parent_client_id = $parent_user_data->parent_client_id;
		}

    $sortByIs = 'DESC';
    $your_assets_sidebar_data = [];

    /** creative Lots Data */
      $lots_query = CreatLots::leftjoin('creative_wrc', 'creative_wrc.lot_id', 'creative_lots.id')->whereIn('creative_lots.brand_id', $brand_arr);
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
      )->where('user_id', $parent_client_id);
      $lots_query = $lots_query->groupBy('creative_lots.id');
      $creative_lots_count = $lots_query->count();
      
      $your_assets_sidebar_data['creative_lots_count'] = $creative_lots_count;

      /**  cataloging Lots Data */
      $catalog_lots_data = [];
      $catalog_lots_query = LotsCatalog::leftjoin('catlog_wrc', 'catlog_wrc.lot_id', 'lots_catalog.id')->whereIn('lots_catalog.brand_id', $brand_arr);
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
      )->where('user_id', $parent_client_id);
      $catalog_lots_query = $catalog_lots_query->groupBy('lots_catalog.id')->orderBy('lots_catalog.created_at', $sortByIs);
      $catalog_lots_count = $catalog_lots_query->count();

      $your_assets_sidebar_data['catalog_lots_count'] = $catalog_lots_count;

    /** Shoot lots **/
      $lots_query_cataloging = Lots::leftJoin('wrc', 'wrc.lot_id', '=', 'lots.id')->whereIn('lots.brand_id', $brand_arr)->whereNotNull('wrc.id')->select(
        'lots.id as lot_id',
        'lots.lot_id as lot_number',
        'lots.s_type as s_type',
        'lots.created_at as lot_created_at',
        'wrc.id as wrc_id',
        'wrc.wrc_id as wrc_number',
        DB::raw("GROUP_CONCAT(wrc.id) as wrc_ids"),
        DB::raw("GROUP_CONCAT(wrc.wrc_id) as wrc_numbers"),
        DB::raw("COUNT(wrc.id) as wrc_counts")
      )->groupby('lots.id')->orderBy('lots.created_at', $sortByIs);
      $lots_query_cataloging = $lots_query_cataloging->where('lots.user_id', $parent_client_id);
      $shoot_lots_count = $lots_query_cataloging->count();

      $your_assets_sidebar_data['shoot_lots_count'] = $shoot_lots_count;


    /** Editing lots **/
      $lots_query_editing = EditorLotModel::leftJoin('editing_wrcs', 'editing_wrcs.lot_id', '=', 'editor_lots.id')
      ->whereIn('editor_lots.brand_id', $brand_arr)->whereNotNull('editing_wrcs.id')->
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
        DB::raw("COUNT(editing_wrcs.id) as wrc_counts")
      )->groupby('editor_lots.id');
    $lots_query_editing = $lots_query_editing->where('editor_lots.user_id', $parent_client_id)->orderBy('editor_lots.created_at', $sortByIs);
    $editor_lots_count = $lots_query_editing->count();

    $your_assets_sidebar_data['editor_lots_count'] = $editor_lots_count;


    /* Sending response */
    return $your_assets_sidebar_data;

  }
}
