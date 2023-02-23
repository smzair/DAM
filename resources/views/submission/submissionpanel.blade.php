
@extends('layouts.admin')

@section('title')
Submissions Panel
@endsection
@section('content')
<style>

.sub-more-btn {
    position: relative;
    border: none;
    box-shadow: none;
    width: 130px;
    height: 40px;
    line-height: 42px;
    display: inline-block;
    color: #000 !important;
}

.sub-more-btn span {
    background: rgb(0,172,238);
    background: linear-gradient(
        0deg
        ,#fbf702 0%, #fbf702 100%);
    display: block;
    position: absolute;
    width: 130px;
    height: 40px;
    box-shadow: inset 2px 2px 2px 0px rgb(255 255 255 / 50%), 7px 7px 20px 0px rgb(0 0 0 / 10%), 4px 4px 5px 0px rgb(0 0 0 / 10%);
    border-radius: 5px;
    margin: 0;
    text-align: center;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-transition: all .3s;
    transition: all .3s;
    color: inherit !important;
}

.sub-more-btn span:nth-child(1) {
    box-shadow: -7px -7px 20px 0px #fff9, -4px -4px 5px 0px #fff9, 7px 7px 20px 0px #0002, 4px 4px 5px 0px #0001;
    -webkit-transform: rotateX(
        90deg
        );
    -moz-transform: rotateX(90deg);
    transform: rotateX(
        90deg
        );
    -webkit-transform-origin: 50% 50% -20px;
    -moz-transform-origin: 50% 50% -20px;
    transform-origin: 50% 50% -20px;
}

.sub-more-btn span:nth-child(2) {
    -webkit-transform: rotateX(
        0deg
        );
    -moz-transform: rotateX(0deg);
    transform: rotateX(
        0deg
        );
    -webkit-transform-origin: 50% 50% -20px;
    -moz-transform-origin: 50% 50% -20px;
    transform-origin: 50% 50% -20px;
}

.sub-more-btn:hover span:nth-child(1) {
    box-shadow: inset 2px 2px 2px 0px rgb(255 255 255 / 50%), 7px 7px 20px 0px rgb(0 0 0 / 10%), 4px 4px 5px 0px rgb(0 0 0 / 10%);
    -webkit-transform: rotateX(
        0deg
        );
    -moz-transform: rotateX(0deg);
    transform: rotateX(
        0deg
        );
}

.sub-more-btn:hover span:nth-child(2) {
    box-shadow: inset 2px 2px 2px 0px rgb(255 255 255 / 50%), 7px 7px 20px 0px rgb(0 0 0 / 10%), 4px 4px 5px 0px rgb(0 0 0 / 10%);
    color: transparent;
    -webkit-transform: rotateX(
        -90deg
        );
    -moz-transform: rotateX(-90deg);
    transform: rotateX(
        -90deg
        );
}

.sku-selc option {
    font-weight: 500;
    color: #000;
}

.dwn-btn {
    border: 0;
    background: #fbf702;
    color: #000;
    font-weight: 500;
    border-radius: 6px;
}

.submission-detl-content {
    border: 1px solid transparent;
    border-radius: 30px;
    box-shadow: rgb(0 0 0 / 30%) 0px 19px 38px, rgb(0 0 0 / 22%) 0px 15px 12px;
}

@media (min-width: 992px) {
    .submission-detl-content {
        transition: all 0.5s ease-in-out;
    }

    .submission-detl-content:hover {
        transform: scale(1.1);
    }
}

@media (max-width: 991px) {
    .submission-detl-modal-wrapper .modal-dialog {
        max-width: 95%;
    }
}

@media (max-width: 767px) {
    .first-image-action h5 {
        font-size: 0.9rem !important;
    }

    .all-image-action h5 {
        font-size: 0.9rem !important;
    }

    .dwn-btn {
        font-size: 0.8rem;
    }
}

@media (max-width: 575px) {
    .payment-indicator {
        margin-bottom: 1rem;
    }
}

/* .modal-backdrop {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
    } */

</style>

    <div class="container-fluid mt-5">
        <div class="row m-0">
            <div class="col-12">
                <div class="card card-transparent" style="border-radius: 15px; box-shadow: rgb(100 100 111 / 20%) 0px 7px 29px 0px;">
                    <div class="card-header py-3">
                      <h3 class="card-title text-left float-none text-uppercase" style="font-size: 1.5rem;">Submission Table</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                      <table class="table  data-table table-head-fixed text-nowrap">
                        <thead>
                          <tr>
                            <th class="align-middle" width="1%">Id</th>
                            <th class="align-middle">Company</th>
                            <th class="align-middle">Brand</th>
                            <th class="align-middle">LOT Number</th>
                            <th class="align-middle">WRC Number</th>
                            <th class="align-middle">Adaptations</th>
                            <th class="align-middle">Approved SKUs Count</th>
                            <th class="align-middle">Images Count</th>
                            <th class="align-middle" width="1%">Submission</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($SubmissionList as $submit)
                      <tr>
                        <td class="align-middle" width="1%">{{$sr++}}</td>
                        <td class="align-middle">{{$submit['Company']}}</td>
                        <td class="align-middle">{{$submit['brand']}}</td>
                        <td class="align-middle">{{$submit['lot_id']}}</td>
                        <td class="align-middle">{{$submit['wrc_id']}}</td>
                        <td class="align-middle">
                            {{$submit['adapt_count']}}
                        </td>
                        <td class="align-middle">{{$submit['sku_count']}}</td>
                        <td class="align-middle">{{$submit['image_count']}}</td>
                        <td class="align-middle" width="1%">
                            <a  onclick="showsub(this)" data-id="{{$submit['id']}}" href="javascript:;" class="sub-more-btn" data-toggle="modal" data-target="#submission">
                              <span>Click!</span>
                                <span>To Submit</span>
                            </a>
                        </td>
                    </tr>@endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>   
</div>
</div>

<div class="modal fade submission-detl-modal-wrapper" id="submission">
    <div class="modal-dialog modal-lg">
        <div class="modal-content submission-detl-content" id="sub-dynamic">
            
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
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
            <li><b>To generate the link for first angle images and full angle images, click on the submission section.</b></li>
        </ul>
    </div>
  </div>

<script type="application/javascript" src="plugins/jquery/jquery.min.js"></script>
<script type="application/javascript" src="plugins/jquery-ui/jquery-ui.min.js"></script>

<script>

    $(document).on('click', '.client-panel-btn', function () {
        $(this).children('.badge').addClass('d-inline-block');
    });


function showsub(obj){
    var wrc_id = $(obj).data('id');
    showLoader();
    $.ajax({
      url: "/Dynamic-submission" ,
      method: 'GET',
      dataType: "html",
      data: {wrc_id: wrc_id},
      success: function(htmlData) {
         $('#sub-dynamic').html(htmlData);
        hideLoader();
    } 
});
}

</script>


@endsection
