<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
use Sum;
use Illuminate\Support\Arr;

class StatusController extends Controller
{
    public function Report(){
    
       $date = Carbon::today();
        $brand = count(Brands::whereDate('created_at','=', $date)->get());
        $brandtouser = count(brands_user::whereDate('created_at','=', $date)->get());
        $user = count(User::whereDate('created_at','=', $date)->get());
        $com = count(Commercials::whereDate('created_at','=', $date)->get());
        $lots = count(Lots::whereDate('created_at','=', $date)->get());
        $acceptance = count(Wrc::whereDate('updated_at','=', $date)->where('status','=','ready_for_plan')->get());
        $wrces  = count(Wrc::whereDate('created_at', '=', $date)->get());
        $skus = count(Skus::whereDate('created_at','=', $date)->get());
        $plan = count(Dayplan::whereDate('created_at','=', $date)->get());
        $planwrc = count(planDate::whereDate('created_at', '=', $date)->get());
        $rawimg = count(uploadraw::whereDate('created_at', '=', $date)->get());
        $editorallocated = count(allocation::whereDate('created_at', '=', $date)->get());
        $editorSubmission = count(editorSubmission::whereDate('created_at', '=', $date)->get());
        $qc = count(editorSubmission::whereDate('updated_at', '=', $date)->where('qc','=','1')->get());
        //////////////////////
        $activeLot = count(Lots::where('lot_done','=','0')->get());
        $totallots = count(Lots::whereDate('created_at','<=', $date)->get());
        $activeWrc = count(Wrc::where('submission','=','0')->get());
        $totalWrc  = count(Wrc::whereDate('created_at', '<=', $date)->get());
        $todayImgs = count(editorSubmission::whereDate('created_at', '=', $date)->get());
        $totalImgs = count(editorSubmission::whereDate('updated_at', '<=', $date)->where('qc','=','1')->get());
        $wrcBilled = count(Wrc::whereDate('updated_at','=',$date)->get());
        //////////////////////

     $wrc = Wrc::getwrcInfo([]);
     $wrcInfo = [];
     $total = 0;
      foreach ($wrc as $wrcs){
      $id = $wrcs->lotId;
      $WrcId = $wrcs->id;
      $index = $wrcs->lot_id;
      $lot_inward = $wrcs->inward;
      $wrcscount = Wrc::where(['lot_id' => $id])->get();
            $wsku_count = Skus::where('wrc_id' ,'=', $WrcId)->get();
      $reject_count = count(Skus::where(['wrc_id' => $WrcId,'status' => '0'] )->get());
      $approved_count = count(Skus::where(['wrc_id' => $WrcId,'status' => '1'] )->get());
    $skucom = count($wsku_count) - $reject_count;
      if($wrcs->Invoice_no == Null){
      }else{
       $wrcInfo[$index]['com'] = $skucom * $wrcs->com ;
        $total +=  $wrcInfo[$index]['com'];
         }
      }
      
    $wrcbill = count($wrcInfo);
   
    
    $wrcInovice = Wrc::whereDate('updated_at','=',$date)->get();
     $wrcInv = [];
     $totaltoday = 0;
    foreach ($wrcInovice as $wrcs){
      $id = $wrcs->lotId;
      $WrcId = $wrcs->id;
      $index = $wrcs->lot_id;
      $lot_inward = $wrcs->inward;
      $wrcscount = Wrc::where(['lot_id' => $id])->get();
            $wsku_count = Skus::where('wrc_id' ,'=', $WrcId)->get();
      $reject_count = count(Skus::where(['wrc_id' => $WrcId,'status' => '0'] )->get());
      $approved_count = count(Skus::where(['wrc_id' => $WrcId,'status' => '1'] )->get());
      
      $commercial = Commercials::where(['id'=>$wrcs->commercial_id])->first();
      
    $skucom = count($wsku_count) - $reject_count;
    if($wrcs->Invoice_no == Null){
      }else{
       $wrcInv[$index]['com'] = $skucom * $commercial->commercial_value_per_sku;
        $totaltoday +=  $wrcInv[$index]['com'];
         }
        
    }
    //dd($totaltoday);
        return view('extra.dashboard',compact('brand','date','user','com','lots','wrces','skus','plan','planwrc','rawimg','editorallocated','editorSubmission','activeLot','totallots','totalWrc','totalImgs','wrcBilled','total','wrcbill','wrcBilled','activeWrc','todayImgs','totaltoday'));
    }

    public function RealtimeData(){
    $wrc = Wrc::getwrcInfo(['single' => true]);
     $invoice = $wrc->Invoice_no;
      $wrc_id = $wrc->wrc_id;
       $html =  view('extra.dashDynamic',compact('invoice','wrc_id'));
       return $html;
    }
    

}
