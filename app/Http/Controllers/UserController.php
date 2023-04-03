<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Brands;
use App\Models\brands_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\activityLogs;
use Image;
use Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\verifyEmail;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    
    {
        $users= User::whereHas('roles', function ($query) {
            return $query->where('name','!=', 'Client');
        })->latest()->paginate(10);;

        $roles= Role::latest()->get();

       


        return view('user.index',compact('users','roles'));

    }

    //Get all chilled clients based on the logged in client ID 
    public function clientIndex(Request $request)
    {
        $client_id = Auth::id();//logged in user id 103
        $dam_data  = User::where('id',$client_id)->first(['dam_enable']);
        $dam_enable = $dam_data != null ? $dam_data['dam_enable'] : 0;// if 1 then add user and if 0 then add user button will disable

        // dd($dam_enable);

        $brands = brands_user::where('user_id',$client_id)->with('getBrandName:id,name')->get();
        $users= User::
        // whereHas('roles', function ($query) {
        //     return $query->where('name','!=', 'Client');
        // })->
        where('parent_client_id',$client_id)
        ->latest()->paginate(10);

        $roles= Role::latest()->get();
        return view('user.indexforclient',compact('users','roles','brands','dam_enable'));

    }
    
    public function editC(Request $request)
    {

        $Id=$request->id;
        $data = User::getUserInfo(['user_id' => $Id, 'group_by' => 'users.id', 'single' => true]);
        $am= User::whereHas('roles', function ($query) {
            return $query->where('name','=', 'Account Management');
        })->latest()->get();

    $brand=Brands::latest()->get();

    
        return view('user.d-edit-client',compact('data','am','brand'));

    }

    public function editE(Request $request)
    {
        $Id=$request->id;
        $data = User::find(['id' => $Id])->first();

        $roles= Role::latest()->get();

        return view('user.d-edit-user',compact('data','roles'));
    }

    public function userValid(Request $request)
    {
        $responseData = array('client_id' => false,'email' => false,);
        
        $client_id=$request->client_id;
        $email=$request->email;

        $client_idData = User::where(['client_id' => $client_id])->first();
        if(!empty($client_idData)){
            $responseData['client_id'] = true;
        }
        $emailData = User::where(['email' => $email])->first();
        if(!empty($emailData)){
            $responseData['email'] = true;
        }
        return response() ->json($responseData , 200);
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

    public function clientValid(Request $request){
        $responseData = array('c_short' => false, 'email' => false, 'gst_number' => false,'client_id' => false);
        $c_short=$request->c_short;
        $email=$request->email;
        
        $client_id=$request->client_id;

        $cShortData = User::where(['c_short' => $c_short])->first();
        if(!empty($cShortData)){
            $responseData['c_short'] = true;
        }
        $clientData = User::where(['client_id' =>$client_id])->first();
        if(!empty($clientData)){
            $responseData['client_id'] = true;
        }
       
        // $client_idData = User::where(['client_id' => $client_id])->first();
        // if(!empty($client_idData)){
        //     $responseData['client_id'] = true;
        // }

        return response() ->json($responseData , 200);
        

    }
    
    public function saveUser(Request $request)

    {
        // dd($request->all());
       $password = ('Odn@2021');
       $user = new User();

       $user->name = $request->name;
       $user->email = $request->email;
       $user->phone = $request->phone;
       $user->client_id =$request->client_id;
       $user->c_short=$request->c_short;
       $user->Company = $request->company;
       $user->Address = $request->address;
       $user->payment_term = $request->payment_term;
       $user->Gst_number= $request->gst_number;
       $user->am_email= $request->am_email;
       $user->password = bcrypt($password);
       $user->verifyToken= Str::random(40) ;
       $user->assignRole($request->role);

       $user->save();


       return response()->json('ok',200);

   }

    /***parent_client(parent client) will create sub_client( sub client) ***/
   public function saveUserClient(Request $request)
    {
        $parent_client_id = Auth::id();//logged in user id 113
        $parent_client_data  = User::where('id',$parent_client_id)->first();

        $role = $request->role;
        $role_data = DB::table('roles')->where('name',$role)->first(['id']);
        $role_id = $role_data != null ? $role_data->id : 0; // sub client role id

        // dd($request->user_module);

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

        // dd(['dam_user_module'=> $dam_user_module, 'oms_user_module'=>$oms_user_module]);

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
            $user->dam_enable = $dam_user_module != '' ? 1 : 0;
            $user->oms_enable = $oms_user_module != '' ? 1 : 0;
            $user->dam_module_name = $dam_user_module != '' ? 'DAM' : '';
            $user->oms_module_name = $oms_user_module != '' ? 'OMS' : '';
            $user->password = bcrypt($password);
            $user->verifyToken = Str::random(40);
            /** create model has role data **/
            $user->assignRole($request->role);
            $user->save();

            foreach($brand_id_array as $key=>$brand){
                $createBrandUser = new Brands_user();
                $createBrandUser->user_id = $user->id;
                $createBrandUser->brand_id = $brand;
                $createBrandUser->save();
            }

            $update_user = User::find($user->id);
            $update_user->oms_enable = $oms_user_module != '' ? '1' : '0';
            $update_user->dam_enable = $dam_user_module != '' ? '1' : '0';
            $update_user->update();

            DB::commit();
            // all good
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

       return response()->json('ok',200);

    }

   public function manage(Request $request){

    $roles= Role::latest()->get();

    $am= User::whereHas('roles', function ($query) {
        return $query->where('name','=', 'Account Management');
    })->latest()->get();

    $brand=Brands::latest()->get();

    $users= User::whereHas('roles', function ($query) {
        return $query->where('name','=', 'Client');
    })->get();
    $users->transform(function($user){
        $userInfo = $user->getUserInfo(['user_id' => $user->id, 'group_by' => 'users.id', 'single' => true]);
        $user->brands_name = $userInfo->brands_name;
        $user->brand_ids =  ($userInfo->brand_ids) ? explode('|', $userInfo->brand_ids): [];
        $user->role= $user->getRoleNames()->first();
        $user->userPermissions = $user->getPermissionNames();
        return $user;
    });


   
    return view('user.manage', compact('roles','am','brand','users'));
}

public function brands(){

return  $this->belongsToMany(Brands::Class);

}

public function getbrands(){

    $brand=Brands::latest()->get();
    
}

public function getAllAm(){

    $users =User::whereHas(
        'roles', function($q){
            $q->where('name', 'Account Management');
        }
    )->get();

    return response() ->json([
     'accountms' => $users
 ], 200);
    

}


public function getAll(){
    $users = User::latest()->get();
    $users->transform(function($user){
        $userInfo = $user->getUserInfo(['user_id' => $user->id, 'group_by' => 'users.id', 'single' => true]);
        $user->brands_name = $userInfo->brands_name;
        $user->brand_ids =  ($userInfo->brand_ids) ? explode('|', $userInfo->brand_ids): [];
        $user->role= $user->getRoleNames()->first();
        $user->userPermissions = $user->getPermissionNames();
        return $user;
    });
    return response()->json([
        'users'=>$users

    ],200);
}

    /**
     * Sho  the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $password = ('Odn@2021');
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->client_id =$request->client_id;
        $user->c_short=$request->c_short;
        $user->Company = $request->company;
        $user->Address = $request->address;
        $user->payment_term = $request->payment_term;
        $user->Gst_number= $request->gst_number;
        $user->am_email= $request->am_email;
        $user->password = bcrypt($password);
        $user->verifyToken= Str::random(40) ;
        $user->assignRole($request->role);
        
        $user->save();

        $id=$user->id;
        $brands=$request->brand;
        Brands_user::where(['user_id' => $id])->delete();

        foreach($brands as $brand){
            $brandObj = new Brands_user();
            $brandObj->user_id = $id;
            $brandObj->brand_id = $brand;
            $brandObj->save();
        }




        return response()->json('ok',200);
    }

    public function updateClient(Request $request){

       $id=$request->id;
        $user = User::findOrFail($id);
        $user->client_id = $request->client_id;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->c_short=$request->c_short;
        $user->Company = $request->Company;
        $user->Address = $request->Address;
        $user->payment_term = $request->payment_term;
        $user->Gst_number= $request->Gst_number;
        $user->am_email= $request->am_email;
        $user->verifyToken= Str::random(40) ;
        $user->assignRole($request->role);
        
        $user->save();

        $brands=$request->brand;
       

        foreach($brands as $brand){
            $brandObj = new Brands_user();
            $brandObj->user_id = $id;
            $brandObj->brand_id = $brand;
            $brandObj->save();
        }

 return response()->json('ok',200);

    
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


//     public function sendEmail($thisUser)
// {
//     Mail::to($thisUser['am_email'])->send(new verifyEmail($thisUser));
// }



    public function sendEmailDone($email,$verifyToken){
        $user = User::where(['email'=>$email,'verifyToken'=>$verifyToken])->first();
        if($user){
            return User::where(['email'=>$email,'verifyToken'=>$verifyToken])->update(['verification_status'=>'1','verifyToken'=>Null]);
        } else{
         'user not found';
     }
 }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)

    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       $id=$request->id;
        $user = User::findOrFail($id);
        $user->client_id = $request->client_id;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->Company = $request->Company;
        $user->email = $request->email;
        $user->Address = $request->Address;
        $user->Gst_number= $request->Gst_number;

        if($request->has('password')){
            $user->password = bcrypt($request->password);
        }


        if($request->has('role')){
            $userRole = $user->getRoleNames();
            foreach($userRole as $role){
                $user->removeRole($role);
            }

            $user->assignRole($request->role);
        }

        if($request->has('permissions')){
            $userPermissions = $user->getPermissionNames();
            foreach($userPermissions as $permssion){
                $user->revokePermissionTo($permssion);
            }

            $user->givePermissionTo($request->permissions);
        }
        $user->save();

        return response()->json('ok',200);
    }

    public function restore($id)
    {
      User::withTrashed()->where('id', $id)->restore();
      
  }


  public function delete(Request $request,$id){

  
  pr($id,1);
    $user = User::findOrfail($id);  
    $user->delete();
    return response()->json('ok',200); 
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    


/////////// usr desfine method

    public function profile (){

        $userId=Auth::id();

        $lastActivity=activityLogs::getLogs(['causer_id'=> $userId, 'order_by'=>'DESC']);


        return view ('profile.index',compact('lastActivity'));

    }

    public function postProfile(Request $request){

     $user=auth()->user();
     $user->getUserInfo(['user_id' => $user->id, 'group_by' => 'users.id', 'single' => true]);
     $this->validate($request, [
        'name'=> 'nullable',
        'client_id'=>'nullable',
        'phone' => 'nullable',
        'Company'=>'nullable',
        'brand'=>'nullable',
        'Address'=>'nullable',
        'Gst_number'=>'nullable',
        'email'=>'required|email|unique:users,email,'.$user->id
        

    ]);
     $user->update($request->all());

     return redirect()->back()->with('success', 'Profile Successfully updated ');
 }

public function getPassword(){

    return view('profile.password');

}

public function postPassword(Request $request){

 $this->validate($request,[
     'newpassword' => 'required|min:6|max:20|confirmed'

 ]);

 $user=auth()->user();

 $user->update([
    'password' => bcrypt($request->newpassword)
]);
 return redirect()->back()->with('success','Password has been change Successfully');

}

public function search(Request $request){
    $searchWord = $request->get('s');
    $users = User::where(function($query) use ($searchWord){
        $query->where('name', 'LIKE', "%$searchWord%")
        ->orWhere('client_id', 'LIKE', "%$searchWord%")
        ->orWhere('email', 'LIKE', "%$searchWord%")
        ->orWhere('Company', 'LIKE', "%$searchWord%");
    })->latest()->get();

    $users->transform(function($user){
        $user->role = $user->getRoleNames()->first();
        $user->userPermissions = $user->getPermissionNames();
        return $user;
    });

    return response()->json([
        'users' => $users
    ], 200);
    
}
public function profileimage(Request $request){
    if($request->hasFile('photo')){
        $photo = $request->file('photo');
        $filename=time().'.'.$photo->getClientOriginalExtension();
        Image::make($photo)->resize(300,300)->save('dist/img/uploads/avatars/'.$filename);

        $user=auth()->user();
        $user->photo = $filename;
        $user->save();
    }
    
      $userId=Auth::id();

        $lastActivity=activityLogs::getLogs(['causer_id'=> $userId, 'order_by'=>'DESC']);

     return view ('profile.index',compact('lastActivity'));

}
public function manage_client_dam(Request $request){
    $dam_enable = $request->dam_enable;
    $id = $request->id;
    $data = User::where('id',$id)->first();
    $status = 0;
    if($data != null){
        $parent_Company = $data['Company'];
        $client_name = $data['name'];
        $password = User::genratePassword($parent_Company, $client_name);
        $user_data = array(
            'name' => $client_name,
            'client_id' => $data->client_id,
            'email' => $data->email,
            'password' => $password
        );

        $update_user = User::find($id);
        $update_user->dam_enable = $dam_enable;
        if($dam_enable == 1){
            $update_user->password = bcrypt($password);
        }
        $status = $update_user->update();
        if($dam_enable == 1 && $status == 1){
            $this->send_password_to_mail($user_data);
        }
    }
    echo $status;
}


}
