<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\allocation;
use App\Models\User;
use App\Models\Skus;
use App\Models\Lots;
use App\Models\Wrc;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use App\Models\uploadraw;
use App\Models\skusStatus;

class allocationController extends Controller {

    public function Index() {


        $allocations = allocation::ReadyAllocation($filter = ['skip_alloted' => true]);

        $allocationList = [];

        foreach ($allocations as $allocation) {

            $index = $allocation->lot_id;
            //$aprvd_count = Skus::where(['lot_id' => $allocation->lotid,'status'=> 1])->get();
          $inward_count = Skus::where(['lot_id' => $allocation->lotid])->distinct('sku_code')->pluck('sku_code');
            $allocationList[$index]['lot_id'] = $allocation->lot_id;
            $allocationList[$index]['lotid'] = $allocation->lotid;
            $allocationList[$index]['name'] = $allocation->brand_name;
            $allocationList[$index]['Company'] = $allocation->Company;
             $allocationList[$index]['inward_count'] = count($inward_count);
            $allocationList[$index]['aprvd_count'] =  'not available';
            $allocationList[$index]['wrcs'][$allocation->wrc_id]['wrcid'] = $allocation->wrcid;
             $allocationList[$index]['allocated_count'] =  'not available';
            
        }


        $users = User::whereHas(
            'roles', function ($q) {
                $q->where('name', 'Editors');
            }
        )->get();


        return view('edit-allocate.allocation', compact('allocationList', 'users'));
    }


    public function wrcAllocation(Request $request){
        $lotId= $request->lot_id;

        $allocations = allocation::getAllocation($filter = ['skip_alloted' => true,'lot_id' =>$lotId, 'group' => true ]);


        $lot = Lots::where('id','=',$lotId)->get()->first();


        $lot_id = $lot->lot_id;

$allo = [];
        foreach($allocations as $allocation){
           $wrcId = $allocation->wrcid;

           $allo[$wrcId]['wrc_Id'] =  $allocation->wrcid;
            $allo[$wrcId]['wrc_id']= $allocation->wrc_id;
            $allo[$wrcId]['type_of_shoot']= $allocation->type_of_shoot;
            $allo[$wrcId]['type_of_clothing']= $allocation->type_of_clothing;
            $allo[$wrcId]['adaptation_1']= $allocation->adaptation_1;
            $allo[$wrcId]['adaptation_2']= $allocation->adaptation_2;
            $allo[$wrcId]['adaptation_3']= $allocation->adaptation_3;
            $allo[$wrcId]['adaptation_4']= $allocation->adaptation_4;
            $allo[$wrcId]['adaptation_5']= $allocation->adaptation_5;
            $allo[$wrcId]['inward_count'] = count(allocation::getAllocation($filter = ['skip_alloted' => true, 'wrc_id' => $wrcId , 'groupSku'=>true ]));
            
        }
        
        $html = view('edit-allocate.wrcAllo',compact('allo','lot_id'));
        return $html;
    }

    public function Allodetails() {

        $allocations = allocation::getAllocation($filter = ['skip_alloted' => false, 'allocation_user_info' => true]);

        $allocationList = [];

        foreach ($allocations as $allocation) {
            $skuIndex = $allocation->lot_id . '' . $allocation->wrc_id . '' . $allocation->sku_id;
            $fileIndex = $allocation->lot_id . '' . $allocation->wrc_id . '' . $allocation->sku_id . '_' . $allocation->filename;

            $allocationList[$allocation->user_id]['editor'] = $allocation->allocation_user_name;
            $allocationList[$allocation->user_id]['client_id'] = $allocation->client_id;
            $allocationList[$allocation->user_id]['Company'] = $allocation->Company;
            $allocationList[$allocation->user_id]['lot_info'][$allocation->lot_id]['all_skus'][$skuIndex] = $allocation->sku_code;
            $allocationList[$allocation->user_id]['lot_info'][$allocation->lot_id]['all_files'][$fileIndex] = $allocation->filename;
            $allocationList[$allocation->user_id]['lot_info'][$allocation->lot_id]['lot_id'] = $allocation->lot_id;
            $allocationList[$allocation->user_id]['lot_info'][$allocation->lot_id]['wrc_info'][$allocation->wrc_id]['wrc_id'] = $allocation->wrc_id;

            $allocationList[$allocation->user_id]['lot_info'][$allocation->lot_id]['wrc_info'][$allocation->wrc_id]['sku_info'][$allocation->sku_id]['sku_id'] = $allocation->sku_code;
            $allocationList[$allocation->user_id]['lot_info'][$allocation->lot_id]['wrc_info'][$allocation->wrc_id]['sku_info'][$allocation->sku_id]['filename'][] = $allocation->filename;
        }
        return view('edit-allocate.re-allocation', compact('allocationList'));
    }

    public function getRequest(Request $request) {

        $wrc_id = array($request->wrc_id); 


        foreach ($wrc_id as $index => $wrc){

            $wr = Wrc::getwrcInfo(['id'=>$wrc])->first();
            $wrc_id = $wr->wrc_id;
            $wrcs =  $wr->id;
            $lots = $wr->lot_id;
            $data = allocation::getAllocation($filter = ['skip_alloted' => true,'wrc_id' => $wrcs, 'groupSku' => true]);
               foreach ($data as $sku){                
                $final['sku_id'][] = $sku->sku_id;
                $final['sku_code'][] = $sku->sku_code;
        }


         }


     return view('edit-allocate.allo-dynamic', compact('wrc_id', 'lots','final'));
     exit();
 }

 public function saveAllo(Request $request) {

    $user_id = $request->user_id;
    $sku_ids = $request->sku_id;

    $sk=[];
foreach ($sku_ids as $sku_id){

    $skuId= $sku_id;

   $sk[$skuId]['uploadraw_ids']= allocation::getAllocation($filter = ['skip_alloted' => true,'sku_code' => $skuId])->pluck('uploadraw_id');


    foreach ($sk[$skuId]['uploadraw_ids'] as $uploadraw_id) {
        $allo = new allocation();
        $allo->uploadraw_id = $uploadraw_id;
        $allo->user_id = $user_id;
        $allo->save();

        $skus = uploadraw::where(['id' => $uploadraw_id])->first();

        $skuId = $skus->sku_id;

        $skuFound = skusStatus::where(['sku_id' => $skuId, 'status' => 'allocation_done'])->get();
        if (count($skuFound) != 0) {

        } else {
            $skuInfo = Skus::find(['id' => $skuId])->first();
            $skuInfo->current_status = 'allocation_done';
            $skuInfo->save();

            // $statusEngine = new skusStatus();
            // $statusEngine->sku_id = $skuId;
            // $statusEngine->status = 'allocation_done';
            // $statusEngine->save();

            // updateWrcStatus($skuInfo->wrc_id, $skuInfo->lot_id);
        }
    }
}
    return "succes";
}

}
