@extends('layouts.admin')

@section('title')
View WRC
@endsection
@section('content')
<div class="lot-table mt-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-transparent">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-7 col-md-6 col-sm-12">
                                <h3 class="card-title text-black text-bold">
                                    <span class="d-inline-block align-middle">
                                        All WRC
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
                            <div class="col-lg-5 col-md-6 col-sm-12">
                                <div class="card-tools float-md-right float-sm-none ml-md-0 mr-0 ml-sm-0 mt-sm-1 float-none ml-xs-0 mt-1">
                                    <a class="btn btn-xs float-left align-middle mt-0 mr-2 py-1 px-2 mb-1" href="{{route('CREATECATLOGWRC')}}" style="position: relative; top: 2px;">Add New WRC</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                        <table id="wrcTableCat" class="table table-head-fixed table-hover text-nowrap data-table">
                            <thead>
                            <tr class="wrc-tt">
                                    <th class="p-2">Id</th>
                                    <th class="p-2">LOT Number</th>
                                    <th class="p-2">Company Name</th>
                                    <th class="p-2">Brand Name</th>
                                    <th class="p-2">WRC Number</th>
                                    <th class="p-2">WRC Created At</th>
                                    <th class="p-2">Batch Number</th>
                                    <!-- <th class="p-2">Work Brief</th>
                                    <th class="p-2">Add Document 1 </th>
                                    <th class="p-2">Add Document 2</th> -->
                                        <th class="p-2">SKU Count</th>
                                    <th class="p-2">Generic Data Format Link</th>
                                    <th class="p-2">Images as per guidelines</th>    
                                    <th class="p-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wrcs as $index => $wrc)
                                @php
                                    if($wrc->batch_no > 0){
                                        $batch_no_is = ($wrc->batch != '' && $wrc->batch != null) ? $wrc->batch : $wrc->batch_no;
                                    }else{
                                        $batch_no_is =  'None';
                                    }
                                @endphp
                                <tr class="wrc-tt">
                                    <td class="p-sm-2 p-1">{{$index+1}}</td>
                                    <td id="lotNum" class="p-sm-2 p-1">{{$wrc->lot_number}}</td>
                                    <td id="companyName" class="p-sm-2 p-1">{{$wrc->Company_name}}</td>
                                    <td id="brndName" class="p-sm-2 p-1">{{$wrc->name}}</td>
                                    <td id="wrcNum" class="p-sm-2 p-1">{{$wrc->wrc_number}}  <span class="cpy-clipboardtable" id="copyBTnTable"><i class="fas fa-copy"></i></span> </td>
                                    <td id="createdAt" class="p-sm-2 p-1">{{dateFormat($wrc->created_at)}}<br><b>{{timeFormat($wrc->created_at)}}</b></td>
                                    <!-- <td id="orderQuantity" class="p-sm-2 p-1">{{$wrc->work_brief}}</td>
                                    <td id="orderQuantity" class="p-sm-2 p-1">{{$wrc->guidelines}}</td>
                                    <td id="orderQuantity" class="p-sm-2 p-1">{{$wrc->document1}}</td>
                                    <td id="orderQuantity" class="p-sm-2 p-1">{{$wrc->document2}}</td> -->
                                    <td id="brndName" class="p-sm-2 p-1">
                                        {{ $batch_no_is }}
                                    </td>
                                    <td id="brndName" class="p-sm-2 p-1">{{$wrc->sku_qty}}</td>
                                    <td id="brndName" class="p-sm-2 p-1">{{$wrc->generic_data_format_link}}</td>
                                    <td id="brndName" class="p-sm-2 p-1">{{$wrc->img_as_per_guidelines}}</td>
                                    <td class="p-sm-2 p-1">
                                    <div class="btn-group-vertical">
                                        <a class="btn btn-warning px-1 py-1 btn-xs mt-1" href="{{('/Catalog-Wrc-Create/'.$wrc->id) }}">Edit WRC</a>
                                    </div>
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
  $('#wrcTableCat').DataTable({
        dom: 'lBfrtip',
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "buttons": ["copy", "csv", "excel", "pdf"]
  }).buttons().container().insertAfter('#masterData_wrapper .dataTables_length');
</script>
@endsection