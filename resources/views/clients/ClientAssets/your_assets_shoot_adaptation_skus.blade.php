@extends('layouts.DamNewMain')
@section('title')
  Your Assets - Adapation Sku's
@endsection

@section('main_content')
	@php
		$user = Auth::user();
		$your_assets_permissions = json_decode($user->your_assets_permissions,true);
		$file_manager_permissions = json_decode($user->file_manager_permissions,true);
		$roledata = getUsersRole($user->id);
		$user_role = $roledata != null ? $roledata->role_name : '-';
	@endphp

@if (count($raw_skus) > 0)
	<div class="row">
		<div class="col-12" >
			<nav
				style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
				aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><span class="breadcrumb-deco" >{{$raw_skus[0]['lot_number']}}</span></li>
					<li class="breadcrumb-item"><a class="breadcrumb-deco" href="{{route('your_assets_shoot_wrcs' , [$raw_skus[0]['lot_id']])}}">WRCs</a></li>
					<li class="breadcrumb-item"><a class="breadcrumb-deco" href="{{route('your_assets_shoot_skus' , [base64_encode($raw_skus[0]['wrc_id'])])}}">{{$raw_skus[0]['wrc_number']}}</a></li>
					<li class="breadcrumb-item active breadcrumb-deco" aria-current="page">{{$raw_skus[0]['adaptation']}}</li>
				</ol>
			</nav>
		</div>
		<div class="col-12" style="margin-top: 40px;">
			<p style="font-weight: 500;font-size: 12px;margin-bottom:0px;color: #FFFFFF;">Total SKU: {{count($raw_skus)}}</p>
		</div>
	</div>
	<div class="row" style="margin-top: 12px;">
		@foreach ($raw_skus as $key => $row)
			@php
				$file_path = $row['file_path'];
				$shoot_image_src = 'IMG/no_preview_available.jpg';
				if($file_path != ''){
					$shoot_image_src = $file_path;
				}
			@endphp
			<div class="col-lg-3 col-md-6 mt-2">
				<div class="row brand-div" style="position: relative">
					<div class="col-2 mt-3">
						<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M23.5735 13.3695C23.5407 13.5231 23.4783 13.6719 23.4167 13.8151C23.2951 14.0967 23.1695 14.3767 23.0335 14.6511C22.0167 16.7039 20.9847 18.7495 19.9703 20.8039C19.5743 21.6063 18.9519 21.9847 18.0567 21.9839C12.7055 21.9767 7.35429 21.9791 2.00309 21.9815C1.42469 21.9815 0.829492 21.7335 0.559893 21.1927C0.411093 20.8943 0.562292 20.6319 0.692692 20.3599C0.796692 20.1423 0.900692 19.9255 1.00549 19.7079C1.21349 19.2735 1.42149 18.8391 1.62949 18.4039C1.83749 17.9695 2.04549 17.5343 2.25269 17.0999C2.46069 16.6647 2.66789 16.2303 2.87509 15.7951C3.08229 15.3599 3.28949 14.9247 3.49669 14.4895C3.70389 14.0543 3.91029 13.6191 4.11749 13.1839C4.22629 12.9551 4.33429 12.7271 4.44309 12.4983C4.83429 11.6743 5.47589 11.2647 6.37909 11.2639C11.4439 11.2615 16.5079 11.2599 21.5727 11.2655C22.0591 11.2655 22.5511 11.3847 22.9239 11.7111C23.2063 11.9583 23.4223 12.2895 23.5303 12.6495C23.5847 12.8311 23.6103 13.0215 23.5975 13.2111C23.5943 13.2647 23.5863 13.3175 23.5743 13.3695H23.5735Z" fill="white"/>
							<path d="M0.408809 17.8057C0.400009 17.7937 0.399209 17.7761 0.400809 17.7617C0.406409 17.7017 0.405609 17.6417 0.405609 17.5817C0.405609 13.5825 0.405609 9.58253 0.405609 5.58333C0.405609 4.56813 0.973609 4.00013 1.99041 3.99933C3.71841 3.99933 5.44641 4.00493 7.17441 3.99613C7.79921 3.99293 8.27521 4.23133 8.62961 4.74813C9.03921 5.34493 9.47361 5.92493 9.88721 6.51933C9.98721 6.66333 10.092 6.72173 10.272 6.72093C12.9736 6.71453 15.6752 6.71773 18.3768 6.71533C18.9816 6.71533 19.4728 6.92653 19.764 7.47613C19.856 7.64973 19.9128 7.86092 19.92 8.05692C19.9408 8.64493 19.9288 9.23373 19.9288 9.82253C19.9288 9.85853 19.9192 9.89453 19.9112 9.95213C19.8 9.95213 19.696 9.95213 19.592 9.95213C14.936 9.95213 10.28 9.95373 5.62401 9.95053C4.91121 9.95053 4.30321 10.1617 3.86801 10.7521C3.76641 10.8905 3.68801 11.0481 3.61361 11.2041C2.59281 13.3385 1.57441 15.4737 0.555209 17.6089C0.540009 17.6409 0.524009 17.6721 0.508809 17.7041C0.494409 17.7337 0.483209 17.7681 0.464009 17.7961C0.452009 17.8137 0.425609 17.8281 0.408809 17.8065V17.8057Z" fill="white"/>
						</svg>

					</div>
					<div class="col-8 mt-2">
						<a style="text-decoration: none;" href="{{route('your_assets_shoot_edited_images' , [base64_encode($row['sku_id'])] )}}">
							<p class="brand-text" id="lot_number{{$row['sku_id'].$key}}">{{$row['sku_code']}}</p>
						</a>
					</div>
					<div class="col-2 mt-3">
						<i class="bi bi-three-dots-vertical test myButton" style="font-size:20px;color: #808080;" role="button"></i>
							<div class="myPopover" style="display: none;">
								@php
										$download_route_is = "download_Shoot_lot_Edited_adaptation";
										$sku_id_is = base64_encode($row['sku_id']);
										$adaptation = base64_encode($raw_skus[0]['adaptation']);
								@endphp
								<a href="{{route($download_route_is , [ 'wrc_id' => base64_encode($raw_skus[0]['wrc_id']) , 'adaptation' => base64_encode($raw_skus[0]['adaptation']) , 'sku_id' => base64_encode($row['sku_code']) ] )}}">
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
									&nbsp;&nbsp;
									Download
								</a>
								<a href="javascript:void(0)" onclick="toggleSidebar(); set_date_time({{$row['sku_id'].$key}}); lots_details('{{ $sku_id_is  }}' , 'sku' , '{{$adaptation}}') ">
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

								
								<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key}}' , 'Shoot Lot WRC adaptation Image' , 'Shoot WRC')" >
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
									&nbsp;&nbsp;
									Share
								</a>
								<p class="d-none" id="url_{{$key}}">
									{{route($download_route_is , [ 'wrc_id' => base64_encode($raw_skus[0]['wrc_id']) , 'adaptation' => base64_encode($raw_skus[0]['adaptation']) , 'sku_id' => base64_encode($row['sku_code']) ] )}}
								</p>
								<a href="#">
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
								
							</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>

@include('clients.ClientAssets.your_assets_side_bar_popup')
@else
	<div style="margin-top: 40px">
		Sku codes not found
	</div>
@endif
@endsection
