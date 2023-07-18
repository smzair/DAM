	<div class="row">
		<p class="fovourites-img-lot-sku-wrc-section">Images</p>
		@if (count($editing_images) > 0 || count($shoot_images) > 0)
			@if (count($shoot_images) > 0)
			@foreach ($shoot_images as $index => $data_row)
					@php
						$unic_index = $data_row['id'].$data_row['lot_id'].$data_row['other_data_id'].$index;
						$action_type = $data_row['type'];
						$row = $data_row['img_row'];
						$path = $data_row['img_src'];

						$other_data = json_decode($data_row['other_data'],true);
						$img_src = "IMG/no_preview_available.jpg";
						$zipFileSize = "File Not Found!!";

						if(file_exists($path)){
							$img_src = $path;
							$zipFileSize = filesize($path);
							$zipFileSize = formatBytes($zipFileSize);
						}

						$tbl_id = $data_row['id'];
						// dd($other_data , $data_row);
					@endphp
					<div class="col-sm-6 col-md-4 col-lg-3 SKU-BOX-STYLE" id="div_{{$tbl_id}}">
						<div class="card brand-img-m border-0 rounded-0">
								<img class="card-img-top brand-img" src="{{asset($img_src)}}"
										alt="Image">
								<div class="card-body total-sku-img-body d-flex justify-content-between"
										style="position: relative">
										<p class="brand-img-name" id="lot_number{{$unic_index}}">{{$other_data['filename']}}</p>
										<i class="bi bi-three-dots-vertical myButton"
												style="cursor: pointer;color:#808080;"></i>
										<div class="myPopover" style="display: none; top:70%;">

												<a href="{{asset($img_src)}}"
														download="{{$other_data['filename']}}">
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
												<a class="view_details" href="javascript:void(0)" onclick="toggleSidebar(); set_image_date_time({{$unic_index}});">
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
													<span id="lot_date{{$unic_index}}">{{dateFormet_dmy($row['created_at'])}}</span>
													<span id="lot_time{{$unic_index}}">{{date('h:i A', strtotime($row['created_at']))}}</span>
													<span id="file_size{{$unic_index}}">{{ $zipFileSize }}</span>
													<span id="image_src{{$unic_index}}">{{asset($img_src)}}</span>
												</div>

												{{-- Share --}}
												
												{{-- Click btn --}}
												<a data-id="{{$unic_index}}" data-url="{{ asset($img_src)}}"  href="javascript:void(0)" class="share_popover_trigger">
														<svg width="20" height="20" viewBox="0 0 20 20" fill="none"	xmlns="http://www.w3.org/2000/svg">
															<path
																d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
																stroke="white" stroke-width="1.5" stroke-linecap="round"
																stroke-linejoin="round">
															</path>
														</svg>
														&nbsp;&nbsp;
														Share
												</a>
												{{-- copy btn --}}
												<a class="d-none"  id="{{$unic_index}}" href="javascript:void(0)"
														onclick="copyUrlToClipboard('url_{{$unic_index}}' , 'Editing {{$action_type}} Image ' , 'Editing')">
														<svg width="20" height="20" viewBox="0 0 20 20" fill="none"	xmlns="http://www.w3.org/2000/svg">
															<path
																d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
																stroke="white" stroke-width="1.5" stroke-linecap="round"
																stroke-linejoin="round">
															</path>
														</svg>
														&nbsp;&nbsp;
														Share
												</a>
												<p class="d-none" id="url_{{$unic_index}}">{{asset($img_src)}}</p>

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
					</div>
				@endforeach
					
			@endif

			@if (count($editing_images) > 0)
				@foreach ($editing_images as $index => $row)
					@php
						$unic_index = $row['lot_id'].$row['other_data_id'].$index;
						$action_type = $row['type'];

						$other_data = json_decode($row['other_data'],true);
						$img_src = "IMG/no_preview_available.jpg";
						$path = $other_data['image_src'];
						if(file_exists($path)){
							$img_src = $path;
							$zipFileSize = filesize($path);
							$zipFileSize = formatBytes($zipFileSize);
						}
						// dd($other_data , $editing_images);
						$tbl_id = $row['id'];
					@endphp
					<div class="col-sm-6 col-md-4 col-lg-3 SKU-BOX-STYLE" id="div_{{$tbl_id}}">
						<div class="card brand-img-m border-0 rounded-0">
								<img class="card-img-top brand-img" src="{{asset($img_src)}}"
										alt="Image">
								<div class="card-body total-sku-img-body d-flex justify-content-between"
										style="position: relative">
										<p class="brand-img-name" id="lot_number{{$unic_index}}">{{$other_data['filename']}}</p>
										<i class="bi bi-three-dots-vertical myButton"
												style="cursor: pointer;color:#808080;"></i>
										<div class="myPopover" style="display: none; top:70%;">

												<a href="{{asset($img_src)}}"
														download="{{$other_data['filename']}}">
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

												<a href="javascript:void(0)" onclick="toggleSidebar(); set_image_date_time({{$unic_index}});">
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
													<span id="lot_date{{$unic_index}}">{{dateFormet_dmy($row['created_at'])}}</span>
													<span id="lot_time{{$unic_index}}">{{date('h:i A', strtotime($row['created_at']))}}</span>
													<span id="file_size{{$unic_index}}">{{ $zipFileSize }}</span>
													<span id="image_src{{$unic_index}}">{{asset($img_src)}}</span>
												</div>

												{{-- Share --}}
												{{-- Click btn --}}
												<a data-id="{{$unic_index}}" data-url="{{ asset($img_src)}}"  href="javascript:void(0)" class="share_popover_trigger">
													<svg width="20" height="20" viewBox="0 0 20 20" fill="none"	xmlns="http://www.w3.org/2000/svg">
														<path
															d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
															stroke="white" stroke-width="1.5" stroke-linecap="round"
															stroke-linejoin="round">
														</path>
													</svg>
													&nbsp;&nbsp;
													Share
												</a>

												{{-- copy btn --}}
												<a class="d-none" id="{{$unic_index}}" href="javascript:void(0)"
														onclick="copyUrlToClipboard('url_{{$unic_index}}' , 'Editing {{$action_type}} Image ' , 'Editing')">
														<svg width="20" height="20" viewBox="0 0 20 20" fill="none"	xmlns="http://www.w3.org/2000/svg">
															<path
																d="M14.1333 5.14154C15.7999 6.29987 16.9499 8.14154 17.1833 10.2665M2.90825 10.3082C3.01302 9.28918 3.33501 8.30446 3.85251 7.42039C4.37001 6.53632 5.07101 5.77346 5.90825 5.1832M6.82492 17.4499C7.79158 17.9415 8.89159 18.2165 10.0499 18.2165C11.1666 18.2165 12.2166 17.9665 13.1583 17.5082M10.0499 6.41654C10.6643 6.41654 11.2536 6.17246 11.688 5.738C12.1225 5.30354 12.3666 4.71429 12.3666 4.09987C12.3666 3.48545 12.1225 2.8962 11.688 2.46174C11.2536 2.02728 10.6643 1.7832 10.0499 1.7832C9.4355 1.7832 8.84625 2.02728 8.41179 2.46174C7.97733 2.8962 7.73325 3.48545 7.73325 4.09987C7.73325 4.71429 7.97733 5.30354 8.41179 5.738C8.84625 6.17246 9.4355 6.41654 10.0499 6.41654ZM4.02492 16.5999C4.63934 16.5999 5.22859 16.3558 5.66305 15.9213C6.09751 15.4869 6.34159 14.8976 6.34159 14.2832C6.34159 13.6688 6.09751 13.0795 5.66305 12.6451C5.22859 12.2106 4.63934 11.9665 4.02492 11.9665C3.4105 11.9665 2.82125 12.2106 2.38679 12.6451C1.95233 13.0795 1.70825 13.6688 1.70825 14.2832C1.70825 14.8976 1.95233 15.4869 2.38679 15.9213C2.82125 16.3558 3.4105 16.5999 4.02492 16.5999ZM15.9749 16.5999C16.5893 16.5999 17.1786 16.3558 17.6131 15.9213C18.0475 15.4869 18.2916 14.8976 18.2916 14.2832C18.2916 13.6688 18.0475 13.0795 17.6131 12.6451C17.1786 12.2106 16.5893 11.9665 15.9749 11.9665C15.3605 11.9665 14.7712 12.2106 14.3368 12.6451C13.9023 13.0795 13.6583 13.6688 13.6583 14.2832C13.6583 14.8976 13.9023 15.4869 14.3368 15.9213C14.7712 16.3558 15.3605 16.5999 15.9749 16.5999Z"
																stroke="white" stroke-width="1.5" stroke-linecap="round"
																stroke-linejoin="round">
															</path>
														</svg>
														&nbsp;&nbsp;
														Share
												</a>
												<p class="d-none" id="url_{{$unic_index}}">{{asset($img_src)}}</p>

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
					</div>
				@endforeach
			@endif
		@else
		<div class="col-sm-6 col-md-4 col-lg-3">
			<p class="underheadingF">No Images</p>
		</div>
		@endif
	</div>