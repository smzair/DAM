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

	@foreach ($raw_skus_files as $row)
		@php
		if($service_is == 'edited'){
			$path=  "edited_img_directory/". date('Y', strtotime($row['created_at'])) . "/" . date('M', strtotime($row['created_at'])) . "/" . $row['lot_number'] . "/" . $row['wrc_number']. "/" . $row['adaptation']. "/" .$row['sku_code']. "/" . $row['filename'] ;
		}elseif ($service_is == 'raw') {
			$path=  "raw_img_directory/". date('Y', strtotime($row['created_at'])) . "/" . date('M', strtotime($row['created_at'])) . "/" . $row['lot_number'] . "/" . $row['wrc_number']. "/" .$row['sku_code']. "/" . $row['filename'] ;
		}
		$img_src = 'IMG/group_10.png';
		if(file_exists($path)){
			$img_src = $path;
		}
		@endphp
		<div class="col-sm-6 col-md-4 col-lg-3 mt-2">
			<div class="card brand-img-m border-0 rounded-0">
				<img class="card-img-top brand-img" src="{{ asset($img_src)}}" alt="Image">
				<div class="card-body d-flex justify-content-between">
					<p class="brand-img-name">{{$row['filename']}}</p>
					<i class="bi bi-three-dots-vertical"></i>
				</div>
			</div>
		</div>		
	@endforeach

</div>

@else
	<div style="margin-top: 40px">
		<?php echo ucfirst($service_is)?> Image not found
	</div>
@endif
@endsection
