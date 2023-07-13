		<!-- sidebar popup start -->
		<div class="sidebar">
			<div class="row sidebar-row-where-content">
				<div class="col-12 d-flex justify-content-between">
				    <div class="row">
				       <div class="col-11">
				           	<p class=" side-lot" id="lot_number"></p>
				       </div>
				       <div class="col-1">
				           <button onclick="toggleSidebar()" type="button" class="btn border-0 close-button">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M14.19 0H5.81C2.17 0 0 2.17 0 5.81V14.18C0 17.83 2.17 20 5.81 20H14.18C17.82 20 19.99 17.83 19.99 14.19V5.81C20 2.17 17.83 0 14.19 0ZM13.36 12.3C13.65 12.59 13.65 13.07 13.36 13.36C13.21 13.51 13.02 13.58 12.83 13.58C12.64 13.58 12.45 13.51 12.3 13.36L10 11.06L7.7 13.36C7.55 13.51 7.36 13.58 7.17 13.58C6.98 13.58 6.79 13.51 6.64 13.36C6.50052 13.2189 6.4223 13.0284 6.4223 12.83C6.4223 12.6316 6.50052 12.4411 6.64 12.3L8.94 10L6.64 7.7C6.50052 7.55886 6.4223 7.36843 6.4223 7.17C6.4223 6.97157 6.50052 6.78114 6.64 6.64C6.93 6.35 7.41 6.35 7.7 6.64L10 8.94L12.3 6.64C12.59 6.35 13.07 6.35 13.36 6.64C13.65 6.93 13.65 7.41 13.36 7.7L11.06 10L13.36 12.3Z"
								fill="white" />
						</svg>
					</button>
				       </div>
				    </div>
				  </div>

				<div class="col-12 wrc-detail-img ">
					<div class="row">
						<div class="col-12" style="margin-top: 16px;">
							<img id="image_src" src="{{asset('IMG/group_10.png')}}" alt="" class="img-fluid" style="background: rgba(255, 255, 255, 0.1);">
						</div>
					</div>
				</div>

				<div class="col-12">
					<div class="row">
						<div class="col-12" style="margin-top: 24px;">
							<p class="heading-details">Folder details</p>
						</div>
						<div class="col-11">
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
						<div class="col-12">
							<p class="side-text">SIZE</p>
							<P class="side-text2" id="file_size"></P>
						</div>
						{{-- Shoot files other data --}}
						<div id="shoot_files_details" class="d-none">
							<div class="col-11">
								<p class="side-text">WRC</p>
								<P  id="wrc_numbers" class="side-text2"></P>
							</div>
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
						<!--<div class="col-12">-->
						<!--	<p class="side-text">TAGS</p>-->
						<!--	<P class="side-text2">Black Tees, Ajio code</P>-->
						<!--</div>-->

						<!--<div class="col-12 d-grid gap-2 ps-4 pe-4">-->
						<!--	<button class="btn border rounded-0  heading-details" type="button">-->
						<!--		<svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">-->
						<!--			<path-->
						<!--				d="M11.5529 4.53224L4.71122 11.7739C4.45289 12.0489 4.20289 12.5906 4.15289 12.9656L3.84455 15.6656C3.73622 16.6406 4.43622 17.3072 5.40289 17.1406L8.08622 16.6822C8.46122 16.6156 8.98622 16.3406 9.24455 16.0572L16.0862 8.81558C17.2696 7.56558 17.8029 6.14058 15.9612 4.39891C14.1279 2.67391 12.7362 3.28224 11.5529 4.53224Z"-->
						<!--				stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"-->
						<!--				stroke-linejoin="round" />-->
						<!--			<path-->
						<!--				d="M10.4111 5.74121C10.5858 6.85859 11.1266 7.88632 11.9486 8.66308C12.7707 9.43984 13.8273 9.92165 14.9528 10.0329"-->
						<!--				stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"-->
						<!--				stroke-linejoin="round" />-->
						<!--		</svg>-->
						<!--		&nbsp; Edit tag-->
						<!--	</button>-->
						<!--</div>-->
						
						<div class="col-12" style="margin-top: 24px;">
							<p class="heading-details">Share</p>
						</div>
						
						

						<div class="col-12">


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

							{{-- <button id="share_btn" data-id="" class="btn rounded-0 copy-link-sidebar" type="button">
								<span id="target_copy_url">
									Copy link
								</span>
									<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect width="30" height="30" rx="15" fill="#98A7DA"/>
										<g clip-path="url(#clip0_2553_6451)">
										<path d="M18 15.675V18.825C18 21.45 16.95 22.5 14.325 22.5H11.175C8.55 22.5 7.5 21.45 7.5 18.825V15.675C7.5 13.05 8.55 12 11.175 12H14.325C16.95 12 18 13.05 18 15.675Z" stroke="#0F0F0F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M22.5 11.175V14.325C22.5 16.95 21.45 18 18.825 18H18V15.675C18 13.05 16.95 12 14.325 12H12V11.175C12 8.55 13.05 7.5 15.675 7.5H18.825C21.45 7.5 22.5 8.55 22.5 11.175Z" stroke="#0F0F0F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</g>
										<defs>
										<clipPath id="clip0_2553_6451">
										<rect width="18" height="18" fill="white" transform="translate(6 6)"/>
										</clipPath>
										</defs>
									</svg>
							</button> --}}
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- sidebar popup end -->