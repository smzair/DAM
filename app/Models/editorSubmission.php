<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;     
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Carbon\Carbon;

class editorSubmission extends Model
{
    use HasFactory,LogsActivity;

    protected $fillable=[
        'sku_id',
        'filename',
        'qc',
        'adaptation',
    ];

    protected $table = 'editor_submission';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
    public static function SubmissionInfo($filter = []){
        $whereArr = [];

        if(isset($filter['lot_id'])){
            $whereArr[] = ['lots.id', '=' , $filter['lot_id']];
        }
        if(isset($filter['adaptation'])){
            $whereArr[] = ['editor_submission.adaptation', '=' , $filter['adaptation']];
        }
        if(isset($filter['wrc_id'])){
            $whereArr[] = ['wrc.id', '=' , $filter['wrc_id']];
        }
    
        if(isset($filter['brand_id'])){
            $whereArr[] = ['brands.id', '=' , $filter['brand_id']];
        }
        if(isset($filter['sku_id'])){
            $whereArr[] = ['sku.id', '=' , $filter['sku_id']];
        } 
        if(isset($filter[''])){
            $whereArr[] = ['sku.id', '=' , $filter['sku_id']];
        }      
         if(isset($filter['submission'])){
            $whereArr[] = ['wrc.submission', '=' , $filter['submission']];
        }
        if(isset($filter['qc'])){
            $whereArr[] = ['editor_submission.qc', '=' , $filter['qc']];
        }
        $result = DB::table('editor_submission')
        ->join('sku','sku.id','=','editor_submission.sku_id')
        ->join('wrc','wrc.id','=','sku.wrc_id')
        ->join('commercial','commercial.id','=','wrc.commercial_id')
        ->join('lots','lots.id','=','wrc.lot_id')
        ->join('users','users.id','=','lots.user_id')
        ->join('brands', 'brands.id', '=', 'lots.brand_id') 
        //->join('allocation', 'allocation.uploadraw_id', '=', 'uploadraw.id', 'Left')  
        ->select( 'wrc.id as wrcid','wrc.wrc_id','lots.lot_id', 'users.Company', 'brands.name' ,'users.client_id', 'lots.id as lotid','wrc.id as wrcid','sku.sku_code','sku.category','editor_submission.id as editorSubmission_id','editor_submission.filename', 'commercial.id as comid','commercial.type_of_shoot','commercial.product_category','editor_submission.sku_id','editor_submission.adaptation','editor_submission.qc','commercial.type_of_shoot','commercial.type_of_shoot','commercial.type_of_shoot','commercial.type_of_shoot','editor_submission.created_at','wrc.submission')
        ->where($whereArr)
        ->orderBy('editor_submission.created_at', 'DESC');

        if(isset($filter['group'])){
            $result->groupBy('wrc.id')->get();
        }
        if(isset($filter['group_by'])){
            $result->groupBy($filter['group_by'])->get();
        }if(isset($filter['single'])){
            return $result->first();
        }
        if(isset($filter['qcDone'])){
            return $result->where('editor_submission.qc','=','1')->get();
        }
        if(isset($filter['qcPending'])){
            return $result->where('editor_submission.qc','=','0')->get();
        }
        if(isset($filter['today'])){
            return $result ->whereDate('editor_submission.updated_at', '=',Carbon::today())->get();
        }
        return  $result->get();
    }


public static function SubmitedInfo($filter = []){
        $whereArr = [];

        if(isset($filter['lot_id'])){
            $whereArr[] = ['lots.id', '=' , $filter['lot_id']];
        }
        if(isset($filter['adaptation'])){
            $whereArr[] = ['editor_submission.adaptation', '=' , $filter['adaptation']];
        }
        if(isset($filter['wrc_id'])){
            $whereArr[] = ['wrc.id', '=' , $filter['wrc_id']];
        }
        if(isset($filter['qc'])){
            $whereArr[] = ['editor_submission.qc', '=' , $filter['qc']];
        }
        if(isset($filter['brand_id'])){
            $whereArr[] = ['brands.id', '=' , $filter['brand_id']];
        }
        if(isset($filter['sku_id'])){
            $whereArr[] = ['sku.id', '=' , $filter['sku_id']];
        } 
        if(isset($filter[''])){
            $whereArr[] = ['sku.id', '=' , $filter['sku_id']];
        }      
         if(isset($filter['submission'])){
            $whereArr[] = ['wrc.submission', '=' , $filter['submission']];
        }
        $result = DB::table('editor_submission')
        ->join('sku','sku.id','=','editor_submission.sku_id')
        ->join('wrc','wrc.id','=','sku.wrc_id')
        ->join('commercial','commercial.id','=','wrc.commercial_id')
        ->join('lots','lots.id','=','wrc.lot_id')
        ->join('users','users.id','=','lots.user_id')
        ->join('brands', 'brands.id', '=', 'lots.brand_id') 
        ->join('submission', 'submission.wrc_id', '=', 'wrc.id')
        ->select( 'wrc.id as wrcid','wrc.wrc_id','lots.lot_id', 'users.Company', 'brands.name' ,'users.client_id', 'lots.id as lotid','wrc.id as wrcid','sku.sku_code','sku.category','editor_submission.id as editorSubmission_id','editor_submission.filename', 'commercial.id as comid','commercial.type_of_shoot','commercial.product_category','editor_submission.sku_id','editor_submission.adaptation','editor_submission.qc','commercial.type_of_shoot','commercial.type_of_shoot','commercial.type_of_shoot','commercial.type_of_shoot','editor_submission.created_at','wrc.submission','submission.submission_date')
        ->where($whereArr)
        ->orderBy('editor_submission.created_at', 'DESC');

        if(isset($filter['group'])){
            $result->groupBy('wrc.id')->get();
        }
        if(isset($filter['group_by'])){
            $result->groupBy($filter['group_by'])->get();
        }if(isset($filter['single'])){
            return $result->first();
        }
        
        return  $result->get();
        
        
    }

     public static function pending(){
        $result = DB::table('uploadraw')
        ->join('editor_submission', 'editor_submission.sku_id', '=', 'uploadraw.sku_id' ,'left')
    ->where('editor_submission.sku_id','=', Null);
         return $result->get();
    }
}


