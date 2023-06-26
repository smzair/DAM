@extends('layouts.DamNewMain')
@section('title')
  Search Data
@endsection
@section('css_links')
	<!-- Owl carausel link -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
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
	
	<style>
		.adap-div {
			background: #1A1A1A;
		}

		.under-adap-div {
			display: flex;
			justify-content: space-between;
			padding: 16px;
		}

		.adap-wrc {
			color: #FFFFFF;
		}

		.adap-wrc,
		.adap-wrc-dots {
			display: inline-block;
			/* Set display property to inline-block */
			vertical-align: middle;
			/* Align elements vertically */
		}

		.wrc-file-div {
			padding: 12px 12px 12px 12px;
		}

		.adap-div-forAdaption {
			background: #333333;
		}

		.adap-div-forAdaption-content {
			padding: 12px 16px 16px 16px;
		}

		.Adaptations-text-wrclevel {
			font-weight: 500;
			font-size: 11px;
			letter-spacing: 0.5px;
			color: #FFFFFF;
			margin-bottom: 0px;
		}

		.WRC-no-file {
			font-weight: 400;
			font-size: 14px;
			letter-spacing: 0.25px;
			color: #FFFFFF;
		}

		.AdaptLogo-section {
			margin-top: 8px;
			display: flex;
			/* gap: 12px; */
			overflow: hidden;
		}

		.owl-item.active {
			width: 39.3px !important;
			margin-right: 0px !important;
		}

		.owl-nav {
			height: 0px !important;
		}

		.owl-dots {
			height: 0px !important;
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
		$searchData_shoot_edited_images = $data_array['searchData_shoot_edited_images'];
		// dd($searchData_shoot_lot , $searchData_shoot_wrc,$searchData_shoot_sku);

		// Editing
		$searchData_editing_lot = $data_array['searchData_editing_lot'];
		$searchData_editing_wrc = $data_array['searchData_editing_wrc'];
		
		// Creative 
		$searchData_creative_lot = $data_array['searchData_creative_lot'];
		$searchData_creative_wrc = $data_array['searchData_creative_wrc'];

		
		// Cataloging 
		$searchData_catalog_lot = $data_array['searchData_catalog_lot'];
		$searchData_catalog_wrc = $data_array['searchData_catalog_wrc'];
		
		// dd($data_array , $searchData_editing_wrc);
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

	{{-- Image section  --}}

	<div class="row">
		@if (count($searchData_shoot_edited_images)  > 0)
			<div class="col-sm-12 col-md-12 col-lg-12">
				<p class="fovourites-img-lot-sku-wrc-section">Shoot Images</p>
			</div>
			@foreach ($searchData_shoot_edited_images as $index => $row)
				@php
					$unic_index = $row['id'].$row['sku_id'].$index;
					$path = $row['file_path'];
					$img_src = "IMG/no_preview_available.jpg";
					$zipFileSize = "File Not Found!!";

					if(file_exists($path)){
						$img_src = $path;
						$zipFileSize = filesize($path);
						$zipFileSize = formatBytes($zipFileSize);
					}

					$tbl_id = $row['id'];
					// dd($row , $row);
				@endphp
				<div class="col-sm-6 col-md-4 col-lg-3 SKU-BOX-STYLE" id="div_{{$tbl_id}}">
					<div class="card brand-img-m border-0 rounded-0">
							<img class="card-img-top brand-img" src="{{asset($img_src)}}"
									alt="Image">
							<div class="card-body total-sku-img-body d-flex justify-content-between"
									style="position: relative">
									<p class="brand-img-name" id="lot_number{{$unic_index}}">{{$row['filename']}}</p>
									<i class="bi bi-three-dots-vertical myButton"
											style="cursor: pointer;color:#808080;"></i>
									<div class="myPopover" style="display: none; top:70%;">

										<a href="{{asset($img_src)}}"
												download="{{$row['filename']}}">
												<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
														xmlns="http://www.w3.org/2000/svg">
														<path
																d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942"
																stroke="white" stroke-width="1.5" stroke-miterlimit="10"
																stroke-linecap="round" stroke-linejoin="round"></path>
												</svg>
												&nbsp;&nbsp;
												Download
										</a>
										<a href="javascript:void(0)" onclick="toggleSidebarNew('image'); set_image_date_time({{$unic_index}});">
												<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
														xmlns="http://www.w3.org/2000/svg">
														<g clip-path="url(#clip0_1043_2491)">
																<path
																		d="M9.99992 13.334L9.99992 9.16732M9.99992 1.66732C5.41658 1.66732 1.66658 5.41732 1.66658 10.0007C1.66659 14.584 5.41659 18.334 9.99992 18.334C14.5833 18.334 18.3333 14.584 18.3333 10.0007C18.3333 5.41732 14.5833 1.66732 9.99992 1.66732Z"
																		stroke="white" stroke-width="1.5" stroke-linecap="round"
																		stroke-linejoin="round"></path>
																<path d="M10.0042 6.66602L9.99665 6.66602" stroke="white"
																		stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
																</path>
														</g>
														<defs>
																<clipPath id="clip0_1043_2491">
																		<rect width="20" height="20" fill="white"></rect>
																</clipPath>
														</defs>
												</svg>
												&nbsp;&nbsp;
												View Details
										</a>
										<div class="d-none">
											<span id="lot_date{{$unic_index}}">{{dateFormet_dmy($row['created_at'])}}</span>
											<span id="lot_time{{$unic_index}}">{{date('h:i A', strtotime($row['created_at']))}}</span>
											<span id="file_size{{$unic_index}}">{{ $zipFileSize }}</span>
											<span id="image_src{{$unic_index}}">{{asset($img_src)}}</span>
										</div>
										{{-- Share --}}
										<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$unic_index}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
											&nbsp;&nbsp;
											Share
										</a>
										<p class="d-none" id="url_{{$unic_index}}">{{ asset($img_src)}}</p>

									</div>
							</div>
					</div>
				</div>
			@endforeach
		@endif
	</div>

	<!-- SKUs Section -->
	<div class="row">
		@if (count($searchData_shoot_sku)  > 0)
			<p class="fovourites-img-lot-sku-wrc-section">SKUs</p>
			@foreach ($searchData_shoot_sku as $key_index => $row)
				@php

					// dd($row);
					$key = $row['sku_id'].$key_index;
					$wrc_info = $row['wrc_info'];
					$wrc_id = $wrc_info['wrc_id'];
					$service_is = isset($row['service']) ? $row['service'] : 'SHOOT';
					$file_path = isset($row['file_path']) ? $row['file_path'] : '';
					$shoot_image_src = 'IMG/no_preview_available.jpg';
					if($file_path != ''){
						$shoot_image_src = $file_path;
					}
					$sku_files_images_image_route = 'your_assets_shoot_edited_images';
					$tbl_id = $row['id'];
					$sku_id_is = base64_encode($row['sku_id']);
					$download_route_is = "download_Shoot_lot_Edited_adaptation";
					$adaptation = base64_encode($row['adaptation']);

				@endphp

				<div class="col-lg-3 col-md-6 SKU-BOX-STYLE" id="div_{{$tbl_id}}">
					<div class="row brand-div2" style="position: relative;">
						<div class="col-2 mt-3">
							<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M23.5735 13.0404C23.5407 13.194 23.4783 13.3428 23.4167 13.486C23.2951 13.7676 23.1695 14.0476 23.0335 14.322C22.0167 16.3748 20.9847 18.4204 19.9703 20.4748C19.5743 21.2772 18.9519 21.6556 18.0567 21.6548C12.7055 21.6476 7.35429 21.65 2.00309 21.6524C1.42469 21.6524 0.829492 21.4044 0.559893 20.8636C0.411093 20.5652 0.562292 20.3028 0.692692 20.0308C0.796692 19.8132 0.900692 19.5964 1.00549 19.3788C1.21349 18.9444 1.42149 18.51 1.62949 18.0748C1.83749 17.6404 2.04549 17.2052 2.25269 16.7708C2.46069 16.3356 2.66789 15.9012 2.87509 15.466C3.08229 15.0308 3.28949 14.5956 3.49669 14.1604C3.70389 13.7252 3.91029 13.29 4.11749 12.8548C4.22629 12.626 4.33429 12.398 4.44309 12.1692C4.83429 11.3452 5.47589 10.9356 6.37909 10.9348C11.4439 10.9324 16.5079 10.9308 21.5727 10.9364C22.0591 10.9364 22.5511 11.0556 22.9239 11.382C23.2063 11.6292 23.4223 11.9604 23.5303 12.3204C23.5847 12.502 23.6103 12.6924 23.5975 12.882C23.5943 12.9356 23.5863 12.9884 23.5743 13.0404H23.5735Z" fill="white"/>
								<path d="M0.408809 17.4766C0.400009 17.4646 0.399209 17.447 0.400809 17.4326C0.406409 17.3726 0.405609 17.3126 0.405609 17.2526C0.405609 13.2534 0.405609 9.25342 0.405609 5.25422C0.405609 4.23902 0.973609 3.67102 1.99041 3.67022C3.71841 3.67022 5.44641 3.67582 7.17441 3.66702C7.79921 3.66382 8.27521 3.90222 8.62961 4.41902C9.03921 5.01582 9.47361 5.59582 9.88721 6.19022C9.98721 6.33422 10.092 6.39262 10.272 6.39182C12.9736 6.38542 15.6752 6.38862 18.3768 6.38622C18.9816 6.38622 19.4728 6.59742 19.764 7.14702C19.856 7.32062 19.9128 7.53182 19.92 7.72782C19.9408 8.31582 19.9288 8.90462 19.9288 9.49342C19.9288 9.52942 19.9192 9.56542 19.9112 9.62302C19.8 9.62302 19.696 9.62302 19.592 9.62302C14.936 9.62302 10.28 9.62462 5.62401 9.62142C4.91121 9.62142 4.30321 9.83262 3.86801 10.423C3.76641 10.5614 3.68801 10.719 3.61361 10.875C2.59281 13.0094 1.57441 15.1446 0.555209 17.2798C0.540009 17.3118 0.524009 17.343 0.508809 17.375C0.494409 17.4046 0.483209 17.439 0.464009 17.467C0.452009 17.4846 0.425609 17.499 0.408809 17.4774V17.4766Z" fill="white"/>
							</svg>

						</div>
						<div class="col-8 mt-2">
							<a style="text-decoration: none;" href="{{route($sku_files_images_image_route , [ $sku_id_is ] )}}">
								<p class="brand-text" id="lot_number{{$row['id'].$key}}">{{$row['sku_code']}}</p>
							</a>
						</div>
						<div class="col-2 mt-3">
							<i class="bi bi-three-dots-vertical test myButton" style="font-size:20px;color: #808080;" role="button"></i>
								<div class="myPopover" style="display: none;">
									
									@if ($row['adaptation'] != '' && $row['adaptation'] != null)
										<a href="{{route($download_route_is , [ 'wrc_id' => base64_encode($wrc_id) , 'adaptation' => $adaptation , 'sku_id' => base64_encode($row['sku_code']) ] )}}">
										<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
											&nbsp;&nbsp;
											Download
										</a>
									@endif
									
									{{-- View Details --}}
									<a href="javascript:void(0)" onclick="toggleSidebarNew('image'); set_shoot_date_time({{$row['id'].$key}}); lots_details('{{ $sku_id_is  }}' , 'sku' , '{{$adaptation}}') ">
										<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
											<g clip-path="url(#clip0_1043_2491)">
												<path d="M9.99992 13.334L9.99992 9.16732M9.99992 1.66732C5.41658 1.66732 1.66658 5.41732 1.66658 10.0007C1.66659 14.584 5.41659 18.334 9.99992 18.334C14.5833 18.334 18.3333 14.584 18.3333 10.0007C18.3333 5.41732 14.5833 1.66732 9.99992 1.66732Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M10.0042 6.66602L9.99665 6.66602" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											</g>
											<defs>
												<clipPath id="clip0_1043_2491">
												<rect width="20" height="20" fill="white"/>
												</clipPath>
											</defs>
										</svg>
										&nbsp;&nbsp;
										View Details
									</a>

									<div class="d-none">
										<span id="lot_date{{$row['id'].$key}}">{{dateFormet_dmy($row['created_at'])}}</span>
										<span id="lot_time{{$row['id'].$key}}">{{date('h:i A', strtotime($row['created_at']))}}</span>
										<span id="image_src{{$row['id'].$key}}">{{asset($shoot_image_src)}}</span>
									</div>


									{{-- Share --}}
									@if ($row['adaptation'] != '' && $row['adaptation'] != null)

										<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key.$row['wrc_id']}}' , 'Shoot Lot WRC Sku Image' , 'Shoot WRC')" >
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
											&nbsp;&nbsp;
											Share
										</a>
										<p class="d-none" id="url_{{$key.$row['wrc_id']}}">{{route($download_route_is , [ 'wrc_id' => base64_encode($wrc_id) , 'adaptation' => $adaptation , 'sku_id' => base64_encode($row['sku_code']) ] )}}</p>
									@endif
									
								</div>
						</div>
					</div>
				</div>
					
			@endforeach
		@endif
	</div>

	<!-- WRCs Section -->
	<div class="row">
		{{-- Shoot Wrcs --}}
			@if (count($searchData_shoot_wrc)  > 0)
				{{-- shoot wrc --}}
				<div class="col-sm-12 col-md-12 col-lg-12">
					<p class="fovourites-img-lot-sku-wrc-section">Shoot Wrcs</p>
				</div>
				@foreach ($searchData_shoot_wrc as $wrc_key => $row)
					<?php 
						// dd($row);
						// $row = $row['wrc_data'];
						$service_is = isset($row['service']) ? $row['service'] : 'SHOOT';
						$file_path = isset($row['file_path']) ? $row['file_path'] : '';
						$tbl_id = $row['wrc_id'];
						$shoot_image_src = 'IMG/no_preview_available.jpg';
						if($file_path != ''){
							$shoot_image_src = $file_path;
						}
						if($service_is == 'SHOOT'){
							$route_is = 'your_assets_shoot_skus';
							$download_route_is = 'download_Shoot_lot_Edited_wrc';
						}else{
							$route_is = 'your_assets_files_editing_uploaded_images';
							$download_route_is = 'download_Editing_lot_Edited_wrc';
						}
						$wrc_unic_key = $row['wrc_id'].$row['id'].$wrc_key;
					?>

					{{-- new code --}}
					<div class="col-lg-3 col-md-6 wrc-file-div">
						<div class="adap-div" style="position: relative;">
							{{-- wrc top section --}}
							<div class="under-adap-div">
								{{-- id="lot_number{{$row['wrc_id'].$wrc_unic_key}}" --}}
								<a href="{{route($route_is , [ base64_encode($row['wrc_id'])])}}" role="button">
									<span class="adap-wrc">
										<span>
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path
													d="M19.6447 10.3167C19.6173 10.4447 19.5653 10.5687 19.514 10.688C19.4127 10.9227 19.308 11.156 19.1947 11.3847C18.3473 13.0953 17.4873 14.8 16.642 16.512C16.312 17.1807 15.7933 17.496 15.0473 17.4953C10.588 17.4893 6.12868 17.4913 1.66935 17.4933C1.18735 17.4933 0.691345 17.2867 0.466679 16.836C0.342679 16.5873 0.468679 16.3687 0.577345 16.142C0.664012 15.9607 0.750679 15.78 0.838012 15.5987C1.01135 15.2367 1.18468 14.8747 1.35801 14.512C1.53135 14.15 1.70468 13.7873 1.87735 13.4253C2.05068 13.0627 2.22335 12.7007 2.39601 12.338C2.56868 11.9753 2.74135 11.6127 2.91401 11.25C3.08668 10.8873 3.25868 10.5247 3.43135 10.162C3.52201 9.97135 3.61201 9.78135 3.70268 9.59068C4.02868 8.90401 4.56334 8.56268 5.31601 8.56201C9.53668 8.56001 13.7567 8.55868 17.9773 8.56335C18.3827 8.56335 18.7927 8.66268 19.1033 8.93468C19.3387 9.14068 19.5187 9.41668 19.6087 9.71668C19.654 9.86801 19.6753 10.0267 19.6647 10.1847C19.662 10.2293 19.6553 10.2733 19.6453 10.3167H19.6447Z"
													fill="white" />
												<path
													d="M0.340654 14.0133C0.333321 14.0033 0.332654 13.9886 0.333988 13.9766C0.338654 13.9266 0.337988 13.8766 0.337988 13.8266C0.337988 10.4939 0.337988 7.16061 0.337988 3.82794C0.337988 2.98194 0.811321 2.50861 1.65865 2.50794C3.09865 2.50794 4.53865 2.51261 5.97865 2.50528C6.49932 2.50261 6.89599 2.70128 7.19132 3.13194C7.53265 3.62928 7.89465 4.11261 8.23932 4.60794C8.32265 4.72794 8.40999 4.77661 8.55999 4.77594C10.8113 4.77061 13.0627 4.77328 15.314 4.77128C15.818 4.77128 16.2273 4.94728 16.47 5.40528C16.5467 5.54994 16.594 5.72594 16.6 5.88928C16.6173 6.37928 16.6073 6.86994 16.6073 7.36061C16.6073 7.39061 16.5993 7.42061 16.5927 7.46861C16.5 7.46861 16.4133 7.46861 16.3267 7.46861C12.4467 7.46861 8.56665 7.46994 4.68665 7.46728C4.09265 7.46728 3.58599 7.64328 3.22332 8.13528C3.13865 8.25061 3.07332 8.38194 3.01132 8.51194C2.16065 10.2906 1.31199 12.0699 0.462654 13.8493C0.449988 13.8759 0.436654 13.9019 0.423988 13.9286C0.411988 13.9533 0.402654 13.9819 0.386654 14.0053C0.376654 14.0199 0.354654 14.0319 0.340654 14.0139V14.0133Z"
													fill="white" />
											</svg>
										</span>
										&nbsp;
										<span class="WRC-no-file" id="lot_number{{$row['wrc_id'].$wrc_unic_key}}">{{$row['wrc_number']}}</span>
									</span>
								</a>
								<span class="adap-wrc-dots">
									<a href="javascript:void(0)" class=" test myButton" role="button"> <i class="bi bi-three-dots-vertical"
										style="font-size:20px;color: #808080;"></i></a>
								</span>
							</div>
							{{-- myPopover Start --}}
							<div class="myPopover" style="z-index: 9; display: none;">
								@php
									$wrc_id_is = base64_encode($row['wrc_id']);
								@endphp
								<a href="{{route($download_route_is , [ base64_encode($row['wrc_id']) ] )}}">
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>&nbsp;
									Download
								</a>
								
								@if ($service_is == 'Shoot')
									<a href="javascript:void(0)" onclick="toggleSidebar(); set_date_time({{$row['wrc_id'].$wrc_unic_key}}); lots_details('{{ $wrc_id_is  }}' , 'wrc' , 'Edited') ">
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
								@else
									<a href="javascript:void(0)" onclick="toggleSidebar(); set_date_time({{$row['wrc_id'].$wrc_unic_key}}); editing_lots_details('{{ $wrc_id_is  }}' , 'wrc' , 'Edited') ">
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
								@endif
			
								<div class="d-none">
									<span id="lot_date{{$row['wrc_id'].$wrc_unic_key}}">{{dateFormet_dmy($row['wrc_created_at'])}}</span>
									<span id="lot_time{{$row['wrc_id'].$wrc_unic_key}}">{{date('h:i A', strtotime($row['wrc_created_at']))}}</span>
									<span id="image_src{{$row['wrc_id'].$wrc_unic_key}}">{{asset($shoot_image_src)}}</span>
								</div>
			
								<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$wrc_unic_key}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>&nbsp;
									Share
								</a>
			
								<p class="d-none" id="url_{{$wrc_unic_key}}">{{route($download_route_is , [ base64_encode($row['wrc_id']) ] )}}</p>
							</div>
							{{-- myPopover End --}}
						</div>
						<div class="adap-div-forAdaption">
							<div class="adap-div-forAdaption-content">
								<p class="Adaptations-text-wrclevel">Adaptations</p>
	
								<div class="AdaptLogo-section icon-container my-carousel owl-carousel">
									@foreach ($row['adaptation_svg_data_arr'] as $adaptation_key =>  $adaptation_svg)
										<span class="item" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{$adaptation_key}}">
											<?php echo $adaptation_svg;?>
										</span>
									@endforeach
	
								</div>
							</div>
						</div>
						
					</div>

					
				@endforeach
			@endif

		{{-- Post-production WRCs --}}
			@if (count($searchData_editing_wrc) > 0)
				{{-- Post-production wrc --}}
				<div class="col-sm-12 col-md-12 col-lg-12">
					<p class="fovourites-img-lot-sku-wrc-section">Post-production Wrcs</p>
				</div>
				@foreach ($searchData_editing_wrc as $wrc_key => $row)
					<?php 
						// dd($row);
						// $row = $row['wrc_data'];
						$service_is = isset($row['service']) ? $row['service'] : 'EDITING';
						$file_path = isset($row['file_path']) ? $row['file_path'] : '';
						$tbl_id = $row['wrc_id'];
						$image_src = 'IMG/no_preview_available.jpg';
						if($file_path != ''){
							$image_src = $file_path;
						}
						
						$route_is = 'your_assets_files_editing_uploaded_images';
						$download_route_is = 'download_Editing_lot_Edited_wrc';
						$wrc_unic_key = $row['wrc_id'].$row['CommercialPerImage'].$wrc_key;
					?>

					<div class="col-lg-3 col-md-6" style="margin-bottom: 24px;" id="div_{{$tbl_id}}">
						<div class="accordion" id="accordionExample{{$wrc_unic_key}}">
							<div class="card z-depth-0 bordered">
								<div class="card-header card-header-style" id="headingOne{{$wrc_unic_key}}"background: #D1D1D1;>
									<div class="mb-0 row">
										<div class="col-2 mt-2" style="padding-left: 23px;">
											<svg width="24" height="24" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M23.5736 12.3803C23.5408 12.5339 23.4784 12.6827 23.4168 12.8259C23.2952 13.1075 23.1696 13.3875 23.0336 13.6619C22.0168 15.7147 20.9848 17.7603 19.9704 19.8147C19.5744 20.6171 18.952 20.9955 18.0568 20.9947C12.7056 20.9875 7.35441 20.9899 2.00321 20.9923C1.42481 20.9923 0.829615 20.7443 0.560015 20.2035C0.411215 19.9051 0.562415 19.6427 0.692815 19.3707C0.796815 19.1531 0.900815 18.9363 1.00561 18.7187C1.21361 18.2843 1.42161 17.8499 1.62961 17.4147C1.83761 16.9803 2.04561 16.5451 2.25281 16.1107C2.46081 15.6755 2.66801 15.2411 2.87521 14.8059C3.08241 14.3707 3.28961 13.9355 3.49681 13.5003C3.70401 13.0651 3.91041 12.6299 4.11761 12.1947C4.22641 11.9659 4.33441 11.7379 4.44321 11.5091C4.83441 10.6851 5.47601 10.2755 6.37921 10.2747C11.444 10.2723 16.508 10.2707 21.5728 10.2763C22.0592 10.2763 22.5512 10.3955 22.924 10.7219C23.2064 10.9691 23.4224 11.3003 23.5304 11.6603C23.5848 11.8419 23.6104 12.0323 23.5976 12.2219C23.5944 12.2755 23.5864 12.3283 23.5744 12.3803H23.5736Z" fill="white"/>
												<path d="M0.408809 16.8165C0.400009 16.8045 0.399209 16.7869 0.400809 16.7725C0.406409 16.7125 0.405609 16.6525 0.405609 16.5925C0.405609 12.5933 0.405609 8.59327 0.405609 4.59407C0.405609 3.57887 0.973609 3.01087 1.99041 3.01007C3.71841 3.01007 5.44641 3.01567 7.17441 3.00687C7.79921 3.00367 8.27521 3.24207 8.62961 3.75887C9.03921 4.35567 9.47361 4.93567 9.88721 5.53007C9.98721 5.67407 10.092 5.73247 10.272 5.73167C12.9736 5.72527 15.6752 5.72847 18.3768 5.72607C18.9816 5.72607 19.4728 5.93727 19.764 6.48687C19.856 6.66047 19.9128 6.87167 19.92 7.06767C19.9408 7.65567 19.9288 8.24447 19.9288 8.83327C19.9288 8.86927 19.9192 8.90527 19.9112 8.96287C19.8 8.96287 19.696 8.96287 19.592 8.96287C14.936 8.96287 10.28 8.96447 5.62401 8.96127C4.91121 8.96127 4.30321 9.17247 3.86801 9.76287C3.76641 9.90127 3.68801 10.0589 3.61361 10.2149C2.59281 12.3493 1.57441 14.4845 0.555209 16.6197C0.540009 16.6517 0.524009 16.6829 0.508809 16.7149C0.494409 16.7445 0.483209 16.7789 0.464009 16.8069C0.452009 16.8245 0.425609 16.8389 0.408809 16.8173V16.8165Z" fill="white"/>
											</svg>&nbsp;&nbsp;
										</div>

										<div class="col-8 mt-2" >
											<a  class="file-wrc-lot-no" id="lot_number{{$row['wrc_id'].$wrc_unic_key}}" href="{{route($route_is , [ base64_encode($row['wrc_id'])])}}" class="btn " type="button" data-toggle="collapse" data-target="#collapseOne{{$wrc_unic_key}}"	aria-expanded="true" aria-controls="collapseOne{{$wrc_unic_key}}">
												{{$row['wrc_number']}}
											</a>       
													
										</div>
										<div class="col-2">
											<span class="test btn myButton" role="button" style="float: right"> <i class="bi bi-three-dots-vertical" style="font-size:20px;color: #808080;"></i></span>
										</div>
										
										<div class="myPopover" style="left: 25%; top: 60%;display: none;">
											@php
												$wrc_id_is = base64_encode($row['wrc_id']);
											@endphp
											{{-- Download --}}
											<a href="{{route($download_route_is , [ base64_encode($row['wrc_id']) ] )}}">
												<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>&nbsp;
												Download
											</a>
											
											{{-- View Details --}}
											@if ($service_is == 'SHOOT')
												<a href="javascript:void(0)" onclick="toggleSidebarNew('image'); set_date_time({{$row['wrc_id'].$wrc_unic_key}}); lots_details('{{ $wrc_id_is  }}' , 'wrc' , 'Edited') ">
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
											@else
												<a href="javascript:void(0)" onclick="toggleSidebarNew('image'); set_date_time({{$row['wrc_id'].$wrc_unic_key}}); editing_lots_details('{{ $wrc_id_is  }}' , 'wrc' , 'Edited') ">
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
											@endif

											<div class="d-none">
												<span id="lot_date{{$row['wrc_id'].$wrc_unic_key}}">{{dateFormet_dmy($row['wrc_created_at'])}}</span>
												<span id="lot_time{{$row['wrc_id'].$wrc_unic_key}}">{{date('h:i A', strtotime($row['wrc_created_at']))}}</span>
												<span id="image_src{{$row['wrc_id'].$wrc_unic_key}}">{{asset($image_src)}}</span>
											</div>
											{{-- Share --}}
											<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$wrc_unic_key}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >
												<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>&nbsp;
												Share
											</a>
											<p class="d-none" id="url_{{$wrc_unic_key}}">{{route($download_route_is , [ base64_encode($row['wrc_id']) ] )}}</p>
										</div>
									</div>
								</div>
								
								<div id="collapseOne{{$wrc_unic_key}}" class="collapse d-none show" aria-labelledby="headingOne{{$wrc_unic_key}}" data-parent="#">
									<div class="card-body card-body-style">
										<div class="col-12">
											<p class="TAGS">TAGS
												<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
													<g clip-path="url(#clip0_92_3135)">
														<path
															d="M7.00004 9.33301L7.00004 6.41634M7.00004 1.16634C3.79171 1.16634 1.16671 3.79134 1.16671 6.99968C1.16671 10.208 3.79171 12.833 7.00004 12.833C10.2084 12.833 12.8334 10.208 12.8334 6.99967C12.8334 3.79134 10.2084 1.16634 7.00004 1.16634Z"
															stroke="#9F9F9F" stroke-linecap="round" stroke-linejoin="round" />
														<path d="M7.00293 4.66699L6.99493 4.66699" stroke="#9F9F9F" stroke-linecap="round"
															stroke-linejoin="round" />
													</g>
													<defs>
														<clipPath id="clip0_92_3135">
															<rect width="14" height="14" fill="white" transform="translate(14 14) rotate(180)" />
														</clipPath>
													</defs>
												</svg>
											</p>
										</div>
										<div class="row">
											<div class="col-4">
												<button type="button" class="btn btn-sm under-acco-button">Black Tees</button>
											</div>
											<div class="col-4">
												<button type="button" class="btn btn-sm under-acco-button">FSN code</button>
											</div>
											<div class="col-4">
												<button type="button" class="btn btn-sm under-acco-button">ASIN code</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			@endif
			
		{{-- Marketing creative WRCs --}}
			@if (count($searchData_creative_wrc)  > 0)
				<div class="col-sm-12 col-md-12 col-lg-12">
					<p class="fovourites-img-lot-sku-wrc-section">Marketing creative Wrcs</p>
				</div>
				@foreach ($searchData_creative_wrc as $wrc_key => $row)
					<?php 

						$wrc_id = $row['wrc_id'];
						if($wrc_id == '' || $wrc_id == null){
							continue;
						}
						// dd($row);
						$service_is = isset($row['service']) ? $row['service'] : 'CEATIVE';
						$file_path = isset($row['file_path']) ? $row['file_path'] : '';
						$tbl_id = $row['wrc_id'];
						$image_src = 'IMG/no_preview_available.jpg';
						if($file_path != ''){
							$image_src = $file_path;
						}
						$wrc_id_is = base64_encode($row['wrc_id']);
						$route_is = 'your_assets_creative_wrcs_links';
						$wrc_unic_key = $row['wrc_id'].$row['per_qty_value'].$wrc_key;
						
					?>

					<div class="col-lg-3 col-md-6" style="margin-bottom: 24px;" id="div_{{$tbl_id}}">
						<div class="accordion" id="accordionExample{{$wrc_unic_key}}">
							<div class="card z-depth-0 bordered">
								<div class="card-header card-header-style" id="headingOne{{$wrc_unic_key}}"background: #D1D1D1;>
									<div class="mb-0 row">
										<div class="col-2 mt-2" style="padding-left: 23px;">
											<svg width="24" height="24" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M23.5736 12.3803C23.5408 12.5339 23.4784 12.6827 23.4168 12.8259C23.2952 13.1075 23.1696 13.3875 23.0336 13.6619C22.0168 15.7147 20.9848 17.7603 19.9704 19.8147C19.5744 20.6171 18.952 20.9955 18.0568 20.9947C12.7056 20.9875 7.35441 20.9899 2.00321 20.9923C1.42481 20.9923 0.829615 20.7443 0.560015 20.2035C0.411215 19.9051 0.562415 19.6427 0.692815 19.3707C0.796815 19.1531 0.900815 18.9363 1.00561 18.7187C1.21361 18.2843 1.42161 17.8499 1.62961 17.4147C1.83761 16.9803 2.04561 16.5451 2.25281 16.1107C2.46081 15.6755 2.66801 15.2411 2.87521 14.8059C3.08241 14.3707 3.28961 13.9355 3.49681 13.5003C3.70401 13.0651 3.91041 12.6299 4.11761 12.1947C4.22641 11.9659 4.33441 11.7379 4.44321 11.5091C4.83441 10.6851 5.47601 10.2755 6.37921 10.2747C11.444 10.2723 16.508 10.2707 21.5728 10.2763C22.0592 10.2763 22.5512 10.3955 22.924 10.7219C23.2064 10.9691 23.4224 11.3003 23.5304 11.6603C23.5848 11.8419 23.6104 12.0323 23.5976 12.2219C23.5944 12.2755 23.5864 12.3283 23.5744 12.3803H23.5736Z" fill="white"/>
												<path d="M0.408809 16.8165C0.400009 16.8045 0.399209 16.7869 0.400809 16.7725C0.406409 16.7125 0.405609 16.6525 0.405609 16.5925C0.405609 12.5933 0.405609 8.59327 0.405609 4.59407C0.405609 3.57887 0.973609 3.01087 1.99041 3.01007C3.71841 3.01007 5.44641 3.01567 7.17441 3.00687C7.79921 3.00367 8.27521 3.24207 8.62961 3.75887C9.03921 4.35567 9.47361 4.93567 9.88721 5.53007C9.98721 5.67407 10.092 5.73247 10.272 5.73167C12.9736 5.72527 15.6752 5.72847 18.3768 5.72607C18.9816 5.72607 19.4728 5.93727 19.764 6.48687C19.856 6.66047 19.9128 6.87167 19.92 7.06767C19.9408 7.65567 19.9288 8.24447 19.9288 8.83327C19.9288 8.86927 19.9192 8.90527 19.9112 8.96287C19.8 8.96287 19.696 8.96287 19.592 8.96287C14.936 8.96287 10.28 8.96447 5.62401 8.96127C4.91121 8.96127 4.30321 9.17247 3.86801 9.76287C3.76641 9.90127 3.68801 10.0589 3.61361 10.2149C2.59281 12.3493 1.57441 14.4845 0.555209 16.6197C0.540009 16.6517 0.524009 16.6829 0.508809 16.7149C0.494409 16.7445 0.483209 16.7789 0.464009 16.8069C0.452009 16.8245 0.425609 16.8389 0.408809 16.8173V16.8165Z" fill="white"/>
											</svg>&nbsp;&nbsp;
										</div>

										<div class="col-8 mt-2" >
											<a  class="file-wrc-lot-no" id="lot_number{{$row['wrc_id'].$wrc_unic_key}}" href="{{route($route_is , [ base64_encode($row['lot_id'])])}}" class="btn " type="button" data-toggle="collapse" data-target="#collapseOne{{$wrc_unic_key}}"	aria-expanded="true" aria-controls="collapseOne{{$wrc_unic_key}}">
												{{$row['wrc_number']}}
											</a>       
										</div>

										<div class="col-2">
											<span class="test btn myButton" role="button" style="float: right"> <i class="bi bi-three-dots-vertical" style="font-size:20px;color: #808080;"></i></span>
										</div>
										
										<div class="myPopover d-none" style="display: none;">
											{{-- View Details --}}
											<a href="javascript:void(0)" onclick="toggleSidebarNew(); set_date_time({{$row['wrc_id'].$wrc_unic_key}}); lots_details('{{ $wrc_id_is  }}' , 'wrc' , 'Edited') ">
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
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			@endif


		{{-- Listing WRCs --}}
			@if (count($searchData_catalog_wrc)  > 0)
				<div class="col-sm-12 col-md-12 col-lg-12">
					<p class="fovourites-img-lot-sku-wrc-section">Listing Wrcs</p>
				</div>
				@foreach ($searchData_catalog_wrc as $wrc_key => $row)
					<?php 

						$wrc_id = $row['wrc_id'];
						if($wrc_id == '' || $wrc_id == null){
							continue;
						}
						// dd($row);
						$service_is = isset($row['service']) ? $row['service'] : 'CEATIVE';
						$file_path = isset($row['file_path']) ? $row['file_path'] : '';
						$tbl_id = $row['wrc_id'].$row['CommercialSKU'];
						$image_src = 'IMG/no_preview_available.jpg';
						if($file_path != ''){
							$image_src = $file_path;
						}
						$wrc_id_is = base64_encode($row['wrc_id']);
						$route_is = 'your_assets_cataloging_wrcs_links';
						$wrc_unic_key = $row['wrc_id'].$row['CommercialSKU'].$row['sku_qty'].$wrc_key;
						
					?>

					<div class="col-lg-3 col-md-6" style="margin-bottom: 24px;" id="div_{{$tbl_id}}">
						<div class="accordion" id="accordionExample{{$wrc_unic_key}}">
							<div class="card z-depth-0 bordered">
								<div class="card-header card-header-style" id="headingOne{{$wrc_unic_key}}"background: #D1D1D1;>
									<div class="mb-0 row">
										<div class="col-2 mt-2" style="padding-left: 23px;">
											<svg width="24" height="24" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M23.5736 12.3803C23.5408 12.5339 23.4784 12.6827 23.4168 12.8259C23.2952 13.1075 23.1696 13.3875 23.0336 13.6619C22.0168 15.7147 20.9848 17.7603 19.9704 19.8147C19.5744 20.6171 18.952 20.9955 18.0568 20.9947C12.7056 20.9875 7.35441 20.9899 2.00321 20.9923C1.42481 20.9923 0.829615 20.7443 0.560015 20.2035C0.411215 19.9051 0.562415 19.6427 0.692815 19.3707C0.796815 19.1531 0.900815 18.9363 1.00561 18.7187C1.21361 18.2843 1.42161 17.8499 1.62961 17.4147C1.83761 16.9803 2.04561 16.5451 2.25281 16.1107C2.46081 15.6755 2.66801 15.2411 2.87521 14.8059C3.08241 14.3707 3.28961 13.9355 3.49681 13.5003C3.70401 13.0651 3.91041 12.6299 4.11761 12.1947C4.22641 11.9659 4.33441 11.7379 4.44321 11.5091C4.83441 10.6851 5.47601 10.2755 6.37921 10.2747C11.444 10.2723 16.508 10.2707 21.5728 10.2763C22.0592 10.2763 22.5512 10.3955 22.924 10.7219C23.2064 10.9691 23.4224 11.3003 23.5304 11.6603C23.5848 11.8419 23.6104 12.0323 23.5976 12.2219C23.5944 12.2755 23.5864 12.3283 23.5744 12.3803H23.5736Z" fill="white"/>
												<path d="M0.408809 16.8165C0.400009 16.8045 0.399209 16.7869 0.400809 16.7725C0.406409 16.7125 0.405609 16.6525 0.405609 16.5925C0.405609 12.5933 0.405609 8.59327 0.405609 4.59407C0.405609 3.57887 0.973609 3.01087 1.99041 3.01007C3.71841 3.01007 5.44641 3.01567 7.17441 3.00687C7.79921 3.00367 8.27521 3.24207 8.62961 3.75887C9.03921 4.35567 9.47361 4.93567 9.88721 5.53007C9.98721 5.67407 10.092 5.73247 10.272 5.73167C12.9736 5.72527 15.6752 5.72847 18.3768 5.72607C18.9816 5.72607 19.4728 5.93727 19.764 6.48687C19.856 6.66047 19.9128 6.87167 19.92 7.06767C19.9408 7.65567 19.9288 8.24447 19.9288 8.83327C19.9288 8.86927 19.9192 8.90527 19.9112 8.96287C19.8 8.96287 19.696 8.96287 19.592 8.96287C14.936 8.96287 10.28 8.96447 5.62401 8.96127C4.91121 8.96127 4.30321 9.17247 3.86801 9.76287C3.76641 9.90127 3.68801 10.0589 3.61361 10.2149C2.59281 12.3493 1.57441 14.4845 0.555209 16.6197C0.540009 16.6517 0.524009 16.6829 0.508809 16.7149C0.494409 16.7445 0.483209 16.7789 0.464009 16.8069C0.452009 16.8245 0.425609 16.8389 0.408809 16.8173V16.8165Z" fill="white"/>
											</svg>&nbsp;&nbsp;
										</div>

										<div class="col-8 mt-2" >
											<a  class="file-wrc-lot-no" id="lot_number{{$row['wrc_id'].$wrc_unic_key}}" href="{{route($route_is , [ base64_encode($row['lot_id'])])}}" class="btn " type="button" data-toggle="collapse" data-target="#collapseOne{{$wrc_unic_key}}"	aria-expanded="true" aria-controls="collapseOne{{$wrc_unic_key}}">
												{{$row['wrc_number']}}
											</a>       
										</div>

										<div class="col-2">
											<span class="test btn myButton" role="button" style="float: right"> <i class="bi bi-three-dots-vertical" style="font-size:20px;color: #808080;"></i></span>
										</div>
										
										<div class="myPopover d-none" style="display: none;">
											{{-- View Details --}}
											<a href="javascript:void(0)" onclick="toggleSidebarNew(); set_date_time({{$row['wrc_id'].$wrc_unic_key}}); lots_details('{{ $wrc_id_is  }}' , 'wrc' , 'Edited') ">
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
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			@endif


	</div>

	<!-- Lots Section -->
	<div class="row">
		{{-- Shoot Lots  --}}
			@if (count($searchData_shoot_lot)  > 0)
				<div class="col-sm-12 col-md-12 col-lg-12">
					<p class="fovourites-img-lot-sku-wrc-section">Shoot Lots</p>
				</div>
				@foreach ($searchData_shoot_lot as $lot_index => $row)
					@php
						// dd($row);
						$service = $service_is = isset($row['service']) ? $row['service'] : 'SHOOT';

						$tbl_id =  $row['id'];
						$route_is = 'your_assets_shoot_wrcs';
						$download_route_is = "download_Shoot_Lot_edited";
						$submission_date = $row['submission_date'] != '' ? dateFormet_dmy($row['submission_date']) : '';

						
						$file_path = $row['file_path'];
						$shoot_image_src = 'IMG/group_10.png';
						$shoot_image_src1 = 'IMG/no_preview_available.jpg';
						if($file_path != ''){
							$shoot_image_src = $file_path;
							$shoot_image_src1 = $file_path;
						}
					@endphp
					<div class="col-lg-4 col-md-6 box border-0" style="background: #0F0F0F; position: relative;" id="div_{{$tbl_id}}">
						<div class="row">
							<div class="under-content-div">
								<div class="col-12">
									<a href="{{route('your_assets_shoot_wrcs' , [$row['lot_id']])}}">
										<img src="{{ asset($shoot_image_src1)}}" alt="" class="img-fluid yourasse-file-img">
									</a>
								</div>
								<div class="col-12 d-flex justify-content-between">
									<div>
										<p class="lot-no-heading">Lot no</p>
										<p class="your-asset-lotno-underbox" id="lot_number{{$row['lot_id'].$lot_index}}">{{$row['lot_number']}}</p>
										<p class="file-lot-date-para">
											<span class="your-asset-lot-date-underbox">
													<svg width="14" height="20" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
																									<path d="M4.66667 1.16675V2.91675M9.33333 1.16675V2.91675M2.04167 5.30258H11.9583M12.25 4.95841V9.91675C12.25 11.6667 11.375 12.8334 9.33333 12.8334H4.66667C2.625 12.8334 1.75 11.6667 1.75 9.91675V4.95841C1.75 3.20841 2.625 2.04175 4.66667 2.04175H9.33333C11.375 2.04175 12.25 3.20841 12.25 4.95841Z" stroke="#808080" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
																									<path d="M9.15545 7.9917H9.1607M9.15545 9.7417H9.1607M6.99711 7.9917H7.00295M6.99711 9.7417H7.00295M4.8382 7.9917H4.84403M4.8382 9.7417H4.84403" stroke="#808080" stroke-linecap="round" stroke-linejoin="round"/>
																									</svg>
											</span>
											<span class="your-asset-lot-date">{{dateFormet_dmy($row['lot_created_at'])}}</span>
											</p>
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
											<a href="javascript:void(0)" onclick="toggleSidebarNew('image' , 'wrc'); set_shoot_date_time({{$row['lot_id'].$lot_index}}, 'shoot');lots_details('{{ $lot_id_is  }}' , 'lot' , 'Edited') ">
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
								<div class="col-12 d-flex justify-content-between">
									<div>
										<p class="inward-qty">Inward Quantity : </p>
										<p class="inward-qty-num">
											{{$row['inward_quantity'] > 0 ? $row['inward_quantity'] : '0'}}
										</p>
									</div>
									<div>
										<p class="inward-qty">Submission</p>
										<p class="inward-qty-num">{{$submission_date}}</p>
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
			@endif

		{{-- Post-production Lots  --}}
			@if (count($searchData_editing_lot) > 0)
				<div class="col-sm-12 col-md-12 col-lg-12">
					<p class="fovourites-img-lot-sku-wrc-section">Post-production Lots</p>
				</div>
				@foreach ($searchData_editing_lot as $key_index => $row)
					@php
						// dd($row);
						$service = $service_is = isset($row['service']) ? $row['service'] : 'EDITING';
						$lot_index = $key_index.$row['company_c_short'];
						$file_path = isset($row['file_path']) ? $row['file_path'] : '';
						$wrc_numbers = isset($row['wrc_numbers']) ? $row['wrc_numbers'] : '';
						$tbl_id =  $row['lot_id'].$row['brand_short_name'];
						$route_is = 'your_assets_editing_wrcs';
						$download_route_is = "download_Editing_Lot_edited";
						$shoot_image_src = 'IMG/group_10.png';
						$shoot_image_src1 = 'IMG/no_preview_available.jpg';
						if($file_path != ''){
							$shoot_image_src = $file_path;
							$shoot_image_src1 = $file_path;
						}
						$submission_date = $row['submission_date'] != '' ? dateFormet_dmy($row['submission_date']) : '';

					@endphp
					<div class="col-lg-4 col-md-6 box border-0" style="background: #0F0F0F; position: relative;" id="div_{{$tbl_id}}">
						<div class="row">
							<div class="under-content-div">
								<div class="col-12">
									<a href="{{route('your_assets_shoot_wrcs' , [$row['lot_id']])}}">
										<img src="{{ asset($shoot_image_src1)}}" alt="" class="img-fluid yourasse-file-img">
									</a>
								</div>
								<div class="col-12 d-flex justify-content-between">
									<div>
										<p class="lot-no-heading">Lot no</p>
										<p class="your-asset-lotno-underbox" id="lot_number{{$row['lot_id'].$lot_index}}">{{$row['lot_number']}}</p>
										<p class="file-lot-date-para">
											<span class="your-asset-lot-date-underbox">Date:</span> &nbsp;<span class="your-asset-lot-date"> {{dateFormet_dmy($row['lot_created_at'])}} </span>
										</p>
										<div class="myPopover" style="display: none;">
											@php
												$lot_id_is = base64_encode($row['lot_id']);
											@endphp
											{{-- Download --}}
											<a href="{{route($download_route_is , [ 'id' =>  $lot_id_is ] )}}">
												<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>&nbsp;
												Download
											</a>

											{{-- View Details --}}
											<a href="javascript:void(0)" onclick="toggleSidebarNew('image', 'wrc');set_editing_date_time('{{$row['lot_id'].$lot_index}}' , 'Editing');editing_lots_details('{{$lot_id_is}}','lot','Edited')">
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
												<span id="wrc_numbers{{$row['lot_id'].$lot_index}}">{{ $wrc_numbers }}</span>

											</div>
											{{-- Share --}}
											<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$lot_index}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >
												<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>&nbsp;
												Share
											</a>
											<p class="d-none" id="url_{{$lot_index}}">{{route($download_route_is , [ 'id' =>  $lot_id_is ] )}}</p>
										</div>
									</div>

									<div type="button" class="btn border-0 rounded-circle myButton">
										<i class="bi bi-three-dots-vertical" style="color: #9F9F9F;line-height: 2.5;">
										</i>
									</div>
								</div>
								
								<div class="col-12 d-flex justify-content-between">
									<div>
										<p class="inward-qty">Inward Quantity : </p>
										<p class="inward-qty-num">
											{{$row['inward_quantity'] > 0 ? $row['inward_quantity'] : '0'}}
										</p>
									</div>
									<div>
										<p class="inward-qty">Submission</p>
										<p class="inward-qty-num">{{$submission_date}}</p>
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
			@endif

		{{-- Marketing creative Lots --}}
			@if (count($searchData_creative_lot)  > 0)
				<div class="col-sm-12 col-md-12 col-lg-12">
					<p class="fovourites-img-lot-sku-wrc-section">Marketing Creative Lots</p>
				</div>
				@foreach ($searchData_creative_lot as $key => $row)
					@php
						// dd($row);
						$lot_created_at = $row['lot_created_at'];
						$submission_date = $row['submission_date'] != '' ? dateFormet_dmy($row['submission_date']) : '';
						$wrc_numbers = ($row['wrc_numbers'] != '' && $row['wrc_numbers'] != null) ? $row['wrc_numbers'] : 'Wrc not generated.'; 
						$lot_id_is = base64_encode($row['id']);
						$lot_index = $tbl_id = $row['lot_id'].$key.$row['id'];
					@endphp

					<div class="col-lg-4 col-md-6 box border-0" style="background: #0F0F0F; position: relative;" id="div_{{$tbl_id}}">
						<div class="row">
							<div class="under-content-div">
								<div class="col-12 d-flex justify-content-between" style="position: relative">
									<div>
										<p class="lot-no-heading">Lot no</p>
										<span class="your-asset-lotno-underbox" id="lot_number{{$row['lot_id'].$lot_index}}">{{$row['lot_number']}}</span>&nbsp;&nbsp;
									</div>

									<div type="button" class="btn border-0 rounded-circle myButton">
										<i class="bi bi-three-dots-vertical" style="color: #9F9F9F;line-height: 2.5;">
										</i>
									</div>
									{{-- 3DOT  myPopover--}}
									<div class="creativemyPopover myPopover" style=" top: 80%; left:25%;display: none;">
										<a href="javascript:void(0)" onclick="toggleSidebarNew('creative' , 'wrc'); set_links_date_time('{{$row['id'].$lot_index}}') ">
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
											<span id="lot_date{{$row['id'].$lot_index}}">{{dateFormet_dmy($row['lot_created_at'])}}</span>
											<span id="lot_time{{$row['id'].$lot_index}}">{{date('h:i A', strtotime($row['lot_created_at']))}}</span>
											<span id="wrc_numbers{{$row['id'].$lot_index}}">{{ $wrc_numbers }}</span>
										</div>
										
										
										 <a href="javascript:void(0)">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M3.47507 12.7498L7.25007 16.5248C7.99675 17.2693 9.00816 17.6873 10.0626 17.6873C11.117 17.6873 12.1284 17.2693 12.8751 16.5248L16.5334 12.8664C17.2779 12.1198 17.696 11.1084 17.696 10.0539C17.696 8.99952 17.2779 7.98812 16.5334 7.24144L12.7501 3.47477C12.3589 3.08252 11.8898 2.77675 11.373 2.57722C10.8562 2.37769 10.3033 2.28884 9.75007 2.31644L5.58341 2.51644C3.91674 2.59144 2.59174 3.91644 2.50841 5.57477L2.30841 9.74144C2.25841 10.8664 2.68341 11.9581 3.47507 12.7498Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M7.91659 9.99967C8.46912 9.99967 8.99902 9.78018 9.38972 9.38948C9.78043 8.99878 9.99992 8.46888 9.99992 7.91634C9.99992 7.36381 9.78043 6.8339 9.38972 6.4432C8.99902 6.0525 8.46912 5.83301 7.91659 5.83301C7.36405 5.83301 6.83415 6.0525 6.44345 6.4432C6.05275 6.8339 5.83325 7.36381 5.83325 7.91634C5.83325 8.46888 6.05275 8.99878 6.44345 9.38948C6.83415 9.78018 7.36405 9.99967 7.91659 9.99967Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
											</svg> &nbsp;
											Add Tag
										</a>
									</div>
								</div>

								<div class="col-12">
										<span class="your-asset-lot-date-underbox">Date :</span> <span class="your-asset-lot-date">{{dateFormet_dmy($row['lot_created_at'])}} </span>
								</div>
								<div class="col-12 d-flex justify-content-between">
									<div>
										<p class="inward-qty">Inward Quantity : </p>
										<p class="inward-qty-num">
											{{$row['inward_quantity'] > 0 ? $row['inward_quantity'] : '0'}}
										</p>
									</div>
									<div>
										<p class="inward-qty">Submission</p>
										<p class="inward-qty-num">{{$submission_date}}</p>
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
			@endif

		{{-- Listing Lots --}}
			@if (count($searchData_catalog_lot)  > 0)
				<div class="col-sm-12 col-md-12 col-lg-12">
					<p class="fovourites-img-lot-sku-wrc-section">Listing Lots</p>
				</div>
				@foreach ($searchData_catalog_lot as $key => $row)
					@php
						// dd('gloableSearchNew' ,$row);
						$lot_created_at = $row['lot_created_at'];
						$submission_date = $row['submission_date'] != '' ? dateFormet_dmy($row['submission_date']) : '';
						$wrc_numbers = ($row['wrc_numbers'] != '' && $row['wrc_numbers'] != null) ? $row['wrc_numbers'] : 'Wrc not generated.'; 
						$lot_id_is = base64_encode($row['id']);
						$lot_index = $tbl_id = $row['lot_id'].$row['id'].$key;
					@endphp

					<div class="col-lg-4 col-md-6 box border-0" style="background: #0F0F0F; position: relative;" id="div_{{$tbl_id}}">
						<div class="row">
							<div class="under-content-div">
								<div class="col-12 d-flex justify-content-between" style="position: relative">
									<div>
										<p class="lot-no-heading">Lot no</p>
										<span class="your-asset-lotno-underbox" id="lot_number{{$row['lot_id'].$lot_index}}">{{$row['lot_number']}}</span>&nbsp;&nbsp;
									</div>

									<div type="button" class="btn border-0 rounded-circle myButton">
										<i class="bi bi-three-dots-vertical" style="color: #9F9F9F;line-height: 2.5;">
										</i>
									</div>
									{{--  myPopover--}}
									<div class="catalogmyPopover myPopover" style=" top: 80%; left:25%;display: none;">
										<a href="javascript:void(0)" onclick="toggleSidebarNew('Listing' , 'wrc'); set_links_date_time('{{$row['lot_id'].$lot_index}}') ">
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
											<span id="wrc_numbers{{$row['lot_id'].$lot_index}}">{{ $wrc_numbers }}</span>
										</div>
										
										
										 <a href="javascript:void(0)">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M3.47507 12.7498L7.25007 16.5248C7.99675 17.2693 9.00816 17.6873 10.0626 17.6873C11.117 17.6873 12.1284 17.2693 12.8751 16.5248L16.5334 12.8664C17.2779 12.1198 17.696 11.1084 17.696 10.0539C17.696 8.99952 17.2779 7.98812 16.5334 7.24144L12.7501 3.47477C12.3589 3.08252 11.8898 2.77675 11.373 2.57722C10.8562 2.37769 10.3033 2.28884 9.75007 2.31644L5.58341 2.51644C3.91674 2.59144 2.59174 3.91644 2.50841 5.57477L2.30841 9.74144C2.25841 10.8664 2.68341 11.9581 3.47507 12.7498Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M7.91659 9.99967C8.46912 9.99967 8.99902 9.78018 9.38972 9.38948C9.78043 8.99878 9.99992 8.46888 9.99992 7.91634C9.99992 7.36381 9.78043 6.8339 9.38972 6.4432C8.99902 6.0525 8.46912 5.83301 7.91659 5.83301C7.36405 5.83301 6.83415 6.0525 6.44345 6.4432C6.05275 6.8339 5.83325 7.36381 5.83325 7.91634C5.83325 8.46888 6.05275 8.99878 6.44345 9.38948C6.83415 9.78018 7.36405 9.99967 7.91659 9.99967Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
											</svg> &nbsp;
											Add Tag
										</a>
									</div>
								</div>

								<div class="col-12">
										<span class="your-asset-lot-date-underbox">Date :</span> <span class="your-asset-lot-date">{{dateFormet_dmy($row['lot_created_at'])}} </span>
								</div>
								<div class="col-12 d-flex justify-content-between">
									<div>
										<p class="inward-qty">Inward Quantity : </p>
										<p class="inward-qty-num">
											{{$row['inward_quantity'] > 0 ? $row['inward_quantity'] : '0'}}
										</p>
									</div>
									<div>
										<p class="inward-qty">Submission</p>
										<p class="inward-qty-num">{{$submission_date}}</p>
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
			@endif
	</div>

	<!-- sidebar popup start -->
	<div class="sidebar">
		<div class="row sidebar-row-where-content">
			<div class="col-12 d-flex justify-content-between">
				<div class="row">
					 <div class="col-11">
							<p class="side-lot" id="lot_number">ODN27122022-GBSTES3744</p>
					 </div>
					 <div class="col-1">
							<button onclick="toggleSidebarNew()" type="button" class="btn border-0 close-button">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M14.19 0H5.81C2.17 0 0 2.17 0 5.81V14.18C0 17.83 2.17 20 5.81 20H14.18C17.82 20 19.99 17.83 19.99 14.19V5.81C20 2.17 17.83 0 14.19 0ZM13.36 12.3C13.65 12.59 13.65 13.07 13.36 13.36C13.21 13.51 13.02 13.58 12.83 13.58C12.64 13.58 12.45 13.51 12.3 13.36L10 11.06L7.7 13.36C7.55 13.51 7.36 13.58 7.17 13.58C6.98 13.58 6.79 13.51 6.64 13.36C6.50052 13.2189 6.4223 13.0284 6.4223 12.83C6.4223 12.6316 6.50052 12.4411 6.64 12.3L8.94 10L6.64 7.7C6.50052 7.55886 6.4223 7.36843 6.4223 7.17C6.4223 6.97157 6.50052 6.78114 6.64 6.64C6.93 6.35 7.41 6.35 7.7 6.64L10 8.94L12.3 6.64C12.59 6.35 13.07 6.35 13.36 6.64C13.65 6.93 13.65 7.41 13.36 7.7L11.06 10L13.36 12.3Z" fill="white"></path>
								</svg>
							</button>
					 </div>
				</div>
			</div>

			<div class="col-12 wrc-detail-img ">
				<div class="row">
					<div class="col-12 ps-4 pe-4" style="margin-top: 16px;">
						<img id="image_src" src="{{asset('IMG/no_preview_available.jpg')}}" alt="" class="img-fluid" style="background: rgba(255, 255, 255, 0.1);">
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
					<div class="col-12 ps-4 file_size_row d-none">
						<p class="side-text">SIZE</p>
						<P class="side-text2" id="file_size"></P>
					</div>

					<div class="col-11 ps-4 wrc_row d-none">
						<p class="side-text">WRC</p>
						<P  id="wrc_numbers" class="side-text2"></P>
					</div>
					{{-- Shoot files other data --}}
					<div id="shoot_files_details" class="p-0 d-none">
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

@section('js_links')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
@endsection

@section('js_scripts')
	{{-- owlCarousel --}}
		<script>
			$(document).ready(function () {
				$('.my-carousel').owlCarousel({
					items: 1,
					loop: false,
					nav: true,
					dots: true,
					margin: 10,
					autoHeight: true,
					responsive: {
						0: {
								items: 1
						},
						600: {
								items: 2
						},
						1000: {
								items: 5
						}
					}
				});
			});
		</script>
	{{-- tooltip --}}
		<script>
			const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
			const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
		</script>

	{{-- right sidebar toggle script --}}
	<script>
		function toggleSidebarNew(action_has = '' , is_wrc = '') {
			$('.wrc-detail-img').addClass('d-none')
			$('.file_size_row').addClass('d-none')
			$('.wrc_row').addClass('d-none')
			$("#shoot_files_details").addClass('d-none')
			if(action_has == 'image'){
				$('.wrc-detail-img').removeClass('d-none')
				$('.file_size_row').removeClass('d-none')
			}
			if(is_wrc == 'wrc'){
				$('.wrc_row').removeClass('d-none')
			}
			var sidebar = document.querySelector('.sidebar');
			sidebar.classList.toggle('open');
		}
	</script>

{{-- set_shoot_date_time --}}
	<script>
		const set_shoot_date_time = (key , service = 'other') => {
			const lot_number = $("#lot_number"+key).html()
			const lot_date = $("#lot_date"+key).html()
			const lot_time = $("#lot_time"+key).html()
			$("#lot_time").html(lot_time)
			$("#lot_date").html(lot_date)
			$("#lot_number").html(lot_number)

			const image_src = $("#image_src"+key).html()
			$("#image_src").attr("src", image_src);

			if(service == 'shoot'){
				$("#s_type").html($("#s_type"+key).html())
				$("#skus_count").html($("#skus_count"+key).html())
				$("#raw_images").html($("#raw_images"+key).html())
				$("#edited_images").html($("#edited_images"+key).html())
				$("#wrc_numbers").html($("#wrc_numbers"+key).html())
				$("#shoot_files_details").removeClass('d-none')
			}else{
				$("#shoot_files_details").addClass('d-none')
			}
		}
	</script>

{{-- set_shoot_date_time --}}
	<script>
		const set_editing_date_time = (key , service = 'other') => {
			const lot_number = $("#lot_number"+key).html()
			const lot_date = $("#lot_date"+key).html()
			const lot_time = $("#lot_time"+key).html()
			$("#lot_time").html(lot_time)
			$("#lot_date").html(lot_date)
			$("#lot_number").html(lot_number)
			$("#wrc_numbers").html($("#wrc_numbers"+key).html())
			const image_src = $("#image_src"+key).html()
			$("#image_src").attr("src", image_src);
		}
	</script>

	{{-- Setting data and time in side bar --}}
	<script>
		const set_links_date_time = (key) => {
			const lot_number = $("#lot_number"+key).html()
			const lot_date = $("#lot_date"+key).html()
			const lot_time = $("#lot_time"+key).html()
			const file_size = $("#file_size"+key).html()
			console.log({lot_number,lot_date , lot_time})
			$("#lot_time").html(lot_time)
			$("#lot_date").html(lot_date)
			$("#lot_number").html(lot_number)
			$("#file_size").html(file_size)
			$("#wrc_numbers").html($("#wrc_numbers"+key).html())
			
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
	
@endsection
