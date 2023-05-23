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
		<p style="font-weight: 500;font-size: 12px;color: #FFFFFF;">Total Images: {{count($raw_skus_files)}}</p>
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
				<div class="card-body total-sku-img-body d-flex justify-content-between" style="position: relative">
					<p class="brand-img-name" id="lot_number{{$row['sku_id'].$key}}">{{$row['filename']}}</p>
					<i class="bi bi-three-dots-vertical myButton" style="cursor: pointer;color:#808080;"></i>
					<div class="myPopover" style="display: none; top 20%;">

						<a href="{{ asset($img_src)}}" download="{{$row['filename']}}">
						     <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                             &nbsp;&nbsp;
						    Download
						    </a>

						<a href="javascript:void(0)" onclick="toggleSidebar(); set_date({{$row['sku_id'].$key}});">
						    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1043_2491)">
                            <path d="M9.99992 13.334L9.99992 9.16732M9.99992 1.66732C5.41658 1.66732 1.66658 5.41732 1.66658 10.0007C1.66659 14.584 5.41659 18.334 9.99992 18.334C14.5833 18.334 18.3333 14.584 18.3333 10.0007C18.3333 5.41732 14.5833 1.66732 9.99992 1.66732Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.0042 6.66602L9.99665 6.66602" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_1043_2491">
                            <rect width="20" height="20" fill="white"/>
                            </clipPath>
                            </defs>
                            </svg>
                            &nbsp;&nbsp;
						    View Details
						    </a>
						<div class="d-none">
							<span id="lot_date{{$row['sku_id'].$key}}">{{dateFormet_dmy($row['sku_created_at'])}}</span>
							<span id="lot_time{{$row['sku_id'].$key}}">{{date('h:i A', strtotime($row['sku_created_at']))}}</span>
							<span id="file_size{{$row['sku_id'].$key}}">{{ $zipFileSize }}</span>
						</div>

						<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >
						     <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            &nbsp;&nbsp;
						    Share
						  </a>
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
