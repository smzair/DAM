@extends('layouts.DamNewMain')
@section('title')
  Client Creative-Lot-Timeline
@endsection

@section('main_content')

<style>
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
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['created_at']) && $lot_detail[0]['created_at'] != null  ? dateFormet_dmy($lot_detail[0]['created_at']) : "-"}}</p>
						</div>
						<div class="progress-label progress-label-2">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['wrc_created_at']) && $lot_detail[0]['wrc_created_at'] != null && $lot_detail[0]['overall_progress'] > '20%' ? dateFormet_dmy($lot_detail[0]['wrc_created_at']) : "-"}}</p>
						</div>
						<div class="progress-label progress-label-3">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['allocated_created_at']) && $lot_detail[0]['allocated_created_at'] != null  && $lot_detail[0]['overall_progress'] > '40%' ? dateFormet_dmy($lot_detail[0]['allocated_created_at']) : "-"}}</p>
						</div>
						<div class="progress-label progress-label-4">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['qc_done_at']) && $lot_detail[0]['qc_done_at'] != null  && $lot_detail[0]['overall_progress'] > '60%' ? dateFormet_dmy($lot_detail[0]['qc_done_at']) : "-"}}</p>
						</div>
						<div class="progress-label progress-label-5">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['submission_date']) && $lot_detail[0]['submission_date'] != null  && $lot_detail[0]['overall_progress'] == '100%' ? dateFormet_dmy($lot_detail[0]['submission_date']) : "-"}}</p>
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
							<td class="table-column" style="position: relative;">
								<p style="cursor: pointer;" onclick="showhideli({{$wrc_index}} , 'wrc')">
									{{$wrc_row['wrc_number']}}
								</p>
								<div class="card-div d-none" id="wrcInfo{{$wrc_index}}">
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
								</div>
							</td>
							<td class="table-column">{{dateFormet_dmy($wrc_row['wrc_created_at'])}}</td>
							<td class="table-column">{{$wrc_row['wrc_order_qty']}}</td>
							<td class="table-column">{{$wrc_row['qc_status'] == 'Done' ? $wrc_row['gd_sum'] : '-'}}</td>
							<td class="table-column table-invoice">{{$wrc_row['submission_status']}}</td>
							<td class="table-column" style="position: relative;">
								<button style="padding: 5px"onclick="showhideli({{$wrc_index}} , 'link')">View Links</button>
								<div class="card-div d-none" id="wrcLink{{$wrc_index}}">
									<div class="row">
										@php
											$creative_link = $wrc_row['creative_link'];
											$creative_link_arr = explode(",",$creative_link);                                
											$tot_creative_link = count($creative_link_arr);
										@endphp									
										<div class="col-sm-12">
											<strong>Creative links</strong>
											@if ($tot_creative_link > 0 && $creative_link != '' && $creative_link != null )
												@foreach ($creative_link_arr as $creative_link_data)
													<p  class="m-0 pb-1" style="word-wrap: break-word;">
														<a href="{{$creative_link_data}}" target="_blank" rel="noopener noreferrer">{{$creative_link_data}}</a>
													</p>
												@endforeach
											@else
												<p class="m-0 p-0">No links available</p>
											@endif										
										</div>

										@php
											$copy_links = $wrc_row['copy_links'];
											$copy_links_arr = explode(",",$copy_links);                                
											$tot_copy_links = count($copy_links_arr);
										@endphp									
										<div class="col-sm-12">
											<strong>Copy links</strong>
											@if ($tot_copy_links > 0 && $copy_links != '' && $copy_links != null )
												@foreach ($copy_links_arr as $copy_links_data)
													<p  class="m-0 pb-1" style="word-wrap: break-word;">
														<a href="{{$copy_links_data}}" target="_blank" rel="noopener noreferrer">{{$copy_links_data}}</a>
													</p>
												@endforeach
											@else
													<p class="m-0 p-0">No links available</p>
											@endif										
										</div>
									</div>
								</div>

							</td>
							<td class="table-column table-invoice">{{'invoiceNumber'}}</td>
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
@endsection
