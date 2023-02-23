<?php

namespace App\Models;

use CreativeUploadLink as GlobalCreativeUploadLink;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreativeUploadLink extends Model
{
    use HasFactory;
    /**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'creative_upload_links';
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable=['allocation_id', 'creative_link', 'copy_link'];

    /* get data for qc list  */
    public static function getDataForQcList(){
        $QcList  = [];

        $QcList = CreativeAllocation::OrderBy('creative_upload_links.id','DESC')
        ->leftJoin('creative_upload_links', 'creative_upload_links.allocation_id', 'creative_allocation.id')
        ->leftJoin('users as users', 'users.id','creative_allocation.user_id')
        ->leftJoin('creative_time_hash', 'creative_time_hash.allocation_id', 'creative_upload_links.allocation_id')
        ->leftJoin('creative_wrc', 'creative_wrc.id', 'creative_allocation.wrc_id')
        ->leftJoin('creative_lots as cl', 'cl.id', 'creative_wrc.lot_id')
        ->leftJoin('brands as brands', 'brands.id', 'cl.brand_id')
        ->leftJoin('creative_wrc_batch', function($join){
			$join->on('creative_wrc_batch.wrc_id', '=', 'creative_allocation.wrc_id');
			$join->on('creative_wrc_batch.batch_no', '=', 'creative_allocation.batch_no');
		})
		->leftJoin('create_commercial as create_commercial',function($join)
        {
            $join->on('create_commercial.user_id','=','cl.user_id');
            $join->on('create_commercial.brand_id','=','cl.brand_id');
        })
        ->groupBy(['creative_wrc_batch.wrc_id','creative_wrc_batch.batch_no','creative_upload_links.id'])
        // ->orderBy('creative_time_hash.id','DESC')
        ->select(
            // 'creative_allocation.*',
            'creative_upload_links.creative_link',
            'creative_upload_links.copy_link',
            'creative_time_hash.start_time',
            'creative_time_hash.end_time',
            'creative_allocation.wrc_id',
            'creative_wrc.wrc_number',
            'creative_wrc.order_qty',
            'creative_wrc.sku_count',
            'creative_wrc.qc_status',
            'creative_wrc.cw_qc_status',
            'creative_wrc.alloacte_to_copy_writer',
            'brands.name as brands_name',
            'creative_upload_links.creative_link as creative_link',
            'creative_upload_links.copy_link as copy_link',
            'create_commercial.kind_of_work as type_of_service',
            // DB::raw('GROUP_CONCAT(creative_upload_links.creative_link) as creative_link_list'),
            // DB::raw('GROUP_CONCAT(creative_upload_links.copy_link) as copy_link_list') 
            'cl.client_bucket','creative_wrc_batch.batch_no','creative_wrc_batch.order_qty as batch_order_qty','creative_wrc_batch.sku_count as batch_sku_count'
        );
        $QcList = $QcList->get();

        // foreach($QcList as $key => $val){
        //     $last_entry_end_date = CreativeTimeHash::where('allocation_id',$val['allocation_id'])->orderBy('id','DESC')->get(['end_time'])->first();

        //     $last_end_time = ($last_entry_end_date->end_time != '' || $last_entry_end_date->end_time != NULL || $last_entry_end_date->end_time != null) ?  $last_entry_end_date->end_time : 'no_data';
        //     $val['last_end_time'] = $last_end_time ;
        // }
        // dd($QcList);
        return $QcList;
    }
    //get Cw Gd User List
    public static function getCwGdUserList($role){

        // Graphic Designer  list
        $graphic_designer_users_data = [];
        $copy_writer_users_data = [];
        $gd_user_id_data = [];
        $cw_user_id_data = [];

        $gd_role_data = DB::table('roles')->where('name','=','GD')->first(['id']);
        $cw_role_data = DB::table('roles')->where('name','=','CW')->first(['id']);
        $gd_id = $gd_role_data != null ? $gd_role_data->id : 0;
        $cw_id = $cw_role_data != null ? $cw_role_data->id : 0;

        if($role == 'GD'){
            $graphic_designer_users_data = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([ ['users.Company' ,'<>' ,NULL], ['model_has_roles.role_id','=', $gd_id]])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']); 
            foreach($graphic_designer_users_data as $key => $val){
                array_push($gd_user_id_data,$val->id);
            }
        }

        if($role == 'CW'){
            $copy_writer_users_data = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([ ['users.Company' ,'<>' ,NULL], ['model_has_roles.role_id','=', $cw_id]])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);
            foreach($copy_writer_users_data as $ckey => $cval){
                array_push($cw_user_id_data,$cval->id);
            }
        }

        return [
            'gd_user_id_data' => $gd_user_id_data,
            'cw_user_id_data' => $cw_user_id_data
        ];
    }

     
}
