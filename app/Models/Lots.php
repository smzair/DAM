<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Lots extends Model {

    use HasFactory,
        LogsActivity;

    public function brands() {
        return $this->hasMany('App\User', 'client_id');
    }

    protected $fillable = ['Company_name', 'brands_id', 'lot_id'];
    protected $table = 'lots';

    public static function getlotInfo($filter = []) {
        $wheerArr = [];
        if (isset($filter['lot_id'])) {
            $wheerArr[] = ['lots.id', '=', $filter['lot_id']];
        }
        if (isset($filter['user_id'])) {
            $wheerArr[] = ['users.id', '=', $filter['user_id']];
        }
        if (isset($filter['brand_id'])) {
            $wheerArr[] = ['brands.id', '=', $filter['brand_id']];
        }
        if (isset($filter['status'])) {
            $wheerArr[] = ['lots.status', '=', $filter['status']];
        }
         if (isset($filter['com_status'])) {
            $wheerArr[] = ['lots.commercial_status', '=', $filter['com_status']];
        }
        $result = DB::table('lots')
                ->join('users', 'users.id', '=', 'lots.user_id')
                ->join('brands', 'brands.id', '=', 'lots.brand_id')
                ->select('lots.lot_id', 'lots.id','lots.brand_id', 'lots.user_id', 'lots.commercial_status','lots.status', 'users.Company', 'users.c_short', 'users.client_id', 'brands.name', 'brands.short_name', 'lots.id', 'lots.s_type','lots.verticleType','users.am_email','users.payment_term','lots.clientBucket','lots.location','lots.shoothandoverDate', 'lots.created_at')
                ->where($wheerArr)
                ->orderBy('lots.id', 'DESC');

        if (isset($filter['paginate'])) {
            return $result->paginate($filter['paginate'])->fragment('lots');
        }

        if (isset($filter['single'])) {
            return $result->first();
        }
        return $result->get();
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults();
    }

    public static function pending() {
        $result = DB::table('lots')
                        ->join('wrc', 'wrc.lot_id', '=', 'lots.id', 'left')->where('wrc.lot_id', '=', Null)->whereDate('wrc.created_at', '>=','2022-03-30');
        return $result->get();
    }
    public static function Inovices(){
         $result = DB::table('lots')
                ->join('users', 'users.id', '=', 'lots.user_id')
                ->join('brands', 'brands.id', '=', 'lots.brand_id')
                  ->join('wrc', 'wrc.lot_id', '=', 'lots.id')
                  ->join('commercial','wrc.commercial_id','=','commercial.id')
                ->select('lots.user_id', 'users.Company', 'brands.name',  'lots.id', 'lots.s_type','lots.verticleType','users.am_email', 'wrc.wrc_id','wrc.Invoice_no','lots.created_at','users.payment_term','commercial.commercial_value_per_sku')
                ->orderBy('lots.id', 'DESC');
        
         return $result->get();
    }

    // get Shoot Lots Wrcs 
    public function getShootWrc(){
		return $this->hasMany('App\Models\Wrc','lot_id','id')->with('getWrcSkus:id,lot_id,wrc_id,sku_code,user_id,brand_id');
	}

    // clients Editor Lot Timeline
    public static function LotTimeline($id){

        $lot_detail = Lots::where('lots.id',$id)->select('lots.id', 
        'lots.lot_id as lot_number',
        'lots.created_at')->get()->toArray(); 

        $wrc_count = Wrc::where('lot_id',$id)->count();

        $lot_status = $wrc_count > 0 ? 'WRC Generated' : 'Inward';
        $wrc_progress = $wrc_count > 0 ? '20' : '0';
        $overall_progress = $wrc_count > 0 ? '40' : '20';
        $lot_detail[0]['inward_quantity'] = 0;
        $lot_detail[0]['lot_status']  = $lot_status;
        $lot_detail[0]['overall_progress']  = $overall_progress;
        $lot_detail[0]['wrc_progress']  = $wrc_progress;
        $lot_detail[0]['wrc_assign']  = "0";
        $lot_detail[0]['wrc_qc']  = "0";
        $lot_detail[0]['wrc_submission']  = "0";
        $lot_detail[0]['allocated_created_at']  = null;
        $lot_detail[0]['qc_done_at']  = null;
        $lot_detail[0]['submission_date']  = null;
        
        $wrc_info = [];
        if($wrc_count > 0){            
            $lot_info_with_wrc_query = Lots::where('lots.id',$id)->leftJoin('wrc', 'wrc.lot_id', 'lots.id');
            $wrc_info = $lot_info_with_wrc_query->select(
                'lots.id', 
                'lots.lot_id as lot_number', 
                'lots.created_at',
                'wrc.id as wrc_id',
                'wrc.wrc_id as wrc_number',
                'wrc.created_at as wrc_created_at',
            )->get()->toArray();
            $tot_sku_count  = 0;
            foreach($wrc_info as $key => $val){
                $sku_info_query = Skus::where('wrc_id', $val['wrc_id'])->where('status', 1);
                $sku_count = $sku_info_query->count();
                $tot_sku_count += $sku_count;
                $wrc_info[$key]['wrc_order_qty'] =  $sku_count;
                $wrc_info[$key]['wrc_qc_qty'] =  $sku_count;
                $wrc_info[$key]['qc_status'] =  'pending';
                $wrc_info[$key]['submission_status'] =  'pending';

                $lot_detail[0]['inward_quantity'] = $tot_sku_count;
                $lot_detail[0]['wrc_created_at'] = $val['wrc_created_at'];
                
                if($tot_sku_count > 0){
                    $sku_info = $sku_info_query->pluck('id')->toarray();

                    $upload_raw_info = uploadraw::whereIn('sku_id', $sku_info)->get()->toArray();
                    $upload_raw_info_id = [];
                    if(count($upload_raw_info) > 0){
                        $lot_detail[0]['allocated_created_at'] = $upload_raw_info[0]['created_at'];
                        $lot_detail[0]['lot_status']  = 'Shoot started';
                        $lot_detail[0]['overall_progress']  = 60;
                        $lot_detail[0]['wrc_assign']  = "20";
                        $upload_raw_info_id = array_column($upload_raw_info, 'id');
                    }

                    $allocation_info = allocation::whereIn('uploadraw_id', $upload_raw_info_id)->get()->toArray();

                    $editor_qc_info = editorSubmission::whereIn('sku_id', $sku_info)->get()->toArray();
                    
                    if(count($editor_qc_info) > 0){
                        $lot_detail[0]['lot_status']  = 'Submissions Pending';
                        $lot_detail[0]['overall_progress']  = 80;
                        $lot_detail[0]['wrc_qc']  = "20";
                        $lot_detail[0]['qc_done_at'] = $editor_qc_info[0]['created_at'];
                        
                        $wrc_info[$key]['qc_status'] =  'Done';
                        $wrc_info[$key]['wrc_qc_qty'] =  count($editor_qc_info);

                        $editor_submission_info = editorSubmission::whereIn('sku_id', $sku_info)->where('qc', '2')->orderByDesc('updated_at')->get()->toArray();
                        
                        if(count($editor_submission_info) > 0 && count($editor_submission_info) == count($editor_qc_info) ){
                            $wrc_info[$key]['submission_status'] =  'Done';

                            $lot_detail[0]['lot_status']  = 'Submissions Done';
                            $lot_detail[0]['overall_progress']  = 100;
                            $lot_detail[0]['wrc_submission']  = "20";
                            $lot_detail[0]['submission_date'] = $editor_submission_info[0]['updated_at'];
                        }
                    }
                }
            }
            // dd($wrc_count, $lot_detail , $wrc_info);          
        }

        // insert into user activity log
        $data_array = array(
            'log_name' => 'Lot Timeline Details',
            'description' => 'Shoot Lot Timeline Details',
            'event' => 'Lot Timeline Details',
            'subject_type' => 'App\Models\CreatLots',
            'subject_id' => '0',
            'properties' => [],
        );
        // ClientActivityLog::saveClient_activity_logs($data_array);
        return array(
            'lot_detail' => $lot_detail,
            'wrc_detail' => $wrc_info,
        );
    }
}
