<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    // getBrand List 
    public function getBrand(Request $request)
    {

        $brand_data = DB::table('brands_user')->where('user_id', $request->user_id)
            ->leftJoin('brands', 'brands_user.brand_id', 'brands.id')
            ->select('brands.name', 'brands.short_name', 'brands_user.brand_id')->get();

        echo $brand_data;
    }
}