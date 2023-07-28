@extends('layouts.admin')
@section('title')
Approve  Invoice and Submission
@endsection
@section('content')


<style type="text/css">
.table td {
  border: 0 !important;
}

.lot-list li {
  cursor: pointer;
}

.bg-color {
  background: #ccc;
  position: relative;
  top:6px;
}

.bg-color.Inworded {
    background:#FFFF00;
}
.bg-color.Inwording.Completed {
    background:#FF8000;
}
.bg-color.Ready.For.Shoot {
    background:#606060;
}
.bg-color.Shoot.Done {
    background:#4C0099;
}
.bg-color.Ready.For.QC {
    background:#000000;
}
.bg-color.Ready.For.Submission {
    background:#0066CC;
}
.bg-color.Approved {
    background:#00CC00;
}
.bg-color.Rejected {
    background:#FF0000;
}

select{background:#ffffff}

.wrc-tt > th,
.wrc-tt > td {
  white-space: normal !important;
}

/*  .wrc-inner-tb {
  display: none;
}*/


</style>



<div class="lot-table mt-5">
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card card-transparent">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
              <h3 class="card-title text-black text-bold">
                <span class="d-inline-block align-middle">
            Approve Invoice
                </span>
                <span class="mr-2 ml-1 d-inline-block" style="position: relative; top: 1px;"></span>
              </h3>
              <div class="card-tools float-left">
              
              </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
              <div class="card-tools float-md-right float-sm-none ml-md-0 mr-0 ml-sm-0 mt-sm-2 float-none ml-xs-0 mt-2">
                <a href="/create-invoice" class="btn btn-xs float-left align-middle mt-0 mr-2 p-1 mb-1 mb-1" style="position: relative; top: 2px;">Request Invoice</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
         <table class="table table-head-fixed table-hover text-nowrap text-center" id="dataTable">
            <thead>
              <tr class="wrc-tt">
                <th class="p-2 small text-bold text-normal" style="width: 30px">Id</th>
                <!-- <th class="p-2 small text-bold text-normal" style="width: 30px">Status</th> -->
                <!--<th class="p-2 small text-bold text-normal" style="width: 80px">Service</th>-->
                <th class="p-2 small text-bold text-normal" style="width: 80px">Brand Name</th>
                <th class="p-2 small text-bold text-normal" style="width: 120px">Company Name</th>
                <th class="p-2 small text-bold text-normal" style="width: 120px">Client Email</th>
                <th class="p-2 small text-bold text-normal" style="width: 110px">Client Name</th>
                <th class="p-2 small text-bold text-normal" style="width: 110px">Invoice Number</th>
                <th class="p-2 small text-bold text-normal" style="width: 110px">Status</th>
                <!--<th class="p-2 small text-bold text-normal" style="width: 110px">State</th>-->
                <th class="p-2 small text-bold text-normal" style="width: 110px">Payment Term</th>
                <th class="p-2 small text-bold text-normal" style="width: 110px">GST</th>
                <th class="p-2 small text-bold text-normal" style="width: 80px"> Bill Amount</th>
                <!--<th class="p-2 small text-bold text-normal" style="width: 80px"> Received Amount</th>-->
                <th class="p-2 small text-bold text-normal" style="width: 80px">Actions</th>
              </tr>
            </thead>
            <tbody>@foreach($list as $comer)
              <tr class="wrc-tt" style="height: 80px">
                <td class="p-sm-2 p-1 small" style="width: 30px ;vertical-align:middle;">{{$id++}}</td>
                <td class="p-sm-2 p-1 small" style="width: 80px ;vertical-align:middle;" >{{$comer->name}}</td>
                <td class="p-sm-2 p-1 small" style="width: 120px ;vertical-align:middle;">{{$comer->Company}}</td>
                <td class="p-sm-2 p-1 small" style="width: 120px; vertical-align:middle;">{{$comer->email}}</td>
                <td class="p-sm-2 p-1 small" style="width: 110px ;vertical-align:middle;">{{($comer->uname)}}</td>
                <td class="p-sm-2 p-1 small" style="width: 110px; vertical-align:middle;">{{$comer->invoice_number}}</td>
                @if($comer->status == 0)
                  <td class="p-sm-2 p-1 small" style="width: 80px ;vertical-align:middle;">Not Approved</td>
                  @else
                  <td class="p-sm-2 p-1 small" style="width: 80px ;vertical-align:middle; "><b>Approved</b></td>
                  @endif
            
                <td class="p-sm-2 p-1 small" style="width: 80px ;vertical-align:middle;">{{$comer->payment_term}}</td>
                   <td class="p-sm-2 p-1 small" style="width: 80px ;vertical-align:middle;">{{$comer->Gst_number}}</td>
                <td class="p-sm-2 p-1 small" style="width: 180px ;vertical-align:middle;">
                  <i class="fas fa-rupee-sign"></i>
                  {{$comer->total_amount}}
                </td>
                
          <td class="p-sm-2 p-1 small" style="width: 80px">
                  <div class="btn-group-vertical">
               
                        <a class="btn btn-warning px-1 py-1 btn-xs mt-1" data-id="{{$comer->id}}"  onclick="updateIn(this)">View Items</a>
                        
                         <a class="btn btn-warning px-1 py-1 btn-xs mt-1" data-id="{{$comer->id}}"  onclick="">Release for Submission</a>
                        @if($comer->status == 0) 
                        <a class="btn btn-warning px-1 py-1 btn-xs mt-1"  
                   href="/viewpdf/{{$comer->id}}" target="_blank" disabled>PDF View</a>
                   
                    @endif
                     @if($comer->status != 0) 
                        <a class="btn btn-warning px-1 py-1 btn-xs mt-1"  
                   href="/viewpdf/{{$comer->id}}" target="_blank" >PDF View</a>
                   
                    @endif
                   
                     @if($comer->status == 0)
                   <button class="btn btn-success px-1 py-1 btn-xs mt-1"style="background-color:blue !important; color:black !important;"  data-id="{{$comer->id}}" onclick="updateInStatus(this)">Approve</button>
                  @endif
                   @if($comer->status != 0)
                    <button class="btn  px-1 py-1 btn-xs mt-1" style="background-color:yellow !important; color:black !important;" data-id="{{$comer->id}}" onclick="export(this)">Export</button>
               @endif
                  </div>
                </td> 
                
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <div class="modal fade" id="modal-default">
        <div class="modal-dialog ">
            <div class="dynam">
                
            </div>
         
          <!-- /.modal-content -->
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="fix-infor-wrapper">
    <a href="javascript:;" class="information-pp-btn" id="info-popbtn">
      <i class="fas fa-info ic-infor"></i>
      <i class="fas fa-times cl-infor"></i>
    </a>
    <div class="infor-content">
      <ul class="info-ll-list">
        <li><b>To add a new commercial, <br> simply click on the ‘Add New Commercials’ button on the table head.</b></li>
      </ul>
    </div>
  </div>

<script type="application/javascript" src="plugins/jquery/jquery.min.js"></script>
<script type="application/javascript" src="plugins/jquery-ui/jquery-ui.min.js"></script>


<script type="application/javascript">

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });

  var prevVal;
  $(".yellowText").on("change",function(){
    var val = $(this).find('option:selected').text();
    $(this).parent().prev('.bg-color').removeClass(`${prevVal}`).addClass(`${val}`);
    prevVal = val;
  });

  $('.st-btn').click(function(){
    $(this).parents('.colform').slideUp(500);
    // $(this).parents('.colform').prev('.bg-color').animate({ top: '6px' });
  });

  $('.bg-color').click(function(){
    $(this).next('.colform').slideDown(500);
  });

  $('.wrc-vw').click(function(){
    $(this).parents('tr').next('tr.wrc-inner-tb').slideToggle(500);
    // $(this).parents('tr').next('tr').siblings('.dd-even').find('.wrc-inner-tb').slideUp(500);
  });

function updateIn(obj){
    var invoice_id = $(obj).data('id');
    
     $.ajax({
        url: "/getinvoiceDetail",
        method: 'GET',
        dataType: "html",
        data: {invoice_id: invoice_id},
        success: function (data) {
            $('.dynam').html(data);
        }
   
});
   $('#modal-default').modal();
}

function rejectPi(obj){
 
 var id = $(obj).data('id');

    $.get('/rejectepi/' + id, function (data) {
       window.location.reload();
    });
 }

 function updateInStatus(obj){
 
 var id = $(obj).data('id');

    $.ajax({
        url: "/updateInvoice",
        method: 'GET',
        dataType: "html",
        data: {id:id},
        success: function (data) {
            $('.dynam').html(data);
        }
   
});
       $('#modal-default').modal();
   
 }
</script>


@endsection