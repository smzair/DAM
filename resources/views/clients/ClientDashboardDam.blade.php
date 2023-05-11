@extends('layouts.DamNewMain')
@section('title')
  Client Dashboard
@endsection

@section('main_content')
<?php 
$lot_status_is = $lot_status_val = "";
	if(isset($other_data)){
		if(isset($other_data['lot_status'])){
			$lot_status_is = $other_data['lot_status'];
		}
	}
	$lot_status_arr = ['all' , 'active' , 'completed'];
	if (in_array($lot_status_is, $lot_status_arr)) {
		$lot_status_val = $lot_status_is;
	} 
?>

<div class="row" style="margin-top:24px ;">
	<div class=" col-12 d-flex justify-content-between">
		<h4 class="headingF">
			Track Lots - {{$lot_status_val}}
		</h4>
	</div>
</div>
<div class="row" style="margin-top: 12px;">
	<div class="col-12">
		<p class="underheadingF">
			Currently, you are seeing {{$lot_status_val}} lots.
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
			@if (count($shoot_lots) > 0 &&  ($user_role == 'Client' || $your_assets_permissions['shoot']))
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
			@if (count($creative_lots) > 0 &&  ($user_role == 'Client' || $your_assets_permissions['Creative']))
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
			@if ( count($lots_catalog) > 0 &&  ( $user_role == 'Client' || $your_assets_permissions['Cataloging']))
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
			@if ( count($editor_lots) > 0 &&  ( $user_role == 'Client' || $your_assets_permissions['Editing']))
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
	
</div>

<div class="row">
	<div class="tab-content" id="pills-tabContent">

		{{-----lot status Shoot start---}}
		@if ($user_role == 'Client' || $your_assets_permissions['shoot'])
		<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
			tabindex="0">
			<div class="row box-container-responsive">
				<div class="col-lg-12">
					<p class="totallotF">Total Lots: {{ count($shoot_lots) }}</p>
				</div>
				@foreach ($shoot_lots as $key => $val)
				@php
					$overall_progress = $val['overall_progress'];
					$overall_progress = intval(str_replace('%', '', $overall_progress));
				@endphp	
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
										Current status :
									</p>
									<p
										style="font-weight: 400;font-size: 15px;margin-top: -8px; font-family: 'Poppins', sans-serif;">
										{{$val['lot_status']}}
									</p>
								</div>
								<div role="progressbar" aria-valuenow="{{$overall_progress}}" aria-valuemin="0" aria-valuemax="100" style="--value:{{$overall_progress}}"></div>
							</div>
							<div class="col-12 d-grid gap-2">
								<a href={{route('clientsShootlotTimelineNew',$val['id'])}} class="btn border rounded-0 btn-secondary" type="button"
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
				<div class="col-lg-11">
					<p class="totallotF">Total Lots: {{ count($creative_lots) }}</p>
				</div>

				@foreach ($creative_lots as $key => $val)
				@php
					$overall_progress = $val['overall_progress'];
					$overall_progress = intval(str_replace('%', '', $overall_progress));
				@endphp	
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
								<div role="progressbar" aria-valuenow="{{$overall_progress}}" aria-valuemin="0" aria-valuemax="100" style="--value:{{$overall_progress}}"></div>
								</div>
								<div class="col-12 d-grid gap-2">
									<a href={{route('clientsCreativelotTimelineNew',$val['lot_id'])}} class="btn border rounded-0 btn-secondary" type="button"
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

				<div class="col-lg-11">
					<p class="totallotF">Total Lots: {{ count($lots_catalog) }}</p>
				</div>
				@foreach ($lots_catalog as $key => $val)
				@php
					$overall_progress = $val['overall_progress'];
					$overall_progress = intval(str_replace('%', '', $overall_progress));
				@endphp	
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
								<div role="progressbar" aria-valuenow="{{$overall_progress}}" aria-valuemin="0" aria-valuemax="100" style="--value:{{$overall_progress}}"></div>
							</div>
							<div class="col-12 d-grid gap-2">
								<a href={{route('clientsCatloglotTimelineNew',$val['lot_id'])}} class="btn border rounded-0 btn-secondary" type="button"
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
				<div class="col-12">
					<p class="totallotF">Total Lots: {{ count($editor_lots) }}</p>
				</div>
				@foreach ($editor_lots as $key => $val)
				@php
						$overall_progress = $val['overall_progress'];
						$overall_progress = intval(str_replace('%', '', $overall_progress));
					@endphp	
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
								<div role="progressbar" aria-valuenow="{{$overall_progress}}" aria-valuemin="0" aria-valuemax="100"
									style="--value:{{$overall_progress}}"></div>
							</div>
							<div class="col-12 d-grid gap-2">
								<a href={{route('clientsEditorLotTimelineNew',$val['lot_id'])}} class="btn border rounded-0 btn-secondary" type="button"
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
