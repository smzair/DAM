<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lots;
use App\Models\Wrc;
use App\Models\Skus;
use App\Models\Dayplan;
use App\Models\PlanDate;
use App\Models\equipments;
use App\Models\equipments_plan;
use App\Models\NotificationModel\ClientNotification;

class adminController extends Controller
{
	public function index(){
	        $list = equipments::get();
		$lots= Lots::getlotInfo($filter = []);
		return view('admin.vieweverything',compact('lots','list'));
	} 

	public function plan(){

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


		$dayplan = Dayplan::latest()->get();
		$isShoot = 0;

		return view('admin.plan', compact('wrcs','dayplan', 'isShoot'));
	}



	public function Bay(){
	        $list = equipments::get();

		$days = Dayplan::latest()->get();
		return view('admin.bay',compact('days','list'));
	}

    public function edit($id)
    {
        $Dayplan = Dayplan::find($id);

        return response()->json([
          'data' => $Dayplan
        ]);

    }

 	public function delete($id){

     $brand=Dayplan::findOrfail($id);
     $brand->delete();
     return redirect()->route('admin.bay')->with('success','Day Deleted');

	}

	public function table() {
		$shootPlanList = planDate::getplanInfo([]);
		$wrcs = [];
		foreach ($shootPlanList as $sPlan) {
			$index = $sPlan->dayplan_id . '_' . $sPlan->wrc_id;
			$wrcs[$index]['id'] = $sPlan->wrc_tbl_id;
			$wrcs[$index]['lot_id'] = $sPlan->lot_id;
			$wrcs[$index]['Company'] = $sPlan->Company;
			$wrcs[$index]['name'] = $sPlan->name;
			$wrcs[$index]['am_email']=$sPlan->am_email;
			$wrcs[$index]['s_type']=$sPlan->s_type;
			$wrcs[$index]['created_at'] = $sPlan->created_at;
			$wrcs[$index]['product_category'] = $sPlan->product_category;
			$wrcs[$index]['type_of_shoot'] = $sPlan->type_of_shoot;
			$wrcs[$index]['type_of_clothing'] = $sPlan->type_of_clothing;
			$wrcs[$index]['adaptation_1'] = $sPlan->adaptation_1;
			$wrcs[$index]['gender'] = $sPlan->gender;
			$wrcs[$index]['date']=$sPlan->date;
			$wrcs[$index]['studio']=$sPlan->studio;
			$wrcs[$index]['photographer']=$sPlan->photographer;
			$wrcs[$index]['stylist']=$sPlan->stylist;
			$wrcs[$index]['makeupartist']=$sPlan->makeupartist;
			$wrcs[$index]['rawqc']=$sPlan->rawqc;
			$wrcs[$index]['model']=$sPlan->model;
			$wrcs[$index]['agency']=$sPlan->agency;
			$wrcs[$index]['assistant']=$sPlan->assistant;
			$wrcs[$index]['adaptation_2']=$sPlan->adaptation_2;
			$wrcs[$index]['adaptation_3']=$sPlan->adaptation_3;
			$wrcs[$index]['adaptation_4']=$sPlan->adaptation_4;
			$wrcs[$index]['adaptation_5']=$sPlan->adaptation_5;
			$wrcs[$index]['wrc_id'] = $sPlan->wrc_id;
			$wrcs[$index]['skus'][] = ['id' => $sPlan->sku_id, 'sku_code' => $sPlan->sku_code, 'category' => $sPlan->category, 'subcategory' => $sPlan->subcategory];
		}
		$wrcs = json_encode($wrcs);
		$wrcs = json_decode($wrcs);
		$dayplan = Dayplan::latest()->get();
		$isShoot = 1;
	
		return view('admin.plan', compact('wrcs','dayplan', 'isShoot'));
	}


	public function getWrc(Request $request){
		$lotId = $request->lot_id;
		$wrcs = Wrc::getwrcInfo(['lot_id' => $lotId]);
		return view('admin.adminwrc',compact('lotId', 'wrcs'));
	}



	public function savDay(Request $request){
		$id = $request->id;
		if (!empty($id)) {
			$data =  Dayplan::find($id);
		} else {
			$data = new Dayplan();
		}
        $data->date = $request->date;
        $data->studio = $request->studio;
        $data->photographer = $request->photographer;
        $data->shoot_hour=$request->shoot_hour;
        $data->model_available=$request->model_available;
        $data->stylist = $request->stylist;
        $data->makeupartist = $request->makeupartist;
        $data->model = $request->models;
        $data->shootType = $request->shootType;
        $data->agency = $request->agency;
        $data->model_charges = $request->model_charges;
        $data->stylist_charges = $request->stylist_charges;
        $data->makeup_charges = $request->makeup_charges;
        $data->rawqc = $request->rawqc;
        $data->assistant= $request->assistant;
        $data->assistant_charges = $request->assistant_charges;
        $data->photographer_charges = $request->photographer_charges;
        $data->extra_model_charges = $request->extra_model_charges;
        $data->save();
        $date = $request->date;
        $id = $data->id;
        $plan_id = $request->dayplan;

			if ($request->dayplan != null) {
				$plan_id = $request->dayplan;
				foreach ($plan_id as $plan) {
					$obj = new equipments_plan();
					$obj->plan_id = $plan;
					$obj->equipment_id = $id;
					$obj->save();
				}
			}

  

		return redirect('/bay')->with('success', " Welcome the new plan for " . $date . " has been added successfully");
	}


	public function getSku(Request $request){
		$wrcId=$request->wrc_id;
		$skus = Skus::where(['wrc_id' => $wrcId])->get();
		return view('admin.adminsku',compact('wrcId', 'skus'));
	}


	public function planShoot(Request $request){
		$wrcs = $request->wrcs;
		$skusId = $request->skus_id;
		$skusCode = $request->skus_code;
		return view('admin.d-sku-plan',compact('wrcs','skusId','skusCode'));
	}

	public function planSave(Request $request){
		$selectedSkus = $request->selected_skus;
		$dayPlan = $request->dayplan;
		foreach ($selectedSkus as $skuId) {
			$planInfo = planDate::getplanInfo(['sku_id' => $skuId, 'single' => true]);
			if($planInfo){
				$data = planDate::find(['id' => $planInfo->id])->first();
			}else{
				$data = new planDate();
			}
			$data->sku_id=$skuId;
			$data->dayplan_id=$dayPlan;
			$data->save();
			
		}

		$Skus_data = Skus::whereIn('sku.id', $selectedSkus)->leftJoin('wrc', 'sku.wrc_id' , 'wrc.id')->
		select(
			'sku.user_id',
			'sku.brand_id',
			'sku.lot_id',
			'sku.wrc_id',
			'sku.sku_code',
			'wrc.wrc_id as wrc_number'
		)->get()->toArray();

		if(count($Skus_data) > 0){
			$wrc_sku_data = $Skus_data['0'];			
			$save_ClientNotification_data = array(
				'user_id' => $wrc_sku_data['user_id'],
				'brand_id' => $wrc_sku_data['brand_id'],
				'wrc_number' => $wrc_sku_data['wrc_number'],
				'service' => 'Shoot',
				'subject' => 'Planning',
				'sku_count' => count($selectedSkus)
			);
			$save_status = ClientNotification::save_ClientNotification($save_ClientNotification_data);
		}

		// dd($selectedSkus , $Skus_data , implode(',',$selectedSkus));

		echo "success";
		exit();
	
	}
	public function skuPlanUplaod(Request $req) {

        $handle = fopen($_FILES['plansheet']['tmp_name'], "r");
        $header = true;
        $skuObj = [];
        $nullIds= [];
        while ($csvLine = fgetcsv($handle, 1000, ",")) {
            if ($header) {
                $header = false;
            } else{
                $skuObj['wrc_number'] = $csvLine[0];
                $skuObj[$csvLine[0]][] = $csvLine[1];
            }  
        }
        $wrcs  = Wrc::getwrcInfo(['wrc_id'=>$skuObj['wrc_number']])->first();
        if(!empty($wrcs->id)){
            $wrcId = $wrcs->id;
            $wrc_id = $wrcs->wrc_id;
            $skusIds = $skusCodes = [];
            foreach($skuObj[$skuObj['wrc_number']]  as $skus){
                $sku = Skus::getskuInfo(['wrc_id'=>$wrcId,'sku_code'=>$skus])->first();
                if($sku->id == null){
                    $nullIds[]=$skus;
                    
                }
                else{
                $skusIds[] = $sku->id;
                $skusCodes[]  = $sku->sku_code; 
            }
                
            }
           
        }

        return view('admin.plansheet',compact('wrc_id','skusIds','skusCodes','nullIds'));
	}

    
}


