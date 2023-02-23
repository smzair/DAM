@extends('layouts.admin')
@section('title')
Flipkart Table
@endsection
@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<style type="text/css">
    .btn.deactive-btn {
        border: 0 !important;
        background-color: rgb(196, 196, 196, 1) !important;
        pointer-events: none !important;
        cursor: default !important;
        opacity: 0.6;
        color: #000 !important;
    }</style>
    <div class="container">
        <div class="row">
            <div class="col-12">
             <p class="text-center text-success">{{session()->pull('message')}}</p>
             <div class="card card-transparent">
                <div class="card-header">
                    <h3 class="card-title">All Uploads</h3>
                    <div class="download-action">
                        <a href="{{route('flipkart.editors.upload')}}" class="btn btn-warning" id="homeActionBtn">Home
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
                    <table class="table data-table table-head-fixed table-hover text-nowrap text-center" id="alluploadTable">
                        <thead>
                            <tr>
                                <th>WRC No</th>
                                <th>LOT No</th>
                                <th>Upload Count</th>
                                <th>Upload Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($totalImgCount as $flip)
                            <tr>
                                <td>{{$flip['wrc_id']}}</td>
                                <td>{{$flip['lot_id']}}</td>
                                <td>{{$flip['imgcount']}}</td>
                                <td>{{dateFormat($flip['created_at'])}}</td>
                                <td>
                                   @if($flip['fstart'] == 0)
                                   <a href="#" class="btn btn-warning" data-wrc_id="{{$flip['wrcId']}}" onclick="Editingstart(this)"id="markDonwBTN">Start Editing</a>
                                   @else
                                   <a href="#" class="btn btn-warning deactive-btn" data-wrc_id="{{$flip['wrcId']}}" id="markDonwBTN">Editing started...</a>

                                   @endif
                                   <a href="#" class="btn btn-warning" data-wrc_id="{{$flip['wrcId']}}" onclick="wrcDone(this)"id="markDonwBTN">Mark Done</a>

                                   <a href="#" class="btn btn-warning" id="alluploadBTN" data-wrc_id="{{$flip['wrcId']}}" onclick="wrcFiles(this)"  data-toggle="modal" data-target=".upload-image-listing-modal">All Upload</a>

                                   <a href="#" class="btn btn-warning" id="downloadACBTN" data-toggle="modal" data-wrc_id="{{$flip['wrcId']}}" onclick="filesDownload(this)" data-target="#uploadactionimageListingModal">Download Files</a>
                               </td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
   </div>
</div>

<div class="modal fade upload-image-listing-modal" id="uploadimageListingModal uploads" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content upload-imagelisting-modal-content dynamic" id="dynamic">

        </div>
    </div>
</div>

<div class="modal fade upload-image-listing-modal" id="uploadactionimageListingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content upload-imagelisting-modal-content " >
            <div class="modal-header">
                <h5 class="modal-title">
                    Download Files
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="file-uploaded-list with-dwnload-btn " >
                    <ul class="list-group dynamicdown" id="dynamicdown">


                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End of Editor Mask Done Download Table -->


<!-- CSS  -->

<style>
	
	/* Downoload Button Style */
    .download-action {
        float: right;
    }
    /* End of Downoload Button Style */

    /* File Uploaded List */

    .file-uploaded-list > ul .file-num {
        margin-right: 4px;
    }

    .file-uploaded-list > ul .file-span {
        display: inline-block;
    }

    .file-uploaded-list > ul .file-action {
        float: right;
    }

    .file-uploaded-list > ul .file-action-btn {
        margin: 0 !important;
    }

    .file-uploaded-list > ul.list-group > li.list-group-item {
        background-color: transparent !important;
        border: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .file-uploaded-list > ul .list-content-inner {
        display: flex;
    }

    .file-uploaded-list > ul .file-span.file-count {
        margin-left: auto;
    }

    .file-uploaded-list.with-dwnload-btn > ul .file-span.file-count {
        margin-left: auto;
        margin-right: auto;
    }

    /* End of File Uploaded List */

</style>

<!-- JS -->

<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- File Uploader Plugin -->
<script src="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/js/plugins/mdb-file-upload.min.js"></script>

<script>
	// File Uploadeder
    $('.file-upload').file_upload();

    function wrcFiles(obj) {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        var wrc_id = $(obj).data('wrc_id');
        $.ajax({
            headers:headers,
            url: "/wrc-file",
            method: 'GET',
            dataType: "html",
            data: {wrc_id: wrc_id},
            success: function (htmlData) {
                $('.dynamic').html(htmlData);

            }

        });

    }


    function filesDownload(obj) {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        var wrc_id = $(obj).data('wrc_id');

        $.ajax({
            headers:headers,
            url: "/files-download",
            method: 'GET',
            dataType: "html",
            data: {wrc_id: wrc_id},
            success: function (htmlData) {
                $('.dynamicdown').html(htmlData);

            }

        });

    }


    function wrcDone(obj) {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        var wrc_id = $(obj).data('wrc_id');
        alert('Are you sure it is done, as you are about to remove this WRC by marking done');
        $.ajax({
            headers:headers,
            url: "/wrc-Done",
            method: 'GET',
            dataType: "text",
            data: {wrc_id: wrc_id},
            success: function (data) {
              window.location.reload();
          }

      });

    }


    function Editingstart(obj) {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        var wrc_id = $(obj).data('wrc_id');

        $.ajax({
            headers:headers,
            url: "/editing-started",
            method: 'GET',
            dataType: "html",
            data: {wrc_id: wrc_id},
            success: function (htmlData) {
               window.location.reload();

           }

       });

    }


</script>
@endsection
