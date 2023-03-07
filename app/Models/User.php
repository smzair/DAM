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
    
  }
