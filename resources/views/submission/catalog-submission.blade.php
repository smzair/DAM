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
                    <h3 class="card-title" style="font-size: 2rem;">Catalogue - Ready For Submission</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
                    <table id="qaTableCat" class="table table-head-fixed text-nowrap data-table">
                        <thead>
                            <tr>
                                <th class="align-middle text-center">ID</th>
                                <th class="align-middle text-center">Lot Number</th>
                                <th class="align-middle text-center">Company Name</th>
                                <th class="align-middle text-center">Brand Name</th>
                                <th class="align-middle text-center">WRC Number</th>
                                <th class="align-middle text-center">Batch Number</th>
                                <th class="align-middle text-center">Wrc Created At</th>
                                <th class="align-middle text-center">Total SKU</th>
                                {{-- <th class="align-middle text-center">Kind of Work</th> --}}
                                <th class="align-middle text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                // pre($catalog_Wrc_list_for_Submission);
                                $modeOfDelivary_arr = modeOfDelivary();
                            @endphp
                           
                            @foreach($catalog_Wrc_list_for_Submission as $row)
                            @php
                                $wrc_id = $row['wrc_id'];
                                // $catalog_link_list = $row['catalog_link_list'];
                                // $catalog_link_arr = explode(",",$catalog_link_list);

                                // $copy_link_list = $row['copy_link_list'];
                                // $copy_link_arr = explode(",",$copy_link_list);
                                
                                // $allocation_ids = $row['allocation_ids'];
                                // $allocation_id_arr = explode(",",$allocation_ids);                                
                                // $tot_allocation_ids = count($allocation_id_arr); 

                                $batch_no = $row['batch_no'];
                                $batch_no_is = $batch_no > 0 ? $batch_no :'None';
                                if($row['batch_no'] > 0){
                                    $batch_no_is = ($row['batch'] != '' && $row['batch'] != null) ? $row['batch'] : $row['batch_no'];
                                }else{
                                    $batch_no_is =  'None';
                                }
                                
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
                                $wrc_created_at =  $row['wrc_created_at'] != '0000-00-00 00:00:00' ? date('d-m-Y h:i A',strtotime($row['wrc_created_at'])) : '';
                                $modeOfDelivary = $row['modeOfDelivary'];
                                $modeofdelivary_is = $modeOfDelivary_arr[$modeOfDelivary];
                                $kind_of_work = $row['kind_of_work']; 
                                $market_place = $row['market_place'];
                                $proforma_item = $row['proforma_item'];


                                $alloacte_to_copy_writer = $row['alloacte_to_copy_writer']; 
                                
                                $cataloger_allocated_qty = $row['cataloger_allocated_qty'];
                                $cp_allocated_qty = $row['cp_allocated_qty']; 

                                $final_link_list = $row['final_link_list'];
                                $catalog_links = $row['catalog_links'];
                                $copy_links = $row['copy_links'];
                                $user_roles = $row['user_roles'];
                                $allo_users_id = $row['allo_users_id'];
                                $allocated_users_name = $row['allocated_users_name'];
                                $catalog_allocation_ids = $row['catalog_allocation_ids'];
                            @endphp
                            <tr>
                                <td class="text-center">{{ $wrc_id }}</td>
                                <td class="text-center">{{ $lot_number }}</td>
                                <td class="text-center">{{ $company }}</td>
                                <td class="text-center">{{ $brands_name .$wrc_id_is }}</td>
                                <td class="text-center">{{ $wrc_number }}</td>
                                <td class="text-center">{{ $batch_no_is }}</td>
                                <td class="text-center">{{ $wrc_created_at }}</td>
                                <td class="text-center">{{ $sku_qty }}</td>
                                {{-- <td>{{ $kind_of_work }}</td> --}}
                                <td>
                                    <div class="d-inline-block mt-1">
                                        {{-- {{ $reworkbtn_disable }} --}}

                                        <p class="d-none" id="data_id_{{ $wrc_id }}" 
                                        data-wrc_id="{{ $wrc_id }}" 
                                        data-proforma_item="{{ $proforma_item }}" 
                                        data-batch_no="{{ $batch_no }}" 
                                        data-company="{{ $company }}"  
                                        data-brands_name="{{ $brands_name }}"  
                                        data-lot_number="{{ $lot_number }}"  
                                        data-wrc_number="{{ $wrc_number }}"  
                                        data-modeofdelivary_is="{{ $modeofdelivary_is }}"  
                                        data-market_place="{{ $market_place }}"  
                                        data-sku_qty="{{ $sku_qty }}"  
                                        data-work_start_date="{{ $work_start_date }}"  

                                        data-final_link_list="{{ $final_link_list }}"  
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
                                            To Submit
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
                        {{-- <div class="form-group">
                            <label class="control-label required">Category</label>
                            <div class="group-inner d-flex" >
                                <div class="radio-col w-25">
                                    <span class="checkVal">
                                        Catloger
                                    </span>
                                    <input onclick="get_list()" type="radio" name="role_id_is" id="check1" value="0" class="radio-check" checked>
                                </div>
                                <div class="radio-col">
                                    <span class="checkVal">
                                        Copy Writer
                                    </span>
                                    <input onclick="get_list()" type="radio" name="role_id_is" id="check2" value="1" class="radio-check">
                                </div>
                            </div>
                        </div> --}}
                        {{-- row 1 --}}
                        <div class="row">
                            <div class="col-4 form-group">
                                <label for="wrc_number">Wrc number</label>
                                <p id="wrc_number"></p>
                            </div>
                            <div class="col-4 form-group">
                                <label for="company">Company</label>
                                <p id="company">Company</p>
                            </div>
                            <div class="col-4 form-group">
                                <label for="brand_name">Brand</label>
                                <p id="brand_name"></p>
                            </div>
                            
                        </div>
                        {{-- row 2 --}}
                        <div class="row" >
                            <div class="col-4 form-group">
                                <label for="work_initiate_date">Wrok Initiate Date</label>
                                <p id="work_initiate_date">Initiate</p>
                            </div>
                            <div class="col-4 form-group">
                                <label for="work_commited_date">Wrok Committed Date</label>
                                <p id="work_commited_date">Committed</p>
                            </div>
                            <div class="col-4 form-group">
                                <label for="work_start_date">Wrok Start Date</label>
                                <p id="work_start_date">Start Date</p>
                            </div>
                        </div>

                        {{-- row 3 --}}
                        <div class="row">
                            <div class="col-4 form-group">
                                <label for="tot_sku">Total Sku</label>
                                <p id="tot_sku"></p>
                            </div>
                            <div class="col-4">
                                <label for="allo_qty_to_cata">Allocated to Catalogure</label>
                                <p id="allo_qty_to_cata">Dummy qty 2</p>
                            </div>
                            <div id="copy_qty_div" class="col-4 d-none">
                                <label for="allo_qty_to_copy">Allocated to Copy Writer</label>
                                <p id="allo_qty_to_copy"> D qty 5</p>
                            </div>
                        </div>

                        {{-- link row --}}
                        <div class="row px-3" id="link_row">
                            <div class="col-12">
                                <div class="row px-3">
                                    <div class="col-12" style="background: #eee; color:#232323 ">
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
                            </div>
                        </div>

                        {{-- Marketplace row --}}
                        <div class="row" id="market_place_row">
                            <div class="col-sm-12">
                                <div>
                                    <h3>Marketplace</h3> 
                                </div>
                            </div>
                            {{-- head --}}
                            <div class="col-sm-3 col-12">
                                <div class="col-ac-details">
                                    <h6>Marketplace</h6>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="col-ac-details">
                                    <h6>Approved Count</h6>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="col-ac-details">
                                    <h6>Rejected Count</h6>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="col-ac-details">
                                    <h6>Date</h6>
                                </div>
                            </div>                        
                             
                            {{-- Body innputs --}}
                            <div class="col-12 mt-1" id="marketplace_list_div">
                                @for ($i = 1; $i < 4; $i++)
                                {{-- <div class="row mb-2" id="marketplace_row${data.id}">
                                    <div class="col-sm-3 col-12">
                                        <div class="col-ac-details">
                                            <input type="hidden" name="marketPlace_id${marketPlace_id}" id="marketPlace_id${marketPlace_id}"  value="${marketPlace_id}">
                                            <h6>${data.marketPlace_name}</h6>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-6">
                                        <div class="col-ac-details">
                                            <input type="text" placeholder="Add Approved Count" id="link${marketPlace_id}" name="link${marketPlace_id}" value="${link}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-6">
                                        <div class="col-ac-details">
                                            <input type="text" placeholder="Add Rejected Count" id="username${marketPlace_id}" name="username${marketPlace_id}" value="${username}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-6">
                                        <div class="col-ac-details">
                                            <input type="date" placeholder="Select Date"  id="password${marketPlace_id}" name="password${marketPlace_id}" value="">
                                        </div>
                                    </div>              
                                </div> --}}
                                @endfor
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <input type="hidden" name="wrc_id" id="wrc_id">
                            <input type="hidden" name="batch_no" id="batch_no">
                            <input type="hidden" name="catalog_allocation_ids" id="catalog_allocation_ids">
                            {{-- <button id="submit_wrc" type="button" class="btn btn-warning"> Submit WRC</button> --}}
                            <button onclick="save_data()" type="button" class="btn btn-warning">Submit WRC</button>
                            <p id="copy_msg" class="msg_box d-none">Link Copied</p>
                        </div>
                        <div id="msg_div" style="display: none;">
                            <p class="msg_box" id="msg_box"></p>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12">
                            <button id="raise_btn" data-proforma_item="" data-wrc_id=""  onclick="Raise(this)"> RAISE FOR INVOICE </button>
                        </div>
                    </div>
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
    async function setdata(val){

        $("#link_row").addClass("d-none");
        $("#market_place_row").addClass("d-none");
        $("#copy_row").addClass("d-none");
        $("#copy_qty_div").addClass("d-none");
        $("#link_copy_writer_row").addClass("d-none");
        
        const data_id = "data_id_"+val; 
        const allocation_ids = catalog_allocation_ids = $("#"+data_id).data("catalog_allocation_ids")+""
        const wrc_id = $("#"+data_id).data("wrc_id")
        const batch_no = $("#"+data_id).data("batch_no")
        
        document.getElementById('catalog_allocation_ids').value = catalog_allocation_ids
        document.getElementById('wrc_id').value = val
        document.getElementById('batch_no').value = batch_no
        
        const proforma_item = $("#"+data_id).data("proforma_item")
        var element = document.getElementById("raise_btn");
        element.setAttribute("data-proforma_item", proforma_item);
        element.setAttribute("data-wrc_id", wrc_id);
        
        console.log('element', element)
        console.log('proforma_item', proforma_item)

        const wrc_number = $("#"+data_id).data("wrc_number")
        const modeofdelivary_is = $("#"+data_id).data("modeofdelivary_is")
        const market_place = $("#"+data_id).data("market_place")
        const brand_name = $("#"+data_id).data("brands_name")
        const lot_number = $("#"+data_id).data("lot_number")
        const company = $("#"+data_id).data("company")
        const tot_sku = $("#"+data_id).data("sku_qty") 
        const work_start_date = $("#"+data_id).data("work_start_date")
        
        const final_link_list = $("#"+data_id).data("final_link_list")
        const catalog_links = $("#"+data_id).data("catalog_links")
        const copy_links = $("#"+data_id).data("copy_links")
        const allo_users_id = $("#"+data_id).data("allo_users_id")
        const allocated_users_name = $("#"+data_id).data("allocated_users_name")
        const user_roles = $("#"+data_id).data("user_roles")+''

        const alloacte_to_copy_writer = $("#"+data_id).data("alloacte_to_copy_writer")
        const cataloger_allocated_qty = $("#"+data_id).data("cataloger_allocated_qty")
        const cp_allocated_qty = $("#"+data_id).data("cp_allocated_qty")

        const final_link_list_arr = final_link_list.split(',')
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

        const catalog_allocation_id_arr = catalog_allocation_ids.split(',')
        if(modeofdelivary_is == 'Uploading'){
            $("#market_place_row").removeClass("d-none");
            let list = "";
            await $.ajax({
                url: "{{ url('get-Sub-Marketplace-count')}}",
                type: "POST",
                dataType: 'json',
                data: {
                    allocation_ids,
                    market_place : market_place,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // console.log(response)
                    // response.map(data => {
                    for (const property in response) {
                        const data  = response[property]
                        console.log(data)
                        const marketPlace_id = data.marketplace_id

                        // const uploaded_Marketplace_id = data.uploaded_Marketplace_id == null ? 0 : data.uploaded_Marketplace_id;
                        const marketPlace_name = data.marketPlace_name == null ? '' : data.marketPlace_name;
                        const approved_Count = data.approved_Count == null ? '' : data.approved_Count;
                        const rejected_Count = data.rejected_Count == null ? '' : data.rejected_Count;
                        const upload_date = data.upload_date == null ? '' : data.upload_date;

                        list += 
                            `<div class="row mb-2" id="marketplace_row${data.id}">
                                <div class="col-sm-3 col-12">
                                    <div class="col-ac-details">
                                        <h6>${data.marketPlace_name}</h6>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-6">
                                    <div class="col-ac-details">
                                        <input type="text" readonly placeholder="Add Approved Count" id="approved_Count${marketPlace_id}" name="approved_Count${marketPlace_id}" value="${approved_Count}" onKeyPress="return isNumber(event);" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-6">
                                    <div class="col-ac-details">
                                        <input type="text" readonly placeholder="Add Rejected Count" id="rejected_Count${marketPlace_id}" name="rejected_Count${marketPlace_id}" value="${rejected_Count}" onKeyPress="return isNumber(event);" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-6">
                                    <div class="col-ac-details">
                                        <input type="date" readonly placeholder="Select Date"  id="upload_date${marketPlace_id}" name="upload_date${marketPlace_id}" value="${upload_date}" autocomplete="off">
                                    </div>
                                </div>              
                            </div>`;
                    }

                    document.getElementById("marketplace_list_div").innerHTML = list;

                    // if(time_has_data.task_status > 0){
                    //     $("#btn_save").css("display", "none");
                    //     $("#btn_comp").css("display", "none");
                    // }
                }
            });
           
        }else{ // not a uploading
            $("#link_row").removeClass("d-none");
            let catalog_li = "";
            let copy_li = "";
            final_link_list_arr.forEach((link , index) => {
                if(link != ''){
                    const user_roles_is = user_roles_arr[index];
                    const allocated_users_is = allocated_users_arr[index];
                    const catalog_allocation_id_is = catalog_allocation_id_arr[index];
                    console.log({user_roles_is , allocated_users_is , link })

                    if(alloacte_to_copy_writer === 1 && user_roles_is == 1){
                        copy_li += `<p class="pointer m-0"> <span title="uploaded by ${allocated_users_arr[index]}" id="p_${catalog_allocation_id_is}">${link}  </span> <i class="fa fa-copy" id="i_p_${catalog_allocation_id_is}" onclick="copyToClipboard('p_${catalog_allocation_id_is}')"></i></p>`
                    }else{
                        catalog_li += `<p class="pointer m-0"> <span title="uploaded by ${allocated_users_arr[index]}" id="p_${catalog_allocation_id_is}">${link}  </span> <i class="fa fa-copy" id="i_p_${catalog_allocation_id_is}" onclick="copyToClipboard('p_${catalog_allocation_id_is}')"></i></p>`
                    }
                }
            });

            // catalog_link_arr.forEach((link , index) => {
            //     // console.log({link , index })
            //     if(link != ''){
            //         console.log(user_roles_arr[index])
            //         catalog_li +=   `<p class="pointer m-0" title="uploaded by ${allocated_users_arr[index]} ${ user_roles_arr[index] == 0 ? '' : ' (Copy Writer)'} "> ${link} <i class="fa fa-copy"></i></p>`
            //     }
            // });
            document.getElementById("link_to_cata_logure").innerHTML = catalog_li;
            
            if(alloacte_to_copy_writer === 1){
                // let copy_li = "";
                // copy_links_arr.forEach((link , index) => {
                //     console.log({link , index })
                //     if(link != ''){
                //         console.log(user_roles_arr[index])
                //         copy_li +=   `<p class="pointer m-0" title="uploaded by ${allocated_users_arr[index]} ${ user_roles_arr[index] == 1 ? '' : ' (Catalogure)'} ">${link} <i class="fa fa-copy"></i></p>`
                //     }
                // });
                document.getElementById("link_to_copy_writer").innerHTML = copy_li;
                document.getElementById("allo_qty_to_copy").innerHTML = cp_allocated_qty;
                $("#copy_row").removeClass("d-none");
                $("#copy_qty_div").removeClass("d-none");
                $("#link_copy_writer_row").removeClass("d-none");
            }
        }

        // submit btn validation
        let btn_disable = false;
        if((tot_sku > cataloger_allocated_qty) || (alloacte_to_copy_writer === 1 && tot_sku >= cp_allocated_qty) ){
            btn_disable = true;
            $("#submit_wrc").attr("title", "Wrc quantity and allocated quantity not same");
        }

        $("#submit_wrc").attr("disabled", true);
        if(btn_disable === false){
             $("#submit_wrc").removeAttr("title");
             $("#submit_wrc").removeAttr("disabled");
        }
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
        }, 1500)
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

{{-- script for save data to rewrok   --}}
<script>
    async function save_data(){
        const wrc_id = document.querySelector("#wrc_id").value  
        const batch_no = document.querySelector("#batch_no").value  
        const catalog_allocation_ids = document.querySelector("#catalog_allocation_ids").value  
        console.warn({wrc_id})
        // return

        // if(catalog_allocation_id == 0 || catalog_allocation_id ==''){
        //     alert('User Was Not Selected ');
        //     $("#catalog_copy_user").focus();
        //     return
        // }
        await $.ajax({
            url: "{{ url('comp-submission')}}",
            type: "POST",
            dataType: 'json',
            data: {
                wrc_id,
                batch_no,
                catalog_allocation_ids,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                if(res.status == 1){
                    $("#msg_box").css("color", "green");
                }else if(res.status == 2){
                    $("#msg_box").css("color", "Blue");
                    
                }else if(res.status == 3){
                    $("#msg_box").css("color", "Blue");
                    
                }else if(res.status == 4){
                    $("#msg_box").css("color", "Blue");
                }else{
                    $("#msg_box").css("color", "red");
                }

                // msg_div msg_box
                document.querySelector("#msg_box").innerHTML = res.massage
                $("#msg_div").css("display", "Block");
            }
        });
        setTimeout( () => {
            $("#msg_div").css("display", "none");
            $('#msg_box').html("");
        }, 3000);
    }
</script>

<!-- Raise script -->
<script>
    async function Raise(obj) {
        var wrc_id = $(obj).data('wrc_id');
        var pt = $(obj).data('proforma_item');
        var ser = '3';
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        await $.ajax({
            url: "{{ url('raise-for-inovice')}}",
            type: "POST",
            dataType: 'html',
            data: {
                wrc_id: wrc_id, 
                pt:pt,
                ser:ser,
                _token: '{{ csrf_token() }}'
            },
            success: function(htmlData) {
                console.log('htmlData', htmlData)
                window.location.reload();
            }
        });

        // $.ajax({
        //     headers: headers,
        //     url: "/raise-for-inovice",
        //     method: 'POST',
        //     dataType: "html",
        //     data: {wrc_id: wrc_id, pt:pt,ser:ser},
        //     success: function (htmlData) {
        //       window.location.reload();
        //     }
        // });
    }
</script>
@endsection