<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreativeWrcModel extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = 'creative_wrc';
    protected $fillable=['lot_id', 'wrc_number', 'commercial_id', 'order_qty', 'work_brief', 'guidelines', 'document1', 'document2', 'status'];

    public static function getDataForCreativeAllocation(){

        // Graphic Designer  list
        $gd_role_data = DB::table('roles')->where('name','=','GD')->first(['id']);
        $cw_role_data = DB::table('roles')->where('name','=','CW')->first(['id']);
        $gd_id = $gd_role_data != null ? $gd_role_data->id : 0;
        $cw_id = $cw_role_data != null ? $cw_role_data->id : 0;

        $graphic_designer_users_data = DB::table('users')
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
        ->where([ ['users.Company' ,'<>' ,NULL], ['model_has_roles.role_id','=', $gd_id]])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);   

        // dd(dump($graphic_designer_users_data));

        $copy_writer_users_data = DB::table('users')
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
        ->where([ ['users.Company' ,'<>' ,NULL], ['model_has_roles.role_id','=', $cw_id]])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);

        // dd(dump($copy_writer_users_data));

        $gd_user_id_data = [];
        $cw_user_id_data = [];

        foreach($graphic_designer_users_data as $key => $val){
            array_push($gd_user_id_data,$val->id);
        }

        foreach($copy_writer_users_data as $ckey => $cval){
            array_push($cw_user_id_data,$cval->id);
        }

        // dd($gd_user_id_data);
        // dd($cw_user_id_data);


        $resData = CreativeWrcModel::orderBy('creative_wrc.id','DESC')
        ->leftJoin('creative_wrc_batch as creative_wrc_batch', 'creative_wrc_batch.wrc_id', 'creative_wrc.id')
        ->leftJoin('creative_lots as cl', 'cl.id', 'creative_wrc.lot_id')
        ->leftJoin('users as users', 'users.id', 'cl.user_id')
        ->leftJoin('brands as brands', 'brands.id', 'cl.brand_id')
        ->leftJoin('create_commercial', function($join){
                    $join->on('create_commercial.user_id', '=', 'cl.user_id');
                    $join->on('create_commercial.brand_id', '=', 'cl.brand_id');
                    $join->on('create_commercial.id', '=', 'creative_wrc.commercial_id');
                })
        ->select('creative_wrc.id as wrc_id','creative_wrc.lot_id', 'creative_wrc.wrc_number', 'creative_wrc.commercial_id', 'creative_wrc.order_qty', 'creative_wrc.work_brief', 'creative_wrc.guidelines', 'creative_wrc.document1', 'creative_wrc.document2', 'creative_wrc.status', 'cl.user_id', 'cl.brand_id', 'cl.lot_number', 'cl.project_name', 'cl.client_bucket', 'users.Company as Company', 'brands.name as brand_name','create_commercial.project_name', 'create_commercial.kind_of_work','creative_wrc.alloacte_to_copy_writer','creative_wrc.sku_count','creative_wrc_batch.order_qty as batch_order_qty','creative_wrc_batch.sku_count as batch_sku_count','creative_wrc_batch.batch_no as batch_batch_no','creative_wrc_batch.work_initiate_date','creative_wrc_batch.work_committed_date as Comitted_initiate_date')
        // ->groupBy('creative_wrc.id')
        // ->groupBy('creative_wrc_batch.id')
        ->get();

        foreach($resData as $rkey=> $rdata){
             // calculate copy writer allocated qty
             $rdata['cw_allocated_qty'] = DB::table('creative_allocation')->whereIn('user_id',$cw_user_id_data)->where('wrc_id',$rdata['wrc_id'])->where('batch_no',$rdata['batch_batch_no'])->sum('allocated_qty');

             // calculate graphics designer allocated qty
             $rdata['gd_allocated_qty'] = DB::table('creative_allocation')->whereIn('user_id',$gd_user_id_data)->where('wrc_id',$rdata['wrc_id'])->where('batch_no',$rdata['batch_batch_no'])->sum('allocated_qty');
        }        
        // dd($resData);
         return [
            "resData"                     => $resData,
            "graphic_designer_users_data" => $graphic_designer_users_data,
            "copy_writer_users_data"      => $copy_writer_users_data
         ];
         
    }

    public static function getDataForCreativeReAllocation(){

        $gd_role_data = DB::table('roles')->where('name','=','GD')->first(['id']);
        $cw_role_data = DB::table('roles')->where('name','=','CW')->first(['id']);
        $gd_id = $gd_role_data != null ? $gd_role_data->id : 0;
        $cw_id = $cw_role_data != null ? $cw_role_data->id : 0;

        // Graphic Designer  list
        $graphic_designer_users_data = DB::table('users')
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
        ->where([ ['users.Company' ,'<>' ,NULL], ['model_has_roles.role_id','=', $gd_id]])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);   

        // dd(dump($graphic_designer_users_data));

        $copy_writer_users_data = DB::table('users')
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
        ->where([ ['users.Company' ,'<>' ,NULL], ['model_has_roles.role_id','=', $cw_id]])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);

        // dd(dump($copy_writer_users_data));

        $gd_user_id_data = [];
        $cw_user_id_data = [];

        foreach($graphic_designer_users_data as $key => $val){
            array_push($gd_user_id_data,$val->id);
        }

        foreach($copy_writer_users_data as $ckey => $cval){
            array_push($cw_user_id_data,$cval->id);
        }

        // dd($gd_user_id_data);
        // dd($cw_user_id_data);


        $resData = CreativeWrcModel::orderBy('creative_wrc.id','DESC')
        ->leftJoin('creative_wrc_batch as creative_wrc_batch', 'creative_wrc_batch.wrc_id', 'creative_wrc.id')
        ->leftJoin('creative_lots as cl', 'cl.id', 'creative_wrc.lot_id')
        ->leftJoin('users as users', 'users.id', 'cl.user_id')
        ->leftJoin('brands as brands', 'brands.id', 'cl.brand_id')
        ->leftJoin('create_commercial', function($join){
                    $join->on('create_commercial.user_id', '=', 'cl.user_id');
                    $join->on('create_commercial.brand_id', '=', 'cl.brand_id');
                    $join->on('create_commercial.id', '=', 'creative_wrc.commercial_id');
                })
        ->select('creative_wrc.id as wrc_id','creative_wrc.lot_id', 'creative_wrc.wrc_number', 'creative_wrc.commercial_id', 'creative_wrc.order_qty', 'creative_wrc.work_brief', 'creative_wrc.guidelines', 'creative_wrc.document1', 'creative_wrc.document2', 'creative_wrc.status', 'cl.user_id', 'cl.brand_id', 'cl.lot_number', 'cl.project_name', 'cl.client_bucket', 'users.Company as Company', 'brands.name as brand_name','create_commercial.project_name', 'create_commercial.kind_of_work','creative_wrc.alloacte_to_copy_writer','creative_wrc.sku_count','creative_wrc_batch.order_qty as batch_order_qty','creative_wrc_batch.sku_count as batch_sku_count','creative_wrc_batch.batch_no as batch_batch_no','creative_wrc_batch.work_initiate_date','creative_wrc_batch.work_committed_date as Comitted_initiate_date')
        // ->groupBy('creative_wrc.id')
        // ->groupBy('creative_wrc_batch.id')
        ->get();

        foreach($resData as $rkey=> $rdata){

            $allocated_users = CreativeAllocation::where('wrc_id',$rdata['wrc_id'])
            ->where('batch_no',$rdata['batch_batch_no'])
            ->leftJoin('users as ulist', 'ulist.id', 'creative_allocation.user_id')
            ->select('ulist.name')->get();

            $rdata['allocated_users'] = $allocated_users;


            // calculate copy writer allocated qty
            $rdata['cw_allocated_qty'] = DB::table('creative_allocation')->whereIn('user_id',$cw_user_id_data)->where('wrc_id',$rdata['wrc_id'])->where('batch_no',$rdata['batch_batch_no'])->sum('allocated_qty');

            // calculate graphics designer allocated qty
            $rdata['gd_allocated_qty'] = DB::table('creative_allocation')->whereIn('user_id',$gd_user_id_data)->where('wrc_id',$rdata['wrc_id'])->where('batch_no',$rdata['batch_batch_no'])->sum('allocated_qty');
        }        
        // dd($resData);
         return [
            "resData"                     => $resData,
            "graphic_designer_users_data" => $graphic_designer_users_data,
            "copy_writer_users_data"      => $copy_writer_users_data
         ];
         
    }

    // get wrc status detail list data 
    public static function getWrcStatusDetailList(){

        $wrcs =  CreativeWrcModel::OrderBy('creative_wrc.id','ASC')
       ->leftJoin('creative_lots', 'creative_lots.id', 'creative_wrc.lot_id')
       ->leftJoin('users', 'users.id', 'creative_lots.user_id')
       ->leftJoin('brands', 'brands.id', 'creative_lots.brand_id')
       ->leftJoin('creative_wrc_batch', 'creative_wrc_batch.wrc_id', 'creative_wrc.id')
       ->orderBy('creative_wrc_batch.id', 'DESC')
       ->groupBy('creative_wrc_batch.wrc_id')
       ->groupBy('creative_wrc_batch.batch_no')
       ->leftJoin('creative_allocation', 'creative_allocation.wrc_id','creative_wrc.id')
       ->leftJoin('create_commercial as create_commercial',function($join)
       {
           $join->on('create_commercial.user_id','=','creative_lots.user_id');
           $join->on('create_commercial.brand_id','=','creative_lots.brand_id');
       })
       ->leftJoin('creative_submissions', function($join){
        $join->on('creative_submissions.wrc_id', '=', 'creative_allocation.wrc_id');
        $join->on('creative_submissions.batch_no', '=', 'creative_allocation.batch_no');
    })
       ->select('creative_wrc.*','creative_lots.user_id','creative_lots.brand_id','creative_lots.id as lot_id','creative_lots.lot_number','users.Company as Company_name','brands.name','create_commercial.kind_of_work',DB::raw('MAX(creative_wrc_batch.batch_no) as batch_no'),'creative_wrc_batch.wrc_id as batch_wrc_id','creative_submissions.status as submission_status')
       ->get();

       foreach($wrcs as $key => $val){
        $lot_id = $val['lot_id'];
			$creative_wrc_count = DB::table('creative_wrc')->where('lot_id',$lot_id)->count();
			$wrc_status = $creative_wrc_count > 0 ? 'Allocation Pending' : 'Inverd Pending';
            $val['wrc_status']  = $wrc_status;

            if($wrc_status == 'Allocation Pending'){
                $creative_allocation_count = DB::table('creative_allocation')->where('wrc_id',$val['batch_wrc_id'])->where('batch_no',$val['batch_no'])->count();
                // dd($creative_allocation_count);
                $wrc_status = $creative_allocation_count > 0 ? 'Tasking Pending' : 'Allocation Pending';
                // dd($wrc_status );
                $val['wrc_status']  = $wrc_status;
            }

            if($wrc_status == 'Tasking Pending'){
                // dd($val['qc_status']);
				if($val['qc_status'] == 0){
					$wrc_status = 'Qc Pending';
					$val['wrc_status']  = 'Qc Pending';
				}
			}

            if($wrc_status == 'Qc Pending'){
				$submission_status = $val['submission_status'];

				$wrc_status = $submission_status  == 0 ? 'Submission Pending' : 'Submitted';
				$val['wrc_status']  = $wrc_status;
			}

            if($wrc_status == 'Submitted'){
                $creative_wrc_client_approval = DB::table('creative_wrc_client_approval')->where('wrc_id',$val['batch_wrc_id'])->where('batch_no',$val['batch_no'])->first(['status']);

                $client_status =  $creative_wrc_client_approval != null ?  $creative_wrc_client_approval->status : 0;

                // dd($client_status);

                $wrc_status = $client_status  == 0 ? 'Client Feedback Pending' : 'Completed';
				$val['wrc_status']  = $wrc_status;
            }

       
    }
       return $wrcs;

    }

    // get Creative Wrcs allocation
    public function wrcAllocations(){
        return $this->hasMany('App\Models\CreativeAllocation','wrc_id','id');
    }


}