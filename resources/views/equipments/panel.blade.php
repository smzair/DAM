
@extends('layouts.admin')
@section('title')
Equipments panel
@endsection
@section('content')

<title>Equipments panel</title>
<head>    
  <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
             <p class="text-center text-success">{{session()->pull('message')}}</p>

<div class="custom-equipment-panel">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card card-transparent">
                    <div class="card-header">
                        <h3 class="card-title">Equipment Panel</h3>
                        <div class="panel-action-btns float-right">
                           <!--  <a href="javascript:;" class="btn btn-warning" id="tagEquipmentBtn" data-toggle="modal" data-target="#tagEquipmentModal">Tag Equipments to a plan</a> -->

                            <a href="javascript:;" class="btn btn-warning" id="newEquipmentBtn" data-toggle="modal" data-target="#newEquipmentModal">Register New Equipment</a>
                            
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
                        <table class="table data-table table-head-fixed table-hover text-nowrap" id="equipmentPanelTable">
                            <thead>
                                <tr>
                                    
                                    <th>Name & Model no</th>
                                    <th>Vendor</th>
                                    <th>Cost</th>
                                    <th>Opt Start Date</th>
                                    <th>Opt End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($list as $item)
                                <tr>
                                
                                    <td>{{$item->equipment_name}}</td>
                                    <td>{{$item->vendor_name}}</td>
                                    <td>Rs {{$item->equipment_cost}}</td>
                                    <td>{{$item->opt_start_date}}</td>
                                    <td>{{$item->opt_end_date}}</td>
                                </tr>
                             @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End of Equipment Panel HTML Table -->

<!-- Equipment Tag Modal HTML  -->

<div class="modal fade tag-equipment-modal" id="tagEquipmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content tag-equipment-modal-content">
            <div class="modal-header">
                <div class="modal-close" data-dismiss="modal" aria-label="Close">
                    Back
                </div>
            </div>
            <div class="modal-body">
                <div class="infor-updated-title">
                    <h4>
                        Tag Equipments to a plan
                    </h4>
                </div>
                <form action="" method="post" id="tagEquipmentForm" class="tag-equipment-form">
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="form-group">
                                <label for="Select A Plan" class="required">Select A Plan</label>
                                <select class="custom-select form-control select2" data-placeholder="Select Plan" style="width: 100%;">
                                     @foreach($list as $item)
                                    <option value="Plan 1">{{$item->equipment_name}} | {{$item->vendor_name}} | Rs {{$item->equipment_cost}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-12">
                            <div class="form-group">
                                <label for="Select All Equipments to be tag" class="required">Select All Equipments to be tag</label>
                                <select class="custom-select form-control select2" multiple="multiple" data-placeholder="Select tags" style="width: 100%;">
                                    @foreach($list as $item)
                                    <option value="{{$item->id}}">{{$item->equipment_name}} | {{$item->vendor_name}} | Rs {{$item->equipment_cost}}</option>
                                    @endforeach
                                 
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="update-button-wrapper">
                                <a href="javascript:;" class="btn btn-warning" id="tagEQBTn">Tag Equipments To A Plan</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- End of Equipment Tag Modal HTML  -->

<!-- New Equipment Modal HTML  -->

<div class="modal fade register-equipment-modal" id="newEquipmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content register-equipment-modal-content">
            <div class="modal-header">
                <div class="modal-close" data-dismiss="modal" aria-label="Close">
                    Back
                </div>
            </div>
            <div class="modal-body">
                <div class="infor-updated-title">
                    <h4>
                        Register A New Equipment
                    </h4>
                </div>
                <div class="infor-updated-content">
                    <form action="" method="post" id="newEquipmentForm" class="new-equipment-form">
                        <div class="row">
                            <div class="col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="Model Name" class="required">Equipment name & model no (if any)</label>
                                    <input type="text" placeholder="Name" class="form-control" name="name" id="modelName">
                                </div>
                            </div>
                            <div class="col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="Vender Name" class="required">Vendor Name</label>
                                    <input type="text" placeholder="Vendor Name" class="form-control" name="vendorname" id="vendorName">
                                </div>
                            </div>
                            <div class="col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="Start Date" class="required">Opt Start Date</label>
                                    <div class="input-group date"  id="startDate">
                                        <input type="text" class="form-control datepicker-input"name="opt_start_date" data-target="#startDate" placeholder="Opt-Start-Date" data-toggle="datepicker" />
                                        <div class="input-group-append" data-target="#startDate">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="End Date" class="required">Opt End Date</label>
                                    <div class="input-group date" id="endDate">
                                        <input type="text" class="form-control datepicker-input" placeholder="Opt-End-Date" name="opt_end_date"data-target="#endDate" data-toggle="datepicker"/>
                                        <div class="input-group-append" data-target="#endDate">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="Equipment Cost" class="required">Equipment Cost</label>
                                    <input type="text" placeholder="Equipment Cost" class="form-control" name="equipmentCost" id="equipmentCost">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="update-button-wrapper">
                                    <a href="javascript:;" class="btn btn-warning" onclick="saveForm()" id="registerEQBTn">Register a new equipment</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End of New Equipment Modal HTML  -->



<!-- Put it Script on same page -->

<script>
    $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        zIndex: 2048,
        format: 'yyyy-mm-dd'
    });

    $('#equipmentPanelTable').DataTable();


    function saveForm(){

        var headers = {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

    $.ajax({
      headers: headers,
      url: "/save-equip",
      method: 'POST',
      dataType: "text",
      data: $('#newEquipmentForm').serialize(),
      success: function (data) {
        $('#newEquipmentForm').modal('hide');
       window.location.reload();

      }

    });
  }
    
</script>
@endsection