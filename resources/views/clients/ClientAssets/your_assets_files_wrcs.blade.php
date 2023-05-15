@extends('layouts.DamNewMain')
@section('title')
  Your Assets - WRCs
@endsection

@section('main_content')
@php
	$user = Auth::user();
	$your_assets_permissions = json_decode($user->your_assets_permissions,true);
	$file_manager_permissions = json_decode($user->file_manager_permissions,true);
	$roledata = getUsersRole($user->id);
	$user_role = $roledata != null ? $roledata->role_name : '-';
	$service_is; // get from controller and based on service_is route will be deside on wrc click 
	// dd($wrc_data);
if($service_is == 'Shoot'){
	$route_is = 'your_assets_shoot_skus';
	$download_route_is = 'download_Shoot_lot_Edited_wrc';
}else{
	$route_is = 'your_assets_files_editing_uploaded_images';
	$download_route_is = 'download_Editing_lot_Edited_wrc';
}

@endphp

@if (count($wrc_data) > 0)
	<div class="row">
		<div class="col-12" style="margin-top: 24px;">
			<nav
				style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
				aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">{{$wrc_data[0]['lot_number']}}</li>
					<li class="breadcrumb-item active breadcrumb-deco" aria-current="page">WRCs</li>
				</ol>
			</nav>
		</div>
		<div class="col-12" style="margin-top: 40px;">
			<p style="font-weight: 500;font-size: 12px;color: #9F9F9F;">Total WRC : {{count($wrc_data)}}</p>
		</div>
	</div>
	{{-- WRCs details --}}
	<div class="row" style="margin-top: 12px;">
		{{-- <div class="col-lg-3 col-md-6 mt-2">
			<div class="accordion accordion-flush" id="accordionFlushExample">
				<div class="accordion-item">
					<h2 class="accordion-header" id="flush-headingFour">
						<button class="btn collapsed siderbar-button rounded-0" type="button" data-bs-toggle="collapse"
							data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">

							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect width="20" height="20" fill="#9F9F9F" />
								<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
								<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
							</svg> &nbsp;&nbsp;
							DEMO1TWSR9-A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<i class="bi bi-three-dots-vertical" style="font-size:20px"></i>
						</button>

					</h2>
					<div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour"
						data-bs-parent="#accordionFlushExample">
						<div class="accordion-body">
							<div class="col-12">
								<p class="TAGS">TAGS
									<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g clip-path="url(#clip0_92_3135)">
											<path
												d="M7.00004 9.33301L7.00004 6.41634M7.00004 1.16634C3.79171 1.16634 1.16671 3.79134 1.16671 6.99968C1.16671 10.208 3.79171 12.833 7.00004 12.833C10.2084 12.833 12.8334 10.208 12.8334 6.99967C12.8334 3.79134 10.2084 1.16634 7.00004 1.16634Z"
												stroke="#9F9F9F" stroke-linecap="round" stroke-linejoin="round" />
											<path d="M7.00293 4.66699L6.99493 4.66699" stroke="#9F9F9F" stroke-linecap="round"
												stroke-linejoin="round" />
										</g>
										<defs>
											<clipPath id="clip0_92_3135">
												<rect width="14" height="14" fill="white" transform="translate(14 14) rotate(180)" />
											</clipPath>
										</defs>
									</svg>
								</p>
							</div>
							<div class="row">
								<div class="col-4">
									<button type="button" class="btn btn-sm under-acco-button">Black Tees</button>
								</div>
								<div class="col-4">
									<button type="button" class="btn btn-sm under-acco-button">FSN code</button>
								</div>
								<div class="col-4">
									<button type="button" class="btn btn-sm under-acco-button">ASIN code</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> --}}

		@foreach ($wrc_data as $key => $row)
			<div class="col-lg-3 col-md-6 mt-2">
				<div class="accordion" id="accordionExample{{$key}}">
					<div class="card z-depth-0 bordered">
						<div class="card-header card-header-style" id="headingOne{{$key}}"background: #D1D1D1;>
							<h5 class="mb-0">
								<a href="{{route($route_is , [ base64_encode($row['wrc_id'])])}}" class="btn " type="button" data-toggle="collapse" data-target="#collapseOne{{$key}}"
									aria-expanded="true" aria-controls="collapseOne{{$key}}">
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect width="20" height="20" fill="#9F9F9F" />
										<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
										<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
									</svg> <span>{{$row['wrc_number']}}</span>                     
								</a>
								<span class="test btn myButton" role="button" style="float: right"> <i class="bi bi-three-dots-vertical" style="font-size:20px"></i></span>
								<div class="myPopover" style="display: none;">
									@php
											
									@endphp
									<a href="{{route($download_route_is , [ base64_encode($row['wrc_id']) ] )}}">Download</a>
									<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >link</a>
									<p class="d-none" id="url_{{$key}}">{{route($download_route_is , [ base64_encode($row['wrc_id']) ] )}}</p>
									<a href="#">Favorite</a>
								</div>
							</h5>
						</div>
						<div id="collapseOne{{$key}}" class="collapse show" aria-labelledby="headingOne{{$key}}" data-parent="#">
							<div class="card-body card-body-style">
								<div class="col-12">
									<p class="TAGS">TAGS
										<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
											<g clip-path="url(#clip0_92_3135)">
												<path
													d="M7.00004 9.33301L7.00004 6.41634M7.00004 1.16634C3.79171 1.16634 1.16671 3.79134 1.16671 6.99968C1.16671 10.208 3.79171 12.833 7.00004 12.833C10.2084 12.833 12.8334 10.208 12.8334 6.99967C12.8334 3.79134 10.2084 1.16634 7.00004 1.16634Z"
													stroke="#9F9F9F" stroke-linecap="round" stroke-linejoin="round" />
												<path d="M7.00293 4.66699L6.99493 4.66699" stroke="#9F9F9F" stroke-linecap="round"
													stroke-linejoin="round" />
											</g>
											<defs>
												<clipPath id="clip0_92_3135">
													<rect width="14" height="14" fill="white" transform="translate(14 14) rotate(180)" />
												</clipPath>
											</defs>
										</svg>
									</p>
								</div>
								<div class="row">
									<div class="col-4">
										<button type="button" class="btn btn-sm under-acco-button">Black Tees</button>
									</div>
									<div class="col-4">
										<button type="button" class="btn btn-sm under-acco-button">FSN code</button>
									</div>
									<div class="col-4">
										<button type="button" class="btn btn-sm under-acco-button">ASIN code</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
			{{-- <div class="col-lg-3 col-md-6  mt-2">
				<div class="accordion accordion-flush" id="accordionFlushExample">
					<div class="accordion-item">
						<h2 class="accordion-header" id="flush-heading{{$key}}">
							<button class="btn collapsed siderbar-button rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$key}}" aria-expanded="false" aria-controls="flush-collapse{{$key}}">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect width="20" height="20" fill="#9F9F9F" />
									<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
									<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
								</svg> <span>{{$row['wrc_number']}}</span>
								<i class="bi bi-three-dots-vertical" style="font-size:20px"></i>
							</button>
						</h2>
						<div id="flush-collapse{{$key}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$key}}"
							data-bs-parent="#accordionFlushExample">
							<div class="accordion-body">
								<div class="col-12">
									<p class="TAGS">TAGS
										<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
											<g clip-path="url(#clip0_92_3135)">
												<path
													d="M7.00004 9.33301L7.00004 6.41634M7.00004 1.16634C3.79171 1.16634 1.16671 3.79134 1.16671 6.99968C1.16671 10.208 3.79171 12.833 7.00004 12.833C10.2084 12.833 12.8334 10.208 12.8334 6.99967C12.8334 3.79134 10.2084 1.16634 7.00004 1.16634Z"
													stroke="#9F9F9F" stroke-linecap="round" stroke-linejoin="round" />
												<path d="M7.00293 4.66699L6.99493 4.66699" stroke="#9F9F9F" stroke-linecap="round"
													stroke-linejoin="round" />
											</g>
											<defs>
												<clipPath id="clip0_92_3135">
													<rect width="14" height="14" fill="white" transform="translate(14 14) rotate(180)" />
												</clipPath>
											</defs>
										</svg>
									</p>
								</div>
								<div class="row">
									<div class="col-4">
										<button type="button" class="btn btn-sm under-acco-button">Black Tees</button>
									</div>
									<div class="col-4">
										<button type="button" class="btn btn-sm under-acco-button">FSN code</button>
									</div>
									<div class="col-4">
										<button type="button" class="btn btn-sm under-acco-button">ASIN code</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> --}}
	</div>
@else
	<div style="margin-top: 40px">
		Wrcs not found
	</div>
		
@endif
@endsection
