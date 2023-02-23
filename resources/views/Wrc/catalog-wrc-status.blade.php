@extends('layouts.admin')

@section('title')
Catalog WRC Status
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
                                        All WRCs Status Panel
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
                                    {{-- <a class="btn btn-xs float-left align-middle mt-0 mr-2 py-1 px-2 mb-1" href="{{route('CREATECATLOGWRC')}}" style="position: relative; top: 2px;">Add New WRC</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                        <table id="wrcTableCat" class="table table-head-fixed table-hover text-nowrap data-table">
                            <thead>
                            <tr class="wrc-tt">
                                    <th class="p-2">S. No.</th>
                                    <th class="p-2">LOT Number</th>
                                    <th class="p-2">WRC Number</th>
                                    <th class="p-2">Company Name</th>
                                    <th class="p-2">Brand Name</th>
                                    <th class="p-2">Batch Number</th>
                                    {{-- <th class="p-2">WRC Created At</th> --}}
                                    <th class="p-2">SKU Count</th>
                                    <th class="p-2">WRC Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sno=1;
                                    // pre($CatalogWrcList[16]);
                                @endphp
                                @foreach($CatalogWrcList as $index => $row)
                                    @php
                                        $lot_number = $row['lot_number'];
                                        $wrc_number = $row['wrc_number'];
                                        $batch_no = $row['batch_no'];
                                        $batch_no_is = $batch_no > 0 ? $batch_no :'None';

                                        $Company = $row['Company'];
                                        $brand_name = $row['brand_name'];
                                        $wrc_created_at = $row['wrc_created_at'];
                                        $sku_qty = $row['sku_qty'];
                                        
                                        $alloacte_to_copy_writer = $row['alloacte_to_copy_writer'];
                                        $cp_sum = $row['cp_sum'];
                                        $cataloger_sum = $row['cataloger_sum'];
                                        
                                        // echo "<br> alloacte_to_copy_writer => $alloacte_to_copy_writer , sku_qty => $sku_qty  , cp_sum => $cp_sum  , cataloger_sum => $cataloger_sum ";
                                        
                                        $wrcStatus = "Allocation Pending";
                                        
                                        if(($alloacte_to_copy_writer == 1 && $sku_qty == $cp_sum && $sku_qty == $cataloger_sum) || ($alloacte_to_copy_writer == 0 && $sku_qty == $cataloger_sum) ){
                                            $wrcStatus = "Tasking Pending";

                                            $allocation_id_list = $row['allocation_id_list'];
                                            $allocation_id_arr = explode(",",$allocation_id_list);                                
                                            $tot_allocation_ids = count($allocation_id_arr);

                                            $task_status_list = $row['task_status_list'];
                                            $task_status_arr = explode(',',$task_status_list);
                                            $task_status_sum = array_sum($task_status_arr);

                                            // echo "<br> tot_allocation_ids => $tot_allocation_ids , task_status_sum => $task_status_sum ";

                                            if($task_status_sum == $tot_allocation_ids){
                                                $wrcStatus = "Qc Pending";
                                            }else if($task_status_sum == (2*$tot_allocation_ids)){
                                                $wrcStatus = "Submission Pending";
                                            }else if($task_status_sum == (3*$tot_allocation_ids)){
                                                $submission_id =$row['submission_id'];
                                                $ar_status =$row['ar_status'];
                                                if($submission_id > 0){
                                                    if($ar_status > 0){
                                                        $wrcStatus = "Completed";
                                                    }else{
                                                        $wrcStatus = "Client Feedback Pending";
                                                    }
                                                }
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{$sno++}}</td>
                                        <td>{{$lot_number}}</td>
                                        <td>{{$wrc_number}}</td>
                                        <td>{{$Company}}</td>
                                        <td>{{$brand_name}}</td>
                                        <td>{{$batch_no_is}}</td>
                                        {{-- <td>{{$wrc_created_at}}</td> --}}
                                        <td>{{$sku_qty}}</td>
                                        <td>{{$wrcStatus}}</td>

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