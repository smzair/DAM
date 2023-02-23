@extends('layouts.admin')

@section('title')
Upload/Tasking Panel
@endsection

@section('content')
<div class="container-fluid mt-5 plan-shoot new-allocation-table-main">
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
                    <div  id="msg_div" style="display: none" class="alert mb-0 p-4 " role="alert">
                            <p id="msg_box"> </p>  
                    </div>
                </div>

                <div class="card-header">
                    <h3 class="card-title">Editor's Panel</h3>
                </div>
                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
                    
                    <table id="allocTableCat" class="table table-head-fixed text-nowrap data-table">
                        <thead>
                            <tr>
                                <th class="cls_wrc_number">WRC Number
                                    <input type="hidden" name="login_user_id_is" value="{{$login_user_id_is}}">
                                </th>
                                <th class="cls_comp_name">Company Name</th>
                                <th class="cls_brand_name">Brand Name</th>
                                <th>Order Qty</th>
                                <th>Document</th>
                                <th>Upload</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                // $allocated_wrcs = array_column($allocated_wrc_list_by_user, 'wrc_id');
                                // pre($allocationList);
                            @endphp
                             
                            @foreach($allocationList as $allocationkey => $row)
                                @php
                                    $allocation_id =  $row['allocation_id_is'];
                                    $wrc_id =  $row['wrc_id'];
                                    $commercial_id =  $row['commercial_id'];
                                    $lot_id =  $row['lot_id'];

                                    // $allocated_wrcs_is = array_intersect($allocated_wrcs,array($wrc_id));
                                    
                                    $allocated_data_arr = $row;
                                    $allocated_qty = $row['allocated_qty'];

                                    $display_date_time = "display:none;";
                                    $display_start     = "display:block;";
                                    $btn_disable       = "";

                                    $extra = "";
                                    
                                    
                                    // if($time_hash_id > 0 && $is_started == 0 && $is_rework == 0){
                                    //     $display_pause = "";
                                    //     $display_start = "display:none;";
                                    // $btn_disable = "";

                                    // }
                                    // if($time_hash_id > 0 && $is_rework == 0){
                                    //     $start_btn_text = "Continue";
                                    // $btn_disable = "";
                                    // }else if( $time_hash_id > 0 && $is_rework == 1){
                                    //     $start_btn_text = "Start Rework";
                                    //     $display_pause = "display:none;";
                                    //     $display_start = "";
                                    // }

                                    // if($time_hash_id > 0 && $task_status > 0){
                                    //     $display_pause = "display:none;";
                                    //     $display_start = "display:none;";
                                    // }
                                
                                @endphp
                                <tr>
                                    <td class="cls_wrc_number">{{ $row['wrc_number'] }}</td>
                                    
                                    <td class="cls_comp_name">{{ $row['Company'] }}</td>
                                    <td class="cls_brand_name">{{ $row['brand_name'].$extra }}</td>
                                    <td>{{ $allocated_qty }}</td>
                                    {{-- Guidelines Links --}}
                                    <td>
                                        @if ($row['documentType'] == 0)
                                            <a target="_blank" href="{{$row['documentUrl']}}">Image Received Link</a>
                                        @else
                                            <a href="{{ asset('/storage/Uploaded_SKU') }}{{"/".$row['documentUrl']}}" download >Download Excel</a>
                                        @endif
                                        {{-- <li><a target="_blank" href="{{ $row['img_as_per_guidelines'] }}" class="work-link">Link</a></li> --}}
                                    </td>
                                    
                                    {{-- Upload market_place --}}
                                    <td>
                                        <p id="data{{ $allocation_id }}" 
                                        data-type_of_service="{{$allocated_data_arr['type_of_service']}}" 
                                        data-wrc_number="{{$allocated_data_arr['wrc_number']}}"   
                                        data-company="{{$row['Company']}}"   
                                        data-brand_name="{{$row['brand_name']}}"   
                                        data-allocated_qty_is="{{$allocated_qty}}"   
                                        style="display: none"></p>

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
                        <div class="col-sm-4 col-12">
                            <div class="col-ac-details">
                                <h6>Brand Name</h6>
                                <p id="brndName"></p>
                            </div>
                        </div>
                        
                        <div class="col-sm-4 col-12">
                            <div class="col-ac-details">
                                <h6>Type of Service</h6>
                                <p id="typeofService"></p>
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
                                <input type="hidden" name="allocated_qty_is" id="allocated_qty_is">
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
        $("#btn_save").css("display", "block");
        $("#btn_comp").css("display", "block");
        document.getElementById("workdetailsform").reset()
       
        const data_id = 'data'+params;
        const type_of_service = $("#"+data_id).data('type_of_service');
        const wrc_number = $("#"+data_id).data('wrc_number');
        const brand_name = $("#"+data_id).data('brand_name');
        const company = $("#"+data_id).data('company');
        const allocated_qty_is = $("#"+data_id).data('allocated_qty_is');
        let api_url = "";

        document.getElementById("allocation_id_is").value = params;
        document.getElementById("allocated_qty_is").value = allocated_qty_is;
        document.querySelector("#typeofService").innerHTML = type_of_service
        document.querySelector("#wrcNo").innerHTML = wrc_number 
        document.querySelector("#brndName").innerHTML = brand_name

        $("#link_row").removeClass("d-none");
        await $.ajax({
            url: "{{ url('get-editing_upload_links')}}",
            type: "POST",
            dataType: 'json',
            data: {
                allocation_id : params,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                if(res == 0){
                    document.querySelector("#btn_save").innerHTML = "save";
                }else{
                    document.querySelector("#btn_save").innerHTML = "update";
                    document.querySelector("#final_link").value = res[0].final_link
                    task_status = res[0].task_status
                    if(task_status > 0){
                        $("#btn_save").css("display", "none");
                        $("#btn_comp").css("display", "none");
                    }
                }
            }
        });
    }
</script>

{{-- formvalidate --}}
<Script>
    async function formvalidate(action){
        // Cataloguer / CW  
        const user_role = '{{ $user_role }}'
        const allocation_id_is  = $("#allocation_id_is").val()
        const final_link  = $("#final_link").val()

        console.log({user_role,allocation_id_is,final_link})
        if(final_link == ''){
            alert('Final Link in required ');
            $( "#final_link" ).focus();
            return
        }
        await $.ajax({
            url: "{{ url('Editing-upload-link') }}",
            type: "POST",
            dataType: 'json',
            data: {
                allocation_id_is: allocation_id_is,
                final_link: final_link,
                action,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                console.log(res)
                if(res?.status > 0){
                    const status = res.status

                    $("#msg_box1").css("color", "green");
                    document.querySelector("#btn_save").innerHTML = "update";
                    if(res?.up_status == 1){
                        document.querySelector("#msg_box1").innerHTML = " link Saved Successfully";
                    }else{
                        document.querySelector("#msg_box1").innerHTML = " link Updated Successfully";
                    }
                    
                    if(res.task_status == 1){
                        document.querySelector("#msg_box1").innerHTML = " WRC Completed Successfully";
                        $("#btn_save").css("display", "none");
                        $("#btn_comp").css("display", "none");
                    }
                }else{
                    document.querySelector("#msg_box1").innerHTML = " somthing Went Wrong";
                    $("#msg_box1").css("color", "red");
                }
                $("#msg_box1").css("display", "block");
            }
        });
        setTimeout( () => {
            $(".msg_box").css("display", "none");
            $('#msg_box1').html("");
        }, 2000);
    }
</Script>
@endsection