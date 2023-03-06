<?php

namespace App\Http\Controllers;

use App\Models\EditingWrc;
use Illuminate\Support\Facades\DB;

class EditingMasterSheetController extends Controller
{
    public function index()
    {
        $EditingWrcMasterList = EditingWrc::
        leftJoin('editor_lots', 'editor_lots.id', 'editing_wrcs.lot_id')->
        leftJoin('editors_commercials', 'editors_commercials.id', 'editing_wrcs.commercial_id')->
        leftJoin('editing_allocations', 'editing_allocations.wrc_id', 'editing_wrcs.id')->
        leftJoin('editing_upload_links', 'editing_upload_links.allocation_id', 'editing_allocations.id')->
        leftJoin('editing_submissions',  'editing_submissions.wrc_id' , 'editing_wrcs.id' )->
        leftJoin('users', 'editor_lots.user_id', 'users.id')->
        leftJoin('brands', 'brands.id',  'editor_lots.brand_id')->
        leftJoin('users as u1', 'editing_allocations.user_id', 'u1.id')->
        select(
            'editing_wrcs.id as wrc_id_is',
            'editing_wrcs.wrc_number',
            'editing_wrcs.created_at as wrc_created_at',
            'editing_wrcs.imgQty as tot_sku_qty',
            'editing_wrcs.imgQty as imgqty',
            'editor_lots.lot_number',
            'editor_lots.request_name',
            'editors_commercials.type_of_service',
            'editors_commercials.CommercialPerImage',
            'editors_commercials.newCommercialId',
            'editing_submissions.id as submission_id',
            'editing_submissions.submission_date',
            'editing_submissions.ar_status',
            'editing_submissions.ar_status as submission_ar_status',
            'editing_submissions.rejection_reason',
            'editing_submissions.action_date',
            'editing_submissions.*',
            'users.Company as company',
            'users.email',
            'users.email',
            'users.am_email',
            'users.client_id',
            'brands.name as brand_name',
            'editing_wrcs.*',
            DB::raw('SUM(CASE WHEN user_role = 0 THEN allocated_qty else 0 END)  as editor_sum'),
            DB::raw('SUM(allocated_qty)  as wrc_inward_qty'),
            DB::raw('GROUP_CONCAT(u1.name) as ass_users'),
            DB::raw('GROUP_CONCAT(editing_allocations.id) as allocation_ids'),
            DB::raw('GROUP_CONCAT(editing_allocations.created_at) as allocation_created_at'),
            DB::raw('GROUP_CONCAT(editing_upload_links.task_status) as uploading_task_status'),
            DB::raw('GROUP_CONCAT(editing_upload_links.updated_at) as link_updated_at'),
        )
        ->groupBy('editing_allocations.wrc_id')->
        orderBy('editing_wrcs.updated_at', 'DESC')
        ->get()->toArray();
        return view('Wrc.Editing-wrc-master-sheet')->with('EditingWrcMasterList', $EditingWrcMasterList);
    }
}
