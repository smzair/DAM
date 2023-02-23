@extends('layouts.admin')

@section('title')
WRC Client Approval & Rejection
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
            @if (Session::has('success'))
            <div class="alert alert-success" id="sub_msg_div" role="alert">
                {{ Session::get('success') }}
            </div>
            {{ Session::forget('success') }}
            @endif
            @if (Session::has('error'))
            <div class="alert alert-danger" id="sub_msg_div" role="alert">
                {{ Session::get('error') }}
            </div>
            {{ Session::forget('error') }}
            @endif
            <div class="card card-transparent">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: 2rem;">WRC Client Approval & Rejection</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
                    <table id="qaTableCat" class="table table-head-fixed text-nowrap data-table">
                        <thead>
                            <tr>
                                <th class="align-middle">ID</th>
                                <th class="align-middle" style="text-align: center">Company Name</th>
                                <th class="align-middle" style="text-align: center">Brand Name</th>
                                <th class="align-middle" style="text-align: center">Lot Number</th>
                                <th class="align-middle" style="text-align: center">WRC Number</th>
                                <th class="align-middle">Feedback Received</th>
                                <th class="align-middle" style="text-align: center">Batch Number</th>
                                <th class="align-middle" style="text-align: center">Order Qty</th>
                                <th class="align-middle" style="text-align: center">SKU Qty</th>
                                <th class="align-middle" style="text-align: center">Kind of Work</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                // pre($creative_Wrc_list_for_Submission);
                            @endphp
                           
                            @foreach($submissionList as $skey=>$row)
                            @php
                                $wrc_id = $row['wrc_id'];
                                $start_time = $row['start_time'];
                                $ini_start_times = $row['ini_start_times'];
                                $ini_start_times_arr = explode(",",$ini_start_times);
                                $tot_times = count($ini_start_times_arr);

                                $initial_start_time;
                                foreach ($ini_start_times_arr as $key => $date) {
                                    if($key == 0){
                                        $initial_start_time = $date;
                                    }else{
                                        // echo "<br> $wrc_id ->  initial_start_time  $initial_start_time  , date => $date  ||||";

                                        if($initial_start_time > $date){
                                            $initial_start_time = $date;
                                        }
                                    }
                                }

                                $work_start_date = date('d-m-Y', strtoTime($initial_start_time));

                                $allow_to_submit = 0;
                                $btn_disable = "disabled";
                                $reworkbtn_disable = "";
                                $submit_check_disable = "disabled"; // checked
                                $submit_check_is_checked = ""; //
                                
                                if($wrc_id == 17) {
                                }
                                $wrc_id_is = $row['wrc_id'];
                                $wrc_id_is = ""; 

                                $company = $row['company_name'];
                                $sku_qty = $row['sku_qty'];
                                $Order_qty = $row['sku_qty'];
                                $brands_name = $row['brand_name'];
                                $lot_number = $row['lot_number'];
                                $wrc_number = $row['wrc_number'];
                                $batch_no = $row['batch_no'];
                                $kind_of_work = $row['kind_of_work']; 

                                $alloacte_to_copy_writer = $row['alloacte_to_copy_writer']; 
                                
                                $creativeer_allocated_qty = $row['creativeer_allocated_qty'];
                                $cp_allocated_qty = $row['cp_allocated_qty']; 

                                $creative_links = $row['creative_links'];
                                $copy_links = $row['copy_links'];
                                $user_roles = $row['user_roles'];
                                $allo_users_id = $row['allo_users_id'];
                                $allocated_users_name = $row['allocated_users_name'];
                                $creative_allocation_ids = $row['creative_allocation_ids'];
                            @endphp
                            <tr>
                                <td id="wrc_id{{$skey}}" data-start_time ="{{dateFormat($row['start_time'])}}<br><b>{{timeFormat($row['start_time'])}}" >{{ $wrc_id }}</td>
                                <td id="company{{$skey}}">{{ $company }}</td>
                                <td id="brands_name{{$skey}}">{{ $brands_name }}</td>
                                <td id="lot_number{{$skey}}">{{ $lot_number }}</td>
                                <td id="wrc_number{{$skey}}" data-copy_link = "{{$copy_links}}" data-creative_link = "{{$creative_links}}" data-creative_submissions_id = "{{$row['creative_submissions_id']}}">{{ $wrc_number }}</td>
                                <td>
                                    <div class="d-inline-block mt-1">
                                        <button data-company="{{ $wrc_id }}" onclick="setdata('{{ $skey }}')" class="btn btn-default py-1 mt-1" data-toggle="modal" data-target="#CreativeApprove">
                                            Approve
                                        </button>
                                        <button data-company="{{ $wrc_id }}" onclick="setdata('{{ $skey }}')" class="btn btn-default py-1 mt-1" data-toggle="modal" data-target="#CreativeReject">
                                            Reject
                                        </button>
                                    </div>
                                </td>
                                <td id="batch_no{{$skey}}">{{ $batch_no }}</td>
                                <?php 
                                if($row['client_bucket'] == 'Retainer'){ ?>
                                    <td id="order_qty{{$skey}}">{{$row['batch_order_qty'] != null ? $row['batch_order_qty'] : 0}}</td>
                                    <td id="sku_count{{$skey}}">{{$row['batch_sku_count'] != null ? $row['batch_sku_count'] : 0}}</td>
                                <?php }else { ?>
                                    <td id="order_qty{{$skey}}">{{$row['order_qty'] != null ? $row['order_qty'] : 0}}</td>
                                    <td id="sku_count{{$skey}}">{{$row['sku_count'] != null ? $row['sku_count'] : 0}}</td>
                                <?php  } ?>
                                <td id="kind_of_work{{$skey}}">{{ $kind_of_work }}</td>
                                
                            </tr>  
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal section --}}
    <div class="modal fade" id="CreativeApprove">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h4 class="modal-title">WRC Client Approval</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('creative_wrc_approve')}}">
                        @csrf
                        <input type="hidden" name="wrc_id" id="wrc_id" value="">
                        <input type="hidden" name="batch_no" class="batch_no" value="">
                        <input type="hidden" name="creative_submissions_id" class="creative_submissions_id" value="">
                        <div class="form-group">
                            <button  type="submit" class="btn btn-warning">Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="CreativeReject">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h4 class="modal-title">WRC Client Rejection</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="width: 50%">
                    <form method="POST" action="{{route('creative_wrc_reject')}}">
                        @csrf
                        <input type="hidden" name="wrc_id" id="wrc_id_reject" value="">
                        <input type="hidden" name="batch_no" class="batch_no_reject" value="">
                        <input type="hidden" name="creative_submissions_id" class="creative_submissions_id" value="">

                        <div class="row">
                            <div class="col-12 form-group">
                                <textarea rows="4" cols="60" name="reject_reason" id="reject_reason" placeholder="Enter Your Reason of rejection..."></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                         
                            <button  type="submit" class="btn btn-warning">Reject </button>
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
        // set wrc id
        const wrc_id_td = "wrc_id"+val;
        const wrc_id = document.getElementById(wrc_id_td).innerHTML;
        document.querySelector('#wrc_id').value = wrc_id;
        document.querySelector('#wrc_id_reject').value = wrc_id;

        // set batch number
        const batch_no_td = "batch_no"+val;
        const batch_no = document.getElementById(batch_no_td).innerHTML;
        document.querySelector('.batch_no').value = batch_no;
        document.querySelector('.batch_no_reject').value = batch_no;

    }
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
    }
</script>

{{-- get user list for rework --}}
<script>
    async function get_list(){
        const wrc_id = document.querySelector("#wrc_id_is").value  
        const role_id_is = document.querySelector('input[name="role_id_is"]:checked').value;
        console.log({role_id_is , wrc_id})
        let options = `<option value="0" data-creative_allocation_id="0" > -- Select User -- </option>`;
        await $.ajax({
            url: "{{ url('get-creative-users_list')}}",
            type: "POST",
            dataType: 'json',
            data: {
                wrc_id : wrc_id,
                role_id_is : role_id_is,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                console.log(res)
                res.map(user => {
                    // console.log(user)
                    options += `<option value="${user.user_id}" data-creative_allocation_id="${user.creative_allocation_id}" > ${user.user_name} </option>`;
                })
            }
        });
        document.getElementById("creative_copy_user").innerHTML = options;
    }
</script>
<!-- msg div script -->
<script>
    setTimeout(function(){
        document.getElementById('sub_msg_div').style.display = "none";
    },3000)
</script>
@endsection