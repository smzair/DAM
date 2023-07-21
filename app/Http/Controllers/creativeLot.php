<?php

namespace App\Http\Controllers;

use App\Mail\NotifyUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\CreatLots;
use App\Models\NotificationModel\ClientNotification;
use App\Notifications\sendNewNotification;
use Google\Service\ServiceControl\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use stdClass;

class creativeLot extends Controller
{
    public function Index()
    {
        $users_data = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([ ['users.Company' ,'<>' ,NULL], ['roles.name','=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);
            // dd($users_data);

        $CreativeLots = (object) [
            'id'=>0,
            'user_id'=>'',
            'brand_id'=>'',
            'lot_number'=>'',
            'project_name'=>'',
            'verticle'=>'',
            'client_bucket'=>'',
            'work_initiate_date'=>'',
            'Comitted_initiate_date'=>'',
            'lot_delivery_days'=>'',
            'status'=>'',
            'button_name' => 'Create Lot',
            'route' => 'STORELOTS'
        ];
        return view('Lots.creative-Lot-create')->with('users_data', $users_data)->with('CreativeLots',$CreativeLots);
    }

    public function view()
    {
        // $num = 1;
       $lots =  CreatLots::OrderBy('creative_lots.id','DESC')
       ->leftJoin('users', 'users.id', 'creative_lots.user_id')
       ->leftJoin('brands', 'brands.id', 'creative_lots.brand_id')
       ->select('creative_lots.*','users.Company','users.client_id','brands.name')
       ->get();
        return view('Lots.Creative_lotView')->with('lots',$lots);
    }
    
    public function store(Request $request)
    {
        //create
        // dd($request);
        $CreativeLots = new CreatLots();
        $CreativeLots->user_id = $request->user_id;
        $CreativeLots->brand_id = $request->brand_id;
        $CreativeLots->lot_number = "";
        $CreativeLots->project_name = $request->project_name;
        $CreativeLots->verticle = $request->vertical_type;
        $CreativeLots->lot_delivery_days = $request->lot_delevery_days;
        $CreativeLots->client_bucket = $request->client_bucket;
        $CreativeLots->work_initiate_date =   date("Y/m/d", strtotime($request->int_date)) ;
        $CreativeLots->Comitted_initiate_date =  date("Y/m/d", strtotime($request->cmt_date));
        $CreativeLots->status = 'ready_for_inwarding';
        $CreativeLots->save();
        
        $id =  $CreativeLots->id;
        // $request->s_type
        $s_type =  $request->project_name;
        $project_name_array = explode(" ", $s_type);
        $count = count($project_name_array);
        $project_name = "";
        // foreach( $project_name_array  as $key=>$val){
        //     $project_name .= $val[0];
        // }

        $project_name .= $project_name_array[0][0];
        $project_name .= $project_name_array[$count-1][0];

        // dd($project_name);
        $lot_number = strtoupper('ODN' . date('dmY') ."-". $request->c_short . $request->short_name .  $project_name . $id);
        //update lot number

        CreatLots::where('id',$id)->update(['lot_number'=> strtoupper($lot_number)]);
        if($CreativeLots){
            request()->session()->flash('success','Lots Successfully added');
            $save_ClientNotification_data = array(
                'user_id' => $request->user_id,
                'brand_id' => $request->brand_id,
                'wrc_number' => $lot_number,
                'service' => 'Creative',
                'subject' => 'Creation',
                'service_number' => $lot_number,
                'Creation_for' => 'Lot'
            );
            $save_status = ClientNotification::save_ClientNotification($save_ClientNotification_data);
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        /* send notification start */
            $brand_data = DB::table('brands')->where('id', $request->brand_id)->first(['name']);
            $brand_name =  $brand_data != null ?  $brand_data->name : "";
            $creation_type = 'Lot';

            $data = new stdClass();
            $data->lot_number = strtoupper($lot_number);
            $data->brand_name = $brand_name;
            $this->send_notification($data, $creation_type);
        /******  send notification end*******/

        return $this->edit($request,$id);
        
    }

    public function edit(Request $request, $id){
        $users_data = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([ ['users.Company' ,'<>' ,NULL], ['roles.name','=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);

        $CreativeLots =  CreatLots::find($id);
        if($CreativeLots){
            $CreativeLots->button_name = 'Update Lot';
            $CreativeLots->route = 'UPDATELOT';
            // return redirect()->route('/Creative-editLots/'.$id)->with('users_data', $users_data)->with('CreativeLots',$CreativeLots);
            return view('Lots.creative-Lot-create')->with('users_data', $users_data)->with('CreativeLots',$CreativeLots);
        }
    }

    public function update(Request $request){
        //create
        $CreativeLots =  CreatLots::find($request->id);
        $CreativeLots->user_id = $request->user_id;
        $CreativeLots->brand_id = $request->brand_id;
        $CreativeLots->lot_number = "";
        $CreativeLots->project_name = $request->project_name;
        $CreativeLots->verticle = $request->vertical_type;
        $CreativeLots->lot_delivery_days = $request->lot_delevery_days;
        $CreativeLots->client_bucket = $request->client_bucket;
        $CreativeLots->work_initiate_date =   date("Y/m/d", strtotime($request->int_date)) ;
        $CreativeLots->Comitted_initiate_date =  date("Y/m/d", strtotime($request->cmt_date));
        $CreativeLots->status = 'ready_for_inwarding';
        $CreativeLots->update();
        
        $id =  $CreativeLots->id;
        // $request->s_type
        $s_type =  $request->project_name;
        $project_name_array = explode(" ", $s_type);
        $count = count($project_name_array);
        $project_name = "";
        // foreach( $project_name_array  as $key=>$val){
        //     $project_name .= $val[0];
        // }

        $project_name .= $project_name_array[0][0];
        $project_name .= $project_name_array[$count-1][0];

        // dd($project_name);
        $lot_number = 'ODN' . date('dmY') ."-". $request->c_short . $request->short_name .  $project_name . $id;
        //update lot number

        CreatLots::where('id',$id)->update(['lot_number'=>strtoupper($lot_number)]);


        if($CreativeLots){
            request()->session()->flash('success','Lots Successfully Updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }

        return $this->edit($request,$id);
    }

    // getBrand List 
    public function getBrand(Request $request){

        $brand_data = DB::table('brands_user')->where('user_id' , $request->user_id)
        ->leftJoin('brands', 'brands_user.brand_id' , 'brands.id')
        ->select('brands.name', 'brands_user.brand_id', 'brands.short_name')->get();

        echo $brand_data;
    }
   
}
