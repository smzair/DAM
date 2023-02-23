<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="600">

    <title>Performance Dashboard</title>

    <link rel="apple-touch-icon" href="Images\logo\odn_logo.svg">

    <link rel="shortcut icon" type="image/x-icon" href="Images\logo\odn_logo.svg">

    <!-- Theme Style -->

    <link rel="stylesheet" href="plugins\bootstrap-5.1.3-dist\css\bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="plugins\visual-percent-preloader\percent-preloader.css" />

    <link rel="stylesheet" type="text/css" href="plugins\slick\slick\slick.css"/>
    <link rel="stylesheet" type="text/css" href="plugins\odometer-master\themes\odometer-theme-car.css"/>

    <!-- Common Style -->

    <link rel="stylesheet" href="dist\css\common_style.css">

</head>

<body>

    <div class="header-container-wrapper">
        <div class="custom-header">
            <div class="container-fluid">
                <div class="custom-header-content">
                    <div class="custom-logo col-header">
                        <h1>Performance Dashboard</h1>
                    </div>
                    <div class="custom-header-right-content col-header">
                        <h5>ODN Connect</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="body-container-wrapper"id="dynamicId">
            <link rel="stylesheet" type="text/css" href="plugins\odometer-master\themes\odometer-theme-car.css"/>
    
<div class="container-fluid">
            <div class="page-center">
                <div class="custom-template-section col-tem1">
                    <div class="row template-row">
                        <div class="col-12">
                            <div class="custom-start-wrapper">
                                <div class="performance-card-wrapper responsive">
                                    <div class="performance-card-item">
                                        <div class="card performance-card-content">
                                            <div class="output-wrapper lot-output">
                                                  <div id="odometer1" class="odometer odometerL"></div>
                                                <h6>LOT</h6>
                                            </div>
                                            <div class="secondary-details lot-details">
                                                <div class="dtl-col first-col">
                                                    <span class="dtl-span dtl-title">Created Now</span>
                                                    <span class="dtl-span dtl-value">{{$lots}}</span>
                                                </div>
                                                <div class="dtl-col second-col">
                                                    <span class="dtl-span dtl-title">Active</span>
                                                    <span class="dtl-span dtl-value">{{$activeLot}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="performance-card-item">
                                        <div class="card performance-card-content">
                                            <div class="output-wrapper lot-output">
                                                <div id="odometer2" class="odometer odometerW"></div>
                                                <h6>WRC</h6>
                                            </div>
                                            <div class="secondary-details lot-details">
                                                <div class="dtl-col first-col">
                                                    <span class="dtl-span dtl-title">Created Now</span>
                                                    <span class="dtl-span dtl-value">{{$wrces}}</span>
                                                </div>
                                                <div class="dtl-col second-col">
                                                    <span class="dtl-span dtl-title">Active</span>
                                                    <span class="dtl-span dtl-value">{{$activeWrc}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="performance-card-item">
                                        <div class="card performance-card-content">
                                            <div class="output-wrapper lot-output">
                                                <div id="odometer3" class="odometer odometerI"></div>
                                                <h6>Images</h6>
                                            </div>
                                            <div class="secondary-details lot-details">
                                                <div class="dtl-col first-col">
                                                    <span class="dtl-span dtl-title">Edited Now</span>
                                                    <span class="dtl-span dtl-value">{{$todayImgs}}</span>
                                                </div>
                                                <div class="dtl-col second-col">
                                                    <span class="dtl-span dtl-title">Total Images</span>
                                                    <span class="dtl-span dtl-value">{{$totalImgs}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="performance-card-item">
                                        <div class="card performance-card-content">
                                            <div class="output-wrapper lot-output">
                                                <div id="odometer4" class="odometer odometerB"></div>
                                                <h6>Invoicing Today</h6>
                                            </div>
                                            <div class="secondary-details lot-details">
                                                <div class="dtl-col first-col">
                                                    <span class="dtl-span dtl-title">Invoicing Done </span>
                                                    <span class="dtl-span dtl-value">{{$wrcBilled}}</span>
                                                </div>
                                                <div class="dtl-col second-col">
                                                    <span class="dtl-span dtl-title">Cumulative</span>
                                                    <span class="dtl-span dtl-value">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="performance-card-item">
                                        <div class="card performance-card-content">
                                            <div class="output-wrapper lot-output">
                                                <div id="odometer5" class="odometer odometerY"></div>
                                                <h6>Invoicing YTD</h6>
                                            </div>
                                            <div class="secondary-details lot-details">
                                                <div class="dtl-col first-col">
                                                    <span class="dtl-span dtl-title">Total Invoice</span>
                                                    <span class="dtl-span dtl-value">{{$wrcbill}}</span>
                                                </div>
                                                <div class="dtl-col second-col">
                                                    <span class="dtl-span dtl-title">Cumulative</span>
                                                    <span class="dtl-span dtl-value">{{$total}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="custom-template-section col-tem2">
                    <div class="row template-row">
                        <div class="col-12">
                            <div class="custom-start-wrapper">
                                <div class="custom-daily-usage-report">
                                    <div class="card panel-content-card">
                                        <div class="card-inner">
                                            <div class="panel-card-header">
                                                <h3 class="panel-card-title">Current Progress as of {{dateFormat($date)}}</h3>
                                            </div>
                                            <div class="card-body table-responsive p-0">
                                                <table class="table m-0">
                                                    <thead>
                                                        <tr>
                                                            <td>Commercial</td>
                                                            <td>Account Management</td>
                                                            <td>Operations</td>
                                                            <td>Studio</td>
                                                            <td>Editing</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                        <div class="row">
                                                        <div class="col-lg-6 col-md-12 col-12 comm-col">
                                                        <div class="rpt-details">
                                                    <p>New <br> Brand Added</p>
                                                    <h6 >{{$brand}}</h6>
                                                                    </div>
                                                                  
                                                                    </div>
                                                        <div class="col-lg-6 col-md-12 col-12 comm-col">
                                                     <div class="rpt-details">
                                                    <p>Commercial <br> Creation</p>
                                                                    <h6>{{$com}}</h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                    <div class="row">
                                                    <div class="col-lg-4 col-12 wrc-cration">
                                                        <div class="rpt-details">
                                                        <p>LOT <br> Creation</p>
                                                                <h6>{{$lots}}</h6>
                                                                        </div>
                                                                    </div>
                                                        <div class="col-lg-4 col-md-6 col-12 wrc-cration">
                                                        <div class="rpt-details">
                                                        <p>WRC <br> Creation</p>
                                                                <h6>{{$wrces}}</h6>
                                                                        </div>
                                                                    </div>
                                                        <div class="col-lg-4 col-md-6 col-12 wrc-cration">
                                                        <div class="rpt-details">
                                                        <p>SKU <br> Inwarding</p>
                                                                    <h6>{{$skus}}</h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="width:280px;">
                                                                <div class="row">
                                                            <div class="col-lg-6 col-12">
                                                        <div class="rpt-details">
                                                            <p>New <br> Plan</p>
                                                                <h6>{{$plan}}</h6>
                                                                        </div>
                                                                    </div>
                                                        <div class="col-lg-6 col-12">
                                                        <div class="rpt-details">
                                                        <p>SKU <br>Planned</p>
                                                                        <h6>{{$planwrc}}</h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-12">
                                                        <div class="rpt-details">
                                                        <p>Shoot <br>Count</p>
                                                                <h6>{{$rawimg}}</h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                <div class="row">
                                                    <div class="col-lg-6 col-12">
                                                    <div class="rpt-details">
                                                    <p>Images <br> Allocated</p>
                                                        <h6>{{$editorallocated}}</h6>
                                                                        </div>
                                                                    </div>
                                                     <div class="col-lg-6 col-12">
                                                     <div class="rpt-details">
                                                    <p>Edited <br> Uploads</p>
                                                    <h6>{{$editorSubmission}}</h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
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

    <div class="custom-notification-alert left-notification" id="dyId">
        <div class="notification-flex-wrapper">
            <div class="notification-col notification-icon">
                <img src="dist\img\content-images\greenTick.svg" alt="Check">
            </div>
            <div class="notification-col notification-text">
                <h5>WRC</h5>
                <p>WRC No generated for M&S by XYZ SPOC</p>
            </div>
        </div>
    </div>

    <div class="custom-notification-alert right-notification" id="dyId">
       
    </div>

    <div class="preloader">
        <div class="inner">
            <span class="percentage"><span id="percentage">20</span>%</span>
        </div>
        <div class="loader-progress" id="loader-progress"> </div>
    </div>

    <script src="plugins\bootstrap-5.1.3-dist\js\bootstrap.bundle.js"></script>
    <script src="plugins\bootstrap-5.1.3-dist\js\bootstrap.min.js"></script>


    <script src="plugins\visual-percent-preloader\percent-preloader.min.js"></script>

<script type="text/javascript" src="plugins\jquery\jquery.min.js"></script>

    <script src="plugins\odometer-master\odometer.js"></script>

    <!-- <script type="text/javascript" src="plugins\slick\slick\slick.min.js"></script> -->


    <!-- Common JS -->

<script type="text/javascript">


 $(document).ready(function(){
     $('[data-toggle="tooltip"]').tooltip();
    // First 
 
//  var totallots;
//  var totalWrc;
//  var totalImgs;
//  var total;
//  var wrcBilled;
 
//       setInterval(function(){

//       $.get('/reload-data', function (data) {

// totallots = data.data.totallots;
// totalWrc = data.data.totalWrc;
// totalImgs = data.data.totalImgs;
// total = data.data.total;
// wrcBilled = data.data.wrcBilled;

//     });


    // }, 40000);
 var qty1 = <?php echo $totallots; ?> ;
   var qty2 = <?php echo $totalWrc; ?> ;
   var qty3 = <?php echo $totalImgs; ?> ;
   var qty4 =  <?php echo $wrcBilled; ?>;
   var qty5 =  <?php echo $total; ?>;

            setInterval(function(){
                odometer1.innerHTML = qty1;
            }, 2000);

    // Second


            setInterval(function(){

                odometer2.innerHTML = qty2;
            }, 2000);

    // Third
           

            setInterval(function(){
                odometer3.innerHTML = qty3;
            }, 2000);

    // Fourth
           

            setInterval(function(){
                odometer4.innerHTML = qty4;
            }, 2000);

    // Fifth
          

            setInterval(function(){
                odometer5.innerHTML = qty5;
            }, 2000);

            var notiFy = $('.custom-notification-alert');

            setTimeout(function(){
                notiFy.css("opacity", "1");
                notiFy.css("visibility", "visible");
            }, 4000);

            setTimeout(function(){
                notiFy.css("opacity", "0");
                notiFy.css("visibility", "hidden");
            }, 8000);


        });

      $.get('/reload-data', function (htmlData) {

        $('#dyId').html(htmlData);
    
    });
    
       </script>

</body>

</html>