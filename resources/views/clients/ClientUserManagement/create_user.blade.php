@extends('layouts.DamNewMain')
@section('title')
Clients - Create New user
@endsection

@section('main_content')
<style>
  .error{
    color: red;
  }
</style>
<div class="row">
  <div class="col-12">
    <a class="btn btn-light border-0 back-btn" href="{{route('Client_Users_list')}}" role="button"><svg width="22" height="14"
        viewBox="0 0 22 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6.69628 1.5L1 7L6.69628 12.5M21 7H1.15953" stroke="#9F9F9F" stroke-width="1.5"
          stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
      &nbsp; back</a>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <p class="create-user-txt ps-2">Add user</p>
    <p class="add-user-para ps-2">You can add a maximum of 10 users.</p>
  </div>
  <form action="" method="post" id="createUser_form">
    <div class="row ps-lg-2 mt-3">
      @csrf

      
      {{-- name --}}

      <div class="col-lg-5 col-md-5 col-sm-12 form_control_gp">
        <input class="form-control form-control-lg rounded-0 mb-3 user-form" type="text" placeholder="Enter name"
          aria-label=".form-control-lg example" name="name" onkeypress ="return isAlphabet(event)">
          <p class="error"></p> 
      </div>
      
      {{-- Brand --}}

      <div class="col-lg-5 col-md-5 col-sm-12 form_control_gp">
        <select id="brand" class="form-select form-select-lg rounded-0 mb-3 user-form" aria-label=".form-select-lg example"  name="brand[]" multiple>
          @foreach ($brands as $row)
            <option value="{{$row['brand_id']}}">{{$row['name']}}</option>
          @endforeach
        </select>
        <p class="error"></p> 
      </div>
      
      {{-- Email --}}

      <div class="col-lg-5 col-md-5 col-sm-12 form_control_gp">
        <input class="form-control form-control-lg rounded-0 mb-3 user-form" type="text" placeholder="Enter email" aria-label=".form-control-lg example" name="email" >
        <p class="error"></p> 
      </div>
      
      {{-- phone --}}
      <div class="col-lg-5 col-md-5 col-sm-12 form_control_gp">
        <input class="form-control form-control-lg rounded-0 mb-3 user-form" type="text"  placeholder="Enter phone no." aria-label=".form-control-lg example"  maxlength="10" onkeypress="return isNumber(event)" name="phone" >
        <p class="error"></p> 
      </div>

      {{-- Address --}}
      <div class="col-lg-10 col-md-10  col-sm-12 form_control_gp">
        <input class="form-control form-control-lg rounded-0 mb-3 user-form" type="text" placeholder="Address" aria-label=".form-control-lg example" name="address">
          <p class="error"></p> 
      </div>

      {{-- user_module --}}
      <div class="col-lg-5 col-md-5 col-sm-12 form_control_gp">
        <select  class="form-select form-select-lg rounded-0 mb-3 user-form" aria-label=".form-select-lg example"  name="user_module[]" id="user_module" multiple>
          <option value="DAM">DAM</option>
          <option value="OMS">OMS</option>
        </select>
        <p class="error"></p> 
      </div>
  
      <div class="col-12">
        <p class="mandatory">* All fields are mandatory</p>
      </div>

      <div class="col-10 mt-4">
        <div class="d-lg-flex d-md-flex justify-content-between">
          <input type="hidden" name="role" value="Sub Client">
          <button type="button" class="btn rounded-0 user-btn" onclick="createUsers()">+ Create user</button>
          <p id="msg_box" class="" style="display: none"></p>

          {{-- <div style="line-height: 0%;">
            <p class="default-pass">Default password</p>
            <p class="odn-sign">Dam@odn2023
              <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="32" height="32" rx="16" fill="#9F9F9F" />
                <rect x="8" y="8" width="16" height="16" fill="#B8B8B8" />
                <line x1="10.1718" y1="9.46481" x2="22.39" y2="21.683" stroke="#D1D1D1" />
                <line x1="9.46468" y1="21.6836" x2="21.6829" y2="9.46537" stroke="#D1D1D1" />
              </svg>
            </p>
          </div> --}}
        </div>
      </div>

    </div>
  </form>
</div>
@endsection

@section('js_scripts')
<script>
  new MultiSelectTag('brand');

  $('#brand').on('change', function() {
    var selectedOptions = $(this).val();
    if (selectedOptions != null && selectedOptions.length > 0) {
      $('option[value=""]').hide();
    } else {
      $('option[value=""]').show();
    }
  });
</script>

<script>
  new MultiSelectTag('user_module');

  $('#user_module').on('change', function() {
    var selectedOptions = $(this).val();
    if (selectedOptions != null && selectedOptions.length > 0) {
      $('option[value=""]').hide();
    } else {
      $('option[value=""]').show();
    }
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
        $('[name="name"]').parents('.form_control_gp').find('.error').text('Name can not be empty!');
        error = 1;
      }

      if(brand.length < 1){
        $('#brand').parents('.form_control_gp').find('.error').text('Brand can not be empty!');
        error = 1
      }

      if(user_module.length < 1){
        $('#user_module').parents('.form_control_gp').find('.error').text('User Module can not be empty!');
        error = 1
      }

      if(phone == ''){
        $('[name="phone"]').parents('.form_control_gp').find('.error').text('Phone Number can not be empty!');
        error = 1
      } else if(phone.length != 10){
        $('[name="phone"]').parents('.form_control_gp').find('.error').text('Please enter valid phone number!');
        error = 1
      }
      if(email == ''){
        $('[name="email"]').parents('.form_control_gp').find('.error').text('Email Id can not be empty!');
        error = 1
      }else if(!validateEmail(email)){
        $('[name="email"]').parents('.form_control_gp').find('.error').text('Not a vailid Email');
        error = 1;
      }
      if(address == ''){
        $('[name="address"]').parents('.form_control_gp').find('.error').text('Address can not be empty!');
        error = 1;
      }
      if(role == ''){
        $('[name="role"]').parents('.form_control_gp').find('.error').text('Please select role can not be empty!');
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
              $('[name="email"]').parents('.form_control_gp').find('.error').text('Please enter unique email ID!');
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
      url: "/save-client-New-users",
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

@endsection


