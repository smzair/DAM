@extends('layouts.admin')
@section('title')
Create New Commercial for Editor
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
                    <a style="float: right;" class="btn btn-success swalDefaultSuccess" href="{{route('ViewCommercialEditor')}}">View All Commercials</a>
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

                    {{-- geting data from helpers --}}
                    @php
                        $users = getUserCompanyData();
                        $typeOfService = getTypeOfService();
                        // pre($users)
                    @endphp

                    @php
                        $formRoute = 'SaveCommercialEditor';
                        $btn_Name = 'Save';
                        // dd($commercial_data);
                        if($commercial_data->id > 0){
                            $formRoute = 'UpdateCommercialEditor';
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
                                    <select class="custom-select form-control-border" id="company_id" name="company_id" aria-hidden="true" style="width: 100%;">
                                        <option value="0" >Select Company Name</option>
                                        @foreach ($users as $user)
                                        
                                        <option  value="{{$user->id}}" data-client_id="{{$user->client_id}}">{{$user->Company . " (". $user->c_short.")"}}</option>
                                        @endforeach
                                    </select>
                                    <p class="input_err" style="color: red; display: none;" id="company_id_err"></p>
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
                                    <h5>Enter New Commercial Information</h5>
                                </div>
                            </div>

                            {{-- Type of Service --}}
                            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Type of Service</label>
                                    <select class="custom-select form-control-border reset" id="type_of_service" placeholder="Select Type of Service" name="type_of_service">
                                        <option value="">Select Type of Service</option>
                                        <option value="Background Change">Background Change</option>
                                        <option value="Image Enhancement">Image Enhancement</option>
                                        <option value="scraping">scraping</option>
                                        <option value="Image Enhancement & Background Change">Image Enhancement & Background Change</option>
                                        <option value="scraping & Background Change">scraping & Background Change</option>
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
                                    <label class="control-label required">Commercial Per Image</label>
                                    <input type="text" class="form-control" name="CommercialPerImage" id="CommercialPerImage" placeholder="Enter Commercial Per Image" value="{{ $commercial_data->CommercialPerImage }}" onKeyPress="return isNumber(event);">
                                    <p class="input_err" style="color: red; display: none;" id="CommercialPerImage_err"></p>
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



{{-- data for update --}}
<script>
    const company_id_val_is = "{{ $commercial_data->company_id }}";
    const saved_brand_id_is = "{{ $commercial_data->brand_id }}";
</script>

{{-- get-brand List --}}
<script>
    $(document).ready(function() {
        $("#company_id").change(async function() {
            const company_id_is = $("#company_id").val();
            const client_id = $("#company_id").find(':selected').data('client_id')
            // client_id
            $("#client_id").val(client_id);
            let options = `<option value="0"> -- Select Brand Name -- </option>`;
            document.getElementById("brands").innerHTML = "";
            await $.ajax({
                url: "{{ url('get-brand') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    user_id: company_id_is,
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
            if(saved_brand_id_is > 0 && company_id_val_is === company_id_is){
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
        }, 2500);
        if (company_id_val_is > 0) {
            $("#company_id").val(company_id_val_is);
            $("#company_id").trigger("change");
        }
    });
</script>


{{-- form submiting --}}
<script>
    function validateForm(event) {
        // event.preventDefault() // this will stop the form from submitting
        $(".input_err").css("display", "none");
        $(".input_err").html("");

        const company_id_is = $("#company_id").val();
        const client_id_is = $("#client_id").val();
        const brand_id = $("#brands").val();
        const type_of_service = $("#type_of_service").val();
        const CommercialPerImage = $("#CommercialPerImage").val();

        // console.log({company_id_is,brand_id,market_place,type_of_service,CommercialPerImage})

        let company_id_is_Valid = true;
        let brand_id_Valid = true;
        let market_place_Valid = true;
        let type_of_service_Valid = true;
        let CommercialPerImage_Valid = true;

        if (type_of_service === '') {
            $("#type_of_service_err").html("Service type Not selected!!");
            document.getElementById("type_of_service_err").style.display = "block";
            type_of_service_Valid = false;
        }
        if (CommercialPerImage === '') {
            $("#CommercialPerImage_err").html("Commercial Per Image Not enter");
            document.getElementById("CommercialPerImage_err").style.display = "block";
            CommercialPerImage_Valid = false;
        }
        if (company_id_is === '' || company_id_is == 0) {
            $("#company_id_err").html("Company Name not Selected");
            document.getElementById("company_id_err").style.display = "block";
            company_id_is_Valid = false;
        }
        
        if (brand_id === '' || brand_id == 0) {
            $("#brands_err").html("Brand not Selected");
            document.getElementById("brands_err").style.display = "block";
            brand_id_Valid = false;
        }
        if (company_id_is_Valid && brand_id_Valid && market_place_Valid && CommercialPerImage_Valid && type_of_service_Valid) {
            return true
        } else {
            return false
        }
    }
</script>

@endsection