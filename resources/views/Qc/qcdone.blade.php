@extends('layouts.admin')
@section('title')
Quality Check
@endsection
@section('content')


    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">


<style>
.dropdown-toggle.open-sk:after {
    transform: rotate(
        -180deg
        );
}
</style>

    <div class="container-fluid mt-5 plan-shoot">
        <div class="row">
            <div class="col-12">
                <div class="card card-transparent">
                    <div class="card-header">
                        <h3 class="card-title" style="font-size: 2rem;">QC Approval</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="align-middle" width="1%">ID</th>
                                    <th class="align-middle">LOT Number</th>
                                      <th class="align-middle">Brand</th>
                                    <th class="align-middle">WRC Number</th>
                                    <th class="align-middle">Inward SKU Count</th>
                                     <th class="align-middle">Rejection Count</th>
                                    <th class="align-middle">Adaptation</th>
                                    <th class="align-middle">Uploaded SKU Count</th>
                                    <th class="align-middle">Images Count</th>
                                    <th class="align-middle">Status</th>
                                    <th class="align-middle" width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($QcList as $qc)
                                <tr>
                                    <td width="1%">{{$sr++}}</td>
                                    <td>{{$qc['lot_id']}}</td>
                                    <td>{{$qc['brand']}}</td>
                                    <td>{{$qc['wrc_id']}}</td>
                                    <td>{{$qc['inward']}}</td>
                                    <td>{{$qc['rejectcount']}}</td>
                                    <td>{{implode(' | ', $qc['adaptation'])}}</td>
                                    <td>{{$qc['sku_count']}}</td>
                                    <td>{{$qc['image_count']}}</td>
                                    <td>
                                        <div class="d-inline-block">
                                        <input data-id="{{$qc['id']}}" type="checkbox" unchecked data-toggle="toggle" data-on="Approved" data-off="Rejected" data-onstyle="success" data-offstyle="warning" data-size="sm" data-width="100" class="toggle-class"   {{ $qc['id'] ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td><a class="accordion-toggle collapsed" id="accordion1" data-toggle="collapse" href="#{{$qc['lot_id']}}_{{$qc['wrc_id']}}" aria-expanded="false">
                                        <span>SKU QC</span></a>
                        
                                    </td>
                                </tr>  
                                <tr id="{{$qc['lot_id']}}_{{$qc['wrc_id']}}" class="collapse" data-parent= "#accordion1" >
                                    <td colspan="9" class="border-0 px-0 align-middle">
                                        <table class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-0 align-top" width="40%">SKU Code</th>
                                                    <th class="border-0 align-top" width="35%">Category</th>
                                                    <th class="border-0 align-top" width="15%">Status & Comments</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>@foreach($qc['skus'] as $sku)
                                                    <td class="align-middle" width="33%">{{$sku['sku_code']}}</td>
                                                    <td class="align-middle" width="33%">{{$sku['category']}}</td>

                                                    <td class="align-middle" width="34%">
                                                        <div class="d-inline-block">
                                                            <input data-id="{{$sku['sku_id']}}" type="checkbox" unchecked data-toggle="toggle" data-on="Submitted" data-off="Pending" data-onstyle="success" data-offstyle="warning" data-size="sm" data-width="100" class="toggle-class"   {{ $sku['qc'] ? 'checked' : '' }}>
                                                        </div>
                                                        <div class="d-inline-block mt-1">
                                                            <a href="javascript:;" class="btn btn-default py-1 mt-1" data-toggle="modal" data-target="#modal-lg"><i class="fas fa-comment mr-1"></i>Comment</a>
                                                        </div>
                                                    </td> 
                                                </tr> @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header py-2">
                        <h4 class="modal-title">Comments</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="comment-form">
                            <div class="form-group">
                                <label>Add a comment</label>
                                <textarea class="form-control" rows="4" name="commentsec" id="commentsec" placeholder="Enter your comment..."></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-warning">Comment</button>
                            </div>
                        </form>
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
            <li><b>In order to submit an SKU, it is necessary to change the status from pending to submitted for a particular WRC number.</b></li>
        </ul>
    </div>
  </div>





<script type="application/javascript" src="plugins/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>


<script>


    $('.sku-box > .sku-count').click(function(){
        $(this).next('ol').fadeToggle(0);
        $(this).toggleClass('open-sk');
    });

        $('.toggle-class').change(function() {
            var qc = $(this).prop('checked') == true ? 1 : 0; 
            var id = $(this).data('id'); 
            console.log(id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/status-qc',
                data: {'qc': qc, 'id': id},
                success: function(data){
                  console.log(data.success)
              }
          });
        });


</script>


@endsection