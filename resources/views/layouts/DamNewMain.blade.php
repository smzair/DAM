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

  <link rel="icon" href="{{ asset('IMG/ODN Logo.jpeg')}}">
	<link rel="stylesheet" href="{{ asset('css/dam_new_style.css')}}">
	<link rel="stylesheet" href="{{ asset('css/dam_new_style_odn.css')}}">
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
    ?>
		<!-- Top navigation bar -->
		<div class="top-section">
			<div class="top_navbar">
				<div class="hamburger w-100">
					<div class="row">
						<div class="col-sm-1 d-flex flex-row align-item-center justify-content-space-around">
							<a style="text-decoration: none;color:#f4fbff; :hover {color: #f4fbff} " href="{{route('home')}}">
								<h2 class="p-0 m-0">ODN</h2>
							</a>
						</div>
						<div class="col-sm-2 d-flex flex-row align-item-center justify-content-space-around">
							<p class="p-0 m-0"><?php echo date('l, d M Y') ?></p>
						</div>
						<div class="col-sm-6">
							<form action="{{route('gloableSearch')}}" method="post">
								@csrf
								<div class="input-group">
									<input type="text" name="search_query" value="{{$search_query}}" class="form-control" placeholder="Search...">
									<div class="input-group-append">
										<button class="btn btn-outline-secondary" type="submit">
											<i class="fa fa-search"></i>
										</button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-sm-3 d-flex" style="justify-content:space-around;">
							<div class="notification-bell">
								<span class="bell-drop">
									<i class="fa fa-bell"></i><span class="notify-count">{{$tot_notification}}</span>
								</span>
							</div>
							<div class="user-details" style=" display: flex;align-items: center;">
								<strong>{{ ucwords($user_data->name) }}</strong>
								<div class="user-image" style="float: right;padding-left: 30px;">
									<img src="{{ asset('IMG/ODN Logo.jpeg')}}" style="max-width: 40px; height: auto;border-radius: 50%;" alt="user">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Top navigation bar END -->

		<!--Left side Bar -->
		<!-- <div class="sidebar">
			<ul>
				<li>
					<a href="#" class="active">
						<span class="icon"><i class="fas fa-home"></i></span>
						<span class="item">Home</span>
					</a>
				</li>
				<li>
					<a href="#">
						<span class="icon"><i class="fas fa-desktop"></i></span>
						<span class="item">My Dashboard</span>
					</a>
				</li>
				<li>
					<a href="#">
						<span class="icon"><i class="fas fa-user-friends"></i></span>
						<span class="item">People</span>
					</a>
				</li>
				<li>
					<a href="#">
						<span class="icon"><i class="fas fa-tachometer-alt"></i></span>
						<span class="item">Perfomance</span>
					</a>
				</li>
				<li>
					<a href="#">
						<span class="icon"><i class="fas fa-database"></i></span>
						<span class="item">Development</span>
					</a>
				</li>
				<li>
					<a href="#">
						<span class="icon"><i class="fas fa-chart-line"></i></span>
						<span class="item">Reports</span>
					</a>
				</li>
				<li>
					<a href="#">
						<span class="icon"><i class="fas fa-user-shield"></i></span>
						<span class="item">Admin</span>
					</a>
				</li>
				<li>
					<a href="#">
						<span class="icon"><i class="fas fa-cog"></i></span>
						<span class="item">Settings</span>
					</a>
				</li>
			</ul>
		</div> -->
		<!--Left side Bar END -->

		<!-- ODN given code -->
		<div class="container-fluid" style="background: #FFFFFF;">
			<!-- Sidebar start -->
			<div class="row viewport">
				<div class="col-lg-2 border border-end-0 ">
					<div class="accordion accordion-flush" id="accordionFlushExample">
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-headingOne">
								<button class="accordion-button collapsed siderbar-button" type="button" data-bs-toggle="collapse"
									data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect width="20" height="20" fill="#9F9F9F" />
										<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
										<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
									</svg> &nbsp;&nbsp;
									TRACK LOTS
								</button>
							</h2>
							<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
								data-bs-parent="#accordionFlushExample">
								<div class="accordion-body">
									<a href="{{route('TrackLots', ['lotStatus' => 'active'])}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button"
										style="width: 100%;">Active</a>
									<a href="{{route('TrackLots', ['lotStatus' => 'completed'])}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button"
										style="width: 100%;">Completed</a>
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-headingTwo">
								<button class="accordion-button collapsed siderbar-button" type="button" data-bs-toggle="collapse"
									data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect width="20" height="20" fill="#9F9F9F" />
										<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
										<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
									</svg> &nbsp;&nbsp;
									YOUR ASSETS
								</button>
							</h2>
							<div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
              data-bs-parent="#accordionFlushExample">
								<div class="accordion-body">
									<a href="{{route('your_assets_files')}}" role="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button"
										style="width: 100%;">File</a>
									<a href="#" role="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button"
										style="width: 100%;">Links</a>
									<a href="#" role="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button"
										style="width: 100%;">Favorites</a>
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-headingThree">
								<button class="accordion-button collapsed siderbar-button" type="button" data-bs-toggle="collapse"
									data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect width="20" height="20" fill="#9F9F9F" />
										<line x1="3.35355" y1="2.64645" x2="17.3536" y2="16.6464" stroke="#D1D1D1" />
										<line x1="2.64645" y1="16.6464" x2="16.6464" y2="2.64645" stroke="#D1D1D1" />
									</svg> &nbsp;&nbsp;
									ADMIN PANEL
								</button>
							</h2>
							<div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree"
              data-bs-parent="#accordionFlushExample">
								<div class="accordion-body">
									<a href="{{route('Client_Users_list')}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button"
										style="width: 100%;">Manage user</a>
									<a href="{{route('ClientProfile')}}" type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button"
										style="width: 100%;">Your profile</a>
										<button type="button" class="btn border-0 rounded-0 btn-secondary btn-lg under-button"
										style="width: 100%;">Settings</button>
								</div>
							</div>
						</div>
						<div class="col">
							<button type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  class="btn border btn-lg last-button log-btn-mob-sty">LOG OUT</button>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						</div>
					</div>
				</div>
				<!-- Sidebar End -->

				<div class="col-sm-10 border main-container-resp">
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
	<script src="{{ asset('ClientsDist\js\common_js_new.js') }}"></script>@yield('js_scripts')
</body>
</html>