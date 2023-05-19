@extends('layouts.DamNewMain')
@section('title')
  Your Assets - <?php echo ucfirst($service_is)?> Image 
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
	// dd($raw_skus_files , $service_is);
	
@endphp

@if (count($raw_skus_files) > 0)
<div class="row">
	<div class="col-12" style="margin-top: 24px;">
		<nav
			style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
			aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><span class="breadcrumb-deco" >{{$raw_skus_files[0]['lot_number']}}</span></li>
				<li class="breadcrumb-item"><a class="breadcrumb-deco" href="{{route('your_assets_shoot_wrcs' , [$raw_skus_files[0]['lot_id']])}}">WRCs</a></li>
				<li class="breadcrumb-item"><a class="breadcrumb-deco" href="{{route('your_assets_shoot_skus' , [base64_encode($raw_skus_files[0]['wrc_id'])])}}">{{$raw_skus_files[0]['wrc_number']}}</a></li>
				
				@if ($service_is == 'edited')
				<li class="breadcrumb-item"><a class="breadcrumb-deco" href="{{route('your_assets_shoot_adaptation_skus' , [ base64_encode($raw_skus_files[0]['wrc_id']) , base64_encode($raw_skus_files[0]['adaptation'])])}}">{{$raw_skus_files[0]['adaptation']}}</a></li>
				@endif
				
				<li class="breadcrumb-item active breadcrumb-deco" aria-current="page">{{$raw_skus_files[0]['sku_code']}}
				</li>
			</ol>
		</nav>
	</div>
	<div class="col-12" style="margin-top: 40px;">
		<p style="font-weight: 500;font-size: 12px;color: #9F9F9F;">Total Images: {{count($raw_skus_files)}}</p>
	</div>
</div>

<div class="row" style="margin-top: 12px;">

	@foreach ($raw_skus_files as $key => $row)
		@php
		if($service_is == 'edited'){
			$path=  "edited_img_directory/". date('Y', strtotime($row['created_at'])) . "/" . date('M', strtotime($row['created_at'])) . "/" . $row['lot_number'] . "/" . $row['wrc_number']. "/" . $row['adaptation']. "/" .$row['sku_code']. "/" . $row['filename'] ;
		}elseif ($service_is == 'raw') {
			$path=  "raw_img_directory/". date('Y', strtotime($row['created_at'])) . "/" . date('M', strtotime($row['created_at'])) . "/" . $row['lot_number'] . "/" . $row['wrc_number']. "/" .$row['sku_code']. "/" . $row['filename'] ;
		}
		$img_src = 'IMG/group_10.png';
		$zipFileSize = "File Not Found!!";
		if(file_exists($path)){
			$img_src = $path;
			$zipFileSize = filesize($path);
			$zipFileSize = formatBytes($zipFileSize);

		}
		@endphp
		<div class="col-sm-6 col-md-4 col-lg-3 mt-2" >
			<div class="card brand-img-m border-0 rounded-0" >
				<img class="card-img-top brand-img" src="{{ asset($img_src)}}" alt="Image">
				<div class="card-body d-flex justify-content-between" style="position: relative">
					<p class="brand-img-name" id="lot_number{{$row['sku_id'].$key}}">{{$row['filename']}}</p>
					<i class="bi bi-three-dots-vertical myButton" style="cursor: pointer;"></i>
					<div class="myPopover" style="display: none; top 20%;">

						<a href="{{ asset($img_src)}}" download="{{$row['filename']}}">Download</a>

						<a href="javascript:void(0)" onclick="toggleSidebar(); set_date({{$row['sku_id'].$key}});">View Details</a>
						<div class="d-none">
							<span id="lot_date{{$row['sku_id'].$key}}">{{dateFormet_dmy($row['sku_created_at'])}}</span>
							<span id="lot_time{{$row['sku_id'].$key}}">{{date('h:i A', strtotime($row['sku_created_at']))}}</span>
							<span id="file_size{{$row['sku_id'].$key}}">{{ $zipFileSize }}</span>
						</div>

						<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >Share</a>
						<p class="d-none" id="url_{{$key}}">{{ asset($img_src)}}</p>
					</div>
				</div>
			</div>
		</div>		
	@endforeach

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
		<?php echo ucfirst($service_is)?> Image not found
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
