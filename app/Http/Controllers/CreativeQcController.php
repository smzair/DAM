<?php

namespace App\Http\Controllers;

use App\Models\CreativeAllocation as ModelsCreativeAllocation;
use App\Models\CreativeQcComments;
use App\Models\CreativeTimeHash;
use App\Models\CreativeUploadLink as ModelsCreativeUploadLink;
use App\Models\CreativeWrcBatch as ModelsCreativeWrcBatch;
use App\Models\CreativeWrcModel;
use Carbon\Carbon;
use CreativeAllocation;
use CreativeUploadLink;
use CreativeWrcBatch;
use CreativeWrcs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;
use stdClass;

class CreativeQcController extends Controller
{
    /*get data  for qc list*/
    public function getDataForQcList(){
        $QcList  = [];
        $QcList = ModelsCreativeUploadLink::getDataForQcList();
        return view('Qc.qc-creative')->with('QcList', $QcList );
    }

    /*get user list for rework */
    public function getUserListForRework(Request $request){

        $filter_wrc_id = $request->filter_wrc_id;
        // dd($filter_wrc_id);
        $filter_user_role = $request->filter_user_role;
        $final_user_id_arr = [];

        $all_user_id = ModelsCreativeUploadLink::getCwGdUserList($filter_user_role);

        $gd_user_id_data = $all_user_id['gd_user_id_data'];
        $cw_user_id_data = $all_user_id['cw_user_id_data'];

        if($filter_user_role == 'GD'){
            $final_user_id_arr = $gd_user_id_data;
        }

        if($filter_user_role == 'CW'){
            $final_user_id_arr = $cw_user_id_data;
        }

        $resData = ModelsCreativeAllocation::where('wrc_id', $filter_wrc_id)->whereIn('user_id',$final_user_id_arr)
        ->leftJoin('users as users', 'users.id','creative_allocation.user_id')
        ->leftJoin('creative_time_hash as creative_time_hash', 'creative_time_hash.allocation_id','creative_allocation.id')
        ->select('users.id','users.name','creative_allocation.id as creative_allocation_id','creative_time_hash.is_rework')
        ->groupBy('users.id')
        ->get();

        echo  $resData;

    }

    // store user data for rework

    public function storeUserDataForRework(Request $request){

        try{

            DB::beginTransaction();
            // dd($request);

            $wrc_id = $request->wrc_id;
            $creative_cw_gd_user = $request->creative_cw_gd_user; // copy writer or graphics designer user id
            $comments = $request->commentsec;

            $allocation_id_data = ModelsCreativeAllocation::where('wrc_id', $wrc_id)->where('user_id',$creative_cw_gd_user)->first(['id']);
            // dd( $allocation_id_data );

            $allocation_id = $allocation_id_data != NULL ? $allocation_id_data->id : 0;

            $old_rework_count_data = CreativeTimeHash::where('allocation_id',$allocation_id)->get(['start_time','end_time','spent_time','rework_count','is_rework','task_status'])->first();

            // dd($allocation_id);

            $is_rework = $old_rework_count_data != NULL ? $old_rework_count_data->is_rework : 0;



            $task_status = $old_rework_count_data != NULL ? $old_rework_count_data->task_status : 0;
            $start_time = $old_rework_count_data != NULL ? $old_rework_count_data->start_time : 0;
            $end_time = $old_rework_count_data != NULL ? $old_rework_count_data->end_time : 0;
            $spent_time = $old_rework_count_data != NULL ? $old_rework_count_data->spent_time : 0;
            $rework_count = $old_rework_count_data != NULL ? $old_rework_count_data->rework_count : 0;

            // Wrc Not Completed No need for rework
            if($task_status != 1){
                // dd($allocation_id);
                request()->session()->flash('error','Wrc Not Completed No need for rework');
                return $this->getDataForQcList();
            }

            $new_spent_time = 0;
            $new_rework_count = 0;

            if( $spent_time == 0){
                $new_spent_time = $spent_time;// calulated ( $end_time- $start_time )
            }else{
                $new_spent_time = (new Carbon($end_time ))->diff(new Carbon($start_time))->format('%h:%I');
            }

            $new_rework_count = $rework_count + 1;
            $is_rework = 1;
            $task_status = 0;

            $new_start_time = '0000-00-00 00:00:00';
            $new_end_time = '0000-00-00 00:00:00';

           $check_time_has = CreativeTimeHash::where('allocation_id',$allocation_id)->get()->count();

            //    dd( $check_time_has );
            // if allocation id not found
           if($check_time_has == 0){
            request()->session()->flash('error','Wrc Not started by user No need for rework!!');
			return $this->getDataForQcList();
           }

            $success =  CreativeTimeHash::where('allocation_id',$allocation_id)->update(['spent_time'=>$spent_time, 'rework_count'=> $rework_count, 'is_rework'=> $is_rework, 'task_status'=> $task_status, 'end_time'=> $new_end_time, 'start_time'=> $new_start_time]);

            // create creative comments
            $commentsData = new CreativeQcComments();
            $commentsData->allocation_id = $allocation_id;
            $commentsData->comments = $comments;
            $commentsData->save();

                 
            if($success){
                request()->session()->flash('success','Rework Successfully started');
            }
            else{
                request()->session()->flash('error','Please try again!!');
            }

			DB::commit();

			return $this->getDataForQcList();

		} catch (\Throwable $th) {
			DB::rollback();
			throw $th;
		}
    }

    public function checkCompletedWrc(Request $request){
        
        $wrc_id = $request->wrc_id;
        $button_action =  $request->button_action;

        $all_creative_allocation = ModelsCreativeAllocation::where('wrc_id', $wrc_id)
        ->leftJoin('creative_time_hash', 'creative_time_hash.allocation_id', 'creative_allocation.id')
        // ->where('creative_time_hash.task_status', '!=', null)
        // ->where('creative_time_hash.task_status', '!=', 2)
        ->select('creative_time_hash.task_status','creative_time_hash.allocation_id')
        ->get();

        $check = 1;

        // dd($all_creative_allocation);

        if($button_action == 'Pending'){
            foreach($all_creative_allocation as $key => $val){
                $check_task_status = $val['task_status'];
                if(($check_task_status != 1) && ($check_task_status != 2)){
                    $check = 0;
                }

                
            }
    
            if($check == 1){
                foreach($all_creative_allocation as $key => $val){
                    $allocation_id = $val['allocation_id'];
                    CreativeTimeHash::where('allocation_id',$allocation_id)->update(['task_status'=>2]);
                }
                CreativeWrcModel::where('id', $wrc_id )->update(['qc_status'=>1]);
                /* send notification start */

                $creative_time_hash_data = CreativeTimeHash::where('allocation_id',$allocation_id)->first(['task_status','is_rework']);
                $is_rework = $creative_time_hash_data != null ? $creative_time_hash_data->is_rework : "";
                $task_status = $creative_time_hash_data != null ? $creative_time_hash_data->task_status : "";


                $wrc_data = CreativeWrcModel::where('id',$wrc_id)->first(['wrc_number','qc_status']);
                $wrc_number = $wrc_data != null ? $wrc_data->wrc_number : "";
                $max_batch_no = ModelsCreativeWrcBatch::where('wrc_id', $wrc_id)->max('batch_no');
                $qc_status = $wrc_data != null ? $wrc_data->qc_status : "";
                $batch_no = "";
                $data = new stdClass();
                $data->batch_no = $batch_no;
                $data->wrc_number = $wrc_number;
                $data->batch_no = $max_batch_no == 0 ? 'None' : $max_batch_no;
                $data->qc_status = $is_rework == 1 ? 'Rework' : ( $task_status == 2 ? "Completed" : "Pending");
                $creation_type = 'Qc';
                $this->send_notification($data, $creation_type);
                /******  send notification end*******/
            }


        }

        if($button_action == 'Completed'){
    
                foreach($all_creative_allocation as $key => $val){
                    $allocation_id = $val['allocation_id'];
                    CreativeTimeHash::where('allocation_id',$allocation_id)->update(['task_status'=>1]);
    
                }
                
                CreativeWrcModel::where('id', $wrc_id )->update(['qc_status'=>0]);
        }
        echo $check;
    }

    public function cwCheckCompletedWrc(Request $request){
        // dd($request);
        $wrc_id = $request->wrc_id;
        $button_action =  $request->button_action;


        $cw_role_data = DB::table('roles')->where('name','=','CW')->first(['id']);
        $cw_id = $cw_role_data != null ? $cw_role_data->id : 0;   

        $copy_writer_users_data = DB::table('users')
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
        ->where([['model_has_roles.role_id','=', $cw_id]])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);

        // dd(dump($copy_writer_users_data));

        $cw_user_id_data = [];
        foreach($copy_writer_users_data as $ckey => $cval){
            array_push($cw_user_id_data,$cval->id);
        }

        $all_creative_allocation = ModelsCreativeAllocation::where('wrc_id', $wrc_id)
        ->leftJoin('creative_time_hash', 'creative_time_hash.allocation_id', 'creative_allocation.id')
        // ->where('creative_time_hash.task_status', '!=', null)
        // ->where('creative_time_hash.task_status', '!=', 2)
        ->whereIn('creative_allocation.user_id',$cw_user_id_data)
        ->select('creative_time_hash.task_status','creative_time_hash.allocation_id')
        ->get();
        $check = 1;

        // dd($all_creative_allocation);

        if($button_action == 'Pending'){
            foreach($all_creative_allocation as $key => $val){
                $check_task_status = $val['task_status'];
                if(($check_task_status != 1) && ($check_task_status != 2)){
                    $check = 0;
                }
            }
    
            if($check == 1){
                foreach($all_creative_allocation as $key => $val){
                    $allocation_id = $val['allocation_id'];
                    CreativeTimeHash::where('allocation_id',$allocation_id)->update(['task_status'=>2]);
    
                }
                CreativeWrcModel::where('id', $wrc_id )->update(['cw_qc_status'=>1]);
            }
        }

        if($button_action == 'Completed'){
    
                foreach($all_creative_allocation as $key => $val){
                    $allocation_id = $val['allocation_id'];
                    CreativeTimeHash::where('allocation_id',$allocation_id)->update(['task_status'=>1]);
    
                }
                CreativeWrcModel::where('id', $wrc_id )->update(['cw_qc_status'=>0, 'qc_status'=>0]);
        }
        echo $check;
    }
}
