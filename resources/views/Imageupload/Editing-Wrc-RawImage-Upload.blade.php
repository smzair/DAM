@extends('layouts.admin')

@section('title')
Editing Wrc Raw Image Upload
@endsection
@section('content')
<link rel="stylesheet" href="plugins/dropzone/dropzone.css">
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
        min-height: 150px;
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

<div class="lot-table mt-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-transparent">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-7 col-md-6 col-sm-12">
                                <h3 class="card-title text-black text-bold">
                                    <span class="d-inline-block align-middle">
                                        All WRC
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
                                    <a class="btn btn-xs float-left align-middle mt-0 mr-2 py-1 px-2 mb-1" href="{{route('EditingWrcCreate')}}" style="position: relative; top: 2px;">Add New WRC</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                        <table id="wrcTableCat" class="table table-head-fixed table-hover text-nowrap data-table">
                            <thead>
                            <tr class="wrc-tt">
                                    <th class="p-2">Id</th>
                                    <th class="p-2">LOT Number</th>
                                    <th class="p-2">Company Name</th>
                                    <th class="p-2">Brand Name</th>
                                    <th class="p-2">WRC Number</th>
                                    <th class="p-2">WRC Created At</th>
                                    <th class="p-2">Type of Service</th>
                                    <th class="p-2">Tentative Image Count</th>
                                    <th class="p-2">Upload Image Link Received</th>
                                    <th class="p-2">Upload SKU Sheet</th>    
                                    <th class="p-2">Upload Image Count</th>    
                                    <th class="p-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // pre($wrcs[0]);
                                @endphp
                                @foreach($wrcs as $key => $row)

                                    <tr id="tr{{ $key }}" >
                                        <td class="p-sm-2 p-1">{{$key+1}}</td>

                                        <td data-value="lot_number">{{ $row['lot_number'] }}</td>
                                        <td data-value="Company">{{ $row['Company_name'] }}</td>
                                        <td data-value="name">{{ $row['name'] }}</td>
                                        <td data-value="wrc_number">
                                            {{ $row['wrc_number'] }}
                                        </td>
                                        <td data-value="wrc_cr_at">{{ dateFormet_dmy($row['created_at']) }}<br><b>{{timeFormat($row['created_at'])}}</b></td>
                                        <td data-value="type_of_service">{{ $row['type_of_service'] }}</td>
                                        <td data-value="imgQty">{{ $row['imgQty'] }}</td>
                                        <td data-value="documentTypeLink" id="" class="p-sm-2 p-1">
                                            @if ($row['documentType'] == 0)
                                                <a target="_blank" href="{{$row['documentUrl']}}">Link</a>
                                                
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td data-value="documentTypeSheet" id="" class="p-sm-2 p-1">
                                            @if ($row['documentType'] == 1)
                                                <a target="_blank" href="{{ asset('/storage/Uploaded_SKU') }}{{"/".$row['documentUrl']}}">Sheet</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td data-value="uploaded_img_qty" id="uploaded_img_qty{{$key}}">{{ $row['uploaded_img_qty'] }}</td>

                                        <td>
                                            <button class="btn btn-warning" id="allocateBTnC" data-toggle="modal"  data-target="#allocateWRCPopupCAt" onclick="setvalue({{ $key }})"> Upload Raw Image </button>
                                        </td>
                                        <input type="hidden" id="key_is{{ $key }}" value="{{ $key }}">
                                        <input type="hidden" id="wrc_id{{ $key }}" value="{{ $row['wrc_id'] }}">
                                        <input type="hidden" id="lot_id{{ $key }}" value="{{ $row['lot_id'] }}">
                                        <input type="hidden" id="work_initiate_date{{ $key }}"  value="{{ $row['work_initiate_date'] }}">
                                        <input type="hidden" id="work_committed_date{{ $key }}"  value="{{ $row['work_committed_date'] }}">
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

<div class="modal fade allocation-wrc-modal" id="allocateWRCPopupCAt">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h4 class="modal-title">Shoot Allocation WRC</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="{{route('EditingWrcRawImgUpload')}}" method="POST" action="" id="EditingWrcRawImgUpload" enctype="multipart/form-data">
                    @csrf

                    <div class="custom-dt-row wrc-details mb-3">
                        <div class="row mb-3">
                            <div class="col-sm-4 col-6">
                                <div class="col-ac-details">
                                    <h6>WRC Number</h6>
                                    <p id="wrcNo"></p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-6">
                                <div class="col-ac-details">
                                    <h6>Tentative Image Count</h6>
                                    <p id="imgQty"></p>
                                </div>
                            </div>

                            <div class="col-sm-4 col-6">
                                <div class="col-ac-details">
                                    <h6>Selected LOT</h6>
                                    <input id="lot_number" rows="3" cols="4" style="width: 100%;" disabled />
                                </div>
                            </div>
                        </div>
                        {{-- Editor Allocated SKU --}}
                        <div class="row ">
                            <div class="col-sm-12 col-12">
                                 <div class="image-uploader">
                                    <div class="uploader-pop">
                                        <div class="dropzone-wrapper">
                                            <div class="dropzone"  id="my-awesome-dropzone">
                                                <i class="fas fa-cloud-upload-alt drop-addicon" style="font-size: 3rem; position: relative; top:25px;"></i>
                                                <div class="fallback">
                                                    <input name="sku_images" type="file" multiple accept="image/*" />
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-dt-row allocater-selection"> 
                        <div class="row">
                            <div class="col-sm-12 col-12" style="text-align: end">
                                <input id="key_is" name="key_is" type="hidden" value="">
                                <input id="wrc_id" name="wrc_id" type="hidden" value="">
                                <input id="lot_id" name="lot_id" type="hidden" value="">
                                <input id="wrc_text" name="wrc_text" type="hidden" value="">
                                <input id="lot_text" name="lot_text" type="hidden" value="">
                               <p class="" id="message" style="text-align: justify;margin-top: 10px"></p>
                                {{-- <button class="btn btn-warning" >Upload</button> --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- End of Table -->



<!-- DataTable Plugins Path -->

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<!-- End of DataTable Plugins Path -->

<!-- Data Table Calling Function -->

<script>
  $('#wrcTableCat').DataTable({
        dom: 'lBfrtip',
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "buttons": ["copy", "csv", "excel", "pdf"]
  }).buttons().container().insertAfter('#masterData_wrapper .dataTables_length');
</script>

<!-- jQuery -->
<script src="{{ asset('/js/app.js') }}"></script>
<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script type="application/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="application/javascript" src="plugins/dropzone/dropzone.js"></script>

<script type="application/javascript" src="plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script >

    $("#my-awesome-dropzone").dropzone({
        url: '/Editing-Wrc-raw-image-upload1',
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
            formData.append("wrcid", $('#wrc_id').val());
            formData.append("wrc_text", $('#wrc_text').val());
            formData.append("lot_id", $('#lot_id').val());
            formData.append("lot_text", $('#lot_text').val());
        },
        init: function () {
            var myDropzone = this; 
        },
        success: function(file, res)
        {
            response = JSON.parse(res)
            const key_is = $('#key_is').val()
            console.log(key_is, 'response', response)
            console.log('#uploaded_img_qty'+key_is)
            if(response.status == false){
                alert(response.message);
            }else{
                document.getElementById('message').innerHTML = response.message + " Total Uploaded images "+ response.tot_uploaded_img_qty
                document.getElementById('uploaded_img_qty'+key_is).innerHTML = response.tot_uploaded_img_qty
            }
        }
    });
</script>

{{-- setvalue to model --}}
<script>
   async function setvalue(val){

        document.getElementById("EditingWrcRawImgUpload").reset()
        let data = {}
        var rowItems = $("#tr"+val).children('td').map(function () {
            data = {
                ...data,
                [this.getAttribute('data-value')]: this.innerHTML
            }
        })
        
        const key_is = val;
        const wrc_id_is = document.querySelector("#wrc_id"+val).value
        const lot_id_is = document.querySelector("#lot_id"+val).value
        const imgQty = data.imgQty
        
        document.querySelector("#key_is").value =  key_is
        document.querySelector("#wrc_id").value =  wrc_id_is
        document.querySelector("#wrcNo").innerHTML = data.wrc_number
        document.querySelector("#imgQty").innerHTML = imgQty
        document.querySelector("#lot_id").value =  lot_id_is
        document.querySelector("#lot_number").value = data.lot_number
        document.querySelector("#wrc_text").value = data.wrc_number
        document.querySelector("#lot_text").value = data.lot_number
    }
</script>
@endsection