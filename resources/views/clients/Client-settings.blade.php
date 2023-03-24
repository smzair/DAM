@extends('layouts.ClientMain')
@section('title')
  Client Settings
@endsection
@section('css_links')
	<link rel="stylesheet" href="">	
    <style>
        #email-verify-form-wrapper , #phone-verify-form-wrapper{
            display: block;
        }
    </style>
@endsection


@section('main_content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper dashboard-content-wrapper">
	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-white navbar-light custom-dashboard-header without-search-header">
        <!-- Left navbar links -->
        <div class="navbar-nav">
          <div class="dash-mobile-trigger">
            <img src="assets-images\Mob-Assets\images\line_img.png" alt="Mobile Trigger">
          </div>
          <div class="welcome-user-title">
            <h4>Settings</h4>
            <p>Change your settings</p>
          </div>
        </div>
        
	</nav>
	<!-- /.navbar -->
	<!-- Main content -->
	<div class="content custom-dashboard-content">
        <div class="container-fluid">
          <div class="row dashboard-template-row settings-template-row">
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
            <div class="col-12">
                <div class="custom-settings-changes-wrapper">
                    <div class="card dashboard-content-card settings-list-card">
                        <div class="card-inner">
                            <ul class="setting-item-list">
                                <li class="setting-item {{$data['email_verified'] == 1 ? 'setting-verified' : ''}} ">
                                    <div class="setting-info">
                                        <span class="setting-label">Verify Email:</span>
                                        <input type="email" class="setting-input-val" name="emailSet" id="emailSet" value="{{$data['email']}}" readonly>
                                    </div>
                                    <div class="setting-action">
                                        <a href="javascript:;" class="btn verify-action-btn" id="emailActionBTN" data-bs-toggle="modal" data-bs-target="#emailverficationModal">
                                            <span class="setting-span" onclick="sendotp(1)">Verify</span>
                                            <span class="setting-span verified">
                                                <img src="assets-images\Desktop-Assets\settings\verify.svg" alt="Verified Tick">
                                                Verified
                                            </span>
                                        </a>
                                    </div>
                                </li>
                                <li class="setting-item {{$data['phone_verified'] == 1 ? 'setting-verified' : ''}}">
                                    <div class="setting-info">
                                        <span class="setting-label">Verify Mobile:</span>
                                        <input type="tel" class="setting-input-val" name="phoneSet" id="phoneSet" value="{{$data['phone']}}" readonly>
                                    </div>
                                    <div class="setting-action">
                                        <a href="javascript:;" class="btn verify-action-btn" id="phoneActionBTN" data-bs-toggle="modal" data-bs-target="#phoneverficationModal">
                                            <span class="setting-span" onclick="sendotp(2)">Verify</span>
                                            <span class="setting-span verified">
                                                <img src="assets-images\Desktop-Assets\settings\verify.svg" alt="Verified Tick">
                                                Verified
                                            </span>
                                        </a>
                                    </div>
                                </li>
                                <li class="setting-item">
                                    <div class="setting-info">
                                        <span class="setting-label">Password:</span>
                                        <input type="password" class="setting-input-val" name="passwordSet" id="passwordSet" value="sahil123@" readonly>
                                    </div>
                                    <div class="setting-action">
                                        <a href="javascript:;" class="btn verify-action-btn" id="passwordActionBTN" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                            <span class="setting-span">Change</span>
                                            <span class="setting-span verified">
                                                <img src="assets-images\Desktop-Assets\settings\verify.svg" alt="Verified Tick">
                                                Changed
                                            </span>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    {{-- <div class="custom-settings-save-btns">
                        <a href="javascript:;" class="btn setting-save-btn" id="saveBTN">Save changes</a>
                        <a href="javascript:;" class="btn setting-cancel-btn" id="cancelBTN">Cancel</a>
                    </div> --}}
                </div>
            </div>
          </div>
        </div><!-- /.container-fluid -->
	</div>
	<!-- /.content -->
	<!-- Profile Varification Modal HTML -->

    <div class="modal-group">
        <div class="row modal-row">
            <div class="col-12">
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
                                                <p>we’ve sent the 4-digit verification code to your email address
                                                    <span id="yourMail1">your@mail.com</span></p>
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
                                <div class="custom-verification-success-msg emailverify-success-msg" id="emailverify-success-msg-id">
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
                                        <p>we’ve sent the 4-digit verification code to your email address
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
                            <div class="custom-verification-success-msg phoneverify-success-msg" id="phoneverify-success-msg-id">
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

                {{-- Change Password --}}
                <div class="modal fade custom-global-modal verfication-modal change-password-modal" id="changePasswordModal" tabindex="-1"
                aria-hidden="true">
                <div class="modal-dialog global-modal-dialog">
                    <div class="modal-content global-modal-content password-modal-content">
                        <div class="modal-body password-modal-body">
                            <div class="modal-close" data-bs-dismiss="modal">
                                <img src="assets-images\Desktop-Assets\settings\close.svg" alt="Close">
                            </div>
                            <div class="custom-modal-form-wrapper password-change-form-wrapper">
                                <div class="modal-title">
                                    <h5>Change your Password</h5>
                                </div>
                                <form action="{{route('ChangePassword')}}" method="POST" class="verification-global-form password-change-form" id="passwordChangeform" onsubmit="return validateForm()" autocomplete="off">
                                    @csrf;
                                    <div class="row">
                                        {{-- <div class="col-12">
                                            <div class="form-group password-form-group">
                                                <div class="group-inner">
                                                    <input type="password" class="formInput old-password-input" name="oldPswdInput" id="oldPswdInput" placeholder="Enter old password" maxlength="10" required>
                                                    <span class="profile-icon pswd-eye-icon" onclick="showhide('old')">
                                                        <img src="assets-images\Desktop-Assets\your profile\eye_sign.svg" class="eye-icon hide-eye" alt="Eye Hide">
                                                        <img src="assets-images\Desktop-Assets\your profile\eye_signdark.svg" class="eye-icon show-eye" alt="Eye Show">                                                 
                                                    </span>
                                                    <div class="old-password_err" style="color: red"></div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="col-12">
                                            <div class="form-group password-form-group">
                                                <div class="group-inner">
                                                    <input type="password" class="formInput new-password-input" name="newPswdInput" id="newPswdInput" placeholder="Create new password" maxlength="10" required autocomplete="off">
                                                    <span class="profile-icon pswd-eye-icon" onclick="showhide('new')">
                                                        <img src="assets-images\Desktop-Assets\your profile\eye_sign.svg" class="eye-icon hide-eye" alt="Eye Hide">
                                                        <img src="assets-images\Desktop-Assets\your profile\eye_signdark.svg" class="eye-icon show-eye" alt="Eye Show">                                                 
                                                    </span>
                                                    <div class="new-password_err" style="color: red"></div>
                                                </div>
                                                <p class="mand-message-label red-msg-label">Password should be at least 8 characters in length and should include at least one upper case letter, one lower case letter,  one number, and one special character.</p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group password-form-group mb-0">
                                                <div class="group-inner">
                                                    <input type="password" class="formInput confirm-password-input" name="confirmPswdInput" id="confirmPswdInput" placeholder="Confirm password" maxlength="10" required autocomplete="off">
                                                    <span class="profile-icon pswd-eye-icon" onclick="showhide('confirm')">
                                                        <img src="assets-images\Desktop-Assets\your profile\eye_sign.svg" class="eye-icon hide-eye" alt="Eye Hide">
                                                        <img src="assets-images\Desktop-Assets\your profile\eye_signdark.svg" class="eye-icon show-eye" alt="Eye Show">                                                 
                                                    </span>
                                                    <div class="confirm-password_err" style="color: red"></div>
                                                </div>
                                                <p class="mand-message-label red-msg-label">Both passwords must match.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="acnt-verify-wrapper">
                                                <button type="submit" class="btn verify-btn reset-password-btn" id="resetPswdBTN">Reset Password</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="custom-verification-success-msg passwordchange-success-msg">
                                <div class="success-checkmark">
                                    <div class="check-icon">
                                      <span class="icon-line line-tip"></span>
                                      <span class="icon-line line-long"></span>
                                      <div class="icon-circle"></div>
                                      <div class="icon-fix"></div>
                                    </div>
                                </div>
                                <h5>Your password is changed</h5>
                                <p>Hi, we have successfully changed your password.</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Profile Varification Modal HTML -->
	</div>
	<!-- /.content-wrapper -->
@endsection

{{-- Other Js pluging   --}}
@section('js_links')
  <script type="text/javascript" src=""></script>
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
    async function validateForm(){
        const oldPswdInput = $('#oldPswdInput').val()
        const newPswdInput = $('#newPswdInput').val()
        const confirmPswdInput = $('#confirmPswdInput').val()
        
        $("#new-password_err").text('')
        $("#confirm-password_err").text('')
        $("#old-password_err").text('')
        console.log({oldPswdInput , newPswdInput, confirmPswdInput})

        if(oldPswdInput == ''){
            $("#new-password_err").text('')
            $("#confirm-password_err").text('')
            $("#old-password_err").text('')
        }
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