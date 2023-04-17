<?php

namespace App\Models\NotificationModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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

    public static function update_is_seen($notificationId){
        $id = base64_decode($notificationId);
        $update_status= 1;
        $update_query = ClientNotification::find($id);
        if($update_query->is_seen == 0){
            $update_query->is_seen = '1';
            $update_query->seen_at = date('Y-m-d H:i:s');
            $update_query->seen_by =  Auth::id();
            $update_status = $update_query->update();
        }
        return $update_status;
    }

    public static function save_ClientNotification($save_ClientNotification_data){
        // dd($save_ClientNotification_data);
        
        $subject = $save_ClientNotification_data['subject'];
        $service = $save_ClientNotification_data['service'];
        $user_id = $save_ClientNotification_data['user_id'];
        $brand_id = $save_ClientNotification_data['brand_id'];
        $wrc_number = $save_ClientNotification_data['wrc_number'];

        $user_data = Auth::user();
        $subject_is = "New Wrc Created!!";
        $discription = "New Wrc Created By ".$user_data->name.". Created WRC is ".$wrc_number;
        
        if($subject == 'Planning' || $subject == 'allocation'){
            $subject_is = "Wrc Planning Completed!!";
            if($service == 'Cataloging'){           
                $discription = $service." Wrc Planning Done By ".$user_data->name.". Allocated WRC is ".$wrc_number;    
            }
        }elseif($subject == 'Submission'){
            $subject_is = "Wrc Submission Done!!";
            if($service == 'Cataloging'){           
                $discription = $service." Wrc Submission Done By ".$user_data->name.". Submited WRC is ".$wrc_number;    
            }
        }elseif($subject == 'Creation'){
            $subject_is = "New Wrc Created!!";
            if($service == 'Editing'){           
                $discription = "New Wrc Created By ".$user_data->name.". Created Editing WRC is ".$wrc_number;
            }elseif($service == 'Editing'){
                $discription = "New Wrc Created By ".$user_data->name.". Created Editing WRC is ".$wrc_number;
            }
        }

        // dd($save_ClientNotification_data, "model");
        
        $save_ClientNotification = new ClientNotification();
        $save_ClientNotification->user_id = $user_id;
        $save_ClientNotification->brand_id = $brand_id;
        $save_ClientNotification->subject = $subject_is;
        $save_ClientNotification->discription = $discription;
        $save_ClientNotification->created_by = $user_data->id;
        $status = $save_ClientNotification->save();
        return $status;
        
    }

    


}
