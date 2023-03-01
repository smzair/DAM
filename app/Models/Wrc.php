<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Carbon\Carbon;

class Wrc extends Model {

    use HasFactory,
        LogsActivity;

    protected $fillable = [
        'lot_id',
        'wrc_id',
        'commercial_id'
    ];
    protected $table = 'wrc';

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults();
    }

    public static function getwrcInfo($filter = []) {
        $wheerArr = [];
        if (isset($filter['lot_id'])) {
            $wheerArr[] = ['wrc.lot_id', '=', $filter['lot_id']];
        }
        if (isset($filter['initialised'])) {
            $wheerArr[] = ['wrc.initialised', '=', $filter['initialised']];
        }
        if (isset($filter['id'])) {
            $wheerArr[] = ['wrc.id', '=', $filter['id']];
        }
          if (isset($filter['lotid'])) {
            $wheerArr[] = ['wrc.lot_id', '=', $filter['lotid']];
        }
              if(isset($filter['wrc_current_AR']) && $filter['wrc_current_AR']){
            $wheerArr[] = ['wrc.Client_AR', '=' , NULL];
        }
        if(isset($filter['wrc__approved']) && $filter['wrc__approved']){
            $wheerArr[] = ['wrc.Client_AR', '=' , 1];
        }
        if(isset($filter['wrc_rejected']) && $filter['wrc_rejected']){
            $wheerArr[] = ['wrc.Client_AR', '=' , 0];
        }
        $result = DB::table('wrc')
                ->join('brands', 'brands.id', '=', 'wrc.brand_id')
                ->join('users', 'users.id', '=', 'wrc.user_id')
                ->join('lots', 'lots.id', '=', 'wrc.lot_id')
                ->join('sku','sku.wrc_id','=','wrc.id')
                ->join('commercial', 'commercial.id', '=', 'wrc.commercial_id')
                ->select('wrc.id','lots.created_at as inward','lots.id as lotId', 'lots.lot_id', 'lots.clientBucket','lots.verticleType','lots.location','lots.s_type','lots.shoothandoverDate','wrc.wrc_id', 'wrc.status', 'wrc.created_at', 'brands.name','users.am_email', 'users.Company','wrc.ppt_approval','wrc.model_approval','wrc.special_approval','wrc.inward_sheet', 'users.client_id', 'commercial.product_category', 'commercial.type_of_shoot', 'commercial.type_of_clothing', 'commercial.gender','commercial.flat_shot','commercial.extra_mood_shot','commercial.commercial_value_per_sku as com', 'commercial.adaptation_1', "wrc.initialised", 'commercial.adaptation_2', 'commercial.adaptation_3', 'commercial.adaptation_4', 'commercial.adaptation_5', 'wrc.Client_AR','wrc.Invoice_no','sku.sku_code','wrc.edt_rejection')
                ->where($wheerArr)
                ->groupBy('wrc.id')
                ->orderBy('wrc.created_at', 'DESC');

        if (isset($filter['single'])) {
            return $result->first();
        }
        if(isset($filter['date'])){
           return $result->whereDate('created_at', '>=' ,Carbon::now()->subDays(4));
        }

        return $result->get();
    }

    
    public static function getwrcTAT($filter = []) {
        $wheerArr = [];
        if (isset($filter['lot_id'])) {
            $wheerArr[] = ['wrc.lot_id', '=', $filter['lot_id']];
        }
        if (isset($filter['initialised'])) {
            $wheerArr[] = ['wrc.initialised', '=', $filter['initialised']];
        }
        if (isset($filter['id'])) {
            $wheerArr[] = ['wrc.id', '=', $filter['id']];
        }
          if (isset($filter['lotid'])) {
            $wheerArr[] = ['wrc.lot_id', '=', $filter['lotid']];
        }
              if(isset($filter['wrc_current_AR']) && $filter['wrc_current_AR']){
            $wheerArr[] = ['wrc.Client_AR', '=' , NULL];
        }
        if(isset($filter['wrc__approved']) && $filter['wrc__approved']){
            $wheerArr[] = ['wrc.Client_AR', '=' , 1];
        }
        if(isset($filter['wrc_rejected']) && $filter['wrc_rejected']){
            $wheerArr[] = ['wrc.Client_AR', '=' , 0];
        }
        $result = DB::table('wrc')
                ->join('brands', 'brands.id', '=', 'wrc.brand_id')
                ->join('users', 'users.id', '=', 'wrc.user_id')
                ->join('lots', 'lots.id', '=', 'wrc.lot_id')
                ->join('sku','sku.wrc_id','=','wrc.id')
                  ->join('uploadraw','uploadraw.sku_id','=','sku.id')
                ->join('commercial', 'commercial.id', '=', 'wrc.commercial_id')
                ->select('wrc.id','lots.created_at as inward','lots.id as lotId', 'uploadraw.created_at as uraw' ,'lots.lot_id', 'lots.clientBucket','lots.verticleType','lots.location','lots.s_type','lots.shoothandoverDate','wrc.wrc_id', 'wrc.status', 'wrc.created_at', 'brands.name','users.am_email', 'users.Company','wrc.ppt_approval','wrc.model_approval','wrc.special_approval','wrc.inward_sheet', 'users.client_id', 'commercial.product_category', 'commercial.type_of_shoot', 'commercial.type_of_clothing', 'commercial.gender','commercial.flat_shot','commercial.extra_mood_shot','commercial.commercial_value_per_sku as com', 'commercial.adaptation_1', "wrc.initialised", 'commercial.adaptation_2', 'commercial.adaptation_3', 'commercial.adaptation_4', 'commercial.adaptation_5', 'wrc.Client_AR','wrc.Invoice_no','sku.sku_code','wrc.edt_rejection')
                ->where($wheerArr)
                ->groupBy('wrc.id')
                ->orderBy('wrc.created_at', 'DESC');

        if (isset($filter['single'])) {
            return $result->first();
        }
        if(isset($filter['date'])){
           return $result->whereDate('created_at', '>=' ,Carbon::now()->subDays(4));
        }

        return $result->get();
    }

    


    public static function pending() {
        $result = DB::table('wrc')
                ->join('sku', 'sku.wrc_id', '=', 'wrc.id', 'left')
                ->where('sku.wrc_id', '=', Null);
        return $result->get();
    }

    // Get uploded Wrcs skus
    public function getWrcSkus(){
		return $this->hasMany('App\Models\Skus','wrc_id','id');
	}

}
