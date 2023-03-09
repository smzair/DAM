<?php

namespace App\Http\Controllers;

use App\Models\Brands_user;
use App\Models\ClientActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class ClientUserManagementController extends Controller
{
    //Get all chilled clients based on the logged in client ID 
    public function Index(Request $request)
    {
        $client_id = Auth::id();//logged in user id 103
        $dam_data  = User::where('id',$client_id)->first(['dam_enable']);
        $dam_enable = $dam_data != null ? $dam_data['dam_enable'] : 0;// if 1 then add user and if 0 then add user button will disable
        $users= User::where('parent_client_id',$client_id)->get();

        // dd($users);
        return view('clients.ClientUserManagement.UserManagementList',compact('users','dam_enable'));

    }

    public function create(){
        $client_id = Auth::id();
        $brands = Brands_user::leftJoin('brands', 'brands.id', '=', 'brands_user.brand_id')
        ->select('*')
        ->where('user_id', '=', 357)
        ->whereNotNull('brands.name')
        ->get()->toArray();
        $roles= Role::latest()->get();

        $user_data = (object) [
            'id' => '0',
            'dam_enable' => '0',
            'dam_enable' => '0',
            'oms_enable' => '0',
        ];
        return view('clients.ClientUserManagement.UserManagement',compact('roles','brands'));
    }

    public function clientUserValid(Request $request)
    {
        $responseData = array('email' => false,);
        $email=$request->email;
        $emailData = User::where(['email' => $email])->first();
        if(!empty($emailData)){
            $responseData['email'] = true;
        }
        return response() ->json($responseData , 200);
    }

    public function saveUserClient(Request $request)
    {
        $parent_client_id = Auth::id();//logged in user id 113
        $parent_client_data  = User::where('id',$parent_client_id)->first();

        $role = $request->role;
        $role_data = DB::table('roles')->where('name',$role)->first(['id']);
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
        $sub_client_address = $request->address;
        $sub_client_phone   = $request->phone;

        $check = $parent_client_data  != null;

        $parent_client_dam_enable =     $check ? $parent_client_data['dam_enable'] : 0;
        $parent_client_am_email   =     $check ? $parent_client_data['am_email'] : 0;
        $parent_active_status     =     $check ? $parent_client_data['active_status'] : 0;
        $parent_dark_mode         =     $check ? $parent_client_data['dark_mode'] : 0;
        $parent_messenger_color   =     $check ? $parent_client_data['messenger_color'] : 0;
        $parent_avatar            =     $check ? $parent_client_data['avatar'] : 0;
        $parent_payment_term      =     $check ? $parent_client_data['payment_term'] : 0;
        $parent_phone_verified    =     $check ? $parent_client_data['phone_verified'] : 0;
        $parent_Company           =     $check ? $parent_client_data['Company'] : 0;
        $parent_c_short           =     $check ? $parent_client_data['c_short'] : 0;
        $parent_location          =     $check ? $parent_client_data['location'] : 0;
        $parent_Gst_number        =     $check ? $parent_client_data['Gst_number'] : 0;
        $parent_status            =     $check ? $parent_client_data['status'] : 0;
        $parent_photo             =     $check ? $parent_client_data['photo'] : 0;
        $client_id         =     $check ? $parent_client_data['client_id'] : 0;


        DB::beginTransaction();
        try {   
            // create sub client 
            $password = 'Odn@2023';
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

            foreach($brand_id_array as $key=>$brand){
                $createBrandUser = new Brands_user();
                $createBrandUser->user_id = $user->id;
                $createBrandUser->brand_id = $brand;
                $createBrandUser->save();
            }

            if($user_id > 0){
                $ClientActivityLog = new ClientActivityLog();
                $ClientActivityLog->log_name = 'Sub Client created';
                $ClientActivityLog->description = 'App\Models\User';
                $ClientActivityLog->event = 'Sub Client created';
                $ClientActivityLog->subject_type = 'App\Models\User';
                $ClientActivityLog->subject_id = $user_id;
                $ClientActivityLog->causer_type = 'App\Models\User';
                $ClientActivityLog->causer_id = Auth::id();
                $ClientActivityLog->properties = json_encode($request->all());
                $ClientActivityLog->save();
            }

            DB::commit();
            return response()->json('ok',200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
       return response()->json('flase',500);
    }

    public function ClientsUserList(){
        $sub_users_list = User::where('users.parent_client_id', '>' , '0')
        ->leftJoin('users as parent_user' , 'users.parent_client_id','=','parent_user.id')
        ->select('users.*','parent_user.name as p_name','parent_user.last_name as p_last_name','parent_user.phone as p_phone')
        ->get()->toArray();
        // dd($sub_users_list);
        return view('admin.Control-panel.clients-user-list',compact('sub_users_list'));
    }

    public function updateClientsUser(Request $request){
        
        $id = $request->id;
        $phone = $request->phone;
        $email = $request->email;
        $name = $request->name;
        $update_status = $satus = 0;
        $massage = "Somthing Went Wrong ";
        try {
            $count_user = User::where('users.id', '<>' , $id)->where('email' , '=' , $email)
            ->count();
            if($count_user == 0){
                $update_user = User::find($id);
                $old = $update_user->getAttributes();
                
                $update_user->phone = $phone;
                $update_user->email = $email;
                $update_user->name = $name;
                $update_status = $update_user->update();
                
                if($update_status){
                    $satus = 1;
                    
                    $updated_user = User::find($id);
                    $attributes = $updated_user->getAttributes();
                     $properties = array(
                        'attributes' => $attributes,
                        'old' => $old
                    );
                    $ClientActivityLog = new ClientActivityLog();
                    $ClientActivityLog->log_name = 'Sub Client Updated';
                    $ClientActivityLog->description = 'Sub Client Updated By '.Auth::user()->name;
                    $ClientActivityLog->event = 'Sub Client Updated';
                    $ClientActivityLog->subject_type = 'App\Models\User';
                    $ClientActivityLog->subject_id = $id;
                    $ClientActivityLog->causer_type = 'App\Models\User';
                    $ClientActivityLog->causer_id = Auth::id();
                    $ClientActivityLog->properties = json_encode($properties);
                    $ClientActivityLog->save();

                    $massage = "Record updated successfully ";
                }
            }else{
                $massage = "Email aleady taken can not update!!";
                $satus = 0;
            }
            $response = array(
                'satus' => $satus,
                'massage' => $massage,
            );
            echo json_encode($response);    
        } catch (\Throwable $error) {
            throw $error;
        }

    }
    
}
