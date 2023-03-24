<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientProfileController extends Controller
{
    public function index(){
        
        $data = User::getClientData();
        // dd($data);
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

        $email_count = User::where('email' , '=' , $email)->where('id' , '<>' , $user_id)->
        count();
        // dd($email_count);
        $update_users = User::find($user_id);
        if($phone != $update_users->phone){
            $update_users->phone_verified = 0;
        }
        if($email != $update_users->email){
            $update_users->email_verified = 0;
            $update_users->email_verified_at = NULL;
        }
        $update_users->name = $name;
        $update_users->last_name = $last_name;
        $update_users->client_id = $client_id;
        if($email_count == 0){
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
            request()->session()->flash('success', 'company_logo Successfully Updated!!');
        }else{
            request()->session()->flash('false', 'Somthing went wrong try again!!!');
        }
        // dd( $status ,$user_data, $request->all());
        return redirect()->route('ClientProfile');
    }

}
