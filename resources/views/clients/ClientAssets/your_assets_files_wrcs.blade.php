@extends('layouts.DamNewMain')
@section('title')
  Your Assets - WRCs
@endsection

@section('css_links')
	<!-- Owl carausel link -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
@endsection

@section('other_css')
	<style>
		.adap-div {
			background: #1A1A1A;
		}

		.under-adap-div {
			display: flex;
			justify-content: space-between;
			padding: 16px;
			align-items:center;
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

<style>
	.accordion-header.active {
		color: rgb(175, 33, 204);
	}

	.accordion-icon.active {
		fill: blue;
	}

	.main-container-resp {
		background-color: #0F0F0F;
	}

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
		font-size: 12px;
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

	/* multiple folder selection style strat  */


	#folder-container {
		overflow: hidden;
	}

	.folder {
		position: relative;
		cursor: pointer;
	}

	.folder.selected {
		border: 1px solid var(--primary-700-main, #FFF300);
		background: var(--neutral-800, #1A1A1A);
		box-shadow: 0px 0px 72px 0px rgba(255, 248, 102, 0.15);
	}

	.folder-content {
		margin-top: 10px;
		padding-left: 20px;
		overflow: hidden;
	}

	#selectedFoldersCount {
		position: absolute;
		top: 58px;
		display: none;
		color: black;
	}

	#selectedFoldersCountText {
		color: #FFFFFF;
		font-size: 12px;
		font-weight: 500;
		line-height: 16px;
		letter-spacing: 0.5px;
	}

	#popoverfolderselect {
		position: absolute;
		top: 10px;
		display: none;
		width: auto;
	}


	.popover-item-container {
		display: flex;
		gap: 24px;
	}

	.popover-item {
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.popover-item-text {
		color: var(--shades-0, #FFF);
		cursor: pointer;
		font-size: 16px;
		font-family: Poppins;
		letter-spacing: 0.5px;
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
	$service_is; // get from controller and based on service_is route will be deside on wrc click 
	// dd($wrc_data , $service_is);
if($service_is == 'Shoot'){
	$route_is = 'your_assets_shoot_skus';
	$download_route_is = 'download_Shoot_lot_Edited_wrc';
}else{
	$route_is = 'your_assets_files_editing_uploaded_images';
	$download_route_is = 'download_Editing_lot_Edited_wrc';
}

@endphp

@if (count($wrc_data) > 0)
	<div class="row">
		<div class="col-12">
			<nav
				style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
				aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">{{$wrc_data[0]['lot_number']}}</li>
					<li class="breadcrumb-item active breadcrumb-deco" aria-current="page">WRCs</li>
				</ol>
			</nav>
		</div>
		<div class="col-12" style="margin-top: 40px;">
			<p style="font-weight: 500;font-size: 12px;color: #FFFFFF; margin-bottom: 0px">Total WRC : {{count($wrc_data)}}</p>
		</div>
	</div>


	{{-- WRCs details --}}
	<div class="row" id="folderContainer" style="margin-top: 12px; position:relative">
		
		@foreach ($wrc_data as $key => $row)
			@php
				$file_path = $row['file_path'];
				$shoot_image_src = 'IMG/no_preview_available.jpg';
				if($file_path != ''){
					$shoot_image_src = $file_path;
				}
			@endphp
			<div class="col-lg-3 col-md-6 wrc-file-div">
				<div class="selectedfolder{{$key+1}} folder">
					<div class="adap-div" style="position: relative;">
						{{-- wrc top section --}}
						<div class="under-adap-div">
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
									<span class="WRC-no-file" id="lot_number{{$row['wrc_id'].$key}}">{{$row['wrc_number']}}</span>
								</span>
							</a>
							<span class="adap-wrc-dots">
								<a href="javascript:void(0)" class=" test myButton" role="button"> <i class="bi bi-three-dots-vertical" style="font-size:20px;color: #808080;"></i></a>
							</span>
							{{-- <span class="adap-wrc-dots">
								<a href="javascript:void(0)" class=" test myButton" role="button"> <i class="bi bi-three-dots-vertical"
									style="font-size:20px;color: #808080;"></i></a>
							</span> --}}
						</div>
						{{-- myPopover Start --}}
						<div class="myPopover" style="z-index: 9; display: none;">
							@php
								$wrc_id_is = base64_encode($row['wrc_id']);
							@endphp
							<a data-wrc_id="{{base64_encode($row['wrc_id'])}}" data-download_route_is="{{$download_route_is}}" href="{{route($download_route_is , [ base64_encode($row['wrc_id']) ] )}}">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>&nbsp;
								Download
							</a>

							<a class="Download d-none" data-wrc_number="{{$row['wrc_number']}}" data-wrc_id="{{base64_encode($row['wrc_id'])}}" data-download_route_is="{{$download_route_is}}" href="{{route($download_route_is , [ base64_encode($row['wrc_id']) , 'multipal'] )}}">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>&nbsp;
								Download
							</a>
							
							@if ($service_is == 'Shoot')
								<a href="javascript:void(0)" onclick="toggleSidebar(); set_date_time({{$row['wrc_id'].$key}}); lots_details('{{ $wrc_id_is  }}' , 'wrc' , 'Edited') ">
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
								<a href="javascript:void(0)" onclick="toggleSidebar(); set_date_time({{$row['wrc_id'].$key}}); editing_lots_details('{{ $wrc_id_is  }}' , 'wrc' , 'Edited') ">
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
								<span id="lot_date{{$row['wrc_id'].$key}}">{{dateFormet_dmy($row['wrc_created_at'])}}</span>
								<span id="lot_time{{$row['wrc_id'].$key}}">{{date('h:i A', strtotime($row['wrc_created_at']))}}</span>
								<span id="image_src{{$row['wrc_id'].$key}}">{{asset($shoot_image_src)}}</span>
							</div>
		
							<a id="{{$row['wrc_id'].$key}}"  href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>&nbsp;
								Share
							</a>
		
							<p class="d-none" id="url_{{$key}}">{{route($download_route_is , [ base64_encode($row['wrc_id']) ] )}}</p>
		
							<?php 
								if ($service_is == 'Shoot'){
									$service = base64_encode('SHOOT');
								}else{
									$service = base64_encode('EDITING');
								}
							?>
							@php
								$module = base64_encode('wrc');
								$lot_id_is = base64_encode($row['lot_id']);
								$wrc_id_is = base64_encode($row['wrc_id']);
								$data_array = array(
									'user_id' => '', 
									'brand_id' => '', 
									'lot_id' => $lot_id_is, 
									'wrc_id' => $wrc_id_is,
									'service' => $service, 
									'module' => $module 
								);
		
								$data_obj = json_encode($data_array,true);
							@endphp
	
							{{-- Add to favorites --}}
							<a class="add_to_favorites_calss" data-data_obj="{{$data_obj}}" href="javascript:void(0)" onclick="add_to_favorites({{$data_obj}})">
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
	
							{{-- Add Tag --}}
							{{-- <a href="javascript:void(0)">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M3.47507 12.7498L7.25007 16.5248C7.99675 17.2693 9.00816 17.6873 10.0626 17.6873C11.117 17.6873 12.1284 17.2693 12.8751 16.5248L16.5334 12.8664C17.2779 12.1198 17.696 11.1084 17.696 10.0539C17.696 8.99952 17.2779 7.98812 16.5334 7.24144L12.7501 3.47477C12.3589 3.08252 11.8898 2.77675 11.373 2.57722C10.8562 2.37769 10.3033 2.28884 9.75007 2.31644L5.58341 2.51644C3.91674 2.59144 2.59174 3.91644 2.50841 5.57477L2.30841 9.74144C2.25841 10.8664 2.68341 11.9581 3.47507 12.7498Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M7.91659 9.99967C8.46912 9.99967 8.99902 9.78018 9.38972 9.38948C9.78043 8.99878 9.99992 8.46888 9.99992 7.91634C9.99992 7.36381 9.78043 6.8339 9.38972 6.4432C8.99902 6.0525 8.46912 5.83301 7.91659 5.83301C7.36405 5.83301 6.83415 6.0525 6.44345 6.4432C6.05275 6.8339 5.83325 7.36381 5.83325 7.91634C5.83325 8.46888 6.05275 8.99878 6.44345 9.38948C6.83415 9.78018 7.36405 9.99967 7.91659 9.99967Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
								</svg> &nbsp;
								Add Tag
							</a> --}}
						</div>
						{{-- myPopover End --}}
					</div>
					@if ($service_is == 'Shoot')
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
					@endif
				</div>
			</div>
		@endforeach

		<div class="col-12 col-lg-12 col-md-12 col-sm-12" style="position: relative">
			{{-- popoverpopoverfolderselect --}}
			<div id="popoverfolderselect" class="popoverpopoverfolderselect">
				<div class="popover-content">
					<div class="popover-item-container">
						{{-- Download --}}
						<div class="popover-item">
							<span>
								<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect width="40" height="40" rx="20" fill="#1A1A1A" />
									<path d="M25.0583 22.0253L20 27.0837L14.9417 22.0253M20 12.917V26.942" stroke="white"
										stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							</span>
							{{-- <span class="popover-item-text" >Download</span> --}}
							<span class="popover-item-text" onclick="download_mul_zip()">Download</span>
						</div>

						{{-- View details --}}
						<div class="popover-item">
							<span>
								<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect width="40" height="40" rx="20" fill="#1A1A1A" />
									<g clip-path="url(#clip0_2148_4279)">
										<path
											d="M19.9999 23.333L19.9999 19.1663M19.9999 11.6663C15.4166 11.6663 11.6666 15.4163 11.6666 19.9997C11.6666 24.583 15.4166 28.333 19.9999 28.333C24.5833 28.333 28.3333 24.583 28.3333 19.9997C28.3333 15.4163 24.5833 11.6663 19.9999 11.6663Z"
											stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
										<path d="M20.0042 16.667L19.9967 16.667" stroke="white" stroke-width="2" stroke-linecap="round"
											stroke-linejoin="round" />
									</g>
									<defs>
										<clipPath id="clip0_2148_4279">
											<rect width="20" height="20" fill="white" transform="translate(10 10)" />
										</clipPath>
									</defs>
								</svg>
							</span>
							<span class="popover-item-text">View details</span>
						</div>

						{{-- add_to_multipal_fav --}}
						<div class="popover-item">
							<span>
								<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect width="40" height="40" rx="20" fill="#1A1A1A" />
									<g clip-path="url(#clip0_2148_4250)">
										<path
											d="M21.4416 12.9252L22.9083 15.8585C23.1083 16.2669 23.6416 16.6585 24.0916 16.7335L26.7499 17.1752C28.4499 17.4585 28.8499 18.6919 27.6249 19.9085L25.5583 21.9752C25.2083 22.3252 25.0166 23.0002 25.1249 23.4835L25.7166 26.0419C26.1833 28.0669 25.1083 28.8502 23.3166 27.7919L20.8249 26.3169C20.3749 26.0502 19.6333 26.0502 19.1749 26.3169L16.6833 27.7919C14.8999 28.8502 13.8166 28.0585 14.2833 26.0419L14.8749 23.4835C14.9833 23.0002 14.7916 22.3252 14.4416 21.9752L12.3749 19.9085C11.1583 18.6919 11.5499 17.4585 13.2499 17.1752L15.9083 16.7335C16.3499 16.6585 16.8833 16.2669 17.0833 15.8585L18.5499 12.9252C19.3499 11.3335 20.6499 11.3335 21.4416 12.9252Z"
											stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
									</g>
									<defs>
										<clipPath id="clip0_2148_4250">
											<rect width="20" height="20" fill="white" transform="translate(10 10)" />
										</clipPath>
									</defs>
								</svg>
							</span>
							<span class="popover-item-text" onclick="add_to_multipal_fav()">Add to favorites</span>
						</div>

						{{-- Share --}}
						<div class="popover-item d-none">
							<span>
								<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect width="40" height="40" rx="20" fill="#1A1A1A" />
									<path
										d="M24.1335 15.1415C25.8002 16.2999 26.9502 18.1415 27.1835 20.2665M12.9085 20.3082C13.0133 19.2892 13.3353 18.3045 13.8528 17.4204C14.3703 16.5363 15.0713 15.7735 15.9085 15.1832M16.8252 27.4499C17.7918 27.9415 18.8918 28.2165 20.0502 28.2165C21.1668 28.2165 22.2168 27.9665 23.1585 27.5082M20.0502 16.4165C20.6646 16.4165 21.2538 16.1725 21.6883 15.738C22.1228 15.3035 22.3668 14.7143 22.3668 14.0999C22.3668 13.4855 22.1228 12.8962 21.6883 12.4617C21.2538 12.0273 20.6646 11.7832 20.0502 11.7832C19.4357 11.7832 18.8465 12.0273 18.412 12.4617C17.9776 12.8962 17.7335 13.4855 17.7335 14.0999C17.7335 14.7143 17.9776 15.3035 18.412 15.738C18.8465 16.1725 19.4357 16.4165 20.0502 16.4165ZM14.0252 26.5999C14.6396 26.5999 15.2288 26.3558 15.6633 25.9213C16.0978 25.4869 16.3418 24.8976 16.3418 24.2832C16.3418 23.6688 16.0978 23.0795 15.6633 22.6451C15.2288 22.2106 14.6396 21.9665 14.0252 21.9665C13.4107 21.9665 12.8215 22.2106 12.387 22.6451C11.9526 23.0795 11.7085 23.6688 11.7085 24.2832C11.7085 24.8976 11.9526 25.4869 12.387 25.9213C12.8215 26.3558 13.4107 26.5999 14.0252 26.5999ZM25.9752 26.5999C26.5896 26.5999 27.1788 26.3558 27.6133 25.9213C28.0478 25.4869 28.2918 24.8976 28.2918 24.2832C28.2918 23.6688 28.0478 23.0795 27.6133 22.6451C27.1788 22.2106 26.5896 21.9665 25.9752 21.9665C25.3607 21.9665 24.7715 22.2106 24.337 22.6451C23.9026 23.0795 23.6585 23.6688 23.6585 24.2832C23.6585 24.8976 23.9026 25.4869 24.337 25.9213C24.7715 26.3558 25.3607 26.5999 25.9752 26.5999Z"
										stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							</span>
							<span class="popover-item-text">Share</span>
						</div>
						
					</div>
				</div>
			</div>
			{{-- selectedFoldersCount --}}
			<div id="selectedFoldersCount">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<g clip-path="url(#clip0_968_3744)">
						<path
							d="M7.49984 18.3337H12.4998C16.6665 18.3337 18.3332 16.667 18.3332 12.5003V7.50033C18.3332 3.33366 16.6665 1.66699 12.4998 1.66699H7.49984C3.33317 1.66699 1.6665 3.33366 1.6665 7.50033V12.5003C1.6665 16.667 3.33317 18.3337 7.49984 18.3337Z"
							stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M6.4585 9.99993L8.81683 12.3583L13.5418 7.6416" stroke="white" stroke-width="1.5"
							stroke-linecap="round" stroke-linejoin="round" />
					</g>
					<defs>
						<clipPath id="clip0_968_3744">
							<rect width="20" height="20" fill="white" />
						</clipPath>
					</defs>
				</svg>
				<span id="selectedFoldersCountText"></span>
			</div>
		</div>
	</div>

	@include('clients.ClientAssets.your_assets_side_bar_popup')
@else
	<div style="margin-top: 40px">
		Wrcs not found
	</div>
		
@endif
@endsection

@section('js_links')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
@endsection

@section('js_scripts')

<script>
	const folderContainer = document.getElementById('folderContainer');
	const folders = Array.from(folderContainer.getElementsByClassName('folder'));
	const selectedFoldersCount = document.getElementById('selectedFoldersCount');
	const popover = document.getElementById('popover');

	let selectedFolders = [];
	let isCtrlPressed = false;

	folderContainer.addEventListener('click', handleFolderSelection);
	document.addEventListener('keydown', handleKeyDown);
	document.addEventListener('keyup', handleKeyUp);

	function handleFolderSelection(event) {
		if (isCtrlPressed) {
			const folder = getClosestFolder(event.target);
			const isSelected = folder.classList.toggle('selected');
			if (isSelected) {
				selectedFolders.push(folder);
			} else {
				selectedFolders11 = selectedFolders.filter((f, index) => {
					console.log(index, ' f :>> ', f);
					console.log('folder :>> ', folder);
				});
				selectedFolders = selectedFolders.filter(f => f !== folder);
			}
			updateSelectedFoldersCount();
			updatePopover();
		}
	}

	function handleKeyDown(event) {
		if (event.key === 'Control' || event.key === 'Meta') {
			isCtrlPressed = true;
		}
	}

	function handleKeyUp(event) {
		if (event.key === 'Control' || event.key === 'Meta') {
			isCtrlPressed = false;
		}
	}

	function updateSelectedFoldersCount() {
		if (selectedFolders.length > 0) {
			const count = selectedFolders.length;
			const selectedFoldersCountText = document.getElementById('selectedFoldersCountText');
			selectedFoldersCountText.textContent = `${count} ${count > 1 ? '' : ''} selected`;
			selectedFoldersCount.style.display = 'block';
		} else {
			selectedFoldersCount.style.display = 'none';
		}
	}

	function updatePopover() {
		if (selectedFolders.length > 0) {
			const folderNames = selectedFolders.map(folder => folder.textContent).join(', ');
			const downloadLink = createDownloadLink();
			// popover.innerHTML = `${folderNames}<br>${downloadLink}`;
			popoverfolderselect.style.display = 'block';
		} else {
			popoverfolderselect.style.display = 'none';
		}
	}

	function createDownloadLink() {
		const link = document.createElement('a');
		link.textContent = 'Download';
		link.href = '#'; // Replace with the actual download link
		link.addEventListener('click', handleDownloadClick);
		return link.outerHTML;
	}

	function handleDownloadClick(event) {
		// Handle the download action here
		event.preventDefault();
		console.log('Download link clicked');
	}

	function getClosestFolder(element) {
		while (element && !element.classList.contains('folder')) {
			element = element.parentElement;
		}
		return element;
	}

</script>

{{--  Function for adding multipal files to favorites --}}
<script>
		async function add_to_multipal_fav(){
		var selectedFolders = document.querySelectorAll('#folderContainer .selected .adap-div .myPopover .add_to_favorites_calss');

		let data_obj_array = [];
		selectedFolders.forEach((element) => {
			var data_obj = element.getAttribute('data-data_obj');
			data_obj_array.push(data_obj);
    });

		if(data_obj_array.length > 0){
			await $.ajax({
				url: "{{ url('your-assets-Multipal-Favorites')}}",
				type: "POST",
				dataType: 'json',
				data: {
					data : data_obj_array,
					_token: '{{ csrf_token() }}'
				},
				success: function(res) {
					console.log('res => ', res )
					if(res?.status){
						$('.Multipal-fav-and-notfav-Text').text(res.massage);
						$('.Multipal-fav-div').removeClass('d-none');
						setTimeout(() => {
							$('.Multipal-fav-div').addClass('d-none');
						}, 2000);
					}else{
						$('.error-text').text(res.massage);
						$('.added-notfav-div').removeClass('d-none');
						setTimeout(() => {
							$('.added-notfav-div').addClass('d-none');
							$('.error-text').text('Removed from favourites');
						}, 2000);
					}
				}
			});
		}
	}

</script>

{{--  Download Multipal zip files --}}
<script>
	function download_mul_zip(){
		const folderNames = selectedFolders.map(async (folder , index) => {
			let selectedfolder_id = folder.classList[0];
			var selectedFolder = document.querySelector('.'+selectedfolder_id);
			var popoverFirstChild = selectedFolder.querySelector('.myPopover .Download');
			var element = selectedFolder.querySelector('.adap-div .myPopover .Download');

			var hrefValue = popoverFirstChild.getAttribute('href');
			var wrc_id = popoverFirstChild.getAttribute('data-wrc_id');
			var wrc_number = popoverFirstChild.getAttribute('data-wrc_number');
			// console.log({index, wrc_id, hrefValue});
			await $.ajax({
				url: hrefValue,
				type: "GET",
				xhrFields: {
					responseType: 'blob'
				},
				success: function(blob) {
					// Create a temporary URL for the downloaded file
					console.log('blob', blob)
					if(blob != 'error'){
						var url = URL.createObjectURL(blob);

						var link = document.createElement('a');
						link.href = url;
						link.download = wrc_number + '.zip';
						// Programmatically click the link to trigger the download
						link.click();
						URL.revokeObjectURL(url);
					}
			},
				error: function(xhr, status, error) {
					console.error('Error:', error);
				}
			});
		})
	}
</script>


{{-- add_to_favorites --}}
	<script>
		async function add_to_favorites(data_obj = ''){
			await $.ajax({
				url: "{{ url('your-assets-Favorites')}}",
				type: "POST",
				dataType: 'json',
				data: {
					data : data_obj,
					_token: '{{ csrf_token() }}'
				},
				success: function(res) {
					console.log('res => ', res )
					if(res?.status){
						$('.added-fav-div').removeClass('d-none');
						setTimeout(() => {
							$('.added-fav-div').addClass('d-none');
						}, 2000);
					}else{
						$('.error-text').text('Somthing Went Wrong');
						$('.added-notfav-div').removeClass('d-none');
						setTimeout(() => {
							$('.added-notfav-div').addClass('d-none');
							$('.error-text').text('Remove from favourites');
						}, 2000);
					}
					console.log('res', res)
					// alert(res.massage)
				}
			});
		}
	</script>

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
@endsection
