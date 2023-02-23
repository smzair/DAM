@extends('layouts.admin')
@section('title')
All WRCs Batch Panel
@endsection
@section('content')
<div class="lot-table mt-1">
    <div class="container-fluid">
        <div class="row">
            @if (Session::has('success'))
                        <div class="alert alert-success" id="msg_div" role="alert">
                            {{ Session::get('success') }}
                        </div>
            @endif
            <div class="col-12">
                <div class="card card-transparent">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-7 col-md-6 col-sm-12">
                                <h3 class="card-title text-black text-bold">
                                    <span class="d-inline-block align-middle">
                                        All WRCs Batch Panel
                                    </span>
                                    <span class="mr-2 ml-1 d-inline-block" style="position: relative; top: 1px;">|</span>
                                </h3>
                                <div class="card-tools float-left">
                                    <ul class="list-unstyled m-0 mt-lg-0 mt-md-1 lot-list">
                                        <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Inworded">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #FFFF00;"></span>
                                        </li>
                                        <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Inwording Completed">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #FF8000;"></span>
                                        </li>
                                        <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Ready For Shoot">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #606060;"></span>
                                        </li>
                                        <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Shoot Done">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #4C0099;"></span>
                                        </li>
                                        <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Ready For QC">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #000000;"></span>
                                        </li>
                                        <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Ready For Submission">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #0066CC;"></span>
                                        </li>
                                        <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Approved">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #00CC00;"></span>
                                        </li>
                                        <li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="Rejected">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #FF0000;"></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-12">
                                <div class="card-tools float-md-right float-sm-none ml-md-0 mr-0 ml-sm-0 mt-sm-1 float-none ml-xs-0 mt-1">
                                    <a class="btn btn-xs float-left align-middle mt-0 mr-2 py-1 px-2 mb-1" href="{{ route('CREATEWRC') }}" style="position: relative; top: 2px;">Add New WRC</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                        <table id="wrcTable" class="table table-head-fixed table-hover text-nowrap data-table">
                            <thead>
                                <tr class="wrc-tt">
                                    <th class="p-2">Id</th>
                                    <th class="p-2">LOT Number</th>
                                    <th class="p-2">WRC Number</th>
                                    <th class="p-2">Company Name</th>
                                    <th class="p-2">Brand Name</th>
                                    <th class="p-2">Project Name</th>
                                    <th class="p-2">Kind Of Work</th>
                                    <th class="p-2">WRC Created At</th>
                                    <th class="p-2">Order Quantity</th>
                                    <th class="p-2">Sku Counts</th>
                                    <th class="p-2">Batch No</th>
                                    <th class="p-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wrcs as $key => $wrc)
                                <tr class="wrc-tt">
                                    <td class="p-sm-2 p-1">{{$key+1}}</td>
                                    <td id="lot_number{{$key}}" class="p-sm-2 p-1">{{$wrc->lot_number}}</td>
                                    <td id="sku_required{{$key}}" class="p-sm-2 p-1" style="display: none">{{$wrc->sku_required}}</td>
                                    <td id="wrc_id{{$key}}" class="p-sm-2 p-1" style="display: none">{{$wrc->id}}</td>
                                    <td id="wrc_number{{$key}}" class="p-sm-2 p-1">{{$wrc->wrc_number}}  <span class="cpy-clipboardtable" id="copyBTnTable"></i></span> </td>
                                    <td id="company_name{{$key}}" class="p-sm-2 p-1">{{$wrc->Company_name}}</td>
                                    <td id="brand_name{{$key}}" class="p-sm-2 p-1">{{$wrc->name}}</td>
                                    <td id="project_name{{$key}}" class="p-sm-2 p-1">{{$wrc->project_name}}</td>
                                    <td id="kind_of_work{{$key}}" class="p-sm-2 p-1">{{$wrc->kind_of_work}}</td>
                                    <td id="createdAt" class="p-sm-2 p-1">{{dateFormat($wrc->created_at)}}<br><b>{{timeFormat($wrc->created_at)}}</b></td>
                                    <td id="orderQuantity{{$key}}" class="p-sm-2 p-1">{{$wrc->order_qty == null ? 0 : $wrc->order_qty}}</td>
                                    <td id="skuQuantity{{$key}}" class="p-sm-2 p-1">{{$wrc->sku_count}}</td>
                                    <td title="None for not retainer and other for retainer" id="batchQuantity{{$key}}" class="p-sm-2 p-1">{{$wrc->batch_no == 0 ? 'None' : $wrc->batch_no}}</td>
                                    <td class="p-sm-2 p-1">
                                    <div class="btn-group-vertical">
                                        <a href="#" class="btn btn-warning alloc-action-btn" data-toggle="modal" data-target="#inverdnewPopup" onclick='setdata(<?php echo $key;?>)'>
                                            Inward New
                                        </a>
                                    </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->
                </div>

                <!-- /.card-body -->
                <form class="" method="POST" action="{{ route('INVERD_NEW_BATCH') }}" id="uploadCreativeAllocForm" onsubmit="return validateForm(event)" enctype="multipart/form-data">
                    @csrf
                    <div class="modal fade inverdnewPopup" id="inverdnewPopup">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header py-2">
                                    <h4 class="modal-title" id="modal_title">Inward New Batch</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick='resetdata()'> 
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <input type="hidden" name="creative_allocation_id" class="creative_allocation_id" value="" />
                                <input type="hidden" name="user_role" class="user_role" value="" />
                                <input type="hidden" name="sku_required" class="sku_required" value="" />
                                <input type="hidden" name="wrc_id" class="wrc_id" value="" />
                                <div class="modal-body">
                                    <div class="custom-dt-row work-details">
                                        <div class="row">

                                            <div class="col-sm-3 col-12">
                                                <div class="col-ac-details">
                                                    <h6>Selected LOT</h6>
                                                    <p class="selectedLot"></p>
                                                </div>
                                            </div>

                                            <div class="col-sm-3 col-12">
                                                <div class="col-ac-details">
                                                    <h6>WRC Number</h6>
                                                    <p class="wrcNo"> </p>
                                                </div>
                                            </div>

                                            <div class="col-sm-3 col-12">
                                                <div class="col-ac-details">
                                                    <h6>Total Batch Count</h6>
                                                    <p class="totalBatchCount"></p>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-3 col-6" style="display: none">
                                                <div class="col-ac-details">
                                                    <h6>Brand Name</h6>
                                                    <p class="brndName"></p>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-6" style="display: none">
                                                <div class="col-ac-details">
                                                    <h6>Project Type</h6>
                                                    <p class="projectType"></p>
                                                </div>
                                            </div>

                                            <div class="col-sm-3 col-12 hideTotalSkuCount">
                                                <div class="col-ac-details">
                                                    <h6>Total SKU Count</h6>
                                                    <p class="totalSkuCount"></p>

                                                </div>
                                            </div>

                                            <div class="col-sm-3 col-12 hideTotalOrderQty">
                                                <div class="col-ac-details">
                                                    <h6>Order Qty</h6>
                                                    <p class="totalOrderQty"></p>
                                                </div>
                                            </div>

                                            <div class="col-sm-3 col-6">
                                                <div class="col-ac-details">
                                                    <h6>Kind of Work</h6>
                                                    <p class="kindOfWork"></p>
                                                </div>
                                            </div>

                                            

                                           
                                        </div>
                                    </div>
                                    <div class="custom-dt-row">
                                        <form class="" method="POST" action="" id="workdetailsform">
                                            <div class="row">
                                               
                                                <div class="col-sm-6 col-12 hodeOrderQtyInput" >
                                                    <div class="custom-info">
                                                        <p><h3>Inwarding Batch Information</h3></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="hideTotalSkuCountLable" id="gd_link_required" >SKU Count</label>
                                                        <label class="hideTotalOrderQtyLable" id="gd_link_required">Order Qty</label>
                                                        <input type="text" class="form-control creative_link" name="sku_order_count" id="sku_order_count"  placeholder="Enter Order Qty" value="" onkeypress="return isNumber(event);">
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-sm-6 col-12 hodeSkuFileInput">
                                                    <p><h3>Upload SKU Sheet</h3></p>
                                                    <div class="col-sm-2 col-12">
                                                        {{-- <label for="files" class="btn">Upload Sheet</label> --}}
                                                        <input id="files" type="file" name="sku_sheet" class="btn btn-success btn-xl btn-warning mb-2">
                                                    </div>
                                                    

                                                </div>

                                                <div class="col-sm-6 col-12">
                                                    
                                                    {{-- <button type="submit" name="submit" value="save" class="btn btn-warning" id="save_btn" href="javascript:void(0)" style="float:right;margin-right:10px;display: flex" >Save</button>

                                                    <button type="submit" name = "submit" value="complete_allocation" class="btn btn-warning" href="javascript:void(0)" style="float:right;margin-right:10px">Save & Add Another</button> --}}

                                                </div>

                                            </div>
                                            <div class="row" style="float:right">
                                                    
                                                    <button type="submit" name="submit" value="save" class="btn btn-warning" id="save_btn" href="javascript:void(0)" style="float:right;margin-right:10px;display: flex" >Save</button>

                                                    {{-- <button type="submit" name = "submit" value="complete_allocation" class="btn btn-warning" href="javascript:void(0)" style="float:right;margin-right:10px">Save & Add Another</button> --}}

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- End of Table -->

<!-- DataTable Plugins Path -->

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<!-- End of DataTable Plugins Path -->

<script>
    $('#wrcTable').DataTable({
        dom: 'lBfrtip',
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "buttons": ["copy", "csv", "excel", "pdf"]
    }).buttons().container().insertAfter('#masterData_wrapper .dataTables_length');
</script>

{{-- script for show file name --}}
<script>
    // $(".file_name_field").css("display", "none");
    $("#files").change(function() {
    filename = this.files[0].name;
    $("#file_name_field").html(filename);
    document.getElementById("file_name_field").style.display = "flex";
    console.log(filename);
});
</script>

<!-- get dynamic data in modal -->
<script>
    function setdata(id){
        console.log('first', id)

        // set order qty
        const orderQuantity_td = "orderQuantity"+id;
        const orderQuantity = document.getElementById(orderQuantity_td).innerHTML;
        document.querySelector('.totalOrderQty').innerHTML = orderQuantity;

        if(orderQuantity == 0){
            document.querySelector('.hideTotalOrderQty').style.display = 'none';
            document.querySelector('.hideTotalOrderQtyLable').style.display = 'none';
            document.querySelector('.hodeOrderQtyInput').style.display = 'none';

           
        }

        // set sku qty
        const skuQuantity_td = "skuQuantity"+id;
        const skuQuantity = document.getElementById(skuQuantity_td).innerHTML;
        document.querySelector('.totalSkuCount').innerHTML = skuQuantity;

        if(skuQuantity == 0){
            document.querySelector('.hideTotalSkuCount').style.display = 'none';
            document.querySelector('.hideTotalSkuCountLable').style.display = 'none';
            document.querySelector('.hodeSkuFileInput').style.display = 'none';
        }

        //set total Batch Count
        const batchQuantity_td = "batchQuantity"+id;
        const batchQuantity = document.getElementById(batchQuantity_td).innerHTML;
        document.querySelector('.totalBatchCount').innerHTML = batchQuantity;

        // set sku required
        const sku_required_td = "sku_required"+id;
        const sku_required = document.getElementById(sku_required_td).innerHTML;
        document.querySelector('.sku_required').value = sku_required;

        // sku_required == 0 means no sku needed insert order qty
        if(sku_required != 0){
            document.querySelector('#sku_order_count').disabled = true;
        }

        // sku_required == 0 means no sku needed insert order qty
        if(sku_required == 0){
            document.querySelector('#files').disabled = true;
        }

         // set wrc id 
         const wrc_id_td = "wrc_id"+id;
        const wrc_id = document.getElementById(wrc_id_td).innerHTML;
        document.querySelector('.wrc_id').value = wrc_id;

        // set wrc number
        const wrc_number_td = "wrc_number"+id;
        const wrc_number = document.getElementById(wrc_number_td).innerHTML;
        document.querySelector('.wrcNo').innerHTML = wrc_number;

        // set wrc number
        const lot_number_td = "lot_number"+id;
        const lot_number = document.getElementById(lot_number_td).innerHTML;
        document.querySelector('.selectedLot').innerHTML = lot_number;

        // set brand name
        const brand_name_td = "brand_name"+id;
        const brand_name = document.getElementById(brand_name_td).innerHTML;
        document.querySelector('.brndName').innerHTML = brand_name;

         //set  project name
         const project_name_td = "project_name"+id;
        const project_name = document.getElementById(project_name_td).innerHTML;
        document.querySelector('.projectType').innerHTML = project_name;

        //set kind of work
        const kind_of_work_td = "kind_of_work"+id;
        const kind_of_work = document.getElementById(kind_of_work_td).innerHTML;
        document.querySelector('.kindOfWork').innerHTML = kind_of_work;

        // //set total Batch Count
        // const batchQuantity_td = "batchQuantity"+id;
        // const batchQuantity = document.getElementById(batchQuantity_td).innerHTML;
        // document.querySelector('.totalBatchCount').innerHTML = batchQuantity;
    }
</script>

{{-- reset enable disable of sku and order qty modal reset--}}
<script> 
    
    function resetdata(){
        $(".inverdnewPopup").on("hidden.bs.modal", function(){
            document.querySelector('#sku_order_count').disabled = false;
            document.querySelector('#sku_order_count').value = '';
            document.querySelector('#files').disabled = false;
            document.querySelector('.hideTotalOrderQty').style.display = 'block';
            document.querySelector('.hideTotalSkuCount').style.display = 'block';
            document.querySelector('.hideTotalOrderQtyLable').style.display = 'block';
            document.querySelector('.hideTotalSkuCountLable').style.display = 'block';
            document.querySelector('.hodeOrderQtyInput').style.display = 'block';
            document.querySelector('.hodeSkuFileInput').style.display = 'block';


        });
    }
</script>
<!-- msg div script -->
<script>
    setTimeout(function(){
        document.getElementById('msg_div').style.display = "none";
    },3000)
</script>
@endsection