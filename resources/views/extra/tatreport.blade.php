@extends('layouts.admin')
@section('title')
TAT Report
@endsection
@section('content')

    <div class="row m-0">
        <div class="col-12">
            <div class="card card-transparent" style="border-radius: 15px; box-shadow: rgb(100 100 111 / 20%) 0px 7px 29px 0px;">
                <div class="card-header py-3">
                    <h3 class="card-title text-left float-none text-uppercase" style="font-size: 1.5rem;">TAT Report</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Brand</th>
                                    <th>AM Name</th>
                                    <th>WRC Number</th>
                                    <th>Lot Size</th>
                                    <th>SKU Count</th>
                                    <th>Pending At</th>
                                    <th>TAT Start Date</th>
                                    <th>TAT End Date</th>
                                    <th>Shoot Upload Date</th>
                                    <th>Start to Shoot TAT</th>
                                    <th>Shoot TAT Status</th>
                                    <th>Qc Date</th>
                                    <th>Shoot to Ed TAT</th>
                                    <th>Editing TAT Status</th>
                                    <th>Overall TAT Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wrcs as $wrc)
                                <tr>
                                    <td>{{$sr++}}</td>
                                    <td>{{$wrc['name']}}</td>
                                    <td>{{$wrc['am_email']}}</td>
                                    <td>{{$wrc['wrc_id']}}</td>
                                    <td>{{$wrc['Lot_size']}}</td>
                                    <td>{{$wrc['inwardwrc_sku_count']}}</td>
                                    <td>{{$wrc['wrc_statuses']}}</td>
                                    <td>{{dateFormat($wrc['TAT_start_date'])}}</td>
                                    <td>{{dateFormat($wrc['TAT_end_date'])}}</td>
                                     <td>{{$wrc['raw_upload']}}</td>
                                    <td>{{$wrc['Inward_to_Shoot']}}</td>
                                    <td>{{$wrc['TAT_Start_To_shoot_status']}}</td>
                                    <td>{{$wrc['editingday']}}</td>
                                    <td>{{$wrc['TAT_Shoot_Edit']}}</td>
                                     <td>{{$wrc['TAT_Start_To_EDIT_status']}}</td>
                                    <td>{{$wrc['TAT_status']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                </div>
            </div>
        </div>
      
    </div>
  @endsection