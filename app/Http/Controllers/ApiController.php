<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //get catlog wrc based on user id and brand id 
    public function getCatlogWrc(Request $request)
    {
        $user_id = $request->user_id;
        $brand_id = $request->brand_id;

        $lots_catalog = DB::table('lots_catalog')
                    ->leftJoin('catlog_wrc', 'lots_catalog.id', '=', 'catlog_wrc.lot_id')
                    ->where('lots_catalog.user_id', $user_id)
                    ->where('lots_catalog.brand_id', $brand_id)
                    ->select('catlog_wrc.*')
                    ->get();

        return response()->json([
            'data' => $lots_catalog,
            'message' => 'Successfully retrieved catlog_wrc',
        ]);
    }

    //get Company User Name
    public function getCompanyUserName(){
        
        $users_data = DB::table('users')
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
        ->orderBy('users.Company')
        ->where([ ['users.Company' ,'<>' ,NULL], ['roles.name','=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);
        return response()->json([
            'data' => $users_data,
            'message' => 'Successfully retrieved catlog_wrc',
        ]);
    }

    //get brands based on user id 
    public function getBrands($userId)
    {
        $brands = DB::table('brands_user')->where('user_id', $userId)
            ->leftJoin('brands', 'brands_user.brand_id', 'brands.id')
            ->select('brands.name', 'brands.short_name', 'brands_user.brand_id')->get();

            return response()->json([
                'data' => $brands,
                'message' => 'Successfully retrieved catlog_wrc',
            ]);
    }


}
