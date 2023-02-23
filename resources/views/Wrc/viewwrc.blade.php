@extends('layouts.admin')

@section('title')
View WRCs
@endsection
@section('content')
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
                                        All WRCs
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
                                    <a class="btn btn-xs float-left align-middle mt-0 mr-2 p-1 mb-1" href="{{route('Wrc.createwrc')}}" style="position: relative; top: 2px;">Add New WRC</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                        <table class="table data-table table-head-fixed table-hover text-nowrap text-center" >
                            <thead>
                                <tr class="wrc-tt">
                                    <th class="p-2 small text-bold text-normal" style="width: 30px">Id</th>
                                    <!-- <th class="p-2 small text-bold text-normal" style="width: 30px">Status</th> -->
                                    <th class="p-2 small text-bold text-normal" style="width: 170px">LOT Number</th>
                                    <th class="p-2 small text-bold text-normal" style="width: 130px">Brand</th>
                                    <th class="p-2 small text-bold text-normal" style="width: 150px">Company Name</th>
                                    <th class="p-2 small text-bold text-normal" style="width: 160px">WRC Number</th>
                                    <th class="p-2 small text-bold text-normal" style="width: 160px">WRC Created At</th>
                                    <th class="p-2 small text-bold text-normal" style="width: 180px">Product Category</th>
                                    <th class="p-2 small text-bold text-normal" style="width: 120px">Type Of Shoot</th>
                                    <th class="p-2 small text-bold text-normal" style="width: 140px">Type Of Clothing</th>
                                    <th class="p-2 small text-bold text-normal" style="width: 80px">Gender</th>
                                    <th class="p-2 small text-bold text-normal" style="width: 180px">Adaptations</th>
                                      <th class="p-2 small text-bold text-normal" style="width: 180px">Commercial per SKU</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wrcs as $index => $wrc)
                                <tr class="wrc-tt">
                                    <td class="p-sm-2 p-1 small" style="width: 30px">{{$index+1}}</td>
                                 <!--    <td class="p-sm-2 p-1 small" style="width: 30px">
                                      <div class="bg-color mb-1 d-none" data-toggle="tooltip" data-placement="top" title="View All Lot Status" style="width: 100%; height: 10px"></div>
                                      <form method="post" name="selectform" action="myform" id="formcollapse" class="colform d-none">
                                        <select id="mySelect" class="custom-select yellowText" onSelect="do()" style="width: 100%;">
                                          <option class="white" value="Status" selected>Status</option>
                                          <option class="yellow" value="Inworded">Inworded</option>
                                          <option class="orange" value="Inwording Completed">Inwording Completed</option>
                                          <option class="gray" value="Ready For Shoot">Ready For Shoot</option>
                                          <option class="voilet" value="Shoot Done">Shoot Done</option>
                                          <option class="black" value="Ready For QC">Ready For QC</option>
                                          <option class="blue" value="Ready For Submission">Ready For Submission</option>
                                          <option class="green" value="Approved">Approved</option>
                                          <option class="red" value="Rejected">Rejected</option>
                                        </select>
                                        <div class="sel-btn d-block mt-2">
                                          <button type="button" class="btn btn-xs btn-success st-btn">Submit</button>
                                        </div>
                                      </form>
                                      <span class="badge d-inline-block rounded-1 p-lg-2 p-md-2 p-sm-2 p-2 px-lg-3 px-md-4 align-middle" style="background: #FFFF00; position: relative; top: -1; cursor: default;" data-toggle="tooltip" data-placement="top" title="Inwarding">Inwarding</span>
                                    </td> -->
                                    <td id="lotNum" class="p-sm-2 p-1 small" style="width: 170px">{{$wrc->lot_id}}</td>
                                    <td id="brndName" class="p-sm-2 p-1 small" style="width: 130px">{{$wrc->name}}</td>
                                    <td id="companyName" class="p-sm-2 p-1 small" style="width: 150px">{{$wrc->Company}}</td>
                                    <td id="wrcNum" class="p-sm-2 p-1 small" style="width: 160px">{{$wrc->wrc_id}}  <span class="cpy-clipboardtable" id="copyBTnTable"><i class="fas fa-copy"></i></span> </td>
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
                                    <td class="p-sm-2 p-1 small" style="width: 80px">{{$wrc->com}}</td>

                                </tr>@endforeach
                            </tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
    </div>
</div>

<!--
        <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header py-2">
                <h4 class="modal-title">WRC Details And Comments</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <dl class="row mb-0">
                  <dt class="col-6 mb-3">Lot Number</dt>
                  <dd class="col-6">5678C</dd>
                  <dt class="col-6 mb-3">Status</dt>
                  <dd class="col-6">
                    <span class="badge d-inline-block rounded-circle p-lg-2 p-md-2 p-sm-2 p-2 mt-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Approved" style="background: #00CC00;"></span>
                  </dd>
                  <dt class="col-6 mb-3">Brands</dt>
                  <dd class="col-6">Watches</dd>
                  <dt class="col-6 mb-3">Company</dt>
                  <dd class="col-6">Titan</dd>
                  <dt class="col-6 mb-3">Date</dt>
                  <dd class="col-6">04/13/2021</dd>
                  <dt class="col-12">
                    <form method="get" action="myform">
                      <div class="form-group">
                        <label>Enter Any Comments</label>
                        <textarea id="cmnts" name="cmnts" class="form-control" rows="3" placeholder="Comments..."></textarea>
                        <button type="submit" class="btn btn-warning mt-2">Submit</button>
                      </div>
                    </form>
                  </dt>
                </dl>
              </div>
            </div> -->
<!-- /.modal-content -->
</div>
</div>

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


<script type="application/javascript" src="plugins/jquery/jquery.min.js"></script>
<script type="application/javascript" src="plugins/jquery-ui/jquery-ui.min.js"></script>


<script type="text/javascript">
   $(document).ready(function() {
    $('.data-table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );
} );

</script>
<script type="text/javascript">

$(document).on('click', '.cpy-clipboardtable', function () {
    var Lot = $(this).parents('.wrc-tt').find('#lotNum').text();
    var Brand = $(this).parents('.wrc-tt').find('#brndName').text();
 var created_at = $(this).parents('.wrc-tt').find('#createdAt').text();   
 var WRC = $(this).parents('.wrc-tt').find('#wrcNum').text().trim();

    var nwArray = [[`${Lot}\t${Brand}\t${created_at}\t${WRC}`]];

    // var tableTextData = nwArray.toString();

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


</script>

@endsection