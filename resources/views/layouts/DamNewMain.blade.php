<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title')</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="{{ asset('ClientsPlugins/bootstrap-5.1.3-dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('ClientsPlugins/fontawesome-free/css/all.min.css') }}">

  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}"> 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
	@yield('css_links')

  <link rel="icon" href="{{ asset('IMG/ODN Logo.jpeg')}}">
	<link rel="stylesheet" href="{{ asset('css/dam_new_style_odn.css')}}">
	<style>
		.accordion-item .accordion-body   .active{
			color: #FFF866;
    	background:#0F0F0F;
		}
		.viewport{
			margin-top: 73px;
			height: calc(100vh - 73px);
		}
		
		.initial-svg {
      display: block;
       }

    .replacement-svg {
      display: none;
     }
     
       #searchBar::placeholder {
            color: #D1D1D1; /* Default placeholder color */
        }
        
        #searchBar.inactive::placeholder {
            color: #D1D1D1; /* Inactive placeholder color */
        }
	</style>

	@yield('other_css')
	<style>
		.btn-primary , .btn-success , .btn-secondary{
			padding: 10px !important;
		}
	</style>
</head>

<body>
	<div class="wrapper">
    <?php 
      $user_data = Auth::user();         
      $ClientNotification = getNotificationList($user_data);
      $tot_notification = count($ClientNotification);
      // dd($tot_notification , $ClientNotification);
			$search_query = "";
			if(isset($other_data)){
				if(isset($other_data['search_query'])){
					$search_query = $other_data['search_query'];
				}
			}

			$get_active_url_data = get_active_url_data();
			$active_tab = $get_active_url_data['active_tab'];
			$active_link = $get_active_url_data['active_link'];

    ?>

		<!-- ODN given code -->
		<div class="container-fluid">
			<!-- Top navigation bar -->
			<div class="row">
				<nav class="navbar navbar-expand-md border border-dark fixed-top">
					{{-- logo --}}
					<a class="navbar-brand my-2 ms-3" href="{{route('home')}}">
						<svg width="73" height="24" viewBox="0 0 73 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M0 12.0006C0 5.12916 5.29653 0 12.5027 0C19.6426 0 24.9391 5.09545 24.9391 12.0006C24.9391 18.9057 19.6438 24 12.5027 24C5.29653 24 0 18.872 0 12.0006ZM21.5859 12.0006C21.5859 6.80517 17.6981 2.98358 12.5027 2.98358C7.23987 2.98358 3.35203 6.80517 3.35203 12.0006C3.35203 17.196 7.23987 21.0129 12.5027 21.0129C17.6981 21.0129 21.5871 17.196 21.5871 12.0006H21.5859Z" fill="#FFF866"/>
							<path d="M27.3857 0.268311H37.2779C44.8188 0.268311 49.9468 5.03367 49.9468 12.0004C49.9468 18.9671 44.8153 23.7313 37.2779 23.7313H27.3857V0.268311ZM37.0734 20.8152C42.872 20.8152 46.5925 17.2621 46.5925 12.0004C46.5925 6.73874 42.8732 3.18448 37.0734 3.18448H30.7378V20.8152H37.0734Z" fill="#FFF866"/>
							<path d="M72.5696 0.268311V23.7313H69.822L55.7432 6.23431V23.7313H52.3877V0.268311H55.1365L69.2176 17.7653V0.268311H72.5696Z" fill="#FFF866"/>
							</svg>        
					</a>
					{{-- navbarCollapse btn --}}
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
						<span class="navbar-toggler-icon">
							<svg viewBox="0 0 100 80" width="30" height="30">
								<rect width="100" height="20"></rect>
								<rect y="30" width="100" height="20"></rect>
								<rect y="60" width="100" height="20"></rect>
							</svg>
						</span>
					</button>

					<div class="collapse navbar-collapse" id="navbarCollapse">

					 <form action="{{route('gloableSearch')}}" method="post" class="ms-4" style="width:50%;">
						@csrf
						<div class="input-group ms-auto  nav-searchbar" style="width:59%;">
								<input type="text" id="searchBar" class="form-control rounded-0" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" style="background: #1A1A1A;border: 1px solid #D1D1D1;" name="search_query" value="{{$search_query}}">
								<div class="input-group-append">
									<button class="btn btn-outline-secondary border border-start-0 rounded-0" type="submit" style="background: #1A1A1A;border: 1px solid #D1D1D1;">
										<svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M15.2362 14.6666L13.9028 13.3333M8.23616 13.9999C9.06787 13.9999 9.89143 13.8361 10.6598 13.5178C11.4282 13.1995 12.1264 12.733 12.7145 12.1449C13.3026 11.5568 13.7691 10.8586 14.0874 10.0902C14.4057 9.32185 14.5695 8.49829 14.5695 7.66658C14.5695 6.83488 14.4057 6.01132 14.0874 5.24292C13.7691 4.47453 13.3026 3.77635 12.7145 3.18824C12.1264 2.60014 11.4282 2.13363 10.6598 1.81535C9.89143 1.49707 9.06787 1.33325 8.23616 1.33325C6.55646 1.33325 4.94555 2.00051 3.75782 3.18824C2.57009 4.37597 1.90283 5.98688 1.90283 7.66658C1.90283 9.34629 2.57009 10.9572 3.75782 12.1449C4.94555 13.3327 6.55646 13.9999 8.23616 13.9999Z" stroke="#D1D1D1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>              
									</button>
								</div>
							</div>
					 </form> 

						<ul class="navbar-nav ms-auto me-3">
							{{-- notification bell --}}
							<li class="nav-item mt-1" style="padding-right: 56px; margin-top: 12px"> 
								<svg width="37" height="36" viewBox="0 0 37 36" fill="none" xmlns="http://www.w3.org/2000/svg">
									<circle cx="18.5696" cy="18" r="18" fill="#1A1A1A"/>
									<path d="M18.5695 13.3667V16.1417M18.5862 9.66675C15.5195 9.66675 13.0362 12.1501 13.0362 15.2167V16.9667C13.0362 17.5334 12.8028 18.3834 12.5112 18.8667L11.4528 20.6334C10.8028 21.7251 11.2528 22.9417 12.4528 23.3417C16.4372 24.6667 20.7434 24.6667 24.7278 23.3417C24.9907 23.254 25.2306 23.1084 25.4296 22.9155C25.6287 22.7227 25.7819 22.4876 25.8779 22.2276C25.9739 21.9676 26.0102 21.6894 25.9843 21.4134C25.9583 21.1375 25.8707 20.8709 25.7278 20.6334L24.6695 18.8667C24.3778 18.3834 24.1445 17.5251 24.1445 16.9667V15.2167C24.1362 12.1667 21.6362 9.66675 18.5862 9.66675Z" stroke="#D1D1D1" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
									<path d="M21.3447 24.25C21.3447 25.775 20.0947 27.025 18.5697 27.025C17.8113 27.025 17.1113 26.7083 16.6113 26.2083C16.1113 25.7083 15.7947 25.0083 15.7947 24.25" fill="#D1D1D1"/>
									</svg><span class="notify-count">{{$tot_notification}}</span>
							</li>
							{{-- user name --}}
							<li class="nav-item">
								<a class="nav-link" href="#" style="color: #D1D1D1;font-weight: 500;font-size: 14px;margin-top: 5px">{{ ucwords($user_data->name) }}</a>
							</li>
							{{-- user profile image --}}
							<li class="nav-item">
								<svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
									<circle cx="23" cy="23" r="23" fill="#808080"/>
									</svg>            
							</li>
						</ul>
					</div>
				</nav>
			</div>
			<!-- Top navigation bar END -->
			
			<!-- Sidebar start -->
			<div class="row viewport">
				<div class="col-lg-2 border border-dark border-end-0 sidebar-position">
					<div class="accordion accordion-flush" id="accordionFlushExample">
						@php
							// pre($get_active_url_data);
						@endphp
						{{-- 1st tab --}}
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-headingOne">
								<button class="mySvg clickable border border-dark border-top-0 border-start-0 border-end-0 svg-container accordion-button siderbar-button {{$active_tab == 1 ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse"
									data-bs-target="#flush-collapseOne" aria-expanded="{{$active_tab == 1 ? 'true' : 'flase'}}" aria-controls="flush-collapseOne" onclick="swapSVG(event)">
									<svg class="initial-svg" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.839 19.4996C9.666 19.3576 9.466 19.2376 9.323 19.0696C7.482 16.9176 5.647 14.7596 3.815 12.6006C2.903 11.5256 2.427 10.2626 2.344 8.87158C2.149 5.57258 3.502 3.06858 6.352 1.41158C7.656 0.653581 9.103 0.408581 10.608 0.527581C12.242 0.656581 13.695 1.23458 14.938 2.30558C16.42 3.58258 17.311 5.19558 17.594 7.13358C17.8 8.54958 17.612 9.91758 17.035 11.2286C16.778 11.8106 16.408 12.3196 15.997 12.8016C14.193 14.9206 12.39 17.0396 10.58 19.1536C10.461 19.2926 10.285 19.3846 10.136 19.4986H9.839V19.4996ZM9.992 17.8156C10.023 17.7746 10.037 17.7536 10.053 17.7346C11.728 15.7656 13.41 13.8026 15.073 11.8236C15.364 11.4776 15.63 11.0886 15.814 10.6776C16.495 9.15758 16.525 7.59558 15.958 6.03758C14.741 2.69958 11.28 1.09058 8.008 2.14158C5.401 2.97858 3.656 5.40558 3.637 8.14558C3.628 9.44758 3.933 10.6646 4.786 11.6846C6.068 13.2166 7.368 14.7326 8.662 16.2546C9.098 16.7676 9.535 17.2796 9.992 17.8156Z" fill="white"/>
										<path d="M9.99001 11.8826C7.95001 11.8876 6.27701 10.2166 6.27101 8.1676C6.26501 6.1236 7.92201 4.4556 9.97601 4.4386C12.015 4.4216 13.705 6.1096 13.704 8.1636C13.702 10.2116 12.038 11.8786 9.99101 11.8826H9.99001ZM12.377 8.1576C12.374 6.8346 11.296 5.7636 9.97501 5.7696C8.66201 5.7756 7.59601 6.8506 7.60001 8.1646C7.60301 9.4886 8.68101 10.5616 10.001 10.5536C11.314 10.5456 12.381 9.4706 12.377 8.1576Z" fill="white"/>
										</svg>
	
										<svg class="replacement-svg" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M9.839 19.4996C9.666 19.3576 9.466 19.2376 9.323 19.0696C7.482 16.9176 5.647 14.7596 3.815 12.6006C2.903 11.5256 2.427 10.2626 2.344 8.87158C2.149 5.57258 3.502 3.06858 6.352 1.41158C7.656 0.653581 9.103 0.408581 10.608 0.527581C12.242 0.656581 13.695 1.23458 14.938 2.30558C16.42 3.58258 17.311 5.19558 17.594 7.13358C17.8 8.54958 17.612 9.91758 17.035 11.2286C16.778 11.8106 16.408 12.3196 15.997 12.8016C14.193 14.9206 12.39 17.0396 10.58 19.1536C10.461 19.2926 10.285 19.3846 10.136 19.4986H9.839V19.4996ZM9.992 17.8156C10.023 17.7746 10.037 17.7536 10.053 17.7346C11.728 15.7656 13.41 13.8026 15.073 11.8236C15.364 11.4776 15.63 11.0886 15.814 10.6776C16.495 9.15758 16.525 7.59558 15.958 6.03758C14.741 2.69958 11.28 1.09058 8.008 2.14158C5.401 2.97858 3.656 5.40558 3.637 8.14558C3.628 9.44758 3.933 10.6646 4.786 11.6846C6.068 13.2166 7.368 14.7326 8.662 16.2546C9.098 16.7676 9.535 17.2796 9.992 17.8156Z" fill="#0F0F0F"/>
											<path d="M9.99001 11.8826C7.95001 11.8876 6.27701 10.2166 6.27101 8.1676C6.26501 6.1236 7.92201 4.4556 9.97601 4.4386C12.015 4.4216 13.705 6.1096 13.704 8.1636C13.702 10.2116 12.038 11.8786 9.99101 11.8826H9.99001ZM12.377 8.1576C12.374 6.8346 11.296 5.7636 9.97501 5.7696C8.66201 5.7756 7.59601 6.8506 7.60001 8.1646C7.60301 9.4886 8.68101 10.5616 10.001 10.5536C11.314 10.5456 12.381 9.4706 12.377 8.1576Z" fill="#0F0F0F"/>
										</svg> &nbsp;&nbsp;
									TRACK LOTS
								</button>
							</h2>
							<div id="flush-collapseOne" class="accordion-collapse collapse {{$active_tab == 1 ? 'show' : ''}}" aria-labelledby="flush-headingOne"
								data-bs-parent="#accordionFlushExample">
								<div class="accordion-body">
									<a href="{{route('TrackLots', ['lotStatus' => 'active'])}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'active_lot' ? 'active' : ''}}"
										style="width: 100%;">Active</a>
									<a href="{{route('TrackLots', ['lotStatus' => 'completed'])}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'completed_lot' ? 'active' : ''}}"
										style="width: 100%;">Completed</a>
								</div>
							</div>
						</div>

						{{-- 2nd tab --}}
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-headingTwo">
								<button class="mySvg clickable svg-container border border-dark border-top-0 border-start-0 border-end-0 accordion-button siderbar-button {{$active_tab == 2 ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse"
									data-bs-target="#flush-collapseTwo" aria-expanded="{{$active_tab == 2 ? 'true' : 'flase'}}" aria-controls="flush-collapseTwo" onclick="swapSVG(event)">
									<svg class="initial-svg" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M0.500023 3.59667C0.604023 3.23167 0.784023 2.91667 1.14802 2.76467C1.32602 2.69067 1.52802 2.63867 1.71902 2.63667C3.18502 2.62667 4.65102 2.63067 6.11702 2.63067C6.57702 2.63067 6.93802 2.81967 7.20402 3.19667C7.56402 3.70667 7.93202 4.21067 8.29002 4.72267C8.36202 4.82567 8.44002 4.86067 8.56302 4.86067C10.79 4.85667 13.017 4.85867 15.243 4.85767C15.74 4.85767 16.144 5.03967 16.37 5.49467C16.457 5.66967 16.491 5.88567 16.495 6.08367C16.509 6.83767 16.501 7.59267 16.501 8.34767C16.501 8.41467 16.501 8.48267 16.501 8.57167C16.575 8.57667 16.64 8.58367 16.705 8.58367C17.163 8.58967 17.622 8.57167 18.077 8.60367C19.166 8.67967 19.82 9.79067 19.34 10.7677C18.316 12.8517 17.273 14.9267 16.238 17.0057C16.115 17.2527 15.92 17.3687 15.643 17.3677C11.016 17.3657 6.38902 17.3677 1.76302 17.3657C1.13802 17.3657 0.725023 17.0567 0.533023 16.4647C0.526023 16.4427 0.511023 16.4227 0.499023 16.4017C0.499023 12.1327 0.499023 7.86467 0.499023 3.59567L0.500023 3.59667ZM1.93602 16.2467C1.99102 16.2507 2.01502 16.2537 2.04002 16.2537C6.43902 16.2537 10.837 16.2537 15.236 16.2577C15.353 16.2577 15.395 16.2057 15.439 16.1167C15.847 15.2917 16.258 14.4677 16.668 13.6437C17.216 12.5437 17.765 11.4437 18.311 10.3427C18.475 10.0127 18.333 9.75667 17.965 9.70867C17.91 9.70167 17.854 9.69867 17.799 9.69867C13.679 9.69867 9.55902 9.69867 5.43902 9.69567C5.13202 9.69567 4.93602 9.80967 4.80302 10.0987C4.05902 11.7147 3.30002 13.3237 2.54702 14.9347C2.34602 15.3647 2.14702 15.7947 1.93602 16.2467ZM1.62602 3.74467V14.2637C1.67502 14.1657 1.70302 14.1127 1.72802 14.0577C2.42102 12.5747 3.11102 11.0907 3.81102 9.61067C3.90202 9.41767 4.02002 9.22867 4.16402 9.07267C4.50802 8.69767 4.96202 8.58267 5.45802 8.58367C8.68102 8.58567 11.904 8.58467 15.127 8.58467C15.21 8.58467 15.293 8.58467 15.372 8.58467V5.97167H15.136C12.934 5.97167 10.731 5.96867 8.52902 5.97367C8.04302 5.97467 7.67402 5.78967 7.39802 5.38967C7.05402 4.89167 6.69202 4.40467 6.34502 3.90767C6.26202 3.78967 6.17402 3.73967 6.02602 3.74067C4.62802 3.74667 3.23002 3.74467 1.83202 3.74467H1.62602Z" fill="white" />
									</svg>

									<svg class="replacement-svg" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M0.500023 3.59667C0.604023 3.23167 0.784023 2.91667 1.14802 2.76467C1.32602 2.69067 1.52802 2.63867 1.71902 2.63667C3.18502 2.62667 4.65102 2.63067 6.11702 2.63067C6.57702 2.63067 6.93802 2.81967 7.20402 3.19667C7.56402 3.70667 7.93202 4.21067 8.29002 4.72267C8.36202 4.82567 8.44002 4.86067 8.56302 4.86067C10.79 4.85667 13.017 4.85867 15.243 4.85767C15.74 4.85767 16.144 5.03967 16.37 5.49467C16.457 5.66967 16.491 5.88567 16.495 6.08367C16.509 6.83767 16.501 7.59267 16.501 8.34767C16.501 8.41467 16.501 8.48267 16.501 8.57167C16.575 8.57667 16.64 8.58367 16.705 8.58367C17.163 8.58967 17.622 8.57167 18.077 8.60367C19.166 8.67967 19.82 9.79067 19.34 10.7677C18.316 12.8517 17.273 14.9267 16.238 17.0057C16.115 17.2527 15.92 17.3687 15.643 17.3677C11.016 17.3657 6.38902 17.3677 1.76302 17.3657C1.13802 17.3657 0.725023 17.0567 0.533023 16.4647C0.526023 16.4427 0.511023 16.4227 0.499023 16.4017C0.499023 12.1327 0.499023 7.86467 0.499023 3.59567L0.500023 3.59667ZM1.93602 16.2467C1.99102 16.2507 2.01502 16.2537 2.04002 16.2537C6.43902 16.2537 10.837 16.2537 15.236 16.2577C15.353 16.2577 15.395 16.2057 15.439 16.1167C15.847 15.2917 16.258 14.4677 16.668 13.6437C17.216 12.5437 17.765 11.4437 18.311 10.3427C18.475 10.0127 18.333 9.75667 17.965 9.70867C17.91 9.70167 17.854 9.69867 17.799 9.69867C13.679 9.69867 9.55902 9.69867 5.43902 9.69567C5.13202 9.69567 4.93602 9.80967 4.80302 10.0987C4.05902 11.7147 3.30002 13.3237 2.54702 14.9347C2.34602 15.3647 2.14702 15.7947 1.93602 16.2467ZM1.62602 3.74467V14.2637C1.67502 14.1657 1.70302 14.1127 1.72802 14.0577C2.42102 12.5747 3.11102 11.0907 3.81102 9.61067C3.90202 9.41767 4.02002 9.22867 4.16402 9.07267C4.50802 8.69767 4.96202 8.58267 5.45802 8.58367C8.68102 8.58567 11.904 8.58467 15.127 8.58467C15.21 8.58467 15.293 8.58467 15.372 8.58467V5.97167H15.136C12.934 5.97167 10.731 5.96867 8.52902 5.97367C8.04302 5.97467 7.67402 5.78967 7.39802 5.38967C7.05402 4.89167 6.69202 4.40467 6.34502 3.90767C6.26202 3.78967 6.17402 3.73967 6.02602 3.74067C4.62802 3.74667 3.23002 3.74467 1.83202 3.74467H1.62602Z" fill="#0F0F0F"/>
									</svg>&nbsp;&nbsp;
									YOUR ASSETS
								</button>
							</h2>
							<div id="flush-collapseTwo" class="accordion-collapse collapse {{$active_tab == 2 ? 'show' : ''}}" aria-labelledby="flush-headingTwo"
              data-bs-parent="#accordionFlushExample">
								<div class="accordion-body">
									<a href="{{route('your_assets_files')}}" role="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'your_assets_files' ? 'active' : ''}}"
										style="width: 100%;">File</a>
									<a href="{{route('your_assets_Links')}}" role="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'your_assets_Links' ? 'active' : ''}}"
										style="width: 100%;">Links</a>
									<a href="javascript:void(0)" role="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button"
										style="width: 100%;">Favorites</a>
								</div>
							</div>
						</div>

						{{-- 3rd tab --}}
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-headingThree">
								<button class="mySvg clickable svg-container border border-dark border-top-0 border-start-0 border-end-0 accordion-button siderbar-button {{$active_tab == 3 ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse"
									data-bs-target="#flush-collapseThree" aria-expanded="{{$active_tab == 3 ? "true" : "flase"}}" aria-controls="flush-collapseThree" onclick="swapSVG(event)">
									<svg class="initial-svg" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M14.6699 19.5004C14.3249 19.3644 14.1869 19.1104 14.2119 18.7434C14.2289 18.4914 14.2199 18.2364 14.2119 17.9834C14.2099 17.9314 14.1639 17.8474 14.1219 17.8364C13.5899 17.6914 13.1379 17.4144 12.7579 17.0154C12.4389 17.1974 12.1319 17.3824 11.8159 17.5504C11.5769 17.6774 11.2989 17.6174 11.1199 17.4264C10.9439 17.2384 10.9009 16.9644 11.0389 16.7414C11.1009 16.6414 11.1999 16.5534 11.2999 16.4894C11.5389 16.3364 11.7879 16.1984 12.0359 16.0604C12.1219 16.0124 12.1629 15.9694 12.1319 15.8584C11.9999 15.3834 11.9999 14.9054 12.1329 14.4304C12.1609 14.3304 12.1299 14.2854 12.0479 14.2394C11.7939 14.0984 11.5429 13.9524 11.2929 13.8054C10.9709 13.6154 10.8679 13.2614 11.0439 12.9654C11.2139 12.6794 11.5679 12.5994 11.8859 12.7784C12.1759 12.9414 12.4629 13.1094 12.7579 13.2794C13.1609 12.8534 13.6409 12.5754 14.2179 12.4364C14.2179 12.0734 14.2109 11.7154 14.2199 11.3574C14.2269 11.0654 14.4309 10.8494 14.7219 10.8014C14.9799 10.7584 15.2499 10.9044 15.3479 11.1584C15.3869 11.2594 15.3989 11.3744 15.4009 11.4844C15.4079 11.7984 15.4029 12.1134 15.4029 12.4374C15.9729 12.5764 16.4539 12.8504 16.8539 13.2814C17.1619 13.1034 17.4589 12.9294 17.7589 12.7594C17.9799 12.6344 18.2009 12.6474 18.4049 12.7924C18.6059 12.9344 18.6779 13.1384 18.6389 13.3784C18.6089 13.5684 18.4969 13.7024 18.3329 13.7974C18.0399 13.9674 17.7479 14.1384 17.4509 14.3114C17.6039 14.8444 17.6139 15.3684 17.4789 15.8954C17.4679 15.9364 17.5159 16.0174 17.5579 16.0434C17.8049 16.1954 18.0599 16.3354 18.3099 16.4834C18.6379 16.6774 18.7439 17.0214 18.5709 17.3194C18.3959 17.6204 18.0509 17.6984 17.7169 17.5094C17.4329 17.3484 17.1499 17.1834 16.8559 17.0144C16.5239 17.3594 16.1409 17.6224 15.6869 17.7734C15.4019 17.8684 15.4029 17.8704 15.4029 18.1704C15.4029 18.3494 15.3919 18.5304 15.4049 18.7084C15.4319 19.0724 15.3079 19.3454 14.9669 19.5024H14.6699V19.5004ZM14.8119 16.7194C15.6899 16.7194 16.3859 16.0224 16.3849 15.1434C16.3839 14.2704 15.6789 13.5634 14.8089 13.5624C13.9409 13.5624 13.2269 14.2714 13.2229 15.1374C13.2199 16.0194 13.9219 16.7184 14.8119 16.7184V16.7194Z" fill="white"/>
										<path d="M2.53803 15.9381C2.62703 15.9381 2.69903 15.9381 2.77203 15.9381C4.91803 15.9381 7.06302 15.9381 9.20902 15.9381C9.59002 15.9381 9.85102 16.1821 9.85202 16.5291C9.85202 16.8411 9.61802 17.0971 9.30503 17.1221C9.25002 17.1261 9.19402 17.1241 9.13802 17.1241C6.78202 17.1241 4.42603 17.1241 2.07003 17.1241C1.56403 17.1241 1.34603 16.9081 1.34603 16.4041C1.34603 15.5381 1.34503 14.6731 1.34603 13.8071C1.34903 11.9181 2.63403 10.3821 4.49303 10.0501C4.66903 10.0191 4.84903 10.0031 5.02803 10.0021C7.28503 9.99813 9.54202 9.99913 11.799 9.99913C12.148 9.99913 12.401 10.2251 12.429 10.5511C12.454 10.8351 12.244 11.1131 11.953 11.1721C11.875 11.1881 11.793 11.1851 11.713 11.1851C9.51802 11.1851 7.32303 11.1831 5.12803 11.1861C3.88703 11.1881 2.86103 12.0141 2.59203 13.2221C2.56503 13.3421 2.54103 13.4661 2.54003 13.5881C2.53503 14.3611 2.53803 15.1331 2.53803 15.9351V15.9381Z" fill="white"/>
										<path d="M8.47097 8.413C6.29097 8.413 4.51697 6.643 4.51197 4.466C4.50697 2.285 6.28997 0.5 8.47297 0.5C10.656 0.5 12.44 2.288 12.432 4.468C12.424 6.648 10.651 8.414 8.46997 8.413H8.47097ZM8.47397 7.226C10.005 7.225 11.252 5.977 11.245 4.452C11.239 2.931 9.99797 1.691 8.47897 1.688C6.94997 1.685 5.70197 2.929 5.69897 4.456C5.69597 5.982 6.94297 7.227 8.47397 7.226Z" fill="white"/>
										</svg>
										<svg  class="replacement-svg"  width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M14.6699 19.5004C14.3249 19.3644 14.1869 19.1104 14.2119 18.7434C14.2289 18.4914 14.2199 18.2364 14.2119 17.9834C14.2099 17.9314 14.1639 17.8474 14.1219 17.8364C13.5899 17.6914 13.1379 17.4144 12.7579 17.0154C12.4389 17.1974 12.1319 17.3824 11.8159 17.5504C11.5769 17.6774 11.2989 17.6174 11.1199 17.4264C10.9439 17.2384 10.9009 16.9644 11.0389 16.7414C11.1009 16.6414 11.1999 16.5534 11.2999 16.4894C11.5389 16.3364 11.7879 16.1984 12.0359 16.0604C12.1219 16.0124 12.1629 15.9694 12.1319 15.8584C11.9999 15.3834 11.9999 14.9054 12.1329 14.4304C12.1609 14.3304 12.1299 14.2854 12.0479 14.2394C11.7939 14.0984 11.5429 13.9524 11.2929 13.8054C10.9709 13.6154 10.8679 13.2614 11.0439 12.9654C11.2139 12.6794 11.5679 12.5994 11.8859 12.7784C12.1759 12.9414 12.4629 13.1094 12.7579 13.2794C13.1609 12.8534 13.6409 12.5754 14.2179 12.4364C14.2179 12.0734 14.2109 11.7154 14.2199 11.3574C14.2269 11.0654 14.4309 10.8494 14.7219 10.8014C14.9799 10.7584 15.2499 10.9044 15.3479 11.1584C15.3869 11.2594 15.3989 11.3744 15.4009 11.4844C15.4079 11.7984 15.4029 12.1134 15.4029 12.4374C15.9729 12.5764 16.4539 12.8504 16.8539 13.2814C17.1619 13.1034 17.4589 12.9294 17.7589 12.7594C17.9799 12.6344 18.2009 12.6474 18.4049 12.7924C18.6059 12.9344 18.6779 13.1384 18.6389 13.3784C18.6089 13.5684 18.4969 13.7024 18.3329 13.7974C18.0399 13.9674 17.7479 14.1384 17.4509 14.3114C17.6039 14.8444 17.6139 15.3684 17.4789 15.8954C17.4679 15.9364 17.5159 16.0174 17.5579 16.0434C17.8049 16.1954 18.0599 16.3354 18.3099 16.4834C18.6379 16.6774 18.7439 17.0214 18.5709 17.3194C18.3959 17.6204 18.0509 17.6984 17.7169 17.5094C17.4329 17.3484 17.1499 17.1834 16.8559 17.0144C16.5239 17.3594 16.1409 17.6224 15.6869 17.7734C15.4019 17.8684 15.4029 17.8704 15.4029 18.1704C15.4029 18.3494 15.3919 18.5304 15.4049 18.7084C15.4319 19.0724 15.3079 19.3454 14.9669 19.5024H14.6699V19.5004ZM14.8119 16.7194C15.6899 16.7194 16.3859 16.0224 16.3849 15.1434C16.3839 14.2704 15.6789 13.5634 14.8089 13.5624C13.9409 13.5624 13.2269 14.2714 13.2229 15.1374C13.2199 16.0194 13.9219 16.7184 14.8119 16.7184V16.7194Z" fill="#0F0F0F" />
									<path d="M2.53803 15.9381C2.62703 15.9381 2.69903 15.9381 2.77203 15.9381C4.91803 15.9381 7.06302 15.9381 9.20902 15.9381C9.59002 15.9381 9.85102 16.1821 9.85202 16.5291C9.85202 16.8411 9.61802 17.0971 9.30503 17.1221C9.25002 17.1261 9.19402 17.1241 9.13802 17.1241C6.78202 17.1241 4.42603 17.1241 2.07003 17.1241C1.56403 17.1241 1.34603 16.9081 1.34603 16.4041C1.34603 15.5381 1.34503 14.6731 1.34603 13.8071C1.34903 11.9181 2.63403 10.3821 4.49303 10.0501C4.66903 10.0191 4.84903 10.0031 5.02803 10.0021C7.28503 9.99813 9.54202 9.99913 11.799 9.99913C12.148 9.99913 12.401 10.2251 12.429 10.5511C12.454 10.8351 12.244 11.1131 11.953 11.1721C11.875 11.1881 11.793 11.1851 11.713 11.1851C9.51802 11.1851 7.32303 11.1831 5.12803 11.1861C3.88703 11.1881 2.86103 12.0141 2.59203 13.2221C2.56503 13.3421 2.54103 13.4661 2.54003 13.5881C2.53503 14.3611 2.53803 15.1331 2.53803 15.9351V15.9381Z"fill="#0F0F0F"/>
									<path d="M8.47097 8.413C6.29097 8.413 4.51697 6.643 4.51197 4.466C4.50697 2.285 6.28997 0.5 8.47297 0.5C10.656 0.5 12.44 2.288 12.432 4.468C12.424 6.648 10.651 8.414 8.46997 8.413H8.47097ZM8.47397 7.226C10.005 7.225 11.252 5.977 11.245 4.452C11.239 2.931 9.99797 1.691 8.47897 1.688C6.94997 1.685 5.70197 2.929 5.69897 4.456C5.69597 5.982 6.94297 7.227 8.47397 7.226Z" fill="#0F0F0F"/>
									</svg>&nbsp;&nbsp;
									ADMIN PANEL
								</button>
							</h2>
							<div id="flush-collapseThree" class="accordion-collapse collapse {{$active_tab == 3 ? 'show' : ''}}" aria-labelledby="flush-headingThree"
              data-bs-parent="#accordionFlushExample">
								<div class="accordion-body">
									<a href="{{route('Client_Users_list')}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'manage_user' ? 'active' : ''}}"
										style="width: 100%;">Manage user</a>

									<a href="{{route('ClientProfile')}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'ClientProfile' ? 'active' : ''}}"
										style="width: 100%;">Your profile</a>

										<a href="{{route('Client_Setting_new')}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'Client_Setting_new' ? 'active' : ''}}"
										style="width: 100%;">Settings</a>
								</div>
							</div>
						</div>

						{{-- Logout btn --}}
						<div class="col log-btn">
							<button type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  class="btn border-0 btn-lg log-out-button">
							    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M18.529 13.141C18.423 13.07 18.3 13.032 18.171 13.032C17.89 13.032 17.634 13.206 17.487 13.498C16.121 16.211 13.421 17.896 10.441 17.896C9.06602 17.896 7.69101 17.528 6.46302 16.831C3.52402 15.163 1.97102 11.689 2.68702 8.38495C3.43702 4.92395 6.29102 2.41395 9.79101 2.13895C11.916 1.97095 13.853 2.59095 15.523 3.97895C16.353 4.66795 17.015 5.52295 17.548 6.59295C17.668 6.83295 17.892 6.97595 18.148 6.97595C18.255 6.97595 18.359 6.95095 18.459 6.90095C18.797 6.72995 18.931 6.33495 18.762 6.00095C17.359 3.21795 15.098 1.50095 12.043 0.896953C11.809 0.850953 11.573 0.821953 11.324 0.791953C11.217 0.778953 11.111 0.765953 11.004 0.751953H9.85001H9.83002C9.72602 0.765953 9.62202 0.778953 9.51802 0.792953C9.28202 0.822953 9.03802 0.854953 8.80202 0.893953C5.25702 1.47595 2.22302 4.33295 1.42402 7.83995C1.35302 8.15395 1.30902 8.46995 1.26302 8.80895C1.24102 8.96795 1.22002 9.12695 1.19502 9.28495C1.18802 9.32695 1.18002 9.36795 1.16902 9.41895L1.16602 10.571V10.59C1.17902 10.681 1.18902 10.773 1.20102 10.868C1.22602 11.083 1.25102 11.286 1.28402 11.491C1.62702 13.582 2.68502 15.509 4.26502 16.917C5.84702 18.326 7.88102 19.152 9.99302 19.241C10.141 19.247 10.29 19.25 10.436 19.25C12.784 19.25 14.882 18.43 16.671 16.814C17.526 16.042 18.223 15.109 18.743 14.04C18.908 13.701 18.822 13.339 18.528 13.141H18.529Z" fill="white"/>
									<path d="M11.712 11.2731C11.581 11.4041 11.45 11.5341 11.319 11.6651L11.309 11.6751C11.045 11.9381 10.772 12.2091 10.508 12.4801C10.355 12.6371 10.285 12.8381 10.311 13.0451C10.337 13.2481 10.45 13.4201 10.63 13.5301C10.739 13.5961 10.856 13.6301 10.976 13.6301C11.162 13.6301 11.341 13.5501 11.493 13.3991C12.103 12.7931 12.71 12.1851 13.317 11.5761L13.71 11.1821C14.426 10.4651 14.429 9.54012 13.717 8.82512C13.023 8.12812 12.326 7.43312 11.63 6.73812L11.526 6.63512C11.462 6.57112 11.408 6.52112 11.353 6.48412C11.242 6.40912 11.114 6.37012 10.982 6.37012C10.783 6.37012 10.593 6.46012 10.46 6.61612C10.233 6.88112 10.247 7.25912 10.491 7.51312C10.758 7.79112 11.037 8.06812 11.307 8.33612L11.329 8.35812C11.455 8.48312 11.58 8.60712 11.705 8.73312C11.736 8.76412 11.766 8.79712 11.804 8.83812L12.254 9.32312H8.66903C8.66903 9.32312 7.55803 9.32112 7.33803 9.32112C7.04003 9.32112 6.74203 9.32112 6.44403 9.32512C6.21203 9.32712 6.01103 9.42212 5.88003 9.59112C5.75403 9.75312 5.71303 9.95812 5.76503 10.1681C5.84403 10.4871 6.10703 10.6781 6.47103 10.6781C7.22903 10.6781 7.98703 10.6781 8.74503 10.6781H12.271L11.806 11.1721C11.768 11.2121 11.74 11.2431 11.711 11.2721L11.712 11.2731Z" fill="white"/>
									</svg>&nbsp;LOG OUT</button>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						</div>

					</div>
				</div>
				<!-- Sidebar End -->

				<div class="col-sm-10 border border-dark main-container-resp offset-lg-2">
          @yield('main_content')
				</div>
			</div>
		</div>
		<!-- ODN given code END -->
	</div><!-- wrapper End -->

	<script src="{{ asset('ClientsPlugins/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('ClientsPlugins\jquery\jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('ClientsPlugins\jquery-nice-select-1.1.0\js\jquery.nice-select.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
	@yield('js_links')
	<!-- Common Js -->
	<script src="{{ asset('ClientsDist\js\common_js_new.js') }}"></script>
	{{-- Svg script --}}
	<script>
           function swapSVG(event) {
      var container = event.currentTarget;
      var initialSVG = container.querySelector(".initial-svg");
      var replacementSVG = container.querySelector(".replacement-svg");
    
      if (initialSVG.style.display !== "none") {
        initialSVG.style.display = "none";
        replacementSVG.style.display = "block";
      } else {
        initialSVG.style.display = "block";
        replacementSVG.style.display = "none";
      }
    }
    </script>
	{{-- myPopover script --}}
	<script>
		var buttons = document.getElementsByClassName("myButton");
		var popovers = document.getElementsByClassName("myPopover");

		for (var i = 0; i < buttons.length; i++) {
			buttons[i].addEventListener("click", createToggleHandler(i));
		}

		function createToggleHandler(index) {
			return function() {
				var popover = popovers[index];
				if (popover.style.display === "none") {
					popover.style.display = "block";
				} else {
					popover.style.display = "none";
				}
			};
		}
	</script>
{{-- script for copy to --}}
<script>
  async function copyUrlToClipboard(id_is , module_is = "Image Download" , action_is = "") {
    const element = document.getElementById(id_is);
		const url_is = element.innerHTML;
    console.log('url_is', url_is)
		navigator.clipboard.writeText(url_is);

		await $.ajax({
			url: "{{ url('Client-user-activty-log') }}",
			type: "POST",
			dataType: 'json',
			data: {
				text: url_is,
				action : action_is,
				module: module_is,
				_token: '{{ csrf_token() }}'
			},
			success: function(res) {
				console.log(res)
			}
		});
		alert("Download Url copied to clipboard!");
  }
</script>
{{-- right sidebar toggle script --}}
<script>
	function toggleSidebar() {
		var sidebar = document.querySelector('.sidebar');
		sidebar.classList.toggle('open');
	}
</script>

	{{-- Setting data and time in side bar --}}
	<script>
		const set_date_time = (key , service = 'other') => {
			const lot_number = $("#lot_number"+key).html()
			const lot_date = $("#lot_date"+key).html()
			const lot_time = $("#lot_time"+key).html()
			$("#lot_time").html(lot_time)
			$("#lot_date").html(lot_date)
			$("#lot_number").html(lot_number)

			const image_src = $("#image_src"+key).html()
			$("#image_src").attr("src", image_src);

			if(service == 'shoot'){
				$("#s_type").html($("#s_type"+key).html())
				$("#skus_count").html($("#skus_count"+key).html())
				$("#raw_images").html($("#raw_images"+key).html())
				$("#edited_images").html($("#edited_images"+key).html())
				$("#wrc_numbers").html($("#wrc_numbers"+key).html())
				$("#shoot_files_details").removeClass('d-none')
			}else{
				$("#shoot_files_details").addClass('d-none')
			}
		}
	</script>

	{{-- Editing details --}}
	<script>
		const editing_lots_details = async (id ,service = 'lot' , img_type = 'Raw' ) => {
			$("#file_size").html('')
			await $.ajax({
				url: "{{ url('editing-file-size') }}",
				type: "POST",
				dataType: 'json',
				data: {
					id,
					service,
					img_type,
					_token: '{{ csrf_token() }}'
				},
				success: function(res) {
					console.log('res', res)
					let ReadableSize = "File not Found!"
					if(res.is_file_get){
						ReadableSize = res.ReadableSize
					}
					$("#file_size").html(ReadableSize)
				}
			});
		}
	</script>

	{{-- Shoot details --}}
	<script>
		const lots_details = async (id ,service = 'lot' , img_type = 'Raw' ) => {
			$("#file_size").html('')
			await $.ajax({
				url: "{{ url('shoot-file-size') }}",
				type: "POST",
				dataType: 'json',
				data: {
					id,
					service,
					img_type,
					_token: '{{ csrf_token() }}'
				},
				success: function(res) {
					console.log('res', res)
					let ReadableSize = "File not Found!"
					if(res.is_file_get){
						ReadableSize = res.ReadableSize
					}
					$("#file_size").html(ReadableSize)
				}
			});
		}
	</script>
	
	<!--searchbar placeholder color script-->
	<script>
		const searchBar = document.getElementById('searchBar');

		searchBar.addEventListener('focus', function() {
			searchBar.classList.remove('inactive');
		});

		searchBar.addEventListener('blur', function() {
			if (searchBar.value === '') {
				searchBar.classList.add('inactive');
			}
		});
	</script>

    @yield('js_scripts')
</body>
</html>