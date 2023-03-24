<?php

namespace App\Http\Controllers;

use App\Mail\emailPhoneVerifcationOtp;
use App\Mail\NotifyUsers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /* Send notification email to a list of users
    @param $data: Data to be passed to the NotifyUsers email view
    */
    public function send_notification($data, $creation_type){

        // dd($data);
        $users = [];
        $notification_data = $data;
        $subject = '';
      
        // send notification subject 
        $subject = [
            // subjects for creative
            'Lot' => 'Lot Created Successfully',//subject when generate lot
            'Wrc' => 'Wrc Created Successfully',//subject when generate wrc
            'WrcAllocation' => 'Creative Wrc Allocation Started Successfully',//subject when allocation start
            'completeTaskInUpload' => 'Tasking Done and ready for qc',//subject when allocation done 
            'Qc' => 'Qc Done and ready for submission',//subject when qc completed

            // subjects for catlog
            'CatlogLot' => 'Lots Catalog Successfully added',//subject when generate catlog lot
            'CatlogWrc' => 'Catlog Wrc Successfully added',//subject when generate wrc
            'WrcAllocationCatlog' => 'Catlog Wrc Allocation Started Successfully',//subject when allocation start
            'completeTaskInUploadCatlogFinalLink' => 'Tasking Done and ready for qc FinalLink',//subject when allocation done (FinalLink case)
            'completeTaskInUploadCatlogMarketPlace' => 'Tasking Done and ready for qc Marketplace',// subject when allocation done (Marketplace case)
            'QcCatlog' => 'Qc Done and ready for submission (Catlog)',//subject when qc completed

            'LotEditor' => 'Editing Lot Created Successfully',//subject when generate lot editing panel
            'WrcEditor' => 'Editing Wrc Created Successfully',//subject when generate wrc
            'WrcAllocationEditor' => 'Editing Wrc Allocation Started Successfully',//subject when allocation start
            'completeTaskInUploadEditingFinalLink' => 'Editing Tasking Done and ready for qc FinalLink',//subject when allocation done (FinalLink case)

            'LotShoot' => 'Lot Created Successfully(Shoot)',//subject when generate lot shoot panel
            'WrcShoot' => 'Wrc Created Successfully (Shoot)',//subject when generate wrc
            'ShootPlanInfo' => 'Plan Info(Shoot)',//subject 
            'ShootRawImage' => 'Shoot Raw Image Info(Shoot)',//subject 

        ][$creation_type] ?? '';

        /*set all users mail in $user  array start*/
        // $user_id = Auth::user()->id;
        $user_id = 9;
        $logged_in_user = DB::table('users')->where('id', $user_id )->first(['email','am_email']);
        $login_user_email = $logged_in_user != null ? $logged_in_user->email : "";
        $am_email = $logged_in_user != null ? $logged_in_user->am_email : "";

        $users = [];

        if($creation_type == 'Lot' || $creation_type == 'Wrc' || $creation_type == 'completeTaskInUpload' || $creation_type == 'Qc' || $creation_type == 'CatlogLot' || $creation_type == 'CatlogWrc' || $creation_type == 'completeTaskInUploadCatlogFinalLink' || $creation_type == 'completeTaskInUploadCatlogMarketPlace' || $creation_type == 'QcCatlog' || $creation_type == 'LotEditor' || $creation_type == 'WrcEditor' || $creation_type == 'completeTaskInUploadEditingFinalLink'  || $creation_type == 'LotShoot' || $creation_type == 'WrcShoot' || $creation_type == 'ShootPlanInfo' || $creation_type == 'ShootRawImage'){
            $users = [$login_user_email, $am_email];
        }

        if($creation_type == 'WrcAllocation'){
            $cw_user_data = $notification_data->cw_user_data;
            $gd_user_data = $notification_data->gd_user_data;

            $users = [$login_user_email, $am_email];
            foreach( $cw_user_data as $cwval){
                $cw_user = DB::table('users')->where('id', $cwval )->first('email');
                if ($cw_user) {
                    $users[] = $cw_user->email;
                }
            }
            foreach( $gd_user_data as $gdval){
                $gd_user = DB::table('users')->where('id', $gdval )->first('email');
                if ($gd_user) {
                    $users[] = $gd_user->email;
                }
            }
        }

        if($creation_type == 'WrcAllocationCatlog'){
            $catlogure_user_data = $notification_data->catlogure_user_data;
            $cw_user_data = $notification_data->cw_user_data;

            $users = [$login_user_email, $am_email];
            
                $cw_user = DB::table('users')->where('id', $catlogure_user_data )->first('email');
                if ($cw_user) {
                    $users[] = $cw_user->email;
                }
                $ct_user = DB::table('users')->where('id', $cw_user_data )->first('email');
                if ($ct_user) {
                    $users[] = $ct_user->email;
                }
        }

        if($creation_type == 'WrcAllocationEditor'){
            $editing_user_data = $notification_data->allocate_editor_id;
            $users = [$login_user_email, $am_email];
            
                $ed_user = DB::table('users')->where('id', $editing_user_data )->first('email');
                if ($ed_user) {
                    $users[] = $ed_user->email;
                }
        }
        /*set all users mail in $user  array end*/

        $users = array_filter(array_unique($users));// return unique e mail data and remove null data 
        // dd( $users);
        Mail::to($users)->send(new NotifyUsers($notification_data, $creation_type, $subject));// send mail to user

    }

    public function sent_otp_to_mail($user_data , $other_data){

        $email = $user_data->email;
        Mail::to($user_data->email)->send(new emailPhoneVerifcationOtp($user_data,$other_data));// send mail to user

    }


}
