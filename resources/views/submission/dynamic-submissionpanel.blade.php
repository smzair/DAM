<head>    
  <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<div class="modal-body">
    <div class="row m-0">
        <div class="col-sm-6 col-12">@foreach($SubmissionList as $submission)
          <h5 class="m-0">Total Images Count : <strong>{{$submission->image_count}}</strong></h5>
          <div class="detail-list mt-4">
            <ul class="list-unstyled m-0 p-0">
                <li class="mb-3">
                    <span class="d-block">Company : <strong>{{$submission->Company}}</strong></span>
                </li>
                <li class="mb-3">
                    <span class="d-block">Client Id : <strong>{{$submission->client_id}}</strong></span>
                </li>
                <li class="mb-3">
                    <span class="d-block">LOT Number : <strong>{{$submission->lot_id}}</strong></span>
                </li>
                <li class="mb-3">
                    <span class="d-block">WRC Number : <strong>{{$submission->wrc_id}}</strong></span>
                </li>
                <li class="mb-3">
                    <span class="d-block">Inwarded SKUs Count : <strong>{{$inwarded_count}}</strong></span>
                </li>
                <li class="mb-3">
                    <span class="d-block">Rejected SKUs Count : <strong>{{$rejected_count}}</strong></span>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-sm-6 col-12 mt-4 mt-sm-0">

            <div class="form-group">
                <label>Submitted SKU Codes</label>
                <select multiple="" class="custom-select sku-selc" style="height: 160px;" disabled="">
                    @foreach($submission->skus as $sku)
                    <option>{{$sku->sku_code}}</option>
                    @endforeach
                </select>
            </div>
        
    </div>
</div>
<div class="row mt-5 px-3">
    <div class="col-sm-5 col-12 mb-3 mb-sm-0">
        <div class="first-image-action">
            <h5 class="mb-3 text-center text-uppercase" style="font-size: 1.1rem;">Submit First Angle Images</h5>
            <p>
                <a href="#" class="btn btn-block btn-warning dwn-btn">Generate Download Link</a>
                <input type="text" class="form-control mt-3 d-none" id="geninput2" name="geninput2" value="{{asset('/first-angle-downlaod')}}/{{$encodedWrcId}}">
            </p>
          
        </div>
    </div>
    <div class="col-sm-2 col-12 mb-3 mb-sm-0" style="align-self: center;">
        <div class="payment-indicator text-center text-uppercase">
            <p class="m-0 small text-bold">Payment</p>
            <p class="m-0 mt-1 small">
                <span class="badge d-inline-block rounded-circle p-lg-2 p-md-2 p-sm-2 p-2 mt-1" style="background: #FF0000; cursor: pointer; margin-right: 4px;"></span>
                <span class="badge d-inline-block rounded-circle p-lg-2 p-md-2 p-sm-2 p-2 mt-1" style="background: #00CC00; cursor: pointer;"></span>
            </p>
        </div>
    </div>
    <div class="col-sm-5 col-12">
        <div class="all-image-action">
            <h5 class="mb-3 text-center text-uppercase" style="font-size: 1.1rem;">Submit All Images</h5>
            <p>
                <a href="#"  class="btn btn-block btn-warning dwn-btn">Generate Download Link</a>
                <input type="text" class="form-control mt-3 d-none" id="geninput2" name="geninput2" value="{{asset('/full-angle-downlaod')}}/{{$encodedWrcId}}">
            </p>
            
        </div>
        
    </div>
    
    <div class= "row ">
        
        <div class="col-12">
    @if($submission->sku_count != $inwarded_count - $rejected_count)
    
       <p class="text-center"> Submission count doesn't match final submission count hence wrc cannot be marked submitted.
    @else  
    <p><a  data-wrc_id="{{$wrcId}}" onclick="firstangle(this)" class="btn btn-block btn-warning dwn-btn text-center" > Mark Wrc as Submitted 
            
               
           
             
             </a>
         
             
             
               
             @endif
             </p>
             </div>
             
             
             </div>
       
           
    @endforeach
    
</div>

<script type="text/javascript">

    $(document).on('click', '.client-panel-btn', function () {
        $(this).children('.badge').addClass('d-inline-block');
    });

    $(document).on('click', '.dwn-btn', function () {
        $(this).next('.form-control').addClass('d-inline-block');
    });
    
     function firstangle(obj) {
     
 
     
         
        var wrc_id = $(obj).data('wrc_id');
        var headers = {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

    $.ajax({
      headers: headers,
            url: "/first-submitted",
            method: 'POST',
            dataType: "html",
            data: {wrc_id: wrc_id},
            success: function (htmlData) {
              window.location.reload();
            }
        });
    }
    
    function fullangle(obj) {
        var wrc_id = $(obj).data('wrc_id');
       var headers = {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

    $.ajax({
      headers: headers,
            url: "/full-submitted",
            method: 'POST',
            dataType: "html",
            data: {wrc_id: wrc_id},
            success: function (htmlData) {
              
            }
        });
    }
</script>   