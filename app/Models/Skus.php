<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Skus extends Model {

    use HasFactory,
        LogsActivity;

    protected $fillable = [
        'user_id',
        'brad_id',
        'lot_id',
        'wrc_id',
        'sku_code', 'brand', 'gender', 'category', 'sku_c', 'status',
    ];
    protected $table = 'sku';

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults();
    }

    public static function getskuInfo($filter = []) {

        $wheerArr = [];
        if (isset($filter['wrc_id'])) {
            $wheerArr[] = ['sku.wrc_id', '=', $filter['wrc_id']];
        }
        if (isset($filter['sku_id'])) {
            $wheerArr[] = ['sku.id', '=', $filter['sku_id']];
        }
        if (isset($filter['user_id'])) {
            $wheerArr[] = ['users.id', '=', $filter['user_id']];
        }
        if (isset($filter['brand_id'])) {
            $wheerArr[] = ['brands.id', '=', $filter['brand_id']];
        }
        if (isset($filter['lot_id'])) {
            $wheerArr[] = ['lots.id', '=', $filter['lot_id']];
        }
        if (isset($filter['status'])) {
            $wheerArr[] = ['sku.status', '=', $filter['status']];
        }
        if (isset($filter['sku_code'])) {
            $wheerArr[] = ['sku.sku_code', '=', $filter['sku_code']];
        }
        $result = DB::table('sku')
                ->join('brands', 'brands.id', '=', 'sku.brand_id')
                ->join('users', 'users.id', '=', 'sku.user_id')
                ->join('lots', 'lots.id', '=', 'sku.lot_id')
                ->join('wrc', 'wrc.id', '=', 'sku.wrc_id')
                ->select('sku.id', 'sku.sku_code', 'sku.created_at', 'wrc.wrc_id', 'sku.lot_id', 'brands.name', 'users.Company', 'sku.category','sku.subcategory', 'sku.brand','sku.status' ,'sku.gender')
                ->where('sku.sku_code','!=', Null)
                ->where($wheerArr)
                ->orderBy('wrc.id', 'DESC');
        if (isset($filter['count'])) {
            return $result->count();
        }
        if (isset($filter['single'])) {
            return $result->first();
        }
        return $result->get();
    }

    // get editor Submission Info 
    public function editorSubmissionInfo(){
		return $this->hasMany('App\Models\Wrc','lot_id','id')->with('getWrcSkus:id,lot_id,wrc_id,sku_code,user_id,brand_id');
	}

}
