@extends('layouts.admin')

@section('title')
Create WRC
@endsection

@section('content')
<head>    
  <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

 <link rel="stylesheet" href="{{asset('plugins/datepicker-in-bootstrap-modal/css/datepicker.css')}}">
 <script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script type="application/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/js/plugins/mdb-file-upload.min.js"></script>
<script type="application/javascript" src="{{asset('plugins/datepicker-in-bootstrap-modal/js/datepicker.js')}}"></script>

<style type="text/css">

    .colp-form2:not(.outer-form) .close {
        display: none;
    }
    .text-title{
        text-align: center;
        font-size: 20px;
    }
    .custom-wrc-table.card.card-transparent {
        display: block !important;
        margin-bottom: 20px;
        box-shadow: none !important;
        background: transparent !important;
        backdrop-filter: none !important;
        border-radius: 8px !important;
        border: 1px solid #adaeb0;
        margin-top: 20px;
    }

    .light-dsh-mode .custom-wrc-table.card.card-transparent {
        border: 1px solid #6f757a;
    }

    .wrc-create-updateversion {
        color: #fff;
    }

    .light-dsh-mode .wrc-create-updateversion {
        color: #000;
    }

    .wrc-flex-list {
        text-align: left;
        background-color: transparent;
        border-radius: 0;
        display: block;
        max-height: 180px;
        height: 100vh;
        overflow-y: auto;
    }

    .wrc-flex-list .wrc-flex-list-item {
        padding-left: 0.8rem;
        padding-right: 0.8rem;
        border: 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0 !important;
        background-color: transparent;
        position: relative;
        display: block;
        padding-left: 2.5rem;
    }

    .wrc-flex-list .wrc-flex-list-item:before {
        content: '';
        display: block;
        position: absolute;
        left: 20px;
        width: 5px;
        height: 11px;
        border-width: 0 2px 2px 0;
        border-style: solid;
        border-color: #FBF702;
        transform-origin: bottom left;
        transform: rotate(45deg);
    }

    .wrc-flex-list .wrc-flex-list-item span {
        display: inline-block;
        vertical-align: top;
        position: relative;
        top: -1px;
    }

    .wrc-flex-list .wrc-flex-list-item span b {
        font-weight: normal;
    }

    .wrc-flex-list .wrc-flex-list-item:last-child {
        border: 0;
    }

    .wrc-flex-list::-webkit-scrollbar-track {
        border-radius: 8px;
        background: #000;
    }

    .wrc-flex-list::-webkit-scrollbar-thumb {
        border-radius: 8px;
        background: #FBF702;
    }

    .wrc-flex-list::-webkit-scrollbar {
        border: 0;
        height: auto;
        width: 8px;
    }

    .card.card-transparent .wrcList {
        font-size: 1rem;
        padding: 0;
    }
    .wrc-dt-no {
        align-items: center;
        display: flex;
        width: 100%;
        justify-content: center;
        font-size: 24px;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .table .dropdown-filter-dropdown {
        color: #fff;
    }

    .table .dropdown-filter-dropdown .dropdown-filter-icon {
        color: #fff;
        border: 1px solid #fff;
    }

    .table .dropdown-filter-dropdown .dropdown-filter-icon .arrow-down {
        border-color: #fff;
    }

    .table .dropdown-filter-content {
        background-color: rgb(84 90 118 / 100%);
        color: #fff;
    }

    .table .dropdown-filter-content div.dropdown-filter-sort span {
        color: #fff;
    }

    .table .dropdown-filter-content div.dropdown-filter-sort:hover {
        border-radius: 4px;
        background-color: rgba(12 15 25 / 30%);
    }

    .table .dropdown-filter-content .form-control {
        border: 1px solid transparent !important;
        background-color: rgba(12 15 25 / 30%) !important;
        color: #fff !important;
        outline: 0 !important;
        box-shadow: none !important;
    }

    .light-dsh-mode .table .dropdown-filter-dropdown .dropdown-filter-icon .arrow-down {
        border-color: #000;
    }

    .light-dsh-mode .table .dropdown-filter-dropdown .dropdown-filter-icon {
        color: #000;
        border: 1px solid #000;
    }

    .light-dsh-mode .table .dropdown-filter-content {
        background-color: rgb(177 177 170 / 80%) !important;
        color: #000;
    }

    .light-dsh-mode .table .dropdown-filter-content div.dropdown-filter-sort span {
        color: #000;
    }
    /* End of Sorting Filter Table CSS*/

</style>

<p class="text-center text-success">{{session()->pull('message')}}</p>
<!-- WRC Update -->

<!-- WorkBucket File Uploader Modal -->

<div class="modal fade sku-uploader-modal" id="skuUploaderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content sku-uploader-modal-content">
            <div class="modal-header">
                <h3 class="modal-title">SKU Uploader</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="sku-uploader">
                    <form action="" method="post" class="sku-uploader-form" id="upload_sku" enctype='multipart/form-data' >
                         @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="file-upload-wrapper">
                                    <input type="file" id="input-file-now" class="file-upload" name="skusheet" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="upload-sku-btn">
                                    <button type="submit" class="btn btn-warning" id="uploadSubmitBTN" style="width: 100%;">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-lg container-fluid mt-2 wrc-create-updateversion">
    <div class="row" id="Hwrc">
    </div>
    <div class="col-sm-6 col-12 d-none">
        <div class="custom-hor-space"></div>
                <!-- <div class="card card-transparent text-center" style="border-radius:20px;">
                    <div class="card-body py-5">
                        WRC No - <span class="text-bold d-inline-block">wrc-4567335667</span>
                    </div>
                </div> -->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-transparent card-info">
                    <div class="card-header bg-warning">
                        <h3 class="card-title">Create New WRC</h3>
                        <a href="javascript:;" class="btn btn-warning upld-action-btn float-right d-none" id="uploadActionBTN" data-toggle="modal" data-target="#skuUploaderModal">
        Upload list of SKUs
    </a>
                    </div>
                    <div class="card-body"> 
                        <form method="POST" action=""  id="wrcform" >
                            @csrf
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label required">Select Company Name</label>
                                        <select class="custom-select form-control-border select2 com " id="wrc_com" name="user_id"  aria-hidden="true" style="width: 100%;">
                                            <option value="None" selected>Select Company Name</option>
                                            @foreach ($users as $userc)
                                            <option value="{{$userc->id}}">{{$userc->Company}}</option>

                                            
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label required">Select Brand</label>
                                        <select class="select2 custom-select form-control-border brand " name="brand_id"  id="wrc_brands">
                                            <option selected>Select Brand</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label required">Select LOT Number</label>
                                        <select class="custom-select form-control-border " name="lot_id" id="wrc_lots">
                                            <option selected>Select LOT Number</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label required">Work Bucket</label>
                                        <select class="custom-select form-control-border " name="commercial_id" id="product_category">
                                            <option value="null" selected disabled>Select Commercial</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="">Special Approval Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="special_approval" id="spDate" placeholder="yyyy-mm-dd" data-toggle="datepicker">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="required">PPT Approval Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="ppt_approval" id="pptDate" placeholder="yyyy-mm-dd" data-toggle="datepicker" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="required">Model Approval date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="model_approval" id="mDate" placeholder="yyyy-mm-dd" data-toggle="datepicker" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="required">Inward sheet date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="inward_sheet" id="InwarsheetDate" placeholder="yyyy-mm-dd" data-toggle="datepicker" required>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr style="border-top: 1px solid #84878a; display:none;">
                            <div class="row" id="dwrc">
                            </div>
                            <div class="col-12" id="Allsku">
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-success btn-xl btn-warning mb-2" onclick="saveWrcForm(0)">Create New WRC</button>
                                    <button type="button" class="btn btn-info wrc-btn mb-2" onclick="saveWrcForm(1)">Submit & Add Another </button>
                                    <p class="text-success" id="msg" style="display: none">
                                    WRC Submitted Succesfully</p>
                                    
                                </div>
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
            <li><b>Select the company name, brand name, and LOT number, and the commercial against which you wish to create a WRC.</b></li>
            <li><b>In order to create more than one WRC, please click on the ‘Submit and Add Another’ button.</b></li>
        </ul>
    </div>
</div>




<script type="application/javascript">


   

        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            zIndex: 2048,
            format: 'yyyy-mm-dd'
        });

         $("#product_category").on("change",function(){
        $('.upld-action-btn').removeClass('d-none');
    });

        $('.file-upload').file_upload();

$("#upload_sku").submit(function (e) {
    e.preventDefault();
    var lot = $('#wrc_lots').val();
    var com = $('#product_category').val();
    var formData = new FormData(this);
     formData.append("lot", lot);
      formData.append("com", com);
    $.ajax({
        url: "/sheet",
        type: 'POST',
        data: formData,
        success: function (htmlData) {
                    $('#Allsku').html(htmlData);
           $('#skuUploaderModal').modal('hide');
$('.modal-backdrop').remove();
        },
        cache: false,
        contentType: false,
        processData: false
    });
});


</script>


@endsection