@extends('layouts.admin')
@section('title')
Consolidated-Lot Create
@endsection
@section('content')
    
<!-- New LOT Panel -->

<style>
	/* Lot New Panel Style  */

	.checkcontainer {
	    display: inline-block;
	    vertical-align: middle;
	}

	.checkcontainer:not(:last-child) {
	    margin-right: 15px;
	}

	.checkcontainer .checkmark {
	    display: inline-block;
	    vertical-align: top;
	}

	.checkcontainer input[type="checkbox"] {
	    position: relative;
	    top: 2px;
	    margin-left: 5px;
	    cursor: pointer;
	}

	.custom-check-row {
	    align-items: center;
	}

	.btn-form-group {
	    text-align: right;
	}

	.panel-accrodian-wrapper .fa-angle-left {
	    transition: all 0.5s ease-in-out;
	    float: right;
	    transform: rotate(-90deg);
	}

	.panel-accrodian-wrapper .accordian-item-wrapper .card.card-transparent .card-title {
	    width: 100%;
	}

	.panel-accrodian-wrapper .accordian-item-wrapper .card.card-transparent .card-header {
	    border: 0 !important;
	    cursor: pointer;
	}

	.panel-accrodian-wrapper .angle-top .fa-angle-left {
	    transform: rotate(90deg);
	}

	/* End of Lot New Panel Style */
</style>

<!-- Lot Creation New Panel -->

<div class="custom-lot-creation-panel">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="panel-inner-wrapper">
                    <div class="card card-transparent">
                        <div class="card-header">
                            <h3 class="card-title">LOT Creation</h3>
                           
                            <div class="col-sm-12 col-12">
                                <div class="btn-form-group">
                                    <div class="custom-action-btn-wrapper">
                                        <a class="btn btn-warning px-1 py-1 btn-xs mt-0" href="{{ route('consolidated_lot_view') }}">All Consolidated LOTs</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if (Session::has('success'))
                        <div class="alert alert-success" id="msg_div" role="alert">
                            {{ Session::get('success') }}
                        </div>
                        {{ Session::forget('success') }}
                        @endif
                        <div class="card-body">
                            <div class="custom-panel-form-group">
                                <form action="{{ route('create_consolidated_lot') }}" onsubmit="return validateFormGenerateLot(event)" method="post" class="lot-panel-form" id="panelForm">
                                    @csrf
                                    <div class="row">
                                        <!-- Company Name -->
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label class="control-label required">Company Name</label>
                                                <input type="hidden" name="id" value="{{$CreativeLots->id }}"> 
                                                <input type="hidden" name="c_short" id="c_short" value="">
                                                <input type="hidden" name="short_name" id="short_name" value="">
                                                <select class="custom-select form-control-border" id="user_id" name="user_id"  aria-hidden="true" style="width: 100%;">
            
                                                    <option value="" selected>Select Company Name</option>
                                                    @foreach ($users_data as $user)
                                                        <option value="{{ $user->id }}" data-c_short="{{ $user->c_short }}">
                                                            {{ $user->Company ." (" . $user->name.")" }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <script type="text/javascript">
                                                    document.querySelector("#user_id").value = "{{$CreativeLots->user_id }}"
                                                </script>
                                                <p class="input_err" style="color: red; display: none;" id="user_id_err"></p>
                                                @error('user_id')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Brand Name -->
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label class="control-label required">Brand Name</label>
                                                <select  class="form-control  brand" id="brand_id" name="brand_id"  data-placeholder = "Select Company" id="brands">
                                                    <option value="">Please Select</option>
                                                </select>
                                                <script type="text/javascript">
                                                    document.querySelector("#brand_id").value = "{{$CreativeLots->brand_id }}"
                                                </script>
                                                <p class="input_err" style="color: red; display: none;" id="brand_id_err"></p>
                                                @error('brand_id')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row custom-check-row">
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label class="control-label required">Select Services to generate LOT*</label>
                                                <div class="custom-two-check">
                                                    <div class="checkcontainer">
                                                        <input type="checkbox" class="" name="shootcheck" id="shootcheck" <?php if($CreativeLots->shoot == 1)echo 'checked'?>>
                                                        <span class="checkmark"></span>
                                                        Shoot
                                                    </div>
                                                    <div class="checkcontainer">
                                                        <input type="checkbox" class="" name="cgcheck" id="cgcheck" <?php if($CreativeLots->creative_graphic == 1)echo 'checked'?>>
                                                        <span class="checkmark"></span>
                                                        Creative Graphics
                                                    </div>
                                                    <div class="checkcontainer">
                                                        <input type="checkbox" class="" name="catcheck" id="catcheck" <?php if($CreativeLots->cataloging == 1)echo 'checked'?>>
                                                        <span class="checkmark"></span>
                                                        Cataloging
                                                    </div>
                                                    <div class="checkcontainer">
                                                        <input type="checkbox" class="" name="editor_lot" id="editor_lot" <?php if($CreativeLots->editor_lot_check == 1)echo 'checked'?>>
                                                        <span class="checkmark"></span>
                                                        Editing
                                                    </div>
                                                    <p class="input_err" style="color: red; display: none;" id="select_service_err"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="btn-form-group">
                                                <div class="custom-action-btn-wrapper">
                                                    {{-- <a href="javascript:;" class="btn btn-warning" id="genLotBTN">
                                                        Generate LOT
                                                    </a> --}}
                                                    <?php if(($CreativeLots->id == 0)){?> 
                                                    <button type="submit" class="btn btn-sm btn-warning md-2" id="genLotBTN">Generate LOT No.</button>
                                                    <?php }else{ ?>
                                                        
                                                        <button type="submit" disabled class="btn btn-sm btn-warning md-2" id="genLotBTN">Generate LOT No.</button>
                                                        <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-accrodian-wrapper">
                    <div class="accordian-item-wrapper" id="accordionPanel">
                        <div class="accordian-item" id="shoot-accor-item" style="display:none;">
                            <div class="card card-transparent">
                                <div class="card-header acc-card-header" id="shootAccor" data-toggle="collapse" data-target="#shootcollapse" aria-expanded="true" aria-controls="shootcollapse">
                                    <h3 class="card-title">
                                        <span class="card-text">
                                        Shoot
                                        </span>
                                        <i class="right fas fa-angle-left"></i>
                                    </h3>
                                </div>
                                <div id="shootcollapse" class="collapse" aria-labelledby="shootAccor" data-parent="#accordionPanel">
                                    <div class="card-body">
                                        <form action="{{ route('create_consolidated_shoot') }}" onsubmit="return validateFormShoot(event)" method="post" id="shootForm">
                                            <input type="hidden" name="consolidated_lot_id" value="{{$CreativeLots->id}}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="control-label required">Type of Service</label>
                                                        <select class="custom-select form-control-border" name="servicesType" id="servicesType">
                                                            <option value="" selected>Select Type of Service</option>
                                                            <option value="E-commerce Shoo">E-commerce Shoot</option>
                                                            <option value="Cataloging">Cataloging</option>
                                                            <option value="Marketing Creatives">Marketing Creatives</option>
                                                            <option value="ODN Verse">ODN Verse</option>
                                                            <option value="GO Live">GO Live</option>
                                                        </select>
                                                        <script type="text/javascript">
                                                            document.querySelector("#servicesType").value = value="{{$shoot_data != null ? $shoot_data->s_type : ""}}"
                                                        </script>
                                                    </div>
                                                    <p class="input_err" style="color: red; display: none;" id="servicesType_err"></p>
                                                </div>
                                                <div class="col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="control-label required">Location</label>
                                                        <select class="custom-select form-control-border" name="locationType" id="locationType">
                                                            <option selected value="">Select Location</option>
                                                            <option value="Delhi">Delhi</option>
                                                            <option value="Bangalore">Bangalore</option>
                                                        </select>
                                                        <script type="text/javascript">
                                                            document.querySelector("#locationType").value = value="{{$shoot_data != null ? $shoot_data->location : ""}}"
                                                        </script>
                                                    </div>
                                                    <p class="input_err" style="color: red; display: none;" id="locationType_err"></p>
                                                </div>
                                                <div class="col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="control-label required">Vertical Type</label>
                                                        <select class="custom-select form-control-border" name="verticalType" id="verticalType">
                                                            <option selected value="">Select Vertical Type</option>
                                                            <option value="Reshoot">Reshoot</option>
                                                            <option value="New Shoot">New Shoot</option>
                                                            <option value="Editing">Editing</option>
                                                        </select>
                                                        <script type="text/javascript">
                                                            document.querySelector("#verticalType").value = value="{{$shoot_data != null ? $shoot_data->verticleType : ""}}"
                                                        </script>
                                                    </div>
                                                    <p class="input_err" style="color: red; display: none;" id="verticalType_err"></p>
                                                </div>
                                                <div class="col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="control-label required">Client Bucket</label>
                                                        <select class="custom-select form-control-border" name="clientBucket" id="clientBucket">
                                                            <option selected value="">Select Client Bucket</option>
                                                            <option value="New">New</option>
                                                            <option value="Existing">Existing</option>
                                                        </select>
                                                        <script type="text/javascript">
                                                            document.querySelector("#clientBucket").value = value="{{$shoot_data != null ? $shoot_data->clientBucket : ""}}"
                                                        </script>
                                                    </div>
                                                    <p class="input_err" style="color: red; display: none;" id="clientBucket_err"></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="btn-form-group">
                                                        <div class="custom-action-btn-wrapper">
                                                            {{-- <a href="javascript:;" class="btn btn-warning" id="shsaveBTN">
                                                                Save
                                                            </a> --}}
                                                            <?php if($CreativeLots->shoot_form_data == 0){ ?>
                                                                <button type="submit" class="btn btn-sm btn-warning md-2" id="saveShootBtn">Save</button>
                                                            <?php }else{ ?>
                                                                <script type="text/javascript">
                                                                    document.getElementById("servicesType").disabled = true;
                                                                    document.getElementById("locationType").disabled = true;
                                                                    document.getElementById("verticalType").disabled = true;
                                                                    document.getElementById("clientBucket").disabled = true;
                                                                </script>
                                                                <button type="submit" disabled class="btn btn-sm btn-warning md-2" id="saveShootBtn">Shoot Already Saved</button>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordian-item" id="cg-accor-item" style="display:none;">
                            <div class="card card-transparent">
                                    <div class="card-header acc-card-header" id="cgAccor" data-toggle="collapse" data-target="#cgcollapse" aria-expanded="true" aria-controls="cgcollapse">
                                        <h3 class="card-title">
                                            <span class="card-text">
                                            Creative Graphics
                                            </span>
                                            <i class="right fas fa-angle-left"></i>
                                        </h3>
                                    </div>
                                    <div id="cgcollapse" class="collapse" aria-labelledby="cgAccor" data-parent="#accordionPanel">
                                        <div class="card-body">
                                            <form action="{{ route('create_consolidated_creative_graphics') }}" onsubmit="return validateFormCreativeGraphics(event)" method="post" id="cgForm">
                                                <input type="hidden" name="consolidated_lot_id" value="{{$CreativeLots->id}}">
                                                @csrf
                                                <div class="row">
                                                    <!-- Project Name -->
                                                    <div class="col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Project Name</label>
                                                            <input type="text" value="{{$creative_data != null ? $creative_data->project_name : ""}}"  class="form-control" name="project_name" id="project_name" placeholder="Enter Project Name" onKeyPress="return isAlphabet(event);">
                                                        </div>
                                                        <p class="input_err" style="color: red; display: none;" id="project_name_err"></p>
                                                    </div>
                                                    <!-- Vertical Type -->
                                                    <div class="col-sm-6 col-12">
                                                        <div class="form-group">
                                                            @php
                                                                $projectType = projectType();
                                                            @endphp
                                                            <label class="control-label required">Vertical Type</label>
                                                            <select class="custom-select form-control-border" name="verticalType" id="verticalType_c">
                                                                <option selected value="">Select Vertical Type</option>
                                                                @foreach ($projectType as $row)
                                                                    <option value="{{ $row['value'] }}">{{ $row['value'] }}</option>
                                                                @endforeach
                                                            </select>
                                                            <script type="text/javascript">
                                                                document.querySelector("#verticalType_c").value = value="{{$creative_data != null ? $creative_data->verticle : ""}}"
                                                            </script>
                                                        </div>
                                                        <p class="input_err" style="color: red; display: none;" id="verticalType_err_c"></p>
                                                    </div>
                                                    <div class="col-sm-6 col-12">
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
                                                            <select class="custom-select form-control-border" name="clientBucket" id="clientBucket_c">
                                                                <option selected value="">Select Client Bucket</option>
                                                                @foreach ($clientBucketStatic as $row)
                                                                    <option value="{{ $row['value'] }}">{{ $row['value'] }}</option>
                                                                @endforeach
                                                            </select>
                                                            <script type="text/javascript">
                                                                document.querySelector("#clientBucket_c").value = value="{{$creative_data != null ? $creative_data->client_bucket : ""}}"
                                                            </script>
                                                            <p class="input_err" style="color: red; display: none;" id="clientBucket_err_c"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">LOT Delivery Days</label>
                                                            <div class="input-group">
                                                                <input type="text" value="{{$creative_data != null ? $creative_data->lot_delivery_days : ""}}" class="form-control" name="lot_delevery_days" id="lot_delevery_days" value="" placeholder="Enter LOT Delivery Days" onkeypress="return isNumber(event);">
                                                            </div>
                                                        </div>
                                                        <p class="input_err" style="color: red; display: none;" id="lot_delevery_days_err"></p>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="btn-form-group">
                                                            <div class="custom-action-btn-wrapper">
                                                                {{-- <a href="javascript:;" class="btn btn-warning" id="cgsaveBTN">
                                                                    Save
                                                                </a> --}}
                                                               
                                                                <?php if($CreativeLots->creative_graphic_form_data == 0){ ?>
                                                                    <button type="submit" class="btn btn-sm btn-warning md-2" id="saveCreativeBtn">Save</button>
                                                                <?php }else{ ?>
                                                                    <script type="text/javascript">
                                                                        document.getElementById("project_name").disabled = true;
                                                                        document.getElementById("verticalType_c").disabled = true;
                                                                        document.getElementById("clientBucket_c").disabled = true;
                                                                        document.getElementById("lot_delevery_days").disabled = true;
                                                                    </script>
                                                                    <button type="submit" disabled class="btn btn-sm btn-warning md-2" id="saveCreativeBtn">Creative Graphics Already Saved</button>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="accordian-item" id="ct-accor-item" style="display:none;">
                            <div class="card card-transparent">
                                <div class="card-header acc-card-header" id="ctAccor" data-toggle="collapse" data-target="#ctcollapse" aria-expanded="true" aria-controls="ctcollapse">
                                    <h3 class="card-title">
                                        <span class="card-text">
                                        Cataloging
                                        </span>
                                        <i class="right fas fa-angle-left"></i>
                                    </h3>
                                </div>
                                <div id="ctcollapse" class="collapse" aria-labelledby="ctAccor" data-parent="#accordionPanel">
                                    <div class="card-body">
                                        <form action="{{ route('create_consolidated_catlog') }}" onsubmit="return validateFormCatloging(event)"  method="post" id="ctForm">
                                            <input type="hidden" name="consolidated_lot_id" value="{{$CreativeLots->id}}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6 col-12">
                                                    @php
                                                        $typeOfService = getTypeOfService();
                                                    @endphp
                                                    <div class="form-group">
                                                        <label class="control-label required">Type of Service</label>
                                                        <select class="custom-select form-control-border" name="servicesType" id="servicesType_c">
                                                            <option selected value="">Select Type of Service</option>
                                                            @foreach($typeOfService as $index => $service)
                                                                <option value="{{$index}}">{{$service}}</option>
                                                            @endforeach
                                                        </select>
                                                        <script type="text/javascript">
                                                            document.querySelector("#servicesType_c").value = value="{{$catlog_data != null ? $catlog_data->serviceType : ""}}"
                                                        </script>
                                                        <p class="input_err" style="color: red; display: none;" id="servicesType_c_err"></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="control-label required">Request Type</label>
                                                        <select class="custom-select form-control-border" name="requestType" id="requestType_c">
                                                            <option value="">Select Request Type</option>
                                                            <option value="New">New</option>
                                                            <option value="Existing">Existing</option>
                                                            <option value="Retainer">Retainer</option>
                                                        </select>
                                                        <script type="text/javascript">
                                                            document.querySelector("#requestType_c").value = value="{{$catlog_data != null ? $catlog_data->requestType : ""}}"
                                                        </script>
                                                        <p class="input_err" style="color: red; display: none;" id="requestType_c_err"></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="control-label required">Request Received Date</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" value="{{$catlog_data != null ? $catlog_data->reqReceviedDate : ""}}" name="reqDate" id="reqDate" placeholder="yyyy-mm-dd" data-toggle="datepicker">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                </span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <p class="input_err" style="color: red; display: none;" id="reqDate_err"></p>

                                                </div>
                                                <div class="col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label class="control-label required">Raw Image Receive Date</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" value="{{$catlog_data != null ? $catlog_data->imgReceviedDate : ""}}" name="rawimgDate" id="rawimgDate" placeholder="yyyy-mm-dd" data-toggle="datepicker">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="input_err" style="color: red; display: none;" id="rawimgDate_err"></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="btn-form-group">
                                                        <div class="custom-action-btn-wrapper">
                                                            {{-- <a href="javascript:;" class="btn btn-warning" id="ctsaveBTN">
                                                                Save
                                                            </a> --}}
                                                            <?php if($CreativeLots->cataloging_form_data == 0){ ?>
                                                                <button type="submit" class="btn btn-sm btn-warning md-2" id="saveCatlogBtn">Save</button>
                                                            <?php }else{ ?>
                                                                <script type="text/javascript">
                                                                    document.getElementById("servicesType_c").disabled = true;
                                                                    document.getElementById("requestType_c").disabled = true;
                                                                    document.getElementById("reqDate").disabled = true;
                                                                    document.getElementById("rawimgDate").disabled = true;
                                                                </script>
                                                                <button type="submit" disabled class="btn btn-sm btn-warning md-2" id="saveCatlogBtn">Cataloging Already Saved</button>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordian-item" id="editor-accor-item" style="display:none;">
                            <div class="card card-transparent">
                                <div class="card-header acc-card-header" id="ctAccor" data-toggle="collapse" data-target="#editorcollapse" aria-expanded="true" aria-controls="editorcollapse">
                                    <h3 class="card-title">
                                        <span class="card-text">
                                        Editing
                                        </span>
                                        <i class="right fas fa-angle-left"></i>
                                    </h3>
                                </div>
                                <div id="editorcollapse" class="collapse" aria-labelledby="ctAccor" data-parent="#accordionPanel">
                                    <div class="card-body">
                                        <form action="{{ route('create_consolidated_editor_lot') }}" onsubmit="return validateFormEditorLot(event)"  method="post" id="ctForm">
                                            <input type="hidden" name="consolidated_lot_id" value="{{$CreativeLots->id}}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-4 col-12">
                                                    <div class="form-group">
                                                        <label class="control-label required">Request Name</label>
                                                        <input type="text" class="form-control" name="request_name"
                                                            value="{{$editor_data != null ? $editor_data->request_name : ""}}" id="request_name"
                                                            placeholder="Enter Request Name">
                                                        <p class="input_err" style="color: red; display: none;" id="request_name_err">
                                                        </p>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="btn-form-group">
                                                        <div class="custom-action-btn-wrapper">
                                                            {{-- <a href="javascript:;" class="btn btn-warning" id="ctsaveBTN">
                                                                Save
                                                            </a> --}}
                                                            <?php if($CreativeLots->editor_lot_form_data == 0){ ?>
                                                                <button type="submit" class="btn btn-sm btn-warning md-2" id="">Save</button>
                                                            <?php }else{ ?>
                                                                <script type="text/javascript">
                                                                    document.getElementById("request_name").disabled = true;
                                                                </script>
                                                                <button type="submit" disabled class="btn btn-sm btn-warning md-2" id="">Editing Already Saved</button>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

<!-- Lot Creation New Panel -->

<script type="text/javascript">

	$('.acc-card-header').click(function(){
        $(this).toggleClass('angle-top');
        $(this).parents('.accordian-item').siblings('.accordian-item').find('.acc-card-header').removeClass('angle-top');
    });

    // Display Shoot Accodian
    /*$("#shootcheck").change(function () {
        if (this.checked) {
            $('#shoot-accor-item').css('display', 'block');
        } else if (!this.checked) {
            $('#shoot-accor-item').css('display', 'none');
        }
    });

    // Display Creative Accodian
    $("#cgcheck").change(function () {
        if (this.checked) {
            $('#cg-accor-item').css('display', 'block');
        } else if (!this.checked) {
            $('#cg-accor-item').css('display', 'none');
        }
    });

    // Display Catalog Accodian
    $("#catcheck").change(function () {
        if (this.checked) {
            $('#ct-accor-item').css('display', 'block');
        } else if (!this.checked) {
            $('#ct-accor-item').css('display', 'none');
        }
    });

    // Display Editor lot 
    $("#editor_lot").change(function () {
        if (this.checked) {
            $('#v-accor-item').css('display', 'block');
        } else if (!this.checked) {
            $('#v-accor-item').css('display', 'none');
        }
    });
    
    
    */
	
</script>

{{-- show selected form based on checkbox --}}
<script type="text/javascript">
    $(document).ready(function() {
        if ($("#shootcheck").is(":checked")) {
            $('#shoot-accor-item').css('display', 'block');
        } else {
            $('#shoot-accor-item').css('display', 'none');
        }

        if ($("#cgcheck").is(":checked")) {
            $('#cg-accor-item').css('display', 'block');
        } else {
            $('#cg-accor-item').css('display', 'none');
        }

        if ($("#catcheck").is(":checked")) {
            $('#ct-accor-item').css('display', 'block');
        } else {
            $('#ct-accor-item').css('display', 'none');
        }

        if ($("#editor_lot").is(":checked")) {
            $('#editor-accor-item').css('display', 'block');
        } else {
            $('#editor-accor-item').css('display', 'none');
        }
    });

</script>

<!-- script for setting short_name -->

<script type="text/javascript">
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
<script type="text/javascript">
    $(document).ready(function() {

        $("#user_id").change(function() {

            const user_id_is = $("#user_id").val();
            console.log('user_id_is', user_id_is)
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

<!-- msg div script -->
<script type="text/javascript">
    setTimeout(function(){
        document.getElementById('msg_div').style.display = "none";
    },3000)
</script>

<script type="text/javascript">
// validate generate lot
    function validateFormGenerateLot(event) {
        $(".input_err").css("display", "none");
        $(".input_err").html("");
        const check_user_id = $('#user_id').val();
        const check_brand_id = $('#brand_id').val();

        let user_id_is_Valid = true;
        let brand_id_Valid = true;
        let select_service_to_generate_lot_valid = true;

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

        let shootcheck = false;
        if ($("#shootcheck").is(":checked")) {
            console.log("The checkbox is checked.");
            shootcheck = true;
        } else {
            console.log("The checkbox is not checked.");
            shootcheck = false;
        }

        let cgcheck = false;
        if ($("#cgcheck").is(":checked")) {
            console.log("The checkbox is checked.");
             cgcheck = true;
        } else {
            console.log("The checkbox is not checked.");
             cgcheck = false;
        }

        let catcheck = false;
        if ($("#catcheck").is(":checked")) {
            console.log("The checkbox is checked.");
             catcheck = true;
        } else {
            console.log("The checkbox is not checked.");
             catcheck = false;
        }

        let editor_lot_check = false;
        if ($("#editor_lot").is(":checked")) {
            console.log("The checkbox is checked.");
            editor_lot_check = true;
        } else {
            console.log("The checkbox is not checked.");
            editor_lot_check = false;
        }

        if ((shootcheck == false) && (cgcheck == false) && (catcheck == false) && (editor_lot_check == false)) {
            $("#select_service_err").html("Select Services to generate LOT is required");
            document.getElementById("select_service_err").style.display = "block";
            select_service_to_generate_lot_valid = false;
        }

        if (user_id_is_Valid && brand_id_Valid && select_service_to_generate_lot_valid) {
            return true
        } else {
            return false
        }
    }

</script>

<script type="text/javascript">
    // validate generate lot
        function validateFormShoot(event) {
            $(".input_err").css("display", "none");
            $(".input_err").html("");

            const check_servicesType = $('#servicesType').val();
            const check_locationType = $('#locationType').val();
            const check_verticalType = $('#verticalType').val();
            const check_clientBucket = $('#clientBucket').val();
    
            let servicesType_is_Valid = true;
            let locationType_is_Valid = true;
            let verticalType_is_Valid = true;
            let clientBucket_is_Valid = true;
    
            if (check_servicesType === '') {
                $("#servicesType_err").html("Type of Service is required");
                document.getElementById("servicesType_err").style.display = "block";
                servicesType_is_Valid = false;
            }

            if (check_locationType === '') {
                $("#locationType_err").html("Location is required");
                document.getElementById("locationType_err").style.display = "block";
                locationType_is_Valid = false;
            }

            if (check_verticalType === '') {
                $("#verticalType_err").html("Vertical Type is required");
                document.getElementById("verticalType_err").style.display = "block";
                verticalType_is_Valid = false;
            }

            if (check_clientBucket === '') {
                $("#clientBucket_err").html("Client Bucket is required");
                document.getElementById("clientBucket_err").style.display = "block";
                clientBucket_is_Valid = false;
            }
    
    
            if (servicesType_is_Valid && locationType_is_Valid && verticalType_is_Valid && clientBucket_is_Valid) {
                return true
            } else {
                return false
            }
        }
    
    </script>

<script type="text/javascript">
    // validate generate lot
        function validateFormCreativeGraphics(event) {
            $(".input_err").css("display", "none");
            $(".input_err").html("");

            const check_project_name = $('#project_name').val();
            const check_verticalType = $('#verticalType_c').val();
            const check_clientBucket = $('#clientBucket_c').val();
            const check_lot_delevery_days = $('#lot_delevery_days').val();
    
            let project_name_is_Valid = true;
            let verticalType_is_Valid = true;
            let lot_delevery_days_is_Valid = true;
            let clientBucket_is_Valid = true;
    
            if (check_project_name === '') {
                $("#project_name_err").html("Project Name is required");
                document.getElementById("project_name_err").style.display = "block";
                project_name_is_Valid = false;
            }

            if (check_clientBucket === '') {
                $("#clientBucket_err_c").html("Client Bucket is required");
                document.getElementById("clientBucket_err_c").style.display = "block";
                clientBucket_is_Valid = false;
            }

            if (check_verticalType === '') {
                $("#verticalType_err_c").html("Vertical Type is required");
                document.getElementById("verticalType_err_c").style.display = "block";
                verticalType_is_Valid = false;
            }

            if (check_lot_delevery_days === '') {
                $("#lot_delevery_days_err").html("LOT Delivery Days is required");
                document.getElementById("lot_delevery_days_err").style.display = "block";
                lot_delevery_days_is_Valid = false;
            }

    
            if (project_name_is_Valid && verticalType_is_Valid && lot_delevery_days_is_Valid && clientBucket_is_Valid) {
                return true
            } else {
                return false
            }
        }
    
    </script>

<script type="text/javascript">
    // validate generate lot
        function validateFormCatloging(event) {
            $(".input_err").css("display", "none");
            $(".input_err").html("");

            const check_servicesType_c = $('#servicesType_c').val();
            const check_requestType = $('#requestType_c').val();
            const check_reqDate = $('#reqDate').val();
            const check_rawimgDate = $('#rawimgDate').val();
    
            let project_name_is_Valid = true;
            let requestType_is_Valid = true;
            let rawimgDate_is_Valid = true;
            let reqDate_is_Valid = true;
    
            if (check_servicesType_c === '') {
                $("#servicesType_c_err").html("Type of Service is required");
                document.getElementById("servicesType_c_err").style.display = "block";
                project_name_is_Valid = false;
            }

            if (check_requestType === '') {
                $("#requestType_c_err").html("Request Type is required");
                document.getElementById("requestType_c_err").style.display = "block";
                requestType_is_Valid = false;
            }

            if (check_reqDate === '') {
                $("#reqDate_err").html("Request Received Date is required");
                document.getElementById("reqDate_err").style.display = "block";
                rawimgDate_is_Valid = false;
            }

            if (check_rawimgDate === '') {
                $("#rawimgDate_err").html("Raw Image Receive Date is required");
                document.getElementById("rawimgDate_err").style.display = "block";
                reqDate_is_Valid = false;
            }
    
            if (project_name_is_Valid && requestType_is_Valid && rawimgDate_is_Valid && reqDate_is_Valid) {
                return true
            } else {
                return false
            }
        }
    
    </script>

    <script type="text/javascript">
        function validateFormEditorLot(event) {
            $(".input_err").css("display", "none");
            $(".input_err").html("");

            const check_request_name = $('#request_name').val();
            
    
            let request_name_is_Valid = true;
           
    
            if (check_request_name === '') {
                $("#request_name_err").html("Request name is required");
                document.getElementById("request_name_err").style.display = "block";
                request_name_is_Valid = false;
            }
    
            if (request_name_is_Valid) {
                return true
            } else {
                return false
            }
        }
    </script>

    @if($CreativeLots->id > 0)
    <script type="text/javascript">
        document.getElementById("editor_lot").disabled = true;
        document.getElementById("catcheck").disabled = true;
        document.getElementById("cgcheck").disabled = true;
        document.getElementById("shootcheck").disabled = true;
        document.getElementById("brand_id").disabled = true;
        document.getElementById("user_id").disabled = true;
    </script>
    @endif
@endsection
