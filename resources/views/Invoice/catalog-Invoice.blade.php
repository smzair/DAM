@extends('layouts.admin')

@section('title')
Update CataLog Invoice Number
@endsection
@section('content')

<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<style type="text/css">
    .info-list > li {
        display: block;
        width: 100%;
        position: relative;
    }

    .info-list > li:not(:last-child) {
        margin-bottom: 4px;
    }

    .info-list > li > span, .info-list > li > a {
        display: inline-block;
    }

    .info-list > li > a:hover, .info-list > li > a:focus {
        text-decoration: underline !important;
    }

    .date, .time {
        display: block;
        width: 100%;
    }

    .time {
        font-weight: 700;
    }

    .allocation-wrc-modal .modal-body {
        padding: 1rem 1.2rem;
    }

    .alloc-action-btn.inactive {
        pointer-events: none;
        opacity: 0.5;
    }

    .card.card-transparent .table td .task-start-button .btn {
        background-color: #FBF702 !important;
        color: #000 !important;
        border-color: transparent;
        width: 100%;
    }

    .card.card-transparent .table td .task-start-button .btn:hover, 
    .card.card-transparent .table td .task-start-button .btn:focus {
        background-color: #ba8b00 !important;
    }

    .alloc-action-btn {
        display: block;
    }

    .alloc-action-btn:first-of-type {
        margin-bottom: 10px;
    }

    .msg_box{
            margin: 0.1em 0;
            background: #d3cdcdfc;
            padding: 0.3em;
        }


        .switch {
            position: relative; 
            display: inline-block;
            min-width: 60px;
            min-height: 34px;
        }
        
        .switch input { 
            opacity: 0; 
            min-width: 60px;
            min-height: 34px;
        }
        
       .switch .btn_success{
            background-color: #00ff00 !important;
            background: transparent;
            border: 1px solid  #00ff00;
            border-radius: 10%;
            color: #000;
        }

        .switch .btn_pending{
            background-color: #d1ff00 !important;
            /* background: transparent; */
            border: 1px solid #d1ff00; 
            border-radius: 10%;
        }

        .pointer{
            cursor: pointer;
            /* list-style:disc outside none;
            display:list-item;  */
            
        }

        .pointer span{
            list-style-type: circle;
        }
        .head_row{
            align-items: center;
            padding: 0 5px;
            align-items: center;
            padding: 10px;
            border: 1px solid;
        }

          .head_row .col-4 , .head_row .col-6 , .head_row .col-9{
            /* border: 1px solid #666; */
        }
</style>

<style>
    .card-body .box{
        padding: 2px 20px;
        /* background: #fff; */
    }

</style>
<div class="container-fluid mt-5 plan-shoot">

    <div class="row" id="upload_row" style="display: none">
        <div class="col-3">
            <div class="card card-transparent card-info mt-3">
                
                <div class="card-header">
                    <h2 class="card-title" > Upload CataLog Wrc Invoice Numbers</h2>
                    <button type="button" class="close"  aria-label="Close" onclick="hideUpload()">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                
                <div class="card-body">
                    <div class="row" style="width: 100%">
                        <form method="POST"  action="{{route('SaveCataLogBulkInvoice')}}" enctype="multipart/form-data" style="width: 100%" >
                            @csrf
                            <div class="col-12">
                                <div class="box">
                                    {{-- <label class="control-label  required" style="display: block">Upload CataLog Wrc Invoice Numbers</label> --}}
                                    
                                    <div class="form-group">
                                        <input required  id="files"  type="file" id="invoice_sheet" name="invoice_sheet" class="btn btn-xl btn-warning mb-2">
                                    </div>
                                </div>
                            </div>
                                    
                            <div class="col-12">
                                <button type="submit" class="btn btn-xl btn-warning mb-2"> Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2nd Row --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-transparent">
                <div id="msg_div">
                    @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if (Session::has('error'))
                        <div class="alert alert-false" role="alert">
                            {{ Session::get('false') }}
                        </div>
                    @endif
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title" style="font-size: 2rem;">Update CataLog Invoice Number</h3>
                        </div>
                        <div class="col-6">
                            <a  class="btn btn-warning" id="uploadPlanSkuCsv" onclick="displayRow()">Upload SKU CSV to Plan</a>
                            <a download="catalog Plan SKU CSV" href="{{ asset('fiels/CataloginvoiceNumber.csv') }}" class="btn btn-warning" id="downloadPlanSkuCsv">Download Plan SKU CSV</a>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
                    <table id="qaTableCat" class="table table-head-fixed text-nowrap data-table">
                        <thead>
                            <tr>
                                <th class="align-middle text-center">ID</th>
                                <th class="align-middle text-center">Lot Number</th>
                                <th class="align-middle text-center">Company Name</th>
                                <th class="align-middle text-center">Brand Name</th>
                                <th class="align-middle text-center">Kind of Work</th>
                                <th class="align-middle text-center">WRC Number</th>
                                <th class="align-middle text-center">Batch Number</th>
                                <th class="align-middle text-center">Submission Count</th>
                                <th class="align-middle text-center">Commercial Per SKU</th>
                                <th class="align-middle text-center">Total Commercial</th>
                                <th class="align-middle text-center">Invoice Number</th>
                                <th class="align-middle text-center">Action</th>
                                <th class="align-middle text-center">Wrc Created At</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                // pre($catalog_Wrc_list_for_Submission);
                                // dd($catalog_Wrc_list_for_Submission);
                                $modeOfDelivary_arr = modeOfDelivary();
                            @endphp
                           
                           @foreach($catalog_Wrc_list_for_Submission  as $row_key => $row)
                            @php
                                $wrc_id = $row['wrc_id'];
                                $batch_no = $row['batch_no'];
                                $batch_no_is = $batch_no > 0 ? $batch_no :'None';

                                $lot_number = $row['lot_number'];
                                $company = $row['company'];
                                $brands_name = $row['brands_name'];
                                $kind_of_work = $row['kind_of_work']; 
                                $wrc_number = $row['wrc_number'];
                                $sku_qty = $row['sku_qty'];
                                $CommercialSKU = $row['CommercialSKU'];
                                $submission_id = $row['submissionId'];
                                
                                $market_place = $row['market_place'];
                                $wrc_id_is = $row['wrc_id'];
                                $wrc_id_is = ""; 
                                $invoice_not_yet = 'Invoice Not Raised Yet';
                                $invoiceNumber = ($row['invoiceNumber'] == null || $row['invoiceNumber'] == '' ) ? $invoice_not_yet : $row['invoiceNumber'] ;

                                $btn_text = $invoiceNumber != $invoice_not_yet ? "Update Invoice Number" :  "Add Invoice Number";
                                $wrc_created_at =  $row['wrc_created_at'] != '0000-00-00 00:00:00' ? date('d-m-Y h:i A',strtotime($row['wrc_created_at'])) : '';
                                $modeOfDelivary = $row['modeOfDelivary'];
                                $modeofdelivary_is = $modeOfDelivary_arr[$modeOfDelivary];
                                $alloacte_to_copy_writer = $row['alloacte_to_copy_writer']; 
                            @endphp
                            <tr>
                                <td class="text-center">{{ $row_key+1 }}</td>
                                <td class="text-center">{{ $lot_number }}</td>
                                <td class="text-center">{{ $company }}</td>
                                <td class="text-center">{{ $brands_name .$wrc_id_is }}</td>
                                <td>{{ $kind_of_work }}</td>
                                <td class="text-center">{{ $wrc_number }}</td>
                                <td class="text-center">{{ $batch_no_is }}</td>
                                <td class="text-center">{{ $sku_qty }}</td>
                                <td class="text-center">{{ $CommercialSKU }}</td>
                                <td class="text-center">{{ $sku_qty*$CommercialSKU }}</td>
                                <td class="text-center" id="invoiceNumber_{{ $submission_id }}">{{ $invoiceNumber }}</td>
                                <td>
                                    <div class="d-inline-block mt-1">
                                        <p class="d-none" id="data_id_{{ $submission_id }}" 
                                        data-lot_number="{{ $lot_number }}"
                                        data-company="{{ $company }}"  
                                        data-brands_name="{{ $brands_name }}"  
                                        data-wrc_number="{{ $wrc_number }}"  
                                        data-wrc_id="{{ $wrc_id }}" 
                                        data-submission_id="{{ $submission_id }}" 
                                        data-batch_no="{{ $batch_no }}" 
                                        data-invoiceNumber="{{ $invoiceNumber }}"  
                                        > </p>

                                        <button id="btn_{{ $submission_id }}" data-company="{{ $wrc_id }}" onclick="setdata('{{ $submission_id }}')" class="btn btn-default py-1 mt-1" data-toggle="modal" data-target="#catalogueCommnentModal">{{$btn_text}}</button>
                                    </div>
                                </td>
                                <td class="text-center">{{ $wrc_created_at }}</td>
                            </tr>  
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal section --}}
    <div class="modal fade" id="catalogueCommnentModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h4 class="modal-title">Enter Invoice Number</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="comment-form">
                        {{-- row 1 --}}
                        <div class="row" >
                            <div class="col-12 form-group">
                                <textarea type="text" class="form-control" name="invoiceNumber" id="invoiceNumber" value=""> </textarea>
                                
                            </div>
                        </div>

                        {{-- <div class="row mt-4">
                            <div class="col-6">
                                <p>Date <span id="submission_date"></span></p>
                            </div>
                            <div class="col-6 ">Wrc Marked Complete</div>
                        </div> --}}
                        
                        <div class="form-group">
                            <input type="hidden" name="wrc_id" id="wrc_id">
                            <input type="hidden" name="batch_no" id="batch_no">
                            <input type="hidden" name="submission_id" id="submission_id">
                            <input type="hidden" name="catalog_allocation_ids" id="catalog_allocation_ids">
                            <button onclick="submit_invoice_number()" type="button" class="btn btn-warning" id="submit_invoice_number_btn">Submit</button>

                        </div>
                        <p id="msg_box" class="msg_box" style="display: none"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<script>
    $(document).on('click', '.cpy-textVal', function () {
        var ValC = $(this).text().trim();

        var nwArray = [[`${ValC}`]];

        navigator.clipboard.writeText(nwArray).then(() => {
            $('.copy-msg').fadeIn(250);
            setTimeout(function () {
                $('.copy-msg').fadeOut(250);
            }, 1000);
        })
        .catch((err) => {
            alert("Error in copying text: ", err);
        });
    });

    $('#qaTableCat').DataTable({
        dom: 'lBfrtip',
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "buttons": ["copy", "csv", "excel", "pdf"]
    }).buttons().container().insertAfter('#masterData_wrapper .dataTables_length');

</script>

<script>
    const invoice_not_yet = '{{$invoice_not_yet}}'
    console.log(invoice_not_yet)
</script>

<script>
    function displayRow(){
        $("#upload_row").css("display", "Block");
    }

    function hideUpload(){
        $("#upload_row").css("display", "none");
    }
</script>

{{-- script for setdata into modal  --}}
<script>
    function setdata(val){
        const data_id = "data_id_"+val; 
        const wrc_id = $("#"+data_id).data("wrc_id")
        const batch_no = $("#"+data_id).data("batch_no")
        const submission_id = $("#"+data_id).data("submission_id")
        
        const lot_number = $("#"+data_id).data("lot_number")
        const wrc_number = $("#"+data_id).data("wrc_number")
        // const invoicenumber = $("#"+data_id).data("invoicenumber") 
        let invoicenumber =  document.getElementById("invoiceNumber_"+val).innerHTML

        document.getElementById("submit_invoice_number_btn").innerHTML = "Update";
        if(invoicenumber == invoice_not_yet){
            invoicenumber = '';
            document.getElementById("submit_invoice_number_btn").innerHTML = "Save";
        }
        
        const brand_name = $("#"+data_id).data("brands_name")
        const company = $("#"+data_id).data("company")
        const tot_sku = $("#"+data_id).data("sku_qty") 

        console.log({data_id, wrc_id, batch_no, invoicenumber , submission_id})
        
        document.getElementById('wrc_id').value = val
        document.getElementById('batch_no').value = batch_no
        document.getElementById("invoiceNumber").value = invoicenumber;
        document.getElementById("submission_id").value = submission_id;
    }
</script>


{{-- script for copy to --}}
<script>
    function copyToClipboard(id_is) {
        const element = document.getElementById(id_is);
        const val_is = element.innerHTML;
        navigator.clipboard.writeText(val_is);
        $("#copy_msg").removeClass("d-none");
        setTimeout(() => {
            $("#copy_msg").addClass("d-none");
        }, 2000)
    }
</script>

{{-- submit_wrc --}}
<script>
    function submit_invoice_number(){
        $('#msg_box').html("");
        $("#msg_box").css("display", "none");
        $("#msg_box").css("color", "red");
        // $("#msg_div").css("display", "Block");

       const wrc_id = document.getElementById('wrc_id').value 
       const batch_no = document.getElementById('batch_no').value 
       const invoiceNumber = document.getElementById("invoiceNumber").value 
       const submission_id = document.getElementById("submission_id").value 

       let old_invoicenumber =  document.getElementById("invoiceNumber_"+submission_id).innerHTML
        
        $.ajax({
            url: "{{ url('save-Catalog-invoice-number')}}",
            type: "POST",
            dataType: 'json',
            data: {
                wrc_id,
                batch_no,
                invoiceNumber,
                submission_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                console.log(res)
                let {update_status , massage } = res;
                console.log({update_status , massage})
                if(update_status == 1){
                    // alert(massage);
                    document.getElementById("invoiceNumber_"+submission_id).innerHTML = invoiceNumber
                    $("#msg_box").css("color", "green");
                    if(old_invoicenumber == invoice_not_yet){
                        invoicenumber = '';
                        document.getElementById("submit_invoice_number_btn").innerHTML = "Update";
                        document.getElementById("btn_"+submission_id).innerHTML = "Update Invoice Number";
                        massage = "Wrc Invoice Number Saved!!"
                    }
                }
                $("#msg_box").css("display", "block");

                document.getElementById("msg_box").innerHTML = massage
                // $('#msg_box').html(massage);
            }
        });
        setTimeout( () => {
            $('#msg_box').html("");
            $("#msg_box").css("display", "none");
        }, 2000);
    }
</script>

<script>
    setTimeout( () => {
        $("#msg_div").css("display", "none");
    }, 2000);
</script>

{{-- submit_wrc --}}
<script>
    function submit_wrc(id){
        console.log(id)
        const wrc_id = id
        $.ajax({
            url: "{{ url('completed-qc-wrc')}}",
            type: "POST",
            dataType: 'json',
            data: {
                wrc_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                res;
                if(res == 1){
                    alert('Qc Status Completed Successfully');
                    window.location.reload();
                }else{
                    alert('Somthing Went Wrong!!!');
                }
            }
        });
        setTimeout( () => {
            $('#msg_box1').html("");
            $("#msg_box1").css("display", "none");
        }, 2000);
    }
</script>


@endsection