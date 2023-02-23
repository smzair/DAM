<?php

namespace App\Http\Controllers;
use App\Resource\Views\Mail\SignupEmail;
use App\Resource\Views\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mailer;

class MailController extends Controller
{

     public static function sendSignupEmail($name , $email, $verification_code){
         $data= [
             'name' => $name,
             'verification_code'=>$verification_code
         ];
         Mail::to()->send(new SignupEmail($data));
     }




    public function sendEmail()
    {

        $details =[
            'title'=> 'Mail form ODN DIGITAL ',
            'body' => 'This is For Testing mail using gmail'         
        ];
        Mail::to("nishant.kumar@odndigital.com")->send(new TestMail($details));
        return "Email sent";
    }
}
