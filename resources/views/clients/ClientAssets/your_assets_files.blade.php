@extends('layouts.DamNewMain')
@section('title')
  Your Assets -files
@endsection

@section('main_content')
@php
	$user = Auth::user();
	$your_assets_permissions = json_decode($user->your_assets_permissions,true);
	$file_manager_permissions = json_decode($user->file_manager_permissions,true);
	$roledata = getUsersRole($user->id);
	$user_role = $roledata != null ? $roledata->role_name : '-';
@endphp

<div class="row" style="margin-top:24px ;">
	<div class=" col-12 d-flex justify-content-between">
		<h4 class="headingF">
			Your assets - Files
		</h4>
		{{-- <button class="btn btn-none border dropdown-toggle btn-outline-none" type="button" id="dropdownMenuButton4"
			data-bs-toggle="dropdown" aria-expanded="false">
			Sort
		</button>
		<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
			<li><a class="dropdown-item" href="#">2022</a></li>
			<li><a class="dropdown-item" href="#">2023</a></li>
		</ul> --}}
	</div>
</div>
<div class="row" style="margin-top: 12px;">
	<div class="col-12">
		<p class="underheadingF">
			Currently, you are seeing Your Assets Files.
		</p>
	</div>
</div>

@if (count($shoot_lots) > 0 || count($editor_lots) > 0 )
	<div class="row" style="margin-top: 40px;" id="File">
		<div class="col-lg-12 d-flex your_assets_tab">
			<ul class="nav nav-pills mb-3 nav-fill" id="pills-tab" role="tablist">
				{{-- Shoot Lots --}}
				@if (count($shoot_lots) > 0)
				<li class="nav-item lots-bar" role="presentation">
					<button class="nav-link active btn-lg tab-button" id="pills-home-tab" data-bs-toggle="pill"
						data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="20" height="20" fill="#9F9F9F" />
							<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
							<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
						</svg>&nbsp; Shoot Lots
					</button>
				</li>
				@endif

				{{-- Post-production Lots --}}
				@if (count($editor_lots) > 0)
				<li class="nav-item lots-bar" role="presentation">
					<button class="nav-link btn-lg tab-button" id="pills-profile-tab" data-bs-toggle="pill"
						data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
						aria-selected="false">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="20" height="20" fill="#9F9F9F" />
							<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
							<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
						</svg>&nbsp; Post-production Lots
					</button>
				</li>
				@endif
			</ul>
		</div>
	</div>

	<div class="row" style="margin-top: 40px;">
		<div class="tab-content" id="pills-tabContent">
			{{-- shoot lots --}}
			@if (count($shoot_lots) > 0)
				<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
					tabindex="0">
					<div class="row box-container-responsive">
						<div class="col-12">
							<p class="totallotF">Total Lots: {{count($shoot_lots)}}</p>
						</div>
						@foreach ($shoot_lots as $key => $row)
							<div class="col-lg-3 col-md-6 box border-0" style="background: #EBEBEB; position: relative;">
								<div class="row">
									<div class="under-content-div">
										<div class="col-12">
											<a href="{{route('your_assets_shoot_wrcs' , [$row['lot_id']])}}"><img src="{{ asset('IMG/group_10.png')}}" alt="" class="img-fluid"></a>
										</div>
										<div class="col-12 d-flex">
											<h3 class="lotnoF">
												<span>Lot no: {{$row['lot_number']}}
												<span type="button" class="btn border-0 rounded-circle myButton">
													<i class="bi bi-three-dots-vertical" style="color: #9F9F9F;line-height: 2.5;">
													</i>
												</span>
												<div class="myPopover" style="display: none;">
													@php
															$download_route_is = "download_Shoot_Lot_edited";
													@endphp
													<a href="{{route($download_route_is , [ 'id' =>  $row['lot_id'] ] )}}">Download</a>
													<a href="{{route('your_assets_shoot_wrcs' , [$row['lot_id']])}}">View details </a>

													<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >Share</a>
													<p class="d-none" id="url_{{$key}}">{{route($download_route_is , [ 'id' =>  $row['lot_id'] ] )}}</p>
													<a href="javascript:void(0)">Favorite</a>
													<a href="javascript:void(0)">Add Tag</a>
												</div>
											</h3>
										</div>
										<div class="col-12">
											<p class="lot-date">Lot date : {{dateFormet_dmy($row['lot_created_at'])}}</p>
										</div>
										<div class="col-12 d-flex justify-content-between">
											<div>
												<p class="inward-qty">Inward Quantity : </p>
												<p class="inward-qty-num">
													{{$row['inward_qty']}}
												</p>
											</div>
											<div>
												<p class="inward-qty">Submission</p>
												<p class="inward-qty-num">{{dateFormet_dmy($row['submission_date'])}}</p>
											</div>
										</div>
										<div class="col-12 d-grid gap-2">
											<a role="button" class="btn border rounded-0 view-img " href="{{route('your_assets_shoot_wrcs' , [$row['lot_id']])}}">
												View images
											</a>
										</div>
									</div>
								</div>
							</div>
						@endforeach				
					</div>
				</div>
			@endif

			{{-- Post-production Lots --}}
			@if (count($editor_lots) > 0)
				<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
					tabindex="0">
					<div class="row box-container-responsive">
						<div class="col-12">
							<p class="totallotF">Total Lots: {{count($editor_lots)}}</p>
						</div>
						@foreach ($editor_lots as $key => $row)
							<div class="col-lg-3 col-md-6 box border-0" style="background: #EBEBEB; position: relative;">
								<div class="row">
									<div class="under-content-div">
										<div class="col-12">
											<a href="{{route('your_assets_editing_wrcs' , [$row['lot_id']])}}"><img src="{{ asset('IMG/group_10.png')}}" alt="" class="img-fluid"></a>
										</div>
										<div class="col-12 d-flex">
											<h3 class="lotnoF">
												<span>Lot no: {{$row['lot_number']}}
												<span type="button" class="btn border-0 rounded-circle myButton">
													<i class="bi bi-three-dots-vertical" style="color: #9F9F9F; line-height: 2.5;">
													</i>
												</span>
												<div class="myPopover" style="display: none;">
													@php
															$download_route_is = "download_Editing_Lot_edited";
													@endphp
													<a href="{{route($download_route_is , [ 'id' =>  base64_encode($row['lot_id'])  ] )}}">Download</a>

													<a role="button" class="btn border rounded-0 view-img " href="{{route('your_assets_editing_wrcs' , [$row['lot_id']])}}">View Details</a>
													
													<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key.$row['lot_id']}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >Share</a>
													<p class="d-none" id="url_{{$key.$row['lot_id']}}">{{route($download_route_is , [ 'id' =>  base64_encode($row['lot_id']) ] )}}</p>
													
													<a href="javascript:void(0)">Favorite</a>
													<a href="javascript:void(0)">Add Tag</a>
												</div>
											</h3>
										</div>
										<div class="col-12">
											<p class="lot-date">Lot date : {{dateFormet_dmy($row['lot_created_at'])}}</p>
										</div>
										<div class="col-12 d-flex justify-content-between">
											<div>
												<p class="inward-qty">Inward Quantity : </p>
												<p class="inward-qty-num">
													{{$row['inward_qty']}}
												</p>
											</div>
											<div>
												<p class="inward-qty">Submission</p>
												<p class="inward-qty-num">{{dateFormet_dmy($row['submission_date'])}}</p>
											</div>
										</div>
										<div class="col-12 d-grid gap-2">
											<a role="button" class="btn border rounded-0 view-img " href="{{route('your_assets_editing_wrcs' , [$row['lot_id']])}}">
												View images
											</a>
										</div>
									</div>
								</div>
							</div>
						@endforeach				
					</div>
				</div>
			@endif
		</div>
	</div>
@else
	<div style="margin-top: 40px">
		Lots not found
	</div>
@endif
@endsection
