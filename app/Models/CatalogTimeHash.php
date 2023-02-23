<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogTimeHash extends Model
{
    use HasFactory;
    protected $table = 'catalog_time_hash';
    protected $fillable = [
        'allocation_id', 'start_time' , 'end_time'
    ];

    public static function set_task_start($allocation_id, $start_time , $login_user_id_is = 0){

        $time_has_id = CatalogTimeHash::where('allocation_id', $allocation_id)->get(['id'])->first();
        $allocated_time_has_id = $time_has_id != null ?  $time_has_id->id : 0;

        $started_task_by_user = 0;
        // dd($allocated_time_has_id);
        // SELECT `id`, `allocation_id`, `start_time`, `end_time`, `ini_start_time`, `ini_end_time`, `task_status`, `is_rework`, `rework_count`, `spent_time`, `created_at`, `updated_at` FROM `catalog_time_hash` WHERE 1
        
        if($login_user_id_is > 0){
            $allocation_id_list = CatalogAllocation::where('user_id', '=' , $login_user_id_is)->select('id', 'wrc_id')->get()->pluck('id')->toArray();

            $CatalogTimeHash_list = CatalogTimeHash::
            where('is_started', '=' ,0)->
            where('task_status', '=', 0)->
            where('is_rework', '=', 0)->
            whereIn('allocation_id', $allocation_id_list)->get(['allocation_id'])->toArray();
            // dd($CatalogTimeHash_list);
            $started_task_by_user = count($CatalogTimeHash_list);
        }

        if($started_task_by_user > 0){
            $status = 2; // Wrc already started;
        }else{
            if ($allocated_time_has_id > 0) {
                $storeData = CatalogTimeHash::find($allocated_time_has_id);
                $storeData->start_time = $start_time;
                $storeData->is_started = 0;
                $storeData->is_rework = 0;
                $status = $storeData->update();
            }else{
                $CatalogTimeHash = new CatalogTimeHash();
                $CatalogTimeHash->allocation_id = $allocation_id;
                $CatalogTimeHash->start_time = $start_time;
                $CatalogTimeHash->end_time = '';
                $CatalogTimeHash->pause_time = '';
                $CatalogTimeHash->ini_start_time = $start_time;
                $CatalogTimeHash->ini_end_time = '';
                $CatalogTimeHash->task_status = 0;
                $CatalogTimeHash->is_started = 0;
                $CatalogTimeHash->is_rework = '';
                $CatalogTimeHash->rework_count = '';
                $CatalogTimeHash->spent_time  = 0;
                $status = $CatalogTimeHash->save();
            }
        }
        return $status;
    }

    public static function set_task_pause($allocation_id, $time)
    {

        $storeData = CatalogTimeHash::where('allocation_id', $allocation_id)->get()->first();
        $old_spent_time = $storeData->spent_time;
        $old_spent_time = $old_spent_time == "" ? 0 : (int)$old_spent_time;

        $ini_start_time = $storeData->ini_start_time;
        $old_start_time = $storeData->start_time;
        if ($ini_start_time == '' || $ini_start_time == '0000-00-00 00:00:00') {
            $ini_start_time = $old_start_time;
        }

        $new_spent_time = (new Carbon($time))->diffInSeconds(new Carbon($old_start_time));
        $tot_spent = $old_spent_time + $new_spent_time;

        $spent_time_is = ($tot_spent != 0 && $tot_spent != "") ? get_date_time($tot_spent) : "";

        $status = CatalogTimeHash::where('allocation_id', $allocation_id)->update([
            'ini_start_time' => $ini_start_time,
            'spent_time' => $tot_spent,
            'pause_time' => $time,
            'is_started' => 1,
        ]);

        $response = array(
            'status' => $status,
            'spent_time' => $spent_time_is,
            'pause_time' => date('Y-m-d h:i:s A', strtotime($time))
        );
        return json_encode($response);
        
         
    }
}
