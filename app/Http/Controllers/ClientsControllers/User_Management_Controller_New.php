<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\Brands_user;
use App\Models\ClientActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;


class User_Management_Controller_New extends Controller
{
  //Get all chilled clients based on the logged in client ID 
  public function Index(Request $request)
  {
    $user_data = Auth::user();
    if ($user_data->dam_enable != 1) {
      request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
      return redirect()->route('home_new');
    }
    $client_id = $user_data->id; //logged in user id 103
    $users = User::where('parent_client_id', $client_id)->get()->toArray();

    return view('clients.ClientUserManagement.users-list')->with('users', $users);
  }

  public function create()
  {
    $user_data = Auth::user();
    if ($user_data->dam_enable != 1) {
      request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
      return redirect()->route('home_new');
    }
    $client_id = $user_data->id; //logged in user id 103
    $brands = Brands_user::leftJoin('brands', 'brands.id', '=', 'brands_user.brand_id')
      ->select('*')
      ->where('user_id', '=', $client_id)
      ->whereNotNull('brands.name')
      ->get()->toArray();

    // dd($brands);

    return view('clients.ClientUserManagement.create_user')->with('brands', $brands);
    // return view('clients.ClientUserManagement.UserManagement')->with('brands', $brands);
  }

  public function saveUserClient(Request $request)
  {

    // dd($request->all());
    $parent_client_id = Auth::id(); //logged in user id 113
    $parent_client_data  = User::where('id', $parent_client_id)->first();

    $role = $request->role;
    $role_data = DB::table('roles')->where('name', $role)->first(['id']);
    $role_id = $role_data != null ? $role_data->id : 0; // sub client role id

    $dam_user_module = '';
    $oms_user_module = '';

    $module_arry = $request->user_module;

    if (in_array("DAM", $module_arry)) {
      $dam_user_module = "DAM";
    }

    if (in_array("OMS", $module_arry)) {
      $oms_user_module = "OMS";
    }

    $brand_id_array     = $request->brand;
    $sub_client_name    = $request->name;
    $sub_client_email   = $request->email;

    $check = $parent_client_data  != null;

    $parent_client_am_email   =     $check ? $parent_client_data['am_email'] : 0;
    $parent_payment_term      =     $check ? $parent_client_data['payment_term'] : 0;
    $parent_Company           =     $check ? $parent_client_data['Company'] : 0;
    $parent_c_short           =     $check ? $parent_client_data['c_short'] : 0;
    $parent_Gst_number        =     $check ? $parent_client_data['Gst_number'] : 0;
    $client_id         =     $check ? $parent_client_data['client_id'] : 0;


    DB::beginTransaction();
    try {
      // create sub client 
      $password = User::genratePassword($parent_Company, $sub_client_name);
      // $password = 'Odn@2023';
      $user = new User();
      $user->name = $request->name;
      $user->email = $request->email;
      $user->phone = $request->phone;
      $user->Address = $request->address;
      $user->client_id = $client_id;
      $user->c_short = $parent_c_short;
      $user->Company = $parent_Company;
      $user->payment_term = $parent_payment_term;
      $user->Gst_number = $parent_Gst_number;
      $user->am_email = $parent_client_am_email;
      $user->parent_client_id = $parent_client_id;
      $user->oms_enable = $oms_user_module != '' ? '1' : '0';
      $user->dam_enable = $dam_user_module != '' ? '1' : '0';
      $user->dam_module_name = $dam_user_module != '' ? 'DAM' : '';
      $user->oms_module_name = $oms_user_module != '' ? 'OMS' : '';
      $user->password = bcrypt($password);
      $user->verifyToken = Str::random(40);

      /** create model has role data **/
      $user->assignRole($request->role);
      $user_id = $user->save();

      foreach ($brand_id_array as $key => $brand) {
        $createBrandUser = new Brands_user();
        $createBrandUser->user_id = $user->id;
        $createBrandUser->brand_id = $brand;
        $createBrandUser->save();
      }

      if ($user_id > 0) {
        $ClientActivityLog = new ClientActivityLog();
        $ClientActivityLog->log_name = 'Sub Client created';
        $ClientActivityLog->description = 'App\Models\User';
        $ClientActivityLog->event = 'Sub Client created';
        $ClientActivityLog->subject_type = 'App\Models\User';
        $ClientActivityLog->subject_id = $user->id;
        $ClientActivityLog->causer_type = 'App\Models\User';
        $ClientActivityLog->causer_id = Auth::id();
        $ClientActivityLog->properties = json_encode($request->all());
        $ClientActivityLog->save();
        $user_data = array(
          'name' => $sub_client_name,
          'client_id' => $client_id,
          'email' => $sub_client_email,
          'password' => $password
        );
        // $this->send_password_to_mail($user_data);
      }

      DB::commit();
      return response()->json('ok', 200);
    } catch (\Throwable $th) {
      DB::rollback();
      throw $th;
    }
    return response()->json('flase', 500);
  }

  // sub_users_access_permission_new
  public function sub_users_access_permission_new(Request $request){
    $ya_shoot = ($request->ya_shoot && ($request->ya_shoot == 'on' || $request->ya_shoot == 1 )) ? true : false ;
    $ya_Creative = ($request->ya_Creative && ($request->ya_Creative == 'on' || $request->ya_Creative == 1 )) ? true : false ;
    $ya_Cataloging = ($request->ya_Cataloging && ($request->ya_Cataloging == 'on' || $request->ya_Cataloging == 1 )) ? true : false ;
    $ya_Editing = ($request->ya_Editing && ($request->ya_Editing == 'on' || $request->ya_Editing == 1 )) ? true : false ;
    
    $fm_shoot = ($request->fm_shoot && ($request->fm_shoot == 'on' || $request->fm_shoot == 1 )) ? true : false ;
    $fm_Creative = ($request->fm_Creative && ($request->fm_Creative == 'on' || $request->fm_Creative == 1 )) ? true : false ;
    $fm_Cataloging = ($request->fm_Cataloging && ($request->fm_Cataloging == 'on' || $request->fm_Cataloging == 1 )) ? true : false ;
    $fm_Editing = ($request->fm_Editing && ($request->fm_Editing == 'on' || $request->fm_Editing == 1 )) ? true : false ;

    $your_assets_permissions = json_encode(array(
        'shoot' => $ya_shoot,
        'Creative' => $ya_Creative,
        'Cataloging' => $ya_Cataloging,
        'Editing' => $ya_Editing
    ),true);

    $file_manager_permissions = json_encode(array(
        'shoot' => $fm_shoot,
        'Creative' => $fm_Creative,
        'Cataloging' => $fm_Cataloging,
        'Editing' => $fm_Editing
    ),true);

    $user_id = $request->user_id;
    $user_data = User::find($user_id);

    $properties = array(
        'attributes' => array(
            "file_manager_permissions" => $file_manager_permissions,
            "file_manager_permissions" => $file_manager_permissions,
        ),
        'old' => array(
            "file_manager_permissions" => $user_data->file_manager_permissions,
            "file_manager_permissions" => $user_data->file_manager_permissions,
        ),
    );
    
    $user_data->your_assets_permissions = $your_assets_permissions;
    $user_data->file_manager_permissions = $file_manager_permissions;
    $update_status = $user_data->update();
    if($update_status){
        $ClientActivityLog = new ClientActivityLog();
        $ClientActivityLog->log_name = 'Sub Client Permission Updated';
        $ClientActivityLog->description = 'Sub Client Permition Updated By '.Auth::user()->name;
        $ClientActivityLog->event = 'Sub Client Permission Updated';
        $ClientActivityLog->subject_type = 'App\Models\User';
        $ClientActivityLog->subject_id = $user_id;
        $ClientActivityLog->causer_type = 'App\Models\User';
        $ClientActivityLog->causer_id = Auth::id();
        $ClientActivityLog->properties = json_encode($properties);
        $ClientActivityLog->save();
        request()->session()->flash('success', 'Permission Successfully Updated!!');
    }else{
        request()->session()->flash('false', 'Somthing went wrong try again!!!');
    }
    return redirect()->route('Client_Users_list');
}
}
