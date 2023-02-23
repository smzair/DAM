<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class planDate extends Model
{
	use HasFactory,LogsActivity;


	protected $fillable=[
		'sku_id',
		'dayplan_id'
	];

	protected $table = 'shootplan';


	public function getActivitylogOptions(): LogOptions
	{
		return LogOptions::defaults();
	}


	public static function getplanInfo($filter = []){
		$wheerArr = [];
		if(isset($filter['dayplan_id'])){
			$wheerArr[] = ['shootplan.dayplan_id', '=' , $filter['dayplan_id']];
		}
		if(isset($filter['sku_id'])){
			$wheerArr[] = ['shootplan.sku_id', '=' , $filter['sku_id']];
		}
		if(isset($filter['wrc_id'])){
			$wheerArr[] = ['sku.wrc_id', '=' , $filter['wrc_id']];
		}
		if(isset($filter['created_at'])){
			$wheerArr[] = ['sku.created_at', '=' , $filter['created_at']];
		}
		$result = DB::table('shootplan')
		->join('sku','sku.id','=','shootplan.sku_id')
		->join('dayplan','dayplan.id','=','shootplan.dayplan_id')
		->join('wrc','wrc.id','=','sku.wrc_id')
		->join('lots','lots.id','=','wrc.lot_id')
		->join('users','users.id','=','lots.user_id')
		->join('brands', 'brands.id', '=', 'lots.brand_id')
		->join('commercial','commercial.id','=','wrc.commercial_id')
		->select('shootplan.id', 'shootplan.sku_id', 'shootplan.dayplan_id', 'dayplan.stylist_charges', 'wrc.wrc_id', 'wrc.id as wrc_tbl_id','sku.id as sku_id', 'commercial.type_of_shoot','wrc.created_at','lots.location','commercial.product_category','commercial.type_of_clothing','sku.sku_code','sku.subcategory','sku.category','lots.lot_id','users.Company','brands.name','commercial.gender','commercial.adaptation_1','dayplan.date','dayplan.studio','dayplan.photographer','dayplan.stylist','dayplan.shoot_hour','dayplan.model_available','dayplan.model_charges','dayplan.assistant_charges','dayplan.makeup_charges','dayplan.photographer_charges','dayplan.extra_model_charges','dayplan.makeupartist','dayplan.rawqc','dayplan.model','dayplan.agency','dayplan.assistant','commercial.adaptation_2','commercial.adaptation_3','commercial.adaptation_4','commercial.adaptation_5','sku.status as sku_status','dayplan.date as shootdate','lots.s_type','users.am_email','sku.created_at')
		->where($wheerArr)
		->orderBy('wrc.created_at', 'desc')
	    ->orderBy('shootplan.dayplan_id', 'desc')
		->groupBy('shootplan.id');
		if(isset($filter['count'])){
			return $result->count();
		}
		if(isset($filter['single'])){
			return $result->first();
		}

		return $result->get();
	}

     public static function pending(){
        $result = DB::table('dayplan')
        ->join('shootplan', 'shootplan.dayplan_id', '=', 'dayplan.id' ,'left')
        ->where('shootplan.dayplan_id','=', Null);
         return $result->get();
    }

 public static function Skupending(){
        $result = DB::table('sku')
        ->join('shootplan', 'shootplan.sku_id', '=', 'sku.id' ,'left')
        ->where('shootplan.sku_id','=', Null);
         return $result->get();
    }


}
