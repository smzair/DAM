<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\ClientsModel\FavoriteAsset;
use App\Models\CreatLots;
use App\Models\EditorLotModel;
use App\Models\Lots;
use App\Models\LotsCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class User_Assets_Favorites_controller extends Controller
{
  public function index()
  {
    return view('clients.ClientAssetsLinks.your-assets-Favorites');
  }

  public function save(Request $request)
  {
    $user_id = '';
    $brand_id = '';
    $lot_id = '';
    $wrc_id = '';
    $service = '';
    $module = '';
    $status = false;
    $massage = "Somthing went wrong!!";
    $data = $request->data;
    if (array_key_exists('service', $data)) {
      $service = $data['service'] != '' ? base64_decode($data['service']) : '';
    }

    if (array_key_exists('module', $data)) {
      $module = $data['module'] != '' ? base64_decode($data['module']) : '';
    }

    if (array_key_exists('lot_id', $data)) {
      $lot_id = $data['lot_id'] != '' ? base64_decode($data['lot_id']) : '';
    }
    if (array_key_exists('wrc_id', $data)) {
      $wrc_id = $data['wrc_id'] != '' ? base64_decode($data['wrc_id']) : '';
    }
    if (array_key_exists('user_id', $data)) {
      $user_id = $data['user_id'] != '' ? base64_decode($data['user_id']) : '';
    }
    if (array_key_exists('brand_id', $data)) {
      $brand_id = $data['brand_id'] != '' ? base64_decode($data['brand_id']) : '';
    }


    try {
      $createdBy = Auth::id();
      if ($service == 'SHOOT') {
        // shoot lot
        if ($module == 'lot' && $lot_id > 0) {
          $lot_detail = Lots::where('lots.id', $lot_id)->leftjoin('wrc', 'wrc.lot_id', 'lots.id')->select(
            'lots.user_id',
            'lots.brand_id',
            'lots.id as lot_id',
            'wrc.id as wrc_id',
            'lots.lot_id as lot_number',
            'lots.created_at'
          )->get()->toArray();
          // protected $fillable = ['user_id', 'brand_id', 'lot_id', 'wrc_id', 'service', 'module', 'created_by'];
          if (count($lot_detail) > 0) {
            $lot_data = $lot_detail[0];
            $response = FavoriteAsset::updateOrCreate(
              ['service' => $service, 'module' => $module, 'lot_id' => $lot_id],
              [
                'user_id' => $lot_data['user_id'],
                'brand_id' => $lot_data['brand_id'],
                'lot_id' => $lot_data['lot_id'],
                'wrc_id' => $lot_data['wrc_id'],
                'module' => $module,
                'created_by' => $createdBy,
              ]
            );
            if ($response) {
              $status = true;
              $massage = 'Lot successfully added to Favorite!!';
            }
          }
        } elseif ($module == 'wrc' && $wrc_id > 0) {
          $lot_detail = Lots::where('wrc.id', $wrc_id)->leftjoin('wrc', 'wrc.lot_id', 'lots.id')->select(
            'lots.user_id',
            'lots.brand_id',
            'lots.id as lot_id',
            'wrc.id as wrc_id',
            'lots.lot_id as lot_number',
            'lots.created_at'
          )->get()->toArray();
          if (count($lot_detail) > 0) {
            $lot_data = $lot_detail[0];
            $response = FavoriteAsset::updateOrCreate(
              ['service' => $service, 'module' => $module, 'lot_id' => $lot_id],
              [
                'user_id' => $lot_data['user_id'],
                'brand_id' => $lot_data['brand_id'],
                'lot_id' => $lot_data['lot_id'],
                'wrc_id' => $lot_data['wrc_id'],
                'module' => $module,
                'created_by' => $createdBy,
              ]
            );
            if ($response) {
              $status = true;
              $massage = 'Wrc successfully added to Favorite!!';
            }
          }
        } elseif ($module == 'adaptation') {
          $lot_detail = Lots::where('wrc.id', $wrc_id)->leftjoin('wrc', 'wrc.lot_id', 'lots.id')->select(
            'lots.user_id',
            'lots.brand_id',
            'lots.id as lot_id',
            'wrc.id as wrc_id',
            'lots.lot_id as lot_number',
            'lots.created_at'
          )->get()->toArray();
          $commercial_id = base64_decode($data['other_data']['commercial_id']);
          $other_data = json_encode(
            array(
              'commercial_id' => $commercial_id,
              'adaptation' => base64_decode($data['other_data']['adaptation'])
            )
          );
          // dd($other_data);
          if (count($lot_detail) > 0) {
            $lot_data = $lot_detail[0];
            $response = FavoriteAsset::updateOrCreate(
              ['service' => $service, 'module' => $module, 'lot_id' => $lot_id, 'other_data' => $other_data],
              [
                'user_id' => $lot_data['user_id'],
                'brand_id' => $lot_data['brand_id'],
                'lot_id' => $lot_data['lot_id'],
                'wrc_id' => $lot_data['wrc_id'],
                'module' => $module,
                'other_data_id' => $commercial_id,
                'other_data' => $other_data,
                'created_by' => $createdBy,
              ]
            );
            // dd($response);
            if ($response) {
              $status = true;
              $massage = 'Adaptation successfully added to Favorite!!';
            }
          }
        }elseif ($module == 'sku') {
          $lot_detail = Lots::where('wrc.id', $wrc_id)->leftjoin('wrc', 'wrc.lot_id', 'lots.id')->select(
            'lots.user_id',
            'lots.brand_id',
            'lots.id as lot_id',
            'wrc.id as wrc_id',
            'lots.lot_id as lot_number',
            'lots.created_at'
          )->get()->toArray();
          // dd($data);
          $sku_id = base64_decode($data['other_data']['sku_id']);
          $type = $data['other_data']['type'];
          $other_data_arr = array(
            'sku_id' => $sku_id,
            'sku_code' => base64_decode($data['other_data']['sku_code']),
            'type' => $type
          );

          if (array_key_exists('adaptation', $data['other_data'])) {
            $other_data_arr['adaptation'] = $data['other_data']['adaptation'];
          }

          $other_data = json_encode($other_data_arr);
          // dd($other_data , $other_data_arr);
          if (count($lot_detail) > 0) {
            $lot_data = $lot_detail[0];
            $response = FavoriteAsset::updateOrCreate(
              ['service' => $service, 'module' => $module, 'lot_id' => $lot_id, 'type' => $type, 'other_data' => $other_data],
              [
                'user_id' => $lot_data['user_id'],
                'brand_id' => $lot_data['brand_id'],
                'lot_id' => $lot_data['lot_id'],
                'wrc_id' => $lot_data['wrc_id'],
                'module' => $module,
                'type' => $type,
                'other_data_id' => $sku_id,
                'other_data' => $other_data,
                'created_by' => $createdBy,
              ]
            );
            // dd($response);
            if ($response) {
              $status = true;
              $massage = 'Sku successfully added to Favorite!!';
            }
          }
        }elseif ($module == 'image') {
          $lot_detail = Lots::where('wrc.id', $wrc_id)->leftjoin('wrc', 'wrc.lot_id', 'lots.id')->select(
            'lots.user_id',
            'lots.brand_id',
            'lots.id as lot_id',
            'wrc.id as wrc_id',
            'lots.lot_id as lot_number',
            'lots.created_at'
          )->get()->toArray();
          // dd($data);
          $other_data_is = $data['other_data'];
          $type = $other_data_is['type'];

          $sku_id = base64_decode($other_data_is['sku_id']);
          $sku_code = base64_decode($other_data_is['sku_code']);
          
          $other_data_arr = $other_data_is;
          $other_data_arr['sku_id'] = $sku_id;
          $other_data_arr['sku_code'] = $sku_code;

          $other_data = json_encode($other_data_arr);
          // dd($data['other_data'] , $other_data , $other_data_arr);
          if (count($lot_detail) > 0) {
            $lot_data = $lot_detail[0];
            $response = FavoriteAsset::updateOrCreate(
              ['service' => $service, 'module' => $module, 'lot_id' => $lot_id, 'type' => $type, 'other_data' => $other_data],
              [
                'user_id' => $lot_data['user_id'],
                'brand_id' => $lot_data['brand_id'],
                'lot_id' => $lot_data['lot_id'],
                'wrc_id' => $lot_data['wrc_id'],
                'module' => $module,
                'type' => $type,
                'other_data_id' => $sku_id,
                'other_data' => $other_data,
                'created_by' => $createdBy,
              ]
            );
            // dd($response);
            if ($response) {
              $status = true;
              $massage = 'Image successfully added to Favorite!!';
            }
          }
        }else{
          // dd($module , $service , $data);
        }
      } else if ($service == 'EDITING') {
        if ($module == 'lot' && $lot_id > 0) {

          $lots_query_cataloging = EditorLotModel::leftJoin('editing_wrcs', 'editing_wrcs.lot_id', '=', 'editor_lots.id')
            ->where('editor_lots.id', $lot_id)->select(
              'editor_lots.user_id',
              'editor_lots.brand_id',
              'editor_lots.id as lot_id',
              'editing_wrcs.id as wrc_id',
              'editing_wrcs.wrc_number',
              'editing_wrcs.uploaded_img_file_path'
            )->groupby('editor_lots.id');

          $editor_lots = $lots_query_cataloging->get()->toArray();
          if (count($editor_lots) > 0) {
            $lot_data = $editor_lots[0];

            $response = FavoriteAsset::updateOrCreate(
              ['service' => $service, 'module' => $module, 'lot_id' => $lot_id],
              [
                'user_id' => $lot_data['user_id'],
                'brand_id' => $lot_data['brand_id'],
                'lot_id' => $lot_data['lot_id'],
                'module' => $module,
                'created_by' => $createdBy,
              ]
            );
            if ($response) {
              $status = true;
              $massage = 'Lot successfully added to Favorite!!';
            }
          }
        } elseif ($module == 'wrc' && $wrc_id > 0) {
          $lots_query_cataloging = EditorLotModel::leftJoin('editing_wrcs', 'editing_wrcs.lot_id', '=', 'editor_lots.id')
            ->where('editing_wrcs.id', $wrc_id)->select(
              'editor_lots.user_id',
              'editor_lots.brand_id',
              'editor_lots.id as lot_id',
              'editing_wrcs.id as wrc_id',
              'editing_wrcs.wrc_number',
              'editing_wrcs.uploaded_img_file_path'
            )->groupby('editor_lots.id');

          $editor_lots = $lots_query_cataloging->get()->toArray();
          if (count($editor_lots) > 0) {
            $lot_data = $editor_lots[0];

            $response = FavoriteAsset::updateOrCreate(
              ['service' => $service, 'module' => $module, 'wrc_id' => $wrc_id],
              [
                'user_id' => $lot_data['user_id'],
                'brand_id' => $lot_data['brand_id'],
                'lot_id' => $lot_data['lot_id'],
                'wrc_id' => $lot_data['wrc_id'],
                'module' => $module,
                'created_by' => $createdBy,
              ]
            );
            if ($response) {
              $status = true;
              $massage = 'Wrc successfully added to Favorite!!';
            }
          }
        }elseif ($module == 'image') {
          $lots_query_cataloging = EditorLotModel::leftJoin('editing_wrcs', 'editing_wrcs.lot_id', '=', 'editor_lots.id')
            ->where('editing_wrcs.id', $wrc_id)->select(
              'editor_lots.user_id',
              'editor_lots.brand_id',
              'editor_lots.id as lot_id',
              'editing_wrcs.id as wrc_id',
              'editing_wrcs.wrc_number',
              'editing_wrcs.uploaded_img_file_path'
            )->groupby('editor_lots.id');

          $editor_lots = $lots_query_cataloging->get()->toArray();
          if (count($editor_lots) > 0) {
            $other_data_is = $data['other_data'];
            $type = $other_data_is['type'];
            $upladed_img_id = $other_data_is['upladed_img_id'];
            $other_data_arr = $other_data_is;
            $other_data = json_encode($other_data_arr);
            $lot_data = $editor_lots[0];

            $response = FavoriteAsset::updateOrCreate(
              ['service' => $service, 'module' => $module, 'lot_id' => $lot_id, 'type' => $type, 'other_data' => $other_data],
              [
                'user_id' => $lot_data['user_id'],
                'brand_id' => $lot_data['brand_id'],
                'lot_id' => $lot_data['lot_id'],
                'wrc_id' => $lot_data['wrc_id'],
                'module' => $module,
                'type' => $type,
                'other_data_id' => $upladed_img_id,
                'other_data' => $other_data,
                'created_by' => $createdBy,
              ]
            );
            if ($response) {
              $status = true;
              $massage = 'Image successfully added to Favorite!!';
            }
          }
        }else{
          // dd($module , $service , $data);
        }
      } else if ($service == 'CATALOGING') {
        // dd($module , $service , $data);

        if ($module == 'lot') {
          if($user_id == '' || $user_id == ''){
            $catalog_lots_query = LotsCatalog::leftjoin('catlog_wrc', 'catlog_wrc.lot_id', 'lots_catalog.id')->where('lots_catalog.id', $lot_id)->select(
              'catlog_wrc.id ad wrc_id',            
              'lots_catalog.id as lot_id',
              'lots_catalog.user_id',
              'lots_catalog.brand_id',
              'lots_catalog.lot_number',
              'lots_catalog.created_at as lot_created_at'
            );
            $catalog_lots_query = $catalog_lots_query->groupBy('lots_catalog.id');
            $catalog_lots = $catalog_lots_query->get()->toArray();
            $lot_data = $catalog_lots[0];
            $user_id = $lot_data['user_id'];
            $brand_id = $lot_data['brand_id'];
          }

          if($user_id > 0 && $user_id > 0 && $lot_id > 0){
            $response = FavoriteAsset::updateOrCreate(
              ['service' => $service, 'module' => $module, 'lot_id' => $lot_id],
              [
                'user_id' => $user_id,
                'brand_id' => $brand_id,
                'lot_id' => $lot_id,
                'wrc_id' => $wrc_id,
                'module' => $module,
                'created_by' => $createdBy,
              ]
            );
            if ($response) {
              $status = true;
              $massage = 'Lot successfully added to Favorite!!';
            }
          }
        }else{
          // dd($data);
        }
      } else if ($service == 'CREATIVE') {
        // dd($module , $service , $data);
        // lot
        if ($module == 'lot') {
          if($user_id == '' || $user_id == ''){
            $lots_query = CreatLots::leftjoin('creative_wrc', 'creative_wrc.lot_id', 'creative_lots.id')->where('creative_lots.id', $lot_id)->select(
              'creative_wrc.id ad wrc_id',            
              'creative_lots.id as lot_id',
              'creative_lots.user_id',
              'creative_lots.brand_id',
              'creative_lots.lot_number',
              'creative_lots.created_at as lot_created_at'
            );
            $lots_query = $lots_query->groupBy('creative_lots.id');
            $catalog_lots = $lots_query->get()->toArray();
            $lot_data = $catalog_lots[0];
            $user_id = $lot_data['user_id'];
            $brand_id = $lot_data['brand_id'];
          }

          if($user_id > 0 && $user_id > 0 && $lot_id > 0){
            $response = FavoriteAsset::updateOrCreate(
              ['service' => $service, 'module' => $module, 'lot_id' => $lot_id],
              [
                'user_id' => $user_id,
                'brand_id' => $brand_id,
                'lot_id' => $lot_id,
                'wrc_id' => $wrc_id,
                'module' => $module,
                'created_by' => $createdBy,
              ]
            );
            if ($response) {
              $status = true;
              $massage = 'Lot successfully added to Favorite!!';
            }
          }
        }else{
          // dd($data);
        }
      }
      $response_data = array(
        'status' => $status,
        'massage' => $massage,
        'data' => $data
      );
    } catch (\Exception $th) {
      dd($th);
      $response_data = array(
        'status' => $status,
        'massage' => $massage,
        'errorInfo' => $th
      );
    }



    echo json_encode($response_data, true);
  }
}
