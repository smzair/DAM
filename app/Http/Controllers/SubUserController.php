<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubUserController extends Controller
{
    //
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
        if ($role_name == 'Sub Client') {
            $parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
            $parent_client_id = $parent_user_data->parent_client_id;

            $brands_user_data = DB::table('brands_user')->where('user_id', $user_id);
            dd($brands_user_data);

        }
        $lots = DB::table('lots')->where('user_id', $parent_client_id)->get();
        dd($user_id, $parent_client_id, $lots);

        dd("subclient query 1");
        return view('user.index', compact('users', 'roles'));
    }
}
