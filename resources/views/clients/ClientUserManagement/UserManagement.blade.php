@extends('layouts.ClientMain')
@section('title')
  User Mangement
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}"> 

	<link rel="stylesheet" href="">	
    <style>
        .form-group .input_err{
            margin: 0.1em 0;
            color: red;
            background: #999;
            display: block;
            padding: 0.3em;
        }
    
        .list-group{
            width: 400px !important;
    
        }
    
        .list-group-item{
            margin-top:10px;
            margin-bottom:10px;
            border-radius: none; 
            background: #20b9932e;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
    
    
        .list-group-item:hover{
            /* transform: scaleX(1.1); */
        }
        .list-group-item:hover .check {
            opacity: 1;
    
        }
        .about span{
            font-size: 12px;
            margin-right: 10px;
    
        }

        .error{
          color: red;
        }
        </style>
@endsection

@section('main_content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper dashboard-content-wrapper">

	<!-- Navbar -->
    @include('clients.top_bar.top-head')
    <!-- /.navbar -->

	<!-- Main content -->


    <div class="content custom-dashboard-content">
		  <div class="container-fluid">
        <div class="card card card-transparent card-info mt-3"  style="max-height: 700px; height: 100%;">
          <div class="card-header">
              <div class="row">
                <div class="col-lg-10 col-10">
                  <h6 class="card-title text-bold"><i class="fas fa-users mr-1"></i> Create User</h6>
                </div>
                <div class="col-lg-2 col-2">
                  <div class="card-tools float-right" style="float: right;">
                    <a class="btn btn-xs btn-warning align-middle mt-0 mr-2 p-1 mb-1 mb-1" href="{{ route('ClientUserManagement')}}">Users List</a>
                  </div>
                </div>
              </div>
          </div>
          <div class="card-body">
            <div class="container" style="">
              <form action="" method="POST" id="createUser_form">
                @csrf
                <div class="row">
                  {{-- Select Module --}}
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label required" for="user_module">Select Module</label>
                        <select class="select2" name="user_module[]" id="user_module" multiple>
                          <option value="DAM">DAM</option>
                          <option value="OMS">OMS</option>
                        </select>
                      <p class="error"></p> 
                    </div>
                  </div>
                  {{-- Select Brand --}}
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label required" for="brand">Select Brand</label>
                        <select class="custom-select select2 " name="brand[]" id="brand" multiple >
                          @foreach ($brands as $row)
                            <option value="{{$row['brand_id']}}">{{$row['name']}}</option>
                          @endforeach
                        </select>
                      <p class="error"></p> 
                    </div>
                  </div>
                  {{-- Name --}}
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label required"> Name </label>
                      <input type="text" name="name" placeholder="Name" class="form-control" onkeypress ="return isAlphabet(event)">   
                      <p class="error"></p> 
                    </div>
                  </div>

                  {{-- Email --}}
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label required requiredu"> Email </label>
                      <input type="text" name="email" placeholder="email" class="form-control" >   
                      <p class="error"></p> 
                    </div>
                  </div>

                  {{-- Address --}}
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label required"> Address </label>
                      <input type="text" name="address" placeholder="Address" class="form-control" maxlength="500">   
                      <p class="error"></p> 
                    </div>
                  </div>
                  
                  {{-- Phone Number --}}
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label required"> Phone Number </label>
                      <input type="text" name="phone" placeholder="Phone Number" class="form-control" maxlength="10" onkeypress="return isNumber(event)">   
                      <p class="error"></p> 
                    </div>
                  </div>
                  {{-- <p style="color: #111"><span >Default Password :</span> Odn@2023</p> --}}
                  <div class="col-md-12">
                    <input type="hidden" name="role" value="Sub Client">
                    <button class="btn btn-warning" onclick="createUsers()" >Save User</button>
                    <p id="msg_box" class="" style="display: none"></p>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
@endsection

{{-- Other Js pluging   --}}
@section('js_links')
  <script type="text/javascript" src=""></script>
  <script src="{{asset('js/select2.full.min.js')}}"></script>

@endsection

@section('js_scripts')

  <script>
    $(document).ready(function() {
        $('.select2').select2();
    });
  </script>

	<script>
    async function createUsers(){
      event.preventDefault();
        var error = 0;
        $('.error').text('');
        var name= $('[name="name"]').val().trim();
        var email = $('[name="email"]').val().trim();
        var phone = $('[name="phone"]').val().trim();
        var role = $('[name="role"]').val();
        var brand = $('#brand').val();
        var user_module = $('#user_module').val();
        var address = $('[name="address"]').val();

        if(name == ''){
          $('[name="name"]').parents('.form-group').find('.error').text('Name can not be empty!');
          error = 1;
        }

        if(brand.length < 1){
          $('#brand').parents('.form-group').find('.error').text('Brand can not be empty!');
          error = 1
        }

        if(user_module.length < 1){
          $('#user_module').parents('.form-group').find('.error').text('User Module can not be empty!');
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
        if(address == ''){
          $('[name="address"]').parents('.form-group').find('.error').text('Address can not be empty!');
          error = 1;
        }
        if(role == ''){
          $('[name="role"]').parents('.form-group').find('.error').text('Please select role can not be empty!');
          error = 1;
        }
        if(error == 0){
          await $.ajax({
            url: "/client-user-validation",
            method: 'GET',
            dataType: "json",
            data:  {email:email},
            success: function(data) {
              console.log('data', data)
              if(data.email){
                $('[name="email"]').parents('.form-group').find('.error').text('Please enter unique email ID!');
                error = 1;
              }
              if(error == 0){
                saveUser();
              }
            }

          });
        }
      }
	</script>

  <script>
    async function saveUser(){
      console.log('test777', $('#createUser_form').serialize())
      await $.ajax({
        url: "/save-client-users",
        method: 'POST',   
        dataType: "json",
        data:  $('#createUser_form').serialize(),
        success: function(data) {
          console.log(data)
          if(data == 'ok'){
            alert('User created');
            location.reload();
          }else{
            $("#msg_box").css("color", "red");
            $("#msg_box").css("display", "block");
            document.querySelector("#msg_box").innerHTML  = "Somthing went Wrong please try again!!!";
          }
        }
      });
    }
  </script>

    
<script>
    function navigateToLink(link) {
      window.open(link, '_blank');
    }
</script>
@endsection