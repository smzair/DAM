<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('ClientsPlugins/bootstrap-5.1.3-dist/css/bootstrap.min.css') }}">

  

  <!-- Common Style -->
  <link rel="stylesheet"  href="{{ asset('ClientsDist/css/common_style.css') }}">

  <style>
    @font-face {
      font-family: 'Helvetica Neue';
      src: url('fonts/Helvetica-Neue/Helvetica-Neue_300/HelveticaNeue-Light.ttf'),
        url('fonts/Helvetica-Neue/Helvetica-Neue_300/HelveticaNeue-Light.woff'),
        url('fonts/Helvetica-Neue/Helvetica-Neue_300/HelveticaNeue-Light.woff2');
      font-weight: 300;
      font-style: normal;
      font-display: swap;
    }

    @font-face {
      font-family: 'Helvetica Neue';
      src: url('fonts/Helvetica-Neue/Helvetica-Neue_400/HelveticaNeue.ttf'),
        url('fonts/Helvetica-Neue/Helvetica-Neue_400/HelveticaNeue.woff'),
        url('fonts/Helvetica-Neue/Helvetica-Neue_400/HelveticaNeue.woff2');
      font-weight: 400;
      font-style: normal;
      font-display: swap;
    }

    @font-face {
      font-family: 'Helvetica Neue';
      src: url('fonts/Helvetica-Neue/Helvetica-Neue_500/HelveticaNeue-Medium.ttf'),
        url('fonts/Helvetica-Neue/Helvetica-Neue_500/HelveticaNeue-Medium.woff'),
        url('fonts/Helvetica-Neue/Helvetica-Neue_500/HelveticaNeue-Medium.woff2');
      font-weight: 500;
      font-style: normal;
      font-display: swap;
    }

    @font-face {
      font-family: 'Helvetica Neue';
      src: url('fonts/Helvetica-Neue/Helvetica-Neue_700/HelveticaNeue-Bold.ttf'),
        url('fonts/Helvetica-Neue/Helvetica-Neue_700/HelveticaNeue-Bold.woff'),
        url('fonts/Helvetica-Neue/Helvetica-Neue_700/HelveticaNeue-Bold.woff2');
      font-weight: 700;
      font-style: normal;
      font-display: swap;
    }

    .nice-select.user-gender-field:after,
    .nice-select.model-gender-field:after,
    .nice-select.shoot-adapdations-field:after,
    .nice-select.form-type-selector:after {
        background-image: url('assets-images/Desktop-Assets/your orders/Arrow.svg');
        content: "";
    }

  </style>

</head>

<body>
  <div class="wrapper dashboard-wrapper-group">

    <!-- Main Sidebar Container -->
    <div class="fixed-sidebar">
      <div class="sidebar-wrapper">
        <div class="sidebar-close">
          <img src="assets-images\Desktop-Assets\settings\close.svg" alt="Close">
        </div>
        <div class="user-login-side">
          <div class="user-login-info">
            <div class="user-pr-img login-info" id="userPhoto">
              <div class="" style="background-image: url('assets-images/Desktop-Assets/user-pr-photo.png');"></div>
            </div>
            <div class="user-pr-id login-info" id="userId">
              <h6>ID: COM002345</h6>
            </div>
          </div>
          <!-- <div class="notification-bell">
            <span class="bell-drop">
              <img src="assets-images\Desktop-Assets\main-dashboard_Icons\notification.svg" class="bell-normal" alt="Notification Bell">
              <img src="assets-images\Desktop-Assets\main-dashboard_Icons\notification-active.svg" class="bell-active" alt="Notification Bell">
              <i id="notify-count">6</i>
            </span>
            <div class="notification-dropdown">
              <div class="notification-inner">
                <div class="notification-header">
                  <div class="notification-title">
                    <h6>Notifications</h6>
                  </div>
                  <div class="read-mark-link">
                    <a href="#" id="markReadlink">
                      <img src="assets-images\Desktop-Assets\dashboard home\markread.svg" alt="Read">
                      <span>Mark as read</span>
                    </a>
                  </div>
                </div>
                <div class="notification-body">
                  <div class="notification-item noread-notification-item">
                    <div class="notify-item-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" viewBox="0 0 14 14">
                        <defs>
                          <clipPath id="clip-path">
                            <rect id="Rectangle_2689" data-name="Rectangle 2689" width="14" height="14" transform="translate(0.285 0.285)" fill="#fff"/>
                          </clipPath>
                        </defs>
                        <g id="Mask_Group_74" data-name="Mask Group 74" transform="translate(-0.285 -0.285)" clip-path="url(#clip-path)">
                          <path id="send" d="M13.682.823a.56.56,0,0,0-.595-.077L1.543,6.165V7.213L6.392,9.153,9.5,13.937h1.049L13.864,1.394a.56.56,0,0,0-.182-.571ZM9.9,12.937,7.23,8.825l4.113-4.506-.651-.594L6.547,8.265l-4-1.6L12.835,1.838Z" transform="translate(-0.74 0.148)" fill="#fff"/>
                        </g>
                      </svg>                      
                    </div>
                    <div class="notify-item-details">
                      <p class="notify-alert" id="notifyalert">Your email has been changed</p>
                      <span class="notify-date" id="notifydate">10 MIN. AGO</span>
                    </div>
                    <div class="notify-close">
                      <a href="javascript:;" class="close-link-notify">
                        <img src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close">
                      </a>
                    </div>
                  </div>
                  <div class="notification-item noread-notification-item">
                    <div class="notify-item-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19.988" viewBox="0 0 20 19.988">
                        <path id="__TEMP__SVG__" d="M21.99,7.949a.96.96,0,0,0-.029-.214c-.007-.025-.021-.049-.03-.074a1.036,1.036,0,0,0-.07-.165.766.766,0,0,0-.057-.075.974.974,0,0,0-.1-.13c-.023-.022-.053-.04-.078-.061a.933.933,0,0,0-.12-.094s-.009,0-.014-.006l-.008-.006L12.5,2.136a1,1,0,0,0-.97,0l-9.02,4.99a.042.042,0,0,1-.011.01l-.01,0c-.035.02-.061.049-.094.073a1.068,1.068,0,0,0-.106.082.9.9,0,0,0-.079.1.888.888,0,0,0-.079.1.918.918,0,0,0-.059.139.654.654,0,0,0-.041.1.975.975,0,0,0-.029.21C2.005,7.965,2,7.98,2,8v8a1,1,0,0,0,.515.874l8.977,4.987h0l.02.011a1.022,1.022,0,0,0,.135.054.821.821,0,0,0,.1.039,1.013,1.013,0,0,0,.506,0,.984.984,0,0,0,.1-.039.938.938,0,0,0,.135-.054l.02-.011h0l8.977-4.987A1,1,0,0,0,22,16V8c0-.017-.006-.031-.007-.048ZM11.97,11.871,5.057,8,7.819,6.477l6.833,3.9-2.682,1.49Zm.048-7.719L18.939,8,16.695,9.246l-6.829-3.9,2.152-1.191ZM13,19.3l0-5.678,3-1.678V15l2-1V10.824l2-1.119v5.7L13,19.3Z" transform="translate(-1.999 -2.01)" fill="#7f7faa"></path>
                      </svg>
                    </div>
                    <div class="notify-item-details">
                      <p class="notify-alert" id="notifyalert">Your order has been placed</p>
                      <span class="notify-date" id="notifydate">FEB 04, 2022 AT 5:55 PM</span>
                      <a href="#" class="btn notify-btn" id="notifyBTN">
                        Track order
                      </a>
                    </div>
                    <div class="notify-close">
                      <a href="javascript:;" class="close-link-notify">
                        <img src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close">
                      </a>
                    </div>
                  </div>
                  <div class="notification-item">
                    <div class="notify-item-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19.988" viewBox="0 0 20 19.988">
                        <path id="__TEMP__SVG__" d="M21.99,7.949a.96.96,0,0,0-.029-.214c-.007-.025-.021-.049-.03-.074a1.036,1.036,0,0,0-.07-.165.766.766,0,0,0-.057-.075.974.974,0,0,0-.1-.13c-.023-.022-.053-.04-.078-.061a.933.933,0,0,0-.12-.094s-.009,0-.014-.006l-.008-.006L12.5,2.136a1,1,0,0,0-.97,0l-9.02,4.99a.042.042,0,0,1-.011.01l-.01,0c-.035.02-.061.049-.094.073a1.068,1.068,0,0,0-.106.082.9.9,0,0,0-.079.1.888.888,0,0,0-.079.1.918.918,0,0,0-.059.139.654.654,0,0,0-.041.1.975.975,0,0,0-.029.21C2.005,7.965,2,7.98,2,8v8a1,1,0,0,0,.515.874l8.977,4.987h0l.02.011a1.022,1.022,0,0,0,.135.054.821.821,0,0,0,.1.039,1.013,1.013,0,0,0,.506,0,.984.984,0,0,0,.1-.039.938.938,0,0,0,.135-.054l.02-.011h0l8.977-4.987A1,1,0,0,0,22,16V8c0-.017-.006-.031-.007-.048ZM11.97,11.871,5.057,8,7.819,6.477l6.833,3.9-2.682,1.49Zm.048-7.719L18.939,8,16.695,9.246l-6.829-3.9,2.152-1.191ZM13,19.3l0-5.678,3-1.678V15l2-1V10.824l2-1.119v5.7L13,19.3Z" transform="translate(-1.999 -2.01)" fill="#7f7faa"></path>
                      </svg>
                    </div>
                    <div class="notify-item-details">
                      <p class="notify-alert" id="notifyalert">Your order has been successfully completed</p>
                      <span class="notify-date" id="notifydate">JAN 15, 2022 AT 3:15 PM</span>
                      <a href="#" class="btn notify-btn" id="notifyBTN">
                        Write a review
                      </a>
                    </div>
                    <div class="notify-close">
                      <a href="javascript:;" class="close-link-notify">
                        <img src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close">
                      </a>
                    </div>
                  </div>
                  <div class="notification-item">
                    <div class="notify-item-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" viewBox="0 0 14 14">
                        <defs>
                          <clipPath id="clip-path">
                            <rect id="Rectangle_2689" data-name="Rectangle 2689" width="14" height="14" transform="translate(0.285 0.285)" fill="#fff"/>
                          </clipPath>
                        </defs>
                        <g id="Mask_Group_74" data-name="Mask Group 74" transform="translate(-0.285 -0.285)" clip-path="url(#clip-path)">
                          <path id="send" d="M13.682.823a.56.56,0,0,0-.595-.077L1.543,6.165V7.213L6.392,9.153,9.5,13.937h1.049L13.864,1.394a.56.56,0,0,0-.182-.571ZM9.9,12.937,7.23,8.825l4.113-4.506-.651-.594L6.547,8.265l-4-1.6L12.835,1.838Z" transform="translate(-0.74 0.148)" fill="#fff"/>
                        </g>
                      </svg>  
                    </div>
                    <div class="notify-item-details">
                      <p class="notify-alert" id="notifyalert">Your order was cancelled</p>
                      <span class="notify-date" id="notifydate">JAN 10, 2022 AT 4:17 PM</span>
                    </div>
                    <div class="notify-close">
                      <a href="javascript:;" class="close-link-notify">
                        <img src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close">
                      </a>
                    </div>
                  </div>
                </div>
                <div class="notification-footer">
                  <a href="#" class="all-notify-link" id="allnotifyLink">
                    See all notifications
                  </a>
                </div>
              </div>
            </div>
          </div> -->
        </div>
        <div class="sidebar-menu">
          <ul class="sidebar-menu-list">
            <li class="sidebar-menu-list-item active-menu">
              <a href="#" class="sidebar-menu-list-link">
                <span class="menu-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                    <path id="__TEMP__SVG__"
                      d="M4.444,14.444h6.667a1.111,1.111,0,0,0,1.111-1.111V4.444a1.111,1.111,0,0,0-1.111-1.111H4.444A1.111,1.111,0,0,0,3.333,4.444v8.889A1.111,1.111,0,0,0,4.444,14.444ZM3.333,22.222a1.111,1.111,0,0,0,1.111,1.111h6.667a1.111,1.111,0,0,0,1.111-1.111V17.778a1.111,1.111,0,0,0-1.111-1.111H4.444a1.111,1.111,0,0,0-1.111,1.111Zm11.111,0a1.111,1.111,0,0,0,1.111,1.111h6.667a1.111,1.111,0,0,0,1.111-1.111V14.444a1.111,1.111,0,0,0-1.111-1.111H15.556a1.111,1.111,0,0,0-1.111,1.111Zm1.111-11.111h6.667A1.111,1.111,0,0,0,23.333,10V4.444a1.111,1.111,0,0,0-1.111-1.111H15.556a1.111,1.111,0,0,0-1.111,1.111V10A1.111,1.111,0,0,0,15.556,11.111Z"
                      transform="translate(-3.333 -3.333)" fill="#7f7faa" />
                  </svg>
                </span>
                <span class="menu-text">
                  Dashboard
                </span>
              </a>
            </li>
            <li class="sidebar-menu-list-item">
              <a href="allorders.html" class="sidebar-menu-list-link">
                <span class="menu-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19.988" viewBox="0 0 20 19.988">
                    <path id="__TEMP__SVG__"
                      d="M21.99,7.949a.96.96,0,0,0-.029-.214c-.007-.025-.021-.049-.03-.074a1.036,1.036,0,0,0-.07-.165.766.766,0,0,0-.057-.075.974.974,0,0,0-.1-.13c-.023-.022-.053-.04-.078-.061a.933.933,0,0,0-.12-.094s-.009,0-.014-.006l-.008-.006L12.5,2.136a1,1,0,0,0-.97,0l-9.02,4.99a.042.042,0,0,1-.011.01l-.01,0c-.035.02-.061.049-.094.073a1.068,1.068,0,0,0-.106.082.9.9,0,0,0-.079.1.888.888,0,0,0-.079.1.918.918,0,0,0-.059.139.654.654,0,0,0-.041.1.975.975,0,0,0-.029.21C2.005,7.965,2,7.98,2,8v8a1,1,0,0,0,.515.874l8.977,4.987h0l.02.011a1.022,1.022,0,0,0,.135.054.821.821,0,0,0,.1.039,1.013,1.013,0,0,0,.506,0,.984.984,0,0,0,.1-.039.938.938,0,0,0,.135-.054l.02-.011h0l8.977-4.987A1,1,0,0,0,22,16V8c0-.017-.006-.031-.007-.048ZM11.97,11.871,5.057,8,7.819,6.477l6.833,3.9-2.682,1.49Zm.048-7.719L18.939,8,16.695,9.246l-6.829-3.9,2.152-1.191ZM13,19.3l0-5.678,3-1.678V15l2-1V10.824l2-1.119v5.7L13,19.3Z"
                      transform="translate(-1.999 -2.01)" fill="#7f7faa" />
                  </svg>
                </span>
                <span class="menu-text">
                  Your orders
                </span>
              </a>
            </li>
            <li class="sidebar-menu-list-item">
              <a href="brandguideline-listing.html" class="sidebar-menu-list-link">
                <span class="menu-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18.182" height="20" viewBox="0 0 18.182 20">
                    <g id="Group_5316" data-name="Group 5316" transform="translate(7674.091 4708)">
                      <path id="Path_2008" data-name="Path 2008"
                        d="M5.455,5.455a.909.909,0,0,1,.909-.909h9.091a.909.909,0,0,1,0,1.818H6.364A.909.909,0,0,1,5.455,5.455Z"
                        transform="translate(-7675.909 -4708.909)" fill="#7f7faa" />
                      <path id="Path_2009" data-name="Path 2009"
                        d="M5.455,9.091a.909.909,0,0,1,.909-.909h9.091a.909.909,0,0,1,0,1.818H6.364A.909.909,0,0,1,5.455,9.091Z"
                        transform="translate(-7675.909 -4708.909)" fill="#7f7faa" />
                      <path id="Path_2010" data-name="Path 2010"
                        d="M6.364,11.818a.909.909,0,0,0,0,1.818h9.091a.909.909,0,0,0,0-1.818Z"
                        transform="translate(-7675.909 -4708.909)" fill="#7f7faa" />
                      <path id="Path_2011" data-name="Path 2011"
                        d="M5.455,16.364a.909.909,0,0,1,.909-.909H10a.909.909,0,1,1,0,1.818H6.364A.909.909,0,0,1,5.455,16.364Z"
                        transform="translate(-7675.909 -4708.909)" fill="#7f7faa" />
                      <path id="Path_2012" data-name="Path 2012"
                        d="M1.818,3.636A2.727,2.727,0,0,1,4.545.909H17.273A2.727,2.727,0,0,1,20,3.636V18.182a2.727,2.727,0,0,1-2.727,2.727H4.545a2.727,2.727,0,0,1-2.727-2.727Zm2.727-.909H17.273a.909.909,0,0,1,.909.909V18.182a.909.909,0,0,1-.909.909H4.545a.909.909,0,0,1-.909-.909V3.636a.909.909,0,0,1,.909-.909Z"
                        transform="translate(-7675.909 -4708.909)" fill="#7f7faa" fill-rule="evenodd" />
                    </g>
                  </svg>
                </span>
                <span class="menu-text">
                  Brand guidelines
                </span>
              </a>
            </li>
            <li class="sidebar-menu-list-item">
              <a href="invoices-listing.html" class="sidebar-menu-list-link">
                <span class="menu-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20.5" height="20.5" viewBox="0 0 20.5 20.5">
                    <g id="Group_5315" data-name="Group 5315" transform="translate(7675.25 4638.25)">
                      <path id="Path_2081" data-name="Path 2081"
                        d="M20.447,4.977H15.918V1.383a.469.469,0,0,0-.468-.468H1.383a.469.469,0,0,0-.468.468V17.946a2.972,2.972,0,0,0,2.969,2.969H17.946a2.972,2.972,0,0,0,2.969-2.969V5.446A.469.469,0,0,0,20.447,4.977Zm-16.563,15a2.034,2.034,0,0,1-2.032-2.032V1.852H14.977V17.946a3.058,3.058,0,0,0,.806,2.032Zm16.094-2.032a2.032,2.032,0,1,1-4.064,0V5.912h4.063Z"
                        transform="translate(-7675.915 -4638.915)" fill="#7f7faa" stroke="#7f7faa" stroke-width="0.5" />
                      <path id="Path_2082" data-name="Path 2082"
                        d="M8.1,12.583a.469.469,0,0,0,.625,0c.119-.106,2.911-2.611,3.566-3.456a2.445,2.445,0,0,0,.421-2.092,2.786,2.786,0,0,0-1.568-1.859,2.522,2.522,0,0,0-2.729.582,2.519,2.519,0,0,0-2.729-.582A2.784,2.784,0,0,0,4.116,7.035a2.441,2.441,0,0,0,.421,2.092C5.189,9.972,7.983,12.477,8.1,12.583ZM5.025,7.259a1.855,1.855,0,0,1,1.05-1.231,1.206,1.206,0,0,1,.508-.116,2.241,2.241,0,0,1,1.47.8.488.488,0,0,0,.728,0c.009-.013.964-1.156,1.977-.69A1.853,1.853,0,0,1,11.8,7.259a1.51,1.51,0,0,1-.252,1.292A42.77,42.77,0,0,1,8.416,11.6,42.73,42.73,0,0,1,5.276,8.55a1.514,1.514,0,0,1-.25-1.292Z"
                        transform="translate(-7675.915 -4638.915)" fill="#7f7faa" stroke="#7f7faa" stroke-width="0.5" />
                      <path id="Path_2083" data-name="Path 2083"
                        d="M12.321,14.158H4.509a.468.468,0,0,0,0,.937h7.812a.468.468,0,1,0,0-.937Z"
                        transform="translate(-7675.915 -4638.915)" fill="#7f7faa" stroke="#7f7faa" stroke-width="0.5" />
                      <path id="Path_2084" data-name="Path 2084"
                        d="M12.321,16.549H4.509a.469.469,0,1,0,0,.938h7.812a.469.469,0,0,0,0-.938Z"
                        transform="translate(-7675.915 -4638.915)" fill="#7f7faa" stroke="#7f7faa" stroke-width="0.5" />
                    </g>
                  </svg>
                </span>
                <span class="menu-text">
                  Invoices
                </span>
              </a>
            </li>
            <li class="sidebar-menu-list-item">
              <a href="profile.html" class="sidebar-menu-list-link">
                <span class="menu-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" viewBox="0 0 16 20">
                    <path id="__TEMP__SVG__"
                      d="M5,20H19a1,1,0,0,1,0,2H5a1,1,0,0,1,0-2ZM4,15,14,5l3,3L7,18H4ZM15,4l2-2,3,3L18,7Z"
                      transform="translate(-4 -2)" fill="#7f7faa" fill-rule="evenodd" />
                  </svg>
                </span>
                <span class="menu-text">
                  Your profile
                </span>
              </a>
            </li>
            <li class="sidebar-menu-list-item">
              <a href="settings.html" class="sidebar-menu-list-link">
                <span class="menu-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="19.98" height="20" viewBox="0 0 19.98 20">
                    <path id="__TEMP__SVG__"
                      d="M21.713,10.48,19.48,9.813a7.766,7.766,0,0,0-.633-1.553L19.94,6.213a.407.407,0,0,0-.073-.48l-1.593-1.6a.407.407,0,0,0-.48-.073L15.76,5.147a7.747,7.747,0,0,0-1.573-.667L13.52,2.273A.407.407,0,0,0,13.127,2H10.873a.407.407,0,0,0-.387.287l-.667,2.2a7.753,7.753,0,0,0-1.587.667l-2-1.08a.407.407,0,0,0-.48.073l-1.62,1.58a.407.407,0,0,0-.073.48l1.08,2a7.753,7.753,0,0,0-.667,1.58l-2.207.667a.407.407,0,0,0-.287.387v2.253a.407.407,0,0,0,.287.387l2.22.667A7.747,7.747,0,0,0,5.153,15.7L4.06,17.793a.407.407,0,0,0,.073.48l1.593,1.593a.407.407,0,0,0,.48.073l2.06-1.1a7.767,7.767,0,0,0,1.533.627l.667,2.247a.407.407,0,0,0,.387.287h2.253a.407.407,0,0,0,.387-.287l.667-2.253a7.753,7.753,0,0,0,1.52-.627l2.073,1.107a.407.407,0,0,0,.48-.073l1.593-1.593a.407.407,0,0,0,.073-.48l-1.107-2.067a7.753,7.753,0,0,0,.633-1.527l2.247-.667a.407.407,0,0,0,.287-.387V10.873a.407.407,0,0,0-.247-.393ZM12,15.667A3.667,3.667,0,1,1,15.667,12,3.667,3.667,0,0,1,12,15.667Z"
                      transform="translate(-1.98 -2)" fill="#7f7faa" />
                  </svg>
                </span>
                <span class="menu-text">
                  Settings
                </span>
              </a>
            </li>
            <li class="sidebar-menu-list-item">
              <a href="#" class="sidebar-menu-list-link red-clr">
                <span class="menu-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18.461" height="20" viewBox="0 0 18.461 20">
                    <path id="__TEMP__SVG__"
                      d="M18.462,10.769a8.979,8.979,0,0,1-.733,3.582,9.121,9.121,0,0,1-4.916,4.916,9.113,9.113,0,0,1-7.163,0A9.121,9.121,0,0,1,.734,14.351,8.986,8.986,0,0,1,0,10.769,9.143,9.143,0,0,1,3.69,3.4a1.52,1.52,0,0,1,1.148-.3,1.418,1.418,0,0,1,1,.6,1.463,1.463,0,0,1,.294,1.136,1.5,1.5,0,0,1-.594,1.016A6.14,6.14,0,0,0,3.72,8.029a6.127,6.127,0,0,0-.157,5.126,6.1,6.1,0,0,0,3.282,3.281,6.087,6.087,0,0,0,4.771,0A6.1,6.1,0,0,0,14.9,13.155a6.129,6.129,0,0,0-.156-5.126,6.133,6.133,0,0,0-1.821-2.176,1.5,1.5,0,0,1-.595-1.016A1.464,1.464,0,0,1,12.62,3.7a1.426,1.426,0,0,1,1.009-.6,1.49,1.49,0,0,1,1.142.3,9.143,9.143,0,0,1,3.69,7.368ZM10.769,1.538V9.231a1.53,1.53,0,0,1-2.62,1.082,1.478,1.478,0,0,1-.457-1.082V1.538A1.478,1.478,0,0,1,8.149.457a1.509,1.509,0,0,1,2.163,0A1.478,1.478,0,0,1,10.769,1.538Z"
                      fill="#ff6961" />
                  </svg>
                </span>
                <span class="menu-text">
                  Sign out
                </span>
              </a>
            </li>
          </ul>
        </div>
        <div class="sidebar-contact-btn">
          <a href="#" class="btn contact-btn-side" id="sidecntBTn">
            <span>Contact us</span>
          </a>
        </div>
      </div>
    </div>

    <!-- End of Main Sidebar Container -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper dashboard-content-wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light custom-dashboard-header">
        <!-- Left navbar links -->
        <div class="navbar-nav">
          <div class="dash-mobile-trigger">
            <img src="assets-images\Mob-Assets\images\line_img.png" alt="Mobile Trigger">
          </div>
          <div class="welcome-user-title">
            <h4>Hello, Kishanramchari shrikant</h4>
            <p>Welcome back!</p>
            <!-- Notification HTML -->
            <div class="notification-bell">
              <span class="bell-drop">
                <img src="assets-images\Desktop-Assets\main-dashboard_Icons\notification.svg" class="bell-normal" alt="Notification Bell">
                <img src="assets-images\Desktop-Assets\main-dashboard_Icons\notification-active.svg" class="bell-active" alt="Notification Bell">
                <i id="notify-count">6</i>
              </span>
              <div class="notification-dropdown">
                <div class="notification-inner">
                  <div class="notification-header">
                    <div class="notification-title">
                      <h6>Notifications</h6>
                    </div>
                    <div class="read-mark-link">
                      <a href="#" id="markReadlink">
                        <img src="assets-images\Desktop-Assets\dashboard home\markread.svg" alt="Read">
                        <span>Mark as read</span>
                      </a>
                    </div>
                  </div>
                  <div class="notification-body">
                    <div class="notification-item noread-notification-item">
                      <div class="notify-item-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" viewBox="0 0 14 14">
                          <defs>
                            <clipPath id="clip-path">
                              <rect id="Rectangle_2689" data-name="Rectangle 2689" width="14" height="14" transform="translate(0.285 0.285)" fill="#fff"/>
                            </clipPath>
                          </defs>
                          <g id="Mask_Group_74" data-name="Mask Group 74" transform="translate(-0.285 -0.285)" clip-path="url(#clip-path)">
                            <path id="send" d="M13.682.823a.56.56,0,0,0-.595-.077L1.543,6.165V7.213L6.392,9.153,9.5,13.937h1.049L13.864,1.394a.56.56,0,0,0-.182-.571ZM9.9,12.937,7.23,8.825l4.113-4.506-.651-.594L6.547,8.265l-4-1.6L12.835,1.838Z" transform="translate(-0.74 0.148)" fill="#fff"/>
                          </g>
                        </svg>                      
                      </div>
                      <div class="notify-item-details">
                        <p class="notify-alert" id="notifyalert">Your email has been changed</p>
                        <span class="notify-date" id="notifydate">10 MIN. AGO</span>
                      </div>
                      <div class="notify-close">
                        <a href="javascript:;" class="close-link-notify">
                          <img src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close">
                        </a>
                      </div>
                    </div>
                    <div class="notification-item noread-notification-item">
                      <div class="notify-item-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19.988" viewBox="0 0 20 19.988">
                          <path id="__TEMP__SVG__" d="M21.99,7.949a.96.96,0,0,0-.029-.214c-.007-.025-.021-.049-.03-.074a1.036,1.036,0,0,0-.07-.165.766.766,0,0,0-.057-.075.974.974,0,0,0-.1-.13c-.023-.022-.053-.04-.078-.061a.933.933,0,0,0-.12-.094s-.009,0-.014-.006l-.008-.006L12.5,2.136a1,1,0,0,0-.97,0l-9.02,4.99a.042.042,0,0,1-.011.01l-.01,0c-.035.02-.061.049-.094.073a1.068,1.068,0,0,0-.106.082.9.9,0,0,0-.079.1.888.888,0,0,0-.079.1.918.918,0,0,0-.059.139.654.654,0,0,0-.041.1.975.975,0,0,0-.029.21C2.005,7.965,2,7.98,2,8v8a1,1,0,0,0,.515.874l8.977,4.987h0l.02.011a1.022,1.022,0,0,0,.135.054.821.821,0,0,0,.1.039,1.013,1.013,0,0,0,.506,0,.984.984,0,0,0,.1-.039.938.938,0,0,0,.135-.054l.02-.011h0l8.977-4.987A1,1,0,0,0,22,16V8c0-.017-.006-.031-.007-.048ZM11.97,11.871,5.057,8,7.819,6.477l6.833,3.9-2.682,1.49Zm.048-7.719L18.939,8,16.695,9.246l-6.829-3.9,2.152-1.191ZM13,19.3l0-5.678,3-1.678V15l2-1V10.824l2-1.119v5.7L13,19.3Z" transform="translate(-1.999 -2.01)" fill="#7f7faa"></path>
                        </svg>
                      </div>
                      <div class="notify-item-details">
                        <p class="notify-alert" id="notifyalert">Your order has been placed</p>
                        <span class="notify-date" id="notifydate">FEB 04, 2022 AT 5:55 PM</span>
                        <a href="#" class="btn notify-btn" id="notifyBTN">
                          Track order
                        </a>
                      </div>
                      <div class="notify-close">
                        <a href="javascript:;" class="close-link-notify">
                          <img src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close">
                        </a>
                      </div>
                    </div>
                    <div class="notification-item">
                      <div class="notify-item-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19.988" viewBox="0 0 20 19.988">
                          <path id="__TEMP__SVG__" d="M21.99,7.949a.96.96,0,0,0-.029-.214c-.007-.025-.021-.049-.03-.074a1.036,1.036,0,0,0-.07-.165.766.766,0,0,0-.057-.075.974.974,0,0,0-.1-.13c-.023-.022-.053-.04-.078-.061a.933.933,0,0,0-.12-.094s-.009,0-.014-.006l-.008-.006L12.5,2.136a1,1,0,0,0-.97,0l-9.02,4.99a.042.042,0,0,1-.011.01l-.01,0c-.035.02-.061.049-.094.073a1.068,1.068,0,0,0-.106.082.9.9,0,0,0-.079.1.888.888,0,0,0-.079.1.918.918,0,0,0-.059.139.654.654,0,0,0-.041.1.975.975,0,0,0-.029.21C2.005,7.965,2,7.98,2,8v8a1,1,0,0,0,.515.874l8.977,4.987h0l.02.011a1.022,1.022,0,0,0,.135.054.821.821,0,0,0,.1.039,1.013,1.013,0,0,0,.506,0,.984.984,0,0,0,.1-.039.938.938,0,0,0,.135-.054l.02-.011h0l8.977-4.987A1,1,0,0,0,22,16V8c0-.017-.006-.031-.007-.048ZM11.97,11.871,5.057,8,7.819,6.477l6.833,3.9-2.682,1.49Zm.048-7.719L18.939,8,16.695,9.246l-6.829-3.9,2.152-1.191ZM13,19.3l0-5.678,3-1.678V15l2-1V10.824l2-1.119v5.7L13,19.3Z" transform="translate(-1.999 -2.01)" fill="#7f7faa"></path>
                        </svg>
                      </div>
                      <div class="notify-item-details">
                        <p class="notify-alert" id="notifyalert">Your order has been successfully completed</p>
                        <span class="notify-date" id="notifydate">JAN 15, 2022 AT 3:15 PM</span>
                        <a href="#" class="btn notify-btn" id="notifyBTN">
                          Write a review
                        </a>
                      </div>
                      <div class="notify-close">
                        <a href="javascript:;" class="close-link-notify">
                          <img src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close">
                        </a>
                      </div>
                    </div>
                    <div class="notification-item">
                      <div class="notify-item-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" viewBox="0 0 14 14">
                          <defs>
                            <clipPath id="clip-path">
                              <rect id="Rectangle_2689" data-name="Rectangle 2689" width="14" height="14" transform="translate(0.285 0.285)" fill="#fff"/>
                            </clipPath>
                          </defs>
                          <g id="Mask_Group_74" data-name="Mask Group 74" transform="translate(-0.285 -0.285)" clip-path="url(#clip-path)">
                            <path id="send" d="M13.682.823a.56.56,0,0,0-.595-.077L1.543,6.165V7.213L6.392,9.153,9.5,13.937h1.049L13.864,1.394a.56.56,0,0,0-.182-.571ZM9.9,12.937,7.23,8.825l4.113-4.506-.651-.594L6.547,8.265l-4-1.6L12.835,1.838Z" transform="translate(-0.74 0.148)" fill="#fff"/>
                          </g>
                        </svg>  
                      </div>
                      <div class="notify-item-details">
                        <p class="notify-alert" id="notifyalert">Your order was cancelled</p>
                        <span class="notify-date" id="notifydate">JAN 10, 2022 AT 4:17 PM</span>
                      </div>
                      <div class="notify-close">
                        <a href="javascript:;" class="close-link-notify">
                          <img src="assets-images\Desktop-Assets\dashboard home\notification-close.svg" alt="Close">
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="notification-footer">
                    <a href="allnotification.html" class="all-notify-link" id="allnotifyLink">
                      See all notifications
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <!-- End of Notification HTML -->
          </div>
        </div>

        <!-- Right navbar links -->
        <ul class="navbar-nav ms-auto">
          <!-- Navbar Search -->
          <li class="nav-item header-nav-item">
            <div class="mobile-search-toggle">
              <img src="assets-images\Desktop-Assets\dashboard home\search.svg" alt="Mobile Search">
            </div>
            <div class="navbar-search-block">
              <form class="form-inline" action="" method="POST">
                <div class="form-group">
                  <span class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18"
                      height="18" viewBox="0 0 18 18">
                      <defs>
                        <clipPath id="a">
                          <rect width="18" height="18" transform="translate(1366.425)" fill="#7f7faa" />
                        </clipPath>
                      </defs>
                      <g transform="translate(-1366.425)" clip-path="url(#a)">
                        <g transform="translate(1367.306 0.882)">
                          <path
                            d="M9.7,1.763A7.936,7.936,0,1,1,1.763,9.7,7.945,7.945,0,0,1,9.7,1.763Zm0,14.108A6.172,6.172,0,1,0,3.527,9.7,6.179,6.179,0,0,0,9.7,15.871Z"
                            transform="translate(-2.645 -2.645)" fill="#7f7fa7" />
                          <path
                            d="M18.517,19.4a.879.879,0,0,1-.623-.258L14.057,15.3A.882.882,0,1,1,15.3,14.057l3.836,3.836a.882.882,0,0,1-.623,1.505Z"
                            transform="translate(-2.645 -2.645)" fill="#7f7fa7" />
                        </g>
                      </g>
                    </svg>
                  </span>
                  <input type="search" placeholder="Search" aria-label="Search" class="formInput header-search-input"
                    name="searchInput" id="searchInput">
                </div>
              </form>
            </div>
          </li>

        </ul>
      </nav>
      <!-- /.navbar -->
      <!-- Main content -->
      <div class="content custom-dashboard-content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row dashboard-template-row home-template-row1">
            <div class="col-lg-12 col-12">
              <div class="card dashboard-content-card order-summary-card">
                <div class="card-inner">
                  <div class="order-summary-details whitebg-order-summary">
                    <div class="row">
                      <div class="col-xl-9 col-12">
                        <div class="dash-action-name order-name">
                          <span class="action-icon order-icn">
                            <img src="assets-images\Desktop-Assets\dashboard home\order-icon-for-card.svg"
                              alt="Order icon">
                          </span>
                          <span class="action-text order-nm" id="orderName">
                            Winter collection 2022 - Topwear
                          </span>
                        </div>
                        <div class="order-info">
                          <div class="row">
                            <div class="col-lg-auto col-6">
                              <div class="info-tile">
                                <p>Order id:</p>
                                <h6 id="orderId">shoot-2356780a</h6>
                              </div>
                            </div>
                            <div class="col-lg-auto col-6">
                              <div class="info-tile">
                                <p>Lot no:</p>
                                <h6 id="lotNo">ODNVJ0012</h6>
                              </div>
                            </div>
                            <div class="col-lg-auto col-6">
                              <div class="info-tile">
                                <p>WRC:</p>
                                <h6 id="wrcNo">WRC12309L</h6>
                              </div>
                            </div>
                            <div class="col-lg-auto col-6">
                              <div class="info-tile">
                                <p>Total SKU:</p>
                                <h6 id="totalSKU">80</h6>
                              </div>
                            </div>
                            <div class="col-lg-auto col-6">
                              <div class="info-tile">
                                <p>Order placed on:</p>
                                <h6 id="orderDate">14/01/2022</h6>
                              </div>
                            </div>
                            <div class="col-lg-auto col-6">
                              <div class="info-tile">
                                <p>Expected delivery:</p>
                                <h6 id="deliveryDate">21/01/2022</h6>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-3 col-12">
                        <div class="order-sum-btns">
                          <a href="#" class="btn btn-dark inward-sheet-btn" id="inwardSheet">
                            Inward Sheet
                          </a>
                          <a href="allorders.html" class="btn btn-transparent view-order-btn" id="viewOrder">
                            View Order
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="order-timeline-details greenbg-order-summary">
                    <div class="row">
                      <div class="col-xl-9 col-12">
                        <div class="status-text">
                          Order status:
                        </div>
                        <div class="order-timeline">
                          <ul>
                            <li class="active-status">
                              <span class="status-tag" id="orderPlaced">
                                Order Placed
                              </span>
                            </li>
                            <li>
                              <span class="status-tag" id="physicalInward">
                                Physical Inward
                              </span>
                            </li>
                            <li>
                              <span class="status-tag" id="boothing">
                                Boothing
                              </span>
                            </li>
                            <li>
                              <span class="status-tag" id="imageEditing">
                                Image Editing
                              </span>
                            </li>
                            <li>
                              <span class="status-tag" id="qualityCheck">
                                Quality Check
                              </span>
                            </li>
                            <li>
                              <span class="status-tag" id="shootSubmission">
                                Shoot Submission
                              </span>
                            </li>
                            <li>
                              <span class="status-tag" id="physicalOutbound">
                                Physical OutBound
                              </span>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-xl-3 col-12">
                        <div class="track-order-wrapper">
                          <a href="track-order.html" class="btn track-order-btn" id="trackBtn">
                            Track Order
                          </a>
                          <a href="faq.html" class="need-help-link">
                            Need Help?
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row dashboard-template-row home-template-row2">
            <div class="col-xl-7 col-lg-6 col-12">
              <div class="card dashboard-content-card brand-guideline-card">
                <div class="card-inner">
                  <div class="dash-action-name guideline-name">
                    <span class="action-icon guideline-icn">
                      <img src="assets-images\Desktop-Assets\dashboard home\brand-guidlines-icon-for-card.svg"
                        alt="Guideline icon">
                    </span>
                    <span class="action-text guideline-nm" id="guidelineName">
                      Brand guidelines
                    </span>
                  </div>
                  <div class="guideline-count">
                    <h4 id="guideline-num">05</h4>
                    <a href="brandguideline-listing.html" class="btn viewallguide-btn" id="viewallguideBtn">View All</a>
                  </div>
                </div>
              </div>
              <div class="card dashboard-content-card review-rate-card">
                <div class="card-inner">
                  <div class="dash-action-name rating-name">
                    <span class="action-icon rating-icn">
                      <img src="assets-images\Desktop-Assets\dashboard home\love.svg" alt="Love icon">
                    </span>
                    <span class="action-text rating-nm" id="ratingName">
                      Hey! Shower your love!
                      <p>Your love keeps us motivated & also provides us the data where we need improvement.</p>
                    </span>
                  </div>
                  <div class="review-action">
                    <div class="review-btn-wrapper order-2 order-xl-0">
                      <a href="review-rating.html" class="btn write-review-btn" id="writeReview">
                        <img src="assets-images\Desktop-Assets\dashboard home\pen.png" alt="Review Pen">
                        Write a review
                      </a>
                    </div>
                    <div class="order-review order-1 order-xl-0">
                      <div class="order-tag">
                        <span>Order Id:</span>
                        <span style="font-weight: 500;">Shoot-2356780a</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-5 col-lg-6 col-12">
              <div class="tt-internal">
                <h6>Your journey so far…</h6>
              </div>
              <div class="card dashboard-content-card image-count-shoot-card">
                <div class="card-inner">
                  <div class="small-card-content order-img-count">
                    <div class="action-icon camera-icon">
                      <img src="assets-images\Desktop-Assets\dashboard home\camera-icon-for-card.svg" alt="Camera Icon">
                    </div>
                    <div class="action-text">
                      <h4 id="img-num">980</h4>
                      <p>Images shots</p>
                    </div>
                  </div>
                  <div class="msg-info">
                    <p>
                      Thank you! for sticking with us. <a href="#">Keep ordering!</a> ✌️
                    </p>
                  </div>
                </div>
              </div>
              <div class="card dashboard-content-card delivery-time-card">
                <div class="card-inner">
                  <div class="small-card-content delivery-date-count">
                    <div class="action-icon delivery-icon">
                      <img src="assets-images\Desktop-Assets\dashboard home\delivery-time-icon-for-card.svg"
                        alt="Delivery Icon">
                    </div>
                    <div class="action-text">
                      <h4 id="delivey-num">49 days</h4>
                      <p>Total delivery time</p>
                    </div>
                  </div>
                  <div class="msg-info">
                    <p>
                      Your images are delivered <a href="#">+50% faster</a> than what the usual marketplace takes. 🚀
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row dashboard-template-row home-template-row3">
            <div class="col-12">
              <div class="card dashboard-content-card new-order-book-now-card">
                <div class="card-inner">
                  <div class="row">
                    <div class="col-xl-9 col-12">
                      <div class="new-order-book-info">
                        <div class="new-book-assets cam-img">
                          <img src="assets-images\Desktop-Assets\dashboard home\camera-shoot-now.png" alt="Camera">
                        </div>
                        <div class="new-book-assets book-infor">
                          <h3>Book a new shoot</h3>
                          <p>The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog. Junk MTV
                            quiz graced by fox whelps. Bawds jog</p>
                          <div class="new-order-book-btn-wrapper d-block d-xl-none">
                            <a href="#" class="btn new-order-book-btn" id="newOrderBtn">BOOK NOW</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-12 d-none d-xl-block">
                      <div class="new-order-book-btn-wrapper d-none d-xl-block">
                        <a href="#" class="btn new-order-book-btn" id="newOrderBtn">BOOK NOW</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- ./wrapper -->



  <script src="plugins/bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>
  <script src="plugins/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>

  <script type="text/javascript" src="plugins\jquery\jquery.min.js"></script>

  <script type="text/javascript" src="plugins\jquery-nice-select-1.1.0\js\jquery.nice-select.js"></script>

  <!-- Common Js -->
  <script src="dist\js\common_js.js"></script>

</body>

</html>