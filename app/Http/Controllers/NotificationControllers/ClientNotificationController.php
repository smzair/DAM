<?php

namespace App\Http\Controllers\NotificationControllers;

use App\Http\Controllers\Controller;
use App\Models\NotificationModel\ClientNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientNotificationController extends Controller
{

    public function Index(){
        $data = ClientNotification::where('is_manual_notification','=','Yes')->
        leftJoin('users', 'users.id', 'client_notifications.user_id')->
        leftjoin('brands', 'brands.id' , 'client_notifications.brand_id' )->
        select('users.name as user_name','users.Company as company', 'brands.name as brand_name' , 'client_notifications.*')->
        get()->toArray();
        return view('admin.Client-Notification.Client-Notification-List')->with('data',$data);
    }


    public function create(){
        $data = (object) [
            'id' => '0',
            'user_id' => '0',
            'brand_id' => '0',
            'subject' => '',
            'discription' => '',
        ];
        return view('admin.Client-Notification.Client-Notification-Create')->with('data',$data);
    }

    public function save(Request $request){
        $id = $request->id;
        $user_id = $request->user_id;
        $brand_id = $request->brand_id;
        $subject = $request->subject;
        $discription = $request->discription;

        DB::beginTransaction();
        try {
            $save_ClientNotification = new ClientNotification();
            $save_ClientNotification->user_id = $user_id;
            $save_ClientNotification->brand_id = $brand_id;
            $save_ClientNotification->subject = $subject;
            $save_ClientNotification->discription = $discription;
            $save_ClientNotification->is_manual_notification = 'Yes';
            $save_ClientNotification->created_by = Auth::id();;
            $status = $save_ClientNotification->save();
            if($status){
                DB::commit();
                request()->session()->flash('success', 'Client Notification Created!!!');
            }else{
                request()->session()->flash('error', 'Please try again!!');
                DB::rollback();
            }
        }catch (\Exception $e) {
            DB::rollback();
            // throw $e;
            request()->session()->flash('error', 'Somthing went wrong!! Please try again!!');
        }
        return redirect()->route('CreateClientNotification');
    }

    public function edit($id){

        $data = ClientNotification::where('id',base64_decode($id))->get()->first();
        // dd($id,$data);
        return view('admin.Client-Notification.Client-Notification-Create')->with('data',$data);

    }

    public function update(Request $request){

        $id = $request->id;
        $user_id = $request->user_id;
        $brand_id = $request->brand_id;
        $subject = $request->subject;
        $discription = $request->discription;
        DB::beginTransaction();
        try {
            $update_ClientNotification = ClientNotification::find($id);
            $update_ClientNotification->user_id = $user_id;
            $update_ClientNotification->brand_id = $brand_id;
            $update_ClientNotification->subject = $subject;
            $update_ClientNotification->discription = $discription;
            $status = $update_ClientNotification->update();
            if($status){
                DB::commit();
                request()->session()->flash('success', 'Client Notification Updated!!!');
            }else{
                request()->session()->flash('error', 'Please try again!!');
                DB::rollback();
            }
        }catch (\Exception $e) {
            DB::rollback();
            // throw $e;
            request()->session()->flash('error', 'Somthing went wrong!! Please try again!!');
        }
        return redirect()-> route('editClientNotification', [base64_encode($id)]);
    }

    // allnotification  List in clients panel
    public function allnotification(){
        $user_data = Auth::user();         
        $ClientNotification = ClientNotification::clientNotificationList($user_data , 'all');
        return view('clients.Notification.allnotification')->with('ClientNotification', $ClientNotification);
    }

    // Client Notifications New
    public function Notifications(){
        $user_data = Auth::user();         
        $ClientNotification = ClientNotification::clientNotificationList($user_data , 'all');
        return view('clients.Notification.ClientNotification')->with('ClientNotification', $ClientNotification);
    }

    // set notifiction to seen Based on id

    public function set_notifiction_to_seen(Request $request){

        $ids = $request->ids;
        $status = false;
        try {
            DB::beginTransaction();
            $response = ClientNotification::whereIn('id', $ids)->where('is_seen', '0')->update(['is_seen' => '1' ,'seen_by' => Auth::id() , 'seen_at' => date('Y-m-d H:i:s')]);
            $status = true;
            if($response > 0){
                DB::commit();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = $th;
            //throw $th;
        }
        echo json_encode(array(
            'status' => $status,
            'response' => $response
        ));
       
    }

    public function ClientNotificatioDetail($notificationId){
        $id = base64_decode($notificationId);
        $ClientNotificatioDetail = [];
        $update_query = ClientNotification::find($id);
        if($update_query){
            if($update_query->is_seen == 0){
                $update_query->is_seen = '1';
                $update_query->seen_at = date('Y-m-d H:i:s');
                $update_query->seen_by =  Auth::id();
                $update_query->update();
            }
            $ClientNotificatioDetail = $update_query->getAttributes();
            // dd($ClientNotificatioDetail);
        }
        return view('clients.Notification.Notification-Detail')->with('ClientNotificatioDetail', $ClientNotificatioDetail);
    }

    public function setNotificationSeen(Request $request){
        $id = $request->notificationId;
        $update_status = ClientNotification::update_is_seen($id);
        echo $update_status;
    }

    // Remove client notification from DAM

    public function remove_notifiction(Request $request){

        $id = $request->notificationId;
        $status = false;
        try {
            DB::beginTransaction();
            $response = ClientNotification::where('id', $id)->delete();
            if($response > 0){
                $status = true;
                DB::commit();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = $th;
            //throw $th;
        }
        echo json_encode(array(
            'status' => $status,
            'response' => $response
        ));
       
    }
    


    

}
