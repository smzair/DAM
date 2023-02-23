<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditingSubmission extends Model
{
    use HasFactory;

    protected $table = 'editing_submissions';
    protected $fillable = [
        'id', 'wrc_id', 'submission_date', 'ar_status', 'rejection_reason', 'action_date'
    ];
    // catalog Wrc list for Submission
    public static function Editing_Wrc_Submission_list($tsak_status_is)
    {
        $Editing_Wrc_list_ready_for_Submission = EditingAllocation::
        WHERE('editing_upload_links.task_status', '=', $tsak_status_is)->
        leftJoin('editing_wrcs', 'editing_wrcs.id', 'editing_allocations.wrc_id')->
        leftJoin('editor_lots', 'editor_lots.id', 'editing_wrcs.lot_id')->
        leftJoin('editors_commercials', 'editors_commercials.id', 'editing_wrcs.commercial_id')->
        leftJoin('editing_upload_links', 'editing_upload_links.allocation_id', 'editing_allocations.id')->
        leftJoin('users', 'users.id', 'editor_lots.user_id')->
        leftJoin('brands', 'brands.id', 'editor_lots.brand_id')->
        leftJoin('users as allocated_users', 'allocated_users.id', 'editing_allocations.user_id')->
        select(
            'editing_wrcs.created_at as wrc_created_at',
            'editing_wrcs.lot_id',
            'editing_wrcs.wrc_number',
            'editing_wrcs.commercial_id',
            'editing_wrcs.imgQty',
            'editing_wrcs.imgQty as wrc_t_sku_qty',
            'editor_lots.brand_id',
            'editor_lots.lot_number',
            'editors_commercials.type_of_service as project_type',
            'users.Company as company',
            'users.c_short',
            'brands.name as brands_name',
            'brands.short_name',
            'editing_allocations.wrc_id',
            DB::raw('GROUP_CONCAT(editing_allocations.id) as editor_allocation_ids'),
            DB::raw('GROUP_CONCAT(editing_allocations.wrc_id) as wrc_ids'),
            DB::raw('GROUP_CONCAT(editing_allocations.user_id) as allocated_users_id'),
            DB::raw('GROUP_CONCAT(editing_allocations.user_role) as user_roles'),
            DB::raw('SUM(CASE WHEN editing_allocations.user_role = 0 THEN editing_allocations.allocated_qty else 0 END)  as editor_allocated_qty'),
            DB::raw('sum(editing_allocations.allocated_qty) as tot_sku_qty'),
            DB::raw('COUNT(editing_allocations.wrc_id) as wrc_cnt'),
            DB::raw('COUNT(editing_allocations.user_role) as cnt_user_role'),
            DB::raw('GROUP_CONCAT(editing_upload_links.final_link) as final_link_list'),
            DB::raw('GROUP_CONCAT(allocated_users.id) as allo_users_id'),
            DB::raw('GROUP_CONCAT(allocated_users.name) as allocated_users_name'),
        )->
        // havingRaw("editor_allocated_qty > 0 AND editor_allocated_qty = imgQty")->
        groupBy(['editing_allocations.wrc_id'])->
        get()->toArray();
        return $Editing_Wrc_list_ready_for_Submission;
    }

    // complte wrc submission
    public static function comp_submission($request)
    {
        $wrc_id = $request->wrc_id;
        $editor_allocation_ids = $request->editor_allocation_ids;
        $submission_date = date('Y-m-d');
        // DB::beginTransaction();
        try {
            $submission_data = EditingSubmission::where('wrc_id', $wrc_id)->get(['id'])->first();
            $submission_id_is = $submission_data != null ?  $submission_data->id : 0;
            $status = 0;
            $massage = "somthing went wrong";
            $task_update_status = $task_status = "";
            if ($submission_id_is > 0) {
                $status = 2;
                $massage = "Wrc Already submitted";
            } else {
                $store_data = new EditingSubmission();
                $store_data->wrc_id = $wrc_id;
                $store_data->submission_date = $submission_date;
                $store_data->ar_status = 0;
                $store_data->rejection_reason = '';
                $store_data->action_date = '';
                $status = $store_data->save();
                $massage = "Wrc Submission Done!!";
                if ($status) {
                    $ids = explode(',', $editor_allocation_ids);
                    $task_status = 2;
                    $task_update_status = EditingUploadLink::whereIn('allocation_id', $ids)->update(['task_status' => $task_status]);
                    if ($task_update_status == count($ids) && count($ids) > 0) {
                        DB::commit();
                    }else
                    {
                        $status = 0;
                        DB::rollback();
                    }
                }else{
                    DB::rollback();
                }
            }
            return json_encode(array(
                'submission_id' => $submission_data,
                'submission_id_is' => $submission_id_is,
                'task_status' => $task_status,
                'task_update_status' => $task_update_status,
                'status' => $status,
                'massage' => $massage
            ));
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    // comp_submission_details
    public static function comp_submission_details($wrc_id)
    {
        $comp_submission_details = CatalogSubmission::WHERE('wrc_id', '=', $wrc_id)->select(
                'wrc_id',
                DB::raw('DATE_FORMAT(submission_date, "%d-%m-%Y") as submission_date')
            )->get()->toArray();

        return json_encode($comp_submission_details);
    }

}
