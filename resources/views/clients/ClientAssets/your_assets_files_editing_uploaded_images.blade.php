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
									if(file_exists($path)){
										$img_src = $path;
									}
								@endphp
								<div class="col-sm-6 col-md-4 col-lg-3 mt-2">
									<div class="card brand-img-m border-0 rounded-0">
										<img class="card-img-top brand-img" src="{{ asset($img_src)}}" alt="Image">
										<div class="card-body d-flex justify-content-between" style="position: relative">
											<p class="brand-img-name">{{$row['filename']}}</p>
											<i class="bi bi-three-dots-vertical myButton" style="cursor: pointer;"></i>
											
											<div class="myPopover" style="display: none; top 20%;">
												<a href="{{ asset($img_src)}}" download="{{$row['filename']}}">Download</a>
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
										if(file_exists($path)){
											$img_src = $path;
										}
									@endphp
									<div class="col-sm-6 col-md-4 col-lg-3 mt-2">
										<div class="card brand-img-m border-0 rounded-0">
											<img class="card-img-top brand-img" src="{{ asset($img_src)}}" alt="Image">
											<div class="card-body d-flex justify-content-between" style="position: relative">
												<p class="brand-img-name">{{$row['filename']}}</p>
												{{-- <p class="brand-img-name">{{$path}}</p> --}}
												<i class="bi bi-three-dots-vertical myButton" style="cursor: pointer;"></i>

												<div class="myPopover" style="display: none; top 20%;">
													<a href="{{ asset($img_src)}}" download="{{$row['filename']}}">Download</a>
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
@else
	<div style="margin-top: 40px">
		Wrcs not found
	</div>
@endif
@endsection
