@extends('layouts.DamNewMain')
@section('title')
Clients - Your Profile
@endsection

@section('main_content')
<div class="row" style="margin-top:24px ;">
  <div id="msg_div">
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('warning'))
        <div class="alert alert-warning" role="alert">
            {{ Session::get('warning') }}
        </div>
    @endif

    @if (Session::has('false'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('false') }}
        </div>
    @endif
</div>
  <div class="col-12">
    <h4 class="headingF">Your profile</h4>

  </div>
  <div class="col-12">
    <p class="underheadingF">
      You can manage your profile details from here.
    </p>
  </div>
  <hr style="margin-left: 15px;">
  <form method="POST" action="{{route('UploadeClientAvtar')}}" class="custom-profiles-form personal-details-form" id="UploadeClientAvtar" enctype="multipart/form-data">
    @csrf
    <div class="col-12 mt-5 d-flex ">
      @php
          $profile_avtar = $data['profile_avtar'];
          $profile_avtar_path =  asset('uploades/profileavtar/'.$profile_avtar);
          if(!file_exists($profile_avtar_path) && $profile_avtar != ''){
              $profile_avtar_src = $profile_avtar_path;
          }else{
              $profile_avtar_src = "assets-images\Desktop-Assets\your profile\blank-avtar.jpg";
          }

      @endphp
      <img width="160" height="160" viewBox="0 0 160 160" style="padding: 10px;border: 1px solid #9999;" src="{{$profile_avtar_src}}" class="profile-pic" alt="No Picture">

      {{-- <svg width="160" height="160" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="20" y="20" width="120" height="120" fill="#EBEBEB" />
        <path
          d="M80.4709 76.6763C80.1768 76.6469 79.8238 76.6469 79.5003 76.6763C76.1244 76.5617 72.9257 75.1376 70.5816 72.7056C68.2374 70.2736 66.9319 67.0247 66.9415 63.6469C66.9415 56.441 72.765 50.5881 80.0003 50.5881C81.7133 50.5572 83.4156 50.864 85.01 51.4909C86.6044 52.1179 88.0597 53.0528 89.2928 54.2422C90.5259 55.4316 91.5127 56.8523 92.1967 58.423C92.8808 59.9938 93.2488 61.6839 93.2797 63.3969C93.3106 65.1099 93.0038 66.8122 92.3768 68.4066C91.7498 70.001 90.815 71.4563 89.6255 72.6894C88.4361 73.9225 87.0155 74.9093 85.4447 75.5933C83.874 76.2774 82.1839 76.6454 80.4709 76.6763ZM65.765 87.5292C58.6473 92.2939 58.6473 100.059 65.765 104.794C73.8532 110.206 87.1179 110.206 95.2062 104.794C102.324 100.029 102.324 92.2645 95.2062 87.5292C87.1473 82.1469 73.8826 82.1469 65.765 87.5292Z"
          stroke="#B8B8B8" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
        <rect x="0.5" y="0.5" width="159" height="159" stroke="#D1D1D1" />
      </svg> --}}
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <div class="d-grid mt-3 d-none" id="change_profile_btn">
        <button type="button" class="btn border rounded-0 user-btn pic-change-btn" id="picChangeBTN">Change photo</button>
        <button class="btn border rounded-0 user-btn pic-upload-btn mb-2 d-none" id="picUploadBTN">Upload Photo</button>
        <button type="button" class="btn border rounded-0 user-btn pic-delete-btn" id="picDeleteBTN">Delete</button>
        <div class="d-none">
          <input class="file-upload-avtar" type="file" name="profileavtar" accept="image/*" id="avtarUpload"/>
        </div>

      </div>
    </div>
  </form>
</div>
<form method="POST" action="{{route('UpdateClientProfile')}}" class="custom-profiles-form personal-details-form" id="personalDetailsForm">
  @csrf
  <div class="row">
    <div class="col-12">
      <div class="row mt-4">
        <div class="col-lg-5 col-md-5 col-sm-12">
          <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-0" name="clientFirstName" id="clientFirstName" value="{{$data['name']}}" placeholder="First name">
            <label for="clientFirstName">First name</label>
          </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-12">
          <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-0" name="clientLastName" id="clientLastName" value="{{$data['last_name']}}" placeholder="last name">
            <label for="clientLastName">Last name</label>
          </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-12">
          <div class="form-floating mb-3">
            <input type="email" class="form-control rounded-0" name="clientEmail" id="clientEmail" value="{{$data['email']}}" placeholder="Email">
            <label for="clientEmail">Email</label>
          </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-12">
          <div class="form-floating mb-3">
            <input type="tel" class="form-control rounded-0" name="clientPhone" id="clientPhone" value="{{$data['phone']}}" placeholder="Mobile">
            <label for="clientPhone">Mobile</label>
          </div>
        </div>
        <div class="col-12" id="edit_btn_row">
          <button onclick="showEditBtn()" type="button" class="btn border user-btn">Edit profile</button>
        </div>
      </div>
    </div>
  </div>
  <div class="row d-none" id="save_btn_row">
    <div class="col-lg-5 col-md-5">
      <input type="hidden" name="id" value="{{$data['id']}}">
      <button type="submit" class="btn btn-lg border profile-btn mt-sm-2">Save details</button>
    </div>
    <div class="col-lg-5 col-md-5">
      <a href="{{route('ClientProfile')}}" type="button" class="btn btn-lg border profile-btn mt-sm-2">Cancel</a>
    </div>
  </div>
</form>

@endsection


@section('js_scripts')

<script>
  function showEditBtn(){
    $("#edit_btn_row").addClass('d-none')
    $("#save_btn_row").removeClass('d-none')
    $("#change_profile_btn").removeClass('d-none')
    
  }
</script>

<script>
  // Personal logo uploader
  var readURL = function(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('.profile-pic').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $(".file-upload-avtar").on('change', function() {
    readURL(this);
    $("#picUploadBTN").removeClass('d-none')
    $("#picChangeBTN").addClass('d-none')
  });

  $(".pic-change-btn").on('click', function() {
    $(".file-upload-avtar").click();
  });

  $(".pic-delete-btn").on('click', function() {
    $('.profile-pic').attr('src', 'assets-images/Desktop-Assets/your profile/blank-avtar.jpg');
    $('.file-upload-avtar').val('')
    $("#picUploadBTN").addClass('d-none')
    $("#picChangeBTN").removeClass('d-none')
    deleteImage(1);
  }); 
</script>

<script>
  async function deleteImage(deleteImageFor){
      // 1 for profile Image 2 for Company Logo
      await $.ajax({
          url: "{{ url('delete-image') }}",
          type: "POST",
          dataType: 'json',
          data: {
              deleteImageFor,
              _token: '{{ csrf_token() }}'
          },
          success: function(res) {
              console.log('res', res)
              massage = res?.massage;
          }
      });
      setTimeout(() => {
          $(".otpError").addClass('d-none')
      }, 4000);
  }
</script>

@endsection
