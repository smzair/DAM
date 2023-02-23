@extends('layouts.admin')
@section('title')
View All Commercial's
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
            View Commercial's
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
              <div class="card-tools float-md-right float-sm-none ml-md-0 mr-0 ml-sm-0 mt-sm-2 float-none ml-xs-0 mt-2">
                <!--<a href="{{route('commercial.create')}}" class="btn btn-xs float-left align-middle mt-0 mr-2 p-1 mb-1 mb-1" style="position: relative; top: 2px;">+ Add New Commercials</a>-->
              </div>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                        <table class="table data-table table-head-fixed table-hover text-nowrap text-center"  id="dataTable">
            <thead>
              <tr class="wrc-tt">
                <th class="p-2 small text-bold text-normal" style="width: 30px">Id</th>
                <!-- <th class="p-2 small text-bold text-normal" style="width: 30px">Status</th> -->
                <th class="p-2 small text-bold text-normal" style="width: 80px">Brands</th>
                <th class="p-2 small text-bold text-normal" style="width: 120px">Company Name</th>
                <th class="p-2 small text-bold text-normal" style="width: 120px">Product Category</th>
                <th class="p-2 small text-bold text-normal" style="width: 110px">Type Of Shoot</th>
                <th class="p-2 small text-bold text-normal" style="width: 110px">Type Of Clothing</th>
                <th class="p-2 small text-bold text-normal" style="width: 80px">Gender</th>
                <th class="p-2 small text-bold text-normal" style="width: 130px">Adaptations</th>
                <th class="p-2 small text-bold text-normal" style="width: 180px">Commercial Value Per Sku</th>
                <th class="p-2 small text-bold text-normal" style="width: 80px">Actions</th> 
                
              </tr>
            </thead>
            <tbody>@foreach($com as $comer)
              <tr class="wrc-tt" style="height: 80px">
                <td class="p-sm-2 p-1 small" style="width: 30px ;vertical-align:middle;">{{$comer->id}}</td>
                <!-- <td class="p-sm-2 p-1 small" style="width: 30px ;vertical-align:middle;">
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
                <td class="p-sm-2 p-1 small" style="width: 80px ;vertical-align:middle;" >{{$comer->name}}</td>
                <td class="p-sm-2 p-1 small" style="width: 120px ;vertical-align:middle;">{{$comer->Company}}</td>
                <td class="p-sm-2 p-1 small" style="width: 120px; vertical-align:middle;">{{$comer->product_category}}</td>
                <td class="p-sm-2 p-1 small" style="width: 110px ;vertical-align:middle;">{{$comer->type_of_shoot}}</td>
                <td class="p-sm-2 p-1 small" style="width: 110px; vertical-align:middle;">{{$comer->type_of_clothing}}</td>
                <td class="p-sm-2 p-1 small" style="width: 80px ;vertical-align:middle;">{{$comer->gender}}</td>
                <td class="p-sm-2 p-1 small" style="width: 130px">
                  <ol class="list-unstyled mb-0">
                    <li>{{$comer->adaptation_1}}</li>
                    <li>{{$comer->adaptation_2}}</li>
                    <li>{{$comer->adaptation_3}}</li>
                    <li>{{$comer->adaptation_4}}</li>
                    <li>{{$comer->adaptation_5}}</li>
                  </ol>
                </td>
                <td class="p-sm-2 p-1 small" style="width: 180px ;vertical-align:middle;">
                  <i class="fas fa-rupee-sign"></i>
                  {{$comer->commercial_value_per_sku}}
                </td>
                <td class="p-sm-2 p-1 small" style="width: 80px">
                  <div class="btn-group-vertical">
               
                        <a class="btn btn-warning px-1 py-1 btn-xs mt-1" href="{{('/edit-com/'.$comer->id) }}">Edit Com</a>
                  </div>
                </td> 
                <!-- <td class="p-sm-2 p-1 small" style="width: 80px">
                  <div class="btn-group-vertical">
                    <button type="button" class="btn btn-primary px-1 py-1 btn-xs wrc-vw" data-toggle="modal" data-target="#modal-default">View</button>
                    <button type="button" class="btn btn-default px-1 py-1 btn-xs mt-1">Add SKU</button>
                  </div>
                </td> -->
                
              </tr>@endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
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
                      <textarea id="cmnts" name="cmnts" class="form-control" rows="3" placeholder="Comments..." required></textarea>
                      <button type="submit" class="btn btn-warning mt-2">Submit</button>
                    </div>
                  </form>
                </dt>
              </dl>
            </div>
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


</script>


@endsection