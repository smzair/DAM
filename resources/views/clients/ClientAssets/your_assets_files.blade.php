@extends('layouts.DamNewMain')
@section('title')
  Your Assets -files
@endsection

@section('main_content')
@php
	$user = Auth::user();
	$your_assets_permissions = json_decode($user->your_assets_permissions,true);
	$file_manager_permissions = json_decode($user->file_manager_permissions,true);
	$roledata = getUsersRole($user->id);
	$user_role = $roledata != null ? $roledata->role_name : '-';
	// dd($shoot_lots,$editor_lots);
@endphp

<?php 
$lot_status_is = $sortBy = $lot_status_val = "" ;
$service_is = 'Shoot';
	if(isset($other_data)){
		if(isset($other_data['sortBy'])){
			$sortBy = $other_data['sortBy'];
		}
		if(isset($other_data['service_is'])){
			$service_is = $other_data['service_is'];
		}
	}
?>
<style>
    .dropdown-toggle::after {
    display: inline-block;
    margin-left: 0.255em;
    vertical-align: 0.255em;
    content: none;
    border-top: 0.3em solid;
    border-right: 0.3em solid transparent;
    border-bottom: 0;
    border-left: 0.3em solid transparent;
	}

	.dropdown-item.active, .dropdown-item:active {
    color: #FFFFFF;
    text-decoration: none;
    background-color: #1A1A1A;
    }
    
    .dropdown-item:hover {
    color:#fffc;
    background:#1A1A1A !important;
    }
</style>

<div class="row">
	<div class=" col-12 d-flex justify-content-between">
		<h4 class="headingF">
			{{$service_is == 'Shoot' ? 'Shoot Lots' : 'Post-production Lots' }}
		</h4>
        <div class="dropdown">
             <a class="btn rounded-0 sort-by-button  dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               <span>Sort</span>
               <span>
                   <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 7H21M6 12H18M10 17H14" stroke="#808080" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>

               </span>
             </a>

           <ul class="dropdown-menu dropdown-menu-show-sortby">
					<li><a class="dropdown-item dropdown-menu-show-sortby-item {{$sortBy == 'latest' ? 'active' : ''}}" href="{{route('your_assets_files', ['service' => $service_is ,'sortBy' => 'latest' ])}}">Latest</a></li>
					<li><a class="dropdown-item dropdown-menu-show-sortby-item {{($sortBy == 'oldest' || $sortBy == 'old')  ? 'active' : ''}}" href="{{route('your_assets_files', ['service' => $service_is ,'sortBy' => 'oldest' ] )}}">Oldest</a></li>
				</ul>
		</div>
	</div>	
</div>

@if (count($shoot_lots) > 0 || count($editor_lots) > 0 )
	
	<div class="row" style="margin-top: 20px;">
		<div class="tab-content" id="pills-tabContent">
			{{-- shoot lots --}}
			@if (count($shoot_lots) > 0)
				<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
					tabindex="0">
					<div class="row box-container-responsive">
						<div class="col-12">
							<p class="totallotF">Total Lots: {{count($shoot_lots)}}</p>
						</div>
						@foreach ($shoot_lots as $key => $row)
							@php
								$file_path = $row['file_path'];
								$shoot_image_src = 'IMG/group_10.png';
								$shoot_image_src1 = 'IMG/no_preview_available.jpg';
								if($file_path != ''){
									$shoot_image_src = $file_path;
									$shoot_image_src1 = $file_path;
								}
							@endphp
							<div class="col-lg-4 col-md-6 box border-0" style="background: #0F0F0F; position: relative;">
								<div class="row">
									<div class="under-content-div">
										<div class="col-12">
											<a href="{{route('your_assets_shoot_wrcs' , [$row['lot_id']])}}">
												<img src="{{ asset($shoot_image_src1)}}" alt="" class="img-fluid yourasse-file-img">
											</a>
										</div>
										<div class="col-12 d-flex justify-content-between">
											<div>
													<p class="your-asset-lotno-underbox">Brand Name</p>
													<p class="file-lot-date-para">
														Lot date:
													<span class="your-asset-lot-date">{{dateFormet_dmy($row['lot_created_at'])}}</span>
													</p>
												<div class="myPopover" style="display: none;">
													@php
															$download_route_is = "download_Shoot_Lot_edited";
															$lot_id_is = base64_encode($row['lot_id']);
													@endphp
													<a href="{{route($download_route_is , [ 'id' =>  $row['lot_id'] ] )}}">
														<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M15.0583 12.0253L9.99998 17.0837L4.94165 12.0253M9.99998 2.91699V16.942" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
														</svg>&nbsp;
														Download
													</a>

													<a href="javascript:void(0)" onclick="toggleSidebar(); set_date_time({{$row['lot_id'].$key}}, 'shoot'); lots_details('{{ $lot_id_is  }}' , 'lot' , 'Edited') ">
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
														<span id="lot_date{{$row['lot_id'].$key}}">{{dateFormet_dmy($row['lot_created_at'])}}</span>
														<span id="lot_time{{$row['lot_id'].$key}}">{{date('h:i A', strtotime($row['lot_created_at']))}}</span>
														<span id="image_src{{$row['lot_id'].$key}}">{{asset($shoot_image_src1)}}</span>
														<span id="skus_count{{$row['lot_id'].$key}}">{{ $row['skus_count'] }}</span>
														<span id="raw_images{{$row['lot_id'].$key}}">{{ $row['raw_images'] }}</span>
														<span id="edited_images{{$row['lot_id'].$key}}">{{ $row['edited_images'] }}</span>
														<span id="s_type{{$row['lot_id'].$key}}">{{ $row['s_type'] }}</span>
														<span id="wrc_numbers{{$row['lot_id'].$key}}">{{ $row['wrc_numbers'] }}</span>
													</div>

													<a id="{{$row['lot_id'].$key}}"  href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
															</svg>&nbsp;
													    Share
													 </a>
													<p class="d-none" id="url_{{$key}}">{{route($download_route_is , [ 'id' =>  $row['lot_id'] ] )}}</p>

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
													<!--<a href="javascript:void(0)">-->
													<!--    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">-->
													<!--  <path d="M3.47507 12.7498L7.25007 16.5248C7.99675 17.2693 9.00816 17.6873 10.0626 17.6873C11.117 17.6873 12.1284 17.2693 12.8751 16.5248L16.5334 12.8664C17.2779 12.1198 17.696 11.1084 17.696 10.0539C17.696 8.99952 17.2779 7.98812 16.5334 7.24144L12.7501 3.47477C12.3589 3.08252 11.8898 2.77675 11.373 2.57722C10.8562 2.37769 10.3033 2.28884 9.75007 2.31644L5.58341 2.51644C3.91674 2.59144 2.59174 3.91644 2.50841 5.57477L2.30841 9.74144C2.25841 10.8664 2.68341 11.9581 3.47507 12.7498Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>-->
													<!--  <path d="M7.91659 9.99967C8.46912 9.99967 8.99902 9.78018 9.38972 9.38948C9.78043 8.99878 9.99992 8.46888 9.99992 7.91634C9.99992 7.36381 9.78043 6.8339 9.38972 6.4432C8.99902 6.0525 8.46912 5.83301 7.91659 5.83301C7.36405 5.83301 6.83415 6.0525 6.44345 6.4432C6.05275 6.8339 5.83325 7.36381 5.83325 7.91634C5.83325 8.46888 6.05275 8.99878 6.44345 9.38948C6.83415 9.78018 7.36405 9.99967 7.91659 9.99967Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>-->
													<!--  	</svg> &nbsp;-->
													<!--    Add Tag-->
													<!-- </a>-->
												</div>
											</div>
											<div type="button" class="btn border-0 rounded-circle myButton">
													<i class="bi bi-three-dots-vertical" style="color: #9F9F9F;">
													</i>
											</div>
										</div>
										<div>
										    <p class="lot-no-heading">Lot no.</p> 
										    <p class="inward-qty-num" id="lot_number{{$row['lot_id'].$key}}">{{$row['lot_number']}}</p>
										</div>
										<div class="col-10 d-flex justify-content-between">
											<div>
												<p class="inward-qty">Inward Quantity</p>
												<p class="inward-qty-num">
													{{$row['inward_qty']}}
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
						@endforeach				
					</div>
				</div>
			@endif

			{{-- Post-production Lots --}}
			@if (count($editor_lots) > 0)
				<div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
					tabindex="0">
					<div class="row box-container-responsive">
						<div class="col-12">
							<p class="totallotF">Total Lots: {{count($editor_lots)}}</p>
						</div>
						@foreach ($editor_lots as $key => $row)
							@php
								$file_path = $row['file_path'];
								$shoot_image_src1 = 'IMG/no_preview_available.jpg';
								if($file_path != ''){
									$shoot_image_src = $file_path;
									$shoot_image_src1 = $file_path;
								}
							@endphp
							<div class="col-lg-4 col-md-6 box border-0" style="background: #0F0F0F; position: relative;">
								<div class="row">
									<div class="under-content-div">
										<div class="col-12">
											<a href="{{route('your_assets_editing_wrcs' , [$row['lot_id']])}}">
												<img  style="width: 100%; min-height: 393px;"  src="{{ asset($shoot_image_src1)}}" alt="" class="img-fluid">
											</a>
										</div>
										<div class="col-12 d-flex d-flex justify-content-between">
										    <div>
										        <p class="your-asset-lotno-underbox">Brand Name</p>
												<p class="file-lot-date-para">
												  Lot date:
												  <span class="your-asset-lot-date"> {{dateFormet_dmy($row['lot_created_at'])}} </span>
												</p>
												 <div class="myPopover" style="display: none;">
													@php
															$download_route_is = "download_Editing_Lot_edited";
															$lot_id_is = base64_encode($row['lot_id']);
													@endphp
													<a href="{{route($download_route_is , [ 'id' =>  base64_encode($row['lot_id'])  ] )}}">Download</a>

													<a href="javascript:void(0)" onclick="toggleSidebar(); set_date_time({{$row['lot_id'].$key}}); editing_lots_details('{{ $lot_id_is  }}' , 'lot' , 'Edited') ">View Details</a>

													<div class="d-none">
														<span id="lot_date{{$row['lot_id'].$key}}">{{dateFormet_dmy($row['lot_created_at'])}}</span>
														<span id="lot_time{{$row['lot_id'].$key}}">{{date('h:i A', strtotime($row['lot_created_at']))}}</span>
														<span id="image_src{{$row['lot_id'].$key}}">{{asset($shoot_image_src1)}}</span>
													</div>
													
													<a id="{{$row['lot_id'].$key}}"  href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$row['lot_id'].$key}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >Share</a>
													<p class="d-none" id="url_{{$row['lot_id'].$key}}">{{route($download_route_is , [ 'id' =>  base64_encode($row['lot_id']) ] )}}</p>
													
													@php
														$service = base64_encode('EDITING');
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
													<a href="javascript:void(0)" onclick="add_to_favorites({{$data_obj}})">
														Add to favorites
													</a>
													<!--<a href="javascript:void(0)">Add Tag</a>-->
												</div>
											</div>
												 
												<div type="button" class="btn border-0 rounded-circle myButton">
													<i class="bi bi-three-dots-vertical" style="color: #9F9F9F; line-height: 2.5;">
													</i>
												</div>
										</div>
										<div>
										    <p class="lot-no-heading">Lot no.</p> 
										    <p class="inward-qty-num" id="lot_number{{$row['lot_id'].$key}}">{{$row['lot_number']}}</p>
										</div>
										<div class="col-10 d-flex justify-content-between">
											<div>
												<p class="inward-qty">Inward Quantity : </p>
												<p class="inward-qty-num">
													{{$row['inward_qty']}}
												</p>
											</div>
											<div>
												<p class="inward-qty">Submission</p>
												<p class="inward-qty-num">{{dateFormet_dmy($row['submission_date'])}}</p>
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
					</div>
				</div>
			@endif
		</div>
	</div>
	@include('clients.ClientAssets.your_assets_side_bar_popup')
@else
	<div style="margin-top: 40px">
		Lots not found
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
				alert(res.massage)
				console.log('res => ', res )
			}
		});
	}
</script>

@endsection
