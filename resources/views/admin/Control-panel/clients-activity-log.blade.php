@extends('layouts.admin')

@section('title')
Clients Acitivity Logs
@endsection
@section('content')
<style>
    .form-group .error{
        font-size: 16px;
        margin: 0px;
        padding: 5px 5px;
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
                                        Clients List
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
                                {{-- <div class="card-tools float-md-right float-sm-none ml-md-0 mr-0 ml-sm-0 mt-sm-1 float-none ml-xs-0 mt-1">
                                    <a class="btn btn-xs float-left align-middle mt-0 mr-2 py-1 px-2 mb-1" href="{{route('CREATECATLOGWRC')}}" style="position: relative; top: 2px;">Add New WRC</a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0"  style="max-height: 750px; height: 100%;">
                        <table id="wrcTableCat" class="table table-head-fixed table-hover text-nowrap data-table">
                            <thead>
                            <tr class="wrc-tt">
                                    <th class="p-2">S. No</th>
                                    <th class="p-2">Log Name</th>
                                    <th class="p-2">Event</th>
                                    <th class="p-2">Description</th>
                                    <th class="p-2">User Name</th>
                                    <th class="p-2">Brand Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // pre($wrcs);
                                @endphp
                                @foreach ($sub_users_list as $key => $row)
                                    <tr class="tr{{$key}}">
                                        <td>{{$key+1}}</td>
                                        <td id="name{{$key}}">{{$row['log_name']}}</td>
                                        <td id="event{{$key}}">{{$row['event']}}</td>
                                        <td id="description{{$key}}">{{$row['description']}}</td>
                                        <td id="user_name{{$key}}">{{$row['user_name']}}</td>
                                        <td id="brand_name{{$key}}">{{$row['brand_name']}}</td>
                                       
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
<!-- End of Table -->

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
                <div class="custom-dt-row wrc-details mb-3">
                    <div class="row mb-3">
                        {{-- <div class="col-sm-4 col-6">
                            <div class="col-ac-details">
                                <h6>Name</h6>
                                <p id="name"></p>
                            </div>
                        </div> --}}
                        <div class="col-sm-4 col-6">
                            <div class="col-ac-details">
                                <h6>Company Name</h6>
                                <p id="Company"></p>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="col-ac-details">
                                <h6>Client Id</h6>
                                <p id="client_id"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="custom-dt-row allocater-selection"> 
                    {{-- Allocate users dropdwon row  --}}
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                               <label class="control-label w-100 required" for="name">name<span style="color: red">*</span></label>
                               <input class="form-control" type="text" name="name" id="name" onkeypress="return isAlphabet(event)" onkeyup="return isAlphabet(event)">
                               <p class="error" style="display: none;"  id="name_err"></p>
                           </div>
                       </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                               <label class="control-label w-100 required" for="email">Email<span style="color: red">*</span></label>
                               <input class="form-control" type="text" name="email" id="email">
                               <p class="error" style="display: none;"  id="email_err"></p>
                           </div>
                       </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                               <label class="control-label w-100 required" for="phone">Phone<span style="color: red">*</span></label>
                               <input class="form-control" type="text" name="phone" id="phone" onkeypress="return isNumber(event)" onkeypress="return isNumber(event)">
                               <p class="error" style="display: none;"  id="phone_err"></p>
                           </div>
                       </div>
                       
                        <div class="col-sm-12 col-12" style="text-align: end">
                            <input id="id" name="id" type="hidden" value="">
                            <input id="key" name="key" type="hidden" value="">
                            <button id="btnUpdate" class="btn btn-warning" onclick="saveData()" >Update</button>
                            <span class="msg_box" id="msg_box1" style="color: red; display: none;"></span>
                            <span class="msg_box" id="msg_box2" style="color: red; display: none;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

{{-- setvalue to model --}}
<script>
    async function setvalue(key){
        $(".error").css("display", "none");
        const name = document.querySelector("#name"+key).innerHTML
        const p_name = document.querySelector("#p_name"+key).innerHTML
        const Company = document.querySelector("#Company"+key).innerHTML
        const client_id = document.querySelector("#client_id"+key).innerHTML
        const email = document.querySelector("#email"+key).innerHTML
        const phone = document.querySelector("#phone"+key).innerHTML
        const user_id = document.querySelector("#user_id"+key).value

        document.querySelector('#name').value = name
        document.querySelector('#Company').innerHTML = Company
        document.querySelector('#client_id').innerHTML = client_id
        document.querySelector('#email').value = email
        document.querySelector('#phone').value = phone
        document.querySelector('#id').value = user_id
        document.querySelector('#key').value = key
    }
</script>

{{-- save Data to allocation   --}}
<script>
    const saveData = async () => {
        $(".error").css("display", "none");
        document.querySelector("#btnUpdate").innerHTML = "Updating..."
        
        const id =  document.querySelector("#id").value 
        const key_is =  document.querySelector("#key").value 
        const phone =  document.querySelector("#phone").value 
        const email =  document.querySelector("#email").value 
        const name =  document.querySelector("#name").value 
        let error = 0;
        if(name == ''){
          $('[name="name"]').parents('.form-group').find('.error').text('Name can not be empty!');
          error = 1
        } 
        
        if(phone == ''){
          $('[name="phone"]').parents('.form-group').find('.error').text('Phone Number can not be empty!');
          error = 1
        } else if(phone.length != 10){
          $('[name="phone"]').parents('.form-group').find('.error').text('Please enter valid phone number!');
          error = 1
        }

        if(email == ''){
            $('[name="email"]').parents('.form-group').find('.error').text('Email Id can not be empty!');
          error = 1
        }else if(!validateEmail(email)){
          $('[name="email"]').parents('.form-group').find('.error').text('Not a vailid Email');
          error = 1;
        }

        if(error == 1){
            document.querySelector("#btnUpdate").innerHTML = "Update"
            $(".error").css("display", "block");
            return 
        }
        await $.ajax({
            url: "{{ route('updateClientsUser')}}",
            type: "POST",
            dataType: 'json',
            data: {
                id,
                phone,
                email,
                name,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                document.querySelector("#btnUpdate").innerHTML = "Update"

                if(res.satus == 1){
                    document.querySelector("#phone"+key_is).innerHTML = phone
                    document.querySelector("#email"+key_is).innerHTML = email
                    document.querySelector("#name"+key_is).innerHTML = name
                    $("#msg_box2").css("color", "green");
                }else{
                    $("#msg_box2").css("color", "red");
                    alert(res.massage)
                }
                document.querySelector("#msg_box2").innerHTML  = res.massage
                $("#msg_box2").css("display", "block");
            }
        });
        setTimeout( () => {
            $(".error").css("display", "none");
            $('#msg_box2').html("");
            $("#msg_box2").css("display", "none");
        }, 3000);
    }
</script>
@endsection