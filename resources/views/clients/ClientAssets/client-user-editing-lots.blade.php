@extends('layouts.ClientMain')
@section('title')
  Client Dashboard
@endsection
@section('css_links')
	<link rel="stylesheet" href="">	
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
				<h4>Editing Lots</h4>
			</div>
		</div>
	</nav>
	<!-- /.navbar -->
	<!-- Main content -->
	<div class="content custom-dashboard-content">
		<div class="container-fluid">
            <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                <table class="table data-table table-head-fixed table-hover text-nowrap text-center">
                    <thead >
                    <tr style="font-size: 14px;">
                        <th width="5%" class="pl-3"># </th>
                        <th>Lot Number</th>
                        <th>Request Name</th>
                        <th>Lot created at</th>
                        <th>Wrc Count</th>
                        <th>Raw Image Count</th>
                        <th>Edited Image Count</th>
                        <th>Action</th> 
                        {{-- 
                        --}}
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($lots as $index => $row)
                        @php
                        // dd($lots);
                            // $get_shoot_wrc = $row['get_shoot_wrc'];
                            // $shootTotUploadRawImage = $row['shootTotUploadRawImage'];
                            // $editor_submission_count = $row['editor_submission_count'];
                            $id_is = $row['id'];
                        @endphp
                        <tr>
                            <td width="5%" class="pl-3">{{$index +1 }}</td>
                            <td>{{$row['lot_number']}}</td>
                            {{-- <td><a href="{{route('client-raw-images-mgmt' , ['id' => $row['id']])}}">{{$row['lot_number']}}</a> </td> --}}
                            <td>{{$row['request_name']}}</td>
                            <td>{{ date('d-m-Y h:i A' ,strtotime($row['created_at']))}}</td>
                            <td>{{$row['wrc_count']}}</td>
                            <td>{{$row['totUploadRawImage']}}</td>
                            <td>{{$row['tot_submission_count']}}</td>
                            <td></td>
                            {{-- 
                            <td>{{$row['sku_count']}}</td>
                            <td>{{$shootTotUploadRawImage}}</td>
                            <td>{{$editor_submission_count}}</td>
                            <td>
                                @if ($shootTotUploadRawImage > 0)
                                    <a class="btn btn-primary" href="#">Download Raw Image</a>
                                @endif
                                @if ($editor_submission_count > 0)
                                    <a class="btn btn-warning" href="#">Edited Raw Image</a>
                                @endif
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
@endsection