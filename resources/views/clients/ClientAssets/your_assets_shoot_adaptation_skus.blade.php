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

@if (count($raw_skus) > 0)
	<div class="row">
		<div class="col-12" style="margin-top: 24px;">
			<nav
				style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
				aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><span class="breadcrumb-deco" >{{$raw_skus[0]['lot_number']}}</span></li>
					<li class="breadcrumb-item"><a class="breadcrumb-deco" href="{{route('your_assets_shoot_wrcs' , [$raw_skus[0]['lot_id']])}}">WRCs</a></li>
					<li class="breadcrumb-item"><a class="breadcrumb-deco" href="{{route('your_assets_shoot_skus' , [base64_encode($raw_skus[0]['wrc_id'])])}}">{{$raw_skus[0]['wrc_number']}}</a></li>
					<li class="breadcrumb-item active breadcrumb-deco" aria-current="page">{{$raw_skus[0]['adaptation']}}</li>
				</ol>
			</nav>
		</div>
		<div class="col-12" style="margin-top: 40px;">
			<p style="font-weight: 500;font-size: 12px;color: #9F9F9F;">Total SKU: {{count($raw_skus)}}</p>
		</div>
	</div>
	<div class="row" style="margin-top: 12px;">
		@foreach ($raw_skus as $row)
			<div class="col-lg-3 col-md-6 mt-2">
				<div class="row brand-div">
					<div class="col-2 mt-3">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="24" height="24" fill="#9F9F9F" />
							<line x1="3.95353" y1="3.24606" x2="20.7535" y2="20.0461" stroke="#D1D1D1" />
							<line x1="3.24642" y1="20.0459" x2="20.0464" y2="3.24586" stroke="#D1D1D1" />
						</svg>
					</div>
					<div class="col-8 mt-2">
						<a style="text-decoration: none;" href="{{route('your_assets_shoot_edited_images' , [base64_encode($row['sku_id'])] )}}">
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
@else
	<div style="margin-top: 40px">
		Sku codes not found
	</div>
@endif
@endsection
