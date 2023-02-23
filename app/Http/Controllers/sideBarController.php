<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wrc;
use App\Models\Skus;
use App\Models\PlanDate;
use App\Models\allocation;
class sideBarController extends Controller
{
    public function planCount(){

        $wrcList=Wrc::getwrcInfo($filter = ['status' => 'ready_for_plan']);
        $wrcs = [];

        foreach ($wrcList as $wrc) {
            $skus = Skus::where(['wrc_id' => $wrc->id])->get();
            $skuList = [];
            foreach ($skus as $sku) {
                $exist = planDate::where(['sku_id' => $sku->id])->count();
                if(!$exist){
                    $skuList[] = $sku;
                }
            }
            $wrc->skus = $skuList;
            if(count($skuList)){
                $wrcs[] = $wrc;
            }
        }
        echo count($wrcs);
        exit();
    }

    public function allocationCount(){
    
    $allocations = allocation::getAllocation($filter = ['skip_alloted' => true]);

        $allocationList = [];


        foreach($allocations as $allocation){

            $index=$allocation->lot_id;
            $inward_count=Skus::getskuInfo($filter = ['wrc_id'=> $allocation->wrcid, 'count' => true]);
            $allocationList[$index]['lot_id'] = $allocation->lot_id;
            $allocationList[$index]['client_id'] = $allocation->client_id;
            $allocationList[$index]['Company'] = $allocation->Company;
        }
        echo count($allocationList);
        exit();
}
}
