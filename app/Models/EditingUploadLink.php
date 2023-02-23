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

        if($action == 'comp'){
            $task_status = 1;
        }else{
            $task_status = 0;
        }

        $link_id = EditingUploadLink::where('allocation_id', $allocation_id)->get(['id'])->first();

        $allocated_link_id = $link_id != null ?  $link_id->id : 0;

        $final_link = $final_link == null ? '' : $final_link;

        if ($allocated_link_id > 0) {
            $storeData = EditingUploadLink::find($allocated_link_id);
            $storeData->allocation_id = $allocation_id;
            $storeData->final_link = $final_link;
            $storeData->task_status = $task_status;
            $status = $storeData->update();
        } else {
            $data = new EditingUploadLink();
            $data->allocation_id = $allocation_id;
            $data->final_link = $final_link;
            $data->task_status = $task_status;
            $status = $data->save();
        }

        if ($status) {
            $up_status = $allocated_link_id > 0 ? 2 : 1;
        } else {
            $up_status = 0;
        }

        return $response = array(
            'status' => $status,
            'up_status' => $up_status,
            'final_link' => $final_link,
            'task_status' => $task_status,
        );
    }

    // Editing uploaded link

    public static function get_editing_uploaded_link($allocation_id)
    {
        $response = EditingUploadLink::
        where('editing_upload_links.allocation_id', $allocation_id)->
        select(
            'editing_upload_links.id',
            'editing_upload_links.task_status',
            'editing_upload_links.final_link',
        )->
        get()->
        toArray();
        if (count($response) == 0) {
            $response = 0;
        }
        return $response;
    }
}
