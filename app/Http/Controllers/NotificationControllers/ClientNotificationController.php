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
        $data = ClientNotification::leftJoin('users', 'users.id', 'client_notifications.user_id')->
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

}
