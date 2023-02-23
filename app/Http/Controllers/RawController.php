<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PlanDate;
use App\Models\Dayplan;
use Session; 
use App\Models\uploadraw;
use App\Models\Skus;
use App\Models\Lots;
use App\Models\Wrc;
use DB;
use stdClass;

class RawController extends Controller
{

	public function rawUploadview(){

		$shoot= planDate::getplanInfo([]);

	//debug($shoot);die;
		return view('Img.viewraw', compact('shoot'));
	}

	public function getview(){
		$skuList = [];
		$shoot= Dayplan::latest()->get();
		$shootFirst= Dayplan::get()->last();
		$skuListContent= $this->rawDyanamic($shootFirst->id);
		return view('Img.raw', compact('skuListContent','shoot','skuList'));	
	}

	public function getPlanSchl(Request $request){
		$dayPlanId = $request->day_plan_id;
		$shootday = planDate::getplanInfo(['dayplan_id' => $dayPlanId, 'single' => true]);
		echo view('Img.dynamic-plan-schedule', compact('shootday'));
		exit(); 
	}

	private function rawDyanamic($dayPlanId){
		$shootPlan = planDate::getplanInfo(['dayplan_id' => $dayPlanId]);
		$skuList = [];
		$wrcList = [];
		$lots = $wrcs = $skus = 0;
		foreach ($shootPlan as $index => $shoot) {
			$skuList[$shoot->lot_id][$shoot->wrc_id][] = $shoot;
			$wrcList[$shoot->wrc_id] = $shoot->wrc_id;
		}

		return view('Img.rawdynamic', compact('skuList'));
		

	}

	public function skuListContent(Request $request){
		$dayPlanId = $request->day_plan_id;
		return $this->rawDyanamic($dayPlanId);
		exit();
	}

	public function setSkuValues(Request $request){
		$selectedSkuId = $request->selected_sku_id;
		$selectedSkuText = $request->selected_sku_text;
		$selectedLot = $request->selected_lot;
		$selectedWrc = $request->selected_wrc;
		$status = $request->status;
		$skuObj = Skus::where(['id' => $selectedSkuId])->first();
		$skuObj->status = $status;
		$skuObj->save();
		$data = json_encode(array('selected_wrc' => $selectedWrc,'selected_lot' => $selectedLot,'selected_sku_id' => $selectedSkuId, 'selected_sku_text' => $selectedSkuText));

		$fh = fopen('sku_data.json', 'w');
		fwrite($fh, $data);
		fclose($fh);
		echo "success";
		exit();
	}


	public function imgUpload(Request $request){
		$skuData = file_get_contents('sku_data.json');//wrc no
		$skuData = json_decode($skuData);
		$input=$request->all();
		if($files=$request->file('sku_images')){
			foreach($files as $file){
				$filename=$file->getClientOriginalName();
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$path="raw_img_directory/".date('Y'). "/" .date('M')."/". $skuData->selected_lot."/".$skuData->selected_wrc."/".$skuData->selected_sku_text;
			$skuId = Skus::where(['sku_code' =>$skuData->selected_sku_text])->first();
			$images = uploadraw::where(['sku_id' => $skuId->id])->get();
			$count =  count($images) + 1;
			$imageName = $skuData->selected_sku_text.'_'.$count . '.' . $ext;

				$file->move($path,$imageName);

				$rawUpload= new uploadraw();
				$rawUpload->filename=$imageName;
				$rawUpload->sku_id=$skuData->selected_sku_id;
				$rawUpload->save();

				 /* send notification start */ //pending for data
				
				 $creation_type = 'ShootRawImage';
	 
				 $data = new stdClass();
				 $data->wrc_number = '';
				 $data->approve_count = '0';
				 $data->rejection_count = '0';
				 $this->send_notification($data, $creation_type);
			 	/******  send notification end*******/

			
			}
			
		}
		
		echo "success";
		exit();

	}
	
	public function bulkImage(Request $request){
    $status = false;
    $message = "SKU Code did not match to exisiting record !";
    $lot_id = $request->lotid;
    $wrc_id = $request->wrcid;
    $lotid = Lots::where( 'lot_id' ,'=', $lot_id)->pluck('id');
    $wrcid = Wrc::where( 'wrc_id' ,'=', $wrc_id)->pluck('id');
    $skucodes = $request->skucodes;
        $input = $request->all();
        if ($files = $request->file('sku_images')) {
            $skucodes = (!empty($skucodes)) ? explode(' | ', $skucodes) : array();
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $ext = pathinfo($filename, PATHINFO_EXTENSION); 
                $skutext = str_replace("." . $ext, "", $filename);
                $pos = strripos("$skutext","_");
                $sku_code = substr($skutext, 0, $pos);
                $path = "raw_img_directory/" . date('Y') . "/" . date('M') . "/" . $lot_id . "/" . $wrc_id . "/" . $sku_code;
                $skuObj = Skus::where(["sku_code" => $sku_code, 'lot_id' => $lotid, 'wrc_id' => $wrcid])->first();
                if (!empty($skuObj)) {
                  $file->move($path, $filename);
			    	$rawUpload= new uploadraw();
			    	$rawUpload->filename=$filename;
			    	$rawUpload->sku_id=$skuObj->id;
			    	
			    	$rawUpload->save();
                    $status = true;
                    $message = "Image upload successfully!";

                    $skuId = $skuObj->id;
        
        	$skuStatus = Skus::where(['id' => $skuId])->first();
            $skuStatus->status = $status;
		    $skuStatus->save();

                    if (!in_array($sku_code, $skucodes)) {
                        $skucodes[] = $sku_code;
                    }
                }
            }
            return response()->json(['status' => $status, 'message' => $message, 'sku_codes' => implode(' | ', $skucodes)]);
        
    }
    return response()->json(['status' => $status, 'message' => $message]);
    }

	public function rejectComment(Request $request){
		$selectedSkuId = $request->selected_sku_id;
		$sku_c = $request->sku_c;
		$skuObj = Skus::where(['id' => $selectedSkuId])->first();
		$skuObj->sku_c = $sku_c;
		$skuObj->save();

		echo "success";
		exit();

	}

	public function getImageCount(Request $request){
		$selectedSkuId = $request->selected_sku_id;
		$imageCount = uploadraw::where(['sku_id' => $selectedSkuId])->count();
		echo $imageCount;
		exit();
	}
}
