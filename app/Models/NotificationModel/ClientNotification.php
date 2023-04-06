<?php

namespace App\Models\NotificationModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClientNotification extends Model
{
    use HasFactory;
    protected $table = 'client_notifications';
    protected $fillable = [ 'user_id', 'brand_id' , 'subject', 'discription'];

// all unseen client's notification list 
    public static function clientNotificationList($user_data, $is_seen = 0){
        $user_id_is = $user_data->id;
        $user_roles = getUsersRole($user_id_is);
        $brand_arr = DB::table('brands_user')->where('user_id', $user_id_is)->get()->pluck('brand_id')->toArray();
        if($user_roles->role_name == 'Client'){
            $parent_client_id = $user_id_is;
        }else{
            $parent_client_id = $user_data->parent_client_id;
        }
        $clientNotificationQuery = ClientNotification::where('client_notifications.user_id', $parent_client_id)->whereIn('client_notifications.brand_id', $brand_arr);
        if($is_seen != 'all'){
            $clientNotificationQuery = $clientNotificationQuery->where('client_notifications.is_seen', '=' ,"$is_seen");
        }
        $clientNotificationList =$clientNotificationQuery->
        orderByDesc('client_notifications.created_at')->
        get()->toArray();
        return $clientNotificationList;
    }
    

}
