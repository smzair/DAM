@extends('layouts.DamNewMain')
@section('title')
  Client Catalog-Lot-Timeline
@endsection

@section('main_content')

{{-- <style>
	.card-div{
		width: 100%;
		padding: 5px 20px;
		border: 2px solid rgba(203, 190, 190, 0.584);
		box-shadow: rgb(170, 170, 170) 4px 4px 10px;
		position: absolute;
		border-radius: 4px;
		background: rgb(246, 243, 243);
		color: rgb(51, 51, 51);
		z-index: 99999;
	}
</style> --}}

<style>
	.hoverpopover {
		/* display: none; */
		position: absolute;
		background: #0F0F0F;
		border: 1px solid #333333;
		box-shadow: 6px 24px 60px rgba(255, 255, 255, 0.06);
		z-index: 1;
		width: 620px !important;
		/* Set the width of the popover */
		top: 328px;
		left: 411px;
	}

	/* CSS for the popover text */
	.popover-text {
		padding: 10px;
	}

	/* CSS for the text element */

	.text {
		cursor: pointer;
		position: relative;
		display: inline-block;
	}

	.upper-head-style-for-track-hover {
  margin-top: -11px;
  margin-left: -11px;
  margin-right: -11px;
  background: #1A1A1A;
}

.track-lot-table-wrc-no {
  font-weight: 500;
  font-size: 16px;
  color: #FFFFFF;
  letter-spacing: 0.15px;
}

.track-lot-table-wrc-date {
  font-weight: 400;
  font-size: 14px;
  color: #808080;
  line-height: 0.1;
}

.track-lot-table-inward-qty {
  font-weight: 500;
  font-size: 14px;
  color: #808080;
}

.track-lot-table-inward-qty-no {
  font-weight: 700;
  font-size: 16px;
  color: #FFFFFF;
  line-height: 0.1;
}

.track-lot-table-typeof-service {
  font-weight: 500;
  font-size: 14px;
  color: #808080;
}

.track-lot-table-marketplace-pri-mode {
  font-weight: 400;
  font-size: 16px;
  color: #FFFFFF;
  text-align: left;
}

.track-lot-adaptation-under {
  font-weight: 400;
  font-size: 16px;
  color: #FFFFFF;
  padding: 8px;
  background: #333333;
}

	.track-lot-table-marketplace-pri-mode{
		word-wrap: break-word;
	}
</style>
<div class="row">
	<div class="col-12">
		<a class="btn btn-light border-0 back-btn" href="{{ url()->previous() }}" role="button"><svg width="22" height="14"
				viewBox="0 0 22 14" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M6.69628 1.5L1 7L6.69628 12.5M21 7H1.15953" stroke="#9F9F9F" stroke-width="1.5"
					stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
			&nbsp; back</a>
	</div>
	<div class="col-12 d-flex justify-content-between">
		<div>
			<h2 class="lot-no-sty">Lot no: {{$lot_detail[0] != null ? $lot_detail[0]['lot_number'] : "-"}}</h2>
			<p class="lot-date-sty">Lot date: {{$lot_detail[0] != null ? dateFormet_dmy($lot_detail[0]['created_at']) : "-"}}</p>
		</div>
		<p class="inward-sty">Inward Quantity: {{$lot_detail[0] != null ? $lot_detail[0]['inward_quantity'] : "-"}}</p>
	</div>
	<div class="col-12 mt-4">
		<div class="row">
			<div class="col-lg-1 mt-3      ">
				<p style="font-weight: 500;font-size: 16px;color: #9F9F9F;">Status:</p>
				<p style="font-weight: 700;font-size: 16px;color: #9F9F9F;">{{$lot_detail[0] != null ? $lot_detail[0]['overall_progress'] : "20%"}}</p>
			</div>
			<div class="col-lg-11">
				<div class="progress-box">
					<div class="progress-labels">
						<div class="progress-label progress-label-1">
							<p class="progress-upper-heading">Inward</p>
						</div>
						<div class="progress-label progress-label-2">
							<p class="progress-upper-heading">WRC Generated</p>
						</div>
						<div class="progress-label progress-label-3">
							<p class="progress-upper-heading">Task Assigned</p>
						</div>
						<div class="progress-label progress-label-4">
							<p class="progress-upper-heading">Editing & QC</p>
						</div>
						<div class="progress-label progress-label-5">
							<p class="progress-upper-heading">Submissions</p>
						</div>
					</div>
					<div class="progress">
						<div class="progress-bar progress-bar-1" role="progressbar_new" style="width: 20%;" aria-valuenow="20"
							aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-2" role="progressbar_new" style="width: {{$lot_detail[0] != null ? $lot_detail[0]['wrc_progress'] : '0%'}};" aria-valuenow="40"
							aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-3" role="progressbar_new" style="width: {{$lot_detail[0] != null ? $lot_detail[0]['wrc_assign'] : '0%'}};" aria-valuenow="60"
							aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-4" role="progressbar_new" style="width: {{$lot_detail[0] != null ? $lot_detail[0]['wrc_qc'] : '0%'}};" aria-valuenow="80"
							aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-5" role="progressbar_new" style="width: {{$lot_detail[0] != null ? $lot_detail[0]['wrc_submission'] : '0%'}};" aria-valuenow="100"
							aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<div class="progress-labels">
						<div class="progress-label progress-label-1">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['created_at']) && $lot_detail[0]['created_at'] != null ? dateFormet_dmy($lot_detail[0]['created_at']) : "-"}}</p>
						</div>
						<div class="progress-label progress-label-2">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['wrc_created_at']) && $lot_detail[0]['wrc_created_at'] != null ? dateFormet_dmy($lot_detail[0]['wrc_created_at']) : "-"}}</p>
						</div>
						<div class="progress-label progress-label-3">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['allocated_created_at']) && $lot_detail[0]['allocated_created_at'] != null ? dateFormet_dmy($lot_detail[0]['allocated_created_at']) : "-"}}</p>
						</div>
						<div class="progress-label progress-label-4">
							<p class="progress-bottom-heading">{{ isset($lot_detail[0]['qc_done_at']) && $lot_detail[0]['qc_done_at'] != null ? dateFormet_dmy($lot_detail[0]['qc_done_at']) : "-"}}</p>
						</div>
						<div class="progress-label progress-label-5">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['submission_date']) && $lot_detail[0]['submission_date'] != null ? dateFormet_dmy($lot_detail[0]['submission_date']) : "-"}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="col-12 mt-4 table-responsive">
		<table class="table border-light">
			<thead>
				<tr>
					<th scope="col" class="table-heading-sty">WRC No.</th>
					<th scope="col" class="table-heading-sty">Date</th>
					<th scope="col" class="table-heading-sty">Quantity</th>
					<th scope="col" class="table-heading-sty">Uploading & QC</th>
					<th scope="col" class="table-heading-sty">Submissions</th>
					<th scope="col" class="table-heading-sty">Final Links</th>
					<th scope="col" class="table-heading-sty">Invoice</th>
				</tr>
			</thead>
			<tbody>
				@php
    			$creative_and_cataloging_lot_statusArr = creative_and_cataloging_lot_statusArr();
				@endphp
				@if ($lot_detail[0]['lot_status'] != $creative_and_cataloging_lot_statusArr[0])
					@foreach ($wrc_detail as $wrc_index => $wrc_row)
						<tr>
							<td class="table-column" >
								<p style="cursor: pointer;" onmouseover="showPopover(this)" onmouseout="hidePopover(this)">
									{{$wrc_row['wrc_number']}}
								</p>
								<div class="hoverpopover card-div" style="display: none" id="wrcInfo{{$wrc_index}}">
									<div class="popover-text">

										<div class="upper-head-style-for-track-hover">
											<div class="upper-heading-wrc-details-table pt-4">
												<div class="col-12 d-flex justify-content-between ps-4 pe-4">
													<div>
														<p class="track-lot-table-wrc-no">{{$wrc_row['wrc_number']}}</p>
														<p class="track-lot-table-wrc-date text-start">{{dateFormet_dmy($wrc_row['wrc_created_at'])}}</p>
													</div>
													<div>
														<p class="track-lot-table-inward-qty">Inward Quantity</p>
														<p class="track-lot-table-inward-qty-no text-start">{{$wrc_row['wrc_order_qty']}}</p>
													</div>
												</div>
											</div>
										</div>

										<div class="lower-wrc-details-table mt-4">
											<div class="col-12 d-flex justify-content-between ps-3 pe-3">
												<div class="row">
													<div class="col-6">
														<p class="track-lot-table-typeof-service text-start">Type of service</p>
														<p class="track-lot-table-marketplace-pri-mode text-start">{{$wrc_row['type_of_service']}}</p>
													</div>

													<div class="col-3">
														<p class="track-lot-table-typeof-service text-start">Commercial (Per SKU)</p>
														<p class="track-lot-table-marketplace-pri-mode text-start">{{$wrc_row['CommercialSKU']}}</p>
													</div>
													<div class="col-3">
														<p class="track-lot-table-typeof-service text-start">Mode of delivery</p>
														<p class="track-lot-table-marketplace-pri-mode text-start">{{$wrc_row['modeOfDelivary']}}</p>
													</div>

												</div>
											</div>
										</div>
										<div class="col-12 ps-3 mt-4">
											<p class="track-lot-table-typeof-service text-start">
												Marketplaces
											</p>
										</div>
										<div class="col-12 d-flex ps-3 text-start">
											@foreach ($wrc_row['market_place_array'] as $item)
												<p class="track-lot-adaptation-under">{{$item}}</p> &nbsp;&nbsp;&nbsp;&nbsp;
											@endforeach
											{{-- <p class="track-lot-adaptation-under">Myntra_premium</p> &nbsp;&nbsp;&nbsp; &nbsp; --}}
										</div>
									</div>
								</div>
								{{-- <div class="card-div d-none" id="wrcInfo{{$wrc_index}}">
									<div class="row">
										<div class="col-sm-8">
											{{$wrc_row['wrc_number']}}
										</div>
										<div class="col-sm-4" style="text-align: right">
											Quantity
										</div>
										<div class="col-sm-8">
											{{dateFormet_dmy($wrc_row['wrc_created_at'])}}
										</div>
										<div class="col-sm-4" style="text-align: right">
											{{$wrc_row['wrc_order_qty']}}
										</div>
										<div class="col-sm-12">Project name</div>
										<div class="col-sm-12"></div>
									</div>
								</div> --}}
							</td>
							<td class="table-column">{{dateFormet_dmy($wrc_row['wrc_created_at'])}}</td>
							<td class="table-column">{{$wrc_row['wrc_order_qty']}}</td>
							<td class="table-column">{{$wrc_row['qc_status'] == 'Done' ? $wrc_row['cata_sum'] : '-'}}</td>
							<td class="table-column table-invoice">{{$wrc_row['submission_status']}}</td>
							<td class="table-column" style="position: relative;">
								<button style="padding: 5px"onclick="showhideli({{$wrc_index}} , 'link')">View Links</button>
								<div class="card-div d-none" id="wrcLink{{$wrc_index}}">
									<div class="row">
										@php
											$final_links = $wrc_row['final_links'];
											$final_links_arr = explode(",",$final_links);                                
											$tot_final_links = count($final_links_arr);
										@endphp
										<div class="col-sm-12">
											@if ($tot_final_links > 0 && $final_links != '' && $final_links != null )
												@foreach ($final_links_arr as $final_links_data)
													<p  class="m-0 p-0" style="white-space: pre-wrap; word-wrap: break-word;">
														<a href="{{$final_links_data}}" target="_blank" rel="noopener noreferrer">{{$final_links_data}}</a>
													</p>
												@endforeach
											@else
													<p class="m-0 p-0">No links available</p>
											@endif

										</div>
									</div>
								</div>

							</td>
							<td class="table-column table-invoice">{{$wrc_row['invoiceNumber']}}</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="7"> WRC not generated</td>
					</tr>
			@endif
			</tbody>
		</table>
	</div>
	<div class="col-12 d-flex justify-content-between last-btn-div">
		<div class="d-flex last-button-mar">
		</div>
		<div class="download-invoice">
			<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<rect width="20" height="20" fill="#9F9F9F" />
				<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
				<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
			</svg>
			&nbsp; <a href="#" class="download-invoice"> Download Invoices</a>
		</div>
	</div>
</div>

@endsection

{{-- Other Js pluging   --}}
@section('js_links')
  <script type="text/javascript" src=""></script>
@endsection

@section('js_scripts')
	<script>
		function showhideli(val , click_event = 'link'){
			let newElement = $('#wrcInfo'+val);
			if(click_event == 'link'){
				newElement = $('#wrcLink'+val);
			}
			let hasClass = newElement.hasClass('d-none')
			let myElement = $('.card-div');
			myElement.addClass('d-none');
			if(hasClass){
				newElement.removeClass('d-none');
			}
		}
	</script>

<script>
	// JavaScript functions to show and hide the popover
	function showPopover(element) {
		var popover = element.nextElementSibling;
		popover.style.display = 'block';
	}

	function hidePopover(element) {
		var popover = element.nextElementSibling;
		popover.style.display = 'none';
	}
</script>
@endsection
