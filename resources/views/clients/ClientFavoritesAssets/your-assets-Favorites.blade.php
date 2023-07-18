@extends('layouts.DamNewMain')
@section('title')
  Your Assets - Favorites
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
			display:flex !important;
			align-items:center;
			gap:16px
		}

		a {
			color: #0d6efd;
			text-decoration: none;
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
		$files_lots = $data_array['files_lots'];
		$link_lots = $data_array['link_lots'];
		$skus_data = $data_array['skus_data'];
		$wrc_data = $data_array['wrc_data'];
		$shoot_images = $images_array['shoot_images'];
		$editing_images = $images_array['editing_images'];
		// dd($wrc_data);

	@endphp

	{{-- Sort by  --}}
	<?php 
	$lot_status_is = $sortBy = $lot_status_val = "" ;
		if(isset($other_data)){
			if(isset($other_data['sortBy'])){
				$sortBy = $other_data['sortBy'];
			}
		}
	?>

	<div class="row">
		<div class=" col-12 d-flex justify-content-between">
				<h4 class="headingF">
						Your Assets
				</h4>
				<div class="dropdown mt-2">
					<a class="btn rounded-0 sort-by-button  dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						Sort &nbsp;&nbsp;&nbsp;&nbsp;
					</a>
					<ul class="dropdown-menu dropdown-menu-show-sortby">
						<li><a class="dropdown-item dropdown-menu-show-sortby-item {{($sortBy == 'latest' || $sortBy == 'newest') ? 'active' : ''}}" href="{{route('your_assets_Favorites', ['sortBy' => 'latest' ])}}">Newest</a></li>
						<li><a class="dropdown-item dropdown-menu-show-sortby-item {{($sortBy == 'oldest' || $sortBy == 'old')  ? 'active' : ''}}" href="{{route('your_assets_Favorites', ['sortBy' => 'oldest' ] )}}">Oldest</a></li>
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
	@include('clients.ClientFavoritesAssets.your-assets-Favorites-images')

	<!-- SKUs Section -->
	@include('clients.ClientFavoritesAssets.your-assets-Favorites-skus')
	
	<!-- WRCs Section -->
	@include('clients.ClientFavoritesAssets.your-assets-Favorites-wrcs')
	
	<!-- Lots Section -->
	@include('clients.ClientFavoritesAssets.your-assets-Favorites-lots')
	
	<!-- sidebar popup start -->
	<div class="sidebar">
		<div id="sidebar_one" class="row sidebar-row-where-content">
			<div class="col-12 d-flex justify-content-between">
				<div class="row">
					<div class="col-11">
						 <p class="side-lot" id="lot_number"></p>
					</div>
					<div class="col-1">
						 <button onclick="toggleSidebar()" type="button" class="btn border-0 close-button">
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M14.19 0H5.81C2.17 0 0 2.17 0 5.81V14.18C0 17.83 2.17 20 5.81 20H14.18C17.82 20 19.99 17.83 19.99 14.19V5.81C20 2.17 17.83 0 14.19 0ZM13.36 12.3C13.65 12.59 13.65 13.07 13.36 13.36C13.21 13.51 13.02 13.58 12.83 13.58C12.64 13.58 12.45 13.51 12.3 13.36L10 11.06L7.7 13.36C7.55 13.51 7.36 13.58 7.17 13.58C6.98 13.58 6.79 13.51 6.64 13.36C6.50052 13.2189 6.4223 13.0284 6.4223 12.83C6.4223 12.6316 6.50052 12.4411 6.64 12.3L8.94 10L6.64 7.7C6.50052 7.55886 6.4223 7.36843 6.4223 7.17C6.4223 6.97157 6.50052 6.78114 6.64 6.64C6.93 6.35 7.41 6.35 7.7 6.64L10 8.94L12.3 6.64C12.59 6.35 13.07 6.35 13.36 6.64C13.65 6.93 13.65 7.41 13.36 7.7L11.06 10L13.36 12.3Z" fill="white"></path>
							</svg>
						</button>
				 	</div>
				</div>
			</div>

			<div class="col-12 wrc-detail-img assets_share ">
				<div class="row">
					<div class="col-12 " style="margin-top: 16px;">
						<img id="image_src" src="{{asset('IMG/group_10.png')}}" alt="" class="img-fluid" style="background: rgba(255, 255, 255, 0.1);">
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="row">
					<div class="col-12 assets_share " style="margin-top: 24px;">
						<p class="heading-details">Folder details</p>
					</div>
					<div class="col-11 ">
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
					<div class="col-12 assets_share">
						<p class="side-text">SIZE</p>
						<P class="side-text2" id="file_size"></P>
					</div>
					{{-- wrc_numbers --}}
					<div class="col-11">
						<p class="side-text">WRC</p>
						<P  id="wrc_numbers" class="side-text2"></P>
					</div>
					{{-- Shoot files other data --}}
					<div id="shoot_files_details" class="d-none">
						<div class="col-10">
							<div class="d-flex justify-content-between">
								<p class="side-text">SHOOT TYPE</p>
								<P class="side-text">SKU</P>
							</div>
							<div class="d-flex justify-content-between">
								<p id="s_type" class="side-text2"></p>
								<P id="skus_count" class="side-text2"></P>
							</div>
						</div>
						<div class="col-10">
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
					
					<div class="col-12 assets_share" style="margin-top: 24px;">
						<p class="heading-details">Share</p>
					</div>

					<div class="col-12 assets_share">
						<div class="url-copied-linkforviewdetails"  >
							<p class="url-copied-link-text"  id="target_copy_url"> </p>
							<span id="share_btn" data-id="" style="cursor: pointer" > 
								<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect width="30" height="30" rx="15" fill="#98A7DA" />
									<g clip-path="url(#clip0_2553_6415)">
											<path
													d="M18 15.675V18.825C18 21.45 16.95 22.5 14.325 22.5H11.175C8.55 22.5 7.5 21.45 7.5 18.825V15.675C7.5 13.05 8.55 12 11.175 12H14.325C16.95 12 18 13.05 18 15.675Z"
													stroke="#0F0F0F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
											<path
													d="M22.5 11.175V14.325C22.5 16.95 21.45 18 18.825 18H18V15.675C18 13.05 16.95 12 14.325 12H12V11.175C12 8.55 13.05 7.5 15.675 7.5H18.825C21.45 7.5 22.5 8.55 22.5 11.175Z"
													stroke="#0F0F0F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
									</g>
									<defs>
											<clipPath id="clip0_2553_6415">
													<rect width="18" height="18" fill="white" transform="translate(6 6)" />
											</clipPath>
									</defs>
								</svg>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		{{-- Multipal selected Case --}}
		<div id="sidebar_multi" class="row d-none">
			<div class="col-12 d-flex justify-content-between ps-4">
				<p class="mt-3 side-lot">DEMO1TWSR9-A</p>
				<button onclick="toggleSidebar()" type="button" class="btn border-0 close-button">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M14.19 0H5.81C2.17 0 0 2.17 0 5.81V14.18C0 17.83 2.17 20 5.81 20H14.18C17.82 20 19.99 17.83 19.99 14.19V5.81C20 2.17 17.83 0 14.19 0ZM13.36 12.3C13.65 12.59 13.65 13.07 13.36 13.36C13.21 13.51 13.02 13.58 12.83 13.58C12.64 13.58 12.45 13.51 12.3 13.36L10 11.06L7.7 13.36C7.55 13.51 7.36 13.58 7.17 13.58C6.98 13.58 6.79 13.51 6.64 13.36C6.50052 13.2189 6.4223 13.0284 6.4223 12.83C6.4223 12.6316 6.50052 12.4411 6.64 12.3L8.94 10L6.64 7.7C6.50052 7.55886 6.4223 7.36843 6.4223 7.17C6.4223 6.97157 6.50052 6.78114 6.64 6.64C6.93 6.35 7.41 6.35 7.7 6.64L10 8.94L12.3 6.64C12.59 6.35 13.07 6.35 13.36 6.64C13.65 6.93 13.65 7.41 13.36 7.7L11.06 10L13.36 12.3Z"
							fill="white" />
					</svg>
				</button>
			</div>
			<div style="margin-top: 170px;">
				<div class="col-12 text-center">
					<svg width="32" height="51" viewBox="0 0 32 51" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_2743_14877)">
							<path
								d="M6.47356 51.0001C5.91258 50.726 5.74946 50.2722 5.75609 49.6601C5.78792 46.6554 5.78394 43.6507 5.80383 40.646C5.80648 40.3413 5.74017 40.1244 5.48687 39.9248C2.57983 37.6267 1.03746 34.5621 0.739061 30.912C0.540131 28.4689 0.564002 26.0071 0.51228 23.5533C0.48443 22.1934 0.513606 20.8307 0.506975 19.4694C0.499018 17.8473 1.19527 16.6324 2.66471 15.9684C4.13281 15.3057 5.50544 15.5878 6.71361 16.6564C6.76268 16.7003 6.8144 16.7389 6.89662 16.8067C7.68041 16.0136 8.6061 15.5359 9.74133 15.5279C10.8646 15.52 11.7969 15.9511 12.6086 16.7628C14.0475 15.4042 15.6602 15.1527 17.4983 16.0682C17.5222 15.7209 17.5513 15.4175 17.5633 15.1114C17.7092 11.4627 17.8511 7.81394 18.0009 4.16519C18.0195 3.70211 18.0314 3.22971 18.1269 2.77861C18.4956 1.03141 20.0698 -0.0943488 21.9557 0.00678355C23.7633 0.102593 25.1637 1.39735 25.3613 3.16584C25.3958 3.47855 25.4078 3.79526 25.4078 4.1093C25.4157 9.52121 25.421 14.9318 25.4263 20.3437C25.4263 20.542 25.4263 20.7416 25.4263 21.045C25.9794 21.045 26.5218 20.9971 27.0536 21.053C29.7498 21.3404 31.3651 23.1448 31.4871 25.9605C31.5958 28.4596 30.9261 30.787 29.9036 33.0265C28.6265 35.8236 26.9488 38.34 24.4383 40.171C23.7527 40.6713 23.4954 41.1623 23.5458 41.986C23.6161 43.1264 23.567 44.2762 23.5617 45.4205C23.559 46.1431 23.1638 46.6009 22.567 46.5956C21.9769 46.5902 21.5777 46.1205 21.575 45.4059C21.5697 43.7292 21.575 42.0526 21.5711 40.3759C21.5711 39.9501 21.6745 39.5708 22.0618 39.3553C24.6598 37.9128 26.3348 35.6347 27.6676 33.0704C28.7631 30.9639 29.5323 28.7497 29.5057 26.3278C29.5044 26.1455 29.4991 25.9619 29.4766 25.7809C29.2246 23.8487 28.279 23.0197 26.3255 23.0171C22.7527 23.0131 19.1786 23.0104 15.6058 23.0091C14.4613 23.0091 13.6324 23.8275 13.6205 24.9639C13.6072 26.1335 14.4745 27.0464 15.6058 27.0491C18.1707 27.0544 20.7342 27.053 23.2991 27.0624C24.1107 27.065 24.5749 27.556 24.4449 28.252C24.3521 28.7457 23.9861 28.9413 23.5537 29.0784C22.1506 29.5255 20.8801 30.2201 19.7674 31.1915C18.2211 32.5435 17.3498 34.2348 17.2622 36.308C17.2556 36.457 17.2516 36.6074 17.233 36.7551C17.1588 37.3446 16.7543 37.7132 16.2119 37.6932C15.6681 37.6733 15.2225 37.2674 15.2729 36.6832C15.3538 35.7464 15.4493 34.7963 15.6947 33.8941C16.1787 32.1123 17.2569 30.6938 18.6561 29.5148C18.8019 29.3911 18.9465 29.2673 19.2011 29.0517C18.5632 29.0517 18.0593 29.0517 17.554 29.0517C16.8763 29.0517 16.1973 29.0544 15.5196 29.0517C14.6456 29.0477 14.2584 28.932 13.3433 28.4024C12.4428 30.107 11.0768 31.0464 9.11005 30.6991C7.20165 30.3625 6.20037 29.0823 5.90728 27.1435C4.7747 27.6918 3.65406 27.7157 2.48567 27.1781C2.55331 30.2507 2.71908 33.2248 4.40734 35.8609C5.12349 36.9787 6.06642 37.8862 7.11412 38.6779C7.61277 39.0545 7.81038 39.4923 7.80242 40.1178C7.76794 42.8736 7.76926 45.6281 7.75865 48.384C7.75865 48.565 7.75865 48.7473 7.75865 49.0028C7.97217 49.0028 8.16315 49.0028 8.35412 49.0028C11.5304 49.0028 14.7066 49.0001 17.8829 49.0041C18.794 49.0041 19.3245 49.7772 18.8961 50.4852C18.7741 50.6861 18.5579 50.8285 18.3855 50.9975H6.47356V51.0001ZM23.4384 21.0011C23.4384 20.8334 23.4384 20.7203 23.4384 20.6059C23.4317 15.0156 23.4251 9.42407 23.4171 3.83385C23.4171 3.70211 23.4118 3.56771 23.3946 3.4373C23.2832 2.55372 22.6506 2.01213 21.7262 2.00016C20.8005 1.98818 20.152 2.51913 20.0419 3.40536C19.9942 3.78328 19.9929 4.16652 19.977 4.5471C19.7886 9.12067 19.595 13.6956 19.4173 18.2705C19.3828 19.1727 19.412 20.0776 19.412 21.0011H23.437H23.4384ZM7.94167 23.1075H7.93106C7.93106 24.3504 7.9231 25.5933 7.93371 26.8361C7.943 27.9699 8.70158 28.775 9.74663 28.7843C10.7996 28.7936 11.6046 27.9672 11.6113 26.8228C11.6259 24.3704 11.6272 21.9179 11.6206 19.4655C11.6166 18.341 10.8394 17.5333 9.79438 17.5253C8.71617 17.5173 7.95361 18.3144 7.94432 19.4788C7.93504 20.6884 7.94167 21.898 7.94167 23.1075ZM2.49761 21.5892H2.49495C2.49495 22.3344 2.48965 23.0796 2.49495 23.8261C2.50291 24.7935 3.1753 25.5281 4.09038 25.58C4.98822 25.6305 5.79455 24.9346 5.8224 23.9725C5.86749 22.3996 5.87014 20.8254 5.83433 19.2525C5.81179 18.2918 5.03463 17.6091 4.11292 17.6331C3.18723 17.657 2.50822 18.3743 2.49761 19.3537C2.48965 20.0989 2.49628 20.844 2.49628 21.5906L2.49761 21.5892ZM17.2994 20.9918C17.2994 20.3969 17.3126 19.85 17.2967 19.3044C17.2702 18.3943 16.5898 17.6451 15.7159 17.536C14.7889 17.4215 13.8725 17.9471 13.7292 18.8627C13.5993 19.6877 13.7014 20.55 13.7014 21.4389C14.8233 20.7788 16.0594 21.1049 17.298 20.9918H17.2994Z"
								fill="#4D4D4D" />
							<path
								d="M22.2578 51C22.1676 50.9348 22.0748 50.8709 21.9859 50.8017C21.4939 50.4172 21.4329 49.7705 21.8454 49.326C22.2419 48.9015 22.8984 48.9042 23.2896 49.3327C23.6914 49.7731 23.6211 50.4385 23.1318 50.8084C23.0416 50.8763 22.9461 50.9361 22.8519 51H22.2565H22.2578Z"
								fill="#4D4D4D" />
						</g>
						<defs>
							<clipPath id="clip0_2743_14877">
								<rect width="31" height="51" fill="white" transform="translate(0.5)" />
							</clipPath>
						</defs>
					</svg>
				</div>
				<div class="col-12">
					<p
						style="margin-bottom: 0px; margin-top: 16px; color: var(--neutral-600, #4D4D4D);text-align: center; font-family: Poppins; font-size: 14px; font-style: normal; font-weight: 500; line-height: 20px; letter-spacing: 0.1px;">
						“One giant leap at a time”.
					</p>
					<p
						style="margin-bottom: 0px; margin-top: 8px;color: var(--neutral-600, #4D4D4D);text-align: center;font-family: Poppins;font-size: 12px;font-style: normal;font-weight: 400;line-height: 16px; letter-spacing: 0.4px;">
						Sorry, We can display only 1 item details at a time.
					</p>
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
		console.log('tooltipTriggerList', tooltipTriggerList)
		const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
		console.log('tooltipList', tooltipList)
	</script>

	{{-- Setting data and time in side bar --}}
	<script>
		const set_links_date_time = (key) => {
			console.log('key', key)
			
			const lot_number = $("#lot_number"+key).html()
			const lot_date = $("#lot_date"+key).html()
			const lot_time = $("#lot_time"+key).html()
			const file_size = $("#file_size"+key).html()
			
			console.log('lot_number', lot_number)
			$("#lot_number").html(lot_number)
			$("#lot_time").html(lot_time)
			$("#lot_date").html(lot_date)
			$("#wrc_numbers").html($("#wrc_numbers"+key).html())
			$('.assets_share').addClass('d-none')
			$("#shoot_files_details").addClass('d-none')
		}
	</script>

	{{-- Setting image data and time in side bar --}}
	<script>
		const set_image_date_time = (key , service = 'other') => {
			console.log('key', key)
			document.getElementById("share_btn").setAttribute("data-id", key);
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
			const target_url = $("#url_"+key).html()
			document.getElementById("share_btn").setAttribute("data-id", key);
			$("#target_copy_url").html(target_url)
			navigator.clipboard.writeText(target_url);
			
			
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
						$('#div_'+id).css({
							"pointer-events": "none",
							"opacity": 0.2
						});

						$('.added-notfav-div').removeClass('d-none');
						setTimeout(() => {
							$('.added-notfav-div').addClass('d-none');
						}, 2000);
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
