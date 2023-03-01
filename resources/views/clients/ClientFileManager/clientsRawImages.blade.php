@extends('layouts.ClientMain')
@section('title')
  Client Dashboard
@endsection
@section('css_links')
	<link rel="stylesheet" href="">	
    <style>
        .form-group .input_err{
            margin: 0.1em 0;
            color: red;
            background: #999;
            display: block;
            padding: 0.3em;
        }
    
        .list-group{
            width: 400px !important;
    
        }
    
        .list-group-item{
            margin-top:10px;
            margin-bottom:10px;
            border-radius: none; 
            background: #20b9932e;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
    
    
        .list-group-item:hover{
            /* transform: scaleX(1.1); */
        }
        .list-group-item:hover .check {
            opacity: 1;
    
        }
        .about span{
            font-size: 12px;
            margin-right: 10px;
    
        }
        </style>
@endsection

@section('main_content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper dashboard-content-wrapper">
	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-white navbar-light custom-dashboard-header">
		<!-- Left navbar links -->
		<div class="navbar-nav">
			<div class="dash-mobile-trigger">
				<img src="{{ asset('assets-images\Mob-Assets\images\line_img.png')}}" alt="Mobile Trigger">
			</div>
			<div class="welcome-user-title">
				<h4>Hello, Rajesh</h4>
			</div>
		</div>
	</nav>
	<!-- /.navbar -->
	<!-- Main content -->

    



	<div class="content custom-dashboard-content">
		<div class="container-fluid">
            <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-transparent card-info mt-3">
                            <div class="card-header">
                                <h6 class="card-title">All Lots</h6>
                            </div>
                            <div class="row">
                                @foreach($lotData as $object)
                                    <div class="col-md-2">
                                        <div class=" justify-content-between align-content-center">
                                            <div class="text-center">
                                                <a ondblclick="navigateToLink('client-raw-images-mgmt/{{$object->id}}')"><img style="cursor: pointer" class=" justify-content-between align-content-center" src="https://img.icons8.com/color/100/000000/folder-invoices.png" width="50" /></a>
                                                <div class="about">
                                                    <span>{{ $object->lot_id }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
@endsection

{{-- Other Js pluging   --}}
@section('js_links')
  <script type="text/javascript" src=""></script>
@endsection

@section('js_scripts')
	<script>
		function semple(){
			console.log('first')
		}
	</script>

    
<script>
    function navigateToLink(link) {
      window.open(link, '_blank');
    }
</script>
@endsection