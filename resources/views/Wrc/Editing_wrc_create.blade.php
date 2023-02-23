@extends('layouts.admin')

@section('title')
Create Editing WRCs
@endsection
@section('content')
<link rel="stylesheet" href="{{asset('plugins/datepicker-in-bootstrap-modal/css/datepicker.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
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
<!-- New WRC Creation (For Editing) -->
<style>
	/* Create WRC Radio Style (For Editing) */
	.radio-div {
	    display: block;
	    padding-top: 10px;
	    color: #fff;
	}

	.radio-div .form-control-check {
	    margin-right: 5px;
	    margin-left: 5px;
	    cursor: pointer;
	}

	#imgOptionSection {
	    /* display: none; */
	}

	#skuOptionSection {
	    /* display: none; */
	}

	/* End of Create WRC Radio Style (For Editing) */
</style>
<div class="container">
    
    <div class="row">
        <div class="col-5">
            <div class="card card-transparent m-0 " style="height: 100%;">
                <div class="" style="height: 100%;display: flex;align-items: center;">
                    <h5 style="float: left;padding:2%">WRC No :- {{$EditingWrc->wrc_number}}</h5>
                    <h5 class="WrcNo" style="padding-top:2%"></h5>
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
                    <a href="{{route('EditingWrcView')}}" class="btn btn-warning upld-action-btn float-right">View All WRCs</a>
                </div>
                <div class="card-body"> 
                    <div id="msg_div">
                        @if (Session::has('success'))
                            <div class="alert alert-success"  role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        @if (Session::has('false'))
                            <div class="alert alert-false" role="alert">
                                {{ Session::get('false') }}
                            </div>
                        @endif
                    </div>

                    {{-- Changing routing based on condition --}}
                    @php
                    // pre($EditingWrc);
                        $formRoute = 'SaveEditingWrcCreate';
                        $btn_Name = 'Create WRC';
                        if($EditingWrc->id > 0){
                            $btn_Name = 'Update WRC';
                            $formRoute = 'UpdateEditingWrcCreate';
                        }

                        $UserCompanyData = getUserCompanyData();
                    @endphp

                    <form method="POST" onsubmit="return validateForm(event)" action="{{ route($formRoute)}}"  id = "wrcform" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                             <!-- Company Name -->
                             <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    
                                    <input type="hidden" name="id" value="{{$EditingWrc->id }}"> 
                                    <input type="hidden" name="c_short" id="c_short" value="">
                                    <input type="hidden" name="short_name" id="short_name" value="">
                                    <input type="hidden" name="s_type" id="s_type" value="">

                                    <label class="control-label required">Company Name</label>
                                    <select class="custom-select form-control-border" id="user_id" name="user_id"  aria-hidden="true" style="width: 100%;">
                                        <option value="" selected>Select Company Name</option>
                                        @foreach ($UserCompanyData as $user)
                                                <option value="{{ $user->id }}" data-c_short="{{ $user->c_short }}">
                                                    {{ $user->Company ." (" . $user->name.")" }}
                                                </option>
                                        @endforeach
                                    </select>
                                    <script>
                                        document.querySelector("#user_id").value = "{{$EditingWrc->user_id }}"
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
                                        document.querySelector("#brand_id").value = "{{$EditingWrc->brand_id }}"
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
                                   
                                    <p class="input_err" style="color: red; display: none;" id="lot_id_err"></p>
                                </div>
                            </div>
                            <!-- Work Bucket -->
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Work Bucket</label>
                                    <select class="custom-select form-control-border " name="commercial_id" id="commercial_id">
                                        <option value="" data-market_place_ids="" >Select Commercial</option>
                                    </select>
                                    <script>
                                        // document.querySelector("#commercial_id").value = "{{$EditingWrc->commercial_id }}"
                                    </script>
                                    <p class="input_err" style="color: red; display: none;" id="commercial_id_err"></p>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3" >
                            <div class="col-sm-4 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Tentative Image Count</label>
                                    <input type="text" class="form-control" name="imgQty" id="imgQty" value="{{$EditingWrc->imgQty}}" placeholder="Enter Tentative Image Count">
                                    <p class="input_err" style="color: red; display: none;" id="imgQty_err"></p>

                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Images Received from Client</label>
                                    <div class="radio-div">
                                        <input type="radio" {{$EditingWrc->documentType == 0 ? 'checked' : ""}} class="form-control-check" name="docType"  value="0" id="link" onclick="documentTypeChnage()" >
                                        <span>Link</span>
                                        <input type="radio" {{$EditingWrc->documentType == 1 ? 'checked' : ""}} class="form-control-check" name="docType" value="1" id="sheet" onclick="documentTypeChnage()" >
                                        <span>SKU Sheet</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Sheet Or Image Link Received    -->
                            <div class="col-sm-4 col-12">
                                <div class="form-group d-none" id="imgLinkReceviedDiv">
                                    <label class="control-label required">Upload Image Link Received</label>
                                    <input type="text" class="form-control" name="documentUrl" id="documentUrl" placeholder="Add Link" value="{{$EditingWrc->documentType == 0 ? $EditingWrc->documentUrl : ''}}"  >
                                    <p class="input_err" style="color: red; display: none;" id="documentUrl_err"></p>

                                </div>
                               
                                <div class="form-group d-none" id="sku_sheetDiv">
                                    <label for="files" class="control-label required" style="font-weight:400;">Upload SKU Sheet</label>
                                    <input accept=".xls,.xlsx,.csv" type="file" id="sku_sheet" name="sku_sheet" class="btn btn-success btn-xl btn-warning mb-2">
                                    <input type="hidden" class="form-control" name="oldDocumentUrl" id="oldDocumentUrl" value="{{$EditingWrc->documentType == 1 ? $EditingWrc->documentUrl : ''}}" >
                                    <p class="input_err" style="color: red; display: none;" id="sku_sheet_err"></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2 float-right">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success btn-xl btn-warning mb-2" >{{$btn_Name}}</button>
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
    const user_id_val_is = "{{ $EditingWrc->user_id }}";
    const saved_brand_id_is = brand_id_val = "<?= $EditingWrc->brand_id ?>";
    const lot_id_val = "<?= $EditingWrc->lot_id ?>";
    const commercial_id_is =  "<?= $EditingWrc->commercial_id; ?>";
</script>

{{-- documentTypeChnage --}}
<script>
    function documentTypeChnage(){
        var linkRadio = document.getElementById("link");
        $("#imgLinkReceviedDiv").addClass("d-none");
        $("#sku_sheetDiv").addClass("d-none");
        
        $("#documentUrl").removeAttr("required"); 
        $("#sku_sheet").removeAttr("required"); 
        
        if (linkRadio.checked) {
            // $("#documentUrl").attr("required", true); 
            $("#imgLinkReceviedDiv").removeClass("d-none");
        } else {
            // $("#sku_sheet").attr("required", true); 
            $("#sku_sheetDiv").removeClass("d-none");
        }
    }

    documentTypeChnage();
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
            // setTimeout(() => {
            //     set_btn_action();
            // }, 1000);
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
            let options = `<option value="0" data-request_name ="" data-short_name ="" data-s_type="" > -- Select Lot Number -- </option>`;
            let options_work = `<option value="0" data-market_place_ids=""  > -- Select Commercial -- </option>`;
           
            await $.ajax({
                url: "{{ url('get-Editing-lot-number') }}",
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
                        options += ` <option value="${lots.id}" data-request_name ="${lots.request_name}" data-short_name ="${lots.short_name}" data-s_type="${lots.request_name}"> ${lots.lot_number}</option>`;
                    })
                    commercial_data.map(commercial => {
                            options_work += ` <option value="${commercial.id}"  > ${commercial.type_of_service} ( ${commercial.CommercialPerImage} )</option>`;
                    })
                    document.getElementById("lot_id").innerHTML = options;
                    document.getElementById("commercial_id").innerHTML = options_work;
                }
            });

            if(lot_id_val > 0 && saved_brand_id_is == brand_id_is){
                document.querySelector("#lot_id").value = "<?= $EditingWrc->lot_id ?>"
                document.querySelector("#commercial_id").value = "<?= $EditingWrc->commercial_id ?>"
                setStype();
            }

           
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

{{-- Marketplace Credentials btn validation --}}
<script>
    function set_btn_action(){
        const commercial_id = document.querySelector("#commercial_id").value;
        // const modeOfDelivary = $("#modeOfDelivary").find(':selected').data('value');

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

        let  docType = 1; // for SKU
        var linkRadio = document.getElementById("link");
        if (linkRadio.checked) {
            docType = 0; // for link   imgQty_err 
        }

        const check_user_id = $('#user_id').val();
        const check_brand_id = $('#brand_id').val();
        const check_lot_id = $('#lot_id').val();
        const check_commercial_id = $('#commercial_id').val();
        const imgQty = $('#imgQty').val();
        const documentUrl = $('#documentUrl').val();
        const oldDocumentUrl = $('#oldDocumentUrl').val();
        const sku_sheet = document.getElementById("sku_sheet");

        let file_is_vaild = 0;

        if (sku_sheet.files.length > 0) {
            var file = sku_sheet.files[0];
            var fileName = file.name;
            var fileType = file.type;
            var csvType = "text/csv";
            var excelType = "application/vnd.ms-excel";

            if (fileType === csvType || fileName.endsWith(".csv") || fileType === excelType || fileName.endsWith(".xlsx") ) {
                file_is_vaild = 1;
            }else{
                file_is_vaild = 2;
            }
        }
    
        let user_id_is_Valid = true;
        let brand_id_Valid = true;
        let lot_id_Valid = true;
        let commercial_id_Valid = true;
        let imgQty_Is_Vailid = true;
        let documentUrl_Is_Vailid = true;
        let sku_sheet_Is_Vailid = true;


        if (check_user_id === '' || check_user_id  == 0) {
            $("#user_id_err").html("Company Name is required");
            document.getElementById("user_id_err").style.display = "block";
            user_id_is_Valid = false;
        }

        if (check_brand_id === '' || check_brand_id == 0) {
            $("#brand_id_err").html("Brand Name is required");
            document.getElementById("brand_id_err").style.display = "block";
            brand_id_Valid = false;
        }
  
        if (check_lot_id === '' || check_lot_id == 0) {
            $("#lot_id_err").html("LOT Number is required");
            document.getElementById("lot_id_err").style.display = "block";
            lot_id_Valid = false;
        }
        
        if (check_commercial_id === '' || check_commercial_id == 0) {
            $("#commercial_id_err").html("Work Bucket is required");
            document.getElementById("commercial_id_err").style.display = "block";
            commercial_id_Valid = false;
        }

        if (imgQty === '' || imgQty == 0) {
            $("#imgQty_err").html("Tentative Image Count is required");
            document.getElementById("imgQty_err").style.display = "block";
            imgQty_Is_Vailid = false;
        }

        if(docType == 0 && documentUrl == ''){
            $("#documentUrl_err").html("Upload Image Link is required");
            document.getElementById("documentUrl_err").style.display = "block";
            documentUrl_Is_Vailid = false;
        }

        if(docType == 1 && oldDocumentUrl == '' && file_is_vaild != 1){
            $("#sku_sheet_err").html("SKU Sheet is required");
            if(file_is_vaild == 2){
                $("#sku_sheet_err").html("Selected file is not a CSV or Excel file");
            }
            document.getElementById("sku_sheet_err").style.display = "block";
            sku_sheet_Is_Vailid = false;
        }
       
        if (user_id_is_Valid && brand_id_Valid && lot_id_Valid && commercial_id_Valid && imgQty_Is_Vailid && documentUrl_Is_Vailid && sku_sheet_Is_Vailid) {
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