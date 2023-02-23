@extends('layouts.admin')
@section('title')
Add & Edit Users
@endsection
@section('content')

  <title>User Manage</title>
 
  <div class="container-fluid mt-5">
    <div class="row">
      <div class="col-12 px-3">
        <div class="card card-transparent m-0">
          <div class="card-header">
            <div class="row">
              <div class="col-lg-7 col-6">
                <h3 class="card-title text-bold">
                  <i class="fas fa-users mr-1">
                  </i>
                  Users 
                </h3>
              </div>
              <div class="col-lg-5 col-6">
                <div class="card-tools float-right">
                  <button class="btn btn-xs btn-warning float-left align-middle mt-0 mr-2 p-1 mb-1 mb-1" style="position:relative;top: 2px;" data-toggle="modal" data-target="#createUser"> 
                    <i class="fas fa-plus-circle">
                    </i> 
                    Add New 
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                        <table class="table data-table table-head-fixed table-hover text-nowrap text-center">
              <thead>
                <tr style="font-size: 14px;">
                  <th width="5%" class="pl-3"># </th>
                  <th>Name </th>
                  <th>Role </th>
                  <th>Employee id </th>
                  <th>Email </th>
                  <th>Address </th>
                  <th>Phone No </th>
                  <th>Action </th>
                  <th>Onboard Date </th>
                </tr>
              </thead>
              <tbody>
              	@foreach($users as $index => $user)
                <tr>
                  <td width="5%" class="pl-3">{{$index}} </td>
                  <td>{{$user->name}} </td>
                  <td> @foreach ($user->roles as $role) {{ $role->name }} @endforeach</td>
                  
                  <td>{{$user->client_id}} </td>
                  <td>{{$user->email}} </td>
                  <td>{{$user->Address}} </td>
                  <td>{{$user->phone}} </td>
                  <td>
                    <a class="btn btn-warning px-1 py-1 btn-xs mt-1" href="javascript:void(0)" onclick="EditUsers(this)" data-id="{{$user->id}}">Edit</a>
                  </td>
                  <td> {{$user->created_at}} </td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
          </div>
          <br>
         
        </div>
        <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
          <div class="modal-dialog " role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Create User
                  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;
                    </span> </button>
              </div>
              <div class="modal-body">
                <form action="" method="POST" class="mng-form" id='createUser_form'>
                	@csrf
                  <div class="form-group">
                    <label class="control-label required" >Select Role</label>
                    <select class="custom-select" name="role" id="role-selc">
                      @foreach($roles as $role)
                        <option>{{$role->name}}</option>
                        @endforeach
                    </select>
                      <p class="error"></p>
                  </div>
                  <div class="form-group">
                    <label class="control-label required"> Name </label>
                    <input type="text" name="name" placeholder="Name" class="form-control" onkeypress ="return isAlphabet(event)">   
                    <p class="error"></p> </div>
                  <div class="form-group">
                    <label class="control-label required requiredu"> Email </label>
                    <input type="email" name="email" placeholder="Email" class="form-control">  
                    <p class="error"></p> 
                  </div>
                  <div class="form-group">
                    <label class="control-label required requiredu" > Employee ID </label>
                    <input type="text" name="client_id" onkeypress="return isAlphaNumeric(event)" placeholder="Employee Id" class="form-control">   
                    <p class="error"></p> 
                  </div>
                  <div class="form-group">
                    <label class="control-label required"> Address </label>
                    <input type="text" name="address" placeholder="Address" class="form-control" maxlength="500">   
                    <p class="error"></p> 
                  </div>
                  <div class="form-group">
                    <label class="control-label required"> Phone Number </label>
                    <input type="text" name="phone" placeholder="Phone Number" class="form-control" maxlength="10" onkeypress="return isNumber(event)">   
                    <p class="error"></p> 
                  </div>
                </form>
                 <p>Default Password : Odn@2021</p>
              </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close </button>
                 <a href="javaScript:void(0)" class="btn btn-warning" onclick="createUsers()">Save User</a>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
          <div id= "d-edit-user" class="modal-dialog" role="document">
        </div>
          </div>
        </div>
      </div>

    </div>

  </div>
<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}">
</script>
<script type="application/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}">
</script>


  <script type="text/javascript">
    $('#del-mng').click(function(){
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
        }
      });
    });

function createUsers(){
  
    var error = 0;
    $('.error').text('');
    var name= $('[name="name"]').val().trim();
    var email = $('[name="email"]').val().trim();
    var phone = $('[name="phone"]').val().trim();
    var client_id= $('[name="client_id"]').val().trim();
    var role = $('[name="role"]').val();
    var address = $('[name="address"]').val();

    if(name == ''){
      $('[name="name"]').parents('.form-group').find('.error').text('Name can not be empty!');
      error = 1;
    }
    if(client_id == ''){
      $('[name="client_id"]').parents('.form-group').find('.error').text('Client Id can not be empty!');
      error = 1;
    }
    if(phone.length != 10){
      $('[name="phone"]').parents('.form-group').find('.error').text('Please enter valid phone number!');
      error = 1
    }
    if(!validateEmail(email)){
      $('[name="email"]').parents('.form-group').find('.error').text('Email Id can not be empty!');
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
      showLoader();
      $.ajax({
        url: "/user-validation",
        method: 'GET',
        dataType: "json",
        data:  {email:email,client_id:client_id},
        success: function(data) {
          if(data.email){
            $('[name="email"]').parents('.form-group').find('.error').text('Please enter unique email ID!');
            error = 1;
          }
           if(data.client_id){
            $('[name="client_id"]').parents('.form-group').find('.error').text('Please enter unique Client Id!');
            error = 1;
          }
          hideLoader();
          if(error == 0){
            saveUser();
          }
        }

      });
    }
  }

  function saveUser(){

    showLoader();
    $.ajax({
      url: "/save-user",
      method: 'POST',   
      dataType: "json",
      data:  $('#createUser_form').serialize(),
      success: function(data) {
              location.reload();

      }

    });
  }

function EUser(){

    showLoader();
    $.ajax({
      url: "/account/update",
      method: 'PUT',   
      dataType: "json",
      data: $('#Edit_User').serialize(),
      success: function(data) {
              location.reload();
              hideLoader();
      }

    });
  }

function EditUsers(obj){

  var id =  $(obj).data('id');

showLoader();
    $.ajax({
        url: "/edit-user",
        method: 'GET',
        dataType: "html",
        data: {id : id},
        success: function(htmlData) {
            $('#d-edit-user').html(htmlData);
            select2();
            $('#editUser').modal();
            hideLoader();
        } 

    }); 
  }



  </script>

@endsection 