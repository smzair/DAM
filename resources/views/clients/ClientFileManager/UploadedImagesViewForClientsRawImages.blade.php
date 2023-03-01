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
        .col-md-2 img {
            transition: transform 0.8s;
        }

        .col-md-2 img:hover {
            transform: scale(1.9);
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
                                <h6 class="card-title">All Images</h6>
                            </div>
                            <div class="row">
                                @foreach($file_data as $object)
                                    <div class="col-md-2">
                                        <div class=" justify-content-between align-content-center">
                                            <div class="text-center">
                                                <a ondblclick="navigateToLink('client-all-images/{{$object->id}}')">
                                                    <img style="cursor: pointer" class=" justify-content-between align-content-center" src="https://img.icons8.com/color/100/000000/document.png" width="100" height="150" />

                                                    @php
                                                        $img_created_at = $object->created_at;
                                                        $wrc_created_at  = $object->wrc_created_at;
                                                        $file_name  = $object->filename;
                                                        $wrc_no  = $object->wrc_id;
                                                        $lot_no  = $object->lot_id;
                                                        $year = date('Y',strtotime($wrc_created_at));
                                                        $month = date('M',strtotime($wrc_created_at));
                                                        echo $url_path = "<br>raw_img_directory/$year/$month/";
                                                    @endphp

                                                    {{-- <img style="cursor: pointer" class=" justify-content-between align-content-center" src="{{asset('raw_img_directory/'.$current_year.'/Feb/ODN10022023-TUTCES3907/TUTCES3907-A/8720107149960/8720107149960_10.jpg')}}" width="100" height="150"/> --}}
                                                
                                                </a>
                                                <div class="about">
                                                    <span>{{ $object->filename }}</span>
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
        console.log('link', link)
    //   window.open(link, '_blank');
    }
</script>
@endsection