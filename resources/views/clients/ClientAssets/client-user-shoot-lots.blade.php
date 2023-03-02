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
                        <th>Lot created at</th>
                        <th>S Type</th>
                        <th>Wrc Count</th>
                        <th>Sku Count</th>
                        <th>Raw Image Count</th>
                        <th>Edited Image Count</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($lots as $index => $row)
                        @php
                            $get_shoot_wrc = $row['get_shoot_wrc'];
                            $shootTotUploadRawImage = $row['shootTotUploadRawImage'];
                            $editor_submission_count = $row['editor_submission_count'];
                            $id_is = $row['id'];
                        @endphp
                        <tr>
                            <td width="5%" class="pl-3">{{$index +1 }}</td>
                            <td><a href="{{route('client-raw-images-mgmt' , ['id' => $row['id']])}}">{{$row['lot_id']}}</a> </td>
                            <td>{{ date('d-m-Y h:i A' ,strtotime($row['created_at']))}}</td>
                            <td>{{$row['s_type']}}</td>
                            <td>{{$row['shoot_wrc_count']}}</td>
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