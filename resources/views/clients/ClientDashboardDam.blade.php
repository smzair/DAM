@extends('layouts.DamNewMain')
@section('title')
  Client Dashboard
@endsection

@section('main_content')
<div class="row" style="margin-top:24px ;">
	<div class=" col-12 d-flex justify-content-between">
		<h4 class="headingF">
			Track Lots - Active
		</h4>
	</div>
</div>
<div class="row" style="margin-top: 12px;">
	<div class="col-12">
		<p class="underheadingF">
			Currently, you are seeing active shoot lots.
		</p>
	</div>
</div>
@php
	$user = Auth::user();
	$your_assets_permissions = json_decode($user->your_assets_permissions,true);
	$file_manager_permissions = json_decode($user->file_manager_permissions,true);
	$roledata = getUsersRole($user->id);
	$user_role = $roledata != null ? $roledata->role_name : '-';
@endphp

<div class="row" style="margin-top: 40px;">
	<div class="col-lg-12 d-flex">
		<ul class="nav nav-pills mb-3 nav-fill" id="pills-tab" role="tablist">
			{{-----lot status Shoot start---}}
			@if ($user_role == 'Client' || $your_assets_permissions['shoot'])
			<li class="nav-item" role="presentation">
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

			{{-----lot status Creative start---}}
			@if ($user_role == 'Client' || $your_assets_permissions['Creative'])
			<li class="nav-item" role="presentation">
				<button class="nav-link btn-lg tab-button" id="pills-profile-tab" data-bs-toggle="pill"
					data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
					aria-selected="false">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect width="20" height="20" fill="#9F9F9F" />
						<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
						<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
					</svg>&nbsp; Creative Lots
				</button>
			</li>
			@endif

			{{-----lot status Cataloging start---}}
			@if ($user_role == 'Client' || $your_assets_permissions['Cataloging'])
			<li class="nav-item" role="presentation">
				<button class="nav-link btn-lg tab-button" id="pills-contact-tab" data-bs-toggle="pill"
					data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
					aria-selected="false">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect width="20" height="20" fill="#9F9F9F" />
						<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
						<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
					</svg>&nbsp; Catalog Lots
				</button>
			</li>
			@endif

			{{-----lot status editor start---}}
			@if ($user_role == 'Client' || $your_assets_permissions['Editing'])
			<li class="nav-item" role="presentation">
				<button class="nav-link btn-lg tab-button" id="pills-editing-tab" data-bs-toggle="pill"
					data-bs-target="#pills-editing" type="button" role="tab" aria-controls="pills-editing"
					aria-selected="false">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect width="20" height="20" fill="#9F9F9F" />
						<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
						<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
					</svg>&nbsp; Editing Lots
				</button>
			</li>
			@endif

		</ul>
	</div>
</div>
<div class="row" style="margin-top: 40px;">
	<div class="col-12">
		<p class="totallotF">Total Lots: {{ count($resDataShoot) + count($resData) + count($resDataCatlog) + count($resDataEditor) }}</p>
	</div>
</div>

<div class="row">
	<div class="tab-content" id="pills-tabContent">

		{{-----lot status Shoot start---}}
		@if ($user_role == 'Client' || $your_assets_permissions['shoot'])
		<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
			tabindex="0">
			<div class="row box-container-responsive">
				@foreach ($resDataShoot as $key => $val)
				<div class="col-lg-3 box" style="background: #EBEBEB;">
					<div class="row">
						<div class="under-content-div">
							<div class="col-12">
								<h3 class="lotnoF">
									Lot no: {{$val['lot_number']}}
								</h3>
							</div>
							<div class="col-12">
								<p style="font-weight: 400;font-size: 13px;">
									Lot date: {{ date('d-m-Y' , strtotime($val['created_at']))}}
								</p>
							</div>
							<div class="col-12 d-flex justify-content-between">
								<div>
									<p style="font-weight: 400;font-size: 13px;">
										Current status:
									</p>
									<p
										style="font-weight: 400;font-size: 15px;margin-top: -8px; font-family: 'Poppins', sans-serif;">
										{{$val['lot_status']}}
									</p>
								</div>
								<div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
									style="--value:80"></div>
							</div>
							<div class="col-12 d-grid gap-2">
								<a target="_blank" href={{route('clientsShootlotTimeline',$val['lot_id'])}} class="btn border rounded-0 btn-secondary" type="button"
									style="font-weight: 500;font-size: 15px;margin-top: 30px; font-family: 'Poppins', sans-serif;">
									View full details
								</a>
							</div>
						</div>
					</div>
				</div>
				@endforeach

			</div>
		</div>
		@endif

		{{-----lot status Creative start---}}
		@if ($user_role == 'Client' || $your_assets_permissions['Creative'])
		<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
			tabindex="0">
			<div class="row box-container-responsive">

				@foreach ($resData as $key => $val)
					<div class="col-lg-3 box" style="background: #EBEBEB;">
						<div class="row">
							<div class="under-content-div">
								<div class="col-12">
									<h3 class="lotnoF">
										Lot No:- {{ $val['lot_number'] }}
									</h3>
								</div>
								<div class="col-12">
									<p style="font-weight: 400;font-size: 13px;">
										Lot date: {{ date('d-m-Y' , strtotime($val['created_at']))}}
									</p>
								</div>
								<div class="col-12 d-flex justify-content-between">
									<div>
										<p style="font-weight: 400;font-size: 13px;">
											Current status:
										</p>
										<p
											style="font-weight: 400;font-size: 15px;margin-top: -8px; font-family: 'Poppins', sans-serif;">
											{{$val['lot_status']}}
										</p>
									</div>
									<div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
										style="--value:80"></div>
								</div>
								<div class="col-12 d-grid gap-2">
									<a target="_blank" href={{route('clientsCreativelotTimeline',$val['lot_id'])}} class="btn border rounded-0 btn-secondary" type="button"
										style="font-weight: 500;font-size: 15px;margin-top: 30px; font-family: 'Poppins', sans-serif;">
										View full details
									</a>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
		@endif

		{{-----lot status catlog start---}}
		@if ($user_role == 'Client' || $your_assets_permissions['Cataloging'])
		<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"
			tabindex="0">
			<div class="row box-container-responsive">

				@foreach ($resDataCatlog as $key => $val)
				<div class="col-lg-3 box" style="background: #EBEBEB;">
					<div class="row">
						<div class="under-content-div">
							<div class="col-12">
								<h3 class="lotnoF">
									Lot no: {{ $val['lot_number'] }}
								</h3>
							</div>
							<div class="col-12">
								<p style="font-weight: 400;font-size: 13px;">
									Lot date: {{ date('d-m-Y' , strtotime($val['created_at']))}}
								</p>
							</div>
							<div class="col-12 d-flex justify-content-between">
								<div>
									<p style="font-weight: 400;font-size: 13px;">
										Current status:
									</p>
									<p
										style="font-weight: 400;font-size: 15px;margin-top: -8px; font-family: 'Poppins', sans-serif;">
										{{$val['lot_status']}}
									</p>
								</div>
								<div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
									style="--value:80"></div>
							</div>
							<div class="col-12 d-grid gap-2">
								<a target="_blank" href={{route('clientsCatloglotTimeline',$val['lot_id'])}} class="btn border rounded-0 btn-secondary" type="button"
									style="font-weight: 500;font-size: 15px;margin-top: 30px; font-family: 'Poppins', sans-serif;">
									View full details
								</a>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		@endif

		{{-----lot status Editing start---}}
		@if ($user_role == 'Client' || $your_assets_permissions['Editing'])
		<div class="tab-pane fade" id="pills-editing" role="tabpanel" aria-labelledby="pills-editing-tab"
			tabindex="0">
			<div class="row box-container-responsive">
				@foreach ($resDataEditor as $key => $val)
				<div class="col-lg-3 box" style="background: #EBEBEB;">
					<div class="row">
						<div class="under-content-div">
							<div class="col-12">
								<h3 class="lotnoF">
									Lot no: {{$val['lot_number']}}
								</h3>
							</div>
							<div class="col-12">
								<p style="font-weight: 400;font-size: 13px;">
									Lot date: {{ date('d-m-Y' , strtotime($val['created_at']))}}
								</p>
							</div>
							<div class="col-12 d-flex justify-content-between">
								<div>
									<p style="font-weight: 400;font-size: 13px;">
										Current status:
									</p>
									<p
										style="font-weight: 400;font-size: 15px;margin-top: -8px; font-family: 'Poppins', sans-serif;">
										{{$val['lot_status']}}
									</p>
								</div>
								<div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
									style="--value:80"></div>
							</div>
							<div class="col-12 d-grid gap-2">
								<a target="_blank" href={{route('clientsEditorLotTimeline',$val['lot_id'])}} class="btn border rounded-0 btn-secondary" type="button"
									style="font-weight: 500;font-size: 15px;margin-top: 30px; font-family: 'Poppins', sans-serif;">
									View full details
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
@endsection
