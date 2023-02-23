@extends('layouts.client')
@section('title')
Flipkart Panel
@endsection
@section('content')

<div class="body-container-wrapper">
        <div class="container">
            <div class="row template-row">
                <div class="col-12">
                    <div class="custom-start-wrapper profile-title-wrapper">
                        <h3>Edit your profile</h3>
                    </div>
                </div>
            </div>
            <div class="row template-row">
                <div class="col-12">
                    <div class="card panel-content-card custom-profile-changes">
                        <div class="card-inner">
                            <form action="" method="POST" class="custom-profiles-form" id="profileForm">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="profile-avtar">
                                            <div class="avtar-logo">
                                                <div class="avtar-logo-inner">
                                                    <img src="Images/content-images/dp2.jpg" class="profile-pic" alt="Profile Picture">
                                                </div>
                                            </div>
                                            <div class="avtar-action-btn">
                                                <a href="javascript:;" class="btn pic-change-btn" id="picChangeBTN">Change Photo</a>
                                                <input class="file-upload-avtar" type="file" accept="image/*" id="avtarUpload">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="firstname">First Name</label>
                                            <input type="text" class="formInput" name="firstName" id="firstName" value="Sahil" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="lastname">Last Name</label>
                                            <input type="text" class="formInput" name="lastName" id="lastName" value="Mohammad" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="userid">User Id</label>
                                            <input type="text" class="formInput" name="userId" id="userId" value="COM002345" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="formInput" name="userEmail" id="userEmail" value="sahil.m@odndigital.in" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="tel" class="formInput masked" name="userPhone" id="userPhone" data-pattern="+** *** *** ****" data-prefix="+91" value="+91 9876543210" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group password-form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="formInput" name="userPassword" id="userPassword" value="Sahil123@" required>
                                            <span class="mand-message-label" data-bs-toggle="modal" data-bs-target="#passwordModal">Change <br> Password</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="profile-submit">
                                        <a href="javascript:;" class="btn profile-submit-btn" id="profilesubmitBTN">
                                            Save
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Change Modal -->

    <div class="modal-group">
        <div class="row modal-row">
            <div class="col-12">
            <div class="modal fade custom-global-modal password-modal" id="passwordModal" tabindex="-1"
                aria-hidden="true">
                <div class="modal-dialog global-modal-dialog">
                    <div class="modal-content global-modal-content password-modal-content">
                        <div class="modal-body password-modal-body">
                        <div class="modal-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </div>
                        <form method="POST" action="" class="password-form" id="passwordForm">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="group-inner">
                                            <input type="password" class="formInput" name="oldPassword" id="oldPassword" placeholder="Enter old password">
                                            <span class="profile-pswd-icon">
                                                <img src="Images\content-images\eye_sign.svg" class="eye-icon hide-eye" alt="Eye Hide">
                                                <img src="Images\content-images\eye_signdark.svg" class="eye-icon show-eye" alt="Eye Show">                                                 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="group-inner">
                                            <input type="password" class="formInput" name="newPassword" id="newPassword" placeholder="Create new password">
                                            <span class="profile-pswd-icon">
                                                <img src="Images\content-images\eye_sign.svg" class="eye-icon hide-eye" alt="Eye Hide">
                                                <img src="Images\content-images\eye_signdark.svg" class="eye-icon show-eye" alt="Eye Show">                                                 
                                            </span>
                                        </div>
                                        <p class="normal-message-label red-msg-label">Must be at least 8 characters.</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="group-inner">
                                            <input type="password" class="formInput" name="confirmPassword" id="confirmPassword" placeholder="Confirm password">
                                            <span class="profile-pswd-icon">
                                                <img src="Images\content-images\eye_sign.svg" class="eye-icon hide-eye" alt="Eye Hide">
                                                <img src="Images\content-images\eye_signdark.svg" class="eye-icon show-eye" alt="Eye Show">                                                 
                                            </span>
                                        </div>
                                        <p class="normal-message-label">Both passwords must match.</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn changepswd-submit-btn" id="changePswdBTN">
                                        Change Password
                                    </button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- End of Password Change Modal -->

    <script src="plugins\bootstrap-5.1.3-dist\js\bootstrap.bundle.js"></script>
    <script src="plugins\bootstrap-5.1.3-dist\js\bootstrap.min.js"></script>

    <script type="text/javascript" src="plugins\jquery\jquery.min.js"></script>

    <script src="plugins\jqueryTime\goodMorning.js"></script>

    <!-- Common JS -->

    <script src="dist\js\common_js.js"></script>

    <script type="text/javascript" src="plugins\vanilla-js-input-mask-main\js\input-mask.js"></script>

    <script>
        $('#greetingMSG').goodMorning();

        // Personal logo uploader
        var readURL = function (input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.profile-pic').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".file-upload-avtar").on('change', function () {
            readURL(this);
        });

        $(".pic-change-btn").on('click', function () {
            $(".file-upload-avtar").click();
        });

        $('.profile-submit-btn').click(function(){
            var imgSRc = $('.profile-pic').attr('src');
            console.log(imgSRc);
            $('.profile-info').css({
                "background-image": "url('"+imgSRc+"')"
            });
        });

        // Show Password

        $('body').on('click', '.profile-pswd-icon:not(.eye-active)', function () {
            $(this).addClass('eye-active');
            $(this).parents('.form-group').find('.formInput').attr('type', 'text');
        });

        $('body').on('click', '.profile-pswd-icon.eye-active', function () {
            $(this).removeClass('eye-active');
            $(this).parents('.form-group').find('.formInput').attr('type', 'password');
        });

    </script>
@endsection