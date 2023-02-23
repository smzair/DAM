<?php

namespace App\Http\Controllers;
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
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\reportMail;
use Mail;
use DB;
use App\Mail\DailyWrc;
use DateTime;
use Filter;

class ReportController extends Controller
{
    public function Report(){
        $time = time();
        $date = Carbon::today();   
        
        $brand = count(Brands::whereDate('created_at','>=', $date)->get());
        $brandtouser = count(brands_user::whereDate('created_at','>=', $date)->get());
        $user = count(User::whereDate('created_at','>=', $date)->get());
        $com = count(Commercials::whereDate('created_at','>=', $date)->get());
        $lots = count(Lots::whereDate('created_at','>=', $date)->get());
        $acceptance = count(Wrc::whereDate('updated_at','>=', $date)->where('status','=','ready_for_plan')->get());
        $wrc  = count(Wrc::whereDate('created_at', '>=', $date)->get());
        $skus = count(Skus::whereDate('created_at','>=', $date)->get());
        $plan = count(Dayplan::whereDate('created_at','>=', $date)->get());
        $planwrc = count(planDate::whereDate('created_at', '>=', $date)->get());
        $rawimg = count(uploadraw::whereDate('created_at', '>=', $date)->get());
        $editorallocated = count(allocation::whereDate('created_at', '>=', $date)->get());
        $editorSubmission = count(editorSubmission::whereDate('created_at', '>=', $date)->get());
        $qc = count(editorSubmission::whereDate('updated_at', '>=', $date)->where('qc','=','1')->get());
        // $brands = count(brands_user::pending());
        // $Commercials= count(Commercials::pending());
        // $Lots = count(Lots::pending());
        // $Wrcs = count(Wrc::pending());
        // $pendingplan = count(planDate::pending());
        // $pendingsku = count(planDate::skupending());
        // $uploadrawpending = count(uploadraw::pending());
        // $pendallocation = count(allocation::pending());
        // $pendingfromediting = count(editorSubmission::pending());
        // $qcpending = count(editorSubmission::where('qc','=','0')->get());
        return view('report.dailyureport',compact('brand','brandtouser','user','com','lots','wrc','skus','plan','planwrc','rawimg','editorallocated','editorSubmission','qc','acceptance','date'));
    }
    
    
     public function sendReport(){
        $date =  Carbon::now();
        $reportdata = [  
            'date'=>$date,
        'brand' => count(Brands::whereDate('created_at', $date)->get()),
        'brandtouser' => count(brands_user::whereDate('created_at', $date)->get()),
        'user' => count(User::whereDate('created_at', $date)->get()),
        'com' => count(Commercials::whereDate('created_at', $date)->get()),
        'lots' => count(Lots::whereDate('created_at', $date)->get()),
        'acceptance' => count(Wrc::whereDate('updated_at', $date)->where('status','=','ready_for_plan')->get()),
        'wrc'  => count(Wrc::whereDate('created_at', $date)->get()),
        'skus' => count(Skus::whereDate('created_at', $date)->get()),
        'plan' => count(Dayplan::whereDate('created_at', $date)->get()),
        'planwrc' => count(planDate::whereDate('created_at', $date)->get()),
        'rawimg' => count(uploadraw::whereDate('created_at', $date)->get()),
        'editorallocated' => count(allocation::whereDate('created_at', $date)->get()),
        'editorSubmission' => count(editorSubmission::whereDate('created_at', $date)->get()),
        'qc' => count(editorSubmission::whereDate('updated_at', $date)->where('qc','=','1')->get()),
        'brands' => count(brands_user::pending()),
        'Commercials' => count(Commercials::pending()),
        'Lots' => count(Lots::pending()),
        'Wrcs' => count(Wrc::pending()),
        'pendingplan' => count(planDate::pending()),
        'pendingsku' => count(planDate::skupending()),
        'uploadrawpending' => count(uploadraw::pending()),
        'pendallocation' => count(allocation::pending()),
        'pendingfromediting' => count(editorSubmission::pending()),
        'qcpending' => count(editorSubmission::where('qc','=','0')->get())
     
];
    
   $users= ['zair.s@odndigital.com','odndigital@gmail.com','vipan.s@odndigital.com','kumar.udaar@odndigital.com','nishant.kumar@odndigital.com','vishal.d@odndigital.com','studio@odndigital.com','abhishek.j@odndigital.com','sandeep.n@odndigital.com','vinod.sharma@odndigital.com','neetu.b@odndigital.com','pankaj.g@odndigital.com','narinder.mahajan@odndigital.com'];
    
    Mail::to($users)->send(new reportmail($reportdata));
  
}
 public function sendWrcs()
{
    $date = Carbon::now();
    $result = DB::table('wrc')
                ->join('brands', 'brands.id', '=', 'wrc.brand_id')
                ->join('users', 'users.id', '=', 'wrc.user_id')
                ->join('lots', 'lots.id', '=', 'wrc.lot_id')
                ->join('commercial', 'commercial.id', '=', 'wrc.commercial_id')
                ->select('wrc.id', 'lots.lot_id', 'wrc.wrc_id', 'wrc.status', 'wrc.created_at','users.am_email', 'brands.name', 'users.Company', 'users.client_id', 'commercial.product_category', 'commercial.type_of_shoot', 'commercial.type_of_clothing', 'commercial.gender', 'commercial.adaptation_1', "wrc.initialised", 'commercial.adaptation_2', 'commercial.adaptation_3', 'commercial.adaptation_4','commercial.adaptation_5')
                ->whereDate('wrc.created_at', '=',$date)
                ->orderBy('id', 'DESC')
                ->get();
        $wrcdata = [
        'date'=>$date,
        'result'=>$result];

    $users= ['nishant.kumar@odndigital.com','anshuman.g@odndigital.com','vinod.sharma@odndigital.com','vishal.d@odndigital.com','studio@odndigital.com','logistics@odndigital.com','ekadashi.g@odndigital.com','aastha.m@odndigital.com','deepshikha.b@odndigital.com','apurba.d@odndigital.com','neetu.b@odndigital.com','zair.s@odndigital.com','kumar.udaar@odndigital.com','abhishek.j@odndigital.com','vipan.s@odndigital.com'];
    
    Mail::to($users)->send(new DailyWrc($wrcdata));
    return "Email Sent";
    
}


public function PublicSheet(){
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
         $wrcInfo[$index]['wrc_id'] = $wrcs->wrc_id;
      $reject_count = count(Skus::where(['wrc_id' => $WrcId,'status' => '0'] )->get());
      $approved_count = count(Skus::where(['wrc_id' => $WrcId,'status' => '1'] )->get());
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
      $wrcInfo[$index]['clientBucket'] = $wrcs->clientBucket;
      $wrcInfo[$index]['shoothandoverDate'] = $wrcs->shoothandoverDate;
      $wrcInfo[$index]['verticalType'] = $wrcs->verticleType;
      $wrcInfo[$index]['Location'] = $wrcs->location;
      $wrcInfo[$index]['am_email'] = $wrcs->am_email;
      $skucom = count($wsku_count) - $reject_count;
      $wrcInfo[$index]['com'] = $skucom * $wrcs->com ;
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
         $photographer_charges = $wrcInfo[$index]['plannins_detail']->photographer_charges /  $wrcInfo[$index]['totalplanedskus'];
         $photographer_chargesFinal = $skucom * $photographer_charges;
         $assistant_charges = $wrcInfo[$index]['plannins_detail']->assistant_charges /  $wrcInfo[$index]['totalplanedskus'];
         $assistant_chargesFinal = $skucom * $assistant_charges;

         $makeup_charges = $wrcInfo[$index]['plannins_detail']->makeup_charges /  $wrcInfo[$index]['totalplanedskus'];
         $makeup_chargesFinal = $skucom * $makeup_charges;

         $model_charges = $wrcInfo[$index]['plannins_detail']->model_charges /  $wrcInfo[$index]['totalplanedskus'];
         $model_chargesFinal = $skucom * $model_charges;
         $stylist_charges = $wrcInfo[$index]['plannins_detail']->stylist_charges/$wrcInfo[$index]['totalplanedskus'];
         $stylist_chargesFinal = $skucom * $stylist_charges;
         $wrcInfo[$index]['stylist_charges'] = round($stylist_chargesFinal,0);
         $wrcInfo[$index]['makeup_charges'] = round($makeup_chargesFinal,0);
    $wrcInfo[$index]['photographer_charges'] = round($photographer_chargesFinal,0);
         $wrcInfo[$index]['model_charges'] = round($model_chargesFinal,0);
         $wrcInfo[$index]['assistant_charges'] = round($assistant_chargesFinal,0);
         $wrcInfo[$index]['shoot_date'] = $wrcInfo[$index]['plannins_detail']->date;
         $wrcInfo[$index]['model_available'] = $wrcInfo[$index]['plannins_detail']->model_available;
         $wrcInfo[$index]['date'][]=$wrcInfo[$index]['plannins_detail']->model_available;
         $max = max($wrcInfo[$index]['date']);
         
         $wrcInfo[$index]['TAT_start_date'] = date('Y-m-d', strtotime($max .' +1 weekday '));
         
             $wrcInfo[$index]['Tat_days'] = now()->diffInWeekdays(Carbon::parse( $wrcInfo[$index]['TAT_start_date']));
             
         $wrcInfo[$index]['studio'] = $wrcInfo[$index]['plannins_detail']->studio;
         $wrcInfo[$index]['type_of_shoot'] = $wrcInfo[$index]['plannins_detail']->type_of_shoot;
         $wrcInfo[$index]['product_category'] = $wrcInfo[$index]['plannins_detail']->product_category;
         $wrcInfo[$index]['type_of_clothing'] = $wrcInfo[$index]['plannins_detail']->product_category;
         $wrcInfo[$index]['adaptation_1'] = $wrcInfo[$index]['plannins_detail']->adaptation_1;
         $wrcInfo[$index]['adaptation_1'] = $wrcInfo[$index]['plannins_detail']->adaptation_1;
         $wrcInfo[$index]['adaptation_2'] = $wrcInfo[$index]['plannins_detail']->adaptation_2;
         $wrcInfo[$index]['adaptation_3'] = $wrcInfo[$index]['plannins_detail']->adaptation_3;
         $wrcInfo[$index]['adaptation_4'] = $wrcInfo[$index]['plannins_detail']->adaptation_4;
         $wrcInfo[$index]['adaptation_5'] = $wrcInfo[$index]['plannins_detail']->adaptation_5;
         $wrcInfo[$index]['photographer'] = $wrcInfo[$index]['plannins_detail']->photographer;
         $wrcInfo[$index]['model'] = $wrcInfo[$index]['plannins_detail']->model;
         $wrcInfo[$index]['agency'] = $wrcInfo[$index]['plannins_detail']->agency;
         $wrcInfo[$index]['stylist'] = $wrcInfo[$index]['plannins_detail']->stylist;
         $wrcInfo[$index]['makeupartist'] = $wrcInfo[$index]['plannins_detail']->makeupartist;
         $wrcInfo[$index]['rawqc'] = $wrcInfo[$index]['plannins_detail']->rawqc;
         $wrcInfo[$index]['assistant'] = $wrcInfo[$index]['plannins_detail']->assistant;
         $wrcInfo[$index]['shoot_hour'] = $wrcInfo[$index]['plannins_detail']->shoot_hour;
         $wrcInfo[$index]['planning_date'] = dateFormat($wrcInfo[$index]['plannins_detail']->created_at);
   
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
         $wrcInfo[$index]['type_of_shoot'] = 'Not Planned';
         $wrcInfo[$index]['product_category'] = 'Not Planned';
         $wrcInfo[$index]['type_of_clothing'] = 'Not Planned';
         $wrcInfo[$index]['adaptation_1'] = 'No Information';
         $wrcInfo[$index]['adaptation_1'] = 'No Information';
         $wrcInfo[$index]['adaptation_2'] = 'No Information';
         $wrcInfo[$index]['adaptation_3'] = 'No Information';
         $wrcInfo[$index]['adaptation_4'] = 'No Information';
         $wrcInfo[$index]['adaptation_5'] = 'No Information';
         $wrcInfo[$index]['photographer'] = 'Not Planned';
         $wrcInfo[$index]['stylist'] = 'Not Planned';
         $wrcInfo[$index]['makeupartist'] = 'Not Planned';
         $wrcInfo[$index]['rawqc'] = 'Not Planned';
         $wrcInfo[$index]['model'] = 'Not Planned';
         $wrcInfo[$index]['agency'] = 'Not Planned';
         $wrcInfo[$index]['assistant'] = 'Not Planned';
         $wrcInfo[$index]['model_available'] = 'Not Planned';
         $wrcInfo[$index]['shoot_hour'] = 'Not Planned';
         $wrcInfo[$index]['planning_date'] ='Not Planned';
         $wrcInfo[$index]['stylist_charges'] = 'Not Planned';
         $wrcInfo[$index]['makeup_charges'] = 'Not Planned';
         $wrcInfo[$index]['photographer_charges'] = 'Not Planned';
         $wrcInfo[$index]['model_charges'] ='Not Planned';
         $wrcInfo[$index]['assistant_charges'] = 'Not Planned';
          
      }
      
       if($sub == ''){
           $wrcInfo[$index]['statuses'] = "Active";
           
      }else{
          
          $wrcInfo[$index]['statuses'] ="Submitted";
          $wrcInfo[$index]['Tat_days'] = "Completed";
            
      }
           
         if($wrcInfo[$index]['shoot_date'] == 'Not Planned' && $wrcInfo[$index]['shootpending'] != 0){
            $wrcInfo[$index]['wrc_statuses'] = 'Planning Pending';
         }
         else{
               if($wrcInfo[$index]['shootpending'] != 0 ){
              $wrcInfo[$index]['wrc_statuses'] = 'Shoot Pending';
         }else{
               if($wrcInfo[$index]['submission_count'] !=  $wrcInfo[$index]['shootdone'] ){
              $wrcInfo[$index]['wrc_statuses'] = 'Editing Pending';
         }else{
             if($wrcInfo[$index]['submission_date'] == 'No Information' ){
              $wrcInfo[$index]['wrc_statuses'] = 'Submission Pending';
         }else{
           if($wrcInfo[$index]['invoice_no'] == 'Not Updated'){
              $wrcInfo[$index]['wrc_statuses'] = 'Invoice Pending';
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
 $wrcInfo[$index]['TAT_status'] = 'Within TAT';
}
}
      if($wrcInfo[$index]['shoot_date'] != 'Not Planned' ){
          
            $wrcInfo[$index]['Inward_to_Shoot'] = Carbon::parse($wrcInfo[$index]['inward_at'])->diffInWeekdays(Carbon::parse($wrcInfo[$index]['shoot_date']));
            if( $wrcInfo[$index]['submission_date'] != 'No Information'){
             $wrcInfo[$index]['Shoot_to_Submission'] = Carbon::parse($wrcInfo[$index]['shoot_date'])->diffInWeekdays(Carbon::parse($wrcInfo[$index]['submission_date']));
             
        }else{
             $wrcInfo[$index]['Shoot_to_Submission'] = Carbon::parse($wrcInfo[$index]['shoot_date'])->diffInWeekdays(now());
             
        }
            if($wrcInfo[$index]['TAT_start_date'] != 'Not Planned' ){
            $wrcInfo[$index]['TAT_Start_To_Shoot'] = Carbon::parse($wrcInfo[$index]['TAT_start_date'])->diffInWeekdays(Carbon::parse($wrcInfo[$index]['shoot_date']));
            }else{
                 $wrcInfo[$index]['TAT_Start_To_Shoot'] = 'Tat Not Started';
            }
            
      }else{
          
            $wrcInfo[$index]['Shoot_to_Submission'] = 'Not Planned';
            $wrcInfo[$index]['Inward_to_Shoot'] = Carbon::parse($wrcInfo[$index]['inward_at'])->diffInWeekdays(now());
            $wrcInfo[$index]['TAT_Start_To_Shoot'] = 'Tat Not Started';
      }
      
      
      /////---- Shoot tat status----------/////

           if(count($lsku_count) > 40 ){
               
               if(   $wrcInfo[$index]['TAT_Start_To_Shoot'] !=  'Tat Not Started' ){

                if($wrcInfo[$index]['TAT_Start_To_Shoot'] <= '2'  ){
                   $wrcInfo[$index]['TAT_Start_To_shoot_status'] = 'Within SHOOT TAT' ;
                }else{
                    $wrcInfo[$index]['TAT_Start_To_shoot_status'] = 'SHOOT TAT Breached' ;
                   
                }
                   
               }else{
                      $wrcInfo[$index]['TAT_Start_To_shoot_status'] = 'Tat Not Started' ;
               }

         
      }else{
          
           if(   $wrcInfo[$index]['TAT_Start_To_Shoot'] !=  'Tat Not Started' ){

                if($wrcInfo[$index]['TAT_Start_To_Shoot'] <= '4'  ){
                   $wrcInfo[$index]['TAT_Start_To_shoot_status'] = 'Within SHOOT TAT' ;
                }else{
                    $wrcInfo[$index]['TAT_Start_To_shoot_status'] = 'SHOOT TAT Breached' ;
                   
                }
                   
               }else{
                      $wrcInfo[$index]['TAT_Start_To_shoot_status'] = 'Tat Not Started' ;
               }
  
      }
         
          /////---- Editing tat status----------/////
     
           ///dd($wrcInfo[$index]['Shoot_to_Submission'],$wrcInfo[$index]['TAT_Start_To_Shoot'],$wrcInfo[$index]['Inward_to_Shoot']);
           
           
      $sr= 1;
   }
   
   $wrcInfo = json_decode(json_encode($wrcInfo), true);

   return view('report.Pumastersheet',compact('wrcInfo','sr','plan'));
}


public function MasterSheet(){
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
         $wrcInfo[$index]['wrc_id'] = $wrcs->wrc_id;
      $reject_count = count(Skus::where(['wrc_id' => $WrcId,'status' => '0'] )->get());
      $approved_count = count(Skus::where(['wrc_id' => $WrcId,'status' => '1'] )->get());
      $wrcInfo[$index]['inward_at'] = $lot_inward;
      $wrcInfo[$index]['shootdone']=count($shoot_sku_count);
      $wrcInfo[$index]['shootpending']= count($wsku_count) - count($shoot_sku_count) - $reject_count;
      
      if(count($sub_count) == '0'){
           $wrcInfo[$index]['submission_count'] = "Pending";
      }else{
          $wrcInfo[$index]['submission_count'] = count($sub_count);
      }
      
      if($sub == ''){
           $wrcInfo[$index]['submission_date'] = "No Information";
      }else{
          $wrcInfo[$index]['submission_date'] =$sub->submission_date;
      }
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
      $wrcInfo[$index]['clientBucket'] = $wrcs->clientBucket;
      $wrcInfo[$index]['shoothandoverDate'] = $wrcs->shoothandoverDate;
      $wrcInfo[$index]['verticalType'] = $wrcs->verticleType;
      $wrcInfo[$index]['Location'] = $wrcs->location;
      $wrcInfo[$index]['am_email'] = $wrcs->am_email;
      $skucom = count($wsku_count) - $reject_count;
      $wrcInfo[$index]['com'] = $skucom * $wrcs->com ;
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
         $photographer_charges = $wrcInfo[$index]['plannins_detail']->photographer_charges /  $wrcInfo[$index]['totalplanedskus'];
         $photographer_chargesFinal = $skucom * $photographer_charges;
         $assistant_charges = $wrcInfo[$index]['plannins_detail']->assistant_charges /  $wrcInfo[$index]['totalplanedskus'];
         $assistant_chargesFinal = $skucom * $assistant_charges;

         $makeup_charges = $wrcInfo[$index]['plannins_detail']->makeup_charges /  $wrcInfo[$index]['totalplanedskus'];
         $makeup_chargesFinal = $skucom * $makeup_charges;

         $model_charges = $wrcInfo[$index]['plannins_detail']->model_charges /  $wrcInfo[$index]['totalplanedskus'];
         $model_chargesFinal = $skucom * $model_charges;
         $stylist_charges = $wrcInfo[$index]['plannins_detail']->stylist_charges/$wrcInfo[$index]['totalplanedskus'];
         $stylist_chargesFinal = $skucom * $stylist_charges;
         $wrcInfo[$index]['stylist_charges'] = round($stylist_chargesFinal,0);
         $wrcInfo[$index]['makeup_charges'] = round($makeup_chargesFinal,0);
         $wrcInfo[$index]['photographer_charges'] = round($photographer_chargesFinal,0);
         $wrcInfo[$index]['model_charges'] = round($model_chargesFinal,0);
         $wrcInfo[$index]['assistant_charges'] = round($assistant_chargesFinal,0);
         $wrcInfo[$index]['shoot_date'] = $wrcInfo[$index]['plannins_detail']->date;
         $wrcInfo[$index]['model_available'] = $wrcInfo[$index]['plannins_detail']->model_available;
         $wrcInfo[$index]['date'][]=$wrcInfo[$index]['plannins_detail']->model_available;
         $max = max($wrcInfo[$index]['date']);
         $wrcInfo[$index]['TAT_start_date'] = date('Y-m-d', strtotime($max .' +1 weekday '));
         $wrcInfo[$index]['studio'] = $wrcInfo[$index]['plannins_detail']->studio;
         $wrcInfo[$index]['type_of_shoot'] = $wrcInfo[$index]['plannins_detail']->type_of_shoot;
         $wrcInfo[$index]['product_category'] = $wrcInfo[$index]['plannins_detail']->product_category;
         
         $wrcInfo[$index]['type_of_clothing'] = $wrcInfo[$index]['plannins_detail']->type_of_clothing;
         $wrcInfo[$index]['adaptation_1'] = $wrcInfo[$index]['plannins_detail']->adaptation_1;
         $wrcInfo[$index]['adaptation_1'] = $wrcInfo[$index]['plannins_detail']->adaptation_1;
         $wrcInfo[$index]['adaptation_2'] = $wrcInfo[$index]['plannins_detail']->adaptation_2;
         $wrcInfo[$index]['adaptation_3'] = $wrcInfo[$index]['plannins_detail']->adaptation_3;
         $wrcInfo[$index]['adaptation_4'] = $wrcInfo[$index]['plannins_detail']->adaptation_4;
         $wrcInfo[$index]['adaptation_5'] = $wrcInfo[$index]['plannins_detail']->adaptation_5;
         $wrcInfo[$index]['photographer'] = $wrcInfo[$index]['plannins_detail']->photographer;
         $wrcInfo[$index]['model'] = $wrcInfo[$index]['plannins_detail']->model;
         $wrcInfo[$index]['agency'] = $wrcInfo[$index]['plannins_detail']->agency;
         $wrcInfo[$index]['stylist'] = $wrcInfo[$index]['plannins_detail']->stylist;
         $wrcInfo[$index]['makeupartist'] = $wrcInfo[$index]['plannins_detail']->makeupartist;
         $wrcInfo[$index]['rawqc'] = $wrcInfo[$index]['plannins_detail']->rawqc;
         $wrcInfo[$index]['assistant'] = $wrcInfo[$index]['plannins_detail']->assistant;
         $wrcInfo[$index]['shoot_hour'] = $wrcInfo[$index]['plannins_detail']->shoot_hour;
         $wrcInfo[$index]['planning_date'] = dateFormat($wrcInfo[$index]['plannins_detail']->created_at);
   
         if(count($lsku_count) > 40){
            $wrcInfo[$index]['TAT_end_date'] =date('Y-m-d', strtotime($max .' +4 weekday'));
         }else{
            $wrcInfo[$index]['TAT_end_date'] =date('Y-m-d', strtotime($max .' +7 weekday'));
         }
      }else{
         $wrcInfo[$index]['TAT_start_date'] = 'Not Planned';
         $wrcInfo[$index]['TAT_end_date'] = 'Not Planned';
         $wrcInfo[$index]['shoot_date'] = 'Not Planned';
         $wrcInfo[$index]['shoot_month'] = 'Not Planned';
         $wrcInfo[$index]['studio'] = 'Not Planned';
         $wrcInfo[$index]['model_available'] = 'Not Planned';
         $wrcInfo[$index]['type_of_shoot'] = 'Not Planned';
         $wrcInfo[$index]['product_category'] = 'Not Planned';
         $wrcInfo[$index]['type_of_clothing'] = 'Not Planned';
         $wrcInfo[$index]['adaptation_1'] = 'No Information';
         $wrcInfo[$index]['adaptation_1'] = 'No Information';
         $wrcInfo[$index]['adaptation_2'] = 'No Information';
         $wrcInfo[$index]['adaptation_3'] = 'No Information';
         $wrcInfo[$index]['adaptation_4'] = 'No Information';
         $wrcInfo[$index]['adaptation_5'] = 'No Information';
         $wrcInfo[$index]['photographer'] = 'Not Planned';
         $wrcInfo[$index]['stylist'] = 'Not Planned';
         $wrcInfo[$index]['makeupartist'] = 'Not Planned';
         $wrcInfo[$index]['rawqc'] = 'Not Planned';
         $wrcInfo[$index]['model'] = 'Not Planned';
         $wrcInfo[$index]['agency'] = 'Not Planned';
         $wrcInfo[$index]['assistant'] = 'Not Planned';
         $wrcInfo[$index]['model_available'] = 'Not Planned';
         $wrcInfo[$index]['shoot_hour'] = 'Not Planned';
         $wrcInfo[$index]['planning_date'] ='Not Planned';
         $wrcInfo[$index]['stylist_charges'] = 'Not Planned';
         $wrcInfo[$index]['makeup_charges'] = 'Not Planned';
         $wrcInfo[$index]['photographer_charges'] = 'Not Planned';
         $wrcInfo[$index]['model_charges'] ='Not Planned';
         $wrcInfo[$index]['assistant_charges'] = 'Not Planned';
          
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
 $wrcInfo[$index]['TAT_status'] = 'Within TAT';
}
}
      $sr= 1;
   }
   
   $wrcInfo = json_decode(json_encode($wrcInfo), true);
   
 
   return view('report.mastersheet',compact('wrcInfo','sr','plan'));
}


function pending(){
    
   $brands = count(brands_user::pending());
   $Commercials= count(Commercials::pending());
   $lotexist = count(Lots::getlotInfo());
   $wrcexist = count(Wrc::getwrcInfo());
   $Lots = count(Lots::pending());
   $Wrcs = count(Wrc::pending());
   $planned = count(planDate::getplanInfo());
   $pendingplan = count(planDate::pending());
   $pendingsku = count(planDate::skupending());
   $shootdone = count(uploadraw::shootcom());
   $uploadrawpending = count(uploadraw::pending());
   $pendallocation = count(allocation::pending());
   $editingcompleted = count(editorSubmission::SubmissionInfo());
   $pendingfromediting = count(editorSubmission::pending());
   $qcdone =  count(editorSubmission::SubmissionInfo($filter = ['qc' => '1','submission'=>'0']));
   $qcpending = count(editorSubmission::where('qc','=','0')->get());
   $submisions = count(submissions::where('wrc_id','!=',NULL)->get());
   $submisionsDate = DB::table('submission')->latest('submission_date')->first();
   
   
  $wrcdata = DB::table('dailyCounts')->latest('created_at')->first();
  
  $yesbdata = $wrcdata->brands;
  $comparebrands = $brands - $yesbdata;
  $yescdata = $wrcdata->Commercials;
  $comparecoms = $Commercials - $yescdata;
  
  $yesldata = $wrcdata->lotexist;
  $compareLots = $lotexist - $yesldata;
  $yeswdata = $wrcdata->wrcexist;
  $comparewrcs = $lotexist - $yeswdata;
  $yespLdata =   $wrcdata->Lots ;
  $comparepL = $Lots - $yespLdata;
  $yesWp = $wrcdata->Wrcs;
  $compareWp = $Wrcs - $yesWp;
  $yesplannedskus = $wrcdata->plannedskus;
  $compareplannedskus = $planned - $yesplannedskus;
  $yespendingplan = $wrcdata->pendingplan;
  $comparependingplan = $pendingplan - $yespendingplan;
  $yespendingsku = $wrcdata->pendingsku;
  $comparependingsku = $pendingsku - $yespendingsku;
  $yesuploadrawpending = $wrcdata->uploadrawpending;
  $compareuploadrawpending = $uploadrawpending - $yesuploadrawpending;
  $yesshootdane = $wrcdata->shootdone;
  $compareshootdone = $shootdone - $yesshootdane;
  $yespendallocation = $wrcdata->pendallocation;
  $comparependallocation = $pendallocation - $yespendallocation;
  $yespendingfromediting =  $wrcdata->pendingfromediting;
  $comparependingfromediting  = $pendingfromediting - $yespendingfromediting;
  $yeseditingcomplete = $wrcdata->editingcomplete;
  $compareeditingcomplete = $editingcompleted - $yeseditingcomplete;
  $yesqcdone = $wrcdata->qcdone;
  $comapreqcdone = $qcdone -  $yesqcdone;
  $yesqcpending = $wrcdata->qcpending;
  $compareqcpending = $qcpending -  $yesqcpending;
  $yessubmisions = $wrcdata->submission;
  $comparesubmission = $submisions - $yessubmisions;
  
  

    $report = new dailyCounts();
    $report->brands = $brands;
  
  
    $report->Commercials = $Commercials;
  
    $report->lotexist = $lotexist;
  
    $report->wrcexist = $wrcexist;
  
    $report->Lots = $Lots;
  
    $report->Wrcs = $Wrcs;
  
    $report->plannedskus = $planned;
  
    $report->pendingplan = $pendingplan;
  
    $report->pendingsku = $pendingsku;
  
    $report->uploadrawpending = $uploadrawpending;
  
    $report->shootdone = $shootdone;
  
    $report->pendallocation = $pendallocation;
    $report->pendingfromediting = $pendingfromediting;
    $report->editingcomplete = $editingcompleted;
    $report->qcdone = $qcdone;
    $report->qcpending = $qcpending;
    $report->submission = $submisions;
    $report->sdate = $submisionsDate->submission_date;
    
    $report->comparebrands = $comparebrands;
      $report->comparesubmission = $comparesubmission;  
     $report->compareqcpending = $compareqcpending;
         $report->comapreqcdone = $comapreqcdone;
         $report->comparependingfromediting = $comparependingfromediting;
       $report->compareeditingcomplete = $compareeditingcomplete;
     $report->comparependallocation = $comparependallocation;
           $report->compareshootdone = $compareshootdone;
       $report->compareuploadrawpending = $compareuploadrawpending;
     $report->comparependingplan = $comparependingplan;
     $report->compareplannedskus = $compareplannedskus;
     $report->compareWp = $compareWp;
     $report->comparepL = $comparepL;
    $report->compareLots = $compareLots;
    $report->comparewrcs = $comparewrcs;
             $report->comparependingsku = $comparependingsku;
     
    $report->save();
    
    $wrcdata = dailyCounts::getCounts();

 $data = [
        'wrcdata'=>$wrcdata,
        'date'=> Carbon::now() ];
   $users= ['zair.s@odndigital.com','vipan.s@odndigital.com'];
    Mail::to($users)->send(new DailyWrc($data));
    return "Email Sent";

}



public function tatReport(){
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
         $wrcInfo[$index]['planning_date'] = dateFormat($wrcInfo[$index]['plannins_detail']->created_at);
   
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
   $wrcInfo = collect($wrcInfo);
 $wrcs = $wrcInfo->where('TAT_status', '=', 'TAT Breached')->where('statuses','=','Active');
// pr($wrcs,1);
return view('extra.tatreport',compact('wrcs','sr'));
}

public function accountDetials(){
    
    $wrcdata = Lots::Inovices($filter = []);

 return view('report.ac',compact('wrcdata'));
    
}

public function  repLot($date){
    $ndate = Carbon::parse($date)->format('Y-m-d');
    $newLots = Lots::whereDate('created_at','=',$ndate)->get();
    
    return view('extra.Lots',compact('newLots'));
}

public function  repWrc($date){
    
    $ndate = Carbon::parse($date)->format('Y-m-d');
    $newWrc = Wrc::whereDate('created_at','=',$ndate)->get();
    dd($newWrc);
    
}

public function  plannedSku($date){
  
   $ndate = Carbon::parse($date)->format('Y-m-d');
    $newplan = planDate::getplanInfo(['created_at' => $ndate])->get();
    dd($newplan);
}

public function  PlanpendingSku($date){
    
    $ndate = Carbon::parse($date)->format('Y-m-d');
    $pendingplan = planDate::skupending()->get();
    dd($pendingplan);
}

public function  uploadraw($date){
     
     $newuploadrawpending = uploadraw::pending()->get();
    dd($newuploadrawpending);
}
public function  shoot($date){
    
    dd('Shoot done details are available in mastersheet');
}

public function  pendingAllo($date){
    
    $pendingaloocation = allocation::pending();
    dd($pendingaloocation);
}

public function  editingComplete($date){
    
    dd('Editing completed details are available in mastersheet');
}

public function  compareQc($date){
    
    $pendingQc = editorSubmission::where('qc','=','0')->get();
    
    dd($pendingQc);
}

public function  CompareSub($date){
    
       dd('Submission details are available in mastersheet');

}




}
