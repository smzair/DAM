

@extends('layouts.admin')

@section('title')
Editor's Panel
@endsection
@section('content')

<link rel="stylesheet" href="plugins/dropzone/dropzone.css">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<style>
    .card-primary:not(.card-outline)>.card-header a {
        color: #000;
    }

    .alert-dialog {
        background-color: #f4f4f4;
        color: #1f1f21;
    }

    .alert-dialog-title {
        font-weight: 400;
        font-weight: 400;
        font-size: 17px;
        font-weight: 500;
        padding: 0 8px;
        text-align: center;
        color: #1f1f21;
    }

    .alert-dialog-button--rowfooter {
        color: #0076ff;
        border-top: 1px solid #ddd;
        cursor: pointer;
    }

    .lot-popup-list ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .lot-popup-list > ul {
        display: block;
    }

    .lot-popup-list ul li {
        position: relative;
    }

    .lot-popup-list ul li a {
        text-decoration: none !important;
    }

    .lot-popup-list > ul {
        padding: 15px 0;
    }

    .lot-popup-list > ul li {
        font-size: 16px;
        line-height: 1.4;
    }

    .lot-popup-list > ul li > a {
        display: block;
        position: relative;
        color: #000;
        padding: 10px 0;
        font-weight: 500;
    }

    .lot-popup-list ul ul.submenu {
        display: none;
    }

    .child-trigger {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 42px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        cursor: pointer;
    }

    .child-trigger i.trigger-icon {
        margin-left: 5px;
        vertical-align: middle;
    }

    .child-trigger i.fa-plus {
        display: inline-block;
    }

    .child-trigger i.fa-minus {
        display: none;
    }

    .child-trigger.child-open i.fa-plus {
        display: none;
    }

    .child-trigger.child-open i.fa-minus {
        display: inline-block;
    }

    .lot-popup-list ul.submenu-wrapper ul {
        padding-left: 20px;
    }

    .wrc-cnt {
        display: inline-block;
    }

    .sku-cnt {
        display: none;
    }

    .img-cnt {
        display: none;
    }

    .lot-popup-list > ul li > span {
        display: block;
        position: relative;
        color: #000;
        padding: 6px 0;
        font-weight: 500;
        font-size: 13px;
    }

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

    .dz-started .drop-addicon {
        display: none;
    }

    .all-no-list {
        border-right: 1px solid rgba(0,0,0,.125);
    }

    .all-no-list li.list-group-item {
        padding: 0 !important;
    }

    a.list-links {
        color: inherit;
        display: block;
    }

    .all-no-list li.list-group-item .list-links {
        padding: .75rem 1.25rem;
        padding-left: 10px;
        padding-right: 10px;
        transition: all .2s;
    }

    .all-no-list li.list-group-item .list-links:hover {
        background-color: #ececec;
    }

    .arrow-right {
        float: right;
        font-size: 1.25rem;
        transition: all 0.3s;
    }

    .wrcs-no-list {
        display: none;
    }

    .skus-no-list {
        display: none;
    }

    .lots-no-list.list-collapse,
    .wrcs-no-list.list-collapse {
        -ms-flex: 0 0 60px;
        flex: 0 0 40px;
        max-width: 40px;
        overflow: hidden;
        position: relative;
        transition: all 0.4s ease-in-out;
    } 

    .lots-no-list.list-collapse h5,
    .wrcs-no-list.list-collapse h5 {
        transition: all 0.5s ease-in-out;
        min-width: 100%;
        text-align: center;
        position: absolute;
        right: 0;
        white-space: nowrap;
        top: 60%;
        bottom: 0;
        transform: translateY(-50%) rotate(-90deg);
        transform-origin: 0% 0%;
        width: 40px;
        height: 0;
    }

    .lots-no-list.list-collapse ul,
    .wrcs-no-list.list-collapse ul {
        display: none;
    }

    .collapse-icon {
        cursor: pointer;
        display: none;
        margin-left: 5px;
    }

    .image-list > li > a,
    .image-list-pop > li > a {
        display: inline-block;
    }

    .edit-tabl-link > .nav-item > a.nav-link {
        color: #fff !important;
        background-color: transparent !important;
        border: 0 !important;
    }

    .edit-tabl-link > .nav-item > a.nav-link:hover,
    .edit-tabl-link > .nav-item > a.nav-link:focus {
        color: #000 !important;
        background-color: rgb(255, 255, 0, 0.8) !important;
    }

    .edit-tabl-link > .nav-item > a.nav-link.active {
        color: #000 !important;
        background-color: rgb(255, 255, 0, 0.8) !important;
    }

    .light-dsh-mode .edit-tabl-link > .nav-item > a.nav-link {
        color: #000 !important;
    }

    .amore-link {
        color: #fff !important;
    }
    .hideme{
        display: none !important; 
    }

    .light-dsh-mode .amore-link {
        color: #000 !important;
    }

    @media (max-width: 767px) {
        .dropzone {
            height: 270px;
        }

        .lws-list-grp {
            height: 50vh !important;
        }

        .vw-upload-img {
            overflow-y: auto;
        }
    }

    @media (max-width: 479px) {
        .edit-tabl-link > .nav-item > a.nav-link {
            font-size: 12px;
        }
    }

</style>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card card-transparent card-primary card-tabs shadow-none mb-0" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                <div class="card-header p-0 pt-1" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                    <ul class="nav nav-tabs justify-content-center row m-0 edit-tabl-link" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item col-6">
                            <a class="nav-link active text-center px-1" id="custom-tabs-first-tab" data-toggle="pill" href="#custom-tabs-first"
                            role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">Allocated Images</a>
                        </li>
                        <li class="nav-item col-6 alert-item">
                            <a class="nav-link text-center px-1" id="custom-tabs-second-tab" data-toggle="pill"
                            href="#custom-tabs-second" role="tab" aria-controls="custom-tabs-one-profile"
                            aria-selected="true">Upload Edited Images</a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="tab-content card card-transparent px-3" id="custom-tabs-one-tabContent" style="border-top-left-radius: 0 !important; border-top-right-radius: 0 !important;">
                <div class="tab-pane fade show active table-responsive" id="custom-tabs-first" role="tabpanel" aria-labelledby="custom-tabs-first-tab">
                    <table class="table projects mb-0">
                        <thead>
                            <tr>
                                <th class="align-middle" width="1%">#</th>
                                <th class="align-middle" width="15%">LOT Number</th>
                                <th class="align-middle" width="15%">Brand Name</th>
                                <th class="align-middle">WRC Count</th>
                                <th class="align-middle">SKU Count</th>
                                <th class="align-middle">Total Allocated Images</th>
                                <th class="align-middle">Details</th>
                                <th class="align-middle text-md-center" width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allocationList as  $allocated)
                            <tr>
                                <td width="1%">{{$sr++}}</td>
                                <td width="25%">{{$allocated['lot_id']}}</td>
                                 <td width="25%">{{$allocated['brand']}}</td>
                                <td>{{$allocated['wrc_count']}}</td>
                                <td>{{$allocated['sku_count']}}</td>
                                <td>{{$allocated['image_count']}}</td>
                                <td data-toggle="collapse" href="#{{$allocated['lot_id']}}" aria-expanded="false" aria-controls="{{$allocated['lot_id']}}">
                                    <a href="#{{$allocated['lot_id']}}" class="amore-link">More Details...</a></td>
                                    <td class="project-actions" width="10%">
                                        <a class="btn btn-block btn-secondary btn-sm px-1"data-lotid="{{$allocated['lotid']}}" onclick="lotDone(this)">
                                            <i class="fa fa-tick"></i>
                                            Mark LOT Done
                                        </a>
                                    </td>

                                </tr>
                                <tr id="{{$allocated['lot_id']}}">
                                    <td colspan="7" class="hiddenRow p-0 border-0">
                                      <div class="collapse" id="{{$allocated['lot_id']}}" style="border-top: 1px solid rgb(222, 226, 230);">
                                        <h3 style="font-size:36px; font-weight: 300; position: relative;" class="text-uppercase pt-3 mb-3 text-center">
                                          Details
                                          <i class="far fa-times-circle" style="position: absolute; font-size: 24px; right: 58px; top: 30px; cursor: pointer;" data-toggle="collapse" href="#{{$allocated['lot_id']}}"></i>
                                      </h3>
                                      <table class="table table-hover text-nowrap text-center mb-0 slide-tt">
                                          <thead>

                                            <tr>
                                              <th class="p-3 small text-bold text-normal">Id</th>
                                              <th class="p-3 small text-bold text-normal">WRC Number</th>
                                              <th class="p-3 small text-bold text-normal">Adaptations</th>
                                              <th class="p-3 small text-bold text-normal">Type Of Shoot</th>
                                              <th class="p-3 small text-bold text-normal">Download</th>
                                          </tr>
                                      </thead>
                                      <tbody> 
                                        @foreach($allocated['wrc_id'] as  $wrcs )
                                        <tr>
                                          <td class="p-sm-2 p-1 small">#</td>
                                          <td class="p-sm-2 p-1 small">{{$wrcs['wrc_id']}}</td>
                                          <td class="p-sm-2 p-1 small">
                                            <ol class="list-unstyled mb-0">
                                              <li>{{$wrcs['adaptation_1']}}</li>
                                              <li>{{$wrcs['adaptation_2']}}</li>
                                              <li>{{$wrcs['adaptation_3']}}</li>
                                              <li>{{$wrcs['adaptation_4']}}</li>
                                              <li>{{$wrcs['adaptation_5']}}</li>
                                          </ol>
                                      </td>
                                      <td class="p-sm-2 p-1 small">{{$wrcs['type_of_shoot']}}</td>
                                      <td> <a class="btn btn-primary btn-sm px-1"href="{{('/raw-img-download/?wrc_id=' . $wrcs['wrcid'])}}">All Images</a></td>

                                      
                                  </tr>
                                  @foreach($wrcs['sku'] as $sku)
                                  <li>{{$sku['sku_code']}}</li>
                                                                    @endforeach

                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
  </div>
  <div class="tab-pane fade" id="custom-tabs-second" role="tabpanel" aria-labelledby="custom-tabs-second-tab">

  </br> 

  <h5> Fill the form to upload edited images </h5></br> 
  <div class="upload-image-form">
   <form action="/file-upload" method="post" enctype="multipart/form-data">

    <div class="row m-0">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="required">LOT Number</label>
                <select class="custom-select select2 rounded-0"  id="lotid">
                  <option value="">Select LOT</option>
                  @foreach($allocationList as  $allocated)

                  <option value="{{$allocated['lotid']}}" >{{$allocated['lot_id']}}</option>
                  @endforeach

              </select>
          </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
            <label class="required">WRC Number</label>
            <select class="custom-select rounded-0  wrcid" name="wrcid" id="wrcid">
               <option selected value="">Select WRC</option>
           </select>
       </div>
   </div>
   <div class="col-sm-6">
    <div class="form-group">
        <label class="required">Adaptation</label>
        <select class="custom-select rounded-0" name="adaptations" id="adaptations">
         <option selected value="">Select Adaptation</option>
     </select>
 </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label class="required">Uploaded SKU Codes</label>
           <input type="text" class="form-control rounded-0" readonly placeholder="Upload Counts" name="count" id="count">
        <input type="text" class="form-control rounded-0" readonly placeholder="SKU Codes" name="skucodes" id="skucodes">
             

    </div>
</div>
<div class="col-sm-12">
    <div class="image-uploader">
        <div class="uploader-pop">
            <div class="dropzone-wrapper">

                <div class="dropzone"  id="my-awesome-dropzone">

                    <form method="post" action="" enctype="multipart/form-data">
                      @csrf
                      <i class="fas fa-cloud-upload-alt drop-addicon" style="font-size: 3rem; position: relative; top:25px;"></i>
                      <div class="fallback">

                        <input name="sku_images" type="file" multiple />
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
</br>
</br> 
</div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Comment Form</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form method="POST" action="comment-form">
            <div class="form-group">
                <label>Add A Comment</label>
                <textarea class="form-control" rows="4" name="skucomment" id="skucomment" placeholder="Enter your comment..."></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-warning">Comment</button>
            </div>
        </form>
    </div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->



</div>

<div class="fix-infor-wrapper edit-panal-fix-infor">
    <a href="javascript:;" class="information-pp-btn" id="info-popbtn">
      <i class="fas fa-info ic-infor"></i>
      <i class="fas fa-times cl-infor"></i>
  </a>
  <div class="infor-content">
    <ul class="info-ll-list">
        <li>
            <h6 style="text-decoration:underline;">Editor's Panel</h6>
            <b>To view allocated raw images, click on the ‘more details’ section and find all images under the download section.</b>
        </li>
        <li>
            <h6 style="text-decoration:underline;">Upload Edited Images</h6>
            <b>
            Make sure to select the correct LOT and WRC. Then select the adaptation in which you want to upload the edited images.</br> 
            NOTE - Please ensure that the uploaded SKU is a part of the selected WRC number. 
            For changing the adaptions, it is recommended that you refresh the page to upload images in a new adaptation.
        </b>
    </li>
</ul>
</div>
</div>

<script type="application/javascript" src="plugins/jquery/jquery.min.js"></script>

<script type="application/javascript" src="plugins/dropzone/dropzone.js"></script>

<script type="application/javascript" src="plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script >

    $("#my-awesome-dropzone").dropzone({
        url: '/edited-imgupload',
        paramName: 'sku_images',
        clickable: true,
        maxFilesize: 1000,
        uploadMultiple: true,
        maxFiles: 1000,
        addRemoveLinks: false,
        autoProcessQueue: true,
        acceptedFiles: '.jpg,.jpeg,.png',
        dictDefaultMessage: 'Drag or Drop images here',
        sending: function(file, xhr, formData) {
            formData.append("_token", $('[name=_token').val());
            formData.append("lotid", $('#lotid').val());
            formData.append("wrcid", $('#wrcid').val());
            formData.append("skucodes", $('#skucodes').val());
            formData.append("adaptations", $('#adaptations').val());
            formData.append("lot_text", $('#lotid').find(":selected").text());
            formData.append("wrc_text", $('#wrcid').find(":selected").text());
            formData.append("adaptations_text", $('#adaptations').find(":selected").text());
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
                   $('#count').val(response.count);
                 

            }

        }

    });

    function lotDone(obj) {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        var lotid = $(obj).data('lotid');
        alert('Are you sure about removing the LOT');
        $.ajax({
            url: "/lotDone",
            method: 'GET',
            dataType: "text",
            data: {lotid: lotid},
            success: function () {
              
            }

        });

    }

</script>

@endsection
