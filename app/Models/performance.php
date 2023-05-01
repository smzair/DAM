<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use DB;
use App\Models\User;
use App\Models\Brands;
use App\Models\brands_user;
use App\Models\Commercials;
use App\Models\Lots;
use App\Models\Wrc;
use App\Models\Skus;
use App\Models\Dayplan;
use App\Models\PlanDate;
use App\Models\uploadraw;
use App\Models\allocation;
use App\Models\editing;
use App\Models\submissions;
use App\Models\editorSubmission;
use App\Models\dailyCounts;
use Carbon\Carbon;
use Illuminate\Http\Request;


class performance extends Model
{ 

 public static function getShootMaster()
 {
 $wrc = Wrc::getwrcInfo($filter = []);
   $wrcInfo = [];
   foreach ($wrc as $wrcs){
      $id = $wrcs->lotId;
      $WrcId = $wrcs->id;
      $index = $wrcs->lot_id.'_'.$wrcs->wrc_id;
      $lot_inward = $wrcs->inward;
      $sub = submissions::where(['wrc_id'=> $WrcId])->first();
      $sub_count = editorSubmission::SubmissionInfo(['wrc_id'=> $WrcId,'group_by'=> "sku_code"]);
      $shoot_sku_count = uploadraw::shootDone($WrcId);
      $wrcscount = Wrc::where(['lot_id' => $id])->get();
      $plan = planDate::getplanInfo(['wrc_id' => $WrcId])->last();
      $lsku_count = Skus::where('lot_id' ,'=', $id)->get();
      $wsku_count = Skus::where('wrc_id' ,'=', $WrcId)->get();
      $shootdoneday =  uploadraw::shootDone($WrcId)->last();
      $wrcInfo[$index]['wrc_id'] = $wrcs->wrc_id;
      $qcday = editorSubmission::SubmissionInfo(['wrc_id'=> $WrcId,'group_by'=> "sku_code"])->last();
      $reject_count = count(Skus::where(['wrc_id' => $WrcId,'status' => '0'] )->get());
      $approved_count = count(Skus::where(['wrc_id' => $WrcId,'status' => '1'] )->get());
       $wrcInfo[$index]['id'] = $WrcId;
      $wrcInfo[$index]['inward_at'] = $lot_inward;
      $wrcInfo[$index]['shootdone']=count($shoot_sku_count);
      $wrcInfo[$index]['shootpending']= count($wsku_count) - count($shoot_sku_count) - $reject_count;
      
      if(count($sub_count) == '0'){
           $wrcInfo[$index]['submission_count'] = "Pending";
           $wrcInfo[$index]['final_com'] = 'Editing not completed';
      }else{
           
          $wrcInfo[$index]['submission_count'] = count($sub_count);
          $wrcInfo[$index]['final_com'] = count($sub_count)*$wrcs->com;
      }
      
      if($sub == ''){
           $wrcInfo[$index]['submission_date'] = "No Information";
      }else{
          $wrcInfo[$index]['submission_date'] =$sub->submission_date;
      }
    $wrcInfo[$index]['days'] = now()->diffInDays(Carbon::parse($lot_inward));
      
      if($wrcs->Client_AR == Null){
       $wrcInfo[$index]['clientar'] = "Not Updated";
      }else{
         $wrcInfo[$index]['clientar'] = $wrcs->Client_AR;
    }
      if($wrcs->Invoice_no == Null){
      $wrcInfo[$index]['invoice_no'] = "Not Updated";
      }else{
      $wrcInfo[$index]['invoice_no'] = $wrcs->Invoice_no;
      }
      $wrcInfo[$index]['lot_id'] = $wrcs->lot_id;
   
      $wrcInfo[$index]['am_email'] = strtoupper(strstr($wrcs->am_email,'.',true));
      $skucom = count($wsku_count) - $reject_count;
   
      $wrcInfo[$index]['wrc_count'] = count($wrcscount);
      $wrcInfo[$index]['inwardLot_sku_count'] = count($lsku_count);
      $wrcInfo[$index]['inwardwrc_sku_count'] = count($wsku_count);
      if(count($lsku_count) > 40){
         $wrcInfo[$index]['Lot_size'] ='Above 40 articles';
      }else{
         $wrcInfo[$index]['Lot_size'] = 'Upto 40 articles';
      }
      $wrcInfo[$index]['reject_count'] = $reject_count;
      $wrcInfo[$index]['approved_count'] = $approved_count;
      $wrcInfo[$index]['plannins_detail'] = $plan;
      $wrcInfo[$index]['lotId'] = $wrcs->id;
      $wrcInfo[$index]['Company'] = $wrcs->Company;
      $wrcInfo[$index]['name'] = $wrcs->name;
      $wrcInfo[$index]['client_id'] = $wrcs->client_id;
      $wrcInfo[$index]['status'] = $wrcs->status;
      $wrcInfo[$index]['ppt_approval'] = $wrcs->ppt_approval;
      $wrcInfo[$index]['model_approval'] = $wrcs->model_approval;    
      $wrcInfo[$index]['special_approval'] = $wrcs->special_approval;
      $wrcInfo[$index]['inward_sheet'] = $wrcs->inward_sheet;
      $wrcInfo[$index]['date'][]=$wrcs->ppt_approval;
      $wrcInfo[$index]['date'][]=$wrcs->model_approval;
      $wrcInfo[$index]['date'][]=$wrcs->special_approval;
      $wrcInfo[$index]['date'][]=$wrcs->inward_sheet;
      $wrcInfo[$index]['date'][]=$lot_inward;
      $wrcInfo[$index]['gender'] = $wrcs->gender;
      if ($plan != Null) {
         $dayplan_id = $plan->dayplan_id; 
         $totalplanedskus = planDate::getplanInfo(['dayplan_id' => $dayplan_id]);
         $wrcInfo[$index]['totalplanedskus'] = count($totalplanedskus);
         $wrcInfo[$index]['shoot_date'] = $wrcInfo[$index]['plannins_detail']->date;
         $wrcInfo[$index]['model_available'] = $wrcInfo[$index]['plannins_detail']->model_available;
         $wrcInfo[$index]['date'][]=$wrcInfo[$index]['plannins_detail']->model_available;
         $max = max($wrcInfo[$index]['date']);
         
         $wrcInfo[$index]['TAT_start_date'] = date('Y-m-d', strtotime($max .' +1 weekday '));
         
             $wrcInfo[$index]['Tat_days'] = now()->diffInWeekdays(Carbon::parse( $wrcInfo[$index]['TAT_start_date']));
             

         $wrcInfo[$index]['shoot_hour'] = $wrcInfo[$index]['plannins_detail']->shoot_hour;
         $wrcInfo[$index]['planning_date'] =$wrcInfo[$index]['plannins_detail']->created_at;
   
         if(count($lsku_count) > 40){
            $wrcInfo[$index]['TAT_end_date'] =date('Y-m-d', strtotime($max .' +4 weekday'));
         }else{
            $wrcInfo[$index]['TAT_end_date'] =date('Y-m-d', strtotime($max .' +7 weekday'));
         }
           $wrcInfo[$index]['Tat_days'] = now()->diffInWeekdays(Carbon::parse( $wrcInfo[$index]['TAT_start_date']));
         
      }else{
         $wrcInfo[$index]['TAT_start_date'] = 'Not Planned';
          $wrcInfo[$index]['Tat_days'] = 'Not planned';
         $wrcInfo[$index]['TAT_end_date'] = 'Not Planned';
         $wrcInfo[$index]['shoot_date'] = 'Not Planned';
         $wrcInfo[$index]['shoot_month'] = 'Not Planned';
         $wrcInfo[$index]['studio'] = 'Not Planned';
         $wrcInfo[$index]['model_available'] = 'Not Planned';
      }
      
       if($sub == ''){
           $wrcInfo[$index]['statuses'] = "Active";
           
      }else{
          
          $wrcInfo[$index]['statuses'] ="Submitted";
          $wrcInfo[$index]['Tat_days'] = "Completed";
            
      }
           
         if($wrcInfo[$index]['shoot_date'] == 'Not Planned' && $wrcInfo[$index]['shootpending'] != 0){
            $wrcInfo[$index]['wrc_statuses'] = 'Planning ';
         }
         else{
               if($wrcInfo[$index]['shootpending'] != 0 ){
              $wrcInfo[$index]['wrc_statuses'] = 'Shoot ';
         }else{
               if($wrcInfo[$index]['submission_count'] !=  $wrcInfo[$index]['shootdone'] ){
              $wrcInfo[$index]['wrc_statuses'] = 'Editing ';
         }else{
             if($wrcInfo[$index]['submission_date'] == 'No Information' ){
              $wrcInfo[$index]['wrc_statuses'] = 'Submission ';
         }else{
           if($wrcInfo[$index]['invoice_no'] == 'Not Updated'){
              $wrcInfo[$index]['wrc_statuses'] = 'Invoice ';
         }else{
            $wrcInfo[$index]['wrc_statuses'] = 'Completed';
         }
         }
         }
         }
         }
         
         if($wrcs->edt_rejection == "0"){
       $wrcInfo[$index]['Internal_fta'] = 'NFTA';
         }else{
              $wrcInfo[$index]['Internal_fta'] = 'FTA';
         }
       
       if($wrcs->Client_AR == "0"){
       $wrcInfo[$index]['External_fta'] = 'NFTA';
        }else{
                   $wrcInfo[$index]['External_fta'] = 'FTA';
        }
      
        if($sub = Null && $wrcInfo[$index]['TAT_end_date'] > Carbon::today()){
 $wrcInfo[$index]['TAT_status'] = 'Within TAT';
       
         }elseif($sub != Null && $wrcInfo[$index]['TAT_end_date'] < $wrcInfo[$index]['submission_date']){
$wrcInfo[$index]['TAT_status'] = 'TAT Breached';
         }
else{
if($wrcInfo[$index]['TAT_end_date'] < Carbon::today()){
   $wrcInfo[$index]['TAT_status'] = 'TAT Breached';
}
else{
 $wrcInfo[$index]['TAT_status'] = 'Within TAT ';
}
}
      if($shootdoneday != NULL ){
          
            $wrcInfo[$index]['Inward_to_Shoot'] = Carbon::parse($wrcInfo[$index]['inward_at'])->diffInWeekdays(Carbon::parse($shootdoneday->uct));
            if( $wrcInfo[$index]['submission_date'] != 'No Information'){
             $wrcInfo[$index]['Shoot_to_Submission'] = Carbon::parse($shootdoneday->uct)->diffInWeekdays(Carbon::parse($wrcInfo[$index]['submission_date']));
             
        }else{
             $wrcInfo[$index]['Shoot_to_Submission'] = Carbon::parse($shootdoneday->uct)->diffInWeekdays(now());
             
        }
            if($wrcInfo[$index]['TAT_start_date'] != 'Not Planned' ){
            $wrcInfo[$index]['TAT_Start_To_Shoot'] = Carbon::parse($wrcInfo[$index]['TAT_start_date'])->diffInWeekdays(Carbon::parse($shootdoneday->uct));
            }else{
                 $wrcInfo[$index]['TAT_Start_To_Shoot'] = ' Not Started';
            }
            
      }else{
          
            $wrcInfo[$index]['Shoot_to_Submission'] = 'Not Planned';
            $wrcInfo[$index]['Inward_to_Shoot'] = 'Shoot Not started';
            $wrcInfo[$index]['TAT_Start_To_Shoot'] = 'NA';
      }
      
      
      if ($shootdoneday != null){
         $wrcInfo[$index]['raw_upload'] =  dateFormat($shootdoneday->uct);
       
      }else{ 
            $wrcInfo[$index]['raw_upload'] =  'NA';
      }
      /////---- Shoot tat status----------/////
 $wrcInfo[$index]['TAT_Shoot_Edit'] = "";
 
        if ($qcday != null){
         $wrcInfo[$index]['editingday'] =  dateFormat($qcday->created_at);
          if ($shootdoneday != null){
            $wrcInfo[$index]['TAT_Shoot_Edit'] = Carbon::parse($wrcInfo[$index]['raw_upload'])->diffInWeekdays(Carbon::parse($qcday->created_at));

          }
      }else{ 
            $wrcInfo[$index]['TAT_Shoot_Edit'] = 'Not Started';
            $wrcInfo[$index]['editingday'] =  'Not Uploaded';
      }

 if(count($lsku_count) > 40 ){
               
               if(   $wrcInfo[$index]['TAT_Shoot_Edit'] !=  'Not Started' ){

                if($wrcInfo[$index]['TAT_Shoot_Edit'] <= '2'  ){
                   $wrcInfo[$index]['TAT_Start_To_EDIT_status'] = 'Within ' ;
                }else{
                    $wrcInfo[$index]['TAT_Start_To_EDIT_status'] = ' Breached' ;
                   
                }
                   
               }else{
                      $wrcInfo[$index]['TAT_Start_To_EDIT_status'] = 'Not Started' ;
               }
      }else{
          
           if(   $wrcInfo[$index]['TAT_Shoot_Edit'] !=  'Not Started' ){

                if($wrcInfo[$index]['TAT_Shoot_Edit'] <= '3'  ){
                   $wrcInfo[$index]['TAT_Start_To_EDIT_status'] = 'Within ' ;
                }else{
                    $wrcInfo[$index]['TAT_Start_To_EDIT_status'] = ' Breached' ;
                   
                }
                   
               }else{
                      $wrcInfo[$index]['TAT_Start_To_EDIT_status'] = 'TAT Not Started' ;
               }
      }
      
      
           if(count($lsku_count) > 40 ){
               
               if(   $wrcInfo[$index]['TAT_Start_To_Shoot'] !=  'TAT Not Started' ){

                if($wrcInfo[$index]['TAT_Start_To_Shoot'] <= '2'  ){
                   $wrcInfo[$index]['TAT_Start_To_shoot_status'] = 'Within ' ;
                }else{
                    $wrcInfo[$index]['TAT_Start_To_shoot_status'] = ' Breached' ;
                   
                }
                   
               }else{
                      $wrcInfo[$index]['TAT_Start_To_shoot_status'] = 'TAT Not Started' ;
               }
      }else{
          
           if(   $wrcInfo[$index]['TAT_Start_To_Shoot'] !=  'TAT Not Started' ){

                if($wrcInfo[$index]['TAT_Start_To_Shoot'] <= '4'  ){
                   $wrcInfo[$index]['TAT_Start_To_shoot_status'] = 'Within ' ;
                }else{
                    $wrcInfo[$index]['TAT_Start_To_shoot_status'] = ' Breached' ;
                   
                }
                   
               }else{
                      $wrcInfo[$index]['TAT_Start_To_shoot_status'] = 'TAT Not Started' ;
               }
      }
          /////---- Editing tat status----------/////
     
           ///dd($wrcInfo[$index]['Shoot_to_Submission'],$wrcInfo[$index]['TAT_Start_To_Shoot'],$wrcInfo[$index]['Inward_to_Shoot']);
           
   }
     $sr= 1;
     
     return $wrcInfo;
}


}

