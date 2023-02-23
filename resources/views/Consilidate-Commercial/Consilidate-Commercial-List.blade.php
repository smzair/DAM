@extends('layouts.admin')
@section('title')New Commercial List
@endsection
@section('content')
<div class="lot-table mt-1">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-transparent">
          <div class="card-header">
            <div class="row">
              <div class="col-lg-8 col-md-8 col-sm-12">
                <h3 class="card-title text-black text-bold">
                  <span class="d-inline-block align-middle">
                    View Commercial's
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
              <div class="col-lg-4 col-md-4 col-sm-12">
                  <div class="card-tools float-md-right float-sm-none ml-md-0 mr-0 ml-sm-0 mt-sm-1 float-none ml-xs-0 mt-1">
                      <a class="btn btn-xs float-left align-middle mt-0 mr-2 py-1 px-2 mb-1" href="{{route('NewCommercial')}}" style="position: relative; top: 2px;">Add New Commercial</a>
                  </div>
              </div>
              <!-- <div class="col-lg-5 col-md-6 col-sm-12">
                <div class="card-tools float-md-right float-sm-none ml-md-0 mr-0 ml-sm-0 mt-sm-2 float-none ml-xs-0 mt-2">
                  <a href="" class="btn btn-xs float-left align-middle mt-0 mr-2 py-1 px-2 mb-1 mb-1" style="position: relative; top: 2px;">Add New Commercials</a>
                </div>
              </div> -->
            </div>
          </div>
          <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
            <table id="commTableCat" class="table table-head-fixed table-hover text-nowrap data-table">
              <thead>
                <tr class="wrc-tt">
                  <th class="p-2">Id</th>
                  <th class="p-2">Company Name</th>
                  <th class="p-2">Brand Name</th>
                  <th class="p-2">Client Id</th>
                  <th class="p-2">Shoot</th>
                  <th class="p-2">Creative Graphics</th>
                  <th class="p-2">Cataloging</th>
                  <th class="p-2">Editing</th>
                  <th class="p-2" style="text-align: center">Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                @endphp
                @foreach($com as $row)

                @php
                // pre($row);
                    $createNewCommercialIdIs = $row->id;
                    $createNewCommercialIdIs = $row->id;
                    $shootCheckIsDone = $row->shootCheckIsDone;
                    $cgCheckIsDone = $row->cgCheckIsDone;
                    $catCheckIsDone = $row->catCheckIsDone;
                    $editorCheckIsDone = $row->editorCheckIsDone;
                    $commshootcheck = $commcgcheck = $commcatcheck = $commEditorcheck = "-";

                    $show_btn = 0;
                    if($shootCheckIsDone == 1 || $cgCheckIsDone == 1 || $catCheckIsDone == 1 || $editorCheckIsDone == 1){
                      $show_btn = 1;
                    }

                    if($shootCheckIsDone > 0){
                      // $commshootcheck = $shootCheckIsDone == 1 ? 'Generate New commercial Pending' : 'New commercial Generated';
                      $commshootcheck = $shootCheckIsDone == 1 ? 'Pending' : 'Done';
                    }

                    if($cgCheckIsDone > 0){
                      $commcgcheck = $cgCheckIsDone == 1 ? 'Pending' : 'Done';
                    }

                    if($catCheckIsDone > 0){
                      $commcatcheck = $catCheckIsDone == 1 ? 'Pending' : 'Done';
                    }

                    if($editorCheckIsDone > 0){
                      $commEditorcheck = $editorCheckIsDone == 1 ? 'Pending' : 'Done';
                    }

                @endphp
                
                <tr class="wrc-tt">
                  <td class="p-sm-2 p-1">{{$num++}}</td>
                  <td class="p-sm-2 p-1">{{$row->company}}</td>
                  <td class="p-sm-2 p-1">{{$row->name}}</td>
                  <td class="p-sm-2 p-1">{{$row->commClientID}}</td>
                  <td class="p-sm-2 p-1">{{$commshootcheck}}</td>
                  <td class="p-sm-2 p-1">{{$commcgcheck}}</td>
                  <td class="p-sm-2 p-1">{{$commcatcheck}}</td>
                  <td class="p-sm-2 p-1">{{$commEditorcheck}}</td>
                  <td style="text-align: center">

                    @if ($show_btn == 1)
                      <a class="btn btn-warning px-1 py-1 btn-xs mt-1" href="{{ route('EditNewCommercial', ['id' => $createNewCommercialIdIs]) }}">Continue Creation</a>  
                    @else
                      <button disabled class="btn btn-warning px-1 py-1 btn-xs mt-1"> Done</button>
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

<!-- End of Table -->

<!-- DataTable Plugins Path -->

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<!-- End of DataTable Plugins Path -->

<!-- Data Table Calling Function -->

<script>
  $('#commTableCat').DataTable({
        dom: 'lBfrtip',
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "buttons": ["copy", "csv", "excel", "pdf"]
  }).buttons().container().insertAfter('#masterData_wrapper .dataTables_length');
</script>
@endsection