@extends('layouts.DamNewMain')
@section('title')
  Your Assets - Editing uploaded images
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
	
@endphp

@if (count($wrc_data) > 0)
<div class="row">
	<div class="col-lg-12">
		<div class="col-12" style="margin-top: 24px;">
			<nav
				style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
				aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><span class="breadcrumb-deco">{{$wrc_data['lot_number']}}</span></li>
					<li class="breadcrumb-item"><a class="breadcrumb-deco" href="{{route('your_assets_editing_wrcs' , [$wrc_data['lot_id']])}}">WRCs</a></li>
					<li class="breadcrumb-item active breadcrumb-deco" aria-current="page">{{$wrc_data['wrc_number']}}</li>
				</ol>
			</nav>
		</div>
		
		
		<div class="row">
			<div class="tab-content" id="pills-tabContent">
				{{-- Edited images --}}
				<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
					tabindex="0">
					<div class="col-12" style="margin-top: 40px;">
						<p style="font-weight: 500;font-size: 12px;color: #9F9F9F;">Total Edited images: {{count($wrc_edited_images)}}</p>
					</div>

					@if (count($wrc_edited_images) > 0)
						<div class="col-12">
							<div class="row" style="margin-top: 10px;">
								@foreach ($wrc_edited_images as $key => $row)
								@php
									// dd($row);
									$path = $row['file_path'].$row['filename'];
									$zipFileSize = "File Not Found!!";
									$img_src = $shoot_image_src = 'IMG/no_preview_available.jpg';

									if(file_exists($path)){
										$img_src = $path;
										$shoot_image_src = $path;
										$zipFileSize = filesize($path);
										$zipFileSize = formatBytes($zipFileSize);
									}
								@endphp
								<div class="col-sm-6 col-md-4 col-lg-3 mt-2">
									<div class="card brand-img-m border-0 rounded-0">
										<img class="card-img-top brand-img" src="{{ asset($img_src)}}" alt="Image">
										<div class="card-body d-flex justify-content-between" style="position: relative">
											<p class="brand-img-name" id="lot_number{{$row['upladed_img_id'].$key}}">{{$row['filename']}}</p>
											<i class="bi bi-three-dots-vertical myButton" style="cursor: pointer;"></i>
											
											<div class="myPopover" style="display: none; top 20%;">
												{{-- Download --}}
												<a href="{{ asset($img_src)}}" download="{{$row['filename']}}">
													<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
													</svg>
													Download
												</a>
												{{-- View Details --}}
												<a href="javascript:void(0)" onclick="toggleSidebar(); set_date({{$row['upladed_img_id'].$key}});">
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
													View Details
												</a>
												<div class="d-none">
													<span id="lot_date{{$row['upladed_img_id'].$key}}">{{dateFormet_dmy($row['created_at'])}}</span>
													<span id="lot_time{{$row['upladed_img_id'].$key}}">{{date('h:i A', strtotime($row['created_at']))}}</span>
													<span id="file_size{{$row['upladed_img_id'].$key}}">{{ $zipFileSize }}</span>
													<span id="image_src{{$row['upladed_img_id'].$key}}">{{asset($shoot_image_src)}}</span>
												</div>

												{{-- Share --}}
												<a id="{{$row['upladed_img_id'].$key}}"  href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key}}' , 'Editing Lot Edited Image' , 'Editing lot')" >
													<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
													</svg>
													Share
												</a>
												<p class="d-none" id="url_{{$key}}">{{ asset($img_src)}}</p>

												@php
													$service = base64_encode('EDITING');
													$module = base64_encode('image');
													$lot_id_is = base64_encode($row['lot_id']);
													$wrc_id_is = base64_encode($row['wrc_id']);
													$data_array = array(
														'user_id' => '', 
														'brand_id' => '', 
														'lot_id' => $lot_id_is, 
														'wrc_id' => $wrc_id_is,
														'service' => $service, 
														'module' => $module,
														'other_data' => [
															// 'sku_id' => $sku_id_is,
															// 'sku_code' => $sku_code_is,
															'upladed_img_id' => $row['upladed_img_id'],
															'filename' => $row['filename'],
															'image_src' => $shoot_image_src,
															'type' => 'Edited'
														]
													);

													$data_obj = json_encode($data_array,true);
												@endphp

												{{-- Add to Favorites --}}
												<a href="javascript:void(0)" onclick="add_to_favorites({{$data_obj}})">
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
													
													Add to favorites
												</a>

												{{-- Add Tag --}}
												<!--<a href="javascript:void(0)">-->
												<!--	<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">-->
												<!--		<path d="M3.47507 12.7507L7.25007 16.5257C7.99675 17.2702 9.00816 17.6883 10.0626 17.6883C11.117 17.6883 12.1284 17.2702 12.8751 16.5257L16.5334 12.8674C17.2779 12.1207 17.696 11.1093 17.696 10.0549C17.696 9.0005 17.2779 7.98909 16.5334 7.24241L12.7501 3.47575C12.3589 3.0835 11.8898 2.77772 11.373 2.57819C10.8562 2.37866 10.3033 2.28982 9.75007 2.31741L5.58341 2.51741C3.91674 2.59241 2.59174 3.91741 2.50841 5.57575L2.30841 9.74241C2.25841 10.8674 2.68341 11.9591 3.47507 12.7507Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>-->
												<!--		<path d="M7.91659 10.0007C8.46912 10.0007 8.99902 9.78116 9.38972 9.39046C9.78043 8.99976 9.99992 8.46985 9.99992 7.91732C9.99992 7.36478 9.78043 6.83488 9.38972 6.44418C8.99902 6.05348 8.46912 5.83398 7.91659 5.83398C7.36405 5.83398 6.83415 6.05348 6.44345 6.44418C6.05275 6.83488 5.83325 7.36478 5.83325 7.91732C5.83325 8.46985 6.05275 8.99976 6.44345 9.39046C6.83415 9.78116 7.36405 10.0007 7.91659 10.0007Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>-->
												<!--	</svg>-->
												<!--	Add Tag-->
												<!--</a>-->
											</div>
										</div>
									</div>
								</div>		
								@endforeach
							</div>
						</div>
					@else
							<p>Edited images Not found</p>
					@endif
				</div>

				{{-- Raw images --}}
				@if (count($wrc_raw_images) > 0)
				<div class="tab-pane fade " id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
					tabindex="0">
					<div class="col-12" style="margin-top: 40px;">
						<p style="font-weight: 500;font-size: 12px;color: #9F9F9F;">Total Skus : {{count($wrc_raw_images)}} </p>
					</div>
					<div class="col-12">
						@if (count($wrc_raw_images) > 0)
							<div class="row" style="margin-top: 10px;">	
								@foreach ($wrc_raw_images as $row)
									@php
										$path = $row['file_path'].$row['filename'];
										$zipFileSize = "File Not Found!!";
										$img_src = $shoot_image_src = 'IMG/no_preview_available.jpg';

										if(file_exists($path)){
											$img_src = $path;
											$shoot_image_src = $path;
											$zipFileSize = filesize($path);
											$zipFileSize = formatBytes($zipFileSize);
										}
									@endphp
									<div class="col-sm-6 col-md-4 col-lg-3 mt-2">
										<div class="card brand-img-m border-0 rounded-0">
											<img class="card-img-top brand-img" src="{{ asset($img_src)}}" alt="Image">
											<div class="card-body d-flex justify-content-between" style="position: relative">
												<p class="brand-img-name" id="lot_number{{$row['upladed_img_id'].$key}}">{{$row['filename']}}</p>

												{{-- <p class="brand-img-name">{{$path}}</p> --}}
												<i class="bi bi-three-dots-vertical myButton" style="cursor: pointer;"></i>

												<div class="myPopover" style="display: none; top 20%;">
													{{-- Download --}}
													<a href="{{ asset($img_src)}}" download="{{$row['filename']}}">
														<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
														</svg>
														Download
													</a>

													{{-- View Details --}}
													<a href="javascript:void(0)" onclick="toggleSidebar(); set_date({{$row['upladed_img_id'].$key}});">
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
														View Details
													</a>
													<div class="d-none">
														<span id="lot_date{{$row['upladed_img_id'].$key}}">{{dateFormet_dmy($row['created_at'])}}</span>
														<span id="lot_time{{$row['upladed_img_id'].$key}}">{{date('h:i A', strtotime($row['created_at']))}}</span>
														<span id="file_size{{$row['upladed_img_id'].$key}}">{{ $zipFileSize }}</span>
														<span id="image_src{{$row['upladed_img_id'].$key}}">{{asset($shoot_image_src)}}</span>
													</div>

													{{-- Share --}}
													<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key.$row['upladed_img_id']}}' , 'Editing Lot raw Image' , 'Editing Raw')" >
														<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
														</svg>
														Share
													</a>
													<p class="d-none" id="url_{{$key.$row['upladed_img_id']}}">{{ asset($img_src)}}</p>

													@php
														$service = base64_encode('EDITING');
														$module = base64_encode('image');
														$lot_id_is = base64_encode($row['lot_id']);
														$wrc_id_is = base64_encode($row['wrc_id']);
														$data_array = array(
															'user_id' => '', 
															'brand_id' => '', 
															'lot_id' => $lot_id_is, 
															'wrc_id' => $wrc_id_is,
															'service' => $service, 
															'module' => $module,
															'other_data' => [
																// 'sku_id' => $sku_id_is,
																// 'sku_code' => $sku_code_is,
																'upladed_img_id' => $row['upladed_img_id'],
																'filename' => $row['filename'],
																'image_src' => $shoot_image_src,
																'type' => 'Raw'
															]
														);

														$data_obj = json_encode($data_array,true);
													@endphp
													{{-- Add to Favorites --}}
													<a href="javascript:void(0)" onclick="add_to_favorites({{$data_obj}})">
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
														
														Add to favorites
													</a>
													{{-- Add Tag --}}
													<!--<a href="javascript:void(0)">-->
													<!--	<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">-->
													<!--		<path d="M3.47507 12.7507L7.25007 16.5257C7.99675 17.2702 9.00816 17.6883 10.0626 17.6883C11.117 17.6883 12.1284 17.2702 12.8751 16.5257L16.5334 12.8674C17.2779 12.1207 17.696 11.1093 17.696 10.0549C17.696 9.0005 17.2779 7.98909 16.5334 7.24241L12.7501 3.47575C12.3589 3.0835 11.8898 2.77772 11.373 2.57819C10.8562 2.37866 10.3033 2.28982 9.75007 2.31741L5.58341 2.51741C3.91674 2.59241 2.59174 3.91741 2.50841 5.57575L2.30841 9.74241C2.25841 10.8674 2.68341 11.9591 3.47507 12.7507Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>-->
													<!--		<path d="M7.91659 10.0007C8.46912 10.0007 8.99902 9.78116 9.38972 9.39046C9.78043 8.99976 9.99992 8.46985 9.99992 7.91732C9.99992 7.36478 9.78043 6.83488 9.38972 6.44418C8.99902 6.05348 8.46912 5.83398 7.91659 5.83398C7.36405 5.83398 6.83415 6.05348 6.44345 6.44418C6.05275 6.83488 5.83325 7.36478 5.83325 7.91732C5.83325 8.46985 6.05275 8.99976 6.44345 9.39046C6.83415 9.78116 7.36405 10.0007 7.91659 10.0007Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>-->
													<!--	</svg>-->
													<!--	Add Tag-->
													<!--</a>-->

												</div>
											</div>
										</div>
									</div>
								@endforeach					
							</div>
						@else
							<p>Raw Images not found</p>
						@endif
					</div>
				</div>
				@endif
			</div>
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

@section('js_scripts')
{{-- Setting data and time in side bar --}}
	<script>
		const set_date = (key) => {
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
		}
	</script>
	
{{-- add_to_favorites --}}
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
