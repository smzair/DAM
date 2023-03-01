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
				<h4>Hello, Kishanramchari shrikant</h4>
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
						<th>Project Name</th>
						<th>Vertical Type</th>
						<th>Client Bucket</th>
						<th>LOT Delivery Days</th>
						<th>Wrc Count</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($lots as $index => $row)
                        <tr>
                            <td width="5%" class="pl-3">{{$index +1 }}</td>
							<td>{{$row['lot_number']}}</td>
							<td>{{$row['project_name']}}</td>
							<td>{{$row['verticle']}}</td>
							<td>{{$row['client_bucket']}}</td>
							<td>{{$row['lot_delivery_days']}}</td>
                            <td>{{count($row['get_creative_wrc'])}}</td>

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