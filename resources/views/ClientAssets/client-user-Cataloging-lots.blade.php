@extends('layouts.admin')
@section('title')
Cataloging Lots
@endsection
@section('content')
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

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
    .dropdown-toggle.open-sk:after {
    transform: rotate(-180deg);
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
                Lots 
              </h3>
            </div>
            <div class="col-lg-5 col-6">
              <div class="card-tools float-right">
                
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
                <th>Lot Number</th>
                <th>Service Type</th>
                <th>Request Type</th>
                {{-- <th>Client id</th>
                <th>Payment Terms</th>
                <th>Email</th>
                <th>AM Mail</th>
                <th>C Name</th>
                <th>Brands</th>
                <th>Address</th>
                <th>Phone No</th>
                <th>GST No</th>
                <th>Action</th>
                <th>Date Posted</th> --}}
              </tr>
            </thead>
            <tbody>
             @foreach($lots as $index => $row)
              @php
              if($index == 0){
                // pre($row); 
              }
              @endphp
             <tr>
              <td width="5%" class="pl-3">{{$index + 1}}</td>
              <td>{{$row->lot_number}}</td>
              <td>{{$row->serviceType}}</td>
              <td>{{$row->requestType}}</td>
              
            </tr>
            @endforeach
          </tbody>
        </table>
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

<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<script>
  $('.sku-box > .sku-count').click(function(){
    $(this).next('ol').fadeToggle(0);
    $(this).toggleClass('open-sk');
  });



  $('.toggle-class-dam').change(async function() {
      let dam_enable = $(this).prop('checked') == true ? 1 : 0; 
      let id = $(this).data('id'); 
      console.log({dam_enable , id})
      await $.ajax({
        type: "POST",
        dataType: "json",
        url: "{{ url('manage-client-dam')}}",
        data: {
          'dam_enable': dam_enable,
          'id': id,
          _token: '{{ csrf_token() }}'

        },
        success: function(data){
          if(!data){
            if (dam_enable) {
              $(this).prop('checked', false);
            } else {
              $(this).prop('checked', true);
            }
          }
        }
    });
  });

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