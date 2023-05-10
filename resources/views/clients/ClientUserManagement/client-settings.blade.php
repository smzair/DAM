@extends('layouts.DamNewMain')
@section('title')
Clients - Settings
@endsection

@section('other_css')
  <style>
    .form-group {
    margin-bottom: 30px;
}


.group-inner {
    position: relative;
}

.profile-icon {
    position: absolute;
    width: 30px;
    height: 30px;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.4s ease-in-out;
    background-color: transparent;
    border: 0;
    border-radius: 100%;
    cursor: pointer;
}

.profile-icon img {
    width: 16px;
}

.profile-icon:hover, 
.profile-icon:focus {
    background-color: #F7F7FD;
}

.custom-profiles-form .form-group {
    position: relative;
}

.custom-profiles-form .form-group .form-label {
    position: absolute;
    left: 15px;
    z-index: 2;
    font-size: 12px;
    top: 10px;
    width: auto;
    line-height: 1;
    margin: 0;
    right: auto;
}

.custom-profiles-form .formInput {
    padding-top: 26px;
    color: #282846;
    font-size: 15px;
}

.custom-personal-details .formInput {
    padding-right: 100px;
}

.custom-profiles-form .formInput.formselect {
    padding-right: 40px;
}


input[type="text"], 
input[type="email"], 
input[type="password"], 
input[type="number"],
input[type="tel"],
input[type="search"],
select,
.nice-select,
textarea,
.marketplace-item-body {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    width: 100%;
    display: inline-block;
    vertical-align: middle;
    background-color: #fff;
    border: 1px solid #BDBDDD;
    padding: 15px;
    border-radius: 10px;
    font-family: "Helvetica Neue","sans-serif";
    font-weight: 400;
    font-style: normal;
    font-size: 16px;
    line-height: 1.5;
    color: #7F7FAA;
    margin: 0;
    outline: 0;
    transition: all 0.3s ease-in-out;
}

.profile-icon.pswd-eye-icon {
    background-color: transparent !important;
}

.pswd-eye-icon img.eye-icon.hide-eye {
    display: inline-block;
}

.pswd-eye-icon img.eye-icon.show-eye {
    display: none;
}

.pswd-eye-icon:after {
    position: absolute;
    left: 5px;
    right: 0;
    top: calc(50% - 0px);
    margin: 0 auto;
    width: 100%;
    height: calc(100% - 5px);
    border-left: 2px solid #7f7faa;
    content: "";
    transform: rotate3d(1, 1, 1, 90deg);
}

.pswd-eye-icon.eye-active:after {
    display: none;
}

.pswd-eye-icon.eye-active img.eye-icon.hide-eye {
    display: none;
}

.pswd-eye-icon.eye-active img.eye-icon.show-eye {
    display: inline-block;
}
    
  </style>
@endsection

@section('main_content')
<div class="row" style="margin-top:24px ;">
  <div class="col-12">
    <h4 class="headingF">
      Settings
    </h4>

  </div>
  <div class="col-12">
    <p class="underheadingF">
      You can change your password and verify mobile no. here.
    </p>
  </div>
  <hr style="margin-left: 15px;">

</div>
<div class="row verification-div">
  <div class="col-lg-6 col-md-7 col-sm-8 col-12 border ">
    <div class="row" style="padding: 16px;">
      <div class="col-12">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12">
            <div style="line-height: 50%;">
              <p>Your Email</p>
              <p>kumar.u@email.com</p>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12">
            <button class="btn btn-secondary offset-lg-4 " style="width: 140px;height: 48px;">
              <svg width="17"
                height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="0.5" width="16" height="16" fill="#9F9F9F" />
                <line x1="2.67191" y1="1.46383" x2="14.8901" y2="13.682" stroke="#D1D1D1" />
                <line x1="1.96481" y1="13.6826" x2="14.183" y2="1.4644" stroke="#D1D1D1" />
              </svg> 
              Verified
            </button>
          </div>
        </div>
      </div>
      <div class="col-12 mt-4">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12">
            <div style="line-height: 50%;">
              <p>Your Email</p>
              <p>kumar.u@email.com</p>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-md-6 col-sm-12">
            <button class="btn btn-secondary offset-lg-4" style="width: 140px;height: 48px;"> Verify </button>
          </div>
        </div>
      </div>
      <div class="col-12 mt-4">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12">
            <div style="line-height: 50%;">
              <p>Your password</p>
              <p>*************</p>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12">
            <button class="btn btn-secondary offset-lg-4" style="width: 140px;height: 48px;" id="passwordActionBTN" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
              Change</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{route('sub_users_access_permission_new')}}" method="post">
      @csrf

      <div class="modal-content">
        <div class="modal-header d-flex justify-content-center">
          <h5 class="modal-title" id="exampleModalLabel">Give Permissions</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <h5>Section</h5>
            <div class="col-sm-12 mb-3 permition_section mt-4" id="your_assets_row" >
              <div  id="your_assets_section">
                {{-- <input type="checkbox" name="your_assets" id="your_assets" checked> --}}
                <label for="your_assets">Your Assets</label>  
              </div>
              <div class="" id="your_assets_services">
                <input type="checkbox" name="ya_shoot" id="ya_shoot"><label for="ya_shoot">Shoot</label>
                <input type="checkbox" name="ya_Creative" id="ya_Creative"><label for="ya_Creative">Creative</label>
                <input type="checkbox" name="ya_Cataloging" id="ya_Cataloging"><label for="ya_Cataloging">Cataloging</label>
                <input type="checkbox" name="ya_Editing" id="ya_Editing"><label for="ya_Editing">Editing</label>
              </div>
            </div>

            <div class="col-sm-12 mb-3 permition_section mt-4" id="file_manager_row">
              <div  id="file_manager_section">
                {{-- <input type="checkbox" name="file_manager" id="file_manager" checked> --}}
                <label for="file_manager">File Manager</label>  
              </div>
              <div class="" id="file_manager_services">
                <input type="checkbox" name="fm_shoot" id="fm_shoot"><label for="fm_shoot">Shoot</label>
                <input type="checkbox" name="fm_Creative" id="fm_Creative"><label for="fm_Creative">Creative</label>
                <input type="checkbox" name="fm_Cataloging" id="fm_Cataloging"><label for="fm_Cataloging">Cataloging</label>
                <input type="checkbox" name="fm_Editing" id="fm_Editing"><label for="fm_Editing">Editing</label>
              </div>
            </div>
          </div>
            
        </div>
        <div class="modal-footer">
          <input type="hidden" name="user_id" id="user_id" value="">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- changePasswordModal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <form action="{{route('ChangePassword')}}" method="POST" class="verification-global-form password-change-form" id="passwordChangeform" onsubmit="return validateForm()" autocomplete="off">
      @csrf

      <div class="modal-content">
        <div class="modal-header d-flex justify-content-center">
          <h5 class="modal-title">Change your Password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 mb-3 permition_section mt-2" id="your_assets_row" >
              <div  id="your_assets_section">
                <label for="your_assets">New password</label>  
              </div>
              <div class="form-group password-form-group" id="your_assets_services">
                <div class="group-inner">
                  <input type="password" class="formInput new-password-input" name="newPswdInput" id="newPswdInput" placeholder="Create new password" maxlength="10" required autocomplete="off">
                  <span class="profile-icon pswd-eye-icon" onclick="showhide('new')">
                      <img src="assets-images\Desktop-Assets\your profile\eye_sign.svg" class="eye-icon hide-eye" alt="Eye Hide">
                      <img src="assets-images\Desktop-Assets\your profile\eye_signdark.svg" class="eye-icon show-eye" alt="Eye Show">                                                 
                  </span>
                  <div class="new-password_err" style="color: red"></div>
              </div>
              <p class="mand-message-label red-msg-label" style="color: red">Password should be at least 8 characters in length and should include at least one upper case letter, one lower case letter,  one number, and one special character.</p>
              </div>
            </div>

            <div class="col-sm-12 mb-3 permition_section mt-2" id="file_manager_row">
              <div  id="">
                {{-- <input type="checkbox" name="file_manager" id="file_manager" checked> --}}
                <label for="file_manager">File Manager</label>  
              </div>
              <div class="form-group password-form-group mb-0">
                <div class="group-inner">
                    <input type="password" class="formInput confirm-password-input" name="confirmPswdInput" id="confirmPswdInput" placeholder="Confirm password" maxlength="10" required autocomplete="off">
                    <span class="profile-icon pswd-eye-icon" onclick="showhide('confirm')">
                        <img src="assets-images\Desktop-Assets\your profile\eye_sign.svg" class="eye-icon hide-eye" alt="Eye Hide">
                        <img src="assets-images\Desktop-Assets\your profile\eye_signdark.svg" class="eye-icon show-eye" alt="Eye Show">                                                 
                    </span>
                    <div class="confirm-password_err" style="color: red"></div>
                </div>
                <p class="mand-message-label red-msg-label" style="color: red">Both passwords must match.</p>
            </div>
            </div>
          </div>
            
        </div>
        <div class="modal-footer">
          <input type="hidden" name="user_id" id="user_id" value="">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@section('js_scripts')
	{{-- Send Otp --}}
    <script>
        async function sendotp(otpfor,resend = 0){
            // 1 for emailVerify 2 for phoneVerify
            $("#yourMail"+otpfor).text('')

            if(otpfor == 1){
                input_id = "#E-vInput"
            }else{
                input_id = "#P-vInput"
            }

            for(let i = 1; i<= 4; i++){
                $(input_id+i).val('');
            }
            await $.ajax({
                url: "{{ url('send-otp') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    otpfor,
                    resend,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    console.log('res', res)
                    massage = res.massage;
                    $("#yourMail"+otpfor).text(res.email)
                    $(".otpError").text(res.massage)
                }
            });
            setTimeout(() => {
                $(".otpError").addClass('d-none')
            }, 4000);
        }
    </script>

  {{-- Verify Otp --}}
  <script>
    async function verifyOtp(otpfor){
      // 1 for emailVerify 2 for phoneVerify
      let otpIs = '';
      let display_block = d_none = input_id = '';

      if(otpfor == 1){
        display_block = 'emailverify-success-msg-id'
        d_none = 'email-verify-form-wrapper'
        input_id = "#E-vInput"
      }else{
        display_block = 'phoneverify-success-msg-id'
        d_none = 'phone-verify-form-wrapper'
        input_id = "#P-vInput"
      }

      for(let i = 1; i<= 4; i++){
        let value = $(input_id+i).val();
        otpIs = otpIs+''+value
      }

      if(otpIs.length != 4){
        $(".otpError").text('4 digit OTP not entered')
        $(".otpError").removeClass('d-none')
        setTimeout(() => {
          $(".otpError").addClass('d-none')
        }, 2000); 
        return
      }
      let final_otp = otpIs*1
      await $.ajax({
        url: "{{ url('verify-otp') }}",
        type: "POST",
        dataType: 'json',
        data: {
          otpfor,
          final_otp,
          _token: '{{ csrf_token() }}'
        },
        success: function(res) {
          if(res.status){
            $("#"+d_none).css('display', 'none');
            $("#"+display_block).css('display', 'block');
          }else{
            $(".otpError").text(res.massage)
            $(".otpError").removeClass('d-none')
          }
        }
      });
      setTimeout(() => {
        $(".otpError").addClass('d-none')
      }, 2000); 
    }
  </script>

  <script>
    function showhide(class_name){
      var myInput = document.getElementsByClassName(class_name+"-password-input");
      let input_type =  $('.'+class_name+"-password-input").attr('type');
      if (input_type === "password") {
        $('.'+class_name+"-password-input").attr('type' , 'text');
      } else {
        $('.'+class_name+"-password-input").attr('type' , 'password');
      }
    }
  </script>

  {{-- verifyOldPass --}}
  <script>
    function validateForm(e){
      // event.preventDefault()
      const newPswdInput = $('#newPswdInput').val()
      const confirmPswdInput = $('#confirmPswdInput').val()
      
      $("#confirm-password_err").text('')
      console.log({oldPswdInput , newPswdInput, confirmPswdInput})

      return false;

      if(newPswdInput.length < 8){
        return false;
      }else if(confirmPswdInput.length < 8){
        return false;
      }else if(newPswdInput == confirmPswdInput) {
        return false;
      }
    }
  </script>

<script>
    $(document).ready(function() {
        setTimeout(() => {
            $('#msg_div').attr("style", "display:none")
        }, 3000);
    });
</script>
    
@endsection


