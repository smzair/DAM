@extends('layouts.DamNewMain')
@section('title')
  Your Assets - Editing uploaded images
@endsection

@section('main_content')
<style>
	.myPopover{
		top: 60%;
	}
</style>
@php
	$user = Auth::user();
	$your_assets_permissions = json_decode($user->your_assets_permissions,true);
	$file_manager_permissions = json_decode($user->file_manager_permissions,true);
	$roledata = getUsersRole($user->id);
	$user_role = $roledata != null ? $roledata->role_name : '-';
	
@endphp

@if (count($wrc_data) > 0)
<div class="row">
	<div class="col-lg-12">
		<div class="col-12" style="margin-top: 24px;">
			<nav
				style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
				aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><span class="breadcrumb-deco">{{$wrc_data['lot_number']}}</span></li>
					<li class="breadcrumb-item"><a class="breadcrumb-deco" href="{{route('your_assets_editing_wrcs' , [$wrc_data['lot_id']])}}">WRCs</a></li>
					<li class="breadcrumb-item active breadcrumb-deco" aria-current="page">{{$wrc_data['wrc_number']}}</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 d-flex" style="margin-top:40px">
			<ul class="nav nav-pills mb-3 nav-fill" id="pills-tab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active btn-lg editedandraw-img-btn" id="pills-home-tab" data-bs-toggle="pill"
						data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
						aria-selected="true">
						Edited Images
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link btn-lg editedandraw-img-btn" id="pills-profile-tab" data-bs-toggle="pill"
						data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
						aria-selected="false">
						Raw images
					</button>
				</li>
			</ul>
		</div>
		
		<div class="row">
			<div class="tab-content" id="pills-tabContent">
				{{-- Edited images --}}
				<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
					tabindex="0">
					<div class="col-12" style="margin-top: 40px;">
						<p style="font-weight: 500;font-size: 12px;color: #9F9F9F;">Total Edited images: {{count($wrc_edited_images)}}</p>
					</div>

					@if (count($wrc_edited_images) > 0)
						<div class="col-12">
							<div class="row" style="margin-top: 10px;">
								@foreach ($wrc_edited_images as $key => $row)
								@php
									$path = $row['file_path'].$row['filename'];
									$img_src = 'IMG/group_10.png';
									$zipFileSize = "File Not Found!!";
									if(file_exists($path)){
										$img_src = $path;
										$zipFileSize = filesize($path);
										$zipFileSize = formatBytes($zipFileSize);
									}
								@endphp
								<div class="col-sm-6 col-md-4 col-lg-3 mt-2">
									<div class="card brand-img-m border-0 rounded-0">
										<img class="card-img-top brand-img" src="{{ asset($img_src)}}" alt="Image">
										<div class="card-body d-flex justify-content-between" style="position: relative">
											<p class="brand-img-name" id="lot_number{{$row['upladed_img_id'].$key}}">{{$row['filename']}}</p>
											<i class="bi bi-three-dots-vertical myButton" style="cursor: pointer;"></i>
											
											<div class="myPopover" style="display: none; top 20%;">
												<a href="{{ asset($img_src)}}" download="{{$row['filename']}}">Download</a>
												
												<a href="javascript:void(0)" onclick="toggleSidebar(); set_date({{$row['upladed_img_id'].$key}});">View Details</a>
												<div class="d-none">
													<span id="lot_date{{$row['upladed_img_id'].$key}}">{{dateFormet_dmy($row['created_at'])}}</span>
													<span id="lot_time{{$row['upladed_img_id'].$key}}">{{date('h:i A', strtotime($row['created_at']))}}</span>
													<span id="file_size{{$row['upladed_img_id'].$key}}">{{ $zipFileSize }}</span>
												</div>

												<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key}}' , 'Editing Lot Edited Image' , 'Editing lot')" >link</a>
												<p class="d-none" id="url_{{$key}}">{{ asset($img_src)}}</p>
											</div>
										</div>
									</div>
								</div>		
								@endforeach
							</div>
						</div>
					@else
							<p>Edited images Not found</p>
					@endif
				</div>

				{{-- Raw images --}}
				<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
					tabindex="0">
					<div class="col-12" style="margin-top: 40px;">
						<p style="font-weight: 500;font-size: 12px;color: #9F9F9F;">Total Skus : {{count($wrc_raw_images)}} </p>
					</div>
					<div class="col-12">
						@if (count($wrc_raw_images) > 0)
							<div class="row" style="margin-top: 10px;">	
								@foreach ($wrc_raw_images as $row)
									@php
										$path = $row['file_path'].$row['filename'];
										$img_src = 'IMG/group_10.png';
										$zipFileSize = "File Not Found!!";
										if(file_exists($path)){
											$img_src = $path;
											$zipFileSize = filesize($path);
											$zipFileSize = formatBytes($zipFileSize);
										}
									@endphp
									<div class="col-sm-6 col-md-4 col-lg-3 mt-2">
										<div class="card brand-img-m border-0 rounded-0">
											<img class="card-img-top brand-img" src="{{ asset($img_src)}}" alt="Image">
											<div class="card-body d-flex justify-content-between" style="position: relative">
												<p class="brand-img-name" id="lot_number{{$row['upladed_img_id'].$key}}">{{$row['filename']}}</p>

												{{-- <p class="brand-img-name">{{$path}}</p> --}}
												<i class="bi bi-three-dots-vertical myButton" style="cursor: pointer;"></i>

												<div class="myPopover" style="display: none; top 20%;">
													<a href="{{ asset($img_src)}}" download="{{$row['filename']}}">Download</a>

													<a href="javascript:void(0)" onclick="toggleSidebar(); set_date({{$row['upladed_img_id'].$key}});">View Details</a>
													<div class="d-none">
														<span id="lot_date{{$row['upladed_img_id'].$key}}">{{dateFormet_dmy($row['created_at'])}}</span>
														<span id="lot_time{{$row['upladed_img_id'].$key}}">{{date('h:i A', strtotime($row['created_at']))}}</span>
														<span id="file_size{{$row['upladed_img_id'].$key}}">{{ $zipFileSize }}</span>
													</div>

													<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key.$row['upladed_img_id']}}' , 'Editing Lot raw Image' , 'Editing Raw')" >link</a>
													<p class="d-none" id="url_{{$key.$row['upladed_img_id']}}">{{ asset($img_src)}}</p>
												</div>
											</div>
										</div>
									</div>
								@endforeach					
							</div>
						@else
							<p>Raw Images not found</p>
						@endif
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
			<p class="mt-3 side-lot" id="lot_number"></p>
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
							<span id="lot_date"></span>
						</p>
						<p class="side-text2 ">
							<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect width="14" height="14" fill="#9F9F9F" />
								<line x1="1.94437" y1="1.23727" x2="12.6353" y2="11.9282" stroke="#D1D1D1" />
								<line x1="1.23727" y1="11.9282" x2="11.9282" y2="1.23728" stroke="#D1D1D1" />
							</svg>
							<span id="lot_time"></span>

						</p>
					</div>
				</div>
				<div class="col-12 ps-4">
					<p class="side-text">SIZE</p>
					<P class="side-text2" id="file_size"></P>
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

@section('js_scripts')
	{{-- Setting data and time in side bar --}}
	<script>
		const set_date = (key) => {
			console.log('key', key)
			const lot_number = $("#lot_number"+key).html()
			const lot_date = $("#lot_date"+key).html()
			const lot_time = $("#lot_time"+key).html()
			const file_size = $("#file_size"+key).html()
			$("#lot_time").html(lot_time)
			$("#lot_date").html(lot_date)
			$("#lot_number").html(lot_number)
			$("#file_size").html(file_size)
		}
	</script>
@endsection
