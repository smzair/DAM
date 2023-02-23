<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Carbon\Carbon;
use DB;


class uploadraw extends Model
{
    use HasFactory,LogsActivity;


    protected $fillable=[
        'sku_id',
        'filename'
    ];

    protected $table = 'uploadraw';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }


    public static function pending(){
        $result = DB::table('sku')
        ->join('uploadraw', 'uploadraw.sku_id', '=', 'sku.id' ,'left')
        ->where('uploadraw.sku_id','=', Null)
        ->whereDate('sku.created_at', '>=', '22-4-1');
         return $result->get();
    }



public static function shootcom(){

$result = DB::table('uploadraw')
        ->join('sku','sku.id','=','uploadraw.sku_id')
        ->join('wrc','wrc.id','=','sku.wrc_id')
        ->join('commercial','commercial.id','=','wrc.commercial_id')
        ->join('lots','lots.id','=','wrc.lot_id')
        ->join('users','users.id','=','lots.user_id')
        ->join('brands', 'brands.id', '=', 'lots.brand_id') 
 ->select('lots.lot_id', 'users.Company','users.client_id', 'users.name','brands.name as brand_name','wrc.wrc_id','sku.sku_code','uploadraw.id as uploadraw_id','uploadraw.filename', 'uploadraw.created_at','commercial.type_of_shoot','commercial.product_category','commercial.type_of_clothing','uploadraw.sku_id');

        return  $result->groupBy('sku_code')->get();
    
}



public static function shootDoneT($filter = []){
  $wheerArr = [];


$result = DB::table('uploadraw')
        ->join('sku','sku.id','=','uploadraw.sku_id')
        ->join('wrc','wrc.id','=','sku.wrc_id')
        ->join('commercial','commercial.id','=','wrc.commercial_id')
        ->join('lots','lots.id','=','wrc.lot_id')
        ->join('users','users.id','=','lots.user_id')
        ->join('brands', 'brands.id', '=', 'lots.brand_id') 
 ->select('lots.lot_id', 'users.Company','users.client_id', 'users.name','brands.name as brand_name','wrc.wrc_id','sku.sku_code','uploadraw.id as uploadraw_id','uploadraw.filename', 'uploadraw.created_at','commercial.type_of_shoot','commercial.product_category','commercial.type_of_clothing','uploadraw.sku_id')
 ->whereDate('uploadraw.created_at', '=',Carbon::today())
        ->orderBy('wrc.id', 'DESC') ;
        
        
        return  $result->get();
    }




public static function shootDone($wrcId){
 
$result = DB::table('uploadraw')
        ->join('sku','sku.id','=','uploadraw.sku_id')
        ->join('wrc','wrc.id','=','sku.wrc_id')
        ->join('commercial','commercial.id','=','wrc.commercial_id')
        ->join('lots','lots.id','=','wrc.lot_id')
        ->join('users','users.id','=','lots.user_id')
        ->join('brands', 'brands.id', '=', 'lots.brand_id') 
 ->select('lots.lot_id', 'users.Company','users.client_id', 'users.name','brands.name as brand_name','wrc.wrc_id','sku.sku_code','uploadraw.id as uploadraw_id','uploadraw.filename', 'uploadraw.created_at as uct','commercial.type_of_shoot','commercial.product_category','commercial.type_of_clothing','uploadraw.sku_id')
   ->where(['wrc.id' => $wrcId])->Orderby('uploadraw.sku_id');
    
    if(isset($filter['date'])){
            return $result ->whereDate('uploadraw.created_at', '=',Carbon::today())
        ->orderBy('wrc.id', 'DESC')->get() ;
        }
        
        return  $result->groupBy('sku_code')->get();
    }
}


