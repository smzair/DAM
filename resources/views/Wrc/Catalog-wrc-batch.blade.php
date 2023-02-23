@extends('layouts.admin')

@section('title')
Catalog-wrc-batch
@endsection
@section('content')
<div class="lot-table mt-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-transparent">
                    <div id="msg_div" style="width: 100%;">
                        @if (Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        @if (Session::has('error'))
                            <div class="alert alert-warning" role="alert">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-header">
                        <div class="row">
                           
                            <div class="col-lg-7 col-md-6 col-sm-12">
                                <h3 class="card-title text-black text-bold">
                                    <span class="d-inline-block align-middle">
                                        Catalog-wrc-batch
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
                                    <th style="text-align: center" class="p-2">Id</th>
                                    <th style="text-align: center" class="p-2">WRC Number</th>
                                    <th style="text-align: center" class="p-2">LOT Number</th>
                                    <th style="text-align: center" class="p-2">Company Name</th>
                                    <th style="text-align: center" class="p-2">Brand Name</th>
                                    <th style="text-align: center" class="p-2">Type of Service</th>
                                    <th style="text-align: center" class="p-2">WRC Created At</th>
                                    <th style="text-align: center" class="p-2">Batch Number</th>
                                    <th style="text-align: center" class="p-2">SKU Count</th>
                                    <th style="text-align: center" class="p-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    // pre($data_arr);
                                @endphp
                                @foreach($data_arr as $index => $row)
                                <tr class="wrc-tt">
                                    <td class="p-sm-2 p-1">{{$index+1}}</td>
                                    <td id="wrc_number<?= $index?>" class="p-sm-2 p-1">{{$row['wrc_number']}}</td>
                                    <td id="lot_number<?= $index?>" class="p-sm-2 p-1">{{$row['lot_number']}}</td>
                                    <td id="Company<?= $index?>" class="p-sm-2 p-1">{{$row['Company']}}</td>
                                    <td id="brand_name<?= $index?>" class="p-sm-2 p-1">{{$row['brand_name']}}</td>
                                    <td id="serviceType<?= $index?>" class="p-sm-2 p-1">{{$row['serviceType']}}</td>
                                    <td id="wrc_created_at<?= $index?>" class="p-sm-2 p-1">{{$row['wrc_created_at']}}</td>
                                    <td id="batch_no<?= $index?>" class="p-sm-2 p-1">{{$row['batch_no']}}</td>
                                    <td id="sku_count<?= $index?>" class="p-sm-2 p-1">{{$row['sku_count']}}</td>
                                    <td class="p-sm-2 p-1">                                        
                                        <input id="wrc_id<?= $index;?>" type="hidden" name="wrc_id" value="<?= $row['wrc_id']?>">
                                        <input id="total_skus<?= $index;?>" type="hidden" name="total_skus" value="<?= $row['total_skus']?>">
                                        <input id="total_batch_no<?= $index;?>" type="hidden" name="total_batch_no" value="<?= $row['total_batch_no']?>">
                                        <div class="btn-group-vertical">
                                        <a href="#" class="btn btn-warning alloc-action-btn" data-toggle="modal" data-target="#inverdnewPopup" onclick='setdata(<?php echo $index;?>)'>
                                            Inward New
                                        </a>
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

    {{-- Modal section --}}
    <div class="modal fade" id="inverdnewPopup">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h4 class="modal-title">Comments</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="custom-dt-row work-details">
                        <div class="row">

                            <div class="col-sm-3 col-12">
                                <div class="col-ac-details">
                                    <h6>Selected LOT</h6>
                                    <p id="selectedLot"></p>
                                </div>
                            </div>

                            <div class="col-sm-3 col-6">
                                <div class="col-ac-details">
                                    <h6>WRC Number</h6>
                                    <p id="wrcNo"> </p>
                                </div>
                            </div>

                            <div class="col-sm-3 col-6">
                                <div class="col-ac-details">
                                    <h6>Total Batch Count</h6>
                                    <p id="totalBatchCount"></p>
                                </div>
                            </div>
                            
                            
                            <div class="col-sm-3 col-6">
                                <div class="col-ac-details">
                                    <h6>SKU Count</h6>
                                    <p id="totalSkuCount"></p>
                                </div>
                            </div>

                            <div class="col-sm-3 col-6">
                                <div class="col-ac-details">
                                    <h6>Type of Service :</h6>
                                    <p id="type_of_service">Type of Service</p>
                                </div>
                            </div>

                            
                            
                        </div>
                    </div>
                    <div class="custom-dt-row">
                        <form method="POST" action="{{ route('WRC_INVERD_NEW_BATCH') }}" onsubmit="return validateForm(event)" id="workdetailsform"  enctype="multipart/form-data">

                             @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="custom-info">
                                        <p><h3>Inwarding Batch Information</h3></p>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label class="control-label" for="Prequisites">Prequisites</label>
                                        <input type="text" class="form-control creative_link" name="Prequisites" id="Prequisites"  placeholder="Enter Prequisites Link" value="">
                                    </div>
                                </div>
                                
                                
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="files" class="control-label required" style="">Upload Sheet</label>
                                        <input type="hidden" name="wrc_id" id="wrc_id" value="">
                                        <input accept=".csv" type="file" name="sku_sheet" id="sku_sheet" class="btn btn-success btn-xl btn-warning mb-2 form-control" style="margin-top: 0px !important">
                                    </div>
                                    <div class="input_err" style="background: #c8c6c6;color: #FF0000;display: none;font-size: 1.2em;padding: 0 15px;" id="input_err"></div>
                                </div>

                                <div class="col-sm-6 col-12">
                                    
                                    {{-- <button type="submit" name="submit" value="save" class="btn btn-warning" id="save_btn" href="javascript:void(0)" style="float:right;margin-right:10px;display: flex" >Save</button>

                                    <button type="submit" name = "submit" value="complete_allocation" class="btn btn-warning" href="javascript:void(0)" style="float:right;margin-right:10px">Save & Add Another</button> --}}

                                </div>
                                <div class="col-sm-12 col-12">
                                </div>

                            </div>
                            <div class="row" style="float:right">
                                <button type="submit" name="submit" value="save" class="btn btn-warning" id="save_btn"  style="float:right;margin-right:10px;display: flex" >Save</button>
                            </div>
                        </form>
                    </div>
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

<!-- set dynamic data in modal -->
<script>
    function setdata(id){
        // set order qty
        
        // set lot_number
        const lot_number_td = "lot_number"+id;
        const lot_number = document.getElementById(lot_number_td).innerHTML;
        document.getElementById('selectedLot').innerHTML = lot_number;

        // set wrc number
        const wrc_number_td = "wrc_number"+id;
        const wrc_number = document.getElementById(wrc_number_td).innerHTML;
        document.getElementById('wrcNo').innerHTML = wrc_number;

        //set total Batch Count
        const batchQuantity_td = "batch_no"+id;
        const batchQuantity = document.getElementById(batchQuantity_td).innerHTML;
        document.getElementById('totalBatchCount').innerHTML = batchQuantity;

        console.log({batchQuantity, batchQuantity_td})

        // set sku qty 
        const skuQuantity_td = "total_skus"+id;
        const skuQuantity = document.getElementById(skuQuantity_td).value;
        document.getElementById('totalSkuCount').innerHTML = skuQuantity;

        // set sku qty serviceType wrc_id
        const wrc_id_td = "wrc_id"+id;
        document.getElementById('wrc_id').value = document.getElementById(wrc_id_td).value;

        var element = document.getElementById('workdetailsform')
        element.reset()
        document.getElementById('Prequisites').value = '';
    }
</script>

<!-- validateForm script -->
<script>
    function validateForm(event) {
        // event.preventDefault() // this will stop the form from submitting
        // debugger
        $(".input_err").css("display", "none");
        $(".input_err").html("");

        const Prequisites = $('#Prequisites').val();
        const sku_sheet = document.getElementById("sku_sheet");

        console.log({Prequisites})
        console.log(sku_sheet)
        let sku_sheet_Is_Vailid = true;

        let file_is_vaild = 0;

        if (sku_sheet.files.length > 0) {
            var file = sku_sheet.files[0];
            var fileName = file.name;
            var fileType = file.type;
            var csvType = "text/csv";
            var excelType = "application/vnd.ms-excel";

            if (fileType === csvType || fileName.endsWith(".csv") ) {
                file_is_vaild = 1;
            }else{
                file_is_vaild = 2;
            }
        }
        if(file_is_vaild != 1){
            $("#input_err").html("SKU Sheet is required");
            if(file_is_vaild == 2){
                $("#input_err").html("Selected file is not a CSV");
            }
            document.getElementById("input_err").style.display = "block";
            sku_sheet_Is_Vailid = false;
        }
        setTimeout(() => {
            $('#input_err').attr("style", "display:none")
        }, 2500);
       
        if (sku_sheet_Is_Vailid) {
            return true
        } else {
            return false
        }
    }
</script>

<script>
    $(document).ready(function() {
        setTimeout(() => {
            console.log("gdfhglkfhd sdfkh ")
            $('#msg_div').attr("style", "display:none")
        }, 3500);
    });
</script>
@endsection