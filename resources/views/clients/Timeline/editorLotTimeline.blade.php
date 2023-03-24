@extends('layouts.ClientMain')
@section('title')
  Client Dashboard
@endsection
@section('css_links')
	<link rel="stylesheet" href="">	
	<style>
		.card{
			border: 0px;
			border-left: 5px solid #32737E;
			box-shadow: 0 6px 10px 0 rgba(0, 0, 0, 0.3);
		}
		.card-body{
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			grid-gap: 5px;
		}
		.card-body-lot {
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			grid-gap: 5px;
		}
		.card-body-wrc {
			display: grid;
			grid-template-columns: repeat(1, 1fr);
			grid-gap: 5px;
		}
		.card-body-uploading {
			display: grid;
			grid-template-columns: repeat(1, 1fr);
			grid-gap: 5px;
		}
		.card-body-payment {
			display: grid;
			grid-template-columns: repeat(4, 1fr);
			grid-gap: 1px;
		}
		.copyCreativeurl{
		text-decoration: none; /* remove the underline */
		}
	</style>
	
@endsection


@section('main_content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper dashboard-content-wrapper">
		<!-- Navbar -->
			@include('clients.top_bar.top-head')
		<!-- /.navbar -->
	<!-- Main content -->
	<div class="content custom-dashboard-content">
		<div class="container-fluid">
			<div class="custom-tracking-action tracking-action-basic-details">
				<div class="order-summary-details whitebg-order-summary">
					<div class="col-sm-12 col-12">
						<div class="dash-action-name tracked-order-name">
							<span class="action-icon tracked-order-icn">
								<img src="..\assets-images\Desktop-Assets\dashboard home\order-icon-for-card.svg" alt="Order icon">
							</span>
							<span class="action-text tracked-order-nm" id="trackedorderName">
								<h5>
									Editor Lot Timeline Details
								</h5>
								<h6 class="action-subtext tracked-order-id" id="trackedorderId">
									Lot ID: {{$lot_generated_detail[0] != null ? $lot_generated_detail[0]['lot_number'] : "-"}}
								</h6>
							</span>
						</div>
					</div>
					<div class="row mt-85" >
						<div class="col-sm-12 col-12">
							<div class="order-timeline order-tracking-timeline">
								<ul class="list-group">
									<li class="list-group-item active-status tracking-active-status">
									  <div class="card">
										<h6 class="card-title p-1">LOT Generated</h6>
										<div class="card-body card-body-wrc">
											<div class="table-responsive">
												<table class="table">
													<thead>
													<tr>
														<th>LOT No</th>
														<th>Inward Quantity</th>
														<th>Date</th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td>{{$lot_generated_detail[0] != null ? $lot_generated_detail[0]['lot_number'] : "-"}}</td>
														<td>{{$lot_generated_detail[0] != null ? $lot_generated_detail[0]['inward_quantity'] : "-"}}</td>
														<td>{{$lot_generated_detail[0] != null ? dateFormet_dmy($lot_generated_detail[0]['created_at']) : "-"}}</td>
													</tr>
													</tbody>
												</table>
											</div>
										</div>
									  </div>
									</li>
									<li class="list-group-item active-status tracking-active-status">
									  <div class="card">
											<h6 class="card-title p-1">Work Request Code Generated</h6>
											<div class="card-body card-body-wrc">
												<div class="table-responsive">
													<table class="table">
														<thead>
														<tr>
															<th>Wrc No</th>
															<th>Quantity</th>
															<th>Date</th>
														</tr>
														</thead>
														<tbody>
															@foreach ($wrc_with_order_qty as $wrc_val)
																<tr>
																	<td class="text-wrap">{{$wrc_val['wrc_number']}}</td>
																	<td class="text-wrap">{{$wrc_val['imgQty']}}</td>
																	<td class="text-wrap">{{dateFormet_dmy($wrc_val['created_at'])}}</td>
																</tr>
															@endforeach
														</tbody>
													</table>
												</div>
											</div>
									  </div>
									</li>
									<li class="list-group-item active-status tracking-active-status">
									  <div class="card">
										<h6 class="card-title p-1">Allocation to Team</h6>
										<div class="card-body card-body-wrc">
											<div class="table-responsive">
												<table class="table">
													<thead>
													<tr>
														<th>Wrc No</th>
														<th>Quantity</th>
														<th>Date</th>
													</tr>
													</thead>
													<tbody>
														@foreach ($allocated_wrc_details as $allo_wrc_val)
															<tr>
																<td class="text-wrap">{{$allo_wrc_val['wrc_number']}}</td>
																<td class="text-wrap">{{$allo_wrc_val['allocated_qty']}}</td>
																<td class="text-wrap">{{dateFormet_dmy($allo_wrc_val['allocation_created_at'])}}</td>
															</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									  </div>
									</li>
									<li class="list-group-item active-status tracking-active-status">
									  <div class="card">
										<h6 class="card-title p-1">Uploading & QC</h6>
										<div class="card-body card-body-uploading">
											<div class="table-responsive">
												<table class="table">
													<thead>
													<tr>
														<th>Wrc No</th>
														<th>Status</th>
														{{-- <th>Completed</th> --}}
														{{-- <th>Date</th> --}}
													</tr>
													</thead>
													<tbody>
														@foreach ($wrc_with_order_qty as $wrc_val)
														<tr>
															<td class="text-wrap">{{$wrc_val['wrc_number']}}</td>
															@if ($wrc_val['qc_status'] == 0)
																<td><p style = "border-radius:20px; width:30%" class="text-wrap card-text bg-warning d-flex align-items-center justify-content-center status-tag text-white"> &nbsp;Pending&nbsp; </p></td>	
															@endif

															@if ($wrc_val['qc_status'] == 1)
																<td><p style = "border-radius:20px; width:30%" class="text-wrap card-text bg-success d-flex align-items-center justify-content-center status-tag text-white"> &nbsp;Completed&nbsp; </p></td>		
															@endif
															{{-- <td class="text-wrap">{{dateFormet_dmy($wrc_val['created_at'])}}</td> --}}
														</tr>
													@endforeach
													</tbody>
												</table>
											</div>
										</div>
									  </div>
									</li>
									{{-- <li class="list-group-item active-status tracking-active-status">
									  <div class="card">
										<h6 class="card-title p-1">Submission</h6>
										<div class="card-body card-body-wrc">
											<div class="table-responsive">
												<table class="table">
													<thead>
													<tr>
														<th>Wrc No</th>
														<th>Final Link</th>
														<th>Date</th>
													</tr>
													</thead>
													

													<tbody>
														@foreach ($Submission_link_details as $sub_val)
																@php
																$final_link_array = explode(',',$sub_val['final_link_array']);
																$copy_link_arr = explode(',',$sub_val['copy_link_arr'])
																@endphp
															<tr>
																<td class="text-wrap">{{$sub_val['wrc_number']}}</td>

																<td>
																	<ul class="list-group mt-2">
																		@foreach($final_link_array as $key => $val)
																		@if($val == "")
																			<li title="{{$val}}"><p  class="copyCreativeurl" >No link for copy</p></li>
																		@endif
																		@if($val != "")
																			<li title="{{$val}}">
																				<a class="copyCreativeurl" href="{{$val}}" onclick="copyUrl(event)">Click Here</a>
																				<span class="copy-message" style="display:none"><br>Link copied!</span>
																			</li>
																		@endif
																		
																		@endforeach
																	</ul>
																</td>

																
																<td class="text-wrap">{{dateFormet_dmy($sub_val['wrc_created_at'])}}</td>
															</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									  </div>
									</li> --}}
									<li class="list-group-item active-status tracking-active-status">
										<div class="card">
										  <div class="d-flex justify-content-between align-items-center bg-yellow p-1">
											<h6 class="card-title mb-0">Invoice</h6>
											
											<a href="#" class="btn contact-btn-side" id="sidecntBTn">
												<span>Click to Complete Payment</span>
											</a>
										  </div>
										  <div class="card-body card-body-payment">
											
											<div class="table-responsive">
												<table class="table">
													<thead>
													<tr>
														<th>Status</th>
														<th><p style = "border-radius: 10px;" class="card-text bg-warning d-flex align-items-center justify-content-center status-tag text-white">Pending</p></th>
													</tr>
													</thead>
												</table>
											</div>
										  </div>
										</div>
									  </li>
									  
									<li></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</div>
	</div>
	<!-- /Main.content -->
	</div>
	<!-- /.content-wrapper -->
@endsection

{{-- Other Js pluging   --}}
@section('js_links')
  <script type="text/javascript" src=""></script>
@endsection

@section('js_scripts')
	<script>
		function semple(){
			console.log('first')
		}
	</script>
	<script>
		function copyUrl(event) {
		  event.preventDefault(); // prevent the link from navigating to the URL
		  
		  const url = event.target.getAttribute('href'); // get the URL from the link's href attribute
		  navigator.clipboard.writeText(url) // copy the URL to the clipboard
			.then(() => {
			  console.log('URL copied to clipboard');
			  const message = event.target.nextElementSibling; // get the next sibling element (the message element)
			  message.style.display = 'inline'; // show the message element
			  setTimeout(() => {
				message.style.display = 'none'; // hide the message element after a few seconds
			  }, 3000);
			})
			.catch((error) => {
			  console.error('Failed to copy URL: ', error);
			});
		}
		</script>
	
@endsection