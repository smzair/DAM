<?php

namespace App\Http\Controllers;

use App\Models\CatalogMarketplaceCredentials;
use App\Models\CatalogWrcBatch;
use App\Models\CatalogWrcSku;
use App\Models\CatlogWrc;
use App\Models\Marketplace;
use App\Models\NotificationModel\ClientNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CatalogWrcController extends Controller
{
    // get data for create
    public function Index()
    {
        $users_data = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([['users.Company', '<>', NULL], ['roles.name', '=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);
        // dd($users_data);

        $CatlogWrc = (object) [
            'id' => 0,
            'user_id' => '',
            'brand_id' => '',
            'lot_id' => '',
            'commercial_id' => '',
            'img_recevied_date' => '',
            'missing_info_notify_date' => '',
            'missing_info_recived_date' => '',
            'confirmation_date' => '',
            'sku_qty' => '',
            'work_brief' => '',
            'modeOfDelivary' => '0', 
            'generic_data_format_link' => '',
            'img_as_per_guidelines' => '',
            'guidelines' => '',
            'document1' => '',
            'document2' => '',
            'wrc_number' => '',
            'alloacte_to_copy_writer' => 1,
            'button_name' => 'Create New Catlog WRC',
            'route' => 'STORECATLOGWRC'
        ];
        $sku_details = array(
            'unique_Count' => 0,
            'variant_Count' => 0,
            'total_Count' => 0,
        );
        return view('Wrc.Catalog-wrc-create')->with('users_data', $users_data)->with('CatlogWrc', $CatlogWrc)->with('sku_details', $sku_details);
    }

    // marketplace_Credentials_List for save and store in wrc panel
    public function marketplace_Credentials_List(Request $request){
        $commercial_id = $request->commercial_id;
        $market_place_ids = $request->market_place_ids;
        // $response = Marketplace::marketplace_Credentials_List($commercial_id, $market_place_ids);
        $response = Marketplace::catalog_marketplace_Credentials_List($commercial_id , $market_place_ids);
        echo json_encode($response);
    }


    public function MarketPlace()
    {
        return view('Wrc.Catalog-marketplace-list');
    }

    // function for marketplace Credentials details in Marketplace Credentials panel 
    public function marketplace_Credentials_details(Request $request){
        $user_id = $request->user_id;
        $brand_id = $request->brand_id;

        $response = CatalogMarketplaceCredentials::get_c_data($user_id, $brand_id);
        echo $response;
    }

    // testing function marketplace_Credentials_List
    // public function catalog_marketplace_Credentials_List(Request $request){
    //     $market_place_ids = '2,4,6';
    //     $commercial_id = '2';
    //     $response = Marketplace::catalog_marketplace_Credentials_List($commercial_id , $market_place_ids);
    //     dd($response);
    // }


    public function save_wrc_Credentials(Request $request){
        $data_arr = $request->data_arr;
        $market_place_id_is = $request->market_place_id_is;
        $commercial_id_is = $request->commercial_id_is;
        $response = Marketplace::save_wrc_Credentials($data_arr, $commercial_id_is , $market_place_id_is);
        echo $response;
    }

    // getBrand List  
    public function getBrand(Request $request){
        $brand_data = DB::table('brands_user')->where('user_id' , $request->user_id)
        ->leftJoin('brands', 'brands_user.brand_id' , 'brands.id')
        ->select('brands.name', 'brands_user.brand_id', 'brands.short_name')->get();
        echo $brand_data;
    }

    public function getLotNumber(Request $request){
        $user_id = $request->user_id;
        $brand_id = $request->brand_id;
        $data = [];

        $lot_number_data = DB::table('lots_catalog')->
        where('lots_catalog.user_id' , $user_id)->
        where('lots_catalog.brand_id' , $brand_id)
        ->leftJoin('brands', 'lots_catalog.brand_id' , 'brands.id')->
        select('lots_catalog.id', 'lots_catalog.lot_number', 'lots_catalog.user_id', 'lots_catalog.brand_id', 'brands.short_name')->
        get();

        $commercial_data = DB::table('create_commercial_catalog')->where('user_id',$user_id)->where('brand_id',$brand_id)->select('id as create_commercial_catalog_id', 'market_place', 'type_of_service', 'market_place  as market_place_ids')->get();
        
        $marketPlace_list = getMarketPlace();
        $marketPlace_data = array_column($marketPlace_list, 'marketPlace_name', 'id');
        foreach($commercial_data as $key => $data){
            $market_place_str = $data->market_place;
            $market_place_arr = explode(',', $market_place_str);
            $market_place_new_str = "";
            foreach($market_place_arr as $key => $val){
                $market_place_new_str .= $marketPlace_data[$val].',';
            }
            $market_place_new_str = rtrim($market_place_new_str, ",");
            $data->market_place = $market_place_new_str;
            // echo "<br>". $market_place_str ." ". $market_place_new_str;
        }

        $data = [ "lot_number_data" => $lot_number_data, "commercial_data" => $commercial_data];
        echo json_encode($data);
    }

    // for store data
    public function store(Request $request)
    {

        // $wrcNumber = $lotInfo->c_short . $lotInfo->short_name . $lotInfo->s_type . $lotInfo->id . '-' . chr($wrcCount + 65);
        DB::beginTransaction();

        try {
       
            $project_name_array = explode(" ", $request->s_type);
            $count = count($project_name_array);
            $project_name = "";
            $wrcs = CatlogWrc::where(['lot_id' => $request->lot_id])->get();
            $wrcCount = $wrcs->count();
            $project_name .= $project_name_array[0][0];
            $project_name .= $project_name_array[$count - 1][0];

            $wrcNumber = $request->c_short . $request->short_name . $project_name . $request->lot_id . '-' . chr($wrcCount + 65);
            $alloacte_to_copy_writer = ((isset($request->alloacte_to_copy_writer) && $request->alloacte_to_copy_writer == 1)) ? 1 : 0;

            $modeOfDelivary = $request->modeOfDelivary;

            $lot_id = $request->lot_id;
            $catalog_requestType = DB::table('lots_catalog')->where('id', $lot_id)->get(['requestType'])->first();
            $requestType = $catalog_requestType  != null ? $catalog_requestType->requestType : null;

            $batch_no = 0;
            $is_retainer = 0;
            if ($requestType == 'Retainer') {
                $batch_no = 1;
                $is_retainer = 1;
            }


            $createWrc = new CatlogWrc();

            $createWrc->lot_id = $request->lot_id;
            $createWrc->wrc_number = $wrcNumber;
            $createWrc->modeOfDelivary = $modeOfDelivary;
            $createWrc->commercial_id = $request->commercial_id;
            
            $createWrc->img_recevied_date = $request->img_recevied_date == null ? '' : $request->img_recevied_date;
            $createWrc->missing_info_notify_date = $request->missing_info_notify_date == null ? '' : $request->missing_info_notify_date;
            $createWrc->missing_info_recived_date = $request->missing_info_recived_date == null ? '' : $request->missing_info_recived_date;
            $createWrc->confirmation_date = $request->confirmation_date == null ? '' : $request->confirmation_date;
            $createWrc->work_brief = $request->work_brief == null ? '' : $request->work_brief;
            $createWrc->guidelines = $request->guide_lines == null ? '' : $request->guide_lines;
            $createWrc->document1 = $request->document1 == null ? '' : $request->document1;
            $createWrc->document2 = $request->document2 == null ? '' : $request->document2;
            $createWrc->generic_data_format_link = $request->generic_data_format_link == null ? '' : $request->generic_data_format_link;
            $createWrc->img_as_per_guidelines = $request->img_as_per_guidelines == null ? '' : $request->img_as_per_guidelines;

            $sku_qty_is = $request->sku_qty == null ? '0' : $request->sku_qty;
            $createWrc->alloacte_to_copy_writer = $alloacte_to_copy_writer;
            $createWrc->sku_qty = $sku_qty_is;
            $createWrc->is_retainer = $is_retainer;
            $createWrc->status = 'Ready_for_allocation';
            $createWrcStatus = $createWrc->save();

            $wrc_id_is = $createWrc->id;

            // code for save file
            $handle = fopen($_FILES['sku_sheet']['tmp_name'], "r");
            $count = 1;
            $saved_rows = 0;

            $sku_details = array(
                'unique_Count' => 0,
                'variant_Count' => 0,
                'total_Count' => 0,
            );
            $csv_batch_arr = [];

            while ($csvLine = fgetcsv($handle, 1000, ",")) {
                if ($count <= 1) {
                    $count++;
                    continue;
                }
                $count++;
               
                $sku_code = trim($csvLine[0]);
                $style = trim($csvLine[1]);
                $batch = trim($csvLine[2]);
                $type_of_service = trim($csvLine[3]);

                if ($sku_code != null && $style != null && $type_of_service != null && $sku_code != '' && $style != '' && $type_of_service != '') {
                    $skuObj = new CatalogWrcSku();
                    $skuObj->sku_code = $sku_code;
                    $skuObj->style = $style;
                    $skuObj->type_of_service = $type_of_service;
                    $skuObj->batch_no = $batch_no;
                    $skuObj->batch = $batch;
                    $skuObj->wrc_id = $wrc_id_is;
                    $skuObj->save();
                    $saved_rows++;
                    $sku_details['total_Count']++;
                    if($style == 'parent'){
                        $sku_details['unique_Count']++;
                    }else{
                        $sku_details['variant_Count']++;
                    }
                }
                if (array_key_exists($batch, $csv_batch_arr)) {
                    $csv_batch_arr[$batch] += 1;
                } else {
                    $csv_batch_arr[$batch] = 1;
                }
            }
            $cnt_batch = 1;
            $batch_no_is = $batch_no;
            if ($is_retainer == 1) {
                foreach($csv_batch_arr as $batch_is => $csvKeyCount){
                    if($cnt_batch != 1){
                        $batch_no_is = $cnt_batch;
                        CatalogWrcSku::where('wrc_id', $wrc_id_is)->where('batch', $batch_is)->update(['batch_no' => $batch_no_is]);
                    }
                    $storeWrcBatch = new CatalogWrcBatch();
                    $storeWrcBatch->wrc_id = $wrc_id_is;
                    $storeWrcBatch->batch_no = $batch_no_is;
                    $storeWrcBatch->sku_count = $csvKeyCount;
                    $storeWrcBatch->prequisites = '';
                    $storeWrcBatch->work_initiate_date = '';
                    $storeWrcBatch->work_committed_date = '';
                    $storeWrcBatch->invoiceNumber = '';
                    $storeWrcBatchStatus = $storeWrcBatch->save();
                    if($storeWrcBatchStatus){
                        $cnt_batch++;
                    }
                }
            } else {
                $storeWrcBatch = new CatalogWrcBatch();
                $storeWrcBatch->wrc_id = $wrc_id_is;
                $storeWrcBatch->batch_no = $batch_no_is;
                $storeWrcBatch->sku_count = $saved_rows;
                $storeWrcBatch->prequisites = '';
                $storeWrcBatch->work_initiate_date = '';
                $storeWrcBatch->work_committed_date = '';
                $storeWrcBatch->invoiceNumber = '';
                $storeWrcBatch->save();
            }


            $tot_sku_qty_is = $saved_rows + $sku_qty_is;
            CatlogWrc::where('id', $wrc_id_is)->update(['sku_qty' => $tot_sku_qty_is]);
            if ($createWrcStatus) {
                $user_data = Auth::user();
                $save_ClientNotification = new ClientNotification();
                $save_ClientNotification->user_id = $request->user_id;
                $save_ClientNotification->brand_id = $request->brand_id;
                $save_ClientNotification->subject = "New Wrc Created!!";
                $save_ClientNotification->discription = "New Wrc Created By ".$user_data->name.". Created WRC is ".$wrcNumber;
                $save_ClientNotification->created_by = $user_data->id;
                $status = $save_ClientNotification->save();  
                
                /* send notification start */
                $data = CatlogWrc::find($createWrc->id);
                $creation_type = 'CatlogWrc';
                $this->send_notification($data, $creation_type);
                /******  send notification end*******/
                DB::commit();
                request()->session()->flash('success', 'Catlog Wrc Successfully added');
            } else {
                request()->session()->flash('error', 'Please try again!!');
            }

        //    return $this->view($request, $createWrc->id);

            $users_data = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([['users.Company', '<>', NULL], ['roles.name', '=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);
            // dd($users_data);

            $CatlogWrc = (object) [
                'id' => 0,
                'user_id' => '',
                'brand_id' => '',
                'lot_id' => '',
                'commercial_id' => '',
                'img_recevied_date' => '',
                'missing_info_notify_date' => '',
                'missing_info_recived_date' => '',
                'confirmation_date' => '',
                'sku_qty' => $saved_rows,
                'work_brief' => '',
                'modeOfDelivary' => '0',
                'generic_data_format_link' => '',
                'img_as_per_guidelines' => '',
                'guidelines' => '',
                'document1' => '',
                'document2' => '',
                'wrc_number' => $wrcNumber,
                'alloacte_to_copy_writer' => 1,
                'button_name' => 'Create New Catlog WRC',
                'route' => 'STORECATLOGWRC'
            ];
            return view('Wrc.Catalog-wrc-create')->with('users_data', $users_data)->with('CatlogWrc', $CatlogWrc)->with('sku_details', $sku_details);;

            // return $this->Index($request, $createWrc->id);
        } catch (\Exception $e) {
            throw $e;
            DB::rollback();
            request()->session()->flash('error', 'Please try again!!');
        }
    }
    // for view
    public function view()
    {
        $wrcs =  CatlogWrc::OrderBy('catlog_wrc.updated_at', 'DESC')
            ->leftJoin('catalog_wrc_batches', 'catalog_wrc_batches.wrc_id', 'catlog_wrc.id')
            ->leftJoin(
            'catalog_wrc_skus',
            function ($join) {
                $join->on('catalog_wrc_batches.wrc_id', '=', 'catalog_wrc_skus.wrc_id');
                $join->on('catalog_wrc_batches.batch_no', '=', 'catalog_wrc_skus.batch_no');
            })
            ->leftJoin('lots_catalog', 'lots_catalog.id', 'catlog_wrc.lot_id')
            ->leftJoin('users', 'users.id', 'lots_catalog.user_id')
            ->leftJoin('brands', 'brands.id', 'lots_catalog.brand_id')
            ->select(
            'catlog_wrc.*',
            'catalog_wrc_batches.batch_no',
            'catalog_wrc_skus.batch',
            'catalog_wrc_batches.updated_at',
            'lots_catalog.user_id',
            'lots_catalog.brand_id', 
            'lots_catalog.lot_number', 
            'users.Company as Company_name', 
            'brands.name'
            )
            -> groupBy(['catalog_wrc_batches.wrc_id', 'catalog_wrc_batches.batch_no'])
            ->get();
        //    dd($wrcs);
        return view('Wrc.Catalog-view-wrc')->with('wrcs', $wrcs);
    }
    // for edit
    public function edit(Request $request, $id)
    {
        $users_data = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([['users.Company', '<>', NULL], ['roles.name', '=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);

        $CatlogWrcs =  CatlogWrc::find($id);
        $lot_id = $CatlogWrcs->lot_id;

        $lot = DB::table('lots_catalog')->where('id', $lot_id)->first(['user_id', 'brand_id']);

        $user_id = $lot != null ? $lot->user_id : 0;
        $brand_id = $lot != null ? $lot->brand_id : 0;
        
        $sku_details = array(
            'unique_Count' => 0,
            'variant_Count' => 0,
            'total_Count' => 0,
        );
        $CatalogWrcSku =  CatalogWrcSku::where('wrc_id','=', $id)->get();

        foreach($CatalogWrcSku as $sku_row){
            // dd($sku_row);
            $sku_details['total_Count']++;
            if ($sku_row->style == 'parent') {
                $sku_details['unique_Count']++;
            } else {
                $sku_details['variant_Count']++;
            }
        }
        


        if ($CatlogWrcs) {
            $CatlogWrcs->button_name = 'Update WRC';
            $CatlogWrcs->route = 'UPDATECATLOGWRC';
            $CatlogWrcs->user_id = $user_id;
            $CatlogWrcs->brand_id = $brand_id;

            return view('Wrc.Catalog-wrc-create')->with('users_data', $users_data)->with('CatlogWrc', $CatlogWrcs)->with('sku_details', $sku_details);
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $id =  $request->id;

        $project_name_array = explode(" ", $request->s_type);
        $count = count($project_name_array);
        $project_name = "";
        $wrcs = CatlogWrc::where(['lot_id' => $request->lot_id])->get();
        $wrcCount = $wrcs->count();
        
        $project_name .= $project_name_array[0][0];
        $project_name .= $project_name_array[$count - 1][0];

        $wrcNumber = $request->c_short . $request->short_name . $project_name . $request->lot_id . '-' . chr($wrcCount + 65);

        //update

        $modeOfDelivary = $request->modeOfDelivary;
        $lot_id = $request->lot_id;
        $catalog_requestType = DB::table('lots_catalog')->where('id', $lot_id)->get(['requestType'])->first();
        $requestType = $catalog_requestType  != null ? $catalog_requestType->requestType : null;
        $alloacte_to_copy_writer = ((isset($request->alloacte_to_copy_writer) && $request->alloacte_to_copy_writer == 1)) ? 1 : 0;

        $batch_no = 0;
        $is_retainer = 0;
        if ($requestType == 'Retainer') {
            $batch_no = 1;
            $is_retainer = 1;
        }


        $createWrc = CatlogWrc::find($id);
        $createWrc->lot_id = $request->lot_id;
        // $createWrc->wrc_number = $wrcNumber;
        $createWrc->modeOfDelivary = $modeOfDelivary;
        $createWrc->commercial_id = $request->commercial_id;

        $createWrc->img_recevied_date = $request->img_recevied_date == null ? '' : $request->img_recevied_date;
        $createWrc->missing_info_notify_date = $request->missing_info_notify_date == null ? '' : $request->missing_info_notify_date;
        $createWrc->missing_info_recived_date = $request->missing_info_recived_date == null ? '' : $request->missing_info_recived_date;
        $createWrc->confirmation_date = $request->confirmation_date == null ? '' : $request->confirmation_date;
        $createWrc->work_brief = $request->work_brief == null ? '' : $request->work_brief;
        $createWrc->guidelines = $request->guide_lines == null ? '' : $request->guide_lines;
        $createWrc->document1 = $request->document1 == null ? '' : $request->document1;
        $createWrc->document2 = $request->document2 == null ? '' : $request->document2;
        $createWrc->generic_data_format_link = $request->generic_data_format_link == null ? '' : $request->generic_data_format_link;
        $createWrc->img_as_per_guidelines = $request->img_as_per_guidelines == null ? '' : $request->img_as_per_guidelines;

        $sku_qty_is = $request->sku_qty == null ? '0' : $request->sku_qty;
        $createWrc->alloacte_to_copy_writer = $alloacte_to_copy_writer;
        // $createWrc->sku_qty = $sku_qty_is;
        $createWrc->is_retainer = $is_retainer;
        $createWrc->status = 'Ready_for_allocation';
        $createWrc->update();

        if ($createWrc) {
            request()->session()->flash('success', 'Wrc Catlog Successfully Updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('EDITCATLOGWRC', [$id]);
        // return $this->edit($request, $id);
    }

    // CatalogWrcStatus
    public function CatalogWrcStatus(){
        $CatalogWrcList = CatlogWrc::CatalogWrcList();
        // pre($CatalogWrcList);
        return view('Wrc.catalog-wrc-status')->with('CatalogWrcList', $CatalogWrcList);


    }
}
