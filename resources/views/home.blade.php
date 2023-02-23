@extends('layouts.admin')
@section('title')
Dashboard
@endsection
@section('content')

   <!-- /.content-header -->

   <!-- Main content -->
   <section class="content">
     <div class="container-fluid">
       <!-- Small boxes (Stat box) -->
       <div class="row">
         <div class="col-lg-3 col-sm-6 col-12">
           <!-- small box -->
            <div class="info-box shadow-lg dm-info-box">
              <span class="info-box-icon bg-warning"><i class="far fa-user"></i></span>

              <div class="info-box-content">
                <h3>Onboard users</h3>
                <h1>{{$users}}</h1>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div> 
         <!-- ./col -->
         <div class="col-lg-3 col-sm-6 col-12">
           <!-- small box -->
            <div class="info-box shadow-lg dm-info-box">
              <span class="info-box-icon bg-warning"><i class="far fa-file"></i></span>
 <a href="https://connect.odndigital.com/daily-usage-report" > 
              <div class="info-box-content">
                <h3>Active LOTS</h3>
                <h1>{{$lots}}</h1>
              </div>
              </a>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
         <!-- ./col -->
         <div class="col-lg-3 col-sm-6 col-12">
           <!-- small box -->
            <div class="info-box shadow-lg dm-info-box">
              <span class="info-box-icon bg-warning"><i class="far fa-image"></i></span>
 <a href="https://connect.odndigital.com/daily-usage-report" > 
              <div class="info-box-content">
                <h3>SKUS</h3>
                <h1>{{$skus}}</h1>
              </div>
              </a>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
         <!-- ./col -->
         <div class="col-lg-3 col-sm-6 col-12">
           <!-- small box -->
            <div class="info-box shadow-lg dm-info-box">
              <span class="info-box-icon bg-warning"><i class="fa fa-lock"></i></span>

             <a href="https://connect.odndigital.com/daily-usage-report" > 
             <div class="info-box-content">
                <h3>Images Shot</h3>
                <h1>{{$raw}}</h1>
              </div>
              </a>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
         <!-- ./col -->
       </div>
       <!-- /.row -->
       <!-- Main row -->

       <!--<div class="row mt-3 mb-3">-->
       <!--   <section class="col-lg-12 connectedSortable">-->
       <!--     <div class="card app-card mb-4">-->
       <!--       <div class="card-header border-0 shadow-none top-app-head">-->
       <!--         <h3 class="card-title">-->
       <!--           Featured Apps-->
       <!--         </h3>-->
       <!--       </div>-->
       <!--       <div class="card-body p-sm-2 pt-sm-3 pb-sm-3 p-1 featured-card-body">-->
       <!--           <ul class="applist row">-->
       <!--               <li class="applistitem col-xl col-lg col-md col-sm-3 col-4">-->
       <!--                 <a href="https://mail.google.com/" target="_blank" class="applistlink">-->
       <!--                   <span class="appimg">-->
       <!--                     <img src="{{ asset ('dist/img/gmail1.png')}}" alt="Gmail">-->
       <!--                   </span>-->
       <!--                   <span class="apptitle">-->
       <!--                     Gmail-->
       <!--                   </span>-->
       <!--                 </a>-->
       <!--               </li>-->
       <!--               <li class="applistitem col-xl col-lg col-md col-sm-3 col-4">-->
       <!--                 <a href="https://calendar.google.com/calendar" target="_blank" class="applistlink">-->
       <!--                   <span class="appimg">-->
       <!--                     <img src="{{ asset ('dist/img/google-calender.png')}}" alt="Calender">-->
       <!--                   </span>-->
       <!--                   <span class="apptitle">-->
       <!--                     Calender-->
       <!--                   </span>-->
       <!--                 </a>-->
       <!--               </li>-->
       <!--               <li class="applistitem col-xl col-lg col-md col-sm-3 col-4">-->
       <!--                 <a href="https://sheets.corp.google.com/" target="_blank" class="applistlink">-->
       <!--                   <span class="appimg">-->
       <!--                     <img src="{{ asset ('dist/img/Google-sheets.png')}}" alt="Sheets">-->
       <!--                   </span>-->
       <!--                   <span class="apptitle">-->
       <!--                     Sheets-->
       <!--                   </span>-->
       <!--                 </a>-->
       <!--               </li>-->
       <!--               <li class="applistitem col-xl col-lg col-md col-sm-3 col-4">-->
       <!--                 <a href="https://docs.google.com/" target="_blank" class="applistlink">-->
       <!--                   <span class="appimg">-->
       <!--                     <img src="{{ asset ('dist/img/google-docs.png')}}" alt="Docs">-->
       <!--                   </span>-->
       <!--                   <span class="apptitle">-->
       <!--                     Docs-->
       <!--                   </span>-->
       <!--                 </a>-->
       <!--               </li>-->
       <!--               <li class="applistitem col-xl col-lg col-md col-sm-3 col-4">-->
       <!--                 <a href="https://www.drive.google.com/" target="_blank" class="applistlink">-->
       <!--                   <span class="appimg">-->
       <!--                     <img src="{{ asset ('dist/img/g-drive.png')}}" alt="Drive">-->
       <!--                   </span>-->
       <!--                   <span class="apptitle">-->
       <!--                     Drive-->
       <!--                   </span>-->
       <!--                 </a>-->
       <!--               </li>-->
       <!--               <li class="applistitem col-xl col-lg col-md col-sm-3 col-4 pdf-item">-->
       <!--                 <a href="https://smallpdf.com/" target="_blank" class="applistlink">-->
       <!--                   <span class="appimg">-->
       <!--                     <img src="{{ asset ('dist/img/small-pdf1.png')}}" alt="PDF" style="width: 45px; height:45px;">-->
       <!--                   </span>-->
       <!--                   <span class="apptitle">-->
       <!--                     Small Pdf-->
       <!--                   </span>-->
       <!--                 </a>-->
       <!--               </li>-->
       <!--               <li class="applistitem col-xl col-lg col-md col-sm-3 col-4">-->
       <!--                 <a href="https://www.figma.com/" target="_blank" class="applistlink">-->
       <!--                   <span class="appimg">-->
       <!--                     <img src="{{ asset ('dist/img/figma-2-logo.png')}}" alt="Figma">-->
       <!--                   </span>-->
       <!--                   <span class="apptitle">-->
       <!--                     Figma-->
       <!--                   </span>-->
       <!--                 </a>-->
       <!--               </li>-->
       <!--               <li class="applistitem col-xl col-lg col-md col-sm-3 col-4">-->
       <!--                 <a href="https://www.zimyo.work/?app_callback_url=https://employee.zimyo.work" target="_blank" class="applistlink">-->
       <!--                   <span class="appimg">-->
       <!--                     <img src="{{ asset ('dist/img/zimo-logo.png')}}" alt="Zimo">-->
       <!--                   </span>-->
       <!--                   <span class="apptitle">-->
       <!--                     zimo ODN HRM-->
       <!--                   </span>-->
       <!--                 </a>-->
       <!--               </li>-->
       <!--               <li class="applistitem col-xl col-lg col-md col-sm-3 col-4 add-more-item">-->
       <!--                 <a href="javascript:;" class="applistlink" data-toggle="tooltip" title="Coming Soon">-->
       <!--                   <span class="appimg">-->
       <!--                     <img src="{{ asset ('dist/img/addmore.png')}}" alt="Add More">-->
       <!--                   </span>-->
       <!--                   <span class="apptitle d-none">-->
       <!--                     Coming Soon-->
       <!--                   </span>-->
       <!--                 </a>-->
       <!--               </li>-->
       <!--           </ul>-->
       <!--       </div>-->
       <!--     </div>-->
       <!--   </section>-->
       <!--</div>-->

       <!--<div class="row">-->
         <!-- Left col -->
       <!--  <section class="col-lg-7 connectedSortable">-->

       <!--  <div class="card app-card mb-4 shadow-none msss-cnnet-card">-->
       <!--   <div class="card-body p-0">-->
       <!--     <h2>Connect Messenger, Dashboard Analytics <br>Notification Center, Status Engine & Detailed Reports <br> Coming Soon!!  </h2> -->
            <!-- <div id="resizable">
       <!--       <iframe src="{{route('connect')}}" id="iframe" width="100%" height="100%"></iframe>-->
       <!--     </div> -->
       <!--   </div>-->
       <!--  </div>-->

       <!--  </section>-->
         <!-- /.Left col -->
         <!-- right col (We are only adding the ID to make the widgets sortable)-->
       <!--  <section class="col-lg-5 connectedSortable dash-calender">-->

            <!-- Calendar -->
       <!--     <div class="card card-transparent card-calenders">-->
       <!--       <div class="card-header border-0">-->

       <!--         <h3 class="card-title">-->
       <!--           <i class="far fa-calendar-alt"></i>-->
       <!--           Calendar-->
       <!--         </h3>-->
                <!-- tools card -->
       <!--         <div class="card-tools">-->
                  <!-- button with a dropdown -->
       <!--           <div class="btn-group">-->
       <!--             <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">-->
       <!--               <i class="fas fa-bars"></i>-->
       <!--             </button>-->
       <!--             <div class="dropdown-menu" role="menu">-->
       <!--               <a href="#" class="dropdown-item">Add new event</a>-->
       <!--               <a href="#" class="dropdown-item">Clear events</a>-->
       <!--               <div class="dropdown-divider"></div>-->
       <!--               <a href="#" class="dropdown-item">View calendar</a>-->
       <!--             </div>-->
       <!--           </div>-->
       <!--           <button type="button" class="btn btn-sm" data-card-widget="collapse">-->
       <!--             <i class="fas fa-minus"></i>-->
       <!--           </button>-->
       <!--           <button type="button" class="btn btn-sm" data-card-widget="remove">-->
       <!--             <i class="fas fa-times"></i>-->
       <!--           </button>-->
       <!--         </div>-->
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
             </div>
            <!-- /.card -->

           <!-- Map card -->
           <div class="card bg-gradient-primary" style="display:none;">
             <div class="card-header border-0">
               <h3 class="card-title">
                 <i class="fas fa-map-marker-alt mr-1"></i>
                 Visitors
               </h3>
               <!-- card tools -->
               <div class="card-tools">
                 <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                   <i class="far fa-calendar-alt"></i>
                 </button>
                 <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                   <i class="fas fa-minus"></i>
                 </button>
               </div>
               <!-- /.card-tools -->
             </div>
             <div class="card-body">
               <div id="world-map" style="height: 250px; width: 100%;"></div>
             </div>
             <!-- /.card-body-->
             <div class="card-footer bg-transparent">
               <div class="row">
                 <div class="col-4 text-center">
                   <div id="sparkline-1"></div>
                   <div class="text-white">Visitors</div>
                 </div>
                 <!-- ./col -->
                 <div class="col-4 text-center">
                   <div id="sparkline-2"></div>
                   <div class="text-white">Online</div>
                 </div>
                 <!-- ./col -->
                 <div class="col-4 text-center">
                   <div id="sparkline-3"></div>
                   <div class="text-white">Sales</div>
                 </div>
                 <!-- ./col -->
               </div>
               <!-- /.row -->
             </div>
           </div>
           <!-- /.card -->

           <!-- PRODUCT LIST -->
           <div class="card notification-card" style="display:none;">
              <div class="card-header">
                <h3 class="card-title">Notification</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <h2>Notification List Coming Soon</h2>
                <!-- <ul class="products-list product-list-in-card pl-2 pr-2">
                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">Samsung TV
                        <span class="badge badge-warning float-right">$1800</span></a>
                      <span class="product-description">
                        Samsung 32" 1080p 60Hz LED Smart HDTV.
                      </span>
                    </div>
                  </li>

                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">Bicycle
                        <span class="badge badge-info float-right">$700</span></a>
                      <span class="product-description">
                        26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                      </span>
                    </div>
                  </li>

                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">
                        Xbox One <span class="badge badge-danger float-right">
                        $350
                      </span>
                      </a>
                      <span class="product-description">
                        Xbox One Console Bundle with Halo Master Chief Collection.
                      </span>
                    </div>
                  </li>

                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">PlayStation 4
                        <span class="badge badge-success float-right">$399</span></a>
                      <span class="product-description">
                        PlayStation 4 500GB Console (PS4)
                      </span>
                    </div>
                  </li>

                </ul> -->
              </div>
              <!-- /.card-body -->
              <!-- <div class="card-footer text-center">
                <a href="javascript:void(0)" class="uppercase">View All Notification</a>
              </div> -->
              <!-- /.card-footer -->



            </div>
            <!-- /.card -->


         </section>
         <!-- right col -->
       </div>
       <!-- /.row (main row) -->
     </div><!-- /.container-fluid -->
   </section>

   <div class="fix-infor-wrapper">
    <a href="javascript:;" class="information-pp-btn" id="info-popbtn">
      <i class="fas fa-info ic-infor"></i>
      <i class="fas fa-times cl-infor"></i>
    </a>
    <div class="infor-content">
      <ul class="info-ll-list">
        <li><b>Dashboard update coming soon!!</b></li>
      </ul>
    </div>
  </div>
@endsection
