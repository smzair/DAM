@extends('layouts.DamNewMain')
@section('title')
  Search Data
@endsection

@section('other_css')
	<style>
		.fovourites-img-lot-sku-wrc-section {
			font-weight: 500;
			font-size: 14px;
		    color: #FFFFFF;
			margin-bottom: 12px;
			margin-top: 40px;
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
		
		$searchData_shoot_lot = $data_array['searchData_shoot_lot'];
		$searchData_shoot_wrc = $data_array['searchData_shoot_wrc'];
		$searchData_shoot_sku = $data_array['searchData_shoot_sku'];
		$searchData_editing_lot = $data_array['searchData_editing_lot'];
		
		// dd($data_array , $searchData_shoot_lot,count($searchData_shoot_lot));
	@endphp



	<div class="row">
		<div class=" col-12 d-flex justify-content-between">
				<h4 class="headingF">
					Search Data
				</h4>
		</div>
	</div>
	<div class="row" style="margin-top: 12px;">
		<div class="col-12">
				<p class="underheadingF">
						Currently, you are viewing Search Data
				</p>
		</div>
	</div>

	<!-- Lots Section -->
	<div class="row">
		@if (count($searchData_shoot_lot) > 0)
			<div class="col-sm-12 col-md-12 col-lg-12">
				<p class="fovourites-img-lot-sku-wrc-section">Shoot & Post-production Lots</p>
			</div>

			@if (count($searchData_shoot_lot) > 0)
				@foreach ($searchData_shoot_lot as $lot_index => $row)
					@php
						$service = $row['service'];
						$tbl_id =  $row['id'];
						if($service == 'SHOOT'){
							$route_is = 'your_assets_shoot_wrcs';
							$download_route_is = "download_Shoot_Lot_edited";
						}elseif($service == 'EDITING'){
							$route_is = 'your_assets_editing_wrcs';
							$download_route_is = "download_Editing_Lot_edited";
						}

						if($service == 'SHOOT' || $service == 'EDITING'){
							$file_path = $row['file_path'];
							$shoot_image_src = 'IMG/group_10.png';
							$shoot_image_src1 = 'IMG/no_preview_available.jpg';
							if($file_path != ''){
								$shoot_image_src = $file_path;
								$shoot_image_src1 = $file_path;
							}
						}
					@endphp

					{{-- Shoot Lots --}}
					@if ($service == 'SHOOT')
						<div class="col-lg-4 col-md-6 box border-0" style="background: #0F0F0F; position: relative;" id="div_{{$tbl_id}}">
							<div class="row">
								<div class="under-content-div">
									<div class="col-12">
										<a href="{{route('your_assets_shoot_wrcs' , [$row['lot_id']])}}">
											<img  style="width: 100%; min-height: 393px;"  src="{{ asset($shoot_image_src1)}}" alt="" class="img-fluid">
										</a>
									</div>
									<div class="col-12 d-flex justify-content-between">
										<div>
											<p class="lot-no-heading">Lot no</p>
											<span class="your-asset-lotno-underbox" id="lot_number{{$row['lot_id'].$lot_index}}">{{$row['lot_number']}}</span>&nbsp;&nbsp;
											<div class="myPopover" style="display: none;">
												@php
													$lot_id_is = base64_encode($row['lot_id']);
												@endphp
												{{-- Download --}}
												<a href="{{route($download_route_is , [ 'id' =>  $row['lot_id'] ] )}}">
													<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
													</svg>&nbsp;
													Download
												</a>

												{{-- View Details --}}
												<a href="javascript:void(0)" onclick="toggleSidebar(); set_date_time({{$row['lot_id'].$lot_index}}, 'shoot');lots_details('{{ $lot_id_is  }}' , 'lot' , 'Edited') ">
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
													<span id="lot_date{{$row['lot_id'].$lot_index}}">{{dateFormet_dmy($row['lot_created_at'])}}</span>
													<span id="lot_time{{$row['lot_id'].$lot_index}}">{{date('h:i A', strtotime($row['lot_created_at']))}}</span>
													<span id="image_src{{$row['lot_id'].$lot_index}}">{{asset($shoot_image_src1)}}</span>
													<span id="skus_count{{$row['lot_id'].$lot_index}}">{{ $row['skus_count'] }}</span>
													<span id="raw_images{{$row['lot_id'].$lot_index}}">{{ $row['raw_images'] }}</span>
													<span id="edited_images{{$row['lot_id'].$lot_index}}">{{ $row['edited_images'] }}</span>
													<span id="s_type{{$row['lot_id'].$lot_index}}">{{ $row['s_type'] }}</span>
													<span id="wrc_numbers{{$row['lot_id'].$lot_index}}">{{ $row['wrc_numbers'] }}</span>
												</div>
												{{-- Share --}}
												<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$lot_index}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >
													<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
													</svg>&nbsp;
													Share
												</a>
												<p class="d-none" id="url_{{$lot_index}}">{{route($download_route_is , [ 'id' =>  $row['lot_id'] ] )}}</p>

												@php
													$service = base64_encode('SHOOT');
													$module = base64_encode('lot');
													$lot_id_is = base64_encode($row['lot_id']);
													$data_array = array(
														'user_id' => '', 
														'brand_id' => '', 
														'lot_id' => $lot_id_is, 
														'wrc_id' => '',
														'service' => $service, 
														'module' => $module 
													);

													$data_obj = json_encode($data_array,true);
												@endphp
												{{-- Add to favorites --}}
												{{-- <a href="javascript:void(0)" onclick="add_to_favorites({{$data_obj}})">
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
												</a> --}}

												{{-- Add Tag --}}
												{{-- <a href="javascript:void(0)">
													<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M3.47507 12.7498L7.25007 16.5248C7.99675 17.2693 9.00816 17.6873 10.0626 17.6873C11.117 17.6873 12.1284 17.2693 12.8751 16.5248L16.5334 12.8664C17.2779 12.1198 17.696 11.1084 17.696 10.0539C17.696 8.99952 17.2779 7.98812 16.5334 7.24144L12.7501 3.47477C12.3589 3.08252 11.8898 2.77675 11.373 2.57722C10.8562 2.37769 10.3033 2.28884 9.75007 2.31644L5.58341 2.51644C3.91674 2.59144 2.59174 3.91644 2.50841 5.57477L2.30841 9.74144C2.25841 10.8664 2.68341 11.9581 3.47507 12.7498Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
														<path d="M7.91659 9.99967C8.46912 9.99967 8.99902 9.78018 9.38972 9.38948C9.78043 8.99878 9.99992 8.46888 9.99992 7.91634C9.99992 7.36381 9.78043 6.8339 9.38972 6.4432C8.99902 6.0525 8.46912 5.83301 7.91659 5.83301C7.36405 5.83301 6.83415 6.0525 6.44345 6.4432C6.05275 6.8339 5.83325 7.36381 5.83325 7.91634C5.83325 8.46888 6.05275 8.99878 6.44345 9.38948C6.83415 9.78018 7.36405 9.99967 7.91659 9.99967Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
													</svg> &nbsp;
													Add Tag
												</a> --}}

												{{-- Remove from Favorites --}}
												{{-- <a href="javascript:void(0)" onclick="remove_favorites('{{base64_encode($tbl_id)}}')">
													<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
														<g clip-path="url(#clip0_1043_2500)">
															<path d="M11.4416 2.92422L12.9083 5.85755C13.1083 6.26589 13.6416 6.65755 14.0916 6.73255L16.7499 7.17422C18.4499 7.45755 18.8499 8.69089 17.6249 9.90755L15.5583 11.9742C15.2083 12.3242 15.0166 12.9992 15.1249 13.4826L15.7166 16.0409C16.1833 18.0659 15.1083 18.8492 13.3166 17.7909L10.8249 16.3159C10.3749 16.0492 9.63326 16.0492 9.17492 16.3159L6.68326 17.7909C4.89992 18.8492 3.81659 18.0576 4.28326 16.0409L4.87492 13.4826C4.98326 12.9992 4.79159 12.3242 4.44159 11.9742L2.37492 9.90755C1.15826 8.69089 1.54992 7.45755 3.24992 7.17422L5.90826 6.73255C6.34992 6.65755 6.88326 6.26589 7.08326 5.85755L8.54992 2.92422C9.34992 1.33255 10.6499 1.33255 11.4416 2.92422Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
														</g>
														<defs>
															<clipPath id="clip0_1043_2500">
																<rect width="20" height="20" fill="white"/>
															</clipPath>
														</defs>
													</svg>
													&nbsp;&nbsp;
													Remove from favorites
												</a> --}}
											</div>
										</div>

										<div type="button" class="btn border-0 rounded-circle myButton">
											<i class="bi bi-three-dots-vertical" style="color: #9F9F9F;line-height: 2.5;">
											</i>
										</div>
									</div>
									<div class="col-12">
											<span class="your-asset-lot-date-underbox">Date :</span> <span class="your-asset-lot-date">{{dateFormet_dmy($row['lot_created_at'])}}</span>
									</div>
									<div class="col-12 d-flex justify-content-between">
										<div>
											<p class="inward-qty">Inward Quantity : </p>
											<p class="inward-qty-num">
												{{$row['inward_quantity']}}
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

					{{-- Editting Lots --}}
					@elseif($service == 'EDITING')
						
						
					@endif

				@endforeach
			@else
				<div class="col-sm-6 col-md-4 col-lg-3">
					<p class="underheadingF">No Lots</p>
				</div>
			@endif
		@else
			<div class="col-sm-6 col-md-4 col-lg-3 ">
				<p class="underheadingF">No Lots</p>
			</div>
		@endif
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
						<img id="image_src" src="{{asset('IMG/group_10.png')}}" alt="" class="img-fluid" style="background: rgba(255, 255, 255, 0.1);">
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="row">
					<div class="col-12 ps-4" style="margin-top: 24px;">
						<p class="heading-details">Folder details</p>
					</div>
					<div class="col-11 ps-4">
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
					<div class="col-12 ps-4">
						<p class="side-text">SIZE</p>
						<P class="side-text2" id="file_size"></P>
					</div>
					{{-- Shoot files other data --}}
					<div id="shoot_files_details" class="p-0 d-none">
						<div class="col-11 ps-4">
							<p class="side-text">WRC</p>
							<P  id="wrc_numbers" class="side-text2"></P>
						</div>
						<div class="col-10 ps-4">
							<div class="d-flex justify-content-between">
								<p class="side-text">SHOOT TYPE</p>
								<P class="side-text">SKU</P>
							</div>
							<div class="d-flex justify-content-between">
								<p id="s_type" class="side-text2"></p>
								<P id="skus_count" class="side-text2"></P>
							</div>
						</div>
						<div class="col-10 ps-4">
							<div class="d-flex justify-content-between">
								<p class="side-text">RAW IMAGE</p>
								<P class="side-text">EDITED IMAGE</P>
							</div>
							<div class="d-flex justify-content-between">
								<p id="raw_images" class="side-text2"></p>
								<P id="edited_images" class="side-text2"></P>
							</div>
						</div>
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
@endsection

@section('js_scripts')
	{{-- Setting data and time in side bar --}}
	<script>
		const set_links_date_time = (key) => {
			console.log('key', key)
			const lot_number = $("#lot_number"+key).html()
			const lot_date = $("#lot_date"+key).html()
			const lot_time = $("#lot_time"+key).html()
			const file_size = $("#file_size"+key).html()
			$("#lot_time").html(lot_time)
			$("#lot_date").html(lot_date)
			$("#lot_number").html(lot_number)
			$("#file_size").html(file_size)
			const image_src = $("#image_src"+key).html()
			$("#image_src").attr("src", image_src);
		}
	</script>

	{{-- Setting image data and time in side bar --}}
	<script>
		const set_image_date_time = (key , service = 'other') => {
			console.log('key', key)
			const lot_number = $("#lot_number"+key).html()
			const lot_date = $("#lot_date"+key).html()
			const lot_time = $("#lot_time"+key).html()
			const file_size = $("#file_size"+key).html()
			$("#lot_time").html(lot_time)
			$("#lot_date").html(lot_date)
			$("#lot_number").html(lot_number)
			$("#file_size").html(file_size)
			const image_src = $("#image_src"+key).html()
			$("#image_src").attr("src", image_src);
			
		}
	</script>

	{{-- Removing files from favorites --}}
	<script>
		async function remove_favorites(id){
			console.log('id', id)
			await $.ajax({
				url: "{{ url('Remove-your-assets-Favorites') }}",
				type: "POST",
				dataType: 'json',
				data: {
					id: id,
					_token: '{{ csrf_token() }}'
				},
				success: function(res) {
					if(res?.status){
						id = res.id;
						alert('File removed from Favorites List')
						$('#div_'+id).css({
							"pointer-events": "none",
							"opacity": 0.2
						});
						// $('#div_'+id).remove();
						// window.location.reload();
					}else{
						alert('somthing went Wrong!!')
					}
				}
			});
		}
	</script>
@endsection
