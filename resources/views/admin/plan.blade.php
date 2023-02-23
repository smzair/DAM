@extends('layouts.admin')
@section('title')
Plan Shoots
@endsection
@section('content')

<style type="text/css">
    .upld-btn {
        float: right;
    }
    .dwn-btn{
        float: right;
        margin-right: 3px ;
    }

</style>


<div class="container-fluid mt-5 plan-shoot">
    <div class="row">
        <div class="col-md-6 col-12 sku-shh-up" style="display:none;">
            <div class="card card-transparent">
                <div class="card-header">
                    <label class="text-center d-block required m-0" style="font-size: 24px; font-weight: 300;">
                        Upload SKUs
                        <span class="close sku-shh-close" style="cursor: pointer;">
                            <i class="fas fa-times-circle"></i>
                        </span>
                    </label>
                </div>
                <div class="card-body">
                    <div class="file-upload-wrapper col-slide-sku-wrap">
                        <form method="POST" action="" id="upload">
                            @csrf
                            <input type="file" id="sku-input-file-now" class="file-upload-sku-2" name="plansheet" />
                            <button type="submit" class="btn btn-warning btn-md">Upload</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        
  
        <div class="col-12">
            <div class="card card-transparent">
                <div class="card-header">
                    <div class="mailbox-controls float-left">
                        <!-- Check all button -->
                        <a href="javaScript:void(0)" class="btn btn-default btn-sm checkbox-toggle-popup float-left mr-2" style="display: none;" onclick="showSelectedSkus()">
                            @if ($isShoot === 0)
                            Click To Plan
                            @endif
                            @if ($isShoot === 1)
                            Click To Re-Plan
                            @endif
                        </a>
                        <div class="btn-group check-pop">
                        <input id="selectAll" type="checkbox" class="checkbox-toggle" style="margin-top: 5px;">
                            <label for="selectAll" class="pl-1 m-0 align-text-bottom" style="cursor: pointer;">Select All</label> &nbsp;

                        </div>

                    </div>
                    <a href="javascript:;" class="btn upld-btn">Uplaod SKU CSV to Plan</a>
                    <a href="{{route('downloadfileplan')}}" class="btn dwn-btn">Download Plan SKU CSV</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" id="skucctt"  style="max-height: 700px; height: 100%;">
                    <table class="table data-table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th class="align-middle">LOT Numbers</th>
                                <th class="align-middle">WRC Numbers</th>
                                <th class="align-middle">Company</th>
                                <th class="align-middle">Brand</th>
                                   @if ($isShoot === 0)
                                <th class="align-middle">Location</th>
                                   @endif
                                <th class="align-middle">Service Type</th>
                                 <th class="align-middle">AM Name</th>
                                <th class="align-middle">Inward Date</th> 
                                <th class="align-middle">Wrc Ageing</th> 
                                @if ($isShoot === 1)
                                <th class="align-middle">Date of plan</th>
                                <th class="align-middle">Studio</th>
                                @endif
                                <th class="align-middle">Shoot Type</th>
                                <th class="align-middle">Clothing</th>
                                <th class="align-middle">SKU Count</th>
                                <th class="align-middle">Article</th>
                                <th class="align-middle">View All SKUs</th>
                            </tr>
                        </thead>
                        <tbody id="#accordion1">
                            @foreach($wrcs as $index => $wrc)
                            <tr class="tr-pre">
                                <td width="10px">
                                    <input type="checkbox" data-wrc_name = "{{$wrc->wrc_id}}" data-wrc_id = "{{$wrc->id}}" data-index = "{{$index}}" id="checkall{{$wrc->id}}" class="check-ln" style="position: relative; top:2px;">
                                </td>
                                <td>{{$wrc->lot_id}}</td>
                                <td>{{$wrc->wrc_id}}</td>
                                <td>{{$wrc->Company}}</td>
                                <td>{{$wrc->name}}</td>
                                  @if ($isShoot === 0)
                              <td>{{$wrc->location}}</td>
                               @endif
                                <td>{{$wrc->s_type}}</td>
                                <td>{{ucwords(strtolower(strstr($wrc->am_email,'.',true)))}}</td>
                                <td>{{dateFormat($wrc->created_at)}}</td>
                                <td>{{now()->diffInDays( Carbon\Carbon::parse($wrc->created_at))}}</td>
                                @if ($isShoot === 1)
                                <td>{{$wrc->date}}</td>
                                <td>{{$wrc->studio}}</td>
                                @endif
                                <td>{{$wrc->type_of_shoot}}</td>
                                <td>{{$wrc->type_of_clothing}}</td>
                                <td>{{count($wrc->skus)}}</td>
                                <td>{{$wrc->product_category}}</td>
                                <td class="accordion-toggle collapsed" id="accordion{{$wrc->id}}_{{$index}}" data-toggle="collapse" href="#sku_list_{{$wrc->id}}_{{$index}}" aria-expanded="false"><i class="fa fa-plus" style="width: 100px; text-align: center; cursor: pointer;"></i></td>
                            </tr>
                            <tr id="sku_list_{{$wrc->id}}_{{$index}}" class="collapse" data-parent="#accordion{{$wrc->id}}_{{$index}}">
                                <td colspan="12">
                                    <div id="collapsediv{{$wrc->id}}">
                                        <div class="container mb-3 ml-3">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <span class=""><strong>Primary Guideline:</strong></span>
                                                    <span class="">{{$wrc->adaptation_1}}</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class=""><strong>Gender:</strong></span>
                                                    <span class="">{{$wrc->gender}}</span>
                                                </div>
                                                <div class="">
                                                    <span class="col-md-4"><strong>Adaptations:</strong></span>
                                                    <span class="">{{$wrc->adaptation_2}}|{{$wrc->adaptation_3}}|{{$wrc->adaptation_4}}|{{$wrc->adaptation_5}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($isShoot === 1)
                                        <table class="table m-0">
                                            <tbody>
                                                <tr>
                                                    <td colspan="8" class="text-center">
                                                        <h3 class="m-0">Planning Details</h3>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="border-0">
                                                        <span >Photographer: <strong>{{$wrc->photographer}}</strong></span>
                                                    </td>
                                                    <td class="border-0">
                                                        <span >Stylist: <strong>{{$wrc->stylist}}</strong></span>
                                                    </td>
                                                    <td class="border-0">
                                                        <span >Makeup Artist: <strong>{{$wrc->makeupartist}}</strong></span>
                                                    </td>
                                                    <td class="border-0">
                                                        <span >Raw QC: <strong>{{$wrc->rawqc}}</strong></span>
                                                    </td>
                                                    <td class="border-0">
                                                        <span >Model: <strong>{{$wrc->model}}</strong></span>
                                                    </td>
                                                    <td class="border-0">
                                                        <span >Agency: <strong>{{$wrc->agency}}</strong></span>
                                                    </td>
                                                    <td class="border-0">
                                                        <span >Assistant: <strong>{{$wrc->assistant}}</strong></span>
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                        @endif
                                        <table class="table  data-table">
                                            <thead>
                                                <tr class="">
                                                    <th>SKU Codes</th>
                                                    <th>Category</th>
                                                    <th>Sub Category</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($wrc->skus as $sku)
                                                <tr class="">
                                                    <td>
                                                        <input type="checkbox" data-wrc_id="{{$wrc->id}}" data-sku_code = "{{$sku->sku_code}}" data-sku_id="{{$sku->id}}" id="check{{$sku->id}}" class="allcheck">
                                                        <span class="ml-1">{{$sku->sku_code}}</span>
                                                    </td>
                                                    <td>{{$sku->subcategory}}</td>
                                                    <td>{{$sku->category}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="modal fade" id="shoot_plan_modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header py-2">
                            <h4 class="modal-title">Allocate Bay</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                                    aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="plan-form" id="day_shoot_form" method="POST" action="">
                                @csrf
                                <div id="d-sku-plan"></div>
                                 <div id="plan-sku"></div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="required">Select Bay</label>
                                            <select class="form-control select2" name="dayplan" data-placeholder="--Select Bay--" style="width: 100%;" required>
                                                <option value="">--Select Bay--</option>
                                                @foreach($dayplan as $day)
                                                <option value="{{$day->id}}">{{dateFormat($day->date)}} {{SEPARATOR}} {{$day->studio}}  {{SEPARATOR}}  {{$day->photographer}}  {{SEPARATOR}}  {{$day->model}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <a href="javaScript:void(0)" class="btn btn-warning" onclick="planShoot()">Plan Shoot</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
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
            <li><b>Either you can choose to plan the entire WRCs at one go or you can choose individual SKUs and plan your shoot accordingly.</b></li>
        </ul>
    </div>
</div>

<script type="application/javascript" src="plugins/jquery/jquery.min.js"></script>
<script type="application/javascript" src="plugins/jquery-ui/jquery-ui.min.js"></script>

<script src="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/js/plugins/mdb-file-upload.min.js"></script>

<script type="text/javascript">

                                            $('.file-upload-sku-2').file_upload();

                                            $(document).on('click', '.upld-btn', function () {
                                                $('.sku-shh-up').slideDown(250);
                                            });

                                            $(document).on('click', '.sku-shh-close', function () {
                                                $('.sku-shh-up').slideUp(250);
                                            });

                                            $("#upload").submit(function (e) {
                                                e.preventDefault();
                                                var current_progress = 0;
                                                var formData = new FormData(this);
                                                $.ajax({
                                                    url: "/plan-sku-sheet",
                                                    type: 'post',
                                                    data: formData,
                                                    dataType: 'html',
                                                    success: function (htmlData) {
                                                        $('#plan-sku').html(htmlData);
                                                        select2();
                                                        $('#shoot_plan_modal').modal();

                                                    },
                                                    cache: false,
                                                    contentType: false,
                                                    processData: false
                                                });
                                            });

</script>

@endsection