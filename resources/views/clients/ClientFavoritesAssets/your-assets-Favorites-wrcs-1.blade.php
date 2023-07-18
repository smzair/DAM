<div class="row">
	<p class="fovourites-img-lot-sku-wrc-section">WRCs</p>

	@if (count($wrc_data) > 0)
		@foreach ($wrc_data as $wrc_key => $item)
			<?php 
				$row = $item['wrc_data'];
				$service_is = $item['service'];
				$file_path = $row['file_path'];
				$tbl_id = $item['id'];
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
				$wrc_unic_key = $item['wrc_id'].$item['id'].$wrc_key;
			?>

			<div class="col-lg-3 col-md-6 wrc-file-div"  id="div_{{$tbl_id}}">
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
								
								<div class="myPopover" style="display: none;">
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
									{{-- Share --}}
									<a id="{{$row['wrc_id'].$wrc_unic_key}}" href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$wrc_unic_key}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >
										<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>&nbsp;
										Share
									</a>
									<p class="d-none" id="url_{{$wrc_unic_key}}">{{route($download_route_is , [ base64_encode($row['wrc_id']) ] )}}</p>

									{{-- Remove from Favorites --}}
									<a href="javascript:void(0)" onclick="remove_favorites('{{base64_encode($tbl_id)}}')">
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
									</a>
								</div>
							</div>
						</div>

						@if ($service_is == 'SHOOT')
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
			</div>
		@endforeach
	@else
	<div class="col-sm-6 col-md-4 col-lg-3">
		<p class="underheadingF">No WRCs</p>
	</div>	
	@endif
</div>