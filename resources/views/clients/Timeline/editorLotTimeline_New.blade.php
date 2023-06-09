@extends('layouts.DamNewMain')
@section('title')
  Client Editing Lot Timeline
@endsection

@section('main_content')

<style>
	.hoverpopover {
		position: absolute;
		background: #0F0F0F;
		border: 1px solid #333333;
		box-shadow: 6px 24px 60px rgba(255, 255, 255, 0.06);
		z-index: 1;
		width: 620px !important;
		/* Set the width of the popover */
		top: 455px;
        left: 405px;
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
		<a class="btn btn-light border-0 back-btn" href="{{ url()->previous() }}" role="button">
		    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_1463_886)">
            <path d="M6.05829 15.1167L0.999958 10.0584L6.05829 5.00003M20.0833 10.0584L1.14162 10.0584" stroke="#808080" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
            <defs>
            <clipPath id="clip0_1463_886">
            <rect width="20" height="20" fill="#808080"/>
            </clipPath>
            </defs>
            </svg>
			&nbsp; back</a>
	</div>
	<div class="col-12 d-flex justify-content-between">
		<div>
			<p class="brand-name-under-track-table">{{$lot_detail[0]['brand_name']}}</p>
			<p class="lot-date-sty">
			    <svg width="14" height="20" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.66667 1.16675V2.91675M9.33333 1.16675V2.91675M2.04167 5.30258H11.9583M12.25 4.95841V9.91675C12.25 11.6667 11.375 12.8334 9.33333 12.8334H4.66667C2.625 12.8334 1.75 11.6667 1.75 9.91675V4.95841C1.75 3.20841 2.625 2.04175 4.66667 2.04175H9.33333C11.375 2.04175 12.25 3.20841 12.25 4.95841Z" stroke="#808080" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9.15538 7.9917H9.16064M9.15538 9.7417H9.16064M6.99705 7.9917H7.00288M6.99705 9.7417H7.00288M4.83813 7.9917H4.84397M4.83813 9.7417H4.84397" stroke="#808080" stroke-linecap="round" stroke-linejoin="round"/>
                 </svg>
			     {{$lot_detail[0] != null ? dateFormet_dmy($lot_detail[0]['created_at']) : "-"}}
			</p>
		</div>
	</div>
	<div style="color: #9F9F9F;">
	    <hr style="margin-top:24px; margin-bottom:24px;">
	</div>
	
	<div class="col-12">
		<div class="col-12 d-flex justify-content-between">
		 <div>
	          <p style="font-weight: 500;font-size: 16px;color: #808080;margin-bottom: 0px;">LOT NO</p>
	          <h2 class="lot-no-sty">  {{$lot_detail[0] != null ? $lot_detail[0]['lot_number'] : "-"}}</h2>
	      </div>
	      <div>
	          <p style="font-weight: 500;font-size: 16px;color: #808080;margin-bottom: 0px;">INWARD QUANTITY</p>
	           <h2 class="lot-no-sty">{{$lot_detail[0] != null ? $lot_detail[0]['inward_quantity'] : "-"}}</h2>
	      </div>
		</div>
		<div class="row progress-row">
			<div class="col-lg-1 progress-column-status-percen">
				<p class="progress-status-head">Status:</p>
				<p class="progress-status-percentage">{{$lot_detail[0] != null ? $lot_detail[0]['overall_progress'] : "20%"}}</p>
			</div>
			<div class="col-lg-11 progress-columnn">
				<div class="progress-box">
					@php
						$overall_progress_is = $lot_detail[0]['overall_progress'];
						$overall_progress_is = str_replace('%', '', $overall_progress_is);
						$dispaly_bar_1 = false;
						$dispaly_bar_2 = false;
						$dispaly_bar_3 = false;
						$dispaly_bar_4 = false;
						$dispaly_bar_5 = false;
						if($overall_progress_is <= 20){
							$dispaly_bar_1 = true;
						}else if($overall_progress_is > 20 && $overall_progress_is <= 40){
							$dispaly_bar_2 = true;
						}else if($overall_progress_is > 40 && $overall_progress_is <= 60){
							$dispaly_bar_3 = true;
						}else if($overall_progress_is > 60 && $overall_progress_is <= 80){
							$dispaly_bar_4 = true;
						}
					@endphp
					<div class="progress-labels">
						<div class="progress-label progress-label-1">
							<p class="progress-upper-heading">
								@if ($dispaly_bar_1)
								<svg class="task-status-svg" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
									<circle cx="10" cy="10" r="10" fill="#59ABB2" fill-opacity="0.1"/>
									<circle class="scale-animation" cx="10" cy="10" r="7" fill="#59ABB2"/>
								</svg>&nbsp;
								@endif
								Inward</p>
						</div>
						<div class="progress-label progress-label-2">
							<p class="progress-upper-heading">
								@if ($dispaly_bar_2)
								<svg class="task-status-svg" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
									<circle cx="10" cy="10" r="10" fill="#59ABB2" fill-opacity="0.1"/>
									<circle class="scale-animation" cx="10" cy="10" r="7" fill="#59ABB2"/>
								</svg>&nbsp;
								@endif
								WRC Generated</p>
						</div>
						<div class="progress-label progress-label-3">
							<p class="progress-upper-heading">
								@if ($dispaly_bar_3)
								<svg class="task-status-svg" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
									<circle cx="10" cy="10" r="10" fill="#59ABB2" fill-opacity="0.1"/>
									<circle class="scale-animation" cx="10" cy="10" r="7" fill="#59ABB2"/>
								</svg>&nbsp;
								@endif
								Task Assigned</p>
						</div>
						<div class="progress-label progress-label-4">
							<p class="progress-upper-heading">
								@if ($dispaly_bar_4)
								<svg class="task-status-svg" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
									<circle cx="10" cy="10" r="10" fill="#59ABB2" fill-opacity="0.1"/>
									<circle class="scale-animation" cx="10" cy="10" r="7" fill="#59ABB2"/>
								</svg>&nbsp;
								@endif
								Quality Check (QC)</p>
						</div>
						<div class="progress-label progress-label-5">
							<p class="progress-upper-heading">
								@if ($dispaly_bar_5)
								<svg class="task-status-svg" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
									<circle cx="10" cy="10" r="10" fill="#59ABB2" fill-opacity="0.1"/>
									<circle class="scale-animation" cx="10" cy="10" r="7" fill="#59ABB2"/>
								</svg>&nbsp;
								@endif
								Submissions</p>
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
					@php
						$overall_progress = $lot_detail[0]['overall_progress'];
						$overall_progress = intval(str_replace('%', '', $overall_progress));
					@endphp	
					<div class="progress-labels">
						<div class="progress-label progress-label-1">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['created_at']) && $lot_detail[0]['created_at'] != null  ? dateFormet_dmy($lot_detail[0]['created_at']) : "-"}}</p>
						</div>
						<div class="progress-label progress-label-2">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['wrc_created_at']) && $lot_detail[0]['wrc_created_at'] != null && $overall_progress > '20' ? dateFormet_dmy($lot_detail[0]['wrc_created_at']) : "-"}}</p>
						</div>
						<div class="progress-label progress-label-3">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['allocated_created_at']) && $lot_detail[0]['allocated_created_at'] != null  && $overall_progress > '40' ? dateFormet_dmy($lot_detail[0]['allocated_created_at']) : "-"}}</p>
						</div>
						<div class="progress-label progress-label-4">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['qc_done_at']) && $lot_detail[0]['qc_done_at'] != null  && $overall_progress > '60' ? dateFormet_dmy($lot_detail[0]['qc_done_at']) : "-"}}</p>
						</div>
						<div class="progress-label progress-label-5">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['submission_date']) && $lot_detail[0]['submission_date'] != null  && $overall_progress == '100' ? dateFormet_dmy($lot_detail[0]['submission_date']) : "-"}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
    <p class="WRC-info-para">WRC INFO.</p>
	<div class="col-12 table-responsive track-lot-table-details">
		<table class="table table-borderless">
			<thead>
				<tr>
					<th scope="col" class="table-heading-sty">WRC No.</th>
					<th scope="col" class="table-heading-sty">Date</th>
					<th scope="col" class="table-heading-sty">Quantity</th>
					<th scope="col" class="table-heading-sty">Quality Check (QC)</th>
					<th scope="col" class="table-heading-sty">Submissions</th>
					<th scope="col" class="table-heading-sty">Invoice</th>
					<th scope="col" class="table-heading-sty" style="text-align: center;">Images</th>
					
				</tr>
			</thead>
			<tbody>
				@if ($lot_detail[0]['lot_status'] != 'Inward')
					@foreach ($wrc_detail as $wrc_index => $wrc_row)
						<tr>
							<td class="table-column">
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
											<div class=" ps-3 ">
												<div class="row d-flex justify-content-between">
													<div class="col-4">
														<p class="track-lot-table-typeof-service text-start">Type of service</p>
														<p class="track-lot-table-marketplace-pri-mode text-start">{{$wrc_row['type_of_service']}}</p>
													</div>

													<div class="col-4">
														<p class="track-lot-table-typeof-service text-start">Commercial (Per unit)</p>
														<p class="track-lot-table-marketplace-pri-mode text-start">{{$wrc_row['CommercialPerImage']}}</p>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
							</td>
							<td class="table-column">{{dateFormet_dmy($wrc_row['wrc_created_at'])}}</td>
							<td class="table-column">{{$wrc_row['wrc_order_qty']}}</td>
							<td class="table-column">{{$wrc_row['qc_status'] == 'Done' ? $wrc_row['cata_sum'] : '-'}}</td>
							<td class="table-column table-invoice">
								{{$wrc_row['submission_status']}}
								<?php
									$diables_img_download = 'diables_img_download';
									if($wrc_row['submission_status'] == 'Done'){
										$diables_img_download = "";
										echo "<br>".date('d/m/Y', strtotime($wrc_row['submission_date']));
									}
								?>
							
							</td>
							<td class="table-column">-</td>
							<td class="table-column" style="text-align: center;">
								<a class="{{$diables_img_download}}" href="{{route('download_Editing_lot_Edited_wrc' , [ base64_encode($wrc_row['wrc_id']) ] )}}">
									@if ($wrc_row['submission_status'] == 'Done')
										<svg width="28" height="27" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M14 2C7.652 2 2.5 7.152 2.5 13.5C2.5 19.848 7.652 25 14 25C20.348 25 25.5 19.848 25.5 13.5C25.5 7.152 20.348 2 14 2ZM18.0595 14.6845L14.6095 18.1345C14.437 18.307 14.2185 18.3875 14 18.3875C13.7815 18.3875 13.563 18.307 13.3905 18.1345L9.9405 14.6845C9.7801 14.5222 9.69014 14.3032 9.69014 14.075C9.69014 13.8468 9.7801 13.6278 9.9405 13.4655C10.274 13.132 10.826 13.132 11.1595 13.4655L13.1375 15.4435V9.475C13.1375 9.0035 13.5285 8.6125 14 8.6125C14.4715 8.6125 14.8625 9.0035 14.8625 9.475V15.4435L16.8405 13.4655C17.174 13.132 17.726 13.132 18.0595 13.4655C18.393 13.799 18.393 14.351 18.0595 14.6845Z" fill="white"/>
										</svg>
									@else
										<svg width="28" height="27" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M14 9.5625V16.3125M14 24.75C20.2134 24.75 25.25 19.7134 25.25 13.5C25.25 7.28663 20.2134 2.25 14 2.25C7.78663 2.25 2.75 7.28663 2.75 13.5C2.75 19.7134 7.78663 24.75 14 24.75Z" stroke="#4D4D4D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M10.625 14.0625L14 17.4375L17.375 14.0625" stroke="#4D4D4D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									@endif
								</a>
							</td>
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
			<?php 
				$lot_status_is = $lot_detail[0]['lot_status'];
				$img_download = "";
				if($lot_status_is != 'Submission Done'){
					$img_download = "diables_img_download";
				}
				?>
			<a href="{{route('download_Editing_Lot_edited', [base64_encode($lot_detail[0]['lot_id'])])}}" type="button" class="btn border btn-lg last-button download-img-raw-btn {{$img_download}}">Download images</a>&nbsp;&nbsp;&nbsp;

			<a href="{{route('download_Editing_Lot_raw', [base64_encode($lot_detail[0]['lot_id'])])}}" type="button" class="btn border btn-lg last-button download-img-raw-btn {{$img_download}}">Download raw</a>
		</div>
		<div class="download-invoice">
			<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1270_842)">
                <path d="M9.99984 7.08317V12.0832M9.99984 18.3332C14.6023 18.3332 18.3332 14.6023 18.3332 9.99984C18.3332 5.39734 14.6023 1.6665 9.99984 1.6665C5.39734 1.6665 1.6665 5.39734 1.6665 9.99984C1.6665 14.6023 5.39734 18.3332 9.99984 18.3332Z" stroke="#98A7DA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M7.5 10.4165L10 12.9165L12.5 10.4165" fill="#98A7DA"/>
                <path d="M7.5 10.4165L10 12.9165L12.5 10.4165" stroke="#98A7DA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </g>
                <defs>
                <clipPath id="clip0_1270_842">
                <rect width="20" height="20" fill="white"/>
                </clipPath>
                </defs>
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
