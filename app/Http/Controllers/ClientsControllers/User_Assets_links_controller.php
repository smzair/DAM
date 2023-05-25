<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\CatalogAllocation;
use App\Models\CatalogSubmission;
use App\Models\CatalogUploadLinks;
use App\Models\CatalogWrcBatch;
use App\Models\CatlogWrc;
use App\Models\ClientActivityLog;
use App\Models\CreativeAllocation;
use App\Models\CreativeSubmission;
use App\Models\CreativeUploadLink;
use App\Models\CreativeWrcBatch;
use App\Models\CreatLots;
use App\Models\LotsCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User_Assets_links_controller extends Controller
{

	public function index()
	{
		$parent_client_id = $user_id = Auth::id();
		if (Auth::user()->dam_enable != 1) {
			request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
			return redirect()->route('home');
		}
		$roledata = getUsersRole($user_id);
		$role_name = "";
		$role_id = "";

		if ($roledata != null) {
			$role_id = $roledata->role_id;
			$role_name = $roledata->role_name;
		}
		$brand_arr = DB::table('brands_user')->where('user_id', $user_id)->get()->pluck('brand_id')->toArray();
		if ($role_name == 'Sub Client') {
			$parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
			$parent_client_id = $parent_user_data->parent_client_id;
		}


		// creative Lots Data.
		$lots_query = CreatLots::leftjoin('creative_wrc', 'creative_wrc.lot_id', 'creative_lots.id')->whereIn('creative_lots.brand_id', $brand_arr);
		$lots_query = $lots_query->select(
			'creative_wrc.lot_id',
			DB::raw('CASE WHEN creative_wrc.sku_required = 1 THEN creative_wrc.sku_count ELSE creative_wrc.order_qty END AS inward_quantity'),
			DB::raw('SUM(CASE WHEN creative_wrc.sku_required = 1 THEN creative_wrc.sku_count ELSE creative_wrc.order_qty END) AS inward_qty'),
			DB::raw('GROUP_CONCAT(creative_wrc.id) as wrc_ids'),
			DB::raw('GROUP_CONCAT(creative_wrc.sku_required) as sku_requireds'),
			DB::raw('GROUP_CONCAT(CONCAT(" ",`creative_wrc`.`wrc_number`)) as wrc_numbers'),
			'creative_lots.id',
			'creative_lots.user_id',
			'creative_lots.brand_id',
			'creative_lots.lot_number',
			'creative_lots.created_at as lot_created_at'
		)->where('user_id', $parent_client_id);
		$lots = $lots_query->groupBy('creative_lots.id');
		$lots = $lots_query->get()->toArray();

		$creative_lots = array();
		foreach ($lots as $key => $row) {
			$wrc_ids = $row['wrc_ids'];
			$sku_requireds = $row['sku_requireds'];
			$wrc_ids = $row['wrc_ids'];
			$submission_date = "";
			if($wrc_ids != '' && $wrc_ids != null){
				$wrc_id_arr = explode(',',$wrc_ids);

				$creative_wrc_batch_query = CreativeWrcBatch::wherein('wrc_id', $wrc_id_arr)->orderbydesc('created_at');
				$creative_wrc_batch_count = $creative_wrc_batch_query->count();
				
				$creative_submissions_query = CreativeSubmission::wherein('wrc_id', $wrc_id_arr)->orderbydesc('created_at');
				$creative_submissions_count = $creative_submissions_query->count();
				
				if($creative_wrc_batch_count == $creative_submissions_count && $creative_wrc_batch_count > 0){
					if($creative_submissions_count > 0){
						$creative_submissions = $creative_submissions_query->first()->toArray();
						$submission_date = $creative_submissions['submission_date'];
					}
				}
			}
			$lots[$key]['submission_date'] = $submission_date;
		}

		$creative_lots = $lots;

		// cataloging Lots Data. 
		$catalog_lots_query = LotsCatalog::leftjoin('catlog_wrc', 'catlog_wrc.lot_id', 'lots_catalog.id')->whereIn('lots_catalog.brand_id', $brand_arr);
		$catalog_lots_query = $catalog_lots_query->select(
			'catlog_wrc.lot_id',
			DB::raw('SUM(catlog_wrc.sku_qty) AS inward_qty'),
			DB::raw('GROUP_CONCAT(catlog_wrc.id) as wrc_ids'),
			DB::raw('GROUP_CONCAT(CONCAT(" ",`catlog_wrc`.`wrc_number`)) as wrc_numbers'),
			'lots_catalog.id',
			'lots_catalog.user_id',
			'lots_catalog.brand_id',
			'lots_catalog.lot_number',
			'lots_catalog.created_at as lot_created_at'
		)->where('user_id', $parent_client_id);
		$catalog_lots = $catalog_lots_query->groupBy('lots_catalog.id');
		$catalog_lots = $catalog_lots_query->get()->toArray();

		foreach ($catalog_lots as $key => $row) {
			$wrc_ids = $row['wrc_ids'];
			$wrc_ids = $row['wrc_ids'];
			$submission_date = "";
			if($wrc_ids != '' && $wrc_ids != null){
				$wrc_id_arr = explode(',',$wrc_ids);

				$catalog_wrc_batches_query = CatalogWrcBatch::wherein('wrc_id', $wrc_id_arr)->orderbydesc('created_at');
				$catalog_wrc_batches_count = $catalog_wrc_batches_query->count();
				
				$catalog_submissions_query = CatalogSubmission::wherein('wrc_id', $wrc_id_arr)->orderbydesc('created_at');
				$catalog_submissions_count = $catalog_submissions_query->count();
				
				if($catalog_wrc_batches_count == $catalog_submissions_count && $catalog_wrc_batches_count > 0){
					$submission_data = $catalog_submissions_query->get()->toArray();
					if($catalog_submissions_count > 0){
						$catalog_submissions = $catalog_submissions_query->first()->toArray();
						$submission_date = $catalog_submissions['submission_date'];
					}
				}
			}
			$catalog_lots[$key]['submission_date'] = $submission_date;
		}
		$catalog_lots_data = $catalog_lots;
    return view('clients.ClientAssetsLinks.your-assets-Links-Lots')->with('catalog_lots', $catalog_lots_data)->with('creative_lots', $creative_lots);

	}

	// your assets creative wrcs links
	public function your_assets_creative_wrcs_links($id){
		$lot_id = base64_decode($id);
		$parent_client_id = $user_id = Auth::id();
		if (Auth::user()->dam_enable != 1) {
			request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
			return redirect()->route('home');
		}
		$roledata = getUsersRole($user_id);
		$role_name = "";
		$role_id = "";

		if ($roledata != null) {
			$role_id = $roledata->role_id;
			$role_name = $roledata->role_name;
		}
		$brand_arr = DB::table('brands_user')->where('user_id', $user_id)->get()->pluck('brand_id')->toArray();
		if ($role_name == 'Sub Client') {
			$parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
			$parent_client_id = $parent_user_data->parent_client_id;
		}

		// creative Lots Data.
		$lots_query = CreatLots::leftjoin('creative_wrc', 'creative_wrc.lot_id', 'creative_lots.id')->
		leftjoin('create_commercial', 'create_commercial.id' , 'creative_wrc.commercial_id')->
		whereIn('creative_lots.brand_id', $brand_arr)->where('creative_wrc.lot_id','=',$lot_id);
		$lots_query = $lots_query->select(
			'creative_wrc.lot_id',
			'creative_wrc.sku_required',
			'creative_wrc.created_at as wrc_created_at', 
			DB::raw('CASE WHEN creative_wrc.sku_required = 1 THEN creative_wrc.sku_count ELSE creative_wrc.order_qty END AS inward_quantity'),
			DB::raw('SUM(CASE WHEN creative_wrc.sku_required = 1 THEN creative_wrc.sku_count ELSE creative_wrc.order_qty END) AS inward_qty'),
			DB::raw('GROUP_CONCAT(creative_wrc.id) as wrc_ids'),
			DB::raw('GROUP_CONCAT(creative_wrc.sku_required) as sku_requireds'),
			DB::raw('GROUP_CONCAT(CONCAT(" ",`creative_wrc`.`wrc_number`)) as wrc_numbers'),
			'create_commercial.kind_of_work as type_of_service',
			'create_commercial.per_qty_value',
			'creative_lots.id',
			'creative_lots.user_id',
			'creative_lots.brand_id',
			'creative_lots.lot_number',
			'creative_lots.project_name',
			'creative_lots.created_at as lot_created_at' 
		)->where('creative_lots.user_id', $parent_client_id);
		$lots_query = $lots_query->groupBy('creative_wrc.id');
		$creative_lots = $lots_query->get()->toArray();
		// dd($creative_lots);

		if(count($creative_lots) > 0){
			foreach ($creative_lots as $key => $row) {
				$wrc_ids = $row['wrc_ids'];
				$submission_date = "";
				$upload_links = array();
				$submition_qty = 0;
				if($wrc_ids != '' && $wrc_ids != null){
					$wrc_id_arr = explode(',',$wrc_ids);
					$sku_required = $row['sku_required'];
					
					// code for get links
					$creative_allocation_query = CreativeAllocation::wherein('wrc_id', $wrc_id_arr)->orderbydesc('created_at');
					$creative_allocation_count = $creative_allocation_query->count();
					if($creative_allocation_count > 0){
						$creative_allocation_ids = $creative_allocation_query->pluck('id')->toArray();
						
						$creative_upload_links_query = CreativeUploadLink::wherein('allocation_id', $creative_allocation_ids)->orderbydesc('created_at');
						$creative_upload_links_count = $creative_upload_links_query->count();
						if($creative_upload_links_count > 0){
							$upload_links = $creative_upload_links_query->get()->toArray();
						}
					}

					// for submission date
					
					$creative_submissions_query = CreativeSubmission::wherein('wrc_id', $wrc_id_arr)->orderbydesc('created_at');
					$creative_submissions_count = $creative_submissions_query->count();
					
					
					if($creative_submissions_count > 0){
						$creative_submissions_batch_no = $creative_submissions_query->pluck('batch_no')->toArray();
						$creative_wrc_batch_query = CreativeWrcBatch::wherein('wrc_id', $wrc_id_arr)->wherein('batch_no', $creative_submissions_batch_no)->orderbydesc('created_at');

						$creative_wrc_batch_count = $creative_wrc_batch_query->count();

						$creative_wrc_batch_data = $creative_wrc_batch_query->get()->toArray();

						if($sku_required == 1){
							$submisstin_qtu_arr = array_column($creative_wrc_batch_data, 'sku_count');
						}else{
							$submisstin_qtu_arr = array_column($creative_wrc_batch_data, 'order_qty');
						}
						$submition_qty += array_sum($submisstin_qtu_arr);
					}
				}
				$creative_lots[$key]['submission_date'] = $submission_date;
				$creative_lots[$key]['upload_links'] = $upload_links;
				$creative_lots[$key]['submition_qty'] = $submition_qty;
			}
		}
		// dd($creative_lots);
    return view('clients.ClientAssetsLinks.your-assets-Links-creative')->with('lot_links', $creative_lots);

	}

	// your assets cataloging wrcs links 
	public function your_assets_cataloging_wrcs_links($id)
	{
		$lot_id = base64_decode($id);
		$parent_client_id = $user_id = Auth::id();
		if (Auth::user()->dam_enable != 1) {
			request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
			return redirect()->route('home');
		}
		$roledata = getUsersRole($user_id);
		$role_name = "";
		$role_id = "";

		if ($roledata != null) {
			$role_id = $roledata->role_id;
			$role_name = $roledata->role_name;
		}

		$brand_arr = DB::table('brands_user')->where('user_id', $user_id)->get()->pluck('brand_id')->toArray();
		if ($role_name == 'Sub Client') {
			$parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
			$parent_client_id = $parent_user_data->parent_client_id;
		}


		$catalog_lots_query = LotsCatalog::leftjoin('catlog_wrc', 'catlog_wrc.lot_id', 'lots_catalog.id')->
		leftjoin('create_commercial_catalog','create_commercial_catalog.id', 'catlog_wrc.commercial_id')->
		whereIn('lots_catalog.brand_id', $brand_arr)->where('lots_catalog.user_id', $parent_client_id)->where('catlog_wrc.lot_id' , $lot_id);
		$catalog_lots_query = $catalog_lots_query->select(
			'catlog_wrc.lot_id',
			DB::raw('SUM(catlog_wrc.sku_qty) AS inward_qty'),
			DB::raw('GROUP_CONCAT(catlog_wrc.id) as wrc_ids'),
			DB::raw('GROUP_CONCAT(CONCAT(" ",`catlog_wrc`.`wrc_number`)) as wrc_numbers'),
			'catlog_wrc.created_at as wrc_created_at',
			'create_commercial_catalog.CommercialSKU as per_qty_value',
			'create_commercial_catalog.type_of_service',
			'lots_catalog.id',
			'lots_catalog.user_id',
			'lots_catalog.brand_id',
			'lots_catalog.lot_number',
			'lots_catalog.serviceType',
			'lots_catalog.created_at as lot_created_at'
		);
		$catalog_lots = $catalog_lots_query->groupBy('catlog_wrc.id');
		$catalog_lots = $catalog_lots_query->get()->toArray();

		foreach ($catalog_lots as $key => $row) {
			$wrc_ids = $row['wrc_ids'];
			$wrc_ids = $row['wrc_ids'];
			$submission_date = "";
			$submition_qty = 0;
			$catalog_upload_links = array();
			$copy_upload_links = array();

			if($wrc_ids != '' && $wrc_ids != null){
				$wrc_id_arr = explode(',',$wrc_ids);

				$catalog_submissions_query = CatalogSubmission::wherein('wrc_id', $wrc_id_arr)->orderbydesc('created_at');
				$catalog_submissions_count = $catalog_submissions_query->count();
				if($catalog_submissions_count > 0){
					$submissions_batch_no = $catalog_submissions_query->pluck('batch_no')->toArray();
					$submition_qty = CatalogWrcBatch::wherein('wrc_id', $wrc_id_arr)->wherein('batch_no', $submissions_batch_no)->orderbydesc('created_at')->sum('sku_count');
				}

				// code for get links
				$catalog_allocation = CatalogAllocation::wherein('wrc_id', $wrc_id_arr)->where('user_role' , '=', '0')->orderbydesc('created_at');
				$allocation_count = $catalog_allocation->count();
				if($allocation_count > 0){

					$catalog_allocation_ids = $catalog_allocation->pluck('id')->toArray();
					$creative_upload_links_query = CatalogUploadLinks::wherein('allocation_id', $catalog_allocation_ids)->orderbydesc('created_at');
					$creative_upload_links_count = $creative_upload_links_query->count();
					if($creative_upload_links_count > 0){
						$catalog_upload_links = $creative_upload_links_query->pluck('final_link')->toArray();
					}
				}
				
				$copy_allocation = CatalogAllocation::wherein('wrc_id', $wrc_id_arr)->where('user_role' , '=', '1')->orderbydesc('created_at');
				$copy_allocation_count = $copy_allocation->count();
				if($copy_allocation_count > 0){

					$copy_allocation_ids = $copy_allocation->pluck('id')->toArray();
					$creative_upload_links_query = CatalogUploadLinks::wherein('allocation_id', $copy_allocation_ids)->orderbydesc('created_at');
					$copy_allocation_count = $creative_upload_links_query->count();
					if($copy_allocation_count > 0){
						$copy_upload_links = $creative_upload_links_query->pluck('final_link')->toArray();
					}
				}

			}
			$catalog_lots[$key]['submission_date'] = $submission_date;
			$catalog_lots[$key]['submition_qty'] = $submition_qty;
			$catalog_lots[$key]['catalog_upload_links'] = $catalog_upload_links;
			$catalog_lots[$key]['copy_upload_links'] = $copy_upload_links;
		}
		// dd($catalog_lots);
    return view('clients.ClientAssetsLinks.your-assets-Links-cataloging')->with('lot_links', $catalog_lots);
		
	}
}
