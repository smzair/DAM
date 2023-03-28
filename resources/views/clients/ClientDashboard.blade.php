@extends('layouts.ClientMain')
@section('title')
  Client Dashboard
@endsection
@section('css_links')
	<link rel="stylesheet" href="">	
	<style>
		/* Style for the scrollbar */
		::-webkit-scrollbar {
		width: 10px; /* Set the width of the scrollbar */
		height: 7px;
		}

		/* Style for the thumb of the scrollbar */
		::-webkit-scrollbar-thumb {
		background-color: #212529; /* Set the background color of the thumb */
		border-radius: 5px; /* Set the border radius of the thumb */
		}

		/* Style for the track of the scrollbar */
		::-webkit-scrollbar-track {
		background-color: #fff; /* Set the background color of the track */
		border-radius: 5px; /* Set the border radius of the track */
		box-shadow: inset 0px 0px 5px rgba(0,0,0,0.2); /* Add a box-shadow to the track */
		}

		/* Style for the scrollbar when hovering over it */
		::-webkit-scrollbar-thumb:hover {
		background-color: #393a3b; /* Set the background color of the thumb when hovering over it */
		}

		/* Style for the scrollbar when it's active */
		::-webkit-scrollbar-thumb:active {
		background-color: #393a3b; /* Set the background color of the thumb when it's active */
		}

		/* Style for the scrollbar when it's in the disabled state */
		::-webkit-scrollbar-thumb:disabled {
		background-color: #ccc; /* Set the background color of the thumb when it's disabled */
		}

		/* Style for the scrollbar when it's in the horizontal state */
		::-webkit-scrollbar-track-piece:end:horizontal {
		background-color: #67efcd; /* Set the background color of the track when it's in the horizontal state */
		}
		.row{
			--bs-gutter-x: 0.5rem;
		}
		 /* target the link using the "lotLink" class */
		.lotLink {
			color: white; /* set the color to white */
			text-decoration: none; /* remove the underline */
    	}
		.lotLink:hover {
			color: #393a3b; /* set the color to gray */
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
		<!-- body (Stat box) -->
			<div class="col-lg-12 col-12">
				@php
					$user = Auth::user();
					$your_assets_permissions = json_decode($user->your_assets_permissions,true);
					$file_manager_permissions = json_decode($user->file_manager_permissions,true);
					$roledata = getUsersRole($user->id);
					$user_role = $roledata != null ? $roledata->role_name : '-';
				@endphp
				@if ($user->dam_enable)

				@if ($user_role == 'Client' || $your_assets_permissions['Creative'])
				{{-- -----lot status for creative start--- --}}
				<div class="card dashboard-content-card order-summary-card">
					<div class="row">
						<div class="order-summary-details whitebg-order-summary">
							<div class="row mb-1">
								<div class="col-xl-9 col-12">
									<span class="action-icon order-icn">
										<img src="assets-images\Desktop-Assets\dashboard home\order-icon-for-card.svg" alt="Order icon">
									</span>
									<span class="action-text order-nm" id="orderName">
										Clients Lot Status (Creative)
									</span>
								</div>
							</div>
							<div class="row">
								@foreach ($resData as $key => $val)
									<div class="col-xl-6 col-md-6 col-sm-12">
										<div class="order-timeline-details greenbg-order-summary mb-1" style="width: 100%;">
											<div class="row">
												<div class="col-xl-12 col-sm-12">
													<div class="status-text">
														<h6><a class="lotLink" target="_blank" href={{route('clientsCreativelotTimeline',$val['lot_id'])}}>Lot No:- {{ $val['lot_number'] }}</a></h6>
													</div>
													<div class="order-timeline">
														<ul style="overflow: auto;padding-top: 15px;padding-left: 10px;">
															@php 
																$previousActive = true;
															@endphp
															@foreach(['Inverd Pending', 'Allocation Pending', 'Uploading Pending', 'Qc Pending', 'Submission Pending'] as $status)
																@php 
																	$active = ($val['lot_status'] == $status);
																@endphp
																<li 
																	@if ($active)
																		class="active-status" 
																		@php $previousActive = false; @endphp 
																	@elseif ($previousActive) 
																		class="active-status" 
																	@endif
																>
																	<span class="status-tag" id="{{ strtolower(str_replace(' ', '', $status)) }}">
																		{{ $status }}
																	</span>
																</li>
															@endforeach
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				{{-- -----lot status for creative end--- --}}
				@endif

				@if ($user_role == 'Client' || $your_assets_permissions['Cataloging'])
				{{-- -----lot status catlog start--- --}}
				<div class="card dashboard-content-card order-summary-card">
					<div class="row">
						<div class="order-summary-details whitebg-order-summary">
							<div class="row mb-1">
								<div class="col-xl-9 col-12">
									<span class="action-icon order-icn">
										<img src="assets-images\Desktop-Assets\dashboard home\order-icon-for-card.svg" alt="Order icon">
									</span>
									<span class="action-text order-nm" id="orderName">
										Clients Lot Status (Catlog)
									</span>
								</div>
							</div>
							<div class="row">
								@foreach ($resDataCatlog as $key => $val)
									<div class="col-xl-6 col-md-6 col-sm-12">
										<div class="order-timeline-details greenbg-order-summary mb-1" style="width: 100%;">
											<div class="row">
												<div class="col-xl-12 col-sm-12">
													<div class="status-text">
														<h6><a class="lotLink" target="_blank" href={{route('clientsCatloglotTimeline',$val['lot_id'])}}>Lot No:- {{ $val['lot_number'] }}</a></h6>
													</div>
													<div class="order-timeline">
														<ul style="overflow: auto;padding-top: 15px;padding-left: 10px;">
															@php 
																$previousActive = true;
															@endphp
															@foreach(['Inverd Pending', 'Allocation Pending', 'Uploading Pending', 'Qc Pending', 'Submission Pending'] as $status)
																@php 
																	$active = ($val['lot_status'] == $status);
																@endphp
																<li 
																	@if ($active)
																		class="active-status" 
																		@php $previousActive = false; @endphp 
																	@elseif ($previousActive) 
																		class="active-status" 
																	@endif
																>
																	<span class="status-tag" id="{{ strtolower(str_replace(' ', '', $status)) }}">
																		{{ $status }}
																	</span>
																</li>
															@endforeach
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				{{-- -----lot status catlog end-----}}
				@endif

				@if ($user_role == 'Client' || $your_assets_permissions['Editing'])
				{{-- -----lot status for editor start--- --}}
				<div class="card dashboard-content-card order-summary-card">
					<div class="row">
						<div class="order-summary-details whitebg-order-summary">
							<div class="row mb-1">
								<div class="col-xl-9 col-12">
									<span class="action-icon order-icn">
										<img src="assets-images\Desktop-Assets\dashboard home\order-icon-for-card.svg" alt="Order icon">
									</span>
									<span class="action-text order-nm" id="orderName">
										Clients Lot Status (Editor)
									</span>
								</div>
							</div>
							<div class="row">
								@foreach ($resDataEditor as $key => $val)
									<div class="col-xl-6 col-md-6 col-sm-12">
										<div class="order-timeline-details greenbg-order-summary mb-1" style="width: 100%;">
											<div class="row">
												<div class="col-xl-12 col-sm-12">
													<div class="status-text">
														<h6><a class="lotLink" target="_blank" href={{route('clientsEditorLotTimeline',$val['lot_id'])}}>Lot No:- {{ $val['lot_number'] }}</a></h6>
													</div>
													<div class="order-timeline">
														<ul style="overflow: auto;padding-top: 15px;padding-left: 10px;">
															@php 
																$previousActive = true;
															@endphp
															@foreach(['Inverd Pending', 'Allocation Pending', 'Uploading Pending', 'Qc Pending', 'Submission Pending'] as $status)
																@php 
																	$active = ($val['lot_status'] == $status);
																@endphp
																<li 
																	@if ($active)
																		class="active-status" 
																		@php $previousActive = false; @endphp 
																	@elseif ($previousActive) 
																		class="active-status" 
																	@endif
																>
																	<span class="status-tag" id="{{ strtolower(str_replace(' ', '', $status)) }}">
																		{{ $status }}
																	</span>
																</li>
															@endforeach
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				{{-- -----lot status for editor end--- --}}
				@endif

				@if ($user_role == 'Client' || $your_assets_permissions['shoot'])
				{{-- -----lot status shoot start--- --}}
				<div class="card dashboard-content-card order-summary-card">
					<div class="row">
						<div class="order-summary-details whitebg-order-summary">
							<div class="row mb-1">
								<div class="col-xl-9 col-12">
									<span class="action-icon order-icn">
										<img src="assets-images\Desktop-Assets\dashboard home\order-icon-for-card.svg" alt="Order icon">
									</span>
									<span class="action-text order-nm" id="orderName">
										Clients Lot Status (Shoot)
									</span>
								</div>
							</div>
							<div class="row">
								@foreach ($resDataShoot as $key => $val)
									<div class="col-xl-6 col-md-6 col-sm-12">
										<div class="order-timeline-details greenbg-order-summary mb-1" style="width: 100%;">
											<div class="row">
												<div class="col-xl-12 col-sm-12">
													<div class="status-text">
														<h6><a class="lotLink" target="_blank" href={{route('clientsShootlotTimeline',$val['lot_id'])}}>Lot No:- {{ $val['lot_number'] }}</a></h6>
													</div>
													<div class="order-timeline">
														<ul style="overflow: auto;padding-top: 15px;padding-left: 10px;">
															@php 
																$previousActive = true;
															@endphp
															@foreach(['Inverd Done', 'Shoot Done', 'Editing/Qc Done', 'Submission Done', 'Invoice Done'] as $status)
																@php 
																	$active = ($val['lot_status'] == $status);
																@endphp
																<li 
																	@if ($active)
																		class="active-status" 
																		@php $previousActive = false; @endphp 
																	@elseif ($previousActive) 
																		class="active-status" 
																	@endif
																>
																	<span class="status-tag" id="{{ strtolower(str_replace(' ', '', $status)) }}">
																		{{ $status }}
																	</span>
																</li>
															@endforeach
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				{{-- -----lot status shoot end-----}}
				@endif
				@endif
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