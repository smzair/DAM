<?php

namespace App\Http\Controllers;

use App\Models\CatalogUploadLinks;
use App\Models\ClientActivityLog;
use App\Models\CreativeUploadLink;
use App\Models\CreatLots;
use App\Models\EditorLotModel;
use App\Models\editorSubmission;
use App\Models\Lots;
use App\Models\LotsCatalog;
use App\Models\uploadraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserAssetsController extends Controller
{
    public function clientUserShootLots()
    {
        $parent_client_id = $user_id = Auth::id();
        if(Auth::user()->dam_enable != 1){
            request()->session()->flash('error','Dam Not Enable!! connect to admin');
            return redirect()->route('home');
        }
        $roledata = getUsersRole($user_id);
        $role_name = "";
        $role_id = "";
        $brand_arr = [];

        if ($roledata != null) {
            $role_id = $roledata->role_id;
            $role_name = $roledata->role_name;
        }

        $lots_query = Lots::with('getShootWrc:id,user_id,brand_id,lot_id,wrc_id')
        ->select('lots.*');
        if ($role_name == 'Sub Client') {
            $parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
            $parent_client_id = $parent_user_data->parent_client_id;
            $brand_arr = DB::table('brands_user')->where('user_id', $user_id)->get()->pluck('brand_id')->toArray();
            $lots_query = $lots_query->whereIn('brand_id', $brand_arr);
        }
        $lots = $lots_query->where('lots.user_id', $parent_client_id)->groupBy('lots.id');
        $lots = $lots_query->get()->toArray();

            foreach ($lots as $key => $row) {
                $get_shoot_wrc = $row['get_shoot_wrc'];
                $sku_count = 0;
                $shootUploadRawImage = $shootTotUploadRawImage = $editor_submission_count =  0;
                foreach ($get_shoot_wrc as $key1 => $row1) {
                    $get_wrc_skus_arr = $row1['get_wrc_skus'];
                    $wrc_skus_count = count($get_wrc_skus_arr);
                    $sku_count += $wrc_skus_count;
                    if($wrc_skus_count > 0){
                        $get_wrc_skus_id_arr = array_column($get_wrc_skus_arr, 'id');
                        $shootUploadRawImage = uploadraw::whereIn('sku_id', $get_wrc_skus_id_arr)->count();
                        $editor_submission = editorSubmission::where('qc','=','1')->whereIn('sku_id', $get_wrc_skus_id_arr)->count();
                    }else{
                        $editor_submission = $shootUploadRawImage = 0;
                    }
                    $shootTotUploadRawImage += $shootUploadRawImage;
                    $editor_submission_count += $editor_submission;
                }
                $shoot_wrc_count = count($get_shoot_wrc);

                $lots[$key]['shoot_wrc_count'] = $shoot_wrc_count;
                $lots[$key]['sku_count'] = $sku_count;
                $lots[$key]['shootTotUploadRawImage'] = $shootTotUploadRawImage;
                $lots[$key]['editor_submission_count'] = $editor_submission_count;
            }
        // dd($lots);
        $properties = [];
        $ClientActivityLog = new ClientActivityLog();
        $ClientActivityLog->log_name = 'Your Assets - Lot View';
        $ClientActivityLog->description = count($lots).' Data viewed';
        $ClientActivityLog->event = 'Shoot lots view';
        $ClientActivityLog->subject_type = 'App\Models\Lots';
        // $ClientActivityLog->subject_id = $user->id;
        $ClientActivityLog->causer_type = 'App\Models\User';
        $ClientActivityLog->causer_id = Auth::id();
        $ClientActivityLog->properties = json_encode($properties);
        $ClientActivityLog->save();
        return view('clients.ClientAssets.client-user-shoot-lots', compact('lots'));
    }

    // Creative Lots 
    public function clientUserCreativeLots()
    {
        $parent_client_id = $user_id = Auth::id();
        if(Auth::user()->dam_enable != 1){
            request()->session()->flash('error','Dam Not Enable!! connect to admin');
            return redirect()->route('home');
        }
        $roledata = getUsersRole($user_id);
        $role_name = "";
        $role_id = "";
        $brand_arr = [];

        if ($roledata != null) {
            $role_id = $roledata->role_id;
            $role_name = $roledata->role_name;
        }

        // $lots_query = DB::table('creative_lots');
        $lots_query = CreatLots::with('getCreativeWrc:id,lot_id,wrc_number,order_qty,sku_required,sku_count')->select('creative_lots.*');
        if ($role_name == 'Sub Client') {
            $parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
            $parent_client_id = $parent_user_data->parent_client_id;
            $brand_arr = DB::table('brands_user')->where('user_id', $user_id)->get()->pluck('brand_id')->toArray();
            $lots_query = $lots_query->whereIn('brand_id', $brand_arr);
        }
        $lots = $lots_query->where('user_id', $parent_client_id);
        $lots = $lots_query->get()->toArray();
        foreach ($lots as $key => $row) {
            $get_creative_wrc = $row['get_creative_wrc'];
            $sku_count = 0;
            $wrcUploadLinks = $totWrcOrderQty = $wrcUploadLinks_count = $wrc_allocations_count =  0;
            foreach ($get_creative_wrc as $key1 => $row1) {
                $wrc_allocations = $row1['wrc_allocations'];
                $wrc_allocations_count_is = count($wrc_allocations);
                if($wrc_allocations_count_is > 0){
                    $wrc_allocations_id_arr = array_column($wrc_allocations, 'id');
                    $wrcUploadLinks = CreativeUploadLink::whereIn('allocation_id', $wrc_allocations_id_arr)->get()->toArray();

                }else{
                    $wrcUploadLinks = [];
                }
                $get_creative_wrc[$key1]['wrcUploadLinks'] = $wrcUploadLinks;
                $wrcUploadLinks_count += count($wrcUploadLinks);
                $wrc_allocations_count += $wrc_allocations_count_is;
                $totWrcOrderQty += ($row1['sku_required'] == 1) ? $row1['sku_count'] : $row1['order_qty'];
            }
            $shoot_wrc_count = count($get_creative_wrc);
            
            $lots[$key]['wrc_count'] = $shoot_wrc_count;
            $lots[$key]['totWrcOrderQty'] = $totWrcOrderQty;
            $lots[$key]['wrc_allocations_count'] = $wrc_allocations_count;
            $lots[$key]['wrcUploadLinks_count'] = $wrcUploadLinks_count;
        }
        // dd($lots);
        $properties = [];
        $ClientActivityLog = new ClientActivityLog();
        $ClientActivityLog->log_name = 'Your Assets - Lot View';
        $ClientActivityLog->description = count($lots).' Data viewed';
        $ClientActivityLog->event = 'Creative lots view';
        $ClientActivityLog->subject_type = 'App\Models\CreatLots';
        // $ClientActivityLog->subject_id = $user->id;
        $ClientActivityLog->causer_type = 'App\Models\User';
        $ClientActivityLog->causer_id = Auth::id();
        $ClientActivityLog->properties = json_encode($properties);
        $ClientActivityLog->save();
        return view('clients.ClientAssets.client-user-creative-lots', compact('lots'));
    }

    // Cataloging Lots
    public function clientUserCatalogingLots()
    {
        $parent_client_id = $user_id = Auth::id();
        if(Auth::user()->dam_enable != 1){
            request()->session()->flash('error','Dam Not Enable!! connect to admin');
            return redirect()->route('home');
        }
        $roledata = getUsersRole($user_id);
        $role_name = "";
        $role_id = "";
        $brand_arr = [];

        if ($roledata != null) {
            $role_id = $roledata->role_id;
            $role_name = $roledata->role_name;
        }

        $lots_query = LotsCatalog::with('WrcListWithAllocation:*');
        if ($role_name == 'Sub Client') {
            $parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
            $parent_client_id = $parent_user_data->parent_client_id;
            $brand_arr = DB::table('brands_user')->where('user_id', $user_id)->get()->pluck('brand_id')->toArray();

            $lots_query = $lots_query->whereIn('brand_id', $brand_arr);
        }
        $lots = $lots_query->where('user_id', $parent_client_id);
        $lots = $lots_query->get()->toArray();

        foreach ($lots as $key => $row) {
            $wrc_list_with_allocation = $row['wrc_list_with_allocation'];
            $wrcUploadLinks = $totWrcOrderQty = $wrcUploadLinks_count = $wrc_allocations_count =  0;
            foreach ($wrc_list_with_allocation as $key1 => $row1) {
                $wrc_allocation_list = $row1['wrc_allocation_list'];
                $wrc_allocations_count_is = count($wrc_allocation_list);
                if($wrc_allocations_count_is > 0){
                    $wrc_allocations_id_arr = array_column($wrc_allocation_list, 'id');
                    $wrcUploadLinks = CatalogUploadLinks::whereIn('allocation_id', $wrc_allocations_id_arr)->get()->toArray();

                }else{
                    $wrcUploadLinks = [];
                }
                $wrc_list_with_allocation[$key1]['wrcUploadLinks'] = $wrcUploadLinks;
                $wrcUploadLinks_count += count($wrcUploadLinks);
                $wrc_allocations_count += $wrc_allocations_count_is;
                $totWrcOrderQty += $row1['sku_qty'];
            }
            $wrc_count = count($wrc_list_with_allocation);
            $lots[$key]['wrc_count'] = $wrc_count;
            $lots[$key]['totWrcOrderQty'] = $totWrcOrderQty;
            $lots[$key]['wrc_allocations_count'] = $wrc_allocations_count;
            $lots[$key]['wrcUploadLinks_count'] = $wrcUploadLinks_count;
        }
        // dd($lots);
        $properties = [];
        $ClientActivityLog = new ClientActivityLog();
        $ClientActivityLog->log_name = 'Your Assets - Lot View';
        $ClientActivityLog->description = count($lots).' Data viewed';
        $ClientActivityLog->event = 'Catalog lots view';
        $ClientActivityLog->subject_type = 'App\Models\LotsCatalog';
        // $ClientActivityLog->subject_id = $user->id;
        $ClientActivityLog->causer_type = 'App\Models\User';
        $ClientActivityLog->causer_id = Auth::id();
        $ClientActivityLog->properties = json_encode($properties);
        $ClientActivityLog->save();
        return view('clients.ClientAssets.client-user-Cataloging-lots', compact('lots'));
    }

    // Editing Lots
    public function clientUserEditingLots()
    {
        $parent_client_id = $user_id = Auth::id();
        if(Auth::user()->dam_enable != 1){
            request()->session()->flash('error','Dam Not Enable!! connect to admin');
            return redirect()->route('home');
        }
        $roledata = getUsersRole($user_id);
        $role_name = "";
        $role_id = "";
        $brand_arr = [];

        if ($roledata != null) {
            $role_id = $roledata->role_id;
            $role_name = $roledata->role_name;
        }

        $lots_query = EditorLotModel::with('getEditingWrc:*');
        if ($role_name == 'Sub Client') {
            $parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
            $parent_client_id = $parent_user_data->parent_client_id;
            $brand_arr = DB::table('brands_user')->where('user_id', $user_id)->get()->pluck('brand_id')->toArray();
            $lots_query = $lots_query->whereIn('brand_id', $brand_arr);
        }
        $lots = $lots_query->where('user_id', $parent_client_id);
        $lots = $lots_query->get()->toArray();

        foreach ($lots as $key => $row) {
            $uploadRawImage = $totUploadRawImage = $tot_submission_count = $imgQty = $uploaded_img_qty =  0;
            $get_editing_wrc = $row['get_editing_wrc'];
            $wrc_count = count($get_editing_wrc);
            foreach ($get_editing_wrc as $key1 => $row1) {
                $totUploadRawImage += $row1['uploaded_img_qty'];
                $editing_edited_images_arr = $row1['get_editing_edited_images'];
                $tot_submission_count += count($editing_edited_images_arr);
            }
            $lots[$key]['wrc_count'] = $wrc_count;
            $lots[$key]['totUploadRawImage'] = $totUploadRawImage;
            $lots[$key]['tot_submission_count'] = $tot_submission_count;
        }

        $properties = [];
        $ClientActivityLog = new ClientActivityLog();
        $ClientActivityLog->log_name = 'Your Assets - Lot View';
        $ClientActivityLog->description = count($lots).' Data viewed';
        $ClientActivityLog->event = 'Editor lots view';
        $ClientActivityLog->subject_type = 'App\Models\EditorLotModel';
        // $ClientActivityLog->subject_id = $user->id;
        $ClientActivityLog->causer_type = 'App\Models\User';
        $ClientActivityLog->causer_id = Auth::id();
        $ClientActivityLog->properties = json_encode($properties);
        $ClientActivityLog->save();

        return view('clients.ClientAssets.client-user-editing-lots', compact('lots'));
    }
}
