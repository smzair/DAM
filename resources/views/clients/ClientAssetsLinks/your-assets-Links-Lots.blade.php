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
	// dd($catalog_lots, $creative_lots);

@endphp

<div class="row" style="margin-top:24px ;">
	<div class=" col-12 d-flex justify-content-between">
		<h4 class="headingF">
			Your Assets - Links
		</h4>
	</div>
</div>
<div class="row" style="margin-top: 12px;">
	<div class="col-12">
		<p class="underheadingF">
			Currently, you are seeing Your Assets Links Lots.
		</p>
	</div>
</div>

@if (count($creative_lots) > 0 || count($catalog_lots) > 0 )
	<div class="row" style="margin-top: 40px;" id="File">
		<div class="col-lg-12 d-flex your_assets_tab">
			<ul class="nav nav-pills mb-3 nav-fill" id="pills-tab" role="tablist">
				{{-- creative Lots --}}
				@if (count($creative_lots) > 0)
				<li class="nav-item lots-bar" role="presentation">
					<button class="nav-link active btn-lg tab-button" id="pills-home-tab" data-bs-toggle="pill"
						data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
						<svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_839_498)">
								<path d="M0.89997 0.764999C1.07277 0.398599 1.27997 0.327399 1.65197 0.507399C2.79517 1.0602 3.93917 1.6106 5.07997 2.1682C5.20157 2.2274 5.31757 2.313 5.41357 2.4082C6.39677 3.3842 7.37517 4.3658 8.35437 5.345C8.39197 5.3826 8.43197 5.4186 8.47597 5.4602C8.75357 5.2114 9.01277 4.9514 9.29997 4.7274C9.91597 4.2474 10.548 3.789 11.1696 3.3154C11.2464 3.257 11.3088 3.169 11.3544 3.0818C11.512 2.7802 11.6384 2.461 11.8136 2.1714C12.1472 1.6218 12.6648 1.2938 13.264 1.1034C14.0072 0.866599 14.7584 0.652999 15.5088 0.439399C15.8656 0.337799 16.1824 0.620199 16.08 0.958599C15.8352 1.7666 15.5808 2.5714 15.3048 3.369C15.0448 4.1218 14.4872 4.5994 13.776 4.9162C13.6992 4.9506 13.6248 4.9946 13.544 5.013C13.2896 5.0706 13.1376 5.237 13 5.449C12.4624 6.2762 11.8424 7.0402 11.168 7.7602C11.1072 7.825 11.0488 7.8914 10.9488 8.0026C11.0032 8.0354 11.0632 8.057 11.1048 8.0978C12.6176 9.6074 14.1288 11.1194 15.6408 12.6306C16.0544 13.0442 16.212 13.5282 16.012 14.0906C15.9528 14.2578 15.8488 14.4202 15.7304 14.5546C15.5184 14.7954 15.2816 15.0146 15.0528 15.2402C14.5544 15.7322 13.6416 15.693 13.1288 15.165C12.1256 14.1322 11.0968 13.1242 10.0792 12.1066C9.56477 11.5922 9.05037 11.0786 8.53677 10.5626C8.50237 10.5282 8.47837 10.4818 8.44397 10.433C8.10557 10.737 7.79597 11.0202 7.48157 11.2978C6.16077 12.4634 4.82957 13.617 3.39117 14.637C2.96957 14.9362 2.51277 15.1866 2.06877 15.4546C1.84317 15.5906 1.58797 15.6026 1.33517 15.5746C1.15517 15.5546 1.03997 15.425 0.96237 15.2666C0.93677 15.2146 0.91997 15.1586 0.89917 15.1042C0.89917 15.0346 0.89917 14.9658 0.89917 14.8962C0.95117 14.7426 0.98077 14.577 1.05917 14.4386C1.31677 13.9834 1.56717 13.521 1.86637 13.0938C3.04717 11.405 4.38477 9.8418 5.75357 8.3042C5.83437 8.213 5.91437 8.121 6.01197 8.0098C5.95917 7.9674 5.91197 7.9378 5.87357 7.8994C4.87597 6.9034 3.87837 5.9066 2.88397 4.9082C2.80797 4.8322 2.73517 4.745 2.68877 4.6498C2.08957 3.4154 1.49517 2.1786 0.89917 0.941799C0.89917 0.882599 0.89917 0.823399 0.89917 0.763399L0.89997 0.764999ZM9.07037 8.6274C8.64557 8.2034 8.23437 7.793 7.82237 7.381C7.82477 7.3786 7.81277 7.3874 7.80237 7.3978C6.37597 8.909 4.99357 10.4594 3.72237 12.1058C3.17037 12.821 2.66077 13.5698 2.13277 14.3034C2.10477 14.3426 2.08557 14.3874 2.06237 14.4298C2.07437 14.4386 2.08557 14.4482 2.09757 14.457C4.61917 12.7402 6.86317 10.6914 9.07117 8.6266L9.07037 8.6274ZM3.77917 4.5146C4.71677 5.4514 5.66397 6.3978 6.61757 7.3514C7.01437 6.9378 7.42077 6.5154 7.81757 6.1026C6.87117 5.1562 5.93277 4.2178 5.00317 3.2882C4.59757 3.6946 4.18317 4.1098 3.77917 4.5154V4.5146ZM9.73677 7.9594C10.5032 7.2722 11.8928 5.605 12.3408 4.8402C12.0944 4.5938 11.8512 4.3506 11.604 4.1042C10.464 4.8426 9.43597 5.7378 8.48237 6.709C8.90397 7.1298 9.31677 7.5418 9.73597 7.9602L9.73677 7.9594ZM12.2064 10.4978C11.588 9.8802 10.9632 9.2562 10.3344 8.6282C9.92477 9.025 9.50397 9.4322 9.08877 9.8346C9.73197 10.477 10.3608 11.105 10.9808 11.725C11.388 11.3178 11.8024 10.9026 12.2072 10.4986L12.2064 10.4978ZM14.9832 1.5642C14.9704 1.5482 14.9576 1.533 14.9448 1.517C14.388 1.6954 13.8264 1.861 13.276 2.0586C12.98 2.165 12.7296 2.365 12.5656 2.6402C12.4376 2.8554 12.3328 3.0858 12.2296 3.3138C12.2128 3.3506 12.2392 3.4274 12.272 3.4618C12.452 3.6522 12.64 3.8346 12.8248 4.0194C13.0568 4.2514 13.0552 4.2482 13.3664 4.1242C13.908 3.9082 14.308 3.5514 14.504 2.9922C14.6696 2.5178 14.8248 2.0394 14.9848 1.5634L14.9832 1.5642ZM14.1408 12.4266C13.7352 12.8322 13.3216 13.2458 12.9104 13.657C13.2168 13.969 13.5288 14.2986 13.856 14.613C14.0176 14.7682 14.2568 14.7618 14.4232 14.6074C14.6584 14.389 14.8856 14.1618 15.104 13.9266C15.2496 13.7698 15.264 13.5346 15.1192 13.3842C14.7984 13.0498 14.4584 12.7346 14.1416 12.4266H14.1408ZM11.6592 12.3738C11.8592 12.5746 12.064 12.7794 12.2432 12.9594C12.6448 12.5578 13.0584 12.1442 13.468 11.7346C13.28 11.5466 13.0784 11.345 12.8832 11.1498C12.4728 11.5602 12.0584 11.9754 11.6592 12.3746V12.3738ZM2.30397 1.8122C2.62797 2.4826 2.93197 3.1114 3.22637 3.7202C3.56077 3.3858 3.88317 3.0634 4.21197 2.7354C3.59837 2.4386 2.97197 2.1354 2.30397 1.8122Z" fill="#808080"/>
							</g>
							<defs>
								<clipPath id="clip0_839_498">
									<rect width="16" height="16" fill="white" transform="translate(0.5)"/>
								</clipPath>
							</defs>
						</svg>
						&nbsp; Marketing Creative Lots
					</button>
				</li>
				@endif

				{{-- catalog Lots --}}
				@if (count($catalog_lots) > 0)
				<li class="nav-item lots-bar" role="presentation">
					<button class="nav-link btn-lg tab-button" id="pills-profile-tab" data-bs-toggle="pill"
						data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
						aria-selected="false">
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_839_525)">
								<path d="M0.400024 13.343V2.65579C0.500024 2.45579 0.643224 2.33179 0.878424 2.28859C2.45762 2.00059 4.03522 1.70059 5.61282 1.40459C6.52082 1.23419 7.42882 1.06379 8.33682 0.893386C8.69122 0.826986 8.94402 1.02939 8.94962 1.38619C8.95122 1.51499 8.94962 1.64379 8.94962 1.77179C8.94962 2.10139 8.94962 2.43179 8.94962 2.77419C9.02322 2.77419 9.08162 2.77419 9.14002 2.77419C11.0984 2.77419 13.0576 2.77419 15.016 2.77419C15.4296 2.77419 15.5992 2.94539 15.5992 3.36059C15.5992 6.45179 15.5992 9.54379 15.5992 12.635C15.5992 13.0566 15.4296 13.2238 15.0032 13.2238C13.0448 13.2238 11.0856 13.2238 9.12722 13.2238C9.07042 13.2238 9.01362 13.2238 8.94962 13.2238C8.94962 13.7054 8.95282 14.1654 8.94882 14.6246C8.94562 14.9614 8.68402 15.1686 8.35202 15.107C5.88562 14.6454 3.41922 14.1822 0.952024 13.7246C0.701624 13.6782 0.504024 13.5862 0.400024 13.3422V13.343ZM7.99122 14.0742V1.92299C5.77362 2.33899 3.56642 2.75259 1.36002 3.16619V12.8318C3.57442 13.2462 5.77762 13.6598 7.99122 14.0742ZM8.95682 6.57499C9.43922 6.57499 9.90482 6.57179 10.3696 6.57659C10.6416 6.57979 10.8448 6.78299 10.8488 7.04219C10.8528 7.30699 10.6488 7.51419 10.3696 7.52379C10.2608 7.52779 10.152 7.52459 10.0432 7.52459C9.68322 7.52459 9.32402 7.52459 8.95922 7.52459V8.47499C9.42242 8.47499 9.87682 8.47339 10.3312 8.47499C10.636 8.47659 10.848 8.67259 10.8488 8.94779C10.8496 9.22299 10.6376 9.42219 10.3336 9.42379C9.92802 9.42619 9.52242 9.42379 9.11682 9.42379C9.06402 9.42379 9.01202 9.42379 8.96162 9.42379V10.3742C9.41762 10.3742 9.86322 10.3742 10.308 10.3742C10.6352 10.3742 10.852 10.5678 10.8488 10.8534C10.8464 11.1334 10.632 11.3222 10.3128 11.3238C9.91202 11.3254 9.51122 11.3238 9.11042 11.3238C9.05842 11.3238 9.00642 11.3238 8.95842 11.3238V12.2638H14.6384V3.73259H8.96002V4.67419C9.42002 4.67419 9.86963 4.67339 10.3192 4.67419C10.6352 4.67499 10.8496 4.86939 10.8496 5.14939C10.8496 5.43019 10.6344 5.62219 10.3176 5.62299C9.91682 5.62459 9.51602 5.62299 9.11522 5.62299C9.06322 5.62299 9.01122 5.62299 8.95762 5.62299V6.57339L8.95682 6.57499Z" fill="#808080"/>
								<path d="M5.43202 7.87133C5.80402 8.29613 6.16802 8.71293 6.53202 9.12893C6.65922 9.27373 6.78802 9.41773 6.91202 9.56493C7.10402 9.79293 7.09282 10.0737 6.88882 10.2537C6.68402 10.4337 6.40002 10.4145 6.20322 10.1929C5.77922 9.71613 5.36162 9.23373 4.94162 8.75453C4.90962 8.71773 4.87522 8.68333 4.83362 8.63773C4.54882 9.00413 4.26962 9.36253 3.99042 9.72093C3.88082 9.86173 3.77282 10.0025 3.66242 10.1425C3.46002 10.3993 3.18322 10.4465 2.95042 10.2657C2.73602 10.0993 2.71682 9.81533 2.90882 9.56653C3.30722 9.04973 3.70962 8.53613 4.10962 8.02013C4.13682 7.98493 4.16242 7.94973 4.19682 7.90333C3.90002 7.56333 3.60482 7.22653 3.31042 6.88893C3.18322 6.74333 3.05522 6.59933 2.92962 6.45293C2.72162 6.20973 2.72642 5.92813 2.94082 5.74173C3.15282 5.55773 3.43362 5.59053 3.64642 5.83133C4.00962 6.24253 4.37042 6.65693 4.73122 7.06973C4.74722 7.08813 4.76002 7.10893 4.78562 7.14413C4.83122 7.08813 4.86482 7.04813 4.89682 7.00653C5.32162 6.46013 5.74642 5.91373 6.17122 5.36733C6.30002 5.20173 6.46402 5.11453 6.67602 5.16253C6.86562 5.20573 6.98722 5.32893 7.03522 5.51853C7.07762 5.68653 7.01762 5.82813 6.91522 5.95853C6.44722 6.55933 5.98002 7.16013 5.51282 7.76173C5.48882 7.79293 5.46562 7.82493 5.43122 7.87053L5.43202 7.87133Z" fill="#808080"/>
								<path d="M12.7496 5.62414C12.5968 5.62414 12.4432 5.62734 12.2904 5.62414C12.0088 5.61694 11.8032 5.41694 11.8016 5.15294C11.8 4.88814 12.0056 4.68094 12.284 4.67694C12.5952 4.67214 12.9064 4.67214 13.2176 4.67694C13.496 4.68174 13.7008 4.88974 13.6992 5.15454C13.6968 5.41294 13.496 5.61454 13.224 5.62414C13.0664 5.62974 12.908 5.62494 12.7496 5.62574V5.62414Z" fill="#808080"/>
								<path d="M12.7505 6.57512C12.9089 6.57512 13.0665 6.57112 13.2249 6.57592C13.4953 6.58392 13.6969 6.78712 13.6993 7.04552C13.7017 7.30472 13.5017 7.51512 13.2321 7.52152C12.9113 7.52872 12.5897 7.52872 12.2689 7.52152C11.9993 7.51512 11.7993 7.30392 11.8017 7.04472C11.8041 6.78632 12.0057 6.58392 12.2769 6.57512C12.4345 6.57032 12.5929 6.57432 12.7513 6.57432L12.7505 6.57512Z" fill="#808080"/>
								<path d="M12.7567 8.47541C12.9095 8.47541 13.0631 8.47221 13.2159 8.47541C13.4943 8.48261 13.6999 8.68821 13.6983 8.95221C13.6967 9.21061 13.4959 9.41621 13.2239 9.42181C12.9079 9.42821 12.5911 9.42821 12.2751 9.42181C12.0031 9.41621 11.8023 9.21141 11.7999 8.95301C11.7975 8.68821 12.0031 8.48261 12.2815 8.47541C12.4399 8.47141 12.5975 8.47541 12.7559 8.47541H12.7567Z" fill="#808080"/>
								<path d="M12.7512 10.3751C12.9096 10.3751 13.0672 10.3711 13.2256 10.3759C13.4952 10.3847 13.6976 10.5879 13.6984 10.8471C13.7 11.1055 13.4992 11.3159 13.2296 11.3223C12.9088 11.3295 12.5872 11.3295 12.2664 11.3223C11.9976 11.3159 11.7976 11.1031 11.8008 10.8447C11.804 10.5863 12.0056 10.3847 12.2768 10.3767C12.4344 10.3719 12.5928 10.3759 12.7512 10.3767V10.3751Z" fill="#808080"/>
							</g>
							<defs>
								<clipPath id="clip0_839_525">
									<rect width="16" height="16" fill="white"/>
								</clipPath>
							</defs>
						</svg>
						&nbsp; Listing Lots
					</button>
				</li>
				@endif
			</ul>
		</div>
	</div>

	<div class="row" style="margin-top: 40px;">
		<div class="tab-content" id="pills-tabContent">
			{{-- shoot lots --}}
			@if (count($creative_lots) > 0)
				<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
					tabindex="0">
					<div class="row box-container-responsive">
						<div class="col-12">
							<p class="totallotF">Total Lots: {{count($creative_lots)}}</p>
						</div>
						@foreach ($creative_lots as $key => $row)
							@php
								$lot_created_at = $row['lot_created_at'];
								$submission_date = $row['submission_date'];
								$lot_id_is = base64_encode($row['id']);
							@endphp
							<div class="col-lg-3 col-md-6 box border-0" style="position: relative;">
								<div class="row">
									<div class="under-content-div">
										
										<div class="col-12 d-flex">
											<h3 class="lotnoF">
												<span>Lot no : <span id="lot_number{{$row['id'].$key}}">{{$row['lot_number']}}</span>
												<span type="button" class="btn border-0 rounded-circle myButton">
													<i class="bi bi-three-dots-vertical" style="color: #9F9F9F;line-height: 2.5;">
													</i>
												</span>
												<div class="myPopover d-none" style="display: none;">
													<a href="javascript:void(0)" onclick="toggleSidebar();">View Details</a>
													<div class="d-none">
														<span id="wrc_numbers{{$row['id'].$key}}">{{ $row['wrc_numbers'] }}</span>
													</div>
													<a href="javascript:void(0)">Favorite</a>
													<a href="javascript:void(0)">Add Tag</a>
												</div>
											</h3>
										</div>
										<div class="col-12">
											<p class="lot-date">Lot date : {{dateFormet_dmy($row['lot_created_at'])}}</p>
										</div>
										<div class="col-12 d-flex justify-content-between">
											<div>
												<p class="inward-qty">Inward Quantity : </p>
												<p class="inward-qty-num">
													{{$row['inward_qty'] != '' ? $row['inward_qty'] : 0}}
												</p>
											</div>
											<div>
												<p class="inward-qty">Submission</p>
												<p class="inward-qty-num">
													{{$submission_date != '' ? dateFormet_dmy($submission_date) : $submission_date }}
												</p>
											</div>
										</div>
										<div class="col-12 d-grid gap-2">
											<a role="button" class="btn border rounded-0 view-img " href="{{route('your_assets_creative_wrcs_links' , ['lot_id' => $lot_id_is])}}">
												View Links
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
			@if (count($catalog_lots) > 0)
				<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
					tabindex="0">
					<div class="row box-container-responsive">
						<div class="col-12">
							<p class="totallotF">Total Lots: {{count($catalog_lots)}}</p>
						</div>
						@foreach ($catalog_lots as $key => $row)
							@php
								$lot_created_at = $row['lot_created_at'];
								$submission_date = $row['submission_date'];
								$lot_id_is = base64_encode($row['id']);
							@endphp
							<div class="col-lg-3 col-md-6 box border-0" style="position: relative;">
								<div class="row">
									<div class="under-content-div">
										
										<div class="col-12 d-flex">
											<h3 class="lotnoF">
												<span>Lot no : <span id="lot_number{{$row['id'].$key}}">{{$row['lot_number']}}</span>
												<span type="button" class="btn border-0 rounded-circle myButton">
													<i class="bi bi-three-dots-vertical" style="color: #9F9F9F; line-height: 2.5;">
													</i>
												</span>
												<div class="myPopover d-none" style="display: none;">
												
													<a href="javascript:void(0)" onclick="toggleSidebar(); ">View Details</a>

													<div class="d-none">
														<span id="lot_date{{$row['id'].$key}}">{{dateFormet_dmy($row['lot_created_at'])}}</span>
													</div>
													
													
													<a href="javascript:void(0)">Favorite</a>
													<a href="javascript:void(0)">Add Tag</a>
												</div>
											</h3>
										</div>
										<div class="col-12">
											<p class="lot-date">Lot date : {{dateFormet_dmy($row['lot_created_at'])}}</p>
										</div>
										<div class="col-12 d-flex justify-content-between">
											<div>
												<p class="inward-qty">Inward Quantity : </p>
												<p class="inward-qty-num">
													{{$row['inward_qty'] != '' ? $row['inward_qty'] : 0}}
												</p>
											</div>
											<div>
												<p class="inward-qty">Submission</p>
												<p class="inward-qty-num">
													{{$submission_date != '' ? dateFormet_dmy($submission_date) : $submission_date }}
												</p>
											</div>
										</div>
										<div class="col-12 d-grid gap-2">
											<a role="button" class="btn border rounded-0 view-img " href="{{route('your_assets_cataloging_wrcs_links' , ['lot_id' => $lot_id_is])}}">
												View Links
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
@endsection
