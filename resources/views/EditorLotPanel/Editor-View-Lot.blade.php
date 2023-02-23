<!-- New View LOTs Table (For Editing) -->

@extends('layouts.admin')
@section('title')
Editing List
@endsection
@section('content')
<div class="lot-table mt-1">
    <div class="container-fluid">
      @if (Session::has('success'))
        <div class="alert alert-success" id="msg_div" role="alert">
            {{ Session::get('success') }}
        </div>
      @endif
    <div class="lot-table mt-1">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-transparent">
                <div class="card-header">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <h3 class="card-title text-black text-bold">
                        <span class="d-inline-block align-middle">
                          All LOTs
                        </span>
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
                        <a href="{{ route('editor_create_lot') }}" class="btn btn-xs float-left align-middle mt-0 mr-2 py-1 px-2 mb-2 mb-sm-1" style="position: relative; top: 2px;">Create a new LOT</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
                  <table id="ElotTable" class="table table-head-fixed table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th class="p-2">Id</th>
                        <th class="p-2">LOT Numbers</th>
                        <th class="p-2">Company Name</th>
                        <th class="p-2">Brand Name</th>
                        <th class="p-2">Client ID</th>
                        <th class="p-2">Request Name</th>
                        <th class="p-2">Creation Date</th>
                        <th class="p-2">Actions</th>
                      </tr>
                    </thead>
                    <tbody>  
                      @foreach($lots as $lot)
                      <tr>
                        <td class="p-sm-2 p-1">{{$lot->id}}</td>
                        <td class="p-sm-2 p-1">{{$lot->lot_number}}</td>
                        <td class="p-sm-2 p-1">{{$lot->Company}}</td>
                        <td class="p-sm-2 p-1">{{$lot->name}}</td>
                        <td class="p-sm-2 p-1">{{$lot->client_id}}</td>
                        <td class="p-sm-2 p-1">{{$lot->request_name}}</td>
                        <td class="p-sm-2 p-1">{{dateFormat($lot->created_at)}}<br><b>{{timeFormat($lot->created_at)}}</b></td>
                        <td class="p-sm-2 p-1">
                          <div class="btn-group-vertical">
                            {{-- <button type="button" class="btn btn-primary px-1 py-1 btn-xs" data-client_id="{{$lot->client_id}}"  data-created_at="{{dateFormat($lot->created_at)}} {{timeFormat($lot->created_at)}}"  data-Company="{{$lot->Company}}" data-lot_id = "{{$lot->lot_id}}" data-name = "{{$lot->name}}" onclick="viewlots(this)">View</button> --}}
                            <a class="btn btn-warning px-1 py-1 btn-xs mt-1" href="{{('/Editor-editLots/'.$lot->id) }}">Edit Lot</a>
                          </div>
                        </td>
                      </tr> @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <div class="modal fade" id="lot-info-modal">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header py-2">
                      <h4 class="modal-title">LOT Details</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <dl class="row mb-0">
                        <dt class="col-6 mb-3">Client Id</dt>
                        <dd class="col-6" id="modal_client_id"></dd>
                        <dt class="col-6 mb-3">LOT Number</dt>
                        <dd class="col-6" id="modal_lot_id"></dd>
                        <dt class="col-6 mb-3">Brands</dt>
                        <dd class="col-6"id="modal_name"></dd>
                        <dt class="col-6 mb-3">Date</dt>
                        <dd class="col-6" id="modal_created_at"></dd>

                      </dl>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
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

<script src="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/js/plugins/mdb-file-upload.min.js"></script>



<!-- End of New View LOTs Table (For Editing) -->

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


