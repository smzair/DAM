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
				<h4>Shoot Lots</h4>
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
                        <th>Lot created at</th>
                        <th>S Type</th>
                        <th>Wrc Count</th>
                        <th>Sku Count</th>

                    </tr>
                    </thead>
                    <tbody>
                        @foreach($lots as $index => $row)
                        @php
                            $get_shoot_wrc = $row['get_shoot_wrc'];
                            
                            // echo "<br>".$row['lot_id'];
                            // pre($get_shoot_wrc);
                        @endphp
                        <tr>
                            <td width="5%" class="pl-3">{{$index +1 }}</td>
                            <td>{{$row['lot_id']}}</td>
                            <td>{{ date('d-m-Y h:i A' ,strtotime($row['created_at']))}}</td>
                            <td>{{$row['s_type']}}</td>
                            <td>{{count($row['get_shoot_wrc'])}}</td>
                            <td>
                                @php
                                    $sku_count = 0;
                                    foreach ($get_shoot_wrc as $key => $row1) {
                                        $sku_count += count($row1['get_wrc_skus']);
                                    }
                                    echo $sku_count;
                                @endphp
                            </td>
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