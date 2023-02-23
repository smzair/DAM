<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Commercials extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable=['user_id',
    'brand_id',
    'product_category',
    'type_of_shoot',
    'type_of_clothing',
    'gender',
    'adaptation_1',
    'adaptation_2',
    'adaptation_3',
    'adaptation_4',
    'adaptation_5',
    'specfic_apdatation',
    'commercial_value_per_sku'];

    protected $table = 'commercial';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public static function getComInfo($filter = []){
        $wheerArr = [];
        if(isset($filter['commercial'])){
            $wheerArr[] = ['commercial.id', '=' , $filter['commercial_id']];
        }
        if(isset($filter['user_id'])){
            $wheerArr[] = ['users.id', '=' , $filter['user_id']];
        }
        if(isset($filter['brand_id'])){
            $wheerArr[] = ['brands.id', '=' , $filter['brand_id']];
        }
        $result = DB::table('commercial')
        ->join('users','users.id','=','commercial.user_id')
        ->join('brands', 'brands.id', '=', 'commercial.brand_id')
        ->select('commercial.id','users.Company','users.client_id','brands.name','commercial.product_category','commercial.specfic_adaptation','commercial.created_at','commercial.type_of_shoot','commercial.type_of_clothing','commercial.gender','commercial.adaptation_1','commercial.adaptation_2','commercial.adaptation_3','commercial.adaptation_4','commercial.adaptation_5','commercial.commercial_value_per_sku')
        ->where($wheerArr)
        ->orderBy('commercial.id', 'asc');
        if(isset($filter['single'])){
            return $result->first();
        }

        return $result->get();
    }

    public static function pending(){
        $result = DB::table('commercial')
        ->join('wrc', 'wrc.commercial_id', '=', 'commercial.id','left')
        ->where('commercial_id','=', NULL);

         return $result->get();
    }

}
