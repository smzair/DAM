<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet"> -->

  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap"> -->

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&display=swap">

  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{asset('plugins/ekko-lightbox/ekko-lightbox.css')}}">

  <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
  
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

  <!-- for new dashboard style we need to include this on main css -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}"> 

  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}"> 

  <link rel="stylesheet" href="{{ asset('/css/common.css') }}"> 


</head>
<body class="sidebar-mini layout-fixed accent-yellow " id="main-bdy" style="height: auto;">

  <!--<div class="loader-ajax">-->
  <!--  <img src="{{asset('dist/img/2021-03-22.gif')}}" alt="loader">-->
  <!--</div>-->

  <div class="wrapper" id="">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav header-link-mnu">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block text-lnk">
          <a href="{{route('home')}}" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block text-lnk">
          <a href="#" class="nav-link">Contact</a>
        </li>
      </ul>

      <!-- Search Form Backup -->


      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <li class="nav-item dark-dsh-light" id="ss-mode">
          <label class="toggle-inner">
            <!-- <input type="checkbox" name="checkbox" id="checkbox"> -->
            <span></span>
            <i class="indicator"></i>
          </label>
        </li>
        <!-- Notifications Dropdown Menu -->
       
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4 sidebar-light-warning sidebar-no-expand dam-sidebar">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link navbar-warning logo-warn">
        <img src="{{ asset ('dist/img/ODN_Logopng.png')}}" alt="DAML" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">CONNECT</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden"><div class="os-resize-observer-host observed"><div class="os-resize-observer" style="left: 0px; right: auto;"></div></div><div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;"><div class="os-resize-observer"></div></div><div class="os-content-glue" style="margin: 0px -8px; width: 73px; height: 497px;"></div><div class="os-padding"><div class="os-viewport os-viewport-native-scrollbars-invisible os-viewport-native-scrollbars-overlaid" style="overflow-y: scroll;"><div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <a href="{{route('user.profile')}} "><img src="{{asset('dist/img/uploads/avatars')}}/{{auth()->user()->photo}}" class="img-circle elevation-2" alt="{{ auth()->user()->name }}"></a>
          </div>
          <div class="info">
           <p> <a href="{{route('user.profile')}} " class="d-block">{{auth()->user()->name}}</a>
            <span class="right badge badge-warning myedit-pr">View & Edit Your Profile</span></p>

          </div>
        </div>
 
 
        <!--Done SidebarSearch Form-->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           <li class="nav-item">
            <a href="{{route('home')}} " class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('Daily-u-reports')}}" class="nav-link">
              <i class="nav-icon fas fa-sign-in-alt"></i>
              <p>Daily Usage Report</p>
            </a>
            </li>
            
             <li class="nav-item">
            <a href="/notify-tatReport" class="nav-link">
              <i class="nav-icon fas fa-sign-in-alt"></i>
              <p>TAT Report</p>
            </a>
            </li>
            
             <li class="nav-item">
            <a href="{{route('feedBack')}}" class="nav-link">
              <i class="nav-icon fas fa-sign-in-alt"></i>
              <p>Request Feedback</p>
            </a>
            </li>
            
             <li class="nav-item">
            <a href="{{route('mastersheet')}}" class="nav-link">
              <i class="nav-icon fas fa-sign-in-alt"></i>
              <p>Master Sheet</p>
            </a>
            </li>
      
          @role('Super Admin')
          <li class="nav-item">
            <a  class="nav-link" style="cursor:pointer;">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{route('user.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add & Edit Employees </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('permission.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permissions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('role.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roles</p>
                </a>
              </li>
            </ul>
          </li>
          @endrole

          @hasanyrole('Client')
            
          <li class="nav-item">
            <a  class="nav-link" style="cursor:pointer;">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Client User Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{route('clientuser.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Client Side Add & Edit Employees </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('permission.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Client Permissions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('role.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Client Roles</p>
                </a>
              </li>
            </ul>
          </li>
          {{-- @endrole --}}
          @endhasanyrole

          @hasanyrole('Commercials|Super Admin')

          <li class="nav-header"><b>Commercials Panel</b></li>
          
            <li class="nav-item">
                  <a href="{{route('Wrc.viewwrc')}}" class="nav-link">
                    <i class="far fa-circle Inwardingarning nav-icon"></i>
                    <p>View All WRC</p>
                  </a>
                </li>
                
                  <li class="nav-item">
                  <a href="{{route('Wrc.invoiceNo')}}" class="nav-link">
                    <i class="far fa-circle Inwardingarning nav-icon"></i>
                    <p>Update WRC Invoice Number</p>
                  </a>
                </li>

          <li class="nav-item">
            <a  class="nav-link" style="cursor:pointer;">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                Clients Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('user.manage')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Clients</p>
                </a>
              </li>
            </ul>
          </li>



          <li class="nav-item">
            <a  class="nav-link" style="cursor:pointer;">
              <!-- <img style="height:24px;width:24px ml-1" src="https://img.icons8.com/ios/50/000000/circled-o.png"/> -->
              <i class="nav-icon fas fa-code-branch"></i>
              <p>
                Brands Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route ('brands.add')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create New Brands</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route ('brands.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Brands</p>
                </a>
              </li>

            </ul></li>
        <li class="nav-header">Commercials</li>
            <li class="nav-item">
              <a  class="nav-link" style="cursor:pointer;">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Shoot Commercials
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('commercial.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create New Commercials</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('viewcom')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View All Shoot Commercials</p>
                  </a>
                </li>
              </ul>
              <!-----  Creative Commercial ---->
              
              <li class="nav-item">
              <a  class="nav-link" style="cursor:pointer;">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Creative Commercials
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('CREATECOM')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create New Commercials</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('viewCOM')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View All Creative Commercials</p>
                  </a>
                </li>
              </ul>
              
                <!-----  Catalog Commercial ---->
              
              <li class="nav-item">
              <a  class="nav-link" style="cursor:pointer;">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Catalog Commercials
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('CREATECATALOG')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create New Commercials</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('viewCommercial')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View All Catalog Commercials</p>
                  </a>
                </li>
              </ul>
              @endhasanyrole
              
             @hasanyrole('Account Management|comview')
             
            <li class="nav-item">
              <a href="{{route('viewcom')}}" class="nav-link" style="cursor:pointer;">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  
                   
                    <p>View All Shoot Commercials</p>
                  </a>
                </li>
                
           
                <li class="nav-item">
                  <a href="{{route('viewCOM')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View All Creative Commercials</p>
                  </a>
                </li>
            
   
                <li class="nav-item">
                  <a href="{{route('viewCommercial')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View All Catalog Commercials</p>
                  </a>
                </li>
              
            @endhasanyrole

            @hasanyrole('Account Management|Super Admin')


            <li class="nav-header"><b>Accounts Management</b></li>

              <li class="nav-item">
          <a href="{{route('admin.index')}}" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
              View All Inwardings
            </p>
          </a>
        </li>
  
   <li class="nav-item">
              <a href="{{route('upload.view.sku')}}" class="nav-link">
                <i class="nav-icon fas fa-file-excel"></i>
                <p>View All SKUs</p>
              </a>
            </li>  
          </li>      
    <li class="nav-header">LOT's</li>
   <li class="nav-item">
              <a  class="nav-link" style="cursor:pointer;">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                Shoot LOT
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
    <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route ('Lots.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create Shoot LOTs</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('Lots.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Shoot LOTs</p>
                  </a>
                </li>
              </ul>
            </li>
            
            
   <li class="nav-item">
              <a  class="nav-link" style="cursor:pointer;">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                 Creative LOT
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
    <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route ('CREATELOT')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create Creative LOTs</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('viewLOT')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Creative LOTs</p>
                  </a>
                </li>
              </ul>
            </li>
            
            
   <li class="nav-item">
              <a  class="nav-link" style="cursor:pointer;">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                 Catalog LOT
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
    <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route ('CREATELOTCATALOG')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create Catalog LOTs</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('VIEWLOTCATALOG')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Catalog LOTs</p>
                  </a>
                </li>
              </ul>
            </li>
            
                <li class="nav-header">WRC's</li>

            <li class="nav-item">
              <a  class="nav-link" style="cursor:pointer;">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                Shoot WRC
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('Wrc.createwrc')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create Shoot WRC</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('Wrc.viewwrc')}}" class="nav-link">
                    <i class="far fa-circle Inwardingarning nav-icon"></i>
                    <p>View Shoot WRC</p>
                  </a>
                </li>
              </ul>
            </li>
            
               <li class="nav-item">
              <a  class="nav-link" style="cursor:pointer;">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                 Creative WRC
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('CREATEWRC')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create Creative WRC</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('viewWRC')}}" class="nav-link">
                    <i class="far fa-circle Inwardingarning nav-icon"></i>
                    <p>View Creative WRC</p>
                  </a>
                </li>
        
            
            <li class="nav-item">
                  <a href="{{route('viewWRCBatchPanel')}}" class="nav-link">
                    <i class="far fa-circle Inwardingarning nav-icon"></i>
                    <p>Creative WRCs Batch Panel</p>
                  </a>
                </li>
              </ul>
            </li>
               <li class="nav-item">
              <a href="{{ route('CREATIVE_SUBMISSION_GET') }}" class="nav-link">
                         <i class="far fa-circle nav-icon"></i>
                       <p>Ready for Submission</p>
                      </a>
                             </li>

                    <li class="nav-item">
                      <a href="{{ route('CREATIVE_SUBMISSION_DONE') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                     <p>Creative Submission Done</p>
                                  </a>
                       </li>

                <li class="nav-item">
                   <a href="{{ route('CREATIVE_WRC_CLIENT_APPROVAL_REJECTION') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                                <p>Creative WRC Client Approval & Rejection</p>
                             </a>
                                            </li>
                                           
            
               <li class="nav-item">
              <a  class="nav-link" style="cursor:pointer;">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                 Catalog WRC
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('CREATECATLOGWRC')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create Catalog WRC</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('viewCatalogWRC')}}" class="nav-link">
                    <i class="far fa-circle Inwardingarning nav-icon"></i>
                    <p>View Catalog WRC</p>
                  </a>
                </li>
                 <li class="nav-item">
                   <a href="{{ route('MarketPlace') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                          <p>Marketplace Credentials</p>
                                                </a>
                                            </li>
                    <li class="nav-item">
                      <a href="{{ route('CatalogWrcBatch') }}" class="nav-link">
                       <i class="far fa-circle nav-icon"></i>
                          <p>Catalog Wrc's Batch Panel </p>
                                                </a>
                                            </li>
                    <li class="nav-item">
                                                    <a href="{{route('C_READYFORSUB')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Catalog Submission List</p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{route('C_SUB_DONE')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Catalog Submission Done</p>
                                                    </a>
                                                </li>
                                                {{-- client approval rejection --}}
                                                <li class="nav-item">
                                                    <a href="{{route('CATA_CLIENT_AR')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Catalog WRC AR</p>
                                                    </a>
                                                </li>
                
              </ul>
            </li>
            
            <li class="nav-item">
    <a  class="nav-link" style="cursor:pointer;">
      <i class="nav-icon far fa-paper-plane"></i>
      <p>
        Submission Panels
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{route('submission')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Ready For Submission </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('submitted')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Submission Done </p>
        </a>
      </li>
      
      <li class="nav-item">
        <a href="{{route('CREATIVE_SUBMISSION_GET')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Creative Submission </p>
        </a>
      </li>
    </ul>
  </li>
  
  <li class="nav-item">
          <a href="{{route('Wrc.clientAR')}}" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
             WRC Client Approval & Rejection
            </p>
          </a>
        </li>
        
            
            @endhasanyrole

            

            @hasanyrole('Inwarding|Super Admin')

            <li class="nav-header"><b>Inward Panel</b></li>

            <li class="nav-item">
              <a href="{{route('Uploadsku.create')}}" class="nav-link">
                <i class="nav-icon fas fa-file-upload"></i>
                <p>Upload SKUs</p>
              </a>
            </li>  

            <li class="nav-item">
              <a href="{{route('upload.view.sku')}}" class="nav-link">
                <i class="nav-icon fas fa-file-excel"></i>
                <p>View All SKUs</p>
              </a>
            </li>  
          </li>



        <!--   <li class="nav-item">
            <a href="{{route('Lots.index')}}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                View All Lot
              </p>
            </a>

          </li>
        -->

        <li class="nav-item">
          <a href="{{route('admin.index')}}" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
              View All Inwardings
            </p>
          </a>
        </li>

        @endhasanyrole
        @hasanyrole('Admin|Super Admin')
        <li class="nav-header"><b>Admin Panel</b></li>
   <li class="nav-item">
              <a href="{{route('upload.view.sku')}}" class="nav-link">
                <i class="nav-icon fas fa-file-excel"></i>
                <p>View All SKUs</p>
              </a>
            </li>  
          </li>   
          
        <li class="nav-item">
                  <a href="{{route('Wrc.viewwrc')}}" class="nav-link">
                    <i class="far fa-circle Inwardingarning nav-icon"></i>
                    <p>View All WRC</p>
                  </a>
                </li>
                
                                <li class="nav-item">
                                        <a href="/equipments-panel" class="nav-link">
                                            <i class="nav-icon fas fa-calendar-plus"></i>
                                            <p>
                                               Add Equipments
                                            </p>
                                        </a>
                                    </li>

        <li class="nav-item">
         <a href="{{route('admin.bay')}}" class="nav-link">
          <i class="nav-icon fas fa-calendar-plus"></i>
          <p>
           View & Add New Day 
         </p>
       </a>
     </li>

     <li class="nav-item">
       <a href="{{route('planshoot')}}" class="nav-link">
         <i class="nav-icon far fa-calendar-alt"></i>
         <p>
           Plan Shoots 
           <span class="badge badge-danger right" id="plan_count"></span>
         </p>
       </a>
     </li>

     <li class="nav-item">
       <a href="{{route('shoottable')}}" class="nav-link">
        <i class=" nav-icon fas fa-table"></i>
        <p>
         Shoots Table
       </p>
     </a>
   </li>
   <li class="nav-item">
    <a href="{{route('admin.index')}}" class="nav-link">
      <i class="fas fa-binoculars nav-icon"></i>
      <p>View All
      </p>
    </a>
  </li>
  @endhasanyrole
  @hasanyrole('Studio|Admin|Super Admin')

  <li class="nav-header">Studio Panel</li>

  <li class="nav-item">
   <a class="nav-link" style="cursor:pointer;">
     <i class="nav-icon fas fa-images"></i>
     <p>
       Images
       <i class="right fas fa-angle-left"></i>
     </p>
   </a>
   <ul class="nav nav-treeview">
     <li class="nav-item">
      <a href="{{route('raw')}}" class="nav-link">
       <i class="far fa-circle nav-icon"></i>
       <p>Upload Images
       </p>
     </a>
   </li>
 </ul>
</li>
@endhasanyrole
    <!--  <li class="nav-item">
        <a href="{{route('viewraw')}}" class="nav-link">
         <i class="far fa-circle text-warning nav-icon"></i>
         <p>View Raw Uplaods
         </p>
       </a>
     </li>
   -->
      @hasanyrole('Editor TL|Super Admin')

                                     <li class="nav-header">Allocation & Editing Panel</li>
                                     <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon far fa-image"></i>
                                            <p>
                                                Allocate
                                                <i class="right fas fa-angle-left"></i>


                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{route('allocation')}}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Allocation
                                                        <span class="badge badge-danger right" id="allocation_count"></span>
                                                    </p>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{route('allodetail')}}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Allocated Details
                                                    </p>
                                                </a>
                                            </li>

                                        </ul>
                                        @endhasanyrole
                     @hasanyrole('Catalog QC|Super Admin|Catalog PL|Catalog TL')                             
                                        
                                                <li class="nav-item">
                                                    <a href="{{route('CATALOG_ALLOCT')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p> Catalog Allocation</p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{route('CATALOG_RE_ALLOCT')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p> Catalog Re Allocation</p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{route('CATALOG_ALLOCTED_DETAILS')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p> Catalog Allocation Details</p>
                                                    </a>
                                                </li>

                                                {{--End Allocation section   --}}

                                                <li class="nav-item">
                                                    <a href="{{route('QcList')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p> QC Status</p>
                                                    </a>
                                                </li>
                                                
                                                 {{-- 13-02-2023 --}}
                                                 
                                                     <li class="nav-item">
                                                    <a href="{{route('NewCommercial')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Add New Commercials</p>
                                                    </a>
                                                </li>
                                                 
                                                 <li class="nav-item">
                                                    <a href="{{route('ViewNewCommercial')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>View All New Commercials</p>
                                                    </a>
                                                </li>
                                                 
                                                 
                                                 {{-- catalog-wrc-status --}}
                                                <li class="nav-item">
                                                    <a href="{{route('CatalogWrcStatus')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Catalog WRC Status</p>
                                                    </a>
                                                </li>
                                                 
                                                  {{-- catalog-Invoice --}}
                                                <li class="nav-item">
                                                    <a href="{{route('CatalogInvoice')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Catalog Invoice</p>
                                                    </a>
                                                </li>
                                                 
                                                  {{-- Editing Panel --}}
                                                <li class="nav-item">
                                                    <a href="{{route('CommercialEditor')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Create Editing Commercial</p>
                                                    </a>
                                                </li>
                                                 
                                                  <li class="nav-item">
                                                    <a href="{{route('ViewCommercialEditor')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Editing Commercial List</p>
                                                    </a>
                                                </li>
                                                 
                                                 <li class="nav-item">
                                                    <a href="{{ route('editor_create_lot') }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Create Editing Lot</p>
                                                    </a>
                                                </li>
                                                 
                                                 <li class="nav-item">
                                                    <a href="{{ route('get_editor_lot_data') }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Editing Lot List</p>
                                                    </a>
                                                </li>
                                                 
                                                 <li class="nav-item">
                                                    <a href="{{route('EditingWrcCreate')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Create Editing Wrc</p>
                                                    </a>
                                                </li>
                                                 
                                                 
                                                 <li class="nav-item">
                                                    <a href="{{route('EditingWrcView')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Editing Wrc List</p>
                                                    </a>
                                                </li>
                                                 
                                                 <li class="nav-item">
                                                    <a href="{{route('Editing_Allocation')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Editing Allocatiion</p>
                                                    </a>
                                                </li>
                                                 
                                                 <li class="nav-item">
                                                    <a href="{{route('Editing_Re_Allocation')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Editing Re-Allocatiion</p>
                                                    </a>
                                                </li>
                                                 
                                                 <li class="nav-item">
                                                    <a href="{{route('Editing_Allocation_Details')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Editing Allocatiion Details</p>
                                                    </a>
                                                </li>
                                                 
                                                 <li class="nav-item">
                                                    <a href="{{route('Editing_Upload')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Editing Upload</p>
                                                    </a>
                                                </li>
                                                 
                                                  <li class="nav-item">
                                                    <a href="{{route('Editing_Submission')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Editing Submission</p>
                                                    </a>
                                                </li>
                                                 
                                                 <li class="nav-item">
                                                    <a href="{{route('Editing_Submission_Done')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Editing Submission Done</p>
                                                    </a>
                                                </li>
                                                 
                                                  <li class="nav-item">
                                                    <a href="{{route('EditingClientARList')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Editing WRC AR</p>
                                                    </a>
                                                </li>
                                                 
                                                
                                                 <li class="nav-item">
                                                    <a href="{{ route('creative_wrc_status_view') }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Creative-wrcs-status-view</p>
                                                    </a>
                                                </li>
                                                 
                                                 <li class="nav-item">
                                                    <a href="{{ route('consolidated_lot_panel') }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Consolidated-Lot-Panel</p>
                                                    </a>
                                                </li>
                                                 
                                                 <li class="nav-item">
                                                    <a href="{{ route('consolidated_lot_view') }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Consolidated-Lot-View</p>
                                                    </a>
                                                </li>
                                                 
                                                 <li class="nav-item">
                                                    <a href="{{ route('update_invoice_number_panel') }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Update Invoice Number Panel</p>
                                                    </a>
                                                </li>
                                                 
                                                 {{-- 13-02-2023 --}}
   @endhasrole           
  
          <!-- creative-->
      @hasanyrole('Creative TL|Super Admin')
   <li class="nav-header">Creative Allocation</li>
   
           <li class="nav-item">
                  <a href="{{route('CREATEWRC')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create Creative WRC</p>
                  </a>
                </li>
             
            
            <li class="nav-item">
                  <a href="{{route('viewWRCBatchPanel')}}" class="nav-link">
                    <i class="far fa-circle Inwardingarning nav-icon"></i>
                    <p>Creative WRCs Batch Panel</p>
                  </a>
                </li>
   
   <li class="nav-item">
                  <a href="{{route('viewWRC')}}" class="nav-link">
                    <i class="far fa-circle Inwardingarning nav-icon"></i>
                    <p>View Creative WRC</p>
                  </a>
                </li>
                                     <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon far fa-image"></i>
                                            <p>
                                                Allocate
                                                <i class="right fas fa-angle-left"></i>


                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                        <a href="{{ route('CREATIVE_ALLOCATION_CREATE') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p> Allocation
                                                        <span class="badge badge-danger right" id="allocation_count"></span>
                                                    </p>
                                                </a>
                                            </li>
                                            
                        <!--                     <li class="nav-item">-->
                        <!--<a href="{{ route('CREATIVE_REALLOCATION_CREATE') }}" class="nav-link">-->
                        <!--                            <i class="far fa-circle nav-icon"></i>-->
                        <!--                            <p> ReAllocation-->
                        <!--                                <span class="badge badge-danger right" id="allocation_count"></span>-->
                        <!--                            </p>-->
                        <!--                        </a>-->
                        <!--                    </li>-->

                                            <li class="nav-item">
                                                <a href="{{ route('CREATIVE_ALLOCATION_GET') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Allocated Details
                                                    </p>
                                                </a>
                                            </li>

                                        </ul>
                                        @endhasanyrole                                
                               @hasanyrole('Creative TL|Super Admin|CW|GD')
                                        <li class="nav-item">
                                            <a href="{{route('UPLOAD_CREATIVE_PANEL')}}" class="nav-link">
                                                <i class="fas fa-columns nav-icon"></i>
                                                <p>Tasking Panel</p>
                                            </a>
                                        </li>
                                         @endhasanyrole
                                          @hasanyrole('Catalog QC|Super Admin|CW|Cataloguer|Catalog PL|Catalog TL')
                                        <li class="nav-item">
                                                    <a href="{{route('CATALOG_UPLOAD')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p> Catalog Upload</p>
                                                    </a>
                                                </li>
                                          @endhasanyrole
                                          
  @hasanyrole('Creative TL|Super Admin')

  <li class="nav-header"><b>QC Panel</b></li>
  <li class="nav-item">
    <a class="nav-link" style="cursor:pointer;">
      <i class="nav-icon fas fa-user-check"></i>
      <p>
        QC
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{route('CREATIVE_QC_GET')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i> 
          <p>Ready for Qc
          </p>
        </a>
      </li>
    </ul>
  </li>
  @endhasanyrole
  
  
  <!-- creative-->
  
  
                                        @hasanyrole('Editor TL|Editors|Super Admin')

                                        <li class="nav-item">
                                            <a href="{{route('editors')}}" class="nav-link">
                                                <i class="fas fa-columns nav-icon"></i>
                                                <p>Editor's Panel</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                <i class="nav-icon far fa-image"></i>
                                                <p>
                                                    Flipkart Panel
                                                    <i class="right fas fa-angle-left"></i>


                                                </p>
                                            </a>
                                            <ul class="nav nav-treeview">

                                             <li class="nav-item">
                                                <a href="{{route('flipkart.editors.table')}}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p> New & On Going Requests</p>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{route('flipkart.editors.upload')}}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Uploads Zip for Flipkart 
                                                        <span class="badge badge-danger right" id="allocation_count"></span>
                                                    </p>
                                                </a>
                                            </li>
                                        </ul>

                                    </li>

                                </li>
                                @endhasanyrole
  @hasanyrole('Qc|Super Admin')

  <li class="nav-header"><b>QC Panel</b></li>
  <li class="nav-item">
    <a class="nav-link" style="cursor:pointer;">
      <i class="nav-icon fas fa-user-check"></i>
      <p>
        QC
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{route('Qc')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i> 
          <p>Ready for Qc
          </p>
        </a>
      </li>
        <li class="nav-item">
        <a href="{{route('qcDone')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i> 
          <p>Qc Done
          </p>
        </a>
      </li>
    </ul>
  </li>
  @endhasanyrole

  <li class="nav-header">Miscellaneous</li>
  @hasanyrole('Account Management|Super Admin')

  <li class="nav-item">
    <a class="nav-link">
      <i class="nav-icon fas fa-file-invoice"></i>
      <p>Payments</p>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{route('Logs')}}" class="nav-link">
      <i class="nav-icon fas fa-sign-in-alt"></i>
      <p>View Logs</p>
    </a>
  </li>
  
  @endhasanyrole

  @hasanyrole('Account Management|Editors|Editor TL|Qc|Studio|Admin|Commercials|Inwarding|Super Admin|CW|GD|Cataloguer')

  <li class="nav-item">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-file"></i>
      <p>Documentation</p>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ route('userGetpassword')}}" class="nav-link">
      <i class="nav-icon fas fa-key text-warning"></i>
      <p>Change Password</p>
    </a>
  </li>



  <li class="nav-item">
    <a class="nav-link" href="{{ route('logout') }}"
    onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
    <i class="nav-icon fas fa-sign-out-alt text-danger"></i>

    <p>   {{ __('Logout') }} </p>
  </a>

  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
  </form>
</li>
</ul>
</nav>  <!-- /.sidebar-menu -->
</div>
</div>
</div>
</div>

@endhasanyrole


<div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
  <div class="os-scrollbar-track">
    <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);">
      
    </div>
  </div>
</div>
<div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden"><div class="os-scrollbar-track">
  <div class="os-scrollbar-handle" style="height: 42.5278%; transform: translate(0px, 0px);">
  </div>
</div>
</div>
<div class="os-scrollbar-corner"></div>
</div>
<!-- /.sidebar -->
</aside>

<div class="content-header">
 <div class="container-fluid">
   <div class="row mb-2">
     <div class="col-sm-6 ">



     </div>
     <!-- /.col -->
     <div class="col-sm-6">

       <ol class="breadcrumb float-sm-right">

         <li class="breadcrumb-item active ">{{auth()->user()->name}}</li>
         <li class="breadcrumb-item active">@yield('title')</li>
       </ol>
     </div><!-- /.col -->
   </div><!-- /.row -->
 </div><!-- /.container-fluid -->
</div>
<div class="copy-msg"><p>Copied!</p></div>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: transparent;">
  @include('Partials.alert')
  @yield('content')
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <strong>Copyright © 2023 <a href="https://odndigital.com">ODN | Connect</a></strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.2.0
  </div>
</footer>
<a href="#top" id="back-to-top">
  <svg width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <g id="_24x24_On_Light_Arrow-Top" data-name="24x24/On Light/Arrow-Top" transform="translate(24) rotate(90)">
      <rect id="view-box" width="24" height="24" fill="none"/>
      <path id="Shape" d="M.22,10.22A.75.75,0,0,0,1.28,11.28l5-5a.75.75,0,0,0,0-1.061l-5-5A.75.75,0,0,0,.22,1.28l4.47,4.47Z" transform="translate(14.75 17.75) rotate(180)" fill="#141124"/>
    </g>
  </svg>
</a>
<div class="fixed-search-wrapper">
  <a href="javascript:;" class="search-tg-btn" id="search-toggle-btt">
    <i class="fas fa-search"></i>
  </a>
  <!-- SEARCH FORM -->
  <div class="input-group input-group-sm hdr-search-wrapper">
    <input class="form-control form-control-navbar hdr-search" type="search" placeholder="Enter" aria-label="Search">
    <div class="input-group-append">
      <button class="btn btn-navbar" data-search="next" type="button">∨</button>
      <button class="btn btn-navbar" data-search="prev" type="button">∧</button>
      <button class="btn btn-navbar" data-search="clear" type="button">?</button>
    </div>
  </div>
</div>


<!-- jQuery -->

<script src ="{{ asset('/js/app.js')}}"  ></script>

<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script type="application/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
 <script src="https://code.jquery.com/jquery-3.5.1.js" type="application/javascript" ></script>
      <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="application/javascript" ></script>
      <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js" type="application/javascript" ></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript" ></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript" ></script>
      <script  src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js" type="text/javascript"></script>

<script type="text/javascript" src="{{asset('js/common.js')}}"></script>

<div id="sidebar-overlay"></div></div>
<!-- ./wrapper -->  

<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

<script type="application/javascript" src="{{asset ('plugins/ekko-lightbox/ekko-lightbox.min.js')}}"></script>

<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

<script src="{{asset('plugins/datepicker-in-bootstrap-modal/js/datepicker.js')}}"></script>

<!-- overlayScrollbars -->
<!--<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>-->
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script> 

<script src="{{asset('js/select2.full.min.js')}}"></script>

<script src="{{ asset('plugins/jquery-cookie-master/src/jquery.cookie.js') }}"></script>

<script src="{{ asset('plugins/mark_plug/jquery.mark.min.js') }}"></script>

<script type="application/javascript" src="{{asset('plugins/sweetalert2/sweetalert2.all.min.js')}}">
</script>

<script>
        $('#dataTable').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "buttons": ["copy", "csv", "excel", "pdf"]
        }).buttons().container().insertAfter('#dataTable_wrapper .dataTables_length');
</script>

 @yield('datatable')
 @yield('customScript')


</body>
</html>
