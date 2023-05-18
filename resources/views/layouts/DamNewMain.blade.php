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
    	background: #0F0F0F;
		}
		.viewport{
			margin-top: 60px;
			height: calc(100vh - 60px);
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
				<nav class="navbar navbar-expand-md fixed-top">
					{{-- logo --}}
					<a class="navbar-brand mt-1 ms-3" href="{{route('home')}}">
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

						{{-- <form action="{{route('gloableSearch')}}" method="post">
						@csrf --}}
						<div class="input-group ms-auto  nav-searchbar">
								<input type="text" class="form-control rounded-0" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" style="background: #1A1A1A;" name="search_query" value="{{$search_query}}">
								<div class="input-group-append">
									<button class="btn btn-outline-secondary border border-left-0 rounded-0" type="submit" style="background: #1A1A1A;">
										<svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M15.2362 14.6666L13.9028 13.3333M8.23616 13.9999C9.06787 13.9999 9.89143 13.8361 10.6598 13.5178C11.4282 13.1995 12.1264 12.733 12.7145 12.1449C13.3026 11.5568 13.7691 10.8586 14.0874 10.0902C14.4057 9.32185 14.5695 8.49829 14.5695 7.66658C14.5695 6.83488 14.4057 6.01132 14.0874 5.24292C13.7691 4.47453 13.3026 3.77635 12.7145 3.18824C12.1264 2.60014 11.4282 2.13363 10.6598 1.81535C9.89143 1.49707 9.06787 1.33325 8.23616 1.33325C6.55646 1.33325 4.94555 2.00051 3.75782 3.18824C2.57009 4.37597 1.90283 5.98688 1.90283 7.66658C1.90283 9.34629 2.57009 10.9572 3.75782 12.1449C4.94555 13.3327 6.55646 13.9999 8.23616 13.9999Z" stroke="#D1D1D1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>              
									</button>
								</div>
							</div>
						{{-- </form> --}}

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
								<button class="mySvg clickable accordion-button siderbar-button {{$active_tab == 1 ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse"
									data-bs-target="#flush-collapseOne" aria-expanded="{{$active_tab == 1 ? 'true' : 'flase'}}" aria-controls="flush-collapseOne">
									<svg class=" mySvg clickable"  width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path class="shape"  d="M9.839 19.5001C9.666 19.3581 9.466 19.2381 9.323 19.0701C7.482 16.9181 5.647 14.7601 3.815 12.6011C2.903 11.5261 2.427 10.2631 2.344 8.87207C2.149 5.57307 3.502 3.06907 6.352 1.41207C7.656 0.654069 9.103 0.409069 10.608 0.528069C12.242 0.657069 13.695 1.23507 14.938 2.30607C16.42 3.58307 17.311 5.19607 17.594 7.13407C17.8 8.55007 17.612 9.91807 17.035 11.2291C16.778 11.8111 16.408 12.3201 15.997 12.8021C14.193 14.9211 12.39 17.0401 10.58 19.1541C10.461 19.2931 10.285 19.3851 10.136 19.4991H9.839V19.5001ZM9.992 17.8161C10.023 17.7751 10.037 17.7541 10.053 17.7351C11.728 15.7661 13.41 13.8031 15.073 11.8241C15.364 11.4781 15.63 11.0891 15.814 10.6781C16.495 9.15807 16.525 7.59607 15.958 6.03807C14.741 2.70007 11.28 1.09107 8.008 2.14207C5.401 2.97907 3.656 5.40607 3.637 8.14607C3.628 9.44807 3.933 10.6651 4.786 11.6851C6.068 13.2171 7.368 14.7331 8.662 16.2551C9.098 16.7681 9.535 17.2801 9.992 17.8161Z" fill="white"/>
										<path class="shape"  d="M9.99001 11.8831C7.95001 11.8881 6.27701 10.2171 6.27101 8.16809C6.26501 6.12409 7.92201 4.45609 9.97601 4.43909C12.015 4.42209 13.705 6.11009 13.704 8.16409C13.702 10.2121 12.038 11.8791 9.99101 11.8831H9.99001ZM12.377 8.15809C12.374 6.83509 11.296 5.76409 9.97501 5.77009C8.66201 5.77609 7.59601 6.85109 7.60001 8.16509C7.60301 9.48909 8.68101 10.5621 10.001 10.5541C11.314 10.5461 12.381 9.47109 12.377 8.15809Z" fill="white"/>
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
								<button class="mySvg clickable accordion-button siderbar-button {{$active_tab == 2 ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse"
									data-bs-target="#flush-collapseTwo" aria-expanded="{{$active_tab == 2 ? 'true' : 'flase'}}" aria-controls="flush-collapseTwo">
									<svg class=" mySvg clickable" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path class="shape" d="M0.499993 3.59692C0.603993 3.23192 0.783993 2.91692 1.14799 2.76492C1.32599 2.69092 1.52799 2.63892 1.71899 2.63692C3.18499 2.62692 4.65099 2.63092 6.11699 2.63092C6.57699 2.63092 6.93799 2.81992 7.20399 3.19692C7.56399 3.70692 7.93199 4.21092 8.28999 4.72292C8.36199 4.82592 8.43999 4.86092 8.56299 4.86092C10.79 4.85692 13.017 4.85892 15.243 4.85792C15.74 4.85792 16.144 5.03992 16.37 5.49492C16.457 5.66992 16.491 5.88592 16.495 6.08392C16.509 6.83792 16.501 7.59292 16.501 8.34792C16.501 8.41492 16.501 8.48292 16.501 8.57192C16.575 8.57692 16.64 8.58392 16.705 8.58392C17.163 8.58992 17.622 8.57192 18.077 8.60392C19.166 8.67992 19.82 9.79092 19.34 10.7679C18.316 12.8519 17.273 14.9269 16.238 17.0059C16.115 17.2529 15.92 17.3689 15.643 17.3679C11.016 17.3659 6.38899 17.3679 1.76299 17.3659C1.13799 17.3659 0.724993 17.0569 0.532993 16.4649C0.525993 16.4429 0.510993 16.4229 0.498993 16.4019C0.498993 12.1329 0.498993 7.86492 0.498993 3.59592L0.499993 3.59692ZM1.93599 16.2469C1.99099 16.2509 2.01499 16.2539 2.03999 16.2539C6.43899 16.2539 10.837 16.2539 15.236 16.2579C15.353 16.2579 15.395 16.2059 15.439 16.1169C15.847 15.2919 16.258 14.4679 16.668 13.6439C17.216 12.5439 17.765 11.4439 18.311 10.3429C18.475 10.0129 18.333 9.75692 17.965 9.70892C17.91 9.70192 17.854 9.69892 17.799 9.69892C13.679 9.69892 9.55899 9.69892 5.43899 9.69592C5.13199 9.69592 4.93599 9.80992 4.80299 10.0989C4.05899 11.7149 3.29999 13.3239 2.54699 14.9349C2.34599 15.3649 2.14699 15.7949 1.93599 16.2469ZM1.62599 3.74492V14.2639C1.67499 14.1659 1.70299 14.1129 1.72799 14.0579C2.42099 12.5749 3.11099 11.0909 3.81099 9.61092C3.90199 9.41792 4.01999 9.22892 4.16399 9.07292C4.50799 8.69792 4.96199 8.58292 5.45799 8.58392C8.68099 8.58592 11.904 8.58492 15.127 8.58492C15.21 8.58492 15.293 8.58492 15.372 8.58492V5.97192H15.136C12.934 5.97192 10.731 5.96892 8.52899 5.97392C8.04299 5.97492 7.67399 5.78992 7.39799 5.38992C7.05399 4.89192 6.69199 4.40492 6.34499 3.90792C6.26199 3.78992 6.17399 3.73992 6.02599 3.74092C4.62799 3.74692 3.22999 3.74492 1.83199 3.74492H1.62599Z" fill="white"/>
									</svg>&nbsp;&nbsp;
									YOUR ASSETS
								</button>
							</h2>
							<div id="flush-collapseTwo" class="accordion-collapse collapse {{$active_tab == 2 ? 'show' : ''}}" aria-labelledby="flush-headingTwo"
              data-bs-parent="#accordionFlushExample">
								<div class="accordion-body">
									<a href="{{route('your_assets_files')}}" role="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'your_assets_files' ? 'active' : ''}}"
										style="width: 100%;">File</a>
									<a href="javascript:void(0)" role="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button"
										style="width: 100%;">Links</a>
									<a href="javascript:void(0)" role="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button"
										style="width: 100%;">Favorites</a>
								</div>
							</div>
						</div>

						{{-- 3rd tab --}}
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-headingThree">
								<button class="mySvg clickable accordion-button siderbar-button {{$active_tab == 3 ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse"
									data-bs-target="#flush-collapseThree" aria-expanded="{{$active_tab == 3 ? "true" : "flase"}}" aria-controls="flush-collapseThree">
									<svg class=" mySvg clickable" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path class="shape" d="M14.67 19.4999C14.325 19.3639 14.187 19.1099 14.212 18.7429C14.229 18.4909 14.22 18.2359 14.212 17.9829C14.21 17.9309 14.164 17.8469 14.122 17.8359C13.59 17.6909 13.138 17.4139 12.758 17.0149C12.439 17.1969 12.132 17.3819 11.816 17.5499C11.577 17.6769 11.299 17.6169 11.12 17.4259C10.944 17.2379 10.901 16.9639 11.039 16.7409C11.101 16.6409 11.2 16.5529 11.3 16.4889C11.539 16.3359 11.788 16.1979 12.036 16.0599C12.122 16.0119 12.163 15.9689 12.132 15.8579C12 15.3829 12 14.9049 12.133 14.4299C12.161 14.3299 12.13 14.2849 12.048 14.2389C11.794 14.0979 11.543 13.9519 11.293 13.8049C10.971 13.6149 10.868 13.2609 11.044 12.9649C11.214 12.6789 11.568 12.5989 11.886 12.7779C12.176 12.9409 12.463 13.1089 12.758 13.2789C13.161 12.8529 13.641 12.5749 14.218 12.4359C14.218 12.0729 14.211 11.7149 14.22 11.3569C14.227 11.0649 14.431 10.8489 14.722 10.8009C14.98 10.7579 15.25 10.9039 15.348 11.1579C15.387 11.2589 15.399 11.3739 15.401 11.4839C15.408 11.7979 15.403 12.1129 15.403 12.4369C15.973 12.5759 16.454 12.8499 16.854 13.2809C17.162 13.1029 17.459 12.9289 17.759 12.7589C17.98 12.6339 18.201 12.6469 18.405 12.7919C18.606 12.9339 18.678 13.1379 18.639 13.3779C18.609 13.5679 18.497 13.7019 18.333 13.7969C18.04 13.9669 17.748 14.1379 17.451 14.3109C17.604 14.8439 17.614 15.3679 17.479 15.8949C17.468 15.9359 17.516 16.0169 17.558 16.0429C17.805 16.1949 18.06 16.3349 18.31 16.4829C18.638 16.6769 18.744 17.0209 18.571 17.3189C18.396 17.6199 18.051 17.6979 17.717 17.5089C17.433 17.3479 17.15 17.1829 16.856 17.0139C16.524 17.3589 16.141 17.6219 15.687 17.7729C15.402 17.8679 15.403 17.8699 15.403 18.1699C15.403 18.3489 15.392 18.5299 15.405 18.7079C15.432 19.0719 15.308 19.3449 14.967 19.5019H14.67V19.4999ZM14.812 16.7189C15.69 16.7189 16.386 16.0219 16.385 15.1429C16.384 14.2699 15.679 13.5629 14.809 13.5619C13.941 13.5619 13.227 14.2709 13.223 15.1369C13.22 16.0189 13.922 16.7179 14.812 16.7179V16.7189Z" fill="white"/>
										<path class="shape" d="M2.53799 15.9379C2.62699 15.9379 2.69899 15.9379 2.77199 15.9379C4.91799 15.9379 7.06299 15.9379 9.20899 15.9379C9.58999 15.9379 9.85099 16.1819 9.85199 16.5289C9.85199 16.8409 9.61799 17.0969 9.30499 17.1219C9.24999 17.1259 9.19399 17.1239 9.13799 17.1239C6.78199 17.1239 4.42599 17.1239 2.07 17.1239C1.564 17.1239 1.34599 16.9079 1.34599 16.4039C1.34599 15.5379 1.34499 14.6729 1.34599 13.8069C1.34899 11.9179 2.63399 10.3819 4.49299 10.0499C4.66899 10.0189 4.84899 10.0029 5.02799 10.0019C7.28499 9.99789 9.54199 9.99889 11.799 9.99889C12.148 9.99889 12.401 10.2249 12.429 10.5509C12.454 10.8349 12.244 11.1129 11.953 11.1719C11.875 11.1879 11.793 11.1849 11.713 11.1849C9.51799 11.1849 7.32299 11.1829 5.12799 11.1859C3.88699 11.1879 2.86099 12.0139 2.59199 13.2219C2.56499 13.3419 2.54099 13.4659 2.53999 13.5879C2.53499 14.3609 2.53799 15.1329 2.53799 15.9349V15.9379Z" fill="white"/>
										<path class="shape" d="M8.471 8.413C6.291 8.413 4.517 6.643 4.512 4.466C4.507 2.285 6.29 0.5 8.473 0.5C10.656 0.5 12.44 2.288 12.432 4.468C12.424 6.648 10.651 8.414 8.47 8.413H8.471ZM8.474 7.226C10.005 7.225 11.252 5.977 11.245 4.452C11.239 2.931 9.998 1.691 8.479 1.688C6.95 1.685 5.702 2.929 5.699 4.456C5.696 5.982 6.943 7.227 8.474 7.226Z" fill="white"/>
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
      var svgs = document.querySelectorAll(".mySvg");

      svgs.forEach(function (svg) {
        var rect = svg.querySelector(".shape");
        var initialColor = rect.getAttribute("fill");
        var isBlack = false;

        svg.addEventListener("click", function () {
          if (isBlack) {
            rect.setAttribute("fill", initialColor);
            isBlack = false;
          } else {
            rect.setAttribute("fill", "black");
            isBlack = true;
          }
        });
      });
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
		const set_date_time = (key) => {
			const lot_number = $("#lot_number"+key).html()
			const lot_date = $("#lot_date"+key).html()
			const lot_time = $("#lot_time"+key).html()
			$("#lot_time").html(lot_time)
			$("#lot_date").html(lot_date)
			$("#lot_number").html(lot_number)
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

@yield('js_scripts')
</body>
</html>