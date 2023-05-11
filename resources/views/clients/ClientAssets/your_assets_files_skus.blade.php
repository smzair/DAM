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
									@foreach ($wrc_data['adaptation'] as $adaptation)
										<div class="col-lg-4 col-md-6 mt-2">
											<div class="row brand-div2">
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
													<i class="bi bi-three-dots-vertical"></i>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					@endif

					{{-- Raw images --}}
					@if (count($raw_skus) > 0)
						<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
							tabindex="0">
							<div class="col-12" style="margin-top: 40px;">
								<p style="font-weight: 500;font-size: 12px;color: #9F9F9F;">Total Skus : {{count($raw_skus)}} </p>
							</div>
							<div class="col-12">
								<div class="row" style="margin-top: 10px;">	
									@foreach ($raw_skus as $row)
										<div class="col-lg-4 col-md-6 mt-2">
											<div class="row brand-div2">
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
													<i class="bi bi-three-dots-vertical"></i>
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
						<img src="Group 10 (1).png" alt="" class="img-fluid" style="background: #EBEBEB;padding:19px;">
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
@else
	<div style="margin-top: 40px">
		Wrcs not found
	</div>
		
@endif
@endsection
