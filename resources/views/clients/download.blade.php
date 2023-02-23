@extends('layouts.client')
@section('title')
Flipkart Panel | Upload Images Zip
@endsection
@section('content')

<div class="body-container-wrapper">
    <div class="container-lg container-fluid">
        <div class="row template-row">
            <div class="col-12">
               <p class="text-center text-warning">{{session()->pull('message')}}</p>

               <div class="custom-panel-title-action">
                <div class="title-action-panel col-action-panel">
                    <h1>
                        <span class="info-text info-span">
                            All Uploads
                        </span>
                        <span class="info-icon info-span" data-toggle="tooltip" data-placement="top" title="View your all uploads">
                            i
                        </span>
                    </h1>
                </div>
                <div class="button-action-panel col-action-panel">
                    <a href="/home" class="btn download-btn" id="HomeBTN">
                        Home
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="custom-panel-table custom-all-uploads-table">
                <div class="card panel-content-card">
                    <div class="card-inner">
                        <div class="table-responsive" style="height: 600px;">
                            <table class="table table-head-fixed data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Upload Date</th>
                                        <th>Upload Count</th>
                                        <th>Status</th>
                                        <th width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($totalImgCount as $file)
                                    <tr>
                                       <td>{{dateFormat($file['created_at'])}}</td>
                                       <td>{{($file['imgcount'])}}</td>
                                       <td>
                                        @if($file['status'] == 1)
                                        <span class="badge status-badge"></span>
                                        <span class="status-value">Completed</span> 
                                        @else
                                        <span class="badge status-badge"></span>
                                        <span class="status-value">Active</span> 
                                        @endif
                                    </td>
                                    <td width="100px">
                                       <td width="100px">
                                        <a href="javascript:;" class="btn td-comment-btn" data-wrc_id="{{($file['wrcId'])}}"id="commentBTN3" data-bs-toggle="modal" data-bs-target="#commentModal" onclick="wrcComment(this)">Comment</a>
                                        <a href="{{route('flipkart.track')}}" class="btn td-track-btn" id="trackBTN3">Track</a>
                                        <a href="#" class="btn td-download-btn" data-bs-toggle="modal" data-bs-target="#imageListingModal" data-wrc_id="{{($file['wrcId'])}}" id="downloadBTN3" onclick="downlodEfile(this)">Download</a>
                                    </td>
                                </tr>@endforeach
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

<!-- Comment Modal -->

<div class="modal-group">
    <div class="row modal-row">
      <div class="col-12">
        <div class="modal fade custom-global-modal comment-modal" id="commentModal" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog global-modal-dialog">
            <div class="modal-content global-modal-content comment-modal-content">
              <div class="modal-body comment-modal-body">
                <div class="modal-close" data-bs-dismiss="modal">
                  <i class="fa fa-times"></i>
              </div>
              <form method="POST" action="/save-wrc-flip-comment" class="comment-form" id="commentForm">
                 @csrf
                 <div class="row wrcComment" id="wrcComment">

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
<div class="modal fade custom-global-modal image-listing-modal" id="imageListingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog global-modal-dialog">
        <div class="modal-content global-modal-content imagelisting-modal-content">
          <div class="modal-body imagelisting-modal-body">
            <div class="modal-close" data-bs-dismiss="modal">
              <i class="fa fa-times"></i>
          </div>
          <div class="custom-file-infor">
            <div class="col-file-info info1">
                <h6>File Uploaded</h6>
            </div>
            <div class="col-file-info info2 ">
                <h6>
                    Download
                </h6>
            </div>
        </div>
        <div class="file-uploaded-list edownload" id="edownload">
        
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>


<!-- End of Comment Modal -->

<script src="plugins\bootstrap-5.1.3-dist\js\bootstrap.bundle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script type="text/javascript">

    function wrcComment(obj) {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        var wrc_id = $(obj).data('wrc_id');
        $.ajax({
            headers:headers,
            url: "/wrc-flip-comment",
            method: 'GET',
            dataType: "html",
            data: {wrc_id: wrc_id},
            success: function (htmlData) {
                $('.wrcComment').html(htmlData);
            }

        });

    }



function downlodEfile(obj) {
    var headers = {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
      var wrc_id = $(obj).data('wrc_id');

    $.ajax({
        headers:headers,
        url: "/efiles-download",
        method: 'GET',
        dataType: "html",
        data: {wrc_id: wrc_id},
        success: function (htmlData) {
            $('.edownload').html(htmlData);

        }

    });

}

</script>
@endsection