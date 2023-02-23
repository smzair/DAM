<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreativeSubmission extends Model
{
    use HasFactory;
    /**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'creative_submissions';
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable=['wrc_id', 'submission_date'];

	public static function readyForSubmission(){
		$resData = CreativeTimeHash::orderBy('creative_time_hash.id','DESC')
		->leftJoin('creative_allocation', 'creative_allocation.id','creative_time_hash.allocation_id')
		->leftJoin('users', 'users.id','creative_allocation.user_id')
		->leftJoin('creative_wrc_batch', function($join){
			$join->on('creative_wrc_batch.wrc_id', '=', 'creative_allocation.wrc_id');
			$join->on('creative_wrc_batch.batch_no', '=', 'creative_allocation.batch_no');
		})
		->leftJoin('creative_wrc', 'creative_wrc.id','creative_allocation.wrc_id')
		->leftJoin('create_commercial', 'create_commercial.id','creative_wrc.commercial_id')
		->leftJoin('creative_lots', 'creative_lots.id','creative_wrc.lot_id')
		->leftJoin('brands', 'brands.id','creative_lots.brand_id')
		->leftJoin('creative_upload_links', 'creative_upload_links.allocation_id','creative_allocation.id')
		->leftJoin('creative_submissions', function($join){
			$join->on('creative_submissions.wrc_id', '=', 'creative_allocation.wrc_id');
			$join->on('creative_submissions.batch_no', '=', 'creative_allocation.batch_no');
		})
		
		
		->select(
			'creative_upload_links.creative_link as creative_links',
			'creative_upload_links.copy_link as copy_links',
			'creative_time_hash.start_time as start_time',
			'users.Company as company_name',
			'brands.name as brand_name',
			'creative_lots.client_bucket',
			'creative_lots.lot_number',
			'creative_wrc.wrc_number',
			'create_commercial.project_name',
			'create_commercial.kind_of_work',
			'creative_wrc.order_qty',
			'creative_wrc.sku_count',
			'creative_wrc_batch.wrc_id as wrc_id',
			'creative_wrc_batch.batch_no as batch_no',
			'creative_wrc_batch.order_qty as batch_order_qty',
			'creative_wrc_batch.sku_count as batch_sku_count'
		)
		->where('creative_time_hash.task_status','=',2)
		->groupBy(['creative_wrc_batch.wrc_id','creative_wrc_batch.batch_no'])
		// ->where('creative_submissions.wrc_id','!=','creative_allocation.wrc_id')
		->get();
		// dd($resData);
		return $resData;
	}	

	public static function SubmissionDone(){
		$resData = CreativeTimeHash::orderBy('creative_time_hash.id','DESC')
		->leftJoin('creative_allocation', 'creative_allocation.id','creative_time_hash.allocation_id')
		->leftJoin('users', 'users.id','creative_allocation.user_id')
		->leftJoin('creative_wrc_batch', function($join){
			$join->on('creative_wrc_batch.wrc_id', '=', 'creative_allocation.wrc_id');
			$join->on('creative_wrc_batch.batch_no', '=', 'creative_allocation.batch_no');
		})
		->leftJoin('creative_wrc', 'creative_wrc.id','creative_allocation.wrc_id')
		->leftJoin('create_commercial', 'create_commercial.id','creative_wrc.commercial_id')
		->leftJoin('creative_lots', 'creative_lots.id','creative_wrc.lot_id')
		->leftJoin('brands', 'brands.id','creative_lots.brand_id')
		->leftJoin('creative_upload_links', 'creative_upload_links.allocation_id','creative_allocation.id')
		->leftJoin('creative_submissions', function($join){
			$join->on('creative_submissions.wrc_id', '=', 'creative_allocation.wrc_id');
			$join->on('creative_submissions.batch_no', '=', 'creative_allocation.batch_no');
		})
		
		->select(
			'creative_upload_links.creative_link as creative_links',
			'creative_upload_links.copy_link as copy_links',
			'creative_time_hash.start_time as start_time',
			'users.Company as company_name',
			'brands.name as brand_name',
			'creative_lots.client_bucket',
			'creative_lots.lot_number',
			'creative_wrc.wrc_number',
			'create_commercial.project_name',
			'create_commercial.kind_of_work',
			'creative_wrc.order_qty',
			'creative_wrc.sku_count',
			'creative_wrc_batch.wrc_id as wrc_id',
			'creative_wrc_batch.batch_no as batch_no',
			'creative_wrc_batch.order_qty as batch_order_qty',
			'creative_wrc_batch.sku_count as batch_sku_count',
			'creative_submissions.id  as creative_submissions_id'
		)
		->where('creative_submissions.Status',1)
		// ->where('creative_submissions.wrc_id','=','creative_allocation.wrc_id')
		
		->get();
		// dd($resData);
		return $resData;
	}

	public static function ApprovalRejectionList(){
		$resData = CreativeTimeHash::orderBy('creative_time_hash.id','DESC')
		->leftJoin('creative_allocation', 'creative_allocation.id','creative_time_hash.allocation_id')
		->leftJoin('users', 'users.id','creative_allocation.user_id')
		->leftJoin('creative_wrc_batch', function($join){
			$join->on('creative_wrc_batch.wrc_id', '=', 'creative_allocation.wrc_id');
			$join->on('creative_wrc_batch.batch_no', '=', 'creative_allocation.batch_no');
		})
		->leftJoin('creative_wrc', 'creative_wrc.id','creative_allocation.wrc_id')
		->leftJoin('create_commercial', 'create_commercial.id','creative_wrc.commercial_id')
		->leftJoin('creative_lots', 'creative_lots.id','creative_wrc.lot_id')
		->leftJoin('brands', 'brands.id','creative_lots.brand_id')
		->leftJoin('creative_upload_links', 'creative_upload_links.allocation_id','creative_allocation.id')
		->leftJoin('creative_submissions', function($join){
			$join->on('creative_submissions.wrc_id', '=', 'creative_allocation.wrc_id');
			$join->on('creative_submissions.batch_no', '=', 'creative_allocation.batch_no');
		})
		
		->select(
			'creative_upload_links.creative_link as creative_links',
			'creative_upload_links.copy_link as copy_links',
			'creative_time_hash.start_time as start_time',
			'users.Company as company_name',
			'users.am_email as am_email',
			'brands.name as brand_name',
			'creative_lots.client_bucket',
			'creative_lots.lot_number',
			'creative_lots.client_bucket',
			'creative_wrc.wrc_number',
			'create_commercial.project_name',
			'create_commercial.kind_of_work',
			'creative_wrc.order_qty',
			'creative_wrc.sku_count',
			'creative_wrc_batch.wrc_id as wrc_id',
			'creative_wrc_batch.batch_no as batch_no',
			'creative_wrc_batch.order_qty as batch_order_qty',
			'creative_wrc_batch.sku_count as batch_sku_count',
			'creative_submissions.id  as creative_submissions_id'
		)
		->where('creative_submissions.Status',1)
		// ->where('creative_submissions.wrc_id','=','creative_allocation.wrc_id')
		->groupBy(['wrc_id','batch_no'])
		->get();
		// dd($resData);
		return $resData;
	}

	 //GET  CREATIVE WRC DETAIL (Master Sheet) 
	public static function getCreativeWrcDetails(){

		$resData = [];
		$resData =  CreativeWrcModel::OrderBy('creative_wrc.id','DESC')
       ->leftJoin('creative_lots', 'creative_lots.id', 'creative_wrc.lot_id')
       ->leftJoin('users', 'users.id', 'creative_lots.user_id')
       ->leftJoin('brands', 'brands.id', 'creative_lots.brand_id')
	   ->leftJoin('creative_allocation', 'creative_allocation.wrc_id','creative_wrc.id')
	   ->leftJoin('create_commercial', 'create_commercial.id','creative_wrc.commercial_id')
	   ->leftJoin('creative_wrc_batch', function($join){
		$join->on('creative_wrc_batch.wrc_id', '=', 'creative_wrc.id');
		// $join->on('creative_wrc_batch.batch_no', '=', 'creative_allocation.batch_no');
		})
		->leftJoin('creative_submissions', function($join){
			$join->on('creative_submissions.wrc_id', '=', 'creative_allocation.wrc_id');
			$join->on('creative_submissions.batch_no', '=', 'creative_allocation.batch_no');
		})
		->leftJoin('creative_time_hash', 'creative_time_hash.allocation_id', 'creative_allocation.id')
       ->select('creative_wrc.*','creative_lots.user_id','creative_lots.brand_id','creative_lots.lot_number','users.Company as Company_name','brands.name','creative_lots.client_bucket','create_commercial.project_name','create_commercial.kind_of_work','create_commercial.per_qty_value','creative_wrc_batch.work_initiate_date','creative_wrc_batch.work_committed_date','creative_submissions.submission_date','creative_submissions.status as submission_status','creative_allocation.wrc_id as submission_wrc_id','creative_allocation.id as allocation_id','creative_allocation.batch_no as submission_batch_no','creative_wrc_batch.work_initiate_date', 'creative_wrc_batch.work_committed_date','creative_lots.lot_delivery_days','creative_lots.id as lot_id','creative_wrc_batch.wrc_id as batch_wrc_id','creative_wrc_batch.batch_no','creative_time_hash.task_status')
	   ->groupBy('creative_wrc_batch.wrc_id')
       ->groupBy('creative_wrc_batch.batch_no')
	//    ->groupBy(['creative_wrc_batch.wrc_id','creative_wrc_batch.batch_no'])
       ->get();
        // dd($resData);

		foreach($resData as $key => $val){
			$task_type_data = DB::table('creative_submissions')->where('wrc_id', $val['submission_wrc_id'])->where('batch_no', $val['submission_batch_no'])->where('Status',1)->first(['wrc_id']);

			$wrc_id = $task_type_data != null ? $task_type_data->wrc_id : 0;

			$sku_order_qty_data = DB::table('creative_wrc')->where('id', $wrc_id)->first(['order_qty', 'sku_count']);

			$order_qty = $sku_order_qty_data != null ? $sku_order_qty_data->order_qty : 0 ; 
			$sku_qty = $sku_order_qty_data != null ? $sku_order_qty_data->sku_count : 0 ; 


			$sku_order_qty = $sku_qty > 0 ? $sku_qty : $order_qty;

			// dd($sku_order_qty);

			$val['sku_order_qty'] = $sku_order_qty;

			$time_hash_data = CreativeTimeHash::where('id',$val['allocation_id'])->first(['is_rework']);
			$is_rework = $time_hash_data != null ? $time_hash_data->is_rework : 0 ;

			$fta = $is_rework > 0 ? 'NFTA' : 'FTA';
			$val['fta']  = $fta;

			$lot_delivery_days = $val['lot_delivery_days'];
			$work_initiate_date = $val['work_initiate_date'];
			$work_committed_date = $val['work_committed_date'];

			$date1 = new DateTime($work_initiate_date);
			$date2 = new DateTime($work_committed_date);
			$interval = $date1->diff($date2);
			// echo $interval->days;

			$total_days = $interval->days;

			$tat_diff = $lot_delivery_days - $total_days ;

			$tat_status = $tat_diff > 0 ?  'Within TAT' : 'TAT Breached';

			$val['tat_status']  = $tat_status;

			// dd($interval->days);

			$wrc_created_at = $val['created_at'];
			$today_date = Carbon::now();

			$date11 = new DateTime($wrc_created_at);
			$date22 = new DateTime($today_date);
			$interval1 = $date11->diff($date22);
			// echo $interval1->days;
			
			// dd($interval1->days);

			$ageing = $interval1->days;

			$val['ageing']  = $ageing;

			$lot_status = "--";

			$lot_id = $val['lot_id'];

			$creative_wrc_count = DB::table('creative_wrc')->where('lot_id',$lot_id)->count();

			// dd($creative_wrc_count);

			$lot_status = $creative_wrc_count > 0 ? 'Allocation Pending' : 'Inverd Pending';


			$val['lot_status']  = $lot_status;
			
			if($lot_status == 'Allocation Pending'){
				$creative_allocation_count = DB::table('creative_allocation')->where('wrc_id',$val['batch_wrc_id'])->where('batch_no',$val['batch_no'])->count();
				// dd($creative_allocation_count);
				$lot_status = $creative_allocation_count > 0 ? 'Uploading Pending' : 'Allocation Pending';
				// dd($lot_status );
				$val['lot_status']  = $lot_status;
			}

			if($lot_status == 'Uploading Pending'){
				if($val['qc_status'] == 0){
					$lot_status = 'Qc Pending';
					$val['lot_status']  = 'Qc Pending';
				}
			}

			if($lot_status == 'Qc Pending'){
				$submission_status = $val['submission_status'];

				$lot_status = $submission_status  == 0 ? 'Submission Pending' : 'Submitted';
				$val['lot_status']  = $lot_status;
			}

		}

		return $resData;

	}
}
