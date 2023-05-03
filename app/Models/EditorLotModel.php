<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditorLotModel extends Model
{
    use HasFactory;
    protected $table = 'editor_lots';
    protected $fillable = ['user_id', 'brand_id', 'lot_number', 'request_name'];

    // get data for create lot
    public static function Index()
    {
        $users_data = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([['users.Company', '<>', NULL], ['roles.name', '=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);
        // dd($users_data);

        $EditorLots = (object) [
            'id' => 0,
            'user_id' => '',
            'brand_id' => '',
            'lot_number' => '',
            'request_name' => '',
            'status' => '',
            'button_name' => 'Create Lot',
            'route' => 'store_editor_lot'
        ];
        return view('EditorLotPanel.Editor-Create-Lot')->with('users_data', $users_data)->with('EditorLots', $EditorLots);
    }

    // store lot data
    public static function store($request)
    {
        $EditorLots = new EditorLotModel();
        $EditorLots->user_id = $request->user_id;
        $EditorLots->brand_id = $request->brand_id;
        $EditorLots->lot_number = "";
        $EditorLots->request_name = $request->request_name;
        $EditorLots->status = 'ready_for_inwarding';
        $EditorLots->save();

        $id =  $EditorLots->id;
        // $request->s_type
        $s_type =  $request->request_name;
        $request_name_array = explode(" ", $s_type);
        $count = count($request_name_array);
        $request_name = "";
        // foreach( $request_name_array  as $key=>$val){
        //     $request_name .= $val[0];
        // }

        $request_name .= $request_name_array[0][0];
        $request_name .= $request_name_array[$count - 1][0];

        // dd($request_name);
        $lot_number = 'ODN' . date('dmY') . "-" . $request->c_short . $request->short_name .  $request_name . $id;
        //update lot number

        EditorLotModel::where('id', $id)->update(['lot_number' => strtoupper($lot_number)]);
        if ($EditorLots) {
            request()->session()->flash('success', 'Lots Created Successfully');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
    }

    // lot listing data
    public static function getEditorLotData()
    {
        $lots = EditorLotModel::orderBy('id', 'DESC')
            ->leftJoin('users', 'users.id', 'editor_lots.user_id')
            ->leftJoin('brands', 'brands.id', 'editor_lots.brand_id')
            ->select('editor_lots.*', 'users.Company', 'users.client_id', 'brands.name')
            ->get();
        return view('EditorLotPanel.Editor-View-Lot')->with('lots', $lots);
    }

    public static function edit($request, $id)
    {
        $users_data = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([['users.Company', '<>', NULL], ['roles.name', '=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);

        $EditorLots =  EditorLotModel::find($id);
        if ($EditorLots) {
            $EditorLots->button_name = 'Update Lot';
            $EditorLots->route = 'editor_update_lot';
            return view('EditorLotPanel.Editor-Create-Lot')->with('users_data', $users_data)->with('EditorLots', $EditorLots);
        }
    }

    // get Editing Lots Wrcs 
    public function getEditingWrc(){
		return $this->hasMany('App\Models\EditingWrc','lot_id','id')->with('getEditingEditedImages:id,user_id,allocation_id,wrc_id,file_path,filename');
	}

    // get Shoot Lots Wrcs 
    public function getShootWrc(){
		return $this->hasMany('App\Models\Wrc','lot_id','id')->with('getWrcSkus:id,lot_id,wrc_id,sku_code,user_id,brand_id');
	}

    // clients Editor Lot Timeline
    public static function clientsEditorLotTimeline($id){
        $lot_info_with_wrc_query = EditorLotModel::where('editor_lots.id', $id)->leftJoin('editing_wrcs', 'editing_wrcs.lot_id', 'editor_lots.id');
    
        $lot_detail = $lot_info_with_wrc_query->select('editor_lots.id as lot_id','editor_lots.lot_number', 'editor_lots.created_at', DB::raw('sum(editing_wrcs.uploaded_img_qty) as inward_quantity'))->get()->toArray();
        
        $wrc_detail_query = $lot_info_with_wrc_query->
        leftJoin('editing_allocations', 'editing_allocations.wrc_id', 'editing_wrcs.id')->
        leftJoin('editing_upload_links', 'editing_upload_links.allocation_id', 'editing_allocations.id')->
        leftJoin('editing_submissions', 'editing_submissions.wrc_id', 'editing_wrcs.id')->    
        select(
        'editing_wrcs.id as wrc_id',
        'editing_wrcs.wrc_number',
        'editing_wrcs.created_at as wrc_created_at',
        'editing_wrcs.documentUrl',
        'editing_wrcs.imgQty as imgqty',
        'editing_wrcs.uploaded_img_qty as wrc_order_qty',
        'editor_lots.id as lot_id',
        'editor_lots.lot_number',
        'editor_lots.request_name',
        'editor_lots.created_at as lot_created_at',

        'editing_allocations.id as allocation_id',
        'editing_allocations.created_at as allocated_created_at',
        'editing_allocations.updated_at as qc_done_at',
        DB::raw('GROUP_CONCAT(editing_allocations.id) as allocation_ids'),
        DB::raw('GROUP_CONCAT(editing_allocations.user_id) as ass_cataloger'),
        DB::raw('GROUP_CONCAT(editing_allocations.user_role) as user_roles'),
        DB::raw('GROUP_CONCAT(editing_allocations.allocated_qty) as tot_allocated_qty_list'),
        DB::raw('GROUP_CONCAT(editing_allocations.uploaded_qty) as tot_uploaded_qty_list'),
        DB::raw('SUM(CASE WHEN editing_allocations.user_role = 0 THEN editing_allocations.allocated_qty else 0 END)  as cata_sum'),

        DB::raw('GROUP_CONCAT(editing_upload_links.id) as uploaded_links_ids'),
        DB::raw('GROUP_CONCAT(editing_upload_links.final_link) as final_links'),
        DB::raw('GROUP_CONCAT(editing_upload_links.task_status) as task_status_list'),
        'editing_submissions.id as submissions_id',
        'editing_submissions.submission_date',
        'editing_submissions.ar_status',
        'editing_submissions.action_date',
        );
        $wrc_detail_query = $wrc_detail_query->orderBy('editing_wrcs.id')->orderBy('editing_allocations.id')->orderBy('editing_upload_links.updated_at')->orderBy('editing_submissions.id');
        $wrc_detail_query = $wrc_detail_query->groupBy('editing_allocations.wrc_id');
        $wrc_detail = $wrc_detail_query->get()->toArray();

        $creative_and_cataloging_lot_statusArr = creative_and_cataloging_lot_statusArr();
        $wrc_count = DB::table('editing_wrcs')->where('lot_id',$id)->count();
        
        $lot_status = $wrc_count > 0 ? $creative_and_cataloging_lot_statusArr[1] : $creative_and_cataloging_lot_statusArr[0];
        $wrc_progress = $wrc_count > 0 ? '20' : '0';
        $overall_progress = $wrc_count > 0 ? '40' : '20';

        $lot_detail[0]['lot_status']  = $lot_status;
        $lot_detail[0]['overall_progress']  = $overall_progress."%";
        $lot_detail[0]['wrc_progress']  = $wrc_progress."%";
        $lot_detail[0]['wrc_assign']  = "0%";
        $lot_detail[0]['wrc_qc']  = "0%";
        $lot_detail[0]['wrc_submission']  = "0%";

        $count_wrc = 0;
        $count_qc = 0;
        $count_submission = 0;

        foreach($wrc_detail as $key => $wrc_row){
            $lot_detail[0]['wrc_created_at']  = $wrc_row['wrc_created_at'];
            $lot_detail[0]['allocated_created_at']  = $wrc_row['allocated_created_at'];
            $cata_sum = $wrc_row['cata_sum'];
            $sku_count = $wrc_row['wrc_order_qty'];
            
            $wrc_detail[$key]['qc_status'] = "Pending";
            $wrc_detail[$key]['submission_status'] = "Pending";
            if($cata_sum > 0){
                $lot_detail[0]['wrc_assign']  = "10%";
                $lot_detail[0]['overall_progress']  = "50%";
                $lot_detail[0]['lot_status']  = $creative_and_cataloging_lot_statusArr[2];

            }
        
            if(($sku_count == $cata_sum) && $sku_count > 0 ){
                $count_wrc++;
                if($wrc_row['submissions_id'] > 0){
                    $wrc_detail[$key]['qc_status'] = "Done";
                    $wrc_detail[$key]['submission_status'] = "Done";
                    $count_qc++;
                    $count_submission++;
                    $lot_detail[0]['qc_done_at']  = $wrc_row['qc_done_at'];
                    $lot_detail[0]['submission_date']  = $wrc_row['submission_date'];
                }else{
                    $allocation_ids = $wrc_row['allocation_ids'];
                    $allocation_id_arr = explode(",",$allocation_ids);                                
                    $tot_allocation_ids = count($allocation_id_arr);
                    
                    $task_status_list = $wrc_row['task_status_list'];
                    $task_status_arr = explode(",",$task_status_list);
                    $tot_task_status = count($task_status_arr);
                    $task_status_sum = array_sum($task_status_arr);

                    if($task_status_sum == (2*$tot_allocation_ids) && $tot_task_status == $tot_allocation_ids){
                        $wrc_detail[$key]['qc_status'] = "Done";
                        $count_qc++;
                        $lot_detail[0]['qc_done_at']  = $wrc_row['qc_done_at'];

                    }else if($task_status_sum == (3*$tot_allocation_ids) && $tot_task_status == $tot_allocation_ids){
                        $wrc_detail[$key]['qc_status'] = "Done";
                        $wrc_detail[$key]['submission_status'] = "Done";
                        $count_qc++;
                        $count_submission++;
                        $lot_detail[0]['qc_done_at']  = $wrc_row['qc_done_at'];
                        $lot_detail[0]['submission_date']  = $wrc_row['submission_date'];
                    }
                }
            }
        }
        if(count($wrc_detail) == $count_wrc && count($wrc_detail) > 0){
            $lot_detail[0]['wrc_assign']  = "20%";
            $lot_detail[0]['overall_progress']  = "60%";
            $lot_detail[0]['lot_status']  = $creative_and_cataloging_lot_statusArr[2];
            if(count($wrc_detail) == $count_qc){
                $lot_detail[0]['wrc_qc']  = "20%";
                $lot_detail[0]['overall_progress']  = "80%";
                $lot_detail[0]['lot_status']  = $creative_and_cataloging_lot_statusArr[3];;
                if(count($wrc_detail) == $count_submission){
                    $lot_detail[0]['lot_status']  = $creative_and_cataloging_lot_statusArr[4];
                    $lot_detail[0]['wrc_submission']  = "20%";
                    $lot_detail[0]['overall_progress']  = "100%";
                }
            }
        }
        // insert into user activity log
        $data_array = array(
            'log_name' => 'Lot Timeline Details',
            'description' => 'Lot Timeline Details',
            'event' => 'Lot Timeline Details',
            'subject_type' => 'App\Models\CreatLots',
            'subject_id' => '0',
            'properties' => [],
        );
        ClientActivityLog::saveClient_activity_logs($data_array);

        return array(
            'lot_detail' => $lot_detail,
            'wrc_detail' => $wrc_detail,
        );

    }


}
