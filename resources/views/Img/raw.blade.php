@extends('layouts.admin')

@section('title')
Studio Panel
@endsection
@section('content')

<head>
    <title>Studio Panel</title>
    
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{asset('plugins/dropzone/dropzone.css')}}">  
    <link href="https://fonts.googleapis.com/css2?family=Lustria&display=swap" rel="stylesheet">
    

    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>

<style>
    /*Start of My Css*/

    .dropzone {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        position: relative;
        cursor: pointer;
        overflow: hidden;
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        max-height: 250px;
        height: auto;
        overflow-y: auto;
        padding: 5px 10px;
        font-size: 1.5rem;
        text-align: center;
        color: #ccc;
        background: #fff;
        box-shadow: none !important;
        min-height: 100%;
        border: 2px dashed rgba(128,128,128,0.35);
        border-radius: 5px;
        flex-wrap: wrap;
    }


    .uploader-pop {
        width: 100%;
        height: auto;
    }

    .dropzone .dz-message {
        width: 100%;
    }

    .image-uploader {
        position: relative;
    }

    .custom-checkbox .custom-control-input:disabled:checked~.custom-control-label::before {
        background-color: #007bff !important;
    }

    .dz-started .drop-addicon {
        display: none;
    }

    .header-search {
        width: auto;
        height: auto;
    }

    .header-search .search {
        position: absolute;
        margin: auto;
        top: -10px;
        right: 0px;
        bottom: auto;
        left: auto;
        width: 40px;
        height: 40px;
        background: #fbf702;
        border-radius: 50%;
        transition: all 1s;
        z-index: 4;
        box-shadow: 0 0 5px 0 rgb(0 0 0 / 40%);
    }

    .header-search .search:hover {
        cursor: pointer;
    }

    .header-search .search::before {
        content: "";
        position: absolute;
        margin: auto;
        top: 16px;
        right: 0;
        bottom: 0;
        left: 15px;
        width: 11px;
        height: 2px;
        background: #000;
        transform: rotate(45deg);
        transition: all 0.5s;
    }

    .header-search .search::after {
        content: "";
        position: absolute;
        margin: auto;
        top: -5px;
        right: 0;
        bottom: 0;
        left: -5px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #000;
        transition: all 0.5s;
    }

    .header-search input {
        position: absolute;
        margin: auto;
        top: 22px;
        right: 0;
        bottom: 0;
        left: auto;
        width: 50px;
        height: 36px;
        outline: none;
        border: none;
        background: #fff;
        color: #000;
        padding: 0 80px 0 20px;
        border-radius: 30px;
        box-shadow: 0px 0px 2px 0px #000, 0px 0px 0px 0 rgb(0 0 0 / 20%);
        transition: all 1s;
        opacity: 0;
        z-index: 5;
    }

    .header-search input:hover {
        cursor: pointer;
    }

    .header-search input:focus {
        width: 300px;
        opacity: 1;
        cursor: text;
    }

    .header-search input:focus ~ .search {
        right: 0;
        background: #151515;
        z-index: 6;
        left: auto;
    }

    .header-search input:focus ~ .search::before {
        top: 0;
        left: 0;
        width: 20px;
    }

    .header-search input:focus ~ .search::before {
        background: #fff;
    }

    .header-search input:focus ~ .search::after {
        top: 0;
        left: 0;
        width: 20px;
        height: 2px;
        border: none;
        background: white;
        border-radius: 0%;
        transform: rotate(-45deg);
    }

    .header-search input::placeholder {
        color: #000;
        opacity: 0.5;
    }

    #accordion .panel{
        border: none;
        border-radius: 0;
        box-shadow: none;
        margin-bottom: 0;
        position: relative;
    }
    #accordion .panel-heading{
        padding: 0;
        border: none;
        border-radius: 0;
    }
    #accordion .panel-title a{
        display: block;
        padding: 10px;
        margin: 0;
        font-size: 17px;
        font-weight: bold;
        color: #011627;
        letter-spacing: 1px;
        text-align: left;
        border-radius: 0;
        position: relative;
    }
    #accordion .panel-title a.collapsed{ background: #fff; }
    #accordion .panel-body{
        padding: 10px 20px;
        margin: 0;
        border: none;
        background: #fff;
        font-size: 15px;
        color: #114570;
        line-height: 28px;
    }

    .panel-collapse .table td {
        border-top: 0;
        border-bottom: 1px solid #dee2e6;
    }

    .click-faq i {
        position: absolute;
        top: -1px;
        margin-left: 5px;
        font-size: 14px;
        line-height: 1.2;
        border: 1px solid #000;
        border-radius: 50%;
        padding: 3px;
        right: 3px;
    }

    .click-faq i.fa.fa-plus {
        display: inline-block;
    }

    .click-faq i.fa.fa-minus {
        display: none;
    }

    .click-faq.fq-open i.fa.fa-plus {
        display: none;
    }

    .click-faq.fq-open i.fa.fa-minus {
        display: inline-block;
    }

    .mega-dropdown {
        z-index: 1022;
        color: #FFFFFF;
        border-top: 4px solid #fbf702 !important;
        padding: 0!important;
        position: absolute;
        width: 36%;
        top: 0;
        left: 0;
        font-weight: 500;
        background: rgb(211 214 221 / 25%);
        box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px;
        border-radius: 14px;
        border-top: 2px solid #fbf702 !important;
        padding-bottom: 20px !important;
    }

    .mega-dropdown-inner {
        display: none;
        margin-left: 10px;
    }

    .mega-dropdown .mega-dropdown__list-item > .mega-dropdown-inner {
        width: 90%;
    }

    .mega-dropdown:not(.mega-dropdown-inner) {
        position: relative;
    }

    .mega-dropdown .mega-dropdown__list-item {
        display: block;
        font-size: 95%;
        color: #FFFFFF !important;
        background-color: transparent;
    }

    .mega-dropdown .mega-dropdown__list-item[data-expandable=true] {
        padding: 10px 20px;
    }

    .mega-dropdown .mega-dropdown__list-item.lot-number {
        padding-left: 8px;
        padding-right: 8px;
    }

    .mega-dropdown .mega-dropdown__list-item:hover {
        background-color: rgba(16 18 27 / 40%);
        color: #fff !important;
        transition: all .2s;
    }

    .mega-dropdown__list-item .mega-dropdown {
        top: -4px;
        left: 100%;
    }

    .mega-dropdown__list-item a {
        padding: 10px 20px;
        display: block;
    }

    .mega-dropdown__list-item a {
        text-decoration: none!important;
        color: inherit!important;
    }

    /* .mega-dropdown .mega-dropdown__list-item.dropdown-active > .mega-dropdown-inner {
        display: block;
        width: 100%;
        } */

        .mega-dropdown .mega-dropdown__list-item.dropdown-active {
            background-color: rgba(16 18 27 / 40%);
            color: #fff !important;
            transition: all .2s;
        }

        .arrow-right {
            float: right;
            font-size: 1.25rem;
            transition: all 0.3s;
        }

        .dropdown-active > .arrow-right {
            transform: rotate(
                -180deg
            );
            transition: all .3s;
        }

        .select-all-sec {
            position: absolute;
            width: 75%;
            padding: 10px 20px;
            text-align: center;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            top: 0;
            right: auto;
            left: 25%;
        }

        .select-all-sec h2 {
            color: #ccc;
            letter-spacing: 2px;
            font-weight: 500;
            text-align: center;
            font-size: 2.5rem;
            line-height: 1.4;
        }

        .lot-open .lot-dt {
            display: none !important;
        }

        .lot-open .wrc-dt {
            display: inline-block !important;
        }

        .wrc-open .wrc-dt {
            display: none !important;
        }

        .wrc-open .sku-dt {
            display: inline-block !important;
        }

        .app-rej-icon {
            display: inline-block;
            font-size: 16px;
            line-height: 1;
            margin-left: 5px;
            vertical-align: bottom;
        }

        .app-rej-icon i {
            display: none;
        }

        .app-rej-icon i.fa-check-circle {
            color: green;
        }

        .app-rej-icon i.fa-times-circle {
            color: red;
        }

        .card.plan-date-tt {
            background: transparent !important;
        }

        .card.plan-date-tt .card-header {
            border: 0;
            background: transparent;
        }

        .all-cnt {
            color: #fff;
        }

        .light-dsh-mode .mega-dropdown {
            background: rgb(146 151 179 / 13%);
        }

        .light-dsh-mode .mega-dropdown .mega-dropdown__list-item {
            color: #000 !important;
        }

        .light-dsh-mode .mega-dropdown .mega-dropdown__list-item:hover {
            background-color: rgba(16 18 27 / 40%);
            color: #000 !important;
            transition: all .2s;
        }

        .light-dsh-mode .mega-dropdown .mega-dropdown__list-item.dropdown-active {
            background-color: rgba(16 18 27 / 40%);
            color: #000 !important;
            transition: all .2s;
        }

        .light-dsh-mode .all-cnt {
            color: #000;
        }

        .article-process-count {
            color: #fff;
        }

        .light-dsh-mode .article-process-count {
            color: #000;
        }

        .art-title {
            font-size: 24px;
            font-weight: 300;
            margin: 16px 0 8px 0px;
            color: #fff;
            text-align: center;
        }

        .light-dsh-mode .art-title {
            color: #000;
        }

        .progress-bar {
            -webkit-animation: progress-bar-stripes 2s linear infinite;
            -o-animation: progress-bar-stripes 2s linear infinite;
            animation: progress-bar-stripes 2s linear infinite;
            background-color: #5cb85c;
        }

        .col-slide-sku-wrap {
            display: none;
        }

        .count-no,
        .count-text {
            display: block;
            text-align: center;
        }

        .count-no {
            margin-bottom: 10px;
            font-size: 20px;
            font-weight: bold;
        }

        .pr-count {
            color : #fff;
        }

        .light-dsh-mode .pr-count {
            color : #000;
        }

        .count-text {
            font-size: 12px;
        }

        .article-process-count .card-body {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .sku-number-ul {
            min-height: 240px;
            max-height: 600px;
            height: 100%;
            overflow-y: auto;
        }

        .sku-number-ul::-webkit-scrollbar {
            display: none;
        }

        .sku-head {
            position: sticky;
            top: 0;
            left: 0;
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
            color: #ffff;
            background-color: rgba(16 18 27 / 80%);
            z-index: 10;
        }

        .all-sts {
            display: block;
            margin-bottom: 20px;
            font-size: 14px;
            width: 100%;
        }

        .col-sts {
            display: inline-block;
            vertical-align: top;
            margin-right: 14px;
        }

        .col-sts.completed-sts {
            margin-right: 0;
        }

        .all-sts .sts-txt {
            margin-left: 8px;
            vertical-align: top;
        }
        
        .lot_text,
        .wrc_text {
            margin-right: 15px;
        }

        .st-bdge {
            margin-right: 5px;
        }

        .sts-wrap {
            float: right;
            margin-right: 10px;
        }

        @media (min-width: 992px) {
            .upld-rw-card {
                max-height: 500px;
                height: 100vh;
                overflow-y: auto;
            }
        }

        @media (min-width: 1348px) {
            .upld-rw-card {
                max-height: 800px;
            }
        }

        @media (max-width: 1199px) and (min-width: 576px) {
            .plan-modal {
                max-width: 90%;
            }
        }



        @media (max-width: 991px) {
            .mega-dropdown__list-item .mega-dropdown {
                left: 0;
                top: 100%;
                margin-top: 20px;
                margin-left: 0;
            }

            .select-all-sec {
                display: none;
            }

            .mega-dropdown {
                width: 100%;
            }

            .dropdown-active > .arrow-right {
                transform: rotate(-270deg);
            }

            .mega-dropdown .mega-dropdown__list-item > .mega-dropdown-inner {
                width: 100%;
            }

            .upld-rw-card {
                max-height: 900px;
                height: 100vh;
                overflow-y: auto;
            }
        }

        @media (max-width: 767px) {


            .date-info {
                clear: both;
            }

            #accordion .panel-title a {
                font-size: 14px;
                padding: 4px;
            }

            .click-faq i {
                padding: 2px;
            }
        }

        @media (max-width: 479px) {
            dt.col-4 {
                font-size: 11px;
            }

            .header-search input:focus {
                width: 250px;
            }
        }
        
        .revised-list {
            padding: 20px;
            max-height: 300px;
            height: 100%;
            overflow-y: auto;
        }

        .revised-list > ol {
            margin: 0;
            display: block;
            padding: 0;
            padding-left: 15px;
            font-size: 16px;
            color: #fff;
        }

        .light-dsh-mode .revised-list > ol {
            color: #000;
        }

        .revised-list > ol > li {
            position: relative;
            width: 100%;
        }

        .revised-list > ol > li:not(:last-child) {
            margin-bottom: 10px;
        }

        .revised-list > ol > li span {
            font-weight: 500;
            display: inline-block;
        }

        .revised-list h5 {
            margin-bottom: 10px;
        }

        .revised-list h5 > span {
            display: block;
            margin-bottom: 10px;
        }

        .revised-list h5 > span.success-folder {
            color: #6ff46f;
        }

        .revised-list h5 > span.error-folder {
            color: #e23a3a;
        }

        @media (max-width: 479px) {
            .revised-list > ol {
                font-size: 14px;
            }

            .revised-list h5 {
                font-size: 1rem;
            }
        }
        
.loader-ajax{
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0,0,0,.5);
    z-index: 99999;
}
.loader-ajax img{
    position: absolute;
    top: 40%;
    left: 46%;
    width: 90px;
}
.loader-ajax a{
    position: absolute;
    top: 40%;
    left: 45%;
    color: #fff !important;
    font-size: 50px;
    font-weight: 400;
}

    </style>

    <body>

<div class="loader-ajax" style="display: none;">
            <img src="{{asset('dist/img/2021-03-22.gif')}}" alt="loader">
          </div>
        <div class="container-fluid mt-1">
            <div class="row m-0">
                <div class="card card-transparent col-12 p-sm-0 shadow-none upld-rw-card" style="border-color: #fbf702;">
                    <div class="card-header px-lg-3 py-lg-4 px-2 py-4">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card-title float-left all-cnt" style="width: 100%;">
                                    <div class="row">
                                        <div class="col-md-7 mb-md-0 mb-3">
                                            <div class="all-sts">
                                                <div class="col-sts pending-sts">
                                <span class="badge d-inline-block rounded-circle p-lg-2 p-md-1 p-sm-1 p-1" style="background: #FFFF00; vertical-align: middle;"></span><span class="d-inline-block sts-txt">-> Pending</span>
                                                </div>
                                    <div class="col-sts completed-sts">
                            
                            <span class="badge d-inline-block rounded-circle p-lg-2 p-md-1 p-sm-1 p-1" style="background: #4C0099; vertical-align: middle;"></span><span class="d-inline-block sts-txt">-> Completed</span>
                                                </div>
                                            </div>
                                            <span class="lot-dt count" style="display: block;">
                                                LOT Count - <span class="text-bold" id="lot_count"></span>
                                            </span>
                                            <span class="wrc-dt count" style="display: none;">
                                                WRC Count - <span class="text-bold" id="wrc_count"></span>
                                            </span>
                                            <span class="sku-dt count" style="display: none;">
                                                SKU Count - <span class="text-bold" id="sku_count"></span>
                                            </span>
                                            <a href="javascript:void(0)"  class="btn btn-sm btn-primary mt-0 ml-1 view-bulk-images d-none" style="vertical-align: baseline;" onclick="Selectedvalue(this)">
                                                <span class="d-inline-block">
                                                    Upload Bulk Images
                                                </span>
                                            </a>
                                        </div>
                                     <div class="col-md-5 mb-md-0 mb-3">
                            <select class="ml-2 select2 required" id = "day_plan_list" name="date" style="width: 100%;" onchange="skuList(this)">
                                                @foreach($shoot as $shootday)
                                                <option value="{{$shootday->id}}">{{$shootday->date}} | {{$shootday->studio}} | {{$shootday->rawqc}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-md-0 mt-3">
                                <div class="card-title float-right ml-2">
                                    <button type="button" class="btn btn-sm btn-primary mt-n2 view-scdh">
                                        <span class="d-md-inline-block d-none">
                                            View Plan Schedule
                                        </span>
                                        <i class="fas fa-bars d-md-none d-inline-block" data-toggle="tooltip" data-placement="left" title="" data-original-title="View Plan Schedule" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body upld-raw-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-xl-4 col-lg-6 order-lg-1">
                                <div class="form-group">
        <label class="required">Uploaded SKU Codes</label>
        <input type="textarea" class="form-control rounded-0" readonly placeholder="SKU Codes" name="skucodes" id="skucodes">
    </div>
                            </div>

                            <div class="col-12 col-md-12 col-xl-8 col-lg-6">
                                <div class="file-upload-wrapper col-slide-sku-wrap">
                                     <form method="POST" action="" id="upload">
                                        @csrf
                                        <label class="text-center d-block required mt-3 mb-2" style="font-size: 24px; font-weight: 300;">
                                            Upload WRC Zip 
                                        </label>
                                     <div class="image-uploader">
        <div class="uploader-pop">
            <div class="dropzone-wrapper">

                <div class="dropzone"  id="my-awesome-dropzone">

                    <form method="post" action="" enctype="multipart/form-data">
                      @csrf
                      <i class="fas fa-cloud-upload-alt drop-addicon" style="font-size: 3rem; position: relative; top:25px;"></i>
                      <div class="fallback">
                <input type="hidden" name="selected_wrc_upload" id="selected_wrc_upload">
            <input type="hidden" name="selected_lot_upload" id="selected_lot_upload">

                        <input name="sku_images" type="file" multiple />
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
                                </div>
                            </div>
                        </div>
                        <div class="row position-relative" style="clear: both;">
                            <div class="col-12 col-sm-12 col-lg-4 mt-3 mt-lg-0 order-lg-1">
                                <div class="comment-form ml-lg-3" style="display: none;">
                                    <form method="POST" id="cmnt-form" action="" class="pt-3">
                                        @csrf


                                        <input type="hidden" id="selected_sku_id" name="selected_sku_id">
                                        <input type="hidden" id="selected_sku_text" name="">
                                        <input type="hidden" id="selected_lot" name="">
                                        <input type="hidden" id="selected_wrc" name="">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="customCheckbox2" checked="" disabled="">
                                                <label for="customCheckbox2" class="custom-control-label" style="font-weight: 400;">mention reason for rejecting this sku</label>
                                            </div>
                                        </div>
                                        <p class="text-success" id="msg" style="display: none">comment Sku submitted succesfully</p>
                                        <div class="form-group">
                                            <label>Why??</label>
                                            <textarea class="form-control" rows="4" name="sku_c" id="skucomment" placeholder="Enter your reason..."></textarea>
                                        </div>
                                        <div class="form-group">
                                            <a href="javascript:void(0)" class="btn btn-default" onclick="updateComment()">Comment</a>
                                        </div>
                                    </form>
                                </div>
                                <div class="image-uploader pt-3 ml-lg-3" style="display: none;">

                                    <div class="uploader-pop">
                                        <div class="sku-comments">
                                            <h5 class="text-center">No. of image present in <span id="image_sku_text"></span>&nbsp;:&nbsp;<span id = "image_count"></span></h5>

                                        </div>
                                        <div class="dropzone-wrapper">
                                            <form action="/raw-imgupload" method="post" enctype="multipart/form-data" class="dropzone" id="sku_images_form">
                                                @csrf

                                                <div class="fallback">
                                                    <input name="sku_images[]" type="file" multiple />
                                                </div>
                                            </form>
                                        </div>

                                    </div>


                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-lg-8 mt-3 mt-lg-0 position-static">
                             <div id="sku_list_content">{!! $skuListContent !!}</div> 

                         </div>
                     </div>
                     <!-- /.card -->
                 </div>
             </div>
         </div>

         <div class="modal fade" id="modal-sm">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Upload Raw Images</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-bold small"> <i class="fas fa-info-circle"></i>
                        If the selected SKU is approved, click on the approved option, if not, select reject.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm float-right child-comment-trigger child-trigger" data-dismiss="modal">Reject</button>
                        <button type="button"  class="btn btn-success btn-sm child-pop-trigger child-trigger" data-dismiss="modal">Approved</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


        <div class="modal fade" id="plan-schedule">
            <div class="modal-dialog modal-xl plan-modal">
              <div class="modal-content">
                <div class="modal-body">
                    <div class="card plan-date-tt shadow-none mb-0">
                        <div class="card-header text-center">
                            <h3 class="card-title float-none text-bold text-uppercase">Plan Schedule</h3>
                        </div>
                        <div class="card-body px-0 pb-0">
                            <div class="panel-group">
                                <div id="dynamic-schedule-content" class="panel panel-default"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


</div>

<div class="fix-infor-wrapper">
    <a href="javascript:;" class="information-pp-btn" id="info-popbtn">
      <i class="fas fa-info ic-infor"></i>
      <i class="fas fa-times cl-infor"></i>
  </a>
  <div class="infor-content">
    <ul class="info-ll-list">
        <li><b>In order to upload raw images, search for the studio, your name, and the adjoining date, and select the row to locate your planned LOT.</b></li>
        <li><b>You can check your planned schedule on the ‘View Plan Schedule’ on the table head.</b></li>
    </ul>
</div>
</div>

<script type="application/javascript" src="plugins/jquery/jquery.min.js"></script>
<script type="application/javascript" src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script type="application/javascript" src="plugins/dropzone/dropzone.js"></script>

<script src="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/js/plugins/mdb-file-upload.min.js"></script>

<script type="application/javascript" >


    $(function () {
        calculateNumbers();
    });

    $("#sku_images_form").dropzone({
        url: '/raw-imgupload',
        paramName: 'sku_images',
        clickable: true,
        maxFilesize: 100000,
        uploadMultiple: true,
        maxFiles: 10000,
        timeout: 180000,
        addRemoveLinks: true,
        autoProcessQueue: true,
        acceptedFiles: '.jpg,.jpeg,.png',
        dictDefaultMessage: '+ Drag or Drop Images Here ',
        init: function () {
           
            var myDropzone = this;

                // Update selector to match your button
                $("#button").click(function (e) {
                    e.preventDefault();
                    myDropzone.processQueue();
                });
            },
            success: function(file, response)
            {
                var selected_sku_id = $('#selected_sku_id').val();
                (selected_sku_id)
            }
        });

    $('.click-faq').click(function(){
        $(this).toggleClass('fq-open');
    });

    $(document).on('click', '.child-pop-trigger', function () {
        $('.dropzone')[0].dropzone.files.forEach(function (file) {
            file.previewTemplate.remove();
        });
        $('.dropzone').removeClass('dz-started');
    });

    $(document).on('click', '.child-comment-trigger', function () {
        $('#cmnt-form')[0].reset();
    });

    
    
    
    function getImageCount(selected_sku_id){
        showLoader();
        $.ajax({
            url: "/get-image-count" ,
            method: 'GET',
            dataType: 'text',
            data: {selected_sku_id : selected_sku_id},
            success: function(response) {
                $('#image_count').text(response);
                $('#image_sku_text').text($('#selected_sku_text').val());
                hideLoader();
            } 
        });
    }
    $(document).on('click','.child-comment-trigger', function(){
        var selected_sku_id = $('#selected_sku_id').val();
        $('.comment-form').slideDown(250);
        $('.image-uploader').slideUp(250);
        setSelectedSku(0);
        $('.sku-number').find(`[data-sku_id='${selected_sku_id}']`).children('.text-danger').addClass('d-inline-block');
        $('.sku-number').find(`[data-sku_id='${selected_sku_id}']`).children('.text-success').removeClass('d-inline-block');
        $('.sku-number').find(`[data-sku_id='${selected_sku_id}']`).children('.db').remove();
    });
    $(document).on('click','.child-pop-trigger',function(){
        var selected_sku_id = $('#selected_sku_id').val();
        $('.image-uploader').slideDown(250);
        $('.comment-form').slideUp(250);
        setSelectedSku(1);
        $('.sku-number').find(`[data-sku_id='${selected_sku_id}']`).children('.text-success').addClass('d-inline-block');
        $('.sku-number').find(`[data-sku_id='${selected_sku_id}']`).children('.text-danger').removeClass('d-inline-block');
        $('.sku-number').find(`[data-sku_id='${selected_sku_id}']`).children('.db').remove();
      });
    function setSelectedSku(status){
        var selected_sku_id = $('#selected_sku_id').val();
        var selected_sku_text = $('#selected_sku_text').val();
        var selected_lot = $('#selected_lot').val();
        var selected_wrc = $('#selected_wrc').val();
        showLoader();
        $.ajax({
            url: "/set-values/" ,
            method: 'GET',
            dataType: 'text',
            data: {selected_lot : selected_lot, selected_wrc : selected_wrc, selected_sku_id : selected_sku_id, selected_sku_text : selected_sku_text, status : status},
            success: function(htmlData) {
                hideLoader();
            } 
        });
    }
    function Selectedvalue(obj){
        $('#selected_wrc_upload').val($('#selected_wrc').val());
        $('#selected_lot_upload').val($('#selected_lot').val());
    }
    $(document).on('click', '.lot-number', function () {
        $('body').addClass('lot-open');
        $('body').removeClass('wrc-open');
        $('.wrc-number').removeClass('dropdown-active');
        var lot_text = $(this).find('.lot_text').text().trim();
        $('#selected_lot').val(lot_text);
        var wrc_number = $(this).find('.wrc-number').length;
        $('#wrc_count').text(wrc_number);
        $('.lot-number').removeClass('dropdown-active');
        $(this).addClass('dropdown-active');
        $('.lot-number').children('.mega-dropdown-inner').slideUp(250);
        $(this).children('.wrc-number-ul.mega-dropdown-inner').slideDown(250);
        $('.sku-number-ul').css('display', 'none');
    });
    $(document).on('click', '.wrc-number', function (e) {
        $('body').addClass('wrc-open');
        var wrc_text = $(this).find('.wrc_text').text().trim();
        $('#selected_wrc').val(wrc_text);
        var sku_number = $(this).find('.sku-number').length;
        $('#sku_count').text(sku_number);
        $('.wrc-number').removeClass('dropdown-active');
        $(this).addClass('dropdown-active');
        $('.wrc-number').children('.mega-dropdown-inner').slideUp(250);
        $(this).children('.mega-dropdown-inner').slideDown(250);
        e.stopPropagation();
        $('.view-bulk-images').addClass('d-inline-block');
    });
    $(document).on('click', '.sku-number > a', function(e){
        var sku_id = $(this).data('sku_id');
        var sku_text = $(this).text().trim();
        var sku_status = $(this).data('sku_status');
        $('.child-comment-trigger').removeClass('hidden');
        $('.child-pop-trigger').text('Approved');
        $('#selected_sku_id').val(sku_id);
        $('#selected_sku_text').val(sku_text);
        if(sku_status == '1'){
            $('.child-comment-trigger').addClass('hidden');
            $('.child-pop-trigger').text('Upload More Images');
        }
        $('#modal-sm').modal('show');
        getImageCount(sku_id);
        e.stopPropagation();
    });

    $('.view-scdh').click(function(){
        var day_plan_id = $('#day_plan_list').val();
        showLoader();
        $.ajax({
            url: "/get-plan-schl" ,
            method: 'GET',
            dataType: 'html',
            data: {day_plan_id : day_plan_id},
            success: function(htmlData) {
                $('#dynamic-schedule-content').html(htmlData);
                $('#plan-schedule').modal('show');
                hideLoader();
            } 
        });
    });

    function updateComment(){
        $.ajax({
            url: "/update-comment1" ,
            method: 'POST',
            dataType: 'text',
            data: $('#cmnt-form').serialize(),
            success: function(response) {
                $('#msg').slideDown('slow');
                setTimeout(function(){ 
                    $('#msg').slideUp('slow'); }, 3000);
            } 
        });
    }

    $(document).on('click','.view-bulk-images', function(){
        $('.col-slide-sku-wrap').slideDown(250);

    });

   $("#my-awesome-dropzone").dropzone({
        url: '/raw-img-bulkupload',
        paramName: 'sku_images',
        clickable: true,
        maxFilesize: 1000000,
        uploadMultiple: true,
        maxFiles: 10000,
        timeout: 180000,
        addRemoveLinks: false,
        autoProcessQueue: true,
        acceptedFiles: '.jpg,.jpeg,.png',
        dictDefaultMessage: 'Drag or Drop images here',
        sending: function(file, xhr, formData) {
            
        var selected_lot = $('#selected_lot').val();
        var selected_wrc = $('#selected_wrc').val(); 
        
            formData.append("_token", $('[name=_token').val());
            formData.append("lotid", selected_lot);
            formData.append("wrcid", selected_wrc);
            formData.append("skucodes", $('#skucodes').val());

        },
        init: function () {
            var myDropzone = this; 
        },
        success: function(file, response)
        {
            if(response.status == false){
                alert(response.message);
            }else{

                $('#skucodes').val(response.sku_codes);

            }

        }

    });
</script>







</body>

</html>

@endsection