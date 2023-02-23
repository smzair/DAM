<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Contracts\ControllerDispatcher;
use Illuminate\Support\Facades\DB;
use stdClass;

class CatalogUploadLinks extends Model
{
    use HasFactory;

    protected $table = 'catalog_upload_links';
    protected $fillable = [
        'allocation_id', 'final_link' , 'catalog_link', 'copy_link'
    ];

    public static function upload_catalog_link($allocation_id_is, $final_link , $catalog_link, $copy_link,  $action)
    {
        $allocation_id = $allocation_id_is ;
        $catalog_link = $catalog_link == null ? '' : $catalog_link;
        $copy_link = $copy_link == null ? '' : $copy_link;
        $final_link = $final_link == null ? '' : $final_link;

        $link_id = CatalogUploadLinks::where('allocation_id', $allocation_id)->get(['id'])->first();
        $allocated_link_id = $link_id != null ?  $link_id->id : 0;

        if($allocated_link_id > 0){
            $storeData = CatalogUploadLinks::find($allocated_link_id);
            $storeData->allocation_id = $allocation_id;
            $storeData->final_link = $final_link;
            $storeData->catalog_link = $catalog_link;
            $storeData->copy_link = $copy_link;
            $status = $storeData->update();            
        }else{
            $data = new CatalogUploadLinks();
            $data->allocation_id = $allocation_id;
            $data->final_link = $final_link;
            $data->catalog_link = $catalog_link;
            $data->copy_link = $copy_link;
            $status = $data->save();
        }

        if($status){
           $res = $allocated_link_id > 0 ? 2 : 1 ;
        }else{
            $res = 0;
        }
        return $res;
    }

    // catalog uploaded link

    public static function get_catalog_uploaded_link($allocation_id){
        // SELECT catalog_upload_links.* FROM `catalog_upload_links` LEFT join catalog_time_hash on catalog_time_hash.allocation_id = catalog_upload_links.allocation_id WHERE catalog_upload_links.allocation_id = 32;
        
        // SELECT `id`, `allocation_id`, `start_time`, `end_time`, `task_status`, `is_rework`, `rework_count`, `spent_time`, `created_at`, `updated_at` FROM `catalog_time_hash` WHERE 1;
        $response = CatalogUploadLinks::
        where('catalog_upload_links.allocation_id',$allocation_id)->
        leftJoin('catalog_time_hash', 'catalog_time_hash.allocation_id', 'catalog_upload_links.allocation_id')->
        select(
            'catalog_upload_links.id',
            'catalog_upload_links.final_link',
            'catalog_upload_links.catalog_link',
            'catalog_upload_links.copy_link',
            'catalog_time_hash.end_time',
            'catalog_time_hash.task_status',
            'catalog_time_hash.spent_time',
            'catalog_time_hash.is_rework',
        )->
        get()->toArray();
        if(count($response) == 0){
            $response = 0;
        }
        return $response;
    }
}
