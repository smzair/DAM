@extends('layouts.admin')
@section('title')
Flipkart Upload
@endsection
@section('content')

<style>

    /* Downoload Button Style */
    .download-action {
        float: right;
    }
    /* End of Downoload Button Style */

    /* File Uploaded List */

    .file-uploaded-list > ul .file-num {
        margin-right: 5px;
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

    .file-upload {
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
        height: 200px;
        padding: 5px 10px;
        font-size: 1rem;
        text-align: center;
        color: #ccc
    }

    .file-upload-wrapper .card.card-body.has-error .file-upload-message .file-upload-error,
    .file-upload-wrapper .card.card-body.has-preview .btn.btn-sm.btn-danger {
        display: block
    }

    .file-upload i {
        font-size: 3rem
    }

    .file-upload .mask.rgba-stylish-slight {
        opacity: 0;
        -webkit-transition: all .15s linear;
        -o-transition: all .15s linear;
        transition: all .15s linear
    }

    .file-upload:hover .mask.rgba-stylish-slight {
        opacity: .8
    }

    .file-upload-wrapper .card.card-body.has-error {
        border-color: #f34141
    }

    .file-upload-wrapper .card.card-body.has-error:hover .file-upload-errors-container {
        visibility: visible;
        opacity: 1;
        -webkit-transition-delay: 0s;
        -o-transition-delay: 0s;
        transition-delay: 0s
    }

    .file-upload-wrapper .card.card-body.disabled input {
        cursor: not-allowed
    }

    .file-upload-wrapper .card.card-body.disabled:hover {
        background-image: none;
        -webkit-animation: none;
        animation: none
    }

    .file-upload-wrapper .card.card-body.disabled .file-upload-message {
        opacity: .5;
        text-decoration: line-through
    }

    .file-upload-wrapper .card.card-body.disabled .file-upload-infos-message {
        display: none
    }

    .file-upload-wrapper .card.card-body input {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 5
    }

    .file-upload-wrapper .card.card-body .file-upload-message {
        position: relative;
        top: 50px;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%)
    }

    .file-upload-wrapper .card.card-body .file-upload-message span.file-icon {
        font-size: 50px;
        color: #ccc
    }

    .file-upload-wrapper .card.card-body .file-upload-message p {
        margin: 5px 0 0
    }

    .file-upload-wrapper .card.card-body .file-upload-message p.file-upload-error {
        color: #f34141;
        font-weight: 700;
        display: none
    }

    .file-upload-wrapper .card.card-body .btn.btn-sm.btn-danger {
        display: none;
        position: absolute;
        opacity: 0;
        z-index: 7;
        top: 10px;
        right: 10px;
        -webkit-transition: all .15s linear;
        -o-transition: all .15s linear;
        transition: all .15s linear
    }
    .error{
        font-size: 12px;
        font-weight: normal;
        color: #DC3545;
    }
    .file-upload-wrapper .card.card-body .file-upload-preview {
        display: none;
        position: absolute;
        z-index: 1;
        background-color: #fff;
        padding: 5px;
        width: 100%;
        height: 100%;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
        text-align: center
    }

    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-render .file-upload-preview-img {
        width: 100%;
        height: 100%;
        background-color: #fff;
        -webkit-transition: border-color .15s linear;
        -o-transition: border-color .15s linear;
        transition: border-color .15s linear;
        -o-object-fit: cover;
        object-fit: cover
    }

    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-render i {
        font-size: 80px;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        position: absolute;
        color: #777
    }

    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-render .file-upload-extension {
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        margin-top: 10px;
        text-transform: uppercase;
        font-weight: 900;
        letter-spacing: -.03em;
        font-size: 1rem;
        color: #fff;
        width: 42px;
        white-space: nowrap;
        overflow: hidden;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis
    }

    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-infos {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        background: rgba(0, 0, 0, .7);
        opacity: 0;
        -webkit-transition: opacity .15s linear;
        -o-transition: opacity .15s linear;
        transition: opacity .15s linear
    }

    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-infos .file-upload-infos-inner {
        position: absolute;
        top: 50%;
        -webkit-transform: translate(0, -40%);
        -ms-transform: translate(0, -40%);
        transform: translate(0, -40%);
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        width: 100%;
        padding: 0 20px;
        -webkit-transition: all .2s ease;
        -o-transition: all .2s ease;
        transition: all .2s ease
    }

    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-infos .file-upload-infos-inner p {
        padding: 0;
        margin: 0;
        position: relative;
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
        color: #fff;
        text-align: center;
        line-height: 25px;
        font-weight: 700
    }

    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-infos .file-upload-infos-inner p.file-upload-infos-message {
        margin-top: 15px;
        padding-top: 15px;
        font-size: 12px;
        position: relative;
        opacity: .5
    }

    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-infos .file-upload-infos-inner p.file-upload-infos-message::before {
        content: "";
        position: absolute;
        top: 0;
        left: 50%;
        -webkit-transform: translate(-50%, 0);
        -ms-transform: translate(-50%, 0);
        transform: translate(-50%, 0);
        background: #fff;
        width: 30px;
        height: 2px
    }

    .file-upload-wrapper .card.card-body:hover .btn.btn-sm.btn-danger,
    .file-upload-wrapper .card.card-body:hover .file-upload-preview .file-upload-infos {
        opacity: 1
    }

    .file-upload-wrapper .card.card-body:hover .file-upload-preview .file-upload-infos .file-upload-infos-inner {
        margin-top: -5px
    }

    .file-upload-wrapper .card.card-body.touch-fallback {
        height: auto !important
    }

    .file-upload-wrapper .card.card-body.touch-fallback:hover {
        background-image: none;
        -webkit-animation: none;
        animation: none
    }

    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview {
        position: relative;
        padding: 0
    }

    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-render {
        display: block;
        position: relative
    }

    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-infos .file-upload-infos-inner p.file-upload-infos-message::before,
    .file-upload-wrapper .card.card-body.touch-fallback.has-preview .file-upload-message {
        display: none
    }

    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-render .file-upload-font-file {
        position: relative;
        -webkit-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        transform: translate(0, 0);
        top: 0;
        left: 0
    }

    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-render .file-upload-font-file::before {
        margin-top: 30px;
        margin-bottom: 30px
    }

    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-render img {
        position: relative;
        -webkit-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        transform: translate(0, 0)
    }

    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-infos {
        position: relative;
        opacity: 1;
        background: 0 0
    }

    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-infos .file-upload-infos-inner {
        position: relative;
        top: 0;
        -webkit-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        transform: translate(0, 0);
        padding: 5px 90px 5px 0
    }

    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-infos .file-upload-infos-inner p {
        padding: 0;
        margin: 0;
        position: relative;
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
        color: #777;
        text-align: left;
        line-height: 25px
    }

    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-infos .file-upload-infos-inner p.file-upload-infos-message {
        margin-top: 0;
        padding-top: 0;
        font-size: 18px;
        position: relative;
        opacity: 1
    }

    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-message {
        -webkit-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        transform: translate(0, 0);
        padding: 40px 0
    }

    .file-upload-wrapper .card.card-body.touch-fallback .btn.btn-sm.btn-danger {
        top: auto;
        bottom: 23px;
        opacity: 1
    }

    .file-upload-wrapper .card.card-body.touch-fallback:hover .file-upload-preview .file-upload-infos .file-upload-infos-inner {
        margin-top: 5rem
    }

    .file-upload-wrapper .card.card-body .file-upload-loader {
        position: absolute;
        top: 15px;
        right: 15px;
        display: none;
        z-index: 9
    }

    .file-upload-wrapper .card.card-body .file-upload-loader::after {
        display: block;
        position: relative;
        width: 20px;
        height: 20px;
        -webkit-animation: rotate .6s linear infinite;
        animation: rotate .6s linear infinite;
        -webkit-border-radius: 100%;
        border-radius: 100%;
        border-top: 1px solid #ccc;
        border-bottom: 1px solid #777;
        border-left: 1px solid #ccc;
        border-right: 1px solid #777;
        content: ""
    }

    .file-upload-wrapper .card.card-body .file-upload-errors-container {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        background: rgba(243, 65, 65, .8);
        text-align: left;
        visibility: hidden;
        opacity: 0;
        -webkit-transition: visibility 0s linear .15s, opacity .15s linear;
        -o-transition: visibility 0s linear .15s, opacity .15s linear;
        transition: visibility 0s linear .15s, opacity .15s linear
    }

    .file-upload-wrapper .card.card-body .file-upload-errors-container ul {
        padding: 10px 20px;
        margin: 0;
        position: absolute;
        left: 0;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%)
    }

    .file-upload-wrapper .card.card-body .file-upload-errors-container ul li {
        margin-left: 20px;
        color: #fff;
        font-weight: 700
    }

    .file-upload-wrapper .card.card-body .file-upload-errors-container.visible {
        visibility: visible;
        opacity: 1;
        -webkit-transition-delay: 0s;
        -o-transition-delay: 0s;
        transition-delay: 0s
    }

    .file-upload-wrapper .card.card-body~.file-upload-errors-container ul {
        padding: 0;
        margin: 15px 0
    }

    .file-upload-wrapper .card.card-body~.file-upload-errors-container ul li {
        margin-left: 20px;
        color: #f34141;
        font-weight: 700
    }
    
    .loader{
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 999;
        background: rgba(255,255,255,0.8) center no-repeat;
    }
    .loader img{
        position: absolute;
        top: 40%;
        left: 46%;
        width: 90px;
    }
    .loader a{
        position: absolute;
        top: 40%;
        left: 45%;
        color: #fff !important;
        font-size: 50px;
        font-weight: 400;
    }

</style>
<head>    
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<div class="loader" style="display: none;">
    <img src="{{asset('dist/img/2021-03-22.gif')}}" alt="loader">
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
             <p class="text-center text-success">{{session()->pull('message')}}</p>

            <div class="card card-transparent">
                <div class="card-header">
                    <h3 class="card-title">Upload folder against folder</h3>
                    <div class="download-action">
                        <a href="{{route('flipkart.editors.table')}}" class="btn btn-warning" id="downloadListBtn">
                            Downloads
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="upload-zip-folder-wrapper">
                <form action="" method="POST" id="uploadzip"class="folder-upload-form" >
                            @csrf
                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label class="control-label required">Lot</label>
                                        <select class="custom-select form-control-border select2 lotSelect" id="lotSelect" name="lot_id"  aria-hidden="true" style="width: 100%;" required>
                                            <option value="None" selected>Select Lot Number</option>
                                            @foreach($PendingLots as $lots)
                                            <option value="{{$lots->id}}">{{$lots->lot_id}}</option>
                                            @endforeach
                                        </select>
                                        

                                    </div>
                                    <p class="error"></p>
                                </div>
                                <div class="col-sm-6 col-12">

                                    <div class="form-group">
                                        <label class="control-label required">WRC</label>
                                        <select class="custom-select form-control-border select2 wrcSelect" id="wrc" name="wrc_id"  aria-hidden="true" style="width: 100%;" >
                                        </select>



                                    </div>
                                    <p class="error"></p>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label class="control-label required">File</label>
                                        <select class="custom-select form-control-border select2" id="file" name="flip_id"  aria-hidden="true" style="width: 100%;" >

                                        </select>
                                        


                                    </div>
                                    <p class="error"></p>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label class="control-label required">Uploaded Image Count</label>
                                        <input type="text" class="form-control" 
                                        name="imageCount" id="imageCount" placeholder="please enter the count of images" >
                                    </div>
                                    <p class="error"></p>
                                </div>

                                 <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label class="control-label required">Missing Image Count</label>
                                        <input type="text" class="form-control" 
                                        name="missingimageCount" id="rejectImageCount" placeholder="please enter the count of images missing" >
                                    </div>
                                    <p class="error"></p>
                                </div>

                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label class="control-label required">Rejected Image Count</label>
                                        <input type="text" class="form-control" 
                                        name="rejectimageCount" id="rejectImageCount" placeholder="please enter the count of Rejected Images" >
                                    </div>
                                    <p class="error"></p>
                                </div>
                                

                                <div class="col-sm-12">
                                    <div class="file-upload-wrapper">
                                        <label class="text-center d-block required  mt-3 mb-2" style="font-size: 24px; font-weight: 400;">Upload Folder 
                                        </label>
                                        <input type="file" id="input-file-now" class="file-upload" name="zip"  />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="javaScript:void(0)" class="btn btn-warning" onclick="upload()" id="uploadfolderBTN">Upload Zip Folder</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- File Uploader Plugin -->
<script src="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/js/plugins/mdb-file-upload.min.js"></script>

<script>
    // File Uploadeder
    $('.file-upload').file_upload();
    
</script>
@endsection