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
        .form-control {
        width: 200px; /* set the width to 200px */
        height: 30px; /* set the height to 30px */
        }
        .popup-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 12%;
            height: 30%;
            background-color: rgba(248, 245, 245, 0.977);
            z-index: 1;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
            border-radius: 10px; /* Add a border-radius to the container */
            }
            .popup-container ul {
            margin-top: 5px;
            list-style-type: none; /* Remove the bullet */
            text-align: left; /* Align the content to the left */
            }
    
            .popup-container a {
            color: black; /* Change the color of the link */
            font-size: 13px;
            text-decoration: none; /* Remove the underline from the link */
            }
            .popup-container ul:hover {
                background-color: rgba(132, 132, 123, 0.31); /* Change the background color on hover */
            }
            

    </style>
@endsection

@section('main_content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper dashboard-content-wrapper">
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
        <div class="content custom-dashboard-content mt-3">
            <div class="container-fluid">
                <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                    <div class="row">
                        <div class="col-sm-8">
                            @if(!empty($previousUrl))
                            <a href="{{ $previousUrl }}"><span class="fa fa-arrow-circle-left" data-toggle="tooltip" title="Go Back"></span></a>

                            @endif
                        </div>
                        
                        <div class="col-sm-4 mb-2">
                            <form id="searchForm" action="{{ url('editorcommonsearch')}}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" class="form-control p-2" placeholder="type here...." id="globalSearch" name="query">
                                    &nbsp; &nbsp;
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary p-1" id="searchBtn" data-toggle="tooltip" title="Search"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- show years folder -->
        @if(count($all_years)>0)
        @include('clients.EditorClientFileManager.clientsEditorImagesYears')
        @endif

        @if(count($monthly_data)>0)
        @include('clients.EditorClientFileManager.clientsRawImagesMonths')
        @endif

        @if(count($lotData)>0)
        @include('clients.EditorClientFileManager.clientseditorImagesLots')
        @endif

        @if(count($wrc_data)>0)
        @include('clients.EditorClientFileManager.WrcViewForClientsEditorImages')
        @endif

        @if(count($adaptation_data)>0)
        @include('clients.EditorClientFileManager.AdaptationViewForClientsEditorImages')
        @endif

        @if(count($sku_data)>0)
        @include('clients.EditorClientFileManager.SkuViewForClientsEditorImages')
        @endif

        @if(count($file_data)>0)
        @include('clients.EditorClientFileManager.UploadedImagesViewForClientsRawImages')
        @endif

	    <!-- /.content -->
    </div>

    {{-- Other Js pluging   --}}
    
    @section('js_scripts')
        <script>
            function semple(){
                console.log('first')
            }
        </script>

        <script>
            function navigateToLink(link) {
                // window.open(link);
                window.location.href = link;
            }
        </script>
    @endsection
@endsection
