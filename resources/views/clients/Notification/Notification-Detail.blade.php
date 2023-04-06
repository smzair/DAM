@extends('layouts.ClientMain')
@section('title')
Notification Detail
@endsection
@section('css_links')
	<link rel="stylesheet" href="">	
	<style>
		.notification-alert-body .notification-alert-content{
			background-color:#b9f1e4dc;
			border: 1px solid #92ecd6;
    	border-radius: 5px;
			padding: 20px;
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
				<div class="row dashboard-template-row notification-template-row">
					<div class="col-12">
							<div class="blank-order-message no-notification-listing d-none" id="noNotification">
									<h2>All notification deleted!!!</h2>
							</div>
							<div class="notification-listing-group">
									<div class="card dashboard-content-card notification-listing-card">
											<div class="card-inner">
												<div class="listing-notify">
													@if (count($ClientNotificatioDetail) > 0)
														<?php 
															$ClientNotificatioDetail_row = $ClientNotificatioDetail;
															$day_ago = timeBefore($ClientNotificatioDetail_row['created_at']);
														?>
														<div class="alert alert-dismissible fade show notification-alert" role="alert">
															<div class="notification-alert-body">
																<div class="notification-alert-content" >
																	<span class="notification-byline notification-alert-desc">
																		<p class="alert-label notificitaion-label" style="text-transform: uppercase;">{{$ClientNotificatioDetail_row['subject']}}</p>
																		<p class="alert-label notificitaion-label">{{ucfirst($ClientNotificatioDetail_row['discription'])}}</p>
																		<span class="alert-label notificitaion-time arrival-time">{{$day_ago}}</span>
																	</span>
																</div>
															</div>
														</div>
														@else
														<div class="alert alert-dismissible fade show notification-alert" role="alert">
																<div class="notification-alert-body">
																		<div class="notification-alert-content">
																			<h3>Notification detail not found</h3>
																		</div>
																</div>
														</div>
													@endif
												</div>
											</div>
									</div>
							</div>
					</div>
					<div class="col-12">
							<div class="toast notification-toast">
									<div class="toast-body">
											<div class="toast-body-inner">
													<p>
															<span class="toast-action toast-icon">
																	<img src="assets-images\Desktop-Assets\dashboard home\trash-white.svg" alt="Trash">
															</span>
															<span class="toast-action toast-msg">
																	Notification successfully deleted.
															</span>
													</p>
													<a href="javascript:;" class="toast-close" data-bs-dismiss="toast">
															<img src="assets-images\Desktop-Assets\dashboard home\close-dark.svg" alt="Close">
													</a>
											</div>
									</div>
							</div>
					</div>
				</div>
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content -->
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