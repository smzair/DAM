<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CatalogSubmission extends Model
{
    use HasFactory;
    protected $table = 'catalog_submissions';
    protected $fillable = [
        'id', 'wrc_id', 'batch_no' , 'submission_date'
    ];

    // catalog Wrc list for Submission
    public static function catalog_Wrc_list_for_Submission($tsak_status_is)
    {
        $catalog_Wrc_list_for_Submission = CatalogAllocation::
        WHERE('catalog_time_hash.task_status', '=', $tsak_status_is)->
        WHERE('lots_catalog.lot_number', '<>', null)->
        leftJoin(
            'catalog_wrc_batches',
            function ($join) {
                $join->on('catalog_wrc_batches.wrc_id', '=', 'catalog_allocation.wrc_id');
                $join->on('catalog_wrc_batches.batch_no', '=', 'catalog_allocation.batch_no');
            }
        )->leftJoin('catlog_wrc', 'catlog_wrc.id', 'catalog_allocation.wrc_id')->
        leftJoin('lots_catalog', 'lots_catalog.id', 'catlog_wrc.lot_id')->
        leftJoin('create_commercial_catalog', 'create_commercial_catalog.id', 'catlog_wrc.commercial_id')->
        leftJoin('catalog_upload_links', 'catalog_upload_links.allocation_id', 'catalog_allocation.id')->
        leftJoin('catalog_time_hash', 'catalog_time_hash.allocation_id', 'catalog_allocation.id')->
        leftJoin('users', 'users.id', 'lots_catalog.user_id')->
        leftJoin('brands', 'brands.id', 'lots_catalog.brand_id')->
        leftJoin('users as allocated_users', 'allocated_users.id', 'catalog_allocation.user_id')->
        select(
            'catalog_allocation.allocated_qty',
            'catalog_allocation.user_id',
            'catalog_allocation.user_role',
            'catalog_allocation.allocated_qty',
            'catalog_allocation.wrc_id',
            'catalog_wrc_batches.batch_no',
            'catalog_wrc_batches.sku_count as sku_qty',
            'catalog_wrc_batches.created_at as wrc_created_at',
            'catlog_wrc.lot_id',
            'catlog_wrc.wrc_number',
            'catlog_wrc.commercial_id',
            'catlog_wrc.alloacte_to_copy_writer',
            'catlog_wrc.sku_qty as wrc_t_sku_qty',
            'catlog_wrc.work_brief',
            'catlog_wrc.modeOfDelivary',
            'lots_catalog.brand_id',
            'lots_catalog.lot_number',
            'lots_catalog.serviceType as kind_of_work',
            'create_commercial_catalog.market_place',
            'create_commercial_catalog.type_of_service as project_type',
            'catalog_time_hash.task_status',
            'catalog_time_hash.spent_time',
            'catalog_time_hash.rework_count',
            'users.Company as company',
            'users.c_short',
            'brands.name as brands_name',
            'brands.short_name',
            DB::raw('GROUP_CONCAT(catalog_allocation.id) as allocation_ids'),
            DB::raw('GROUP_CONCAT(catalog_allocation.wrc_id) as wrc_ids'),
            DB::raw('GROUP_CONCAT(catalog_allocation.user_id) as allocated_users_id'),
            DB::raw('GROUP_CONCAT(catalog_allocation.user_role) as user_roles'),
            DB::raw('SUM(CASE WHEN catalog_allocation.user_role = 0 THEN catalog_allocation.allocated_qty else 0 END)  as cataloger_allocated_qty'),
            DB::raw('SUM(CASE WHEN catalog_allocation.user_role = 1 THEN catalog_allocation.allocated_qty else 0 END)  as cp_allocated_qty'),
            DB::raw('sum(catalog_allocation.allocated_qty) as tot_sku_qty'),

            DB::raw('COUNT(catalog_allocation.wrc_id) as wrc_cnt'),
            DB::raw('COUNT(catalog_allocation.user_role) as cnt_user_role'),

            DB::raw('GROUP_CONCAT(catalog_upload_links.final_link) as final_link_list'),
            DB::raw('GROUP_CONCAT(catalog_upload_links.catalog_link) as catalog_links'),
            DB::raw('GROUP_CONCAT(catalog_upload_links.copy_link) as copy_links'),

            DB::raw('GROUP_CONCAT(catalog_time_hash.id) as time_hash_ids'),
            DB::raw('GROUP_CONCAT(catalog_time_hash.spent_time) as tot_spent_time'),
            DB::raw('GROUP_CONCAT(catalog_time_hash.ini_start_time) as ini_start_times'),
            DB::raw('GROUP_CONCAT(catalog_time_hash.ini_end_time) as ini_end_times'),

            DB::raw('GROUP_CONCAT(catalog_allocation.id) as catalog_allocation_ids'),
            DB::raw('GROUP_CONCAT(allocated_users.id) as allo_users_id'),
            DB::raw('GROUP_CONCAT(allocated_users.name) as allocated_users_name')
        )->
        selectRaw('(SELECT batch from catalog_wrc_skus WHERE catalog_wrc_skus.batch_no = catalog_wrc_batches.batch_no AND catalog_wrc_batches.wrc_id = catalog_wrc_skus.wrc_id limit 1) as "batch"')->
        groupBy(['catalog_allocation.wrc_id', 'catalog_allocation.batch_no'])->get()->toArray();
        return $catalog_Wrc_list_for_Submission;
    }

    // complte wrc submission
    public static function comp_submission($wrc_id , $batch_no , $submission_date, $catalog_allocation_ids ){

        $submission_id = CatalogSubmission::
        where('wrc_id', $wrc_id)->where('batch_no', $batch_no)->
        get(['id'])->first();
        $submission_id_is = $submission_id != null ?  $submission_id->id : 0;
        $status = 0;
        $massage = "somthing went wrong";
        $task_update_status = $task_status = "";
        if($submission_id_is > 0){
            $status = 2;
            $massage = "Wrc Already submitted";
        }else{
            $store_data = new CatalogSubmission();
            $store_data->wrc_id = $wrc_id;
            $store_data->batch_no = $batch_no;
            $store_data->submission_date = $submission_date;
            
            $status = $store_data->save();
            $massage = "Wrc Submission Done!!";

            if($status){
                $ids = explode(',', $catalog_allocation_ids);
                $task_update_status = CatalogTimeHash::whereIn('allocation_id', $ids)
                    ->update(['task_status' => 3]);
            }
        }

        return json_encode(array(
            'submission_id' => $submission_id,
            'submission_id_is' => $submission_id_is,
            'task_status' => $task_status,
            'task_update_status' => $task_update_status,
            'status' => $status,
            'massage' => $massage
        ));
    }

    // comp_submission_details
    public static function comp_submission_details($wrc_id){
        $comp_submission_details = CatalogSubmission::
        WHERE('wrc_id' , '=', $wrc_id)->
        select(
            'wrc_id',
            DB::raw('DATE_FORMAT(submission_date, "%d-%m-%Y") as submission_date')
        )->
        get()->toArray(); 

        return json_encode($comp_submission_details);

    }

    // Catalog Wrc List For Invoice Genrate 
    public static function catalog_Wrc_For_Invoice($tsak_status_is)
    {
        $catalog_Wrc_list_for_Submission = CatalogSubmission::
        WHERE('catalog_submissions.ar_status', '=', '1')->
        WHERE('lots_catalog.lot_number', '<>', null)->
        leftJoin(
            'catalog_wrc_batches',
            function ($join) {
                $join->on('catalog_wrc_batches.wrc_id', '=', 'catalog_submissions.wrc_id');
                $join->on('catalog_wrc_batches.batch_no', '=', 'catalog_submissions.batch_no');
            }
        )->
        leftJoin('catlog_wrc', 'catlog_wrc.id', 'catalog_submissions.wrc_id')->
        leftJoin('lots_catalog', 'lots_catalog.id', 'catlog_wrc.lot_id')->
        leftJoin('create_commercial_catalog', 'create_commercial_catalog.id', 'catlog_wrc.commercial_id')->
        leftJoin('users', 'users.id', 'lots_catalog.user_id')->
        leftJoin('brands', 'brands.id', 'lots_catalog.brand_id')->
        select(
            'lots_catalog.lot_number',
            'users.Company as company',
            'brands.name as brands_name',
            'lots_catalog.serviceType as kind_of_work',
            'catlog_wrc.wrc_number',
            'catalog_wrc_batches.batch_no',
            'catalog_wrc_batches.sku_count as sku_qty',
            'create_commercial_catalog.CommercialSKU',
            'catalog_wrc_batches.invoiceNumber',
            'catalog_wrc_batches.id as submissionId',
            // 'catalog_submissions.id as submissionId',
            'catalog_wrc_batches.created_at as wrc_created_at',
            'catalog_wrc_batches.wrc_id',
            'catlog_wrc.commercial_id',
            'catlog_wrc.alloacte_to_copy_writer',
            'catlog_wrc.sku_qty as wrc_t_sku_qty',
            'catlog_wrc.work_brief',
            'catlog_wrc.modeOfDelivary',
            'catlog_wrc.lot_id',
            'lots_catalog.brand_id',
            'create_commercial_catalog.market_place',
            'create_commercial_catalog.type_of_service as project_type',
            'users.c_short',
            'brands.short_name'
        )->
        selectRaw('(SELECT batch from catalog_wrc_skus WHERE catalog_wrc_skus.batch_no = catalog_wrc_batches.batch_no AND catalog_wrc_batches.wrc_id = catalog_wrc_skus.wrc_id limit 1) as "batch"')->
        groupBy(['catalog_submissions.wrc_id', 'catalog_submissions.batch_no'])->
        orderBy('catalog_submissions.updated_at')->
        get()->toArray();
        return $catalog_Wrc_list_for_Submission;
    }

    // Catalog Wrc Invoice Save / Update
    public static function SaveCatalogInvoiceNumber($request)
    {
        $submission_id = $request->submission_id;
        $wrc_id = $request->wrc_id;
        $batch_no = $request->batch_no;
        $invoiceNumber = $request->invoiceNumber;
        $update_status = 0;
        $massage = "somthing went Wrong!!!";

        $update_status = CatalogWrcBatch::where('id', $submission_id)->update(['invoiceNumber' => $invoiceNumber]);
        if($update_status){
            $massage = "Wrc Invoice Number Updated!!";
        }

        $response = array(
            'wrc_id' => $wrc_id,
            'batch_no' => $batch_no,
            'update_status' => $update_status,
            'massage' => $massage,
        );
        return json_encode($response);
    }
    
}
