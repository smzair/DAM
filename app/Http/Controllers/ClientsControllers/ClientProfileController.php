<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\ClientActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientProfileController extends Controller
{
    public function index(){
        
        $data = User::getClientData();
        // dd($data);
        return view('clients.ClientUserManagement.clients-profile')->with('data',$data);
        return view('clients.Client-Profile')->with('data',$data);
    }

    public function UpdateClientProfile(Request $request){
        $user_id = $request->id;
        $roledata = getUsersRole($user_id);
        $role = $roledata->role_name;

        $name = $request->clientFirstName != null ? $request->clientFirstName : '';
        $last_name = $request->clientLastName != null ? $request->clientLastName : '';
        $client_id = $request->clientId != null ? $request->clientId : 'Not Yet Generat';
        $email = $request->clientEmail != null ? $request->clientEmail : '';
        $phone = $request->clientPhone != null ? $request->clientPhone : '';

        $email_count = User::where('email' , '=' , "$email")->where('id' , '<>' , $user_id)->
        count();
        $update_users = User::find($user_id);
        if($phone != $update_users->phone){
            $update_users->phone_verified = 0;
        }
        // dd($request->all(), $email_count);
        if($email != $update_users->email ){
            $update_users->email_verified = 0;
            $update_users->email_verified_at = NULL;
        }
        $update_users->name = $name;
        $update_users->last_name = $last_name;
        $update_users->client_id = $client_id;
        if($email_count == 0 && $email != '' && $email != null){
            $update_users->email = $email;
        }
        $update_users->phone = $phone;
        $update_users_status = $update_users->update();

        if ($update_users_status) {
            if($email_count == 0){
                request()->session()->flash('success', 'Profile Successfully Updated!!');
            }else{
                request()->session()->flash('warning', 'Profile Successfully Updated!! Not a unique email ID! Can not update it');
            }
        } else {
            request()->session()->flash('false', 'Somthing went wrong try again!!!');
        }
        // dd($update_users_status , $update_users , $request->all());
        return redirect()->route('ClientProfile');
    }

    public function UpdateClientcompanyDetails(Request $request){
        $user_id = $request->id;
        $roledata = getUsersRole($user_id);
        $role = $roledata->role_name;
        
        $Company = $request->companyName != null ? $request->companyName : '';
        $email = $request->companyEmail != null ? $request->companyEmail : '';
        $phone = $request->companyPhone != null ? $request->companyPhone : '';
        
        $email_count = User::where('email' , '=' , $email)->where('id' , '<>' , $user_id)->
        count();
        $update_users = User::find($user_id);
        $old_email = $update_users->email;
        if($phone != $update_users->phone){
            $update_users->phone_verified = 0;
        }
        if($email != $old_email){
            $update_users->email_verified = 0;
            $update_users->email_verified_at = NULL;
        }
        if($email_count == 0){
            $update_users->email = $email;
        }
        $update_users->phone = $phone;
        $update_users->Company = $Company;
        $update_users_status = $update_users->update();

        if ($update_users_status) {
            if($email_count == 0){
                request()->session()->flash('success', 'Company Details Successfully Updated!!');
            }else{
                request()->session()->flash('warning', 'Company Details Successfully Updated!! Not a unique email ID! Can not update it');
            }
        }else {
            request()->session()->flash('false', 'Somthing went wrong try again!!!');
        }
        return redirect()->route('ClientProfile');
    }

    public function UpdateClientbillingDetails(Request $request){
        $user_id = $request->id;
        $roledata = getUsersRole($user_id);
        $role = $roledata->role_name;
        
        $Gst_number = $request->gstNo != null ? $request->gstNo : '';
        $pen_number = $request->panNo != null ? $request->panNo : '';
        $Address = $request->completeAddress != null ? $request->completeAddress : '';
        $postal_code = $request->pinCode != null ? $request->pinCode : '';
        $update_users = User::find($user_id);
        $update_users->Gst_number = $Gst_number;
        $update_users->pen_number = $pen_number;
        $update_users->Address = $Address;
        $update_users->postal_code = $postal_code;
        $update_users_status = $update_users->update();

        if ($update_users_status) {
            request()->session()->flash('success', 'Billing Details Successfully Updated!!');
        }else {
            request()->session()->flash('false', 'Somthing went wrong try again!!!');
        }
        return redirect()->route('ClientProfile');
    }

    public function UploadeClientAvtar(Request $request){
        $file = $request->file('profileavtar');
        $filename = $file->getClientOriginalName();
        $file_path = "uploades/profileavtar/";
        $file->move($file_path, $filename);

        $user_data = User::find(Auth::id());
        $user_data->profile_avtar = $filename;
        $status = $user_data->update();
        if($status){
            request()->session()->flash('success', 'Profile Avtar Successfully Updated!!');
        }else{
            request()->session()->flash('false', 'Somthing went wrong try again!!!');
        }
        return redirect()->route('ClientProfile');
        // dd( $status ,$user_data, $request->all());
    }

    public function UploadeCompanyLogo(Request $request){
        $file = $request->file('company_logo');
        $filename = $file->getClientOriginalName();
        $file_path = "uploades/company_logo/";
        $file->move($file_path, $filename);

        $user_data = User::find(Auth::id());
        $user_data->company_logo = $filename;
        $status = $user_data->update();
        if($status){
            request()->session()->flash('success', 'Company Logo Successfully Updated!!');
        }else{
            request()->session()->flash('false', 'Somthing went wrong try again!!!');
        }
        // dd( $status ,$user_data, $request->all());
        return redirect()->route('ClientProfile');
    }

    // delete-image
    function deleteImage(Request $request){
        $user_data = User::find(Auth::id());
        $profile_avtar = $user_data->profile_avtar;
        $company_logo = $user_data->company_logo;
        $deleteImageFor = $request->deleteImageFor;

        if($deleteImageFor == 1){
            $user_data->profile_avtar = null;
            $event = $log_name = "Profile Image Delete";
            $file_path = "uploades/profileavtar/".$profile_avtar;

        }else{
            $user_data->company_logo = null;
            $event = $log_name = "Company Logo Delete";
            $file_path = "uploades/company_logo/".$company_logo;
        }

        $update_status = $user_data->update();

        if($update_status){
            $ClientActivityLog = new ClientActivityLog();
            
            $ClientActivityLog->log_name = $log_name;
            $ClientActivityLog->description = $log_name.' By '.$user_data->name;
            $ClientActivityLog->event = $event;
            $ClientActivityLog->subject_type = 'App\Models\User';
            $ClientActivityLog->subject_id = 0;
            $ClientActivityLog->causer_type = 'App\Models\User';
            $ClientActivityLog->causer_id = $user_data->id;
            $ClientActivityLog->properties = [];
            if(($deleteImageFor == 1 && $profile_avtar != '') || ($deleteImageFor == 2 && $company_logo != '')){
                $ClientActivityLogSatus = $ClientActivityLog->save();
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
        }
        echo "Success"; 
    }

}
