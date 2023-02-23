@extends('layouts.admin')
@section('title')
    Create New Commercial for Creative
@endsection
@section('content')
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

        .btn-form-group p{
            font-size: 20px;
        }

        /* End of Lot New Panel Style */
    </style>
    <!-- Commercial Panel -->
    <div class="custom-commercial-creation-panel">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="panel-inner-wrapper">
                        <div class="card card-transparent">
                            <div class="card-header">
                                <h3 class="card-title">Add Commercial</h3>
                                <a style="float: right;" class="btn btn-success swalDefaultSuccess" href="{{route('ViewNewCommercial')}}">View All New Commercials</a>
                            </div>

                            @php
                                $users = getUserCompanyData();
                                $kindOfWork = kindOfWork();
                                $marketPlace = getMarketPlace();
                                $typeOfService = getTypeOfService();
                                $getTypeOfShootList = getTypeOfShootList();
                                $getProductList = getProductList();
                                $AdaptationsList = getAdaptationsList();
                                
                                // pre($AdaptationsList);
                            @endphp
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
                                    // pre($newCommercial);
                                    $shootCheckIsDone = $newCommercial['shootCheckIsDone'];
                                    $cgCheckIsDone = $newCommercial['cgCheckIsDone'];
                                    $catCheckIsDone = $newCommercial['catCheckIsDone'];
                                    $editorCheckIsDone = $newCommercial['editorCheckIsDone'];
                                    $check_disabled = '';
                                    $show_submit = 1;
                                    $btn_display = "";
                                    if($shootCheckIsDone == 2 || $cgCheckIsDone == 2 || $catCheckIsDone == 2 || $editorCheckIsDone == 2){
                                        $show_submit = 0;
                                        $check_disabled = "disabled";
                                        $btn_display = "d-none";
                                    }
                                    $formRoute = 'SaveNewCommercial';
                                    $btn_Name = 'Create Commercial';
                                    $btn_title = "Commercial Not Created";
                                    $btn_disabled = "disabled";

                                    if($newCommercial['id'] > 0){
                                        $formRoute = 'UpdateNewCommercial';
                                        $btn_Name = 'Update Commercial';
                                        $btn_disabled = "";
                                        $btn_title = "Fill All Required fields";
                                    }

                                    
                                @endphp
                                <div class="custom-panel-form-group">
                                    <form action="{{route($formRoute)}}" method="post" class="comm-panel-form" id="panelForm2">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-4 col-12">
                                                <div class="form-group">
                                                    <input type="hidden" name="id" value="{{$newCommercial['id']}}">
                                                    <input type="hidden" name="c_short" id="c_short" value="{{$newCommercial['c_short']}}">
                                                    <input type="hidden" name="short_name" id="short_name" value="{{$newCommercial['short_name']}}">
                                                    <label class="control-label required">Company Name</label>

                                                    <select class="custom-select form-control-border"
                                                        name="commCompanyId" id="commcompanyNameP" onchange="validateNewCommercialForm()">
                                                        <option value="0">Select Company Name</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                data-client_id="{{ $user->client_id }}" data-c_short="{{ $user->c_short }}">
                                                                {{ $user->Company . ' (' . $user->client_id . ')' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <script>
                                                    document.querySelector("#commcompanyNameP").value = "{{$newCommercial['commCompanyId'] }}"
                                                </script>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label class="control-label required">Brand Name</label>
                                                    <select class="custom-select form-control-border" name="commBrandId"
                                                        id="commbrandNameP" onchange="validateNewCommercialForm()">
                                                        <option value="0"  data-short_name="" > -- Select Brand Name -- </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label class="control-label required">Client ID</label>
                                                    <input readonly type="text" class="form-control" name="commClientID"
                                                        id="commClientID" placeholder="Client ID"
                                                        value="{{$newCommercial['commClientID']}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row custom-check-row">
                                            <div class="col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label class="control-label required">Select Service(s) to generate
                                                        Commercial</label>
                                                    <div class="custom-two-check">
                                                        <div class="checkcontainer">
                                                            <input {{$check_disabled}} type="checkbox"  {{$newCommercial['commshootcheck'] == 1 ? 'checked' : ''}} class="panel-checkbox" name="commshootcheck" id="commshootcheck" value="1" onclick="validateNewCommercialForm()">
                                                            <span class="checkmark"></span>
                                                            Shoot
                                                        </div>
                                                        <div class="checkcontainer">
                                                            <input {{$check_disabled}}  type="checkbox" {{$newCommercial['commcgcheck'] == 1 ? 'checked' : ''}} class="panel-checkbox" name="commcgcheck" id="commcgcheck" value="1" onclick="validateNewCommercialForm()">
                                                            <span class="checkmark"></span>
                                                            Creative Graphics
                                                        </div>
                                                        <div class="checkcontainer">
                                                            <input {{$check_disabled}} type="checkbox" {{$newCommercial['commcatcheck'] == 1 ? 'checked' : ''}} class="panel-checkbox" name="commcatcheck" id="commcatcheck" value="1" onclick="validateNewCommercialForm()">
                                                            <span class="checkmark"></span>
                                                            Cataloging
                                                        </div>
                                                        <div class="checkcontainer">
                                                            <input {{$check_disabled}} type="checkbox" {{$newCommercial['commEditorcheck'] == 1 ? 'checked' : ''}} class="panel-checkbox" name="commEditorcheck" id="commEditorcheck" value="1" onclick="validateNewCommercialForm()">
                                                            <span class="checkmark"></span>
                                                            Editing
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-12">
                                                <div class="btn-form-group">
                                                    <div class="custom-action-btn-wrapper">
                                                        @if ($show_submit == 1)
                                                        @endif
                                                        <button type="submit" class="btn btn-warning {{$btn_display}}" id="genCommBTN">{{$btn_Name}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Other Forms --}}
                    <div class="panel-accrodian-wrapper">
                        <div class="accordian-item-wrapper" id="commaccordionPanel">
                            {{-- Shoot secction  --}}
                            <div class="accordian-item" id="commshoot-accor-item" style="display:none;">
                                <div class="card card-transparent">
                                    <div class="card-header acc-card-header" id="commshootAccor" data-toggle="collapse"
                                        data-target="#commshootcollapse" aria-expanded="true"
                                        aria-controls="commshootcollapse">
                                        <h3 class="card-title">
                                            <span class="card-text">
                                                Shoot
                                            </span>
                                            <i class="right fas fa-angle-left"></i>
                                        </h3>
                                    </div>
                                    <div id="commshootcollapse" class="collapse" aria-labelledby="commshootAccor"
                                        data-parent="#commaccordionPanel">
                                        <div class="card-body">
                                            @php
                                                // pre($data_array);
                                                if(count($data_array['shootCommercialArr']) > 0){
                                                    extract($data_array['shootCommercialArr']);
                                                }else{
                                                    
                                                    $product_category = "";
                                                    $type_of_shoot = "";
                                                    $type_of_clothing = "";
                                                    $gender = "";
                                                    $adaptation_1 = $adaptation_2 = $adaptation_3 = $adaptation_4 = $adaptation_5 = "";
                                                    $commercial_value_per_sku = "";
                                                }
                                            @endphp
                                            <form action="{{route('saveShootCommercial')}}" method="post" id="commshootForm">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-sm-3 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Product Category</label>

                                                            <input type="hidden" id="newCommercialId" name="newCommercialId" value="{{$newCommercial['id']}}">
                                                            <input type="hidden" name="user_id" value="{{$newCommercial['commCompanyId']}}">
                                                            <input type="hidden" name="brand_id" value="{{$newCommercial['commBrandId']}}">

                                                            <select class="custom-select form-control-border" name="product_category" id="commproductCat" onchange="validateShootForm()">
                                                                <option value="">Select Product Category</option>
                                                                 @foreach($getProductList as $index => $getProduct)
                                                                    @php
                                                                        $selected = "";
                                                                    @endphp
                                                                    <option {{ $selected }} value="{{$getProduct}}">{{$getProduct}}</option>
                                                                @endforeach
                                                            </select>
                                                            <script>
                                                                document.getElementById("commproductCat").value = "{{ $product_category }}";
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Type of Shoot</label>
                                                            <select class="custom-select form-control-border"
                                                                name="type_of_shoot" id="commshootType" onchange="validateShootForm()">
                                                                <option value="">Select Type of Shoot</option>
                                                                 @foreach($getTypeOfShootList as $index => $typeOfShoot)
                                                                    @php
                                                                        $selected = "";
                                                                    @endphp
                                                                    <option {{ $selected }} value="{{$typeOfShoot}}">{{$typeOfShoot}}</option>
                                                                @endforeach
                                                            </select>
                                                            <script>
                                                                document.getElementById("commshootType").value = "{{ $type_of_shoot }}";
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Type of Clothing</label>
                                                            <select class="custom-select form-control-border"
                                                                name="type_of_clothing" id="commclothingType" onchange="validateShootForm()">
                                                                <option value="">Select Type of Clothing</option>
                                                                <option value="Sets">Sets</option>
                                                                <option value="Mix">Mix</option>
                                                                <option value="Combo">Combo</option>
                                                                <option value="Topwear">Topwear</option>
                                                                <option value="Bottom Wear">Bottom Wear</option>
                                                            </select>
                                                            <script>
                                                                document.getElementById("commclothingType").value = "{{ $type_of_clothing }}";
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Gender</label>
                                                            <select class="custom-select form-control-border"
                                                                name="gender" id="commGender" onchange="validateShootForm()">
                                                                <option value="">Select Gender</option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                                <option value="Others">Others</option>
                                                            </select>
                                                            <script>
                                                                document.getElementById("commGender").value = "{{ $gender }}";
                                                            </script>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Primary
                                                                Adaptation</label>
                                                            <select class="custom-select form-control-border"
                                                                name="adaptation_1" id="commPAdpt" onchange="validateShootForm()">
                                                                <option value="">Select Primary Adaptation</option>
                                                                @foreach($AdaptationsList as $index => $adaptations)
                                                                    @php
                                                                        $selected = "";
                                                                    @endphp
                                                                    <option {{ $selected }} value="{{$adaptations}}">{{$adaptations}}</option>
                                                                @endforeach
                                                            </select>
                                                            <script>
                                                                document.getElementById("commPAdpt").value = "{{ $adaptation_1 }}";
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Adaptation 1</label>
                                                            <select class="custom-select form-control-border"
                                                                name="adaptation_2" id="commAdpt1" onchange="validateShootForm()">
                                                                <option value="">Select Adaptation 1</option>
                                                                @foreach($AdaptationsList as $index => $adaptations)
                                                                    @php
                                                                        $selected = "";
                                                                    @endphp
                                                                    <option {{ $selected }} value="{{$adaptations}}">{{$adaptations}}</option>
                                                                @endforeach
                                                            </select>
                                                            <script>
                                                                document.getElementById("commAdpt1").value = "{{ $adaptation_2 }}";
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Adaptation 2</label>
                                                            <select class="custom-select form-control-border"
                                                                name="adaptation_3" id="commAdpt2" onchange="validateShootForm()">
                                                                <option value="">Select Adaptation 2</option>
                                                                @foreach($AdaptationsList as $index => $adaptations)
                                                                    @php
                                                                        $selected = "";
                                                                    @endphp
                                                                    <option {{ $selected }} value="{{$adaptations}}">{{$adaptations}}</option>
                                                                @endforeach
                                                            </select>
                                                            <script>
                                                                document.getElementById("commAdpt2").value = "{{ $adaptation_3 }}";
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Adaptation 3</label>
                                                            <select class="custom-select form-control-border"
                                                                name="adaptation_4" id="commAdpt3" onchange="validateShootForm()">
                                                                <option value="">Select Adaptation 3</option>
                                                                @foreach($AdaptationsList as $index => $adaptations)
                                                                    @php
                                                                        $selected = "";
                                                                    @endphp
                                                                    <option {{ $selected }} value="{{$adaptations}}">{{$adaptations}}</option>
                                                                @endforeach
                                                            </select>
                                                            <script>
                                                                document.getElementById("commAdpt2").value = "{{ $adaptation_3 }}";
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Adaptation 4</label>
                                                            <select class="custom-select form-control-border"
                                                                name="adaptation_5" id="commAdpt4" onchange="validateShootForm()">
                                                                <option value="">Select Adaptation 4</option>
                                                                @foreach($AdaptationsList as $index => $adaptations)
                                                                    @php
                                                                        $selected = "";
                                                                    @endphp
                                                                    <option {{ $selected }} value="{{$adaptations}}">{{$adaptations}}</option>
                                                                @endforeach
                                                            </select>
                                                            <script>
                                                                document.getElementById("commAdpt4").value = "{{ $adaptation_5 }}";
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Commercial per
                                                                SKU</label>
                                                            <input type="text" class="form-control" name="commercial_value_per_sku" value="{{$commercial_value_per_sku}}" id="commSKU" placeholder="Enter Commercial per SKU"  onkeypress="return isNumber(event);" onchange="validateShootForm()">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="btn-form-group">
                                                            <div class="custom-action-btn-wrapper">
                                                                 @if ($shootCheckIsDone != 2)
                                                                    @if ($newCommercial['commshootcheck'] == 1 )
                                                                        <button title="{{$btn_title}}"  {{$btn_disabled}} type="submit" class="btn btn-warning" id="commshsaveBTN">  Save  </button>
                                                                    @endif
                                                                @else
                                                                    <p style="color: #00ff00">Shoot Commercial Already Saved</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--  Creative Graphics secction  --}}
                            <div class="accordian-item" id="commcg-accor-item" style="display:none;">
                                <div class="card card-transparent">
                                    <div class="card-header acc-card-header" id="commcgAccor" data-toggle="collapse"
                                        data-target="#commcgcollapse" aria-expanded="true"
                                        aria-controls="commcgcollapse">
                                        <h3 class="card-title">
                                            <span class="card-text">
                                                Creative Graphics
                                            </span>
                                            <i class="right fas fa-angle-left"></i>
                                        </h3>
                                    </div>
                                    <div id="commcgcollapse" class="collapse" aria-labelledby="commcgAccor"
                                        data-parent="#commaccordionPanel">
                                        <div class="card-body">
                                            @php
                                                // pre($data_array);
                                                if(count($data_array['cgCommercialArr']) > 0){
                                                    extract($data_array['cgCommercialArr']);
                                                }else{
                                                    $project_name = "";
                                                    $kind_of_work = "";
                                                    $per_qty_value = "";
                                                }
                                            @endphp
                                            <form action="{{route('SaveCreativeCommercial')}}" method="post" id="commcgForm">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Project Name</label>
                                                           
                                                            <input type="hidden" name="newCommercialId" value="{{$newCommercial['id']}}">
                                                            <input type="hidden" name="user_id" value="{{$newCommercial['commCompanyId']}}">
                                                            <input type="hidden" name="brand_id" value="{{$newCommercial['commBrandId']}}">

                                                            <input type="text" class="form-control" name="commProjectName" id="commProjectName" value="{{$project_name}}" placeholder="Enter Project Name" onkeypress="return isAlphabet(event);"  onchange="validateCreativeForm()">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Kind of Work</label>
                                                            <select class="custom-select form-control-border" name="commWorkType" id="commWorkType"  onchange="validateCreativeForm()">
                                                                <option value="">Select Kind of Work</option>
                                                                @foreach ($kindOfWork as $row)
                                                                    <option value="{{ $row['value'] }}">{{ $row['value'] }}</option>
                                                                @endforeach
                                                            </select>
                                                            <script>
                                                                document.getElementById("commWorkType").value = "{{ $kind_of_work }}";
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Commercial Per
                                                                Qty</label>
                                                            <input type="text" class="form-control" name="commQty" value="{{$per_qty_value}}"  id="commQty" placeholder="Enter Commercial Per Qty" onkeypress="return isNumber(event);" onkeyup="validateCreativeForm()">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="btn-form-group">
                                                            <div class="custom-action-btn-wrapper">
                                                                @if ($cgCheckIsDone != 2)
                                                                    @if ($newCommercial['commcgcheck'] == 1 )
                                                                        <button title="{{$btn_title}}"  {{$btn_disabled}} type="submit" class="btn btn-warning" id="commcgsaveBTN">Save</button>
                                                                    @endif
                                                                 @else
                                                                    <p  style="color: #00ff00">Creative Commercial Already Saved</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Cataloging secction  --}}
                            <div class="accordian-item" id="comm-ct-accor-item" style="display:none;">
                                <div class="card card-transparent">
                                    <div class="card-header acc-card-header" id="commctAccor" data-toggle="collapse"
                                        data-target="#commctcollapse" aria-expanded="true"
                                        aria-controls="commctcollapse">
                                        <h3 class="card-title">
                                            <span class="card-text">
                                                Cataloging
                                            </span>
                                            <i class="right fas fa-angle-left"></i>
                                        </h3>
                                    </div>
                                    <div id="commctcollapse" class="collapse" aria-labelledby="commctAccor"
                                        data-parent="#commaccordionPanel">
                                        <div class="card-body">
                                            @php
                                                // pre($data_array);
                                                if(count($data_array['catlogingCommercialArr']) > 0){
                                                    extract($data_array['catlogingCommercialArr']);
                                                }else{
                                                    $market_place = "";
                                                    $type_of_service = "";
                                                    $CommercialSKU = "";
                                                }
                                                $commercial_id_is = 0;
                                                if($market_place != ''){
                                                    $market_place_arr = explode(',',$market_place);
                                                    $commercial_id_is = count($market_place_arr);
                                                }
                                            @endphp
                                            <form action="{{route('SaveCatalogingCommercial')}}" method="post" id="commctForm">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-sm-4 col-12">
                                                        <div class="form-group">

                                                            <input type="hidden" name="newCommercialId" value="{{$newCommercial['id']}}">
                                                            <input type="hidden" name="user_id" value="{{$newCommercial['commCompanyId']}}">
                                                            <input type="hidden" name="brand_id" value="{{$newCommercial['commBrandId']}}">

                                                            <label class="control-label required">Marketplace</label>
                                                            <select class="custom-select form-control-border"
                                                                name="market_place[]" id="commMarketplace" multiple="multiple" onchange="validateCatalogingForm()" >
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
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Type of Service</label>
                                                            <select class="custom-select form-control-border"
                                                                name="commctseviceType" id="commctseviceType" onchange="validateCatalogingForm()">
                                                                <option value="">Select Type of Service</option>
                                                                @foreach($typeOfService as $index => $service)
                                                                    <option value="{{$service}}">{{$service}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Commercial Per
                                                                Unit</label>
                                                            <input type="text" class="form-control" name="commUnit"
                                                                id="commUnit" placeholder="Enter Commercial Per Unit" onkeypress="return isNumber(event);" onkeyup="validateCatalogingForm()">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="btn-form-group">
                                                            <div class="custom-action-btn-wrapper">
                                                                @if ($catCheckIsDone != 2)
                                                                    @if ($newCommercial['commcatcheck'] == 1 )
                                                                        <button title="{{$btn_title}}"  {{$btn_disabled}} type="submit" class="btn btn-warning" id="commctsaveBTN">  Save  </button>
                                                                    @endif
                                                                @else
                                                                    <p style="color: #00ff00">Cataloging Commercial Already Saved</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Editing secction  --}}
                            <div class="accordian-item" id="comm-Editor-accor-item" style="display:none;">
                                <div class="card card-transparent">
                                    <div class="card-header acc-card-header" id="commEditorAccor" data-toggle="collapse"
                                        data-target="#commEditorcollapse" aria-expanded="true"
                                        aria-controls="commEditorcollapse">
                                        <h3 class="card-title">
                                            <span class="card-text">
                                                Editing
                                            </span>
                                            <i class="right fas fa-angle-left"></i>
                                        </h3>
                                    </div>
                                    
                                    <div id="commEditorcollapse" class="collapse" aria-labelledby="commEditorAccor"
                                        data-parent="#commaccordionPanel">
                                        <div class="card-body">
                                            @php
                                                // pre($data_array);
                                                if(count($data_array['editorCommercialArr']) > 0){
                                                    $editorCommercialArr = $data_array['editorCommercialArr'];
                                                    extract($data_array['editorCommercialArr']);
                                                }else{
                                                    $type_of_service = "";
                                                    $CommercialPerImage = "";
                                                }
                                            @endphp
                                            <form action="{{route('SaveEditorCommercial')}}" method="post" id="commctForm">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Type of Service</label>
                                                            <select class="custom-select form-control-border"
                                                                name="type_of_service" id="type_of_service" onchange="validateEditorForm()">
                                                                <option value="">Select Type of Service</option>
                                                                <option value="Background Change">Background Change</option>
                                                                <option value="Image Enhancement">Image Enhancement</option>
                                                                <option value="scraping">scraping</option>
                                                                <option value="Image Enhancement & Background Change">Image Enhancement & Background Change</option>
                                                                <option value="scraping & Background Change">scraping & Background Change</option>
                                                            </select>
                                                            <script>
                                                                document.getElementById("type_of_service").value = "{{ $type_of_service }}";
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label required">Commercial Per
                                                                Image</label>
                                                            <input type="text" class="form-control" name="CommercialPerImage"  value="{{$CommercialPerImage}}"
                                                                id="CommercialPerImage" placeholder="Enter Commercial Per Image" onkeypress="return isNumber(event);" onkeyup="validateEditorForm()">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="btn-form-group">
                                                            <div class="custom-action-btn-wrapper">
                                                                <input type="hidden" name="newCommercialId" value="{{$newCommercial['id']}}">
                                                                <input type="hidden" name="user_id" value="{{$newCommercial['commCompanyId']}}">
                                                                <input type="hidden" name="brand_id" value="{{$newCommercial['commBrandId']}}">
                                                                @if ($editorCheckIsDone != 2)
                                                                    @if ($newCommercial['commEditorcheck'] == 1 )
                                                                        <button title="{{$btn_title}}"  {{$btn_disabled}} type="submit" class="btn btn-warning" id="commEditorSaveBTN">  Save  </button>
                                                                    @endif
                                                                @else
                                                                    <p style="color: #00ff00">Editors Commercial Already Saved</p>
                                                                @endif
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
    {{-- Check box actiion Script --}}
    <script>
        // Commercial Panel

        // Display Shoot Accodian
        $("#commshootcheck").change(function() {
            if (this.checked) {
                $('#commshoot-accor-item').css('display', 'block');
            } else if (!this.checked) {
                $('#commshoot-accor-item').css('display', 'none');
            }
        });

        // Display Creative Accodian
        $("#commcgcheck").change(function() {
            if (this.checked) {
                $('#commcg-accor-item').css('display', 'block');
            } else if (!this.checked) {
                $('#commcg-accor-item').css('display', 'none');
            }
        });

        // Display Catalog Accodian
        $("#commcatcheck").change(function() {
            if (this.checked) {
                $('#comm-ct-accor-item').css('display', 'block');
            } else if (!this.checked) {
                $('#comm-ct-accor-item').css('display', 'none');
            }
        });

        // Display Editors Accodian
        $("#commEditorcheck").change(function() {
            if (this.checked) {
                $('#comm-Editor-accor-item').css('display', 'block');
            } else if (!this.checked) {
                $('#comm-Editor-accor-item').css('display', 'none');
            }
        });
    </script>

    {{-- data for update $newCommercial['commcatcheck'] --}}
    <script>
        const commshootcheck_is = +"{{ $newCommercial['commshootcheck'] }}";
        const commcgcheck_is = +"{{ $newCommercial['commcgcheck'] }}";
        const commcatcheck_is = +"{{ $newCommercial['commcatcheck'] }}";
        const commEditorcheck_is = +"{{ $newCommercial['commEditorcheck'] }}";
        const user_id_val_is = +"{{ $newCommercial['commCompanyId'] }}";
        const saved_brand_id_is = +"{{ $newCommercial['commBrandId'] }}";
    </script>

    {{-- Validation for Add NewCommercial Commercial Form  --}}
    <script>
        function validateNewCommercialForm(){
            const eleman = document.getElementById('genCommBTN');
            eleman.setAttribute("disabled", true);
            const commcompanyNameP = +$('#commcompanyNameP').val();
            const commbrandNameP = +$('#commbrandNameP').val();
            const commshootcheck = $('#commshootcheck').is(':checked')
            const commcgcheck = $('#commcgcheck').is(':checked')
            const commcatcheck = $('#commcatcheck').is(':checked')
            const commEditorcheck = $('#commEditorcheck').is(':checked')
            // console.log({commcompanyNameP , commbrandNameP ,commshootcheck ,commcgcheck ,commcatcheck})
            if(commcompanyNameP > 0 && commbrandNameP > 0 && (commshootcheck || commcgcheck || commcatcheck || commEditorcheck)){
                eleman.removeAttribute("disabled");
            }
        }
        validateNewCommercialForm()
    </script>
   
    {{-- Validation for Shoot Form   --}}
    <script>
        function validateShootForm(){
            const commshsaveBTN = document.getElementById('commshsaveBTN');
            commshsaveBTN.setAttribute("disabled", true);

            const newCommercialId = +$('#newCommercialId').val();
            const commproductCat = $('#commproductCat').val();
            const commshootType = $('#commshootType').val();
            const commclothingType = $('#commclothingType').val();
            const commGender = $('#commGender').val();
            const commPAdpt = $('#commPAdpt').val();
            const commAdpt1 = $('#commAdpt1').val();
            const commAdpt2 = $('#commAdpt2').val();
            const commAdpt3 = $('#commAdpt3').val();
            const commAdpt4 = $('#commAdpt4').val();
            const commSKU = +$('#commSKU').val();

            if( newCommercialId > 0 && commproductCat != ""  &&  commshootType != ""  &&  commclothingType != ""  &&  commGender != ""  &&  commPAdpt != ""  &&  commAdpt1 != ""  &&  commAdpt2 != ""  &&  commAdpt3 != ""  &&  commAdpt4 != ""  &&  commSKU > 0){
                commshsaveBTN.removeAttribute("disabled");
            }
        }
        validateShootForm()
    </script>

    {{-- Validation for Creative Graphics Form   --}}
    <script>
        function validateCreativeForm(){
            const saveBtn = document.getElementById('commcgsaveBTN');
            saveBtn.setAttribute("disabled", true);

            const newCommercialId = +$('#newCommercialId').val();
            const commProjectName = $('#commProjectName').val();
            const commWorkType = $('#commWorkType').val();
            const commQty = +$('#commQty').val();
           
            if( newCommercialId > 0 && commProjectName != ""  &&  commWorkType != "" &&  commQty > 0){
                saveBtn.removeAttribute("disabled");
            }
        }
        validateCreativeForm()
    </script>

    {{-- Validation for Cataloging Form   --}}
    <script>
        function validateCatalogingForm(){
            const saveBtn = document.getElementById('commctsaveBTN');
            saveBtn.setAttribute("disabled", true);

            const newCommercialId = +$('#newCommercialId').val();
            const commMarketplace = $('#commMarketplace').val();
            const commctseviceType = $('#commctseviceType').val();
            const commUnit = +$('#commUnit').val();
            // console.log(commMarketplace)
            // console.log({commctseviceType , commUnit , newCommercialId })
            if( newCommercialId > 0 && commMarketplace.length > 0  &&  commctseviceType != "" &&  commUnit > 0){
                saveBtn.removeAttribute("disabled");
            }
        }
        validateCatalogingForm()
    </script>

    {{-- Validation for Cataloging Form   --}}
    <script>
        function validateEditorForm(){
            const saveBtn = document.getElementById('commEditorSaveBTN');
            saveBtn.setAttribute("disabled", true);

            const newCommercialId = +$('#newCommercialId').val();
            const type_of_service = $('#type_of_service').val();
            const CommercialPerImage = +$('#CommercialPerImage').val();
            // console.log(commMarketplace)
            // console.log({commctseviceType , commUnit , newCommercialId })
            if( newCommercialId > 0  &&  type_of_service != "" &&  CommercialPerImage > 0){
                saveBtn.removeAttribute("disabled");
            }
        }
        validateEditorForm()
    </script>

    {{-- 
    // console.log({
            //     newCommercialId,
            //     commproductCat,
            //     commshootType,
            //     commclothingType,
            //     commGender,
            //     commPAdpt,
            //     commAdpt1,
            //     commAdpt2,
            //     commAdpt3,
            //     commAdpt4,
            //     commSKU,
            // })    
    --}}
   


    <!-- script for setting short_name -->
    <script type="text/javascript">
        $("#commbrandNameP").change(function() { 
            const short_name = $("#commbrandNameP").find(':selected').data('short_name');
                $("#short_name").val(short_name);
        });
    </script>

    {{-- get-brand List --}}
    <script>
        $(document).ready(function() {
            $("#commcompanyNameP").change(async function() {
                const user_id_is = +$("#commcompanyNameP").val();
                const client_id = $("#commcompanyNameP").find(':selected').data('client_id')
                const c_short = $("#commcompanyNameP").find(':selected').data('c_short')

                // client_id
                $("#commClientID").val(client_id);
                $("#c_short").val(c_short);
                let options = `<option value="0"> -- Select Brand Name -- </option>`;
                document.getElementById("commbrandNameP").innerHTML = "";
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
                                ` <option value="${brands.brand_id}"  data-short_name="${brands.short_name}" > ${brands.name}</option>`;
                        })
                    }
                });
                document.getElementById("commbrandNameP").innerHTML = options;
                if (saved_brand_id_is > 0 && user_id_val_is === user_id_is) {
                    document.getElementById("commbrandNameP").value = saved_brand_id_is;
                    console.log({saved_brand_id_is, user_id_val_is , user_id_is})
                    $("#commbrandNameP").trigger("change"); 
                }
            });
        })
    </script>

    {{-- code for updation --}}
    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('#msg_div').attr("style", "display:none")
            }, 2000);
            if(user_id_val_is > 0){
                $("#commcompanyNameP").trigger("change"); 
                if(commshootcheck_is == 1){
                    $('#commshoot-accor-item').css('display', 'block');
                }

                if(commcgcheck_is == 1){
                    $('#commcg-accor-item').css('display', 'block');
                }

                if(commcatcheck_is == 1){
                    $('#comm-ct-accor-item').css('display', 'block');
                }

                if(commEditorcheck_is == 1){
                    $('#comm-Editor-accor-item').css('display', 'block');
                }
            }
        })
    </script>

    <!-- End of Commercial Panel -->
@endsection
