@extends('layouts.admin') @section('title') Profile @endsection @section('content')

<head>
    <title>Profile Page With Edit</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<style type="text/css">
    .bg-c-lite-green {
        background: -webkit-gradient(linear, left top, right top, from(#f29263), to(#ee5a6f));
        background: linear-gradient(to right, yellow, #f29263);
    }
   
    .bg-color {
        background: #ccc;
        position: relative;
        top:6px;
    }
   
    .bg-color.Inworded {
        background:#FFFF00;
    }
    .bg-color.Inwording.Completed {
        background:#FF8000;
    }
    .bg-color.Ready.For.Shoot {
        background:#606060;
    }
    .bg-color.Shoot.Done {
        background:#4C0099;
    }
    .bg-color.Ready.For.QC {
        background:#000000;
    }
    .bg-color.Ready.For.Submission {
        background:#0066CC;
    }
    .bg-color.Approved {
        background:#00CC00;
    }
    .bg-color.Rejected {
        background:#FF0000;
    }
   
    select{background:#ffffff}
   
    .pp-btns {
        display: inline-block;
        vertical-align: middle;
        -webkit-transform: perspective(1px) translateZ(0);
        transform: perspective(1px) translateZ(0);
        box-shadow: 0 0 1px rgb(0 0 0 / 0%);
        position: relative;
        -webkit-transition-property: color;
        transition-property: color;
        -webkit-transition-duration: 0.5s;
        transition-duration: 0.5s;
        background: #fff !important;
        border-radius: 0 !important;
        color: #000 !important;
    }
   
    .pp-btns:before {
        content: "";
        position: absolute;
        z-index: -1;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #ffc107;
        -webkit-transform: scaleX(0);
        transform: scaleX(0);
        -webkit-transform-origin: 0 50%;
        transform-origin: 0 50%;
        -webkit-transition-property: transform;
        transition-property: transform;
        -webkit-transition-duration: 0.5s;
        transition-duration: 0.5s;
        -webkit-transition-timing-function: ease-out;
        transition-timing-function: ease-out;
    }
   
    .pp-btns:hover, .pp-btns:focus {
        color: #fff !important;
    }
   
    .pp-btns:hover:before, .pp-btns:focus:before {
        -webkit-transform: scaleX(1);
        transform: scaleX(1);
        -webkit-transition-timing-function: cubic-bezier(0.52, 1.64, 0.37, 0.66);
        transition-timing-function: cubic-bezier(0.52, 1.64, 0.37, 0.66);
    }
   
    .pr-content {
        display: none;
    }
   
    .user-profile-sec.pr-content {
        display: flex;
    }
   
    .pr-content.active {
        animation: scale-display 0.9s;
        display: flex;
    }
   
    .pr-content.outr {
        animation: scale-display 0.9s;
    }
   
    .user-profile-sec.active {
        display: none;
    }
   
    .pr-content.out {
        animation: scale-display--reversed 0.3s;
        animation-fill-mode: forwards;
        display: flex;
    }
   
    .user-order-summary .table td,
    .user-order-summary .table th {
        border: 0 !important;
    }
   
    .widget-user .widget-user-header {
        height: 220px;
    }
   
    .widget-user .widget-user-image>img {
        width: 155px;
    }
   
    .widget-user .widget-user-image {
        top: 130px;
        margin-left: -79px;
    }
   
    .widget-user .card-footer {
        padding-top: 80px;
    }
   
    .widget-user .widget-user-header {
        padding-top: 50px;
    }
   
    .widget-user .widget-user-image i {
        position: absolute;
        top: 110px;
        right: 4px;
        border-radius: 50%;
        height: 35px;
        width: 35px;
        display: flex !important;
        align-items: center;
        justify-content: center;
        color: #000;
        background-color: #fff;
        box-shadow: 0 0 0px 0px #b8b8b8;
        cursor: pointer;
        font-size: 20px;
        padding-left: 0px;
    }
   
    .file-upload {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        position: relative;
        cursor: pointer;
        overflow: hidden;
        width: 100%;
        max-width: 100%;
        height: 200px;
        padding: 5px 10px;
        font-size: 1rem;
        text-align: center;
        color: #ccc
    }
   
    .file-upload-wrapper .card.card-body.has-error .file-upload-message .file-upload-error,
    .file-upload-wrapper .card.card-body.has-preview .btn.btn-sm.btn-danger {
        display: block
    }
   
    .file-upload i {
        font-size: 3rem
    }
   
    .file-upload .mask.rgba-stylish-slight {
        opacity: 0;
        -webkit-transition: all .15s linear;
        -o-transition: all .15s linear;
        transition: all .15s linear
    }
   
    .file-upload:hover .mask.rgba-stylish-slight {
        opacity: .8
    }
   
    .file-upload-wrapper .card.card-body.has-error {
        border-color: #f34141
    }
   
    .file-upload-wrapper .card.card-body.has-error:hover .file-upload-errors-container {
        visibility: visible;
        opacity: 1;
        -webkit-transition-delay: 0s;
        -o-transition-delay: 0s;
        transition-delay: 0s
    }
   
    .file-upload-wrapper .card.card-body.disabled input {
        cursor: not-allowed
    }
   
    .file-upload-wrapper .card.card-body.disabled:hover {
        background-image: none;
        -webkit-animation: none;
        animation: none
    }
   
    .file-upload-wrapper .card.card-body.disabled .file-upload-message {
        opacity: .5;
        text-decoration: line-through
    }
   
    .file-upload-wrapper .card.card-body.disabled .file-upload-infos-message {
        display: none
    }
   
    .file-upload-wrapper .card.card-body input {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 5
    }
   
    .file-upload-wrapper .card.card-body .file-upload-message {
        position: relative;
        top: 50px;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%)
    }
   
    .file-upload-wrapper .card.card-body .file-upload-message span.file-icon {
        font-size: 50px;
        color: #ccc
    }
   
    .file-upload-wrapper .card.card-body .file-upload-message p {
        margin: 5px 0 0
    }
   
    .file-upload-wrapper .card.card-body .file-upload-message p.file-upload-error {
        color: #f34141;
        font-weight: 700;
        display: none
    }
   
    .file-upload-wrapper .card.card-body .btn.btn-sm.btn-danger {
        display: none;
        position: absolute;
        opacity: 0;
        z-index: 7;
        top: 10px;
        right: 10px;
        -webkit-transition: all .15s linear;
        -o-transition: all .15s linear;
        transition: all .15s linear
    }
   
    .file-upload-wrapper .card.card-body .file-upload-preview {
        display: none;
        position: absolute;
        z-index: 1;
        background-color: #fff;
        padding: 5px;
        width: 100%;
        height: 100%;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
        text-align: center
    }
   
    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-render .file-upload-preview-img {
        width: 100%;
        height: 100%;
        background-color: #fff;
        -webkit-transition: border-color .15s linear;
        -o-transition: border-color .15s linear;
        transition: border-color .15s linear;
        -o-object-fit: cover;
        object-fit: cover
    }
   
    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-render i {
        font-size: 80px;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        position: absolute;
        color: #777
    }
   
    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-render .file-upload-extension {
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        margin-top: 10px;
        text-transform: uppercase;
        font-weight: 900;
        letter-spacing: -.03em;
        font-size: 1rem;
        color: #fff;
        width: 42px;
        white-space: nowrap;
        overflow: hidden;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis
    }
   
    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-infos {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        background: rgba(0, 0, 0, .7);
        opacity: 0;
        -webkit-transition: opacity .15s linear;
        -o-transition: opacity .15s linear;
        transition: opacity .15s linear
    }
   
    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-infos .file-upload-infos-inner {
        position: absolute;
        top: 50%;
        -webkit-transform: translate(0, -40%);
        -ms-transform: translate(0, -40%);
        transform: translate(0, -40%);
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        width: 100%;
        padding: 0 20px;
        -webkit-transition: all .2s ease;
        -o-transition: all .2s ease;
        transition: all .2s ease
    }
   
    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-infos .file-upload-infos-inner p {
        padding: 0;
        margin: 0;
        position: relative;
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
        color: #fff;
        text-align: center;
        line-height: 25px;
        font-weight: 700
    }
   
    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-infos .file-upload-infos-inner p.file-upload-infos-message {
        margin-top: 15px;
        padding-top: 15px;
        font-size: 12px;
        position: relative;
        opacity: .5
    }
   
    .file-upload-wrapper .card.card-body .file-upload-preview .file-upload-infos .file-upload-infos-inner p.file-upload-infos-message::before {
        content: "";
        position: absolute;
        top: 0;
        left: 50%;
        -webkit-transform: translate(-50%, 0);
        -ms-transform: translate(-50%, 0);
        transform: translate(-50%, 0);
        background: #fff;
        width: 30px;
        height: 2px
    }
   
    .file-upload-wrapper .card.card-body:hover .btn.btn-sm.btn-danger,
    .file-upload-wrapper .card.card-body:hover .file-upload-preview .file-upload-infos {
        opacity: 1
    }
   
    .file-upload-wrapper .card.card-body:hover .file-upload-preview .file-upload-infos .file-upload-infos-inner {
        margin-top: -5px
    }
   
    .file-upload-wrapper .card.card-body.touch-fallback {
        height: auto !important
    }
   
    .file-upload-wrapper .card.card-body.touch-fallback:hover {
        background-image: none;
        -webkit-animation: none;
        animation: none
    }
   
    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview {
        position: relative;
        padding: 0
    }
   
    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-render {
        display: block;
        position: relative
    }
   
    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-infos .file-upload-infos-inner p.file-upload-infos-message::before,
    .file-upload-wrapper .card.card-body.touch-fallback.has-preview .file-upload-message {
        display: none
    }
   
    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-render .file-upload-font-file {
        position: relative;
        -webkit-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        transform: translate(0, 0);
        top: 0;
        left: 0
    }
   
    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-render .file-upload-font-file::before {
        margin-top: 30px;
        margin-bottom: 30px
    }
   
    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-render img {
        position: relative;
        -webkit-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        transform: translate(0, 0)
    }
   
    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-infos {
        position: relative;
        opacity: 1;
        background: 0 0
    }
   
    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-infos .file-upload-infos-inner {
        position: relative;
        top: 0;
        -webkit-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        transform: translate(0, 0);
        padding: 5px 90px 5px 0
    }
   
    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-infos .file-upload-infos-inner p {
        padding: 0;
        margin: 0;
        position: relative;
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
        color: #777;
        text-align: left;
        line-height: 25px
    }
   
    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-preview .file-upload-infos .file-upload-infos-inner p.file-upload-infos-message {
        margin-top: 0;
        padding-top: 0;
        font-size: 18px;
        position: relative;
        opacity: 1
    }
   
    .file-upload-wrapper .card.card-body.touch-fallback .file-upload-message {
        -webkit-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        transform: translate(0, 0);
        padding: 40px 0
    }
   
    .file-upload-wrapper .card.card-body.touch-fallback .btn.btn-sm.btn-danger {
        top: auto;
        bottom: 23px;
        opacity: 1
    }
   
    .file-upload-wrapper .card.card-body.touch-fallback:hover .file-upload-preview .file-upload-infos .file-upload-infos-inner {
        margin-top: 5rem
    }
   
    .file-upload-wrapper .card.card-body .file-upload-loader {
        position: absolute;
        top: 15px;
        right: 15px;
        display: none;
        z-index: 9
    }
   
    .file-upload-wrapper .card.card-body .file-upload-loader::after {
        display: block;
        position: relative;
        width: 20px;
        height: 20px;
        -webkit-animation: rotate .6s linear infinite;
        animation: rotate .6s linear infinite;
        -webkit-border-radius: 100%;
        border-radius: 100%;
        border-top: 1px solid #ccc;
        border-bottom: 1px solid #777;
        border-left: 1px solid #ccc;
        border-right: 1px solid #777;
        content: ""
    }
   
    .file-upload-wrapper .card.card-body .file-upload-errors-container {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        background: rgba(243, 65, 65, .8);
        text-align: left;
        visibility: hidden;
        opacity: 0;
        -webkit-transition: visibility 0s linear .15s, opacity .15s linear;
        -o-transition: visibility 0s linear .15s, opacity .15s linear;
        transition: visibility 0s linear .15s, opacity .15s linear
    }
   
    .file-upload-wrapper .card.card-body .file-upload-errors-container ul {
        padding: 10px 20px;
        margin: 0;
        position: absolute;
        left: 0;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%)
    }
   
    .file-upload-wrapper .card.card-body .file-upload-errors-container ul li {
        margin-left: 20px;
        color: #fff;
        font-weight: 700
    }
   
    .file-upload-wrapper .card.card-body .file-upload-errors-container.visible {
        visibility: visible;
        opacity: 1;
        -webkit-transition-delay: 0s;
        -o-transition-delay: 0s;
        transition-delay: 0s
    }
   
    .file-upload-wrapper .card.card-body~.file-upload-errors-container ul {
        padding: 0;
        margin: 15px 0
    }
   
    .file-upload-wrapper .card.card-body~.file-upload-errors-container ul li {
        margin-left: 20px;
        color: #f34141;
        font-weight: 700
    }
   
    input[type="checkbox"] {
        display: none;
    }
   
    #button {
        position: relative;
        display: block;
        width: 360px;
        height: 90px;
        background-color: #fff;
        border-radius: 370px;
        cursor: pointer;
        transform: scale(0.4);
        margin: 0px auto;
        /*  border: 1px solid #ffc107;*/
        background: rgba(232, 232, 232, 0.6);
    }
   
    #knob {
        width: 180px;
        height: 92px;
        background: yellow;
        background-size: 700px;
        position: relative;
        top: 0px;
        left: 0px;
        border-radius: 397px;
        transition: 0.4s ease left, 0.4s ease background-position;
        z-index: 2;
    }
   
    #subscribe, #alright {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: #000;
        font-size: 27px;
        font-weight: 300;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        margin-left: 215px;
        z-index: 3;
        height: 100%;
        display: flex;
        align-items: center;
    }
   
    #alright {
        margin-left: 40px;
        text-align: center;
    }
   
      /*#lol-checkbox:checked + #button #knob {
      left: 180px;
      background-position: -350px 0;
      }*/

      .bg-od #knob {
          left: 180px;
          background-position: -350px 0;
      }

      .widget-user-desc i {
          border-radius: 50%;
          height: 25px;
          width: 25px;
          display: inline-block !important;
          align-items: center;
          justify-content: center;
          color: #000;
          background-color: #fff;
          box-shadow: 0 0 0px 0px #b8b8b8;
          cursor: pointer;
          font-size: 15px;
          padding-left: 0px;
          line-height: 26px;
          vertical-align: top;
      }

      .widget-user .widget-user-username {
          font-size: 32px;
          margin-bottom: 8px;
      }

      #modal-lg .modal-content {
          border: 3px solid #ffc107 !important;
      }

      .recent-activities,
      .order-details {
          height: 100vh;
          overflow-y: auto;
          max-height: 574px;
      }

      .recent-activities .item {
          padding: 0 15px;
          /*border-bottom: 1px solid #eee;*/
      }

      .recent-activities .item div[class*='col-'] {
            padding: 10px;
      }

      .recent-activities .content {
        text-align: center;
      }

      .recent-activities h5 {
          font-weight: 400;
          color: #333;
          font-size: 1.3rem;
          text-transform: capitalize;
      }

      .recent-activities p {
          font-size: 0.75em;
          color: #d1cbcb;
      }

      .light-dsh-mode .recent-activities p {
        color: #141313;
      }

      .recent-activities .icon {
        width: 45px;
        height: 45px;
        line-height: 1;
        background: transparent;
        text-align: center;
        display: inline-block;
        vertical-align: middle;
      }

      .recent-activities .date {
          font-size: 0.75rem;
          color: #999;
          padding: 10px;
          text-align: right;
      }

      .recent-activities .date > span:not(.text-info) {
        font-size: 1rem;
     }

      .light-dsh-mode .recent-activities .date {
        color: #141313;
      }

      .recent-activities .date-holder {
        display: flex;
        justify-content: center;
        text-align: left !important;
        padding: 10px 0 0 0 !important;
      }

      .order-details p {
          font-size: 14px !important;
      }

      .recent-activities .icon i {
        padding-top: 10px;
        font-size: 1.8rem;
        color: yellow;
      }




    /*  .file-upload {
    background: #6c757d;
    box-shadow: none;
    }*/

    .card.card-transparent .profile-grp .card,
    .card.card-transparent .activities-grp .card {
        background-color: transparent;
    }

    .card.card-transparent .profile-grp .card h3, 
    .card.card-transparent .profile-grp .card h4, 
    .card.card-transparent .profile-grp .card h5 {
        color: #000;
    }

    .recent-activities .date span.text-info {
        color: yellow !important;
    }
   
    @keyframes scale-display {
      0% {
        opacity: 0;
        transform: scale(0);
        -webkit-transform: scale(0);
    }
    100% {
        opacity: 1;
        transform: scale(1);
        -webkit-transform: scale(1);
    }
}
@keyframes scale-display--reversed {
  0% {
    display: inline-flex;
    opacity: 1;
    transform: scale(1);
    -webkit-transform: scale(1);
}
99% {
    display: inline-flex;
    opacity: 0;
    transform: scale(0);
    -webkit-transform: scale(0);
}
100% {
    display: none;
    opacity: 0;
    transform: scale(0);
    -webkit-transform: scale(0);
}
}

@media (min-width: 768px) {
      /*        .profile-grp {
      height: 615px;
      }*/

      .profile-grp .widget-user .widget-user-header {
          border-top-right-radius: 0;
      }

      .user-profile {
          border-bottom-right-radius: 0;
      }

      .frm-prf {
          border-top-left-radius: 0;
      }
  }

  @media (max-width: 991px) and (min-width: 768px) {
     .recent-activities, .order-details {
        max-height: 700px;
        height: calc(100vh + 90px);
    } 
}

@media (min-width: 1200px) {
    .invoice-col .cc-details {
        font-size: 18px;
    }
}

@media (max-width: 414px) {
    .invoice-col {
        -ms-flex: 0 0 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
}

</style>

<body>
    <div class="container bootstrap snippet mt-5">
        <div class="row card card-transparent mb-5 m-0">
            <div class="col-sm-12 p-0">
                <div class="row d-flex clearfix">
                    <div class="col-xl-7 col-lg-6 col-md-6 mb-md-0 mb-4 pr-md-0 float-left profile-grp">
                        <div class="card p-0 bg-c-lite-green user-profile m-0 h-100">
                            <div class="card card-widget widget-user mb-0 bg-transparent shadow-none">
                                <div class="widget-user-header text-white" style="background: url('dist/img/photo1.png') center center;"></div>
                                <div class="widget-user-image">
                                    <img class="img-circle" src="dist/img/uploads/avatars/{{auth()->user()->photo}} " alt="{{ auth()->user()->name . ' photo' }}"> <i class="fa fa-camera" data-toggle="modal" data-target="#modal-default"></i>
                                </div>
                                <div class="card-footer bg-transparent text-black px-2">
                                    <h3 class="widget-user-username text-center">{{ auth()->user()->Company}}</h3>
                                    <h4 class="widget-user-desc text-center mb-3">
                                        <span>
                                          {{ auth()->user()->name }}
                                      </span>
                                      <i class="fas fa-pencil-alt mr-1" data-toggle="modal" data-target="#modal-lg"></i>
                                  </h4>
                                  <div class="row d-none">
                                    <div class="col-4 d-md-block d-block border-right" style="border-color: #212529 !important;">
                                        <div class="description-block">
                                            <h5 class="description-header">3,200</h5>
                                            <span class="description-text small">SALES</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <div class="col-sm-12 d-none d-md-none border-right-0">
                                        <div class="description-block">
                                            <h5 class="description-header">3,200</h5>
                                            <span class="description-text">SALES</span>
                                        </div>
                                    </div>
                                    <div class="col-4 d-md-block d-block border-right" style="border-color: #212529 !important;">
                                        <div class="description-block">
                                            <h5 class="description-header">13,000</h5>
                                            <span class="description-text small">FOLLOWERS</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <div class="col-sm-12 d-none d-md-none border-right-0">
                                        <div class="description-block">
                                            <h5 class="description-header">13,000</h5>
                                            <span class="description-text">FOLLOWERS</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <div class="col-4 d-md-block d-block">
                                        <div class="description-block">
                                            <h5 class="description-header">35</h5>
                                            <span class="description-text small">PRODUCTS</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <div class="col-sm-12 d-none d-md-none">
                                        <div class="description-block">
                                            <h5 class="description-header">35</h5>
                                            <span class="description-text">PRODUCTS</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                </div>
                                <div class="row invoice-info p-lg-3 p-md-1 pt-md-3 p-2">
                                    <div class="col-6 invoice-col">
                                        <div class="cc-details"> <span>
                                          <strong><i class="fas fa-envelope mr-1"></i></strong>
                                      </span>
                                      <span>
                                        {{ auth()->user()->email }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-6 invoice-col">
                                <div class="cc-details"> <span>
                                  <strong><i class="fas fa-phone-alt mr-1"></i></strong>
                              </span>
                              <span>
                                  {{ auth()->user()->phone}}
                              </span>
                          </div>
                      </div>
                      <!-- /.col -->
                      <div class="col-6 invoice-col">
                        <div class="cc-details mt-3"> <span>
                          <strong><i class="fas fa-user mr-1"></i></strong>
                      </span>
                      <span>
                          {{ auth()->user()->client_id }}
                      </span>
                  </div>
              </div>
              <div class="col-6 invoice-col">
                <div class="cc-details mt-3"> <span>
                  <strong>GST: </strong>
              </span>
              <span>
                  {{ auth()->user()->Gst_number }}
              </span>
          </div>
      </div>
      <!-- /.col -->
      <div class="col-6 invoice-col">
        <div class="cc-details mt-3"> <address class="mb-0">
            <i class="fas fa-home"></i>
          <strong>Address :</strong><br>
          {{ auth()->user()->Address }}
      </address>
  </div>
</div>
 <div class="col-6 invoice-col">
        <div class="cc-details mt-4 mt-md-4"> 
               <a class="btn btn-warning text-black" href="{{route('userGetpassword')}}">Change Password</a>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="col-xl-5 col-lg-6 col-md-6 pl-md-0 float-left activities-grp">
    <div class="card card-warning m-0 shadow-none frm-prf">
        <div class="card-header border-bottom-0 text-center mb-2 py-3">
            <input type="checkbox" id="lol-checkbox">
            <!-- <label id="button" class="switch-button" for="lol-checkbox">
                <div id="knob" class="knob-bg"></div>
                <div id="alright" class="pr-detls">Recent
                    <br>Activities</div>
                    <div id="subscribe" class="all-order">All Orders</div>
                </label> -->
                <h3 class="card-title float-none">All Activities</h3>
            </div>
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row user-profile-sec pr-content">
                            <div class="col-12">
                                <div class="recent-activities">
                                    @foreach($lastActivity as $activity)
                                    <div class="item">
                                        <div class="row">
                                            <div class="col-2 date-holder text-right">
                                                <div class="icon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                            </div>
                                            <div class="col-6 content">
                                                <h5>{{$activity->description}}</h5>
                                                <p>{{$activity->subject_type}}</p>
                                            </div>
                                            <div class="col-4 date-pr-wrapper">
                                                <div class="date">
                                                    <span>{{timeformat($activity->created_at)}}</span>
                                                    <br><span class="text-info">{{(new Carbon\Carbon($activity->created_at))->diffForHumans()}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row user-order-summary pr-content">
                            <div class="col-sm-12">
                                <div class="order-details card-body p-3 pt-4">
                                    <div class="row mb-5">
                                        <div class="col-12">
                                            <h6 class="mb-3 pb-4 border-bottom">
                                              <span class="text-bold d-inline-block">Lot Number :</span>
                                              <span class="d-inline-block">5678C</span>
                                          </h6>
                                      </div>
                                      <div class="col-6">
                                        <p class="mb-4"> <span class="d-inline-block">WRC Number :</span>
                                            <span class="text-bold d-inline-block">46F</span>
                                        </p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <p class="mb-4"> <span class="d-inline-block">Current Status :</span>
                                            <span class="text-bold d-inline-block">Approved</span>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p class="mb-4"> <span class="d-inline-block">Inwording Date :</span>
                                            <span class="text-bold d-inline-block">04/13/2021</span>
                                        </p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <p class="mb-4"> <span class="d-inline-block">Price :</span>
                                            <span class="text-bold d-inline-block">$ 98.99</span>
                                        </p>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="button" class="btn btn-xs btn-success float-right rounded-0">Pay Now</button>
                                        <button type="button" class="btn btn-xs btn-warning float-left mr-2 rounded-0">Track WRC</button>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-12">
                                        <h6 class="mb-3 pb-4 border-bottom">
                                          <span class="text-bold d-inline-block">Lot Number :</span>
                                          <span class="d-inline-block">5678C</span>
                                      </h6>
                                  </div>
                                  <div class="col-6">
                                    <p class="mb-4"> <span class="d-inline-block">WRC Number :</span>
                                        <span class="text-bold d-inline-block">46F</span>
                                    </p>
                                </div>
                                <div class="col-6 text-right">
                                    <p class="mb-4"> <span class="d-inline-block">Current Status :</span>
                                        <span class="text-bold d-inline-block">Approved</span>
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-4"> <span class="d-inline-block">Inwording Date :</span>
                                        <span class="text-bold d-inline-block">04/13/2021</span>
                                    </p>
                                </div>
                                <div class="col-6 text-right">
                                    <p class="mb-4"> <span class="d-inline-block">Price :</span>
                                        <span class="text-bold d-inline-block">$ 98.99</span>
                                    </p>
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="button" class="btn btn-xs btn-success float-right rounded-0">Pay Now</button>
                                    <button type="button" class="btn btn-xs btn-warning float-left mr-2 rounded-0">Track WRC</button>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-12">
                                    <h6 class="mb-3 pb-4 border-bottom">
                                      <span class="text-bold d-inline-block">Lot Number :</span>
                                      <span class="d-inline-block">5678C</span>
                                  </h6>
                              </div>
                              <div class="col-6">
                                <p class="mb-4"> <span class="d-inline-block">WRC Number :</span>
                                    <span class="text-bold d-inline-block">46F</span>
                                </p>
                            </div>
                            <div class="col-6 text-right">
                                <p class="mb-4"> <span class="d-inline-block">Current Status :</span>
                                    <span class="text-bold d-inline-block">Approved</span>
                                </p>
                            </div>
                            <div class="col-6">
                                <p class="mb-4"> <span class="d-inline-block">Inwording Date :</span>
                                    <span class="text-bold d-inline-block">04/13/2021</span>
                                </p>
                            </div>
                            <div class="col-6 text-right">
                                <p class="mb-4"> <span class="d-inline-block">Price :</span>
                                    <span class="text-bold d-inline-block">$ 98.99</span>
                                </p>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="button" class="btn btn-xs btn-success float-right rounded-0">Pay Now</button>
                                <button type="button" class="btn btn-xs btn-warning float-left mr-2 rounded-0">Track WRC</button>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-12">
                                <h6 class="mb-3 pb-4 border-bottom">
                                  <span class="text-bold d-inline-block">Lot Number :</span>
                                  <span class="d-inline-block">5678C</span>
                              </h6>
                          </div>
                          <div class="col-6">
                            <p class="mb-4"> <span class="d-inline-block">WRC Number :</span>
                                <span class="text-bold d-inline-block">46F</span>
                            </p>
                        </div>
                        <div class="col-6 text-right">
                            <p class="mb-4"> <span class="d-inline-block">Current Status :</span>
                                <span class="text-bold d-inline-block">Approved</span>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="mb-4"> <span class="d-inline-block">Inwording Date :</span>
                                <span class="text-bold d-inline-block">04/13/2021</span>
                            </p>
                        </div>
                        <div class="col-6 text-right">
                            <p class="mb-4"> <span class="d-inline-block">Price :</span>
                                <span class="text-bold d-inline-block">$ 98.99</span>
                            </p>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="button" class="btn btn-xs btn-success float-right rounded-0">Pay Now</button>
                            <button type="button" class="btn btn-xs btn-warning float-left mr-2 rounded-0">Track WRC</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
</div>
</div>
</div>
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
        <li><b>Please update your profile</b></li>
      </ul>
    </div>
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form enctype="multipart/form-data" method="POST" action="{{route('updateuserimage')}}">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title" >Upload Photo</h3>
                </div>
                <div class="modal-body">
                    <div class="file-upload-wrapper">
                        <input type="file" id="input-file-now" name="photo" class="file-upload" />
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning text-black">Upload</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{route('user.postProfile')}}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="required">First Name*</label>
                                <input class="form-control" type="text" id="firstname" value="{{ auth()->user()->name }}" name="name" placeholder="First Name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="required">Email</label>
                                <input class="form-control" type="email" id="email" name="email" value="{{ auth()->user()->email }}" placeholder="Email Address" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="required">Company Name</label>
                                <input class="form-control" type="text" id="companyname" name="Company" value="{{ auth()->user()->Company }}" placeholder="Company Name" readonlY>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="required">Client Id</label>
                                <input class="form-control" type="text" id="clientid" name="client_id" value="{{ auth()->user()->client_id }}" placeholder="Enter Your Id" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="required">Phone Number</label>
                                <input class="form-control" type="text" id="phoneno" name="phone" placeholder="Phone Number" value="{{ auth()->user()->phone }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="required" >GST Number</label>
                                <input class="form-control" type="text" id="gstno" name="Gst_number" value="{{ auth()->user()->Gst_number }}" placeholder="GST Number" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="required">Address</label>
                                <textarea class="form-control" rows="4" name="Address" value=" {{ auth()->user()->Address }}" placeholder="Address"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-warning btn-block mt-1">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script type="application/javascript" src="plugins/jquery/jquery.min.js"></script>
<script type="application/javascript" src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script type="application/javascript" src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script type="application/javascript" src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>


<script src="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/js/plugins/mdb-file-upload.min.js"></script>
<script>
    $(function () {
        bsCustomFileInput.init();
    });

          // $('#alright').on('click', function(e) {
          //    // $('.pr-content').show();
          //    $('.pr-content').removeClass('outr').addClass('active');
          // });

          // $('#subscribe').on('click', function(e) {
          //    $('.pr-content').addClass('outr').removeClass('active');
          // });

          $('.all-order').on('click', function(e) {
            $('.pr-content').removeClass('outr').addClass('active');
        });

          $('.pr-detls').on('click', function(e) {
            $('.pr-content').addClass('outr').removeClass('active');
        });

          $('.all-order').on('click', function(e) {
            $(this).parent('.switch-button').addClass('bg-od');
        });

          $('.pr-detls').on('click', function(e) {
            $(this).parent('.switch-button').removeClass('bg-od');
        });


          $('.file-upload').file_upload();
      </script>
    <!-- <script type="application/javascript">
var readURL = function(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function (e) {
$('.avatar').attr('src', e.target.result);
}

reader.readAsDataURL(input.files[0]);
}
}


$(".file-upload").on('change', function(){
readURL(this);
});

</script> -->
</body>@endsection