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
												<span>Lot no : <span id="lot_number{{$row['lot_id'].$key}}">{{$row['lot_number']}}</span>
												<span type="button" class="btn border-0 rounded-circle myButton">
													<i class="bi bi-three-dots-vertical" style="color: #9F9F9F;line-height: 2.5;">
													</i>
												</span>
												<div class="myPopover" style="display: none;">
													@php
															$download_route_is = "download_Shoot_Lot_edited";
															$lot_id_is = base64_encode($row['lot_id']);
													@endphp
													<a href="{{route($download_route_is , [ 'id' =>  $row['lot_id'] ] )}}">Download</a>

													<a href="javascript:void(0)" onclick="toggleSidebar(); set_date_time({{$row['lot_id'].$key}}); lots_details('{{ $lot_id_is  }}' , 'lot' , 'Edited') ">View Details</a>


													<div class="d-none">
														<span id="lot_date{{$row['lot_id'].$key}}">{{dateFormet_dmy($row['lot_created_at'])}}</span>
														<span id="lot_time{{$row['lot_id'].$key}}">{{date('h:i A', strtotime($row['lot_created_at']))}}</span>
													</div>

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
												<span>Lot no : <span id="lot_number{{$row['lot_id'].$key}}">{{$row['lot_number']}}</span>
												<span type="button" class="btn border-0 rounded-circle myButton">
													<i class="bi bi-three-dots-vertical" style="color: #9F9F9F; line-height: 2.5;">
													</i>
												</span>
												<div class="myPopover" style="display: none;">
													@php
															$download_route_is = "download_Editing_Lot_edited";
															$lot_id_is = base64_encode($row['lot_id']);
													@endphp
													<a href="{{route($download_route_is , [ 'id' =>  base64_encode($row['lot_id'])  ] )}}">Download</a>

													<a href="javascript:void(0)" onclick="toggleSidebar(); set_date_time({{$row['lot_id'].$key}}); editing_lots_details('{{ $lot_id_is  }}' , 'lot' , 'Edited') ">View Details</a>

													<div class="d-none">
														<span id="lot_date{{$row['lot_id'].$key}}">{{dateFormet_dmy($row['lot_created_at'])}}</span>
														<span id="lot_time{{$row['lot_id'].$key}}">{{date('h:i A', strtotime($row['lot_created_at']))}}</span>
													</div>
													
													<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$row['lot_id'].$key}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >Share</a>
													<p class="d-none" id="url_{{$row['lot_id'].$key}}">{{route($download_route_is , [ 'id' =>  base64_encode($row['lot_id']) ] )}}</p>
													
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
		Lots not found
	</div>
@endif
@endsection

@section('js_scripts')
	



	
@endsection
