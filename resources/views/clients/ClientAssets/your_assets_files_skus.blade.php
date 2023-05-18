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
	
@endphp

@if (count($wrc_data) > 0)
<div class="row">
	<div class="col-lg-9">
		<div class="col-12" style="margin-top: 24px;">
			<nav
				style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
				aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><span class="breadcrumb-deco">{{$wrc_data['lot_number']}}</span></li>
					<li class="breadcrumb-item"><a class="breadcrumb-deco" href="{{route('your_assets_shoot_wrcs' , [$wrc_data['lot_id']])}}">WRCs</a></li>
					<li class="breadcrumb-item active breadcrumb-deco" aria-current="page">{{$wrc_data['wrc_number']}}</li>
				</ol>
			</nav>
		</div>
		@if (count($wrc_data['adaptation']) > 0 || count($raw_skus) > 0)
			<div class="col-lg-12 d-flex" style="margin-top:40px">
				<ul class="nav nav-pills mb-3 nav-fill" id="pills-tab" role="tablist">
					{{-- Edited Images --}}
					@if (count($wrc_data['adaptation']) > 0)
						<li class="nav-item" role="presentation">
							<button class="nav-link active btn-lg editedandraw-img-btn" id="pills-home-tab" data-bs-toggle="pill"
								data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
								aria-selected="true">
								Edited Images
							</button>
						</li>
					@endif

					{{-- Raw images --}}
					@if (count($raw_skus) > 0)
						<li class="nav-item" role="presentation">
							<button class="nav-link btn-lg editedandraw-img-btn" id="pills-profile-tab" data-bs-toggle="pill"
								data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
								aria-selected="false">
								Raw images
							</button>
						</li>
					@endif

				</ul>
			</div>
			
			<div class="row">
				<div class="tab-content" id="pills-tabContent">
					{{-- Edited images --}}
					@if (count($wrc_data['adaptation']) > 0)

						<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
							tabindex="0">
							<div class="col-12" style="margin-top: 40px;">
								<p style="font-weight: 500;font-size: 12px;color: #9F9F9F;">Total Adaptations: {{count($wrc_data['adaptation'])}}</p>
							</div>

							<div class="col-12">
								<div class="row" style="margin-top: 10px;">
									@foreach ($wrc_data['adaptation'] as $key => $adaptation)
										<div class="col-lg-4 col-md-6 mt-2">
											<div class="row brand-div2" style="position: relative">
												<div class="col-2 mt-3">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
														xmlns="http://www.w3.org/2000/svg">
														<rect width="24" height="24" fill="#9F9F9F" />
														<line x1="3.95353" y1="3.24606" x2="20.7535" y2="20.0461" stroke="#D1D1D1" />
														<line x1="3.24642" y1="20.0459" x2="20.0464" y2="3.24586" stroke="#D1D1D1" />
													</svg>
												</div>
												<div class="col-8 mt-2">
													<a style="text-decoration: none;" href="{{route('your_assets_shoot_adaptation_skus' , [ base64_encode($wrc_data['wrc_id']) , base64_encode($adaptation)])}}">
														<p class="brand">{{$adaptation}}</p>
													</a>
												</div>
												<div class="col-2 mt-3">
													<i class="bi bi-three-dots-vertical test myButton" style="font-size:20px" role="button"></i>
														<div class="myPopover" style="display: none;">
															@php
																	$download_route_is = "download_Shoot_lot_Edited_adaptation";
															@endphp
															<a href="{{route($download_route_is , [ 'wrc_id' => base64_encode($wrc_data['wrc_id']) , 'adaptation' => base64_encode($adaptation) ] )}}">Download</a>
															<a href="javascript:void(0)" onclick="toggleSidebar()">View Details</a>
															
															<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key}}' , 'Shoot Lot WRC adaptation Image' , 'Shoot WRC')" >Share</a>
															<p class="d-none" id="url_{{$key}}">{{route($download_route_is , [ 'wrc_id' => base64_encode($wrc_data['wrc_id']) , 'adaptation' => base64_encode($adaptation) ] )}}</p>
															
															<a href="javascript:void(0)">Favorite</a>
															<a href="javascript:void(0)">Add Tag</a>
														</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					@endif

					{{-- Raw images --}}
					@php
						// dd($raw_skus);
					@endphp
					@if (count($raw_skus) > 0)
						<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
							tabindex="0">
							<div class="col-12" style="margin-top: 40px;">
								<p style="font-weight: 500;font-size: 12px;color: #9F9F9F;">Total Skus : {{count($raw_skus)}} </p>
							</div>
							<div class="col-12">
								<div class="row" style="margin-top: 10px;">	
									@foreach ($raw_skus as $key => $row)
										<div class="col-lg-4 col-md-6 mt-2">
											<div class="row brand-div2" style="position: relative;">
												<div class="col-2 mt-3">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
														xmlns="http://www.w3.org/2000/svg">
														<rect width="24" height="24" fill="#9F9F9F" />
														<line x1="3.95353" y1="3.24606" x2="20.7535" y2="20.0461" stroke="#D1D1D1" />
														<line x1="3.24642" y1="20.0459" x2="20.0464" y2="3.24586" stroke="#D1D1D1" />
													</svg>
												</div>
												<div class="col-8 mt-2">
													<a style="text-decoration: none;" href="{{route('your_assets_files_shoot_raw_images' , [base64_encode($row['sku_id'])] )}}">
														<p class="brand">{{$row['sku_code']}}</p>
													</a>
												</div>
												<div class="col-2 mt-3">
													<i class="bi bi-three-dots-vertical test myButton" style="font-size:20px" role="button"></i>
														<div class="myPopover" style="display: none;">
															@php
																	$download_route_is = "download_Shoot_lot_raw_sku";
															@endphp
															<a href="{{route($download_route_is , [ 'wrc_id' => base64_encode($row['wrc_id']) , 'sku_id' => base64_encode($row['sku_code']) ] )}}">Download</a>
															
															<a href="javascript:void(0)" onclick="toggleSidebar()">View Details</a>

															<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key.$row['wrc_id']}}' , 'Shoot Lot WRC Sku Image' , 'Shoot WRC')" >Share</a>
															<p class="d-none" id="url_{{$key.$row['wrc_id']}}">{{route($download_route_is , [ 'wrc_id' => base64_encode($row['wrc_id']) , 'sku_id' => base64_encode($row['sku_code'])] )}}</p>
															
															<a href="javascript:void(0)">Favorite</a>
															<a href="javascript:void(0)">Add Tag</a>
														</div>
												</div>
											</div>
										</div>
									@endforeach					
								</div>
							</div>
						</div>
					@endif
				</div>
			</div>
		@else
			<div style="margin-top: 40px;">Wrcs Data not found</div>
		@endif
	</div>
	
	<div class="col-lg-3 d-none" style="margin-top: 24px;">

		<div class="row">
			<div class="col-12">
				<p>Actions</p>
			</div>

			<div class="col-7 d-flex justify-content-between">
				<button class="btn">
					<svg class="" width="40" height="40" viewBox="0 0 40 40" fill="none"
						xmlns="http://www.w3.org/2000/svg">
						<rect width="40" height="40" fill="#9F9F9F" />
						<line x1="4.89896" y1="4.19235" x2="35.4444" y2="34.7378" stroke="#D1D1D1" />
						<line x1="4.19186" y1="34.7382" x2="34.7373" y2="4.19279" stroke="#D1D1D1" />
					</svg>
				</button>

				<button class="btn">
					<svg class="" width="40" height="40" viewBox="0 0 40 40" fill="none"
						xmlns="http://www.w3.org/2000/svg">
						<rect width="40" height="40" fill="#9F9F9F" />
						<line x1="4.89896" y1="4.19235" x2="35.4444" y2="34.7378" stroke="#D1D1D1" />
						<line x1="4.19186" y1="34.7382" x2="34.7373" y2="4.19279" stroke="#D1D1D1" />
					</svg>
				</button>
				<button class="btn">
					<svg class="" width="40" height="40" viewBox="0 0 40 40" fill="none"
						xmlns="http://www.w3.org/2000/svg">
						<rect width="40" height="40" fill="#9F9F9F" />
						<line x1="4.89896" y1="4.19235" x2="35.4444" y2="34.7378" stroke="#D1D1D1" />
						<line x1="4.19186" y1="34.7382" x2="34.7373" y2="4.19279" stroke="#D1D1D1" />
					</svg>
				</button>
				<button class="btn">
					<svg class="" width="40" height="40" viewBox="0 0 40 40" fill="none"
						xmlns="http://www.w3.org/2000/svg">
						<rect width="40" height="40" fill="#9F9F9F" />
						<line x1="4.89896" y1="4.19235" x2="35.4444" y2="34.7378" stroke="#D1D1D1" />
						<line x1="4.19186" y1="34.7382" x2="34.7373" y2="4.19279" stroke="#D1D1D1" />
					</svg>
				</button>
			</div>
			<hr class="mt-4">

			<div class="col-12 d-flex justify-content-between">
				<p class="mt-3 side-lot">Ajio</p>
				<button type="button" class="btn btn-light border-0 rounded-circle"
					style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; background: #FFFFFF;">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M9.17 14.83L14.83 9.17M14.83 14.83L9.17 9.17M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z"
							stroke="#9F9F9F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</button>
			</div>

			<div class="col-12">
				<div class="row">
					<div class="col-12" style="margin-top: 16px;">
						<img src="{{asset('IMG/group_10.png')}}" alt="" class="img-fluid" style="background: #EBEBEB;padding:19px;">
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="row">
					<div class="col-12" style="margin-top: 24px;">
						<p class="heading-details">Folder details</p>
					</div>
					<div class="col-9">
						<p class="side-text">DATE & TIME</p>
						<div class="d-flex justify-content-between">
							<p class="side-text2">
								<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect width="14" height="14" fill="#9F9F9F" />
									<line x1="1.94437" y1="1.23727" x2="12.6353" y2="11.9282" stroke="#D1D1D1" />
									<line x1="1.23727" y1="11.9282" x2="11.9282" y2="1.23728" stroke="#D1D1D1" />
								</svg>
								16-04-23
							</p>
							<p class="side-text2">
								<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect width="14" height="14" fill="#9F9F9F" />
									<line x1="1.94437" y1="1.23727" x2="12.6353" y2="11.9282" stroke="#D1D1D1" />
									<line x1="1.23727" y1="11.9282" x2="11.9282" y2="1.23728" stroke="#D1D1D1" />
								</svg>
								19:52
							</p>
						</div>
					</div>
					<div class="col-12">
						<p class="side-text">SIZE</p>
						<P class="side-text2">4.20 GB</P>
					</div>
					<div class="col-12">
						<p class="side-text">TAGS</p>
						<P class="side-text2">Black Tees, Ajio code</P>
					</div>

					<div class="col-12 d-grid gap-2">
						<button class="btn border rounded-0 add-more-tag-btn" type="button">
							+ Add more tags
						</button>
					</div>
					<div class="col-12 mt-3">
						<button class="remove-tag border-0" style="background: #FFFFFF;">- Remove tags</button>
					</div>
					<hr class="mt-4">
				</div>
			</div>
			<div class="col-12">
				<div class="row">

					<div class="col-12" style="margin-top: 24px;">
						<p class="heading-details">Share</p>
					</div>

					<div class="col-12 d-grid gap-2 my-2">
						<button class="btn border rounded-0 side-text2" type="button">
							<svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect x="0.5" width="14" height="14" fill="#9F9F9F" />
								<line x1="2.44437" y1="1.23727" x2="13.1353" y2="11.9282" stroke="#D1D1D1" />
								<line x1="1.73727" y1="11.9287" x2="12.4282" y2="1.23776" stroke="#D1D1D1" />
							</svg>
							Create link
						</button>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- sidebar popup start -->
<div class="sidebar">
	<div class="row">
		<div class="col-12 d-flex justify-content-between ps-4">
			<p class="mt-3 side-lot">DEMO1TWSR9-A</p>
			<button onclick="toggleSidebar()" type="button" class="btn border-0 close-button">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path
						d="M14.19 0H5.81C2.17 0 0 2.17 0 5.81V14.18C0 17.83 2.17 20 5.81 20H14.18C17.82 20 19.99 17.83 19.99 14.19V5.81C20 2.17 17.83 0 14.19 0ZM13.36 12.3C13.65 12.59 13.65 13.07 13.36 13.36C13.21 13.51 13.02 13.58 12.83 13.58C12.64 13.58 12.45 13.51 12.3 13.36L10 11.06L7.7 13.36C7.55 13.51 7.36 13.58 7.17 13.58C6.98 13.58 6.79 13.51 6.64 13.36C6.50052 13.2189 6.4223 13.0284 6.4223 12.83C6.4223 12.6316 6.50052 12.4411 6.64 12.3L8.94 10L6.64 7.7C6.50052 7.55886 6.4223 7.36843 6.4223 7.17C6.4223 6.97157 6.50052 6.78114 6.64 6.64C6.93 6.35 7.41 6.35 7.7 6.64L10 8.94L12.3 6.64C12.59 6.35 13.07 6.35 13.36 6.64C13.65 6.93 13.65 7.41 13.36 7.7L11.06 10L13.36 12.3Z"
						fill="white" />
				</svg>
			</button>
		</div>

		<div class="col-12 wrc-detail-img ">
			<div class="row">
				<div class="col-12 ps-4 pe-4" style="margin-top: 16px;">
					<img src="{{asset('IMG/group_10.png')}}" alt="" class="img-fluid" style="background: rgba(255, 255, 255, 0.1);">
				</div>
			</div>
		</div>

		<div class="col-12">
			<div class="row">
				<div class="col-12 ps-4" style="margin-top: 24px;">
					<p class="heading-details">Folder details</p>
				</div>
				<div class="col-9 ps-4">
					<p class="side-text ">DATE & TIME</p>
					<div class="d-flex justify-content-between ">
						<p class="side-text2 ">
							<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect width="14" height="14" fill="#9F9F9F" />
								<line x1="1.94437" y1="1.23727" x2="12.6353" y2="11.9282" stroke="#D1D1D1" />
								<line x1="1.23727" y1="11.9282" x2="11.9282" y2="1.23728" stroke="#D1D1D1" />
							</svg>
							16-04-23
						</p>
						<p class="side-text2 ">
							<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect width="14" height="14" fill="#9F9F9F" />
								<line x1="1.94437" y1="1.23727" x2="12.6353" y2="11.9282" stroke="#D1D1D1" />
								<line x1="1.23727" y1="11.9282" x2="11.9282" y2="1.23728" stroke="#D1D1D1" />
							</svg>
							19:52
						</p>
					</div>
				</div>
				<div class="col-12 ps-4">
					<p class="side-text">SIZE</p>
					<P class="side-text2">4.20 GB</P>
				</div>
				<div class="col-12 ps-4">
					<p class="side-text">TAGS</p>
					<P class="side-text2">Black Tees, Ajio code</P>
				</div>

				<div class="col-12 d-grid gap-2 ps-4 pe-4">
					<button class="btn border rounded-0  heading-details" type="button">
						<svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M11.5529 4.53224L4.71122 11.7739C4.45289 12.0489 4.20289 12.5906 4.15289 12.9656L3.84455 15.6656C3.73622 16.6406 4.43622 17.3072 5.40289 17.1406L8.08622 16.6822C8.46122 16.6156 8.98622 16.3406 9.24455 16.0572L16.0862 8.81558C17.2696 7.56558 17.8029 6.14058 15.9612 4.39891C14.1279 2.67391 12.7362 3.28224 11.5529 4.53224Z"
								stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
								stroke-linejoin="round" />
							<path
								d="M10.4111 5.74121C10.5858 6.85859 11.1266 7.88632 11.9486 8.66308C12.7707 9.43984 13.8273 9.92165 14.9528 10.0329"
								stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
								stroke-linejoin="round" />
						</svg>
						&nbsp; Edit tag
					</button>
				</div>
				
				<div class="col-12 ps-4" style="margin-top: 24px;">
					<p class="heading-details">Share</p>
				</div>

				<div class="col-12 d-grid gap-2 my-2 ps-4 pe-4">
					<button class="btn border rounded-0 side-text2" type="button">
						<svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect x="0.5" width="14" height="14" fill="#9F9F9F" />
							<line x1="2.44437" y1="1.23727" x2="13.1353" y2="11.9282" stroke="#D1D1D1" />
							<line x1="1.73727" y1="11.9287" x2="12.4282" y2="1.23776" stroke="#D1D1D1" />
						</svg>
						Create link
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- sidebar popup end -->
@else
	<div style="margin-top: 40px">
		Wrcs not found
	</div>
		
@endif
@endsection
