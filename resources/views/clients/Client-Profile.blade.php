@extends('layouts.ClientMain')
@section('title')
  Client Dashboard
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
            <h4>Personal Details</h4>
            <p>Hey, Just want to let you know change is good.. 😁</p>
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
          </div>
        </div>
	</nav>
	<!-- /.navbar -->
	<!-- Main content -->
	<div class="content custom-dashboard-content">
        <div class="container-fluid">
          <div class="row dashboard-template-row profile-template-row">
            <div class="col-12">
                <div class="custom-dashboard-tabber custom-profile-tabber">
                    <ul class="tabs profile-tabs">
						{{-- personalDetailsTab li --}}
                       
                        <li class="tab-link profile-link current" data-tab="personalDetails" id="personalDetailsTab">
                            <span class="tab-span profile-span">
                                Personal Details
                            </span>
                        </li>

						{{-- companyDetailsTab li --}}
                        <li class="tab-link profile-link" data-tab="companyDetails" id="companyDetailsTab">
                            <span class="tab-span profile-span">
                                Company Details
                            </span>
                        </li>

						{{-- billingInformationTab li --}}
                        <li class="tab-link profile-link" data-tab="billingInformation" id="billingInformationTab">
                            <span class="tab-span profile-span">
                                Billing Information
                            </span>
                        </li>
                    </ul>

                    @php
                        $id = $data['id'];
                        $profile_avtar = $data['profile_avtar'];
                        $profile_avtar_path =  asset('uploades/profileavtar/'.$profile_avtar);
                        if(!file_exists($profile_avtar_path) && $profile_avtar != ''){
                            $profile_avtar_src = $profile_avtar_path;
                        }else{
                            $profile_avtar_src = "assets-images\Desktop-Assets\your profile\blank-avtar.jpg";
                        }

                        $company_logo = $data['company_logo'];
                        $company_logo_path =  asset('uploades/company_logo/'.$company_logo);
                        if(!file_exists($company_logo_path) && $company_logo != ''){
                            $company_logo_src = $company_logo_path;
                        }else{
                            $company_logo_src = "assets-images\Desktop-Assets\your profile\blank-avtar.jpg";
                        }
                    @endphp
					{{--  --}}
                    <div class="tab-listing-content custom-profilelisting-content" id="profilesContent">
						{{-- personalDetails section --}}
                        <div class="tab-content profile-content current" id="personalDetails">
                            <div class="custom-profile-details custom-personal-details">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-5 col-12 order-lg-2 order-0 d-none d-lg-block">
                                        <div class="right-col-image">
                                            <img src="assets-images\Desktop-Assets\your profile\Upload-logo-info.svg" alt="Upload Logo Information">
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-lg-7 col-12 order-lg-1 order-0">
                                        <div class="left-col-details">
                                            <div class="row">
                                                {{-- user profile --}}
                                                <div class="col-12">
                                                    <form method="POST" action="{{route('UploadeClientAvtar')}}" class="custom-profiles-form personal-details-form" id="UploadeClientAvtar" enctype="multipart/form-data">
                                                        @csrf;
                                                        <div class="profile-avtar">
                                                            <div class="avtar-logo">
                                                                <div class="avtar-logo-inner">
                                                                    <img src="{{$profile_avtar_src}}" class="profile-pic" alt="No Picture">
                                                                </div>
                                                            </div>
                                                            <div class="avtar-action-btn">
                                                                <a href="javascript:;" class="btn pic-change-btn" id="picChangeBTN">Change Photo</a>
                                                                <button class="btn pic-upload-btn mb-2 d-none" id="picUploadBTN">Upload Photo</button>
                                                                <a href="javascript:;" class="btn pic-delete-btn" id="picDeleteBTN">Delete</a>
                                                            </div>
                                                            <div>
                                                                <input class="file-upload-avtar" type="file" name="profileavtar" accept="image/*" id="avtarUpload"/>

                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <form method="POST" action="{{route('UpdateClientProfile')}}" class="custom-profiles-form personal-details-form" id="personalDetailsForm">
                                                @csrf;
                                                <div class="row">
                                                    {{-- First Name --}}
                                                    <div class="col-xl-6 col-lg-12 col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">First Name</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <input type="text" class="formInput first-name-input" name="clientFirstName" id="clientFirstName" value="{{$data['name']}}" >
                                                                <span class="profile-icon username-icon">
                                                                    <img src="assets-images\Desktop-Assets\your profile\Name.svg" alt="Name">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Last Name --}}
                                                    <div class="col-xl-6 col-lg-12 col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">Last Name</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <input type="text" class="formInput last-name-input" name="clientLastName" id="clientLastName" value="{{$data['last_name']}}" >
                                                                <span class="profile-icon username-icon">
                                                                    <img src="assets-images\Desktop-Assets\your profile\Name.svg" alt="Name">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Client id: --}}
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">Client id:</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <input type="text" class="formInput client-id-input" name="clientId" id="clientId" value="{{$data['client_id']}}">
                                                                <span class="profile-icon clientid-icon">
                                                                    <img src="assets-images\Desktop-Assets\your profile\client-id.svg" alt="Client Id">                                                                     
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Email --}}
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">Email</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <input type="email" class="formInput client-email-input" name="clientEmail" id="clientEmail" value="{{$data['email']}}">
                                                                @if (!$data['email_verified'])
                                                                    <span class="verify-link email-verify" id="emailVerify" data-bs-toggle="modal" data-bs-target="#emailverficationModal" onclick="sendotp(1)">verify</span>
                                                                @else
                                                                    <span class="verify-link email-verify verified" disabled>
                                                                        <img src="assets-images\Desktop-Assets\settings\verify.svg" alt="Verified Tick">
                                                                        Verified
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Mobile --}}
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">Mobile</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <input type="tel" class="formInput client-phone-input masked" name="clientPhone" id="clientPhone"  value="{{$data['phone']}}" maxlength="10" onkeypress="return isNumber(event)" >
                                                                
                                                                @if (!$data['phone_verified'])
                                                                    <span class="verify-link phone-verify" id="phoneVerify" data-bs-toggle="modal" data-bs-target="#phoneverficationModal" onclick="sendotp(2)">verify</span>
                                                                @else
                                                                    <span class="verify-link email-verify verified" disabled>
                                                                        <img src="assets-images\Desktop-Assets\settings\verify.svg" alt="Verified Tick">
                                                                        Verified
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- <div class="col-xl-6 col-lg-12 col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">City</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <select type="select" class="city-field formInput formselect" name="locationSelect" id="locationSelect" disabled>
                                                                    <option value="New Delhi" class="selected-option" selected>New Delhi</option>
                                                                    <option value="Bangalore">Bangalore</option>
                                                                    <option value="Kolkata">Kolkata</option>
                                                                    <option value="Mumbai">Mumbai</option>
                                                                </select>
                                                                <span class="profile-icon location-icon">
                                                                    <img src="assets-images\Desktop-Assets\your profile\location.svg" alt="Location">                                                                     
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div> --}}

                                                    {{-- Country --}}
                                                    {{-- <div class="col-xl-6 col-lg-12 col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">Country</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <!-- All countries -->
																<select type="select" class="country-field formInput formselect" name="countrySelect" id="countrySelect" disabled>
                                                                    <option value="IN">India</option>
																</select>
                                                                <span class="profile-icon country-icon">
                                                                    <img src="assets-images\Desktop-Assets\your profile\location.svg" alt="Country">                                                                     
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div> --}}

                                                    {{-- Password --}}
                                                    {{-- <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">Password</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <input type="password" class="formInput client-password-input" name="clientPassword" id="clientPassword" value="Sahil123@" readonly>
                                                                <span class="verify-link password-change" id="changePassword" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                                                    change <br/> password
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                </div>

                                                <div class="row custom-profile-btn-row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="custom-profile-action-btn">
                                                            <button class="btn profile-action-btn edit-btn" id="personaleditBTN">
                                                                <input type="hidden" name="id" value="{{$data['id']}}">
                                                                Edit
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="custom-profile-action-btn">
                                                            <a href="{{route('ClientProfile')}}" class="btn profile-action-btn cancel-btn" id="personalcancelBTN">
                                                                Cancel
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
						{{-- companyDetails section --}}
                        <div class="tab-content profile-content" id="companyDetails">
                            <div class="custom-profile-details custom-company-details">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-5 col-12 order-md-2 order-0">
                                        <div class="right-col-image">
                                            <img src="assets-images\Desktop-Assets\your profile\Upload-companylogo-info.svg" alt="Upload Logo Information">
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-lg-7 col-12 order-md-1 order-0">
                                        <div class="left-col-details">
                                            <div class="row">
                                                <div class="col-12">
                                                    <form action="{{route('UploadeCompanyLogo')}}" method="POST" enctype="multipart/form-data" >
                                                        @csrf;
                                                        <div class="profile-avtar">
                                                            <div class="avtar-logo">
                                                                <div class="avtar-logo-inner">
                                                                    <img src="{{$company_logo_src}}" class="company-pic" alt="Company logo">
                                                                </div>
                                                            </div>
                                                            <div class="avtar-action-btn">
                                                                @if ($data['role'] == 'Client')

                                                                    <a href="javascript:;" class="btn company-pic-change-btn" id="companypicChangeBTN">Change Logo</a>
                                                                    <button class="btn company-logo-upload-btn mb-2 d-none" id="compLogoUploadBTN">Upload logo</button>
                                                                    <a href="javascript:;" class="btn company-pic-delete-btn" id="companypicDeleteBTN">Delete</a>
                                                                    <input class="file-upload-company" name="company_logo" type="file" accept="image/*" id="companyavtarUpload"/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>  
                                            <form method="POST" action="{{route('UpdateClientcompanyDetails')}}" class="custom-profiles-form company-details-form" id="companyDetailsForm">
                                                @csrf;
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">Company name:</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <input type="text" class="formInput company-name-input" name="companyName" id="companyName" value="{{$data['company_name']}}" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">Company email:</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <input type="email" class="formInput company-email-input" name="companyEmail" id="companyEmail" value="{{$data['company_email']}}" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">Website:</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <input type="text" class="formInput company-website-input" name="companyWebsite" id="companyWebsite" value="" readonly>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">Contact no:</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <input type="tel" class="formInput company-phone-input masked" name="companyPhone" id="companyPhone"  value="{{$data['company_phone']}}" maxlength="10" onkeypress="return isNumber(event)" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($data['role'] == 'Client')
                                                    <div class="row custom-profile-btn-row">
                                                        <div class="col-md-6 col-12">
                                                            <div class="custom-profile-action-btn">
                                                                <input type="hidden" name="id" value="{{$data['id']}}">
                                                                <button class="btn profile-action-btn edit-btn" id="companyeditBTN">
                                                                    <input type="hidden" name="id" value="{{$data['id']}}">
                                                                    Edit
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="custom-profile-action-btn">
                                                                <a href="{{route('ClientProfile')}}"   class="btn profile-action-btn cancel-btn" id="companycancelBTN">
                                                                    Cancel
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

						{{-- billingInformation section --}}
                        <div class="tab-content profile-content" id="billingInformation">
                            <div class="custom-profile-details custom-billing-details">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-5 col-12 order-md-2 order-0">
                                        <div class="right-col-image">
                                            <img src="assets-images\Desktop-Assets\your profile\billing-info-tips.svg" alt="Billing Information">
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-lg-7 col-12 order-md-1 order-0">
                                        <div class="left-col-details">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">
                                                            <span class="label-span label-val">Full name:</span>
                                                        </label>
                                                        <div class="group-inner">
                                                            <input type="text" class="formInput full-name-input" name="fullName" id="fullName" value="{{$data['name']}} {{$data['last_name']}}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>    
                                            <form method="POST" action="{{route('UpdateClientbillingDetails')}}" class="custom-profiles-form billing-details-form" id="billingDetailsForm">
                                                @csrf;
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">Company name:</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <input type="text" class="formInput final-company-name-input" name="F-CompanyName" id="F-CompanyName" value="{{$data['company_name']}}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">GST:</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <input type="text" class="formInput gst-input" name="gstNo" id="gstNo" value="{{$data['Gst_number']}}" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">PAN:</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <input type="text" class="formInput pan-no-input" name="panNo" id="panNo" value="{{$data['pen_number']}}" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">Address:</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <input type="text" class="formInput address-input" name="completeAddress" id="completeAddress" value="{{$data['Address']}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">ZIP/Postal code:</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <input type="text" class="formInput pincode-input" name="pinCode" id="pinCode" value="{{$data['postal_code']}}" maxlength="6">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-xl-6 col-lg-12 col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">City</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <select type="select" class="city-field formInput formselect" name="billinglocationSelect" id="billinglocationSelect" disabled>
                                                                    <option value="New Delhi" class="selected-option" selected>New Delhi</option>
                                                                    <option value="Bangalore">Bangalore</option>
                                                                    <option value="Kolkata">Kolkata</option>
                                                                    <option value="Mumbai">Mumbai</option>
                                                                </select>
                                                                <span class="profile-icon location-icon">
                                                                    <img src="assets-images\Desktop-Assets\your profile\location.svg" alt="Location">                                                                     
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    {{-- <div class="col-xl-6 col-lg-12 col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <span class="label-span label-val">Country</span>
                                                            </label>
                                                            <div class="group-inner">
                                                                <!-- All countries -->
                                                                <select type="select" class="country-field formInput formselect" name="billingcountrySelect" id="billingcountrySelect" disabled>
                                                                    <option value="AF">Afghanistan</option>
																</select>
                                                                <span class="profile-icon country-icon">
                                                                    <img src="assets-images\Desktop-Assets\your profile\location.svg" alt="Country">                                                                     
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                                <div class="row custom-profile-btn-row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="custom-profile-action-btn">
                                                            <input type="hidden" name="id" value="{{$data['id']}}">
                                                            <button class="btn profile-action-btn edit-btn" id="billingeditBTN">
                                                                Edit
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="custom-profile-action-btn">
                                                            <a href="{{route('ClientProfile')}}" class="btn profile-action-btn cancel-btn" id="billingcancelBTN">
                                                                Cancel
                                                            </a>
                                                        </div>
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
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </div>
	<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
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
                                        <button onclick="verifyOtp(1)" class="btn verify-btn" id="emailverifyBtn">Submit</button>
                                        <p>Didn’t receive the code? <a href="javascript:;" onclick="sendotp(1,1)" class="resend-link">Resend code</a></p>
                                    </div>
                                    <div class="otpError d-none" style="color: red;padding: 10px">
                                        
                                    </div>
                                </div>
                                <div class="custom-verification-success-msg emailverify-success-msg" id="emailverify-success-msg">
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
                                            <span id="yourMail2">+918505854319</span></p>
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
                                    <a href="javascript:;" onclick="verifyOtp(2)" class="btn verify-btn" id="phoneverifyBtn">Submit</a>
                                    <p>Didn’t receive the code? <a href="javascript:;" onclick="sendotp(2,1)" class="resend-link">Resend code</a></p>
                                </div>
                                <div class="otpError d-none" style="color: red;padding: 10px">
                                
                                </div>
                            </div>
                            <div class="custom-verification-success-msg phoneverify-success-msg" id="phoneverify-success-msg">
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
                                <form action="" method="POST" class="verification-global-form password-change-form" id="passwordChangeform">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group password-form-group">
                                                <div class="group-inner">
                                                    <input type="password" class="formInput old-password-input" name="oldPswdInput" id="oldPswdInput" placeholder="Enter old password" maxlength="10" required>
                                                    <span class="profile-icon pswd-eye-icon">
                                                        <img src="assets-images\Desktop-Assets\your profile\eye_sign.svg" class="eye-icon hide-eye" alt="Eye Hide">
                                                        <img src="assets-images\Desktop-Assets\your profile\eye_signdark.svg" class="eye-icon show-eye" alt="Eye Show">                                                 
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group password-form-group">
                                                <div class="group-inner">
                                                    <input type="password" class="formInput new-password-input" name="newPswdInput" id="newPswdInput" placeholder="Create new password" maxlength="10" required>
                                                    <span class="profile-icon pswd-eye-icon">
                                                        <img src="assets-images\Desktop-Assets\your profile\eye_sign.svg" class="eye-icon hide-eye" alt="Eye Hide">
                                                        <img src="assets-images\Desktop-Assets\your profile\eye_signdark.svg" class="eye-icon show-eye" alt="Eye Show">                                                 
                                                    </span>
                                                </div>
                                                <p class="mand-message-label red-msg-label">Must be at least 8 characters.</p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group password-form-group mb-0">
                                                <div class="group-inner">
                                                    <input type="password" class="formInput confirm-password-input" name="confirmPswdInput" id="confirmPswdInput" placeholder="Confirm password" maxlength="10" required>
                                                    <span class="profile-icon pswd-eye-icon">
                                                        <img src="assets-images\Desktop-Assets\your profile\eye_sign.svg" class="eye-icon hide-eye" alt="Eye Hide">
                                                        <img src="assets-images\Desktop-Assets\your profile\eye_signdark.svg" class="eye-icon show-eye" alt="Eye Show">                                                 
                                                    </span>
                                                </div>
                                                <p class="mand-message-label">Both passwords must match.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="acnt-verify-wrapper">
                                                <a href="javascript:;" class="btn verify-btn reset-password-btn" id="resetPswdBTN">Reset Password</a>
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

@endsection

{{-- Other Js pluging   --}}
@section('js_links')
  	<script type="text/javascript" src=""></script>
@endsection

@section('js_scripts')
	<script type="text/javascript" src="{{asset('ClientsPlugins\vanilla-js-input-mask-main\js\input-mask.js')}}"></script>

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

	<script>
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
            $("#picUploadBTN").removeClass('d-none')
            $("#picChangeBTN").addClass('d-none')
		});

		$(".pic-change-btn").on('click', function () {
			$(".file-upload-avtar").click();
		});

		$(".pic-delete-btn").on('click', function () {
			$('.profile-pic').attr('src', 'assets-images/Desktop-Assets/your profile/blank-avtar.jpg');
            $('.file-upload-avtar').val('')
            $("#picUploadBTN").addClass('d-none')
            $("#picChangeBTN").removeClass('d-none')
            deleteImage(1);
		});

		// Company logo uploader
		var readURL2 = function (input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('.company-pic').attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]);
			}
		}

		$(".file-upload-company").on('change', function () {
			readURL2(this);
            $("#compLogoUploadBTN").removeClass('d-none')
            $("#companypicChangeBTN").addClass('d-none')
		});

		$(".company-pic-change-btn").on('click', function () {
			$(".file-upload-company").click();
		});

		$(".company-pic-delete-btn").on('click', function () {
			$('.company-pic').attr('src', 'assets-images/Desktop-Assets/your profile/blank-avtar.jpg');
            $('.file-upload-company').val('')
            $("#companypicChangeBTN").removeClass('d-none')
            $("#compLogoUploadBTN").addClass('d-none')
            deleteImage(2);
		});

		$(".edit-btn").on('click', function () {
			$(this).parents('.custom-profiles-form').find('.formInput').removeAttr('readonly');
			$(this).parents('.custom-profiles-form').find('.formselect').removeAttr('disabled');
			$(this).parents('.custom-profiles-form').find('.formselect').removeClass('disabled'); 
			$(this).parents('.custom-profiles-form').find('.formInput.first-name-input').focus();
		});

		$(".cancel-btn").on('click', function () {
			$(this).parents('.custom-profiles-form').find('.formInput').attr('readonly','readonly');
			$(this).parents('.custom-profiles-form').find('.formselect').attr('disabled','disabled');
			$(this).parents('.custom-profiles-form').find('.formselect').addClass('disabled'); 
		});

		$(".profile-link").on('click', function () {
			var tabName = $(this).children('.profile-span').text().trim();
			$(this).parents('.dashboard-content-wrapper').children('.custom-dashboard-header').find('.welcome-user-title').children('h4').text(tabName);
		});

		$("#personalDetailsTab").on('click', function () {
			removeCurrentclass()
			$("#personalDetails").addClass('current')
			$("#personalDetailsTab").addClass('current')
			$(this).parents('.dashboard-content-wrapper').children('.custom-dashboard-header').find('.welcome-user-title').children('p').text('Hey, Just want to let you know change is good.. 😁');
		});

		$("#companyDetailsTab").on('click', function () {
			removeCurrentclass()
			$("#companyDetails").addClass('current')
			$("#companyDetailsTab").addClass('current')
			$(this).parents('.dashboard-content-wrapper').children('.custom-dashboard-header').find('.welcome-user-title').children('p').text('Hey, please check your company details.. 😁');
		});
		
		$("#billingInformationTab").on('click', function () {
			removeCurrentclass()
			$("#billingInformation").addClass('current')
			$("#billingInformationTab").addClass('current')
			$(this).parents('.dashboard-content-wrapper').children('.custom-dashboard-header').find('.welcome-user-title').children('p').text('Brace yourself… well, it saves on dental bills… 😁');
		});

	</script>

	<script>
		function removeCurrentclass(){
			$("#personalDetailsTab").removeClass('current');
			$("#companyDetailsTab").removeClass('current');
			$("#billingInformationTab").removeClass('current');
			$("#personalDetails").removeClass('current');
			$("#companyDetails").removeClass('current');
			$("#billingInformation").removeClass('current');
		}
	</script>

    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('#msg_div').attr("style", "display:none")
                $(".otpError").addClass('d-none')
            }, 3500);
        });
    </script>

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
                display_block = 'emailverify-success-msg'
                d_none = 'email-verify-form-wrapper'
                input_id = "#E-vInput"
            }else{
                display_block = 'phoneverify-success-msg'
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


@endsection