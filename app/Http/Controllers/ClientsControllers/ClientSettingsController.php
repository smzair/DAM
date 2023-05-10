<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\ClientActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientSettingsController extends Controller
{
    public function index(){
        $data = User::getClientData();
        // dd($data);
        return view('clients.Client-settings')->with('data',$data);
    }

    public function Client_Setting_new(){
        $data = User::getClientData();
        // dd($data);
        return view('clients.ClientUserManagement.client-settings')->with('data',$data);
    }

    public function ChangePassword(Request $request){
        $oldPswdInput = trim($request->oldPswdInput);
        $newPswdInput = trim($request->newPswdInput);
        $confirmPswdInput = trim($request->confirmPswdInput);

        $uppercase = preg_match('@[A-Z]@', $newPswdInput);
        $lowercase = preg_match('@[a-z]@', $newPswdInput);
        $number    = preg_match('@[0-9]@', $newPswdInput);
        $specialChars = preg_match('@[^\w]@', $newPswdInput);

        if($uppercase && $lowercase && $number && $specialChars && strlen($newPswdInput) > 7) {
            if($newPswdInput == $confirmPswdInput){
                $user_id = Auth::id();
                $update_user_data = User::find($user_id);
                $old = $update_user_data->getAttributes();
                $update_user_data->password = bcrypt($newPswdInput);
                $update_status = $update_user_data->update();

                if($update_status){

                    $attributes = $update_user_data->getAttributes();
                     $properties = array(
                        'attributes' => $attributes,
                        'old' => $old
                    );
                    $ClientActivityLog = new ClientActivityLog();
                    $ClientActivityLog->log_name = 'Password Updat';
                    $ClientActivityLog->description = 'Password By '.Auth::user()->name;
                    $ClientActivityLog->event = 'Password Updated';
                    $ClientActivityLog->subject_type = 'App\Models\User';
                    $ClientActivityLog->subject_id = $user_id;
                    $ClientActivityLog->causer_type = 'App\Models\User';
                    $ClientActivityLog->causer_id = Auth::id();
                    $ClientActivityLog->properties = json_encode($properties);
                    $ClientActivityLogSatus =$ClientActivityLog->save();
                    request()->session()->flash('success', 'Password Updated!!!');
                }else{
                    request()->session()->flash('warning', 'Somthing went wrong!! Please try again!!');
                }
                request()->session()->flash('false', 'Password should be at least 8 characters in length and should include at least one upper case letter, one lower case letter,  one number, and one special character.');
            }else{
                request()->session()->flash('false', 'Password and Confirm Password not same.');
            }
        }else{
            request()->session()->flash('false', 'Password should be at least 8 characters in length and should include at least one upper case letter, one lower case letter,  one number, and one special character.');
        }
        return redirect()->route('ClientSetting');
    }
}
