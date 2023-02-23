@extends('layouts.admin')

@section('title')
Create LOTS CATALOGS 

{{-- Update LOT --}}
@endsection
@section('content')
<!-- New Create Lot (For Catalogue) -->
<div class="container-lg container-fluid my-5 lot-create-updateversion">
     <style>
        .form-group .input_err{
            margin: 0.1em 0;
            color: red;
            background: #7e79798a;
            display: block;
            padding: 0.3em;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card card-transparent m-0">
                <div class="card-header">
                    <h3 class="card-title">Add LOTs</h3>
                    <a style="float: right;" class="btn btn-warning swalDefaultSuccess" href="{{route('VIEWLOTCATALOG')}}">View All LOTs</a>
                </div>
                <div class="card-body">
                    <!-- New Create Lot  -->
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

                    {{-- Changing routing based on condition --}}
                    @php
                        $formRoute = 'SAVELOTSCATALOG';
                        $btn_Name = 'Create LOT';
                        if($lotInfo->id > 0){
                            $btn_Name = 'Update Lots Catalog';
                            $formRoute = 'UPDATELOTSCATALOG';
                        }
                    @endphp

                    {{-- geting data from helpers --}}
                    @php
                        $users = getUserCompanyData();
                        $typeOfService = getTypeOfService();
                    @endphp
                    {{-- Form --}}
                    <form method="POST" action="{{route($formRoute)}}" onsubmit="return validateForm(event)">
                        <div class="row custom-select-row">
                            @csrf
                            <input type="hidden" name="id" value="<?php echo isset($lotInfo->id) ? $lotInfo->id : '0'; ?>">
                            <input type="hidden" name="c_short" id="c_short" value="<?php echo isset($lotInfo->c_short) ? $lotInfo->c_short : ''; ?>">
                            <input type="hidden" name="short_name" id="short_name" value="<?php echo isset($lotInfo->short_name) ? $lotInfo->short_name : ''; ?>">

                            {{-- Company Name --}}
                            <div class="col-sm-6">
                                    <div class="form-group">
                                        @php
                                            // pre($users);
                                        @endphp
                                    <label class="control-label required">Company Name</label>
                                    <select class="custom-select form-control-border " id="user_id" name="user_id"  aria-hidden="true" style="width: 100%;">
                                        <option value="" selected>Select Company Name</option>
                                        @foreach ($users as $user)
                                        <option  value="{{$user->id}}" data-client_id="{{$user->client_id}}" data-c_short="{{$user->c_short}}">{{ucfirst($user->Company)." (".ucfirst($user->c_short).")"}}</option>
                                        @endforeach
                                    </select>
                                    <p class="input_err" style="color: red; display: none;" id="user_id_err"></p>

                                </div>
                            </div>

                            {{-- Brand Name --}}
                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Brand Name</label>
                                    <select  class="form-control" id="brands" name="brand_id"  data-placeholder = "Select Brand" onchange="branchChange()">
                                        <option value="" data-short_name="">Select Brand Name</option>
                                    </select>
                                    <p class="input_err" style="color: red; display: none;" id="brands_err"></p>

                                </div>
                            </div>
                            {{-- Type of Service --}}
                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Type of Service</label>
                                    <select class="form-control" name="serviceType" id="serviceType">
                                        <option value="">Select Type of Service</option>
                                        @foreach($typeOfService as $index => $service)
                                            <option value="{{$index}}">{{$service}}</option>
                                        @endforeach
                                        {{-- <option value="Reshoot">Reshoot</option>
                                        <option value="New Shoot">New Shoot</option>
                                        <option value="Editing">Editing</option> --}}
                                    </select>
                                        <p class="input_err" style="color: red; display: none;" id="serviceType_err"></p>

                                     <script>
                                         document.getElementById("serviceType").value = "{{ $lotInfo->serviceType }}";
                                    </script>
                                </div>
                            </div>
                            {{-- Request Type --}}
                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Request Type</label>
                                    <select class="form-control" name="requestType" id="requestType">
                                        <option value="">Select Request Type</option>
                                        <option value="New">New</option>
                                        <option value="Existing">Existing</option>
                                        <option value="Retainer">Retainer</option>
                                    </select>
                                     <script>
                                         document.getElementById("requestType").value = "{{ $lotInfo->requestType }}";
                                    </script>
                                    <p class="input_err" style="color: red; display: none;" id="requestType_err"></p>
                                </div>
                            </div>
                            {{-- Request Received Date --}}
                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Request Received Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="reqReceviedDate" id="reqReceviedDate" placeholder="Select Request Received Date" data-toggle="datepicker" value="<?php echo ($lotInfo->reqReceviedDate != '0000-00-00' && $lotInfo->reqReceviedDate != '') ? dateFormet_mdy($lotInfo->reqReceviedDate) : ''?>">
                                    </div>
                                    <p class="input_err" style="color: red; display: none;" id="reqReceviedDate_err"></p>
                                </div>
                            </div>
                            {{-- Raw Image Receive Date --}}
                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="control-label">Raw Image Receive Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="imgReceviedDate" id="imgReceviedDate" placeholder="Select Raw Image Receive Date" data-toggle="datepicker"  value="<?php echo ($lotInfo->imgReceviedDate != '0000-00-00' && $lotInfo->imgReceviedDate != '') ? dateFormet_mdy($lotInfo->imgReceviedDate) : ''?>">
                                    </div>
                                    <p class="input_err" style="color: red; display: none;" id="imgReceviedDate_err"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row custom-select-row">
                            <div class="col-sm-12 mb-3">
                                <button type="submit" class="btn btn-sm btn-warning md-2" >{{ $btn_Name}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- data for update --}}
<script>
    const user_id_val_is = "{{ $lotInfo->user_id }}";
    const saved_brand_id_is = "{{ $lotInfo->brand_id }}";
</script>

@endsection

{{-- custom Script  --}}
@section('customScript')
<!--<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>-->

    <script type="application/javascript" src="{{asset('plugins/datepicker-in-bootstrap-modal/js/datepicker.js')}}"></script>
    <script src="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/js/plugins/mdb-file-upload.min.js"></script>

    <script type="text/javascript">
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            zIndex: 2048,
            format: 'yyyy-mm-dd'
        });
    </script>
    
    {{-- branchChange --}}
    <script>
        const branchChange = () => {
            const short_name = $("#brands").find(':selected').data('short_name')
            $("#short_name").val(short_name);
        }
    </script>

    {{-- get-brand List --}}
    <script>
        $(document).ready(function() {
            $("#user_id").change(async function() {
                const user_id_is = $("#user_id").val();
                const client_id = $("#user_id").find(':selected').data('client_id')
                const c_short = $("#user_id").find(':selected').data('c_short')
                $("#client_id").val(client_id);
                $("#c_short").val(c_short);

                let options = `<option value="0"  data-short_name=""> -- Select Brand Name -- </option>`;
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
                                ` <option value="${brands.brand_id}" data-short_name="${brands.short_name}"> ${brands.name}</option>`;
                        })
                    }
                });
                document.getElementById("brands").innerHTML = options;
                if(saved_brand_id_is > 0 && user_id_val_is === user_id_is){
                    document.getElementById("brands").value = saved_brand_id_is;
                    branchChange();
                }
            });
        })
    </script>

    {{-- setting data into form --}}
    <script defer>
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
            const brand_id = $("#brands").val();
            const type_of_service = $("#serviceType").val();
            const requestType = $("#requestType").val();
            const reqReceviedDate = $("#reqReceviedDate").val();
            const imgReceviedDate = $("#imgReceviedDate").val();

            console.log({user_id_is,brand_id,requestType,type_of_service,imgReceviedDate})

            let user_id_is_Valid = true;
            let brand_id_Valid = true;
            let type_of_service_Valid = true;
            let requestType_Valid = true;
            let reqReceviedDate_Valid = true;
            let imgReceviedDate_Valid = true;

            if (user_id_is === '') {
                $("#user_id_err").html("Company Name not Selected");
                document.getElementById("user_id_err").style.display = "block";
                user_id_is_Valid = false;
            }

             if (brand_id === '' || brand_id == 0) {
                $("#brands_err").html("Brand not Selected");
                document.getElementById("brands_err").style.display = "block";
                brand_id_Valid = false;
            }

            if (type_of_service === '') {
                $("#serviceType_err").html("Service type Not selected!!");
                document.getElementById("serviceType_err").style.display = "block";
                type_of_service_Valid = false;
            }

            if (requestType == '') {
                $("#requestType_err").html("Request Type Selected");
                document.getElementById("requestType_err").style.display = "block";
                requestType_Valid = false;
            }
            
            if (reqReceviedDate == '') {
                $("#reqReceviedDate_err").html("Request Received Date not Selected");
                document.getElementById("reqReceviedDate_err").style.display = "block";
                reqReceviedDate_Valid = false;
            }
           
            // if (imgReceviedDate == '') {
            //     $("#imgReceviedDate_err").html("Raw Image Receive Date not Selected");
            //     document.getElementById("imgReceviedDate_err").style.display = "block";
            //     imgReceviedDate_Valid = false;
            // }
           
            if (user_id_is_Valid && brand_id_Valid && requestType_Valid && imgReceviedDate_Valid && reqReceviedDate_Valid && type_of_service_Valid) {
                return true
            } else {
                return false
            }
        }
    </script>
@endsection