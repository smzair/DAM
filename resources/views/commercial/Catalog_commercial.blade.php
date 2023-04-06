@extends('layouts.admin')
@section('title')
Create New Commercial for Creative
@endsection

@section('content')
<div class="container">
    <style>
    .form-group .input_err{
        margin: 0.1em 0;
        color: red;
        background: #999;
        display: block;
        padding: 0.3em;
    }
    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-transparent card-info mt-3">
                <div class="card-header">
                    <h3 class="card-title">Add Commercial</h3>
                    <a style="float: right;" class="btn btn-success swalDefaultSuccess" href="{{route('viewCommercial')}}">View All Commercials</a>
                </div>
                <div class="card-body">
                    {{-- sucsses and false msg div --}}
                    <div id="msg_div">
                        @if (Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        @if (Session::has('false'))
                            <div class="alert alert-false" role="alert">
                                {{ Session::get('false') }}
                            </div>
                        @endif
                    </div>


                    @php
                        $formRoute = 'SAVECATALOG';
                        $btn_Name = 'Save';
                        if($commercial_data->id > 0){
                            $formRoute = 'UPDATECATALOG';
                            $btn_Name = 'Update';
                        }
                    @endphp
                    <form method="POST" action="{{ route($formRoute) }}"  onsubmit="return validateForm(event)">
                        @csrf
                        {{-- row 1 --}}
                        <div class="row">
                            {{-- Company Name --}}
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label required">Company Name</label>
                                    <input type="hidden" name="id" value="{{ $commercial_data->id }}">
                                    <select class="custom-select select2 form-control-border" id="user_id" name="user_id" aria-hidden="true" style="width: 100%;">
                                        <option value="" >Select Company Name</option>
                                        @foreach ($users as $user)
                                        <option  value="{{$user->id}}" data-client_id="{{$user->client_id}}">{{$user->Company."(.$user->name.)"}}</option>
                                        @endforeach
                                    </select>
                                    <p class="input_err" style="color: red; display: none;" id="user_id_err"></p>
                                </div>
                            </div>
                            {{-- Brand Name --}}
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label required">Brand Name</label>
                                    <select class="custom-select form-control-border" name="brand_id" id="brands"> 
                                        <option value=""> -- Select Brand Name -- </option>
                                    </select>
                                     <p class="input_err" style="color: red; display: none;" id="brands_err"></p>
                                </div>
                            </div>
                            {{-- Client Id --}}
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Client Id</label>
                                    <input type="text" class="form-control form-control-border" id="client_id" name="client_id" placeholder="Client Id" readonly>
                                </div>
                                <p class="input_err" style="color: red; display: none;" id="client_id_err"></p>
                            </div>
                        </div>
                        {{-- 2nd row --}}
                        <div class="row">
                            {{-- geting data from helpers --}}
                             @php
                                $marketPlace = getMarketPlace();
                                $typeOfService = getTypeOfService();
                                // pre($marketPlace);
                            @endphp
                            <div class="col-sm-12 col-12">
                                <div class="cc-title">
                                    <h5>Enter New Commercial Info</h5>
                                </div>
                            </div>
                            {{-- Marketplace --}}
                            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Marketplace</label>
                                    {{-- <select class="custom-select select2bs4 form-control-border js-example-basic-multiple" placeholder="Select Marketplace" name="market_place[]" id="market_place" aria-hidden="true" style="width: 100%;" multiple="multiple"> --}}
                                        @php

                                        $commercial_id_is = $commercial_data->id;
                                          $market_place_arr =  explode(',',$commercial_data->market_place);
                                        //   $market_place_arr =  json_decode($commercial_data->market_place,true);
                                        //   print_r($market_place_arr);
                                        @endphp
                                    <select class="custom-select select2 select2bs4 form-control-border js-example-basic-multiple" placeholder="Select Marketplace" name="market_place[]" id="market_place" aria-hidden="true" style="width: 100%;" multiple="multiple">
                                        <option value="" disabled>Select Marketplace</option>
                                        @foreach($marketPlace as $index => $getProduct)

                                        @php
                                        $marketPlace_id =  $getProduct['id'];
                                        $marketPlace_name =  $getProduct['marketPlace_name'];
                                        $selected = "";
                                            if($commercial_id_is > 0){
                                                if(in_array($marketPlace_id , $market_place_arr)){
                                                   $selected = "selected";
                                                }
                                            }
                                        @endphp
                                        <option {{ $selected }} value="{{$marketPlace_id}}">{{$marketPlace_name}}</option>
                                        @endforeach
                                    </select>
                                    <p class="input_err" style="color: red; display: none;" id="market_place_err"></p>
                                </div>
                            </div>

                            {{-- Type of Service --}}
                            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Type of Service</label>
                                    <select class="custom-select select2 form-control-border reset" id="type_of_service" placeholder="Select Type of Service" name="type_of_service">
                                        <option value="">Select Type of Service</option>
                                        @foreach($typeOfService as $index => $service)
                                        <option value="{{$index}}">{{$service}}</option>
                                        @endforeach
                                    </select>
                                    <p class="input_err" style="color: red; display: none;" id="type_of_service_err"></p>

                                    <script>
                                         document.getElementById("type_of_service").value = "{{ $commercial_data->type_of_service }}";
                                    </script>
                                </div>
                            </div>
                            {{-- Commercial Per SKU --}}
                            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Commercial Per SKU*</label>
                                    <input type="text" class="form-control" name="CommercialSKU" id="CommercialSKU" placeholder="Enter Commercial Per SKU" value="{{ $commercial_data->CommercialSKU }}" onKeyPress="return isNumber(event);">
                                    <p class="input_err" style="color: red; display: none;" id="CommercialSKU_err"></p>
                                </div>
                            </div>

                            {{-- submit buttons --}}
                            <div class="col-sm-12">

                                <button type="submit" name="save" value="1" class="btn btn-success swalDefaultSuccess">{{ $btn_Name }}</button>

                                @php
                                    if($commercial_data->id == 0 || $commercial_data->id == ''){  
                                        echo '<button type="submit" name="save" value="2" class="btn btn-info ml-1 wrc-btn">Save And Add</button>';
                                    }
                                @endphp

                                {{-- <button type="submit" class="btn btn-success swalDefaultSuccess" onclick="saveComForm(0)">Save</button> --}}

                                {{-- <button type="button" class="btn btn-info ml-1 wrc-btn" onclick="saveComForm(1)">Save & Add Another </button> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('/js/app.js') }}"></script>
<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script type="application/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

<script src="multiselect/jquery.multiselect.js"></script>
<script>
    // $(document).ready(function() {
    //     $('.js-example-basic-multiple').select2();
    // });

    $('#market_place').multiselect();
    // $('select[multiple]').multiselect();market_place
</script>

{{-- data for update --}}
<script>
    const user_id_val_is = "{{ $commercial_data->user_id }}";
    const saved_brand_id_is = "{{ $commercial_data->brand_id }}";
</script>

{{-- get-brand List --}}
<script>
    $(document).ready(function() {
        $("#user_id").change(async function() {
            const user_id_is = $("#user_id").val();
            const client_id = $("#user_id").find(':selected').data('client_id')
            // client_id
            $("#client_id").val(client_id);
            let options = `<option value="0"> -- Select Brand Name -- </option>`;
            document.getElementById("brands").innerHTML = "";
            await $.ajax({
                url: "{{ url('get-brand') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    user_id: user_id_is,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    res.map(brands => {
                        options +=
                            ` <option value="${brands.brand_id}"> ${brands.name}</option>`;
                    })
                }
            });
            document.getElementById("brands").innerHTML = options;
            if(saved_brand_id_is > 0 && user_id_val_is === user_id_is){
                document.getElementById("brands").value = saved_brand_id_is;
            }
        });
    })
</script>


{{-- setting data into form --}}
<script>
    $(document).ready(function() {
        setTimeout(() => {
            $('#msg_div').attr("style", "display:none")
        }, 1500);
        if (user_id_val_is > 0) {
            $("#user_id").val(user_id_val_is);
            $("#user_id").trigger("change");
        }
    });
</script>


{{-- form submiting --}}
<script>
    function validateForm(event) {
        // event.preventDefault() // this will stop the form from submitting
        $(".input_err").css("display", "none");
        $(".input_err").html("");

        const user_id_is = $("#user_id").val();
        const client_id_is = $("#client_id").val();
        const brand_id = $("#brands").val();
        const market_place = $("#market_place").val();
        const type_of_service = $("#type_of_service").val();
        const CommercialSKU = $("#CommercialSKU").val();

        // console.log({user_id_is,brand_id,market_place,type_of_service,CommercialSKU})

        let user_id_is_Valid = true;
        let brand_id_Valid = true;
        let market_place_Valid = true;
        let type_of_service_Valid = true;
        let CommercialSKU_Valid = true;

        if (type_of_service === '') {
            $("#type_of_service_err").html("Service type Not selected!!");
            document.getElementById("type_of_service_err").style.display = "block";
            type_of_service_Valid = false;
        }
        if (CommercialSKU === '') {
            $("#CommercialSKU_err").html("CommercialSKU Not enter");
            document.getElementById("CommercialSKU_err").style.display = "block";
            CommercialSKU_Valid = false;
        }
        if (user_id_is === '') {
            $("#user_id_err").html("Company Name not Selected");
            document.getElementById("user_id_err").style.display = "block";
            user_id_is_Valid = false;
        }
        if (market_place === '') {
            $("#market_place_err").html("Market Place not Selected");
            document.getElementById("market_place_err").style.display = "block";
            market_place_Valid = false;
        }
        if (brand_id === '' || brand_id == 0) {
            $("#brands_err").html("Brand not Selected");
            document.getElementById("brands_err").style.display = "block";
            brand_id_Valid = false;
        }
        if (user_id_is_Valid && brand_id_Valid && market_place_Valid && CommercialSKU_Valid && type_of_service_Valid) {
            return true
        } else {
            return false
        }
    }
</script>

@endsection