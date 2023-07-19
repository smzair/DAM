@extends('layouts.DamNewMain')
@section('title')
  Your Assets - <?php echo ucfirst($service_is)?> Image 
@endsection

@section('main_content')
<style>
	.myPopover{
		top: 60%;
	}
</style>
@php
	$user = Auth::user();
	$your_assets_permissions = json_decode($user->your_assets_permissions,true);
	$file_manager_permissions = json_decode($user->file_manager_permissions,true);
	$roledata = getUsersRole($user->id);
	$user_role = $roledata != null ? $roledata->role_name : '-';
	// dd($raw_skus_files , $service_is);
	
@endphp

@if (count($raw_skus_files) > 0)
<div class="row">
	<div class="col-12">
		<nav
			style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
			aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('your_assets_files' , ['service' => 'Shoot'])}}" class="breadcrumb-deco" >{{$raw_skus_files[0]['lot_number']}}</a></li>
				<li class="breadcrumb-item"><a class="breadcrumb-deco" href="{{route('your_assets_shoot_wrcs' , [$raw_skus_files[0]['lot_id']])}}">WRCs</a></li>
				<li class="breadcrumb-item"><a class="breadcrumb-deco" href="{{route('your_assets_shoot_skus' , [base64_encode($raw_skus_files[0]['wrc_id'])])}}">{{$raw_skus_files[0]['wrc_number']}}</a></li>
				
				@if ($service_is == 'edited')
				<li class="breadcrumb-item"><a class="breadcrumb-deco" href="{{route('your_assets_shoot_adaptation_skus' , [ base64_encode($raw_skus_files[0]['wrc_id']) , base64_encode($raw_skus_files[0]['adaptation'])])}}">{{$raw_skus_files[0]['adaptation']}}</a></li>
				@endif
				
				<li class="breadcrumb-item active breadcrumb-deco" aria-current="page">{{$raw_skus_files[0]['sku_code']}}
				</li>
			</ol>
		</nav>
	</div>
	<div class="col-12" style="margin-top: 40px;">
		<p style="font-weight: 500;font-size: 12px;color: #FFFFFF;margin-bottom:0px;">Total Images: {{count($raw_skus_files)}}</p>
	</div>
</div>

<div class="row" id="folderContainer" >

	@foreach ($raw_skus_files as $key => $row)
		@php
		if($service_is == 'edited'){
			$path=  "edited_img_directory/". date('Y', strtotime($row['created_at'])) . "/" . date('M', strtotime($row['created_at'])) . "/" . $row['lot_number'] . "/" . $row['wrc_number']. "/" . $row['adaptation']. "/" .$row['sku_code']. "/" . $row['filename'] ;
		}elseif ($service_is == 'raw') {
			$path=  "raw_img_directory/". date('Y', strtotime($row['created_at'])) . "/" . date('M', strtotime($row['created_at'])) . "/" . $row['lot_number'] . "/" . $row['wrc_number']. "/" .$row['sku_code']. "/" . $row['filename'] ;
		}

		$shoot_image_src = 'IMG/no_preview_available.jpg';
		// $img_src = 'IMG/group_10.png';
		$img_src = 'IMG/no_preview_available.jpg';
		$zipFileSize = "File Not Found!!";
		if(file_exists($path)){
			$img_src = $path;
			$shoot_image_src = $img_src;
			$zipFileSize = filesize($path);
			$zipFileSize = formatBytes($zipFileSize);

		}
		@endphp
		<div class="col-sm-6 col-md-4 col-lg-3 SKU-BOX-STYLE" >
			<div class="selectedfolder{{$key+1}} folder">
			<div class="card brand-img-m border-0 rounded-0" >
				<img class="card-img-top brand-img zoomable-image" src="{{ asset($img_src)}}" alt="Image">
				<div class="zoomed-container">
					<img src="{{ asset($img_src)}}" alt="Zoomed Image" class="zoomed-image">
				</div>
				<div class="navigation-buttons left">
					<button class="previous-button" style="display:none">&#8249;</button>
				</div>
		
				<div class="navigation-buttons right">
					<button class="next-button" style="display:none">&#8250;</button>
				</div>
                
				<div class="card-body total-sku-img-body d-flex justify-content-between" style="position: relative">
					<p class="brand-img-name" id="lot_number{{$row['sku_id'].$key}}">{{$row['filename']}}</p>
					<i class="bi bi-three-dots-vertical myButton" style="cursor: pointer;color:#808080;font-size:20px;"></i>
					<div class="myPopover" style="display: none; top 20%;">

						<a class="Download" data-file_name="{{$row['wrc_number']}}" href="{{ asset($img_src)}}" download="{{$row['filename']}}">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							&nbsp;&nbsp;
							Download
						</a>

						<a class="view_details" href="javascript:void(0)" onclick="toggleSidebar(); set_date({{$row['sku_id'].$key}});">
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
							<span id="lot_date{{$row['sku_id'].$key}}">{{dateFormet_dmy($row['sku_created_at'])}}</span>
							<span id="lot_time{{$row['sku_id'].$key}}">{{date('h:i A', strtotime($row['sku_created_at']))}}</span>
							<span id="file_size{{$row['sku_id'].$key}}">{{ $zipFileSize }}</span>
							<span id="image_src{{$row['sku_id'].$key}}">{{asset($shoot_image_src)}}</span>
							<span id="share_btn{{$row['sku_id'].$key}}">{{$row['sku_id'].$key}}</span>
						</div>

						{{-- Click btn --}}
						<a data-id="{{$row['sku_id'].$key}}" data-url="{{ asset($img_src)}}"  href="javascript:void(0)" class="share_popover_trigger">
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							&nbsp;&nbsp;
							Share
						</a>

						{{-- copy btn --}}
						<a class="d-none" id="{{$row['sku_id'].$key}}" href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$row['sku_id'].$key}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							&nbsp;&nbsp;
							Share
						</a>
						<p class="d-none" id="url_{{$row['sku_id'].$key}}">{{ asset($img_src)}}</p>

						@php
							$service = base64_encode('SHOOT');
							$module = base64_encode('image');
							$lot_id_is = base64_encode($row['lot_id']);
							$wrc_id_is = base64_encode($row['wrc_id']);
							$sku_code_is = base64_encode($row['sku_code']);
							$sku_id_is = base64_encode($row['sku_id']);
							$image_id = base64_encode($row['image_id']);
							$data_array = array(
								'user_id' => '', 
								'brand_id' => '', 
								'lot_id' => $lot_id_is, 
								'wrc_id' => $wrc_id_is,
								'service' => $service, 
								'module' => $module,
								'other_data' => [
									'sku_id' => $sku_id_is,
									'image_id' => $image_id,
									'sku_code' => $sku_code_is,
									'filename' => $row['filename'],
									'type' => ucfirst($service_is)
								]
							);

							$data_obj = json_encode($data_array,true);
						@endphp
						{{-- Add to Favorites --}}
						<a  class="add_to_favorites_calss" data-data_obj="{{$data_obj}}"  href="javascript:void(0)" onclick="add_to_favorites({{$data_obj}})">
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
							Add to favorites
						</a>
						{{-- Add Tag --}}
						{{-- <a href="javascript:void(0)">
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M3.47507 12.7507L7.25007 16.5257C7.99675 17.2702 9.00816 17.6883 10.0626 17.6883C11.117 17.6883 12.1284 17.2702 12.8751 16.5257L16.5334 12.8674C17.2779 12.1207 17.696 11.1093 17.696 10.0549C17.696 9.0005 17.2779 7.98909 16.5334 7.24241L12.7501 3.47575C12.3589 3.0835 11.8898 2.77772 11.373 2.57819C10.8562 2.37866 10.3033 2.28982 9.75007 2.31741L5.58341 2.51741C3.91674 2.59241 2.59174 3.91741 2.50841 5.57575L2.30841 9.74241C2.25841 10.8674 2.68341 11.9591 3.47507 12.7507Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M7.91659 10.0007C8.46912 10.0007 8.99902 9.78116 9.38972 9.39046C9.78043 8.99976 9.99992 8.46985 9.99992 7.91732C9.99992 7.36478 9.78043 6.83488 9.38972 6.44418C8.99902 6.05348 8.46912 5.83398 7.91659 5.83398C7.36405 5.83398 6.83415 6.05348 6.44345 6.44418C6.05275 6.83488 5.83325 7.36478 5.83325 7.91732C5.83325 8.46985 6.05275 8.99976 6.44345 9.39046C6.83415 9.78116 7.36405 10.0007 7.91659 10.0007Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
							</svg>
							&nbsp;&nbsp;
							Add Tag
						</a> --}}
					</div>
				</div>
			</div>
			</div>
		</div>		
	@endforeach

	{{-- Multi selected menu --}}
	<div class="col-12 col-lg-12 col-md-12 col-sm-12">
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
						<span class="popover-item-text" onclick="download_mul_img()">Download</span>
					</div>

					{{-- View details --}}
					<div class="popover-item" id="multi_view_details">
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
		<?php echo ucfirst($service_is)?> Image not found
	</div>
@endif
@endsection

@section('js_scripts')
@include('clients.ClientAssets.multipal_select_js')
	{{-- Setting data and time in side bar --}}
	<script>
		const set_date = (key) => {
			document.getElementById("share_btn").setAttribute("data-id", key);
			console.log('key', key)
			const lot_number = $("#lot_number"+key).html()
			const lot_date = $("#lot_date"+key).html()
			const lot_time = $("#lot_time"+key).html()
			const file_size = $("#file_size"+key).html()
			const image_src = $("#image_src"+key).html()
			$("#image_src").attr("src", image_src);
			$("#lot_time").html(lot_time)
			$("#lot_date").html(lot_date)
			$("#lot_number").html(lot_number)
			$("#file_size").html(file_size)
			const target_url = $("#url_"+key).html()
			document.getElementById("share_btn").setAttribute("data-id", key);
			$("#target_copy_url").html(target_url)
			navigator.clipboard.writeText(target_url);
		}
	</script>

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
@endsection
