<?php

namespace App\Http\Controllers;

use App\Models\CatalogAllocation;
use App\Models\CatalogUploadedMarketplaceCount;
use App\Models\CatalogWrcBatch;
use App\Models\CatlogWrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class CatalogUploadedMarketplaceCountController extends Controller
{
    // get_uploaded_Marketplace_count

    function get_uploaded_Marketplace_count(Request $request)
    {
        $allocation_id = $request->allocation_id;
        $market_place = $request->market_place;
        echo $response = CatalogUploadedMarketplaceCount::get_uploaded_Marketplace_count($allocation_id, $market_place);
    }

    // Get Marketplace count in Submission panel
    function get_sub_Marketplace_count(Request $request)
    {
        $allocation_ids = $request->allocation_ids;
        $market_place = $request->market_place;
        echo $response = CatalogUploadedMarketplaceCount::get_sub_Marketplace_count($allocation_ids, $market_place);
    }

    

    // save Marketplace-approved-Count
    function save_Marketplace_approved_Count(Request $request)
    {
        // dd($request->data_arr);
         $response = CatalogUploadedMarketplaceCount::save_Marketplace_approved_Count($request);
         $check_array = json_decode($response);
         $response_success_check = $check_array->response;
         if($response_success_check == 1){
            /****** send notification start */
            $Catlog_allocation_data = CatalogAllocation::where('id',$request->allocation_id_is)->first(['wrc_id','user_id']);
            $wrc_id = $Catlog_allocation_data != null ? $Catlog_allocation_data->wrc_id : 0;
            $user_id = $Catlog_allocation_data != null ? $Catlog_allocation_data->user_id : 0;
            $allocated_qty = CatalogAllocation::where('wrc_id',$wrc_id)->where('user_id',$user_id)->sum('allocated_qty');
            $wrc_data = CatlogWrc::where('id',$wrc_id)->first(['wrc_number','sku_qty']);
            $wrc_number = $wrc_data != null ? $wrc_data->wrc_number : "";
            $order_qty = $wrc_data != null ? $wrc_data->sku_qty : "";
            $max_batch_no = CatalogWrcBatch::where('wrc_id', $wrc_id)->max('batch_no');

            $user_id = 9;
            // $user_id = Auth::user()->id;
            $logged_in_user_data = DB::table('users')->where('id', $user_id )->first(['name']);
            $uploaded_by_user_name = $logged_in_user_data != null ? $logged_in_user_data->name : " ";

            $data = new stdClass();
            $data->wrc_number = $wrc_number;
            $data->batch_no = $max_batch_no;
            $data->uploaded_by_user_name = $uploaded_by_user_name;
            $data->data_array = $request->data_arr;
            $data->order_qty = $order_qty;
            $creation_type = 'completeTaskInUploadCatlogMarketPlace';
            $this->send_notification($data, $creation_type);
            /****** send notification end*******/
         }
         echo $response;
    }
        
}
