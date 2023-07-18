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
								<span class="WRC-no-file" id="lot_number{{$row['wrc_id'].$wrc_unic_key}}">{{$row['wrc_number']}}</span>
							</span>
						</a>
						<span class="adap-wrc-dots">
							<a href="javascript:void(0)" class=" test myButton" role="button"> <i class="bi bi-three-dots-vertical" style="font-size:20px;color: #808080;"></i></a>
						</span>						
					</div>
					{{-- myPopover Start --}}
					<div class="myPopover" style="z-index: 9; display: none;">
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
						{{-- Click btn --}}
						<a data-id="{{$row['wrc_id'].$wrc_unic_key}}" data-url="{{route($download_route_is , [ base64_encode($row['wrc_id']) ] )}}"  href="javascript:void(0)" class="share_popover_trigger">
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>&nbsp;
							Share
						</a>
						{{-- copy btn --}}
						<a  class="d-none" id="{{$row['wrc_id'].$wrc_unic_key}}" href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$row['wrc_id'].$wrc_unic_key}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>&nbsp;
							Share
						</a>
						<p class="d-none" id="url_{{$row['wrc_id'].$wrc_unic_key}}">{{route($download_route_is , [ base64_encode($row['wrc_id']) ] )}}</p>

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
					{{-- myPopover End --}}
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
		@endforeach
	@else
	<div class="col-sm-6 col-md-4 col-lg-3">
		<p class="underheadingF">No WRCs</p>
	</div>	
	@endif
</div>