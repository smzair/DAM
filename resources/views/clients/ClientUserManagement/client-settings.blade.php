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


.modal-content {
    border: 0;
    border-radius: 20px;
    background-color: #fff;
    position: relative;
}

.modal-body {
    padding: 40px;
}

.modal:after {
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    height: 100%;
    width: 100%;
    background-color: rgba(40,40,70,0.6);
    content: "";
    z-index: -1;
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

.modal-close {
    width: 40px;
    height: 40px;
    cursor: pointer;
    position: absolute;
    top: 20px;
    right: 20px;
}

.verification-process {
    display: block;
    width: 100%;
}

.verification-info {
    max-width: 400px;
    display: block;
    margin: 0 auto;
    text-align: center;
    margin-bottom: 30px;
}

.verification-info h5 {
    margin-bottom: 15px;
    font-weight: bold;
}

.verification-info p {
    margin: 0;
    letter-spacing: 0.15px;
}

.verification-info p > span {
    display: inline-block;
    color: #282846;
    font-weight: 700;
}

.verification-otp {
    display: block;
    width: 100%;
    text-align: center;
    max-width: 475px;
    margin: 0 auto;
}

.verification-otp .inputs {
    display: flex;
    width: 100%;
    flex-wrap: nowrap;
    justify-content: center;
}

.verification-otp .verification-inputs {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    vertical-align: middle;
    background-color: #fff;
    border: 1px solid #BDBDDD;
    font-family: "Helvetica Neue","sans-serif";
    font-weight: 700;
    font-style: normal;
    font-size: 22px;
    line-height: 1;
    color: #282846;
    margin: 0;
    outline: 0;
    text-align: center;
}

.verification-otp .verification-inputs:not(:last-child) {
    margin-right: 40px;
}

.verfication-modal .global-modal-dialog {
    max-width: 500px;
}

.acnt-verify-wrapper {
    display: block;
    width: 100%;
    text-align: center;
    margin-top: 30px;
}

.acnt-verify-wrapper .verify-btn {
    color: #fff;
    width: 100%;
    font-weight: 500;
    background-color: #282846;
    text-transform: uppercase;
    outline: 0;
    border: 0;
}

.acnt-verify-wrapper p {
    margin: 0;
    margin-top: 20px;
    color: #282846;
    letter-spacing: 0.15px;
    font-weight: 400;
}

.acnt-verify-wrapper p a {
    color: #007580;
    text-decoration: none !important;
    font-weight: 700;
    display: inline-block;
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

  <div id="msg_div">
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @elseif (Session::has('warning'))
        <div class="alert alert-warning" role="alert">
            {{ Session::get('warning') }}
        </div>
    @elseif (Session::has('false'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('false') }}
        </div>
    @endif
</div>

</div>
<div class="row verification-div">
  <div class="col-lg-8 col-md-8 col-sm-8 col-12 border ">
    <div class="row" style="padding: 16px;">
      <div class="col-12">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12">
            <div style="line-height: 50%;">
              <p>Your Email</p>
              <p>{{$data['email']}}</p>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12">
            @if ($data['email_verified'] == 1)
              <button class="btn btn-secondary offset-lg-4 " style="width: 140px;height: 48px;">
                <svg width="17"
                  height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect x="0.5" width="16" height="16" fill="#9F9F9F" />
                  <line x1="2.67191" y1="1.46383" x2="14.8901" y2="13.682" stroke="#D1D1D1" />
                  <line x1="1.96481" y1="13.6826" x2="14.183" y2="1.4644" stroke="#D1D1D1" />
                </svg> 
                Verified
              </button>
            @else
              <button class="btn btn-secondary offset-lg-4" style="width: 140px;height: 48px;" data-bs-toggle="modal" data-bs-target="#emailverficationModal" onclick="sendotp(1)"> Verify </button>
            @endif
          </div>
        </div>
      </div>
      <div class="col-12 mt-4">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12">
            <div style="line-height: 50%;">
              <p>Your Phone</p>
              <p>{{$data['phone']}}</p>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-md-6 col-sm-12">
            @if ($data['phone_verified'] == 1)
              <button class="btn btn-secondary offset-lg-4 " style="width: 140px;height: 48px;">
                <svg width="17"
                  height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect x="0.5" width="16" height="16" fill="#9F9F9F" />
                  <line x1="2.67191" y1="1.46383" x2="14.8901" y2="13.682" stroke="#D1D1D1" />
                  <line x1="1.96481" y1="13.6826" x2="14.183" y2="1.4644" stroke="#D1D1D1" />
                </svg> 
                Verified
              </button>
            @else
              <button class="btn btn-secondary offset-lg-4" style="width: 140px;height: 48px;" data-bs-toggle="modal" data-bs-target="#phoneverficationModal" onclick="sendotp(2)"> Verify </button>
            @endif
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

{{-- models  --}}
<div class="modal-group">
  <div class="row modal-row">
      <div class="col-12">
        {{-- email verfication Modal --}}
          <div class="modal fade custom-global-modal verfication-modal email-modal" id="emailverficationModal" tabindex="-1"
              aria-hidden="true">
              <div class="modal-dialog global-modal-dialog">
                  <div class="modal-content global-modal-content verfication-modal-content">
                      <div class="modal-body verfication-modal-body">
                          <div class="modal-close" data-bs-dismiss="modal">
                              <img src="assets-images\Desktop-Assets\settings\close.svg" alt="Close">
                          </div>
                          <div class="custom-modal-form-wrapper email-verify-form-wrapper" id="email-verify-form-wrapper">
                              <form action="" method="POST" class="verification-global-form email-verify-form" id="emailVerifyform">
                                  <div class="verification-process">
                                      <div class="verification-info">
                                          <h5>Verification code</h5>
                                          <p>We’ve sent the 4-digit Email verification code to your email address
                                              <span id="yourMail1"></span></p>
                                      </div>
                                      <div class="verification-otp">
                                          <div class="inputs" id="emailverifyInputs">
                                              <input maxlength="1" class="verification-inputs" id="E-vInput1" placeholder="_" value="">
                                              <input maxlength="1" class="verification-inputs" id="E-vInput2" placeholder="_" value="">
                                              <input maxlength="1" class="verification-inputs" id="E-vInput3" placeholder="_" value="">
                                              <input maxlength="1" class="verification-inputs" id="E-vInput4" placeholder="_" value="">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="acnt-verify-wrapper">
                                      <a href="javascript:;" class="btn verify-btn" id="emailverifyBtn" onclick="verifyOtp(1)">Submit</a>
                                      <p>Didn’t receive the code? <a href="javascript:;" class="resend-link" onclick="sendotp(1,1)">Resend code</a></p>
                                  </div>
                              </form>
                          </div>
                          <div class="custom-verification-success-msg emailverify-success-msg" id="emailverify-success-msg-id" style="display: none">
                              <div class="success-checkmark">
                                  <div class="check-icon">
                                    <span class="icon-line line-tip"></span>
                                    <span class="icon-line line-long"></span>
                                    <div class="icon-circle"></div>
                                    <div class="icon-fix"></div>
                                  </div>
                              </div>
                              <h5>Your email is verified</h5>
                              <p>Hi, we have successfully verified your email address.</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          {{-- phone verfication Modal --}}
          <div class="modal fade custom-global-modal verfication-modal phone-modal" id="phoneverficationModal" tabindex="-1"
          aria-hidden="true">
            <div class="modal-dialog global-modal-dialog">
                <div class="modal-content global-modal-content verfication-modal-content">
                    <div class="modal-body verfication-modal-body">
                        <div class="modal-close" data-bs-dismiss="modal">
                            <img src="assets-images\Desktop-Assets\settings\close.svg" alt="Close">
                        </div>
                        <div class="custom-modal-form-wrapper phone-verify-form-wrapper" id="phone-verify-form-wrapper">
                            <div class="verification-process">
                                <div class="verification-info">
                                    <h5>Verification code</h5>
                                    <p>We’ve sent the 4-digit Phone verification code to your email address
                                        <span id="yourMail2">your@mail.com</span></p>
                                </div>
                                <div class="verification-otp">
                                    <div class="inputs" id="phoneverifyInputs">
                                        <input maxlength="1" class="verification-inputs" id="P-vInput1" placeholder="_" value="">
                                        <input maxlength="1" class="verification-inputs" id="P-vInput2" placeholder="_" value="">
                                        <input maxlength="1" class="verification-inputs" id="P-vInput3" placeholder="_" value="">
                                        <input maxlength="1" class="verification-inputs" id="P-vInput4" placeholder="_" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="acnt-verify-wrapper">
                                <a href="javascript:;" class="btn verify-btn" id="phoneverifyBtn" onclick="verifyOtp(2)">Submit</a>
                                <p>Didn’t receive the code? <a href="javascript:;" class="resend-link" onclick="sendotp(2,1)">Resend code</a></p>
                            </div>
                            <div class="otpError d-none" style="color: red;padding: 10px">
                            
                            </div>
                        </div>
                        <div class="custom-verification-success-msg phoneverify-success-msg" id="phoneverify-success-msg-id" style="display: none">
                            <div class="success-checkmark">
                                <div class="check-icon">
                                  <span class="icon-line line-tip"></span>
                                  <span class="icon-line line-long"></span>
                                  <div class="icon-circle"></div>
                                  <div class="icon-fix"></div>
                                </div>
                            </div>
                            <h5>Your phone is verified</h5>
                            <p>Hi, we have successfully verified your phone number.</p>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          
      </div>
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
                <label for="your_assets">New Password</label>  
              </div>
              <div class="form-group password-form-group" id="your_assets_services">
                <div class="group-inner">
                  <input type="password" class="formInput new-password-input" name="newPswdInput" id="newPswdInput" placeholder="Create new password" maxlength="16" autocomplete="off">
                  <span class="profile-icon pswd-eye-icon" onclick="showhide('new')">
                      <img src="assets-images\Desktop-Assets\your profile\eye_sign.svg" class="eye-icon hide-eye" alt="Eye Hide">
                      <img src="assets-images\Desktop-Assets\your profile\eye_signdark.svg" class="eye-icon show-eye" alt="Eye Show">                                                 
                  </span>
                </div>
                <div class="mand-message-label red-msg-label new-password_err d-none" style="color: red"></div>
              </div>
            </div>

            <div class="col-sm-12 mb-3 permition_section mt-2" id="file_manager_row">
              <div  id="">
                {{-- <input type="checkbox" name="file_manager" id="file_manager" checked> --}}
                <label for="file_manager">Confirm Password</label>  
              </div>
              <div class="form-group password-form-group mb-0">
                <div class="group-inner">
                    <input type="password" class="formInput confirm-password-input" name="confirmPswdInput" id="confirmPswdInput" placeholder="Confirm password" maxlength="16" autocomplete="off">
                    <span class="profile-icon pswd-eye-icon" onclick="showhide('confirm')">
                        <img src="assets-images\Desktop-Assets\your profile\eye_sign.svg" class="eye-icon hide-eye" alt="Eye Hide">
                        <img src="assets-images\Desktop-Assets\your profile\eye_signdark.svg" class="eye-icon show-eye" alt="Eye Show">                                                 
                    </span>
                  </div>
                  <div class="confirm-password_err" style="color: red"></div>
                <p class="mand-message-label red-msg-label " style="color: red"></p>
            </div>
            </div>
          </div>
            
        </div>
        <div class="modal-footer">
          <input type="hidden" name="user_id" id="user_id" value="">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

{{-- js_scripts --}}
@section('js_scripts')
  {{-- Send Otp --}}
  <script>
    async function sendotp(otpfor, resend = 0) {
      // 1 for emailVerify 2 for phoneVerify
      $("#yourMail" + otpfor).text('')

      if (otpfor == 1) {
        input_id = "#E-vInput"
      } else {
        input_id = "#P-vInput"
      }

      for (let i = 1; i <= 4; i++) {
        $(input_id + i).val('');
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
          $("#yourMail" + otpfor).text(res.email)
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
    async function verifyOtp(otpfor) {
      // 1 for emailVerify 2 for phoneVerify
      let otpIs = '';
      let display_block = d_none = input_id = '';

      if (otpfor == 1) {
        display_block = 'emailverify-success-msg-id'
        d_none = 'email-verify-form-wrapper'
        input_id = "#E-vInput"
      } else {
        display_block = 'phoneverify-success-msg-id'
        d_none = 'phone-verify-form-wrapper'
        input_id = "#P-vInput"
      }

      for (let i = 1; i <= 4; i++) {
        let value = $(input_id + i).val();
        otpIs = otpIs + '' + value
      }

      if (otpIs.length != 4) {
        $(".otpError").text('4 digit OTP not entered')
        $(".otpError").removeClass('d-none')
        setTimeout(() => {
          $(".otpError").addClass('d-none')
        }, 2000);
        return
      }
      let final_otp = otpIs * 1
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
          if (res.status) {
            $("#" + d_none).css('display', 'none');
            $("#" + display_block).css('display', 'block');
            setTimeout(() => {
              window.location.reload();
            }, 3000);
          } else {
            $(".otpError").text(res.massage)
            $(".otpError").removeClass('d-none')
          }
        }
      });
      setTimeout(() => {
        $(".otpError").addClass('d-none')
      }, 3500);
    }
  </script>

  <script>
    function showhide(class_name) {
      var myInput = document.getElementsByClassName(class_name + "-password-input");
      let input_type = $('.' + class_name + "-password-input").attr('type');
      if (input_type === "password") {
        $('.' + class_name + "-password-input").attr('type', 'text');
      } else {
        $('.' + class_name + "-password-input").attr('type', 'password');
      }
    }
  </script>

  {{-- verifyOldPass --}}
  <script>
    function validateForm(e) {
      // event.preventDefault()
      const newPswdInput = $('#newPswdInput').val()
      const confirmPswdInput = $('#confirmPswdInput').val()

      $(".confirm-password_err").text('')
      $(".new-password_err").text('')
      $(".new-password_err").removeClass('d-none')

      const pass_patern = ""
      const passwordIsValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}$/.test(newPswdInput);
      console.log({
        passwordIsValid,
        confirmPswdInput
      })
      let submit_form = false
      if (newPswdInput.length < 8) {
        $(".new-password_err").text('Password should be at least 8 characters in length.')
        submit_form = false;
      } else if (!passwordIsValid) {
        $(".new-password_err").text('Password should include at least one upper case letter, one lower case letter,  one number, and one special character.')
        submit_form = false;
      } else if (newPswdInput != confirmPswdInput) {
        $(".confirm-password_err").text('New Password and Confirm Password Not same.')
        submit_form = false;
      } else {
        submit_form = true;

      }
      return submit_form;

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


