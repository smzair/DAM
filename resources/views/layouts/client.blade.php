<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Theme Style -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-5.1.3-dist/css\bootstrap.min.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('plugins/visual-percent-preloader/percent-preloader.css')}}" />
    <!-- Common Style -->
    <link rel="stylesheet" href="{{ asset('/css/commonclient_style.css') }}">
</head>
<style type="text/css">
    .logout{
        width: 30px;
    height: 30px;
    display: inline-block;
    margin-left: 10px;
    background-repeat: no-repeat;
    background-size: cover;
    border: 0;
    border-radius: 50%;
    cursor: pointer;
    }
</style>
<body>

    <div class="header-container-wrapper">
        <div class="custom-header">
            <div class="container-fluid">
                <div class="custom-header-content">
                    <div class="custom-logo col-header">
                     <a href="/home" title="Logo">
                        <img src="{{asset('dist/img/logo/odn_logo.svg')}}" alt="ODN" />
                    </a>
                </div>
                <div class="custom-header-right-content col-header">
                    <div class="greeting-wrapper">
                        <div class="col-info greeting-info">
                            <p>Flipkart</p>
                        </div>
                        <div class="col-info user-photo" id="userPhoto">
                            <span class="profile-info" style="background-image: url('dist/img/content-images/dp.jpg');"></span>


                            <ul class="profile-dropdown">
                                <li class="profile-dropdown-item">
                                    <a href="{{route('flipkart.profile')}}" class="profile-dropdown-link" id="editProfile">
                                        Edit
                                    </a>
                                </li>
                                <li class="profile-dropdown-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                 onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                                 <p>   {{ __('Logout') }} </p>
                             </a>
                         </li>
                     </ul>
                 </div>
                 <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                  <img class="logout"  src="{{asset('dist/img/logout.png')}}"></img>
                </a>
             </div>
         </div>
     </div>
 </div>
</div>
</div>

<div class="preloader">
    <div class="inner">
      <span class="percentage"><span id="percentage">10</span>%</span>
  </div>
  <div class="loader-progress" id="loader-progress"> </div>
</div>

<div class="body-container-wrapper">
  @yield('content')
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
</li>
<script src="{{asset('plugins/visual-percent-preloader/percent-preloader.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap-5.1.3-dist/js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('plugins/bootstrap-5.1.3-dist/js/bootstrap.min.js')}}"></script>

<script type="text/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

<script src="{{asset('plugins/jqueryTime/goodMorning.js')}}"></script>

<!-- Common JS -->

<script src="{{ asset('js/common_client.js')}}"></script>

<script>
    $('#greetingMSG').goodMorning();



</script>

</body>
</html>