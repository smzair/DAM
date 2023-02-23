<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditingAllocation extends Model
{
    use HasFactory;
    protected $table = 'editing_allocations';
    protected $fillable = [
        'user_id', 'wrc_id', 'user_role', 'allocated_qty'
    ];

    // Function for Get WRC list for allocation 
    public static function get_wrc_list_for_allocation($allocation_type = 1)
    {
        if($allocation_type == 1){
            $having_con = "=";
        }else{
            $having_con = ">";
        }
        $wrcList = EditingWrc::
        leftJoin('editing_allocations', 'editing_allocations.wrc_id', 'editing_wrcs.id')->
        leftJoin('editor_lots', 'editor_lots.id', 'editing_wrcs.lot_id')->
        leftJoin('editors_commercials', 'editors_commercials.id', 'editing_wrcs.commercial_id')->
        leftJoin('users', 'editor_lots.user_id', 'users.id')->
        leftJoin('brands', 'brands.id', '=', 'editor_lots.brand_id')->
        leftJoin('users as assign_users', 'editing_allocations.user_id', 'assign_users.id')->
        select(
            'editing_wrcs.id',
            'editing_wrcs.lot_id',
            'editing_wrcs.wrc_number',
            'editing_wrcs.commercial_id',
            'editing_wrcs.imgQty',
            'editing_wrcs.documentType',
            'editing_wrcs.documentUrl',
            'editing_wrcs.work_initiate_date',
            'editing_wrcs.work_committed_date',
            'editing_wrcs.created_at',
            'editing_wrcs.id as wrc_id',
            'editor_lots.lot_number',
            'users.Company',
            'brands.name',
            'editors_commercials.type_of_service',
            DB::raw('GROUP_CONCAT(editing_allocations.user_id) as ass_users'),
            DB::raw('SUM(CASE WHEN user_role = 0 THEN allocated_qty else 0 END)  as editors_sum'),
            DB::raw('GROUP_CONCAT(assign_users.name) as ass_users'),
        )->
        havingRaw("editors_sum $having_con 0 AND editors_sum <> imgQty")->
        // having('editors_sum', $having_con, 0)->
        groupBy('editing_wrcs.id')->
        get()->toArray();
        return $wrcList;
    }

    // save Editing Allocation users 
    public static function saveEditingAllocation($request){
        $user_id = $request->user_id;
        $editor_Qty = $request->editor_Qty;
        $wrc_id = $request->wrc_id;
        $batch_no = $request->batch_no;
        $wrc_batch_id_is = $request->wrc_batch_id_is;
        $work_initiate_date_is = $request->work_initiate_date_is;
        $work_committed_date_is = $request->work_committed_date_is;
        $allocation_type = $request->allocation_type; // 1 for allocation 2 for Re-Allocation
        $res = [];
        // DB::beginTransaction();
        $res['user'] = '0';
        if ($user_id > 0) {
            $CatalogAllocation_list = EditingAllocation::where([
                ['user_id',  $user_id],
                ['wrc_id',  $wrc_id],
            ])->get()->toArray();
            $all_cnt = count($CatalogAllocation_list);

            if ($all_cnt > 0) {
                $res['user'] = '3';
            } else {
                $catalog_allocation_user = new EditingAllocation();
                $catalog_allocation_user->user_id = $user_id;
                $catalog_allocation_user->wrc_id = $wrc_id;
                $catalog_allocation_user->allocated_qty = $editor_Qty;
                $catalog_allocation_user->user_role = 0;
                $status = $catalog_allocation_user->save();
                if ($status) {
                    $res['user'] = '1';
                } else {
                    $res['user'] = '2';
                }
            }
        }
        
        // DB::rollback();
        $updateData = EditingWrc::find($wrc_id);
        if ($allocation_type == 1 || $updateData->work_initiate_date == null || $updateData->work_initiate_date == '0000-00-00') {
            $updateData->work_initiate_date = $work_initiate_date_is != null ? $work_initiate_date_is : $updateData->work_initiate_date;
        }
        if ($allocation_type == 1 || $updateData->work_initiate_date == null || $updateData->work_initiate_date == '0000-00-00') {
            $updateData->work_committed_date = $work_committed_date_is != null ? $work_committed_date_is : $updateData->work_committed_date;
        }
        $update_status = $updateData->update();
        $res['update_status'] = $update_status;
        return $res;
    }

    // Allocated Editors list  
    public static function editing_allocated_Editors_list()
    {
        $editing_allocated_Editors_list = EditingAllocation::leftJoin('users', 'editing_allocations.user_id', 'users.id')->select(
                'editing_allocations.id',
                'editing_allocations.wrc_id',
                'editing_allocations.user_id',
                'users.name as editor',
            )->groupBy('editing_allocations.user_id')->get()->toArray();

        return $editing_allocated_Editors_list;
    }

    //Lot wise Editing allocated user and Wrc List
    public static function editing_allocation_List_by_lot_numbers()
    {

        $editing_allocation_List_by_lot_numbers = EditingAllocation::
        leftJoin('users', 'editing_allocations.user_id', 'users.id')->
        leftJoin('editing_wrcs', 'editing_wrcs.id', 'editing_allocations.wrc_id')->
        leftJoin('editor_lots', 'editor_lots.id', 'editing_wrcs.lot_id')->
        select(
            'editing_allocations.id',
            'editing_allocations.wrc_id',
            'editing_allocations.user_id',
            'users.name as editor',
            'editing_wrcs.imgQty',
            'editing_wrcs.lot_id',
            'editor_lots.lot_number',
            DB::raw('GROUP_CONCAT(editing_allocations.wrc_id) as wrc_ids'),
            DB::raw('GROUP_CONCAT(editing_allocations.allocated_qty) as allocated_qtys'),
            DB::raw('GROUP_CONCAT(editing_wrcs.wrc_number) as wrc_numbers'),
            DB::raw('COUNT(editing_allocations.wrc_id) as wrc_cnt'),
            DB::raw('sum(editing_allocations.allocated_qty) as tot_sku_qty')
        )->
        groupBy(['editing_allocations.user_id', 'editor_lots.id'])->
        orderBy('editing_allocations.wrc_id', 'asc')->
        get()->
        toArray();
        return $editing_allocation_List_by_lot_numbers;
    }

    // allocated list for upload 
    public static function allocated_wrc_list_by_user($login_user_id_is)
    {
        $allocated_wrc_list_by_user = EditingAllocation::
        select(
            'editing_allocations.id',
            'editing_allocations.wrc_id',
            'editing_allocations.user_id',
            'editing_allocations.user_role',
            'editing_allocations.allocated_qty',
            DB::raw('GROUP_CONCAT(editing_allocations.user_id) as ass_cataloger'),
            DB::raw('GROUP_CONCAT(editing_allocations.id) as allocations_ids'),
            DB::raw('GROUP_CONCAT(editing_allocations.user_role) as user_roles'),
        )->groupBy('editing_allocations.wrc_id')->
        get()->toArray();
        return $allocated_wrc_list_by_user;
    }

    public static function get_Editing_Allocation_List($login_user_id = 0)
    {
        $editing_allocation_list = EditingAllocation::
        where('editing_allocations.user_id', $login_user_id)->
        leftJoin('editing_wrcs', 'editing_wrcs.id', 'editing_allocations.wrc_id')->
        leftJoin('editors_commercials', 'editors_commercials.id', 'editing_wrcs.commercial_id')->
        leftJoin('catalog_time_hash', 'catalog_time_hash.allocation_id', 'editing_allocations.id')->
        leftJoin('editor_lots', 'editor_lots.id', 'editing_wrcs.lot_id')->
        leftJoin('users', 'users.id', 'editor_lots.user_id')->
        leftJoin('brands', 'brands.id', 'editor_lots.brand_id')->select(
            'editing_allocations.id as allocation_id_is',
            'editing_allocations.wrc_id',
            'editing_allocations.allocated_qty',

            'editing_wrcs.wrc_number',
            'editing_wrcs.imgQty',
            'editing_wrcs.lot_id',
            'editing_wrcs.commercial_id',
            'editing_wrcs.documentType',
            'editing_wrcs.documentUrl',
            'editing_wrcs.created_at',

            'editor_lots.lot_number',
            'editors_commercials.type_of_service',
            'users.Company',
            'brands.name as brand_name',
            DB::raw('GROUP_CONCAT(editing_allocations.user_id) as ass_cataloger'),
            DB::raw('GROUP_CONCAT(editing_allocations.user_role) as user_roles'),
        )->groupBy('editing_allocations.wrc_id')->orderBy('editing_allocations.updated_at', 'DESC')->get()->toArray();
        return $editing_allocation_list;
    }


}
