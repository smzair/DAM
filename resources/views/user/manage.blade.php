@extends('layouts.admin')
@section('title')
Manage Clients
@endsection
@section('content')

<title>Manage Clients</title>
<style type="text/css">
  .del-data-pop {
        color : #fff;
    }

    .del-data-pop .swal2-title {
        color:#fff !important;
    }

    .del-data-pop .swal2-content {
        color:#fff !important;
    }

    .light-dsh-mode .del-data-pop .swal2-title,
    .light-dsh-mode .del-data-pop .swal2-content {
        color:#000 !important;
    }

    .del-data-pop .swal2-icon.swal2-warning {
        border-color: #FBF702;
        color: #FBF702;
    }
</style>

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
                Clients 
              </h3>
            </div>
            <div class="col-lg-5 col-6">
              <div class="card-tools float-right">
                <button class="btn btn-xs btn-warning float-left align-middle mt-0 mr-2 p-1 mb-1 mb-1" style="position:relative;top: 2px;" data-toggle="modal" data-target="#createClient"> 
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
            <thead >
              <tr style="font-size: 14px;">
                <th width="5%" class="pl-3"># </th>
                <th>Name</th>
                <th>Role</th>
                <th>Client id</th>
                <th>Payment Terms</th>
                <th>Email</th>
                <th>AM Mail</th>
                <th>C Name</th>
                <th>Brands</th>
                <th>Address</th>
                <th>Phone No</th>
                <th>GST No</th>
                <th>Action</th>
                <th>Date Posted</th>
              </tr>
            </thead>
            <tbody>
             @foreach($users as $index => $user)
             <tr>
              <td width="5%" class="pl-3">{{$index}}</td>
              <td>{{$user->name}}</td>
              @foreach ($user->roles as $role)
              <td> {{ $role->name }}</td>
              @endforeach
              <td>{{$user->client_id}}</td>
              <td>{{$user->payment_term}}</td>
              <td>{{$user->email}}</td>
              <td>{{$user->am_email}}</td>
              <td>{{$user->Company}}</td>
              <td style="width: 100%; min-width: 250px;">{{$user->brands_name}}</td>
              <td style="width: 100%; min-width: 325px;">{{$user->Address}}</td>
              <td>{{$user->phone}}</td>
              <td>{{$user->Gst_number}}</td>
              <td>
                <a class="btn btn-warning px-1 py-1 btn-xs mt-1" href="javascript:void(0)" onclick="EditUsers(this)" data-id="{{$user->id}}">Edit</a>
              </td>
              <td>{{$user->created_at}} </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  <div class="modal fade" id="createClient" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createUserModalLabel">Create Client
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;
            </span> </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="" class="mng-form" id="createClient_form">
              @csrf
              <div class="row">
                <div class="col-6">
                  <div class="col-12 p-0">
                    <h5 class="card-title float-none text-bold text-uppercase mb-3">
                      Client Details
                    </h5>
                  </div>
                  <div class="col-12 p-0">
                    <div class="form-group">
                      <label class="control-label required">Select Role</label>
                      <select class="select2" name="role" style="width:100%" data-placeholder="Please select role">
                        <option value="">Please select role</option>
                        <option selected>Client</option>
                      </select>
                      <p class="error"></p>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="form-group">
                      <label class="control-label required"> Name </label>
                      <input type="text"  name="name" placeholder="Name" class="form-control" maxlength="100" onkeypress ="return isAlphabet(event)" />
                      <p class="error"></p>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="form-group">
                      <label class="control-label requiredu"> Client Id </label>
                      <input type="text"  name="client_id" placeholder="Client Id" class="form-control" maxlength="14" value="Not Yet Generated" onkeypress ="return isAlphaNumeric(event)" />
                      <p class="error"></p>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="form-group">
                      <label class="control-label required"> Email </label>
                      <input type="email" name="email" placeholder="Email" class="form-control"> 
                      <p class="error"></p>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="form-group">
                      <label class="control-label required"> Phone Number </label>
                      <input type="text" name="phone" placeholder="Phone Number" class="form-control" maxlength="10" onkeypress="return isNumber(event)"> 
                      <p class="error"></p>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="form-group">
                      <label class="control-label required"> Address </label>
                      <textarea name="address" placeholder="Address" class="form-control" maxlength="500"></textarea>
                      <p class="error"></p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="col-12 p-0">
                    <h5 class="card-title float-none text-bold text-uppercase mb-3">
                      Company Details
                    </h5>
                  </div>
                  <div class="col-12 p-0">
                    <div class="form-group">
                      <label class="control-label required"> Select Assigned AM</label>
                      <select class="select2" name="am_email" style="width:100%" data-placeholder="Select Account Manager">
                        <option value="">Select Account Manager</option>
                        @foreach($am as $ams)
                        <option value="{{$ams->email}}">{{$ams->name}}</option>
                        @endforeach
                      </select>
                      <p class="error"></p>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="form-group">
                      <label class="control-label required"> Company Name </label>
                      <input type="text" name="company" placeholder="Company Name" class="form-control" onkeypress="return isAlphaNumeric(event)"> 
                      <p class="error"></p>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="form-group">
                      <label class="control-label required"> Company Short Name </label>
                      <input type="text" name="c_short" placeholder="Any Two Prefix" required class="form-control" maxlength="4" onkeypress="return isAlphaNumeric(event)"> 
                      <p class="error"></p>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="form-group">
                      <label class="control-label required required">Payment Terms</label>
                      <select class="select2" name="payment_term" style="width:100%" data-placeholder="Select Payment Terms">
                        <option value="">Payment Terms</option>
                        <option>100% Advance Before Bulk Submission</option>
                        <option>50 % Advance & Remaining Before Bulk Submission</option>
                        <option>Monthly Payments - No Advance</option>
                        <option>50% Advance Remaining After 15 days of Invoice</option>
                        <option>Post Bulk Images & Invoice Submission</option>
                        <option>Post Receipt of Hard Copy At Client Level</option>
                      </select>
                      <p class="error"></p>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="form-group">
                      <label class="control-label requiredu"> GST Number </label>
                      <input type="text" name="gst_number" value="None" class="form-control" maxlength="15" onkeypress="return isAlphaNumeric(event)">
                      <p class="error"></p>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="form-group brnd-frm-input">
                      <label class="control-label required">Brand</label>
                      <select class="select2"  name="brand[]" multiple style="width:100% " data-placeholder="Select Brand">
                        <option value="">Select Brand</option>
                        @foreach($brand as $brnd)
                        <option value="{{$brnd->id}}">{{$brnd->name}}</option>
                        @endforeach
                      </select>
                      <p class="error"></p>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close </button>
            <a href="javascript:void(0)" class="btn btn-warning" onclick="clientValidation()">Save Client </a>
          </div>
        </div>
      </div>
  </div>
  <div class="modal fade" id="editClient" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content" id="d-edit-client" >

        </div>
      </div>
  </div>

<div class="modal fade del-data-pop" id="del-clientID">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="swal2-header">
                        <div class="swal2-icon swal2-warning swal2-icon-show" style="display: flex;"><div class="swal2-icon-content">!</div></div>
                        <h2 class="swal2-title" id="swal2-title" style="display: flex;">Are you sure?</h2>
                    </div>
                    <div class="swal2-content">
                        <div id="swal2-content" class="swal2-html-container" style="display: block;">You won't be able to revert this!</div>
                    </div>
                    <div class="swal2-actions">
                        <button type="button" class="btn btn-warning mr-2" id="del-id" style="display: inline-block;">Yes, delete it!</button>
                        <button type="button" class="btn btn-danger bg-danger" id="cancel-id" data-dismiss="modal" style="display: inline-block;">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
   
  </div>
</div>
</div>



<div class="fix-infor-wrapper">
  <a href="javascript:;" class="information-pp-btn" id="info-popbtn">
    <i class="fas fa-info ic-infor"></i>
    <i class="fas fa-times cl-infor"></i>
  </a>
  <div class="infor-content">
    <ul class="info-ll-list">
      <li><b>To register a new client or a user, click on <strong>Add New</strong> | To tag a brand, click on the edit option and update</b></li>
    </ul>
  </div>
</div>

<script type="application/javascript" src="plugins/jquery/jquery.min.js">
</script>
<script type="application/javascript" src="plugins/jquery-ui/jquery-ui.min.js">
</script>
<script type="application/javascript" src="plugins/bootstrap/js/bootstrap.bundle.min.js">
</script>
<script type="application/javascript" src="dist/js/adminlte.js">
</script>
<script type="application/javascript" src="dist/js/adminlte.min.js">
</script>
<script type="application/javascript" src="plugins/sweetalert2/sweetalert2.all.min.js">
</script>


<script type="text/javascript">

  function clientValidation(){
    var error = 0;
    $('.error').text('');
    var name= $('[name="name"]').val().trim();
    var email = $('[name="email"]').val().trim();
    var phone = $('[name="phone"]').val().trim();
    var company= $('[name="company"]').val().trim();
    var client_id= $('[name="client_id"]').val().trim();
    var gst_number = $('[name="gst_number"]').val().trim();
    var role = $('[name="role"]').val();
    var am_email = $('[name="am_email"]').val();
    var c_short = $('[name="c_short"]').val().trim();
    var payment_term = $('[name="payment_term"]').val();
    var address = $('[name="address"]').val().trim();
    var brand = $('[name="brand[]"]').val();

    if(name == ''){
      $('[name="name"]').parents('.form-group').find('.error').text('Name can not be empty!');
      error = 1;
    }
    // if(client_id == ''){
    //   $('[name="client_id"]').parents('.form-group').find('.error').text('Client Id can not be empty!');
    //   error = 1;
    // }
    if(phone.length != 10){
      $('[name="phone"]').parents('.form-group').find('.error').text('Please enter valid phone number!');
      error = 1
    }
    if(!validateEmail(email)){
      $('[name="email"]').parents('.form-group').find('.error').text('Please enter valid email ID!');
      error = 1;
    }
    if(address.length < 5 ){
      $('[name="address"]').parents('.form-group').find('.error').text('Please make sure address lenght should be of more than 5 characters');
      error = 1;
    }
    if(am_email == ''){
      $('[name="am_email"]').parents('.form-group').find('.error').text('Please Select Account Manager!');
      error = 1;
    }
    if(company == ''){
      $('[name="company"]').parents('.form-group').find('.error').text('Company name can not be empty!');
      error = 1;
    }
    if(payment_term == ''){
      $('[name="payment_term"]').parents('.form-group').find('.error').text('Please select Payment term');
      error = 1;
    }
    if(brand == ''){
      $('[name="brand[]"]').parents('.form-group').find('.error').text('Please select a brand!');
      error = 1;
    }
    if(c_short.length > 4 || c_short.length == 0){
      $('[name="c_short"]').parents('.form-group').find('.error').text('Please select a Comany short name!');
      error = 1;
    }
    if(role == ''){
      $('[name="role"]').parents('.form-group').find('.error').text('Please select a role!');
      error = 1;
    }
    if(error == 0){
      showLoader();
      $.ajax({
        url: "/client-validation",
        method: 'GET',
        dataType: "json",
        data:  {gst_number:gst_number, client_id:client_id},
        success: function(data) {
          if(data.gst_number){
            $('[name="gst_number"]').parents('.form-group').find('.error').text('Please enter unique Gst number!');
            error = 1;
          }
          if(data.client_id){
            $('[name="client_id"]').parents('.form-group').find('.error').text('Please enter unique Client Id!');
            error = 1;
          }
          hideLoader();
          if(error == 0){
            saveClient();
          }
        }

      });
    }
  }

  function saveClient(){

    showLoader();
    $.ajax({
      url: "/create",
      method: 'POST',   
      dataType: "json",
      data:  $('#createClient_form').serialize(),
      success: function(data) {
        location.reload();
      }
    });
  }

function EClient(){
    showLoader();
    $.ajax({
      url: "/account/Cupdate",
      method: 'PUT',   
      dataType: "json",
      data: $('#editClient_form').serialize(),
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
      url: "/edit-client",
      method: 'GET',
      dataType: "html",
      data: {id : id},
      success: function(htmlData) {
        $('#d-edit-client').html(htmlData);
        select2();
        $('#editClient').modal();
        hideLoader();
      } 
    }); 
  }
</script>
@endsection 