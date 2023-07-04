<?php

namespace App\Http\Controllers;

use App\Models\CreativeWrcModel;
use App\Models\CreatLots;
use App\Models\CreativeWrcSkus;
use App\Models\CreativeWrcBatch;
use App\Models\NotificationModel\ClientNotification;
use Carbon\Carbon;
use CreativeLots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class creativeWrc extends Controller
{
   public function Index()
   {

    $users_data = DB::table('users')
    ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
    ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
    ->where([ ['users.Company' ,'<>' ,NULL], ['roles.name','=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);
    // dd($users_data);

    $CreativeWrc = (object) [
        'id'=>0,
        'user_id'=>'',
        'brand_id'=>'',
        'wrc_number'=>'',
        'lot_id'=>'',
        'commercial_id'=>'',
        'order_qty'=>'',
        'work_brief'=>'',
        'guidelines'=>'',
        'document1'=>'',
        'document2'=>'',
        'sku_required'=>0,
        'alloacte_to_copy_writer'=>1,
        'button_name' => 'Create New WRC',
         'route' => 'STOREWRC'
    ];

    return view('Wrc.Creative-wrc-create')->with('users_data', $users_data)->with('CreativeWrc',$CreativeWrc);
   }

   // getBrand List 
   public function getBrand(Request $request)
   {
        $brand_data = DB::table('brands_user')->where('user_id' , $request->user_id)
        ->leftJoin('brands', 'brands_user.brand_id' , 'brands.id')
        ->select('brands.name', 'brands_user.brand_id', 'brands.short_name')->get();

        echo $brand_data;
    }

    // LOT Number List 
    public function getLotNumber(Request $request){

        $user_id = $request->user_id;
        $brand_id = $request->brand_id;
        $data = [];

        // get lot number dropdown value
        $lot_number_data = DB::table('creative_lots')->where('creative_lots.user_id' , $user_id)->where('creative_lots.brand_id' , $brand_id)
        ->leftJoin('brands', 'creative_lots.brand_id' , 'brands.id')
        ->select('creative_lots.id','creative_lots.project_name','creative_lots.client_bucket', 'creative_lots.lot_number', 'creative_lots.user_id', 'creative_lots.brand_id', 'brands.short_name')->get();

        // get commercial dropdown value
        $commercial_data = DB::table('create_commercial')->where('user_id',$user_id)->where('brand_id',$brand_id)->select('id as create_commercial_id', 'kind_of_work', 'project_name', 'per_qty_value')->get();
        $data = [ "lot_number_data" => $lot_number_data, "commercial_data" => $commercial_data];

        echo json_encode($data);
    }
    // for store data
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // dd($request);
            $lot_id  = $request->lot_id;
            $lot_data = DB::table('creative_lots')->where('id',$lot_id)->first(['user_id','brand_id']);
            $lot_user_id =  $lot_data != null ?  $lot_data->user_id : 0;
            $lot_brand_id =  $lot_data != null ?  $lot_data->brand_id : 0;

            $commercial_data = DB::table('create_commercial')->where(['user_id'=> $lot_user_id,'brand_id'=> $lot_brand_id])->first(['kind_of_work']);
            $kind_of_work = $commercial_data != null ?  $commercial_data->kind_of_work : '';
            $kind_of_work_ini = $kind_of_work != '' ? $kind_of_work[0] : '';
         

            // $wrcNumber = $lotInfo->c_short . $lotInfo->short_name . $lotInfo->s_type . $lotInfo->id . '-' . chr($wrcCount + 65);
            $project_name_array = explode(" ",$request->s_type);
            $count = count($project_name_array);
            $project_name = "";
            $wrcs = CreativeWrcModel::where(['lot_id' => $request->lot_id])->get();
            $wrcCount = $wrcs->count();
            //get first char of each word
            // foreach( $project_name_array  as $key=>$val){
            //     $project_name .= $val[0];
            // }
            //get first char of first and last word
            // dd($project_name_array);
            if(count($project_name_array) > 0){
                $project_name .= $project_name_array[0] != "" ? $project_name_array[0][0] : "";
                $project_name .= $project_name_array[$count-1] != "" ? $project_name_array[$count-1][0] : "";
            }
            

            $alloacte_to_copy_writer = ((isset($request->alloacte_to_copy_writer) && $request->alloacte_to_copy_writer == 1)) ? 1 : 0;

            // $wrcNumber = $request->c_short . $request->short_name . $project_name . $request->lot_id . '-' . chr($wrcCount + 65);
            // project name change to ct 
            $wrcNumber = $request->c_short . $request->short_name . 'CT' . $kind_of_work_ini . $request->lot_id . '-' . chr($wrcCount + 65);
            
            $sku_required_num = 0;
            $sku_required = $request->sku_required;
            if($sku_required == 'sku_yes'){
                $sku_required_num = 1;
            }

            $createWrc = new CreativeWrcModel();
            $createWrc->lot_id = $request->lot_id;
            $createWrc->wrc_number = strtoupper($wrcNumber);
            $createWrc->commercial_id = $request->commercial_id;
            $createWrc->order_qty = $request->order_qty;
            $createWrc->work_brief = $request->work_brief;
            $createWrc->guidelines = $request->guide_lines;
            $createWrc->document1 = $request->document1;
            $createWrc->document2 = $request->document2;
            $createWrc->sku_required = $sku_required_num;
            $createWrc->alloacte_to_copy_writer = $alloacte_to_copy_writer;
            $createWrc->status = 'inwarding_done';
            $createWrc->save();

            //insert excel data 

            if($sku_required == 'sku_yes'){
                $file = ($request->sku_sheet->getRealPath());

                $handle = fopen($_FILES['sku_sheet']['tmp_name'], "r");
                $header = true;
                $count = 1;
                while ($csvLine = fgetcsv($handle, 1000, ",")) {
                    // Add a condition to stop header insertion
                    if ($count <= 1) {
                        $count++;
                        continue;
                    }

                    $sku_code = $csvLine[1];
                    $project_name = $csvLine[2];
                    $kind_of_work = $csvLine[3];
                    $wrc_id = $createWrc->id;

                    $creative_wrc_batch = CreativeWrcBatch::orderby('id','DESC')->where('wrc_id',$wrc_id)->get('batch_no')->first();
                    $creative_wrc_batch_no = $creative_wrc_batch != null ? $creative_wrc_batch->batch_no : 0;

                    $new_creative_wrc_batch_no = $creative_wrc_batch_no + 1;


                    if($sku_code != null && $project_name != null && $kind_of_work != null){
                        $skuObj = new CreativeWrcSkus();
                        $skuObj->sku_code = $sku_code;
                        $skuObj->project_name = $project_name;
                        $skuObj->kind_of_work = $kind_of_work;
                        $skuObj->creative_wrc_batch_no = $new_creative_wrc_batch_no;
                        $skuObj->wrc_id = $wrc_id ;

                        $skuObj->save();
                    }
                    
                }
            }
            $wrc_data = CreativeWrcModel::where('id',$createWrc->id)->get(['sku_count'])->first();
            $old_sku_count = $wrc_data != null ?  $wrc_data->sku_count : 0;
            $skus = CreativeWrcSkus::where('wrc_id',$createWrc->id)->get()->count();

            $new_sku_count = $skus +  $old_sku_count ;
            CreativeWrcModel::where('id',$createWrc->id)->update(['sku_count'=> $new_sku_count]);

            $lot_id = $request->lot_id;
            $creativeLot = DB::table('creative_lots')->where('id',$lot_id)->get(['client_bucket'])->first();
            $client_bucket = $creativeLot  != null ? $creativeLot->client_bucket : null;


            // create batch no of wrc when client bucked is Retainer

            if($client_bucket == 'Retainer'){
                $creativeWrcBatch = new CreativeWrcBatch();
                $creativeWrcBatch->wrc_id = $createWrc->id;
                $creativeWrcBatch->batch_no = 1;
                $creativeWrcBatch->order_qty = $request->order_qty;
                $creativeWrcBatch->sku_count = $new_sku_count;
                $creativeWrcBatch->save();
            }else{
                $creativeWrcBatch = new CreativeWrcBatch();
                $creativeWrcBatch->wrc_id = $createWrc->id;
                $creativeWrcBatch->batch_no = 0; // batch 0 not retainer case
                $creativeWrcBatch->order_qty = $request->order_qty;
                $creativeWrcBatch->sku_count = $new_sku_count;
                $creativeWrcBatch->save();
            }

            
            if($createWrc){
                request()->session()->flash('success','Wrc Successfully added');
                $save_ClientNotification_data = array(
                    'user_id' => $request->user_id,
                    'brand_id' => $request->brand_id,
                    'wrc_number' => $createWrc->wrc_number,
                    'service' => 'Creative',
                    'subject' => 'Creation',
                );
                $save_status = ClientNotification::save_ClientNotification($save_ClientNotification_data);
                DB::commit();
                
                /* send notification start */
                $creation_type = 'Wrc';
                $data = CreativeWrcModel::find($createWrc->id);
                $this->send_notification($data, $creation_type);
                /******  send notification end*******/    
            }
            else{
                request()->session()->flash('error','Please try again!!');
            }

            return $this->view();
            // return $this->edit($request,$createWrc->id);// update in same page
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
            // something went wrong
        }
        

    }

    // for store data
    public function storeNewBatch(Request $request)
    {
        // dd($request);
        DB::beginTransaction();

        try {

            $wrc_id = $request->wrc_id;
            $sku_required_num = $request->sku_required; // if 0 then no and if 1 then yes
            $sku_order_count = $request->sku_order_count; // order qty

            //insert excel data 

            if($sku_required_num == 1){
                $file = ($request->sku_sheet->getRealPath());

                $handle = fopen($_FILES['sku_sheet']['tmp_name'], "r");
                $header = true;
                $count = 1;
                while ($csvLine = fgetcsv($handle, 1000, ",")) {
                    // Add a condition to stop header insertion
                    if ($count <= 1) {
                        $count++;
                        continue;
                    }

                    $sku_code = $csvLine[1];
                    $project_name = $csvLine[2];
                    $kind_of_work = $csvLine[3];
                   

                    $creative_wrc_batch = CreativeWrcBatch::orderby('id','DESC')->where('wrc_id',$wrc_id)->get('batch_no')->first();
                    $creative_wrc_batch_no = $creative_wrc_batch != null ? $creative_wrc_batch->batch_no : 0;

                    $new_creative_wrc_batch_no = $creative_wrc_batch_no + 1;


                    if($sku_code != null && $project_name != null && $kind_of_work != null){
                        $skuObj = new CreativeWrcSkus();
                        $skuObj->sku_code = $sku_code;
                        $skuObj->project_name = $project_name;
                        $skuObj->kind_of_work = $kind_of_work;
                        $skuObj->creative_wrc_batch_no = $new_creative_wrc_batch_no;
                        $skuObj->wrc_id = $wrc_id ;

                        $skuObj->save();
                    }
                    
                }
            }

            $wrc_data = CreativeWrcModel::where('id',$wrc_id)->get(['sku_count','order_qty'])->first();

            $old_order_qty = $wrc_data != null ?  $wrc_data->order_qty : 0;
            $new_order_qty = $old_order_qty + $sku_order_count;

            // $old_sku_count = $wrc_data != null ?  $wrc_data->sku_count : 0;
            $skus = CreativeWrcSkus::where('wrc_id',$wrc_id)->get()->count();
            $new_sku_count = $skus;
            CreativeWrcModel::where('id',$wrc_id)->update(['sku_count'=> $new_sku_count,'order_qty'=> $new_order_qty]);

            // create batch no of wrc when client bucked is Retainer

            $creativeWrcBatch = CreativeWrcBatch::where('wrc_id',$wrc_id)->orderBy('id','DESC')->get(['batch_no'])->first();

            $old_batch_no = $creativeWrcBatch != null ? $creativeWrcBatch->batch_no : 0;
            $new_batch_no =  $old_batch_no + 1;

            CreativeWrcModel::where('id',$wrc_id)->update(['sku_count'=> $new_sku_count,'order_qty'=> $new_order_qty]);

            $creativeWrcBatch = new CreativeWrcBatch();
            $creativeWrcBatch->wrc_id = $wrc_id;
            $creativeWrcBatch->batch_no = $new_batch_no;
            $creativeWrcBatch->order_qty = $sku_order_count;
            $creativeWrcBatch->sku_count = $new_sku_count;
            $creativeWrcBatch->save();

            DB::commit();
            
            if($wrc_id){
                request()->session()->flash('success','Wrc Batch Successfully added');
            }
            else{
                request()->session()->flash('error','Please try again!!');
            }

            //    return $this->Index();
            return $this->viewBatchPanel();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
        

    }

    public function view()
    {
       $wrcs =  CreativeWrcModel::OrderBy('creative_wrc.id','ASC')
       ->leftJoin('creative_lots', 'creative_lots.id', 'creative_wrc.lot_id')
       ->leftJoin('users', 'users.id', 'creative_lots.user_id')
       ->leftJoin('brands', 'brands.id', 'creative_lots.brand_id')
       ->leftJoin('creative_wrc_batch', 'creative_wrc_batch.wrc_id', 'creative_wrc.id')
       ->orderBy('creative_wrc_batch.id', 'DESC')
       ->groupBy('creative_wrc_batch.wrc_id')
       ->groupBy('creative_wrc_batch.batch_no')
       ->leftJoin('create_commercial as create_commercial',function($join)
       {
           $join->on('create_commercial.user_id','=','creative_lots.user_id');
           $join->on('create_commercial.brand_id','=','creative_lots.brand_id');
       })
       ->select('creative_wrc.*','creative_lots.user_id','creative_lots.brand_id','creative_lots.lot_number','users.Company as Company_name','brands.name','create_commercial.kind_of_work',DB::raw('MAX(creative_wrc_batch.batch_no) as batch_no'))
       ->get();
        // dd($wrcs);
        return view('Wrc.Creative-wrc-view')->with('wrcs',$wrcs);
    }

    // get data for view in batch panel
    public function viewBatchPanel()
    {
        $wrcs = CreatLots::where('creative_lots.client_bucket','=','Retainer')
        ->leftJoin('creative_wrc', 'creative_wrc.lot_id', 'creative_lots.id')
        ->leftJoin('users', 'users.id', 'creative_lots.user_id')
        ->leftJoin('brands', 'brands.id', 'creative_lots.brand_id')
        ->leftJoin('creative_wrc_batch', 'creative_wrc_batch.wrc_id', 'creative_wrc.id')
        ->orderBy('creative_wrc_batch.id', 'DESC')
        ->groupBy('creative_wrc_batch.wrc_id')
        ->groupBy('creative_wrc_batch.batch_no')
        ->leftJoin('create_commercial as create_commercial',function($join)
			{
				$join->on('create_commercial.user_id','=','creative_lots.user_id');
				$join->on('create_commercial.brand_id','=','creative_lots.brand_id');
			})
       ->select('creative_wrc.*','creative_lots.user_id','creative_lots.project_name','creative_lots.brand_id','creative_lots.lot_number','users.Company as Company_name','brands.name','create_commercial.kind_of_work',DB::raw('MAX(creative_wrc_batch.batch_no) as batch_no'))
        ->get();
        //    dd($wrcs);
        return view('Wrc.Creative-wrc-batch-view')->with('wrcs',$wrcs);
    }

    public function edit(Request $request, $id){
        $users_data = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([ ['users.Company' ,'<>' ,NULL], ['roles.name','=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);

        $CreativeWrcs =  CreativeWrcModel::find($id);
        $lot_id = $CreativeWrcs->lot_id;

        $lot = CreatLots::where('id',$lot_id)->first(['user_id','brand_id']);

        $user_id = $lot['user_id'];
        $brand_id = $lot['brand_id'];

        

        if($CreativeWrcs){
            $CreativeWrcs->button_name = 'Update WRC';
            $CreativeWrcs->route = 'UPDATEWRC';
            $CreativeWrcs->user_id = $user_id;
            $CreativeWrcs->brand_id = $brand_id;
            
            return view('Wrc.Creative-wrc-create')->with('users_data', $users_data)->with('CreativeWrc',$CreativeWrcs);
           
        }
    }

    public function update(Request $request){
        // dd($request);
        $id =  $request->id;

        $project_name_array = explode(" ",$request->s_type);
        $count = count($project_name_array);
        $project_name = "";
        $wrcs = CreativeWrcModel::where(['lot_id' => $request->lot_id])->get();
        $wrcCount = $wrcs->count();
        //get first char of each word
        // foreach( $project_name_array  as $key=>$val){
        //     $project_name .= $val[0];
        // }
        //get first char of first and last word
        $project_name .= $project_name_array[0][0];
        $project_name .= $project_name_array[$count-1][0];

        $wrcNumber = $request->c_short . $request->short_name . $project_name . $request->lot_id . '-' . chr($wrcCount + 65);
        $alloacte_to_copy_writer = ((isset($request->alloacte_to_copy_writer) && $request->alloacte_to_copy_writer == 1)) ? 1 : 0;
            // dd($alloacte_to_copy_writer);


        $sku_required = $request->sku_required;
        if($sku_required == 'sku_yes'){
            $sku_required_num = 1;
        }else{
            $sku_required_num = 0;
        }
        //create
        $CreativeWrcs =  CreativeWrcModel::find($id);
        $CreativeWrcs->lot_id = $request->lot_id;
        // $CreativeWrcs->wrc_number = $wrcNumber;
        $CreativeWrcs->commercial_id = $request->commercial_id;
        $CreativeWrcs->order_qty = $request->order_qty;
        $CreativeWrcs->work_brief = $request->work_brief;
        $CreativeWrcs->guidelines = $request->guide_lines;
        $CreativeWrcs->document1 = $request->document1;
        $CreativeWrcs->document2 = $request->document2;
        $CreativeWrcs->sku_required = $sku_required_num;
        $CreativeWrcs->alloacte_to_copy_writer = $alloacte_to_copy_writer;
        $CreativeWrcs->status = 'inwarding_done';
        $CreativeWrcs->update();
        
        if($CreativeWrcs){
            request()->session()->flash('success','Wrc Successfully Updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }

        return $this->edit($request,$id);
    }

    // get wrc status detail list 
    public function wrcStatusView()
    {
        $wrcs = CreativeWrcModel::getWrcStatusDetailList();
        return view('WrcStatus.Creative-wrc-status-view')->with('wrcs',$wrcs);
    }
}