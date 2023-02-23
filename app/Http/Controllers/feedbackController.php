<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\feedback;
use Auth;
use Mail;
use App\Mail\feedbackM;
use Carbon\Carbon;
use Illuminate\Http\Request;

class feedbackController extends Controller
{
  
  public function indexShoot(){

     $users = User::latest()->get();

    return view('feedback.feedbackshoot',compact('users'));
  }

public function savefeed(Request $request){

$userId = Auth::id();
$user_id = $request->user_id;
$brand_id = $request->brand_id;
$type_of_service = $request->type_of_service;
$name = $request->name;
$email = $request->email;
$am =  User::where('id','=',$userId)->pluck('name');

$obj = new feedback();
$obj->user_id = $user_id;
$obj->brand_id = $brand_id;
$obj->type_of_service = $type_of_service;
$obj->name = $name;
$obj->email = $email;
$obj->am_name = $am;
$obj->save();

$id = $obj->id;
$url = 'odnconnect.odndigital.com/form/'.$id;
$rejectUrl = 'odnconnect.odndigital.com/form-reject/'.$id;
//dd($am_email,$url);

$bannerSm = 'odnconnect.odndigital.com/Images/new/bannerS-M.png';
$logoimg ='odnconnect.odndigital.com/Images/logo.png';
$banners = 'odnconnect.odndigital.com/Images/new/bannerS.png';
$thank = 'odnconnect.odndigital.com/Images/thankyou.png';
$footrs ='odnconnect.odndigital.com/Images/new/footerS.png';
$footrM = 'odnconnect.odndigital.com/Images/new/footerS-M.png';

  $data = [
      'bannerSm'=>$bannerSm,
      'logoimg' =>$logoimg,
      'banners'=>$banners,
      'thank'=>$thank,
      'footrs'=>$footrs,
      'footrM'=>$footrM,
        'url'=>$url,
        'Rurl' => $rejectUrl,
        'name'=>$name,
        'am' => $am,
        'date'=> Carbon::today()];
        $users= [$email];


      
       Mail::to($users)->send(new feedbackM($data));
        return "Email Sent";
}

public function feedForm($id){

return view('feedback.index',compact('id'));

}
public function feedStart($id){

return view('feedback.form',compact('id'));
}

public function saveCfeed(Request $request){
$Id=$request->id;
$q1=$request->q1;
$q2 = $request->q2;
$q3 = $request->q3;
$q4 = $request->q4;
$q5_1 = $request->q5_1;
$q5_2 = $request->q5_2;
$q5_3 = $request->q5_3;
$q6_1 = $request->q6_1;
$q6_2 = $request->q6_2;
$q6_3 = $request->q6_3;
$q7 = $request->q7;
$q8 = $request->q8;


$objData = feedback::find($Id);
$objData->q1=$q1;
$objData->q2=$q2;
$objData->q3=$q3;
$objData->q4=$q4;
$objData->q5_1=$q5_1;
$objData->q5_2=$q5_2;
$objData->q5_3=$q5_3;
$objData->q6_1=$q6_1;
$objData->q6_2=$q6_2;
$objData->q6_3=$q6_3;
$objData->q7=$q7;
$objData->q8=$q8;

$objData->save();

return "success";
}

public function thankYou(){

return view('feedback.thankYou');
}
public function feedbackView(){

$fd = feedback::getlotInfo();
$feedback = [];

foreach ($fd as  $data) {
   $index = $data->id;
   
    $feedback[$index]['Company'] = $data->Company;
    $feedback[$index]['name'] = $data->name;
    $feedback[$index]['am_name'] = $data->am_name;
    $feedback[$index]['Cemail'] = $data->email;
    $feedback[$index]['C_name'] = $data->C_name;
     $feedback[$index]['q1'] = $data->q1;
      $feedback[$index]['q2'] = $data->q2;
       $feedback[$index]['q3'] = $data->q3;
        $feedback[$index]['q3'] = $data->q3;
         $feedback[$index]['q4'] = $data->q3;
          $feedback[$index]['q5_1'] = $data->q5_1;
           $feedback[$index]['q5_2'] = $data->q5_2;
            $feedback[$index]['q5_3'] = $data->q5_3;
             $feedback[$index]['q6_1'] = $data->q6_1;
              $feedback[$index]['q6_2'] = $data->q6_2;
               $feedback[$index]['q6_3'] = $data->q6_3;
        $feedback[$index]['q7'] = $data->q7;
         $feedback[$index]['q8'] = $data->q8;
         $feedback[$index]['Request_raised'] = $data->created_at;
         $feedback[$index]['filled'] = $data->updated_at;

}

return view('feedback.feedsheet',compact('feedback'));
}
public function feedbackReject($id){

$objData = feedback::find($Id);
$objData->q1='Request rejected';
$objData->q2='Request rejected';
$objData->q3='Request rejected';
$objData->q4='Request rejected';
$objData->q5_1='Request rejected';
$objData->q5_2='Request rejected';
$objData->q5_3='Request rejected';
$objData->q6_1='Request rejected';
$objData->q6_2='Request rejected';
$objData->q6_3='Request rejected';
$objData->q7='Request rejected';
$objData->q8='Request rejected';
$objData->save();

return "success";
}

}