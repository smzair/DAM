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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

	@yield('css_links')

  <link rel="icon" href="{{ asset('IMG/ODN Logo.jpeg')}}">
	<link rel="stylesheet" href="{{ asset('css/dam_new_style_odn.css')}}">
	<link rel="stylesheet" href="{{ asset('css/DamMobStyle.css')}}">
	<style>
		.accordion-item .accordion-body   .active{
			color: #FFF300;
    	background:#0F0F0F;
		}
		.viewport{
			margin-top: 107px;
			height: calc(100vh - 111px);
		}
		
		.initial-svg {
      display: block;
       }

    .replacement-svg {
      display: none;
     }
     
       #searchBar::placeholder {
            color: #808080; /* Default placeholder color */
        }
        
        #searchBar.inactive::placeholder {
            color: #808080; /* Inactive placeholder color */
        }
        
        /* submission_date done css */
        .submission_date{
            color: #808080;
            font-size: 12px;
            font-style: normal;
            font-weight: 400;
            line-height: 16px;
            letter-spacing: 0.4px;
            margin:0px;
        }
	</style>

	<style>
		.url-copied , .url-copied-new{
			background: #0F0F0F;
			border: 1px solid var(--neutral-700, #333);
			box-shadow: 6px 24px 40px 0px rgba(255, 255, 255, 0.06);
			width: 338px;
		}
		.url-copied-text{
			color: #FFF;
			/* DAM/Title/Medium */
			font-family: Poppins;
			font-size: 16px;
			font-style: normal;
			font-weight: 500;
			line-height: 24px;
			letter-spacing: 0.15px;
			margin-top: 0px;
			margin-bottom: 0px;
		}
		.url-copied-link{
			display: flex;
			align-items: center;
			gap: 16px;
			padding: 16px 12px;
			background: rgba(152, 167, 218, 0.10);
			margin-top: 8px;
		}
		.url-copied-link-text{
			color: var(--success-300, #98A7DA);
			font-family: Poppins;
			font-size: 16px;
			font-style: normal;
			font-weight: 400;
			line-height: 24px;
			letter-spacing: 0.5px;
			margin-top: 0px;
			margin-bottom: 0px;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		.url-copied-element{
				padding: 24px;
		}

		/* favourites section */
		.added-fav-div , .Multipal-fav-div{
				background: var(--tertiary-700-main, #50AB64);
				position: fixed;
				left: 50%;
				transform: translate(-50%, -50%);
		}
		.added-fav-and-notfav-Text{
			color: var(--shades-0, #FFF);
			/* DAM/Label/Large */
			font-family: Poppins;
			font-size: 14px;
			font-style: normal;
			font-weight: 500;
			line-height: 20px;
			letter-spacing: 0.1px;
			padding:16px;
			text-align: center;
			position: relative;
			top: auto;
			margin: 0px;
		}
		
		.Multipal-fav-and-notfav-Text{
		    color: var(--shades-0, #FFF);
			/* DAM/Label/Large */
			font-family: Poppins;
			font-size: 14px;
			font-style: normal;
			font-weight: 500;
			line-height: 20px;
			letter-spacing: 0.1px;
			padding:16px;
			text-align: center;
			position: relative;
			top: auto;
			margin: 0px;
		}

		.added-notfav-div{
			background: var(--error-500, #F26B6B);
			position: fixed;
			left: 50%;
			transform: translate(-50%, -50%);
		}
	</style>

	@yield('other_css')
	<style>
		.btn-primary , .btn-success , .btn-secondary{
			padding: 10px !important;
		}
	</style>
	
	<!--Notifiaction click on bell icon-->
	
	<style>
	 /* Styles for the popover container */
    .notification-popover-container {
      position: relative;
      display: inline-block;
      cursor:pointer;
    }

    /* Styles for the popover content */
    .popover-for-notifaction {
      display: none;
      position: absolute;
      top: 36px;
      right: -20px;
      padding: 24px;
      background: #0F0F0F;
      border: 1px solid #333333!important;
      border-radius: 4px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
      z-index: 2;
      width: 400px;
      border-radius: 0px;
      box-shadow: 4px 16px 40px rgba(255, 255, 255, 0.06);
    }

    .notificatio-pop-heading {
      background: #1A1A1A;
      color: #FFFFFF;
      font-weight: 500;
      font-size: 22px;
      margin: -23px -23px 0px -23px;
      padding: 24px 0px 16px 24px;
    }

    .active-notification {
      font-weight: 500;
      font-size: 14px;
      letter-spacing: 0.1px;
      color: #FFFFFF;
      margin-top: 16px;
      margin-bottom: 0px;
      cursor: pointer;
    }

    .Inactive-notification {
      font-weight: 400;
      font-size: 14px;
      letter-spacing: 0.25px;
      color: #808080;
      margin-bottom: 0px;
      cursor: pointer;
    }

    .notification-time {
      font-weight: 500;
      font-size: 11px;
      letter-spacing: 0.5px;
      color: #4D4D4D;
      margin-top: 4px;
    }
    
     .No-notifications-rec {
      font-weight: 400;
      font-size: 14px;
      letter-spacing: 0.25px;
      color: #808080;
      margin-bottom:0px;
    }

    .hr-line {
      color: #9F9F9F;
    }

    .content {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.5s ease;
    }

    .expanded {
      max-height: 1000px;
    }

    .view-all {
      color: #98A7DA;
      text-decoration: none;
      cursor: pointer;
      margin-top: 0px;
      font-weight: 500;
      font-size: 11px;
      margin-bottom: 0px;
    }

    .view-all:hover {
      color: #7c93e0;
    }

		
	</style>

	{{-- Track lot new Css  --}}
	<style>
		
	  @keyframes scaleAnimation {
      0% { transform: scale(1); }
      50% { transform: scale(1.2); }
      100% { transform: scale(1); }
    }
    
    .task-status-svg {
      width: 20px;
      height: 20px;
    }
    
    .task-status-svg circle {
      fill: #50AB64;
      stroke: none;
      transition: fill 0.3s;
      transform-origin: center;
    }
    
    .task-status-svg .scale-animation {
      animation: scaleAnimation 1.5s infinite;
    }

		.diables_img_download{
			pointer-events: none;
		}

		.last-button-mar .diables_img_download{
			background: #4D4D4D !important;
			color: #808080 !important;
			border:0px !important;
		}
	</style>

	{{-- No New notification css --}}
	<style>
		@keyframes taskStatus {
			0% { transform: scale(1); }
			50% { transform: scale(1.2); }
			100% { transform: scale(1); }
		}
		
		rect[x="1.3999"][y="1"][width="14"][height="14"] {
			animation: taskStatus 1.5s infinite;
			fill: #59ABB2;
			stroke: #59ABB2;
			transition: fill 0.3s, stroke 0.3s;
		}
		
		rect[x="1.3999"][y="1"][width="14"][height="14"]:hover {
			fill: #FFD700;
			stroke: #FFD700;
		}
	</style>

	{{-- Copy url propover  --}}
	<style>
		.urlpopover {
			display: none;
            position: absolute;
            top: auto;
            left: 0;
            z-index: 1;
    }

		.url-copied-linkforviewdetails {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 12px;
            background: rgba(152, 167, 218, 0.10);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
		}

		#share_btn.active{
			/* border: 1px solid var(--primary-700-main, #FFF300); */
			border-radius: 45%;
			background: var(--neutral-800, #1A1A1A);
			box-shadow: 0px 0px 72px 20px rgba(255, 248, 102, 0.15);
		}
	</style>

{{-- /* multiple folder selection style strat  */ --}}
<style>
	#folder-container {
		overflow: hidden;
	}

	.folder {
		position: relative;
		cursor: pointer;
	}

	.folder.selected {
		border: 1px solid var(--tertiary-700-main, #50AB64);
        box-shadow: 4px 16px 60px 0px rgba(255, 255, 255, 0.10);
		background: var(--neutral-800, #1A1A1A);
	}

	.folder-content {
		margin-top: 10px;
		padding-left: 20px;
		overflow: hidden;
	}

	#selectedFoldersCount {
		position: absolute;
		top: 94px;
		display: none;
		color: black;
		background:#0F0F0F;
		height: 33px;
		width: 227px;
	}

	#selectedFoldersCountText {
		color: #FFFFFF;
		font-size: 12px;
		font-weight: 500;
		line-height: 16px;
		letter-spacing: 0.5px;
	}

	#popoverfolderselect {
		position: absolute;
		top: 10px;
		display: none;
		width: 84%;
		background:#0F0F0F;
		padding: 4px;
        left: 10px;
	}


	.popover-item-container {
		display: flex;
		gap: 24px;
	}

	.popover-item {
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.popover-item-text {
		color: var(--shades-0, #FFF);
		cursor: pointer;
		font-size: 16px;
		font-family: Poppins;
		letter-spacing: 0.5px;
	}
	.popover-item-container .disable {
		pointer-events: none;
		opacity: .4;
	}

	.mobile-bottom-nav-content-div .active{
		background: #FFF300;
    border-radius: 0;
    box-shadow: none;
	}

	.mobile-bottom-nav-content-div .active .mobile-bottom-nav-content-heading{
		color: #0F0F0F;
	}

	.popup-content .active a{
		color: #fff300;
	}
	a{
		text-decoration: none;
		text-decoration-color: transparent;
	}
</style>

</head>

<body>
	<div class="wrapper">
    <?php 
      $user_data = Auth::user();         
      $ClientNotification = getNotificationList($user_data , 'all');
      
			$is_seen_notifications = array_column($ClientNotification, 'id','is_seen');
			$new_notification = array_key_exists('0', $is_seen_notifications);

			$tot_notification = count($ClientNotification);
			$ids = json_encode(array_column($ClientNotification, 'id'),true);

      // dd($is_seen_notifications , $ClientNotification);
			$search_query = "";
			if(isset($other_data)){
				if(isset($other_data['search_query'])){
					$search_query = $other_data['search_query'];
				}
			}

			$get_active_url_data = get_active_url_data();
			$active_tab = $get_active_url_data['active_tab'];
			$active_link = $get_active_url_data['active_link'];
			$routeName = $get_active_url_data['routeName'];
			// dd($get_active_url_data);

			$ClientCommonController = new \App\Http\Controllers\ClientsControllers\ClientCommonController();
    	$your_assets_sidebar_data = $ClientCommonController->your_assets_sidebar();
    ?>

		<!-- ODN given code -->
		<div class="container-fluid">
			<!-- Top navigation bar -->
			<div class="row">
				<!-- Desktop Navbar Strat -->
				<nav class="navbar navbar-expand-md border border-dark fixed-top d-none d-md-flex d-xl-flex d-lg-flex" >
					{{-- logo --}}
					<a class="navbar-brand" href="{{route('ClientDashboard')}}">
						<svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_2254_3636)">
                            <path d="M52 0H0V52H52V0Z" fill="#FFF300"/>
                            <path d="M5.05096 26.0003C5.05096 22.0331 8.10892 19.0718 12.2694 19.0718C16.3916 19.0718 19.4496 22.0136 19.4496 26.0003C19.4496 29.987 16.3923 32.9282 12.2694 32.9282C8.10892 32.9282 5.05096 29.9675 5.05096 26.0003ZM17.5136 26.0003C17.5136 23.0007 15.269 20.7944 12.2694 20.7944C9.23091 20.7944 6.98626 23.0007 6.98626 26.0003C6.98626 28.9999 9.23091 31.2036 12.2694 31.2036C15.269 31.2036 17.5143 28.9999 17.5143 26.0003H17.5136Z" fill="#231F20"/>
                            <path d="M20.8621 19.2268H26.5734C30.9271 19.2268 33.8878 21.9781 33.8878 26.0003C33.8878 30.0226 30.9251 32.7732 26.5734 32.7732H20.8621V19.2268ZM26.4553 31.0896C29.8031 31.0896 31.9512 29.0382 31.9512 26.0003C31.9512 22.9625 29.8038 20.9105 26.4553 20.9105H22.7974V31.0896H26.4553Z" fill="#231F20"/>
                            <path d="M46.949 19.2268V32.7732H45.3627L37.2343 22.6713V32.7732H35.297V19.2268H36.884L45.0137 29.3287V19.2268H46.949Z" fill="#231F20"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_2254_3636">
                            <rect width="52" height="52" fill="white"/>
                            </clipPath>
                            </defs>
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

					 <form action="{{route('gloableSearchNew')}}" method="post" class="ms-4" style="width:50%;">
						@csrf
						<div class="input-group ms-auto  nav-searchbar" style="width:59%;">
								<input type="text" id="searchBar" class="form-control rounded-0 search-input" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" style="background: #1A1A1A;border: 1px solid #333333; color: #FFFFFF;padding:16px;" name="search_query" value="{{$search_query}}">
								<div class="input-group-append">
									<button class="btn  border-start-0 rounded-0" type="submit" style="background: #1A1A1A;border: 1px solid #333333;padding:16px;">
										<svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M15.2362 14.6666L13.9028 13.3333M8.23616 13.9999C9.06787 13.9999 9.89143 13.8361 10.6598 13.5178C11.4282 13.1995 12.1264 12.733 12.7145 12.1449C13.3026 11.5568 13.7691 10.8586 14.0874 10.0902C14.4057 9.32185 14.5695 8.49829 14.5695 7.66658C14.5695 6.83488 14.4057 6.01132 14.0874 5.24292C13.7691 4.47453 13.3026 3.77635 12.7145 3.18824C12.1264 2.60014 11.4282 2.13363 10.6598 1.81535C9.89143 1.49707 9.06787 1.33325 8.23616 1.33325C6.55646 1.33325 4.94555 2.00051 3.75782 3.18824C2.57009 4.37597 1.90283 5.98688 1.90283 7.66658C1.90283 9.34629 2.57009 10.9572 3.75782 12.1449C4.94555 13.3327 6.55646 13.9999 8.23616 13.9999Z" stroke="#808080" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>              
									</button>
								</div>
							</div>
					 </form> 

						<ul class="navbar-nav ms-auto">
							{{-- notification bell --}}
							<li class="nav-item mt-1 notification-popover-container" style="padding-right: 48px; margin-top: 12px">
								
									@if ($new_notification)
										<svg  id="popover-trigger" width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
											<rect width="36" height="36" rx="18" fill="#1A1A1A"/>
											<path d="M18 13.366V16.141M18.0167 9.66602C14.95 9.66602 12.4667 12.1493 12.4667 15.216V16.966C12.4667 17.5327 12.2334 18.3827 11.9417 18.866L10.8834 20.6327C10.2334 21.7243 10.6834 22.941 11.8834 23.341C15.8678 24.666 20.174 24.666 24.1584 23.341C24.4213 23.2533 24.6611 23.1077 24.8602 22.9148C25.0592 22.722 25.2124 22.4869 25.3084 22.2269C25.4044 21.9669 25.4408 21.6886 25.4148 21.4127C25.3888 21.1368 25.3012 20.8702 25.1584 20.6327L24.1 18.866C23.8084 18.3827 23.575 17.5243 23.575 16.966V15.216C23.5667 12.166 21.0667 9.66602 18.0167 9.66602Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
											<path d="M20.775 24.25C20.775 25.775 19.525 27.025 18 27.025C17.2416 27.025 16.5416 26.7083 16.0416 26.2083C15.5416 25.7083 15.225 25.0083 15.225 24.25" fill="white"/>
											<circle cx="30.4307" cy="5" r="4.25" fill="#FFF866" stroke="#0F0F0F" stroke-width="1.5"/>
										</svg>
											
									@else
										<svg id="popover-trigger" width="42" height="42" viewBox="0 0 37 36" fill="none" xmlns="http://www.w3.org/2000/svg">
											<circle cx="18.5696" cy="18" r="18" fill="#1A1A1A"/>
											<path d="M18.5695 13.3667V16.1417M18.5862 9.66675C15.5195 9.66675 13.0362 12.1501 13.0362 15.2167V16.9667C13.0362 17.5334 12.8028 18.3834 12.5112 18.8667L11.4528 20.6334C10.8028 21.7251 11.2528 22.9417 12.4528 23.3417C16.4372 24.6667 20.7434 24.6667 24.7278 23.3417C24.9907 23.254 25.2306 23.1084 25.4296 22.9155C25.6287 22.7227 25.7819 22.4876 25.8779 22.2276C25.9739 21.9676 26.0102 21.6894 25.9843 21.4134C25.9583 21.1375 25.8707 20.8709 25.7278 20.6334L24.6695 18.8667C24.3778 18.3834 24.1445 17.5251 24.1445 16.9667V15.2167C24.1362 12.1667 21.6362 9.66675 18.5862 9.66675Z" stroke="#D1D1D1" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
											<path d="M21.3447 24.25C21.3447 25.775 20.0947 27.025 18.5697 27.025C17.8113 27.025 17.1113 26.7083 16.6113 26.2083C16.1113 25.7083 15.7947 25.0083 15.7947 24.25" fill="#D1D1D1"/>
										</svg>
									@endif
									<div class="popover-for-notifaction" id="popover-for-notifaction">
										<div class="notificatio-pop-heading">Notifications</div>

										@if ($tot_notification > 0)
											@foreach ($ClientNotification as $notification_key => $row)
												@php
													if($notification_key > 2){
														break;
													}
													$create_date_is = date('Y-m-d H:i:s',strtotime($row['created_at']));										
													$day_ago = timeBefore($row['created_at']);
													$is_seen = $row['is_seen'];
													$seen_class = ($is_seen == 1) ? 'Inactive-notification' : 'active-notification';
												@endphp
												<div>
													<p class="{{$seen_class}}">
														{{$row['discription']}}
													</p>
													<p class="notification-time">
														{{$day_ago}}
													</p>
													<hr class="hr-line">
												</div>
											@endforeach
											<div class="d-flex justify-content-between">
												{{-- <a role="button" class="view-all" id="viewButton" onclick="toggleContent()">View All</a> --}}
												<p class="view-all" onclick="set_notifiction_to_seen({{$ids}})" style="cursor: pointer;">Mark all as read</p>
												<a href="{{route('Notifications')}}" role="button" class="view-all" id="viewButton">
														View All 
														<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M5.93994 13.2807L10.2866 8.93404C10.7999 8.4207 10.7999 7.5807 10.2866 7.06737L5.93994 2.7207" stroke="#98A7DA" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
														</svg>
												</a>
											</div>
										@else
											<div class="text-center" style="margin-top: 16px;">
                                              <svg width="90" height="90" viewBox="0 0 90 90" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="9" y="9" width="72" height="72" rx="36" fill="#1A1A1A" />
                                                <path
                                                  d="M45.0001 37.586V42.026M45.0268 31.666C40.1201 31.666 36.1468 35.6393 36.1468 40.546V43.346C36.1468 44.2527 35.7734 45.6127 35.3068 46.386L33.6134 49.2127C32.5734 50.9593 33.2934 52.906 35.2134 53.546C41.5885 55.666 48.4784 55.666 54.8534 53.546C55.2741 53.4057 55.6578 53.1726 55.9763 52.8641C56.2948 52.5555 56.5399 52.1794 56.6935 51.7634C56.8471 51.3474 56.9053 50.9022 56.8638 50.4607C56.8222 50.0192 56.682 49.5927 56.4534 49.2127L54.7601 46.386C54.2934 45.6127 53.9201 44.2393 53.9201 43.346V40.546C53.9068 35.666 49.9068 31.666 45.0268 31.666Z"
                                                  stroke="#4D4D4D" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" />
                                                <path
                                                  d="M49.4401 55C49.4401 57.44 47.4401 59.44 45.0001 59.44C43.7867 59.44 42.6667 58.9333 41.8667 58.1333C41.0667 57.3333 40.5601 56.2133 40.5601 55"
                                                  fill="#4D4D4D" />
                                              </svg>
                                            </div>
                                            <p class="text-center No-notifications-rec">No notifications received.</p>
										@endif
										
									</div>
									{{-- <span class="notify-count">{{$tot_notification}}</span> --}}
							</li>
							{{-- user name --}}
							<li class="nav-item">
								<a class="nav-link" href="{{route('ClientProfile')}}" style="color: #D1D1D1;font-weight: 500;font-size: 14px;margin-top: 5px">{{ ucwords($user_data->name) .' '. ucwords($user_data->last_name) }}</a>
							</li>
							{{-- user profile image --}}
							<li class="nav-item">
								@php
									$profile_avtar = $user_data->profile_avtar;
									$profile_avtar_path =  asset('uploades/profileavtar/'.$profile_avtar);
									if(!file_exists($profile_avtar_path) && $profile_avtar != ''){
											$profile_avtar_src = $profile_avtar_path;
									}else{
											$profile_avtar_src = asset("assets-images\Desktop-Assets\your profile\blank-avtar.jpg");
									}
								@endphp
								<img width="46" height="46" style="border: 1px solid;border-radius: 50%;overflow: hidden;"  src="{{$profile_avtar_src}}" alt="">
								{{-- <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
									<circle cx="23" cy="23" r="23" fill="#808080"/>
									</svg>             --}}
							</li>
						</ul>
					</div>
				</nav>
				<!-- Desktop Navbar End -->

				<!-- Mobile Navbar start -->
				<div class="Mobnavbar p-0 d-lg-none d-xl-none d-lg-none d-xs-block d-sm-block d-md-none">
					<div class="navbar-content">
							<div class="nav-logo">
									<svg width="141" height="32" viewBox="0 0 141 32" fill="none" xmlns="http://www.w3.org/2000/svg">
											<g clip-path="url(#clip0_2868_3775)">
													<path d="M140.106 12.9971H122.088V15.2493H129.971V31.0147H132.223V15.2493H140.106V12.9971Z"
															fill="#FFF300" />
													<path
															d="M29.7488 2.11144C29.7488 2.52528 29.6296 2.91097 29.4222 3.23754H3.23755V28.7625H17.1261L16 31.0147H0.985352V0.985337H29.4231C29.6296 1.31097 29.7488 1.6976 29.7488 2.11144Z"
															fill="#FFF300" />
													<path
															d="M2.34604 0H1.87683C0.840287 0 0 0.840287 0 1.87683V2.34604C0 3.38259 0.840287 4.22287 1.87683 4.22287H2.34604C3.38259 4.22287 4.22287 3.38259 4.22287 2.34604V1.87683C4.22287 0.840287 3.38259 0 2.34604 0Z"
															fill="#FFF300" />
													<path
															d="M2.34604 27.7771H1.87683C0.840287 27.7771 0 28.6174 0 29.654V30.1232C0 31.1597 0.840287 32 1.87683 32H2.34604C3.38259 32 4.22287 31.1597 4.22287 30.1232V29.654C4.22287 28.6174 3.38259 27.7771 2.34604 27.7771Z"
															fill="#FFF300" />
													<path
															d="M29.7488 2.11144C29.7488 2.52528 29.6296 2.91097 29.4222 3.23754C29.3396 3.37079 29.2411 3.49372 29.1303 3.60446C28.9614 3.77431 28.7625 3.91507 28.5429 4.01924C28.2679 4.14968 27.9611 4.22287 27.6373 4.22287C27.3136 4.22287 27.0076 4.14968 26.7327 4.01924C26.3695 3.84751 26.0645 3.57443 25.8515 3.23754C25.8065 3.16622 25.7661 3.09208 25.7295 3.01607C25.5991 2.74111 25.5259 2.43425 25.5259 2.11144C25.5259 1.78862 25.5991 1.48082 25.7295 1.20587C25.7661 1.12985 25.8065 1.05572 25.8515 0.985337C25.935 0.852082 26.0345 0.728211 26.1443 0.618417C26.5272 0.236481 27.0546 0 27.6373 0C28.2201 0 28.7484 0.236481 29.1303 0.618417C29.2411 0.72915 29.3396 0.852082 29.4231 0.985337C29.6296 1.31097 29.7488 1.6976 29.7488 2.11144Z"
															fill="#FFF300" />
													<path
															d="M83.8006 23.132H97.3138V20.8798H83.8006V15.2493H99.5622V12.9971H81.5484V31.0147H99.566V28.7625H83.8006V23.132Z"
															fill="#FFF300" />
													<path
															d="M119.836 15.2493H119.832V12.9971H101.818V31.0147H119.836V28.7625H117.584H104.07V15.2493H117.584H119.836Z"
															fill="#FFF300" />
													<path
															d="M56.7742 12.9971V27.17L43.261 13.6558L42.6022 12.9971H41.0088V14.5905V31.0147H43.261V16.8427L56.7742 30.355L57.4339 31.0147H59.0264V29.4222V12.9971H56.7742Z"
															fill="#FFF300" />
													<path
															d="M77.044 12.9971V27.17L63.5308 13.6558L62.8721 12.9971H61.2786V14.5905V31.0147H63.5308V16.8427L77.044 30.355L77.7037 31.0147H79.2962V29.4222V12.9971H77.044Z"
															fill="#FFF300" />
													<path
															d="M18.4868 29.8886C18.4868 30.4713 18.2503 30.9997 17.8684 31.3816C17.6985 31.5514 17.4996 31.6922 17.28 31.7964C17.005 31.9268 16.6982 32 16.3754 32C16.0525 32 15.7447 31.9268 15.4707 31.7964C15.0315 31.588 14.6759 31.2324 14.4676 30.7932C14.3371 30.5182 14.2639 30.2114 14.2639 29.8886C14.2639 29.5658 14.3371 29.258 14.4676 28.9839C14.5717 28.7643 14.7125 28.5654 14.8823 28.3955C15.2643 28.0136 15.7926 27.7771 16.3754 27.7771C16.9581 27.7771 17.4864 28.0136 17.8684 28.3955C18.2503 28.7775 18.4868 29.3058 18.4868 29.8886Z"
															fill="#FFF300" />
													<path d="M38.7566 12.9971H20.739V31.0147H38.7566V12.9971Z" fill="#FFF300" />
													<path
															d="M22.4891 22.0059C22.4891 20.6311 23.5486 19.6054 24.99 19.6054C26.4314 19.6054 27.4778 20.6245 27.4778 22.0059C27.4778 23.3872 26.4183 24.4063 24.99 24.4063C23.5617 24.4063 22.4891 23.3806 22.4891 22.0059ZM26.8077 22.0059C26.8077 20.9661 26.0298 20.2022 24.991 20.2022C23.9521 20.2022 23.1601 20.967 23.1601 22.0059C23.1601 23.0447 23.9381 23.8095 24.991 23.8095C26.0439 23.8095 26.8077 23.0447 26.8077 22.0059Z"
															fill="#231F20" />
													<path
															d="M27.9677 19.6589H29.9458C31.4548 19.6589 32.4805 20.6114 32.4805 22.0059C32.4805 23.4004 31.4548 24.3528 29.9458 24.3528H27.9677V19.6589ZM29.9055 23.7691C31.0654 23.7691 31.8095 23.0588 31.8095 22.0059C31.8095 20.953 31.0654 20.2426 29.9055 20.2426H28.6386V23.7701H29.9055V23.7691Z"
															fill="#231F20" />
													<path
															d="M37.0064 19.6589V24.3528H36.4565L33.6403 20.8526V24.3528H32.9694V19.6589H33.5193L36.3355 23.1592V19.6589H37.0064Z"
															fill="#231F20" />
											</g>
											<defs>
													<clipPath id="clip0_2868_3775">
															<rect width="140.106" height="32" fill="white" />
													</clipPath>
											</defs>
									</svg>
							</div>
							<div class="hambur-notifi-div-mob">
									<svg width="36" height="30" viewBox="0 0 36 30" fill="none" xmlns="http://www.w3.org/2000/svg">
											<rect width="30" height="30" rx="15" fill="#1A1A1A" />
											<path
													d="M15 11.1389V13.4514M15.0139 8.05556C12.4583 8.05556 10.3889 10.125 10.3889 12.6806V14.1389C10.3889 14.6111 10.1945 15.3194 9.9514 15.7222L9.06945 17.1944C8.52779 18.1042 8.90279 19.1181 9.90279 19.4514C13.2231 20.5555 16.8116 20.5555 20.132 19.4514C20.351 19.3783 20.5509 19.2569 20.7168 19.0962C20.8827 18.9355 21.0103 18.7396 21.0903 18.5229C21.1703 18.3063 21.2006 18.0744 21.179 17.8445C21.1573 17.6145 21.0843 17.3924 20.9653 17.1944L20.0833 15.7222C19.8403 15.3194 19.6458 14.6042 19.6458 14.1389V12.6806C19.6389 10.1389 17.5556 8.05556 15.0139 8.05556Z"
													stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" />
											<path
													d="M17.3125 20.2083C17.3125 21.4792 16.2708 22.5208 15 22.5208C14.3681 22.5208 13.7847 22.2569 13.3681 21.8403C12.9514 21.4236 12.6875 20.8403 12.6875 20.2083"
													fill="white" />
											<circle cx="30.4307" cy="5" r="4.25" fill="#FFF300" stroke="#0F0F0F" stroke-width="1.5" />
									</svg>
									<div>
											<button class="navbar-toggler popup-trigger" type="button" data-popup-target="sidebarPopup" onclick="openSidebarPopup(event)">
													<span class="navbar-toggler-icon">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path d="M3 7H21M3 12H21M3 17H21" stroke="white" stroke-width="1.5"
																			stroke-linecap="round" />
															</svg>
													</span>
											</button>
									</div>
							</div>
					</div>
					<div class="nav-searchbar-div">
							<div class="search-container">
								<form action="{{route('gloableSearchNew')}}" method="post" style="width:100%; display: flex;">
									@csrf
									<input type="text" class="search-input" placeholder="Search" name="search_query" value="{{$search_query}}">
									<button class="btn search-icon">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
													<g clip-path="url(#clip0_2820_13159)">
															<path
																	d="M18.3334 18.3333L16.6667 16.6667M9.58335 17.5C10.623 17.5 11.6524 17.2952 12.6129 16.8974C13.5734 16.4995 14.4462 15.9164 15.1813 15.1813C15.9164 14.4461 16.4996 13.5734 16.8974 12.6129C17.2953 11.6524 17.5 10.623 17.5 9.58333C17.5 8.5437 17.2953 7.51425 16.8974 6.55375C16.4996 5.59326 15.9164 4.72053 15.1813 3.9854C14.4462 3.25027 13.5734 2.66713 12.6129 2.26928C11.6524 1.87143 10.623 1.66666 9.58335 1.66666C7.48372 1.66666 5.47009 2.50074 3.98542 3.9854C2.50076 5.47006 1.66669 7.4837 1.66669 9.58333C1.66669 11.683 2.50076 13.6966 3.98542 15.1813C5.47009 16.6659 7.48372 17.5 9.58335 17.5Z"
																	stroke="#808080" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
													</g>
													<defs>
															<clipPath id="clip0_2820_13159">
																	<rect width="20" height="20" fill="white" />
															</clipPath>
													</defs>
											</svg>
									</button>
								</form>
							</div>
					</div>
				</div>
				<!-- Mobile Navbar End -->
			</div>
			<!-- Top navigation bar END -->
			
			<!-- Sidebar start -->
			<div class="row viewport">
				<div class="col-lg-2 border border-dark border-end-0 sidebar-position">
					<div class="accordion accordion-flush d-none d-md-block d-xl-block d-lg-block" id="accordionFlushExample">
						@php
							// pre($get_active_url_data);
						@endphp
						{{-- 1st tab --}}
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-headingOne">
								<button class="mySvg clickable border border-dark border-top-0 border-start-0 border-end-0 svg-container accordion-button siderbar-button {{$active_tab == 1 ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse"
									data-bs-target="#flush-collapseOne" aria-expanded="{{$active_tab == 1 ? 'true' : 'flase'}}" aria-controls="flush-collapseOne" onclick="swapSVG(event)">
									<svg class="initial-svg" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: {{$active_tab == 1 ? 'none' : 'block'}}">
										<path d="M9.839 19.4996C9.666 19.3576 9.466 19.2376 9.323 19.0696C7.482 16.9176 5.647 14.7596 3.815 12.6006C2.903 11.5256 2.427 10.2626 2.344 8.87158C2.149 5.57258 3.502 3.06858 6.352 1.41158C7.656 0.653581 9.103 0.408581 10.608 0.527581C12.242 0.656581 13.695 1.23458 14.938 2.30558C16.42 3.58258 17.311 5.19558 17.594 7.13358C17.8 8.54958 17.612 9.91758 17.035 11.2286C16.778 11.8106 16.408 12.3196 15.997 12.8016C14.193 14.9206 12.39 17.0396 10.58 19.1536C10.461 19.2926 10.285 19.3846 10.136 19.4986H9.839V19.4996ZM9.992 17.8156C10.023 17.7746 10.037 17.7536 10.053 17.7346C11.728 15.7656 13.41 13.8026 15.073 11.8236C15.364 11.4776 15.63 11.0886 15.814 10.6776C16.495 9.15758 16.525 7.59558 15.958 6.03758C14.741 2.69958 11.28 1.09058 8.008 2.14158C5.401 2.97858 3.656 5.40558 3.637 8.14558C3.628 9.44758 3.933 10.6646 4.786 11.6846C6.068 13.2166 7.368 14.7326 8.662 16.2546C9.098 16.7676 9.535 17.2796 9.992 17.8156Z" fill="white"/>
										<path d="M9.99001 11.8826C7.95001 11.8876 6.27701 10.2166 6.27101 8.1676C6.26501 6.1236 7.92201 4.4556 9.97601 4.4386C12.015 4.4216 13.705 6.1096 13.704 8.1636C13.702 10.2116 12.038 11.8786 9.99101 11.8826H9.99001ZM12.377 8.1576C12.374 6.8346 11.296 5.7636 9.97501 5.7696C8.66201 5.7756 7.59601 6.8506 7.60001 8.1646C7.60301 9.4886 8.68101 10.5616 10.001 10.5536C11.314 10.5456 12.381 9.4706 12.377 8.1576Z" fill="white"/>
										</svg>
	
									<svg class="replacement-svg" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: {{$active_tab == 1 ? 'block' : 'none'}}">
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
									<svg class="initial-svg" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: {{$active_tab == 2 ? 'none' : 'block'}}">
										<path d="M0.500023 3.59667C0.604023 3.23167 0.784023 2.91667 1.14802 2.76467C1.32602 2.69067 1.52802 2.63867 1.71902 2.63667C3.18502 2.62667 4.65102 2.63067 6.11702 2.63067C6.57702 2.63067 6.93802 2.81967 7.20402 3.19667C7.56402 3.70667 7.93202 4.21067 8.29002 4.72267C8.36202 4.82567 8.44002 4.86067 8.56302 4.86067C10.79 4.85667 13.017 4.85867 15.243 4.85767C15.74 4.85767 16.144 5.03967 16.37 5.49467C16.457 5.66967 16.491 5.88567 16.495 6.08367C16.509 6.83767 16.501 7.59267 16.501 8.34767C16.501 8.41467 16.501 8.48267 16.501 8.57167C16.575 8.57667 16.64 8.58367 16.705 8.58367C17.163 8.58967 17.622 8.57167 18.077 8.60367C19.166 8.67967 19.82 9.79067 19.34 10.7677C18.316 12.8517 17.273 14.9267 16.238 17.0057C16.115 17.2527 15.92 17.3687 15.643 17.3677C11.016 17.3657 6.38902 17.3677 1.76302 17.3657C1.13802 17.3657 0.725023 17.0567 0.533023 16.4647C0.526023 16.4427 0.511023 16.4227 0.499023 16.4017C0.499023 12.1327 0.499023 7.86467 0.499023 3.59567L0.500023 3.59667ZM1.93602 16.2467C1.99102 16.2507 2.01502 16.2537 2.04002 16.2537C6.43902 16.2537 10.837 16.2537 15.236 16.2577C15.353 16.2577 15.395 16.2057 15.439 16.1167C15.847 15.2917 16.258 14.4677 16.668 13.6437C17.216 12.5437 17.765 11.4437 18.311 10.3427C18.475 10.0127 18.333 9.75667 17.965 9.70867C17.91 9.70167 17.854 9.69867 17.799 9.69867C13.679 9.69867 9.55902 9.69867 5.43902 9.69567C5.13202 9.69567 4.93602 9.80967 4.80302 10.0987C4.05902 11.7147 3.30002 13.3237 2.54702 14.9347C2.34602 15.3647 2.14702 15.7947 1.93602 16.2467ZM1.62602 3.74467V14.2637C1.67502 14.1657 1.70302 14.1127 1.72802 14.0577C2.42102 12.5747 3.11102 11.0907 3.81102 9.61067C3.90202 9.41767 4.02002 9.22867 4.16402 9.07267C4.50802 8.69767 4.96202 8.58267 5.45802 8.58367C8.68102 8.58567 11.904 8.58467 15.127 8.58467C15.21 8.58467 15.293 8.58467 15.372 8.58467V5.97167H15.136C12.934 5.97167 10.731 5.96867 8.52902 5.97367C8.04302 5.97467 7.67402 5.78967 7.39802 5.38967C7.05402 4.89167 6.69202 4.40467 6.34502 3.90767C6.26202 3.78967 6.17402 3.73967 6.02602 3.74067C4.62802 3.74667 3.23002 3.74467 1.83202 3.74467H1.62602Z" fill="white" />
									</svg>

									<svg class="replacement-svg" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: {{$active_tab == 2 ? 'block' : 'none'}}">
										<path d="M0.500023 3.59667C0.604023 3.23167 0.784023 2.91667 1.14802 2.76467C1.32602 2.69067 1.52802 2.63867 1.71902 2.63667C3.18502 2.62667 4.65102 2.63067 6.11702 2.63067C6.57702 2.63067 6.93802 2.81967 7.20402 3.19667C7.56402 3.70667 7.93202 4.21067 8.29002 4.72267C8.36202 4.82567 8.44002 4.86067 8.56302 4.86067C10.79 4.85667 13.017 4.85867 15.243 4.85767C15.74 4.85767 16.144 5.03967 16.37 5.49467C16.457 5.66967 16.491 5.88567 16.495 6.08367C16.509 6.83767 16.501 7.59267 16.501 8.34767C16.501 8.41467 16.501 8.48267 16.501 8.57167C16.575 8.57667 16.64 8.58367 16.705 8.58367C17.163 8.58967 17.622 8.57167 18.077 8.60367C19.166 8.67967 19.82 9.79067 19.34 10.7677C18.316 12.8517 17.273 14.9267 16.238 17.0057C16.115 17.2527 15.92 17.3687 15.643 17.3677C11.016 17.3657 6.38902 17.3677 1.76302 17.3657C1.13802 17.3657 0.725023 17.0567 0.533023 16.4647C0.526023 16.4427 0.511023 16.4227 0.499023 16.4017C0.499023 12.1327 0.499023 7.86467 0.499023 3.59567L0.500023 3.59667ZM1.93602 16.2467C1.99102 16.2507 2.01502 16.2537 2.04002 16.2537C6.43902 16.2537 10.837 16.2537 15.236 16.2577C15.353 16.2577 15.395 16.2057 15.439 16.1167C15.847 15.2917 16.258 14.4677 16.668 13.6437C17.216 12.5437 17.765 11.4437 18.311 10.3427C18.475 10.0127 18.333 9.75667 17.965 9.70867C17.91 9.70167 17.854 9.69867 17.799 9.69867C13.679 9.69867 9.55902 9.69867 5.43902 9.69567C5.13202 9.69567 4.93602 9.80967 4.80302 10.0987C4.05902 11.7147 3.30002 13.3237 2.54702 14.9347C2.34602 15.3647 2.14702 15.7947 1.93602 16.2467ZM1.62602 3.74467V14.2637C1.67502 14.1657 1.70302 14.1127 1.72802 14.0577C2.42102 12.5747 3.11102 11.0907 3.81102 9.61067C3.90202 9.41767 4.02002 9.22867 4.16402 9.07267C4.50802 8.69767 4.96202 8.58267 5.45802 8.58367C8.68102 8.58567 11.904 8.58467 15.127 8.58467C15.21 8.58467 15.293 8.58467 15.372 8.58467V5.97167H15.136C12.934 5.97167 10.731 5.96867 8.52902 5.97367C8.04302 5.97467 7.67402 5.78967 7.39802 5.38967C7.05402 4.89167 6.69202 4.40467 6.34502 3.90767C6.26202 3.78967 6.17402 3.73967 6.02602 3.74067C4.62802 3.74667 3.23002 3.74467 1.83202 3.74467H1.62602Z" fill="#0F0F0F"/>
									</svg>&nbsp;&nbsp;
									YOUR ASSETS
								</button>
							</h2>
							<div id="flush-collapseTwo" class="accordion-collapse collapse {{$active_tab == 2 ? 'show' : ''}}" aria-labelledby="flush-headingTwo"
              data-bs-parent="#accordionFlushExample">
								<div class="accordion-body">

									{{-- Shoot Lots --}}
									@if ($your_assets_sidebar_data['shoot_lots_count'] > 0)
									<a href="{{route('your_assets_files' , ['service' => 'Shoot'])}}" role="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'Shoot_lot' ? 'active' : ''}}"
										style="width: 100%;">Shoot Lots</a>
									@endif

									{{-- Post-production Lots --}}
									@if ($your_assets_sidebar_data['editor_lots_count'] > 0)
									<a href="{{route('your_assets_files' , ['service' => 'PostProduction'])}}" role="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'PostProduction_lots' ? 'active' : ''}}"
										style="width: 100%;">Post-production Lots</a>
									@endif

									{{-- Creative Lots --}}
									@if ($your_assets_sidebar_data['creative_lots_count'] > 0)
									<a href="{{route('your_assets_Links' , ['service' => 'Creative'])}}" role="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'Creative_lots' ? 'active' : ''}}"
										style="width: 100%;">Creative Lots</a>
									@endif

									{{-- Listing Lots --}}
									@if ($your_assets_sidebar_data['catalog_lots_count'] > 0)
									<a href="{{route('your_assets_Links' , ['service' => 'Listing'])}}" role="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'Listing_lots' ? 'active' : ''}}"
										style="width: 100%;">Listing Lots</a>
									@endif
									
									<hr style="background:#333333;margin-top:16px;margin-bottom:16px;height: 2px;">

									{{-- Favorites --}}
									<a href="{{route('your_assets_Favorites')}}" role="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'your_assets_Favorites' ? 'active' : ''}}"
										style="width: 100%;">
									    <div style="gap:8px; display: flex; align-items: center;">
									        <span>
									        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_2422_5940)">
                                            <path d="M9.15327 2.34001L10.3266 4.68668C10.4866 5.01334 10.9133 5.32668 11.2733 5.38668L13.3999 5.74001C14.7599 5.96668 15.0799 6.95334 14.0999 7.92668L12.4466 9.58001C12.1666 9.86001 12.0133 10.4 12.0999 10.7867L12.5733 12.8333C12.9466 14.4533 12.0866 15.08 10.6533 14.2333L8.65994 13.0533C8.29994 12.84 7.70661 12.84 7.33994 13.0533L5.34661 14.2333C3.91994 15.08 3.05327 14.4467 3.42661 12.8333L3.89994 10.7867C3.98661 10.4 3.83327 9.86001 3.55327 9.58001L1.89994 7.92668C0.926606 6.95334 1.23994 5.96668 2.59994 5.74001L4.72661 5.38668C5.07994 5.32668 5.50661 5.01334 5.66661 4.68668L6.83994 2.34001C7.47994 1.06668 8.51994 1.06668 9.15327 2.34001Z" stroke="#808080" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </g>
                                            <defs>
                                            <clipPath id="clip0_2422_5940">
                                            <rect width="16" height="16" fill="white"/>
                                            </clipPath>
                                            </defs>
                                        </svg>
									    </span>
									    <span>
									         Favorites
									    </span>
									    </div>
									    
									</a>
								</div>
							</div>
						</div>

						{{-- 3rd tab --}}
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-headingThree">
								<button class="mySvg clickable svg-container border border-dark border-top-0 border-start-0 border-end-0 accordion-button siderbar-button {{$active_tab == 3 ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse"
									data-bs-target="#flush-collapseThree" aria-expanded="{{$active_tab == 3 ? "true" : "flase"}}" aria-controls="flush-collapseThree" onclick="swapSVG(event)">
									<svg class="initial-svg" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: {{$active_tab == 3 ? 'none' : 'block'}}">
										<path d="M14.6699 19.5004C14.3249 19.3644 14.1869 19.1104 14.2119 18.7434C14.2289 18.4914 14.2199 18.2364 14.2119 17.9834C14.2099 17.9314 14.1639 17.8474 14.1219 17.8364C13.5899 17.6914 13.1379 17.4144 12.7579 17.0154C12.4389 17.1974 12.1319 17.3824 11.8159 17.5504C11.5769 17.6774 11.2989 17.6174 11.1199 17.4264C10.9439 17.2384 10.9009 16.9644 11.0389 16.7414C11.1009 16.6414 11.1999 16.5534 11.2999 16.4894C11.5389 16.3364 11.7879 16.1984 12.0359 16.0604C12.1219 16.0124 12.1629 15.9694 12.1319 15.8584C11.9999 15.3834 11.9999 14.9054 12.1329 14.4304C12.1609 14.3304 12.1299 14.2854 12.0479 14.2394C11.7939 14.0984 11.5429 13.9524 11.2929 13.8054C10.9709 13.6154 10.8679 13.2614 11.0439 12.9654C11.2139 12.6794 11.5679 12.5994 11.8859 12.7784C12.1759 12.9414 12.4629 13.1094 12.7579 13.2794C13.1609 12.8534 13.6409 12.5754 14.2179 12.4364C14.2179 12.0734 14.2109 11.7154 14.2199 11.3574C14.2269 11.0654 14.4309 10.8494 14.7219 10.8014C14.9799 10.7584 15.2499 10.9044 15.3479 11.1584C15.3869 11.2594 15.3989 11.3744 15.4009 11.4844C15.4079 11.7984 15.4029 12.1134 15.4029 12.4374C15.9729 12.5764 16.4539 12.8504 16.8539 13.2814C17.1619 13.1034 17.4589 12.9294 17.7589 12.7594C17.9799 12.6344 18.2009 12.6474 18.4049 12.7924C18.6059 12.9344 18.6779 13.1384 18.6389 13.3784C18.6089 13.5684 18.4969 13.7024 18.3329 13.7974C18.0399 13.9674 17.7479 14.1384 17.4509 14.3114C17.6039 14.8444 17.6139 15.3684 17.4789 15.8954C17.4679 15.9364 17.5159 16.0174 17.5579 16.0434C17.8049 16.1954 18.0599 16.3354 18.3099 16.4834C18.6379 16.6774 18.7439 17.0214 18.5709 17.3194C18.3959 17.6204 18.0509 17.6984 17.7169 17.5094C17.4329 17.3484 17.1499 17.1834 16.8559 17.0144C16.5239 17.3594 16.1409 17.6224 15.6869 17.7734C15.4019 17.8684 15.4029 17.8704 15.4029 18.1704C15.4029 18.3494 15.3919 18.5304 15.4049 18.7084C15.4319 19.0724 15.3079 19.3454 14.9669 19.5024H14.6699V19.5004ZM14.8119 16.7194C15.6899 16.7194 16.3859 16.0224 16.3849 15.1434C16.3839 14.2704 15.6789 13.5634 14.8089 13.5624C13.9409 13.5624 13.2269 14.2714 13.2229 15.1374C13.2199 16.0194 13.9219 16.7184 14.8119 16.7184V16.7194Z" fill="white"/>
										<path d="M2.53803 15.9381C2.62703 15.9381 2.69903 15.9381 2.77203 15.9381C4.91803 15.9381 7.06302 15.9381 9.20902 15.9381C9.59002 15.9381 9.85102 16.1821 9.85202 16.5291C9.85202 16.8411 9.61802 17.0971 9.30503 17.1221C9.25002 17.1261 9.19402 17.1241 9.13802 17.1241C6.78202 17.1241 4.42603 17.1241 2.07003 17.1241C1.56403 17.1241 1.34603 16.9081 1.34603 16.4041C1.34603 15.5381 1.34503 14.6731 1.34603 13.8071C1.34903 11.9181 2.63403 10.3821 4.49303 10.0501C4.66903 10.0191 4.84903 10.0031 5.02803 10.0021C7.28503 9.99813 9.54202 9.99913 11.799 9.99913C12.148 9.99913 12.401 10.2251 12.429 10.5511C12.454 10.8351 12.244 11.1131 11.953 11.1721C11.875 11.1881 11.793 11.1851 11.713 11.1851C9.51802 11.1851 7.32303 11.1831 5.12803 11.1861C3.88703 11.1881 2.86103 12.0141 2.59203 13.2221C2.56503 13.3421 2.54103 13.4661 2.54003 13.5881C2.53503 14.3611 2.53803 15.1331 2.53803 15.9351V15.9381Z" fill="white"/>
										<path d="M8.47097 8.413C6.29097 8.413 4.51697 6.643 4.51197 4.466C4.50697 2.285 6.28997 0.5 8.47297 0.5C10.656 0.5 12.44 2.288 12.432 4.468C12.424 6.648 10.651 8.414 8.46997 8.413H8.47097ZM8.47397 7.226C10.005 7.225 11.252 5.977 11.245 4.452C11.239 2.931 9.99797 1.691 8.47897 1.688C6.94997 1.685 5.70197 2.929 5.69897 4.456C5.69597 5.982 6.94297 7.227 8.47397 7.226Z" fill="white"/>
									</svg>
									<svg  class="replacement-svg"  width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: {{$active_tab == 3 ? 'block' : 'none'}}">
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
									<a class="d-none" href="{{route('Client_Users_list')}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'manage_user' ? 'active' : ''}}"
										style="width: 100%;">Manage user</a>

									<a href="{{route('ClientProfile')}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'ClientProfile' ? 'active' : ''}}"
										style="width: 100%;">Your profile</a>

										<a href="{{route('Client_Setting_new')}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'Client_Setting_new' ? 'active' : ''}}"
										style="width: 100%;">Settings</a>
								</div>
							</div>
						</div>

						{{-- 4rd tab --}}
						<div class="accordion-item d-none">
							<h2 class="accordion-header" id="flush-heading-four">
								<button class="mySvg clickable svg-container border border-dark border-top-0 border-start-0 border-end-0 accordion-button siderbar-button {{$active_tab == 4 ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse"
									data-bs-target="#flush-collapse-four" aria-expanded="{{$active_tab == 4 ? "true" : "flase"}}" aria-controls="flush-collapse-four" onclick="swapSVG(event)">
									<svg class="initial-svg" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: {{$active_tab == 4 ? 'none' : 'block'}}">
										<path d="M14.6699 19.5004C14.3249 19.3644 14.1869 19.1104 14.2119 18.7434C14.2289 18.4914 14.2199 18.2364 14.2119 17.9834C14.2099 17.9314 14.1639 17.8474 14.1219 17.8364C13.5899 17.6914 13.1379 17.4144 12.7579 17.0154C12.4389 17.1974 12.1319 17.3824 11.8159 17.5504C11.5769 17.6774 11.2989 17.6174 11.1199 17.4264C10.9439 17.2384 10.9009 16.9644 11.0389 16.7414C11.1009 16.6414 11.1999 16.5534 11.2999 16.4894C11.5389 16.3364 11.7879 16.1984 12.0359 16.0604C12.1219 16.0124 12.1629 15.9694 12.1319 15.8584C11.9999 15.3834 11.9999 14.9054 12.1329 14.4304C12.1609 14.3304 12.1299 14.2854 12.0479 14.2394C11.7939 14.0984 11.5429 13.9524 11.2929 13.8054C10.9709 13.6154 10.8679 13.2614 11.0439 12.9654C11.2139 12.6794 11.5679 12.5994 11.8859 12.7784C12.1759 12.9414 12.4629 13.1094 12.7579 13.2794C13.1609 12.8534 13.6409 12.5754 14.2179 12.4364C14.2179 12.0734 14.2109 11.7154 14.2199 11.3574C14.2269 11.0654 14.4309 10.8494 14.7219 10.8014C14.9799 10.7584 15.2499 10.9044 15.3479 11.1584C15.3869 11.2594 15.3989 11.3744 15.4009 11.4844C15.4079 11.7984 15.4029 12.1134 15.4029 12.4374C15.9729 12.5764 16.4539 12.8504 16.8539 13.2814C17.1619 13.1034 17.4589 12.9294 17.7589 12.7594C17.9799 12.6344 18.2009 12.6474 18.4049 12.7924C18.6059 12.9344 18.6779 13.1384 18.6389 13.3784C18.6089 13.5684 18.4969 13.7024 18.3329 13.7974C18.0399 13.9674 17.7479 14.1384 17.4509 14.3114C17.6039 14.8444 17.6139 15.3684 17.4789 15.8954C17.4679 15.9364 17.5159 16.0174 17.5579 16.0434C17.8049 16.1954 18.0599 16.3354 18.3099 16.4834C18.6379 16.6774 18.7439 17.0214 18.5709 17.3194C18.3959 17.6204 18.0509 17.6984 17.7169 17.5094C17.4329 17.3484 17.1499 17.1834 16.8559 17.0144C16.5239 17.3594 16.1409 17.6224 15.6869 17.7734C15.4019 17.8684 15.4029 17.8704 15.4029 18.1704C15.4029 18.3494 15.3919 18.5304 15.4049 18.7084C15.4319 19.0724 15.3079 19.3454 14.9669 19.5024H14.6699V19.5004ZM14.8119 16.7194C15.6899 16.7194 16.3859 16.0224 16.3849 15.1434C16.3839 14.2704 15.6789 13.5634 14.8089 13.5624C13.9409 13.5624 13.2269 14.2714 13.2229 15.1374C13.2199 16.0194 13.9219 16.7184 14.8119 16.7184V16.7194Z" fill="white"/>
										<path d="M2.53803 15.9381C2.62703 15.9381 2.69903 15.9381 2.77203 15.9381C4.91803 15.9381 7.06302 15.9381 9.20902 15.9381C9.59002 15.9381 9.85102 16.1821 9.85202 16.5291C9.85202 16.8411 9.61802 17.0971 9.30503 17.1221C9.25002 17.1261 9.19402 17.1241 9.13802 17.1241C6.78202 17.1241 4.42603 17.1241 2.07003 17.1241C1.56403 17.1241 1.34603 16.9081 1.34603 16.4041C1.34603 15.5381 1.34503 14.6731 1.34603 13.8071C1.34903 11.9181 2.63403 10.3821 4.49303 10.0501C4.66903 10.0191 4.84903 10.0031 5.02803 10.0021C7.28503 9.99813 9.54202 9.99913 11.799 9.99913C12.148 9.99913 12.401 10.2251 12.429 10.5511C12.454 10.8351 12.244 11.1131 11.953 11.1721C11.875 11.1881 11.793 11.1851 11.713 11.1851C9.51802 11.1851 7.32303 11.1831 5.12803 11.1861C3.88703 11.1881 2.86103 12.0141 2.59203 13.2221C2.56503 13.3421 2.54103 13.4661 2.54003 13.5881C2.53503 14.3611 2.53803 15.1331 2.53803 15.9351V15.9381Z" fill="white"/>
										<path d="M8.47097 8.413C6.29097 8.413 4.51697 6.643 4.51197 4.466C4.50697 2.285 6.28997 0.5 8.47297 0.5C10.656 0.5 12.44 2.288 12.432 4.468C12.424 6.648 10.651 8.414 8.46997 8.413H8.47097ZM8.47397 7.226C10.005 7.225 11.252 5.977 11.245 4.452C11.239 2.931 9.99797 1.691 8.47897 1.688C6.94997 1.685 5.70197 2.929 5.69897 4.456C5.69597 5.982 6.94297 7.227 8.47397 7.226Z" fill="white"/>
									</svg>
									<svg  class="replacement-svg"  width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: {{$active_tab == 4 ? 'block' : 'none'}}">
										<path d="M14.6699 19.5004C14.3249 19.3644 14.1869 19.1104 14.2119 18.7434C14.2289 18.4914 14.2199 18.2364 14.2119 17.9834C14.2099 17.9314 14.1639 17.8474 14.1219 17.8364C13.5899 17.6914 13.1379 17.4144 12.7579 17.0154C12.4389 17.1974 12.1319 17.3824 11.8159 17.5504C11.5769 17.6774 11.2989 17.6174 11.1199 17.4264C10.9439 17.2384 10.9009 16.9644 11.0389 16.7414C11.1009 16.6414 11.1999 16.5534 11.2999 16.4894C11.5389 16.3364 11.7879 16.1984 12.0359 16.0604C12.1219 16.0124 12.1629 15.9694 12.1319 15.8584C11.9999 15.3834 11.9999 14.9054 12.1329 14.4304C12.1609 14.3304 12.1299 14.2854 12.0479 14.2394C11.7939 14.0984 11.5429 13.9524 11.2929 13.8054C10.9709 13.6154 10.8679 13.2614 11.0439 12.9654C11.2139 12.6794 11.5679 12.5994 11.8859 12.7784C12.1759 12.9414 12.4629 13.1094 12.7579 13.2794C13.1609 12.8534 13.6409 12.5754 14.2179 12.4364C14.2179 12.0734 14.2109 11.7154 14.2199 11.3574C14.2269 11.0654 14.4309 10.8494 14.7219 10.8014C14.9799 10.7584 15.2499 10.9044 15.3479 11.1584C15.3869 11.2594 15.3989 11.3744 15.4009 11.4844C15.4079 11.7984 15.4029 12.1134 15.4029 12.4374C15.9729 12.5764 16.4539 12.8504 16.8539 13.2814C17.1619 13.1034 17.4589 12.9294 17.7589 12.7594C17.9799 12.6344 18.2009 12.6474 18.4049 12.7924C18.6059 12.9344 18.6779 13.1384 18.6389 13.3784C18.6089 13.5684 18.4969 13.7024 18.3329 13.7974C18.0399 13.9674 17.7479 14.1384 17.4509 14.3114C17.6039 14.8444 17.6139 15.3684 17.4789 15.8954C17.4679 15.9364 17.5159 16.0174 17.5579 16.0434C17.8049 16.1954 18.0599 16.3354 18.3099 16.4834C18.6379 16.6774 18.7439 17.0214 18.5709 17.3194C18.3959 17.6204 18.0509 17.6984 17.7169 17.5094C17.4329 17.3484 17.1499 17.1834 16.8559 17.0144C16.5239 17.3594 16.1409 17.6224 15.6869 17.7734C15.4019 17.8684 15.4029 17.8704 15.4029 18.1704C15.4029 18.3494 15.3919 18.5304 15.4049 18.7084C15.4319 19.0724 15.3079 19.3454 14.9669 19.5024H14.6699V19.5004ZM14.8119 16.7194C15.6899 16.7194 16.3859 16.0224 16.3849 15.1434C16.3839 14.2704 15.6789 13.5634 14.8089 13.5624C13.9409 13.5624 13.2269 14.2714 13.2229 15.1374C13.2199 16.0194 13.9219 16.7184 14.8119 16.7184V16.7194Z" fill="#0F0F0F" />
										<path d="M2.53803 15.9381C2.62703 15.9381 2.69903 15.9381 2.77203 15.9381C4.91803 15.9381 7.06302 15.9381 9.20902 15.9381C9.59002 15.9381 9.85102 16.1821 9.85202 16.5291C9.85202 16.8411 9.61802 17.0971 9.30503 17.1221C9.25002 17.1261 9.19402 17.1241 9.13802 17.1241C6.78202 17.1241 4.42603 17.1241 2.07003 17.1241C1.56403 17.1241 1.34603 16.9081 1.34603 16.4041C1.34603 15.5381 1.34503 14.6731 1.34603 13.8071C1.34903 11.9181 2.63403 10.3821 4.49303 10.0501C4.66903 10.0191 4.84903 10.0031 5.02803 10.0021C7.28503 9.99813 9.54202 9.99913 11.799 9.99913C12.148 9.99913 12.401 10.2251 12.429 10.5511C12.454 10.8351 12.244 11.1131 11.953 11.1721C11.875 11.1881 11.793 11.1851 11.713 11.1851C9.51802 11.1851 7.32303 11.1831 5.12803 11.1861C3.88703 11.1881 2.86103 12.0141 2.59203 13.2221C2.56503 13.3421 2.54103 13.4661 2.54003 13.5881C2.53503 14.3611 2.53803 15.1331 2.53803 15.9351V15.9381Z"fill="#0F0F0F"/>
										<path d="M8.47097 8.413C6.29097 8.413 4.51697 6.643 4.51197 4.466C4.50697 2.285 6.28997 0.5 8.47297 0.5C10.656 0.5 12.44 2.288 12.432 4.468C12.424 6.648 10.651 8.414 8.46997 8.413H8.47097ZM8.47397 7.226C10.005 7.225 11.252 5.977 11.245 4.452C11.239 2.931 9.99797 1.691 8.47897 1.688C6.94997 1.685 5.70197 2.929 5.69897 4.456C5.69597 5.982 6.94297 7.227 8.47397 7.226Z" fill="#0F0F0F"/>
									</svg>&nbsp;&nbsp;
									ADMIN Control
								</button>
							</h2>
							<div id="flush-collapse-four" class="accordion-collapse collapse {{$active_tab == 4 ? 'show' : ''}}" aria-labelledby="flush-heading-four"
              data-bs-parent="#accordionFlushExample">
								<div class="accordion-body">
									<a href="{{route('ClientAdminControlUploadedFileList')}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'ClientAdminControlUploadedFileList' ? 'active' : ''}}"
										style="width: 100%;">Uploaded Files</a>
								</div>
							</div>
						</div>						
						
						<div class="logout-container">
							<a href="#" class="logout-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path class="button-icon" d="M18.529 13.141C18.423 13.07 18.3 13.032 18.171 13.032C17.89 13.032 17.634 13.206 17.487 13.498C16.121 16.211 13.421 17.896 10.441 17.896C9.06602 17.896 7.69101 17.528 6.46302 16.831C3.52402 15.163 1.97102 11.689 2.68702 8.38495C3.43702 4.92395 6.29102 2.41395 9.79101 2.13895C11.916 1.97095 13.853 2.59095 15.523 3.97895C16.353 4.66795 17.015 5.52295 17.548 6.59295C17.668 6.83295 17.892 6.97595 18.148 6.97595C18.255 6.97595 18.359 6.95095 18.459 6.90095C18.797 6.72995 18.931 6.33495 18.762 6.00095C17.359 3.21795 15.098 1.50095 12.043 0.896953C11.809 0.850953 11.573 0.821953 11.324 0.791953C11.217 0.778953 11.111 0.765953 11.004 0.751953H9.85001H9.83002C9.72602 0.765953 9.62202 0.778953 9.51802 0.792953C9.28202 0.822953 9.03802 0.854953 8.80202 0.893953C5.25702 1.47595 2.22302 4.33295 1.42402 7.83995C1.35302 8.15395 1.30902 8.46995 1.26302 8.80895C1.24102 8.96795 1.22002 9.12695 1.19502 9.28495C1.18802 9.32695 1.18002 9.36795 1.16902 9.41895L1.16602 10.571V10.59C1.17902 10.681 1.18902 10.773 1.20102 10.868C1.22602 11.083 1.25102 11.286 1.28402 11.491C1.62702 13.582 2.68502 15.509 4.26502 16.917C5.84702 18.326 7.88102 19.152 9.99302 19.241C10.141 19.247 10.29 19.25 10.436 19.25C12.784 19.25 14.882 18.43 16.671 16.814C17.526 16.042 18.223 15.109 18.743 14.04C18.908 13.701 18.822 13.339 18.528 13.141H18.529Z" fill="#808080"/>
									<path class="button-icon" d="M11.7121 11.2731C11.5811 11.4041 11.4501 11.5341 11.3191 11.6651L11.3091 11.6751C11.0451 11.9381 10.7721 12.2091 10.5081 12.4801C10.3551 12.6371 10.2851 12.8381 10.3111 13.0451C10.3371 13.2481 10.4501 13.4201 10.6301 13.5301C10.7391 13.5961 10.8561 13.6301 10.9761 13.6301C11.1621 13.6301 11.3411 13.5501 11.4931 13.3991C12.1031 12.7931 12.7101 12.1851 13.3171 11.5761L13.7101 11.1821C14.4261 10.4651 14.4291 9.54012 13.7171 8.82512C13.0231 8.12812 12.3261 7.43312 11.6301 6.73812L11.5261 6.63512C11.4621 6.57112 11.4081 6.52112 11.3531 6.48412C11.2421 6.40912 11.1141 6.37012 10.9821 6.37012C10.7831 6.37012 10.5931 6.46012 10.4601 6.61612C10.2331 6.88112 10.2471 7.25912 10.4911 7.51312C10.7581 7.79112 11.0371 8.06812 11.3071 8.33612L11.3291 8.35812C11.4551 8.48312 11.5801 8.60712 11.7051 8.73312C11.7361 8.76412 11.7661 8.79712 11.8041 8.83812L12.2541 9.32312H8.66915C8.66915 9.32312 7.55815 9.32112 7.33815 9.32112C7.04015 9.32112 6.74215 9.32112 6.44415 9.32512C6.21215 9.32712 6.01115 9.42212 5.88015 9.59112C5.75415 9.75312 5.71315 9.95812 5.76515 10.1681C5.84415 10.4871 6.10715 10.6781 6.47115 10.6781C7.22915 10.6781 7.98715 10.6781 8.74515 10.6781H12.2711L11.8061 11.1721C11.7681 11.2121 11.7401 11.2431 11.7111 11.2721L11.7121 11.2731Z" fill="#808080"/>
									</svg>
								Logout
							</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>
						</div>

					</div>
				</div>
				<!-- Sidebar End -->

				<!-- Bottom Navbar Start -->
				<div class="mobile-bottom-nav p-0 d-lg-none d-xl-none d-lg-none d-xs-block d-sm-block d-md-none">
					<div class="mobile-bottom-nav-content-div">
						{{-- Track Lots --}}
							<button class="mobile-bottom-nav-content btn {{$active_tab == '1' ? 'active' : ''}}" onclick="openPopup('popupOverlay1')">
									<div class="icon-container">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path
															d="M11.8068 23.4C11.5992 23.2296 11.3592 23.0856 11.1876 22.884C8.97837 20.3016 6.77637 17.712 4.57797 15.1212C3.48357 13.8312 2.91237 12.3156 2.81277 10.6464C2.57877 6.68763 4.20237 3.68283 7.62237 1.69443C9.18717 0.784834 10.9236 0.490835 12.7296 0.633635C14.6904 0.788435 16.434 1.48203 17.9256 2.76723C19.704 4.29963 20.7732 6.23523 21.1128 8.56083C21.36 10.26 21.1344 11.9016 20.442 13.4748C20.1336 14.1732 19.6896 14.784 19.1964 15.3624C17.0316 17.9052 14.868 20.448 12.696 22.9848C12.5532 23.1516 12.342 23.262 12.1632 23.3988H11.8068V23.4ZM11.9904 21.3792C12.0276 21.33 12.0444 21.3048 12.0636 21.282C14.0736 18.9192 16.092 16.5636 18.0876 14.1888C18.4368 13.7736 18.756 13.3068 18.9768 12.8136C19.794 10.9896 19.83 9.11524 19.1496 7.24564C17.6892 3.24003 13.536 1.30923 9.60957 2.57043C6.48117 3.57483 4.38717 6.48723 4.36437 9.77524C4.35357 11.3376 4.71957 12.798 5.74317 14.022C7.28157 15.8604 8.84157 17.6796 10.3944 19.506C10.9176 20.1216 11.442 20.736 11.9904 21.3792Z"
															fill="#808080" />
													<path
															d="M11.988 14.2596C9.54003 14.2656 7.53243 12.2604 7.52523 9.80161C7.51803 7.34881 9.50643 5.34721 11.9712 5.32681C14.418 5.30641 16.446 7.33201 16.4448 9.79681C16.4424 12.2544 14.4456 14.2548 11.9892 14.2596H11.988ZM14.8524 9.78961C14.8488 8.20201 13.5552 6.91681 11.97 6.92401C10.3944 6.93121 9.11523 8.22121 9.12003 9.79801C9.12363 11.3868 10.4172 12.6744 12.0012 12.6648C13.5768 12.6552 14.8572 11.3652 14.8524 9.78961Z"
															fill="#808080" />
											</svg>
									</div>
									<div class="mobile-bottom-nav-content-heading">Track Lots</div>
							</button>

							{{-- Your Assets --}}
							<button class="mobile-bottom-nav-content btn {{$active_tab == '2' ? 'active' : ''}}">
									<div class="icon-container">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path
															d="M0.600016 4.3164C0.724816 3.8784 0.940816 3.5004 1.37762 3.318C1.59122 3.2292 1.83362 3.1668 2.06282 3.1644C3.82202 3.1524 5.58122 3.1572 7.34042 3.1572C7.89242 3.1572 8.32562 3.384 8.64482 3.8364C9.07682 4.4484 9.51842 5.0532 9.94802 5.6676C10.0344 5.7912 10.128 5.8332 10.2756 5.8332C12.948 5.8284 15.6204 5.8308 18.2916 5.8296C18.888 5.8296 19.3728 6.048 19.644 6.594C19.7484 6.804 19.7892 7.0632 19.794 7.3008C19.8108 8.2056 19.8012 9.1116 19.8012 10.0176C19.8012 10.098 19.8012 10.1796 19.8012 10.2864C19.89 10.2924 19.968 10.3008 20.046 10.3008C20.5956 10.308 21.1464 10.2864 21.6924 10.3248C22.9992 10.416 23.784 11.7492 23.208 12.9216C21.9792 15.4224 20.7276 17.9124 19.4856 20.4072C19.338 20.7036 19.104 20.8428 18.7716 20.8416C13.2192 20.8392 7.66682 20.8416 2.11562 20.8392C1.36562 20.8392 0.870016 20.4684 0.639616 19.758C0.631216 19.7316 0.613216 19.7076 0.598816 19.6824C0.598816 14.5596 0.598816 9.438 0.598816 4.3152L0.600016 4.3164ZM2.32322 19.4964C2.38922 19.5012 2.41802 19.5048 2.44802 19.5048C7.72682 19.5048 13.0044 19.5048 18.2832 19.5096C18.4236 19.5096 18.474 19.4472 18.5268 19.3404C19.0164 18.3504 19.5096 17.3616 20.0016 16.3728C20.6592 15.0528 21.318 13.7328 21.9732 12.4116C22.17 12.0156 21.9996 11.7084 21.558 11.6508C21.492 11.6424 21.4248 11.6388 21.3588 11.6388C16.4148 11.6388 11.4708 11.6388 6.52682 11.6352C6.15842 11.6352 5.92322 11.772 5.76362 12.1188C4.87082 14.058 3.96002 15.9888 3.05642 17.922C2.81522 18.438 2.57642 18.954 2.32322 19.4964ZM1.95122 4.494V17.1168C2.01002 16.9992 2.04362 16.9356 2.07362 16.8696C2.90522 15.09 3.73322 13.3092 4.57322 11.5332C4.68242 11.3016 4.82402 11.0748 4.99682 10.8876C5.40962 10.4376 5.95442 10.2996 6.54962 10.3008C10.4172 10.3032 14.2848 10.302 18.1524 10.302C18.252 10.302 18.3516 10.302 18.4464 10.302V7.1664H18.1632C15.5208 7.1664 12.8772 7.1628 10.2348 7.1688C9.65162 7.17 9.20882 6.948 8.87762 6.468C8.46482 5.8704 8.03042 5.286 7.61402 4.6896C7.51442 4.548 7.40882 4.488 7.23122 4.4892C5.55362 4.4964 3.87602 4.494 2.19842 4.494H1.95122Z"
															fill="#808080" />
											</svg>
									</div>
									<div class="mobile-bottom-nav-content-heading">Your Assets</div>
							</button>

							{{-- Admin Panel --}}
							<button class="mobile-bottom-nav-content btn {{$active_tab == '3' ? 'active' : ''}}">
									<div class="icon-container">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path
															d="M17.604 23.4C17.19 23.2368 17.0244 22.932 17.0544 22.4916C17.0748 22.1892 17.064 21.8832 17.0544 21.5796C17.052 21.5172 16.9968 21.4164 16.9464 21.4032C16.308 21.2292 15.7656 20.8968 15.3096 20.418C14.9268 20.6364 14.5584 20.8584 14.1792 21.06C13.8924 21.2124 13.5588 21.1404 13.344 20.9112C13.1328 20.6856 13.0812 20.3568 13.2468 20.0892C13.3212 19.9692 13.44 19.8636 13.56 19.7868C13.8468 19.6032 14.1456 19.4376 14.4432 19.272C14.5464 19.2144 14.5956 19.1628 14.5584 19.0296C14.4 18.4596 14.4 17.886 14.5596 17.316C14.5932 17.196 14.556 17.142 14.4576 17.0868C14.1528 16.9176 13.8516 16.7424 13.5516 16.566C13.1652 16.338 13.0416 15.9132 13.2528 15.558C13.4568 15.2148 13.8816 15.1188 14.2632 15.3336C14.6112 15.5292 14.9556 15.7308 15.3096 15.9348C15.7932 15.4236 16.3692 15.09 17.0616 14.9232C17.0616 14.4876 17.0532 14.058 17.064 13.6284C17.0724 13.278 17.3172 13.0188 17.6664 12.9612C17.976 12.9096 18.3 13.0848 18.4176 13.3896C18.4644 13.5108 18.4788 13.6488 18.4812 13.7808C18.4896 14.1576 18.4836 14.5356 18.4836 14.9244C19.1676 15.0912 19.7448 15.42 20.2248 15.9372C20.5944 15.7236 20.9508 15.5148 21.3108 15.3108C21.576 15.1608 21.8412 15.1764 22.086 15.3504C22.3272 15.5208 22.4136 15.7656 22.3668 16.0536C22.3308 16.2816 22.1964 16.4424 21.9996 16.5564C21.648 16.7604 21.2976 16.9656 20.9412 17.1732C21.1248 17.8128 21.1368 18.4416 20.9748 19.074C20.9616 19.1232 21.0192 19.2204 21.0696 19.2516C21.366 19.434 21.672 19.602 21.972 19.7796C22.3656 20.0124 22.4928 20.4252 22.2852 20.7828C22.0752 21.144 21.6612 21.2376 21.2604 21.0108C20.9196 20.8176 20.58 20.6196 20.2272 20.4168C19.8288 20.8308 19.3692 21.1464 18.8244 21.3276C18.4824 21.4416 18.4836 21.444 18.4836 21.804C18.4836 22.0188 18.4704 22.236 18.486 22.4496C18.5184 22.8864 18.3696 23.214 17.9604 23.4024H17.604V23.4ZM17.7744 20.0628C18.828 20.0628 19.6632 19.2264 19.662 18.1716C19.6608 17.124 18.8148 16.2756 17.7708 16.2744C16.7292 16.2744 15.8724 17.1252 15.8676 18.1644C15.864 19.2228 16.7064 20.0616 17.7744 20.0616V20.0628Z"
															fill="#808080" />
													<path
															d="M3.04562 19.1256C3.15242 19.1256 3.23882 19.1256 3.32642 19.1256C5.90162 19.1256 8.47562 19.1256 11.0508 19.1256C11.508 19.1256 11.8212 19.4184 11.8224 19.8348C11.8224 20.2092 11.5416 20.5164 11.166 20.5464C11.1 20.5512 11.0328 20.5488 10.9656 20.5488C8.13842 20.5488 5.31122 20.5488 2.48402 20.5488C1.87682 20.5488 1.61522 20.2896 1.61522 19.6848C1.61522 18.6456 1.61402 17.6076 1.61522 16.5684C1.61882 14.3016 3.16082 12.4584 5.39162 12.06C5.60282 12.0228 5.81882 12.0036 6.03362 12.0024C8.74202 11.9976 11.4504 11.9988 14.1588 11.9988C14.5776 11.9988 14.8812 12.27 14.9148 12.6612C14.9448 13.002 14.6928 13.3356 14.3436 13.4064C14.25 13.4256 14.1516 13.422 14.0556 13.422C11.4216 13.422 8.78762 13.4196 6.15362 13.4232C4.66442 13.4256 3.43322 14.4168 3.11042 15.8664C3.07802 16.0104 3.04922 16.1592 3.04802 16.3056C3.04202 17.2332 3.04562 18.1596 3.04562 19.122V19.1256Z"
															fill="#808080" />
													<path
															d="M10.1652 10.0956C7.54918 10.0956 5.42038 7.97158 5.41438 5.35918C5.40838 2.74198 7.54798 0.599976 10.1676 0.599976C12.7872 0.599976 14.928 2.74558 14.9184 5.36158C14.9088 7.97758 12.7812 10.0968 10.164 10.0956H10.1652ZM10.1688 8.67118C12.006 8.66998 13.5024 7.17238 13.494 5.34238C13.4868 3.51718 11.9976 2.02918 10.1748 2.02558C8.33998 2.02198 6.84238 3.51478 6.83878 5.34718C6.83518 7.17838 8.33158 8.67238 10.1688 8.67118Z"
															fill="#808080" />
											</svg>
									</div>
									<div class="mobile-bottom-nav-content-heading">Admin Panel</div>
							</button>

							{{-- Admin Control --}}
							<button class="mobile-bottom-nav-content btn {{$active_tab == '4' ? 'active' : ''}}">
									<div class="icon-container">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path
															d="M17.604 23.4C17.19 23.2368 17.0244 22.932 17.0544 22.4916C17.0748 22.1892 17.064 21.8832 17.0544 21.5796C17.052 21.5172 16.9968 21.4164 16.9464 21.4032C16.308 21.2292 15.7656 20.8968 15.3096 20.418C14.9268 20.6364 14.5584 20.8584 14.1792 21.06C13.8924 21.2124 13.5588 21.1404 13.344 20.9112C13.1328 20.6856 13.0812 20.3568 13.2468 20.0892C13.3212 19.9692 13.44 19.8636 13.56 19.7868C13.8468 19.6032 14.1456 19.4376 14.4432 19.272C14.5464 19.2144 14.5956 19.1628 14.5584 19.0296C14.4 18.4596 14.4 17.886 14.5596 17.316C14.5932 17.196 14.556 17.142 14.4576 17.0868C14.1528 16.9176 13.8516 16.7424 13.5516 16.566C13.1652 16.338 13.0416 15.9132 13.2528 15.558C13.4568 15.2148 13.8816 15.1188 14.2632 15.3336C14.6112 15.5292 14.9556 15.7308 15.3096 15.9348C15.7932 15.4236 16.3692 15.09 17.0616 14.9232C17.0616 14.4876 17.0532 14.058 17.064 13.6284C17.0724 13.278 17.3172 13.0188 17.6664 12.9612C17.976 12.9096 18.3 13.0848 18.4176 13.3896C18.4644 13.5108 18.4788 13.6488 18.4812 13.7808C18.4896 14.1576 18.4836 14.5356 18.4836 14.9244C19.1676 15.0912 19.7448 15.42 20.2248 15.9372C20.5944 15.7236 20.9508 15.5148 21.3108 15.3108C21.576 15.1608 21.8412 15.1764 22.086 15.3504C22.3272 15.5208 22.4136 15.7656 22.3668 16.0536C22.3308 16.2816 22.1964 16.4424 21.9996 16.5564C21.648 16.7604 21.2976 16.9656 20.9412 17.1732C21.1248 17.8128 21.1368 18.4416 20.9748 19.074C20.9616 19.1232 21.0192 19.2204 21.0696 19.2516C21.366 19.434 21.672 19.602 21.972 19.7796C22.3656 20.0124 22.4928 20.4252 22.2852 20.7828C22.0752 21.144 21.6612 21.2376 21.2604 21.0108C20.9196 20.8176 20.58 20.6196 20.2272 20.4168C19.8288 20.8308 19.3692 21.1464 18.8244 21.3276C18.4824 21.4416 18.4836 21.444 18.4836 21.804C18.4836 22.0188 18.4704 22.236 18.486 22.4496C18.5184 22.8864 18.3696 23.214 17.9604 23.4024H17.604V23.4ZM17.7744 20.0628C18.828 20.0628 19.6632 19.2264 19.662 18.1716C19.6608 17.124 18.8148 16.2756 17.7708 16.2744C16.7292 16.2744 15.8724 17.1252 15.8676 18.1644C15.864 19.2228 16.7064 20.0616 17.7744 20.0616V20.0628Z"
															fill="#808080" />
													<path
															d="M3.04562 19.1256C3.15242 19.1256 3.23882 19.1256 3.32642 19.1256C5.90162 19.1256 8.47562 19.1256 11.0508 19.1256C11.508 19.1256 11.8212 19.4184 11.8224 19.8348C11.8224 20.2092 11.5416 20.5164 11.166 20.5464C11.1 20.5512 11.0328 20.5488 10.9656 20.5488C8.13842 20.5488 5.31122 20.5488 2.48402 20.5488C1.87682 20.5488 1.61522 20.2896 1.61522 19.6848C1.61522 18.6456 1.61402 17.6076 1.61522 16.5684C1.61882 14.3016 3.16082 12.4584 5.39162 12.06C5.60282 12.0228 5.81882 12.0036 6.03362 12.0024C8.74202 11.9976 11.4504 11.9988 14.1588 11.9988C14.5776 11.9988 14.8812 12.27 14.9148 12.6612C14.9448 13.002 14.6928 13.3356 14.3436 13.4064C14.25 13.4256 14.1516 13.422 14.0556 13.422C11.4216 13.422 8.78762 13.4196 6.15362 13.4232C4.66442 13.4256 3.43322 14.4168 3.11042 15.8664C3.07802 16.0104 3.04922 16.1592 3.04802 16.3056C3.04202 17.2332 3.04562 18.1596 3.04562 19.122V19.1256Z"
															fill="#808080" />
													<path
															d="M10.1652 10.0956C7.54918 10.0956 5.42038 7.97158 5.41438 5.35918C5.40838 2.74198 7.54798 0.599976 10.1676 0.599976C12.7872 0.599976 14.928 2.74558 14.9184 5.36158C14.9088 7.97758 12.7812 10.0968 10.164 10.0956H10.1652ZM10.1688 8.67118C12.006 8.66998 13.5024 7.17238 13.494 5.34238C13.4868 3.51718 11.9976 2.02918 10.1748 2.02558C8.33998 2.02198 6.84238 3.51478 6.83878 5.34718C6.83518 7.17838 8.33158 8.67238 10.1688 8.67118Z"
															fill="#808080" />
											</svg>
									</div>
									<div class="mobile-bottom-nav-content-heading">Admin Control</div>
							</button>
					</div>
				</div>
				<!-- Bottom Navbar End -->

				<!-- popup for track lot (1)-->
				<div class="popup-overlay" id="popupOverlay1">
					<div class="popup-content">
							<button class="close-btn" onclick="closePopup('popupOverlay1')">
									<img src="{{asset('IMG/Frame_261.png')}}" alt="">
							</button>
							<p class="{{$active_link == 'active_lot' ? 'active' : ''}}">
								<a class="active-link-track-mob" href="{{route('TrackLots', ['lotStatus' => 'active'])}}" >Active</a>
							</p>
							<p class="{{$active_link == 'completed_lot' ? 'active' : ''}}">
								<a class="completed-link-track-mob" href="{{route('TrackLots', ['lotStatus' => 'completed'])}}" >Completed</a>
							</p>
					</div>
			</div>
		 <!-- popup for track lot end-->

		 <!-- Sidebar popup container -->
		 <div class="side-bar-overlay" id="overlay" onclick="closeSidebarPopup()"></div>
		 <div class="sidebar-popup" id="sidebarPopup">
			<div class="sidebar-content">
					<!-- Content inside the sidebar popup -->
					<button class="side-bar-close-btn" onclick="closeSidebarPopup()">
							<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M12.5 27.5L27.5 12.5M27.5 27.5L12.5 12.5" stroke="#808080" stroke-linecap="round"
											stroke-linejoin="round" />
									<rect x="0.5" y="0.5" width="39" height="39" stroke="#333333" />
							</svg>
					</button>
					<div class="profile-mob-div">
							<div class="profile-img-name-div">
									@php
										$profile_avtar = $user_data->profile_avtar;
										$profile_avtar_path =  asset('uploades/profileavtar/'.$profile_avtar);
										if(!file_exists($profile_avtar_path) && $profile_avtar != ''){
												$profile_avtar_src = $profile_avtar_path;
										}else{
												// $profile_avtar_src = asset("assets-images\Desktop-Assets\your profile\blank-avtar.jpg");
												$profile_avtar_src = asset('IMG/ben-sweet-2LowviVHZ-E-unsplash.jpg');
										}
									@endphp
									<div class="rounded">
										 <img src="{{$profile_avtar_src}}" alt="" class="rounded-circle profile-pic-mobile">
									</div>
									<div class="profile-name">
										{{-- {{ ucwords($user_data->name) .' '. ucwords($user_data->last_name) }} --}}
										<a style="color: #fff;text-decoration:none" href="{{route('ClientProfile')}}" > {{ ucwords($user_data->name) .' '. ucwords($user_data->last_name) }}</a>
									</div>
							</div>
	
							<div>
									<hr style="background: #333; height: 1px; margin-top: 0; margin-bottom: 16px;border: 0;">
									<p class="logout-mob-text" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</p>
							</div>
					</div>
			</div>
		 </div>
		 <!-- Sidebar popup container End-->

				<div class="col-sm-10 border border-dark main-container-resp offset-lg-2">
					<div class="row" >
						<div class="col-12" style="display: inline-flex; position: fixed; z-index: 9999;">
							{{-- url-copied --}}
							<div class="url-copied d-none" style="display: none" >
								<div class="url-copied-element">
									 <p class="url-copied-text">URL copied!</p>
									 <div class="url-copied-link">
											<p class="url-copied-link-text" style="pointer-events: none">https://www.youtube.com</p>											
												<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
														<rect width="30" height="30" rx="15" fill="#98A7DA"/>
														<g clip-path="url(#clip0_2553_6415)">
														<path d="M18 15.675V18.825C18 21.45 16.95 22.5 14.325 22.5H11.175C8.55 22.5 7.5 21.45 7.5 18.825V15.675C7.5 13.05 8.55 12 11.175 12H14.325C16.95 12 18 13.05 18 15.675Z" stroke="#0F0F0F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
														<path d="M22.5 11.175V14.325C22.5 16.95 21.45 18 18.825 18H18V15.675C18 13.05 16.95 12 14.325 12H12V11.175C12 8.55 13.05 7.5 15.675 7.5H18.825C21.45 7.5 22.5 8.55 22.5 11.175Z" stroke="#0F0F0F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
														</g>
														<defs>
														<clipPath id="clip0_2553_6415">
														<rect width="18" height="18" fill="white" transform="translate(6 6)"/>
														</clipPath>
														</defs>
												</svg>                    
										 
									 </div>
								</div>
							</div>
							<!-- fav div -->
							<div class="added-fav-div d-none">
								<p class="added-fav-and-notfav-Text">Added to favourites</p>
							</div>

							<!-- Multipal div -->
							<div class="Multipal-fav-div d-none">
								<p class="Multipal-fav-and-notfav-Text"></p>
							</div>
		
							<!--  Removefav div -->
							<div class="added-notfav-div d-none">
								<p class="added-fav-and-notfav-Text error-text">Removed from favourites</p>
							</div>
						</div>
					</div>
          @yield('main_content')

					{{-- common share url popover --}}
					<div class="urlpopover">
						<div class="url-copied-new">
							<div class="url-copied-element">
								<p class="url-copied-text">URL copied!</p>
								<div class="url-copied-link">
									<p class="url-copied-link-text" id='target_url'>https://www.youtube.com</p>
									<span id="share_btn_new" style="cursor: pointer; ">
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
							</div>
						</div>
					</div>
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

	<!-- Navbar Script hide and show -->
	<script>
		let prevScrollpos = window.pageYOffset;

		window.onscroll = function () {
				let currentScrollPos = window.pageYOffset;
				if (prevScrollpos > currentScrollPos) {
						document.querySelector(".Mobnavbar").classList.add("show");
						document.querySelector(".Mobnavbar").classList.remove("hide");
				} else {
						document.querySelector(".Mobnavbar").classList.add("hide");
						document.querySelector(".Mobnavbar").classList.remove("show");
				}
				prevScrollpos = currentScrollPos;
		};
		</script>

		<script>
				const dropdownItems = document.querySelectorAll(".services-text-dropdown-item");
				const buttonText = document.querySelector(".button-text");

				dropdownItems.forEach((item) => {
						item.addEventListener("click", function (event) {
								event.preventDefault();
								const selectedItemText = item.textContent;
								buttonText.textContent = selectedItemText;
								buttonText.style.color = "#FFFFFF";
								dropdownItems.forEach((item) => {
										item.classList.remove("selected");
								});
								item.classList.add("selected");
						});
				});
		</script>

	<!-- Progress circle script -->
	<script>
		function animateProgressBars() {
				var progressCircles = document.querySelectorAll('.progress-circle');
				progressCircles.forEach(function (circle) {
						var progressValue = circle.querySelector('.progress-value');
						var progress = circle.querySelector('.progress-bar');

						var percentage = parseInt(progressValue.textContent);

						var circumference = 2 * Math.PI * progress.getAttribute('r');
						var offset = circumference * (100 - percentage) / 100;

						progress.style.strokeDashoffset = circumference;

						progress.classList.remove('progress-bar-filled');
						progress.getBoundingClientRect();

						progress.style.transition = 'stroke-dashoffset 1s ease-in-out';
						progress.style.strokeDashoffset = offset + 'px';

						if (percentage === 100) {
								progress.classList.add('progress-bar-filled');
						}
				});
		}
		// Example usage
		animateProgressBars();
	</script>

	<!-- bottom popup script -->
	<script>
			function openPopup(popupId) {
					const popup = document.getElementById(popupId);
					if (popup) {
							popup.style.display = "block";
					}
			}
			function closePopup(popupId) {
					const popup = document.getElementById(popupId);
					if (popup) {
							popup.style.display = "none";
					}
			}
	</script>

	<!-- sidebar popup script -->
	<script>
			function openSidebarPopup(event) {
				const triggerElement = event.currentTarget;
				const popupId = triggerElement.getAttribute("data-popup-target");
				const sidebarPopup = document.getElementById(popupId);
				const overlay = document.getElementById("overlay");
				sidebarPopup.classList.add("open");
				overlay.style.display = "block";
			}
			function closeSidebarPopup() {
					const sidebarPopup = document.getElementById("sidebarPopup");
					const overlay = document.getElementById("overlay");
					sidebarPopup.classList.remove("open");
					overlay.style.display = "none";
			}
	</script>

	{{-- New share and copy url propover script --}}

	<script>
    const popoverTriggers = document.querySelectorAll('.share_popover_trigger');
    const urlpopover = document.querySelector('.urlpopover');

    const hidePopover_new = function () {
      urlpopover.style.display = 'none';
    };

    popoverTriggers.forEach(function (trigger) {
      trigger.addEventListener('click', function (e) {
        e.preventDefault();
				const target_id = e.target.getAttribute('data-id');
				const target_url = e.target.getAttribute('data-url');
				console.log({
					target_id,target_url
				})
				navigator.clipboard.writeText(target_url);
				$("#target_url").html(target_url)


				document.getElementById("share_btn_new").setAttribute("data-id", target_id);

        // const rect = trigger.getBoundingClientRect();
        // const triggerHeight = rect.height;
        // const triggerTop = rect.top + window.pageYOffset;
        // const triggerLeft = rect.left + window.pageXOffset;
        // urlpopover.style.top = triggerTop + triggerHeight + 'px';
        // urlpopover.style.left = triggerLeft + 'px';
        // urlpopover.style.display = 'block'
				;
				const rect = trigger.getBoundingClientRect();
					const triggerHeight = rect.height;
					const triggerTop = rect.top + window.pageYOffset;
					const triggerLeft = rect.left + window.pageXOffset;
					const popoverHeight = urlpopover.offsetHeight;
					const offset = 70; // Adjust this value to increase or decrease the offset
					const topPosition = triggerTop - popoverHeight - offset;
					const leftPosition = triggerLeft;
					urlpopover.style.top = topPosition + 'px';
					urlpopover.style.left = leftPosition + 'px';
					urlpopover.style.display = 'block';
      });
    });

    document.addEventListener('click', function (e) {
      const targetElement = e.target;

      if (!urlpopover.contains(targetElement) && !targetElement.classList.contains('share_popover_trigger')) {
        hidePopover_new();
      }
    });

    urlpopover.addEventListener('click', function (e) {
      e.stopPropagation();
    });

  </script>

	{{-- Adding click event for Share  --}}
	<script>
		var button = document.getElementById("share_btn_new");
		button.addEventListener("click", function() {
			console.log('button', button)
			var linkId = document.getElementById("share_btn_new").getAttribute("data-id");
			var link = document.getElementById(linkId);
			console.log({linkId , link})
			if (link) {
				link.click();
			}
		});
	</script>

	{{-- view details copy link --}}

	<script>
			var button = document.getElementById("share_btn");
			button.addEventListener("click", function() {
				var linkId = button.getAttribute("data-id");
				var link = document.getElementById(linkId);
				console.log({linkId , link})

				if (link) {
					link.click();
					$("#share_btn").addClass('active')
					setTimeout(() => {
						$("#share_btn").removeClass('active')
					}, 2000);
				}
			});
		// function copy_link_new(){
		// 	const linkId = button.getAttribute("data-id");
		// 	const link = document.getElementById(linkId);
		// 	if (link) {
		// 		// link.click();
		// 	}

		// }
	</script>
	{{-- Svg script --}}
		<script>
			function swapSVG(event) {
				$(".initial-svg").css("display", "block");
				$(".replacement-svg").css("display", "none");
				
				var container = event.currentTarget;
				var initialSVG = container.querySelector(".initial-svg");
				var replacementSVG = container.querySelector(".replacement-svg");
				

				if (container.classList.contains("collapsed")) {
					initialSVG.style.display = "block";
					replacementSVG.style.display = "none";
				} else {
					initialSVG.style.display = "none";
					replacementSVG.style.display = "block";
				}
			}
		</script>	
	<script>
    var buttons = document.getElementsByClassName("myButton");
    var popovers = document.getElementsByClassName("myPopover");

    for (var i = 0; i < buttons.length; i++) {
      buttons[i].addEventListener("click", createToggleHandler(i));
    }

    document.addEventListener("click", function (event) {
      hideAllPopovers();
    });

    function createToggleHandler(index) {
      return function (event) {
        event.stopPropagation();
        var popover = popovers[index];
        if (popover.style.display === "none") {
          hideAllPopovers();
          popover.style.display = "block";
        } else {
          popover.style.display = "none";
        }
      };
    }

    function hideAllPopovers() {
      for (var i = 0; i < popovers.length; i++) {
        popovers[i].style.display = "none";
      }
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
		$('.url-copied-link-text').text(url_is);
		$('.url-copied').removeClass('d-none');

		setTimeout(() => {
			$('.url-copied').addClass('d-none');
		}, 2000);
		// alert("Download Url copied to clipboard!");
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
			$("#wrc_numbers").html('')
			$("#wrc_numbers").html($("#wrc_numbers"+key).html())

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
			const target_url = $("#url_"+key).html()
			document.getElementById("share_btn").setAttribute("data-id", key);
			$("#target_copy_url").html(target_url)
			navigator.clipboard.writeText(target_url);
			$(".assets_share").removeClass('d-none')
			console.log('target_url', target_url)
			console.log('service', service)
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
	
	<!--Notifaction Click on bell icon & view more and less-->
	
	 <script>
      document.addEventListener("DOMContentLoaded", function () {
      var popoverTrigger = document.getElementById("popover-trigger");
      var popoverContent = document.getElementById("popover-for-notifaction");
      var isPopoverOpen = false;

      function togglePopover() {
        if (isPopoverOpen) {
          popoverContent.style.display = "none";
          isPopoverOpen = false;
        } else {
          popoverContent.style.display = "block";
          isPopoverOpen = true;
        }
      }

      popoverTrigger.addEventListener("click", function () {
        togglePopover();
      });

      document.addEventListener("click", function (event) {
        if (event.target !== popoverTrigger && !popoverTrigger.contains(event.target) && !popoverContent.contains(event.target)) {
          popoverContent.style.display = "none";
          isPopoverOpen = false;
        }
      });
    });
  </script>
  <script>
    function toggleContent() {
      var contentDiv = document.getElementById("content");
      var viewButton = document.getElementById("viewButton");

      contentDiv.classList.toggle("expanded");

      if (contentDiv.classList.contains("expanded")) {
        viewButton.innerText = "View Less";
      } else {
        viewButton.innerText = "View All";
      }
    }
  </script>

  <!--svg color change when tab active-->
  
  <script>
  function activateTab(tabNumber) {
  const tabs = document.getElementsByClassName("tab");
  
  for (let i = 0; i < tabs.length; i++) {
    tabs[i].classList.remove("active");
  }
  
  const tab = document.querySelector(`.tab:nth-child(${tabNumber})`);
  tab.classList.add("active");
  }
 </script>
 
 <!--Zoomed image script on tap image-->
 
 <script>
        var zoomableImages = document.querySelectorAll(".zoomable-image");
        var zoomedContainer = document.querySelector(".zoomed-container");
        var zoomedImg = zoomedContainer.querySelector(".zoomed-image");
        var previousButton = document.querySelector(".previous-button");
        var nextButton = document.querySelector(".next-button");
        var navigationButtons = document.querySelectorAll(".navigation-buttons");

        var currentIndex = 0;

        zoomableImages.forEach(function(image, index) {
            image.addEventListener("click", function(event) {
                currentIndex = index;
                zoomedImg.src = event.target.src;
                zoomedContainer.classList.add("active");
                navigationButtons.forEach(function(button) {
                    button.classList.add("active");
                });
            });
        });

        previousButton.addEventListener("click", showPreviousImage);
        nextButton.addEventListener("click", showNextImage);

        zoomedContainer.addEventListener("click", function() {
            zoomedContainer.classList.remove("active");
            navigationButtons.forEach(function(button) {
                button.classList.remove("active");
            });
        });

        document.addEventListener("keydown", function(event) {
            if (event.key === "ArrowLeft") {
                showPreviousImage();
            } else if (event.key === "ArrowRight") {
                showNextImage();
            }
        });

        function showPreviousImage() {
            currentIndex = (currentIndex - 1 + zoomableImages.length) % zoomableImages.length;
            zoomedImg.src = zoomableImages[currentIndex].src;
        }

        function showNextImage() {
            currentIndex = (currentIndex + 1) % zoomableImages.length;
            zoomedImg.src = zoomableImages[currentIndex].src;
        }
</script>
 

	{{-- set notification to seen  --}}
	<script>
		async function set_notifiction_to_seen(ids){
			await $.ajax({
				url: "{{ url('set_notifiction_to_seen') }}",
				type: "POST",
				dataType: 'json',
				data: {
					ids,
					_token: '{{ csrf_token() }}'
				},
				success: function(res) {
					console.log(res)
					if(res?.status){
						alert('Notification seen')
						window.location.reload(true);
					}
				}
			});
		}

	</script> 
	
		{{-- Under searchbar search suggestion  --}}
		<script>
            function typeSearchSuggestions(searchInputs, suggestions) {
              var index = 0;
        
              function typeSuggestion() {
                var suggestion = suggestions[index];
                searchInputs.forEach(function(searchInput) {
                  searchInput.placeholder = suggestion;
                });
                index = (index + 1) % suggestions.length;
              }
        
              setInterval(typeSuggestion, 3000); // Repeat every 3 seconds
            }
            var searchInputs = document.querySelectorAll('.search-input');
            var suggestions = ['Search by "Gender" ', 'Search by "Date"', 'Search by "Months"', 'Search by "Year"', 'Search by "Type of clothing"', 'Search by "Product type"'];
            typeSearchSuggestions(searchInputs, suggestions);
  </script>

	@yield('js_scripts')
</body>
</html>