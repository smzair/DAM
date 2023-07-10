<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditingUploadLink extends Model
{
    use HasFactory;
    protected $table = 'editing_upload_links';
    protected $fillable = [
        'allocation_id', 'final_link', 'task_status'
    ];

    public static function Editing_upload_link($request)
    {
        $allocation_id = $request->allocation_id_is;
        $final_link = $request->final_link;
        $action = $request->action;
        $wrc_id = $request->wrc_id;

        if($action == 'comp'){
            $task_status = 1;
        }else{
            $task_status = 0;
        }

        $EditingAllocation_data = EditingAllocation::where('editing_allocations.id', $allocation_id)->
        leftJoin('editing_upload_links', 'editing_upload_links.allocation_id', 'editing_allocations.id')->
        leftJoin('editing_wrcs', 'editing_allocations.wrc_id', 'editing_wrcs.id')->
        select(
            'editing_allocations.*',
            'editing_upload_links.id as allocated_link_id',
            'editing_upload_links.task_status',
            'editing_upload_links.final_link',
            'editing_allocations.file_path',
            'editing_wrcs.uploaded_img_file_path',
        )->first()->toArray();
        $allocated_qty = $EditingAllocation_data['allocated_qty'];
        $uploaded_qty = $EditingAllocation_data['uploaded_qty'];
        $final_link = ($EditingAllocation_data['final_link'] == null || $EditingAllocation_data['final_link'] == '' ) ? $EditingAllocation_data['file_path'] : $EditingAllocation_data['final_link'] ;

        $task_status = $EditingAllocation_data['task_status'] > 0 ? $EditingAllocation_data['task_status'] : 0;
        $massage = "Somthing Went Wrong";

        if ($uploaded_qty >= $allocated_qty && $task_status == 0) {
            $allocated_link_id = $EditingAllocation_data['allocated_link_id'] != null ?  $EditingAllocation_data['allocated_link_id'] : 0;
            if ($allocated_link_id > 0) {
                $storeData = EditingUploadLink::find($allocated_link_id);
                $storeData->allocation_id = $allocation_id;
                $storeData->final_link = $final_link;
                $storeData->task_status = 1;
                $status = $storeData->update();
            } else {
                $data = new EditingUploadLink();
                $data->allocation_id = $allocation_id;
                $data->final_link = $final_link;
                $data->task_status = 1;
                $status = $data->save();
            }

            if ($status) {
                $up_status = $allocated_link_id > 0 ? 2 : 1;
            } else {
                $up_status = 0;
            }
        }else{
            $status = 2;
            $up_status = 0;
            if($uploaded_qty < $allocated_qty || $uploaded_qty == 0){
                $massage = "Uploading Not Completed!!";
            }
            if($task_status > 0 && $uploaded_qty >= $allocated_qty){
                $status = 3;
                $massage = "Wrc already Completed!!";

            }
        }
        $response = array(
            'status' => $status,
            'massage' => $massage,
            'up_status' => $up_status,
            'final_link' => $final_link,
            'task_status' => $task_status,
        );
        return $response;
        // dd($EditingAllocation_data, $response , $request->all());
    }

     // Editing uploaded link
     public static function get_editing_uploaded_link($allocation_id)
     {
 
        $EditingAllocation_data = EditingAllocation::where('editing_allocations.id' , $allocation_id)->
        leftJoin('editing_upload_links', 'editing_upload_links.allocation_id', 'editing_allocations.id')->
        select(
            'editing_allocations.*',
            'editing_upload_links.id',
            'editing_upload_links.task_status',
            'editing_upload_links.final_link',
        )->first()->toArray();

        $allocated_qty = $EditingAllocation_data['allocated_qty'];
        $uploaded_qty = $EditingAllocation_data['uploaded_qty'];
        $final_link = $EditingAllocation_data['final_link'];
        $task_status = $EditingAllocation_data['task_status'] > 0 ? $EditingAllocation_data['task_status'] : 0;
        $is_uploading_pending = 1;
        if($uploaded_qty >= $allocated_qty){
            $is_uploading_pending = 0;
        }
        $response = array(
            'is_uploading_pending' => $is_uploading_pending,
            'task_status' => $task_status,
            'final_link' => $final_link, 
        );
        return $response ;
        
        // $response = EditingUploadLink::
        // where('editing_upload_links.allocation_id', $allocation_id)->
        // select(
        //     'editing_upload_links.id',
        //     'editing_upload_links.task_status',
        //     'editing_upload_links.final_link',
        // )->
        // get()->
        // toArray();
        // if (count($response) == 0) {
        //     $response = 0;
        // }
        // return $response;
     }
}
