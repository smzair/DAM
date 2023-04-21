@extends('layouts.DamNewMain')
@section('title')
  Client Dashboard
@endsection

@section('main_content')
@php
	// dd($lot_generated_detail);
@endphp
<div class="row">
	<div class="col-12">
		<a class="btn btn-light border-0 back-btn" href="#" role="button"><svg width="22" height="14"
				viewBox="0 0 22 14" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M6.69628 1.5L1 7L6.69628 12.5M21 7H1.15953" stroke="#9F9F9F" stroke-width="1.5"
					stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
			&nbsp; back</a>
	</div>
	<div class="col-12 d-flex justify-content-between">
		<div>
			<h2 class="lot-no-sty">Lot no: ODN10022023-BEUCBFW31</h2>
			<p class="lot-date-sty">Lot date: 06-04-2023</p>
		</div>
		<p class="inward-sty">Inward Quantity: 377</p>
	</div>
	<div class="col-12 mt-4">
		<div class="row">
			<div class="col-lg-1 mt-3      ">
				<p style="font-weight: 500;font-size: 16px;color: #9F9F9F;">Status:</p>
				<p style="font-weight: 700;font-size: 16px;color: #9F9F9F;">70%</p>
			</div>
			<div class="col-lg-11">
				<div class="progress-box">
					<div class="progress-labels">
						<div class="progress-label progress-label-1">
							<p class="progress-upper-heading">Inward</p>
						</div>
						<div class="progress-label progress-label-2">
							<p class="progress-upper-heading">WRC Generated</p>
						</div>
						<div class="progress-label progress-label-3">
							<p class="progress-upper-heading">Shoot started</p>
						</div>
						<div class="progress-label progress-label-4">
							<p class="progress-upper-heading">Editing & QC</p>
						</div>
						<div class="progress-label progress-label-5">
							<p class="progress-upper-heading">Submissions</p>
						</div>
					</div>
					<div class="progress">
						<div class="progress-bar progress-bar-1" role="progressbar" style="width: 20%;" aria-valuenow="20"
							aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-2" role="progressbar" style="width: 20%;" aria-valuenow="40"
							aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-3" role="progressbar" style="width: 20%;" aria-valuenow="60"
							aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-4" role="progressbar" style="width: 20%;" aria-valuenow="80"
							aria-valuemin="0" aria-valuemax="100"></div>
						<div class="progress-bar progress-bar-5" role="progressbar" style="width: 20%;" aria-valuenow="100"
							aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<div class="progress-labels">
						<div class="progress-label progress-label-1">
							<p class="progress-bottom-heading">06-04-2023</p>
						</div>
						<div class="progress-label progress-label-2">
							<p class="progress-bottom-heading">14-04-2023</p>
						</div>
						<div class="progress-label progress-label-3">
							<p class="progress-bottom-heading">15-04-2023</p>
						</div>
						<div class="progress-label progress-label-4">
							<p class="progress-bottom-heading">24-04-2023</p>
						</div>
						<div class="progress-label progress-label-5">
							<p></p>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="col-12 mt-4 table-responsive">
		<table class="table border-light">
			<thead>
				<tr>
					<th scope="col" class="table-heading-sty">WRC No.</th>
					<th scope="col" class="table-heading-sty">Date</th>
					<th scope="col" class="table-heading-sty">Quantity</th>
					<th scope="col" class="table-heading-sty">Editing & QC</th>
					<th scope="col" class="table-heading-sty">Rejected</th>
					<th scope="col" class="table-heading-sty">Submissions</th>
					<th scope="col" class="table-heading-sty">Invoice</th>
					<th scope="col" class="table-heading-sty">Images</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="wrc-no-sty">

					</td>
					<td class="table-column">14-04-2023</td>
					<td class="table-column">126</td>
					<td class="table-column">120</td>
					<td class="table-column">6</td>
					<td class="table-column">Pending</td>
					<td class="table-column table-invoice">Pending</td>
					<td style="justify-content: center;" class="table-img">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="20" height="20" fill="#9F9F9F" />
							<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
							<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
						</svg>
					</td>
				</tr>
				<tr>
					<td class="wrc-no-sty">DEMO1TWSR9-A</td>
					<td class="table-column">14-04-2023</td>
					<td class="table-column">126</td>
					<td class="table-column">120</td>
					<td class="table-column">6</td>
					<td class="table-column">Pending</td>
					<td class="table-column table-invoice">Paid</td>
					<td style="justify-content: center;" class="table-img">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="20" height="20" fill="#9F9F9F" />
							<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
							<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
						</svg>
					</td>
				</tr>
				<tr>
					<td class="wrc-no-sty">DEMO1TWSR9-A</td>
					<td class="table-column">14-04-2023</td>
					<td class="table-column">126</td>
					<td class="table-column">120</td>
					<td class="table-column">6</td>
					<td class="table-column">Pending</td>
					<td class="table-column table-invoice">Pending</td>
					<td style="justify-content: center;" class="table-img">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="20" height="20" fill="#9F9F9F" />
							<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
							<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
						</svg>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-12 d-flex justify-content-between last-btn-div">
		<div class="d-flex last-button-mar">
			<button type="button" class="btn border btn-lg last-button">Download images</button>&nbsp;&nbsp;&nbsp;
			<button type="button" class="btn border btn-lg last-button">Download raw</button>
		</div>
		<div class="download-invoice">
			<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<rect width="20" height="20" fill="#9F9F9F" />
				<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
				<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
			</svg>
			&nbsp; <a href="#" class="download-invoice"> Download Invoices</a>
		</div>
	</div>
</div>
@endsection
