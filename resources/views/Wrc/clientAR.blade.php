@extends('layouts.admin')

@section('title')
WRC Approval & Rejection 
@endsection
@section('content')

<head>
   <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>


<p class="text-center text-success">{{session()->pull('message')}}</p>
<!-- Client Approval And Rejection -->
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
                                   
WRC Client Approval & Rejection 
                                 </span>
                                 
                             </h3>
                             <!-- <div class="card-tools float-left">
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
                            </div> -->
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="card-tools float-md-right float-sm-none ml-md-0 mr-0 ml-sm-0 mt-sm-1 float-none ml-xs-0 mt-1">
                                <a class="btn btn-xs float-left align-middle mt-0 mr-2 p-1 mb-1" href="{{route('Wrc.createwrc')}}" style="position: relative; top: 2px;">Add New WRC</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                    <table class="table data-table table-head-fixed table-hover text-nowrap text-center">
                        <thead>
                            <tr class="wrc-tt">
                                <th class="p-2 small text-bold text-normal" style="width: 30px">Id</th>
                                <!-- <th class="p-2 small text-bold text-normal" style="width: 30px">Status</th> -->
                                <th class="p-2 small text-bold text-normal" style="width: 170px">LOT Number</th>
                                <th class="p-2 small text-bold text-normal" style="width: 130px">Brand</th>
                                <th class="p-2 small text-bold text-normal" style="width: 150px">Company Name</th>
                                <th class="p-2 small text-bold text-normal" style="width: 160px">WRC Number</th>
                                <th class="p-2 small text-bold text-normal" style="width: 180px">Invoice Number</th>
                                <th class="p-2 small text-bold text-normal" style="width: 180px">Feedback Received</th>
                                <th class="p-2 small text-bold text-normal" style="width: 160px">Created At</th>
                                <th class="p-2 small text-bold text-normal" style="width: 180px">Product Category</th>
                                <th class="p-2 small text-bold text-normal" style="width: 120px">Type Of Shoot</th>
                                <th class="p-2 small text-bold text-normal" style="width: 140px">Type Of Clothing</th>
                                <th class="p-2 small text-bold text-normal" style="width: 80px">Gender</th>
                                <th class="p-2 small text-bold text-normal" style="width: 180px">Adaptations</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wrcs as $index => $wrc)
                            <tr class="wrc-tt">
                                <td class="p-sm-2 p-1 small" style="width: 30px">{{$index+1}}</td>
                                <td id="lotNum" class="p-sm-2 p-1 small" style="width: 170px">{{$wrc->lot_id}}</td>
                                <td id="brndName" class="p-sm-2 p-1 small" style="width: 130px">{{$wrc->name}}</td>
                                <td id="companyName" class="p-sm-2 p-1 small" style="width: 150px">{{$wrc->Company}}</td>
                                <td id="wrcNum" class="p-sm-2 p-1 small" style="width: 160px">{{$wrc->wrc_id}}  <span class="cpy-clipboardtable" id="copyBTnTable"><i class="fas fa-copy"></i></span> </td>
@if($wrc->Invoice_no == Null)
<td class="p-sm-2 p-1 small" style="width: 180px">
                                   Not Available
                                </td>
@else
 <td class="p-sm-2 p-1 small" style="width: 180px">
                                   {{$wrc->Invoice_no}}
                                </td>
@endif
                               

                                <td class="p-sm-2 p-1 small" style="width: 180px">
                                    <a href="#" class="btn btn-small btn-danger reject"  id="rejectionBTN" data-wrc="{{$wrc->id}}" data-toggle="modal" data-target="#modalRejection"  data-reject="0">
                                      Reject
                                  </a>
                                  <a href="#" data-wrc="{{$wrc->id}}" data-approved="1" class="btn btn-small btn-success approve-btn" id="approved">
                                      Approve
                                  </a>
                              </td>
                              <td id="createdAt" class="p-sm-2 p-1 small" style="width: 150px">{{dateFormat($wrc->created_at)}}</td>
                              <td class="p-sm-2 p-1 small" style="width: 180px">{{$wrc->product_category}}</td>
                              <td class="p-sm-2 p-1 small" style="width: 120px">{{$wrc->type_of_shoot}}</td>
                              <td class="p-sm-2 p-1 small" style="width: 140px">{{$wrc->type_of_clothing}}</td>
                              <td class="p-sm-2 p-1 small" style="width: 80px">{{$wrc->gender}}</td>
                              <td class="p-sm-2 p-1 small" style="width: 180px">
                                <ol class="list-unstyled">
                                    <li>{{$wrc->adaptation_1}}</li>
                                    <li>{{$wrc->adaptation_2}}</li>
                                    <li>{{$wrc->adaptation_3}}</li>
                                    <li>{{$wrc->adaptation_4}}</li>
                                    <li> {{$wrc->adaptation_5}}</li>
                                </ol>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
        </div>

    </div>
</div>
</div>
</div>

<!-- Client Approval And Rejection Modal -->
<div class="modal fade " id="modalRejection" >

  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h4 class="modal-title">Enter your reason of rejection</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">
    <form action="" class="rejection-form" id="rejectionForm">
        @csrf
        <div class="dyn"></div>
    </form>
</div>
</div>
</div>
</div>
</div>

<!-- End Of Client Approval And Rejection Modal -->

<div class="fix-infor-wrapper">
    <a href="javascript:;" class="information-pp-btn" id="info-popbtn">
        <i class="fas fa-info ic-infor"></i>
        <i class="fas fa-times cl-infor"></i>
    </a>
    <div class="infor-content">
        <ul class="info-ll-list">
            <li><b>To create a new WRC, click on the ‘Add New WRC’ button on the table head.</b></li>
        </ul>
    </div>
</div>
<script type="application/javascript" src="plugins/jquery/jquery.min.js">
</script>
<script type="application/javascript" src="plugins/jquery-ui/jquery-ui.min.js">
</script>



<script type="text/javascript">

    $(document).on('click', '.cpy-clipboardtable', function () {
        var Lot = $(this).parents('.wrc-tt').find('#lotNum').text();
        var Brand = $(this).parents('.wrc-tt').find('#brndName').text();
        var created_at = $(this).parents('.wrc-tt').find('#createdAt').text();
        var WRC = $(this).parents('.wrc-tt').find('#wrcNum').text().trim();

        var nwArray = [[`${Lot}\t${Brand}\t${created_at}\t${WRC}`]];

        navigator.clipboard.writeText(nwArray).then(() => {
            $('.copy-msg').fadeIn(250);
            setTimeout(function () {
                $('.copy-msg').fadeOut(250);
            }, 1000);
        })
        .catch((err) => {
            alert("Error in copying text: ", err);
        });
    });


    $('.reject').click(function(){

       var wrc = $(this).data('wrc');
       var reject = $(this).data('reject');

       var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    $.ajax({
        headers: headers,
        url: "/get-client-rejection" ,
        method: 'GET',
        dataType: 'html',
        data: {wrc : wrc, reject : reject},

        success: function (htmlData) {
            $('.dyn').html(htmlData);
            $('.modal').modal();
        } 
    });
});

    function updateComment(){
        
        $.ajax({
            url: "/update-comment" ,
            method: 'POST',
            dataType: 'text',
            data: $('#rejectionForm').serialize(),
            success: function(response) {
window.location.reload();
              }
        });
    }


     $('.approve-btn').click(function(){

       var wrc = $(this).data('wrc');
       var approved = $(this).data('approved');

       var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    $.ajax({
        headers: headers,
        url: "/client-approval" ,
        method: 'POST',
        dataType: 'text',
        data: {wrc : wrc, approved : approved},
        success: function (response) {

            window.location.reload();

           
        } 
    });
});

</script>

@endsection