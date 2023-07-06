@extends('layouts.admin')

@section('title')
Upload/Tasking Panel
@endsection

@section('content')

<link rel="stylesheet" href="plugins/dropzone/dropzone.css">
<style>
    .card-primary:not(.card-outline)>.card-header a {
        color: #000;
    }

    .alert-dialog {
        background-color: #f4f4f4;
        color: #1f1f21;
    }

    .alert-dialog-title {
        font-weight: 400;
        font-weight: 400;
        font-size: 17px;
        font-weight: 500;
        padding: 0 8px;
        text-align: center;
        color: #1f1f21;
    }

    .alert-dialog-button--rowfooter {
        color: #0076ff;
        border-top: 1px solid #ddd;
        cursor: pointer;
    }

    .lot-popup-list ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .lot-popup-list > ul {
        display: block;
    }

    .lot-popup-list ul li {
        position: relative;
    }

    .lot-popup-list ul li a {
        text-decoration: none !important;
    }

    .lot-popup-list > ul {
        padding: 15px 0;
    }

    .lot-popup-list > ul li {
        font-size: 16px;
        line-height: 1.4;
    }

    .lot-popup-list > ul li > a {
        display: block;
        position: relative;
        color: #000;
        padding: 10px 0;
        font-weight: 500;
    }

    .lot-popup-list ul ul.submenu {
        display: none;
    }

    .child-trigger {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 42px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        cursor: pointer;
    }

    .child-trigger i.trigger-icon {
        margin-left: 5px;
        vertical-align: middle;
    }

    .child-trigger i.fa-plus {
        display: inline-block;
    }

    .child-trigger i.fa-minus {
        display: none;
    }

    .child-trigger.child-open i.fa-plus {
        display: none;
    }

    .child-trigger.child-open i.fa-minus {
        display: inline-block;
    }

    .lot-popup-list ul.submenu-wrapper ul {
        padding-left: 20px;
    }

    .wrc-cnt {
        display: inline-block;
    }

    .sku-cnt {
        display: none;
    }

    .img-cnt {
        display: none;
    }

    .lot-popup-list > ul li > span {
        display: block;
        position: relative;
        color: #000;
        padding: 6px 0;
        font-weight: 500;
        font-size: 13px;
    }

    .dropzone {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        position: relative;
        cursor: pointer;
        overflow: hidden;
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        max-height: 250px;
        height: auto;
        overflow-y: auto;
        padding: 5px 10px;
        font-size: 1.5rem;
        text-align: center;
        color: #ccc;
        background: #fff;
        box-shadow: none !important;
        min-height: 150px;
        border: 2px dashed rgba(128,128,128,0.35);
        border-radius: 5px;
        flex-wrap: wrap;
    }

    .uploader-pop {
        width: 100%;
        height: auto;
    }

    .dropzone .dz-message {
        width: 100%;
    }

    .image-uploader {
        position: relative;
    }

    .dz-started .drop-addicon {
        display: none;
    }

    .all-no-list {
        border-right: 1px solid rgba(0,0,0,.125);
    }

    .all-no-list li.list-group-item {
        padding: 0 !important;
    }

    a.list-links {
        color: inherit;
        display: block;
    }

    .all-no-list li.list-group-item .list-links {
        padding: .75rem 1.25rem;
        padding-left: 10px;
        padding-right: 10px;
        transition: all .2s;
    }

    .all-no-list li.list-group-item .list-links:hover {
        background-color: #ececec;
    }

    .arrow-right {
        float: right;
        font-size: 1.25rem;
        transition: all 0.3s;
    }

    .wrcs-no-list {
        display: none;
    }

    .skus-no-list {
        display: none;
    }

    .lots-no-list.list-collapse,
    .wrcs-no-list.list-collapse {
        -ms-flex: 0 0 60px;
        flex: 0 0 40px;
        max-width: 40px;
        overflow: hidden;
        position: relative;
        transition: all 0.4s ease-in-out;
    } 

    .lots-no-list.list-collapse h5,
    .wrcs-no-list.list-collapse h5 {
        transition: all 0.5s ease-in-out;
        min-width: 100%;
        text-align: center;
        position: absolute;
        right: 0;
        white-space: nowrap;
        top: 60%;
        bottom: 0;
        transform: translateY(-50%) rotate(-90deg);
        transform-origin: 0% 0%;
        width: 40px;
        height: 0;
    }

    .lots-no-list.list-collapse ul,
    .wrcs-no-list.list-collapse ul {
        display: none;
    }

    .collapse-icon {
        cursor: pointer;
        display: none;
        margin-left: 5px;
    }

    .image-list > li > a,
    .image-list-pop > li > a {
        display: inline-block;
    }

    .edit-tabl-link > .nav-item > a.nav-link {
        color: #fff !important;
        background-color: transparent !important;
        border: 0 !important;
    }

    .edit-tabl-link > .nav-item > a.nav-link:hover,
    .edit-tabl-link > .nav-item > a.nav-link:focus {
        color: #000 !important;
        background-color: rgb(255, 255, 0, 0.8) !important;
    }

    .edit-tabl-link > .nav-item > a.nav-link.active {
        color: #000 !important;
        background-color: rgb(255, 255, 0, 0.8) !important;
    }

    .light-dsh-mode .edit-tabl-link > .nav-item > a.nav-link {
        color: #000 !important;
    }

    .amore-link {
        color: #fff !important;
    }
    .hideme{
        display: none !important; 
    }

    .light-dsh-mode .amore-link {
        color: #000 !important;
    }

    @media (max-width: 767px) {
        .dropzone {
            height: 270px;
        }

        .lws-list-grp {
            height: 50vh !important;
        }

        .vw-upload-img {
            overflow-y: auto;
        }
    }

    @media (max-width: 479px) {
        .edit-tabl-link > .nav-item > a.nav-link {
            font-size: 12px;
        }
    }

</style>
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
                                <th>Type of Service</th>
                                <th>Document</th>
                                <th>Allocated Qty</th>
                                <th>Download Raw Images</th>
                                <th>Uploaded Qty</th>
                                <th>Download Edited Images</th>
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
                                    $uploaded_qty =  $row['uploaded_qty'];
                                    $file_path =  $row['file_path'];

                                    $allocated_data_arr = $row;
                                    $allocated_qty = $row['allocated_qty'];

                                    $display_date_time = "display:none;";
                                    $display_start     = "display:block;";
                                    $btn_disable       = "";
                                    $extra = "";
                                @endphp
                                <tr>
                                    <td class="cls_wrc_number">{{ $row['wrc_number'] }}</td>
                                    
                                    <td class="cls_comp_name">{{ $row['Company'] }}</td>
                                    <td class="cls_brand_name">{{ $row['brand_name'].$extra }}</td>
                                    {{-- Guidelines Links --}}
                                    <td class="cls_comp_name">{{ $row['type_of_service'] }}</td>
                                    <td>
                                        @if ($row['documentType'] == 0)
                                            <a target="_blank" href="{{$row['documentUrl']}}">Link</a>
                                        @else
                                            <a href="{{ asset('/storage/Uploaded_SKU') }}{{"/".$row['documentUrl']}}" download >Download Excel</a>
                                        @endif
                                        {{-- <li><a target="_blank" href="{{ $row['img_as_per_guidelines'] }}" class="work-link">Link</a></li> --}}
                                    </td>
                                    <td>{{ $allocated_qty }}</td>

                                    <td>
                                        <a href="{{route('Editing_Raw_Image_Download', [base64_encode($wrc_id)])}}">Download</a>
                                    </td>

                                    <td class="cls_comp_name" id="uploaded_qty{{$allocation_id}}">{{ $uploaded_qty }}</td>
                                    <td>
                                        @if ($file_path != '' || $file_path != null)
                                            <a href="{{route('Editing_User_Edited_Image_Download', [base64_encode($allocation_id)])}}">Download</a>
                                        @endif
                                    </td>
                                    {{-- Upload market_place --}}
                                    <td>
                                        <p id="data{{ $allocation_id }}" 
                                        data-type_of_service="{{$allocated_data_arr['type_of_service']}}" 
                                        data-wrc_number="{{$allocated_data_arr['wrc_number']}}"   
                                        data-wrc_id="{{$allocated_data_arr['wrc_id']}}"   
                                        data-lot_id="{{$allocated_data_arr['lot_id']}}"   
                                        data-lot_number="{{$allocated_data_arr['lot_number']}}"   
                                        data-company="{{$row['Company']}}"   
                                        data-file_path="{{$row['file_path']}}"   
                                        data-brand_name="{{$row['brand_name']}}"   
                                        data-allocated_qty_is="{{$allocated_qty}}"   
                                        style="display: none"></p>

                                        <input type="hidden" id="key_is{{ $allocation_id }}" value="{{ $allocation_id }}">
                                        <input type="hidden" id="file_path{{ $allocation_id }}" value="{{ $file_path }}">
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
                        @csrf
                        {{-- Link Row --}}
                        <div class="row d-none" id="link_row">
                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="control-label required"> Final Link</label>
                                    <input autocomplete="off" type="text" class="form-control" name="final_link" id="final_link" value="final link" placeholder="Add Link ">
                                </div>
                            </div>
                        </div>

                        {{-- dropzone row --}}
                        <div class="row d-none" id="dropzone_row">
                            <div class="col-sm-12 col-12">
                                <div class="image-uploader">
                                    <div class="uploader-pop">
                                        <div class="dropzone-wrapper">
                                            <div class="dropzone"  id="my-awesome-dropzone">
                                                <i class="fas fa-cloud-upload-alt drop-addicon" style="font-size: 3rem; position: relative; top:25px;"></i>
                                                <div class="fallback">
                                                    <input name="sku_images" type="file" multiple accept="image/*" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        {{-- Save and complte Button row --}}
                        <div class="row mt-4">
                            <div class="col-sm-6 col-12">
                                <div class="custom-info">
                                  <p class="d-none">Please mark the WRC as complete only after you have uploaded the corresponding documents.</p>
                                </div>
                            </div>

                            <div class="col-sm-6 col-12"  style="position: relative;" >
                                <input type="hidden" name="allocation_id_is" id="allocation_id_is">
                                <input type="hidden" name="allocated_qty_is" id="allocated_qty_is">
                                <input type="hidden" name="wrc_id" id="wrc_id">
                                <input type="hidden" name="wrc_text" id="wrc_text">
                                <input type="hidden" name="lot_id" id="lot_id">
                                <input type="hidden" name="lot_text" id="lot_text">
                                <input id="key_is" name="key_is" type="hidden" value="">
                                <input id="file_path" name="file_path" type="hidden" value="">
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

<!-- jQuery -->
<script src="{{ asset('/js/app.js') }}"></script>
<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script type="application/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="application/javascript" src="plugins/dropzone/dropzone.js"></script>

<script type="application/javascript" src="plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script >

    $("#my-awesome-dropzone").dropzone({
        url: '/Editing-Wrc-Edited-image-upload',
        paramName: 'sku_images',
        clickable: true,
        maxFilesize: 1000,
        uploadMultiple: true,
        maxFiles: 1000,
        addRemoveLinks: false,
        autoProcessQueue: true,
        acceptedFiles: '.jpg,.jpeg,.png',
        dictDefaultMessage: 'Drag or Drop images here',
        sending: function(file, xhr, formData) {
            formData.append("_token", $('[name=_token').val());
            formData.append("wrcid", $('#wrc_id').val());
            formData.append("wrc_text", $('#wrc_text').val());
            formData.append("lot_id", $('#lot_id').val());
            formData.append("lot_text", $('#lot_text').val());
            formData.append("allocation_id_is", $('#allocation_id_is').val());
        },
        init: function () {
            var myDropzone = this; 
        },
        success: function(file, res)
        {
            response = JSON.parse(res)
            const key_is = $('#key_is').val()
            const file_path = $('#file_path').val()
            if(response.status == false){
                alert(response.message);
            }else{
                $("#msg_box1").css("color", "green");
                document.getElementById('uploaded_qty'+key_is).innerHTML = response.tot_uploaded_img_qty
                document.getElementById('msg_box1').innerHTML = response.message + " Total Uploaded images "+ response.tot_uploaded_img_qty
                $("#msg_box1").css("display", "block");
                if(file_path == '' || file_path == null){
                    window.location.reload()
                }
                if(response.upload_compete_status == 1){
                    alert("Uploading complted");
                    $("#dropzone_row").addClass("d-none");
                }
            }
        }
    });
</script>

{{-- set_data --}}
<script>
    async function set_data(params) {
        $("#dropzone_row").addClass("d-none");
        $("#link_row").addClass("d-none");
        $("#btn_save").css("display", "none");
        $("#btn_comp").css("display", "block");
        document.getElementById("workdetailsform").reset()
       
        const data_id = 'data'+params;
        const type_of_service = $("#"+data_id).data('type_of_service');
        const wrc_number = $("#"+data_id).data('wrc_number');
        const brand_name = $("#"+data_id).data('brand_name');
        const company = $("#"+data_id).data('company');
        const allocated_qty_is = $("#"+data_id).data('allocated_qty_is');
        const wrc_id_is = $("#"+data_id).data('wrc_id');
        const lot_id_is = $("#"+data_id).data('lot_id');
        const lot_number_is = $("#"+data_id).data('lot_number');
        const file_path_is = $("#"+data_id).data('file_path');
        let api_url = "";

        document.querySelector("#key_is").value =  params
        document.getElementById("wrc_id").value = wrc_id_is;
        document.getElementById("file_path").value = file_path_is;
        document.getElementById("lot_id").value = lot_id_is;
        document.getElementById("lot_text").value = lot_number_is;
        document.getElementById("wrc_text").value = wrc_number;
        document.getElementById("allocation_id_is").value = params;
        document.getElementById("allocated_qty_is").value = allocated_qty_is;
        document.querySelector("#typeofService").innerHTML = type_of_service
        document.querySelector("#wrcNo").innerHTML = wrc_number 
        document.querySelector("#brndName").innerHTML = brand_name

        // $("#link_row").removeClass("d-none");
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
                    document.querySelector("#final_link").value = res.final_link
                    task_status = res.task_status

                    if(res.is_uploading_pending == 1){
                        $("#dropzone_row").removeClass("d-none");
                    }
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
        const wrc_id  = $("#wrc_id").val()
        // if(final_link == ''){
        //     alert('Final Link in required ');
        //     $( "#final_link" ).focus();
        //     return
        // }
        await $.ajax({
            url: "{{ url('Editing-upload-link') }}",
            type: "POST",
            dataType: 'json',
            data: {
                allocation_id_is: allocation_id_is,
                final_link: final_link,
                action,
                wrc_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                console.log(res)
                if(res?.status > 0){
                    const status = res.status
                    const up_status = res.up_status
                    $("#msg_box1").css("color", "green");
                    if(status == 2){
                        $("#msg_box1").css("color", "Red");
                    }else if(status == 3){
                        $("#msg_box1").css("color", "Blue");
                    }
                    // document.querySelector("#btn_save").innerHTML = "update";
                    if(up_status == 1){
                        document.querySelector("#msg_box1").innerHTML = " link Saved Successfully";
                    }else if(up_status == 2){
                        document.querySelector("#msg_box1").innerHTML = " link Updated Successfully";
                    }else{
                        document.querySelector("#msg_box1").innerHTML = res.massage;
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