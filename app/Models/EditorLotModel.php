<?php

namespace App\Models;

use App\Models\NotificationModel\ClientNotification;
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
            $save_ClientNotification_data = array(
                'user_id' => $EditorLots['user_id'],
                'brand_id' => $EditorLots['brand_id'],
                'wrc_number' => $lot_number,
                'service_number' => $lot_number,
                'service' => 'Editing',
                'subject' => 'Creation',
                'Creation_for' => 'Lot'
            );
            ClientNotification::save_ClientNotification($save_ClientNotification_data);
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
        
        $lot_detail = EditorLotModel::where('editor_lots.id', $id)->leftJoin('editing_wrcs', 'editing_wrcs.lot_id', 'editor_lots.id')->
        leftjoin('editors_commercials' ,'editors_commercials.id' , 'editing_wrcs.commercial_id' )->
        leftjoin('users' ,'users.id' , 'editor_lots.user_id' )->
        leftjoin('brands' , 'brands.id' , 'editor_lots.brand_id')->
        select(
            'editor_lots.id',
            'editor_lots.id as lot_id',
            'editor_lots.created_at as lot_created_at',
            DB::raw("DATE_FORMAT(editor_lots.created_at, '%d-%m-%Y') as lots_formatted_date"),
            'editor_lots.lot_number', 'editor_lots.created_at', 'users.Company as company_name',
        'users.c_short as company_c_short',
        'brands.name as brand_name',
        'brands.short_name as brand_short_name', DB::raw('sum(editing_wrcs.uploaded_img_qty) as inward_quantity'))->get()->toArray();
        
        $lot_info_with_wrc_query = EditorLotModel::where('editing_wrcs.lot_id', $id)->leftJoin('editing_wrcs', 'editing_wrcs.lot_id', 'editor_lots.id')->
        leftjoin('editors_commercials' ,'editors_commercials.id' , 'editing_wrcs.commercial_id' )->
        leftjoin('users' ,'users.id' , 'editor_lots.user_id' )->
        leftjoin('brands' , 'brands.id' , 'editor_lots.brand_id');
        
        $wrc_detail_query = $lot_info_with_wrc_query->
        leftJoin('editing_allocations', 'editing_allocations.wrc_id', 'editing_wrcs.id')->
        leftJoin('editing_upload_links', 'editing_upload_links.allocation_id', 'editing_allocations.id')->
        leftJoin('editing_submissions', 'editing_submissions.wrc_id', 'editing_wrcs.id')->    
        select(
        'editing_wrcs.id as wrc_id',
        'editing_wrcs.wrc_number',
        'editing_wrcs.created_at as wrc_created_at',
        DB::raw("DATE_FORMAT(editing_wrcs.created_at, '%d-%m-%Y') as wrc_formatted_date"),
        'editing_wrcs.documentUrl',
        'editing_wrcs.invoice_number',
        'editing_wrcs.updated_at',
        'editing_wrcs.imgQty as imgqty',
        'editing_wrcs.uploaded_img_file_path',
        'editing_wrcs.uploaded_img_qty as wrc_order_qty',
        'editor_lots.id as lot_id',
        'editor_lots.lot_number',
        'editor_lots.request_name',
        'editor_lots.created_at as lot_created_at',
        DB::raw("DATE_FORMAT(editor_lots.created_at, '%d-%m-%Y') as lots_formatted_date"),
        'editors_commercials.type_of_service',
        'editors_commercials.CommercialPerImage',
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
        'editing_submissions.action_date'
        );
        $wrc_detail_query = $wrc_detail_query->orderBy('editing_wrcs.id')->orderBy('editing_allocations.id')->orderBy('editing_upload_links.updated_at')->orderBy('editing_submissions.id');
        $wrc_detail_query = $wrc_detail_query->groupBy('editing_wrcs.id');
        $wrc_detail = $wrc_detail_query->get()->toArray();

        $Editing_lot_statusArr = Editing_lot_statusArr();
        $lot_status_percentage = lot_status_percentage();
        $wrc_count = DB::table('editing_wrcs')->where('lot_id',$id)->count();
        
        $lot_status = $wrc_count > 0 ? $Editing_lot_statusArr[1] : $Editing_lot_statusArr[0];
        $wrc_progress = $wrc_count > 0 ? $lot_status_percentage[1] - $lot_status_percentage[0] : '0';
        $overall_progress = $wrc_count > 0 ? $lot_status_percentage[1] : $lot_status_percentage[0];

        $lot_detail[0]['lot_status']  = $lot_status;
        $lot_detail[0]['overall_progress']  = $overall_progress."%";
        $lot_detail[0]['wrc_progress']  = $wrc_progress."";
        $lot_detail[0]['wrc_assign']  = "0";
        $lot_detail[0]['wrc_qc']  = "0";
        $lot_detail[0]['wrc_submission']  = "0";
        $lot_detail[0]['submission_date']  = '';
        $lot_detail[0]['file_path'] =  '';
        $lot_detail[0]['skus_count'] =  '';
        $lot_detail[0]['raw_images'] =  '';
        $lot_detail[0]['edited_images'] =  '';
        $lot_detail[0]['s_type'] =  '';
        $lot_detail[0]['wrc_numbers'] =  '';
        $lot_detail[0]['wrc_created_at']  = '';
        $lot_detail[0]['allocated_created_at']  = '';
        $lot_detail[0]['lot_invoiceing']  = "0";
        $lot_detail[0]['lot_invoice_date']  = null;

        if(count($wrc_detail) > 0){
            $lot_detail[0]['wrc_numbers'] =  implode(', ',array_column($wrc_detail , 'wrc_number'));
          }

        $count_wrc = 0;
        $count_qc = 0;
        $count_submission = 0;
        $lots_file_path = "";
        $invoce_done_wrc = 0;
        $invoce_parcially_done_wrc = 0;
        

        foreach($wrc_detail as $key => $wrc_row){
            $uploaded_img_file_path = $wrc_row['uploaded_img_file_path'];
            $wrc_id_arr = explode(',', $wrc_row['wrc_id']);
            $editing_uploaded_images = EditingUploadedImages::whereIn('editing_uploaded_images.wrc_id', $wrc_id_arr)->get()->toArray();
            $file_path = "";

            foreach ($editing_uploaded_images as $key_is => $item) {
                if($file_path != ""){
                    break;
                }
                $path= $item['file_path']. $item['filename'];
                $path1 = $uploaded_img_file_path. $item['filename'];
                if(file_exists($path)){
                    $file_path = $path;
                }else if(file_exists($path1)){
                    $file_path = $path1;
                }
            }
            if($lots_file_path == '' && $file_path != ''){
                $lots_file_path = $file_path;
            }
            $lot_detail[0]['file_path'] = $lots_file_path;
            $wrc_detail[$key]['file_path'] = $file_path;
            
            $lot_detail[0]['wrc_created_at']  = $wrc_row['wrc_created_at'];
            $lot_detail[0]['allocated_created_at']  = $wrc_row['allocated_created_at'];
            $cata_sum = $wrc_row['cata_sum'];
            $sku_count = $wrc_row['wrc_order_qty'];
            
            $wrc_detail[$key]['qc_status'] = "Pending";
            $wrc_detail[$key]['submission_status'] = "Pending";
            $wrc_detail[$key]['invoice_date'] =  '';
            $wrc_detail[$key]['wrc_current_status'] =  1;
            $wrc_detail[$key]['service'] =  'EDITING';
            if($cata_sum > 0){
                $lot_detail[0]['wrc_assign']  = 9;
                $lot_detail[0]['overall_progress']  = $lot_status_percentage[1] + 9;        
                $lot_detail[0]['lot_status']  = $Editing_lot_statusArr[2];
                $wrc_detail[$key]['wrc_current_status'] =  2;

            }
        
            if(($sku_count == $cata_sum) && $sku_count > 0 ){
                $count_wrc++;
                $wrc_detail[$key]['wrc_current_status'] =  2;
                if($wrc_row['submissions_id'] > 0){
                    $wrc_detail[$key]['qc_status'] = "Done";
                    $wrc_detail[$key]['submission_status'] = "Done";
                    $count_qc++;
                    $count_submission++;
                    $lot_detail[0]['qc_done_at']  = $wrc_row['qc_done_at'];
                    $lot_detail[0]['submission_date']  = $wrc_row['submission_date'];
                    $wrc_detail[$key]['wrc_current_status'] =  5;

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
                        $wrc_detail[$key]['wrc_current_status'] =  3;

                    }else if($task_status_sum == (3*$tot_allocation_ids) && $tot_task_status == $tot_allocation_ids){
                        $wrc_detail[$key]['qc_status'] = "Done";
                        $wrc_detail[$key]['submission_status'] = "Done";
                        $count_qc++;
                        $count_submission++;
                        $lot_detail[0]['qc_done_at']  = $wrc_row['qc_done_at'];
                        $lot_detail[0]['submission_date']  = $wrc_row['submission_date'];
                        $wrc_detail[$key]['wrc_current_status'] =  5;
                    }
                }

                // code for invoicing
                if($wrc_detail[$key]['qc_status'] == 'Done'){
                    $invoice_number = $wrc_row['invoice_number'];
                    $wrc_detail[$key]['invoice_date'] = $wrc_row['updated_at'];
                    $lot_detail[0]['lot_invoice_date'] = $wrc_row['updated_at'];
                    $wrc_id = $wrc_row['wrc_id'];
                    if($invoice_number != '' && $invoice_number != null ){
                        $invoce_done_wrc += 1;
                        $wrc_detail[$key]['wrc_current_status'] =  4;
                    
                    }else{
                        $pre_invoice_data = DB::table('pre_invoice')->where('service_id' , '=' , '4')->where('wrc_id' , '=' , $wrc_id)->get()->toArray();
                        if(count($pre_invoice_data) > 0 ){
                            $invoce_parcially_done_wrc += 1; 
                            if($pre_invoice_data[0]->invoice_group_id > 0){
                                $invoce_done_wrc += 1;
                                $lot_detail[0]['lot_invoice_date']  = $pre_invoice_data[0]->updated_at;
                                $wrc_detail[$key]['wrc_current_status'] =  4;
                            }
                        }
                    }
                    if($wrc_detail[$key]['submission_status'] == "Done" && $wrc_detail[$key]['wrc_current_status'] ==  4){
                        $wrc_detail[$key]['wrc_current_status'] =  5;
                    }
                }
            }
        }
        if(count($wrc_detail) == $count_wrc && count($wrc_detail) > 0){
            // $lot_detail[0]['wrc_assign']  = "20";
            // $lot_detail[0]['overall_progress']  = "60";
            $lot_detail[0]['wrc_assign']  = $lot_status_percentage[2] - $lot_status_percentage[1];
            $lot_detail[0]['overall_progress']  = $lot_status_percentage[2];
            $lot_detail[0]['lot_status']  = $Editing_lot_statusArr[2];
            if(count($wrc_detail) == $count_qc){
                $lot_detail[0]['overall_progress']  = $lot_status_percentage[3];
                $lot_detail[0]['wrc_qc']  = $lot_status_percentage[3] - $lot_status_percentage[2];
                $lot_detail[0]['lot_status']  = $Editing_lot_statusArr[3];

                // Lot invoicing 
                if ($invoce_done_wrc == $count_wrc) {
                    $lot_detail[0]['overall_progress']  = $lot_status_percentage[4];
                    $lot_detail[0]['lot_invoiceing']  = $lot_status_percentage[4] - $lot_status_percentage[3];
                    $lot_detail[0]['lot_status']  = $Editing_lot_statusArr[4];
                }else if($invoce_parcially_done_wrc > 0){
                    $lot_invoiceing  = 7 ;                           
                    $lot_detail[0]['lot_invoiceing']  = $lot_invoiceing ;
                    $lot_detail[0]['overall_progress']  = $lot_status_percentage[3] + $lot_invoiceing ;
                    $lot_detail[0]['lot_status']  = $Editing_lot_statusArr[4];
                }
                if(count($wrc_detail) == $count_submission && $invoce_done_wrc == $count_wrc){
                    $lot_detail[0]['lot_status']  = $Editing_lot_statusArr[5];
                    $lot_detail[0]['wrc_submission']  = $lot_status_percentage[5] - $lot_status_percentage[4];
                    $lot_detail[0]['overall_progress']  = "100";
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
        // ClientActivityLog::saveClient_activity_logs($data_array);

        return array(
            'lot_detail' => $lot_detail,
            'wrc_detail' => $wrc_detail,
        );

    }


}
