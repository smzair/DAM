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
	if(isset($other_data)){
		if(isset($other_data['sortBy'])){
			$sortBy = $other_data['sortBy'];
		}
	}
?>

<div class="row">
	<div class=" col-12 d-flex justify-content-between">
		<h4 class="headingF">
			Your assets - Files
		</h4>

		<div class="dropdown mt-2">
			<a class="btn rounded-0 sort-by-button  dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				Sort &nbsp;&nbsp;&nbsp;&nbsp;
			</a>
				<ul class="dropdown-menu dropdown-menu-show-sortby">
					<li><a class="dropdown-item dropdown-menu-show-sortby-item {{$sortBy == 'latest' ? 'active' : ''}}" href="{{route('your_assets_files', ['sortBy' => 'latest' ])}}">Latest</a></li>
					<li><a class="dropdown-item dropdown-menu-show-sortby-item {{($sortBy == 'oldest' || $sortBy == 'old')  ? 'active' : ''}}" href="{{route('your_assets_files', ['sortBy' => 'oldest' ] )}}">Oldest</a></li>
				</ul>
		</div>
	</div>

	<div class="col-12" style="margin-top: 12px;">
		<p class="underheadingF">
			Currently, you are seeing Your Assets Files.
		</p>
	</div>
</div>

@if (count($shoot_lots) > 0 || count($editor_lots) > 0 )
	<div class="row ps-lg-2 pe-lg-2" style="margin-top: 40px;" id="File">
		<div class="col-lg-12 d-flex your_assets_tab" style="background: #1A1A1A;">
			<ul class="nav nav-pills mb-3 nav-fill ps-2 pe-2 tabs" id="pills-tab" role="tablist" style="padding: 16px 16px 0px 16px">
				{{-- Shoot Lots --}}
				@if (count($shoot_lots) > 0)
				<li class="nav-item lots-bar tab active" role="presentation" onclick="activateTab(1)">
					<button class="nav-link active btn-lg tab-button tab-text" id="pills-home-tab" data-bs-toggle="pill"
						data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1189_669)">
                        <path class="tab-icon" d="M1.48716 8.85763C1.55676 8.79283 1.60156 8.75363 1.64316 8.71203C2.16716 8.18883 2.68956 7.66563 3.21356 7.14243C3.52156 6.83523 3.79516 6.83683 4.10476 7.14643C4.49196 7.53363 4.87916 7.92163 5.27916 8.32323C5.32796 8.27683 5.37276 8.23763 5.41516 8.19523C6.30636 7.30483 7.19676 6.41363 8.08796 5.52323C8.40396 5.20723 8.67436 5.20723 8.99196 5.52323C9.32796 5.85843 9.66796 6.18963 9.99676 6.53203C10.3016 6.84883 10.1664 7.33043 9.74876 7.44163C9.54956 7.49443 9.37996 7.42963 9.23916 7.28883C9.01196 7.06163 8.78796 6.83043 8.54956 6.58803C8.49356 6.64163 8.44956 6.68163 8.40716 6.72403C7.51596 7.61443 6.62556 8.50563 5.73436 9.39603C5.41916 9.71123 5.14956 9.70963 4.83116 9.39203C4.44396 9.00563 4.05756 8.61843 3.66396 8.22403C3.61836 8.26563 3.57996 8.29683 3.54476 8.33203C2.89356 8.98323 2.24076 9.63203 1.59436 10.2888C1.53596 10.348 1.49436 10.4512 1.49196 10.5344C1.48156 10.9408 1.48636 11.348 1.48796 11.7544C1.48956 12.1416 1.68556 12.34 2.07116 12.3408C2.95836 12.3424 3.84476 12.3384 4.73196 12.3424C5.14156 12.344 5.38076 12.6856 5.25356 13.0744C5.18556 13.2832 5.01676 13.4208 4.78316 13.4224C3.82316 13.4264 2.86156 13.4456 1.90236 13.4152C1.05516 13.3888 0.414358 12.6896 0.405558 11.8312C0.395958 10.8368 0.403158 9.84243 0.402358 8.84803C0.402358 6.61683 0.402358 4.38483 0.402358 2.15363C0.402358 1.06963 1.06076 0.407227 2.13996 0.407227C5.33756 0.407227 8.53516 0.407227 11.7328 0.407227C12.5616 0.407227 13.1864 0.873627 13.3704 1.63043C13.4008 1.75523 13.4176 1.88723 13.4184 2.01523C13.4232 2.73843 13.4232 3.46163 13.42 4.18483C13.4184 4.60483 13.0736 4.84723 12.6792 4.71363C12.4584 4.63843 12.3376 4.45683 12.3368 4.18563C12.3352 3.49603 12.3368 2.80723 12.3368 2.11763C12.3368 1.67443 12.152 1.49123 11.708 1.49123C8.51036 1.49123 5.31276 1.49123 2.11516 1.49123C1.67196 1.49123 1.48796 1.67523 1.48796 2.11923C1.48796 4.30003 1.48796 6.48083 1.48796 8.66163V8.85763H1.48716Z" fill="#808080"/>
                        <path class="tab-icon" d="M15.6 8.00756C15.5944 8.48676 15.372 8.98116 14.9568 9.39636C13.1776 11.1732 11.3968 12.9484 9.62717 14.7348C9.42237 14.942 9.21117 15.0628 8.92557 15.114C8.13197 15.2564 7.34317 15.4276 6.55037 15.5804C6.30717 15.6276 6.07757 15.5596 5.92637 15.3644C5.85277 15.2692 5.80477 15.1092 5.82637 14.9932C5.99197 14.0948 6.17117 13.198 6.36317 12.3044C6.39277 12.1644 6.48317 12.0188 6.58557 11.9164C8.41037 10.082 10.24 8.25076 12.0728 6.42436C12.6768 5.82276 13.5664 5.65716 14.3288 5.98116C15.1048 6.31076 15.6024 7.06116 15.6 8.00836V8.00756ZM13.1712 9.65556C12.6976 9.17556 12.2392 8.71156 11.7616 8.22836C11.728 8.26916 11.692 8.32036 11.648 8.36356C10.3672 9.64596 9.09197 10.934 7.79837 12.2036C7.52077 12.4764 7.33437 12.7572 7.29037 13.1508C7.24637 13.5452 7.15197 13.934 7.07757 14.3348C7.11757 14.3348 7.13997 14.338 7.16077 14.3348C7.65997 14.2412 8.15997 14.1524 8.65677 14.0492C8.75357 14.0292 8.85597 13.9708 8.92637 13.9012C10.3112 12.5236 11.692 11.1412 13.0736 9.75956C13.1128 9.72036 13.1496 9.67876 13.1712 9.65636V9.65556ZM12.58 7.44196C13.0512 7.91476 13.512 8.37636 13.9872 8.85396C14.104 8.72596 14.2464 8.60276 14.348 8.45076C14.5696 8.11876 14.5824 7.75876 14.3952 7.40916C14.208 7.05956 13.896 6.90516 13.5024 6.90676C13.0864 6.90756 12.8224 7.16356 12.5808 7.44276L12.58 7.44196Z" fill="#808080"/>
                        <path class="tab-icon" d="M6.9112 4.2066C6.9104 5.129 6.1968 5.8362 5.2728 5.8306C4.3584 5.8258 3.656 5.117 3.6576 4.2002C3.6592 3.2778 4.3712 2.5714 5.296 2.5762C6.2112 2.581 6.9128 3.289 6.9112 4.2058V4.2066ZM5.2792 4.7458C5.6032 4.7482 5.824 4.5306 5.8264 4.2082C5.8288 3.8842 5.612 3.6634 5.2896 3.661C4.9648 3.6586 4.7448 3.8754 4.7424 4.1978C4.74 4.5226 4.9568 4.7434 5.2792 4.745V4.7458Z" fill="#808080"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_1189_669">
                        <rect width="16" height="16" fill="white"/>
                        </clipPath>
                        </defs>
                        </svg>
                        &nbsp; Shoot Lots
					</button>
				</li>
				@endif

				{{-- Post-production Lots --}}
				@if (count($editor_lots) > 0)
				<li class="nav-item lots-bar tab" role="presentation" onclick="activateTab(2)">
					<button class="nav-link btn-lg tab-button tab-text" id="pills-profile-tab" data-bs-toggle="pill"
						data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
						aria-selected="false">
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1189_669)">
                        <path class="tab-icon" d="M1.48716 8.85763C1.55676 8.79283 1.60156 8.75363 1.64316 8.71203C2.16716 8.18883 2.68956 7.66563 3.21356 7.14243C3.52156 6.83523 3.79516 6.83683 4.10476 7.14643C4.49196 7.53363 4.87916 7.92163 5.27916 8.32323C5.32796 8.27683 5.37276 8.23763 5.41516 8.19523C6.30636 7.30483 7.19676 6.41363 8.08796 5.52323C8.40396 5.20723 8.67436 5.20723 8.99196 5.52323C9.32796 5.85843 9.66796 6.18963 9.99676 6.53203C10.3016 6.84883 10.1664 7.33043 9.74876 7.44163C9.54956 7.49443 9.37996 7.42963 9.23916 7.28883C9.01196 7.06163 8.78796 6.83043 8.54956 6.58803C8.49356 6.64163 8.44956 6.68163 8.40716 6.72403C7.51596 7.61443 6.62556 8.50563 5.73436 9.39603C5.41916 9.71123 5.14956 9.70963 4.83116 9.39203C4.44396 9.00563 4.05756 8.61843 3.66396 8.22403C3.61836 8.26563 3.57996 8.29683 3.54476 8.33203C2.89356 8.98323 2.24076 9.63203 1.59436 10.2888C1.53596 10.348 1.49436 10.4512 1.49196 10.5344C1.48156 10.9408 1.48636 11.348 1.48796 11.7544C1.48956 12.1416 1.68556 12.34 2.07116 12.3408C2.95836 12.3424 3.84476 12.3384 4.73196 12.3424C5.14156 12.344 5.38076 12.6856 5.25356 13.0744C5.18556 13.2832 5.01676 13.4208 4.78316 13.4224C3.82316 13.4264 2.86156 13.4456 1.90236 13.4152C1.05516 13.3888 0.414358 12.6896 0.405558 11.8312C0.395958 10.8368 0.403158 9.84243 0.402358 8.84803C0.402358 6.61683 0.402358 4.38483 0.402358 2.15363C0.402358 1.06963 1.06076 0.407227 2.13996 0.407227C5.33756 0.407227 8.53516 0.407227 11.7328 0.407227C12.5616 0.407227 13.1864 0.873627 13.3704 1.63043C13.4008 1.75523 13.4176 1.88723 13.4184 2.01523C13.4232 2.73843 13.4232 3.46163 13.42 4.18483C13.4184 4.60483 13.0736 4.84723 12.6792 4.71363C12.4584 4.63843 12.3376 4.45683 12.3368 4.18563C12.3352 3.49603 12.3368 2.80723 12.3368 2.11763C12.3368 1.67443 12.152 1.49123 11.708 1.49123C8.51036 1.49123 5.31276 1.49123 2.11516 1.49123C1.67196 1.49123 1.48796 1.67523 1.48796 2.11923C1.48796 4.30003 1.48796 6.48083 1.48796 8.66163V8.85763H1.48716Z" fill="#808080"/>
                        <path class="tab-icon" d="M15.6 8.00756C15.5944 8.48676 15.372 8.98116 14.9568 9.39636C13.1776 11.1732 11.3968 12.9484 9.62717 14.7348C9.42237 14.942 9.21117 15.0628 8.92557 15.114C8.13197 15.2564 7.34317 15.4276 6.55037 15.5804C6.30717 15.6276 6.07757 15.5596 5.92637 15.3644C5.85277 15.2692 5.80477 15.1092 5.82637 14.9932C5.99197 14.0948 6.17117 13.198 6.36317 12.3044C6.39277 12.1644 6.48317 12.0188 6.58557 11.9164C8.41037 10.082 10.24 8.25076 12.0728 6.42436C12.6768 5.82276 13.5664 5.65716 14.3288 5.98116C15.1048 6.31076 15.6024 7.06116 15.6 8.00836V8.00756ZM13.1712 9.65556C12.6976 9.17556 12.2392 8.71156 11.7616 8.22836C11.728 8.26916 11.692 8.32036 11.648 8.36356C10.3672 9.64596 9.09197 10.934 7.79837 12.2036C7.52077 12.4764 7.33437 12.7572 7.29037 13.1508C7.24637 13.5452 7.15197 13.934 7.07757 14.3348C7.11757 14.3348 7.13997 14.338 7.16077 14.3348C7.65997 14.2412 8.15997 14.1524 8.65677 14.0492C8.75357 14.0292 8.85597 13.9708 8.92637 13.9012C10.3112 12.5236 11.692 11.1412 13.0736 9.75956C13.1128 9.72036 13.1496 9.67876 13.1712 9.65636V9.65556ZM12.58 7.44196C13.0512 7.91476 13.512 8.37636 13.9872 8.85396C14.104 8.72596 14.2464 8.60276 14.348 8.45076C14.5696 8.11876 14.5824 7.75876 14.3952 7.40916C14.208 7.05956 13.896 6.90516 13.5024 6.90676C13.0864 6.90756 12.8224 7.16356 12.5808 7.44276L12.58 7.44196Z" fill="#808080"/>
                        <path class="tab-icon" d="M6.9112 4.2066C6.9104 5.129 6.1968 5.8362 5.2728 5.8306C4.3584 5.8258 3.656 5.117 3.6576 4.2002C3.6592 3.2778 4.3712 2.5714 5.296 2.5762C6.2112 2.581 6.9128 3.289 6.9112 4.2058V4.2066ZM5.2792 4.7458C5.6032 4.7482 5.824 4.5306 5.8264 4.2082C5.8288 3.8842 5.612 3.6634 5.2896 3.661C4.9648 3.6586 4.7448 3.8754 4.7424 4.1978C4.74 4.5226 4.9568 4.7434 5.2792 4.745V4.7458Z" fill="#808080"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_1189_669">
                        <rect width="16" height="16" fill="white"/>
                        </clipPath>
                        </defs>
                        </svg>
                        &nbsp; Post-production Lots
					</button>
				</li>
				@endif
			</ul>
		</div>
	</div>

	<div class="row" style="margin-top: 40px;">
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
												    <p class="lot-no-heading">Lot no</p>
												    <p class="your-asset-lotno-underbox" id="lot_number{{$row['lot_id'].$key}}">{{$row['lot_number']}}</p>
												    <p class="file-lot-date-para">
												    <span class="your-asset-lot-date-underbox">
												        <svg width="14" height="20" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4.66667 1.16675V2.91675M9.33333 1.16675V2.91675M2.04167 5.30258H11.9583M12.25 4.95841V9.91675C12.25 11.6667 11.375 12.8334 9.33333 12.8334H4.66667C2.625 12.8334 1.75 11.6667 1.75 9.91675V4.95841C1.75 3.20841 2.625 2.04175 4.66667 2.04175H9.33333C11.375 2.04175 12.25 3.20841 12.25 4.95841Z" stroke="#808080" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M9.15545 7.9917H9.1607M9.15545 9.7417H9.1607M6.99711 7.9917H7.00295M6.99711 9.7417H7.00295M4.8382 7.9917H4.84403M4.8382 9.7417H4.84403" stroke="#808080" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
												    </span>
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

													<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$key}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >
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
													<a href="javascript:void(0)">
													    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    											<path d="M3.47507 12.7498L7.25007 16.5248C7.99675 17.2693 9.00816 17.6873 10.0626 17.6873C11.117 17.6873 12.1284 17.2693 12.8751 16.5248L16.5334 12.8664C17.2779 12.1198 17.696 11.1084 17.696 10.0539C17.696 8.99952 17.2779 7.98812 16.5334 7.24144L12.7501 3.47477C12.3589 3.08252 11.8898 2.77675 11.373 2.57722C10.8562 2.37769 10.3033 2.28884 9.75007 2.31644L5.58341 2.51644C3.91674 2.59144 2.59174 3.91644 2.50841 5.57477L2.30841 9.74144C2.25841 10.8664 2.68341 11.9581 3.47507 12.7498Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    											<path d="M7.91659 9.99967C8.46912 9.99967 8.99902 9.78018 9.38972 9.38948C9.78043 8.99878 9.99992 8.46888 9.99992 7.91634C9.99992 7.36381 9.78043 6.8339 9.38972 6.4432C8.99902 6.0525 8.46912 5.83301 7.91659 5.83301C7.36405 5.83301 6.83415 6.0525 6.44345 6.4432C6.05275 6.8339 5.83325 7.36381 5.83325 7.91634C5.83325 8.46888 6.05275 8.99878 6.44345 9.38948C6.83415 9.78018 7.36405 9.99967 7.91659 9.99967Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    									</svg> &nbsp;
													    Add Tag
													 </a>
												</div>
											</div>
											<div type="button" class="btn border-0 rounded-circle myButton">
													<i class="bi bi-three-dots-vertical" style="color: #9F9F9F;">
													</i>
											</div>
										</div>
										<div class="col-12 d-flex justify-content-between">
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
				<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
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
												<p class="lot-no-heading">Lot no</p>
												<p class="your-asset-lotno-underbox" id="lot_number{{$row['lot_id'].$key}}">{{$row['lot_number']}}</p>
												<p class="file-lot-date-para">
												  <span class="your-asset-lot-date-underbox">Date:</span> &nbsp;<span class="your-asset-lot-date"> {{dateFormet_dmy($row['lot_created_at'])}} </span>
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
													
													<a href="javascript:void(0)" onclick="copyUrlToClipboard('url_{{$row['lot_id'].$key}}' , 'Shoot Lot WRC Image' , 'Shoot WRC')" >Share</a>
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
													<a href="javascript:void(0)">Add Tag</a>
												</div>
											</div>
												 
												<div type="button" class="btn border-0 rounded-circle myButton">
													<i class="bi bi-three-dots-vertical" style="color: #9F9F9F; line-height: 2.5;">
													</i>
												</div>
										</div>
										<div class="col-12 d-flex justify-content-between">
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
