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

        $lot_detail = Lots::where('lots.id',$id)->
        leftjoin('users' ,'users.id' , 'lots.user_id' )->
        leftjoin('brands' , 'brands.id' , 'lots.brand_id')->
        select('lots.id',
        'lots.id as lot_id', 
        'lots.s_type as s_type', 
        'lots.created_at as lot_created_at',
        DB::raw("DATE_FORMAT(lots.created_at, '%d-%m-%Y') as lots_formatted_date"),
        'users.Company as company_name',
        'users.c_short as company_c_short',
        'brands.name as brand_name',
        'brands.short_name as brand_short_name',
        'lots.lot_id as lot_number',
        'lots.created_at')->get()->toArray(); 

        $wrc_count = Wrc::where('lot_id',$id)->count();

        $shoot_lot_statusArr = shoot_lot_statusArr();
        $lot_status = $wrc_count > 0 ? $shoot_lot_statusArr[1] : $shoot_lot_statusArr[0];
        
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
        $lot_detail[0]['file_path'] =  '';
        $lot_detail[0]['skus_count'] =  0;
        $lot_detail[0]['raw_images'] =  '';
        $lot_detail[0]['edited_images'] =  '';
        // $lot_detail[0]['s_type'] =  '';
        $lot_detail[0]['wrc_numbers'] =  '';

        
        $wrc_info = [];
        if($wrc_count > 0){            
            $lot_info_with_wrc_query = Lots::where('lots.id',$id)->leftJoin('wrc', 'wrc.lot_id', 'lots.id')->leftJoin('commercial', 'commercial.id', 'wrc.commercial_id');
            $wrc_info = $lot_info_with_wrc_query->select(
                'lots.id', 
                'lots.lot_id as lot_number', 
                'lots.created_at',
                'lots.created_at as lot_created_at',
                DB::raw("DATE_FORMAT(lots.created_at, '%d-%m-%Y') as lots_formatted_date"),
                DB::raw("CONCAT(commercial.product_category, ', ', commercial.type_of_shoot, ', ', commercial.type_of_clothing, ', ', commercial.gender, ', ', commercial.adaptation_1) as tags"),
                'commercial.product_category',
                'commercial.type_of_shoot',
                'commercial.type_of_clothing',
                'commercial.gender',
                'commercial.adaptation_1 as primary_adaptation',
                'commercial.adaptation_1',
                'commercial.adaptation_2',
                'commercial.adaptation_3',
                'commercial.adaptation_4',
                'commercial.adaptation_5',
                'commercial.commercial_value_per_sku',
                'wrc.id as wrc_id',
                'wrc.wrc_id as wrc_number',
                'wrc.created_at as wrc_created_at',
                DB::raw("DATE_FORMAT(wrc.created_at, '%d-%m-%Y') as wrc_formatted_date"),
            )->get()->toArray();
            $tot_sku_count  = 0;
            $submited_wrc = 0;
            $wrc_id_arr = array();
            // dd($wrc_info , $lot_detail);
            foreach($wrc_info as $key => $val){
                $sku_info_query = Skus::where('wrc_id', $val['wrc_id']);
                // $sku_info_query = Skus::where('wrc_id', $val['wrc_id'])->where('status', 1);
                $sku_count = $sku_info_query->count();
                $tot_sku_count += $sku_count;
                $wrc_info[$key]['wrc_order_qty'] =  $sku_count;
                $wrc_info[$key]['wrc_qc_qty'] =  '';
                $wrc_info[$key]['qc_status'] =  'pending';
                $wrc_info[$key]['submission_status'] =  'pending';
                $wrc_info[$key]['submission_date'] =  '';
                $wrc_info[$key]['service'] =  'SHOOT';

                $file_path = '';


                $rejected_skus = Skus::where('wrc_id', $val['wrc_id'])->where('status', '=' , 0)->count();
                $wrc_info[$key]['rejected_skus'] =  $rejected_skus;                
                $adaptation_arr = array();

                for($i = 1; $i <= 5 ; $i++){
                    $adaptation_key = 'adaptation_'.$i;
                    if($val[$adaptation_key] != 'NA' && $val[$adaptation_key] != null){
                        array_push($adaptation_arr , $val[$adaptation_key]);
                    }
                    unset($wrc_info[$key][$adaptation_key]);
                }
                $wrc_info[$key]['adaptation'] = $adaptation_arr;
                
                $lot_detail[0]['inward_quantity'] = $tot_sku_count;
                $lot_detail[0]['wrc_created_at'] = $val['wrc_created_at'];

                if($sku_count > 0){
                    $sku_info = $sku_info_query->pluck('id')->toarray();

                    $upload_raw_info = uploadraw::whereIn('sku_id', $sku_info)->get()->toArray();
                    $upload_raw_info_id = [];
                    if(count($upload_raw_info) > 0){
                        $lot_detail[0]['allocated_created_at'] = $upload_raw_info[0]['created_at'];
                        $lot_detail[0]['lot_status']  = $shoot_lot_statusArr[2];
                        $lot_detail[0]['overall_progress']  = 60;
                        $lot_detail[0]['wrc_assign']  = "20";
                        $upload_raw_info_id = array_column($upload_raw_info, 'id');
                    }

                    $allocation_info = allocation::whereIn('uploadraw_id', $upload_raw_info_id)->get()->toArray();

                    // $editor_qc_info = editorSubmission::whereIn('sku_id', $sku_info)->where('editor_submission.qc' , '=' , '1')->orderby('editor_submission.filename' , 'ASC')->get()->toArray();
                    $editor_qc_info = editorSubmission::whereIn('sku_id', $sku_info)->where('editor_submission.qc' , '=' , '1')->orderby('editor_submission.filename' , 'DESC')->groupby('editor_submission.sku_id')->get()->toArray();
                    
                    
                    if(count($editor_qc_info) > 0){
                        $lot_detail[0]['lot_status']  = $shoot_lot_statusArr[3];
                        $lot_detail[0]['overall_progress']  = 80;
                        $lot_detail[0]['wrc_qc']  = "20";
                        $lot_detail[0]['qc_done_at'] = $editor_qc_info[0]['created_at'];
                        
                        $wrc_info[$key]['qc_status'] =  'Done';
                        $wrc_info[$key]['wrc_qc_qty'] =  count($editor_qc_info);
                        
                        $lot_submission_query = submissions::where('submission.wrc_id', '=', $val['wrc_id'])->select('id as submission_id', 'submission.submission_date');
                        $lot_submission_count = $lot_submission_query->count();
                        if($lot_submission_count > 0){
                            array_push($wrc_id_arr , $val['wrc_id']);
                            $submited_wrc += 1;

                            $submission_data = $lot_submission_query->get()->toArray();
                            
                            $wrc_info[$key]['submission_status'] =  'Done';
                            $wrc_info[$key]['submission_date'] =  $submission_data[0]['submission_date'];

                        }

                        if($submited_wrc == count($wrc_info)){
                            $lot_submission_data= submissions::whereIn('submission.wrc_id', $wrc_id_arr)->select('id as submission_id', 'submission.submission_date')->orderByDesc('submission.submission_date')->get()->toArray();
                            $lot_detail[0]['lot_status']  = $shoot_lot_statusArr[4];
                            $lot_detail[0]['overall_progress']  = 100;
                            $lot_detail[0]['wrc_submission']  = "20";
                            $lot_detail[0]['submission_date'] = $lot_submission_data[0]['submission_date'];

                        }
                    }
                }
                $wrc_info[$key]['file_path'] =  $file_path;
            }
            $lot_detail[0]['skus_count'] =  $tot_sku_count;
            // dd($wrc_count, $lot_detail , $wrc_info);

            $wrc_id_arr = array_column($wrc_info, 'wrc_id');
            $wrc_number_arr = array_column($wrc_info, 'wrc_number');
            $wrc_numbers = implode(',',$wrc_number_arr);
            $sku_info_query = Skus::whereIn('sku.wrc_id', $wrc_id_arr)->where('status', 1)->select('id as sku_id', 'wrc_id', 'sku_code', 'status');
            $skus_count = $sku_info_query->count();
            $skus_array = $sku_info_query->get()->toArray();
            if($skus_count > 0){
                $file_path = "";
                $lot_number = $lot_detail[0]['lot_number'];
                $skus_sku_id_arr = array_column($skus_array , 'sku_id');
                $skus_sku_code_arr = array_column($skus_array , 'sku_code' , 'sku_id');

                $upload_raw_count = uploadraw::whereIn('sku_id', $skus_sku_id_arr)->count();
                $editor_Submission_count = editorSubmission::wherein('sku_id' , $skus_sku_id_arr)->where('qc','=','1')->count();

                $lot_detail[0]['raw_images'] =  $upload_raw_count;
                $lot_detail[0]['edited_images'] =  $editor_Submission_count;

                if($file_path == ''){
                    $editor_Submission_data = editorSubmission::wherein('sku_id' , $skus_sku_id_arr)->where('qc','=','1')->where('filename', 'LIKE', '%_1.%')->get()->toArray();
                    foreach ($editor_Submission_data as $key_is => $item) {
                        if($file_path != ""){
                            break;
                        }            
                        $adaptation = $item['adaptation'];
                        $sku_id = $item['sku_id'];
                        $sku_code = $skus_sku_code_arr[$item['sku_id']];
                        
                        foreach ($wrc_number_arr as $key => $wrc_number) {
                            if($file_path != ""){
                                break;
                            }   
                            $path=  "edited_img_directory/". date('Y', strtotime($item['created_at'])) . "/" . date('M', strtotime($item['created_at'])) . "/" . $lot_number."/" . $wrc_number."/" . $adaptation. "/" .$sku_code. "/" . $item['filename'];


                            if(file_exists($path)){
                                $file_path = $path;
                            }
                        }

                    }
                    $lot_detail[0]['file_path'] =  $file_path;

                    // if($lot_detail[0]['id'] == 3744){
                    //     dd($wrc_number_arr, $upload_raw_data ,$file_path , $lot_detail[0]); 
                    // }
                }
                
                if($file_path == ''){
                    $upload_raw_query = uploadraw::whereIn('sku_id', $skus_sku_id_arr)->where('filename', 'LIKE', '%_1.%')->groupby('sku_id')->groupby('filename');
                    $upload_raw_count = $upload_raw_query->count();
                    $upload_raw_data = $upload_raw_query->get()->toArray();
    
                    foreach ($upload_raw_data as $key_is => $raw_data) {
                        if($file_path != ""){
                          break;
                        }
                        $sku_id = $raw_data['sku_id'];
                        $sku_code = $skus_sku_code_arr[$raw_data['sku_id']];
                        $created_at = $raw_data['created_at'];
                        $filename = $raw_data['filename'];
    
                        foreach ($wrc_number_arr as $key => $wrc_number) {
                            if($file_path != ""){
                                break;
                            }
                            $path =  "raw_img_directory/" . date('Y', strtotime($created_at)) . "/" . date('M', strtotime($created_at)) . "/" . $lot_number."/" . $wrc_number."/" . $sku_code."/" . $filename;
                            if(file_exists($path)){
                              $file_path = $path;
                            }
                        }
              
                    }
                }
            }        
            $lot_detail[0]['wrc_numbers'] =  $wrc_numbers;
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
