@extends('layouts.DamNewMain')
@section('title')
  Your Assets - Links
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
{{-- Sort by  --}}
<?php 
$lot_status_is = $sortBy = $lot_status_val = "" ;
	if(isset($other_data)){
		if(isset($other_data['sortBy'])){
			$sortBy = $other_data['sortBy'];
		}
		if(isset($other_data['service_is'])){
			$service_is = $other_data['service_is'];
		}
	}
?>

<div class="row">
	<div class=" col-12 d-flex justify-content-between">
		<h4 class="headingF">
			{{$service_is == 'Creative' ? 'Creative Lots' : 'Listing Lots' }}
		</h4>
		<div class="dropdown mt-2">
			<a class="btn rounded-0 sort-by-button  dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				Sort &nbsp;&nbsp;&nbsp;&nbsp;
			</a>
			<ul class="dropdown-menu dropdown-menu-show-sortby">
				<li><a class="dropdown-item dropdown-menu-show-sortby-item {{$sortBy == 'latest' ? 'active' : ''}}" href="{{route('your_assets_Links', ['sortBy' => 'latest' ])}}">Latest</a></li>
				<li><a class="dropdown-item dropdown-menu-show-sortby-item {{($sortBy == 'oldest' || $sortBy == 'old')  ? 'active' : ''}}" href="{{route('your_assets_Links', ['sortBy' => 'oldest' ] )}}">Oldest</a></li>
			</ul>
	</div>
</div>

@if (count($creative_lots) > 0 || count($catalog_lots) > 0 )

	<div class="row" style="margin-top: 20px;">
		<div class="" id="pills-tabContent">
			{{-- creative Lots --}}
			@if (count($creative_lots) > 0)
				<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
					tabindex="0">
					<div class="row box-container-responsive">
						<div class="col-12">
							<p class="totallotF">Total Lots: {{count($creative_lots)}}</p>
						</div>
						
						@foreach ($creative_lots as $key => $row)
							@php
								$lot_created_at = $row['lot_created_at'];
								$submission_date = $row['submission_date'];
								$wrc_numbers = ($row['wrc_numbers'] != '' && $row['wrc_numbers'] != null) ? $row['wrc_numbers'] : 'Wrc not generated.'; 
								$lot_id_is = base64_encode($row['id']);
								// dd($row);
							@endphp

							<div class="col-lg-4 col-md-6 box border-0" style="position: relative;">
								<div class="row">
									<div class="under-content-div">
										
										<div class="col-12 d-flex d-flex justify-content-between">
										    <div>
												<p class="lot-no-heading">Lot no</p>
												<span class="your-asset-lotno-underbox" id="lot_number{{$row['id'].$key}}">{{$row['lot_number']}}</span>
												<p class="file-lot-date-para">
												    <span class="your-asset-lot-date-underbox">Date :</span> <span class="your-asset-lot-date">{{dateFormet_dmy($row['lot_created_at'])}} </span>
												</p>
												 <div class="myPopover" style="display: none;">
													<a href="javascript:void(0)" onclick="toggleSidebar(); set_links_date_time('{{$row['id'].$key}}') ">
														<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
															<g clip-path="url(#clip0_1069_2515)">
																<path d="M9.99992 13.333L9.99992 9.16634M9.99992 1.66634C5.41658 1.66634 1.66658 5.41634 1.66658 9.99968C1.66659 14.583 5.41659 18.333 9.99992 18.333C14.5833 18.333 18.3333 14.583 18.3333 9.99967C18.3333 5.41634 14.5833 1.66634 9.99992 1.66634Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
																<path d="M10.0042 6.66699L9.99665 6.66699" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
															</g>
															<defs>
																<clipPath id="clip0_1069_2515">
																	<rect width="20" height="20" fill="white"/>
																</clipPath>
															</defs>
														</svg>&nbsp;
														View Details
													</a>

													<div class="d-none">
														<span id="lot_date{{$row['id'].$key}}">{{dateFormet_dmy($row['lot_created_at'])}}</span>
														<span id="lot_time{{$row['id'].$key}}">{{date('h:i A', strtotime($row['lot_created_at']))}}</span>
														<span id="wrc_numbers{{$row['id'].$key}}">{{ $wrc_numbers }}</span>

													</div>
													
													@php
														$service = base64_encode('CREATIVE');
														$module = base64_encode('lot');
														$lot_id_is = base64_encode($row['id']);
														$data_array = array(
															'user_id' => base64_encode($row['user_id']), 
															'brand_id' => base64_encode($row['brand_id']), 
															'lot_id' => $lot_id_is, 
															'wrc_id' => '',
															'service' => $service, 
															'module' => $module 
														);

														$data_obj = json_encode($data_array,true);
													@endphp
													
													<a href="javascript:void(0)" onclick="add_to_favorites({{$data_obj}})">
													
														<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
															<g clip-path="url(#clip0_1069_2524)">
															<path d="M11.4416 2.9252L12.9083 5.85853C13.1083 6.26686 13.6416 6.65853 14.0916 6.73353L16.7499 7.1752C18.4499 7.45853 18.8499 8.69186 17.6249 9.90853L15.5583 11.9752C15.2083 12.3252 15.0166 13.0002 15.1249 13.4835L15.7166 16.0419C16.1833 18.0669 15.1083 18.8502 13.3166 17.7919L10.8249 16.3169C10.3749 16.0502 9.63326 16.0502 9.17492 16.3169L6.68326 17.7919C4.89992 18.8502 3.81659 18.0585 4.28326 16.0419L4.87492 13.4835C4.98326 13.0002 4.79159 12.3252 4.44159 11.9752L2.37492 9.90853C1.15826 8.69186 1.54992 7.45853 3.24992 7.1752L5.90826 6.73353C6.34992 6.65853 6.88326 6.26686 7.08326 5.85853L8.54992 2.9252C9.34992 1.33353 10.6499 1.33353 11.4416 2.9252Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
															</g>
															<defs>
															<clipPath id="clip0_1069_2524">
															<rect width="20" height="20" fill="white"/>
															</clipPath>
															</defs>
														</svg>&nbsp;
														Add to favorites
													</a>
												 <a href="javascript:void(0)">
														<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M3.47507 12.7498L7.25007 16.5248C7.99675 17.2693 9.00816 17.6873 10.0626 17.6873C11.117 17.6873 12.1284 17.2693 12.8751 16.5248L16.5334 12.8664C17.2779 12.1198 17.696 11.1084 17.696 10.0539C17.696 8.99952 17.2779 7.98812 16.5334 7.24144L12.7501 3.47477C12.3589 3.08252 11.8898 2.77675 11.373 2.57722C10.8562 2.37769 10.3033 2.28884 9.75007 2.31644L5.58341 2.51644C3.91674 2.59144 2.59174 3.91644 2.50841 5.57477L2.30841 9.74144C2.25841 10.8664 2.68341 11.9581 3.47507 12.7498Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
															<path d="M7.91659 9.99967C8.46912 9.99967 8.99902 9.78018 9.38972 9.38948C9.78043 8.99878 9.99992 8.46888 9.99992 7.91634C9.99992 7.36381 9.78043 6.8339 9.38972 6.4432C8.99902 6.0525 8.46912 5.83301 7.91659 5.83301C7.36405 5.83301 6.83415 6.0525 6.44345 6.4432C6.05275 6.8339 5.83325 7.36381 5.83325 7.91634C5.83325 8.46888 6.05275 8.99878 6.44345 9.38948C6.83415 9.78018 7.36405 9.99967 7.91659 9.99967Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
														</svg> &nbsp;
														Add Tag
													</a>
												</div>
											</div>
											<div type="button" class="btn border-0 rounded-circle myButton">
													<i class="bi bi-three-dots-vertical" style="color: #9F9F9F;">
													</i>
											</div>
										</div>
										<div class="col-12 d-flex justify-content-between">
											<div>
												<p class="inward-qty">Inward Quantity : </p>
												<p class="inward-qty-num">
													{{$row['inward_qty'] != '' ? $row['inward_qty'] : 0}}
												</p>
											</div>
											<div>
												<p class="inward-qty">Submission</p>
												<p class="inward-qty-num">
													{{$submission_date != '' ? dateFormet_dmy($submission_date) : $submission_date }}
												</p>
											</div>
										</div>
										<div class="col-12 d-grid gap-2">
											<a role="button" class="btn border rounded-0 view-img " href="{{route('your_assets_creative_wrcs_links' , ['lot_id' => $lot_id_is])}}">
												View Links
											</a>
										</div>
									</div>
								</div>
							</div>
						@endforeach				
					
					</div>
				</div>
			@endif

			{{-- catalog Lots --}}
			@if (count($catalog_lots) > 0)
				<div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
					tabindex="0">
					<div class="row box-container-responsive">
						<div class="col-12">
							<p class="totallotF">Total Lots: {{count($catalog_lots)}}</p>
						</div>
						@foreach ($catalog_lots as $key => $row)
							@php
								$lot_created_at = $row['lot_created_at'];
								$submission_date = $row['submission_date'];
								$lot_id_is = base64_encode($row['id']);
								$wrc_numbers = ($row['wrc_numbers'] != '' && $row['wrc_numbers'] != null) ? $row['wrc_numbers'] : 'Wrc not generated'; 
								// dd($row);
							@endphp
							<div class="col-lg-4 col-md-6 box border-0" style="position: relative;">
								<div class="row">
									<div class="under-content-div">
										
										<div class="col-12 d-flex d-flex justify-content-between">
											     <div>
											    	<p class="lot-no-heading">Lot no</p>
											    	<span class="your-asset-lotno-underbox" id="lot_number{{$row['brand_id'].$key}}">{{$row['lot_number']}}</span>
											    	<p class="file-lot-date-para">
											    	   <span class="your-asset-lot-date-underbox">Date :</span> <span class="your-asset-lot-date">{{dateFormet_dmy($row['lot_created_at'])}}</span> 
											    	</p>
											    	
												 	<div class="myPopover" style="display: none;">
													<a href="javascript:void(0)" onclick="toggleSidebar(); set_links_date_time('{{$row['brand_id'].$key}}')">
														<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
															<g clip-path="url(#clip0_1069_2515)">
																<path d="M9.99992 13.333L9.99992 9.16634M9.99992 1.66634C5.41658 1.66634 1.66658 5.41634 1.66658 9.99968C1.66659 14.583 5.41659 18.333 9.99992 18.333C14.5833 18.333 18.3333 14.583 18.3333 9.99967C18.3333 5.41634 14.5833 1.66634 9.99992 1.66634Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
																<path d="M10.0042 6.66699L9.99665 6.66699" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
															</g>
															<defs>
																<clipPath id="clip0_1069_2515">
																	<rect width="20" height="20" fill="white"/>
																</clipPath>
															</defs>
														</svg>&nbsp;
														View Details
													</a>

													<div class="d-none">
														<span id="lot_date{{$row['brand_id'].$key}}">{{dateFormet_dmy($row['lot_created_at'])}}</span>
														<span id="lot_time{{$row['brand_id'].$key}}">{{date('h:i A', strtotime($row['lot_created_at']))}}</span>
														<span id="wrc_numbers{{$row['brand_id'].$key}}">{{ $wrc_numbers }}</span>
													</div>
													
													@php
														$service = base64_encode('CATALOGING');
														$module = base64_encode('lot');
														$lot_id_is = base64_encode($row['id']);
														$data_array = array(
															'user_id' => base64_encode($row['user_id']), 
															'brand_id' => base64_encode($row['brand_id']), 
															'lot_id' => $lot_id_is, 
															'wrc_id' => '',
															'service' => $service, 
															'module' => $module 
														);

														$data_obj = json_encode($data_array,true);
													@endphp
													<a href="javascript:void(0)" onclick="add_to_favorites({{$data_obj}})">
													
														<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
															<g clip-path="url(#clip0_1069_2524)">
															<path d="M11.4416 2.9252L12.9083 5.85853C13.1083 6.26686 13.6416 6.65853 14.0916 6.73353L16.7499 7.1752C18.4499 7.45853 18.8499 8.69186 17.6249 9.90853L15.5583 11.9752C15.2083 12.3252 15.0166 13.0002 15.1249 13.4835L15.7166 16.0419C16.1833 18.0669 15.1083 18.8502 13.3166 17.7919L10.8249 16.3169C10.3749 16.0502 9.63326 16.0502 9.17492 16.3169L6.68326 17.7919C4.89992 18.8502 3.81659 18.0585 4.28326 16.0419L4.87492 13.4835C4.98326 13.0002 4.79159 12.3252 4.44159 11.9752L2.37492 9.90853C1.15826 8.69186 1.54992 7.45853 3.24992 7.1752L5.90826 6.73353C6.34992 6.65853 6.88326 6.26686 7.08326 5.85853L8.54992 2.9252C9.34992 1.33353 10.6499 1.33353 11.4416 2.9252Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
															</g>
															<defs>
															<clipPath id="clip0_1069_2524">
															<rect width="20" height="20" fill="white"/>
															</clipPath>
															</defs>
														</svg>&nbsp;
														Add to favorites
													</a>
												 <a href="javascript:void(0)">
														<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M3.47507 12.7498L7.25007 16.5248C7.99675 17.2693 9.00816 17.6873 10.0626 17.6873C11.117 17.6873 12.1284 17.2693 12.8751 16.5248L16.5334 12.8664C17.2779 12.1198 17.696 11.1084 17.696 10.0539C17.696 8.99952 17.2779 7.98812 16.5334 7.24144L12.7501 3.47477C12.3589 3.08252 11.8898 2.77675 11.373 2.57722C10.8562 2.37769 10.3033 2.28884 9.75007 2.31644L5.58341 2.51644C3.91674 2.59144 2.59174 3.91644 2.50841 5.57477L2.30841 9.74144C2.25841 10.8664 2.68341 11.9581 3.47507 12.7498Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
															<path d="M7.91659 9.99967C8.46912 9.99967 8.99902 9.78018 9.38972 9.38948C9.78043 8.99878 9.99992 8.46888 9.99992 7.91634C9.99992 7.36381 9.78043 6.8339 9.38972 6.4432C8.99902 6.0525 8.46912 5.83301 7.91659 5.83301C7.36405 5.83301 6.83415 6.0525 6.44345 6.4432C6.05275 6.8339 5.83325 7.36381 5.83325 7.91634C5.83325 8.46888 6.05275 8.99878 6.44345 9.38948C6.83415 9.78018 7.36405 9.99967 7.91659 9.99967Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
														</svg> &nbsp;
														Add Tag
													</a>
												</div>
										    	</div>
												<div type="button" class="btn border-0 rounded-circle myButton">
													<i class="bi bi-three-dots-vertical" style="color: #9F9F9F;">
													</i>
												</div>
										</div>
										<div class="col-12 d-flex justify-content-between">
											<div>
												<p class="inward-qty">Inward Quantity : </p>
												<p class="inward-qty-num">
													{{$row['inward_qty'] != '' ? $row['inward_qty'] : 0}}
												</p>
											</div>
											<div>
												<p class="inward-qty">Submission</p>
												<p class="inward-qty-num">
													{{$submission_date != '' ? dateFormet_dmy($submission_date) : $submission_date }}
												</p>
											</div>
										</div>
										<div class="col-12 d-grid gap-2">
											<a role="button" class="btn border rounded-0 view-img " href="{{route('your_assets_cataloging_wrcs_links' , ['lot_id' => $lot_id_is])}}">
												View Links
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
		<div class="row sidebar-row-where-content">
			<div class="col-12 d-flex justify-content-between">
			    <div class="row">
			      <div class="col-11">
			         <p class="side-lot" id="lot_number"></p>
			      </div>
			      <div class="col-1">
			         <button onclick="toggleSidebar()" type="button" class="btn border-0 close-button">
					   <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M14.19 0H5.81C2.17 0 0 2.17 0 5.81V14.18C0 17.83 2.17 20 5.81 20H14.18C17.82 20 19.99 17.83 19.99 14.19V5.81C20 2.17 17.83 0 14.19 0ZM13.36 12.3C13.65 12.59 13.65 13.07 13.36 13.36C13.21 13.51 13.02 13.58 12.83 13.58C12.64 13.58 12.45 13.51 12.3 13.36L10 11.06L7.7 13.36C7.55 13.51 7.36 13.58 7.17 13.58C6.98 13.58 6.79 13.51 6.64 13.36C6.50052 13.2189 6.4223 13.0284 6.4223 12.83C6.4223 12.6316 6.50052 12.4411 6.64 12.3L8.94 10L6.64 7.7C6.50052 7.55886 6.4223 7.36843 6.4223 7.17C6.4223 6.97157 6.50052 6.78114 6.64 6.64C6.93 6.35 7.41 6.35 7.7 6.64L10 8.94L12.3 6.64C12.59 6.35 13.07 6.35 13.36 6.64C13.65 6.93 13.65 7.41 13.36 7.7L11.06 10L13.36 12.3Z"	fill="white" />
					   </svg>
				  </button>
			     </div>
			  </div>
			</div>

			<div class="col-12 wrc-detail-img d-none">
				<div class="row">
					<div class="col-12" style="margin-top: 16px;">
						<img id="image_src" src="{{asset('IMG/group_10.png')}}" alt="" class="img-fluid" style="background: rgba(255, 255, 255, 0.1);">
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="row">
					<div class="col-11">
						<p class="side-text ">DATE & TIME</p>
						<div class="d-flex justify-content-between ">
							<p class="side-text2 ">
								<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M4.66667 1.16699V2.91699M9.33333 1.16699V2.91699M2.04167 5.30283H11.9583M12.25 4.95866V9.91699C12.25 11.667 11.375 12.8337 9.33333 12.8337H4.66667C2.625 12.8337 1.75 11.667 1.75 9.91699V4.95866C1.75 3.20866 2.625 2.04199 4.66667 2.04199H9.33333C11.375 2.04199 12.25 3.20866 12.25 4.95866Z" stroke="white" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M9.15563 7.99121H9.16088M9.15563 9.74121H9.16088M6.9973 7.99121H7.00313M6.9973 9.74121H7.00313M4.83838 7.99121H4.84421M4.83838 9.74121H4.84421" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
								<span id="lot_date"></span>
							</p>
							<p class="side-text2 ">
								<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
									<g clip-path="url(#clip0_1069_5368)">
										<path d="M12.8332 7.00033C12.8332 10.2203 10.2198 12.8337 6.99984 12.8337C3.77984 12.8337 1.1665 10.2203 1.1665 7.00033C1.1665 3.78033 3.77984 1.16699 6.99984 1.16699C10.2198 1.16699 12.8332 3.78033 12.8332 7.00033Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M9.16418 8.85503L7.35585 7.77586C7.04085 7.58919 6.78418 7.14003 6.78418 6.77253V4.38086" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
									</g>
									<defs>
										<clipPath id="clip0_1069_5368">
											<rect width="14" height="14" fill="white"/>
										</clipPath>
									</defs>
								</svg>
								<span id="lot_time"></span>

							</p>
						</div>
					</div>

					{{-- Shoot files other data --}}
					<div id="files_details">
						<div class="col-11">
							<p class="side-text">WRC</p>
							<P  id="wrc_numbers" class="side-text2"></P>
						</div>
					</div>

					<div class="col-12">
						<p class="side-text">TAGS</p>
						<P class="side-text2">Black Tees, Ajio code</P>
					</div>

					<!--<div class="col-12 d-grid gap-2">-->
					<!--	<button class="btn border rounded-0  heading-details" type="button">-->
					<!--		<svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">-->
					<!--			<path-->
					<!--				d="M11.5529 4.53224L4.71122 11.7739C4.45289 12.0489 4.20289 12.5906 4.15289 12.9656L3.84455 15.6656C3.73622 16.6406 4.43622 17.3072 5.40289 17.1406L8.08622 16.6822C8.46122 16.6156 8.98622 16.3406 9.24455 16.0572L16.0862 8.81558C17.2696 7.56558 17.8029 6.14058 15.9612 4.39891C14.1279 2.67391 12.7362 3.28224 11.5529 4.53224Z"-->
					<!--				stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"-->
					<!--				stroke-linejoin="round" />-->
					<!--			<path-->
					<!--				d="M10.4111 5.74121C10.5858 6.85859 11.1266 7.88632 11.9486 8.66308C12.7707 9.43984 13.8273 9.92165 14.9528 10.0329"-->
					<!--				stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"-->
					<!--				stroke-linejoin="round" />-->
					<!--		</svg>-->
					<!--		&nbsp; Edit tag-->
					<!--	</button>-->
					<!--</div>-->
					
					<div class="col-12" style="margin-top: 24px;">
						<p class="heading-details">Share</p>
					</div>

					<div class="col-12 d-grid gap-2 my-2">
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
{{-- Setting data and time in side bar --}}
<script>
	const set_links_date_time = (key , service = 'other') => {
		const lot_number = $("#lot_number"+key).html()
		const lot_date = $("#lot_date"+key).html()
		const lot_time = $("#lot_time"+key).html()

		$("#lot_time").html(lot_time)
		$("#lot_date").html(lot_date)
		$("#lot_number").html(lot_number)
		$("#wrc_numbers").html($("#wrc_numbers"+key).html())
		
	}
</script>
{{-- add to favorites Script --}}
	<script>
		async function add_to_favorites(data_obj = ''){
			console.log('data_obj => ', data_obj);
			await $.ajax({
				url: "{{ url('your-assets-Favorites')}}",
				type: "POST",
				dataType: 'json',
				data: {
					data : data_obj,
					_token: '{{ csrf_token() }}'
				},
				success: function(res) {
					alert(res.massage)
					console.log('res => ', res )
				}
			});
		}
	</script>

@endsection
