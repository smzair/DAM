@extends('layouts.admin')

@section('title')
Create Catlog WRCs
@endsection
@section('content')
<link rel="stylesheet" href="{{asset('plugins/datepicker-in-bootstrap-modal/css/datepicker.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<!-- New WRC Creation (For Catalogue) -->
<div class="container">
    <style>
        @media (min-width: 992px){
            .modal-lg, .modal-xl{
                max-width: 900px;
            }
        }
         .msg_box{
            margin: 0.1em 0;
            background: #928c8cfc;
            padding: 0.3em;
        }
    </style>

    <div class="row ">
        <div class="col-5">
            <div class="card card-transparent m-0 " style="height: 100%;">
                <div class="" style="height: 100%;display: flex;align-items: center;">
                    <h5 style="float: left;padding:2%">Wrc Number :- </h5>
                    <h5 class="WrcNo" style="padding-top:2%">{{$CatlogWrc->wrc_number }}</h5>
                </div>
            </div>
        </div>

        @php
            $cl_wrc_id = $CatlogWrc->id;
            $dis_none = ""; 
            if($cl_wrc_id > 0){
                $disabled = "disabled";
                $dis_none = "display: none"; 
                
            }
        @endphp

        <div class="col-3">
            <div class="card card-transparent m-0 " style="align-items:center; padding: 10px; height: 100%;justify-content: center;" >
                <div>
                    <a  download="catalog sku Master Sheet" href="{{ asset('files/catalog_sku_Master_Sheet.csv') }}" class="btn" style="margin-bottom: 6px"><i class="fa fa-download"></i> Download Master Sheet</a>
                </div>
                <div style="{{ $dis_none }}">
                    <label for="files" class="btn">Upload Sheet</label>
                    <br>
                </div>
                <span  class="file_name_field" style="color: white;" id="file_name_field"></span>
            </div>
        </div>    
        <div class="col-4">
            <div class="card card-transparent m-0 " style="height: 100%;">
                <div style="height: 100%;display: flex;padding: 0 20px;flex-direction: column;justify-content: center;">

                    @php
                        $unique_Count = $sku_details['unique_Count'] > 0 ? $sku_details['unique_Count'] : '';
                        $variant_Count = $sku_details['variant_Count'] > 0 ? $sku_details['variant_Count'] : '';
                        $total_Count = $sku_details['total_Count'] > 0 ? $sku_details['total_Count'] : '';
                    @endphp
                    <h5>Unique Count :  <span><?php echo $unique_Count; ?></span></h5>
                    <h5>Variant Count :   <span><?php echo $variant_Count; ?></span></h5>
                    <h5>Total Count :   <span><?php echo $total_Count; ?></span></h5>

                </div>

            </div>
        </div>
    </div>

    {{-- form row  --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-transparent card-info mt-3">
                <div class="card-header bg-warning">
                    <h3 class="card-title">Create New WRC</h3>
                    <a href="{{route('viewCatalogWRC')}}" class="btn btn-warning upld-action-btn float-right">View All WRCs</a>
                </div>
                <div class="card-body"> 
                    @if (Session::has('success'))
                            <div class="alert alert-success" id="msg_div" role="alert">
                                {{ Session::get('success') }}
                            </div>
                    
                    @endif

                    <form method="POST" onsubmit="return validateForm(event)" action="{{ route($CatlogWrc->route)}}"  id = "wrcform" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                             <!-- Company Name -->
                             <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    
                                    <input type="hidden" name="id" value="{{$CatlogWrc->id }}"> 
                                    <input type="hidden" name="c_short" id="c_short" value="">
                                    <input type="hidden" name="short_name" id="short_name" value="">
                                    <input type="hidden" name="s_type" id="s_type" value="">

                                    <label class="control-label required">Company Name</label>
                                    <select class="custom-select select2 form-control-border" id="user_id" name="user_id"  aria-hidden="true" style="width: 100%;">
                                        <option value="" selected>Select Company Name</option>
                                        @foreach ($users_data as $user)
                                                <option value="{{ $user->id }}" data-c_short="{{ $user->c_short }}">
                                                    {{ $user->Company ." (" . $user->name.")" }}
                                                </option>
                                        @endforeach
                                    </select>
                                    <script>
                                        document.querySelector("#user_id").value = "{{$CatlogWrc->user_id }}"
                                    </script>
                                    <p class="input_err" style="color: red; display: none;" id="user_id_err"></p>
                                </div>
                            </div>
                            <!-- Brand Name -->
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Brand Name</label>
                                    <select class="custom-select form-control-border" name="brand_id"  id="brand_id">
                                        <option value = "">Select Brand</option>
                                    </select>
                                    <script>
                                        document.querySelector("#brand_id").value = "{{$CatlogWrc->brand_id }}"
                                    </script>
                                    <p class="input_err" style="color: red; display: none;" id="brand_id_err"></p>
                                </div>
                            </div>
                            <!-- LOT Number -->
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label required">LOT Number</label>
                                    <select class="custom-select form-control-border " name="lot_id" id="lot_id" onchange="setStype()">
                                        <option value = "">Select LOT Number</option>

                                    </select>
                                    <script>
                                        document.querySelector("#lot_id").value = "{{$CatlogWrc->lot_id }}"
                                    </script>
                                    <p class="input_err" style="color: red; display: none;" id="lot_id_err"></p>
                                </div>
                            </div>
                            <!-- Work Bucket -->
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Work Bucket</label>
                                    <select class="custom-select form-control-border " name="commercial_id" id="commercial_id" onchange="set_btn_action()">
                                        <option value="" data-market_place_ids="" >Select Commercial</option>
                                    </select>
                                    <script>
                                        document.querySelector("#commercial_id").value = "{{$CatlogWrc->commercial_id }}"
                                    </script>
                                    <p class="input_err" style="color: red; display: none;" id="commercial_id_err"></p>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            {{-- Mode of Delivery modeOfDelivary_err --}}
                            @php
                                $delivary_mode = modeOfDelivary();
                                // pre($CatlogWrc);
                            @endphp
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label  required" style="display: block">Mode of Delivery</label>
                                     <select class="custom-select form-control-border" id="modeOfDelivary" name="modeOfDelivary" onchange="set_btn_action()"  aria-hidden="true" style="width: 100%;">
                                        <option value="0" data-value='' >Mode of Delivery</option>
                                        @foreach ($delivary_mode as $key => $val)
                                                <option value="{{ $key }}" data-value="{{ $val }}">
                                                    {{ $val }}
                                                </option>
                                        @endforeach
                                    </select>

                                    <script>
                                        document.querySelector("#modeOfDelivary").value = "{{$CatlogWrc->modeOfDelivary }}"
                                    </script>
                                    <p class="input_err" style="color: red; display: none;" id="modeOfDelivary_err"></p>
                                </div>
                            </div>

                            <!-- Upload Sheet   -->
                            <div class="col-sm-6 col-12" style="margin-top: 3%; display: none; " >
                                @php
                                    $CatlogWrc_id = $CatlogWrc->id;
                                    $required = "required";
                                    if($CatlogWrc_id > 0){
                                        $required = "";
                                    }
                                @endphp
                                <div class="form-group">
                                    <input {{ $required }}  id="files" style="visibility:hidden;" type="file" id="sku_sheet" name="sku_sheet" class="btn btn-success btn-xl btn-warning mb-2">
                                </div>
                            </div>
                            
                            <!-- Sku Quantity -->
                            {{-- <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label required">SKU Qty</label>
                                    <input type="text" class="form-control" name="sku_qty" id="sku_qty" value="{{$CatlogWrc->sku_qty }}" placeholder="Enter SKU Quantity" onkeypress="return isNumber(event);">
                                    <p class="input_err" style="color: red; display: none;" id="sku_qty_err"></p>
                                </div>
                            </div> --}}

                            {{-- Allow to Copy Writer --}}
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label  required" style="display: block">Allow to Copy Writer</label>
                                    <input type="checkbox" class="form-control" name="alloacte_to_copy_writer" value="1" <?php if($CatlogWrc->alloacte_to_copy_writer == 1)echo 'checked'?>>
                                </div>
                            </div>                         
                           
                        </div>

                        <div class="row mt-3" >
                            <!-- Image Receive Date -->
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label ">Image Receive Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="img_recevied_date" id="img_recevied_date" placeholder="Select Image Receive Date" data-toggle="datepicker" value="<?php echo ($CatlogWrc->img_recevied_date != '0000-00-00' && $CatlogWrc->img_recevied_date != '') ? dateFormet_ymd($CatlogWrc->img_recevied_date) : ''?>">
                                    </div>
                                    <p class="input_err" style="color: red; display: none;" id="img_recevied_date_err"></p>
                                </div>
                            </div>
                            <!-- Missing Info Notify Date -->
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label ">Missing Info Notify Date</label>
                                    <div class="input-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="missing_info_notify_date" id="missing_info_notify_date" placeholder="Select Missing Info Notify Date" data-toggle="datepicker" value="<?php echo ($CatlogWrc->img_recevied_date != '0000-00-00' && $CatlogWrc->missing_info_notify_date != '') ? dateFormet_ymd($CatlogWrc->missing_info_notify_date) : ''?>">
                                    </div>
                                    <p class="input_err" style="color: red; display: none;" id="missing_info_notify_date_err"></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Missing Info Received Date -->
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label ">Missing Info Received Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="missing_info_recived_date" id="missing_info_recived_date" placeholder="Select Missing Info Received Date" data-toggle="datepicker" value="<?php echo ($CatlogWrc->missing_info_recived_date != '0000-00-00' && $CatlogWrc->missing_info_recived_date != '') ? dateFormet_ymd($CatlogWrc->missing_info_recived_date) : ''?>">
                                    </div>
                                    <p class="input_err" style="color: red; display: none;" id="missing_info_recived_date_err"></p>
                                    </div>
                                </div>
                            
                            <!-- Details Confirmation Date -->
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label">Details Confirmation Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="confirmation_date" id="confirmation_date" placeholder="Select Details Confirmation Date" data-toggle="datepicker" value="<?php echo ($CatlogWrc->confirmation_date != '0000-00-00' && $CatlogWrc->confirmation_date != '') ? dateFormet_ymd($CatlogWrc->confirmation_date) : ''?>">
                                    </div>
                                    <p class="input_err" style="color: red; display: none;" id="confirmation_date_err"></p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-sm-12 col-12">
                                <div class="cc-title">
                                    <h5>Guidelines</h5>
                                </div>
                            </div>
                            <!-- Work Brief -->
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="required">Work Brief</label>
                                    <input type="text" class="form-control" name="work_brief" id="work_brief" placeholder="Add Link" value="{{$CatlogWrc->work_brief }}">
                                    <p class="input_err" style="color: red; display: none;" id="work_brief_err"></p>
                                </div>
                            </div>
                            <!-- Guidelines -->
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="required">Guidelines</label>
                                    <input type="text" class="form-control" name="guide_lines" id="guide_lines" placeholder="Add Link" value="{{$CatlogWrc->guidelines }}">
                                    <p class="input_err" style="color: red; display: none;" id="guide_lines_err"></p>
                                </div>
                            </div>
                            <!-- Add Document -->
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="required">Add Document</label>
                                    <input type="text" class="form-control" name="document1" id="document1" placeholder="Add Link" value="{{$CatlogWrc->document1 }}">
                                    <p class="input_err" style="color: red; display: none;" id="document1_err"></p>
                                </div>
                            </div>
                            <!-- Add Document -->
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="required">Add Document</label>
                                    <input type="text" class="form-control" name="document2" id="document2" placeholder="Add Link" value="{{$CatlogWrc->document2 }}">
                                    <p class="input_err" style="color: red; display: none;" id="document2_err"></p>
                                </div>
                            </div>
                        </div> --}}

                        {{-- Prerequisites --}}
                        <div class="row mt-2">
                            <div class="col-sm-12 col-12">
                                <div class="cc-title">
                                    <h5>Prerequisites</h5>
                                </div>
                            </div>
                           
                             <!--  Generic Data Format -->
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="">Generic Data Format</label>
                                    <input type="text" class="form-control" name="generic_data_format_link" id="generic_data_format_link" placeholder="Add Link" value="{{$CatlogWrc->generic_data_format_link }}">
                                </div>
                            </div>
                            {{-- Images as per guidelines --}}
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="">Images as per guidelines</label>
                                    <input type="text" class="form-control" name="img_as_per_guidelines" id="img_as_per_guidelines" placeholder="Add Link" value="{{$CatlogWrc->img_as_per_guidelines }}">
                                    <p class="input_err" style="color: red; display: none;" id="work_brief_err"></p>
                                </div>
                            </div>
                            {{-- Marketplace Credentials Btn --}}
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="">Marketplace Credentials</label>
                                    <button id="set_Credentials" type="button" class="btn btn-success btn-xl btn-warning mb-2 form-control" data-toggle="modal" data-target="#openModel"  onclick="set_Credentials_data()" disabled="true">Add Credentials</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2 float-right">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success btn-xl btn-warning mb-2" onclick="">{{$CatlogWrc->button_name}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="openModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h4 class="modal-title">Add Marketplace Credentials</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="custom-dt-row work-details">
                </div>
                    
                <div class="custom-dt-row">
                    <div class="row">
                        <div class="col-sm-3 col-12">
                            <div class="col-ac-details">
                                <h6>Marketplace</h6>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="col-ac-details">
                                <h6>Link</h6>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="col-ac-details">
                                <h6>Username</h6>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="col-ac-details">
                                <h6>Password</h6>
                            </div>
                        </div>                        
                    </div>
                    <form class="" method="POST" action="" id="saveCredentialsform" >
                        <div class="row">
                            <div class="col-12" id="marketplace_list_div">
                            </div>

                            <div class="col-12 p-3">
                                <p class="msg_box" id="msg_box1" style="display: none;"> </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-9">
                                <p class="d-none" style="padding: 0px; margin:0px; color:#fbf702; text-align: end;font-size: 20px;" id="last_updated_p">Last Updated : <span id="last_updated_span"></span> </p>
                            </div>
                            <div class="col-3 float-right"  style="position: relative;" >
                                <input type="hidden" name="market_place_id_is" id="market_place_id_is">
                                <input type="hidden" name="commercial_id_is" id="commercial_id_is">
                                <button type="button" id="btn_save" class="btn btn-warning" style="float:right; margin: 0 5px;" onclick="saveCredentials(event)">Save Credentials</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of New WRC Creation (For Catalogue) -->
<script type="text/javascript">
 
 $('[data-toggle="datepicker"]').datepicker({
    autoHide: true,
    zIndex: 2048,
    format: 'yyyy-mm-dd'
});

</script>
<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

<script>
    const user_id_val_is = "{{ $CatlogWrc->user_id }}";
    const saved_brand_id_is = brand_id_val = "<?= $CatlogWrc->brand_id ?>";
    const lot_id_val = "<?= $CatlogWrc->lot_id ?>";
    const commercial_id_is =  "<?= $CatlogWrc->commercial_id; ?>";
</script>

<!-- Get Brand List -->
<script>
    $(document).ready(function() {
        $("#user_id").change(async function() {
            const user_id_is = $("#user_id").val();
            const c_short = $("#user_id").find(':selected').data('c_short');
            $("#c_short").val(c_short);
            let options = `<option value="" data-short_name=""  > -- Select Brand Name -- </option>`;
            await $.ajax({
                url: "{{ url('get-catlog-brand') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    user_id: user_id_is,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    console.log(res)
                    res.map(brands => {
                        options +=
                            ` <option value="${brands.brand_id}" data-short_name="${brands.short_name}" > ${brands.name}</option>`;
                    })
                    document.getElementById("brand_id").innerHTML = options;
                }
            });

            if(saved_brand_id_is > 0 && user_id_val_is === user_id_is){
                document.getElementById("brand_id").value = saved_brand_id_is;
            }
            $("#brand_id").trigger("change");
            setTimeout(() => {
                set_btn_action();
            }, 1000);
        });
    })
</script>


<!-- Select LOT Number  -->
<script>
    $(document).ready(function() {
        $("#brand_id").change(async function() {
            const user_id_is = $("#user_id").val();
            const brand_id_is = $("#brand_id").val();
            const short_name = $("#brand_id").find(':selected').data('short_name');
            $("#short_name").val(short_name);
            let options = `<option value="0" data-s_type="" > -- Select Lot Number -- </option>`;
            let options_work = `<option value="0" data-market_place_ids=""  > -- Select Commercial -- </option>`;
           
            await $.ajax({
                url: "{{ url('get-catlog-lot-number') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    user_id: user_id_is,
                    brand_id: brand_id_is,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    const {commercial_data,lot_number_data} = res;
                    lot_number_data.map(lots => {

                        console.log(lots)
                        options +=
                            ` <option value="${lots.id}" data-s_type="${lots.project_name}"> ${lots.lot_number}</option>`;
                    })
                    commercial_data.map(commercial => {
                            options_work +=
                            ` <option value="${commercial.create_commercial_catalog_id}" data-market_place_ids="${commercial.market_place_ids}" > ${commercial.market_place} | ${commercial.type_of_service}</option>`;
                    })
                    document.getElementById("lot_id").innerHTML = options;
                    document.getElementById("commercial_id").innerHTML = options_work;
                }
            });

            if(lot_id_val > 0 && saved_brand_id_is == brand_id_is){
                document.querySelector("#lot_id").value = "<?= $CatlogWrc->lot_id ?>"
                document.querySelector("#commercial_id").value = "<?= $CatlogWrc->commercial_id ?>"
                setStype();
            }

            setTimeout(() => {
                set_btn_action();
            }, 1000);
        });
    })
</script>

{{-- code for updation --}}
<script>
    $(document).ready(function() {
        if(user_id_val_is > 0){
            $("#user_id").trigger("change"); 
        }
    })
</script>

{{-- script for set_Credentials_data --}}
<script>
    function set_Credentials_data(){
        $("#last_updated_p").addClass('d-none');
        $('#msg_box1').html("");
        $("#msg_box1").css("display", "none");
        const commercial_id = document.querySelector("#commercial_id").value;
        // const market_place_ids = document.querySelector("#commercial_id").dataset.market_place_ids commercial_id_is
        const market_place_id_is = $("#commercial_id").find(':selected').data('market_place_ids');
        document.querySelector("#market_place_id_is").value = market_place_id_is;
        document.querySelector("#commercial_id_is").value = commercial_id;

        if(!commercial_id > 0){
            alert('Work Bucket Not selected');
            return
        }

       

        let list = "";
        $.ajax({
            url: "{{ url('Catalog-Wrc-marketplace-Credentials-list') }}",
            type: "POST",
            dataType: 'json',
            data: {
                commercial_id,
                market_place_ids:market_place_id_is,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                // console.log(res)
                let updated_date_is = "";
                res.map(data => {
                    // console.log(data)
                    const marketPlace_id = data.id
                    const credentials_id = data.credentials_id == null ? 0 : data.credentials_id;
                    const link = data.link == null ? '' : data.link;
                    const password = data.password == null ? '' : data.password;
                    const username = data.username == null ? '' : data.username;
                    const created_date = data.created_date == null ? '' : data.created_date;
                    const updated_date = data.updated_date == null ? '' : data.updated_date;

                    if(updated_date != ''){
                        updated_date_is = updated_date
                    }

                    list += 
                    `<div class="row mt-3" id="marketplace_row${data.id}">
                        <div class="col-sm-3 col-12">
                            <div class="col-ac-details">
                                <h6>${data.marketPlace_name}</h6>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="col-ac-details">
                                <input type="hidden" name="marketPlace_id${marketPlace_id}" id="marketPlace_id${marketPlace_id}"  value="${marketPlace_id}">
                                
                                <input type="hidden" name="credentials_id${marketPlace_id}" id="credentials_id${marketPlace_id}"  value="${credentials_id}">

                                <input type="text" placeholder="Enter link" id="link${marketPlace_id}" name="link${marketPlace_id}" value="${link}">
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="col-ac-details">
                                <input type="text" placeholder="Enter username" id="username${marketPlace_id}" name="username${marketPlace_id}" value="${username}">
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="col-ac-details">
                                <input type="text" placeholder="Enter password"  id="password${marketPlace_id}" name="password${marketPlace_id}" value="${password}">
                            </div>
                        </div>              
                    </div>`;
                })

                if(updated_date_is != ''){
                    $("#last_updated_p").removeClass('d-none');
                    document.getElementById("last_updated_span").innerHTML = updated_date_is;

                }

                // console.log(list)
                document.getElementById("marketplace_list_div").innerHTML = list;
                // document.getElementById("commercial_id").innerHTML = options_work;
            }
        });
    }
</script>

{{-- Marketplace Credentials btn validation --}}
<script>
    function set_btn_action(){
        const commercial_id = document.querySelector("#commercial_id").value;
        const modeOfDelivary = $("#modeOfDelivary").find(':selected').data('value');

        // console.log(commercial_id)
        var eleman = document.getElementById('set_Credentials');
        eleman.setAttribute("disabled", true);
        if(commercial_id > 0 && modeOfDelivary == 'Uploading'){
            eleman.removeAttribute("disabled");;
        }
    }
</script>

{{-- Sku file script --}}
<script>
    // $(".file_name_field").css("display", "none");
    $("#files").change(function() {
    filename = this.files[0].name;
    $("#file_name_field").html(filename);
    document.getElementById("file_name_field").style.display = "flex";
    console.log(filename);
});
</script>

{{-- script for Save Credentials document.querySelector("#commercial_id_is").value --}}
<script>
   async function saveCredentials(event){
        event.preventDefault();
        
        const market_place_id_is = document.querySelector('#market_place_id_is').value
        const commercial_id_is = document.querySelector("#commercial_id_is").value
        const market_place_id_arr = market_place_id_is.split(",");
        const data_arr = [];

        market_place_id_arr.forEach(element_id => {
            const marketPlace_id_id = "marketPlace_id"+element_id
            const link_id = "link"+element_id
            const username_id = "username"+element_id
            const password_id = "password"+element_id
            const credentials_id_id = "credentials_id"+element_id
            
            const marketPlace_id = document.getElementById(marketPlace_id_id).value
            const link = document.getElementById(link_id).value
            const username = document.getElementById(username_id).value
            const password = document.getElementById(password_id).value
            const credentials_id = document.getElementById(credentials_id_id).value
            // data_arr[''+marketPlace_id] = {
            //     marketPlace_id,
            //     link,
            //     username,
            //     password,
            // }

            data_arr.push({
                marketPlace_id,
                link,
                username,
                password,
                credentials_id,
            })
        });


        data_arr_st = JSON.stringify(data_arr);
        console.log(data_arr_st)
        $('#msg_box1').html("");
        $("#msg_box1").css("display", "none");
        await $.ajax({
            url: "{{ url('save-wrc-Credentials') }}",
            type: "POST",
            dataType: 'json',
            data: {
                market_place_id_is,
                commercial_id_is,
                data_arr,
                // data_arr_st,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                console.log(res)


                if(res.response == 1){
                    $("#msg_box1").css("color", "green");
                    document.querySelector("#msg_box1").innerHTML  = res.massage;
                    resCredentials_id_arr = res.resCredentials_id_arr

                    // console.log(resCredentials_id_arr)

                    for (const id_is in resCredentials_id_arr) {
                        const value_is  = resCredentials_id_arr[id_is]
                        console.log({id_is ,value_is })
                        document.getElementById(id_is).value = value_is
                    }
                }else{
                    $("#msg_box1").css("color", "red");
                    document.querySelector("#msg_box1").innerHTML  = "Somthing went Wrong please try again!!!"
                }
                $("#msg_box1").css("display", "block");
            }
        });
        setTimeout( () => {
            $('#msg_box1').html("");
            $("#msg_box1").css("display", "none");
        }, 2000);
        // return false
    }
</script>

<!-- Select Project Name -->
<script>
    function setStype(){
        const s_type = $("#lot_id").find(':selected').data('s_type');
        $("#s_type").val(s_type);
    }
</script>

<!-- validateForm script -->
<script>
    function validateForm(event) {
        // event.preventDefault() // this will stop the form from submitting
        $(".input_err").css("display", "none");
        $(".input_err").html("");

        const check_user_id = $('#user_id').val();
        const check_brand_id = $('#brand_id').val();
        const check_lot_id = $('#lot_id').val();
        const check_commercial_id = $('#commercial_id').val();
        const check_img_recevied_date = $('#img_recevied_date').val();
        const check_missing_info_notify_date = $('#missing_info_notify_date').val();
        const check_missing_info_recived_date = $('#missing_info_recived_date').val();
        const check_confirmation_date = $('#confirmation_date').val();
        const check_work_brief = $('#work_brief').val();
        const check_guide_lines = $('#guide_lines').val();
        const check_document1 = $('#document1').val();
        const check_document2 = $('#document2').val();
        const check_sku_qty = $('#sku_qty').val();
        const check_modeOfDelivary = $('#modeOfDelivary').val();

        let user_id_is_Valid = true;
        let brand_id_Valid = true;
        let lot_id_Valid = true;
        let commercial_id_Valid = true;
        let img_recevied_date_Valid = true;
        let missing_info_notify_date_Valid = true;
        let missing_info_recived_date_Valid = true;
        let confirmation_date_Valid = true;
        let work_brief_Valid = true;
        let guide_lines_Valid = true;
        let document1_Valid = true;
        let document2_Valid = true;
        let sku_qty_Valid = true;
        let modeOfDelivary_is_vaild = true;

        // if (check_sku_qty === '') {
        //     $("#sku_qty_err").html("SKU qty is required");
        //     document.getElementById("sku_qty_err").style.display = "block";
        //     sku_qty_Valid = false;
        // }

        if (check_modeOfDelivary == '' || check_modeOfDelivary == 0) {
            $("#modeOfDelivary_err").html("Mode of Delivery not selected");
            document.getElementById("modeOfDelivary_err").style.display = "block";
            modeOfDelivary_is_vaild = false;
        }

        // if (check_img_recevied_date === '') {
        //     $("#img_recevied_date_err").html("Image Receive Date is required");
        //     document.getElementById("img_recevied_date_err").style.display = "block";
        //     order_qty_Valid = false;
        // }
            
        // if (check_missing_info_notify_date === '') {
        //     $("#missing_info_notify_date_err").html("Missing Info Notify Date is required");
        //     document.getElementById("missing_info_notify_date_err").style.display = "block";
        //     order_qty_Valid = false;
        // }

        // if (check_missing_info_recived_date === '') {
        //     $("#missing_info_recived_date_err").html("Missing Info Received Date is required");
        //     document.getElementById("missing_info_recived_date_err").style.display = "block";
        //     order_qty_Valid = false;
        // }

        // if (check_confirmation_date === '') {
        //     $("#confirmation_date_err").html("Details Confirmation Date is required");
        //     document.getElementById("confirmation_date_err").style.display = "block";
        //     order_qty_Valid = false;
        // }

        if (check_document2 === '') {
            $("#document2_err").html("Add Document is required");
            document.getElementById("document2_err").style.display = "block";
            document2_Valid = false;
        }

        if (check_document1 === '') {
            $("#document1_err").html("Add Document is required");
            document.getElementById("document1_err").style.display = "block";
            document1_Valid = false;
        }

        if (check_guide_lines === '') {
            $("#guide_lines_err").html("Guidelines is required");
            document.getElementById("guide_lines_err").style.display = "block";
            guide_lines_Valid = false;
        }

        if (check_work_brief === '') {
            $("#work_brief_err").html("Work Brief is required");
            document.getElementById("work_brief_err").style.display = "block";
            work_brief_Valid = false;
        }

        if (check_commercial_id === '' || check_commercial_id == 0) {
            $("#commercial_id_err").html("Work Bucket is required");
            document.getElementById("commercial_id_err").style.display = "block";
            commercial_id_Valid = false;
        }
       
        if (check_lot_id === '') {
            $("#lot_id_err").html("LOT Number is required");
            document.getElementById("lot_id_err").style.display = "block";
            lot_id_Valid = false;
        }

        if (check_user_id === '') {
            $("#user_id_err").html("Company Name is required");
            document.getElementById("user_id_err").style.display = "block";
            user_id_is_Valid = false;
        }

        if (check_brand_id === '') {
            $("#brand_id_err").html("Brand Name is required");
            document.getElementById("brand_id_err").style.display = "block";
            brand_id_Valid = false;
        }

        if (modeOfDelivary_is_vaild && user_id_is_Valid && brand_id_Valid && lot_id_Valid && commercial_id_Valid && img_recevied_date_Valid && missing_info_notify_date_Valid && missing_info_recived_date_Valid && confirmation_date_Valid && work_brief_Valid && guide_lines_Valid && document1_Valid && document2_Valid && sku_qty_Valid) {
            return true
        } else {
            return false
        }
       
    }
</script>
<!-- msg div script -->
<script>
    setTimeout(function(){
        document.getElementById('msg_div').style.display = "none";
    },3000)
</script>
<!-- Wrc no div script -->
<script>
    const wrcNoId = document.querySelector('.WrcNo').innerHTML;
    if(wrcNoId == 0){
        $(".WrcNoShowHide").css("display", "none");
    }
</script>
@endsection