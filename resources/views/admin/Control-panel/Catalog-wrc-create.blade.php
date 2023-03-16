@extends('layouts.admin')

@section('title')
Admin Control
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

                    <form method="POST" onsubmit="return validateForm(event)" action=""  id = "wrcform" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                             <!-- Company Name -->
                             <div class="col-sm-4 col-12">
                                <div class="form-group">
                                    <input type="hidden" name="id" value=""> 

                                    <label class="control-label required">Service</label>
                                    <select class="custom-select select2 form-control-border" id="service" name="service"  aria-hidden="true" style="width: 100%;">
                                        <option value="0" selected>Select Service</option>
                                        <option value="1" >Shoot</option>
                                        <option value="2" >Creative</option>
                                        <option value="3" >Cataloging</option>
                                        <option value="4" >Editing</option>
                                    </select>
                                    <script>
                                        // document.querySelector("#service").value = ""
                                    </script>
                                    <p class="input_err" style="color: red; display: none;" id="service_err"></p>
                                </div>
                            </div>
                            
                            <!-- LOT Number -->
                            <div class="col-sm-4 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Lot Number</label>
                                    <select class="custom-select select2 form-control-border " name="lot_id" id="lot_id" onchange="setStype()">
                                        <option value = "0">-- Select Lot Number --</option>
                                    </select>
                                    <p class="input_err" style="color: red; display: none;" id="lot_id_err"></p>
                                </div>
                            </div>

                            <!-- Brand Name -->
                            <div class="col-sm-4 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Wrc Number</label>
                                    <select class="custom-select select2 form-control-border" name="wrc"  id="wrc" onchange="set_btn_action()">
                                        <option value = "0">-- Select Wrc Number --</option>
                                    </select>
                                    <p class="input_err" style="color: red; display: none;" id="wrc_err"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="btn_row" style="display: none">
                            <!-- Upload Sheet   -->
                            <div class="col-sm-4 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Select file for upload</label>
                                    <input required class="custom-select form-control-border  btn btn-success btn-xl btn-warning mb-2" id="files" type="file" id="sku_sheet" name="sku_sheet" >
                                </div>
                            </div>
                        
                            <div class="col-sm-12 float-right">
                                <div>
                                    <button type="submit" class="btn btn-success btn-xl btn-warning mb-2" onclick="">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

{{-- get Lot number List --}}

<script>
    $(document).ready(function() {
        $("#service").change(async function() {
            const service_id = $("#service").val();
            let options = `<option value="0" > -- Select Lot Number -- </option>`;
            if(service_id > 0){
                await $.ajax({
                   url: "{{ url('get-service-lot-number') }}",
                   type: "POST",
                   dataType: 'json',
                   data: {
                       service_id,
                       _token: '{{ csrf_token() }}'
                   },
                   success: function(res) {
                       console.log(res)
                       res.map(lots => {
                           console.log(lots)
                           options +=
                               ` <option value="${lots.id}"> ${lots.lot_number}</option>`;
                       })
                   }
                });
            }
            document.getElementById("lot_id").innerHTML = options;
            select2();
            setTimeout(() => {
                $("#lot_id").trigger("change");
                set_btn_action();
            }, 500);
        });
    });
</script>

{{-- Get Wrc Number List --}}
<script>
    $(document).ready(function() {
        $("#lot_id").change(async function() {
            const service_id = $("#service").val();
            const lot_id_is = $("#lot_id").val();
            let options = `<option value="0" >-- Select Wrc Number --</option>`;
            if(service_id > 0 && lot_id_is > 0){
                await $.ajax({
                   url: "{{ url('get-service-wrc-number') }}",
                   type: "POST",
                   dataType: 'json',
                   data: {
                       service_id,
                       lot_id_is,
                       _token: '{{ csrf_token() }}'
                   },
                   success: function(res) {
                       console.log(res)
                       res.map(wrc => {
                           console.log(wrc)
                           options +=  `<option value="${wrc.id}"> ${wrc.wrc_number}</option>`;
                       })
                   }
                });
            }
            document.getElementById("wrc").innerHTML = options;
            select2();
            setTimeout(() => {
                set_btn_action();
            }, 500);
        });
    });
</script>

<script>
    function set_btn_action(){
        const service_id = +$("#service").val();
        const lot_id_is = +$("#lot_id").val();
        const wrc_id = +$("#wrc").val();
        console.log({service_id, lot_id_is ,wrc_id})
        if(service_id == 0 || lot_id_is == 0 || wrc_id == 0){
            document.getElementById("btn_row").style.display = "none";

        }else{
            document.getElementById("btn_row").style.display = "block";
        }
        
    }
</script>

{{-- Sku file script --}}
<script>
    // $(".file_name_field").css("display", "none");
    $("#files").change(function() {
        filename = this.files[0].name;
        // $("#file_name_field").html(filename);
        // document.getElementById("btn_row").style.display = "flex";
        console.log(filename);
    });
</script>

@endsection