 @extends('layouts.client')
@section('title')
Flipkart Panel
@endsection
@section('content')
<div class="body-container-wrapper">
        <div class="container-lg container-fluid">
            <div class="row template-row pb-0">
                <div class="col-12">
                    <div class="custom-panel-title-action">
                        <div class="title-action-panel col-action-panel">
                            <h1>
                                <span class="info-text info-span">
                                    Track
                                </span>
                                <span class="info-icon info-span" data-toggle="tooltip" data-placement="top" title="Track your folder update">
                                    i
                                </span>
                            </h1>
                        </div>
                        <div class="button-action-panel col-action-panel">
                            <a href="{{route('home')}}" class="btn download-btn" id="HomeBTN">
                                Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row template-row pt-0">
               <div class="col-md-6 col-12">
                   <div class="folder-update-info">
                       <div class="row">
                           <div class="col-md-12 col-sm-4 col-12">
                                <div class="card panel-content-card small-info-card">
                                    <div class="card-inner">
                                        <div class="update-info info-upload">
                                            <h4>Upload Date</h4>
                                            <h3 id="F-uploadDate">02 April 2022</h3>
                                        </div>
                                    </div>
                                </div>
                           </div>
                           <div class="col-md-12 col-sm-4 col-12">
                                <div class="card panel-content-card small-info-card">
                                    <div class="card-inner">
                                        <div class="update-info info-count">
                                            <h4>Images Count</h4>
                                            <h3 id="F-imageCount">500</h3>
                                        </div>
                                    </div>
                                </div>
                           </div>
                           <div class="col-md-12 col-sm-4 col-12">
                                <div class="card panel-content-card small-info-card">
                                    <div class="card-inner">
                                        <div class="update-info info-date">
                                            <h4>Expected Delivery Date</h4>
                                            <h3 id="F-deliveryDate">04 April 2022</h3>
                                        </div>
                                    </div>
                                </div>
                           </div>
                       </div>
                   </div>
                   <div class="folder-remarks-info">
                        <div class="row">
                            <dt class="col-sm-3 col-12">
                                <div class="col-remarks label-info">
                                    Remarks*
                                </div>
                            </dt>
                            <dd class="col-sm-9 col-12">
                                <div class="col-remarks label-val" id="RemarksVal">
                                    Not Available
                                </div>
                            </dd>
                            <dt class="col-sm-3 col-12">
                                <div class="col-remarks label-info">
                                    Comments*
                                </div>
                            </dt>
                            <dd class="col-sm-9 col-12">
                                <div class="col-remarks label-val" id="CommentsVal">
                                    Not Available
                                </div>
                            </dd>
                        </div>
                   </div>
               </div> 
               <div class="col-md-6 col-12">
                   <div class="custom-track-timeline">
                       <div class="card panel-content-card">
                           <div class="card-inner">
                               <div class="timeline-card-header">
                                   <h3>Timeline</h3>
                               </div>
                               <div class="timeline-card-body">
                                    <ul class="track-timeline">
                                        <li class="track-timeline-item action-done">
                                            <span class="track-timeline-span">
                                                <h6 class="tracked-label">Upload</h6>
                                                <h3 class="tracked-status" id="uploadedDate">02 April 2022</h3>
                                            </span>
                                        </li>
                                        <li class="track-timeline-item">
                                            <span class="track-timeline-span">
                                                <h6 class="tracked-label">Review</h6>
                                                <h3 class="tracked-status" id="reviewDate">03 April 2022</h3>
                                            </span>
                                        </li>
                                        <li class="track-timeline-item">
                                            <span class="track-timeline-span">
                                                <h6 class="tracked-label">Editing Started</h6>
                                                <h3 class="tracked-status" id="editingDate">03 April 2022</h3>
                                            </span>
                                        </li>
                                        <li class="track-timeline-item">
                                            <span class="track-timeline-span">
                                                <h6 class="tracked-label">Complete</h6>
                                                <h3 class="tracked-status" id="completedDate">05 April 2022</h3>
                                                <p class="tracked-download"><a href="#" class="btn final-download-btn" id="finalDownloadBTN">Download Images</a></p>
                                            </span>
                                        </li>
                                    </ul>
                               </div>
                           </div>
                       </div>
                   </div>
               </div> 
            </div>
        </div>
    </div>

    <script src="plugins\bootstrap-5.1.3-dist\js\bootstrap.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    @endsection