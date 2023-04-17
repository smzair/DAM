<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreativeAllocation as ModelsCreativeAllocation;
use App\Models\CreativeQcComments;
use App\Models\CreativeTimeHash;
use App\Models\CreativeUploadLink as ModelsCreativeUploadLink;
use App\Models\CreativeWrcModel;
use App\Models\CreativeWRCclientApproval;
use App\Models\CreativeSubmission;
use App\Models\CreativeWrcBatch as ModelsCreativeWrcBatch;
use App\Models\CreativeWrcSkus;
use App\Models\NotificationModel\ClientNotification;
use Carbon\Carbon;
use CreativeAllocation;
use CreativeWrcBatch;
use Illuminate\Support\Facades\DB;

class CreativeSubmissionController extends Controller
{
    public function getCreativeSubmission(Request $request){
        $submissionList = CreativeSubmission::readyForSubmission() ;
        return view('Submission.creative-ready-for-submission')->with('submissionList',$submissionList);
    }

    // ready for submission
    public function addCreativeSubmission(Request $request){
        $wrc_id = $request['wrc_id'];
        $batch_no = $request['batch_no'];
        $allocation_id_array = array();
        DB::beginTransaction();

        $creative_allocation = ModelsCreativeAllocation::where('wrc_id',$wrc_id)->where('batch_no',$batch_no)->get();
        foreach($creative_allocation as $ckey => $cdata){
            $allocation_id = $cdata['id'];
            array_push( $allocation_id_array , $allocation_id);

        }

            $check_task_status = true;
            foreach($allocation_id_array as $akey => $adata){
                $task_status_data = CreativeTimeHash::where('allocation_id',$adata)->orderBy('id','DESC')->first('task_status');
                $task_status =  $task_status_data != null ? $task_status_data->task_status : 0;
                if($task_status != 2){
                    $check_task_status = false;
                }
            }

            if($check_task_status){

                $subMissionIdData = CreativeSubmission::where('wrc_id',$wrc_id)->where('batch_no',$batch_no)->first('id');

                $sub_id = $subMissionIdData != null ? $subMissionIdData->id : 0;

                // dd( $sub_id );
                $submission_date = Carbon::now();

                if($sub_id == 0){
                    $creativeSubmission = new CreativeSubmission();
                    $creativeSubmission->wrc_id = $wrc_id;
                    $creativeSubmission->batch_no = $batch_no;
                    $creativeSubmission->submission_date =  $submission_date;
                    $creativeSubmission->Status =  1;
                    $creativeSubmission->save();

                    $CreativeWrc_gd_query = CreativeWrcModel::
                    leftJoin('creative_wrc_batch as creative_wrc_batch', 'creative_wrc_batch.wrc_id', 'creative_wrc.id')->            
                    leftJoin('creative_lots', 'creative_lots.id', 'creative_wrc.lot_id')->
                    select(
                        'creative_wrc.wrc_number',
                        'creative_wrc.alloacte_to_copy_writer',
                        'creative_lots.user_id',
                        'creative_lots.brand_id',
                        'creative_wrc_batch.wrc_id',
                        'creative_wrc_batch.batch_no',
                        'creative_wrc_batch.order_qty',
                    )->
                    where('creative_wrc_batch.wrc_id', $wrc_id)->where('creative_wrc_batch.batch_no', $batch_no);
                    $CreativeWrc_gd_data = $CreativeWrc_gd_query->first()->toArray();

                    $save_ClientNotification_data = array(
                        'user_id' => $CreativeWrc_gd_data['user_id'],
                        'brand_id' => $CreativeWrc_gd_data['brand_id'],
                        'wrc_number' => $CreativeWrc_gd_data['wrc_number'],
                        'service' => 'Creative',
                        'subject' => 'Planning',
                    );
                    // dd($save_ClientNotification_data);
                    ClientNotification::save_ClientNotification($save_ClientNotification_data);
                    DB::commit();


                }else{
                    $creativeSubmission =  CreativeSubmission::find($sub_id);
                    $creativeSubmission->wrc_id = $wrc_id;
                    $creativeSubmission->batch_no = $batch_no;
                    $creativeSubmission->Status =  1;
                    $creativeSubmission->submission_date =  $submission_date;
                    $creativeSubmission->update();
                    DB::commit();

                }

                request()->session()->flash('success','Wrc Submitted Successfully');
                return $this->getCreativeSubmission($request);

            }else{
                DB::rollBack();
                request()->session()->flash('error','Uncompleted WRC - First complete WRC');
                return $this->getCreativeSubmission($request);
            }


    }
    
    // get data for submission done
    public function getDataForCreativeSubmissionDone(Request $request){
        $submissionList = CreativeSubmission::SubmissionDone() ;
        return view('Submission.creative-submission-done')->with('submissionList',$submissionList);
    }

  

    // submission done
    public function addCreativeSubmissionDone(Request $request){

        $creative_submissions_id = $request['creative_submissions_id'];
        
        if( $creative_submissions_id != null){
            $creativeSubmission =  CreativeSubmission::find($creative_submissions_id);
            $creativeSubmission->Status =  1;
            $creativeSubmission->update();
            request()->session()->flash('success','Wrc Submitted Successfully');
            return $this->getDataForCreativeSubmissionDone($request);
        }else{
            request()->session()->flash('error','Something Went wrong');
                return $this->getDataForCreativeSubmissionDone($request);
        }

    }

      // CREATIVE WRC CLIENT APPROVAL REJECTION
      public function creativeWrcClientApprovalRejection(Request $request){
        $submissionList = CreativeSubmission::ApprovalRejectionList() ;
        return view('ApprovalAndRejection.approval_rejection')->with('submissionList',$submissionList);
    }

    public function creativeWrcApprove(Request $request){
        // dd($request);
        $wrc_id = $request->wrc_id;
        $batch_no = $request->batch_no;
        $approval_date = Carbon::now();

        $check = CreativeWRCclientApproval::where('wrc_id',$wrc_id)->where('batch_no',$batch_no)->count();
        if($check > 0){
            request()->session()->flash('error','Wrc Already Approved/Rejected ');
            return $this->creativeWrcClientApprovalRejection($request);
        }

        $createApproval =  new CreativeWRCclientApproval();
        $createApproval->status =  1;
        $createApproval->wrc_id =  $wrc_id;
        $createApproval->batch_no =  $batch_no;
        $createApproval->approval_date = $approval_date;
        $createApproval->save();
        request()->session()->flash('success','Wrc Approved Successfully');
        return $this->creativeWrcClientApprovalRejection($request);
    }

    public function creativeWrcReject(Request $request){
        // dd($request);
        $wrc_id = $request->wrc_id;
        $batch_no = $request->batch_no;
        $rejection_date = Carbon::now();

        $check = CreativeWRCclientApproval::where('wrc_id',$wrc_id)->where('batch_no',$batch_no)->count();
        if($check > 0){
            request()->session()->flash('error','Wrc Already Rejected/Approved');
            return $this->creativeWrcClientApprovalRejection($request);
        }

        $wrc_data = CreativeWrcModel::where('id', $wrc_id)->get();

        foreach($wrc_data as $key => $value){

            $createWrc = new CreativeWrcModel();
            $createWrc->lot_id = $value['lot_id'];
            $createWrc->wrc_number = $value['wrc_number'].'-R';
            $createWrc->commercial_id = $value['commercial_id'];
            $createWrc->order_qty = $value['order_qty'];
            $createWrc->work_brief = $value['work_brief'];
            $createWrc->guidelines = $value['guidelines'];
            $createWrc->document1 = $value['document1'];
            $createWrc->document2 = $value['document2'];
            $createWrc->sku_required = $value['sku_required'];
            $createWrc->alloacte_to_copy_writer = $value['alloacte_to_copy_writer'];
            $createWrc->status = $value['status'];
            $createWrc->qc_status = $value['qc_status'];
            $createWrc->sku_count = $value['sku_count'];
            $createWrc->save();

            /*create creative allocation for new rejected wrc */
            $creative_allocation_data = ModelsCreativeAllocation::where('wrc_id', $wrc_id)->where('batch_no', $batch_no)->get();

            foreach($creative_allocation_data as $ckey => $cvalue){

                $createAllocation = new ModelsCreativeAllocation();
                $createAllocation->wrc_id = $createWrc->id;
                $createAllocation->user_id = $cvalue['user_id'];
                $createAllocation->allocated_qty = $cvalue['allocated_qty'];
                $createAllocation->batch_no = $cvalue['batch_no'];
                $createAllocation->save();

            }

            /*create creative wrc batch for new rejected wrc */
            $creative_batch_data = ModelsCreativeWrcBatch::where('wrc_id', $wrc_id)->where('batch_no', $batch_no)->get();

            foreach($creative_batch_data as $bkey => $bvalue){

                $createBatch = new ModelsCreativeWrcBatch();
                $createBatch->wrc_id = $createWrc->id;
                $createBatch->batch_no = $bvalue['batch_no'];
                $createBatch->order_qty = $bvalue['order_qty'];
                $createBatch->sku_count = $bvalue['sku_count'];
                $createBatch->save();

            }

            /*create creative wrc skusfor new rejected wrc */
            $creative_wrc_sku_data = CreativeWrcSkus::where('wrc_id', $wrc_id)->where('creative_wrc_batch_no', $batch_no)->get();

            foreach($creative_wrc_sku_data as $skey => $svalue){

                $createBatch = new CreativeWrcSkus();
                $createBatch->wrc_id = $createWrc->id;
                $createBatch->sku_code = $svalue['sku_code'];
                $createBatch->project_name = $svalue['project_name'];
                $createBatch->creative_wrc_batch_no = $svalue['creative_wrc_batch_no'];
                $createBatch->kind_of_work = $svalue['kind_of_work'];
                $createBatch->save();

            }
        }

        $createApproval =  new CreativeWRCclientApproval();
        $createApproval->status =  0;
        $createApproval->wrc_id =  $wrc_id;
        $createApproval->batch_no =  $batch_no;
        $createApproval->rejection_date = $rejection_date;
        $createApproval->save();
        request()->session()->flash('success','Wrc Rejected Successfully');
        return $this->creativeWrcClientApprovalRejection($request);
    }


    //GET  CREATIVE WRC DETAIL (Master Sheet) 
      public function getCreativeWrcDetail(Request $request){
        $getCreativeWrcDetails = CreativeSubmission::getCreativeWrcDetails() ;
        return view('CreativeWrcDetail.creative_wrc_detail')->with('getCreativeWrcDetails',$getCreativeWrcDetails);
    }
    
}