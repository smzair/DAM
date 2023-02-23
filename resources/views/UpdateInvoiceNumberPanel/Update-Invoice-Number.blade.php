@extends('layouts.admin')
@section('title')
Update Invoice Number Panel
@endsection
@section('content')
<div class="lot-table mt-1">
    <div class="container-fluid">
        @if (Session::has('success'))
                        <div class="alert alert-success" id="msg_div" role="alert">
                            {{ Session::get('success') }}
                        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card card-transparent">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <h3 class="card-title text-black text-bold">
                                    <span class="d-inline-block align-middle">
                                        Update Invoice Number Panel
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
                                
                                <div >
                                    <a class="btn btn-xs float-left align-middle mt-0 mr-2 py-1 px-2 mb-1" data-toggle="modal" data-target="#UploadInvoiceNo" style="position: relative; top: 2px;">Upload Invoice No</a>
                                </div>

                                <div>
                                    <a style="margin-left: 15%;" download="update_invoice_no" href="{{ asset('files/update_invoice_no.csv') }}" class="btn btn-xs float-left align-right mt-0 mr-2 py-1 px-2 mb-1"><i class="fa fa-download"></i> Download CSV For Upload Invoice No.</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                        <table id="wrcTable" class="table table-head-fixed table-hover text-nowrap data-table">
                            <thead>
                                <tr class="wrc-tt">
                                    <th class="p-2">Sr. No</th>
                                    <th class="p-2">LOT Number</th>
                                    <th class="p-2">Company Name</th>
                                    <th class="p-2">Brand Name</th>
                                    <th class="p-2">Kind Of Work</th>
                                    <th class="p-2">WRC Number</th>
                                    <th class="p-2">Batch No</th>
                                    <th class="p-2">Submission Count</th>
                                    <th class="p-2">Commercial Per Sku</th>
                                    <th class="p-2">Total Commercial</th>
                                    {{-- <th class="p-2">Order Quantity</th> --}}
                                    {{-- <th class="p-2">Sku Counts</th> --}}
                                    <th class="p-2">Invoice No</th>
                                    <th class="p-2">Actions</th>
                                    <th class="p-2" style="display: none">--</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wrcs as $index => $wrc)
                                <tr class="wrc-tt">
                                    <td class="p-sm-2 p-1">{{$index+1}}</td>
                                    <td id="wrc_id{{$index}}" class="p-sm-2 p-1" style="display: none">{{$wrc->id}}</td>
                                    <td id="lotNum" class="p-sm-2 p-1">{{$wrc->lot_number}}</td>
                                    <td id="companyName" class="p-sm-2 p-1">{{$wrc->Company_name}}</td>
                                    <td id="brndName" class="p-sm-2 p-1">{{$wrc->name}}</td>
                                    <td id="kind_of_work{{$index}}" class="p-sm-2 p-1">{{$wrc->kind_of_work}}</td>
                                    <td id="wrcNum" class="p-sm-2 p-1">{{$wrc->wrc_number}}  <span class="cpy-clipboardtable" id="copyBTnTable"></span> </td>
                                    <td title="None for not retainer and other for retainer" id="batchQuantity{{$index}}" class="p-sm-2 p-1">{{$wrc->batch_no == 0 ? 'None' : $wrc->batch_no}}</td>
                                    <td id="commerccialPerSku" class="p-sm-2 p-1">{{$wrc->submission_count}}</td>
                                    <td id="commerccialPerSku" class="p-sm-2 p-1">{{$wrc->per_qty_value}}</td>
                                    <td id="commerccialPerSku" class="p-sm-2 p-1">{{$wrc->per_qty_value * $wrc->submission_count}}</td>
                                    {{-- <td id="orderQuantity" class="p-sm-2 p-1">{{$wrc->order_qty}}</td> --}}
                                    {{-- <td id="skuQuantity{{$index}}" class="p-sm-2 p-1">{{$wrc->sku_count}}</td> --}}
                                    <td id="invoice_no{{$index}}" class="p-sm-2 p-1">{{$wrc->invoice_no == null ? 'Invoice Not Raised yet' : $wrc->invoice_no}}</td>
                                    <td class="p-sm-2 p-1">
                                        <div class="d-inline-block mt-1">
                                            <?php if($wrc->invoice_no == null){ ?>
                                                <button class="btn btn-default py-1 mt-1" data-toggle="modal" data-target="#AddInvoiceNo" onclick="setdata('{{ $index }}')">
                                                    Add Invoice Number
                                                </button>
                                            <?php }else{ ?>
                                                <button class="btn btn-default py-1 mt-1" data-toggle="modal" data-target="#AddInvoiceNo" onclick="setdata('{{ $index }}')">
                                                    Update Invoice Number
                                                </button>
                                            <?php } ?>
                                           
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
    <div class="modal fade" id="AddInvoiceNo">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h4 class="modal-title">Enter invoice number</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="width: 50%">
                    <form method="POST" action="{{route('update_wrc_invoice_no')}}">
                        @csrf
                        <input type="hidden" name="wrc_id" id="wrc_id_update_invoice" value="">
                        <input type="hidden" name="batch_no" class="batch_no_update_invoice" value="">

                        <div class="row">
                            <div class="col-12 form-group">
                                <textarea required rows="4" cols="60" name="wrc_invoice_no" class="wrc_invoice_no" id="wrc_invoice_no" placeholder="Enter invoice number.."></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <button  type="submit" class="btn btn-warning update_invoice_button">Submit </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="UploadInvoiceNo">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h6 class="modal-title">Upload Invoice No</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{route('update_wrc_invoice_no')}}" enctype="multipart/form-data" onsubmit="return validateForm();">

                    @csrf
                    <div class="modal-body" style="width: 50%">
                        <div class="row">
                            <label for="invoice_no_sheet" class="btn btn-success btn-xl btn-warning mb-2">
                                <i class="fa fa-upload"></i> Choose CSV
                            </label>
                            <div class="col-12 form-group">
                                <input type="file" accept=".csv" id="invoice_no_sheet" name="invoice_no_sheet" style="display: none;" onchange="updateFileName(this)">
                            </div>
                            <div class="col-12 form-group" id="file-name-display">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <div class="form-group">
                            <button  type="submit" value="Submit" class="btn btn-warning update_invoice_button">Submit </button>
                        </div>
                        <div class="col-12 form-group" id="file-error-display" style="color: #FF0000">
                        </div>
                    </div>
                </form>
                
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

<script>
    $('#wrcTable').DataTable({
        dom: 'lBfrtip',
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "buttons": ["copy", "csv", "excel", "pdf"]
    }).buttons().container().insertAfter('#masterData_wrapper .dataTables_length');
</script>
<script>
    setTimeout(function(){
        document.getElementById('msg_div').style.display = "none";
    },3000)
</script>

{{-- script for setdata into modal  --}}
<script type="text/javascript">
    function setdata(val){
        // set wrc id
        const wrc_id_td = "wrc_id"+val;
        const wrc_id = document.getElementById(wrc_id_td).innerHTML;
        document.querySelector('#wrc_id_update_invoice').value = wrc_id;

        // set batch number
        const batch_no_td = "batchQuantity"+val;
        const batch_no = document.getElementById(batch_no_td).innerHTML;
        document.querySelector('.batch_no_update_invoice').value = batch_no;

        // set wrc no
        const invoice_no_td = "invoice_no"+val;
        const invoice_no = document.getElementById(invoice_no_td).innerHTML;
        if(invoice_no == 'Invoice Not Raised yet'){
            document.querySelector('.wrc_invoice_no').value = null;
            document.querySelector('.update_invoice_button').innerHTML = 'Submit';
        }else{
            document.querySelector('.wrc_invoice_no').value = invoice_no;
            document.querySelector('.update_invoice_button').innerHTML = 'Update';
        }
        
    }
</script>

<!-- msg div script -->
<script type="text/javascript">
    setTimeout(function(){
        document.getElementById('msg_div').style.display = "none";
    },3000)
</script>

<script type="text/javascript">
    function updateFileName(input) {
      var fileName = input.value.split("\\").pop();
      document.getElementById("file-name-display").innerHTML = fileName || "No file selected";
    }
    </script>

<script>
    function validateForm() {
        var fileInput = document.getElementById("invoice_no_sheet");
        var filePath = fileInput.value;

        if (!filePath) {
            document.getElementById("file-error-display").innerHTML = "Please select a file";
            return false;
        } else {
            var allowedExtensions = /(\.csv)$/i;
            if (!allowedExtensions.exec(filePath)) {
                document.getElementById("file-error-display").innerHTML = "Please select a .csv file";
                return false;
            }
        }

        document.getElementById("file-error-display").innerHTML = "";
        return true;
    }
</script>

@endsection