@extends('layouts.DamNewMain')
@section('title')
  Your Assets - files
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
			left: -220px !important;
			top: auto !important;
		}

		.myPopover_links{
			width: 218px;
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
			margin-top: -10px;
			margin-left: -10px;
			margin-right: -10px;
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

@if (count($lot_links) > 0)
	<div class="row">
		<div class="col-12">
			<a class="btn btn-light border-0 back-btn" href="{{ route('your_assets_Links') }}" role="button"><svg width="22" height="14"
					viewBox="0 0 22 14" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M6.69628 1.5L1 7L6.69628 12.5M21 7H1.15953" stroke="#9F9F9F" stroke-width="1.5"
						stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
				&nbsp; back</a>
		</div>

		<div class="col-12 mt-4 table-responsive" style="min-height: 80vh">
			<table class="table border-light" style="background: #0F0F0F;" id="linktablehover">
				<thead>
					<tr>
						<th scope="col" class="table-heading-sty">Project name</th>
						<th scope="col" class="table-heading-sty">Type of work</th>
						<th scope="col" class="table-heading-sty">Quantity</th>
						<th scope="col" class="table-heading-sty">Submissions</th>
						<th scope="col" class="table-heading-sty">File links</th>
						<th scope="col" class="table-heading-sty">WRC No.</th>
					</tr>
				</thead>
				<tbody>

					@foreach ($lot_links as $key => $row)
						@php
								$project_name = $row['project_name'];
								$inward_qty = $row['inward_qty'];
								$type_of_service = $row['type_of_service'];
								$wrc_numbers = $row['wrc_numbers'];
								$per_qty_value = $row['per_qty_value'];
								$submition_qty = $row['submition_qty'];
								$wrc_created_at = $row['wrc_created_at'];
								$upload_links = $row['upload_links'];
								$upload_links_count = count($upload_links);
						@endphp
						<tr>
							<td class="table-column">{{$project_name}}</td>
							<td class="table-column">{{$type_of_service}}</td>
							<td class="table-column">{{$inward_qty}}</td>
							<td class="table-column">{{$submition_qty}}</td>
							{{-- <td class="table-column">{{$wrc_numbers}}</td> --}}
							<td class="table-column" style="position: relative">
								<button class=" test myButton" style="border: 1px solid white;padding: 8px;">
									File Links
								</button>
								<div class="myPopover myPopover_links" style="display: none">
									<div class="mt-2" style="line-height: 0.7;">
										<p>Creative links</p>
										@if ($upload_links_count > 0)
											@foreach ($upload_links as $links)
												@if ($links['creative_link'] != '')
													<a href="{{$links['creative_link']}}"><p style="padding-left: 10px">View link</p></a>
												@endif
											@endforeach
										@else
											<p>Links Not uplodaed</p>	
										@endif
									</div>
									<div class="mt-2" style="line-height: 0.7;">
										<p>Copy links</p>
										@if ($upload_links_count > 0)
											@foreach ($upload_links as $links)
												@if ($links['copy_link'] != '')
													<a href="{{$links['copy_link']}}"><p style="padding-left: 10px">View link</p></a>
												@endif
											@endforeach
										@else
											<p>Links Not uplodaed</p>	
										@endif
									</div>
								</div>
							</td>
							<td class="wrc-no-sty" style="position: relative">
								<p class="text" >{{$wrc_numbers}}</p>
								<div class="hoverpopoverforlinks" style="display: none">
									<div class="popover-text">
										<div class="upper-head-style-for-track-hover">
											<div class="upper-heading-wrc-details-table pt-2 pb-1">
												<div class="col-12 d-flex justify-content-between ps-4 pe-4">
													<div>
														<p class="track-lot-table-wrc-no">{{$wrc_numbers}}</p>
														<p class="track-lot-table-wrc-date text-start">{{dateFormat($wrc_created_at)}}</p>
													</div>
													<div>
														<p class="track-lot-table-inward-qty">Inward Quantity</p>
														<p class="track-lot-table-inward-qty-no text-start">{{$inward_qty}}</p>
													</div>
												</div>
											</div>
										</div>
										<div class="lower-wrc-details-table mt-4">
											<div class="col-12 ps-3 mt-4">
												<p class="track-lot-table-typeof-service text-start">
													Project name
												</p>
											</div>
											<div class="col-12 d-flex ps-3 text-start">
												<p class="track-lot-table-marketplace-pri-mode text-start">
													{{$project_name}}
												</p>
											</div>
											<div class="col-12 d-flex justify-content-between ps-3 pe-3 mt-4">
												<div>
													<p class="track-lot-table-typeof-service text-start">Type of service</p>
													<p class="track-lot-table-marketplace-pri-mode text-start">{{$type_of_service}}</p>
												</div>
												<div>
													<p class="track-lot-table-typeof-service text-start">Commercial (Per unit)</p>
													<p class="track-lot-table-marketplace-pri-mode text-start">₹{{$per_qty_value}}</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
					@endforeach
					
					{{-- <tr>
						<td class="table-column">The quick brown fox jumps over the lazy d...</td>
						<td class="table-column">Static post</td>
						<td class="table-column">126</td>
						<td class="table-column">126</td>
						<td class="table-column">
							<button class=" test myButton" style="border: 1px solid white;padding: 8px;">
								File Links
								<div class="myPopover">
									<div class="mt-3" style="line-height: 0.7;">
										<p>Creative links</p>
										<a href="#">View link</a>
									</div>
									<div class="mt-5" style="line-height: 0.7;">
										<p>Copy links</p>
										<a href="#">View link</a>
									</div>
								</div>
							</button>
						</td>
						<td class="wrc-no-sty">
							<p class="text" onmouseover="showPopover(this)" onmouseout="hidePopover(this)">DEMO1TWSR9-B</p>
							<!-- <a href="#" class="btn test myButton" role="button"></a> -->
							<div class="hoverpopoverforlinks" id="myPopover">
								<div class="popover-text">
									<div class="upper-head-style-for-track-hover">
										<div class="upper-heading-wrc-details-table pt-4">
											<div class="col-12 d-flex justify-content-between ps-4 pe-4">
												<div>
													<p class="track-lot-table-wrc-no">DEMO1TWSR9-B</p>
													<p class="track-lot-table-wrc-date text-start">23/01/2023</p>
												</div>
												<div>
													<p class="track-lot-table-inward-qty">Inward Quantity</p>
													<p class="track-lot-table-inward-qty-no text-start">130</p>
												</div>
											</div>
										</div>
									</div>
									<div class="lower-wrc-details-table mt-4">
										<div class="col-12 ps-3 mt-4">
											<p class="track-lot-table-typeof-service text-start">
												Project name
											</p>
										</div>
										<div class="col-12 d-flex ps-3 text-start">
											<p class="track-lot-table-marketplace-pri-mode text-start">
												The quick brown fox jumps over the lazy
											</p>
										</div>
										<div class="col-12 d-flex justify-content-between ps-3 pe-3 mt-4">
											<div>
												<p class="track-lot-table-typeof-service text-start">Type of service</p>
												<p class="track-lot-table-marketplace-pri-mode text-start">Static post</p>
											</div>
											<div>
												<p class="track-lot-table-typeof-service text-start">Commercial (Per unit)</p>
												<p class="track-lot-table-marketplace-pri-mode text-start">₹800</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr> --}}
				</tbody>
			</table>
		</div>
	</div>
@else
	<div style="color: #FFFFFF;">
		Wrc Not found
	</div>
@endif
@endsection

@section('js_scripts')
	<script>
		  // Attach event listeners to the parent container
        var linktablehover = document.getElementById('linktablehover');
        linktablehover.addEventListener('mouseover', showPopover);
        linktablehover.addEventListener('mouseout', hidePopover);
        
        // Show the popover when hovering over a text element
        function showPopover(event) {
          var target = event.target;
          if (target.classList.contains('text')) {
            var hoverpopoverforlinks = target.nextElementSibling;
            positionPopover(target, hoverpopoverforlinks);
            hoverpopoverforlinks.style.display = 'block';
          }
        }
        
        // Position the popover to the left of the text element
        function positionPopover(textElement, hoverpopoverforlinks) {
          var textRect = textElement.getBoundingClientRect();
          var textLeft = textRect.left;
          var textTop = textRect.top;
        
          hoverpopoverforlinks.style.right = 'auto'; // Reset the right property
          hoverpopoverforlinks.style.left = textLeft + 'px';
          hoverpopoverforlinks.style.top = textTop + 'px';
        }
        
        // Hide the popover when moving away from a text element
        function hidePopover(event) {
          var target = event.target;
          if (target.classList.contains('text')) {
            var hoverpopoverforlinks = target.nextElementSibling;
            hoverpopoverforlinks.style.display = 'none';
          }
        }

	</script>

	
@endsection
