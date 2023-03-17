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
									Creative Lot Timeline Details
								</h5>
								<h6 class="action-subtext tracked-order-id" id="trackedorderId">
									Lot ID: ODN10022023-BEUCBFW31
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
														<td>ODN10022023-BEUCBFW31</td>
														<td>15</td>
														<td>17-03-2023</td>
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
														<tr>
															<td>BEUCBWP14-A</td>
															<td>15</td>
															<td>17-03-2023</td>
														</tr>
														<tr>
															<td>BEUCBWP14-B</td>
															<td>25</td>
															<td>17-03-2023</td>
														</tr>
														<tr>
															<td>BEUCBWP14-C</td>
															<td>18</td>
															<td>17-03-2023</td>
														</tr>
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
													<tr>
														<td>BEUCBWP14-A</td>
														<td>15</td>
														<td>17-03-2023</td>
													</tr>
													<tr>
														<td>BEUCBWP14-B</td>
														<td>25</td>
														<td>17-03-2023</td>
													</tr>
													<tr>
														<td>BEUCBWP14-C</td>
														<td>18</td>
														<td>17-03-2023</td>
													</tr>
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
														<th>Pending</th>
														<th>Completed</th>
														<th>Date</th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td>BEUCBWP14-A</td>
														<td>13</td>
														<td>6</td>
														<td>17-03-2023</td>
													</tr>
													<tr>
														<td>BEUCBWP14-B</td>
														<td>25</td>
														<td>14</td>
														<td>17-03-2023</td>
													</tr>
													<tr>
														<td>BEUCBWP14-C</td>
														<td>18</td>
														<td>9</td>
														<td>17-03-2023</td>
													</tr>
													</tbody>
												</table>
											</div>
										</div>
									  </div>
									</li>
									<li class="list-group-item active-status tracking-active-status">
									  <div class="card">
										<h6 class="card-title p-1">Submission</h6>
										<div class="card-body card-body-wrc">
											<div class="table-responsive">
												<table class="table">
													<thead>
													<tr>
														<th>Wrc No</th>
														<th>Click To Copy Final Link</th>
														<th>Date</th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td>BEUCBWP14-A</td>
														<td><a href="#">http://127.0.0.1:8000/clients-creative-lot-timeline/31</a></td>
														<td>17-03-2023</td>
													</tr>
													<tr>
														<td>BEUCBWP14-B</td>
														<td><a href="#">http://127.0.0.1:8000/clients-creative-lot-timeline/31</a></td>
														<td>17-03-2023</td>
													</tr>
													<tr>
														<td>BEUCBWP14-C</td>
														<td><a href="#">http://127.0.0.1:8000/clients-creative-lot-timeline/31</a></td>
														<td>17-03-2023</td>
													</tr>
													</tbody>
												</table>
											</div>
										</div>
									  </div>
									</li>
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
@endsection