@extends('layouts.admin')

@section('title')
@if ($id === 0)
Create LOT
@else
Update LOT
@endif
@endsection
@section('content')

<link rel="stylesheet" href="{{asset('plugins/datepicker-in-bootstrap-modal/css/datepicker.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<div class="container-lg container-fluid my-5 lot-create-updateversion">
    <div class="row">
        <div class="col-sm-5 col-12">
            <div class="card card-transparent text-center" style="border-radius:20px;">
                @if ($id === 0)
                <div class="card-body py-5">

                </div>
                @else
                <div class="card-body py-5">
                    Lot No - <span class="text-bold d-inline-block">{{$lotInfo->lot_id}}</span>
                </div>
                @endif

            </div>
        </div>
        

        <div class="col-sm-2 col-12 d-none d-sm-flex" style="align-items: center;">
            <div class="custom-lots-button mb-3 mb-sm-0">
                @if ($id === 0)
                
                @else
                <a href="{{route('downloadfile')}}" class="btn btn-sm btn-warning btn-block">Download Master Sheet</a>
                <button type="button" id="upld-sheet" class="btn btn-sm btn-warning btn-block" data-toggle="modal" data-target="#upld-sku-sheet-modal">Upload Sheet</button>
                @endif
            </div>
        </div>



        @if ($id === 0)
        <div class="col-sm-5 col-12">
            <div class="card card-transparent text-center" style="border-radius:20px;">
                <div class="card-body py-5">

                    Total Article Count - <span class="text-bold d-inline-block">0</span>

                </div>
            </div>
        </div>
        @else
        <div class="col-sm-5 col-12">
            <div class="card card-transparent text-center" style="border-radius:20px;">
                <div class="card-body py-5">
                    Total Article Count - <span class="text-bold d-inline-block">{{$sku}} Inwarded</span>
                </div>
            </div>
        </div>
        @endif
        
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card card-transparent m-0">
          <!-- <div class="card-header">
              <h3 class="card-title">First</h3>
          </div> -->
          <!-- /.card-header -->
          <div class="card-body">
            <form method="POST" action="{{route('savelots')}}">

                <input type="hidden" name="c_short" id="c_short" value="<?php echo isset($lotInfo->c_short) ? $lotInfo->c_short : ''; ?>">
                <input type="hidden" name="short_name" id="short_name" value="<?php echo isset($lotInfo->short_name) ? $lotInfo->short_name : ''; ?>">
                <div class="row custom-select-row">
                 @csrf
                 <input type="hidden" name="id" value="{{$id}}">
                 <div class="col-sm-4">
                   <div class="form-group">
                       <label class="control-label required">Brand</label>
                       <select  class="form-control select2 brand" id="brand_id" name="brand_id"  data-placeholder = "Select Company">
                           <option disabled selected>Please Select</option>
                           @foreach ( $brands  as $brand)
                           <option <?php echo (!empty($lotInfo->brand_id) && $lotInfo->brand_id == $brand->id) ? 'selected' : ''; ?> value="{{$brand->id}}" data-short_name = "{{$brand->short_name}}">{{$brand->name}}</option>
                           @endforeach
                       </select>
                   </div>
               </div>
               <div class="col-sm-4" id="company_list_html">{!! $companyListHtml !!}</div>
               <div class="col-sm-4" id="service_list_html">{!! $lotServicesListHtml !!}</div>
               <div class="col-sm-4" id="shootLocationCol">
                <div class="form-group">
                    <label class="control-label required">Location</label>
                    <select class="form-control" name="Location" id="shootLocation">
                     
                       @if ($id === 0)
                       <option value="locationSelect" selected>Please select location</option>
                       @else
                       <option value="{{$lotInfo->location}}" selected>{{$lotInfo->location}}</option>
                       @endif
                       <option value="Delhi">Delhi</option>
                       <option value="Bangalore">Bangalore</option>
                   </select>
               </div>
           </div>
           <div class="col-sm-4" id="verticalTypeCol">
            <div class="form-group">
                <label class="control-label required">Vertical Type</label>
                <select class="form-control"  name="verticalType" id="verticalType">
                 

                    @if($id === 0)
                    <option value="typeSelect" selected>Please select type</option>
                    @else
                    <option value="{{$lotInfo->verticleType}}" selected >{{$lotInfo->verticleType}}</option>
                    @endif
                    
                    <option value="Reshoot" >Reshoot</option>
                    <option value="New Shoot">New Shoot</option>
                    <option value="Editing">Editing</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4" id="clientBucketCol">
            <div class="form-group">
                <label class="control-label required">Client Bucket</label>
                <select class="form-control client-bucket-select" name="clientBucket" id="clientBucket">
                    @if($id === 0)
                    <option value="selectClientBucket">Please select client bucket</option>
                    @else
                    <option value="{{$lotInfo->clientBucket}}" selected>{{$lotInfo->clientBucket}}</option>
                    @endif
                    
                    
                    <option value="New">New</option>
                    <option value="Existing">Existing</option>
                     <option value="Cancel">Cancel</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row custom-select-row">
        <div class="col-sm-12 shoot-handover-date d-none" id="">
            <div class="form-group">
                <label class="required">Shoot handover date</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                    @if ($id === 0)
                    <input type="text" class="form-control" name="shoothandoverDate" id="shootHandoverDate" placeholder="yyyy-mm-dd" data-toggle="datepicker">
                    @else
                    <input type="text" class="form-control" name="shoothandoverDate" value="{{$lotInfo->shoothandoverDate}}" id="shootHandoverDate" placeholder="yyyy-mm-dd" data-toggle="datepicker">
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-12 mb-3">
            @if ($id === 0)
            <button type="submit" class="btn btn-sm btn-warning md-2" >Create Lot</button>
            @else
            <button type="submit" class="btn btn-sm btn-warning md-2" >Update Lot</button>
            @endif
        </div>
    </div>
</form>
<div class="custom-edit-table">
    <div class="tb-title">
        <h5>SKU Sheet</h5>
    </div>
    @if ($id === 0)
    <div class="tb-title">
        <h6>Create LOT To Start Inwarding</h6>
    </div>
    
    @else
    @if ($sku === 0)
    <div class="tb-title">
        <h6>Uplaod SKU Sheet</h6>
    </div>
    @else
    <div class="edit-cc-content table-responsive" >
        <table class="table edt-table text-nowrap m-0">
            <thead>
                <tr>
                    <th class="align-middle">Id</th> 
                    <th class="align-middle">Sku Code</th>
                    <th class="align-middle">Gender</th>
                    <th class="align-middle">Category</th>
                    <th class="align-middle">Type of clothing</th>
                </tr>
            </thead>
            <tbody>
                @foreach($skus as $sku)<tr>
                    <td class="align-middle td-data index-tddata">{{$sr++}}</td>
                    <td class="align-middle td-data">{{$sku->sku_code}}</td>
                    <td class="align-middle td-data">{{$sku->gender}}</td>
                    <td class="align-middle td-data">{{$sku->category}}</td>
                    <td class="align-middle td-data">{{$sku->type_of_clothing}}</td>
                    
                </tr>@endforeach
            </tbody>
        </table>
    </div>
    @endif
    
    @endif
    
</div>
</div>
</div>
</div>
</div>
<div class="modal fade" id="upld-sku-sheet-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload SKU</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="upload-sheet-in-lot">
                    <form metod="post" action="" id="upload_sku_form" enctype='multipart/form-data' >
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                @if ($id === 0)
                                
                                @else
                                <input type="hidden" name="lot_id" value="{{$lotInfo->id}}">
                                
                                @endif

                                <div class="file-upload-wrapper">
                                    <input type="file" id="input-file-now"  class="file-upload" name="skusheet" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-warning mb-2">Upload SKUs</button>
                            </div>
                        </div>
                    </form>
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
        <li><b>To generate a LOT, please select the brand name, company name, and the type of service. In case of any errors, kindly update the LOT as per the correct details.</b></li>
    </ul>
</div>
</div>

<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

<script type="application/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<script type="application/javascript" src="{{asset('plugins/datepicker-in-bootstrap-modal/js/datepicker.js')}}"></script>

<script src="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/js/plugins/mdb-file-upload.min.js"></script>

<script type="text/javascript">
 
 $('[data-toggle="datepicker"]').datepicker({
    autoHide: true,
    zIndex: 2048,
    format: 'yyyy-mm-dd'
});

 $('.file-upload').file_upload();


 function savelots(){

    showLoader();
    $.ajax({
      url: "/save-lots",
      method: 'POST',  
      dataType: "json",
      data:  $('#Create_lots').serialize(),
      success: function(data) {

      }

  });
}

$(".client-bucket-select").change(function () {
    if ($(this).val() == "New") {
        $(this).parents(".custom-select-row").siblings().children('.shoot-handover-date').removeClass('d-none');
        $(this).parents(".custom-select-row").siblings().children('.shoot-handover-date').addClass('d-block');
    } else if ($(this).val() == "Existing") {
        $(this).parents(".custom-select-row").siblings().children('.shoot-handover-date').addClass('d-none');
        $(this).parents(".custom-select-row").siblings().children('.shoot-handover-date').removeClass('d-block');
    }
});



</script>
@endsection
