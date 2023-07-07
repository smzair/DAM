@extends('layouts.DamNewMain')
@section('title')
  Client Shoot Lot Timeline
@endsection

@section('main_content')

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
		top: auto !important;
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
		text-decoration: underline !important;
	}

	.upper-head-style-for-track-hover {
		margin-top: -10px;
		margin-left: -10px;
		margin-right: -10px;
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
		
		
	.back-svg-container {
       display: inline-block;
       position: relative;
    }
    
    .back-svg-container:hover .svg-rect {
      fill: #FFFFFF; /* Change the color on hover */
    }
    
    .back-svg-container:hover .svg-path {
      stroke: #0F0F0F; /* Change the color on hover */
      }
      
</style>

{{-- download-all-assets Style --}}
<style>
	.last-btn-div .download-all-assets{
		background: #FFF300 !important;
		color: #0F0F0F !important;
		padding: 15px 20px !important;
	}
	.last-btn-div .download-all-assets:hover{
		background: #FFF300 !important;
		color: #0F0F0F !important;
		padding: 15px 20px !important;
	}
</style>

<div class="row">
	<div class="col-12">
		<a class="btn back-svg-container  back-btn" href="{{ url()->previous() }}" role="button">
		   <svg class="svg-icon" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect class="svg-rect" width="44" height="44" rx="22" fill="#1A1A1A" />
              <g class="svg-path" clip-path="url(#clip0_1827_12903)">
                <path class="svg-path" d="M18.0583 27.1167L13 22.0584L18.0583 17M32.0833 22.0584L13.1416 22.0584" stroke="#808080" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
              </g>
              <defs>
                <clipPath id="clip0_1827_12903">
                  <rect width="20" height="20" fill="white" transform="translate(12 12)" />
                </clipPath>
              </defs>
         </svg>
        </a>
	</div>
	<div class="col-12 d-flex justify-content-between" style="margin-top:40px;">
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
		  <div class="lot-inwrd-vertical-parent-div">
               <div class="sec-parent-div d-flex">
                   <div>
                     <p style="font-weight: 500;font-size: 14px;color: #9F9F9F;margin-bottom: 0px;">Lot No.</p>
	                 <h2 class="lot-no-sty">  {{$lot_detail[0] != null ? $lot_detail[0]['lot_number'] : "-"}}</h2>
                   </div>
                   <span class="border border-dark border-for-track-lot-start"></span>
                   <div>
                     <p style="font-weight: 500;font-size: 14px;color: #9F9F9F;margin-bottom: 0px;">Inward quantity</p>
	                 <h2 class="lot-no-sty">{{$lot_detail[0] != null ? $lot_detail[0]['inward_quantity'] : "-"}}</h2>
                   </div>
                   <span class="border border-1 border-dark border-for-track-lot-start"></span>
                   <div>
                    <p style="font-weight: 500;font-size: 14px;color: #9F9F9F;margin-bottom: 0px;">Vertical type</p>
	                <h2 class="lot-no-sty">Shoot Lot</h2>
                   </div>
               </div>
        </div>
	</div>
	<div style="color: #9F9F9F;">
	    <hr style="margin-top:24px; margin-bottom:24px;">
	</div>
    <div class="col-12">
        <p class="LOT-STATUS-head-tracklots">LOT STATUS</p>
    </div>
    
	<div class="col-12">
		<div class="row progress-row">
			<div class="col-lg-1 progress-column-status-percen">
				<p class="progress-status-head">Status:</p>
				<p class="progress-status-percentage">{{$lot_detail[0] != null ? $lot_detail[0]['overall_progress'].'%' : "20%"}}</p>
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
						$dispaly_bar_6 = false;
							$lot_status_percentage = lot_status_percentage();
							// dd($lot_status_percentage , $lot_detail[0]['overall_progress'] , $lot_status_percentage[5]);
						if($overall_progress_is <= $lot_status_percentage[0]){
							$dispaly_bar_1 = true;
						}else if($overall_progress_is > $lot_status_percentage[0] && $overall_progress_is <= $lot_status_percentage[1]){
							$dispaly_bar_2 = true;
						}else if($overall_progress_is > $lot_status_percentage[1] && $overall_progress_is <= $lot_status_percentage[2]){
							$dispaly_bar_3 = true;
						}else if($overall_progress_is > $lot_status_percentage[2] && $overall_progress_is <= $lot_status_percentage[3]){
							$dispaly_bar_4 = true;						
						}else if($overall_progress_is > $lot_status_percentage[3] && $overall_progress_is <= $lot_status_percentage[4]){
							$dispaly_bar_5 = true;
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
							   Research & Strategy
							</p>
						</div>
						<div class="progress-label progress-label-3">
							<p class="progress-upper-heading">
								@if ($dispaly_bar_3)
								<svg class="task-status-svg" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
									<circle cx="10" cy="10" r="10" fill="#59ABB2" fill-opacity="0.1"/>
									<circle class="scale-animation" cx="10" cy="10" r="7" fill="#59ABB2"/>
								</svg>&nbsp;
								@endif
								Work Started</p>
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
								Invoice</p>
						</div>
						<div class="progress-label progress-label-5">
							<p class="progress-upper-heading">
								@if ($dispaly_bar_6)
								<svg class="task-status-svg" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
									<circle cx="10" cy="10" r="10" fill="#59ABB2" fill-opacity="0.1"/>
									<circle class="scale-animation" cx="10" cy="10" r="7" fill="#59ABB2"/>
								</svg>&nbsp;
								@endif
								Submissions</p>
						</div>
					</div>
					<div class="progress">
						
						<div class="progress-bar progress-bar-1" role="progressbar_new" style="width: 16%;" aria-valuenow="16"
							aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-2" role="progressbar_new" style="width: {{$lot_detail[0] != null && $lot_detail[0]['overall_progress'] > $lot_status_percentage[0] ? $lot_detail[0]['wrc_progress'].'%' : '0%'}};" aria-valuenow="33"
							aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-3" role="progressbar_new" style="width: {{$lot_detail[0] != null && $lot_detail[0]['overall_progress'] > $lot_status_percentage[1] ? $lot_detail[0]['wrc_assign'].'%' : '0%'}};" aria-valuenow="50"
							aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-4" role="progressbar_new" style="width: {{$lot_detail[0] != null && $lot_detail[0]['overall_progress'] > $lot_status_percentage[2] ? $lot_detail[0]['wrc_qc'].'%' : '0%'}};" aria-valuenow="67"
							aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-5" role="progressbar_new" style="width: {{$lot_detail[0] != null && $lot_detail[0]['overall_progress'] > $lot_status_percentage[3] ? $lot_detail[0]['lot_invoiceing'].'%' : '0%'}};" aria-valuenow="84"
							aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-6" role="progressbar_new" style="width: {{$lot_detail[0] != null && $lot_detail[0]['overall_progress'] > $lot_status_percentage[4] ? $lot_detail[0]['wrc_submission'].'%' : '0%'}};" aria-valuenow="100"
							aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					@php
						$overall_progress = $lot_detail[0]['overall_progress'];
						$overall_progress = intval(str_replace('%', '', $overall_progress));
					@endphp	
					<div class="progress-labels">
						<div class="progress-label progress-label-1" style="width: {{$lot_status_percentage[0]}}%">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['created_at']) && $lot_detail[0]['created_at'] != null  ? dateFormet_dmy($lot_detail[0]['created_at']) : "-"}}</p>
						</div>
						<div class="progress-label progress-label-2" style="width: {{$lot_status_percentage[1] - $lot_status_percentage[0]}}%">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['wrc_created_at']) && $lot_detail[0]['wrc_created_at'] != null && $overall_progress > '20' ? dateFormet_dmy($lot_detail[0]['wrc_created_at']) : "-"}}</p>
						</div>
						<div class="progress-label progress-label-3" style="width: {{$lot_status_percentage[2] - $lot_status_percentage[1]}}%">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['allocated_created_at']) && $lot_detail[0]['allocated_created_at'] != null  && $overall_progress > '40' ? dateFormet_dmy($lot_detail[0]['allocated_created_at']) : "-"}}</p>
						</div>
						<div class="progress-label progress-label-4"  style="width: {{$lot_status_percentage[3] - $lot_status_percentage[2]}}%">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['qc_done_at']) && $lot_detail[0]['qc_done_at'] != null  && $overall_progress > '60' ? dateFormet_dmy($lot_detail[0]['qc_done_at']) : "-"}}</p>
						</div>
						{{-- invoice date --}}
						<div class="progress-label progress-label-5"  style="width: {{$lot_status_percentage[4] - $lot_status_percentage[3]}}%">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['lot_invoice_date']) && $lot_detail[0]['lot_invoice_date'] != null  && $overall_progress > '80' ? dateFormet_dmy($lot_detail[0]['lot_invoice_date']) : "-"}}</p>
						</div>

						<div class="progress-label progress-label-6" style="width: {{$lot_status_percentage[5] - $lot_status_percentage[4]}}%">
							<p class="progress-bottom-heading">{{isset($lot_detail[0]['submission_date']) && $lot_detail[0]['submission_date'] != null  && $overall_progress > '80' ? dateFormet_dmy($lot_detail[0]['submission_date']) : "-"}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
      <p class="WRC-info-para">WRC INFO.</p>
	<div class="col-12 table-responsive track-lot-table-details">
		<table class="table table-borderless " id="tracktablehover">
			<thead>
				<tr>
					<th scope="col" class="table-heading-sty">WRC No.</th>
					<th scope="col" class="table-heading-sty">Date</th>
					<th scope="col" class="table-heading-sty">Quantity</th>
					<th scope="col" class="table-heading-sty">Quality Check (QC)</th>
					<th scope="col" class="table-heading-sty">Rejected</th>
					<th scope="col" class="table-heading-sty">Status</th>
					<th scope="col" class="table-heading-sty">Delivery</th>
					<th scope="col" class="table-heading-sty">Invoice</th>
					<th scope="col" class="table-heading-sty" style="text-align: center;">Images</th>
					
				</tr>
			</thead>
			<tbody>
				@if ($lot_detail[0]['lot_status'] != 'Inward')
					@foreach ($wrc_detail as $wrc_index => $wrc_row)
						<tr>
							<td class="table-column wrc-no-sty">
								<p class="text">
									{{$wrc_row['wrc_number']}}
								</p>

								<div class="hoverpopover" style="display: none" id="wrcInfo{{$wrc_index}}">
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
											<div class=" ps-3">
												<div class="row d-flex justify-content-between">
													<div class="col-3">
														<p class="track-lot-table-typeof-service text-start">Product Type</p>
														<p class="track-lot-table-marketplace-pri-mode text-start">{{$wrc_row['product_category']}}</p>
													</div>
													<div class="col-3">
														<p class="track-lot-table-typeof-service text-start">Type Shoot</p>
														<p class="track-lot-table-marketplace-pri-mode text-start">{{$wrc_row['type_of_shoot']}}</p>
													</div>
													<div class="col-3">
														<p class="track-lot-table-typeof-service text-start">Type of clothing</p>
														<p class="track-lot-table-marketplace-pri-mode text-start">{{$wrc_row['type_of_clothing']}}</p>
													</div>
													<div class="col-3">
														<p class="track-lot-table-typeof-service text-start">Gender</p>
														<p class="track-lot-table-marketplace-pri-mode text-start">{{$wrc_row['gender']}}</p>
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 ps-3 mt-4">
											<p class="track-lot-table-typeof-service text-start">
												Adaptations
											</p>
										</div>
										<div class="col-12 d-flex ps-3 text-start">
											{{-- @foreach ($wrc_row['adaptation'] as $item)
												
												<p class="track-lot-adaptation-under">{{$item}}</p> &nbsp;&nbsp;&nbsp;&nbsp;
											@endforeach --}}
											<div class="adap-div-forAdaption">
												<div class="adap-div-forAdaption-content">
													<div class="AdaptLogo-section icon-container my-carousel owl-carousel">
														@foreach ($wrc_row['track_lot_adaptation_svg_data_arr'] as $adaptation_key =>  $adaptation_svg)
															<span class="item" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{$adaptation_key}}">
																<?php echo $adaptation_svg;?>
															</span>
														@endforeach
						
													</div>
												</div>
											</div>
											{{-- <p class="track-lot-adaptation-under">Myntra_premium</p> &nbsp;&nbsp;&nbsp; &nbsp; --}}
										</div>
									</div>
								</div>
							</td>
							<td class="table-column">{{dateFormet_dmy($wrc_row['wrc_created_at'])}}</td>
							<td class="table-column">{{$wrc_row['wrc_order_qty']}}</td>
							<td class="table-column">{{$wrc_row['qc_status'] == 'Done' ? $wrc_row['wrc_qc_qty'] : '-'}}</td>
							<td class="table-column">{{$wrc_row['rejected_skus']}}</td>
							<td class="table-column">
								<p class="mb-0">
									@if ($wrc_row['wrc_current_status'] == 1)
										<svg width="76" height="26" viewBox="0 0 76 26" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M6.216 8.182C6.216 7.202 5.656 6.572 4.41 6.572H2.646V9.834H4.41C5.656 9.834 6.216 9.148 6.216 8.182ZM1.05 5.27H4.41C6.72 5.27 7.854 6.6 7.854 8.182C7.854 9.33 7.238 10.562 5.6 10.968L8.008 15H6.104L3.864 11.108H2.646V15H1.05V5.27ZM16.1837 7.44H14.5877C14.6157 6.726 14.2097 6.348 13.6077 6.348C12.9777 6.348 12.5717 6.768 12.5717 7.286C12.5717 7.818 12.8657 8.252 13.5517 8.994L16.1277 11.556L17.1217 9.918H18.8437L17.5837 12.074C17.4717 12.27 17.3457 12.466 17.2337 12.648L19.5997 15H17.5137L16.3097 13.796C15.3717 14.734 14.2937 15.182 12.9357 15.182C10.8357 15.182 9.4357 14.02 9.4357 12.2C9.4357 10.884 10.1777 9.778 11.7177 9.148C11.1717 8.49 10.9757 7.972 10.9757 7.286C10.9757 6.012 12.0117 5.046 13.6777 5.046C15.3717 5.046 16.2817 6.11 16.1837 7.44ZM12.9357 13.824C13.8457 13.824 14.5877 13.46 15.2597 12.746L12.6837 10.156C11.5497 10.604 11.0317 11.276 11.0317 12.144C11.0317 13.082 11.7877 13.824 12.9357 13.824ZM27.3121 12.242C27.3121 13.698 26.1221 15.098 23.9521 15.098C22.0061 15.098 20.5081 14.034 20.5081 12.312H22.2161C22.2861 13.11 22.8461 13.754 23.9521 13.754C25.0721 13.754 25.7021 13.152 25.7021 12.326C25.7021 9.974 20.5361 11.5 20.5361 7.916C20.5361 6.208 21.8941 5.144 23.8821 5.144C25.7441 5.144 27.0601 6.124 27.2001 7.79H25.4361C25.3801 7.132 24.8061 6.53 23.7981 6.502C22.8741 6.474 22.1601 6.922 22.1601 7.86C22.1601 10.058 27.3121 8.686 27.3121 12.242Z" fill="white"/>
											<rect y="22" width="76" height="4" fill="#1A1A1A"/>
											<rect y="22" width="25.3333" height="4" fill="#FFF300"/>
										</svg>
									@elseif ($wrc_row['wrc_current_status'] == 2)
										<svg width="76" height="26" viewBox="0 0 76 26" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M3.024 15.014L0.266 5.27H1.96L3.976 13.194L6.16 5.27H7.952L9.982 13.152L12.012 5.27H13.72L10.836 15H9.03L6.986 7.636L4.816 15L3.024 15.014ZM22.4863 11.136C22.4863 13.558 20.6943 15.126 18.4823 15.126C16.2843 15.126 14.6183 13.558 14.6183 11.136C14.6183 8.714 16.3543 7.16 18.5523 7.16C20.7503 7.16 22.4863 8.714 22.4863 11.136ZM16.2423 11.136C16.2423 12.886 17.2783 13.74 18.4823 13.74C19.6723 13.74 20.8483 12.886 20.8483 11.136C20.8483 9.386 19.7143 8.546 18.5243 8.546C17.3203 8.546 16.2423 9.386 16.2423 11.136ZM25.7601 10.94V15H24.1641V7.286H25.7601V8.406C26.2081 7.636 26.9781 7.16 28.0701 7.16V8.812H27.6641C26.4881 8.812 25.7601 9.302 25.7601 10.94ZM29.6371 15V4.64H31.2331V10.66L34.0331 7.286H36.2451L32.6891 11.15L36.2451 15H34.0891L31.2331 11.682V15H29.6371ZM46.9798 12.844C46.9798 14.146 45.8458 15.126 44.0258 15.126C42.1778 15.126 40.8758 14.034 40.8058 12.634H42.4578C42.5138 13.264 43.1158 13.782 43.9978 13.782C44.9218 13.782 45.4118 13.39 45.4118 12.858C45.4118 11.346 40.9318 12.214 40.9318 9.386C40.9318 8.154 42.0798 7.16 43.8998 7.16C45.6498 7.16 46.7978 8.098 46.8818 9.638H45.2858C45.2298 8.966 44.7118 8.504 43.8438 8.504C42.9898 8.504 42.5418 8.854 42.5418 9.372C42.5418 10.926 46.8958 10.058 46.9798 12.844ZM49.0563 12.858V8.588H48.1463V7.286H49.0563V5.368H50.6663V7.286H52.5423V8.588H50.6663V12.858C50.6663 13.432 50.8903 13.67 51.5623 13.67H52.5423V15H51.2823C49.9103 15 49.0563 14.426 49.0563 12.858ZM53.5813 11.108C53.5813 8.728 55.1913 7.16 57.2213 7.16C58.5233 7.16 59.4193 7.776 59.8953 8.406V7.286H61.5053V15H59.8953V13.852C59.4053 14.51 58.4813 15.126 57.1933 15.126C55.1913 15.126 53.5813 13.488 53.5813 11.108ZM59.8953 11.136C59.8953 9.484 58.7613 8.546 57.5573 8.546C56.3673 8.546 55.2193 9.442 55.2193 11.108C55.2193 12.774 56.3673 13.74 57.5573 13.74C58.7613 13.74 59.8953 12.802 59.8953 11.136ZM68.1676 14.076C68.1676 14.65 67.7196 15.098 67.1596 15.098C66.5856 15.098 66.1376 14.65 66.1376 14.076C66.1376 13.502 66.5856 13.054 67.1596 13.054C67.7196 13.054 68.1676 13.502 68.1676 14.076ZM70.9956 14.076C70.9956 14.65 70.5476 15.098 69.9876 15.098C69.4136 15.098 68.9656 14.65 68.9656 14.076C68.9656 13.502 69.4136 13.054 69.9876 13.054C70.5476 13.054 70.9956 13.502 70.9956 14.076ZM65.3536 14.076C65.3536 14.65 64.9056 15.098 64.3456 15.098C63.7716 15.098 63.3236 14.65 63.3236 14.076C63.3236 13.502 63.7716 13.054 64.3456 13.054C64.9056 13.054 65.3536 13.502 65.3536 14.076Z" fill="white"/>
											<rect y="22" width="76" height="4" fill="#1A1A1A"/>
											<rect y="22" width="38" height="4" fill="#FFF300"/>
										</svg>
									@elseif ($wrc_row['wrc_current_status'] == 3)
										<svg width="76" height="26" viewBox="0 0 76 26" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M2.156 10.114C2.156 12.312 3.556 13.712 5.488 13.712C7.42 13.712 8.82 12.312 8.82 10.114C8.82 7.916 7.42 6.544 5.488 6.544C3.556 6.544 2.156 7.916 2.156 10.114ZM10.458 10.114C10.458 11.948 9.604 13.432 8.274 14.286L10.612 16.764H8.582L6.874 14.916C6.44 15.042 5.978 15.098 5.488 15.098C2.744 15.098 0.518 13.04 0.518 10.114C0.518 7.202 2.744 5.144 5.488 5.144C8.26 5.144 10.458 7.202 10.458 10.114ZM11.6375 10.114C11.6375 7.202 13.8635 5.144 16.6075 5.144C18.6375 5.144 20.3875 6.166 21.1295 8.07H19.2115C18.6935 7.034 17.7695 6.544 16.6075 6.544C14.6755 6.544 13.2755 7.916 13.2755 10.114C13.2755 12.312 14.6755 13.698 16.6075 13.698C17.7695 13.698 18.6935 13.208 19.2115 12.172H21.1295C20.3875 14.076 18.6375 15.084 16.6075 15.084C13.8635 15.084 11.6375 13.04 11.6375 10.114Z" fill="white"/>
											<rect y="22" width="76" height="4" fill="#1A1A1A"/>
											<rect y="22" width="50.6667" height="4" fill="#FFF300"/>
										</svg>
									@elseif ($wrc_row['wrc_current_status'] == 4)
									<svg width="76" height="26" viewBox="0 0 76 26" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1.05 15V5.27H2.646V15H1.05ZM10.3154 15V10.688C10.3154 9.274 9.54541 8.546 8.38341 8.546C7.20741 8.546 6.43741 9.274 6.43741 10.688V15H4.84141V7.286H6.43741V8.168C6.95541 7.538 7.80941 7.16 8.73341 7.16C10.5394 7.16 11.8974 8.294 11.8974 10.45V15H10.3154ZM13.1232 7.286H14.8312L17.0152 13.572L19.1992 7.286H20.8932L17.9532 15H16.0492L13.1232 7.286ZM29.5496 11.136C29.5496 13.558 27.7576 15.126 25.5456 15.126C23.3476 15.126 21.6816 13.558 21.6816 11.136C21.6816 8.714 23.4176 7.16 25.6156 7.16C27.8136 7.16 29.5496 8.714 29.5496 11.136ZM23.3056 11.136C23.3056 12.886 24.3416 13.74 25.5456 13.74C26.7356 13.74 27.9116 12.886 27.9116 11.136C27.9116 9.386 26.7776 8.546 25.5876 8.546C24.3836 8.546 23.3056 9.386 23.3056 11.136ZM31.2273 15V7.286H32.8233V15H31.2273ZM32.0393 6.264C31.4653 6.264 31.0173 5.816 31.0173 5.242C31.0173 4.668 31.4653 4.22 32.0393 4.22C32.5993 4.22 33.0473 4.668 33.0473 5.242C33.0473 5.816 32.5993 6.264 32.0393 6.264ZM34.4868 11.136C34.4868 8.728 36.0548 7.16 38.2668 7.16C40.1568 7.16 41.3888 8.098 41.8228 9.722H40.1008C39.8348 8.98 39.2188 8.504 38.2668 8.504C36.9788 8.504 36.1248 9.456 36.1248 11.136C36.1248 12.83 36.9788 13.782 38.2668 13.782C39.2188 13.782 39.8068 13.362 40.1008 12.564H41.8228C41.3888 14.076 40.1568 15.126 38.2668 15.126C36.0548 15.126 34.4868 13.558 34.4868 11.136ZM46.7613 8.504C45.6833 8.504 44.8153 9.232 44.6473 10.45H48.9173C48.8893 9.26 47.9513 8.504 46.7613 8.504ZM50.3733 12.704C49.9393 14.048 48.7213 15.126 46.8313 15.126C44.6193 15.126 42.9813 13.558 42.9813 11.136C42.9813 8.714 44.5493 7.16 46.8313 7.16C49.0293 7.16 50.5833 8.686 50.5833 10.954C50.5833 11.22 50.5693 11.472 50.5273 11.738H44.6333C44.7453 13.012 45.6553 13.782 46.8313 13.782C47.8113 13.782 48.3573 13.306 48.6513 12.704H50.3733Z" fill="white"/>
										<rect y="22" width="76" height="4" fill="#1A1A1A"/>
										<rect y="22" width="63.3333" height="4" fill="#FFF300"/>
									</svg>
									@elseif ($wrc_row['wrc_current_status'] == 5)
									<svg width="76" height="26" viewBox="0 0 76 26" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M7.616 12.242C7.616 13.698 6.426 15.098 4.256 15.098C2.31 15.098 0.812 14.034 0.812 12.312H2.52C2.59 13.11 3.15 13.754 4.256 13.754C5.376 13.754 6.006 13.152 6.006 12.326C6.006 9.974 0.84 11.5 0.84 7.916C0.84 6.208 2.198 5.144 4.186 5.144C6.048 5.144 7.364 6.124 7.504 7.79H5.74C5.684 7.132 5.11 6.53 4.102 6.502C3.178 6.474 2.464 6.922 2.464 7.86C2.464 10.058 7.616 8.686 7.616 12.242ZM16.5852 7.286V15H14.9892V14.076C14.4852 14.734 13.6172 15.112 12.7072 15.112C10.9012 15.112 9.52922 13.978 9.52922 11.822V7.286H11.1112V11.584C11.1112 12.998 11.8812 13.726 13.0432 13.726C14.2192 13.726 14.9892 12.998 14.9892 11.584V7.286H16.5852ZM20.387 8.434C20.891 7.734 21.857 7.16 23.075 7.16C25.119 7.16 26.701 8.728 26.701 11.108C26.701 13.488 25.105 15.126 23.075 15.126C21.801 15.126 20.891 14.552 20.387 13.88V15H18.791V4.64H20.387V8.434ZM25.077 11.108C25.077 9.442 23.929 8.546 22.725 8.546C21.535 8.546 20.387 9.484 20.387 11.136C20.387 12.802 21.535 13.74 22.725 13.74C23.929 13.74 25.077 12.774 25.077 11.108ZM39.3133 15V10.688C39.3133 9.274 38.5433 8.546 37.3813 8.546C36.2053 8.546 35.4353 9.274 35.4353 10.688V15H33.8533V10.688C33.8533 9.274 33.0833 8.546 31.9213 8.546C30.7453 8.546 29.9753 9.274 29.9753 10.688V15H28.3793V7.286H29.9753V8.168C30.4933 7.538 31.3333 7.16 32.2573 7.16C33.4753 7.16 34.4973 7.678 35.0293 8.686C35.5053 7.748 36.5973 7.16 37.7173 7.16C39.5233 7.16 40.8953 8.294 40.8953 10.45V15H39.3133ZM43.0262 15V7.286H44.6222V15H43.0262ZM43.8382 6.264C43.2642 6.264 42.8162 5.816 42.8162 5.242C42.8162 4.668 43.2642 4.22 43.8382 4.22C44.3982 4.22 44.8462 4.668 44.8462 5.242C44.8462 5.816 44.3982 6.264 43.8382 6.264ZM52.5716 12.844C52.5716 14.146 51.4376 15.126 49.6176 15.126C47.7696 15.126 46.4676 14.034 46.3976 12.634H48.0496C48.1056 13.264 48.7076 13.782 49.5896 13.782C50.5136 13.782 51.0036 13.39 51.0036 12.858C51.0036 11.346 46.5236 12.214 46.5236 9.386C46.5236 8.154 47.6716 7.16 49.4916 7.16C51.2416 7.16 52.3896 8.098 52.4736 9.638H50.8776C50.8216 8.966 50.3036 8.504 49.4356 8.504C48.5816 8.504 48.1336 8.854 48.1336 9.372C48.1336 10.926 52.4876 10.058 52.5716 12.844ZM60.1501 12.844C60.1501 14.146 59.0161 15.126 57.1961 15.126C55.3481 15.126 54.0461 14.034 53.9761 12.634H55.6281C55.6841 13.264 56.2861 13.782 57.1681 13.782C58.0921 13.782 58.5821 13.39 58.5821 12.858C58.5821 11.346 54.1021 12.214 54.1021 9.386C54.1021 8.154 55.2501 7.16 57.0701 7.16C58.8201 7.16 59.9681 8.098 60.0521 9.638H58.4561C58.4001 8.966 57.8821 8.504 57.0141 8.504C56.1601 8.504 55.7121 8.854 55.7121 9.372C55.7121 10.926 60.0661 10.058 60.1501 12.844ZM61.9746 15V7.286H63.5706V15H61.9746ZM62.7866 6.264C62.2126 6.264 61.7646 5.816 61.7646 5.242C61.7646 4.668 62.2126 4.22 62.7866 4.22C63.3466 4.22 63.7946 4.668 63.7946 5.242C63.7946 5.816 63.3466 6.264 62.7866 6.264ZM70.232 14.076C70.232 14.65 69.784 15.098 69.224 15.098C68.65 15.098 68.202 14.65 68.202 14.076C68.202 13.502 68.65 13.054 69.224 13.054C69.784 13.054 70.232 13.502 70.232 14.076ZM73.06 14.076C73.06 14.65 72.612 15.098 72.052 15.098C71.478 15.098 71.03 14.65 71.03 14.076C71.03 13.502 71.478 13.054 72.052 13.054C72.612 13.054 73.06 13.502 73.06 14.076ZM67.418 14.076C67.418 14.65 66.97 15.098 66.41 15.098C65.836 15.098 65.388 14.65 65.388 14.076C65.388 13.502 65.836 13.054 66.41 13.054C66.97 13.054 67.418 13.502 67.418 14.076Z" fill="#50AB64"/>
										<rect y="22" width="76" height="4" fill="#1A1A1A"/>
										<rect y="22" width="76" height="4" fill="#50AB64"/>
									</svg>
									@endif
								</p>
							</td>
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
							<td class="table-column">
								<p class="mb-0">
									@if ($wrc_row['wrc_current_status'] > 3)
										<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M12 2.5C6.49 2.5 2 6.99 2 12.5C2 18.01 6.49 22.5 12 22.5C17.51 22.5 22 18.01 22 12.5C22 6.99 17.51 2.5 12 2.5ZM16.78 10.2L11.11 15.87C10.9694 16.0105 10.7788 16.0893 10.58 16.0893C10.3812 16.0893 10.1906 16.0105 10.05 15.87L7.22 13.04C7.08052 12.8989 7.0023 12.7084 7.0023 12.51C7.0023 12.3116 7.08052 12.1211 7.22 11.98C7.51 11.69 7.99 11.69 8.28 11.98L10.58 14.28L15.72 9.14C16.01 8.85 16.49 8.85 16.78 9.14C17.07 9.43 17.07 9.9 16.78 10.2Z" fill="#50AB64"/>
										</svg>
									@else
										<svg width="92" height="24" viewBox="0 0 92 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M39.2237 6.832H40.6797V18H39.2237L33.3677 9.12V18H31.9117V6.832H33.3677L39.2237 15.696V6.832ZM43.2777 20.72L47.6457 2.928H49.1017L44.7177 20.72H43.2777ZM59.2591 18L58.3631 15.52H53.4991L52.6031 18H51.0671L55.0991 6.912H56.7791L60.7951 18H59.2591ZM57.9471 14.336L55.9311 8.704L53.9151 14.336H57.9471Z" fill="#808080"/>
										</svg>
									@endif
								</p>
							</td>
							<td class="table-column" style="text-align: center;">
								@if ($wrc_row['submission_status'] == 'Done')
									<a class="{{$diables_img_download}}" href="{{route('download_Shoot_lot_Edited_wrc' , [ base64_encode($wrc_row['wrc_id']) ] )}}"  >
										<svg width="28" height="27" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M14 2C7.652 2 2.5 7.152 2.5 13.5C2.5 19.848 7.652 25 14 25C20.348 25 25.5 19.848 25.5 13.5C25.5 7.152 20.348 2 14 2ZM18.0595 14.6845L14.6095 18.1345C14.437 18.307 14.2185 18.3875 14 18.3875C13.7815 18.3875 13.563 18.307 13.3905 18.1345L9.9405 14.6845C9.7801 14.5222 9.69014 14.3032 9.69014 14.075C9.69014 13.8468 9.7801 13.6278 9.9405 13.4655C10.274 13.132 10.826 13.132 11.1595 13.4655L13.1375 15.4435V9.475C13.1375 9.0035 13.5285 8.6125 14 8.6125C14.4715 8.6125 14.8625 9.0035 14.8625 9.475V15.4435L16.8405 13.4655C17.174 13.132 17.726 13.132 18.0595 13.4655C18.393 13.799 18.393 14.351 18.0595 14.6845Z" fill="white"/>
										</svg>
									</a>

									@else
										{{-- <svg width="28" height="27" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M14 9.5625V16.3125M14 24.75C20.2134 24.75 25.25 19.7134 25.25 13.5C25.25 7.28663 20.2134 2.25 14 2.25C7.78663 2.25 2.75 7.28663 2.75 13.5C2.75 19.7134 7.78663 24.75 14 24.75Z" stroke="#4D4D4D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M10.625 14.0625L14 17.4375L17.375 14.0625" stroke="#4D4D4D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg> --}}
									@endif
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
		<div class="download-invoice">
			<div class="d-none">
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
					</svg>&nbsp; <a href="" class="download-invoice"> Download Invoices</a>
			</div>
		</div> 
		<div class="d-flex last-button-mar">
			<?php 
				$lot_status_is = $lot_detail[0]['lot_status'];
				$img_download = "";
				if($lot_status_is != 'Submission Done'){
					$img_download = "diables_img_download";
				}
				?>

				@if ($lot_status_is == 'Submission Done')
					<a href="{{route('download_Shoot_Lot_edited', ['id' => $lot_detail[0]['id']])}}" type="button" class="btn btn-lg last-button download-img-raw-btn download-all-assets {{$img_download}}">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_2311_15276)">
							<path d="M9.99984 7.08332V12.0833M9.99984 18.3333C14.6023 18.3333 18.3332 14.6025 18.3332 9.99999C18.3332 5.39749 14.6023 1.66666 9.99984 1.66666C5.39734 1.66666 1.6665 5.39749 1.6665 9.99999C1.6665 14.6025 5.39734 18.3333 9.99984 18.3333Z" stroke="#0F0F0F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M7.5 10.4167L10 12.9167L12.5 10.4167" stroke="#0F0F0F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</g>
							<defs>
							<clipPath id="clip0_2311_15276">
							<rect width="20" height="20" fill="white"/>
							</clipPath>
							</defs>
							</svg>&nbsp;&nbsp;&nbsp;
						Download all assets
					</a>
				@endif
			{{-- <a href="{{route('download_Shoot_Lot_raw', ['id' => $lot_detail[0]['id']])}}" type="button" class="btn btn-lg last-button download-img-raw-btn {{$img_download}}">Download raw</a>&nbsp;&nbsp;&nbsp; --}}
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
      // Attach event listeners to the parent container
      var tracktablehover = document.getElementById('tracktablehover');
      tracktablehover.addEventListener('mouseover', showPopover);
      tracktablehover.addEventListener('mouseout', hidePopover);
  
      // Show the popover when hovering over a text element
      function showPopover(event) {
        var target = event.target;
        if (target.classList.contains('text')) {
          var hoverpopover = target.nextElementSibling;
          positionPopover(target, hoverpopover);
          hoverpopover.style.display = 'block';
        }
      }
  
      // Position the popover to the right of the text element
      function positionPopover(textElement, hoverpopover) {
        var textRect = textElement.getBoundingClientRect();
        var textRight = textRect.right;
        var textTop = textRect.top;
  
        hoverpopover.style.left = textRight + 'px';
        hoverpopover.style.top = textTop + 'px';
      }
  
      // Hide the popover when moving away from a text element
      function hidePopover(event) {
        var target = event.target;
        if (target.classList.contains('text')) {
          var hoverpopover = target.nextElementSibling;
          hoverpopover.style.display = 'none';
        }
      }
    </script>

{{-- tooltip --}}
	<script>
		const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
		const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
	</script>	

@endsection
