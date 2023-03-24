<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ClientCommonController extends Controller
{
    // Send otp for emailVerifyOtp And phoneVerifyOtp
    public function sendOtp(Request $request){
        $otpfor = $request->otpfor;
        if($request->otpfor == 1){
            $sendOtpFor = "emailVerifyOtp";
            $OtpExpires_at = "emailVerifyOtpExpireAt";
        }else{
            $sendOtpFor = "phoneVerifyOtp";
            $OtpExpires_at = "phoneVerifyOtpExpireAt";
        }

        // OTP has expired, remove it from session
        if ($request->resend == 1 || Carbon::now()->greaterThanOrEqualTo(Session::get($OtpExpires_at))) {
            Session::forget($sendOtpFor);
            Session::forget($OtpExpires_at);
        }

        $SessionOtp = Session::get($sendOtpFor);
        $user_data = Auth::user();
        $massage = 'OTP sent!';
        if ($SessionOtp !== null && $SessionOtp !== '') {
            $otp = $SessionOtp;
        } else {
            $otp = strval(mt_rand(1000, 9999));
            $other_data = array(
                'otp' => $otp, 
                'sendOtpFor' => $sendOtpFor, 
                'otpfor' => $request->otpfor
            );
    
            if(($user_data->email_verified == 0 && $otpfor == 1) || ($user_data->phone_verified == 0 && $otpfor == 2)){
                Session::put($sendOtpFor, $otp);
                Session::put($OtpExpires_at, Carbon::now()->addSeconds(300));
                $this->sent_otp_to_mail($user_data, $other_data);
                $massage = 'OTP sent!';
            }else{
                $massage = 'Already vairified!!';
            }
        }

        $response = array(
            'massage' => $massage, 
            'email' => $user_data->email,
        );
        echo json_encode($response);
    }

    // verify otp for email And phone
    public function verifyOtp(Request $request){
        $final_otp = $request->final_otp;
        $otpfor = $request->otpfor;

        if($otpfor == 1){
            $sendOtpFor = "emailVerifyOtp";
            $OtpExpires_at = "emailVerifyOtpExpireAt";
        }else{
            $sendOtpFor = "phoneVerifyOtp";
            $OtpExpires_at = "phoneVerifyOtpExpireAt";
        }

        $is_OtpExpired = false;
        if (Carbon::now()->greaterThanOrEqualTo(Session::get($OtpExpires_at))) {
            $is_OtpExpired = true;
        }
        
        $status = false;
        if(!$is_OtpExpired){
            $SessionOtp = Session::get($sendOtpFor);
            if($SessionOtp == $final_otp){
                $user_data = User::find(Auth::id());
                if($otpfor == 1){
                    $user_data->email_verified = 1;
                    $user_data->email_verified_at = date('Y-m-d H:i:s');
                }else{
                    $user_data->phone_verified = 1;
                }
                $status = $user_data->update();
                if($status){
                    Session::forget($sendOtpFor);
                    Session::forget($OtpExpires_at);
                    $massage = "Success";
                }else{
                    $massage = "Somthing went wrong";
                }
            }else{
                $massage = "Otp not matched";
            }
        }else{
            $massage = "Otp expired";
        }
        echo json_encode(array(
            'status' => $status,
            'massage' => $massage
        ));
    }
}
