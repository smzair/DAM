<?php

namespace App\Http\Controllers;

use App\Models\Skus;
use App\Models\uploadraw;
use App\Models\Wrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class clientFileManager extends Controller
{
    public function clientRawImages(Request $request){

        $logged_in_user_id = Auth::id();

        $lotData = DB::table('users')
        ->where('users.id', $logged_in_user_id)
        ->where('users.dam_enable', '1')
        ->join('brands_user', 'brands_user.user_id', 'users.id')
        ->join('brands', 'brands.id', 'brands_user.brand_id')
        ->join('lots', function($join) {
            $join->on('lots.user_id', '=', 'brands_user.user_id');
            $join->on('lots.brand_id', '=', 'brands_user.brand_id');
        })->select('lots.*')->get();

        /*$resData = DB::table('users')
                ->where('users.id', $logged_in_user_id)
                ->where('users.dam_enable', '1')
                ->join('brands_user', 'brands_user.user_id', 'users.id')
                ->join('brands', 'brands.id', 'brands_user.brand_id')
                ->join('lots', function($join) {
                    $join->on('lots.user_id', '=', 'brands_user.user_id');
                    $join->on('lots.brand_id', '=', 'brands_user.brand_id');
                })
                ->join('wrc', function($join) {
                    $join->on('wrc.lot_id', '=', 'lots.id');
                    $join->on('wrc.user_id', '=', 'brands_user.user_id');
                })
                ->join('sku', function($join) {
                    $join->on('sku.wrc_id', '=', 'wrc.id');
                    $join->on('sku.user_id', '=', 'brands_user.user_id');
                    $join->on('sku.lot_id', '=', 'lots.id');
                })
                ->join('uploadraw', 'uploadraw.sku_id', 'sku.id')
                ->select(
                    'uploadraw.*',
                    'lots.lot_id',
                    'wrc.wrc_id'
                )
                ->get();*/
                           
        // dd($lotData);

        return view('clients.ClientFileManager.clientsRawImages',compact('lotData'));
    }

    //get wrc based on lot id
    public function getWrcForClientRawImages(Request $request, $id){
        $lot_id = $id;
        $logged_in_user_id = Auth::id();
        $wrc_data = Wrc::where('lot_id',$lot_id)->where('user_id',$logged_in_user_id)->get();
        return view('clients.ClientFileManager.WrcViewForClientsRawImages',compact('wrc_data'));
    }

    public function getSkusForClientRawImages(Request $request, $id){
        $wrc_id = $id;
        $logged_in_user_id = Auth::id();
        $sku_data = Skus::where('wrc_id',$wrc_id)->where('user_id',$logged_in_user_id)->get();
        return view('clients.ClientFileManager.SkuViewForClientsRawImages',compact('sku_data'));

    }

    // get upload raw images based on skus id
    public function getClientUploadRawImages(Request $request, $id){
        $sku_id = $id;
        $file_data = uploadraw::where('uploadraw.sku_id',$id)
        
        ->leftJoin('sku', 'sku.id', 'uploadraw.sku_id')
        ->join('wrc', function($join) {
            $join->on('wrc.id', '=', 'sku.wrc_id');
            $join->on('wrc.user_id', '=', 'sku.user_id');
            $join->on('wrc.lot_id', '=', 'sku.lot_id');
        })
        ->join('lots', function($join) {
            $join->on('lots.user_id', '=', 'wrc.user_id');
            $join->on('lots.id', '=', 'wrc.lot_id');
        })
        ->select(
            'uploadraw.*',
            'wrc.wrc_id',
            'wrc.created_at as wrc_created_at',
            'lots.lot_id'
        )
        ->get();
        // dd($file_data);
        return view('clients.ClientFileManager.UploadedImagesViewForClientsRawImages',compact('file_data'));
    }

    public function clientEditorImages(Request $request){
        $logged_in_user_id = Auth::id();
        $resData = DB::table('users')
                ->where('users.id', $logged_in_user_id)
                ->where('users.dam_enable', '1')
                ->join('brands_user', 'brands_user.user_id', 'users.id')
                ->join('brands', 'brands.id', 'brands_user.brand_id')
                ->join('editor_lots', function($join) {
                    $join->on('editor_lots.user_id', '=', 'brands_user.user_id');
                    $join->on('editor_lots.brand_id', '=', 'brands_user.brand_id');
                })
                ->join('editing_wrcs', function($join) {
                    $join->on('editing_wrcs.lot_id', '=', 'editor_lots.id');
                })
                ->join('sku', function($join) {
                    $join->on('sku.wrc_id', '=', 'editing_wrcs.id');
                    $join->on('sku.user_id', '=', 'brands_user.user_id');
                    $join->on('sku.lot_id', '=', 'editor_lots.id');
                })
                ->join('editor_submission', 'editor_submission.sku_id', 'sku.id')
                ->select(
                    'editor_submission.*',
                    'editor_lots.lot_number',
                    'editing_wrcs.wrc_number'
                )
                ->get();
                           
        dd($resData);
    }
}
