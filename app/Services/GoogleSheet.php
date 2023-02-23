<?php

namespace App\Services;

use App\Models\Brands;
use App\Models\brands_user;
use App\Models\Commercials;
use App\Models\Lots;
use App\Models\Wrc;
use App\Models\Skus;
use App\Models\Dayplan;
use App\Models\planDate;
use App\Models\uploadraw;
use App\Models\allocation;
use App\Models\editing;
use App\Models\editorSubmission;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_ClearValuesRequest;
use Google_Client;
use App\Models\User;

class Googlesheet{
	
	private $spreadSheetId;
	private $client;
	private $googleSheetService;
	public $data;

	public function __construct(){

		$this->spreadSheetId = config('datastudio.google_sheet_id');
		$this->client = new Google_Client();
		$this->client->setAuthConfig(storage_path('credentials.json'));
		$this->client->addScope("https://www.googleapis.com/auth/spreadsheets");

		$this->googleSheetService = new Google_Service_Sheets($this->client);
	}

	public function readGoogleSheet(){

		$dimensions = $this->getDimensions($this->spreadSheetId);
		$range = 'Sheet1!A2:' . $dimensions['colCount'];
		$requestBody = new Google_Service_Sheets_ClearValuesRequest();
		$data = $this->googleSheetService
		->spreadsheets_values
		->clear($this->spreadSheetId, $range ,$requestBody);

		return "ok";

	}

	public function saveDataToSheet(){

		$wrc = Wrc::getwrcInfo($filter = []);
    
		$wrcInfo = array();
		$sr= 0;
		foreach ($wrc as $wrcs){
			$id = $wrcs->lotId;
			$WrcId = $wrcs->id;
			$index = $sr++;
			$lot_inward = $wrcs->inward;
			$wrcscount = Wrc::where(['lot_id' => $id])->get();
			$plan = planDate::getplanInfo(['wrc_id' => $WrcId])->last();
			$lsku_count = Skus::where('lot_id' ,'=', $id)->get();
			$wsku_count = Skus::where('wrc_id' ,'=', $WrcId)->get();
			$reject_count = count(Skus::where(['wrc_id' => $WrcId,'status' => '0'] )->get());
			$approved_count = count(Skus::where(['wrc_id' => $WrcId,'status' => '1'] )->get());
			$wrcInfo[$index]['Company'] = !empty($wrcs->Company) ? $wrcs->Company : 'Not Available';
			$wrcInfo[$index]['date'][]=$wrcs->ppt_approval;
			$wrcInfo[$index]['date'][]=$wrcs->model_approval;
			$wrcInfo[$index]['date'][]=$wrcs->special_approval;
			$wrcInfo[$index]['date'][]=$wrcs->inward_sheet;
			$wrcInfo[$index]['date'][]=$lot_inward;
			$skucom = count($wsku_count) - $reject_count;
			
			
			$wrcInfo[$index]['plannins_detail'] = $plan;
			
			
			$wrcInfo[$index]['inward_at'] = dateFormat($lot_inward);
			$wrcInfo[$index]['lot_id'] = $wrcs->lot_id;
			$wrcInfo[$index]['inwardLot_sku_count'] = count($lsku_count);
			$wrcInfo[$index]['wrc_id'] = $wrcs->wrc_id;
			$wrcInfo[$index]['wrc_count'] = count($wrcscount);
			$wrcInfo[$index]['inwardwrc_sku_count'] = count($wsku_count);
			$wrcInfo[$index]['name'] = !empty($wrcs->name) ? $wrcs->name :'Not Available' ;
			$wrcInfo[$index]['client_id'] = !empty($wrcs->client_id) ? $wrcs->client_id : 'Not Available';
			$wrcInfo[$index]['Location'] = !empty($wrcs->location) ? $wrcs->location : 'Not Available';
			$wrcInfo[$index]['verticalType'] = !empty($wrcs->verticleType) ? $wrcs->verticleType : 'Not Available';
			$wrcInfo[$index]['clientBucket'] = !empty($wrcs->clientBucket) ? $wrcs->clientBucket : 'Not Available' ;
			$wrcInfo[$index]['shoothandoverDate'] = !empty($wrcs->shoothandoverDate) ? $wrcs->shoothandoverDate : 'Not Available';
			$wrcInfo[$index]['gender'] = $wrcs->gender;
			$wrcInfo[$index]['am_email'] = !empty($wrcs->am_email) ? $wrcs->am_email :'Not Available';
    	   
			if(!empty($plan)) {
				$dayplan_id = $plan->dayplan_id; 
				$totalplanedskus = planDate::getplanInfo(['dayplan_id' => $dayplan_id]);
				$wrcInfo[$index]['totalplanedskus'] = count($totalplanedskus);
				$photographer_charges = $wrcInfo[$index]['plannins_detail']->photographer_charges/$wrcInfo[$index]['totalplanedskus'];
				$photographer_chargesFinal = $skucom * $photographer_charges;
				$assistant_charges=$wrcInfo[$index]['plannins_detail']->assistant_charges/$wrcInfo[$index]['totalplanedskus'];
				$assistant_chargesFinal=$skucom*$assistant_charges;
				$wrcInfo[$index]['date'][]=$wrcInfo[$index]['plannins_detail']->model_available;
				$wrcInfo[$index]['type_of_shoot'] = $wrcInfo[$index]['plannins_detail']->type_of_shoot;
				
				$wrcInfo[$index]['type_of_clothing'] = $wrcInfo[$index]['plannins_detail']->product_category;
				$wrcInfo[$index]['adaptation_1'] = !empty($wrcInfo[$index]['plannins_detail']->adaptation_1) ? $wrcInfo[$index]['plannins_detail']->adaptation_1 : 'Not Available';
				$wrcInfo[$index]['adaptation_2'] = !empty($wrcInfo[$index]['plannins_detail']->adaptation_2) ? $wrcInfo[$index]['plannins_detail']->adaptation_2 : 'Not Available' ;
				$wrcInfo[$index]['adaptation_3'] = !empty($wrcInfo[$index]['plannins_detail']->adaptation_3) ? $wrcInfo[$index]['plannins_detail']->adaptation_3 : 'Not Available';
				$wrcInfo[$index]['adaptation_4'] = !empty($wrcInfo[$index]['plannins_detail']->adaptation_4) ? $wrcInfo[$index]['plannins_detail']->adaptation_4 : 'Not Available';
				$wrcInfo[$index]['adaptation_5'] = !empty($wrcInfo[$index]['plannins_detail']->adaptation_5) ? $wrcInfo[$index]['plannins_detail']->adaptation_5 :'Not Available';

				if(empty($wrcs->ppt_approval)){
					$wrcInfo[$index]['ppt_approval'] = 'Not Available';
				}else{
					$wrcInfo[$index]['ppt_approval'] = dateFormat($wrcs->ppt_approval);  
				}
				if(empty($wrcs->model_approval)){
					$wrcInfo[$index]['model_approval'] = 'Not Available';
				}else{
					$wrcInfo[$index]['model_approval'] = dateFormat($wrcs->model_approval);  
				}

				if(empty($wrcs->inward_sheet)){
					$wrcInfo[$index]['inward_sheet'] = 'Not Available';
				}else{
					$wrcInfo[$index]['inward_sheet'] =  dateFormat($wrcs->inward_sheet);  

				}
				if(empty($wrcs->special_approval)){
					$wrcInfo[$index]['special_approval'] = 'Not Available';
				}else{
					$wrcInfo[$index]['special_approval'] =  dateFormat($wrcs->special_approval);  
				}
				if(empty($wrcInfo[$index]['plannins_detail']->model_available)){
					$wrcInfo[$index]['model_available'] = 'Not Available';
				}else{
					$wrcInfo[$index]['model_available'] =  dateFormat($wrcInfo[$index]['plannins_detail']->model_available);
				}
				if(count($lsku_count) > 40){
					$wrcInfo[$index]['Lot_size'] ='Above 40 articles';
				}else{
					$wrcInfo[$index]['Lot_size'] = 'Upto 40 articles';
				}
				$max = max($wrcInfo[$index]['date']);
				$wrcInfo[$index]['TAT_start_date'] = date('d-M-y', strtotime($max .' +1 weekday '));
				if(count($lsku_count) > 40){
					$wrcInfo[$index]['TAT_end_date'] =date('d-M-y', strtotime($max .' +5 weekday'));
				}else{
					$wrcInfo[$index]['TAT_end_date'] =date('d-M-y',strtotime($max .' +11 weekday'));
				}
				
				$wrcInfo[$index]['planning_date'] = date('d-M-Y', strtotime($wrcInfo[$index]['plannins_detail']->created_at));
				
				$wrcInfo[$index]['shoot_month'] = date('M', strtotime($wrcInfo[$index]['plannins_detail']->shootdate));
				
				$wrcInfo[$index]['shoot_date'] =  date('d-M-Y', strtotime($wrcInfo[$index]['plannins_detail']->shootdate));
				
                $wrcInfo[$index]['reject_count'] = $reject_count;
                $wrcInfo[$index]['Editing'] = 'Not Available';
               
            if($wrcs->Client_AR == Null){
				$wrcInfo[$index]['clientar'] = "Not Available";
			}
			elseif($wrcs->Client_AR == 0){
				$wrcInfo[$index]['clientar'] = "WRC Rejected";
			}
			if($wrcs->Client_AR == 1){
				$wrcInfo[$index]['clientar'] = "WRC Approved";
			}

			$wrcInfo[$index]['submission_date'] = 'Not Available';
			$wrcInfo[$index]['submission_quantity'] = 'Not Available';
			
			$wrcInfo[$index]['shoot_hour'] =  !empty($wrcInfo[$index]['plannins_detail']->shoot_hour) ? $wrcInfo[$index]['plannins_detail']->shoot_hour : 'Not Available';
			
			$wrcInfo[$index]['studio'] = $wrcInfo[$index]['plannins_detail']->studio;
			
			$wrcInfo[$index]['model'] = !empty($wrcInfo[$index]['plannins_detail']->model) ? $wrcInfo[$index]['plannins_detail']->model : 'Not Available';
			$wrcInfo[$index]['agency'] = !empty($wrcInfo[$index]['plannins_detail']->agency) ? $wrcInfo[$index]['plannins_detail']->agency :'Not Available';
			$wrcInfo[$index]['photographer'] = !empty($wrcInfo[$index]['plannins_detail']->photographer) ? $wrcInfo[$index]['plannins_detail']->photographer : 'Not Available';
			$wrcInfo[$index]['makeupartist'] = !empty($wrcInfo[$index]['plannins_detail']->makeupartist) ? $wrcInfo[$index]['plannins_detail']->makeupartist : 'Not Available';
			$wrcInfo[$index]['stylist'] = !empty($wrcInfo[$index]['plannins_detail']->stylist) ? $wrcInfo[$index]['plannins_detail']->stylist :'Not Available';
			$wrcInfo[$index]['assistant'] = !empty($wrcInfo[$index]['plannins_detail']->assistant) ? $wrcInfo[$index]['plannins_detail']->assistant :'Not Available';
			$wrcInfo[$index]['rawqc'] = !empty($wrcInfo[$index]['plannins_detail']->rawqc) ? $wrcInfo[$index]['plannins_detail']->rawqc : 'Not Available' ;
			$wrcInfo[$index]['invoice_no'] = !empty($wrcs->Invoice_no) ? $wrcs->Invoice_no : 'Not Available';
			$makeup_charges = $wrcInfo[$index]['plannins_detail']->makeup_charges /  $wrcInfo[$index]['totalplanedskus'];
			$makeup_chargesFinal = $skucom * $makeup_charges;
			$model_charges = $wrcInfo[$index]['plannins_detail']->model_charges /  $wrcInfo[$index]['totalplanedskus'];
			$model_chargesFinal = $skucom * $model_charges;
			$stylist_charges = $wrcInfo[$index]['plannins_detail']->stylist_charges/$wrcInfo[$index]['totalplanedskus'];
			$stylist_chargesFinal = $skucom * $stylist_charges;

			$wrcInfo[$index]['photographer_charges'] = round($photographer_chargesFinal,0);
					$wrcInfo[$index]['makeup_charges'] = round($makeup_chargesFinal,0);

			$wrcInfo[$index]['stylist_charges'] = round($stylist_chargesFinal,0);
			$wrcInfo[$index]['assistant_charges'] = round($assistant_chargesFinal,0);
			$wrcInfo[$index]['model_charges'] = round($model_chargesFinal,0);		
			}else{
			$wrcInfo[$index]['totalplanedskus'] = "Not Planned";
			$wrcInfo[$index]['date'] = "Not Planned";
			$wrcInfo[$index]['model_available'] = "Not Planned";
			$wrcInfo[$index]['planning_date'] = "Not Planned";
						$wrcInfo[$index]['planning_date'] = "Not Planned";
			$wrcInfo[$index]['planning_date'] = "Not Planned";

			$wrcInfo[$index]['shoot_hour'] = "Not Planned";
			$wrcInfo[$index]['studio'] = "Not Planned";
			$wrcInfo[$index]['model'] = "Not Planned";
			$wrcInfo[$index]['agency'] = "Not Planned";
			$wrcInfo[$index]['photographer'] = "Not Planned";
			$wrcInfo[$index]['makeupartist'] = "Not Planned";
			$wrcInfo[$index]['stylist'] = "Not Planned";
			$wrcInfo[$index]['assistant'] = "Not Planned";
			$wrcInfo[$index]['rawqc'] = "Not Planned";
			$wrcInfo[$index]['photographer_charges'] = "Not Planned";
			$wrcInfo[$index]['makeup_charges'] = "Not Planned";
			$wrcInfo[$index]['stylist_charges'] = "Not Planned";
			$wrcInfo[$index]['assistant_charges'] = "Not Planned";
			$wrcInfo[$index]['model_charges'] = "Not Planned";
			}
			$wrcInfo[$index]['singleskucom'] = $wrcs->com ;
			$wrcInfo[$index]['com'] = $skucom * $wrcs->com ;
			
			unset($wrcInfo[$index]['date']);
			unset($wrcInfo[$index]['plannins_detail']);
			$wrcInfo[$index] = array_values($wrcInfo[$index]);

	

		}
//  pr($wrcInfo,1);

		$dimensions = $this->getDimensions($this->spreadSheetId);


		$body = new Google_Service_Sheets_ValueRange([
			'values' => $wrcInfo
		]);


		$params = [
			'valueInputOption' => 'USER_ENTERED',
		];

		$range = "A" . ($dimensions['rowCount'] + 1);

		return $this->googleSheetService
		->spreadsheets_values
		->update($this->spreadSheetId, $range, $body, $params);

	}




	private function getDimensions($spreadSheetId){
		$rowDimensions = $this->googleSheetService->spreadsheets_values->batchGet(
			$spreadSheetId,
			['ranges' => 'Sheet1!A:A','majorDimension'=>'COLUMNS']
		);

        //if data is present at nth row, it will return array till nth row
        //if all column values are empty, it returns null
		$rowMeta = $rowDimensions->getValueRanges()[0]->values;
		if (! $rowMeta) {
			return [
				'error' => true,
				'message' => 'missing row data'
			];
		}
		$colDimensions = $this->googleSheetService->spreadsheets_values->batchGet(
			$spreadSheetId,
			['ranges' => 'Sheet1!1:1','majorDimension'=>'ROWS']
		);
        //if data is present at nth col, it will return array till nth col
        //if all column values are empty, it returns null
		$colMeta = $colDimensions->getValueRanges()[0]->values;
		if (! $colMeta) {
			return [
				'error' => true,
				'message' => 'missing row data'
			];
		}

		return [
			'error' => false,
			'rowCount' => count($rowMeta[0]),
			'colCount' => $this->colLengthToColumnAddress(count($colMeta[0]))
		];
	}



	private  function colLengthToColumnAddress($number)
	{
		if ($number <= 0) return null;

		$temp; $letter = '';
		while ($number > 0) {
			$temp = ($number - 1) % 26;
			$letter = chr($temp + 65) . $letter;
			$number = ($number - $temp - 1) / 26;
		}
		return $letter;
	}

}