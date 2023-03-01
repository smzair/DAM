<?php

namespace App\Http\Controllers;

use App\Models\CreatLots;
use App\Models\Lots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserAssetsController extends Controller
{
    public function clientUserShootLots()
    {
        $parent_client_id = $user_id = Auth::id();
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
        return view('clients.ClientAssets.client-user-shoot-lots', compact('lots'));
    }

    // Creative Lots 
    public function clientUserCreativeLots()
    {
        $parent_client_id = $user_id = Auth::id();
        $roledata = getUsersRole($user_id);
        $role_name = "";
        $role_id = "";
        $brand_arr = [];

        if ($roledata != null) {
            $role_id = $roledata->role_id;
            $role_name = $roledata->role_name;
        }

        // $lots_query = DB::table('creative_lots');
        $lots_query = CreatLots::with('getCreativeWrc:id,lot_id,wrc_number')->select('creative_lots.*');
        if ($role_name == 'Sub Client') {
            $parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
            $parent_client_id = $parent_user_data->parent_client_id;
            $brand_arr = DB::table('brands_user')->where('user_id', $user_id)->get()->pluck('brand_id')->toArray();
            $lots_query = $lots_query->whereIn('brand_id', $brand_arr);
        }
        $lots = $lots_query->where('user_id', $parent_client_id);
        $lots = $lots_query->get()->toArray();
        // dd($lots);
        return view('clients.ClientAssets.client-user-creative-lots', compact('lots'));
    }

    // Cataloging Lots
    public function clientUserCatalogingLots()
    {
        $parent_client_id = $user_id = Auth::id();
        $roledata = getUsersRole($user_id);
        $role_name = "";
        $role_id = "";
        $brand_arr = [];

        if ($roledata != null) {
            $role_id = $roledata->role_id;
            $role_name = $roledata->role_name;
        }

        $lots_query = DB::table('lots_catalog');
        if ($role_name == 'Sub Client') {
            $parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
            $parent_client_id = $parent_user_data->parent_client_id;
            $brand_arr = DB::table('brands_user')->where('user_id', $user_id)->get()->pluck('brand_id')->toArray();

            $lots_query = $lots_query->whereIn('brand_id', $brand_arr);
        }
        $lots = $lots_query->where('user_id', $parent_client_id);
        $lots = $lots_query->get();
        return view('ClientAssets.client-user-Cataloging-lots', compact('lots'));
    }

    // Editing Lots
    public function clientUserEditingLots()
    {
        $parent_client_id = $user_id = Auth::id();
        $roledata = getUsersRole($user_id);
        $role_name = "";
        $role_id = "";
        $brand_arr = [];

        if ($roledata != null) {
            $role_id = $roledata->role_id;
            $role_name = $roledata->role_name;
        }

        $lots_query = DB::table('editor_lots');
        if ($role_name == 'Sub Client') {
            $parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
            $parent_client_id = $parent_user_data->parent_client_id;
            $brand_arr = DB::table('brands_user')->where('user_id', $user_id)->get()->pluck('brand_id')->toArray();

            $lots_query = $lots_query->whereIn('brand_id', $brand_arr);
        }
        $lots = $lots_query->where('user_id', $parent_client_id);
        $lots = $lots_query->get();
        return view('ClientAssets.client-user-Editing-lots', compact('lots'));
    }
}
