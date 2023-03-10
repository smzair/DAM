@extends('layouts.ClientMain')
@section('title')
  Creative Shoot
@endsection
@section('css_links')
	<link rel="stylesheet" href="">	
@endsection

@section('main_content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper dashboard-content-wrapper">
	<!-- Navbar -->
		@include('clients.top_bar.top-head')
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
						<th>Order Count</th>
                        <th>Uploaded Link Count</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($lots as $index => $row)
						@php
							$id_is = $row['id'];
                            $wrc_count = $row['wrc_count'];
                            $totWrcOrderQty = $row['totWrcOrderQty'];
                            $wrc_allocations_count = $row['wrc_allocations_count'];
                            $wrcUploadLinks_count = $row['wrcUploadLinks_count'];
                            $creative_wrcs = $row['get_creative_wrc'];
						@endphp
                        <tr>
                            <td width="5%" class="pl-3">{{$index +1 }}</td>
							<td>{{$row['lot_number']}}</td>
							<td>{{$row['project_name']}}</td>
							<td>{{$row['verticle']}}</td>
							<td>{{$row['client_bucket']}}</td>
							<td>{{$row['lot_delivery_days']}}</td>
                            <td style="position: relative;">
								@if ($row['wrc_count'] > 0)
								 <span class="dropdown-toggle d-inline-block ed-wrc-cnt" onclick="showhideli({{ $index }})"  style="cursor: pointer;"> {{$row['wrc_count']}}</span>
								 <div id="wrcInfo{{ $index }}" style="display: none; padding: 5px 20px; border: 2px #cbbebe95 solid; box-shadow: 4px 4px 10px #aaa; position: absolute;border-radius: 8px;background: #f6f3f3;color: #333;z-index:99999">
										 @foreach($creative_wrcs as $wrc_key => $wrc_number_arr)
											 <p class="" style="cursor: pointer;">{{$wrc_number_arr['wrc_number']}}</p>
										 @endforeach
								 </div>
								@endif
							 </td>
							 <td>{{$row['totWrcOrderQty']}}</td>
							<td>{{$row['wrcUploadLinks_count']}}</td>
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
		function showhideli(val){
		var x = document.getElementById("wrcInfo"+val);
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}
		}
	</script>
@endsection