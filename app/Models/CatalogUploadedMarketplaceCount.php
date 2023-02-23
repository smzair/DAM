<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CatalogUploadedMarketplaceCount extends Model
{
    use HasFactory;
    protected $table = 'catalog_uploaded_marketplace_counts';
    protected $fillable = [
        'allocation_id', 'marketplace_id', 'approved_Count', 'rejected_Count', 'upload_date'
    ];


    public static function get_uploaded_Marketplace_count($allocation_id, $market_place_ids)
    {
        $market_place_ids = explode(',', $market_place_ids);
        $response = Marketplace::
        leftJoin(
            'catalog_uploaded_marketplace_counts as cata_up_m_c',
            function ($join) use ($allocation_id) {
            $join->on('cata_up_m_c.marketplace_id', '=', 'marketplaces.id');
            $join->where('cata_up_m_c.allocation_id', '=', $allocation_id)
                ->orWhere('cata_up_m_c.allocation_id', '=', NULL);
        })->
        whereIn('marketplaces.id', $market_place_ids)->
        select(
            DB::raw('(CASE WHEN cata_up_m_c.id IS NULL THEN 0 ELSE cata_up_m_c.id END) AS uploaded_Marketplace_id'),
            'marketplaces.id as marketplace_id',
            'marketplaces.marketPlace_name',
            DB::raw("(CASE WHEN cata_up_m_c.approved_Count IS NULL THEN '' WHEN cata_up_m_c.approved_Count = 0 THEN '' ELSE cata_up_m_c.approved_Count END) AS approved_Count"),
            DB::raw("(CASE WHEN cata_up_m_c.rejected_Count IS NULL THEN '' WHEN cata_up_m_c.rejected_Count = 0 THEN '' ELSE cata_up_m_c.rejected_Count END) AS rejected_Count"),
            DB::raw("(CASE WHEN cata_up_m_c.upload_date IS NULL THEN '' WHEN cata_up_m_c.upload_date = '0000-00-00' THEN '' ELSE cata_up_m_c.upload_date END) AS upload_date"),
            // DB::raw("(CASE WHEN cata_up_m_c.upload_date IS NULL THEN '' WHEN cata_up_m_c.upload_date = '0000-00-00' THEN '' ELSE DATE_FORMAT(cata_up_m_c.upload_date , '%d-%m-%Y') END) AS upload_date"),
        )->get()->toArray();


        $data1 = CatalogTimeHash::where('allocation_id', $allocation_id)->get()->first()->toArray();
        $time_has_data = [];

        $time_has_data['allocation_id'] = $data1['allocation_id'];
        $time_has_data['created_at'] = $data1['created_at'];
        $time_has_data['start_time'] = $data1['start_time'];
        $time_has_data['end_time'] = $data1['end_time'];
        $time_has_data['ini_start_time'] = $data1['ini_start_time'];
        $time_has_data['ini_end_time'] = $data1['ini_end_time'];
        $time_has_data['is_rework'] = $data1['is_rework'];
        $time_has_data['is_started'] = $data1['is_started'];
        $time_has_data['pause_time'] = $data1['pause_time'];
        $time_has_data['task_status'] = $data1['task_status'];
        $tot_spent = $data1['spent_time'];
        $spent_time_is = ($tot_spent != 0 && $tot_spent != "") ? get_date_time($tot_spent) : "";
        $time_has_data['spent_time'] = $spent_time_is;
        // dd($time_has_data);
        $data = json_encode(
            array(
                "response" => $response,
                "time_has_data" => $time_has_data,
                "spent_time_is" => $spent_time_is,
            )
        );
        return $data;
    }

    // get_sub_Marketplace_count

    public static function get_sub_Marketplace_count($allocation_ids, $market_place_ids)
    {
        $market_place_ids = explode(',', $market_place_ids);
        $allocation_ids_list = explode(',', $allocation_ids);
        $response = Marketplace::leftJoin(
            'catalog_uploaded_marketplace_counts as cata_up_m_c',
            function ($join) use ($allocation_ids_list) {
                $join->on('cata_up_m_c.marketplace_id', '=', 'marketplaces.id');
                $join->whereIn('cata_up_m_c.allocation_id', $allocation_ids_list)
                ->orWhere('cata_up_m_c.allocation_id', '=', NULL);
            }
        )->whereIn('marketplaces.id', $market_place_ids)->select(
            DB::raw('(CASE WHEN cata_up_m_c.id IS NULL THEN 0 ELSE cata_up_m_c.id END) AS uploaded_Marketplace_id'),
            'marketplaces.id as marketplace_id',
            'marketplaces.marketPlace_name',
            DB::raw("(CASE WHEN cata_up_m_c.approved_Count IS NULL THEN 0 ELSE cata_up_m_c.approved_Count END) AS approved_Count"),
            DB::raw("(CASE WHEN cata_up_m_c.rejected_Count IS NULL THEN 0 ELSE cata_up_m_c.rejected_Count END) AS rejected_Count"),
            DB::raw("(CASE WHEN cata_up_m_c.upload_date IS NULL THEN '' WHEN cata_up_m_c.upload_date = '0000-00-00' THEN '' ELSE cata_up_m_c.upload_date END) AS upload_date"),
            // DB::raw("(CASE WHEN cata_up_m_c.upload_date IS NULL THEN '' WHEN cata_up_m_c.upload_date = '0000-00-00' THEN '' ELSE DATE_FORMAT(cata_up_m_c.upload_date , '%d-%m-%Y') END) AS upload_date"),
        )->
        // groupBy(['marketplaces.id'])->
        get()->toArray();
        $data_arr = [];
        foreach ($response as $key => $row) {
            $marketplace_id = $row['marketplace_id'];
            $marketPlace_name = $row['marketPlace_name'];
            $marketPlace_name = $row['marketPlace_name'];
            $approved_Count = $row['approved_Count'];
            $rejected_Count = $row['rejected_Count'];
            $upload_date = $row['upload_date'];
            // echo " <br><br> marketPlace_name => $marketPlace_name ,approved_Count => $approved_Count ,rejected_Count => $rejected_Count ";
            if (array_key_exists($marketPlace_name, $data_arr)) {
                $data_arr[$marketPlace_name]['approved_Count'] =  $data_arr[$marketPlace_name]['approved_Count'] + $approved_Count;
                $data_arr[$marketPlace_name]['rejected_Count'] = $data_arr[$marketPlace_name]['rejected_Count'] + $rejected_Count;
                if ($data_arr[$marketPlace_name]['upload_date'] < $upload_date) {
                    $data_arr[$marketPlace_name]['upload_date'] = $upload_date;
                }
            } else {
                // $data_arr[$marketPlace_name] = [];
                $data_arr[$marketPlace_name]['marketplace_id'] = $marketplace_id;
                $data_arr[$marketPlace_name]['marketPlace_name'] = $marketPlace_name;
                $data_arr[$marketPlace_name]['approved_Count'] = $approved_Count;
                $data_arr[$marketPlace_name]['rejected_Count'] = $rejected_Count;
                $data_arr[$marketPlace_name]['upload_date'] = $upload_date;
            }
        }

        $data = json_encode($data_arr);
        return $data;
    }

    public static function save_Marketplace_approved_Count($request){

        $allocation_id_is = $request->allocation_id_is;
        $data_arr = $request->data_arr;
        $market_place_id_is = $request->market_place_id_is;
        $action = $request->action;

        $response = 0;
        $res_arr = [];
        $end_time_is = '';
        $up_status = '';
        $spent_time_is = '';
        $massage = "Somthing went Wrong please try again!!!";

        $resuploaded_Marketplace_id = [];
        DB::beginTransaction();
        try {

            foreach ($data_arr as $data) {
                $uploaded_Marketplace_id    = $data['uploaded_Marketplace_id'];
                $marketplace_id             = $data['marketPlace_id'];
                $approved_Count             = $data['approved_Count'] == '' ? '' : $data['approved_Count'];
                $rejected_Count             = $data['rejected_Count'] == '' ? '' : $data['rejected_Count'];
                $upload_date                = $data['upload_date'] == '' ? '' : $data['upload_date'];
                // dd($data);
                if ($uploaded_Marketplace_id > 0) {
                    $storeData = CatalogUploadedMarketplaceCount::find($uploaded_Marketplace_id);
                    $storeData->allocation_id = $allocation_id_is;
                    $storeData->marketplace_id = $marketplace_id;
                    $storeData->approved_Count = $approved_Count;
                    $storeData->rejected_Count = $rejected_Count;
                    $storeData->upload_date = $upload_date;
                    $status = $storeData->update();
                    $massage = "Marketplace Count updated!!!";
                } else {
                    $massage = "Marketplace Count Saved!!!";

                    $saveData = new CatalogUploadedMarketplaceCount();

                    // dd($saveData);
                    $saveData->allocation_id = $allocation_id_is;
                    $saveData->marketplace_id = $marketplace_id;
                    $saveData->approved_Count = $approved_Count;
                    $saveData->rejected_Count = $rejected_Count;
                    $saveData->upload_date = $upload_date;
                    $status = $saveData->save();
                    if ($status) {
                        $uploaded_Marketplace_id = $saveData->id;
                    }
                }

                $resuploaded_Marketplace_id['uploaded_Marketplace_id' . $marketplace_id] = $uploaded_Marketplace_id;
                array_push($res_arr, $status);
            }

            if (array_sum($res_arr) == count($res_arr)) {

                

                $timeHashData = CatalogTimeHash::where('allocation_id', $allocation_id_is)->get()->first();
                $old_spent_time = $timeHashData->spent_time;
                $is_started = $timeHashData->is_started;
                $old_spent_time = $old_spent_time == "" ? 0 : (int)$old_spent_time;

                $spent_time_is = ($old_spent_time != 0 && $old_spent_time != "") ? get_date_time($old_spent_time) : "";
                // dd($timeHashData);
                if ($status != 0 && $action == 'comp') {
                    $old_start_time = $timeHashData->start_time;
                    $end_time = date('Y-m-d H:i:s');
                    $ini_start_time = $timeHashData->ini_start_time;
                    $ini_end_time = $timeHashData->ini_end_time;

                    if ($ini_start_time == '' || $ini_start_time == '0000-00-00 00:00:00') {
                        $ini_start_time = $old_start_time;
                    }

                    if ($ini_end_time == '' || $ini_end_time == '0000-00-00 00:00:00') {
                        $ini_end_time = $end_time;
                    }
                    $new_spent_time = (new Carbon($end_time))->diffInSeconds(new Carbon($old_start_time));

                    if ($is_started == 1) {
                        $new_spent_time = 0;
                    }

                    $tot_spent = $old_spent_time + $new_spent_time;

                    $up_status = CatalogTimeHash::where('allocation_id', $allocation_id_is)->update([
                        'end_time' => $end_time,
                        'ini_start_time' => $ini_start_time,
                        'ini_end_time' => $ini_end_time,
                        'spent_time' => $tot_spent,
                        'task_status' => 1,
                        'is_rework' => 0,
                        'is_started' => 0,
                    ]);
                    if ($up_status) {
                        $end_time_is = date('Y-m-d h:i:s A', strtotime($end_time));
                        $massage = "Marketplace Count Saved!! Wrc Completed";

                        $spent_time_is = ($tot_spent != 0 && $tot_spent != "") ? get_date_time($tot_spent) : "";
                    }

                }
                DB::commit();
                $response = 1;
            } else {
                DB::rollback();
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
        
        return json_encode(array(
            'status' => $status,
            'up_status' => $up_status,
            'response' => $response,
            'res_arr' => $res_arr,
            'end_time' => $end_time_is,
            'spent_time_is' => $spent_time_is,
            'resuploaded_Marketplace_id' => $resuploaded_Marketplace_id,
            'massage' => $massage,
        ));


        // return $request->allocation_id_is;
    }


   
}
