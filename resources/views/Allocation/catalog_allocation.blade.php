
@extends('layouts.admin')

@section('title')
Catalogin Allocation
@endsection
@section('content')
<!-- New Allocation View -->

<!-- New Allocation Table View (For Catalogue) -->

<div class="container-fluid mt-5 plan-shoot new-allocation-table-main">
     <style>

        .custom-new-form-group {
            display: flex;
            flex-wrap: nowrap;
            justify-content: space-between;
        }

        .group-inner.select-wrapper {
            flex: 1 1 auto;
            max-width: 80%;
        }

          .group-inner.input-wrapper {
            flex: 0 0 auto;
            max-width: 20%;
            padding-left: 10px;
        }
        .input_err , #msg_box{
            margin: 0.1em 0;
            background: #928c8cfc;
            display: block;
            padding: 0.3em;
        }

        .msg_box{
            margin: 0.1em 0;
            background: #928c8cfc;
            display: none;
            padding: 0.3em;
        }
    </style>

    <style>
        @media (min-width: 992px){
            .modal-lg, .modal-xl {
                min-width: 950px !important;
            }
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card card-transparent">
                <div class="card-header">
                    {{-- <h3 class="card-title">Catalog Allocation</h3> --}}
                    <h3 class="card-title">Allocation - To be Allocated</h3>
                    <a style="float: right;" class="btn btn-success swalDefaultSuccess" href="{{route('CATALOG_ALLOCTED_DETAILS')}}">Allocation Details</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">

                    {{-- getCataloguer --}}

                    @php
                        $getCataloguer = getCataloguer();
                        $getcopywriter = getcopywriter();
                        $MarketPlaces = getMarketPlace();
                        $market_place_arr = array_column($MarketPlaces, 'marketPlace_name', 'id');
                        // $wrcList_arr = array_column($wrcList, 'wrc_number', 'id');
                        // pre($market_place_arr);
                        // pre($wrcList_arr);
                    @endphp
                    <table id="allocTableC" class="table table-head-fixed text-nowrap data-table">
                        <thead>
                            <tr>
                                <th>WRC</th>
                                <th>LOT Numbers</th>
                                <th>Company Name</th>
                                <th>Brand Name</th>
                                <th>Marketplace</th>
                                <th>Type of Service</th>
                                <th>WRC Created At</th>
                                <th>Batch Number</th>
                                <th>SKU Count</th>
                                <th>Cata Allocated Qty</th>
                                <th>Cata Pending Qty</th>
                                <th>CW Allocated Qty</th>
                                <th>CW Pending Qty</th>
                                {{-- <th>Request Receive Date</th> --}}
                                {{-- <th>Raw Image Receive Date</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            @foreach($wrcList as $key => $row)
                                @php

                                    if($key == 1){
                                        // pre($row);
                                    }
                                    // echo " key => $key "; batch_no

                                    $sku_qty = $row['sku_qty'];
                                    $cataloger_sum = $row['cataloger_sum'];
                                    $cp_sum = $row['cp_sum'];
                                    $batch_no = $row['batch_no'] > 0 ? $row['batch_no'] : 'None';
                                    if($row['batch_no'] > 0){
                                        $batch_no_is = ($row['batch'] != '' && $row['batch'] != null) ? $row['batch'] : $row['batch_no'];
                                    }else{
                                        $batch_no_is =  'None';
                                    }

                                    if($cataloger_sum > 0 || $cp_sum > 0){
                                        continue;
                                    }

                                    $alloacte_to_copy_writer = $row['alloacte_to_copy_writer'];
                                    $market_place = $row['market_place'];

                                    $market_place_ids = explode(',',$market_place);

                                    if(($alloacte_to_copy_writer == 1 && ($sku_qty - $cp_sum) == 0)){

                                    }
                                
                                @endphp

                                <tr id="tr{{ $key }}" >
                                    <td data-value="wrc_number">
                                        {{ $row['wrc_number'] }}
                                    </td>
                                    <td data-value="lot_number">{{ $row['lot_number'] }}</td>
                                    <td data-value="Company">{{ $row['Company'] }}</td>
                                    <td data-value="name">{{ $row['name'] }}
                                        
                                    </td>
                                    <td data-value="market_place">
                                        @foreach ($market_place_ids as $id)
                                            <p class="m-0">{{ $market_place_arr[$id] }}</p>
                                        @endforeach
                                    </td>
                                    <td data-value="type_of_service">{{ $row['type_of_service'] }}</td>
                                    <td data-value="wrc_cr_at">{{ dateFormet_dmy($row['created_at']) }}</td>
                                    <td data-value="batch_no">{{ $batch_no_is }}</td>
                                    <td data-value="sku_qty">{{ $row['sku_qty'] }}</td>

                                    <td data-value="cataloger_sum">{{ $row['cataloger_sum'] }}</td>
                                    <td data-value="cataloger_pen">{{ $row['sku_qty'] - $row['cataloger_sum'] }}</td>
                                    <td data-value="cp_sum">{{ $row['cp_sum'] }}</td>
                                    <td data-value="cp_pen">{{ $row['alloacte_to_copy_writer'] == 1 ? $row['sku_qty'] - $row['cp_sum'] : 0 }}</td>
                                    {{-- <td data-value="img_recevied_date">{{ dateFormet_dmy($row['img_recevied_date']) }}</td> --}}
                                    {{-- <td data-value="raw_img_date">{{ dateFormet_dmy($row['created_at']) }}</td> --}}
                                    <td>
                                        <input type="hidden" id="wrc_id{{ $key }}" data-alloacte_to_copy_writer="{{ $row['alloacte_to_copy_writer'] }}" value="{{ $row['id'] }}">
                                        <input type="hidden" id="batch_no{{ $key }}"  value="{{ $row['batch_no'] }}">
                                        <input type="hidden" id="wrc_batch_id{{ $key }}"  value="{{ $row['wrc_batch_id'] }}">
                                        <input type="hidden" id="work_initiate_date{{ $key }}"  value="{{ $row['work_initiate_date'] }}">
                                        <input type="hidden" id="work_committed_date{{ $key }}"  value="{{ $row['work_committed_date'] }}">
                                        <button class="btn btn-warning" id="allocateBTnC" data-toggle="modal" 
                                        data-target="#allocateWRCPopupCAt" onclick="setvalue({{ $key }})">
                                            Allocate
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

<div class="modal fade allocation-wrc-modal" id="allocateWRCPopupCAt">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h4 class="modal-title">Shoot Allocation WRC</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <form class="" method="POST" action="" id="allocWRCform"> --}}
                    <div class="custom-dt-row wrc-details mb-3">
                        <div class="row mb-3">
                            <div class="col-sm-3 col-6">
                                <div class="col-ac-details">
                                    <h6>WRC Number</h6>
                                    <p id="wrcNo"></p>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="col-ac-details">
                                    <h6>SKU Count</h6>
                                    <p id="sku_qty"></p>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="col-ac-details">
                                    <h6>Batch Number</h6>
                                    <p id="batch_number"></p>
                                </div>
                            </div>

                            <div class="col-sm-3 col-6">
                                <div class="col-ac-details">
                                    <h6>Selected LOT</h6>
                                    <input id="lot_number" rows="3" cols="4" style="width: 100%;" disabled />
                                </div>
                            </div>
                        </div>
                        {{-- Cataloger Allocated SKU --}}
                        <div class="row ">
                            <div class="col-sm-3 col-12">
                                <div class="col-ac-details">
                                    <h6>Cataloger Allocated SKU</h6>
                                    <p id="cata_allocated_sku"></p>
                                </div>
                            </div>
                             <div class="col-sm-3 col-12">
                                <div class="col-ac-details">
                                    <h6>Cataloger Pending SKU</h6>
                                    <p id="cata_pending_sku">5</p>
                                </div>
                            </div>
                            {{-- </div> --}}
                            {{-- Copy Writer Allocated SKU  --}}
                            <div class="col-sm-6">
                                <div  id="copywriter_sky_row">
                                    <div class="col-sm-6 col-12">
                                        <div class="col-ac-details">
                                            <h6>Copy Writer Allocated SKU</h6>
                                            <p id="cp_allocated_sku">15</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="col-ac-details">
                                            <h6>Copy Writer Pending SKU</h6>
                                            <p id="cp_pending_sku">5</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                 <div class="form-group">
                                    <label class="control-label w-100 required" for="work_initiate_date_is">Work Initiate Date <span style="color: red">*</span></label>
                                    <input class="form-control" type="date" name="work_initiate_date_is" id="work_initiate_date_is">
                                </div>
                                <p class="" style="color: red; display: none;"  id="work_initiate_date_is_err"></p>

                            </div>
                            <div class="col-sm-2">
                            </div>

                            <div class="col-sm-4">
                                 <div class="form-group">
                                    <label class="control-label  w-100 required" for="work_committed_date_is">Work Committed Date <span style="color: red">*</span></label>
                                    <input class="form-control" type="date" name="work_committed_date_is" id="work_committed_date_is">
                                </div>
                                <p class="" style="color: red; display: none;"  id="work_committed_date_is_err"></p>

                            </div>
                             <div class="col-sm-2">
                            </div>
                        </div>
                    </div>
                    <div class="custom-dt-row allocater-selection"> 
                        {{-- Allocate users dropdwon row  --}}
                        <div class="row">
                            <div class="col-sm-6 col-12" id="Cataloguer_row">
                                <div class="form-group custom-new-form-group">
                                    <div class="group-inner select-wrapper">
                                        <label class="control-label required">Allocate Cataloguer</label>
                                        <select class="custom-select form-control-border Cataloguer-name" name="CataloguerName"  id="CataloguerName" style="width:100%;">
                                            <option value="">--Select Cataloguer--</option>
                                            @foreach ($getCataloguer as $row)
                                                <option value="{{ $row->id }}" data-name="{{ $row->name }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="group-inner input-wrapper">
                                        <label class="control-label">Qty</label>
                                        <input type="number" class="form-control" name="Cataloguer_Qty" id="Cataloguer_Qty">
                                    </div> 
                                </div>
                                <p class="input_err" style="color: red; display: none;"  id="user_id_err"></p>
                            </div>
                            {{-- Select copywriter Dropdown --}}
                             <div class="col-sm-6 col-12" id="copy_writer_row" style="display: block">
                                <div class="form-group custom-new-form-group">
                                    <div class="group-inner select-wrapper">
                                        <label class="control-label required">Allocate copywriter</label>
                                        <select class="custom-select form-control-border Cataloguer-name" name="copywriterName"  id="copywriterName" style="width:100%;">
                                            <option value="" data-name="">--Select copywriter--</option>
                                            @foreach ($getcopywriter as $row)
                                                <option value="{{ $row->id }}" data-name="{{ $row->name }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="group-inner input-wrapper">
                                        <label class="control-label">Qty</label>
                                        <input type="number" class="form-control" name="copywriter_Qty" id="copywriter_Qty">
                                    </div> 
                                </div>
                                <p class="input_err" style="color: red; display: none;" id="copywriter_err"></p>
                            </div>

                            <div class="col-sm-12 col-12" style="text-align: end">
                                <input id="wrc_id" name="wrcNo" type="hidden" value="">
                                <input id="batch_no" name="batch_no" type="hidden" value="">
                                <input id="wrc_batch_id_is" name="wrc_batch_id_is" type="hidden" value="">
                                <input id="key_is" name="key" type="hidden" value="">
                                <button class="btn btn-warning" onclick="saveData()" >Complete Allocation</button>
                                <span class="msg_box" id="msg_box1" style="color: red; display: none;"></span>
                                <span class="msg_box" id="msg_box2" style="color: red; display: none;"></span>
                            </div>
                        </div>
                    </div>
                {{-- </form> --}}
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

<!-- Data Table Calling Function -->

<script>
  $('#allocTableC').DataTable({
        dom: 'lBfrtip',
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "buttons": ["copy", "csv", "excel", "pdf"]
  }).buttons().container().insertAfter('#masterData_wrapper .dataTables_length');
</script>


{{-- setvalue to model --}}
<script>
   async function setvalue(val){
        document.querySelector("#CataloguerName").value = "";
        document.querySelector("#copywriterName").value = "";
        document.querySelector("#Cataloguer_Qty").value = "";
        document.querySelector("#copywriter_Qty").value = "";
        $("#copy_writer_row").css("display", "none");
        $("#copywriter_sky_row").css("display", "none");

        let data = {}
        var rowItems = $("#tr"+val).children('td').map(function () {
            data = {
                ...data,
                [this.getAttribute('data-value')]: this.innerHTML
            }
        })
        
        const wrc_id_is = document.querySelector("#wrc_id"+val).value
        const batch_no_is = document.querySelector("#batch_no"+val).value
        const sku_qty = data.sku_qty

        const wrc_batch_id_is = document.querySelector("#wrc_batch_id"+val).value
        const work_initiate_date_is = document.querySelector("#work_initiate_date"+val).value
        const work_committed_date_is = document.querySelector("#work_committed_date"+val).value

        document.querySelector("#wrc_batch_id_is").value =  wrc_batch_id_is
        document.querySelector("#work_initiate_date_is").value =  work_initiate_date_is != '0000:00:00' ? work_initiate_date_is : ''
        document.querySelector("#work_committed_date_is").value =  work_committed_date_is != '0000:00:00' ? work_committed_date_is : ''
        document.querySelector("#key_is").value =  val

        document.querySelector("#wrc_id").value =  wrc_id_is
        document.querySelector("#batch_no").value =  batch_no_is
        document.querySelector("#wrcNo").innerHTML = data.wrc_number
        document.querySelector("#batch_number").innerHTML = data.batch_no != 'None' ? data.batch_no : '-'
        document.querySelector("#sku_qty").innerHTML = sku_qty
        document.querySelector("#lot_number").value = data.lot_number
        const alloacte_to_copy_writer = $("#wrc_id"+val).data("alloacte_to_copy_writer") 
        console.log(alloacte_to_copy_writer)
        if(alloacte_to_copy_writer === 1){
            $("#copy_writer_row").css("display", "block");
            $("#copywriter_sky_row").css("display", "flex");
        }
        
        await $.ajax({
            url: "{{ url('catalog-allocated-sku-count') }}",
            type: "POST",
            dataType: 'json',
            data: {
                wrc_id: wrc_id_is,
                batch_no: batch_no_is,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                if(res !== 0){
                    cataloger_sum = res[0].cataloger_sum;
                    cp_sum = res[0].cp_sum;
                    if(cataloger_sum == null){
                        cataloger_sum = 0;
                    }
                    if(cp_sum == null){
                        cp_sum = 0
                    }
                    document.querySelector("#cata_allocated_sku").innerHTML = cataloger_sum 
                    document.querySelector("#cata_pending_sku").innerHTML = sku_qty - cataloger_sum 
                    document.querySelector("#cp_allocated_sku").innerHTML = cp_sum 
                    document.querySelector("#cp_pending_sku").innerHTML = sku_qty - cp_sum 
                }else{
                    cataloger_sum = 0;
                    cp_sum = 0;
                    document.querySelector("#cata_allocated_sku").innerHTML = cataloger_sum 
                    document.querySelector("#cata_pending_sku").innerHTML = sku_qty - cataloger_sum 
                    document.querySelector("#cp_allocated_sku").innerHTML = cp_sum 
                    document.querySelector("#cp_pending_sku").innerHTML = sku_qty - cp_sum 
                }
            }
        });
    }
</script>

{{-- save Data to allocation   --}}
<script>
    const saveData = async () => {

        const wrc_id =  document.querySelector("#wrc_id").value 
        const batch_no =  document.querySelector("#batch_no").value 
        const user_id_is =  document.querySelector("#CataloguerName").value 
        const Cataloguer_Qty =  +document.querySelector("#Cataloguer_Qty").value 
        const CataloguerName = $("#CataloguerName").find(':selected').data('name');
        
        const copywriter_id_is =  document.querySelector("#copywriterName").value 
        const copywriter_Qty =  +document.querySelector("#copywriter_Qty").value 
        const copywriterName = $("#copywriterName").find(':selected').data('name');

        const cata_allocated_sku =   +document.querySelector("#cata_allocated_sku").innerHTML 
        const cata_pending_sku   =   +document.querySelector("#cata_pending_sku").innerHTML 
        const cp_allocated_sku   =   +document.querySelector("#cp_allocated_sku").innerHTML 
        const cp_pending_sku     =   +document.querySelector("#cp_pending_sku").innerHTML 


        console.log({user_id_is,Cataloguer_Qty,wrc_id,batch_no,copywriter_id_is,copywriter_Qty})
        
        // console.log({user_id_is,CataloguerName, Cataloguer_Qty ,copywriter_id_is,copywriterName , copywriter_Qty})

        $(".input_err").css("display", "none");
        if(user_id_is === ''  &&  copywriter_id_is === ''){
            document.querySelector("#user_id_err").innerHTML  = "Cataloguer/copywriter not selected "
            $(".input_err").css("display", "block");
            $("#copywriter_err").css("display", "none");
            return
        }
        if(user_id_is > 0 &&  (Cataloguer_Qty < 1 || Cataloguer_Qty == '')){
            document.querySelector("#user_id_err").innerHTML  = "Qty not entered"
            $(".input_err").css("display", "block");
            $("#copywriter_err").css("display", "none");
            return
        }


        if(copywriter_Qty > cp_pending_sku){
            document.querySelector("#copywriter_err").innerHTML  = "Allocated qty is more then pending qty";
            if(cp_pending_sku === 0){
                document.querySelector("#copywriter_err").innerHTML  = "No qty for allocation";
                document.querySelector("#copywriterName").value = "";
            }
            document.querySelector("#copywriter_Qty").value = "";
            $("#copywriter_err").css("display", "block");
            return
        }

        if(Cataloguer_Qty > cata_pending_sku){
            document.querySelector("#user_id_err").innerHTML  = "Allocated qty is more then pending qty";
            if(cata_pending_sku === 0){
                document.querySelector("#user_id_err").innerHTML  = "No qty for allocation";
                document.querySelector("#CataloguerName").value = "";
            }
            document.querySelector("#Cataloguer_Qty").value = "";
            $("#user_id_err").css("display", "block");
            return
        }

        if(copywriter_id_is > 0 &&  (copywriter_Qty < 1 || copywriter_Qty == '')){
            document.querySelector("#copywriter_err").innerHTML  = "Qty not entered"
            $(".input_err").css("display", "block");
            $("#user_id_err").css("display", "none");
            return
        }

        const key_is =  document.querySelector("#key_is").value 
        const wrc_batch_id_is =  document.querySelector("#wrc_batch_id_is").value 
        const work_initiate_date_is =  document.querySelector("#work_initiate_date_is").value 
        const work_committed_date_is =  document.querySelector("#work_committed_date_is").value 

        console.log({work_initiate_date_is , work_committed_date_is })

        // debugger
        // if(work_initiate_date_is == ''){
        //     document.querySelector("#work_initiate_date_is_err").innerHTML  = "Work Initiate Date not selected "
        //     return
        // }

        await $.ajax({
            url: "{{ url('set-catalog-allocation') }}",
            type: "POST",
            dataType: 'json',
            data: {
                user_id: user_id_is,
                Cataloguer_Qty,
                wrc_id,
                batch_no,
                wrc_batch_id_is,
                work_initiate_date_is,
                work_committed_date_is,
                allocation_type : 1,
                copywriter_id : copywriter_id_is,
                copywriter_Qty,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                
                if(res.update_status){
                    document.querySelector("#work_initiate_date"+key_is).value = work_initiate_date_is
                    document.querySelector("#work_committed_date"+key_is).value = work_initiate_date_is
                }

                console.log(res.user)
                if(user_id_is > 0 && Cataloguer_Qty > 0){
                    if(res.user == 1){
                        document.querySelector("#CataloguerName").value = "";
                        document.querySelector("#Cataloguer_Qty").value = "";
                        $("#msg_box1").css("color", "green");
                        document.querySelector("#cata_allocated_sku").innerHTML  = cata_allocated_sku + Cataloguer_Qty
                        document.querySelector("#cata_pending_sku").innerHTML  = cata_pending_sku - Cataloguer_Qty
                        document.querySelector("#msg_box1").innerHTML  = "Catalog Wrc allocated to "+CataloguerName+" Successfully"
                    }else if(res.user == 3){
                        document.querySelector("#CataloguerName").value = "";
                        document.querySelector("#Cataloguer_Qty").value = "";
                        $("#msg_box1").css("color", "red");
                        document.querySelector("#msg_box1").innerHTML  = "This Wrc already allocated to "+CataloguerName;
                    }else if(res.user == 2) {
                        $("#msg_box1").css("color", "red");
                        document.querySelector("#msg_box1").innerHTML  = "Somthing went Wrong please try again!!!"
                    }
                    $("#msg_box1").css("display", "block");
                }

                if(copywriter_id_is > 0 && copywriter_Qty > 0){
                    if(res.copywriter == 1){
                        document.querySelector("#copywriterName").value = "";
                        document.querySelector("#copywriter_Qty").value = "";
                        document.querySelector("#cp_allocated_sku").innerHTML = cp_allocated_sku + copywriter_Qty
                        document.querySelector("#cp_pending_sku").innerHTML  = cp_pending_sku - copywriter_Qty
                        $("#msg_box2").css("color", "green");
                        document.querySelector("#msg_box2").innerHTML  = "Catalog Wrc allocated to "+copywriterName+" Successfully"
                    }else if(res.copywriter == 3){
                        document.querySelector("#copywriterName").value = "";
                        document.querySelector("#copywriter_Qty").value = "";
                        $("#msg_box2").css("color", "red");
                        document.querySelector("#msg_box2").innerHTML  = "This Wrc already allocated to "+copywriterName;
                    }else if(res.copywriter == 2) {
                        $("#msg_box2").css("color", "red");
                        document.querySelector("#msg_box2").innerHTML  = "Somthing went Wrong please try again!!!"
                    }
                    $("#msg_box2").css("display", "block");
                }
            }
        });
        setTimeout( () => {
            $(".input_err").css("display", "none");
            $('#msg_box1').html("");
            $('#msg_box2').html("");
            $("#msg_box1").css("display", "none");
            $("#msg_box2").css("display", "none");
        }, 3000);
    }
</script>
@endsection

<!-- End of Data Table Calling Function  -->