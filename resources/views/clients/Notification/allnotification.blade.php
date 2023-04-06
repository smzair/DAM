@extends('layouts.ClientMain')
@section('title')
  All Notification
@endsection
@section('css_links')
	<link rel="stylesheet" href="">	
	<style>
		.card-inner .listing-notify .notification-alert{
			margin-bottom: 4px;
		}
		.card-inner .listing-notify .seen_notification{
			background-color:#b9f1e4dc;
			border: 1px solid #92ecd6;
    	border-radius: 5px;
		}
		
		.card-inner .listing-notify .unseen_notification{
			background-color: #f3dce1ce;
			border: 1px solid #f8a7b2;
    	border-radius: 5px;
		}

		.card-inner .listing-notify .arrival-time{
			font-size: 10.1px
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
		<div class="content custom-dashboard-content mt-3">
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

                          <?php 
                            // pre($ClientNotification);
                          ?>

                          @foreach ($ClientNotification as $row)

                          <?php
														$day_ago = timeBefore($row['created_at']);
														$is_seen = $row['is_seen'];
														$seen_class = $is_seen == 1 ? 'seen_notification' : 'unseen_notification';
                          ?>
                            <div class="alert alert-dismissible fade show notification-alert {{$seen_class}} " role="alert">
															<a href="{{route('ClientNotificatioDetail',[base64_encode($row['id'])])}}">
																<div class="notification-alert-body">
																	<div class="notification-alert-content">
																		<span class="notification-byline notification-alert-icon">
																		</span>
																		<span class="notification-byline notification-alert-desc">
																				<p class="alert-label notificitaion-label" style="text-transform: uppercase;">{{$row['subject']}}</p>
																				<span class="alert-label notificitaion-time arrival-time">{{$day_ago}} </span>
																		</span>
																	</div>
																</div>
															</a>
                            </div>
                          @endforeach

													{{-- 
													
													<div class="alert alert-dismissible fade show notification-alert" role="alert">
															<div class="notification-alert-body">
																	<div class="notification-alert-content">
																			<span class="notification-byline notification-alert-icon">
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" viewBox="0 0 14 14">
																							<defs>
																								<clipPath id="clip-path">
																									<rect id="Rectangle_2689" data-name="Rectangle 2689" width="14" height="14" transform="translate(0.285 0.285)" fill="#fff"></rect>
																								</clipPath>
																							</defs>
																							<g id="Mask_Group_74" data-name="Mask Group 74" transform="translate(-0.285 -0.285)" clip-path="url(#clip-path)">
																								<path id="send" d="M13.682.823a.56.56,0,0,0-.595-.077L1.543,6.165V7.213L6.392,9.153,9.5,13.937h1.049L13.864,1.394a.56.56,0,0,0-.182-.571ZM9.9,12.937,7.23,8.825l4.113-4.506-.651-.594L6.547,8.265l-4-1.6L12.835,1.838Z" transform="translate(-0.74 0.148)" fill="#fff"></path>
																							</g>
																					</svg>
																			</span>
																			<span class="notification-byline notification-alert-desc">
																					<p class="alert-label notificitaion-label">
																							Your email has been changed.
																					</p>
																					<span class="alert-label notificitaion-time arrival-time">
																							30 min. ago
																					</span>
																			</span>
																	</div>
																	<a href="javascript:;" class="alert-toast nt-alert-toast" data-bs-dismiss="alert" aria-label="Close" id="notification2">
																			<img src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close Icon">
																	</a>
															</div>
													</div>
													<div class="alert alert-dismissible fade show notification-alert" role="alert">
															<div class="notification-alert-body">
																	<div class="notification-alert-content">
																			<span class="notification-byline notification-alert-icon">
																					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="19.988" viewBox="0 0 20 19.988">
																							<path id="__TEMP__SVG__" d="M21.99,7.949a.96.96,0,0,0-.029-.214c-.007-.025-.021-.049-.03-.074a1.036,1.036,0,0,0-.07-.165.766.766,0,0,0-.057-.075.974.974,0,0,0-.1-.13c-.023-.022-.053-.04-.078-.061a.933.933,0,0,0-.12-.094s-.009,0-.014-.006l-.008-.006L12.5,2.136a1,1,0,0,0-.97,0l-9.02,4.99a.042.042,0,0,1-.011.01l-.01,0c-.035.02-.061.049-.094.073a1.068,1.068,0,0,0-.106.082.9.9,0,0,0-.079.1.888.888,0,0,0-.079.1.918.918,0,0,0-.059.139.654.654,0,0,0-.041.1.975.975,0,0,0-.029.21C2.005,7.965,2,7.98,2,8v8a1,1,0,0,0,.515.874l8.977,4.987h0l.02.011a1.022,1.022,0,0,0,.135.054.821.821,0,0,0,.1.039,1.013,1.013,0,0,0,.506,0,.984.984,0,0,0,.1-.039.938.938,0,0,0,.135-.054l.02-.011h0l8.977-4.987A1,1,0,0,0,22,16V8c0-.017-.006-.031-.007-.048ZM11.97,11.871,5.057,8,7.819,6.477l6.833,3.9-2.682,1.49Zm.048-7.719L18.939,8,16.695,9.246l-6.829-3.9,2.152-1.191ZM13,19.3l0-5.678,3-1.678V15l2-1V10.824l2-1.119v5.7L13,19.3Z" transform="translate(-1.999 -2.01)" fill="#7f7faa"></path>
																					</svg>
																			</span>
																			<span class="notification-byline notification-alert-desc">
																					<p class="alert-label notificitaion-label">
																							Your order has been placed.
																					</p>
																					<span class="alert-label notificitaion-time arrival-time">
																							Feb 04, 2022 at 5:55 pm
																					</span>
																			</span>
																			<span class="notification-byline notification-alert-btn">
																					<a href="javascript:;" class="btn nt-alert-btn" id="NotifyTrackBtn">
																							Track order
																					</a>
																			</span>
																	</div>
																	<a href="javascript:;" class="alert-toast nt-alert-toast" data-bs-dismiss="alert" aria-label="Close" id="notification3">
																			<img src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close Icon">
																	</a>
															</div>
													</div>

													<div class="alert alert-dismissible fade show notification-alert" role="alert">
															<div class="notification-alert-body">
																	<div class="notification-alert-content">
																			<span class="notification-byline notification-alert-icon">
																					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="19.988" viewBox="0 0 20 19.988">
																							<path id="__TEMP__SVG__" d="M21.99,7.949a.96.96,0,0,0-.029-.214c-.007-.025-.021-.049-.03-.074a1.036,1.036,0,0,0-.07-.165.766.766,0,0,0-.057-.075.974.974,0,0,0-.1-.13c-.023-.022-.053-.04-.078-.061a.933.933,0,0,0-.12-.094s-.009,0-.014-.006l-.008-.006L12.5,2.136a1,1,0,0,0-.97,0l-9.02,4.99a.042.042,0,0,1-.011.01l-.01,0c-.035.02-.061.049-.094.073a1.068,1.068,0,0,0-.106.082.9.9,0,0,0-.079.1.888.888,0,0,0-.079.1.918.918,0,0,0-.059.139.654.654,0,0,0-.041.1.975.975,0,0,0-.029.21C2.005,7.965,2,7.98,2,8v8a1,1,0,0,0,.515.874l8.977,4.987h0l.02.011a1.022,1.022,0,0,0,.135.054.821.821,0,0,0,.1.039,1.013,1.013,0,0,0,.506,0,.984.984,0,0,0,.1-.039.938.938,0,0,0,.135-.054l.02-.011h0l8.977-4.987A1,1,0,0,0,22,16V8c0-.017-.006-.031-.007-.048ZM11.97,11.871,5.057,8,7.819,6.477l6.833,3.9-2.682,1.49Zm.048-7.719L18.939,8,16.695,9.246l-6.829-3.9,2.152-1.191ZM13,19.3l0-5.678,3-1.678V15l2-1V10.824l2-1.119v5.7L13,19.3Z" transform="translate(-1.999 -2.01)" fill="#7f7faa"></path>
																					</svg>
																			</span>
																			<span class="notification-byline notification-alert-desc">
																					<p class="alert-label notificitaion-label">
																							Your order has been placed.
																					</p>
																					<span class="alert-label notificitaion-time arrival-time">
																							Jan 15, 2022 at 3:15 pm
																					</span>
																			</span>
																			<span class="notification-byline notification-alert-btn">
																					<a href="javascript:;" class="btn nt-alert-btn" id="NotifyReviewBtn">
																							Write a review
																					</a>
																			</span>
																	</div>
																	<a href="javascript:;" class="alert-toast nt-alert-toast" data-bs-dismiss="alert" aria-label="Close" id="notification4">
																			<img src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close Icon">
																	</a>
															</div>
													</div> --}}
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