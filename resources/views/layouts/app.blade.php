<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ODN Connect</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('dist/css/adminlte.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<style>

.login-outer-wrapper-grp {
    display: flex;
    width: 100%;
    background-color: #fff;
}

.door-app-wrapper {
    position: relative;
    width: 360px;
    height: 418px;
}

.door-app {
    background-image: radial-gradient( circle farthest-corner at 10% 20%, rgba(242,11,54,1) 12.2%, rgba(237,52,163,1) 84.8% );
    position: absolute;
    top: 0px;
    left: 0px;
    width: 360px;
    height: 418px;
    transform-origin: left;
    transition: all 0.3s ease-in-out;
    z-index: 9;
    cursor: pointer;
    display: flex;
    align-items: center;
    flex-direction: column-reverse;
    padding-bottom: 20px;
}

.door-app-wrapper.door-open .door-app {
    transform: perspective(1200px) translateZ(0px) translateX(0px) translateY(0px) rotateY(
-100deg
);
}

.open-door-page {
    background-color: #fff;
    width: 75%;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    padding: 0 10px;
    min-height: 570px;
    padding-left: 20px;
}

.img-log-sec {
    max-width: 730px;
    width: 100%;
}

.img-log-sec img {
    width: 100%;
    height: 430px;
}

.open-door-page h1 {
    width: 100%;
    text-align: left;
    font-size: 11rem;
    font-weight: bold;
    /* text-shadow: 0px 10px black; */
    /* background: linear-gradient(to right, #000 20%, #bada55 30%, #bada44 70%, #000 80%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    text-fill-color: transparent;
    background-size: 200% auto;
    animation: textShine 7s ease-in-out infinite alternate; */
    margin-bottom: 0;
    color: #000;
}

.login-page {
    background: yellow;
    min-height: 570px;
    width: 25%;
    position: relative;
}

.login-box, .register-box {
    width: auto;
}

/* @keyframes textShine {
  to {
    background-position: 200%;
  }
} */

.door-app-wrapper {
    position: relative;
    height: 468px;
    left: -50%;
    right: auto;
    box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px;
    background-color: #fff;
    padding-top: 30px;
    padding-bottom: 30px;
    border-radius: 10px;
    z-index: 9;
}

.door-app-wrapper #app .login-box .card {
    background-color: transparent !important;
    backdrop-filter: none !important;
    box-shadow: none !important;
}

.door-app-wrapper #app .login-box .card .card-header {
    font-weight: bold;
    color: #000;
    text-transform: uppercase;
    border-bottom: 2px solid rgb(255, 255, 0, 0.8) !important;
}

.load-more-log {
    width: 100%;
    display: block;
    padding-left: 139px;
    max-width: 1000px;
    margin-top: -376px;
    img_bgposition: relative;
    z-index: 2;
}

.load-more-log ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: block;
    margin-bottom: 20px;
}

.load-more-log ul li {
    position: relative;
    display: inline-block;
    vertical-align: top;
    margin-right: 10px;
}

.load-more-log ul li img {
    display: inline-block;
    width: 35px;
}

.load-more-log ul li span {
    font-size: 16px;
    font-weight: bold;
}

#app .reset-pss-card {
    background-color: transparent !important;
    backdrop-filter: none;
    border: 0 !important;
    box-shadow: none !important;
    color: #666;
    border-radius: 0px;
    padding: 20px;
    padding-left: 13px;
    padding-right: 13px;
}

#app .reset-pss-card .card-header {
    font-weight: bold;
    color: #000;
    text-transform: uppercase;
    border-bottom: 2px solid rgb(255, 255, 0, 0.8) !important;
}

@media (min-width: 1500px) {
    .upld-rw-card {
        max-height: 800px;
    }

    .img-log-sec {
        max-width: 1000px;
    }

    .img-log-sec img {
        height: 640px;
    }

    .open-door-page {
        padding-left: 80px;
        width: 80%;
    }

    .login-page {
        width: 20%;
    }

    .load-more-log {
        padding-left: 247px;
        margin-top: -400px;
    }
}

@media (max-width: 1270px) {
    .img-log-sec {
        max-width: 500px;
    }

    .img-log-sec img {
        height: auto;
    }

    .load-more-log {
        max-width: 100%;
        padding-left: 65px;
    }
}

@media (max-width: 992px) {
    .img-log-sec {
        max-width: 400px;
    }

    .open-door-page {
        padding-left: 60px;
    }

    .img-log-sec img {
        width: 100%;
    }

    .load-more-log {
        padding-left: 50px;
    }

    .load-more-log ul li {
        display: block;
        margin-bottom: 10px;
        margin-right: 0;
    }
}

@media (max-width: 830px) {
    .open-door-page {
        padding-left: 20px;
    }
}

@media (max-width: 767px) {
    .login-outer-wrapper-grp {
        display: block;
        background-color: #fff;
        height: 100vh;
        position: fixed;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        overflow-y: auto;
    }

    .open-door-page {
        background-color: yellow;
        height: 50%;
        padding-left: 0;
        padding-right: 0;
        width: 100%;
        display: block;
        min-height: auto;
    }

    .open-door-page h1 {
        text-align: center;
    }

    .login-page {
        width: 100%;
        background-color: transparent;
        justify-content: center;
        padding: 0 10px;
        min-height: auto;
        height: 50%;
        position: relative;
    }

    .door-app-wrapper {
        width: auto;
        height: auto;
        position: absolute;
        top: -75%;
        left: auto;
        right: auto;
        margin: 0 auto;
    }

    .login-box, .register-box {
        width: 100%;
    }

    .img-log-sec {
        display: none;
    }

    .load-more-log {
        display: none;
    }
}

@media (max-width: 479px) {
    .open-door-page h1 {
        font-size: 9.5rem;
    }

    .door-app-wrapper {
        width: 90%;
    }
}

</style>

<body>
    <div class="login-outer-wrapper-grp">
        <div class="open-door-page">
            <div class="img-log-sec">
                <img src="{{ asset ('dist/img/odn_login.jpg')}}" alt="Login">
            </div>
            <div class="load-more-log">
                <ul>
                    <li>
                        <img src="{{ asset ('dist/img/login_loader.gif')}}" alt="Loader" />
                        <span>Creating Enviroment</span>
                    </li>
                    <li>
                        <img src="{{ asset ('dist/img/login_loader.gif')}}" alt="Loader" />
                        <span>Securing Your Session</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="login-page">
            <div class="door-app-wrapper">
                <!-- <div class="door-app">
                    <img src="{{ asset ('dist/img/loader-gif/secure_dr2.gif')}}" alt="Looader" width="50px">
                    Securing Your Sessions
                </div> -->
                <div id="app">

                    <!-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                        <div class="container">
                            <a class="navbar-brand" href="{{ url('/') }}">
                                ODN Connect
                            </a>
                        

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                                <ul class="navbar-nav mr-auto">

                                </ul>

                                <ul class="navbar-nav ml-auto">

                                    @guest
                                        @if (Route::has('login'))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                            </li>
                                        @endif
                                        
                                        @if (Route::has('register'))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                            </li>
                                        @endif
                                    @else
                                        <li class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                {{ Auth::user()->name }}
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </div>
                                        </li>
                                    @endguest
                                </ul>
                            </div>
                        </div>
                    </nav> -->


                    <main class="py-0">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
    </div>
</body>


<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script type="application/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="application/javascript" src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script type="application/javascript" src="{{asset('dist/js/adminlte.js')}}"></script>
<script type="application/javascript" src="{{asset('dist/js/adminlte.min.js')}}"></script>

<script type="application/javascript">
    $('.door-app').click(function(){
        $('.door-app-wrapper').toggleClass('door-open');
    });
</script>

</html>
