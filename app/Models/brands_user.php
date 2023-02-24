<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use DB;
class Brands_user extends Model
{
    use HasFactory, LogsActivity;
    protected $primaryKey = 'id';
    protected $table = 'brands_user';
    protected $fillable = ["user_id","brand_id"];

    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

   
     public static function pending(){
            $result = DB::table('brands')
            ->join('brands_user', 'brands_user.brand_id', '=', 'brands.id','left')
            ->where('brand_id','=',NULL)
              ->whereDate('brands.created_at', '>=', '22-4-1');
        return  $result->get(); 

    }

    public function getBrandName(){
		return $this->hasOne('App\Models\Brands','id','brand_id');
	}
}
