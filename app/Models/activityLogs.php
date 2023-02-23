<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class activityLogs extends Model
{
    use HasFactory;

     protected $table = 'activity_log';

     public static function getLogs($filter = []){

        $whereArr = [];

        if(isset($filter['causer_id'])){
            $whereArr[] = ['activity_log.causer_id', '=' , $filter['causer_id']];
        }
      

         $result = DB::table('activity_log')
        ->join('users','users.id','=','activity_log.causer_id')
        ->select('activity_log.id', 'activity_log.log_name','activity_log.causer_id', 'activity_log.description', 'activity_log.subject_type', 'activity_log.event', 'activity_log.subject_id','activity_log.created_at','users.name')
        ->where($whereArr);
         
        if(isset($filter['group'])){
            $result->groupBy('activity_log.id')->get();
        }
        if(isset($filter['group_by'])){
            $result->groupBy($filter['group_by'])->get();
        }
        if(isset($filter['order_by'])){
            $result->orderBy('activity_log.id' ,$filter['order_by']);
        }
        if(isset($filter['count'])){
            return $result->count();
        }
        if(isset($filter['single'])){
            return $result->first();
        }
        if(isset($filter['paginate']) && is_numeric($filter['paginate'])){
            return $result->paginate((int) $filter['paginate']);
        }
        
        return  $result->get();

     }
}
