@extends('layouts.admin')

@section('title')
Create LOT

<!--- if condition to be applied for update details of the page-->
Update LOT
@endsection
@section('content')

<link rel="stylesheet" href="{{asset('plugins/datepicker-in-bootstrap-modal/css/datepicker.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<style>
    /* New Page Additional CSS  */

    .cc-title {
        margin-bottom: 20px;
        border-top: 1px solid #FFFF00;
        padding-top: 10px;
        margin-top: 10px;
    }

    /* End of New Page Additional CSS  */
</style> 

    
<div class="container-lg container-fluid my-5 lot-create-updateversion">
    <div class="row lotNoShowHide" style="padding-bottom: 2rem">
        <div class="col-12">
            <div class="card card-transparent m-0" style="flex-direction:row;">
                <h5 style="float: left;padding:2%">Creative Lot Number :- </h5>
                <h5 class="lotNo" style="float: right;padding-top:2%">{{$CreativeLots->lot_number }}</h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-transparent m-0">
                <div class="card-header">
                    <h3 class="card-title">Add LOTs</h3>
                    <a style="float: right;" class="btn btn-warning swalDefaultSuccess" href="javascript:;">View All LOTs</a>
                </div>
                <div class="card-body">
                    <!-- New Create Lot -->
                    @if (Session::has('success'))
                        <div class="alert alert-success" id="msg_div" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <form method="POST" id = "form" action="{{ route($CreativeLots->route) }}" onsubmit="return validateForm(event)">
                       
                        <div class="row custom-select-row">
                        @csrf
                            
                            <!-- Company Name -->
                            <div class="col-sm-4">
                                 <div class="form-group">
                                    <label class="control-label required">Company Name</label>
                                    <input type="hidden" name="id" value="{{$CreativeLots->id }}"> 
                                    <input type="hidden" name="c_short" id="c_short" value="">
                                    <input type="hidden" name="short_name" id="short_name" value="">
                                    <select class="custom-select form-control-border  com " id="user_id" name="user_id"  aria-hidden="true" style="width: 100%;">

                                        <option value="" selected>Select Company Name</option>
                                        @foreach ($users_data as $user)
                                                <option value="{{ $user->id }}" data-c_short="{{ $user->c_short }}">
                                                    {{ $user->Company ." (" . $user->name.")" }}
                                                </option>
                                            @endforeach
                                    </select>
                                    <script>
                                        document.querySelector("#user_id").value = "{{$CreativeLots->user_id }}"
                                    </script>
                                    <p class="input_err" style="color: red; display: none;" id="user_id_err"></p>
                                    @error('user_id')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Brand Name -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label required">Brand Name</label>
                                    <select  class="form-control  brand" id="brand_id" name="brand_id"  data-placeholder = "Select Company" id="brands">
                                        <option value="">Please Select</option>
                                    </select>
                                    <script>
                                        document.querySelector("#brand_id").value = "{{$CreativeLots->brand_id }}"
                                    </script>
                                    <p class="input_err" style="color: red; display: none;" id="brand_id_err"></p>
                                    @error('brand_id')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Project Type -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label required">Project name</label>
                                    <input type="text" value="{{$CreativeLots->project_name }}" class="form-control" name="project_name" id="project_name"
                                            placeholder="Enter Project Name" onKeyPress="return isAlphabet(event);">
                                </div>
                                <p class="input_err" style="color: red; display: none;" id="project_name_err"></p>
                            </div>
                            <!-- >Vertical Type -->
                            <div class="col-sm-4" id="verticalTypeCol">
                                <div class="form-group">
                                        @php
                                            $projectType = projectType();
                                        @endphp
                                    <label class="control-label required">Vertical Type</label>
                                    <select class="form-control" name="vertical_type" id="vertical_type">
                                    <option value="">Select Vertical Type</option>
                                    @foreach ($projectType as $row)
                                                <option value="{{ $row['value'] }}">{{ $row['value'] }}</option>
                                    @endforeach
                                    </select>
                                    <script>
                                        document.querySelector("#vertical_type").value = "<?= $CreativeLots->verticle ?>"
                                    </script>
                                    <p class="input_err" style="color: red; display: none;" id="vertical_type_err"></p>
                                </div>
                            </div>


                            <div class="col-sm-4" id="clientBucketCol">
                                <div class="form-group">
                                        @php
                                            $clientBucketStatic = (object) array(
                                                                            array( 'id' => "1",'value' => 'Existing',),
                                                                            array('id' => "2",'value' => 'Upselling'),
                                                                            array('id' => "3",'value' => 'New'),
                                                                            array('id' => "4",'value' => 'Retainer')
                                                                        );
                                        @endphp
                                    <label class="control-label required">Client Bucket</label>
                                    <select class="form-control client-bucket-select" name="client_bucket" id="client_bucket">
                                    <option value="">Select Client Bucket</option>
                                        @foreach ($clientBucketStatic as $row)
                                                    <option value="{{ $row['value'] }}">{{ $row['value'] }}</option>
                                        @endforeach
                                    </select>
                                    <script>
                                        document.querySelector("#client_bucket").value = "<?=$CreativeLots->client_bucket ?>"
                                    </script>
                                    <p class="input_err" style="color: red; display: none;" id="client_bucket_err"></p>
                                </div>
                            </div>

                            {{-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label required">Work Initiate Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="int_date" id="int_date" placeholder="yyyy-mm-dd" data-toggle="datepicker" value="{{$CreativeLots->work_initiate_date }}">
                                    </div>
                                    <p class="input_err" style="color: red; display: none;" id="int_date_err"></p>
                                </div>
                            </div> --}}
                            <!-- Work Committed Date -->
                            {{-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label required">Work Committed Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="cmt_date" id="cmt_date" placeholder="yyyy-mm-dd" data-toggle="datepicker" value="{{$CreativeLots->Comitted_initiate_date }}">
                                    </div>
                                    <p class="input_err" style="color: red; display: none;" id="cmt_date_err"></p>
                                </div>
                            </div> --}}
                            <!-- Work Committed Date -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label required">LOT Delivery Days</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="lot_delevery_days" id="lot_delevery_days" value="{{$CreativeLots->lot_delivery_days }}" placeholder="Enter LOT Delivery Days" onkeypress="return isNumber(event);">
                                    </div>
                                    <p class="input_err" style="color: red; display: none;" id="lot_delevery_days_err"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row custom-select-row">
                            <div class="col-sm-12 mb-3">
                                   <button type="submit" class="btn btn-sm btn-warning md-2" >{{$CreativeLots->button_name}}</button>
                            </div>
                        </div>
                    </form>
                    <!-- <a class="btn btn-sm btn-warning md-2" href="{{ route('viewLOT') }}">Get list</a> -->
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

<script type="application/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<script type="application/javascript" src="{{asset('plugins/datepicker-in-bootstrap-modal/js/datepicker.js')}}"></script>

<script src="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/js/plugins/mdb-file-upload.min.js"></script>

<script type="text/javascript">
 
 $('[data-toggle="datepicker"]').datepicker({
    autoHide: true,
    zIndex: 2048,
    format: 'yyyy-mm-dd'
});

</script>

<!-- script for setting short_name -->

<script>
    $("#brand_id").change(function() { 
        const short_name = $("#brand_id").find(':selected').data('short_name');
            $("#short_name").val(short_name);
    });
</script>

@if(isset($CreativeLots->id))
<script defer>  
    setTimeout(()=>{
        $("#user_id").change();
        document.querySelector("#brand_id").value = "<?= $CreativeLots->brand_id ?>"
    },2000)
    
</script>
@endif
<!-- Select Brand Name -->
<script>
    $(document).ready(function() {

        $("#user_id").change(function() {

            const user_id_is = $("#user_id").val();
            const c_short = $("#user_id").find(':selected').data('c_short');
            $("#c_short").val(c_short);


            let options = `<option value="" data-short_name="" > -- Select Brand Name -- </option>`;
            $.ajax({
                url: "{{ url('get-brand') }}",
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
                            ` <option value="${brands.brand_id}" data-short_name="${brands.short_name}"> ${brands.name}</option>`;
                    })
                    console.log(options)
                    document.getElementById("brand_id").innerHTML = options;

                }
            });
            setTimeout(()=>{
                document.querySelector("#brand_id").value = "<?= $CreativeLots->brand_id ?>"
            },1000)
        });
    })
</script>

<!-- validateForm script -->
<script>
    function validateForm(event) {
        // event.preventDefault() // this will stop the form from submitting
        $(".input_err").css("display", "none");
        $(".input_err").html("");

        const check_user_id = $('#user_id').val();
        const check_brand_id = $('#brand_id').val();
        const check_project_name = $('#project_name').val();
        const check_vertical_type = $('#vertical_type').val();
        const check_client_bucket = $('#client_bucket').val();
        // const check_int_date = $('#int_date').val();
        // const check_cmt_date = $('#cmt_date').val();
        const check_lot_delevery_days = $('#lot_delevery_days').val();

        let user_id_is_Valid = true;
        let brand_id_Valid = true;
        let project_name_Valid = true;
        let vertical_type_Valid = true;
        let client_bucket_Valid = true;
        let int_date_Valid = true;
        let cmt_date_Valid = true;
        let lot_delevery_days_Valid = true;

        // if (check_cmt_date === '') {
        //     $("#cmt_date_err").html("Work Committed Date is required");
        //     document.getElementById("cmt_date_err").style.display = "block";
        //     brand_id_Valid = false;
        // }

        if (check_lot_delevery_days === '') {
            $("#lot_delevery_days_err").html("LOT Delivery Days is requied");
            document.getElementById("lot_delevery_days_err").style.display = "block";
            lot_delevery_days_Valid = false;
        }

        // if (check_int_date === '') {
        //     $("#int_date_err").html("Work Initiate Date is required");
        //     document.getElementById("int_date_err").style.display = "block";
        //     brand_id_Valid = false;
        // }

        if (check_client_bucket === '') {
            $("#client_bucket_err").html("Client Bucket is required");
            document.getElementById("client_bucket_err").style.display = "block";
            client_bucket_Valid = false;
        }
        
        if (check_project_name === '') {
            $("#project_name_err").html("Project Name is required");
            document.getElementById("project_name_err").style.display = "block";
            project_name_Valid = false;
        }

        if (check_vertical_type === '') {
            $("#vertical_type_err").html("Vertical Type is required");
            document.getElementById("vertical_type_err").style.display = "block";
            vertical_type_Valid = false;
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
        
        if (user_id_is_Valid && brand_id_Valid && project_name_Valid && vertical_type_Valid && client_bucket_Valid && int_date_Valid && cmt_date_Valid && lot_delevery_days_Valid) {
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

<!-- lot no div script -->
<script>
    const lotNoId = document.querySelector('.lotNo').innerHTML;
    if(lotNoId == 0){
        $(".lotNoShowHide").css("display", "none");
    }
</script>

@endsection
