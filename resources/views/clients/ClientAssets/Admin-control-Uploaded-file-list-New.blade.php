@extends('layouts.DamNewMain')
@section('title')
Admin control - Uploaded files 
@endsection

@section('other_css')
	<style>
		.hoverpopoverforlinks {
			display: none;
			position: absolute;
			background: #0F0F0F;
			border: 1px solid #333333;
			box-shadow: 6px 24px 60px rgba(255, 255, 255, 0.06);
			z-index: 1;
			width: 385px !important;
			/* left: 927.5px !important; */
			right: 20px !important;
			/* Set the width of the popover */
		}

		.myPopover_links{
			width: 350px;
			left: -20px;
			top: 95%;
		}

		/* CSS for the popover text */
		.popover-text {
			padding: 10px;
		}

		.popover-text p{
			margin-bottom: 3px;
		}

		/* CSS for the text element */

		.text {
			cursor: pointer;
			position: relative;
			display: inline-block;
		}

		/* Extra add-on CSS */

		.upper-head-style-for-track-hover {
			margin-top: -11px;
			margin-left: -11px;
			margin-right: -11px;
			background: #1A1A1A;
		}

		.track-lot-table-wrc-no {
			font-weight: 500;
			font-size: 16px;
			color: #FFFFFF;
			letter-spacing: 0.15px;
		}

		.track-lot-table-wrc-date {
			font-weight: 400;
			font-size: 14px;
			color: #808080;
			/* line-height: 0.1; */
		}

		.track-lot-table-inward-qty {
			font-weight: 500;
			font-size: 14px;
			color: #808080;
		}

		.track-lot-table-inward-qty-no {
			font-weight: 700;
			font-size: 16px;
			color: #FFFFFF;
			/* line-height: 0.1; */
		}

		.track-lot-table-typeof-service {
			font-weight: 500;
			font-size: 14px;
			color: #808080;
		}

		.track-lot-table-marketplace-pri-mode {
			font-weight: 400;
			font-size: 16px;
			color: #FFFFFF;
			/* line-height: 0.1; */
			text-align: left;
		}

		.track-lot-adaptation-under {
			font-weight: 400;
			font-size: 16px;
			color: #FFFFFF;
			padding: 8px;
			background: #333333;
		}
	</style>
@endsection


@section('main_content')
@php
	$user = Auth::user();
	$your_assets_permissions = json_decode($user->your_assets_permissions,true);
	$file_manager_permissions = json_decode($user->file_manager_permissions,true);
	$roledata = getUsersRole($user->id);
	$user_role = $roledata != null ? $roledata->role_name : '-';
	// dd($catalog_lots, $creative_lots);

@endphp
	<div class="row">
		<div class="col-12">
			<a class="btn btn-light border-0 back-btn" href="{{ url()->previous() }}" role="button"><svg width="22" height="14"
					viewBox="0 0 22 14" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M6.69628 1.5L1 7L6.69628 12.5M21 7H1.15953" stroke="#9F9F9F" stroke-width="1.5"
						stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
				&nbsp; back</a>
		</div>

		<div class="col-12 mt-4 table-responsive" style="min-height: 80vh">
			<table class="table border-light" style="background: #0F0F0F;">
				<thead>
					<tr>
						<th scope="col" class="table-heading-sty">Service name</th>
						<th scope="col" class="table-heading-sty">Lot Number</th>
						<th scope="col" class="table-heading-sty">Wrc Number</th>
						<th scope="col" class="table-heading-sty">File</th>
						<th scope="col" class="table-heading-sty">File Uploaded By</th>
						<th scope="col" class="table-heading-sty">Uploaded At</th>
					</tr>
				</thead>
				<tbody>
					@if (count($data) > 0)
						@foreach($data as $index => $row)
							<tr>
								{{-- <td width="5%" class="pl-3">{{$index+1}} </td> --}}
								<td  class="table-column">{{$row['service']}}</td>
								<td  class="table-column">{{$row['lot_number']}}</td>
								<td  class="table-column">{{$row['wrc_number']}}</td>
								<td  class="table-column"><a href="{{asset($row['file_path'].$row['filename'])}}" download="{{$row['filename']}}">Download</a></td>
								<td  class="table-column">{{$row['uploaded_by']}}</td>
								<td  class="table-column">{{date('d-M-Y h:i A', strtotime($row['created_at']))}}</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td class="table-column text-center" colspan="6"> No files.</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
@endsection

@section('js_scripts')
	<script>
		// JavaScript functions to show and hide the popover
		function showPopover(element) {
			var popover = element.nextElementSibling;
			popover.style.display = 'block';
		}

		function hidePopover(element) {
			var popover = element.nextElementSibling;
			popover.style.display = 'none';
		}
	</script>

	
@endsection
