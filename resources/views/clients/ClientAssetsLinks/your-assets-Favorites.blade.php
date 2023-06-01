@extends('layouts.DamNewMain')
@section('title')
  Your Assets - Favorites
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
	<div class=" col-12 d-flex justify-content-between">
			<h4 class="headingF">
					Your Assets
			</h4>
			<button class="btn btn-none border dropdown-toggle btn-outline-none" type="button"
					id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-expanded="false">
					Sort
			</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
					<li><a class="dropdown-item" href="#">2022</a></li>
					<li><a class="dropdown-item" href="#">2023</a></li>
			</ul>
	</div>
</div>
<div class="row" style="margin-top: 12px;">
	<div class="col-12">
			<p class="underheadingF">
					Currently, you are viewing: Favorites
			</p>
	</div>
</div>

<!-- Image Section -->
<div class="row">
	<p class="fovourites-img-lot-sku-wrc-section">Images</p>
	<div class="col-sm-6 col-md-4 col-lg-3 mt-2">
			<div class="card brand-img-m border-0 rounded-0">
					<img class="card-img-top brand-img" src="https://odnconnect.odndigital.com/IMG/group_10.png"
							alt="Image">
					<div class="card-body total-sku-img-body d-flex justify-content-between"
							style="position: relative">
							<p class="brand-img-name" id="lot_number493100">OD_BT_0440D_T20_J4_AW22_EC_1.JPG</p>
							<i class="bi bi-three-dots-vertical myButton"
									style="cursor: pointer;color:#808080;"></i>
							<div class="myPopover" style="display: none; top:20%;">

									<a href="https://odnconnect.odndigital.com/IMG/group_10.png"
											download="OD_BT_0440D_T20_J4_AW22_EC_1.JPG">
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

									<a href="javascript:void(0)" onclick="toggleSidebar(); set_date(493100);">
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
											<span id="lot_date493100">03-11-2022</span>
											<span id="lot_time493100">08:01 AM</span>
											<span id="file_size493100">File Not Found!!</span>
											<span
													id="image_src493100">https://odnconnect.odndigital.com/IMG/no_preview_available.jpg</span>
									</div>

									<a href="javascript:void(0)"
											onclick="copyUrlToClipboard('url_0' , 'Shoot Lot WRC Image' , 'Shoot WRC')">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
															d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"
															stroke-linejoin="round"></path>
											</svg>
											&nbsp;&nbsp;
											Share
									</a>
									<p class="d-none" id="url_0">https://odnconnect.odndigital.com/IMG/group_10.png</p>
							</div>
					</div>
			</div>
	</div>
</div>

<!-- Lots Section -->
<div class="row">
	<p class="fovourites-img-lot-sku-wrc-section">Lots</p>
	<div class="col-lg-4 col-md-6 box border-0" style="background: #0F0F0F; position: relative;">
			<div class="row">
					<div class="under-content-div">
							<div class="col-12">
									<a href="https://odnconnect.odndigital.com/your-assets-shoot-wrcs/3562">
											<img style="width: 100%; min-height: 393px;"
													src="https://odnconnect.odndigital.com/IMG/no_preview_available.jpg" alt=""
													class="img-fluid">
									</a>
							</div>
							<div class="col-12 d-flex justify-content-between">
									<div>
											<p class="lot-no-heading">Lot no</p>
											<span class="your-asset-lotno-underbox"
													id="lot_number35620">ODN03112022-MSMnSES3562</span>&nbsp;&nbsp;
											<div class="myPopover" style="display: none;">
													<a
															href="https://odnconnect.odndigital.com/download-shoot-lot-Edited-image/3562">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942"
																			stroke="white" stroke-width="1.5" stroke-miterlimit="10"
																			stroke-linecap="round" stroke-linejoin="round"></path>
															</svg>&nbsp;
															Download
													</a>

													<a href="javascript:void(0)"
															onclick="toggleSidebar(); set_date_time(35620, 'shoot'); lots_details('MzU2Mg==' , 'lot' , 'Edited') ">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_1069_2515)">
																			<path
																					d="M9.99992 13.333L9.99992 9.16634M9.99992 1.66634C5.41658 1.66634 1.66658 5.41634 1.66658 9.99968C1.66659 14.583 5.41659 18.333 9.99992 18.333C14.5833 18.333 18.3333 14.583 18.3333 9.99967C18.3333 5.41634 14.5833 1.66634 9.99992 1.66634Z"
																					stroke="white" stroke-width="1.5" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																			<path d="M10.0042 6.66699L9.99665 6.66699" stroke="white"
																					stroke-width="2" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_1069_2515">
																					<rect width="20" height="20" fill="white"></rect>
																			</clipPath>
																	</defs>
															</svg>&nbsp;
															View Details
													</a>


													<div class="d-none">
															<span id="lot_date35620">03-11-2022</span>
															<span id="lot_time35620">08:00 AM</span>
															<span
																	id="image_src35620">https://odnconnect.odndigital.com/IMG/no_preview_available.jpg</span>
															<span id="skus_count35620">39</span>
															<span id="raw_images35620">275</span>
															<span id="edited_images35620">155</span>
															<span id="s_type35620">ES</span>
															<span
																	id="wrc_numbers35620">MSMnSES3562-A,MSMnSES3562-B,MSMnSES3562-C,MSMnSES3562-D,MSMnSES3562-E</span>
													</div>

													<a href="javascript:void(0)"
															onclick="copyUrlToClipboard('url_0' , 'Shoot Lot WRC Image' , 'Shoot WRC')">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"
																			stroke-linejoin="round"></path>
															</svg>&nbsp;
															Share
													</a>
													<p class="d-none" id="url_0">
															https://odnconnect.odndigital.com/download-shoot-lot-Edited-image/3562
													</p>
													<a href="javascript:void(0)">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_1069_2524)">
																			<path
																					d="M11.4416 2.9252L12.9083 5.85853C13.1083 6.26686 13.6416 6.65853 14.0916 6.73353L16.7499 7.1752C18.4499 7.45853 18.8499 8.69186 17.6249 9.90853L15.5583 11.9752C15.2083 12.3252 15.0166 13.0002 15.1249 13.4835L15.7166 16.0419C16.1833 18.0669 15.1083 18.8502 13.3166 17.7919L10.8249 16.3169C10.3749 16.0502 9.63326 16.0502 9.17492 16.3169L6.68326 17.7919C4.89992 18.8502 3.81659 18.0585 4.28326 16.0419L4.87492 13.4835C4.98326 13.0002 4.79159 12.3252 4.44159 11.9752L2.37492 9.90853C1.15826 8.69186 1.54992 7.45853 3.24992 7.1752L5.90826 6.73353C6.34992 6.65853 6.88326 6.26686 7.08326 5.85853L8.54992 2.9252C9.34992 1.33353 10.6499 1.33353 11.4416 2.9252Z"
																					stroke="white" stroke-width="1.5" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_1069_2524">
																					<rect width="20" height="20" fill="white"></rect>
																			</clipPath>
																	</defs>
															</svg>&nbsp;
															Add to favorites
													</a>
													<a href="javascript:void(0)">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M3.47507 12.7498L7.25007 16.5248C7.99675 17.2693 9.00816 17.6873 10.0626 17.6873C11.117 17.6873 12.1284 17.2693 12.8751 16.5248L16.5334 12.8664C17.2779 12.1198 17.696 11.1084 17.696 10.0539C17.696 8.99952 17.2779 7.98812 16.5334 7.24144L12.7501 3.47477C12.3589 3.08252 11.8898 2.77675 11.373 2.57722C10.8562 2.37769 10.3033 2.28884 9.75007 2.31644L5.58341 2.51644C3.91674 2.59144 2.59174 3.91644 2.50841 5.57477L2.30841 9.74144C2.25841 10.8664 2.68341 11.9581 3.47507 12.7498Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"
																			stroke-linejoin="round"></path>
																	<path
																			d="M7.91659 9.99967C8.46912 9.99967 8.99902 9.78018 9.38972 9.38948C9.78043 8.99878 9.99992 8.46888 9.99992 7.91634C9.99992 7.36381 9.78043 6.8339 9.38972 6.4432C8.99902 6.0525 8.46912 5.83301 7.91659 5.83301C7.36405 5.83301 6.83415 6.0525 6.44345 6.4432C6.05275 6.8339 5.83325 7.36381 5.83325 7.91634C5.83325 8.46888 6.05275 8.99878 6.44345 9.38948C6.83415 9.78018 7.36405 9.99967 7.91659 9.99967Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
															</svg> &nbsp;
															Add Tag
													</a>
											</div>
									</div>
									<div type="button" class="btn border-0 rounded-circle myButton">
											<i class="bi bi-three-dots-vertical" style="color: #9F9F9F;line-height: 2.5;">
											</i>
									</div>
							</div>
							<div class="col-12">
									<span class="your-asset-lot-date-underbox">Date :</span> <span
											class="your-asset-lot-date">03-11-2022</span>
							</div>
							<div class="col-12 d-flex justify-content-between">
									<div>
											<p class="inward-qty">Inward Quantity : </p>
											<p class="inward-qty-num">
													39
											</p>
									</div>
									<div>
											<p class="inward-qty">Submission</p>
											<p class="inward-qty-num">22-12-2022</p>
									</div>
							</div>
							<div class="col-12 d-grid gap-2">
									<a role="button" class="btn border rounded-0 view-img "
											href="https://odnconnect.odndigital.com/your-assets-shoot-wrcs/3562">
											View images
									</a>
							</div>
					</div>
			</div>
	</div>
	<div class="col-lg-4 col-md-6 box border-0" style="background: #0F0F0F; position: relative;">
			<div class="row">
					<div class="under-content-div">
							<div class="col-12">
									<a href="https://odnconnect.odndigital.com/your-assets-shoot-wrcs/3562">
											<img style="width: 100%; min-height: 393px;"
													src="https://odnconnect.odndigital.com/IMG/no_preview_available.jpg" alt=""
													class="img-fluid">
									</a>
							</div>
							<div class="col-12 d-flex justify-content-between">
									<div>
											<p class="lot-no-heading">Lot no</p>
											<span class="your-asset-lotno-underbox"
													id="lot_number35620">ODN03112022-MSMnSES3562</span>&nbsp;&nbsp;
											<div class="myPopover" style="display: none;">
													<a
															href="https://odnconnect.odndigital.com/download-shoot-lot-Edited-image/3562">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942"
																			stroke="white" stroke-width="1.5" stroke-miterlimit="10"
																			stroke-linecap="round" stroke-linejoin="round"></path>
															</svg>&nbsp;
															Download
													</a>

													<a href="javascript:void(0)"
															onclick="toggleSidebar(); set_date_time(35620, 'shoot'); lots_details('MzU2Mg==' , 'lot' , 'Edited') ">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_1069_2515)">
																			<path
																					d="M9.99992 13.333L9.99992 9.16634M9.99992 1.66634C5.41658 1.66634 1.66658 5.41634 1.66658 9.99968C1.66659 14.583 5.41659 18.333 9.99992 18.333C14.5833 18.333 18.3333 14.583 18.3333 9.99967C18.3333 5.41634 14.5833 1.66634 9.99992 1.66634Z"
																					stroke="white" stroke-width="1.5" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																			<path d="M10.0042 6.66699L9.99665 6.66699" stroke="white"
																					stroke-width="2" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_1069_2515">
																					<rect width="20" height="20" fill="white"></rect>
																			</clipPath>
																	</defs>
															</svg>&nbsp;
															View Details
													</a>


													<div class="d-none">
															<span id="lot_date35620">03-11-2022</span>
															<span id="lot_time35620">08:00 AM</span>
															<span
																	id="image_src35620">https://odnconnect.odndigital.com/IMG/no_preview_available.jpg</span>
															<span id="skus_count35620">39</span>
															<span id="raw_images35620">275</span>
															<span id="edited_images35620">155</span>
															<span id="s_type35620">ES</span>
															<span
																	id="wrc_numbers35620">MSMnSES3562-A,MSMnSES3562-B,MSMnSES3562-C,MSMnSES3562-D,MSMnSES3562-E</span>
													</div>

													<a href="javascript:void(0)"
															onclick="copyUrlToClipboard('url_0' , 'Shoot Lot WRC Image' , 'Shoot WRC')">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"
																			stroke-linejoin="round"></path>
															</svg>&nbsp;
															Share
													</a>
													<p class="d-none" id="url_0">
															https://odnconnect.odndigital.com/download-shoot-lot-Edited-image/3562
													</p>
													<a href="javascript:void(0)">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_1069_2524)">
																			<path
																					d="M11.4416 2.9252L12.9083 5.85853C13.1083 6.26686 13.6416 6.65853 14.0916 6.73353L16.7499 7.1752C18.4499 7.45853 18.8499 8.69186 17.6249 9.90853L15.5583 11.9752C15.2083 12.3252 15.0166 13.0002 15.1249 13.4835L15.7166 16.0419C16.1833 18.0669 15.1083 18.8502 13.3166 17.7919L10.8249 16.3169C10.3749 16.0502 9.63326 16.0502 9.17492 16.3169L6.68326 17.7919C4.89992 18.8502 3.81659 18.0585 4.28326 16.0419L4.87492 13.4835C4.98326 13.0002 4.79159 12.3252 4.44159 11.9752L2.37492 9.90853C1.15826 8.69186 1.54992 7.45853 3.24992 7.1752L5.90826 6.73353C6.34992 6.65853 6.88326 6.26686 7.08326 5.85853L8.54992 2.9252C9.34992 1.33353 10.6499 1.33353 11.4416 2.9252Z"
																					stroke="white" stroke-width="1.5" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_1069_2524">
																					<rect width="20" height="20" fill="white"></rect>
																			</clipPath>
																	</defs>
															</svg>&nbsp;
															Add to favorites
													</a>
													<a href="javascript:void(0)">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M3.47507 12.7498L7.25007 16.5248C7.99675 17.2693 9.00816 17.6873 10.0626 17.6873C11.117 17.6873 12.1284 17.2693 12.8751 16.5248L16.5334 12.8664C17.2779 12.1198 17.696 11.1084 17.696 10.0539C17.696 8.99952 17.2779 7.98812 16.5334 7.24144L12.7501 3.47477C12.3589 3.08252 11.8898 2.77675 11.373 2.57722C10.8562 2.37769 10.3033 2.28884 9.75007 2.31644L5.58341 2.51644C3.91674 2.59144 2.59174 3.91644 2.50841 5.57477L2.30841 9.74144C2.25841 10.8664 2.68341 11.9581 3.47507 12.7498Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"
																			stroke-linejoin="round"></path>
																	<path
																			d="M7.91659 9.99967C8.46912 9.99967 8.99902 9.78018 9.38972 9.38948C9.78043 8.99878 9.99992 8.46888 9.99992 7.91634C9.99992 7.36381 9.78043 6.8339 9.38972 6.4432C8.99902 6.0525 8.46912 5.83301 7.91659 5.83301C7.36405 5.83301 6.83415 6.0525 6.44345 6.4432C6.05275 6.8339 5.83325 7.36381 5.83325 7.91634C5.83325 8.46888 6.05275 8.99878 6.44345 9.38948C6.83415 9.78018 7.36405 9.99967 7.91659 9.99967Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
															</svg> &nbsp;
															Add Tag
													</a>
											</div>
									</div>
									<div type="button" class="btn border-0 rounded-circle myButton">
											<i class="bi bi-three-dots-vertical" style="color: #9F9F9F;line-height: 2.5;">
											</i>
									</div>
							</div>
							<div class="col-12">
									<span class="your-asset-lot-date-underbox">Date :</span> <span
											class="your-asset-lot-date">03-11-2022</span>
							</div>
							<div class="col-12 d-flex justify-content-between">
									<div>
											<p class="inward-qty">Inward Quantity : </p>
											<p class="inward-qty-num">
													39
											</p>
									</div>
									<div>
											<p class="inward-qty">Submission</p>
											<p class="inward-qty-num">22-12-2022</p>
									</div>
							</div>
							<div class="col-12 d-grid gap-2">
									<a role="button" class="btn border rounded-0 view-img "
											href="https://odnconnect.odndigital.com/your-assets-shoot-wrcs/3562">
											View images
									</a>
							</div>
					</div>
			</div>
	</div>
	<div class="col-lg-4 col-md-6 box border-0" style="background: #0F0F0F; position: relative;">
			<div class="row">
					<div class="under-content-div">
							<div class="col-12">
									<a href="https://odnconnect.odndigital.com/your-assets-shoot-wrcs/3562">
											<img style="width: 100%; min-height: 393px;"
													src="https://odnconnect.odndigital.com/IMG/no_preview_available.jpg" alt=""
													class="img-fluid">
									</a>
							</div>
							<div class="col-12 d-flex justify-content-between">
									<div>
											<p class="lot-no-heading">Lot no</p>
											<span class="your-asset-lotno-underbox"
													id="lot_number35620">ODN03112022-MSMnSES3562</span>&nbsp;&nbsp;
											<div class="myPopover" style="display: none;">
													<a
															href="https://odnconnect.odndigital.com/download-shoot-lot-Edited-image/3562">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942"
																			stroke="white" stroke-width="1.5" stroke-miterlimit="10"
																			stroke-linecap="round" stroke-linejoin="round"></path>
															</svg>&nbsp;
															Download
													</a>

													<a href="javascript:void(0)"
															onclick="toggleSidebar(); set_date_time(35620, 'shoot'); lots_details('MzU2Mg==' , 'lot' , 'Edited') ">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_1069_2515)">
																			<path
																					d="M9.99992 13.333L9.99992 9.16634M9.99992 1.66634C5.41658 1.66634 1.66658 5.41634 1.66658 9.99968C1.66659 14.583 5.41659 18.333 9.99992 18.333C14.5833 18.333 18.3333 14.583 18.3333 9.99967C18.3333 5.41634 14.5833 1.66634 9.99992 1.66634Z"
																					stroke="white" stroke-width="1.5" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																			<path d="M10.0042 6.66699L9.99665 6.66699" stroke="white"
																					stroke-width="2" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_1069_2515">
																					<rect width="20" height="20" fill="white"></rect>
																			</clipPath>
																	</defs>
															</svg>&nbsp;
															View Details
													</a>


													<div class="d-none">
															<span id="lot_date35620">03-11-2022</span>
															<span id="lot_time35620">08:00 AM</span>
															<span
																	id="image_src35620">https://odnconnect.odndigital.com/IMG/no_preview_available.jpg</span>
															<span id="skus_count35620">39</span>
															<span id="raw_images35620">275</span>
															<span id="edited_images35620">155</span>
															<span id="s_type35620">ES</span>
															<span
																	id="wrc_numbers35620">MSMnSES3562-A,MSMnSES3562-B,MSMnSES3562-C,MSMnSES3562-D,MSMnSES3562-E</span>
													</div>

													<a href="javascript:void(0)"
															onclick="copyUrlToClipboard('url_0' , 'Shoot Lot WRC Image' , 'Shoot WRC')">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"
																			stroke-linejoin="round"></path>
															</svg>&nbsp;
															Share
													</a>
													<p class="d-none" id="url_0">
															https://odnconnect.odndigital.com/download-shoot-lot-Edited-image/3562
													</p>
													<a href="javascript:void(0)">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_1069_2524)">
																			<path
																					d="M11.4416 2.9252L12.9083 5.85853C13.1083 6.26686 13.6416 6.65853 14.0916 6.73353L16.7499 7.1752C18.4499 7.45853 18.8499 8.69186 17.6249 9.90853L15.5583 11.9752C15.2083 12.3252 15.0166 13.0002 15.1249 13.4835L15.7166 16.0419C16.1833 18.0669 15.1083 18.8502 13.3166 17.7919L10.8249 16.3169C10.3749 16.0502 9.63326 16.0502 9.17492 16.3169L6.68326 17.7919C4.89992 18.8502 3.81659 18.0585 4.28326 16.0419L4.87492 13.4835C4.98326 13.0002 4.79159 12.3252 4.44159 11.9752L2.37492 9.90853C1.15826 8.69186 1.54992 7.45853 3.24992 7.1752L5.90826 6.73353C6.34992 6.65853 6.88326 6.26686 7.08326 5.85853L8.54992 2.9252C9.34992 1.33353 10.6499 1.33353 11.4416 2.9252Z"
																					stroke="white" stroke-width="1.5" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_1069_2524">
																					<rect width="20" height="20" fill="white"></rect>
																			</clipPath>
																	</defs>
															</svg>&nbsp;
															Add to favorites
													</a>
													<a href="javascript:void(0)">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M3.47507 12.7498L7.25007 16.5248C7.99675 17.2693 9.00816 17.6873 10.0626 17.6873C11.117 17.6873 12.1284 17.2693 12.8751 16.5248L16.5334 12.8664C17.2779 12.1198 17.696 11.1084 17.696 10.0539C17.696 8.99952 17.2779 7.98812 16.5334 7.24144L12.7501 3.47477C12.3589 3.08252 11.8898 2.77675 11.373 2.57722C10.8562 2.37769 10.3033 2.28884 9.75007 2.31644L5.58341 2.51644C3.91674 2.59144 2.59174 3.91644 2.50841 5.57477L2.30841 9.74144C2.25841 10.8664 2.68341 11.9581 3.47507 12.7498Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"
																			stroke-linejoin="round"></path>
																	<path
																			d="M7.91659 9.99967C8.46912 9.99967 8.99902 9.78018 9.38972 9.38948C9.78043 8.99878 9.99992 8.46888 9.99992 7.91634C9.99992 7.36381 9.78043 6.8339 9.38972 6.4432C8.99902 6.0525 8.46912 5.83301 7.91659 5.83301C7.36405 5.83301 6.83415 6.0525 6.44345 6.4432C6.05275 6.8339 5.83325 7.36381 5.83325 7.91634C5.83325 8.46888 6.05275 8.99878 6.44345 9.38948C6.83415 9.78018 7.36405 9.99967 7.91659 9.99967Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
															</svg> &nbsp;
															Add Tag
													</a>
											</div>
									</div>
									<div type="button" class="btn border-0 rounded-circle myButton">
											<i class="bi bi-three-dots-vertical" style="color: #9F9F9F;line-height: 2.5;">
											</i>
									</div>
							</div>
							<div class="col-12">
									<span class="your-asset-lot-date-underbox">Date :</span> <span
											class="your-asset-lot-date">03-11-2022</span>
							</div>
							<div class="col-12 d-flex justify-content-between">
									<div>
											<p class="inward-qty">Inward Quantity : </p>
											<p class="inward-qty-num">
													39
											</p>
									</div>
									<div>
											<p class="inward-qty">Submission</p>
											<p class="inward-qty-num">22-12-2022</p>
									</div>
							</div>
							<div class="col-12 d-grid gap-2">
									<a role="button" class="btn border rounded-0 view-img "
											href="https://odnconnect.odndigital.com/your-assets-shoot-wrcs/3562">
											View images
									</a>
							</div>
					</div>
			</div>
	</div>
	<div class="col-lg-4 col-md-6 box border-0" style="background: #0F0F0F; position: relative;">
			<div class="row">
					<div class="under-content-div">
							<div class="col-12">
									<a href="https://odnconnect.odndigital.com/your-assets-shoot-wrcs/3562">
											<img style="width: 100%; min-height: 393px;"
													src="https://odnconnect.odndigital.com/IMG/no_preview_available.jpg" alt=""
													class="img-fluid">
									</a>
							</div>
							<div class="col-12 d-flex justify-content-between">
									<div>
											<p class="lot-no-heading">Lot no</p>
											<span class="your-asset-lotno-underbox"
													id="lot_number35620">ODN03112022-MSMnSES3562</span>&nbsp;&nbsp;
											<div class="myPopover" style="display: none;">
													<a
															href="https://odnconnect.odndigital.com/download-shoot-lot-Edited-image/3562">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942"
																			stroke="white" stroke-width="1.5" stroke-miterlimit="10"
																			stroke-linecap="round" stroke-linejoin="round"></path>
															</svg>&nbsp;
															Download
													</a>

													<a href="javascript:void(0)"
															onclick="toggleSidebar(); set_date_time(35620, 'shoot'); lots_details('MzU2Mg==' , 'lot' , 'Edited') ">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_1069_2515)">
																			<path
																					d="M9.99992 13.333L9.99992 9.16634M9.99992 1.66634C5.41658 1.66634 1.66658 5.41634 1.66658 9.99968C1.66659 14.583 5.41659 18.333 9.99992 18.333C14.5833 18.333 18.3333 14.583 18.3333 9.99967C18.3333 5.41634 14.5833 1.66634 9.99992 1.66634Z"
																					stroke="white" stroke-width="1.5" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																			<path d="M10.0042 6.66699L9.99665 6.66699" stroke="white"
																					stroke-width="2" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_1069_2515">
																					<rect width="20" height="20" fill="white"></rect>
																			</clipPath>
																	</defs>
															</svg>&nbsp;
															View Details
													</a>


													<div class="d-none">
															<span id="lot_date35620">03-11-2022</span>
															<span id="lot_time35620">08:00 AM</span>
															<span
																	id="image_src35620">https://odnconnect.odndigital.com/IMG/no_preview_available.jpg</span>
															<span id="skus_count35620">39</span>
															<span id="raw_images35620">275</span>
															<span id="edited_images35620">155</span>
															<span id="s_type35620">ES</span>
															<span
																	id="wrc_numbers35620">MSMnSES3562-A,MSMnSES3562-B,MSMnSES3562-C,MSMnSES3562-D,MSMnSES3562-E</span>
													</div>

													<a href="javascript:void(0)"
															onclick="copyUrlToClipboard('url_0' , 'Shoot Lot WRC Image' , 'Shoot WRC')">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"
																			stroke-linejoin="round"></path>
															</svg>&nbsp;
															Share
													</a>
													<p class="d-none" id="url_0">
															https://odnconnect.odndigital.com/download-shoot-lot-Edited-image/3562
													</p>
													<a href="javascript:void(0)">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_1069_2524)">
																			<path
																					d="M11.4416 2.9252L12.9083 5.85853C13.1083 6.26686 13.6416 6.65853 14.0916 6.73353L16.7499 7.1752C18.4499 7.45853 18.8499 8.69186 17.6249 9.90853L15.5583 11.9752C15.2083 12.3252 15.0166 13.0002 15.1249 13.4835L15.7166 16.0419C16.1833 18.0669 15.1083 18.8502 13.3166 17.7919L10.8249 16.3169C10.3749 16.0502 9.63326 16.0502 9.17492 16.3169L6.68326 17.7919C4.89992 18.8502 3.81659 18.0585 4.28326 16.0419L4.87492 13.4835C4.98326 13.0002 4.79159 12.3252 4.44159 11.9752L2.37492 9.90853C1.15826 8.69186 1.54992 7.45853 3.24992 7.1752L5.90826 6.73353C6.34992 6.65853 6.88326 6.26686 7.08326 5.85853L8.54992 2.9252C9.34992 1.33353 10.6499 1.33353 11.4416 2.9252Z"
																					stroke="white" stroke-width="1.5" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_1069_2524">
																					<rect width="20" height="20" fill="white"></rect>
																			</clipPath>
																	</defs>
															</svg>&nbsp;
															Add to favorites
													</a>
													<a href="javascript:void(0)">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M3.47507 12.7498L7.25007 16.5248C7.99675 17.2693 9.00816 17.6873 10.0626 17.6873C11.117 17.6873 12.1284 17.2693 12.8751 16.5248L16.5334 12.8664C17.2779 12.1198 17.696 11.1084 17.696 10.0539C17.696 8.99952 17.2779 7.98812 16.5334 7.24144L12.7501 3.47477C12.3589 3.08252 11.8898 2.77675 11.373 2.57722C10.8562 2.37769 10.3033 2.28884 9.75007 2.31644L5.58341 2.51644C3.91674 2.59144 2.59174 3.91644 2.50841 5.57477L2.30841 9.74144C2.25841 10.8664 2.68341 11.9581 3.47507 12.7498Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"
																			stroke-linejoin="round"></path>
																	<path
																			d="M7.91659 9.99967C8.46912 9.99967 8.99902 9.78018 9.38972 9.38948C9.78043 8.99878 9.99992 8.46888 9.99992 7.91634C9.99992 7.36381 9.78043 6.8339 9.38972 6.4432C8.99902 6.0525 8.46912 5.83301 7.91659 5.83301C7.36405 5.83301 6.83415 6.0525 6.44345 6.4432C6.05275 6.8339 5.83325 7.36381 5.83325 7.91634C5.83325 8.46888 6.05275 8.99878 6.44345 9.38948C6.83415 9.78018 7.36405 9.99967 7.91659 9.99967Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
															</svg> &nbsp;
															Add Tag
													</a>
											</div>
									</div>
									<div type="button" class="btn border-0 rounded-circle myButton">
											<i class="bi bi-three-dots-vertical" style="color: #9F9F9F;line-height: 2.5;">
											</i>
									</div>
							</div>
							<div class="col-12">
									<span class="your-asset-lot-date-underbox">Date :</span> <span
											class="your-asset-lot-date">03-11-2022</span>
							</div>
							<div class="col-12 d-flex justify-content-between">
									<div>
											<p class="inward-qty">Inward Quantity : </p>
											<p class="inward-qty-num">
													39
											</p>
									</div>
									<div>
											<p class="inward-qty">Submission</p>
											<p class="inward-qty-num">22-12-2022</p>
									</div>
							</div>
							<div class="col-12 d-grid gap-2">
									<a role="button" class="btn border rounded-0 view-img "
											href="https://odnconnect.odndigital.com/your-assets-shoot-wrcs/3562">
											View images
									</a>
							</div>
					</div>
			</div>
	</div>
</div>

<!-- SKUs Section -->
<div class="row">
	<p class="fovourites-img-lot-sku-wrc-section">SKUs</p>
	<div class="col-lg-3 col-md-6 mt-2">
			<div class="row brand-div2" style="position: relative;">
					<div class="col-2 mt-3">
							<svg width="24" height="25" viewBox="0 0 24 25" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
											d="M23.5735 13.0404C23.5407 13.194 23.4783 13.3428 23.4167 13.486C23.2951 13.7676 23.1695 14.0476 23.0335 14.322C22.0167 16.3748 20.9847 18.4204 19.9703 20.4748C19.5743 21.2772 18.9519 21.6556 18.0567 21.6548C12.7055 21.6476 7.35429 21.65 2.00309 21.6524C1.42469 21.6524 0.829492 21.4044 0.559893 20.8636C0.411093 20.5652 0.562292 20.3028 0.692692 20.0308C0.796692 19.8132 0.900692 19.5964 1.00549 19.3788C1.21349 18.9444 1.42149 18.51 1.62949 18.0748C1.83749 17.6404 2.04549 17.2052 2.25269 16.7708C2.46069 16.3356 2.66789 15.9012 2.87509 15.466C3.08229 15.0308 3.28949 14.5956 3.49669 14.1604C3.70389 13.7252 3.91029 13.29 4.11749 12.8548C4.22629 12.626 4.33429 12.398 4.44309 12.1692C4.83429 11.3452 5.47589 10.9356 6.37909 10.9348C11.4439 10.9324 16.5079 10.9308 21.5727 10.9364C22.0591 10.9364 22.5511 11.0556 22.9239 11.382C23.2063 11.6292 23.4223 11.9604 23.5303 12.3204C23.5847 12.502 23.6103 12.6924 23.5975 12.882C23.5943 12.9356 23.5863 12.9884 23.5743 13.0404H23.5735Z"
											fill="white"></path>
									<path
											d="M0.408809 17.4766C0.400009 17.4646 0.399209 17.447 0.400809 17.4326C0.406409 17.3726 0.405609 17.3126 0.405609 17.2526C0.405609 13.2534 0.405609 9.25342 0.405609 5.25422C0.405609 4.23902 0.973609 3.67102 1.99041 3.67022C3.71841 3.67022 5.44641 3.67582 7.17441 3.66702C7.79921 3.66382 8.27521 3.90222 8.62961 4.41902C9.03921 5.01582 9.47361 5.59582 9.88721 6.19022C9.98721 6.33422 10.092 6.39262 10.272 6.39182C12.9736 6.38542 15.6752 6.38862 18.3768 6.38622C18.9816 6.38622 19.4728 6.59742 19.764 7.14702C19.856 7.32062 19.9128 7.53182 19.92 7.72782C19.9408 8.31582 19.9288 8.90462 19.9288 9.49342C19.9288 9.52942 19.9192 9.56542 19.9112 9.62302C19.8 9.62302 19.696 9.62302 19.592 9.62302C14.936 9.62302 10.28 9.62462 5.62401 9.62142C4.91121 9.62142 4.30321 9.83262 3.86801 10.423C3.76641 10.5614 3.68801 10.719 3.61361 10.875C2.59281 13.0094 1.57441 15.1446 0.555209 17.2798C0.540009 17.3118 0.524009 17.343 0.508809 17.375C0.494409 17.4046 0.483209 17.439 0.464009 17.467C0.452009 17.4846 0.425609 17.499 0.408809 17.4774V17.4766Z"
											fill="white"></path>
							</svg>

					</div>
					<div class="col-8 mt-2">
							<a style="text-decoration: none;"
									href="https://odnconnect.odndigital.com/your-assets-shoot-raw_images/NDkzMTA=">
									<p class="brand-text" id="lot_number493100">OD_BT_0440D_T20_J4_AW22_EC</p>
							</a>
					</div>
					<div class="col-2 mt-3">
							<i class="bi bi-three-dots-vertical test myButton"
									style="font-size:20px;color: #808080;" role="button"></i>
							<div class="myPopover" style="display: none;">
									<a
											href="https://odnconnect.odndigital.com/Shoot-lot-raw-sku-Images/MjI5Nw==/T0RfQlRfMDQ0MERfVDIwX0o0X0FXMjJfRUM=">
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

									<a href="javascript:void(0)"
											onclick="toggleSidebar(); set_date_time(493100); lots_details('NDkzMTA=' , 'sku' , 'Raw') ">
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
											<span id="lot_date493100">03-11-2022</span>
											<span id="lot_time493100">08:01 AM</span>
											<span
													id="image_src493100">https://odnconnect.odndigital.com/IMG/no_preview_available.jpg</span>
									</div>


									<a href="javascript:void(0)"
											onclick="copyUrlToClipboard('url_02297' , 'Shoot Lot WRC Sku Image' , 'Shoot WRC')">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
															d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"
															stroke-linejoin="round"></path>
											</svg>
											&nbsp;&nbsp;
											Share
									</a>
									<p class="d-none" id="url_02297">
											https://odnconnect.odndigital.com/Shoot-lot-raw-sku-Images/MjI5Nw==/T0RfQlRfMDQ0MERfVDIwX0o0X0FXMjJfRUM=
									</p>

									<a href="javascript:void(0)">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<g clip-path="url(#clip0_1043_2500)">
															<path
																	d="M11.4416 2.92422L12.9083 5.85755C13.1083 6.26589 13.6416 6.65755 14.0916 6.73255L16.7499 7.17422C18.4499 7.45755 18.8499 8.69089 17.6249 9.90755L15.5583 11.9742C15.2083 12.3242 15.0166 12.9992 15.1249 13.4826L15.7166 16.0409C16.1833 18.0659 15.1083 18.8492 13.3166 17.7909L10.8249 16.3159C10.3749 16.0492 9.63326 16.0492 9.17492 16.3159L6.68326 17.7909C4.89992 18.8492 3.81659 18.0576 4.28326 16.0409L4.87492 13.4826C4.98326 12.9992 4.79159 12.3242 4.44159 11.9742L2.37492 9.90755C1.15826 8.69089 1.54992 7.45755 3.24992 7.17422L5.90826 6.73255C6.34992 6.65755 6.88326 6.26589 7.08326 5.85755L8.54992 2.92422C9.34992 1.33255 10.6499 1.33255 11.4416 2.92422Z"
																	stroke="white" stroke-width="1.5" stroke-linecap="round"
																	stroke-linejoin="round"></path>
													</g>
													<defs>
															<clipPath id="clip0_1043_2500">
																	<rect width="20" height="20" fill="white"></rect>
															</clipPath>
													</defs>
											</svg>
											&nbsp;&nbsp;
											Add to favorites
									</a>

									<a href="javascript:void(0)">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
															d="M3.47507 12.7507L7.25007 16.5257C7.99675 17.2702 9.00816 17.6883 10.0626 17.6883C11.117 17.6883 12.1284 17.2702 12.8751 16.5257L16.5334 12.8674C17.2779 12.1207 17.696 11.1093 17.696 10.0549C17.696 9.0005 17.2779 7.98909 16.5334 7.24241L12.7501 3.47575C12.3589 3.0835 11.8898 2.77772 11.373 2.57819C10.8562 2.37866 10.3033 2.28982 9.75007 2.31741L5.58341 2.51741C3.91674 2.59241 2.59174 3.91741 2.50841 5.57575L2.30841 9.74241C2.25841 10.8674 2.68341 11.9591 3.47507 12.7507Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"
															stroke-linejoin="round"></path>
													<path
															d="M7.91659 10.0007C8.46912 10.0007 8.99902 9.78116 9.38972 9.39046C9.78043 8.99976 9.99992 8.46985 9.99992 7.91732C9.99992 7.36478 9.78043 6.83488 9.38972 6.44418C8.99902 6.05348 8.46912 5.83398 7.91659 5.83398C7.36405 5.83398 6.83415 6.05348 6.44345 6.44418C6.05275 6.83488 5.83325 7.36478 5.83325 7.91732C5.83325 8.46985 6.05275 8.99976 6.44345 9.39046C6.83415 9.78116 7.36405 10.0007 7.91659 10.0007Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
											</svg>
											&nbsp;&nbsp;
											Add Tag
									</a>
							</div>
					</div>
			</div>
	</div>
	<div class="col-lg-3 col-md-6 mt-2">
			<div class="row brand-div2" style="position: relative;">
					<div class="col-2 mt-3">
							<svg width="24" height="25" viewBox="0 0 24 25" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
											d="M23.5735 13.0404C23.5407 13.194 23.4783 13.3428 23.4167 13.486C23.2951 13.7676 23.1695 14.0476 23.0335 14.322C22.0167 16.3748 20.9847 18.4204 19.9703 20.4748C19.5743 21.2772 18.9519 21.6556 18.0567 21.6548C12.7055 21.6476 7.35429 21.65 2.00309 21.6524C1.42469 21.6524 0.829492 21.4044 0.559893 20.8636C0.411093 20.5652 0.562292 20.3028 0.692692 20.0308C0.796692 19.8132 0.900692 19.5964 1.00549 19.3788C1.21349 18.9444 1.42149 18.51 1.62949 18.0748C1.83749 17.6404 2.04549 17.2052 2.25269 16.7708C2.46069 16.3356 2.66789 15.9012 2.87509 15.466C3.08229 15.0308 3.28949 14.5956 3.49669 14.1604C3.70389 13.7252 3.91029 13.29 4.11749 12.8548C4.22629 12.626 4.33429 12.398 4.44309 12.1692C4.83429 11.3452 5.47589 10.9356 6.37909 10.9348C11.4439 10.9324 16.5079 10.9308 21.5727 10.9364C22.0591 10.9364 22.5511 11.0556 22.9239 11.382C23.2063 11.6292 23.4223 11.9604 23.5303 12.3204C23.5847 12.502 23.6103 12.6924 23.5975 12.882C23.5943 12.9356 23.5863 12.9884 23.5743 13.0404H23.5735Z"
											fill="white"></path>
									<path
											d="M0.408809 17.4766C0.400009 17.4646 0.399209 17.447 0.400809 17.4326C0.406409 17.3726 0.405609 17.3126 0.405609 17.2526C0.405609 13.2534 0.405609 9.25342 0.405609 5.25422C0.405609 4.23902 0.973609 3.67102 1.99041 3.67022C3.71841 3.67022 5.44641 3.67582 7.17441 3.66702C7.79921 3.66382 8.27521 3.90222 8.62961 4.41902C9.03921 5.01582 9.47361 5.59582 9.88721 6.19022C9.98721 6.33422 10.092 6.39262 10.272 6.39182C12.9736 6.38542 15.6752 6.38862 18.3768 6.38622C18.9816 6.38622 19.4728 6.59742 19.764 7.14702C19.856 7.32062 19.9128 7.53182 19.92 7.72782C19.9408 8.31582 19.9288 8.90462 19.9288 9.49342C19.9288 9.52942 19.9192 9.56542 19.9112 9.62302C19.8 9.62302 19.696 9.62302 19.592 9.62302C14.936 9.62302 10.28 9.62462 5.62401 9.62142C4.91121 9.62142 4.30321 9.83262 3.86801 10.423C3.76641 10.5614 3.68801 10.719 3.61361 10.875C2.59281 13.0094 1.57441 15.1446 0.555209 17.2798C0.540009 17.3118 0.524009 17.343 0.508809 17.375C0.494409 17.4046 0.483209 17.439 0.464009 17.467C0.452009 17.4846 0.425609 17.499 0.408809 17.4774V17.4766Z"
											fill="white"></path>
							</svg>

					</div>
					<div class="col-8 mt-2">
							<a style="text-decoration: none;"
									href="https://odnconnect.odndigital.com/your-assets-shoot-raw_images/NDkzMTA=">
									<p class="brand-text" id="lot_number493100">OD_BT_0440D_T20_J4_AW22_EC</p>
							</a>
					</div>
					<div class="col-2 mt-3">
							<i class="bi bi-three-dots-vertical test myButton"
									style="font-size:20px;color: #808080;" role="button"></i>
							<div class="myPopover" style="display: none;">
									<a
											href="https://odnconnect.odndigital.com/Shoot-lot-raw-sku-Images/MjI5Nw==/T0RfQlRfMDQ0MERfVDIwX0o0X0FXMjJfRUM=">
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

									<a href="javascript:void(0)"
											onclick="toggleSidebar(); set_date_time(493100); lots_details('NDkzMTA=' , 'sku' , 'Raw') ">
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
											<span id="lot_date493100">03-11-2022</span>
											<span id="lot_time493100">08:01 AM</span>
											<span
													id="image_src493100">https://odnconnect.odndigital.com/IMG/no_preview_available.jpg</span>
									</div>


									<a href="javascript:void(0)"
											onclick="copyUrlToClipboard('url_02297' , 'Shoot Lot WRC Sku Image' , 'Shoot WRC')">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
															d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"
															stroke-linejoin="round"></path>
											</svg>
											&nbsp;&nbsp;
											Share
									</a>
									<p class="d-none" id="url_02297">
											https://odnconnect.odndigital.com/Shoot-lot-raw-sku-Images/MjI5Nw==/T0RfQlRfMDQ0MERfVDIwX0o0X0FXMjJfRUM=
									</p>

									<a href="javascript:void(0)">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<g clip-path="url(#clip0_1043_2500)">
															<path
																	d="M11.4416 2.92422L12.9083 5.85755C13.1083 6.26589 13.6416 6.65755 14.0916 6.73255L16.7499 7.17422C18.4499 7.45755 18.8499 8.69089 17.6249 9.90755L15.5583 11.9742C15.2083 12.3242 15.0166 12.9992 15.1249 13.4826L15.7166 16.0409C16.1833 18.0659 15.1083 18.8492 13.3166 17.7909L10.8249 16.3159C10.3749 16.0492 9.63326 16.0492 9.17492 16.3159L6.68326 17.7909C4.89992 18.8492 3.81659 18.0576 4.28326 16.0409L4.87492 13.4826C4.98326 12.9992 4.79159 12.3242 4.44159 11.9742L2.37492 9.90755C1.15826 8.69089 1.54992 7.45755 3.24992 7.17422L5.90826 6.73255C6.34992 6.65755 6.88326 6.26589 7.08326 5.85755L8.54992 2.92422C9.34992 1.33255 10.6499 1.33255 11.4416 2.92422Z"
																	stroke="white" stroke-width="1.5" stroke-linecap="round"
																	stroke-linejoin="round"></path>
													</g>
													<defs>
															<clipPath id="clip0_1043_2500">
																	<rect width="20" height="20" fill="white"></rect>
															</clipPath>
													</defs>
											</svg>
											&nbsp;&nbsp;
											Add to favorites
									</a>

									<a href="javascript:void(0)">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
															d="M3.47507 12.7507L7.25007 16.5257C7.99675 17.2702 9.00816 17.6883 10.0626 17.6883C11.117 17.6883 12.1284 17.2702 12.8751 16.5257L16.5334 12.8674C17.2779 12.1207 17.696 11.1093 17.696 10.0549C17.696 9.0005 17.2779 7.98909 16.5334 7.24241L12.7501 3.47575C12.3589 3.0835 11.8898 2.77772 11.373 2.57819C10.8562 2.37866 10.3033 2.28982 9.75007 2.31741L5.58341 2.51741C3.91674 2.59241 2.59174 3.91741 2.50841 5.57575L2.30841 9.74241C2.25841 10.8674 2.68341 11.9591 3.47507 12.7507Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"
															stroke-linejoin="round"></path>
													<path
															d="M7.91659 10.0007C8.46912 10.0007 8.99902 9.78116 9.38972 9.39046C9.78043 8.99976 9.99992 8.46985 9.99992 7.91732C9.99992 7.36478 9.78043 6.83488 9.38972 6.44418C8.99902 6.05348 8.46912 5.83398 7.91659 5.83398C7.36405 5.83398 6.83415 6.05348 6.44345 6.44418C6.05275 6.83488 5.83325 7.36478 5.83325 7.91732C5.83325 8.46985 6.05275 8.99976 6.44345 9.39046C6.83415 9.78116 7.36405 10.0007 7.91659 10.0007Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
											</svg>
											&nbsp;&nbsp;
											Add Tag
									</a>
							</div>
					</div>
			</div>
	</div>
	<div class="col-lg-3 col-md-6 mt-2">
			<div class="row brand-div2" style="position: relative;">
					<div class="col-2 mt-3">
							<svg width="24" height="25" viewBox="0 0 24 25" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
											d="M23.5735 13.0404C23.5407 13.194 23.4783 13.3428 23.4167 13.486C23.2951 13.7676 23.1695 14.0476 23.0335 14.322C22.0167 16.3748 20.9847 18.4204 19.9703 20.4748C19.5743 21.2772 18.9519 21.6556 18.0567 21.6548C12.7055 21.6476 7.35429 21.65 2.00309 21.6524C1.42469 21.6524 0.829492 21.4044 0.559893 20.8636C0.411093 20.5652 0.562292 20.3028 0.692692 20.0308C0.796692 19.8132 0.900692 19.5964 1.00549 19.3788C1.21349 18.9444 1.42149 18.51 1.62949 18.0748C1.83749 17.6404 2.04549 17.2052 2.25269 16.7708C2.46069 16.3356 2.66789 15.9012 2.87509 15.466C3.08229 15.0308 3.28949 14.5956 3.49669 14.1604C3.70389 13.7252 3.91029 13.29 4.11749 12.8548C4.22629 12.626 4.33429 12.398 4.44309 12.1692C4.83429 11.3452 5.47589 10.9356 6.37909 10.9348C11.4439 10.9324 16.5079 10.9308 21.5727 10.9364C22.0591 10.9364 22.5511 11.0556 22.9239 11.382C23.2063 11.6292 23.4223 11.9604 23.5303 12.3204C23.5847 12.502 23.6103 12.6924 23.5975 12.882C23.5943 12.9356 23.5863 12.9884 23.5743 13.0404H23.5735Z"
											fill="white"></path>
									<path
											d="M0.408809 17.4766C0.400009 17.4646 0.399209 17.447 0.400809 17.4326C0.406409 17.3726 0.405609 17.3126 0.405609 17.2526C0.405609 13.2534 0.405609 9.25342 0.405609 5.25422C0.405609 4.23902 0.973609 3.67102 1.99041 3.67022C3.71841 3.67022 5.44641 3.67582 7.17441 3.66702C7.79921 3.66382 8.27521 3.90222 8.62961 4.41902C9.03921 5.01582 9.47361 5.59582 9.88721 6.19022C9.98721 6.33422 10.092 6.39262 10.272 6.39182C12.9736 6.38542 15.6752 6.38862 18.3768 6.38622C18.9816 6.38622 19.4728 6.59742 19.764 7.14702C19.856 7.32062 19.9128 7.53182 19.92 7.72782C19.9408 8.31582 19.9288 8.90462 19.9288 9.49342C19.9288 9.52942 19.9192 9.56542 19.9112 9.62302C19.8 9.62302 19.696 9.62302 19.592 9.62302C14.936 9.62302 10.28 9.62462 5.62401 9.62142C4.91121 9.62142 4.30321 9.83262 3.86801 10.423C3.76641 10.5614 3.68801 10.719 3.61361 10.875C2.59281 13.0094 1.57441 15.1446 0.555209 17.2798C0.540009 17.3118 0.524009 17.343 0.508809 17.375C0.494409 17.4046 0.483209 17.439 0.464009 17.467C0.452009 17.4846 0.425609 17.499 0.408809 17.4774V17.4766Z"
											fill="white"></path>
							</svg>

					</div>
					<div class="col-8 mt-2">
							<a style="text-decoration: none;"
									href="https://odnconnect.odndigital.com/your-assets-shoot-raw_images/NDkzMTA=">
									<p class="brand-text" id="lot_number493100">OD_BT_0440D_T20_J4_AW22_EC</p>
							</a>
					</div>
					<div class="col-2 mt-3">
							<i class="bi bi-three-dots-vertical test myButton"
									style="font-size:20px;color: #808080;" role="button"></i>
							<div class="myPopover" style="display: none;">
									<a
											href="https://odnconnect.odndigital.com/Shoot-lot-raw-sku-Images/MjI5Nw==/T0RfQlRfMDQ0MERfVDIwX0o0X0FXMjJfRUM=">
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

									<a href="javascript:void(0)"
											onclick="toggleSidebar(); set_date_time(493100); lots_details('NDkzMTA=' , 'sku' , 'Raw') ">
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
											<span id="lot_date493100">03-11-2022</span>
											<span id="lot_time493100">08:01 AM</span>
											<span
													id="image_src493100">https://odnconnect.odndigital.com/IMG/no_preview_available.jpg</span>
									</div>


									<a href="javascript:void(0)"
											onclick="copyUrlToClipboard('url_02297' , 'Shoot Lot WRC Sku Image' , 'Shoot WRC')">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
															d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"
															stroke-linejoin="round"></path>
											</svg>
											&nbsp;&nbsp;
											Share
									</a>
									<p class="d-none" id="url_02297">
											https://odnconnect.odndigital.com/Shoot-lot-raw-sku-Images/MjI5Nw==/T0RfQlRfMDQ0MERfVDIwX0o0X0FXMjJfRUM=
									</p>

									<a href="javascript:void(0)">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<g clip-path="url(#clip0_1043_2500)">
															<path
																	d="M11.4416 2.92422L12.9083 5.85755C13.1083 6.26589 13.6416 6.65755 14.0916 6.73255L16.7499 7.17422C18.4499 7.45755 18.8499 8.69089 17.6249 9.90755L15.5583 11.9742C15.2083 12.3242 15.0166 12.9992 15.1249 13.4826L15.7166 16.0409C16.1833 18.0659 15.1083 18.8492 13.3166 17.7909L10.8249 16.3159C10.3749 16.0492 9.63326 16.0492 9.17492 16.3159L6.68326 17.7909C4.89992 18.8492 3.81659 18.0576 4.28326 16.0409L4.87492 13.4826C4.98326 12.9992 4.79159 12.3242 4.44159 11.9742L2.37492 9.90755C1.15826 8.69089 1.54992 7.45755 3.24992 7.17422L5.90826 6.73255C6.34992 6.65755 6.88326 6.26589 7.08326 5.85755L8.54992 2.92422C9.34992 1.33255 10.6499 1.33255 11.4416 2.92422Z"
																	stroke="white" stroke-width="1.5" stroke-linecap="round"
																	stroke-linejoin="round"></path>
													</g>
													<defs>
															<clipPath id="clip0_1043_2500">
																	<rect width="20" height="20" fill="white"></rect>
															</clipPath>
													</defs>
											</svg>
											&nbsp;&nbsp;
											Add to favorites
									</a>

									<a href="javascript:void(0)">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
															d="M3.47507 12.7507L7.25007 16.5257C7.99675 17.2702 9.00816 17.6883 10.0626 17.6883C11.117 17.6883 12.1284 17.2702 12.8751 16.5257L16.5334 12.8674C17.2779 12.1207 17.696 11.1093 17.696 10.0549C17.696 9.0005 17.2779 7.98909 16.5334 7.24241L12.7501 3.47575C12.3589 3.0835 11.8898 2.77772 11.373 2.57819C10.8562 2.37866 10.3033 2.28982 9.75007 2.31741L5.58341 2.51741C3.91674 2.59241 2.59174 3.91741 2.50841 5.57575L2.30841 9.74241C2.25841 10.8674 2.68341 11.9591 3.47507 12.7507Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"
															stroke-linejoin="round"></path>
													<path
															d="M7.91659 10.0007C8.46912 10.0007 8.99902 9.78116 9.38972 9.39046C9.78043 8.99976 9.99992 8.46985 9.99992 7.91732C9.99992 7.36478 9.78043 6.83488 9.38972 6.44418C8.99902 6.05348 8.46912 5.83398 7.91659 5.83398C7.36405 5.83398 6.83415 6.05348 6.44345 6.44418C6.05275 6.83488 5.83325 7.36478 5.83325 7.91732C5.83325 8.46985 6.05275 8.99976 6.44345 9.39046C6.83415 9.78116 7.36405 10.0007 7.91659 10.0007Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
											</svg>
											&nbsp;&nbsp;
											Add Tag
									</a>
							</div>
					</div>
			</div>
	</div>
	<div class="col-lg-3 col-md-6 mt-2">
			<div class="row brand-div2" style="position: relative;">
					<div class="col-2 mt-3">
							<svg width="24" height="25" viewBox="0 0 24 25" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
											d="M23.5735 13.0404C23.5407 13.194 23.4783 13.3428 23.4167 13.486C23.2951 13.7676 23.1695 14.0476 23.0335 14.322C22.0167 16.3748 20.9847 18.4204 19.9703 20.4748C19.5743 21.2772 18.9519 21.6556 18.0567 21.6548C12.7055 21.6476 7.35429 21.65 2.00309 21.6524C1.42469 21.6524 0.829492 21.4044 0.559893 20.8636C0.411093 20.5652 0.562292 20.3028 0.692692 20.0308C0.796692 19.8132 0.900692 19.5964 1.00549 19.3788C1.21349 18.9444 1.42149 18.51 1.62949 18.0748C1.83749 17.6404 2.04549 17.2052 2.25269 16.7708C2.46069 16.3356 2.66789 15.9012 2.87509 15.466C3.08229 15.0308 3.28949 14.5956 3.49669 14.1604C3.70389 13.7252 3.91029 13.29 4.11749 12.8548C4.22629 12.626 4.33429 12.398 4.44309 12.1692C4.83429 11.3452 5.47589 10.9356 6.37909 10.9348C11.4439 10.9324 16.5079 10.9308 21.5727 10.9364C22.0591 10.9364 22.5511 11.0556 22.9239 11.382C23.2063 11.6292 23.4223 11.9604 23.5303 12.3204C23.5847 12.502 23.6103 12.6924 23.5975 12.882C23.5943 12.9356 23.5863 12.9884 23.5743 13.0404H23.5735Z"
											fill="white"></path>
									<path
											d="M0.408809 17.4766C0.400009 17.4646 0.399209 17.447 0.400809 17.4326C0.406409 17.3726 0.405609 17.3126 0.405609 17.2526C0.405609 13.2534 0.405609 9.25342 0.405609 5.25422C0.405609 4.23902 0.973609 3.67102 1.99041 3.67022C3.71841 3.67022 5.44641 3.67582 7.17441 3.66702C7.79921 3.66382 8.27521 3.90222 8.62961 4.41902C9.03921 5.01582 9.47361 5.59582 9.88721 6.19022C9.98721 6.33422 10.092 6.39262 10.272 6.39182C12.9736 6.38542 15.6752 6.38862 18.3768 6.38622C18.9816 6.38622 19.4728 6.59742 19.764 7.14702C19.856 7.32062 19.9128 7.53182 19.92 7.72782C19.9408 8.31582 19.9288 8.90462 19.9288 9.49342C19.9288 9.52942 19.9192 9.56542 19.9112 9.62302C19.8 9.62302 19.696 9.62302 19.592 9.62302C14.936 9.62302 10.28 9.62462 5.62401 9.62142C4.91121 9.62142 4.30321 9.83262 3.86801 10.423C3.76641 10.5614 3.68801 10.719 3.61361 10.875C2.59281 13.0094 1.57441 15.1446 0.555209 17.2798C0.540009 17.3118 0.524009 17.343 0.508809 17.375C0.494409 17.4046 0.483209 17.439 0.464009 17.467C0.452009 17.4846 0.425609 17.499 0.408809 17.4774V17.4766Z"
											fill="white"></path>
							</svg>

					</div>
					<div class="col-8 mt-2">
							<a style="text-decoration: none;"
									href="https://odnconnect.odndigital.com/your-assets-shoot-raw_images/NDkzMTA=">
									<p class="brand-text" id="lot_number493100">OD_BT_0440D_T20_J4_AW22_EC</p>
							</a>
					</div>
					<div class="col-2 mt-3">
							<i class="bi bi-three-dots-vertical test myButton"
									style="font-size:20px;color: #808080;" role="button"></i>
							<div class="myPopover" style="display: none;">
									<a
											href="https://odnconnect.odndigital.com/Shoot-lot-raw-sku-Images/MjI5Nw==/T0RfQlRfMDQ0MERfVDIwX0o0X0FXMjJfRUM=">
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

									<a href="javascript:void(0)"
											onclick="toggleSidebar(); set_date_time(493100); lots_details('NDkzMTA=' , 'sku' , 'Raw') ">
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
											<span id="lot_date493100">03-11-2022</span>
											<span id="lot_time493100">08:01 AM</span>
											<span
													id="image_src493100">https://odnconnect.odndigital.com/IMG/no_preview_available.jpg</span>
									</div>


									<a href="javascript:void(0)"
											onclick="copyUrlToClipboard('url_02297' , 'Shoot Lot WRC Sku Image' , 'Shoot WRC')">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
															d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"
															stroke-linejoin="round"></path>
											</svg>
											&nbsp;&nbsp;
											Share
									</a>
									<p class="d-none" id="url_02297">
											https://odnconnect.odndigital.com/Shoot-lot-raw-sku-Images/MjI5Nw==/T0RfQlRfMDQ0MERfVDIwX0o0X0FXMjJfRUM=
									</p>

									<a href="javascript:void(0)">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<g clip-path="url(#clip0_1043_2500)">
															<path
																	d="M11.4416 2.92422L12.9083 5.85755C13.1083 6.26589 13.6416 6.65755 14.0916 6.73255L16.7499 7.17422C18.4499 7.45755 18.8499 8.69089 17.6249 9.90755L15.5583 11.9742C15.2083 12.3242 15.0166 12.9992 15.1249 13.4826L15.7166 16.0409C16.1833 18.0659 15.1083 18.8492 13.3166 17.7909L10.8249 16.3159C10.3749 16.0492 9.63326 16.0492 9.17492 16.3159L6.68326 17.7909C4.89992 18.8492 3.81659 18.0576 4.28326 16.0409L4.87492 13.4826C4.98326 12.9992 4.79159 12.3242 4.44159 11.9742L2.37492 9.90755C1.15826 8.69089 1.54992 7.45755 3.24992 7.17422L5.90826 6.73255C6.34992 6.65755 6.88326 6.26589 7.08326 5.85755L8.54992 2.92422C9.34992 1.33255 10.6499 1.33255 11.4416 2.92422Z"
																	stroke="white" stroke-width="1.5" stroke-linecap="round"
																	stroke-linejoin="round"></path>
													</g>
													<defs>
															<clipPath id="clip0_1043_2500">
																	<rect width="20" height="20" fill="white"></rect>
															</clipPath>
													</defs>
											</svg>
											&nbsp;&nbsp;
											Add to favorites
									</a>

									<a href="javascript:void(0)">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
															d="M3.47507 12.7507L7.25007 16.5257C7.99675 17.2702 9.00816 17.6883 10.0626 17.6883C11.117 17.6883 12.1284 17.2702 12.8751 16.5257L16.5334 12.8674C17.2779 12.1207 17.696 11.1093 17.696 10.0549C17.696 9.0005 17.2779 7.98909 16.5334 7.24241L12.7501 3.47575C12.3589 3.0835 11.8898 2.77772 11.373 2.57819C10.8562 2.37866 10.3033 2.28982 9.75007 2.31741L5.58341 2.51741C3.91674 2.59241 2.59174 3.91741 2.50841 5.57575L2.30841 9.74241C2.25841 10.8674 2.68341 11.9591 3.47507 12.7507Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"
															stroke-linejoin="round"></path>
													<path
															d="M7.91659 10.0007C8.46912 10.0007 8.99902 9.78116 9.38972 9.39046C9.78043 8.99976 9.99992 8.46985 9.99992 7.91732C9.99992 7.36478 9.78043 6.83488 9.38972 6.44418C8.99902 6.05348 8.46912 5.83398 7.91659 5.83398C7.36405 5.83398 6.83415 6.05348 6.44345 6.44418C6.05275 6.83488 5.83325 7.36478 5.83325 7.91732C5.83325 8.46985 6.05275 8.99976 6.44345 9.39046C6.83415 9.78116 7.36405 10.0007 7.91659 10.0007Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
											</svg>
											&nbsp;&nbsp;
											Add Tag
									</a>
							</div>
					</div>
			</div>
	</div>
	<div class="col-lg-3 col-md-6 mt-2">
			<div class="row brand-div2" style="position: relative;">
					<div class="col-2 mt-3">
							<svg width="24" height="25" viewBox="0 0 24 25" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
											d="M23.5735 13.0404C23.5407 13.194 23.4783 13.3428 23.4167 13.486C23.2951 13.7676 23.1695 14.0476 23.0335 14.322C22.0167 16.3748 20.9847 18.4204 19.9703 20.4748C19.5743 21.2772 18.9519 21.6556 18.0567 21.6548C12.7055 21.6476 7.35429 21.65 2.00309 21.6524C1.42469 21.6524 0.829492 21.4044 0.559893 20.8636C0.411093 20.5652 0.562292 20.3028 0.692692 20.0308C0.796692 19.8132 0.900692 19.5964 1.00549 19.3788C1.21349 18.9444 1.42149 18.51 1.62949 18.0748C1.83749 17.6404 2.04549 17.2052 2.25269 16.7708C2.46069 16.3356 2.66789 15.9012 2.87509 15.466C3.08229 15.0308 3.28949 14.5956 3.49669 14.1604C3.70389 13.7252 3.91029 13.29 4.11749 12.8548C4.22629 12.626 4.33429 12.398 4.44309 12.1692C4.83429 11.3452 5.47589 10.9356 6.37909 10.9348C11.4439 10.9324 16.5079 10.9308 21.5727 10.9364C22.0591 10.9364 22.5511 11.0556 22.9239 11.382C23.2063 11.6292 23.4223 11.9604 23.5303 12.3204C23.5847 12.502 23.6103 12.6924 23.5975 12.882C23.5943 12.9356 23.5863 12.9884 23.5743 13.0404H23.5735Z"
											fill="white"></path>
									<path
											d="M0.408809 17.4766C0.400009 17.4646 0.399209 17.447 0.400809 17.4326C0.406409 17.3726 0.405609 17.3126 0.405609 17.2526C0.405609 13.2534 0.405609 9.25342 0.405609 5.25422C0.405609 4.23902 0.973609 3.67102 1.99041 3.67022C3.71841 3.67022 5.44641 3.67582 7.17441 3.66702C7.79921 3.66382 8.27521 3.90222 8.62961 4.41902C9.03921 5.01582 9.47361 5.59582 9.88721 6.19022C9.98721 6.33422 10.092 6.39262 10.272 6.39182C12.9736 6.38542 15.6752 6.38862 18.3768 6.38622C18.9816 6.38622 19.4728 6.59742 19.764 7.14702C19.856 7.32062 19.9128 7.53182 19.92 7.72782C19.9408 8.31582 19.9288 8.90462 19.9288 9.49342C19.9288 9.52942 19.9192 9.56542 19.9112 9.62302C19.8 9.62302 19.696 9.62302 19.592 9.62302C14.936 9.62302 10.28 9.62462 5.62401 9.62142C4.91121 9.62142 4.30321 9.83262 3.86801 10.423C3.76641 10.5614 3.68801 10.719 3.61361 10.875C2.59281 13.0094 1.57441 15.1446 0.555209 17.2798C0.540009 17.3118 0.524009 17.343 0.508809 17.375C0.494409 17.4046 0.483209 17.439 0.464009 17.467C0.452009 17.4846 0.425609 17.499 0.408809 17.4774V17.4766Z"
											fill="white"></path>
							</svg>

					</div>
					<div class="col-8 mt-2">
							<a style="text-decoration: none;"
									href="https://odnconnect.odndigital.com/your-assets-shoot-raw_images/NDkzMTA=">
									<p class="brand-text" id="lot_number493100">OD_BT_0440D_T20_J4_AW22_EC</p>
							</a>
					</div>
					<div class="col-2 mt-3">
							<i class="bi bi-three-dots-vertical test myButton"
									style="font-size:20px;color: #808080;" role="button"></i>
							<div class="myPopover" style="display: none;">
									<a
											href="https://odnconnect.odndigital.com/Shoot-lot-raw-sku-Images/MjI5Nw==/T0RfQlRfMDQ0MERfVDIwX0o0X0FXMjJfRUM=">
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

									<a href="javascript:void(0)"
											onclick="toggleSidebar(); set_date_time(493100); lots_details('NDkzMTA=' , 'sku' , 'Raw') ">
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
											<span id="lot_date493100">03-11-2022</span>
											<span id="lot_time493100">08:01 AM</span>
											<span
													id="image_src493100">https://odnconnect.odndigital.com/IMG/no_preview_available.jpg</span>
									</div>


									<a href="javascript:void(0)"
											onclick="copyUrlToClipboard('url_02297' , 'Shoot Lot WRC Sku Image' , 'Shoot WRC')">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
															d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"
															stroke-linejoin="round"></path>
											</svg>
											&nbsp;&nbsp;
											Share
									</a>
									<p class="d-none" id="url_02297">
											https://odnconnect.odndigital.com/Shoot-lot-raw-sku-Images/MjI5Nw==/T0RfQlRfMDQ0MERfVDIwX0o0X0FXMjJfRUM=
									</p>

									<a href="javascript:void(0)">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<g clip-path="url(#clip0_1043_2500)">
															<path
																	d="M11.4416 2.92422L12.9083 5.85755C13.1083 6.26589 13.6416 6.65755 14.0916 6.73255L16.7499 7.17422C18.4499 7.45755 18.8499 8.69089 17.6249 9.90755L15.5583 11.9742C15.2083 12.3242 15.0166 12.9992 15.1249 13.4826L15.7166 16.0409C16.1833 18.0659 15.1083 18.8492 13.3166 17.7909L10.8249 16.3159C10.3749 16.0492 9.63326 16.0492 9.17492 16.3159L6.68326 17.7909C4.89992 18.8492 3.81659 18.0576 4.28326 16.0409L4.87492 13.4826C4.98326 12.9992 4.79159 12.3242 4.44159 11.9742L2.37492 9.90755C1.15826 8.69089 1.54992 7.45755 3.24992 7.17422L5.90826 6.73255C6.34992 6.65755 6.88326 6.26589 7.08326 5.85755L8.54992 2.92422C9.34992 1.33255 10.6499 1.33255 11.4416 2.92422Z"
																	stroke="white" stroke-width="1.5" stroke-linecap="round"
																	stroke-linejoin="round"></path>
													</g>
													<defs>
															<clipPath id="clip0_1043_2500">
																	<rect width="20" height="20" fill="white"></rect>
															</clipPath>
													</defs>
											</svg>
											&nbsp;&nbsp;
											Add to favorites
									</a>

									<a href="javascript:void(0)">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
															d="M3.47507 12.7507L7.25007 16.5257C7.99675 17.2702 9.00816 17.6883 10.0626 17.6883C11.117 17.6883 12.1284 17.2702 12.8751 16.5257L16.5334 12.8674C17.2779 12.1207 17.696 11.1093 17.696 10.0549C17.696 9.0005 17.2779 7.98909 16.5334 7.24241L12.7501 3.47575C12.3589 3.0835 11.8898 2.77772 11.373 2.57819C10.8562 2.37866 10.3033 2.28982 9.75007 2.31741L5.58341 2.51741C3.91674 2.59241 2.59174 3.91741 2.50841 5.57575L2.30841 9.74241C2.25841 10.8674 2.68341 11.9591 3.47507 12.7507Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"
															stroke-linejoin="round"></path>
													<path
															d="M7.91659 10.0007C8.46912 10.0007 8.99902 9.78116 9.38972 9.39046C9.78043 8.99976 9.99992 8.46985 9.99992 7.91732C9.99992 7.36478 9.78043 6.83488 9.38972 6.44418C8.99902 6.05348 8.46912 5.83398 7.91659 5.83398C7.36405 5.83398 6.83415 6.05348 6.44345 6.44418C6.05275 6.83488 5.83325 7.36478 5.83325 7.91732C5.83325 8.46985 6.05275 8.99976 6.44345 9.39046C6.83415 9.78116 7.36405 10.0007 7.91659 10.0007Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
											</svg>
											&nbsp;&nbsp;
											Add Tag
									</a>
							</div>
					</div>
			</div>
	</div>
</div>

<!-- WRCs Section -->
<div class="row">
	<p class="fovourites-img-lot-sku-wrc-section">WRCs</p>
	<div class="col-lg-3 col-md-6 mt-2">
			<div class="accordion" id="accordionExample0">
					<div class="card z-depth-0 bordered">
							<div class="card-header card-header-style" id="headingOne0" background:="" #d1d1d1;="">
									<h5 class="mb-0">
											<a href="https://odnconnect.odndigital.com/your-assets-shoot-skus/MjI5Nw=="
													class="btn " type="button" data-toggle="collapse"
													data-target="#collapseOne0" aria-expanded="true"
													aria-controls="collapseOne0">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
															xmlns="http://www.w3.org/2000/svg">
															<path
																	d="M23.5736 12.3803C23.5408 12.5339 23.4784 12.6827 23.4168 12.8259C23.2952 13.1075 23.1696 13.3875 23.0336 13.6619C22.0168 15.7147 20.9848 17.7603 19.9704 19.8147C19.5744 20.6171 18.952 20.9955 18.0568 20.9947C12.7056 20.9875 7.35441 20.9899 2.00321 20.9923C1.42481 20.9923 0.829615 20.7443 0.560015 20.2035C0.411215 19.9051 0.562415 19.6427 0.692815 19.3707C0.796815 19.1531 0.900815 18.9363 1.00561 18.7187C1.21361 18.2843 1.42161 17.8499 1.62961 17.4147C1.83761 16.9803 2.04561 16.5451 2.25281 16.1107C2.46081 15.6755 2.66801 15.2411 2.87521 14.8059C3.08241 14.3707 3.28961 13.9355 3.49681 13.5003C3.70401 13.0651 3.91041 12.6299 4.11761 12.1947C4.22641 11.9659 4.33441 11.7379 4.44321 11.5091C4.83441 10.6851 5.47601 10.2755 6.37921 10.2747C11.444 10.2723 16.508 10.2707 21.5728 10.2763C22.0592 10.2763 22.5512 10.3955 22.924 10.7219C23.2064 10.9691 23.4224 11.3003 23.5304 11.6603C23.5848 11.8419 23.6104 12.0323 23.5976 12.2219C23.5944 12.2755 23.5864 12.3283 23.5744 12.3803H23.5736Z"
																	fill="white"></path>
															<path
																	d="M0.408809 16.8165C0.400009 16.8045 0.399209 16.7869 0.400809 16.7725C0.406409 16.7125 0.405609 16.6525 0.405609 16.5925C0.405609 12.5933 0.405609 8.59327 0.405609 4.59407C0.405609 3.57887 0.973609 3.01087 1.99041 3.01007C3.71841 3.01007 5.44641 3.01567 7.17441 3.00687C7.79921 3.00367 8.27521 3.24207 8.62961 3.75887C9.03921 4.35567 9.47361 4.93567 9.88721 5.53007C9.98721 5.67407 10.092 5.73247 10.272 5.73167C12.9736 5.72527 15.6752 5.72847 18.3768 5.72607C18.9816 5.72607 19.4728 5.93727 19.764 6.48687C19.856 6.66047 19.9128 6.87167 19.92 7.06767C19.9408 7.65567 19.9288 8.24447 19.9288 8.83327C19.9288 8.86927 19.9192 8.90527 19.9112 8.96287C19.8 8.96287 19.696 8.96287 19.592 8.96287C14.936 8.96287 10.28 8.96447 5.62401 8.96127C4.91121 8.96127 4.30321 9.17247 3.86801 9.76287C3.76641 9.90127 3.68801 10.0589 3.61361 10.2149C2.59281 12.3493 1.57441 14.4845 0.555209 16.6197C0.540009 16.6517 0.524009 16.6829 0.508809 16.7149C0.494409 16.7445 0.483209 16.7789 0.464009 16.8069C0.452009 16.8245 0.425609 16.8389 0.408809 16.8173V16.8165Z"
																	fill="white"></path>
													</svg>&nbsp;&nbsp;
													<span class="file-wrc-lot-no" id="lot_number22970">MSMnSES3562-A</span>
											</a>

											<span class="test btn myButton" role="button" style="float: right"> <i
															class="bi bi-three-dots-vertical"
															style="font-size:20px;color: #808080;"></i></span>

											<div class="myPopover" style="display: none;">
													<a
															href="https://odnconnect.odndigital.com/Shoot-lot-Edited-wrc-Images/MjI5Nw==">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942"
																			stroke="white" stroke-width="1.5" stroke-miterlimit="10"
																			stroke-linecap="round" stroke-linejoin="round"></path>
															</svg>&nbsp;
															Download
													</a>

													<a href="javascript:void(0)"
															onclick="toggleSidebar(); set_date_time(22970); lots_details('MjI5Nw==' , 'wrc' , 'Edited') ">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_1069_2515)">
																			<path
																					d="M9.99992 13.333L9.99992 9.16634M9.99992 1.66634C5.41658 1.66634 1.66658 5.41634 1.66658 9.99968C1.66659 14.583 5.41659 18.333 9.99992 18.333C14.5833 18.333 18.3333 14.583 18.3333 9.99967C18.3333 5.41634 14.5833 1.66634 9.99992 1.66634Z"
																					stroke="white" stroke-width="1.5" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																			<path d="M10.0042 6.66699L9.99665 6.66699" stroke="white"
																					stroke-width="2" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_1069_2515">
																					<rect width="20" height="20" fill="white"></rect>
																			</clipPath>
																	</defs>
															</svg>&nbsp;
															View Details
													</a>

													<div class="d-none">
															<span id="lot_date22970">03-11-2022</span>
															<span id="lot_time22970">08:17 AM</span>
															<span
																	id="image_src22970">https://odnconnect.odndigital.com/IMG/no_preview_available.jpg</span>
													</div>

													<a href="javascript:void(0)"
															onclick="copyUrlToClipboard('url_0' , 'Shoot Lot WRC Image' , 'Shoot WRC')">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"
																			stroke-linejoin="round"></path>
															</svg>&nbsp;
															Share
													</a>

													<p class="d-none" id="url_0">
															https://odnconnect.odndigital.com/Shoot-lot-Edited-wrc-Images/MjI5Nw==
													</p>

													<a href="javascript:void(0)">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_1069_2524)">
																			<path
																					d="M11.4416 2.9252L12.9083 5.85853C13.1083 6.26686 13.6416 6.65853 14.0916 6.73353L16.7499 7.1752C18.4499 7.45853 18.8499 8.69186 17.6249 9.90853L15.5583 11.9752C15.2083 12.3252 15.0166 13.0002 15.1249 13.4835L15.7166 16.0419C16.1833 18.0669 15.1083 18.8502 13.3166 17.7919L10.8249 16.3169C10.3749 16.0502 9.63326 16.0502 9.17492 16.3169L6.68326 17.7919C4.89992 18.8502 3.81659 18.0585 4.28326 16.0419L4.87492 13.4835C4.98326 13.0002 4.79159 12.3252 4.44159 11.9752L2.37492 9.90853C1.15826 8.69186 1.54992 7.45853 3.24992 7.1752L5.90826 6.73353C6.34992 6.65853 6.88326 6.26686 7.08326 5.85853L8.54992 2.9252C9.34992 1.33353 10.6499 1.33353 11.4416 2.9252Z"
																					stroke="white" stroke-width="1.5" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_1069_2524">
																					<rect width="20" height="20" fill="white"></rect>
																			</clipPath>
																	</defs>
															</svg>&nbsp;
															Add to favorites
													</a>
													<a href="javascript:void(0)">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M3.47507 12.7498L7.25007 16.5248C7.99675 17.2693 9.00816 17.6873 10.0626 17.6873C11.117 17.6873 12.1284 17.2693 12.8751 16.5248L16.5334 12.8664C17.2779 12.1198 17.696 11.1084 17.696 10.0539C17.696 8.99952 17.2779 7.98812 16.5334 7.24144L12.7501 3.47477C12.3589 3.08252 11.8898 2.77675 11.373 2.57722C10.8562 2.37769 10.3033 2.28884 9.75007 2.31644L5.58341 2.51644C3.91674 2.59144 2.59174 3.91644 2.50841 5.57477L2.30841 9.74144C2.25841 10.8664 2.68341 11.9581 3.47507 12.7498Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"
																			stroke-linejoin="round"></path>
																	<path
																			d="M7.91659 9.99967C8.46912 9.99967 8.99902 9.78018 9.38972 9.38948C9.78043 8.99878 9.99992 8.46888 9.99992 7.91634C9.99992 7.36381 9.78043 6.8339 9.38972 6.4432C8.99902 6.0525 8.46912 5.83301 7.91659 5.83301C7.36405 5.83301 6.83415 6.0525 6.44345 6.4432C6.05275 6.8339 5.83325 7.36381 5.83325 7.91634C5.83325 8.46888 6.05275 8.99878 6.44345 9.38948C6.83415 9.78018 7.36405 9.99967 7.91659 9.99967Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
															</svg> &nbsp;
															Add Tag
													</a>
											</div>
									</h5>
							</div>

							<div id="collapseOne0" class="collapse show" aria-labelledby="headingOne0"
									data-parent="#">
									<div class="card-body card-body-style">
											<div class="col-12">
													<p class="TAGS">TAGS
															<svg width="14" height="14" viewBox="0 0 14 14" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_92_3135)">
																			<path
																					d="M7.00004 9.33301L7.00004 6.41634M7.00004 1.16634C3.79171 1.16634 1.16671 3.79134 1.16671 6.99968C1.16671 10.208 3.79171 12.833 7.00004 12.833C10.2084 12.833 12.8334 10.208 12.8334 6.99967C12.8334 3.79134 10.2084 1.16634 7.00004 1.16634Z"
																					stroke="#9F9F9F" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																			<path d="M7.00293 4.66699L6.99493 4.66699" stroke="#9F9F9F"
																					stroke-linecap="round" stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_92_3135">
																					<rect width="14" height="14" fill="white"
																							transform="translate(14 14) rotate(180)"></rect>
																			</clipPath>
																	</defs>
															</svg>
													</p>
											</div>
											<div class="row">
													<div class="col-4">
															<button type="button" class="btn btn-sm under-acco-button">Black
																	Tees</button>
													</div>
													<div class="col-4">
															<button type="button" class="btn btn-sm under-acco-button">FSN
																	code</button>
													</div>
													<div class="col-4">
															<button type="button" class="btn btn-sm under-acco-button">ASIN
																	code</button>
													</div>
											</div>
									</div>
							</div>
					</div>
			</div>
	</div>
	<div class="col-lg-3 col-md-6 mt-2">
			<div class="accordion" id="accordionExample0">
					<div class="card z-depth-0 bordered">
							<div class="card-header card-header-style" id="headingOne0" background:="" #d1d1d1;="">
									<h5 class="mb-0">
											<a href="https://odnconnect.odndigital.com/your-assets-shoot-skus/MjI5Nw=="
													class="btn " type="button" data-toggle="collapse"
													data-target="#collapseOne0" aria-expanded="true"
													aria-controls="collapseOne0">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
															xmlns="http://www.w3.org/2000/svg">
															<path
																	d="M23.5736 12.3803C23.5408 12.5339 23.4784 12.6827 23.4168 12.8259C23.2952 13.1075 23.1696 13.3875 23.0336 13.6619C22.0168 15.7147 20.9848 17.7603 19.9704 19.8147C19.5744 20.6171 18.952 20.9955 18.0568 20.9947C12.7056 20.9875 7.35441 20.9899 2.00321 20.9923C1.42481 20.9923 0.829615 20.7443 0.560015 20.2035C0.411215 19.9051 0.562415 19.6427 0.692815 19.3707C0.796815 19.1531 0.900815 18.9363 1.00561 18.7187C1.21361 18.2843 1.42161 17.8499 1.62961 17.4147C1.83761 16.9803 2.04561 16.5451 2.25281 16.1107C2.46081 15.6755 2.66801 15.2411 2.87521 14.8059C3.08241 14.3707 3.28961 13.9355 3.49681 13.5003C3.70401 13.0651 3.91041 12.6299 4.11761 12.1947C4.22641 11.9659 4.33441 11.7379 4.44321 11.5091C4.83441 10.6851 5.47601 10.2755 6.37921 10.2747C11.444 10.2723 16.508 10.2707 21.5728 10.2763C22.0592 10.2763 22.5512 10.3955 22.924 10.7219C23.2064 10.9691 23.4224 11.3003 23.5304 11.6603C23.5848 11.8419 23.6104 12.0323 23.5976 12.2219C23.5944 12.2755 23.5864 12.3283 23.5744 12.3803H23.5736Z"
																	fill="white"></path>
															<path
																	d="M0.408809 16.8165C0.400009 16.8045 0.399209 16.7869 0.400809 16.7725C0.406409 16.7125 0.405609 16.6525 0.405609 16.5925C0.405609 12.5933 0.405609 8.59327 0.405609 4.59407C0.405609 3.57887 0.973609 3.01087 1.99041 3.01007C3.71841 3.01007 5.44641 3.01567 7.17441 3.00687C7.79921 3.00367 8.27521 3.24207 8.62961 3.75887C9.03921 4.35567 9.47361 4.93567 9.88721 5.53007C9.98721 5.67407 10.092 5.73247 10.272 5.73167C12.9736 5.72527 15.6752 5.72847 18.3768 5.72607C18.9816 5.72607 19.4728 5.93727 19.764 6.48687C19.856 6.66047 19.9128 6.87167 19.92 7.06767C19.9408 7.65567 19.9288 8.24447 19.9288 8.83327C19.9288 8.86927 19.9192 8.90527 19.9112 8.96287C19.8 8.96287 19.696 8.96287 19.592 8.96287C14.936 8.96287 10.28 8.96447 5.62401 8.96127C4.91121 8.96127 4.30321 9.17247 3.86801 9.76287C3.76641 9.90127 3.68801 10.0589 3.61361 10.2149C2.59281 12.3493 1.57441 14.4845 0.555209 16.6197C0.540009 16.6517 0.524009 16.6829 0.508809 16.7149C0.494409 16.7445 0.483209 16.7789 0.464009 16.8069C0.452009 16.8245 0.425609 16.8389 0.408809 16.8173V16.8165Z"
																	fill="white"></path>
													</svg>&nbsp;&nbsp;
													<span class="file-wrc-lot-no" id="lot_number22970">MSMnSES3562-A</span>
											</a>

											<span class="test btn myButton" role="button" style="float: right"> <i
															class="bi bi-three-dots-vertical"
															style="font-size:20px;color: #808080;"></i></span>

											<div class="myPopover" style="display: none;">
													<a
															href="https://odnconnect.odndigital.com/Shoot-lot-Edited-wrc-Images/MjI5Nw==">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942"
																			stroke="white" stroke-width="1.5" stroke-miterlimit="10"
																			stroke-linecap="round" stroke-linejoin="round"></path>
															</svg>&nbsp;
															Download
													</a>

													<a href="javascript:void(0)"
															onclick="toggleSidebar(); set_date_time(22970); lots_details('MjI5Nw==' , 'wrc' , 'Edited') ">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_1069_2515)">
																			<path
																					d="M9.99992 13.333L9.99992 9.16634M9.99992 1.66634C5.41658 1.66634 1.66658 5.41634 1.66658 9.99968C1.66659 14.583 5.41659 18.333 9.99992 18.333C14.5833 18.333 18.3333 14.583 18.3333 9.99967C18.3333 5.41634 14.5833 1.66634 9.99992 1.66634Z"
																					stroke="white" stroke-width="1.5" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																			<path d="M10.0042 6.66699L9.99665 6.66699" stroke="white"
																					stroke-width="2" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_1069_2515">
																					<rect width="20" height="20" fill="white"></rect>
																			</clipPath>
																	</defs>
															</svg>&nbsp;
															View Details
													</a>

													<div class="d-none">
															<span id="lot_date22970">03-11-2022</span>
															<span id="lot_time22970">08:17 AM</span>
															<span
																	id="image_src22970">https://odnconnect.odndigital.com/IMG/no_preview_available.jpg</span>
													</div>

													<a href="javascript:void(0)"
															onclick="copyUrlToClipboard('url_0' , 'Shoot Lot WRC Image' , 'Shoot WRC')">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"
																			stroke-linejoin="round"></path>
															</svg>&nbsp;
															Share
													</a>

													<p class="d-none" id="url_0">
															https://odnconnect.odndigital.com/Shoot-lot-Edited-wrc-Images/MjI5Nw==
													</p>

													<a href="javascript:void(0)">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_1069_2524)">
																			<path
																					d="M11.4416 2.9252L12.9083 5.85853C13.1083 6.26686 13.6416 6.65853 14.0916 6.73353L16.7499 7.1752C18.4499 7.45853 18.8499 8.69186 17.6249 9.90853L15.5583 11.9752C15.2083 12.3252 15.0166 13.0002 15.1249 13.4835L15.7166 16.0419C16.1833 18.0669 15.1083 18.8502 13.3166 17.7919L10.8249 16.3169C10.3749 16.0502 9.63326 16.0502 9.17492 16.3169L6.68326 17.7919C4.89992 18.8502 3.81659 18.0585 4.28326 16.0419L4.87492 13.4835C4.98326 13.0002 4.79159 12.3252 4.44159 11.9752L2.37492 9.90853C1.15826 8.69186 1.54992 7.45853 3.24992 7.1752L5.90826 6.73353C6.34992 6.65853 6.88326 6.26686 7.08326 5.85853L8.54992 2.9252C9.34992 1.33353 10.6499 1.33353 11.4416 2.9252Z"
																					stroke="white" stroke-width="1.5" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_1069_2524">
																					<rect width="20" height="20" fill="white"></rect>
																			</clipPath>
																	</defs>
															</svg>&nbsp;
															Add to favorites
													</a>
													<a href="javascript:void(0)">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M3.47507 12.7498L7.25007 16.5248C7.99675 17.2693 9.00816 17.6873 10.0626 17.6873C11.117 17.6873 12.1284 17.2693 12.8751 16.5248L16.5334 12.8664C17.2779 12.1198 17.696 11.1084 17.696 10.0539C17.696 8.99952 17.2779 7.98812 16.5334 7.24144L12.7501 3.47477C12.3589 3.08252 11.8898 2.77675 11.373 2.57722C10.8562 2.37769 10.3033 2.28884 9.75007 2.31644L5.58341 2.51644C3.91674 2.59144 2.59174 3.91644 2.50841 5.57477L2.30841 9.74144C2.25841 10.8664 2.68341 11.9581 3.47507 12.7498Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"
																			stroke-linejoin="round"></path>
																	<path
																			d="M7.91659 9.99967C8.46912 9.99967 8.99902 9.78018 9.38972 9.38948C9.78043 8.99878 9.99992 8.46888 9.99992 7.91634C9.99992 7.36381 9.78043 6.8339 9.38972 6.4432C8.99902 6.0525 8.46912 5.83301 7.91659 5.83301C7.36405 5.83301 6.83415 6.0525 6.44345 6.4432C6.05275 6.8339 5.83325 7.36381 5.83325 7.91634C5.83325 8.46888 6.05275 8.99878 6.44345 9.38948C6.83415 9.78018 7.36405 9.99967 7.91659 9.99967Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
															</svg> &nbsp;
															Add Tag
													</a>
											</div>
									</h5>
							</div>

							<div id="collapseOne0" class="collapse show" aria-labelledby="headingOne0"
									data-parent="#">
									<div class="card-body card-body-style">
											<div class="col-12">
													<p class="TAGS">TAGS
															<svg width="14" height="14" viewBox="0 0 14 14" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_92_3135)">
																			<path
																					d="M7.00004 9.33301L7.00004 6.41634M7.00004 1.16634C3.79171 1.16634 1.16671 3.79134 1.16671 6.99968C1.16671 10.208 3.79171 12.833 7.00004 12.833C10.2084 12.833 12.8334 10.208 12.8334 6.99967C12.8334 3.79134 10.2084 1.16634 7.00004 1.16634Z"
																					stroke="#9F9F9F" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																			<path d="M7.00293 4.66699L6.99493 4.66699" stroke="#9F9F9F"
																					stroke-linecap="round" stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_92_3135">
																					<rect width="14" height="14" fill="white"
																							transform="translate(14 14) rotate(180)"></rect>
																			</clipPath>
																	</defs>
															</svg>
													</p>
											</div>
											<div class="row">
													<div class="col-4">
															<button type="button" class="btn btn-sm under-acco-button">Black
																	Tees</button>
													</div>
													<div class="col-4">
															<button type="button" class="btn btn-sm under-acco-button">FSN
																	code</button>
													</div>
													<div class="col-4">
															<button type="button" class="btn btn-sm under-acco-button">ASIN
																	code</button>
													</div>
											</div>
									</div>
							</div>
					</div>
			</div>
	</div>
	<div class="col-lg-3 col-md-6 mt-2">
			<div class="accordion" id="accordionExample0">
					<div class="card z-depth-0 bordered">
							<div class="card-header card-header-style" id="headingOne0" background:="" #d1d1d1;="">
									<h5 class="mb-0">
											<a href="https://odnconnect.odndigital.com/your-assets-shoot-skus/MjI5Nw=="
													class="btn " type="button" data-toggle="collapse"
													data-target="#collapseOne0" aria-expanded="true"
													aria-controls="collapseOne0">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
															xmlns="http://www.w3.org/2000/svg">
															<path
																	d="M23.5736 12.3803C23.5408 12.5339 23.4784 12.6827 23.4168 12.8259C23.2952 13.1075 23.1696 13.3875 23.0336 13.6619C22.0168 15.7147 20.9848 17.7603 19.9704 19.8147C19.5744 20.6171 18.952 20.9955 18.0568 20.9947C12.7056 20.9875 7.35441 20.9899 2.00321 20.9923C1.42481 20.9923 0.829615 20.7443 0.560015 20.2035C0.411215 19.9051 0.562415 19.6427 0.692815 19.3707C0.796815 19.1531 0.900815 18.9363 1.00561 18.7187C1.21361 18.2843 1.42161 17.8499 1.62961 17.4147C1.83761 16.9803 2.04561 16.5451 2.25281 16.1107C2.46081 15.6755 2.66801 15.2411 2.87521 14.8059C3.08241 14.3707 3.28961 13.9355 3.49681 13.5003C3.70401 13.0651 3.91041 12.6299 4.11761 12.1947C4.22641 11.9659 4.33441 11.7379 4.44321 11.5091C4.83441 10.6851 5.47601 10.2755 6.37921 10.2747C11.444 10.2723 16.508 10.2707 21.5728 10.2763C22.0592 10.2763 22.5512 10.3955 22.924 10.7219C23.2064 10.9691 23.4224 11.3003 23.5304 11.6603C23.5848 11.8419 23.6104 12.0323 23.5976 12.2219C23.5944 12.2755 23.5864 12.3283 23.5744 12.3803H23.5736Z"
																	fill="white"></path>
															<path
																	d="M0.408809 16.8165C0.400009 16.8045 0.399209 16.7869 0.400809 16.7725C0.406409 16.7125 0.405609 16.6525 0.405609 16.5925C0.405609 12.5933 0.405609 8.59327 0.405609 4.59407C0.405609 3.57887 0.973609 3.01087 1.99041 3.01007C3.71841 3.01007 5.44641 3.01567 7.17441 3.00687C7.79921 3.00367 8.27521 3.24207 8.62961 3.75887C9.03921 4.35567 9.47361 4.93567 9.88721 5.53007C9.98721 5.67407 10.092 5.73247 10.272 5.73167C12.9736 5.72527 15.6752 5.72847 18.3768 5.72607C18.9816 5.72607 19.4728 5.93727 19.764 6.48687C19.856 6.66047 19.9128 6.87167 19.92 7.06767C19.9408 7.65567 19.9288 8.24447 19.9288 8.83327C19.9288 8.86927 19.9192 8.90527 19.9112 8.96287C19.8 8.96287 19.696 8.96287 19.592 8.96287C14.936 8.96287 10.28 8.96447 5.62401 8.96127C4.91121 8.96127 4.30321 9.17247 3.86801 9.76287C3.76641 9.90127 3.68801 10.0589 3.61361 10.2149C2.59281 12.3493 1.57441 14.4845 0.555209 16.6197C0.540009 16.6517 0.524009 16.6829 0.508809 16.7149C0.494409 16.7445 0.483209 16.7789 0.464009 16.8069C0.452009 16.8245 0.425609 16.8389 0.408809 16.8173V16.8165Z"
																	fill="white"></path>
													</svg>&nbsp;&nbsp;
													<span class="file-wrc-lot-no" id="lot_number22970">MSMnSES3562-A</span>
											</a>

											<span class="test btn myButton" role="button" style="float: right"> <i
															class="bi bi-three-dots-vertical"
															style="font-size:20px;color: #808080;"></i></span>

											<div class="myPopover" style="display: none;">
													<a
															href="https://odnconnect.odndigital.com/Shoot-lot-Edited-wrc-Images/MjI5Nw==">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942"
																			stroke="white" stroke-width="1.5" stroke-miterlimit="10"
																			stroke-linecap="round" stroke-linejoin="round"></path>
															</svg>&nbsp;
															Download
													</a>

													<a href="javascript:void(0)"
															onclick="toggleSidebar(); set_date_time(22970); lots_details('MjI5Nw==' , 'wrc' , 'Edited') ">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_1069_2515)">
																			<path
																					d="M9.99992 13.333L9.99992 9.16634M9.99992 1.66634C5.41658 1.66634 1.66658 5.41634 1.66658 9.99968C1.66659 14.583 5.41659 18.333 9.99992 18.333C14.5833 18.333 18.3333 14.583 18.3333 9.99967C18.3333 5.41634 14.5833 1.66634 9.99992 1.66634Z"
																					stroke="white" stroke-width="1.5" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																			<path d="M10.0042 6.66699L9.99665 6.66699" stroke="white"
																					stroke-width="2" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_1069_2515">
																					<rect width="20" height="20" fill="white"></rect>
																			</clipPath>
																	</defs>
															</svg>&nbsp;
															View Details
													</a>

													<div class="d-none">
															<span id="lot_date22970">03-11-2022</span>
															<span id="lot_time22970">08:17 AM</span>
															<span
																	id="image_src22970">https://odnconnect.odndigital.com/IMG/no_preview_available.jpg</span>
													</div>

													<a href="javascript:void(0)"
															onclick="copyUrlToClipboard('url_0' , 'Shoot Lot WRC Image' , 'Shoot WRC')">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"
																			stroke-linejoin="round"></path>
															</svg>&nbsp;
															Share
													</a>

													<p class="d-none" id="url_0">
															https://odnconnect.odndigital.com/Shoot-lot-Edited-wrc-Images/MjI5Nw==
													</p>

													<a href="javascript:void(0)">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_1069_2524)">
																			<path
																					d="M11.4416 2.9252L12.9083 5.85853C13.1083 6.26686 13.6416 6.65853 14.0916 6.73353L16.7499 7.1752C18.4499 7.45853 18.8499 8.69186 17.6249 9.90853L15.5583 11.9752C15.2083 12.3252 15.0166 13.0002 15.1249 13.4835L15.7166 16.0419C16.1833 18.0669 15.1083 18.8502 13.3166 17.7919L10.8249 16.3169C10.3749 16.0502 9.63326 16.0502 9.17492 16.3169L6.68326 17.7919C4.89992 18.8502 3.81659 18.0585 4.28326 16.0419L4.87492 13.4835C4.98326 13.0002 4.79159 12.3252 4.44159 11.9752L2.37492 9.90853C1.15826 8.69186 1.54992 7.45853 3.24992 7.1752L5.90826 6.73353C6.34992 6.65853 6.88326 6.26686 7.08326 5.85853L8.54992 2.9252C9.34992 1.33353 10.6499 1.33353 11.4416 2.9252Z"
																					stroke="white" stroke-width="1.5" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_1069_2524">
																					<rect width="20" height="20" fill="white"></rect>
																			</clipPath>
																	</defs>
															</svg>&nbsp;
															Add to favorites
													</a>
													<a href="javascript:void(0)">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																			d="M3.47507 12.7498L7.25007 16.5248C7.99675 17.2693 9.00816 17.6873 10.0626 17.6873C11.117 17.6873 12.1284 17.2693 12.8751 16.5248L16.5334 12.8664C17.2779 12.1198 17.696 11.1084 17.696 10.0539C17.696 8.99952 17.2779 7.98812 16.5334 7.24144L12.7501 3.47477C12.3589 3.08252 11.8898 2.77675 11.373 2.57722C10.8562 2.37769 10.3033 2.28884 9.75007 2.31644L5.58341 2.51644C3.91674 2.59144 2.59174 3.91644 2.50841 5.57477L2.30841 9.74144C2.25841 10.8664 2.68341 11.9581 3.47507 12.7498Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"
																			stroke-linejoin="round"></path>
																	<path
																			d="M7.91659 9.99967C8.46912 9.99967 8.99902 9.78018 9.38972 9.38948C9.78043 8.99878 9.99992 8.46888 9.99992 7.91634C9.99992 7.36381 9.78043 6.8339 9.38972 6.4432C8.99902 6.0525 8.46912 5.83301 7.91659 5.83301C7.36405 5.83301 6.83415 6.0525 6.44345 6.4432C6.05275 6.8339 5.83325 7.36381 5.83325 7.91634C5.83325 8.46888 6.05275 8.99878 6.44345 9.38948C6.83415 9.78018 7.36405 9.99967 7.91659 9.99967Z"
																			stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
															</svg> &nbsp;
															Add Tag
													</a>
											</div>
									</h5>
							</div>

							<div id="collapseOne0" class="collapse show" aria-labelledby="headingOne0"
									data-parent="#">
									<div class="card-body card-body-style">
											<div class="col-12">
													<p class="TAGS">TAGS
															<svg width="14" height="14" viewBox="0 0 14 14" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_92_3135)">
																			<path
																					d="M7.00004 9.33301L7.00004 6.41634M7.00004 1.16634C3.79171 1.16634 1.16671 3.79134 1.16671 6.99968C1.16671 10.208 3.79171 12.833 7.00004 12.833C10.2084 12.833 12.8334 10.208 12.8334 6.99967C12.8334 3.79134 10.2084 1.16634 7.00004 1.16634Z"
																					stroke="#9F9F9F" stroke-linecap="round"
																					stroke-linejoin="round"></path>
																			<path d="M7.00293 4.66699L6.99493 4.66699" stroke="#9F9F9F"
																					stroke-linecap="round" stroke-linejoin="round"></path>
																	</g>
																	<defs>
																			<clipPath id="clip0_92_3135">
																					<rect width="14" height="14" fill="white"
																							transform="translate(14 14) rotate(180)"></rect>
																			</clipPath>
																	</defs>
															</svg>
													</p>
											</div>
											<div class="row">
													<div class="col-4">
															<button type="button" class="btn btn-sm under-acco-button">Black
																	Tees</button>
													</div>
													<div class="col-4">
															<button type="button" class="btn btn-sm under-acco-button">FSN
																	code</button>
													</div>
													<div class="col-4">
															<button type="button" class="btn btn-sm under-acco-button">ASIN
																	code</button>
													</div>
											</div>
									</div>
							</div>
					</div>
			</div>
	</div>
</div>
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
@endsection
