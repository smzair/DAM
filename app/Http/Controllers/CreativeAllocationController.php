<?php

namespace App\Http\Controllers;
use App\Models\CreativeWrcModel;
use App\Models\CreativeAllocation;
use App\Models\CreativeUploadLink;
use App\Models\CreativeTimeHash;
use App\Models\CreativeWrcBatch;
use App\Models\CreativeWrcSkus as ModelsCreativeWrcSkus;
use Carbon\Carbon;
use CreativeWrcSkus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class CreativeAllocationController extends Controller
{
    // get data for create
    public function index(){
        $allocationList = CreativeWrcModel::getDataForCreativeAllocation() ;
        // dd( $allocationList);
        return view('Allocation.creative_allocation')->with('allocationList',$allocationList);
    }

    // get data for re allocation create
    public function indexForReAllocation(){
        $allocationList = CreativeWrcModel::getDataForCreativeReAllocation() ;
        // dd( $allocationList);
        return view('Allocation.creative_reallocation')->with('allocationList',$allocationList);
    }

    // assign wrc to user
    public function store(Request $request){
        // dd($request);
        $requestedData = $request->all();
        $msgCheck = false;

        $wrc_id = $request->wrc_id;
        $batch_no = $request->batch_no;
        $int_date = $request->int_date;
        $cmt_date = $request->cmt_date;

        CreativeWrcBatch::where('wrc_id',$wrc_id)->where('batch_no',$batch_no)->update(['work_initiate_date'=>$int_date, 'work_committed_date'=>$cmt_date]);
        
        foreach($requestedData['copywriterName'] as $key =>  $copywriterNameData){

            $presentDataCW = CreativeAllocation::where(['wrc_id'=>$request->wrc_id,'batch_no'=>$request->batch_no,'user_id'=>$requestedData['copywriterName'][$key]])
            ->groupBy('wrc_id')->get(['id','allocated_qty'])->first();

            $presentIdCW = $presentDataCW != NULL ? $presentDataCW->id : 0;
            $allocated_qty_cw = $presentDataCW != NULL ? $presentDataCW->allocated_qty : 0;

            // dd($presentIdCW);
            $cw_user_array = [];
            $gd_user_array = [];

            if($requestedData['copywriterName'][$key] != 0){
                if($presentIdCW === 0){
                    $CreativeAllocation                = new CreativeAllocation();
                    $CreativeAllocation->wrc_id        = $request->wrc_id;
                    $CreativeAllocation->batch_no        = $request->batch_no;
                    $CreativeAllocation->user_id       = $requestedData['copywriterName'][$key];
                    $CreativeAllocation->allocated_qty = $requestedData['copyWriterQty'][$key];
                    $CreativeAllocation->save();
                    $msgCheck = true;
                    //cw data push to send e mail
                    array_push($cw_user_array, $requestedData['copywriterName'][$key]);
                }else{
                    $CreativeAllocation                =  CreativeAllocation::find($presentIdCW);
                    $CreativeAllocation->wrc_id        = $request->wrc_id;
                    $CreativeAllocation->batch_no        = $request->batch_no;
                    $CreativeAllocation->user_id       = $requestedData['copywriterName'][$key];
                    $CreativeAllocation->allocated_qty = $requestedData['copyWriterQty'][$key] + $allocated_qty_cw;
                    $CreativeAllocation->update();
                    $msgCheck = true;
                    //gd data push to send e mail
                    array_push($cw_user_array, $requestedData['copywriterName'][$key]);
                }
            }

        }

        foreach($requestedData['designerName'] as $key =>  $designerNameData){

            $presentDataGd = CreativeAllocation::where(['wrc_id'=>$request->wrc_id,'batch_no'=>$request->batch_no,'user_id'=>$requestedData['designerName'][$key]])
            ->groupBy('wrc_id')->get(['id','allocated_qty'])->first();

            $presentIdGd = $presentDataGd != NULL ? $presentDataGd->id : 0;
            $allocated_qty_gd = $presentDataGd != NULL ? $presentDataGd->allocated_qty : 0;

            if($requestedData['designerName'][$key] != 0){
                if($presentIdGd === 0){
                    $CreativeAllocation                 = new CreativeAllocation();
                    $CreativeAllocation->wrc_id         = $request->wrc_id;
                    $CreativeAllocation->batch_no        = $request->batch_no;
                    $CreativeAllocation->user_id        = $requestedData['designerName'][$key];
                    $CreativeAllocation->allocated_qty  = $requestedData['GraphicDesignerQty'][$key];
                    $CreativeAllocation->save();
                    $msgCheck = true;
                    //gd data push to send e mail
                    array_push($gd_user_array, $requestedData['designerName'][$key]);
                }else{
                    $CreativeAllocation                 =  CreativeAllocation::find($presentIdGd);
                    $CreativeAllocation->wrc_id         = $request->wrc_id;
                    $CreativeAllocation->batch_no        = $request->batch_no;
                    $CreativeAllocation->user_id        = $requestedData['designerName'][$key];
                    $CreativeAllocation->allocated_qty  = $requestedData['GraphicDesignerQty'][$key] + $allocated_qty_gd;
                    $CreativeAllocation->update();
                    $msgCheck = true;
                    //gd data push to send e mail
                    array_push($gd_user_array, $requestedData['designerName'][$key]);
                }
            }
        }
        if($msgCheck){
            request()->session()->flash('success','Wrc Allocated Successfully');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }

        /* send notification start */
            $creative_allocation_data = CreativeAllocation::where('id',$CreativeAllocation->id)->first(['wrc_id','user_id']);
            $wrc_id = $creative_allocation_data != null ? $creative_allocation_data->wrc_id : 0;
            $user_id = $creative_allocation_data != null ? $creative_allocation_data->user_id : 0;
            $allocated_qty = CreativeAllocation::where('wrc_id',$wrc_id)->where('user_id',$user_id)->sum('allocated_qty');
            $wrc_data = CreativeWrcModel::where('id',$wrc_id)->first(['wrc_number']);
            $wrc_number = $wrc_data != null ? $wrc_data->wrc_number : "";
            $max_batch_no = CreativeWrcBatch::where('wrc_id', $wrc_id)->max('batch_no');
            $data = new stdClass();
            $data->wrc_number = $wrc_number;
            $data->batch_no = $max_batch_no;
            $data->allocated_count = $allocated_qty;
            $data->cw_user_data = $cw_user_array;
            $data->gd_user_data = $gd_user_array;
            $creation_type = 'WrcAllocation';
            $this->send_notification($data, $creation_type);
        /******  send notification end*******/ 
        
        $allocationList = CreativeWrcModel::getDataForCreativeAllocation() ;
        return view('Allocation.creative_allocation')->with('allocationList',$allocationList);
    }

    // creative allocation get 
    public function CreativeAllocationGet(){
        $allocationList = CreativeAllocation::GetCreativeAllocation();
        // dd($allocationList);
        return view('Allocation.creative_allocation_details')->with('allocationList',$allocationList);
    }

    // upload creative panel get list
    public function uploadCreative(){
        $allocationList = CreativeAllocation::GetCreativeAllocationForUpload();
        // dd(Carbon::now());
        return view('Allocation.upload_creative_panel')->with('allocationList',$allocationList);
    }

    public function setCreativeAllocationStart(Request $request){
        // dd($request);
        $allocate_id = CreativeTimeHash::where('allocation_id',$request->allocation_id)->get(['id'])->first();
        $already_allocated_id = $allocate_id != null ?  $allocate_id->id : 0;
        $start_time = Carbon::now();
        $pause_time = Carbon::now();

        $action = $request->action; // "pause"// "start"
 
        if($action == "start"){

            if( $already_allocated_id == 0){
                $storeData = new CreativeTimeHash();
                $storeData->start_time = $start_time;
                $storeData->ini_start_time = $start_time;
                $storeData->allocation_id = $request->allocation_id;
                $storeData->is_rework = 0;
                $storeData->end_time = '0000-00-00 00:00:00';
                $storeData->pause_time = '0000-00-00 00:00:00';
                $storeData->save();
                if($storeData){
                    echo json_encode([
                        "message"=>"success",
                        "start_time"=>$storeData->start_time,
                        "start_time1"=>dateFormat($storeData->start_time),
                        "start_time2"=>timeFormat($storeData->start_time)
                    ]);
                }
                else{
                    echo json_encode([
                        "message"=>"error",
                        "start_time"=>'',
                        "start_time1"=>'',
                        "start_time2"=>''
                    ]);
                }
            }else{
                $storeData = CreativeTimeHash::find($already_allocated_id);
                $storeData->start_time = $start_time;
                $storeData->ini_start_time = $start_time;
                $storeData->allocation_id = $request->allocation_id;
                $storeData->is_rework = 0;
                $storeData->end_time = '0000-00-00 00:00:00';
                $storeData->pause_time = '0000-00-00 00:00:00';
                $storeData->update();
                if($storeData){
                    echo json_encode([
                        "message"=>"success",
                        "start_time"=>$storeData->start_time,
                        "start_time1"=>dateFormat($storeData->start_time),
                        "start_time2"=>timeFormat($storeData->start_time)
                    ]);
                }
                else{
                    echo json_encode([
                        "message"=>"error",
                        "start_time"=>'',
                        "start_time1"=>'',
                        "start_time2"=>''
                    ]);
                }
            }
        }

        if($action == "pause"){

            $timeHashData = CreativeTimeHash::where('allocation_id', $request->allocation_id)->get()->first();
            $old_start_time = $timeHashData->start_time;
            $old_spent_time = $timeHashData->spent_time;
            $old_spent_time = ($old_spent_time == "" || $old_spent_time == 0) ? 0 : (int)$old_spent_time;
           
            $new_spent_time = (new Carbon($pause_time))->diffInSeconds(new Carbon($old_start_time));
            //  echo strtotime($new_spent_time);
            $tot_spent = $old_spent_time + $new_spent_time;


            // dd($already_allocated_id);
            $storeData = CreativeTimeHash::find($already_allocated_id);
            $storeData->pause_time = $pause_time;
            $storeData->spent_time = $tot_spent;
            $storeData->allocation_id = $request->allocation_id;
            $storeData->is_rework = 0;
            $storeData->end_time = '0000-00-00 00:00:00';
            $storeData->update();
            if($storeData){
                echo json_encode([
                    "message"=>"success",
                    "start_time"=>$storeData->start_time,
                    "start_time1"=>dateFormat($storeData->start_time),
                    "start_time2"=>timeFormat($storeData->start_time)
                ]);
            }
            else{
                echo json_encode([
                    "message"=>"error",
                    "start_time"=>'',
                    "start_time1"=>'',
                    "start_time2"=>''
                ]);
            }
        }
        
    }

    // if task started then pause start tiem automatically
    public function setCreativeAllocationPause(Request $request){

        $start_time_data = CreativeTimeHash::where('start_time','!=','0000-00-00 00:00:00')
        // ->where('pause_time','==','0000-00-00 00:00:00')
        ->where('task_status','==','0')->get();

        foreach($start_time_data as $key => $val){
            // return $val->allocation_id;

            $pause_time = Carbon::now();
            $allocate_id = CreativeTimeHash::where('allocation_id',$val->allocation_id)->get(['id'])->first();
            $already_allocated_id = $allocate_id != null ?  $allocate_id->id : 0;

            $timeHashData = CreativeTimeHash::where('allocation_id', $val->allocation_id)->get()->first();
            $old_start_time = $timeHashData->start_time;
            $old_spent_time = $timeHashData->spent_time;
            $old_spent_time = ($old_spent_time == "" || $old_spent_time == 0) ? 0 : (int)$old_spent_time;
        
            $new_spent_time = (new Carbon($pause_time))->diffInSeconds(new Carbon($old_start_time));
            //  echo strtotime($new_spent_time);
            $tot_spent = $old_spent_time + $new_spent_time;


            // dd($already_allocated_id);
            $storeData = CreativeTimeHash::find($already_allocated_id);
            $storeData->pause_time = $pause_time;
            $storeData->spent_time = $tot_spent;
            $storeData->allocation_id = $val->allocation_id;
            $storeData->is_rework = 0;
            $storeData->end_time = '0000-00-00 00:00:00';
            $storeData->update();
            if($storeData){
                echo json_encode([
                    "message"=>"success",
                    "start_time"=>$storeData->start_time,
                    "start_time1"=>dateFormat($storeData->start_time),
                    "start_time2"=>timeFormat($storeData->start_time)
                ]);
            }
            else{
                echo json_encode([
                    "message"=>"error",
                    "start_time"=>'',
                    "start_time1"=>'',
                    "start_time2"=>''
                ]);
            }
        } 
        
    }


    public function storeUploaddata(Request $request){
        // dd( $request);

        $creative_allocation_id =  $request->creative_allocation_id;
        $creative_link =  $request->workLink1;
        $copy_link =  $request->workLink2;
        $action_type = $request->submit;

        if($action_type == 'save'){

            $allocate_id = CreativeUploadLink::where('allocation_id',$creative_allocation_id)->get(['id'])->first();
            $already_allocated_id = $allocate_id != null ?  $allocate_id->id : 0;

            if( $already_allocated_id == 0){
                $storeData = new CreativeUploadLink();
                $storeData->allocation_id = $creative_allocation_id;
                $storeData->creative_link = $creative_link;
                $storeData->copy_link = $copy_link;
                $storeData->save();

                if($storeData){
                    request()->session()->flash('success','Uploading Creatives Added Successfully');
                }
                else{
                    request()->session()->flash('error','Please try again!!');
                }

            }else{
                $storeData = CreativeUploadLink::find($already_allocated_id);
                $storeData->allocation_id = $creative_allocation_id;
                $storeData->creative_link = $creative_link;
                $storeData->copy_link = $copy_link;
                $storeData->update();

                if($storeData){
                    request()->session()->flash('success','Uploading Creatives Updated Successfully');
                }
                else{
                    request()->session()->flash('error','Please try again!!');
                }
            }

            
        }

        if($action_type == 'complete_allocation'){

            $allocate_id = CreativeUploadLink::where('allocation_id',$creative_allocation_id)->get(['id'])->first();
            $already_allocated_id = $allocate_id != null ?  $allocate_id->id : 0;

            $end_time = Carbon::now();

            if( $already_allocated_id == 0){

                $storeData = new CreativeUploadLink();
                $storeData->allocation_id = $creative_allocation_id;
                $storeData->creative_link = $creative_link;
                $storeData->copy_link = $copy_link;
                $storeData->save();

                $timeHashData = CreativeTimeHash::where('allocation_id', $creative_allocation_id)->get()->first();
                $old_start_time = $timeHashData != null ? $timeHashData->start_time : null;
                $old_spent_time = $timeHashData != null ? $timeHashData->spent_time : null;
                $old_spent_time = ($old_spent_time == "" || $old_spent_time == 0) ? 0 : (int)$old_spent_time;
                // "%Y-%m-%d %H:%i:%s"
                // $new_spent_time = (new Carbon($end_time))->diff(new Carbon($old_start_time))->format('%Y-%m-%d %H:%I:%s');
                $new_spent_time = (new Carbon($end_time))->diffInSeconds(new Carbon($old_start_time));
                //  echo strtotime($new_spent_time);
                $tot_spent = $old_spent_time + $new_spent_time;

               
                // update creative_time_hash end time
                CreativeTimeHash::where('allocation_id',$creative_allocation_id)->update(['end_time'=>$end_time,'ini_end_time'=>$end_time, 'task_status'=>1, 'is_rework'=>0, 'spent_time' => $tot_spent ]);

                if($storeData){
                    request()->session()->flash('success','Allocated Completed Successfully');
                }
                else{
                    request()->session()->flash('error','Please try again!!');
                }

            }else{
                $storeData = CreativeUploadLink::find($already_allocated_id);
                $storeData->allocation_id = $creative_allocation_id;
                $storeData->creative_link = $creative_link;
                $storeData->copy_link = $copy_link;
                $storeData->update();

                $timeHashData = CreativeTimeHash::where('allocation_id', $creative_allocation_id)->get()->first();
                $old_start_time = $timeHashData != null ? $timeHashData->start_time : null;
                $old_spent_time = $timeHashData != null ? $timeHashData->spent_time : null;
                $old_spent_time = ($old_spent_time == "" || $old_spent_time == 0) ? 0 : (int)$old_spent_time;
                // "%Y-%m-%d %H:%i:%s"
                // $new_spent_time = (new Carbon($end_time))->diff(new Carbon($old_start_time))->format('%Y-%m-%d %H:%I:%s');
                $new_spent_time = (new Carbon($end_time))->diffInSeconds(new Carbon($old_start_time));
                //  echo strtotime($new_spent_time);
                $tot_spent = $old_spent_time + $new_spent_time;

                // update creative_time_hash end time
                CreativeTimeHash::where('allocation_id',$creative_allocation_id)->update(['end_time'=>$end_time ,'ini_end_time'=>$end_time, 'task_status'=>1, 'is_rework'=>0, 'spent_time' => $tot_spent]);

                if($storeData){
                    request()->session()->flash('success','Allocated Completed Successfully');
                }
                else{
                    request()->session()->flash('error','Please try again!!');
                }
            }

            /* send notification start */
            $creative_allocation_data = CreativeAllocation::where('id',$creative_allocation_id)->first(['wrc_id','user_id']);
            $wrc_id = $creative_allocation_data != null ? $creative_allocation_data->wrc_id : 0;
            $user_id = $creative_allocation_data != null ? $creative_allocation_data->user_id : 0;
            $allocated_qty = CreativeAllocation::where('wrc_id',$wrc_id)->where('user_id',$user_id)->sum('allocated_qty');
            $wrc_data = CreativeWrcModel::where('id',$wrc_id)->first(['wrc_number']);
            $wrc_number = $wrc_data != null ? $wrc_data->wrc_number : "";
            $max_batch_no = CreativeWrcBatch::where('wrc_id', $wrc_id)->max('batch_no');

            $user_id = 9;
            // $user_id = Auth::user()->id;
            $logged_in_user_data = DB::table('users')->where('id', $user_id )->first(['name']);
            $uploaded_by_user_name = $logged_in_user_data != null ? $logged_in_user_data->name : " ";

            $data = new stdClass();
            $data->wrc_number = $wrc_number;
            $data->batch_no = $max_batch_no;
            $data->uploaded_by_user_name = $uploaded_by_user_name;
            $data->uploaded_detail = $creative_link != null ? $creative_link  : $copy_link;
            $creation_type = 'completeTaskInUpload';
            $this->send_notification($data, $creation_type);
            /******  send notification end*******/ 
        }

        return $this->uploadCreative();

    }

    public function getSkuList(Request $request){

        $wrc_id = $request['wrc_id'];
        $batch_no = $request['batch_no'];

        $sku_list = ModelsCreativeWrcSkus::where('wrc_id',$wrc_id)->where('creative_wrc_batch_no',$batch_no)->get();

        echo $sku_list;

        // dd($sku_list);
        
    }
}
