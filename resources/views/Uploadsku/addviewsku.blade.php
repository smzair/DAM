
@extends('layouts.admin')
@section('title')
View All SKUs
@endsection
@section('content')

    <title>View All SKUs</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   


<style type="text/css">
  .table td {
    border: 0 !important;
  }

  .lot-list li {
    cursor: pointer;
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

  tr > td {
    vertical-align: middle !important;
  }

  .toggle-on,
  .toggle-off {
    font-weight: 400 !important;
  }

</style>



<div class="lot-table mt-5">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-transparent">
          <div class="card-header">
            <div class="row">
              <div class="col-lg-8 col-md-6 col-sm-12">
                <h3 class="card-title text-black text-bold">
                  <span class="d-inline-block align-middle">
                 View All SKUs
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
              <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card-tools float-md-right float-sm-none ml-md-0 mr-0 ml-sm-0 mt-sm-1 float-none ml-xs-0 mt-1">
                  <a href="{{route('Lots.index')}}" class="btn btn-sm float-left align-middle mt-0 mr-2 p-1 mb-1" style="position: relative; top: 2px;">View All LOTs</a>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="data-table table  table-head-fixed table-hover text-nowrap text-center">
              <thead>
                <tr class="text-center">
                  <th>Id</th>
                  <th class="pl-3">LOT Number</th>
                  <th>Brand</th>
                  <th>Company Name</th>
                  <th>WRC Number</th>
                  <th>SKU Code</th>
                  <th>Gender</th>
                  <th>Category</th>
                  <th>Sub Category</th>
                 </tr>
              </thead>
              <tbody>
                @foreach($skus  as $sku )
                <tr class="text-center">
                  <td>{{$sku->id}}</td>
                  <td class="pl-3">{{$sku->lot_id}}</td>
                  <td>{{$sku->name}}</td>
                  <td>{{$sku->Company}}</td>
                  <td>{{$sku->wrc_id}}</td>
                  <td>{{$sku->sku_code}}</td>
                  <td>{{$sku->gender}}</td>
                  <td>{{$sku->category}}</td>
                  <td>{{$sku->subcategory}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        <!--   <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">SKU Details And Comments</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <dl class="row mb-0">
                    <dt class="col-6 mb-3">SKU Code</dt>
                    <dd class="col-6">786DFT</dd>
                    <dt class="col-6 mb-3">Lot Number</dt>
                    <dd class="col-6">5678C</dd>
                    <dt class="col-6 mb-3">WRC Number</dt>
                    <dd class="col-6">678456</dd>
                    <dt class="col-6 mb-3">Status</dt>
                    <dd class="col-6">
                      <span class="badge d-inline-block rounded-circle p-lg-2 p-md-2 p-sm-2 p-2 mt-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Approved" style="background: #00CC00;"></span>
                    </dd>
                    <dt class="col-12">
                      <form method="get" action="myform">
                        <div class="form-group">
                          <label>Enter Any Comments</label>
                          <textarea id="cmnts" name="cmnts" class="form-control" rows="3" placeholder="Comments..."></textarea>
                        </div>
                      </form>
                    </dt>
                  </dl>
                </div>
                <div class="modal-footer justify-content-between">
             <a class="btn btn-primary">Add Comments</a>
                </div>
              </div>
            <!-- /.modal-content -->
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
        <li><b>To view the LOTs, press on the view all LOTs button on the table head.</b></li>
      </ul>
    </div>
  </div>

<script type="application/javascript" src="plugins/jquery/jquery.min.js"></script>
<script type="application/javascript" src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- <script type="application/javascript" src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script type="application/javascript" src="dist/js/adminlte.js"></script>
<script type="application/javascript" src="dist/js/adminlte.min.js"></script>

<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script> -->

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

<script type="application/javascript">

    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });

$()

</script>

@endsection