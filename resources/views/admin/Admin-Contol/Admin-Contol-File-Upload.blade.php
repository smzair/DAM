@extends('layouts.admin')

@section('title')
Admin Control - File Upload
@endsection
@section('content')
<link rel="stylesheet" href="{{asset('plugins/datepicker-in-bootstrap-modal/css/datepicker.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<!-- New WRC Creation (For Catalogue) -->
<div class="container">
    <style>
        @media (min-width: 992px){
            .modal-lg, .modal-xl{
                max-width: 900px;
            }
        }
         .msg_box{
            margin: 0.1em 0;
            background: #928c8cfc;
            padding: 0.3em;
        }
    </style>

    {{-- form row  --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-transparent card-info mt-3">
                <div class="card-header bg-warning">
                    <h3 class="card-title">Admin Control</h3>
                </div>
                <div class="card-body"> 
                    @if (Session::has('success'))
                        <div class="alert alert-success" id="msg_div" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    {{-- <form method="POST" onsubmit="return validateForm(event)" action="{{route('SaveAdminControlFile')}}"  id = "wrcform" enctype="multipart/form-data" class="upload-form" > --}}
                    <form method="POST"  action="{{route('SaveAdminControlFile')}}"  id = "wrcform" enctype="multipart/form-data" class="upload-form" >
                        @csrf
                        <div class="row">
                             <!-- Company Name -->
                             <div class="col-sm-4 col-12">
                                <div class="form-group">
                                    <input type="hidden" name="id" value=""> 

                                    <label class="control-label required">Service</label>
                                    <select class="custom-select select2 form-control-border" id="service" name="service"  aria-hidden="true" style="width: 100%;">
                                        <option value="0" selected>Select Service</option>
                                        <option value="1" >Shoot</option>
                                        <option value="2" >Creative</option>
                                        <option value="3" >Cataloging</option>
                                        <option value="4" >Editing</option>
                                    </select>
                                    <script>
                                        // document.querySelector("#service").value = ""
                                    </script>
                                    <p class="input_err" style="color: red; display: none;" id="service_err"></p>
                                </div>
                            </div>
                            
                            <!-- LOT Number -->
                            <div class="col-sm-4 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Lot Number</label>
                                    <select class="custom-select select2 form-control-border " name="lot_id" id="lot_id" onchange="setStype()">
                                        <option value = "0">-- Select Lot Number --</option>
                                    </select>
                                    <p class="input_err" style="color: red; display: none;" id="lot_id_err"></p>
                                </div>
                            </div>

                            <!-- Brand Name -->
                            <div class="col-sm-4 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Wrc Number</label>
                                    <select class="custom-select select2 form-control-border" name="wrc"  id="wrc" onchange="set_btn_action()">
                                        <option value = "0">-- Select Wrc Number --</option>
                                    </select>
                                    <p class="input_err" style="color: red; display: none;" id="wrc_err"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="btn_row" style="display: none">
                            <!-- Upload Sheet   -->
                            <div class="col-sm-4 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Select file for upload</label>
                                    <input  class="form-control-border  btn btn-success btn-xl btn-warning mb-2" id="files" type="file" name="file_upload" >
                                    <label for="uploading" id="uploading"></label>
                                    <div class="progress" style="display: none" ></div>
                                    <p class="input_err" style="color: red; display: none;" id="file_error"></p>
                                </div>
                            </div>
                        
                            <div class="col-sm-12 float-right">
                                <div>
                                    <button type="submit" class="btn btn-success btn-xl btn-warning mb-2" onclick="">upload</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
{{-- <script src="https://malsup.github.io/jquery.form.js"></script>  --}}


{{-- get Lot number List --}}

<script>
    $(document).ready(function() {
        $("#service").change(async function() {
            const service_id = $("#service").val();
            let options = `<option value="0" > -- Select Lot Number -- </option>`;
            if(service_id > 0){
                await $.ajax({
                   url: "{{ url('get-service-lot-number') }}",
                   type: "POST",
                   dataType: 'json',
                   data: {
                       service_id,
                       _token: '{{ csrf_token() }}'
                   },
                   success: function(res) {
                       console.log(res)
                       res.map(lots => {
                           console.log(lots)
                           options +=
                               ` <option value="${lots.id}"> ${lots.lot_number}</option>`;
                       })
                   }
                });
            }
            document.getElementById("lot_id").innerHTML = options;
            select2();
            setTimeout(() => {
                $("#lot_id").trigger("change");
                set_btn_action();
            }, 500);
        });
    });
</script>

{{-- Get Wrc Number List --}}
<script>
    $(document).ready(function() {
        $("#lot_id").change(async function() {
            const service_id = $("#service").val();
            const lot_id_is = $("#lot_id").val();
            let options = `<option value="0" >-- Select Wrc Number --</option>`;
            if(service_id > 0 && lot_id_is > 0){
                await $.ajax({
                   url: "{{ url('get-service-wrc-number') }}",
                   type: "POST",
                   dataType: 'json',
                   data: {
                       service_id,
                       lot_id_is,
                       _token: '{{ csrf_token() }}'
                   },
                   success: function(res) {
                       console.log(res)
                       res.map(wrc => {
                           console.log(wrc)
                           options +=  `<option value="${wrc.id}"> ${wrc.wrc_number}</option>`;
                       })
                   }
                });
            }
            document.getElementById("wrc").innerHTML = options;
            select2();
            setTimeout(() => {
                set_btn_action();
            }, 500);
        });
    });
</script>

<script>
    function set_btn_action(){
        const service_id = +$("#service").val();
        const lot_id_is = +$("#lot_id").val();
        const wrc_id = +$("#wrc").val();
        console.log({service_id, lot_id_is ,wrc_id})
        if(service_id == 0 || lot_id_is == 0 || wrc_id == 0){
            document.getElementById("btn_row").style.display = "none";

        }else{
            document.getElementById("btn_row").style.display = "block";
        }
        
    }
</script>

{{-- Sku file script --}}
<script>
    // $(".file_name_field").css("display", "none");
    $("#files").change(function() {
        filename = this.files[0].name;
        // $("#file_name_field").html(filename);
        // document.getElementById("btn_row").style.display = "flex";
    });
</script>

<script>
    function validateForm(){
        const file = document.getElementById('files').files

        if(file.length == 0){
            $("#file_error").html('File not selected');
            document.getElementById("file_error").style.display = "block";
            return false;
        }else{
           
        }
    }
</script>


<script>
    // Declare global variables for easy access 
    const uploadForm = document.querySelector('.upload-form');
    const filesInput = uploadForm.querySelector('#files');

    // Attach onchange event handler to the files input element
    filesInput.onchange = () => {
        uploadForm.querySelector('#uploading').innerHTML = '';
        // for (let i = 0; i < filesInput.files.length; i++) {
        // }
        if(filesInput.files.length > 0){
            uploadForm.querySelector('#uploading').innerHTML += '<span><i class="fa-solid fa-file"></i>' + filesInput.files[0].name + '</span>';
            document.querySelector(".progress").style.display = "block";
            console.log(filesInput.files)
        }
    };

    // Attach submit event handler to form
    uploadForm.onsubmit = event => {
        event.preventDefault();
        // Make sure files are selected
        if (!filesInput.files.length) {
            uploadForm.querySelector('#file_error').innerHTML = 'Please select a file!';
        } else {
            // Create the form object
            let uploadFormDate = new FormData(uploadForm);
            // Initiate the AJAX request
            let request = new XMLHttpRequest();
           
            // Ensure the request method is POST
            request.open('POST', uploadForm.action);

            request.upload.addEventListener('progress', event => {
                console.log("loaded ", event.loaded)
                console.log("total ", event.total)
                console.log("total in mb ", (event.total/(1024*1024)).toFixed(2) + 'MB')
                let loaded_size_in_mb = event.loaded/(1024*1024) * 1;
                let tot_size_in_mb = event.total/(1024*1024) * 1;
                
                // uploadForm.querySelector('button').innerHTML = 'Uploading... ' + '(' + ((event.loaded/event.total)*100).toFixed(2) + '%)';
                uploadForm.querySelector('button').innerHTML = 'Uploading... ' + '(' + loaded_size_in_mb.toFixed(2) + 'MB/'+tot_size_in_mb.toFixed(2) + 'MB)';
                // Update the progress bar
                uploadForm.querySelector('.progress').style.background = 'linear-gradient(to right, #2be564, #066a24 ' + Math.round((event.loaded/event.total)*100) + '%, #e6e8ec ' + Math.round((event.loaded/event.total)*100) + '%)';
                
                uploadForm.querySelector('button').disabled = true;
            });
            // The following code will execute when the request is complete
            request.onreadystatechange = () => {
                if (request.readyState == 4 && request.status == 200) {
                    const response = JSON.parse(request.response)
                    console.log(response)
                    uploadForm.querySelector('#uploading').innerHTML = response.massage;
                }
                uploadForm.querySelector('button').innerHTML = 'upload'
                uploadForm.querySelector('button').disabled = false;
            };
            // Execute request
            request.send(uploadFormDate);
            
        }
    };
</script>

@endsection