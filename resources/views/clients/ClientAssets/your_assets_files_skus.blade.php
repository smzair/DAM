@extends('layouts.DamNewMain')
@section('title')
  Your Assets - WRCs
@endsection

@section('main_content')
@php
	$user = Auth::user();
	$your_assets_permissions = json_decode($user->your_assets_permissions,true);
	$file_manager_permissions = json_decode($user->file_manager_permissions,true);
	$roledata = getUsersRole($user->id);
	$user_role = $roledata != null ? $roledata->role_name : '-';
	// dd($wrc_data, $raw_skus);
@endphp

@if (count($wrc_data) > 0)
<div class="row">
	<div class="col-lg-12">
		<div class="col-12" >
			<nav
				style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
				aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><span class="breadcrumb-deco">{{$wrc_data['lot_number']}}</span></li>
					<li class="breadcrumb-item"><a class="breadcrumb-deco" href="{{route('your_assets_shoot_wrcs' , [$wrc_data['lot_id']])}}">WRCs</a></li>
					<li class="breadcrumb-item active breadcrumb-deco" aria-current="page">{{$wrc_data['wrc_number']}}</li>
				</ol>
			</nav>
		</div>
		@if (count($wrc_data['adaptation']) > 0 || count($raw_skus) > 0)
			
			<div class="row">
				<div class="tab-content" id="pills-tabContent">
					{{-- Edited images --}}
					@if (count($wrc_data['adaptation']) > 0)

						<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
							tabindex="0">
							<div class="col-12" style="margin-top: 40px;">
								<p style="font-weight: 500;font-size: 12px;color: #FFFFFF; margin-bottom:0px;">Total Adaptations: {{count($wrc_data['adaptation'])}}</p>
							</div>

							<div class="col-12 ">
								<div class="row" >
									@foreach ($wrc_data['adaptation'] as $key => $adaptation_arr)
									@php
										$file_path = $adaptation_arr['file_path'];
										$shoot_image_src = 'IMG/no_preview_available.jpg';
										if($file_path != ''){
											$shoot_image_src = $file_path;
										}
									@endphp
										<div class="col-lg-3 col-md-6 SKU-BOX-STYLE">
											<div class="row brand-div2" style="position: relative">
												<div class="col-10">
													<a style="text-decoration: none;display:flex; gap:16px; align-items:center" href="{{route('your_assets_shoot_adaptation_skus' , [ base64_encode($wrc_data['wrc_id']) , base64_encode($adaptation_arr['adaptation'])])}}">
													    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    														<path d="M19.6447 10.317C19.6173 10.445 19.5653 10.569 19.514 10.6884C19.4127 10.923 19.308 11.1564 19.1947 11.385C18.3473 13.0957 17.4873 14.8004 16.642 16.5124C16.312 17.181 15.7933 17.4964 15.0473 17.4957C10.588 17.4897 6.12868 17.4917 1.66935 17.4937C1.18735 17.4937 0.691345 17.287 0.466679 16.8364C0.342679 16.5877 0.468679 16.369 0.577345 16.1424C0.664012 15.961 0.750679 15.7804 0.838012 15.599C1.01135 15.237 1.18468 14.875 1.35801 14.5124C1.53135 14.1504 1.70468 13.7877 1.87735 13.4257C2.05068 13.063 2.22335 12.701 2.39601 12.3384C2.56868 11.9757 2.74135 11.613 2.91401 11.2504C3.08668 10.8877 3.25868 10.525 3.43135 10.1624C3.52201 9.97171 3.61201 9.78171 3.70268 9.59105C4.02868 8.90438 4.56334 8.56305 5.31601 8.56238C9.53668 8.56038 13.7567 8.55905 17.9773 8.56371C18.3827 8.56371 18.7927 8.66305 19.1033 8.93505C19.3387 9.14105 19.5187 9.41705 19.6087 9.71705C19.654 9.86838 19.6753 10.027 19.6647 10.185C19.662 10.2297 19.6553 10.2737 19.6453 10.317H19.6447Z" fill="white"/>
    														<path d="M0.340654 14.0129C0.333321 14.0029 0.332654 13.9882 0.333988 13.9762C0.338654 13.9262 0.337988 13.8762 0.337988 13.8262C0.337988 10.4936 0.337988 7.16024 0.337988 3.82758C0.337988 2.98158 0.811321 2.50824 1.65865 2.50758C3.09865 2.50758 4.53865 2.51224 5.97865 2.50491C6.49932 2.50224 6.89599 2.70091 7.19132 3.13158C7.53265 3.62891 7.89465 4.11224 8.23932 4.60758C8.32265 4.72758 8.40999 4.77624 8.55999 4.77558C10.8113 4.77024 13.0627 4.77291 15.314 4.77091C15.818 4.77091 16.2273 4.94691 16.47 5.40491C16.5467 5.54958 16.594 5.72558 16.6 5.88891C16.6173 6.37891 16.6073 6.86958 16.6073 7.36024C16.6073 7.39024 16.5993 7.42024 16.5927 7.46824C16.5 7.46824 16.4133 7.46824 16.3267 7.46824C12.4467 7.46824 8.56665 7.46958 4.68665 7.46691C4.09265 7.46691 3.58599 7.64291 3.22332 8.13491C3.13865 8.25024 3.07332 8.38158 3.01132 8.51158C2.16065 10.2902 1.31199 12.0696 0.462654 13.8489C0.449988 13.8756 0.436654 13.9016 0.423988 13.9282C0.411988 13.9529 0.402654 13.9816 0.386654 14.0049C0.376654 14.0196 0.354654 14.0316 0.340654 14.0136V14.0129Z" fill="white"/>
													    </svg>
														<p class="brand" id="lot_number{{$wrc_data['wrc_id'].$key}}">{{$adaptation_arr['adaptation']}}</p>
													</a>
												</div>
												<div class="col-2">
													<i class="bi bi-three-dots-vertical test myButton" style="font-size:20px;color: #808080;" role="button"></i>
														<div class="myPopover" style="display: none;">
															@php
																$download_route_is = "download_Shoot_lot_Edited_adaptation";
															$wrc_id_is = base64_encode($wrc_data['wrc_id']);
															$adaptation_is = base64_encode($adaptation_arr['adaptation']);
													@endphp
															<a href="{{route($download_route_is , [ 'wrc_id' => base64_encode($wrc_data['wrc_id']) , 'adaptation' => base64_encode($adaptation_arr['adaptation']) ] )}}">
																<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
																</svg>
																&nbsp;&nbsp;
																Download
															</a>

															<a href="javascript:void(0)" onclick="toggleSidebar(); set_date_time({{$wrc_data['wrc_id'].$key}}); lots_details('{{ $wrc_id_is  }}' , 'adaptation' , '{{$adaptation_is}}' ) ">
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
																<span id="lot_date{{$wrc_data['wrc_id'].$key}}">{{dateFormet_dmy($wrc_data['wrc_created_at'])}}</span>
																<span id="lot_time{{$wrc_data['wrc_id'].$key}}">{{date('h:i A', strtotime($wrc_data['wrc_created_at']))}}</span>
																<span id="image_src{{$wrc_data['wrc_id'].$key}}">{{asset($shoot_image_src)}}</span>

															</div>
															
															<a href="javascript:void(0)" data-id="{{$wrc_data['wrc_id'].$key}}" data-url="{{route($download_route_is , [ 'wrc_id' => base64_encode($wrc_data['wrc_id']) , 'adaptation' => base64_encode($adaptation_arr['adaptation']) ] )}}" class="share_popover_trigger">
																<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
																</svg>
																&nbsp;&nbsp;
																Share
															</a>

															<a class="d-none" id="{{$wrc_data['wrc_id'].$key}}"  href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$wrc_data['wrc_id'].$key}}' , 'Shoot Lot WRC adaptation Image' , 'Shoot WRC')" >
																<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
																</svg>
																&nbsp;&nbsp;
																Share
															</a>
															<p class="d-none" id="url_{{$wrc_data['wrc_id'].$key}}">{{route($download_route_is , [ 'wrc_id' => base64_encode($wrc_data['wrc_id']) , 'adaptation' => base64_encode($adaptation_arr['adaptation']) ] )}}</p>
															
															@php
																$service = base64_encode('SHOOT');
																$module = base64_encode('adaptation');
																$lot_id_is = base64_encode($wrc_data['lot_id']);
																$wrc_id_is = base64_encode($wrc_data['wrc_id']);
																$commercial_id = base64_encode($wrc_data['commercial_id']);
																$data_array = array(
																	'user_id' => '', 
																	'brand_id' => '', 
																	'lot_id' => $lot_id_is, 
																	'wrc_id' => $wrc_id_is,
																	'service' => $service, 
																	'module' => $module,
																	'other_data' => [
																		'commercial_id' => $commercial_id,
																		'adaptation' => $adaptation_is,
																	]
																);

																$data_obj = json_encode($data_array,true);
															@endphp
															{{-- Add to Favorites --}}
															<a class="d-none" href="javascript:void(0)" onclick="add_to_favorites({{$data_obj}})">
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
																Add to Favorites
															</a>

															<!--<a href="javascript:void(0)">-->
															<!--	<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">-->
															<!--		<path d="M3.47507 12.7507L7.25007 16.5257C7.99675 17.2702 9.00816 17.6883 10.0626 17.6883C11.117 17.6883 12.1284 17.2702 12.8751 16.5257L16.5334 12.8674C17.2779 12.1207 17.696 11.1093 17.696 10.0549C17.696 9.0005 17.2779 7.98909 16.5334 7.24241L12.7501 3.47575C12.3589 3.0835 11.8898 2.77772 11.373 2.57819C10.8562 2.37866 10.3033 2.28982 9.75007 2.31741L5.58341 2.51741C3.91674 2.59241 2.59174 3.91741 2.50841 5.57575L2.30841 9.74241C2.25841 10.8674 2.68341 11.9591 3.47507 12.7507Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>-->
															<!--		<path d="M7.91659 10.0007C8.46912 10.0007 8.99902 9.78116 9.38972 9.39046C9.78043 8.99976 9.99992 8.46985 9.99992 7.91732C9.99992 7.36478 9.78043 6.83488 9.38972 6.44418C8.99902 6.05348 8.46912 5.83398 7.91659 5.83398C7.36405 5.83398 6.83415 6.05348 6.44345 6.44418C6.05275 6.83488 5.83325 7.36478 5.83325 7.91732C5.83325 8.46985 6.05275 8.99976 6.44345 9.39046C6.83415 9.78116 7.36405 10.0007 7.91659 10.0007Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>-->
															<!--	</svg>-->
															<!--	&nbsp;&nbsp;-->
															<!--		Add Tag-->
															<!--</a>-->
														</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					@endif

					{{-- Raw images --}}
					@php
						// dd($raw_skus);
					@endphp
					@if (count($raw_skus) > 0)
						<div class="tab-pane fade d-none" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
							tabindex="0">
							<div class="col-12" style="margin-top: 40px;">
								<p style="font-weight: 500;font-size: 12px;color: #FFFFFF;margin-bottom:0px;">Total Skus : {{count($raw_skus)}} </p>
							</div>
							<div class="col-12 ">
								<div class="row">	
									@foreach ($raw_skus as $key => $row)
									@php
										$file_path = $row['file_path'];
										$shoot_image_src = 'IMG/no_preview_available.jpg';
										if($file_path != ''){
											$shoot_image_src = $file_path;
										}
									@endphp
										<div class="col-lg-3 col-md-6 SKU-BOX-STYLE">
											<div class="row brand-div2" style="position: relative;">
												<div class="col-2 mt-3">
													<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M19.6447 10.317C19.6173 10.445 19.5653 10.569 19.514 10.6884C19.4127 10.923 19.308 11.1564 19.1947 11.385C18.3473 13.0957 17.4873 14.8004 16.642 16.5124C16.312 17.181 15.7933 17.4964 15.0473 17.4957C10.588 17.4897 6.12868 17.4917 1.66935 17.4937C1.18735 17.4937 0.691345 17.287 0.466679 16.8364C0.342679 16.5877 0.468679 16.369 0.577345 16.1424C0.664012 15.961 0.750679 15.7804 0.838012 15.599C1.01135 15.237 1.18468 14.875 1.35801 14.5124C1.53135 14.1504 1.70468 13.7877 1.87735 13.4257C2.05068 13.063 2.22335 12.701 2.39601 12.3384C2.56868 11.9757 2.74135 11.613 2.91401 11.2504C3.08668 10.8877 3.25868 10.525 3.43135 10.1624C3.52201 9.97171 3.61201 9.78171 3.70268 9.59105C4.02868 8.90438 4.56334 8.56305 5.31601 8.56238C9.53668 8.56038 13.7567 8.55905 17.9773 8.56371C18.3827 8.56371 18.7927 8.66305 19.1033 8.93505C19.3387 9.14105 19.5187 9.41705 19.6087 9.71705C19.654 9.86838 19.6753 10.027 19.6647 10.185C19.662 10.2297 19.6553 10.2737 19.6453 10.317H19.6447Z" fill="white"/>
                                                        <path d="M0.340654 14.0129C0.333321 14.0029 0.332654 13.9882 0.333988 13.9762C0.338654 13.9262 0.337988 13.8762 0.337988 13.8262C0.337988 10.4936 0.337988 7.16024 0.337988 3.82758C0.337988 2.98158 0.811321 2.50824 1.65865 2.50758C3.09865 2.50758 4.53865 2.51224 5.97865 2.50491C6.49932 2.50224 6.89599 2.70091 7.19132 3.13158C7.53265 3.62891 7.89465 4.11224 8.23932 4.60758C8.32265 4.72758 8.40999 4.77624 8.55999 4.77558C10.8113 4.77024 13.0627 4.77291 15.314 4.77091C15.818 4.77091 16.2273 4.94691 16.47 5.40491C16.5467 5.54958 16.594 5.72558 16.6 5.88891C16.6173 6.37891 16.6073 6.86958 16.6073 7.36024C16.6073 7.39024 16.5993 7.42024 16.5927 7.46824C16.5 7.46824 16.4133 7.46824 16.3267 7.46824C12.4467 7.46824 8.56665 7.46958 4.68665 7.46691C4.09265 7.46691 3.58599 7.64291 3.22332 8.13491C3.13865 8.25024 3.07332 8.38158 3.01132 8.51158C2.16065 10.2902 1.31199 12.0696 0.462654 13.8489C0.449988 13.8756 0.436654 13.9016 0.423988 13.9282C0.411988 13.9529 0.402654 13.9816 0.386654 14.0049C0.376654 14.0196 0.354654 14.0316 0.340654 14.0136V14.0129Z" fill="white"/>
                                                    </svg>


												</div>
												<div class="col-8 mt-2">
													<a style="text-decoration: none;" href="{{route('your_assets_files_shoot_raw_images' , [base64_encode($row['sku_id'])] )}}">
														<p class="brand-text" id="lot_number{{$row['sku_id'].$key}}">{{$row['sku_code']}}</p>
													</a>
												</div>
												<div class="col-2 mt-3">
													<i class="bi bi-three-dots-vertical test myButton" style="font-size:20px;color: #808080;" role="button"></i>
														<div class="myPopover" style="display: none;">
															@php
																	$download_route_is = "download_Shoot_lot_raw_sku";
																	$sku_id_is = base64_encode($row['sku_id']);
															@endphp
															<a href="{{route($download_route_is , [ 'wrc_id' => base64_encode($row['wrc_id']) , 'sku_id' => base64_encode($row['sku_code']) ] )}}">
																<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
																</svg>
																&nbsp;&nbsp;
																Download
															</a>
															
															<a href="javascript:void(0)" onclick="toggleSidebar(); set_date_time({{$row['sku_id'].$key}}); lots_details('{{ $sku_id_is  }}' , 'sku' , 'Raw') ">
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
																<span id="image_src{{$row['sku_id'].$key}}">{{asset($shoot_image_src)}}</span>
															</div>


															<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key.$row['wrc_id']}}' , 'Shoot Lot WRC Sku Image' , 'Shoot WRC')" >
																<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
																</svg>
																&nbsp;&nbsp;
																Share
															</a>
															<p class="d-none" id="url_{{$key.$row['wrc_id']}}">{{route($download_route_is , [ 'wrc_id' => base64_encode($row['wrc_id']) , 'sku_id' => base64_encode($row['sku_code'])] )}}</p>
															
															@php
																$service = base64_encode('SHOOT');
																$module = base64_encode('sku');
																$lot_id_is = base64_encode($wrc_data['lot_id']);
																$wrc_id_is = base64_encode($wrc_data['wrc_id']);
																$sku_code_is = base64_encode($row['sku_code']);
																$data_array = array(
																	'user_id' => '', 
																	'brand_id' => '', 
																	'lot_id' => $lot_id_is, 
																	'wrc_id' => $wrc_id_is,
																	'service' => $service, 
																	'module' => $module,
																	'other_data' => [
																		'sku_id' => $sku_id_is,
																		'sku_code' => $sku_code_is,
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
																&nbsp;&nbsp;
																Add to favorites
															</a>

															<!--<a href="javascript:void(0)">-->
															<!--	<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">-->
															<!--		<path d="M3.47507 12.7507L7.25007 16.5257C7.99675 17.2702 9.00816 17.6883 10.0626 17.6883C11.117 17.6883 12.1284 17.2702 12.8751 16.5257L16.5334 12.8674C17.2779 12.1207 17.696 11.1093 17.696 10.0549C17.696 9.0005 17.2779 7.98909 16.5334 7.24241L12.7501 3.47575C12.3589 3.0835 11.8898 2.77772 11.373 2.57819C10.8562 2.37866 10.3033 2.28982 9.75007 2.31741L5.58341 2.51741C3.91674 2.59241 2.59174 3.91741 2.50841 5.57575L2.30841 9.74241C2.25841 10.8674 2.68341 11.9591 3.47507 12.7507Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>-->
															<!--		<path d="M7.91659 10.0007C8.46912 10.0007 8.99902 9.78116 9.38972 9.39046C9.78043 8.99976 9.99992 8.46985 9.99992 7.91732C9.99992 7.36478 9.78043 6.83488 9.38972 6.44418C8.99902 6.05348 8.46912 5.83398 7.91659 5.83398C7.36405 5.83398 6.83415 6.05348 6.44345 6.44418C6.05275 6.83488 5.83325 7.36478 5.83325 7.91732C5.83325 8.46985 6.05275 8.99976 6.44345 9.39046C6.83415 9.78116 7.36405 10.0007 7.91659 10.0007Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>-->
															<!--	</svg>-->
															<!--	&nbsp;&nbsp;-->
															<!--	Add Tag-->
															<!--</a>-->
														</div>
												</div>
											</div>
										</div>
									@endforeach					
								</div>
							</div>
						</div>
					@endif
				</div>
			</div>
		@else
			<div style="color:#FFFFFF;">Wrcs Data not found</div>
		@endif
	</div>
</div>

@include('clients.ClientAssets.your_assets_side_bar_popup')
@else
	<div style="color:#FFFFFF;">
		Wrcs not found
	</div>
		
@endif
@endsection

@section('js_scripts')
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
