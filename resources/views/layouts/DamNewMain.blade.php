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
			color: #FFF300;
    	background:#0F0F0F;
		}
		.viewport{
			margin-top: 111px;
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
			z-index: 1
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
				<nav class="navbar navbar-expand-md border border-dark fixed-top">
					{{-- logo --}}
					<a class="navbar-brand" href="{{route('home')}}">
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
								<a class="nav-link" href="#" style="color: #D1D1D1;font-weight: 500;font-size: 14px;margin-top: 5px">{{ ucwords($user_data->name) }}</a>
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
									<a href="{{route('Client_Users_list')}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'manage_user' ? 'active' : ''}}"
										style="width: 100%;">Manage user</a>

									<a href="{{route('ClientProfile')}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'ClientProfile' ? 'active' : ''}}"
										style="width: 100%;">Your profile</a>

										<a href="{{route('Client_Setting_new')}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button {{$active_link == 'Client_Setting_new' ? 'active' : ''}}"
										style="width: 100%;">Settings</a>
								</div>
							</div>
						</div>

						{{-- 4rd tab --}}
						<div class="accordion-item">
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

						{{-- Logout btn --}}
						<!--<div class="col log-btn">-->
						<!--	<button type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  class="btn border-0 btn-lg log-out-button">-->
						<!--	    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">-->
      <!--                              <path d="M18.529 13.141C18.423 13.07 18.3 13.032 18.171 13.032C17.89 13.032 17.634 13.206 17.487 13.498C16.121 16.211 13.421 17.896 10.441 17.896C9.06602 17.896 7.69101 17.528 6.46302 16.831C3.52402 15.163 1.97102 11.689 2.68702 8.38495C3.43702 4.92395 6.29102 2.41395 9.79101 2.13895C11.916 1.97095 13.853 2.59095 15.523 3.97895C16.353 4.66795 17.015 5.52295 17.548 6.59295C17.668 6.83295 17.892 6.97595 18.148 6.97595C18.255 6.97595 18.359 6.95095 18.459 6.90095C18.797 6.72995 18.931 6.33495 18.762 6.00095C17.359 3.21795 15.098 1.50095 12.043 0.896953C11.809 0.850953 11.573 0.821953 11.324 0.791953C11.217 0.778953 11.111 0.765953 11.004 0.751953H9.85001H9.83002C9.72602 0.765953 9.62202 0.778953 9.51802 0.792953C9.28202 0.822953 9.03802 0.854953 8.80202 0.893953C5.25702 1.47595 2.22302 4.33295 1.42402 7.83995C1.35302 8.15395 1.30902 8.46995 1.26302 8.80895C1.24102 8.96795 1.22002 9.12695 1.19502 9.28495C1.18802 9.32695 1.18002 9.36795 1.16902 9.41895L1.16602 10.571V10.59C1.17902 10.681 1.18902 10.773 1.20102 10.868C1.22602 11.083 1.25102 11.286 1.28402 11.491C1.62702 13.582 2.68502 15.509 4.26502 16.917C5.84702 18.326 7.88102 19.152 9.99302 19.241C10.141 19.247 10.29 19.25 10.436 19.25C12.784 19.25 14.882 18.43 16.671 16.814C17.526 16.042 18.223 15.109 18.743 14.04C18.908 13.701 18.822 13.339 18.528 13.141H18.529Z" fill="#0F0F0F"/>-->
      <!--                              <path d="M11.7119 11.2731C11.5809 11.4041 11.4499 11.5341 11.3189 11.6651L11.3089 11.6751C11.0449 11.9381 10.7719 12.2091 10.5079 12.4801C10.3549 12.6371 10.2849 12.8381 10.3109 13.0451C10.3369 13.2481 10.4499 13.4201 10.6299 13.5301C10.7389 13.5961 10.8559 13.6301 10.9759 13.6301C11.1619 13.6301 11.3409 13.5501 11.4929 13.3991C12.1029 12.7931 12.7099 12.1851 13.3169 11.5761L13.7099 11.1821C14.4259 10.4651 14.4289 9.54012 13.7169 8.82512C13.0229 8.12812 12.3259 7.43312 11.6299 6.73812L11.5259 6.63512C11.4619 6.57112 11.4079 6.52112 11.3529 6.48412C11.2419 6.40912 11.1139 6.37012 10.9819 6.37012C10.7829 6.37012 10.5929 6.46012 10.4599 6.61612C10.2329 6.88112 10.2469 7.25912 10.4909 7.51312C10.7579 7.79112 11.0369 8.06812 11.3069 8.33612L11.3289 8.35812C11.4549 8.48312 11.5799 8.60712 11.7049 8.73312C11.7359 8.76412 11.7659 8.79712 11.8039 8.83812L12.2539 9.32312H8.6689C8.6689 9.32312 7.5579 9.32112 7.3379 9.32112C7.0399 9.32112 6.7419 9.32112 6.4439 9.32512C6.2119 9.32712 6.0109 9.42212 5.8799 9.59112C5.7539 9.75312 5.7129 9.95812 5.7649 10.1681C5.8439 10.4871 6.1069 10.6781 6.4709 10.6781C7.2289 10.6781 7.9869 10.6781 8.7449 10.6781H12.2709L11.8059 11.1721C11.7679 11.2121 11.7399 11.2431 11.7109 11.2721L11.7119 11.2731Z" fill="#0F0F0F"/>-->
      <!--                          </svg>-->
      <!--                              &nbsp;Logout</button>-->
						<!--	<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">-->
						<!--		@csrf-->
						<!--	</form>-->
						<!--</div>-->
						
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