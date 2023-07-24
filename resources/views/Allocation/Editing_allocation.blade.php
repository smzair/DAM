
@extends('layouts.admin')

@section('title')
Editing Allocation
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
                    <h3 class="card-title"> {{ $allocation_type == 2 ? 'Re-':''}}Allocation - To be Allocated</h3>
                    <a style="float: right;" class="btn btn-success swalDefaultSuccess" href="{{route('Editing_Allocation_Details')}}">Allocation Details</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">

                    {{-- getCataloguer --}}

                    @php
                        $getCataloguer = getCataloguer();
                        $editorsList = getEditors();
                        // $wrcList_arr = array_column($wrcList, 'wrc_number', 'id');
                        // pre($market_place_arr);
                        // pre($wrcList);
                    @endphp
                    <table id="allocTableC" class="table table-head-fixed text-nowrap data-table">
                        <thead>
                            <tr>
                                <th>WRC</th>
                                <th>LOT Numbers</th>
                                <th>Company Name</th>
                                <th>Brand Name</th>
                                <th>Type of Service</th>
                                <th>WRC Created At</th>
                                <th>Tentative Image Count</th>
                                <th>Uploaded Tentative Image Count</th>
                                <th>Allocated Qty</th>
                                <th>Pending Qty</th>
                                {{-- 
                                <th>CW Allocated Qty</th>
                                <th>CW Pending Qty</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            @foreach($wrcList as $key => $row)

                                <tr id="tr{{ $key }}" >
                                    <td data-value="wrc_number">
                                        {{ $row['wrc_number'] }}
                                    </td>
                                    <td data-value="lot_number">{{ $row['lot_number'] }}</td>
                                    <td data-value="Company">{{ $row['Company'] }}</td>
                                    <td data-value="name">{{ $row['name'] }}
                                    </td>
                                    <td data-value="type_of_service">{{ $row['type_of_service'] }}</td>
                                    <td data-value="wrc_cr_at">{{ dateFormet_dmy($row['created_at']) }}</td>
                                    <td data-value="imgQty">{{ $row['imgQty'] }}</td>
                                    <td data-value="uploaded_img_qty">{{ $row['uploaded_img_qty'] }}</td>
                                    <td id="editors_sum{{ $key }}" data-value="editors_sum">{{ $row['editors_sum'] }}</td>
                                    <td id="editors_pending{{ $key }}" data-value="editors_pending">{{ $row['uploaded_img_qty'] - $row['editors_sum'] }}</td>
                                    <td>
                                        <button class="btn btn-warning" id="allocateBTnC" data-toggle="modal"  data-target="#allocateWRCPopupCAt" onclick="setvalue({{ $key }})"> Allocate </button>
                                    </td>
                                    <input type="hidden" id="wrc_id{{ $key }}" value="{{ $row['wrc_id'] }}">
                                    <input type="hidden" id="work_initiate_date{{ $key }}"  value="{{ $row['work_initiate_date'] }}">
                                    <input type="hidden" id="work_committed_date{{ $key }}"  value="{{ $row['work_committed_date'] }}">
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
                            <div class="col-sm-4 col-6">
                                <div class="col-ac-details">
                                    <h6>WRC Number</h6>
                                    <p id="wrcNo"></p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-6">
                                <div class="col-ac-details">
                                    <h6>Tentative Image Count</h6>
                                    <p id="imgQty"></p>
                                </div>
                            </div>

                            <div class="col-sm-4 col-6">
                                <div class="col-ac-details">
                                    <h6>Selected LOT</h6>
                                    <input id="lot_number" rows="3" cols="4" style="width: 100%;" disabled />
                                </div>
                            </div>
                        </div>
                        {{-- Editor Allocated SKU --}}
                        <div class="row ">
                            <div class="col-sm-4 col-6">
                                <div class="col-ac-details">
                                    <h6>Uploaded Image Count</h6>
                                    <p id="uploaded_img_qty"></p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="col-ac-details">
                                    <h6>Editor Allocated SKU</h6>
                                    <p id="editor_allocated_qty"></p>
                                </div>
                            </div>
                             <div class="col-sm-4 col-12">
                                <div class="col-ac-details">
                                    <h6>Editor Pending SKU</h6>
                                    <p id="Editor_pending_sku">5</p>
                                </div>
                            </div>
                            {{-- Copy Writer Allocated SKU  --}}
                            {{-- <div class="col-sm-6">
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
                            </div> --}}
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                 <div class="form-group">
                                    <label class="control-label w-100 required" for="work_initiate_date_is">Work Initiate Date <span style="color: red">*</span></label>
                                    <input class="form-control" type="date" name="work_initiate_date_is" id="work_initiate_date_is">
                                </div>
                                <p class="input_err" style="color: red; display: none;"  id="work_initiate_date_is_err"></p>

                            </div>
                            {{-- <div class="col-sm-2">
                            </div> --}}

                            <div class="col-sm-4">
                                 <div class="form-group">
                                    <label class="control-label  w-100 required" for="work_committed_date_is">Work Committed Date <span style="color: red">*</span></label>
                                    <input class="form-control" type="date" name="work_committed_date_is" id="work_committed_date_is">
                                </div>
                                <p class="input_err" style="color: red; display: none;"  id="work_committed_date_is_err"></p>

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
                                        <label class="control-label required">Allocate Editor</label>
                                        <select class="custom-select form-control-border Editor-name" name="editorName"  id="editorName" style="width:100%;">
                                            <option value=""  data-name="">--Select Editor--</option>
                                            @foreach ($editorsList as $row)
                                                <option value="{{ $row->id }}" data-name="{{ $row->name }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="group-inner input-wrapper">
                                        <label class="control-label">Qty</label>
                                        <input type="text" class="form-control" onkeypress="return isNumber(event);" name="editor_Qty" id="editor_Qty" >
                                    </div> 
                                </div>
                                <p class="input_err" style="color: red; display: none;"  id="user_id_err"></p>
                            </div>
                            {{-- Select copywriter Dropdown --}}
                            {{-- <div class="col-sm-6 col-12" id="copy_writer_row" style="display: block">
                                <div class="form-group custom-new-form-group">
                                    <div class="group-inner select-wrapper">
                                        <label class="control-label required">Allocate copywriter</label>
                                        <select class="custom-select form-control-border Editor-name" name="copywriterName"  id="copywriterName" style="width:100%;">
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
                            </div> --}}

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
<script>
    let allocation_type_is = +'{{$allocation_type}}'
</script>

{{-- setvalue to model --}}
<script>
   async function setvalue(val){
        document.querySelector("#editorName").value = "";
        document.querySelector("#editor_Qty").value = "";
        let data = {}
        var rowItems = $("#tr"+val).children('td').map(function () {
            data = {
                ...data,
                [this.getAttribute('data-value')]: this.innerHTML
            }
        })
        
        const wrc_id_is = document.querySelector("#wrc_id"+val).value
        const imgQty = data.imgQty
        const uploaded_img_qty = data.uploaded_img_qty
        const work_initiate_date_is = document.querySelector("#work_initiate_date"+val).value
        const work_committed_date_is = document.querySelector("#work_committed_date"+val).value
        console.log({work_initiate_date_is, work_committed_date_is , wrc_id_is, data})
        
        document.querySelector("#work_initiate_date_is").value =  work_initiate_date_is != '0000:00:00' ? work_initiate_date_is : ''
        document.querySelector("#work_committed_date_is").value =  work_committed_date_is != '0000:00:00' ? work_committed_date_is : ''
        document.querySelector("#key_is").value =  val
        document.querySelector("#wrc_id").value =  wrc_id_is
        document.querySelector("#wrcNo").innerHTML = data.wrc_number
        document.querySelector("#imgQty").innerHTML = imgQty
        document.querySelector("#uploaded_img_qty").innerHTML = uploaded_img_qty
        document.querySelector("#lot_number").value = data.lot_number
        document.querySelector("#editor_allocated_qty").innerHTML = data.editors_sum
        document.querySelector("#Editor_pending_sku").innerHTML = data.editors_pending
        
        // await $.ajax({ 
        //     url: "{{ url('Editing-allocated-sku-count') }}",
        //     type: "POST",
        //     dataType: 'json',
        //     data: {
        //         wrc_id: wrc_id_is,
        //         batch_no: batch_no_is,
        //         _token: '{{ csrf_token() }}'
        //     },
        //     success: function(res) {
        //         if(res !== 0){
        //             cataloger_sum = res[0].cataloger_sum;
        //             cp_sum = res[0].cp_sum;
        //             if(cataloger_sum == null){
        //                 cataloger_sum = 0;
        //             }
        //             if(cp_sum == null){
        //                 cp_sum = 0
        //             }
        //             document.querySelector("#editor_allocated_qty").innerHTML = cataloger_sum 
        //             document.querySelector("#Editor_pending_sku").innerHTML = sku_qty - cataloger_sum 
        //             document.querySelector("#cp_allocated_sku").innerHTML = cp_sum 
        //             document.querySelector("#cp_pending_sku").innerHTML = sku_qty - cp_sum 
        //         }else{
        //             cataloger_sum = 0;
        //             cp_sum = 0;
        //             document.querySelector("#editor_allocated_qty").innerHTML = cataloger_sum 
        //             document.querySelector("#Editor_pending_sku").innerHTML = sku_qty - cataloger_sum 
        //             document.querySelector("#cp_allocated_sku").innerHTML = cp_sum 
        //             document.querySelector("#cp_pending_sku").innerHTML = sku_qty - cp_sum 
        //         }
        //     }
        // });
    }
</script>

{{-- save Data to allocation   --}}
<script>
    const saveData = async () => {
        $(".input_err").css("display", "none");

        const wrc_id =  document.querySelector("#wrc_id").value 
        const batch_no =  document.querySelector("#batch_no").value 
        const user_id_is =  document.querySelector("#editorName").value 
        let editor_Qty =  +document.querySelector("#editor_Qty").value
        const Editor_pending_sku = +document.querySelector("#Editor_pending_sku").innerHTML 
        const editorName = $("#editorName").find(':selected').data('name');
        const editor_allocated_qty =   +document.querySelector("#editor_allocated_qty").innerHTML 

        const key_is =  document.querySelector("#key_is").value 
        const wrc_batch_id_is =  document.querySelector("#wrc_batch_id_is").value 
        const work_initiate_date_is =  document.querySelector("#work_initiate_date_is").value 
        const work_committed_date_is =  document.querySelector("#work_committed_date_is").value 

        if(work_initiate_date_is == ''){
            document.querySelector("#work_initiate_date_is_err").innerHTML  = "Work Initiate Date not selected "
            $("#work_initiate_date_is_err").css("display", "block");
            return
        }
        if(work_committed_date_is == ''){
            document.querySelector("#work_committed_date_is_err").innerHTML  = "Work Commited Date not selected "
            $("#work_committed_date_is_err").css("display", "block");
            return
        }

       
        if(user_id_is === '' || user_id_is == 0){
            document.querySelector("#user_id_err").innerHTML  = "Editor not selected "
            $("#user_id_err").css("display", "block");
            return
        }
        if(user_id_is > 0 &&  (editor_Qty < 1 || editor_Qty == '')){
            let qtyMsg = "Qty should be greter then 0"
            document.querySelector("#user_id_err").innerHTML  = qtyMsg
            $("#user_id_err").css("display", "block");
            return
        }

        if(editor_Qty > Editor_pending_sku){
            document.querySelector("#user_id_err").innerHTML  = "Allocated qty is more then pending qty";
            if(Editor_pending_sku === 0){
                document.querySelector("#user_id_err").innerHTML  = "No qty for allocation";
                document.querySelector("#editorName").value = "";
            }
            document.querySelector("#editor_Qty").value = "";
            $("#user_id_err").css("display", "block");
            return
        }

        await $.ajax({
            url: "{{ url('set-Editing-allocation') }}",
            type: "POST",
            dataType: 'json',
            data: {
                user_id: user_id_is,
                editor_Qty,
                wrc_id,
                batch_no,
                wrc_batch_id_is,
                work_initiate_date_is,
                work_committed_date_is,
                allocation_type : allocation_type_is,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                if(res.update_status){
                    document.querySelector("#work_initiate_date"+key_is).value = work_initiate_date_is
                    document.querySelector("#work_committed_date"+key_is).value = work_committed_date_is
                }

                if(user_id_is > 0 && editor_Qty > 0){
                    if(res.user == 1){
                        document.querySelector("#editorName").value = "";
                        document.querySelector("#editor_Qty").value = "";
                        $("#msg_box1").css("color", "green");
                        const editors_sum = editor_allocated_qty + editor_Qty
                        const editors_pending = Editor_pending_sku - editor_Qty
                        document.querySelector("#editor_allocated_qty").innerHTML  = editors_sum
                        document.querySelector("#editors_sum"+key_is).innerHTML  = editors_sum
                        document.querySelector("#Editor_pending_sku").innerHTML  = editors_pending
                        document.querySelector("#editors_pending"+key_is).innerHTML  = editors_pending
                        document.querySelector("#msg_box1").innerHTML  = "Wrc allocated to "+editorName+" Successfully"
                    }else if(res.user == 3){
                        document.querySelector("#editorName").value = "";
                        document.querySelector("#editor_Qty").value = "";
                        $("#msg_box1").css("color", "red");
                        document.querySelector("#msg_box1").innerHTML  = "This Wrc already allocated to "+editorName;
                    }else if(res.user == 2) {
                        $("#msg_box1").css("color", "red");
                        document.querySelector("#msg_box1").innerHTML  = "Somthing went Wrong please try again!!!"
                    }
                    $("#msg_box1").css("display", "block");
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