<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditingClientAR extends Model
{
    use HasFactory;
    // Editing Wrc list for Submission
    public static function EditingClientARList()
    {
        $EditingClientARList = EditingSubmission::
        leftJoin('editing_wrcs', 'editing_wrcs.id', 'editing_submissions.wrc_id')->
        leftJoin('editor_lots', 'editor_lots.id', 'editing_wrcs.lot_id')->
        leftJoin('users', 'users.id', 'editor_lots.user_id')->
        leftJoin('brands', 'brands.id', 'editor_lots.brand_id')->
        select(
            'editing_submissions.id as submission_id',
            'editing_submissions.wrc_id',
            'editing_submissions.submission_date',
            'editing_submissions.ar_status',
            'editing_submissions.rejection_reason',
            'editing_submissions.action_date',
            'editing_wrcs.wrc_number',
            'editing_wrcs.commercial_id',
            'editing_wrcs.imgQty as imgqty',
            'editing_wrcs.invoice_number',
            'editing_wrcs.imgQty as wrc_t_sku_qty',
            'editor_lots.brand_id',
            'editor_lots.lot_number',
            'editor_lots.request_name',
            'users.Company as company',
            'users.c_short',
            'brands.name as brands_name',
            'brands.short_name',
        )->
        get()->toArray();
        return $EditingClientARList;
    }

    public static function Editing_reject_approve_wrc($request)
    {

        $submission_id = $request->submission_id;
        $wrc_id = $request->wrc_id;
        $ar_status = $request->ar_status;
        $rejection_reason = $request->rejection_reason;
        $update_status = 0;
        $new_wrc_id = 0;
        $massage = "somthing went Wrong!!!";

        $rejection_reason = $rejection_reason == NULL ? '' : $rejection_reason;
        try {
            DB::beginTransaction();
            $data = EditingSubmission::where('id', $submission_id)->where('ar_status', '<>', '0')->get()->toArray();
            $count_data = count($data);
            if ($count_data > 0) {
                if ($data['0']['ar_status'] == 1) {
                    $massage = "Wrc already Approved!!!";
                } else {
                    $massage = "Wrc already Rejected!!";
                }
            } else {
                $action_date = date('Y-m-d H:i:s');
                $storeData = EditingSubmission::find($submission_id);
                $storeData->ar_status = $ar_status;
                $storeData->action_date = $action_date;
                $storeData->rejection_reason = $rejection_reason;
                $update_status = $storeData->update();
                if ($update_status) {
                    $wrc_status_is = 1;
                    $massage = "Wrc Approved!!";
                    if($ar_status == 2){
                        $EditingWrc =  EditingWrc::find($wrc_id);
                        $EditingWrc->wrc_status = $ar_status;
                        $wrc_status_is = $EditingWrc->update();
                        $massage = "Wrc Rejected!!";

                    }
                    if($wrc_status_is){
                        DB::commit();
                    }else{
                        DB::rollback();
                    }
                } else {
                    DB::rollback();
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
        }
        $response = array(
            'wrc_id' => $wrc_id,
            'update_status' => $update_status,
            'massage' => $massage,
            'ar_status' => $ar_status,
            'rejection_reason' => $rejection_reason,
        );
        return $response;
    }
}
