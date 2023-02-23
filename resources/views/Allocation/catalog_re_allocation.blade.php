
@extends('layouts.admin')

@section('title')

Creative Allocation

@endsection
@section('content')

<style type="text/css">
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

    .custom-info {
        width: 100%;
        display: block;
        margin-top: 16px;
    }

    .custom-info p {
        margin: 0;
    }

    .info-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: block;
    }

    .info-list > li {
        display: block;
        width: 100%;
        position: relative;
    }

    .info-list > li:not(:last-child) {
        margin-bottom: 4px;
    }

    .info-list > li > span, .info-list > li > a {
        display: inline-block;
    }

    .info-list > li > a:hover, .info-list > li > a:focus {
        text-decoration: underline !important;
    }

    .date, .time {
        display: block;
        width: 100%;
    }

    .time {
        font-weight: 700;
    }

    .allocation-wrc-modal .modal-body {
        padding: 1rem 1.2rem;
    }

    .alloc-action-btn.inactive {
        pointer-events: none;
        opacity: 0.5;
    }

    .card.card-transparent .table td .task-start-button .btn {
        background-color: #FBF702 !important;
        color: #000 !important;
        border-color: transparent;
        width: 100%;
    }

    .card.card-transparent .table td .task-start-button .btn:hover, 
    .card.card-transparent .table td .task-start-button .btn:focus {
        background-color: #ba8b00 !important;
    }

    .alloc-action-btn {
        display: block;
    }

    .alloc-action-btn:first-of-type {
        margin-bottom: 10px;
    }

</style>
<div class="container-fluid mt-5 plan-shoot new-allocation-table-main">
    <div class="row">
        <div class="col-12">
            <div class="card card-transparent">
                <div class="card-header">
                    <h3 class="card-title">Creative Allocation</h3>
                    @if (Session::has('success'))
                        <div class="alert alert-success" id="msg_div" role="alert">
                            {{ Session::get('success') }}
                        </div>
                        {{ Session::forget('success') }}
                    @endif
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
                    <table id="allocTable" class="table table-head-fixed text-nowrap data-table">
                        <thead>
                            <tr>
                                <th>WRC</th>
                                <th>LOT Numbers</th>
                                <th>Company Name</th>
                                <th>Brand Name</th>
                                <th>Project Type</th>
                                <th>Kind of Work</th>
                                <th>WRC Created At</th>
                                <th >Batches No</th>
                                <th>Allocated Users Name</th>
                                <th>Order Qty</th>
                                <th>Sku Qty</th>
                                <th>GD Allocated Qty</th>
                                <th>GD Pending Qty</th>
                                <th>CW Allocated Qty</th>
                                <th>CW Pending Qty</th>
                                <th>Work Initiate Date</th>
                                <th>Work Committed Date</th>
                              
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allocationList['resData']  as $key => $lotinfo)
                            <?php  if( ((($lotinfo['gd_allocated_qty'] == null || $lotinfo['gd_allocated_qty'] == 0) ? 0 : $lotinfo['gd_allocated_qty']) != 0) || ((($lotinfo['cw_allocated_qty'] == null || $lotinfo['cw_allocated_qty'] == 0) ? 0 : $lotinfo['cw_allocated_qty']) != 0)) {?>
                                <tr>
                                    {{-- <?php dd($lotinfo); ?> --}}
                                    <td id="wrc_number{{$key}}">{{$lotinfo['wrc_number']}}</td>
                                    <td style="display: none;" id="wrc_number_id{{$key}}">{{$lotinfo['wrc_id']}}</td>
                                    <td style="display: none;" id="alloacte_to_copy_writer{{$key}}">{{$lotinfo['alloacte_to_copy_writer']}}</td>
                                    <td id="lot_number{{$key}}">{{$lotinfo['lot_number']}}</td>
                                    <td id="Company{{$key}}">{{$lotinfo['Company']}}</td>
                                    <td id="brand_name{{$key}}">{{$lotinfo['brand_name']}}</td>
                                    <td id="project_name{{$key}}">{{$lotinfo['project_name']}}</td>
                                    <td id="kind_of_work{{$key}}">{{$lotinfo['kind_of_work']}}</td>
                                    <td id="created_at{{$key}}">{{dateFormat($lotinfo->created_at)}}<br><b>{{timeFormat($lotinfo->created_at)}}</td>
                                    <td title="0 for not retainer and other for retainer" id="batch_batch_no{{$key}}">{{$lotinfo['batch_batch_no'] != null ? $lotinfo['batch_batch_no'] : 'None'}}</td>
                                    <td id="brand_name{{$key}}">
                                        @foreach($lotinfo['allocated_users']  as $ukey => $uval)
                                        <ul>{{$uval['name']}}</ul>

                                        @endforeach
                                        
                                        
                                    
                                    
                                    </td>
                                    <!-- <td>{{--count($lotinfo['wrcs'])--}}</td> -->


                                    {{-- add this logic for lot with Retainer client bucket --start--}}
                                    <?php 
                                    if($lotinfo['client_bucket'] == 'Retainer'){ ?>
                                        <td id="order_qty{{$key}}">{{$lotinfo['batch_order_qty'] != null ? $lotinfo['batch_order_qty'] : 0}}</td>
                                        <td id="sku_count{{$key}}">{{$lotinfo['batch_sku_count'] != null ? $lotinfo['batch_sku_count'] : 0}}</td>
                                    <?php }else { ?>
                                        <td id="order_qty{{$key}}">{{$lotinfo['order_qty'] != null ? $lotinfo['order_qty'] : 0}}</td>
                                        <td id="sku_count{{$key}}">{{$lotinfo['sku_count'] != null ? $lotinfo['sku_count'] : 0}}</td>
                                    <?php  } ?>
                                    {{-- add this logic for lot with Retainer client bucket --end--}}
                                    

                                    <td id="gd_allocated_qty{{$key}}">{{($lotinfo['gd_allocated_qty'] == null || $lotinfo['gd_allocated_qty'] == 0) ? 0 : $lotinfo['gd_allocated_qty']}}</td>

                                    <?php 
                                    if($lotinfo['client_bucket'] == 'Retainer'){ ?>
                                        <td id="pending_qty_gd{{$key}}">{{ (($lotinfo['batch_order_qty'] == '' || $lotinfo['batch_order_qty'] == 0 || $lotinfo['batch_order_qty'] == null) ? $lotinfo['batch_sku_count'] : $lotinfo['batch_order_qty']) - $lotinfo['gd_allocated_qty']}}</td>

                                    <?php }else { ?>
                                        <td id="pending_qty_gd{{$key}}">{{ (($lotinfo['order_qty'] == '' || $lotinfo['order_qty'] == 0 || $lotinfo['order_qty'] == null) ? $lotinfo['sku_count'] : $lotinfo['order_qty']) - $lotinfo['gd_allocated_qty']}}</td>
                                    <?php  } ?>

                                    <td id="cw_allocated_qty{{$key}}">{{($lotinfo['cw_allocated_qty'] == null || $lotinfo['cw_allocated_qty'] == 0) ? 0 : $lotinfo['cw_allocated_qty']}}</td>

                                    <?php 
                                    if($lotinfo['client_bucket'] == 'Retainer'){ ?>
                                        <td id="pending_qty_cw{{$key}}">{{(($lotinfo['batch_order_qty'] == '' || $lotinfo['batch_order_qty'] == 0 || $lotinfo['batch_order_qty'] == null) ? $lotinfo['batch_sku_count'] : $lotinfo['batch_order_qty'])- $lotinfo['cw_allocated_qty']}}</td>

                                    <?php }else { ?>
                                        <td id="pending_qty_cw{{$key}}">{{(($lotinfo['order_qty'] == '' || $lotinfo['order_qty'] == 0 || $lotinfo['order_qty'] == null) ? $lotinfo['sku_count'] : $lotinfo['order_qty'])- $lotinfo['cw_allocated_qty']}}</td>
                                    <?php  } ?>
                                

                                   
                                    <td id="work_initiate_date{{$key}}">{{dateFormat($lotinfo->work_initiate_date)}}
                                        {{--<br> <b>{{timeFormat($lotinfo->work_initiate_date)}}</b> --}}
                                    </td>
                                    <td id="Comitted_initiate_date{{$key}}">{{dateFormat($lotinfo->Comitted_initiate_date)}}
                                        {{--<br> <b>{{timeFormat($lotinfo->Comitted_initiate_date)}}</b> --}}
                                    </td>
                                   
                                    <td>
                                        <button class="btn btn-warning" id="allocateBTn" data-toggle="modal" data-target="#allocateWRCPopup" onclick='setdata(<?php echo $key;?>)'>
                                            Allocate
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

<div class="modal fade allocation-wrc-modal" id="allocateWRCPopup">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h4 class="modal-title">Creative - Allocate WRC</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick='resetdata()'> 
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="custom-dt-row wrc-details">
                    <div class="row">

                        <div class="col-sm-4 col-6">
                            <div class="col-ac-details">
                                <h6>Selected LOT</h6>
                                <p class="selLot"></p>
                            </div>
                        </div>

                        <div class="col-sm-4 col-12">
                            <div class="col-ac-details">
                                <h6>WRC Number</h6>
                                <p class="wrcNo"></p>
                            </div>
                        </div>

                        <div class="col-sm-4 col-12">
                            <div class="col-ac-details">
                                <h6 title="0 for not retainer and other for retainer">Batches No</h6>
                                <p class="batchesNo"></p>
                            </div>
                        </div>
                        
                        <div class="col-sm-4 col-6">
                            <div class="col-ac-details">
                                <h6 class="hideTotalOrderQtyLable">Order Quantity</h6>
                                <h6 class="hideTotalSkuCountLable">Sku Count</h6>
                                <p class="QuntyCount"></p>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="col-ac-details">
                                <h6>GD Allocated Qty</h6>
                                <p class="AllocatedCountGd"></p>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="col-ac-details">
                                <h6>GD Pending Qty</h6>
                                <p class="PendingCountGd"></p>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="col-ac-details">
                                <h6>CW Allocated Qty</h6>
                                <p class="AllocatedCountCw"></p>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="col-ac-details">
                                <h6>CW Pending Qty</h6>
                                <p class="PendingCountCw"></p>
                            </div>
                        </div>
                       
                       
                        
                    </div>
                </div>
                <div class="custom-dt-row allocater-selection">
                    <form class="" method="POST" action="{{ route('CREATIVE_ALLOCATION_STORE') }}" id="allocWRCform" onsubmit="return validateForm(event)">
                        @csrf
                        <input type="hidden" name="wrc_id" class="wrc_id" value="" />
                        <input type="hidden" name="batch_no" class="batch_no" value="" />
                        <input type="hidden" name="alloacte_to_copy_writer" class="alloacte_to_copy_writer" value="" />
                        <?php
                            $reqArray = [1,2,3];

                            $graphicDesignerData = '<option selected value = 0>Select Graphic Designer</option>';
                            $copyWriterData = '<option selected value = 0>Select Copywriter</option>';    
                                                                 
                            foreach($allocationList['graphic_designer_users_data']  as $gkey => $gdata){
                                // dd($gdata->name);
                                $graphicDesignerData .= '<option value="'.$gdata->id.'">'.$gdata->name.'</option>';
                            }
                            foreach($allocationList['copy_writer_users_data']  as $ckey => $cdata){
                                $copyWriterData .= '<option value="'.$cdata->id.'">'.$cdata->name.'</option>';
                            }
                            $check = '';
                            foreach( $reqArray  as $data){
                               $check .= '<div class="col-sm-6 col-12">
                                    <div class="form-group custom-new-form-group">
                                        <div class="group-inner select-wrapper">
                                            <label class="control-label required">Graphic Designer '.$data.'</label>
                                            <select class="custom-select form-control-border designer-name GDNAMESTYLE'.$data.'" name="designerName[]" >
                                                 '.$graphicDesignerData.' 
                                            </select>
                                        </div>
                                        <div class="group-inner input-wrapper">
                                            <label class="control-label">Qty</label>
                                            <input type="text" class="form-control GDQTYSTYLE'.$data.'" id="GraphicDesignerQty"  onkeypress="return isNumber(event);" name="GraphicDesignerQty[]">
                                        </div>  
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12 CWSTYLE'.$data.'">
                                    <div class="form-group custom-new-form-group">
                                        <div class="group-inner select-wrapper">
                                            <label class="control-label required">Copy Writer '.$data.'</label>
                                            <select class="custom-select form-control-border copywriter-name CWNAMESTYLE'.$data.'" name="copywriterName[]">
                                             '.$copyWriterData.'
                                            </select>
                                        </div>
                                        <div class="group-inner input-wrapper">
                                            <label class="control-label">Qty</label>
                                            <input type="text" class="form-control CWQTYSTYLE'.$data.'" onkeypress="return isNumber(event);" name="copyWriterQty[]" id="copyWriterQty">
                                        </div>  
                                    </div>
                                </div>';
                            }
                        ?>
                          <div class="row">
                          <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label required">Work Initiate Date</label>
                                    <div class="input-group">
                                        {{-- <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div> --}}
                                        <input type="text" class="form-control int_date" name="int_date" id="int_date" placeholder="yyyy-mm-dd" data-toggle="datepicker" value="">
                                    </div>
                                    <p class="input_err" style="color: red; display: none;" id="int_date_err"></p>
                                </div>
                        </div>
                        <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label required">Work Committed Date</label>
                                    <div class="input-group">
                                        {{-- <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div> --}}
                                        <input type="text" class="form-control cmt_date" name="cmt_date" id="cmt_date" placeholder="yyyy-mm-dd" data-toggle="datepicker" value="">
                                    </div>
                                    <p class="input_err" style="color: red; display: none;" id="cmt_date_err"></p>
                                </div>
                        </div>
                          </div>
                        <div class="row">
                            <?= $check ?>
                            <div class="col-sm-12 col-12">
                                <button type="submit" class="btn btn-sm btn-warning md-2" >Complete Allocation</button>
                            </div>
                            <p class="input_err" style="color: red; display: none;" id="total_allocated_qty_err"></p>
                        </div>
                    </form>
                </div>
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

<script>
    $('#allocTable').DataTable({
        dom: 'lBfrtip',
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "buttons": ["copy", "csv", "excel", "pdf"]
    }).buttons().container().insertAfter('#masterData_wrapper .dataTables_length');
</script>

<!-- get dynamic data in modal -->
<script>
    function setdata(id){

        // document.querySelector("#CWQTYSTYLE1").value = "";
        // document.querySelector("#CWQTYSTYLE2").value = "";
        // document.querySelector("#CWQTYSTYLE2").value = "";
        // document.querySelector("#CWNAMESTYLE1").value = "";
        // document.querySelector("#CWNAMESTYLE2").value = "";
        // document.querySelector("#CWNAMESTYLE3").value = "";
        // document.querySelector("#GDQTYSTYLE1").value = "";
        // document.querySelector("#GDQTYSTYLE2").value = "";
        // document.querySelector("#GDQTYSTYLE2").value = "";
        // document.querySelector("#GDNAMESTYLE1").value = "";
        // document.querySelector("#GDNAMESTYLE2").value = "";
        // document.querySelector("#GDNAMESTYLE3").value = "";
        

        // set order qty
        const order_qty_td = "order_qty"+id;
        const order_qty = document.getElementById(order_qty_td).innerHTML;

        // set sku  qty
        const sku_count_td = "sku_count"+id;
        const sku_count = document.getElementById(sku_count_td).innerHTML; 

        if(order_qty == 0){
            document.querySelector('.hideTotalOrderQtyLable').style.display = 'none';
            document.querySelector('.hideTotalSkuCountLable').style.display = 'block';
            document.querySelector('.QuntyCount').innerHTML = sku_count;
        }

        if(sku_count == 0){
            document.querySelector('.hideTotalSkuCountLable').style.display = 'none';
            document.querySelector('.hideTotalOrderQtyLable').style.display = 'block';
            document.querySelector('.QuntyCount').innerHTML = order_qty;
        }

        

        // set copy writer allocated qty
        const cw_allocated_qty_td = "cw_allocated_qty"+id;
        const cw_allocated_qty = document.getElementById(cw_allocated_qty_td).innerHTML;
        document.querySelector('.AllocatedCountCw').innerHTML = cw_allocated_qty;

         // set graphics designer allocated qty
         const gd_allocated_qty_td = "gd_allocated_qty"+id;
        const gd_allocated_qty = document.getElementById(gd_allocated_qty_td).innerHTML;
        document.querySelector('.AllocatedCountGd').innerHTML = gd_allocated_qty;

        // set GD Pending qty
        const pending_qty_gd_td = "pending_qty_gd"+id;
        const pending_qty_gd = document.getElementById(pending_qty_gd_td).innerHTML;
        document.querySelector('.PendingCountGd').innerHTML = pending_qty_gd;

        // set CW Pending qty
        const pending_qty_cw_td = "pending_qty_cw"+id;
        const pending_qty_cw = document.getElementById(pending_qty_cw_td).innerHTML;
        document.querySelector('.PendingCountCw').innerHTML = pending_qty_cw;

        // set wrc number
        const wrc_number_td = "wrc_number"+id;
        const wrc_number = document.getElementById(wrc_number_td).innerHTML;
        document.querySelector('.wrcNo').innerHTML = wrc_number;

        // set batch_batch_no number
        const batch_batch_no_td = "batch_batch_no"+id;
        const batch_batch_no = document.getElementById(batch_batch_no_td).innerHTML;
        document.querySelector('.batchesNo').innerHTML = batch_batch_no;

        // set batch no
        if(batch_batch_no == 'None'){
            document.querySelector(".batch_no").value = 0
        }else{
            document.querySelector(".batch_no").value = batch_batch_no
        }

        // set lot number
        const lot_number_td = "lot_number"+id;
        const lot_number = document.getElementById(lot_number_td).innerHTML;
        document.querySelector('.selLot').innerHTML = lot_number;
       
        // set wrc id
        const wrc_id_td = "wrc_number_id"+id;
        const wrc_id = document.getElementById(wrc_id_td).innerHTML;
        document.querySelector(".wrc_id").value = wrc_id

        // work_initiate_date
        const work_initiate_date_td = "work_initiate_date"+id;
        const work_initiate_date = document.getElementById(work_initiate_date_td).innerHTML;
        console.log('work_initiate_date', work_initiate_date)
        // document.querySelector(".int_date").value = work_initiate_date
        document.getElementById("int_date").value = work_initiate_date

        // cmt_date

        // Comitted_initiate_date
        const Comitted_initiate_date_td = "Comitted_initiate_date"+id;
        const Comitted_initiate_date = document.getElementById(Comitted_initiate_date_td).innerHTML;
        // document.querySelector(".cmt_date").value = Comitted_initiate_date
        document.getElementById("cmt_date").value = Comitted_initiate_date

        // set wrc id
        const alloacte_to_copy_writer_td = "alloacte_to_copy_writer"+id;
        const alloacte_to_copy_writer = document.getElementById(alloacte_to_copy_writer_td).innerHTML;
        document.querySelector(".alloacte_to_copy_writer").value = alloacte_to_copy_writer

        console.log('alloacte_to_copy_writer', alloacte_to_copy_writer)
        if(alloacte_to_copy_writer == 0){
            document.querySelector(".CWSTYLE1").style.display = 'none'
            document.querySelector(".CWSTYLE2").style.display = 'none'
            document.querySelector(".CWSTYLE3").style.display = 'none'
        }else{
            document.querySelector(".CWSTYLE1").style.display = 'block'
            document.querySelector(".CWSTYLE2").style.display = 'block'
            document.querySelector(".CWSTYLE3").style.display = 'block'

        }
    }
</script>



<!-- msg div script -->
<script>
    setTimeout(function(){
        document.getElementById('msg_div').style.display = "none";
    },3000)
</script>


<!-- validateForm script -->
<script>
    function validateForm(event) {
        
        // event.preventDefault() // this will stop the form from submitting
        $(".input_err").css("display", "none");
        $(".input_err").html("");

        const int_date = document.getElementById('int_date').value;
        const cmt_date = document.getElementById('cmt_date').value;
        console.log('int_date', int_date)
        console.log('cmt_date', cmt_date)

        if(int_date == ''){
            return alert("Work Initiate Date is required"),false; 
        }

        if(cmt_date == ''){
            return alert("Work Committed Date is required"),false; 
        }

        var GraphicDesignerQtyTotal = 0;
        var copyWriterQtyTotal = 0;

        var GraphicDesignerNameValues = $("select[name='designerName[]']")
        .map(function(){return $(this).val();}).get();

        var copyWriterNameValues = $("select[name='copywriterName[]']")
              .map(function(){return $(this).val();}).get();

        var GraphicDesignerQtyValues = $("input[name='GraphicDesignerQty[]']")
        .map(function(){return $(this).val();}).get();

        var copyWriterQtyValues = $("input[name='copyWriterQty[]']")
              .map(function(){return $(this).val();}).get();

              console.log('GraphicDesignerNameValues', GraphicDesignerNameValues)
              console.log('GraphicDesignerQtyValues', GraphicDesignerQtyValues)

        let gd = false // for graphic designer validation
        let gdq = false // for graphic designer qty validation
        let cw = false // for copy writer validation
        let cwq = false // for copy writer qty validation

        GraphicDesignerNameValues.find((val)=>{
            if(val != 0){
                return gd = true
            }
        })
        copyWriterNameValues.find((val)=>{
            if(val != 0){
                return cw = true
            }
        })

        if((!cw) && (!gd)){
            return alert("At least one graphic designer or copywriter should be selected"),false; 
        }

        GraphicDesignerQtyValues.find((val)=>{
            if(val != 0){
                return gdq = true
            }
        })
        copyWriterQtyValues.find((val)=>{
            if(val != 0){
                return cwq = true
            }
        })

        if((!cwq) && (!gdq)){
            return alert("Qty is required with selected user"),false; 
        }

        $(GraphicDesignerQtyValues).each(function (index, element) {
            GraphicDesignerQtyTotal = GraphicDesignerQtyTotal + Number(element);
        });
        $(copyWriterQtyValues).each(function (index, element) {
            copyWriterQtyTotal = copyWriterQtyTotal + Number(element);
        });

        const pending_qty_gd = document.querySelector('.PendingCountGd').innerHTML;
        const pending_qty_cw = document.querySelector('.PendingCountCw').innerHTML;
        // const validate_allocated_qty = (Number(copyWriterQtyTotal) + Number(GraphicDesignerQtyTotal));

        //The allocated quantity cannot be greater than the pending quantity
        if(GraphicDesignerQtyTotal > pending_qty_gd){
            alert("Sum of Graphics designer Qty cannot be greater than the GD pending quantity");
            return false
        }

        if(copyWriterQtyTotal > pending_qty_cw){
            alert("Sum of Copy Writer Qty cannot be greater than the CW pending quantity");
            return false
        }
        return true
        
    }
</script>

<script type="application/javascript" src="{{asset('plugins/datepicker-in-bootstrap-modal/js/datepicker.js')}}"></script>
<script type="text/javascript">
 
 $('[data-toggle="datepicker"]').datepicker({
    autoHide: true,
    zIndex: 2048,
    format: 'yyyy-mm-dd'
});

</script>

{{-- reset enable disable of sku and order qty modal reset--}}
<script type="application/javascript"> 
    
    function resetdata(){
        $(".inverdnewPopup").on("hidden.bs.modal", function(){
            document.querySelector('.hideTotalOrderQtyLable').style.display = 'block';
            document.querySelector('.hideTotalSkuCountLable').style.display = 'block';
        });
    }
</script>
@endsection