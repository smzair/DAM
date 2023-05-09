<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


use DB;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable 
{
  use HasFactory, Notifiable, HasRoles, SoftDeletes , LogsActivity;

  

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'id';
    protected $fillable = [
      'name',
      'email',
      'password',
      'phone',
      'photo',
      'client_id',
      'Address',
      'Gst_number',
      'Company',
      'brand',
      'verifyToken'
      
    ];

    /**s
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'password',
      'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'email_verified_at' => 'datetime',
      
    ];


    public function getpassword(Request $request){

      $password=$request->password;

      $decryptedPassword = decrypt($encryptedPassword);

      $password == $decryptedPassword;
    }

    
    public function getActivitylogOptions(): LogOptions
    {
      return LogOptions::defaults();
    }

    public function brand()
    {
      return $this->belongsToMany('App\Models\Brands');
    }


    public static function getUserInfo($filter = []){
      $wheerArr = [];
      $selectArr[] = 'users.*';
      if(empty($filter['group_by'])){
        $selectArr[] = 'brands.id as brand_id';
        $selectArr[]= 'brands.name as brand_name';
      }
      if(!empty($filter['group_by'])){
        $selectArr[] = DB::raw('group_concat(brands.name separator " | ") as `brands_name`');
        $selectArr []= DB::raw('group_concat(brands.id separator "|") as `brand_ids`','brands.short_name');
      }

      if(isset($filter['user_id'])){
        $wheerArr[] = ['users.id', '=' , $filter['user_id']];
      }
      if(isset($filter['brand_id'])){
        $wheerArr[] = ['brands.id', '=' , $filter['brand_id']];
      }
      $result = DB::table('users')
      ->leftJoin('brands_user', 'brands_user.user_id', '=', 'users.id')
      ->leftJoin('brands', 'brands.id', '=', 'brands_user.brand_id')
      ->select($selectArr)
      ->where($wheerArr);
      if(!empty($filter['group_by'])){
        $result->groupBy($filter['group_by']);
      }
      
      if(isset($filter['single'])){
        return $result->first();
      }

      return $result->get();;
    }

    public function ParentUserDetail(){
    return  $this->hasOne('App\Models\User','parent_client_id','id');
    }
    
    public static function getClientData(){
      $user_id = Auth::id();

      $roledata = getUsersRole($user_id);
      $role = $roledata->role_name;
      $data_query = User::where('users.id','=',$user_id)->select(
        'users.id',
        'users.client_id',
        'users.name',
        'users.last_name',
        'users.email',
        'users.email_verified',
        'users.am_email',
        'users.active_status',
        'users.avatar',
        'users.profile_avtar',
        'users.email_verified_at',
        'users.phone',
        'users.phone_verified',
        'users.Address',
        'users.Company',
        'users.Gst_number',
        'users.pen_number',
        'users.postal_code',
        'users.status',
        'users.dam_enable',
        'users.oms_enable');
      
      if($role == 'Client'){
        $data_query = $data_query->addSelect(
          'users.id as parent_client_id',
          'users.name as company_user_name',
          'users.Company as company_name',
          'users.phone as company_phone',
          'users.company_logo',
          'users.last_name as company_last_name',
          'users.email as company_email'
        );

      }else{
        $data_query = $data_query->
        leftJoin('users as parent_users' , 'parent_users.id','=','users.parent_client_id' )->
        addSelect(
          'parent_users.id as parent_client_id',
          'parent_users.name as company_user_name',
          'parent_users.Company as company_name',
          'parent_users.phone as company_phone',
          'parent_users.company_logo',
          'parent_users.last_name as company_last_name',
          'parent_users.email as company_email'
        );
      }
      $data = $data_query->first()->toArray();

      $data['role'] = $role;
      // dd($roledata , $data_query, $data);
      return $data;
    }

    public static function genratePassword($company, $name){
      $company = strtolower(str_replace(' ', '' , $company));
      $name = strtolower(str_replace(' ', '' , $name));
      $password = ucfirst(substr($company,0,4)."@".date('NWy').ucfirst(substr($name,0,2)).rand(999 , 9999));
      return $password;
    }
    
    
  }
