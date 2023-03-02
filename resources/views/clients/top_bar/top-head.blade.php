<nav class="main-header navbar navbar-expand navbar-white navbar-light custom-dashboard-header">
    <!-- Left navbar links -->
    <div class="navbar-nav">
        <div class="dash-mobile-trigger">
            <img src="{{ asset('assets-images\Mob-Assets\images\line_img.png')}}" alt="Mobile Trigger">
        </div>
        <div class="welcome-user-title">
            <h4>Hello, {{ ucwords(Auth::user()->name) }}</h4>
        </div>
    </div>
</nav>