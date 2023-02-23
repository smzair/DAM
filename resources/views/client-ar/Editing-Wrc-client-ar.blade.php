@extends('layouts.admin')

@section('title')
Editing - Client Approval/Rejection
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
<div class="container-fluid mt-5 plan-shoot">
    <div class="row">
        <div class="col-12">
            <div class="card card-transparent">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: 2rem;">Client Approval & Rejection</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
                    <table id="qaTableCat" class="table table-head-fixed text-nowrap data-table">
                        <thead>
                            <tr>
                                <th class="align-middle">S.No</th>
                                <th class="align-middle" style="text-align: center">Lot Number</th>
                                <th class="align-middle" style="text-align: center">Brand Name</th>
                                <th class="align-middle" style="text-align: center">Company Name</th>
                                <th class="align-middle" style="text-align: center">WRC Number</th>
                                <th class="align-middle" style="text-align: center">Invoice Number</th>
                                <th class="align-middle" style="text-align: center">Feedback Action</th>
                                <th class="align-middle" style="text-align: center">Submission Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sno = 1;
                            @endphp
                            @foreach($data_list as $row)
                                @php
                                    $wrc_id_is = $row['wrc_id'];
                                    $wrc_id_is = ""; 
                                    $submission_id = $row['submission_id'];
                                    $wrc_id = $row['wrc_id'];
                                    $lot_number = $row['lot_number'];
                                    $brands_name = $row['brands_name'];
                                    $c_short = $row['c_short'];
                                    $company = $row['company'];
                                    $wrc_number = $row['wrc_number'];
                                    $submission_date = $row['submission_date']; 
                                    $ar_status = $row['ar_status'];
                                    $imgqty = $row['imgqty'];
                                    $invoice_number = $row['invoice_number'] != '' ? $row['invoice_number'] : '-' ;
                                    $btn_disable = "disabled";

                                    if ($ar_status == 1) {
                                        $btn_Reject = "Wrc Approved can't Reject!!";
                                        $btn_Approve = "Wrc already Approved";
                                    }elseif ($ar_status == 2) {
                                        $btn_Reject = "Wrc already Rejected!!";
                                        $btn_Approve = "Wrc Rejected can't Approved!!";
                                    }else {
                                        $btn_Reject = "Click for Reject";
                                        $btn_Approve = "Click for Approve";
                                        $btn_disable = "";
                                    }

                                @endphp
                                <tr>
                                    <td class="text-center">{{ $sno++ }}</td>
                                    <td class="text-center">{{ $lot_number }}</td>
                                    <td class="text-center">{{ $brands_name .$wrc_id_is }}</td>
                                    <td class="text-center">{{ $company }}</td>
                                    <td class="text-center">{{ $wrc_number }}</td>
                                    <td class="text-center">{{ $invoice_number }}</td>
                                    
                                    <td class="text-center">

                                        <span class="d-none" id="data_id_{{$submission_id}}" data-wrc_id="{{$wrc_id}}"  data-submission_id="{{$submission_id}}" ></span>

                                        <button id="btn_Reject{{ $submission_id }}"  title="{{ $btn_Reject }}" {{ $btn_disable }} onclick="setdata('{{ $submission_id }}')" class="btn transpant py-1 mt-1" data-toggle="modal" data-target="#catalogueCommnentModal"> Reject </button>
                                    <button id="btn_Approve{{ $submission_id }}" onclick="setdata('{{ $submission_id }}') ; wrc_reject_approve_wrc('1')" title="{{ $btn_Approve }}" {{ $btn_disable }} class="btn transpant py-1 mt-1">Approve</button>
                                    </td>
                                    <td class="text-center">{{ dateFormat($submission_date) }}</td>
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
                    <h4 class="modal-title">Enter your Reason of Rejection</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="comment-form">
                        <div class="row">
                            <div class="col-12 form-group">
                                {{-- <label for="rejection_reason">Enter your reason of rejection</label> --}}
                                <textarea class="form-control" name="rejection_reason" id="rejection_reason" placeholder="Enter your reason of rejection"></textarea>
                            </div>
                        </div>
                        <div id="msg_div" style="display: none;">
                            <p class="msg_box" id="msg_box"></p>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="wrc_id" id="wrc_id">
                            <input type="hidden" name="submission_id" id="submission_id">
                            <button onclick="wrc_reject_approve_wrc(2)" type="button" class="btn btn-warning">Submit WRC</button>
                        </div>
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



{{-- script for setdata into modal  --}}
<script>
    function setdata(val){
        const data_id = "#data_id_"+val;
        const wrc_id = $(data_id).data('wrc_id')
        const submission_id = $(data_id).data('submission_id')
        document.getElementById('wrc_id').value = wrc_id
        document.getElementById('submission_id').value = submission_id
    }
</script>


{{-- script for save data to rewrok   --}}
<script>
    async function wrc_reject_approve_wrc(ar_status){
        const wrc_id_is = wrc_id  = document.querySelector("#wrc_id").value  
        const submission_id  = document.querySelector("#submission_id").value  
        const rejection_reason = document.querySelector("#rejection_reason").value  
        const btn_Reject_id = "btn_Reject"+submission_id;
        const btn_Approve_id = "btn_Approve"+submission_id;

        console.log({btn_Approve_id , btn_Reject_id})
        console.warn({wrc_id , rejection_reason , ar_status ,wrc_id_is})
        
        await $.ajax({
            url: "{{ url('Editing-client-wrc-AR')}}",
            type: "POST",
            dataType: 'json',
            data: {
                submission_id,
                wrc_id,
                ar_status,
                rejection_reason,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                // console.log({res})
                let massage = "somthing went Wrong!!!"
                let btn_Reject = '';
                let btn_Approve = '';               
                
                if(res?.update_status == 1){
                    $("#"+btn_Approve_id).attr("disabled" , true);
                    $("#"+btn_Reject_id).attr("disabled" , true);
                    $("#msg_box").css("color", "green");
                    if(res?.ar_status == 1){
                        massage  = "Wrc Approved";
                        if(res.massage){
                            massage = res.massage
                        }
                        btn_Reject = "Wrc Approved can't Reject!!";
                        btn_Approve = "Wrc already Approved"; 
                        alert(massage)

                    }else{
                        massage  = "Wrc rejected";
                        if(res.massage){
                            massage = res.massage
                        }
                        btn_Reject = "Wrc already Rejected!!";
                        btn_Approve = "Wrc Rejected can't Approved!!";
                    }
                    // window.location.reload();
                }else{
                    massage = res.massage
                    $("#msg_box").css("color", "red");
                    btn_Approve = document.getElementById(btn_Approve_id).title
                    btn_Reject = document.getElementById(btn_Reject_id).title
                    if(res.ar_status == 1){
                        alert(massage)
                    }
                }

                document.getElementById(btn_Approve_id).title = btn_Approve;
                document.getElementById(btn_Reject_id).title = btn_Reject;
                document.querySelector("#msg_box").innerHTML = massage
                $("#msg_div").css("display", "Block");
            }
        });
        setTimeout( () => {
            $("#msg_div").css("display", "none");
            $('#msg_box').html("");
        }, 2000);
    }
</script>
@endsection