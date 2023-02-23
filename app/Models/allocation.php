<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class allocation extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'allocation';
    
    
    
    
    public static function ReadyAllocation($filter = []){
        $wheerArr = [];
        
        if(isset($filter['skip_alloted']) && $filter['skip_alloted']){
            $wheerArr[] = ['allocation.uploadraw_id', '=' , NULL];
        }
        if(isset($filter['skip_alloted']) && !$filter['skip_alloted']){
            $wheerArr[] = ['allocation.uploadraw_id', '!=' , NULL];
        }
        if(isset($filter['lot_done']) && $filter['lot_done']){
            $wheerArr[] = ['lots.lot_done', '=' , '0'];
        }
        if(isset($filter['wrc_id']) && is_numeric($filter['wrc_id'])){
            $wheerArr[] = ['wrc.id', '=' , $filter['wrc_id']];
        }
        if(isset($filter['lot_id']) && is_numeric($filter['lot_id'])){
            $wheerArr[] = ['lots.id', '=' , $filter['lot_id']];
        }
        if(isset($filter['user_id']) && is_numeric($filter['user_id'])){
            $wheerArr[] = ['allocation.user_id', '=' , $filter['user_id']];
        }
        if(isset($filter['brand_id']) && is_numeric($filter['brand_id'])){
            $wheerArr[] = ['brands.id', '=' , $filter['brand_id']];
        } 
 $result = DB::table('uploadraw')
        ->join('sku','sku.id','=','uploadraw.sku_id')
        ->join('wrc','wrc.id','=','sku.wrc_id')
        ->join('commercial','commercial.id','=','wrc.commercial_id')
        ->join('lots','lots.id','=','wrc.lot_id')
        ->join('users','users.id','=','lots.user_id')
        ->join('brands', 'brands.id', '=', 'lots.brand_id') 
        ->join('allocation', 'allocation.uploadraw_id', '=', 'uploadraw.id','left')
        ->select('allocation.user_id', 'lots.lot_id', 'users.Company','users.client_id', 'users.name','brands.name as brand_name','lots.id as lotid','wrc.id as wrcid','wrc.wrc_id','lots.lot_done', 'commercial.id as comid','commercial.type_of_shoot','commercial.product_category','commercial.type_of_clothing','uploadraw.created_at','commercial.adaptation_1','commercial.adaptation_2','commercial.adaptation_3','commercial.adaptation_4','commercial.adaptation_5','uploadraw.sku_id', 'allocation.uploadraw_id as auploadraw_id')
        ->where($wheerArr)->get();
        return  $result;
        
        
    }

    public static function getAllocation($filter = []){
        $wheerArr = [];
        
        if(isset($filter['skip_alloted']) && $filter['skip_alloted']){
            $wheerArr[] = ['allocation.uploadraw_id', '=' , NULL];
        }
        if(isset($filter['skip_alloted']) && !$filter['skip_alloted']){
            $wheerArr[] = ['allocation.uploadraw_id', '!=' , NULL];
        }
        if(isset($filter['lot_done']) && $filter['lot_done']){
            $wheerArr[] = ['lots.lot_done', '=' , '0'];
        }
        if(isset($filter['wrc_id']) && is_numeric($filter['wrc_id'])){
            $wheerArr[] = ['wrc.id', '=' , $filter['wrc_id']];
        }
        if(isset($filter['lot_id']) && is_numeric($filter['lot_id'])){
            $wheerArr[] = ['lots.id', '=' , $filter['lot_id']];
        }
        if(isset($filter['user_id']) && is_numeric($filter['user_id'])){
            $wheerArr[] = ['allocation.user_id', '=' , $filter['user_id']];
        }
        if(isset($filter['brand_id']) && is_numeric($filter['brand_id'])){
            $wheerArr[] = ['brands.id', '=' , $filter['brand_id']];
        } 
        if(isset($filter['sku_code']) && !empty($filter['sku_code'])){
            $wheerArr[] = ['sku.sku_code', '=' , $filter['sku_code']];
        }    
        $select = array('allocation.user_id', 'lots.lot_id', 'users.Company','users.client_id', 'users.name','brands.name as brand_name','lots.id as lotid','wrc.id as wrcid','wrc.wrc_id','sku.sku_code','lots.lot_done','uploadraw.id as uploadraw_id','uploadraw.filename', 'uploadraw.created_at', 'commercial.id as comid','commercial.type_of_shoot','commercial.product_category','commercial.type_of_clothing','commercial.adaptation_1','commercial.adaptation_2','commercial.adaptation_3','commercial.adaptation_4','commercial.adaptation_5','uploadraw.sku_id', 'allocation.uploadraw_id as auploadraw_id','sku.wrc_id as skw');
        
 $result = DB::table('uploadraw')
        ->join('sku','sku.id','=','uploadraw.sku_id')
        ->join('wrc','wrc.id','=','sku.wrc_id')
        ->join('commercial','commercial.id','=','wrc.commercial_id')
        ->join('lots','lots.id','=','wrc.lot_id')
        ->join('users','users.id','=','lots.user_id')
        ->join('brands', 'brands.id', '=', 'lots.brand_id') 
        ->join('allocation', 'allocation.uploadraw_id', '=', 'uploadraw.id','left');
        
        if(isset($filter['allocation_user_info']) && $filter['allocation_user_info']){
            $select[] = 'allo_users.name as allocation_user_name';
            $result->join('users as allo_users', 'allo_users.id', '=', 'allocation.user_id');
        }
        $result->select($select)
        ->where($wheerArr)
        ->orderBy('lots.id', 'DESC') ;
        if(isset($filter['group'])){
            $result->groupBy('wrc.id')->get();
        }
        if(isset($filter['single'])){
            return $result->first();
        }
        
        return  $result->get();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

 
        public static function pending(){
        $result = DB::table('uploadraw')
        ->join('editor_submission', 'editor_submission.sku_id', '=', 'uploadraw.sku_id' ,'left')
    ->where('editor_submission.sku_id','=', Null)
    ->whereDate('uploadraw.created_at', '>=', '22-4-1');

         return $result->get();
    }
    
}
