@extends('layouts.client')
@section('title')
Flipkart Panel | Upload Images Zip
@endsection
@section('content')

<div class="loader" style="display: none;">
            <img src="{{asset('dist/img/2021-03-22.gif')}}" alt="loader">
          </div>

        <div class="container">
            <div class="row template-row">
                <div class="col-12">
                    <div class="custom-panel-title-action">
                        <div class="title-action-panel col-action-panel">
                            <h1>
                                <span class="info-text info-span">
                                    Upload Image For Editing
                                </span>
                                <span class="info-icon info-span">
                                    i
                                </span>
                            </h1>
                        </div>
                        <div class="button-action-panel col-action-panel">
                            <a href="{{route('flipkart.download')}}" class="btn download-btn" id="downloadBTN">
                                Downloads
                            </a>
                        </div>
                    </div>
                </div>
                               <p class="text-center text-warning">{{session()->pull('message')}}</p>

                <div class="col-12">
                    <div class="custom-upload-img-folder">
                        <form action="" method="POST" class="folder-form" id="upload">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="imagecount">Images Count</label>
                                        <input type="text" class="upload-form-input" name="imageCount" id="imageCount" placeholder="Please enter the count of images">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="service">Service Type</label>
                                        <select class="upload-form-input select2"  id="user_id"  name="service_type" required data-placeholder="Select Service Type" >
                                             <option value = "" selected>Please select</option>
                                    <option value = "Background Color Change">Background Color Change</option>
                                            <option value = "Croping">Croping</option>
                                            <option value = "Editing">Editing</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="remarks">Remarks</label>
                                        <textarea class="upload-form-input" name="remarks" id="remarks" cols="10" rows="5" placeholder="Please enter the count of images"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group file-upload-form-group">
                                        <div class="file-upload-wrapper">
                                            <input type="file" class="file-upload" name="zip" id="imageFolder" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit"  class="btn upload-submit-btn" id="uploadBTN">
                                        Upload Zip Folder
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="{{asset('plugins/bootstrap-5.1.3-dist/js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('plugins/bootstrap-5.1.3-dist/js/bootstrap.min.js')}}"></script>

<script type="text/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

<script src="{{asset('plugins/jqueryTime/goodMorning.js')}}"></script>

<!-- Common JS -->

<script src="{{ asset('js/common_client.js')}}"></script>

    <script src="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/js/plugins/mdb-file-upload.min.js"></script>

    <!-- Common JS -->

   

    <script type="text/javascript">
        $('.file-upload').file_upload();

$("#upload").submit(function(e) {

        e.preventDefault();    
var formData = new FormData(this);

        alert('Please Do not refresh the page, click ok Upload has been started please wait for a while');
    $('#ajax-loader').show();
      $.ajax({     

        
            url: "/upload-Zip",
            type: 'POST',
            data: formData,
            dataType : 'html',
            beforeSend: function(){
    /* Show image container */
    $(".loader").show();
   },
   success: function(response){
    $(".loader").hide();
   },
   complete:function(data){
    /* Hide image container */
    
   window.location.reload();
  },
     
            cache: false,
            contentType: false,
            processData: false
        });


    });



    </script>
@endsection