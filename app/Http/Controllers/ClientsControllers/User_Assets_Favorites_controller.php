<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\ClientsModel\FavoriteAsset;
use App\Models\EditorLotModel;
use App\Models\Lots;
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
          $other_data = json_encode(
            array(
              'sku_id' => $sku_id,
              'sku_code' => base64_decode($data['other_data']['sku_code']),
              'type' => $type
            )
          );
          // dd($type);
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
        }else{
          dd($module , $service);
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
        }
      } else if ($service == 'CATALOGING') {
      } else if ($service == 'CREATIVE') {
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
