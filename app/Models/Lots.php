<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
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
        $result = DB::table('lots')
                ->join('users', 'users.id', '=', 'lots.user_id')
                ->join('brands', 'brands.id', '=', 'lots.brand_id')
                ->select('lots.lot_id', 'lots.brand_id', 'lots.user_id', 'lots.status', 'users.Company', 'users.c_short', 'users.client_id', 'brands.name', 'brands.short_name', 'lots.id', 'lots.s_type','lots.verticleType','users.am_email','lots.clientBucket','lots.location','lots.shoothandoverDate', 'lots.created_at')
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

    

}
