<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CatalogClientApprovalRejection extends Model
{
    use HasFactory;
    // catalog Wrc list for Submission
    public static function catalog_client_cr_list()
    {

        // SELECT catalog_submissions.wrc_id , catalog_submissions.submission_date 
        // , catlog_wrc.wrc_number , catlog_wrc.alloacte_to_copy_writer , catlog_wrc.ar_status , catlog_wrc.sku_qty , catlog_wrc.lot_id 
        // , lots_catalog.id , lots_catalog.lot_number , lots_catalog.user_id , lots_catalog.brand_id , lots_catalog.serviceType , lots_catalog.requestType
        // , users.Company  , users.c_short , brands.name , brands.short_name
        

        $catalog_client_cr_list = CatalogSubmission::
            leftJoin('catlog_wrc', 'catlog_wrc.id', 'catalog_submissions.wrc_id')->
            leftJoin(
                'catalog_wrc_batches',
                function ($join) {
                    $join->on('catalog_wrc_batches.wrc_id', '=', 'catalog_submissions.wrc_id');
                    $join->on('catalog_wrc_batches.batch_no', '=', 'catalog_submissions.batch_no');
                }
            )->
            leftJoin('lots_catalog', 'lots_catalog.id', 'catlog_wrc.lot_id')->
            leftJoin('users', 'users.id', 'lots_catalog.user_id')->
            leftJoin('brands', 'brands.id', 'lots_catalog.brand_id')->
        select(
            'catalog_submissions.id as submission_id',
            'catalog_submissions.wrc_id',
            'catalog_submissions.batch_no',
            'catalog_submissions.submission_date',
            'catalog_submissions.ar_status',
            'catalog_submissions.rejection_reason',
            'catalog_submissions.action_date',
            'catlog_wrc.wrc_number',
            'catlog_wrc.commercial_id',
            'catlog_wrc.alloacte_to_copy_writer',
            'catlog_wrc.work_brief',
            'catlog_wrc.sku_qty as wrc_t_sku_qty',
            'catalog_wrc_batches.sku_count as sku_qty',
            'lots_catalog.brand_id',
            'lots_catalog.lot_number',
            'lots_catalog.serviceType as kind_of_work',
            'lots_catalog.requestType',
            'users.Company as company',
            'users.c_short',
            'brands.name as brands_name',
            'brands.short_name',
        )->
        get()->toArray();
        return $catalog_client_cr_list;
    }

    public static function wrc_reject_approve_wrc($request){


        $submission_id = $request->submission_id;
        $wrc_id = $request->wrc_id;
        $batch_no = $request->batch_no;
        $ar_status = $request->ar_status;
        $rejection_reason = $request->rejection_reason;

        $rejection_reason = $rejection_reason == NULL ? '' : $rejection_reason;

        $data = CatalogSubmission::where('id', $submission_id)->where('ar_status', '<>','0')->get()->toArray();

        $count_data = count($data);
        $update_status = 0;
        $new_wrc_id = 0;
        $massage = "somthing went Wrong!!!";

        if($count_data > 0){
            if($data['0']['ar_status'] == 1){
                $massage = "Wrc already Approved!!!";
            }else{
                $massage = "Wrc already Rejected!!";
            }
        }else{
            DB::beginTransaction();
            try {

                $action_date = date('Y-m-d H:i:s');
                $storeData = CatalogSubmission::find($submission_id);
                $storeData->ar_status = $ar_status;
                $storeData->action_date = $action_date;
                $storeData->rejection_reason = $rejection_reason;
                $update_status = $storeData->update();

                if ($update_status && $ar_status == 2) {
                    // geting data for new wrc
                    $wrc_data = CatlogWrc::where('id', $wrc_id)->get()->toArray();
                    $wrc_data_row = $wrc_data['0'];
                    $new_wrc_number = $wrc_data_row['wrc_number']."R";
                    
                    // geting New Wrc Data
                    $new_wrc_number_data = CatlogWrc::where('wrc_number', $new_wrc_number)->get()->toArray();
                    $new_wrc_count = count($new_wrc_number_data);

                    // genrating new Wrc Id
                    $old_sku_qty = 0;
                    if($new_wrc_count > 0){
                        $new_wrc_number_arr = $new_wrc_number_data['0'];
                        $new_wrc_id = $new_wrc_number_arr['id'];
                        $old_sku_qty = $new_wrc_number_arr['sku_qty'];
                    }else{
                        $save_wrc = new CatlogWrc();
                        // dd($wrc_data_row);
                        $save_wrc->lot_id = $wrc_data_row['lot_id'];
                        $save_wrc->wrc_number = $new_wrc_number;
                        $save_wrc->modeOfDelivary = $wrc_data_row['modeOfDelivary'];
                        $save_wrc->commercial_id = $wrc_data_row['commercial_id'];
                        $save_wrc->status = $wrc_data_row['status'];
                        $save_wrc->ar_status = $wrc_data_row['ar_status'];
                        $save_wrc->alloacte_to_copy_writer = $wrc_data_row['alloacte_to_copy_writer'];
                        $save_wrc->rejection_reason = $wrc_data_row['rejection_reason'];
                        $save_wrc->img_recevied_date = $wrc_data_row['img_recevied_date'];
                        $save_wrc->missing_info_notify_date = $wrc_data_row['missing_info_notify_date'];
                        $save_wrc->missing_info_recived_date = $wrc_data_row['missing_info_recived_date'];
                        $save_wrc->confirmation_date = $wrc_data_row['confirmation_date'];
                        $save_wrc->work_brief = $wrc_data_row['work_brief'];
                        $save_wrc->guidelines = $wrc_data_row['guidelines'];
                        $save_wrc->document1 = $wrc_data_row['document1'];
                        $save_wrc->document1 = $wrc_data_row['document1'];
                        $save_wrc->document2 = $wrc_data_row['document2'];
                        $save_wrc->is_retainer = $wrc_data_row['is_retainer'];
                        $save_wrc->generic_data_format_link = $wrc_data_row['generic_data_format_link'];
                        $save_wrc->img_as_per_guidelines = $wrc_data_row['img_as_per_guidelines'];
                        $save_wrc->sku_qty = $old_sku_qty;
                        $save_wrc->save();
                        $new_wrc_id = $save_wrc->id;
                    }

                    if($new_wrc_id > 0){
                        $WrcSku_data = CatalogWrcSku::where('wrc_id', $wrc_id)->where('batch_no', $batch_no)->get()->toArray();
                        $WrcSku_save_arr = [];
                        $total_sku_data = count($WrcSku_data);
                        foreach ($WrcSku_data as $key => $sku_row) {
                            $skuObj = new CatalogWrcSku();
                            $skuObj->sku_code = $sku_row['sku_code'];
                            $skuObj->style = $sku_row['style'];
                            $skuObj->type_of_service = $sku_row['type_of_service'];
                            $skuObj->wrc_id = $new_wrc_id;
                            $skuObj->batch_no = $sku_row['batch_no'];
                            $skuObj_save = $skuObj->save();
                            array_push($WrcSku_save_arr, $skuObj_save);
                        }
    
                        if($total_sku_data == array_sum($WrcSku_save_arr) && $total_sku_data > 0){
                            $storeWrcBatch = new CatalogWrcBatch();
                            $storeWrcBatch->wrc_id = $new_wrc_id;
                            $storeWrcBatch->batch_no = $batch_no;
                            $storeWrcBatch->sku_count = $total_sku_data;
                            $storeWrcBatch->prequisites = '';
                            $storeWrcBatch_save = $storeWrcBatch->save();
    
                            if($storeWrcBatch_save){
                                $tot_sku_qty_is = $old_sku_qty + $total_sku_data;
                                CatlogWrc::where('id', $new_wrc_id)->update(['sku_qty' => $tot_sku_qty_is]);
                                $massage = "Wrc Rejected!!";
                                DB::commit();
                            }else{
                                $update_status = 0;
                                DB::rollback();
                            }
                        }else{
                            $update_status = 0;
                            DB:: rollback();
                        }
                    }else{
                        $update_status = 0;
                        DB:: rollback();
                    }
                } else if ($update_status && $ar_status == 1) {
                    $massage = "Wrc Approved!!";
                    DB::commit();
                }else{
                    DB::rollback();
                }
            } catch (\Exception $e) {
                DB::rollback();
            }
        }

        $response = array(
            'wrc_id' => $wrc_id,
            'new_wrc_id' => $new_wrc_id,
            'update_status' => $update_status,
            'massage' => $massage,
            'ar_status' => $ar_status,
            'rejection_reason' => $rejection_reason,
        );
        return json_encode($response);
    }
}
