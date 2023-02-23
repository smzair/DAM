@extends('layouts.admin')
@section('title')
View & Add New Day 
@endsection
@section('content')



<title>View & Add New Day </title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{asset('plugins/datepicker-in-bootstrap-modal/css/datepicker.css')}}">
<link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
<link href="https://fonts.googleapis.com/css2?family=Lustria&display=swap" rel="stylesheet">


<style type="text/css">
    .table td {
        border: 0 !important;
    }

    .table td,
    .table th {
        vertical-align: middle !important;
    }

    .lot-list li {
        cursor: pointer;
    }

    select {
        background: #ffffff;
    }

    .wrc-tt>th,
    .wrc-tt>td {
        white-space: normal !important;
    }

    .card-title {
        color: #ccc;
        font-family: 'Lustria', serif;
        letter-spacing: 2px;
        font-weight: bold;
        text-align: center;
        font-size: 2.5rem;
        line-height: 1.4;
    }

    .toggle-on,
    .toggle-off {
        font-weight: 400 !important;
    }

    /* .mobile-trigger {
        background-color: transparent;
        height: 35px;
        width: 35px;
        border-radius: 4px;
        position: relative;
        padding: 0;
        margin: 0;
        border: 1px solid #fff;
        background: #fff;
        outline: 0;
        margin-bottom: 20px;
    }

    .mobile-trigger:hover,
    .mobile-trigger:focus {
        background-color: #000;
        outline: 0;
    }

    .mobile-trigger svg path {
        fill: #ccc;
    } */

    .date-open .date-range {
        display: block !important;
    }

    .date-open .single-date {
        display: none;
    }


    /* Switch starts here */
    .rocker {
        display: inline-block;
        position: relative;
    /*
    SIZE OF SWITCH
    ==============
    All sizes are in em - therefore
    changing the font-size here
    will change the size of the switch.
    See .rocker-small below as example.
    */
        font-size: 2em;
        font-weight: bold;
        text-align: center;
        text-transform: uppercase;
        color: #888;
        width: 7em;
        height: 4em;
        overflow: hidden;
        border-bottom: 0.5em solid #eee;
    }

    .rocker-small {
        font-size: 0.75em;
        margin: 0 !important;
    }

    .rocker::before {
        content: "";
        position: absolute;
        top: 0.5em;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #999;
        border: 0.5em solid #eee;
        border-bottom: 0;
    }

    .rocker input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .switch-left,
    .switch-right {
        cursor: pointer;
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 2.5em;
        width: 3em;
        transition: 0.2s;
    }

    .switch-left {
        height: 2.4em;
        width: 2.75em;
        left: 0.85em;
        bottom: 0.4em;
        background-color: #ddd;
        transform: rotate(15deg) skewX(15deg);
    }

    .switch-right {
        right: 0.5em;
        bottom: 0;
        background-color: #fbf702;
        color: #000 !important;
    }

    .switch-left::before,
    .switch-right::before {
        content: "";
        position: absolute;
        width: 0.4em;
        height: 2.45em;
        bottom: -0.45em;
        background-color: #ccc;
        transform: skewY(-65deg);
    }

    .switch-left::before {
        left: -0.4em;
    }

    .switch-right::before {
        right: -0.375em;
        background-color: transparent;
        transform: skewY(65deg);
    }

    input:checked + .switch-left {
        background-color: #fbf702;
        color: #000 !important;
        bottom: 0px;
        left: 0.5em;
        height: 2.5em;
        width: 3em;
        transform: rotate(0deg) skewX(0deg);
    }

    input:checked + .switch-left::before {
        background-color: transparent;
        width: 3.0833em;
    }

    input:checked + .switch-left + .switch-right {
        background-color: #ddd;
        color: #888;
        bottom: 0.4em;
        right: 0.8em;
        height: 2.4em;
        width: 2.75em;
        transform: rotate(-15deg) skewX(-15deg);
    }

    input:checked + .switch-left + .switch-right::before {
        background-color: #ccc;
    }

    /* Keyboard Users */
    input:focus + .switch-left {
        color: #333;
    }

    input:checked:focus + .switch-left {
        color: #fff;
    }

    input:focus + .switch-left + .switch-right {
        color: #fff;
    }

    input:checked:focus + .switch-left + .switch-right {
        color: #333;
    }

</style>

<body>
    <div class="lot-table mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-transparent">
                        <div class="card-header border-transparent py-5 text-center" style="background-color: rgba(0,0,0,.03);">
                          <h2 class="card-title float-none text-uppercase" style="cursor: pointer;" data-toggle="modal"
                          data-target="#modal-lg">
                          <i class="fa fa-plus" aria-hidden="true"></i>
                          <span>Add New Day</span>
                      </h2>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                      <div class="table-responsive">
                        <table class="table m-0">
                          <thead>
                              <tr>
                                <th>Plan Date</th>
                                <th>Studio</th>
                                <th>Photographer</th>
                                <th>Stylist</th>
                                <th>Makeup Artist</th>
                                <th>Raw QC</th>
                                <th>Model</th>
                                <th>Agency</th>
                                <th>Assistant</th>
                                <th class="pr-2" width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($days as $day)
                            <tr>
                                <td>{{$day->date}}</td>
                                <td>{{$day->studio}}</td>
                                <td>{{$day->photographer}}</td>
                                <td>{{$day->stylist}}</td>
                                <td>{{$day->makeupartist}}</td>
                                <td>{{$day->rawqc}}</td>
                                <td>{{$day->model}}</td>
                                <td>{{$day->agency}}</td>
                                <td>{{$day->assistant}}</td>
                                <td class="pr-3">
                                    
                                     <a href="#" data-id="{{$day->id}}"onclick="edit(this)" class="btn btn-sm btn-warning py-1 px-3 mb-2 bg-warning"  >Edit </a>
                                    
                                    <a href="{{('/delete/bay/'.$day->id) }}" class="btn btn-sm btn-danger py-1 px-3 mb-2 bg-danger"  >Delete</a>
                                    
                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="modal-lg">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h4 class="modal-title">Add Details For The Day</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                                <!-- <button type="button" class="mobile-trigger">
                                    <svg class="gb_We" focusable="false" viewBox="0 0 24 24"><path d="M6,8c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM12,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM6,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM6,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM12,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM16,6c0,1.1 0.9,2 2,2s2,-0.9 2,-2 -0.9,-2 -2,-2 -2,0.9 -2,2zM12,8c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM18,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM18,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2z"></path></svg>
                                </button> -->

                                <form id="dayform" class="plan-form" method="POST" action="/save-day">
                                    @csrf
                        <input type="hidden" name="id" id="id" value="">

                                    <div class="row">
                                    <div class="col-sm-4">
                                    <div class="form-group single-date">
                                    <label class="required">Select Date</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                   <span class="input-group-text">
                                 <i class="far fa-calendar-alt"></i>
                                                        </span>
                                    </div>
        <input type="text" class="form-control start-d-input px-2" id="date" value="" name="date" placeholder="yyyy-mm-dd" data-toggle="datepicker"  >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="required">Studio</label>
                                                <select name="studio" id="studio" value="" class="form-control" name="studio" >
                                                    
                                                    <option selected disabled>Please Select</option>
                                                    <option>Delhi Studio Model 1</option>
                                                    <option>Delhi Studio Model 2</option>
                                                    <option>Delhi Studio Model 3</option>
                                                    <option>Delhi Studio Model 4</option>
                                                    <option>Delhi Studio Model 5</option>
                                                    option>Delhi Studio Product 6</option>
                                                    <option>Delhi Studio Product 7</option>
                                                    <option>Delhi Studio Product 8</option>
                                                    <option>Delhi Studio Product 9</option>
                                                    
                                                    <option>Bengaluru Studio 1</option>
                                                    <option>Bengaluru Studio 2</option> 
                                                    <option>Bengaluru Studio 3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="required">Photographer</label>
                                                <input  id="photographer" value="" class="form-control" name="photographer" type="text"  placeholder="Photographer"  >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row custom-select-row">
                                        <div class="col-sm-6">
                                           <div class="form-group">
                                            <label class="required">Shoot Hours</label>
                                            <select id="shoot_hour" value=""  name="shoot_hour" class="form-control shoot-select" 
                                            >
                                                <option selected disabled>Please Select</option>
                                                <option value="Half_Day">Half Day</option>
                                                <option value="Half_Night">Half Night</option>
                                                <option value="Full_Day">Full Day</option>
                                                <option value="Full_Night">Full Night</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="required">Type of shoot</label>
                                            <select name="shootType" id="shootType" value="" class="form-control shoot-select" >
                                                <option selected disabled>Please Select</option>
                                                <option value="Shoot_1">Model Shoot</option>
                                                <option value="Shoot_2">Product Shoot</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                      <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="required">Assistant</label>
                                        <input type="text" id="assistant" value="" class="form-control" 
                                        name="assistant" placeholder="Assistant" >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="required">Photographer Charges</label>
                                        <input type="text" id="photographer_charges" value="" class="form-control" 
                                        name="photographer_charges" placeholder="Photographer Charges" >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="required">Assistant Charges</label>
                                        <input type="text" id="assistant_charges" value="" class="form-control" 
                                        name="assistant_charges" placeholder="Assistant Charges" >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="required">Raw QC</label>
                                        <input class="form-control" id="rawqc" value="" type="text"  name="rawqc" placeholder="Raw QC Name" >
                                    </div>
                                </div>
                                </div>
                                <div class="row custom-select-row1 d-none">
                                    <div class="col-sm-4">
                                      <div class="form-group">
                                        <label class="required">Stylist</label>
                                        <input id="stylist" value="" class="form-control" type="text" 
                                        name="stylist" placeholder="Stylist" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="required">Stylist Charges</label>
                                        <input type="text" id="stylist_charges" value="" class="form-control" name="stylist_charges" placeholder=" Stylist Charges" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="required">Makeup Artist</label>
                                        <input id="makeupartist" value="" class="form-control" type="text" 
                                        name="makeupartist" placeholder="Makeup Artist Name" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="required">Makeup Artist Charges</label>
                                        <input type="text" id="makeup_charges" value=""  class="form-control" 
                                        name="makeup_charges" placeholder=" Makeup Artist Charges" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="required">Model Name</label>
                                        <input type="text" id="models" value="" class="form-control" name="models"
                                        placeholder=" Model Name" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="required">Model Charges</label>
                                        <input type="text" id="model_charges" value="" class="form-control" 
                                        name="model_charges" placeholder="Model Charges" >
                                    </div>
                                </div>
                                 <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="required">Extra Model Charges</label>
                                        <input type="text" id="extra_model_charges" value="" class="form-control" 
                                        name="extra_model_charges" placeholder="Extra Model Charges" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="required">Agency</label>
                                        <input class="form-control" id="agency" value="" type="text" name="agency"
                                        placeholder=" Agency Name" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="required">Model Available Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="model_available" value="" name="model_available" placeholder="yyyy-mm-dd" data-toggle="datepicker" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                           <div class="col-sm-12 col-12">
                            <div class="form-group">
                                <label for="Select All Equipments to be tag" class="required">Select All Equipments to be tag</label>
                                <select class="custom-select form-control select2" multiple="multiple" name="dayplan[]"data-placeholder="Select tags" style="width: 100%;">
                                    @foreach($list as $item)
                                    <option value="{{$item->id}}">{{$item->equipment_name}} | {{$item->vendor_name}} | Rs {{$item->equipment_cost}}</option>
                                    @endforeach
                                 
                                </select>
                            </div>
                        </div>
                            

                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn" style="background: #fbf702;">Save Plan</button>
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
        <li><b>To add a new plan, select the ‘add new day’ button and fill up all the required details.</b></li>
        <li><b>In case of any errors in the planning process, you can choose to delete your day by clicking on the ‘Delete’ button.</b></li>
        <li><b>Note<span style="color:red;">*</span>  this delete option is only valid if you haven’t planned any SKUs on this particular day.</b></li>
    </ul>
</div>
</div>

<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script type="application/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="application/javascript" src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('plugins/datepicker-in-bootstrap-modal/js/datepicker.js')}}"></script>
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>


<script type="application/javascript">

    $('input:checkbox').change(function(){
      if($(this).is(":checked")) {
          $('.lot-table').addClass("checkshow");
      } else {
          $('.lot-table').removeClass("checkshow");
      }
  });

    $('input:checkbox').click(function(){
        $('.lot-table').addClass("checkshow");
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });


    $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        zIndex: 2048,
        format: 'yyyy-mm-dd'
    });

    $('#reservation').daterangepicker();

    $('.switch-left').click(function(){
        $('body').addClass('date-open');
    });

    $('.switch-right').click(function(){
        $('body').removeClass('date-open');
    });



</script>


<script type="text/javascript">
    
    function edit(obj){
 var id = $(obj).data('id');

    console.log(id)
    $.get('/edit/' + id, function (data) {
       $('#modal-lg').modal('show');

         $('#id').val(data.data.id);
         $('#agency').val(data.data.agency);
         $('#assistant').val(data.data.assistant);
         $('#assistant_charges').val(data.data.assistant_charges);
         $('#date').val(data.data.date);
         $('#makeup_charges').val(data.data.makeup_charges);
         $('#makeupartist').val(data.data.makeupartist);
         $('#models').val(data.data.model);
         $('#shootType').val(data.data.shootType);
         $('#model_charges').val(data.data.model_charges);
         $('#model_available').val(data.data.model_available);
         $('#photographer').val(data.data.photographer);
         $('#photographer_charges').val(data.data.photographer_charges);
         $('#rawqc').val(data.data.rawqc);
         $('#shoot_hour').val(data.data.shoot_hour);
         $('#studio').val(data.data.studio);
         $('#stylist').val(data.data.stylist);
        $( '#stylist_charges').val(data.data.stylist_charges);
        $( '#extra_model_charges').val(data.data.extra_model_charges);
     });
}


</script>


<script type="text/javascript">
    $(".shoot-select").change(function () {
        if ($(this).val() == "Shoot_1") {
            $(this).parents(".custom-select-row").siblings('.custom-select-row1').removeClass('d-none');
            $(this).parents(".custom-select-row").siblings('.custom-select-row2').addClass('d-none');
        } else if ($(this).val() == "Shoot_2") {
            $(this).parents(".custom-select-row").siblings('.custom-select-row2').removeClass('d-none');
            $(this).parents(".custom-select-row").siblings('.custom-select-row1').addClass('d-none');
        }
    });
</script>


</body>

@endsection