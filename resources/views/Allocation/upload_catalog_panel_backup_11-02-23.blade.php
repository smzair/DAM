@extends('layouts.admin')

@section('title')
Cataloger Panel
@endsection

@section('content')
<div class="container-fluid mt-5 plan-shoot new-allocation-table-main">

    <style type="text/css">

  
    

    /* .info-list > li {
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
    } */


</style>
<style> 

    .Credentials , .cls_wrc_number , .cls_comp_name , .cls_brand_name {
        /* display: none; */
    }
        .msg_box{
        margin: 0.1em 0;
        background: #d2c9c9fc;
        display: none;
        width: 100%;
        padding: 0.3em;
    }

    @media (min-width: 992px){
        .modal-lg, .modal-xl{
            max-width: 900px;
        }
    }
</style>
    <div class="row">
        <div class="col-12">
            <div class="card card-transparent">
                @php
                    
                    $show_td = 0;
                    if($user_role == 'Cataloguer'){
                        $show_td = 1;
                        $td_head = "Assigned Copy Writers";
                    }else{
                        $show_td = 2;
                        $td_head = "Assigned Cataloguers";
                    }
                @endphp

                    <div style="width: 100%"> 
                       {{-- <div   id="msg_div" style="" class="alert alert-danger mb-0" role="alert"> --}}
                       <div  id="msg_div" style="display: none" class="alert mb-0 p-4 " role="alert">
                             <p id="msg_box"> </p>  
                        </div>
                    </div>
                

                <div class="card-header">
                    <h3 class="card-title">{{ $user_role }} Panel</h3>
                </div>
               
                <!-- /.card-header msg_div msg_box  -->
                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
                    
                    
                    <table id="allocTableCat" class="table table-head-fixed text-nowrap data-table">
                        <thead>
                            <tr>
                                <th class="cls_wrc_number">WRC Number
                                    <input type="hidden" name="login_user_id_is" value="{{$login_user_id_is}}">
                                </th>
                                <th>Batch Number</th>
                                <th class="cls_comp_name">Company Name</th>
                                <th class="cls_brand_name">Brand Name</th>
                                <th>Mode Of Delivary</th>
                                <th class="Marketplace">Marketplace</th>
                                <th class="Credentials">Credentials</th>
                                <th>Order Qty</th>
                                {{-- <th>SKU Count</th> --}}
                                <th>{{ $td_head }}</th>
                                <th>Guidelines Links</th>
                                <th>Time Spent</th>
                                <th>Action</th>
                                <th>Upload</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $second = 26584;
                                $modeOfDelivary_arr = modeOfDelivary();
                                $getMarketPlace = getMarketPlace();
                                $MarketPlace_array_list = array_column($getMarketPlace, 'marketPlace_name','id');
                                
                                $commercial_wise_MarketplaceCredentials_list = commercial_wise_MarketplaceCredentials_list();
                                $Mar_place_cre_array_1 = array_column($commercial_wise_MarketplaceCredentials_list, 'commercial_id');
                                
                                $getcopyWriter_array = getcopyWriter();
                                $getcopyWriter = array_column($getcopyWriter_array, 'name','id');

                                $getCataloguer = getCataloguer();
                                $Cataloguers = array_column($getCataloguer, 'name','id');

                                $allocated_wrc_batch = array_column($allocated_wrc_list_by_user, 'batch_no');
                                $allocated_wrcs = array_column($allocated_wrc_list_by_user, 'wrc_id');

                                // pre($allocated_wrc_list_by_user[6]);
                                // pre($allocated_wrcs);
                                // pre($allocated_wrc_batch);
                            @endphp
                             
                            @foreach($allocationList as $allocationkey => $row)
                            @php
                                $allocation_id =  $row['allocation_id_is'];
                                $wrc_id =  $row['wrc_id'];
                                $commercial_id =  $row['commercial_id'];
                                $lot_id =  $row['lot_id'];
                                $batch_no =  $row['batch_no'];
                                $market_place = $row['market_place'];

                                $market_place_ids = explode(',',$row['market_place']);
                                $modeOfDelivary =  $row['modeOfDelivary'];
                                $modeOfDelivary_is = $modeOfDelivary_arr[$modeOfDelivary];

                                $allocated_wrcs_is = array_intersect($allocated_wrcs,array($wrc_id));
                                
                                foreach ($allocated_wrcs_is as $key => $value) {
                                    if($allocated_wrc_batch[$key] == $batch_no){
                                        $ass_cataloger = $allocated_wrc_list_by_user[$key]['ass_cataloger'];
                                        $user_roles = $allocated_wrc_list_by_user[$key]['user_roles'];
                                        break ;
                                    }
                                }
                                
                                $ass_cataloger_list = explode(',',$ass_cataloger);
                                $user_roles_list = explode(',',$user_roles);
                               
                                $allocated_data_arr = $row;
                                
                                $time_hash_id  =  $row['time_hash_id'];
                                $is_rework     =  $row['is_rework'];
                                $task_status   =  $row['task_status'];
                                $rework_count  =  $row['rework_count'];
                                $start_time    =  $row['start_time'];
                                $end_time      =  $row['end_time'];
                                $is_started    =  $row['is_started'];

                                $allocated_qty = $row['allocated_qty'];
                                $end_time_is = $spent_time =  $row['spent_time'];

                                $spent_time_is = ($spent_time != 0 && $spent_time != "") ? get_date_time($spent_time) : "";

                                $start_time_is     = "";
                                $display_date_time = "display:none;";
                                $display_start     = "display:block;";
                                $btn_disable       = "disabled";

                                $extra = "";
                                $display_start = "";
                                $display_pause = "display:none;";
                                $start_btn_text = "Start";
                                
                                if($time_hash_id > 0){
                                    $start_btn_text = "continue";
                                }

                                if($time_hash_id > 0 && $is_started == 0  ){
                                    $display_pause = "";
                                    $display_start = "display:none;";
                                }


                                if($time_hash_id > 0 && $task_status == 1){
                                    $display_pause = "display:none;";
                                    $display_start = "display:none;";

                                    if($is_rework == 1){
                                        $display_start = "";
                                    }
                                }


                               if(($time_hash_id > 0 && (($task_status == 0 && $is_rework == 0) || ($task_status == 1 && $is_rework == 0) || $task_status == 2  )) ){
                                   $btn_disable = "";
                                    // $display_start = "display:none;";
                                    // $display_start = "display:none;";

                                    // $display_pause = "";
                                    
                                    // $display_date_time = "display:block;";
                                    $start_time_is = date('d-m-Y h:i:s A' , strtotime($start_time));
                               }

                               if($allocation_id == 1 || $allocation_id == 4){
                                    // pre($row);
                                }
                            @endphp
                            <tr>
                                <td class="cls_wrc_number">{{ $row['wrc_number'] }}</td>
                                <td>
                                    <?php echo $row['batch_no'] > 0 ? $row['batch_no'] : 'None' ;?>
                                </td>
                                <td class="cls_comp_name">{{ $row['Company'] }}</td>
                                <td class="cls_brand_name">{{ $row['brand_name'].$extra }}</td>
                                <td>{{ $modeOfDelivary_is }}</td>
                                
                                <td class="Marketplace"> 
                                   <?php 
                                   $kind_of_work = "";
                                    if($modeOfDelivary_is == 'Uploading'){
                                        $Uploading_market_place_list = array_intersect($Mar_place_cre_array_1,array($commercial_id));
                                        foreach ($Uploading_market_place_list as $key => $array_index) {
                                            $Up_mar_cre_arr = $commercial_wise_MarketplaceCredentials_list[$key];
                                            echo "<p class='m-0'>".$Up_mar_cre_arr['marketPlace_name']. " ( ".$Up_mar_cre_arr['link']." )</p>";

                                            $kind_of_work .= $Up_mar_cre_arr['marketPlace_name'].", ";
                                        }
                                    }else{  ?>
                                        @foreach ($market_place_ids as $mp_id)
                                            <p class="m-0">{{ $MarketPlace_array_list[$mp_id] }}</p>
                                            @php
                                                $kind_of_work .= $MarketPlace_array_list[$mp_id].", ";
                                            @endphp
                                        @endforeach
                                    <?php } 
                                    $kind_of_work = rtrim($kind_of_work,", ")
                                    ?> 
                                </td>
                                <td class="Credentials"> 
                                    <?php 
                                        if($modeOfDelivary_is == 'Uploading'){
                                            $Uploading_market_place_list = array_intersect($Mar_place_cre_array_1,array($commercial_id));
                                            foreach ($Uploading_market_place_list as $key => $array_index) {
                                                $Up_mar_cre_arr = $commercial_wise_MarketplaceCredentials_list[$key];
                                                echo "<p class='m-0'>Username => ".$Up_mar_cre_arr['username']. " | password => ".$Up_mar_cre_arr['password']."</p>";
                                            }
                                        }
                                    ?>    
                                </td>
                                <td>{{ $allocated_qty }}</td>
                                <td>
                                    <ul class="info-list">
                                        {{-- Assigned Cataloguers --}}
                                        @if ($show_td == 2)
                                            @foreach ($ass_cataloger_list as $key => $user_id)
                                                <?php 
                                                $user_role_is = $user_roles_list[$key];
                                                if($user_role_is == 0){   ?>
                                                    <li><span class="gd-name"><?=  $Cataloguers[$user_id] ?></span></li>
                                                <?php }  ?>
                                            @endforeach
                                        @endif

                                        {{--Assigned Copy Writers --}}
                                        @if ($show_td == 1)
                                            @foreach ($ass_cataloger_list as $key => $user_id)
                                                <?php 
                                                $user_role_is = $user_roles_list[$key];
                                                if($user_role_is == 1){   ?>
                                                    <li><span class="gd-name"><?=  $getcopyWriter[$user_id] ?></span></li>
                                                <?php }  ?>
                                            @endforeach

                                        @endif
                                    </ul>
                                </td>
                                {{-- Guidelines Links --}}
                                <td>
                                  <ul class="info-list">
                                    <li><a href="{{ $row['work_brief'] }}" class="work-link">Link</a></li>
                                    <li><a href="{{ $row['guidelines'] }}" class="work-link">Link</a></li>
                                    <li><a href="{{ $row['document1'] }}" class="work-link">Link</a></li>
                                    <li><a href="{{ $row['document2'] }}" class="work-link">Link</a></li>
                                  </ul>
                                </td>

                                {{-- time_spant --}}
                                <td >
                                    <p id="time_spant{{ $allocation_id }}">
                                        {{ $spent_time_is }}
                                    </p>
                                </td>
                                {{-- action --}}
                                <td>
                                  <div class="task-action task-start-button" >
                                    <a href="javascript:;" style="{{ $display_start }}" class="btn btn-warning" onclick="start_task('{{ $allocation_id }}')" id="startBTN{{ $allocation_id }}" >
                                      {{ $start_btn_text }}
                                    </a>

                                    <a href="javascript:;" style="{{ $display_pause }}" class="btn btn-warning" onclick="Pause_task('{{ $allocation_id }}')" id="pauseBTN{{ $allocation_id }}" >
                                      Pause
                                    </a>
                                  </div>

                                    <div class="task-action task-start-timings" id="show_date_time{{ $allocation_id }}"  style="{{$display_date_time}}"> {{ $start_time_is }}
                                    
                                    </div>
                                </td>
                                {{-- Upload market_place --}}
                                <td>
                                    <p id="data{{ $allocation_id }}" 
                                    data-project_type="{{$allocated_data_arr['project_type']}}" 
                                    data-wrc_number="{{$allocated_data_arr['wrc_number']}}"   
                                    data-kind_of_work="{{$kind_of_work}}"   
                                    data-modeOfDelivary_is="{{$modeOfDelivary_is}}"   
                                    data-market_place="{{$market_place}}"   
                                    data-company="{{$row['Company']}}"   
                                    data-brand_name="{{$row['brand_name']}}"   
                                    data-start_date="{{$start_time_is}}"   
                                    style="display: none"></p>

                                    @if ($modeOfDelivary_is == 'Uploading')
                                        {{-- <button  class="btn btn-warning alloc-action-btn inactive" id="uploadBTn{{ $allocation_id }}" data-toggle="modal" data-target="#editpanelPopupCat" {{ $btn_disable }}  onclick="set_data('{{ $allocation_id }}')">
                                            Upload Uploading
                                        </button> --}}
                                        
                                    @else
                                    @endif
                                    <button  class="btn btn-warning alloc-action-btn inactive" id="uploadBTn{{ $allocation_id }}" data-toggle="modal" data-target="#editpanelPopupCat" {{ $btn_disable }}  onclick="set_data('{{ $allocation_id }}')">
                                        Upload
                                    </button>
                                    
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

<div class="modal fade" id="editpanelPopupCat">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h4 class="modal-title">Uploading Panel - {{ $user_role }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="custom-dt-row work-details">
                    <div class="row">
                        <div class="col-sm-4 col-12">
                            <div class="col-ac-details">
                                <h6>WRC Number</h6>
                                <p id="wrcNo"></p>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="col-ac-details">
                                <h6>Brand Name</h6>
                                <p id="brndName"></p>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="col-ac-details">
                                <h6>Start Date</h6>
                                <p id="startDate"></p>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="col-ac-details">
                                <h6>Project Type</h6>
                                <p id="projectType"></p>
                            </div>
                        </div> 
                        <div class="col-sm-4 col-6">
                            <div class="col-ac-details">
                                <h6>Kind of Work</h6>
                                <p id="kindOfWork"></p>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="col-ac-details">
                                <h6>Mode of Delivery</h6>
                                <p id="mode_of_Delivery"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="custom-dt-row">
                    <form class="" method="POST" action="" id="workdetailsform" autocomplete="off">
                        {{-- Link Row --}}
                        <div class="row" id="link_row">

                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="control-label required"> Final Link</label>
                                    <input autocomplete="off" type="text" class="form-control" name="final_link" id="final_link" placeholder="Add Link ">
                                </div>
                            </div>
                            <div class="col-sm-6 col-12 d-none">
                                <div class="form-group">
                                    <label class="control-label <?php echo $user_role == 'Cataloguer' ? 'required' : ''  ?>"> Cataloguer Link</label>
                                    <input type="text" class="form-control" name="workLink1" id="workLink1" placeholder="Link" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-6 col-12 d-none">
                                <div class="form-group">
                                    <label class="control-label  <?php echo $user_role == 'CW' ? 'required' : ''  ?> "> CW Link</label>
                                    <input type="text" class="form-control" name="workLink2" id="workLink2" placeholder="Link" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        {{-- Marketplace row --}}
                        <div class="row mt-3" id="market_place_row">
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

                        {{-- Save and complte Button row --}}
                        <div class="row mt-4">
                            <div class="col-sm-6 col-12">
                                <div class="custom-info">
                                  <p>Please mark the WRC as complete only after you have uploaded the corresponding documents.</p>
                                </div>
                            </div>

                            <div class="col-sm-6 col-12"  style="position: relative;" >
                                <input type="hidden" name="allocation_id_is" id="allocation_id_is">
                                <input type="hidden" name="market_place_id_is" id="market_place_id_is">
                                <input type="hidden" name="mode_of_Delivery_is" id="mode_of_Delivery_is">
                                <button type="button" id="btn_comp" class="btn btn-warning" name="comp_wrc" value="comp_wrc" style="float:right; margin: 0 5px;" onclick="formvalidate('comp')">Complete Wrc</button>

                                <button type="button" id="btn_save" class="btn btn-warning" style="float:right; margin: 0 5px;"  onclick="formvalidate('save')"  name="save_wrc" value="save_wrc">Save</button>
                                
                            </div>
                             <p class="msg_box" id="msg_box1" style="display: none;"></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTable Plugins Path -->

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<!-- End of DataTable Plugins Path -->

<script>
    $('#allocTableCat').DataTable({
          dom: 'lBfrtip',
          "lengthMenu": [ 5, 25, 50, -1], [10, 25, 50, "All"],
          "buttons": ["copy", "csv", "excel", "pdf"]
    }).buttons().container().insertAfter('#masterData_wrapper .dataTables_length');

    $('.task-start-button .btn').click(function(){
      $(this).parent('.task-start-button').next('.task-start-timings').css('display', 'block');
      $(this).css('display', 'none');
      $(this).parents('td').siblings('td').find('.alloc-action-btn').removeClass('inactive');
    });
</script>

{{-- set_data --}}
<script>
    async function set_data(params) {
        $("#link_row").addClass("d-none");
        $("#market_place_row").addClass("d-none");
        $("#btn_save").css("display", "block");
        $("#btn_comp").css("display", "block");
        document.getElementById("workdetailsform").reset()

        // market_place_row  link_row 
        // debugger 

        const data_id = 'data'+params;
        const time_spant = 'time_spant'+params;
        const project_type = $("#"+data_id).data('project_type');
        const wrc_number = $("#"+data_id).data('wrc_number');
        const kind_of_work = $("#"+data_id).data('kind_of_work');
        const brand_name = $("#"+data_id).data('brand_name');
        const company = $("#"+data_id).data('company');
        const startDate = $("#"+data_id).data('start_date');
        const modeofdelivary_is = $("#"+data_id).data('modeofdelivary_is');
        const market_place = $("#"+data_id).data('market_place');
        let api_url = "";
        

        console.log({data_id, modeofdelivary_is , kind_of_work }) 

        document.getElementById("allocation_id_is").value = params;
        document.getElementById("market_place_id_is").value = market_place;
        document.getElementById("mode_of_Delivery_is").value = modeofdelivary_is;
        document.querySelector("#projectType").innerHTML = project_type
        document.querySelector("#wrcNo").innerHTML = wrc_number 
        document.querySelector("#kindOfWork").innerHTML =  kind_of_work
        document.querySelector("#brndName").innerHTML = brand_name
        document.querySelector("#startDate").innerHTML = startDate
        document.querySelector("#mode_of_Delivery").innerHTML =  modeofdelivary_is

        document.querySelector("#workLink1").value = "";
        document.querySelector("#workLink2").value = "";

        if(modeofdelivary_is == 'Uploading'){
            $("#market_place_row").removeClass("d-none");
            let list = "";
            await $.ajax({
                url: "{{ url('get-uploaded_Marketplace_count')}}",
                type: "POST",
                dataType: 'json',
                data: {
                    allocation_id : params,
                    market_place : market_place,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    const {response , time_has_data} = res;
                    // console.log(response)
                    // console.log(time_has_data)
                    const uploaded_Marketplace_id = response[0]['uploaded_Marketplace_id'];
                    let btn_save = 'save';
                    if(uploaded_Marketplace_id > 0){
                        btn_save = 'update';
                    }

                    document.querySelector("#btn_save").innerHTML = btn_save;

                    response.map(data => {
                        console.log(data)
                        const marketPlace_id = data.marketplace_id

                        const uploaded_Marketplace_id = data.uploaded_Marketplace_id == null ? 0 : data.uploaded_Marketplace_id;
                        const marketPlace_name = data.marketPlace_name == null ? '' : data.marketPlace_name;
                        const approved_Count = data.approved_Count == null ? '' : data.approved_Count;
                        const rejected_Count = data.rejected_Count == null ? '' : data.rejected_Count;
                        const upload_date = data.upload_date == null ? '' : data.upload_date;

                        list += 
                            `<div class="row mb-2" id="marketplace_row${data.id}">
                                <div class="col-sm-3 col-12">
                                    <div class="col-ac-details">
                                        <input type="hidden" name="marketPlace_id${marketPlace_id}" id="marketPlace_id${marketPlace_id}"  value="${marketPlace_id}">
                                        <input type="hidden" name="uploaded_Marketplace_id${marketPlace_id}" id="uploaded_Marketplace_id${marketPlace_id}"  value="${uploaded_Marketplace_id}">
                                        <h6>${data.marketPlace_name}</h6>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-6">
                                    <div class="col-ac-details">
                                        <input type="text" placeholder="Add Approved Count" id="approved_Count${marketPlace_id}" name="approved_Count${marketPlace_id}" value="${approved_Count}" onKeyPress="return isNumber(event);" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-6">
                                    <div class="col-ac-details">
                                        <input type="text" placeholder="Add Rejected Count" id="rejected_Count${marketPlace_id}" name="rejected_Count${marketPlace_id}" value="${rejected_Count}" onKeyPress="return isNumber(event);" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-6">
                                    <div class="col-ac-details">
                                        <input type="date" placeholder="Select Date"  id="upload_date${marketPlace_id}" name="upload_date${marketPlace_id}" value="${upload_date}" autocomplete="off">
                                    </div>
                                </div>              
                            </div>`;
                    })

                    document.getElementById("marketplace_list_div").innerHTML = list;

                    if(time_has_data.task_status > 0){
                        $("#btn_save").css("display", "none");
                        $("#btn_comp").css("display", "none");
                    }
                }
            });
        }else{ // not a uploading
            $("#link_row").removeClass("d-none");
            await $.ajax({
                url: "{{ url('get-catalog_upload_links')}}",
                type: "POST",
                dataType: 'json',
                data: {
                    allocation_id : params,
                    market_place : market_place,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    // console.log(res)
                    if(res == 0){
                        document.querySelector("#btn_save").innerHTML = "save";
                    }else{
                        document.querySelector("#btn_save").innerHTML = "update";
                        document.querySelector("#final_link").value = res[0].final_link
                        document.querySelector("#workLink1").value = res[0].catalog_link
                        document.querySelector("#workLink2").value = res[0].copy_link

                        end_time = res[0].end_time
                        task_status = res[0].task_status
                        spent_time_is = res[0].spent_time_is
                        if(task_status > 0){
                            $("#btn_save").css("display", "none");
                            $("#btn_comp").css("display", "none");
                        }
                    }
                }
            });
        }
    }
</script>

{{-- start_task --}}
<script>
   async function start_task(id){
        // console.log(id)pauseBTN
        allocation_id = id;
        const startBTN = 'startBTN'+allocation_id;
        const uploadBTn = 'uploadBTn'+allocation_id;
        const pauseBTN = 'pauseBTN'+allocation_id;
        const show_date_time = 'show_date_time'+allocation_id;
        const login_user_id_is = '{{$login_user_id_is}}';
        console.log(login_user_id_is);
         await $.ajax({
            url: "{{ url('set-catalog-allocation-start')}}",
            type: "POST",
            dataType: 'json',
            data: {
                allocation_id,
                login_user_id_is,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                console.log(res)
                // msg_div msg_box startBTN 
                btn_name = document.querySelector("#"+startBTN).innerHTML

                const msg_div = document.getElementById("msg_div");
                const msg_box = document.getElementById("msg_box");
                msg_div.classList.remove("alert-success");
                msg_div.classList.remove("alert-danger");
                msg_div.classList.remove("alert-warning");
                if(res?.status == true || res?.status == 1){
                    msg_div.classList.add("alert-success");
                    msg_box.innerHTML  = "Wrc "+btn_name+"!!";
                    $("#"+startBTN).css("display", "none");
                    // document.getElementById(show_date_time).innerHTML = res.start_time
                    document.getElementById('data'+allocation_id).dataset.start_date = res.start_time
                    // $("#"+show_date_time).css("display", "block");
                    $('#'+uploadBTn).prop('disabled', false);
                    $('#'+pauseBTN).css('display', 'block');
                }else if(res?.status == 2){
                    msg_div.classList.add("alert-warning");
                    msg_box.innerHTML  = "Wrc already started!! pause it first then "+btn_name+" this one";
                }else{
                    msg_div.classList.add("alert-danger");
                    msg_box.innerHTML  = "Somthing went Wrong !! Try again!!";
                }
                $("#msg_div").css("display", "block");
            }
        });
        setTimeout( () => {
            $("#msg_div").css("display", "none");
        }, 2000);
    }
</script>

{{-- Pause_task --}}
<script>
   async function Pause_task(id){
        // console.log(id)pauseBTN
        allocation_id = id;
        const startBTN = 'startBTN'+allocation_id;
        const uploadBTn = 'uploadBTn'+allocation_id;
        const pauseBTN = 'pauseBTN'+allocation_id;
        const show_date_time = 'show_date_time'+allocation_id;
         await $.ajax({
            url: "{{ url('set-catalog-allocation-pause')}}",
            type: "POST",
            dataType: 'json',
            data: {
                allocation_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                console.log(res)
                // msg_div msg_box startBTN 
                const msg_div = document.getElementById("msg_div");
                const msg_box = document.getElementById("msg_box");
                msg_div.classList.remove("alert-success");
                msg_div.classList.remove("alert-danger");
                msg_div.classList.remove("alert-warning");

                if(res.status == true || res.status == 1){
                    msg_div.classList.add("alert-success");
                    msg_box.innerHTML  = "Wrc Paused!!";
                    $("#"+startBTN).css("display", "block");
                    $('#'+pauseBTN).css('display', 'none');
                   
                    document.querySelector("#"+startBTN).innerHTML = 'Continue';
                    document.querySelector("#time_spant"+allocation_id).innerHTML = res.spent_time;
                }else{
                    msg_div.classList.add("alert-danger");
                    msg_box.innerHTML  = "Somthing went Wrong!! Try again!!";
                }
                $("#msg_div").css("display", "block");
            }
        });
        setTimeout( () => {
            $("#msg_div").css("display", "none");
        }, 2500);
    }
</script>

{{-- formvalidate --}}
<Script>
    async function formvalidate(action){
        // Cataloguer / CW  
        const user_role = '{{ $user_role }}'
        const allocation_id_is  = $("#allocation_id_is").val()
        const market_place_id_is  = $("#market_place_id_is").val()
        const mode_of_Delivery_is  = $("#mode_of_Delivery_is").val()
        const data_arr = [];

        const final_link  = $("#final_link").val()
        let workLink1  = $("#workLink1").val()
        let workLink2  = $("#workLink2").val()

        console.log({allocation_id_is , market_place_id_is , mode_of_Delivery_is })

        const market_place_id_arr = market_place_id_is.split(",");

       
        console.warn(action)

        if(mode_of_Delivery_is == 'Uploading'){
            market_place_id_arr.forEach(element_id => {
                const model_marketPlace_id = "marketPlace_id"+element_id
                const approved_Count_id = "approved_Count"+element_id
                const marketPlace_name_id = "marketPlace_name"+element_id
                const rejected_Count_id = "rejected_Count"+element_id
                const upload_date_id = "upload_date"+element_id
                const uploaded_Marketplace_id_id = "uploaded_Marketplace_id"+element_id

                // console.log({
                //     model_marketPlace_id,
                //     approved_Count_id,
                //     marketPlace_name_id,
                //     rejected_Count_id,
                //     upload_date_id,
                //     uploaded_Marketplace_id_id,
                // })
                
                // const marketPlace_name = document.getElementById(marketPlace_name_id).value
                const uploaded_Marketplace_id = document.getElementById(uploaded_Marketplace_id_id).value
                const marketPlace_id = document.getElementById(model_marketPlace_id).value
                const approved_Count = document.getElementById(approved_Count_id).value
                const rejected_Count = document.getElementById(rejected_Count_id).value
                const upload_date = document.getElementById(upload_date_id).value

                data_arr.push({
                    uploaded_Marketplace_id,
                    marketPlace_id,
                    approved_Count,
                    rejected_Count,
                    upload_date,
                })
            });

            await $.ajax({
                url: "{{ url('save-Marketplace-approved-Count') }}",
                type: "POST",
                dataType: 'json',
                 data: {
                    allocation_id_is,
                    data_arr,
                    market_place_id_is,
                    action,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    console.log(res)
                    const {resuploaded_Marketplace_id , response } = res

                    console.log(resuploaded_Marketplace_id)
                    if(res?.response == 1){
                        $("#msg_box1").css("color", "green");
                        document.querySelector("#btn_save").innerHTML = "update";

                        for (const id_is in resuploaded_Marketplace_id) {
                            // console.log(id_is)
                            const value_is  = resuploaded_Marketplace_id[id_is]
                            console.log({id_is ,value_is })
                            document.getElementById(id_is).value = value_is
                        }

                        if(res?.up_status == 1){
                            document.querySelector("#time_spant"+allocation_id_is).innerHTML = res.spent_time_is;
                            $("#btn_save").css("display", "none");
                            $("#btn_comp").css("display", "none");
                            $("#startBTN"+allocation_id_is).css("display", "none");
                            $("#pauseBTN"+allocation_id_is).css("display", "none");
                        }
                        
                    }else{
                        $("#msg_box1").css("color", "red");
                        res.massage  = "Somthing went Wrong please try again!!!"
                    }
                    document.querySelector("#msg_box1").innerHTML  = res.massage;
                    $("#msg_box1").css("display", "block");
                }
            });
        }else{

            if(final_link == ''){
                alert('Final Link in required ');
                $( "#final_link" ).focus();
                return
            }

            if(workLink1 == ''){
                workLink1 = final_link;
            }
            if(workLink2 == ''){
                workLink2 = final_link;
            }

            if(user_role == 'Cataloguer' && workLink1 == ''){
                alert('Cataloguer Link in required ');
                $( "#workLink1" ).focus();
                return
            }

            if(user_role == 'CW' && workLink2 == ''){
                alert('Copy Writer Link in required ');
                $( "#workLink1" ).focus();
                return
            }
            await $.ajax({
                url: "{{ url('catalog-upload-link') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    allocation_id_is: allocation_id_is,
                    final_link: final_link,
                    catalog_link: workLink1,
                    copy_link: workLink2,
                    action,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    console.log(res)
                    if(res?.status > 0){
                        const status = res.status

                        $("#msg_box1").css("color", "green");
                        if(status == 1){
                            document.querySelector("#btn_save").innerHTML = "update";
                            document.querySelector("#msg_box1").innerHTML = user_role +" link Saved Successfully";
                        }else{
                            document.querySelector("#btn_save").innerHTML = "update";
                            document.querySelector("#msg_box1").innerHTML = user_role+" link Updated Successfully";
                        }
                        
                        if(res.up_status == 1){
                            document.querySelector("#msg_box1").innerHTML = user_role+" WRC Completed Successfully";
                            // document.querySelector("#btn_save").innerHTML = "update";
                            console.warn(res.end_time)
                            document.querySelector("#time_spant"+allocation_id_is).innerHTML = res.spent_time_is;
                            $("#btn_save").css("display", "none");
                            $("#btn_comp").css("display", "none");
                            $("#startBTN"+allocation_id_is).css("display", "none");
                            $("#pauseBTN"+allocation_id_is).css("display", "none");
                        }
                    }else{
                            $("#msg_box1").css("color", "red");

                    }
                        $("#msg_box1").css("display", "block");
                }
            });
        }
        setTimeout( () => {
            $(".msg_box").css("display", "none");
            $('#msg_box1').html("");
        }, 2000);
    }
</Script>
@endsection