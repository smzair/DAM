<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title')</title>

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
	<link rel="stylesheet" href="{{ asset('css/dam_new_style.css')}}">
	<link rel="stylesheet" href="{{ asset('css/dam_new_style_odn.css')}}">
	<style>
		.accordion-item .accordion-body .active{
			color: #FFF866;
    	background: #0F0F0F;
		}
    .viewport{
      height: calc(100% - 70px);
    }
    .viewport_row{
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%,-50%);
    }
	</style>
</head>

<body>
	<div class="wrapper">
		<!-- Top navigation bar -->
		<div class="top-section">
			<div class="top_navbar">
				<div class="hamburger w-100">
					<div class="row">
						<div class="col-sm-1 d-flex flex-row align-item-center justify-content-space-around">
							<a style="text-decoration: none;color:#f4fbff; :hover {color: #f4fbff} " href="{{route('home')}}">
								<h2 class="p-0 m-0">
								    <svg width="73" height="24" viewBox="0 0 73 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 12.0006C0 5.12916 5.29653 0 12.5027 0C19.6426 0 24.9391 5.09545 24.9391 12.0006C24.9391 18.9057 19.6438 24 12.5027 24C5.29653 24 0 18.872 0 12.0006ZM21.5859 12.0006C21.5859 6.80517 17.6981 2.98358 12.5027 2.98358C7.23987 2.98358 3.35203 6.80517 3.35203 12.0006C3.35203 17.196 7.23987 21.0129 12.5027 21.0129C17.6981 21.0129 21.5871 17.196 21.5871 12.0006H21.5859Z" fill="#FFF866"/>
										<path d="M27.3857 0.268555H37.2779C44.8188 0.268555 49.9468 5.03392 49.9468 12.0006C49.9468 18.9674 44.8153 23.7316 37.2779 23.7316H27.3857V0.268555ZM37.0734 20.8154C42.872 20.8154 46.5925 17.2623 46.5925 12.0006C46.5925 6.73899 42.8732 3.18472 37.0734 3.18472H30.7378V20.8154H37.0734Z" fill="#FFF866"/>
										<path d="M72.5696 0.268555V23.7316H69.822L55.7432 6.23456V23.7316H52.3877V0.268555H55.1365L69.2176 17.7656V0.268555H72.5696Z" fill="#FFF866"/>
										</svg>
									</h2>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="container-fluid">
			<!-- Sidebar start -->
			<div class="row viewport">
				<div class="col-sm-12 border border-dark main-container-resp">
          <div class="row viewport_row">
            <div class="text-center">
              <svg width="121" height="120" viewBox="0 0 121 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="0.5" width="120" height="120" fill="#9F9F9F" />
                <line x1="18.8536" y1="17.6464" x2="102.854" y2="101.646" stroke="#D1D1D1" />
                <line x1="18.1464" y1="101.646" x2="102.146" y2="17.6465" stroke="#D1D1D1" />
              </svg>
            </div>
            <div class="text-center">
              <p class="underheadingF mt-4" style="color: #f84646">{{$massage}}</p>
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
	
</body>
</html>
