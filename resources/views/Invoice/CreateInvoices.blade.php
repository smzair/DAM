@extends('layouts.admin')
@section('title')
Request Invoice
@endsection
@section('content')
<style>
.raise {
    display: none; /* hide the button by default */
  }
</style>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card card-transparent">
                <div class="card-header">
                    <h3 class="card-title">Request Invoice</h3>
                </div>
                <div class="card-body">
                <form metod="POST" action="" id="day_invoice">
                    @csrf
                        <div class="row">
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Brand Name</label>
                                    <select class="custom-select  form-control-border select2 pi_brand"  name="brand_id" aria-hidden="true" style="width: 100%;">
                                        <option selected>Select Brand Name</option>
                                       @foreach($brands as $brand)
                                        <option  value="{{$brand->id}}" >{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Company Name</label>
                                    <select class="custom-select form-control-border" name="user_id" id="user">
                                        <option selected>Select Company Name</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                <label class="control-label required">GST No.</label>
                                <input type="text" id="gst" name="gst" value="" class="form-control"  disabled readonly>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                <label class="control-label required">Address</label>
                                <input type="text" id="address"  name="address" value=""class="form-control" placeholder=""  disabled readonly>
                                </div>
                            </div>
                        </div>
                       <div class="row">
                         <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Contact Person Name</label>
                                    <input type="text"  id="pname"  name="pname" value="" class="form-control" placeholder=""  disabled readonly>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                <label class="control-label required">Contact Person Mail</label>
                                <input type="text"  id="pemail"  name="pmail" value="" class="form-control" placeholder=""  disabled readonly>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                <label class="control-label required">Contact Person number</label>
                                <input type="text"  id="pnumber"  name="pnumber" value="" class="form-control" placeholder=""  disabled readonly>
                                </div>
                            </div>
                    <!--        <div class="col-sm-3 col-12">-->
                    <!--        <div class="form-group">-->
                    <!--            <label class="control-label required">Contact Start Date</label>-->
                    <!--            <input type="text"  class="form-control" placeholder="pre-populated"  disabled readonly>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--<div class="row">-->
                    <!--    <div class="col-sm-3 col-12">-->
                    <!--            <div class="form-group">-->
                    <!--            <label class="control-label required">Contact End Date</label>-->
                    <!--            <input type="text"  class="form-control" placeholder="pre-populated"  disabled readonly>-->
                    <!--            </div>-->
                    <!--    </div>-->
                        <div class="col-sm-3 col-12">
                        <div class="form-group">
                                <label class="control-label required">Payment terms</label>
                                <input class="custom-select form-control-border" name="Payment_term" id="payment" disabled> 
                                        <!--<option selected>Select payment term</option>-->
                                   
                                </div>
                        </div>
                        
                           
                      <div class="col-12 dy-table">
                 </div>
           </center>
           
        </div>
                        </div>
                        <p class="ml-3">Payment Summary</p>
                    <div class="row ml-3">
                        <!--<div class="col-sm-3 ml-2 col-3">-->
                        <!--        <div class="form-group">-->
                        <!--        <label class="control-label ">Extra Charges (if any)</label>-->
                        <!--        <input type="text" name="extracharges" placeholder="Enter Amount in Rupees" class="total form-control"  >-->
                        <!--        </div>-->
                        <!--        </div> -->
                                
                        <!--        <div class="col-sm-3 ml-2 col-3">-->
                        <!--        <div class="form-group">-->
                        <!--        <label class="control-label ">Remarks</label>-->
                        <!--        <input type="text" name="extracharges" placeholder="Remarks for Extra charges" class="total form-control"  >-->
                        <!--        </div>-->
                        <!--        </div> -->
                    
                            <div class="col-sm-3 col-3">
                                <div class="form-group">
                                <label class="control-label required">Total Bill Amount</label>
                                <input type="text" name="totalA" class="totalA form-control" readonly >
                                </div>
                                 </div>
                                 <div class="col-sm-3 col-3">
                                 <div class="form-group">
                                <label class="control-label required">Amount in PI</label>
                                <input type="text" name="totalR" class="totalR form-control" readonly >
                                </div>
                                 </div>
                                 <div class="col-sm-3 col-3">
                                <!--<div class="form-group">-->
                                <!--<label class="control-label required">Balance Amount to be charged</label>-->
                                <!--<input type="text" name="total" class="totalB form-control" readonly >-->
                                <!--</div>-->
                                 </div>
                                 
                                 
                                
                                
                        <!--         <div class="col-sm-6 col-6  mt-4">-->
                        <!--       <button type="button"  class="btn bg-warning btn-md  mt-2 show" >Show Total</button>-->

                        <!--<button type="button" class="btn bg-danger btn-md  mt-2 ml-2" disabled>Download Pdf</button>-->
                        <!--</div>-->
                      </div>
                      <div class="col-sm-3 col-3 mb-3 ml-3">
                                <div class="form-group">
                                <a href="javaScript:void(0)" class="btn btn-default btn-sm checkbox-toggle-popup float-left mr-2" s onclick="raiseInvoice()">
                        Request Invoice
                        </a>
                                </div>
                                 </div>
                    </form>
                </div>
            </div>
        </div> 
    </div>
</div>


    
     
        
<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script type="application/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<script>
        $(document).ready(function(){
        
    $(document).on('change','.pi_brand',function () {
    var brandid = $(this).val();
    
    showLoader();
    $.ajax({
        url: "performafinduser",
        method: 'GET',
        dataType: "json",
        data: {brandid: brandid},
        success: function (data) {
            $('#user').html(data.wrc_html);
            hideLoader();
        }
    });
});    
 $(document).on('change','#user',function () {
    var user_id = $(this).val();
    var brandid = $('.pi_brand').val();
    var In = '1';
    showLoader();
    $.ajax({
        url: "performadetail",
        method: 'GET',
        dataType: "json",
        data: {user_id: user_id,brandid:brandid,In:In},
        success: function (data) {
          $('.dy-table').html(data.html);
         $('#gst').val(data.data.Gst_number);
         $('#address').val(data.data.Address);
         $('#pname').val(data.data.name);
         $('#pemail').val(data.data.email);
         $('#pnumber').val(data.data.phone);
         $('#payment').val(data.data.payment_term);
         
            hideLoader();
        }
    });
});    
});    


function showSelectedWRCs() {
    
    alert('ok');
 
    var wrc = [];
    $('.check-ln:checked').each(function () {
       
        var id = $(this).data('id');
        wrc.push(id);
        
        
    });

    $.ajax({
          headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        url: "/paytments-inovice",
        method: 'get',
        dataType: "json",
        data:{wrc:wrc},
        success: function (data) {
         $('.totalA').val(data.inwardTotal);
         $('.totalR').val(data.linkTotal);

        }

    });
    
}
function raiseInvoice(){
     $.ajax({
        url: "/save-raised-invoice",
        method: 'POST',
        dataType: "text",
        data: $('#day_invoice').serialize(),
        success: function (data) {
           
            window.location.reload();
         
        }

    });
}
  
        </script>
@endsection
