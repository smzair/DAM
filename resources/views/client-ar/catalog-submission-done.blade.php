@extends('layouts.admin')

@section('title')
Catalogue - Submission
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
                    <h3 class="card-title" style="font-size: 2rem;">Catalogue - Submission Done</h3>
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
                                <th class="align-middle" style="text-align: center">Total SKY</th>
                                <th class="align-middle" style="text-align: center">Kind of Work</th>
                                <th class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                // pre($catalog_Wrc_list_for_Submission);
                            @endphp
                           
                            @foreach($catalog_Wrc_list_for_Submission as $row)
                            @php
                                $wrc_id = $row['wrc_id'];
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

                                $company = $row['company'];
                                $sku_qty = $row['sku_qty'];
                                $brands_name = $row['brands_name'];
                                $lot_number = $row['lot_number'];
                                $wrc_number = $row['wrc_number'];
                                $kind_of_work = $row['kind_of_work']; 

                                $alloacte_to_copy_writer = $row['alloacte_to_copy_writer']; 
                                
                                $cataloger_allocated_qty = $row['cataloger_allocated_qty'];
                                $cp_allocated_qty = $row['cp_allocated_qty']; 

                                $catalog_links = $row['catalog_links'];
                                $copy_links = $row['copy_links'];
                                $user_roles = $row['user_roles'];
                                $allo_users_id = $row['allo_users_id'];
                                $allocated_users_name = $row['allocated_users_name'];
                                $catalog_allocation_ids = $row['catalog_allocation_ids'];
                            @endphp
                            <tr>
                                <td>{{ $wrc_id }}</td>
                                <td>{{ $company }}</td>
                                <td>{{ $brands_name .$wrc_id_is }}</td>
                                <td>{{ $lot_number }}</td>
                                <td>{{ $wrc_number }}</td>
                                <td>{{ $sku_qty }}</td>
                                <td>{{ $kind_of_work }}</td>
                               
                                <td>
                                    <div class="d-inline-block mt-1">
                                        {{-- {{ $reworkbtn_disable }} --}}

                                        <p class="d-none" id="data_id_{{ $wrc_id }}" 
                                        data-wrc_id="{{ $wrc_id }}" 
                                        data-company="{{ $company }}"  
                                        data-brands_name="{{ $brands_name }}"  
                                        data-lot_number="{{ $lot_number }}"  
                                        data-wrc_number="{{ $wrc_number }}"  
                                        data-sku_qty="{{ $sku_qty }}"  
                                        data-work_start_date="{{ $work_start_date }}"  

                                        data-catalog_links="{{ $catalog_links }}"  
                                        data-copy_links="{{ $copy_links }}"  
                                        data-allo_users_id="{{ $allo_users_id }}"  
                                        data-allocated_users_name="{{ $allocated_users_name }}"  
                                        data-catalog_allocation_ids="{{ $catalog_allocation_ids }}"  
                                        
                                        data-user_roles="{{ $user_roles }}"  
                                        data-alloacte_to_copy_writer="{{ $alloacte_to_copy_writer }}" 
                                        data-cataloger_allocated_qty="{{ $cataloger_allocated_qty }}" 
                                        data-cp_allocated_qty="{{ $cp_allocated_qty }}" 
                                        > </p>

                                        <button data-company="{{ $wrc_id }}" onclick="setdata('{{ $wrc_id }}')" class="btn btn-default py-1 mt-1" data-toggle="modal" data-target="#catalogueCommnentModal">
                                            Details
                                        </button>
                                    </div>
                                </td>
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
                    <h4 class="modal-title">Ready For Submission</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="comment-form">
                        {{-- row 1 --}}
                        <div class="row">
                            <div class="col-3 form-group">
                                <label for="wrc_number">Wrc number</label>
                                <p id="wrc_number">Wrc number is</p>
                            </div>
                            <div class="col-3 form-group">
                                <label for="company">Company</label>
                                <p id="company">Company</p>
                            </div>
                            <div class="col-3 form-group">
                                <label for="brand_name">Brand</label>
                                <p id="brand_name">Wrc number is</p>
                            </div>
                            <div class="col-3 form-group">
                                <label for="tot_sku">Total Sky</label>
                                <p id="tot_sku">Wrc number is</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3 form-group">
                                <label for="work_start_date">Wrok Start Date</label>
                                <p id="work_start_date">Start Date</p>
                            </div>
                            <div class="col-3 form-group">
                                <label for="work_initiate_date">Wrok Initiate Date</label>
                                <p id="work_initiate_date">Initiate</p>
                            </div>
                            <div class="col-3 form-group">
                                <label for="work_commited_date">Wrok Committed Date</label>
                                <p id="work_commited_date">Committed</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="allo_qty_to_cata">Allocated to Catalogure</label>
                                <p id="allo_qty_to_cata">Dummy qty 2</p>
                            </div>
                            <div id="copy_qty_div" class="col-6 form-group d-none">
                                <label for="allo_qty_to_copy">Allocated to Copy Writer</label>
                                <p id="allo_qty_to_copy"> D qty 5</p>
                            </div>
                        </div>

                        <div class="row px-3">
                            <div class="col-12 form-group" style="background: #eee; color:#232323 ">
                                <div class="row head_row"  >
                                    <div class="col-3">
                                        <p class="m-0">Link To Catalogure</p>
                                    </div>
                                    <div class="col-9" id="link_to_cata_logure">
                                    </div>
                                </div>
                                <div class="row head_row  "  id="link_copy_writer_row">
                                    <div class="col-3">
                                        <p class="m-0">Link To Copy Writer</p>
                                    </div>
                                    <div class="col-9" id="link_to_copy_writer">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p>Date <span id="submission_date"></span></p>
                            </div>
                            <div class="col-6">Wrc Marked Complete</div>
                        </div>
                        
                        <div class="form-group">
                            <input type="hidden" name="wrc_id" id="wrc_id">
                            <input type="hidden" name="catalog_allocation_ids" id="catalog_allocation_ids">
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
        $("#copy_row").addClass("d-none");
        $("#copy_qty_div").addClass("d-none");
        $("#link_copy_writer_row").addClass("d-none");

        console.log({val})
        const data_id = "data_id_"+val;
        const catalog_allocation_ids = $("#"+data_id).data("catalog_allocation_ids")

        document.getElementById('catalog_allocation_ids').value = catalog_allocation_ids
        document.getElementById('wrc_id').value = val
        const wrc_id = $("#"+data_id).data("wrc_id")
        const wrc_number = $("#"+data_id).data("wrc_number")
        const brand_name = $("#"+data_id).data("brands_name")
        const lot_number = $("#"+data_id).data("lot_number")
        const company = $("#"+data_id).data("company")
        const tot_sku = $("#"+data_id).data("sku_qty") 
        const work_start_date = $("#"+data_id).data("work_start_date")
        
        const catalog_links = $("#"+data_id).data("catalog_links")
        const copy_links = $("#"+data_id).data("copy_links")
        const allo_users_id = $("#"+data_id).data("allo_users_id")
        const allocated_users_name = $("#"+data_id).data("allocated_users_name")
        const user_roles = $("#"+data_id).data("user_roles")+''

        const alloacte_to_copy_writer = $("#"+data_id).data("alloacte_to_copy_writer")
        const cataloger_allocated_qty = $("#"+data_id).data("cataloger_allocated_qty")
        const cp_allocated_qty = $("#"+data_id).data("cp_allocated_qty")

        const catalog_link_arr = catalog_links.split(',')
        const copy_links_arr = copy_links.split(',')
        const user_roles_arr = user_roles.split(',')
        const allocated_users_arr = allocated_users_name.split(',')

        document.getElementById("wrc_number").innerHTML = wrc_number;
        document.getElementById("brand_name").innerHTML = brand_name;
        document.getElementById("company").innerHTML = company;
        document.getElementById("tot_sku").innerHTML = tot_sku;
        document.getElementById("work_start_date").innerHTML = work_start_date;
        document.getElementById("allo_qty_to_cata").innerHTML = cataloger_allocated_qty;

        let catalog_li = "";
        catalog_link_arr.forEach((link , index) => {
            console.log({link , index })
            if(link != ''){
                console.log(user_roles_arr[index])
                catalog_li +=   `<p class="pointer m-0" title="uploaded by ${allocated_users_arr[index]} ${ user_roles_arr[index] == 0 ? '' : ' (Copy Writer)'} "> ${link} <i class="fas fa-copy"></i></p>`
            }
        });
        document.getElementById("link_to_cata_logure").innerHTML = catalog_li;
        
        if(alloacte_to_copy_writer === 1){
            let copy_li = "";
            copy_links_arr.forEach((link , index) => {
                console.log({link , index })
                if(link != ''){
                    console.log(user_roles_arr[index])
                    copy_li +=   `<p class="pointer m-0" title="uploaded by ${allocated_users_arr[index]} ${ user_roles_arr[index] == 1 ? '' : ' (Catalogure)'} ">${link} <i class="fas fa-copy"></i></p>`
                }
                document.getElementById("link_to_copy_writer").innerHTML = copy_li;
            });
            document.getElementById("allo_qty_to_copy").innerHTML = cp_allocated_qty;
            $("#copy_row").removeClass("d-none");
            $("#copy_qty_div").removeClass("d-none");
            $("#link_copy_writer_row").removeClass("d-none");
        }

        // const wrc_id = val
        $.ajax({
            url: "{{ url('catalog-submission-details')}}",
            type: "POST",
            dataType: 'json',
            data: {
                wrc_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                console.log()
                const submission_date = res?.[0]?.submission_date
                document.getElementById("submission_date").innerHTML = submission_date;
            }
        });
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


@endsection