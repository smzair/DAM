<!-- New View LOTs Table (For Editing) -->

@extends('layouts.admin')
@section('title')
Client Notification List
@endsection
@section('content')
<div class="lot-table mt-1">
    <div class="container-fluid">
      <div class="lot-table mt-1">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-transparent">
                <div class="card-header">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <h3 class="card-title text-black text-bold">
                        <span class="d-inline-block align-middle">All Client Notification List</span>
                        <span class="mr-2 ml-1 d-inline-block" style="position: relative; top: 1px;">|</span>
                      </h3>
                      <div class="card-tools float-left">
                        <ul class="list-unstyled m-0 mt-lg-0 mt-md-1 lot-list">
                          <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Inworded">
                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #FFFF00;"></span>
                          </li>
                          <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Inwording Completed">
                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #FF8000;"></span>
                          </li>
                          <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Ready For Shoot">
                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #606060;"></span>
                          </li>
                          <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Shoot Done">
                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #4C0099;"></span>
                          </li>
                          <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Ready For QC">
                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #000000;"></span>
                          </li>
                          <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Ready For Submission">
                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #0066CC;"></span>
                          </li>
                          <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Approved">
                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #00CC00;"></span>
                          </li>
                          <li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="Rejected">
                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #FF0000;"></span>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <div class="card-tools float-md-right float-sm-none ml-md-0 mr-0 ml-sm-0 mt-sm-1 float-none ml-xs-0 mt-2">
                        <a href="{{ route('CreateClientNotification') }}" class="btn btn-xs float-left align-middle mt-0 mr-2 py-1 px-2 mb-2 mb-sm-1" style="position: relative; top: 2px;">Create New Notification</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
                  <table id="ElotTable" class="table table-head-fixed table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th class="p-2">Id</th>
                        <th class="p-2">Company Name</th>
                        <th class="p-2">Brand Name</th>
                        <th class="p-2">Subject</th>
                        <th class="p-2">Discription</th>
                        <th class="p-2">Is Seen</th>
                        <th class="p-2">Seen At</th>
                        <th class="p-2">Created At</th>
                        <th class="p-2">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $key => $row)
                      <?php $id = $row['id'];?>
                        <tr>
                          <td>{{$key + 1}}</td>
                          <td>{{$row['company']}}</td>
                          <td>{{$row['brand_name']}}</td>
                          <td>{{$row['subject']}}</td>
                          <td>{{$row['discription']}}</td>
                          <td>{{$row['is_seen'] == 1 ? 'Yes' : 'No'}}</td>
                          <td>{{$row['is_seen'] == 1 ? date('d-M-Y h:i A' , strtotime($row['seen_at'])) : '-'}}</td>
                          <td>{{ date('d-M-Y h:i A' , strtotime($row['created_at'])) }}</td>
                          <td>
                            @if ($row['is_seen'] == 1 )
                                <button disabled class="btn btn-warning">Notification Seen Can't Edit</button>
                            @else
                              <a class="btn btn-warning px-1 py-1 btn-xs mt-1" href="{{ route('editClientNotification', [base64_encode($id)]) }}">Edit</a>
                            @endif
                          </td>
                        </tr>
                      @endforeach 
                      
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script type="application/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="application/javascript" src="{{asset('plugins/datepicker-in-bootstrap-modal/js/datepicker.js')}}"></script>

<!-- DataTable Plugins Path -->
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<!-- End of DataTable Plugins Path -->
<script>
	$('#ElotTable').DataTable({
        dom: 'lBfrtip',
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "buttons": ["copy", "csv", "excel", "pdf"]
  	}).buttons().container().insertAfter('#masterData_wrapper .dataTables_length');
</script>
@endsection


