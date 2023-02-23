@extends('layouts.admin')
@section('title')
Consilidated Lot View
@endsection
@section('content')
<div class="lot-table mt-1">
    <div class="container-fluid">
        @if (Session::has('success'))
                        <div class="alert alert-success" id="msg_div" role="alert">
                            {{ Session::get('success') }}
                        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card card-transparent">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-7 col-md-6 col-sm-12">
                                <h3 class="card-title text-black text-bold">
                                    <span class="d-inline-block align-middle">
                                        Consolidated-Lot-List
                                    </span>
                                    <span class="mr-2 ml-1 d-inline-block" style="position: relative; top: 1px;">|</span>
                                </h3>
                                <div class="card-tools float-left">
                                    <ul class="list-unstyled m-0 mt-lg-0 mt-md-1 lot-list">
                                        <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Inworded">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #FFFF00;"></span>
                                        </li>
                                        <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Inwording Completed">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #FF8000;"></span>
                                        </li>
                                        <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Ready For Shoot">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #606060;"></span>
                                        </li>
                                        <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Shoot Done">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #4C0099;"></span>
                                        </li>
                                        <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Ready For QC">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #000000;"></span>
                                        </li>
                                        <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Ready For Submission">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #0066CC;"></span>
                                        </li>
                                        <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Approved">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #00CC00;"></span>
                                        </li>
                                        <li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="Rejected">
                                            <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #FF0000;"></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-12">
                                <div class="card-tools float-md-right float-sm-none ml-md-0 mr-0 ml-sm-0 mt-sm-1 float-none ml-xs-0 mt-1">
                                    <a class="btn btn-xs float-left align-middle mt-0 mr-2 py-1 px-2 mb-1" href="{{ route('create_consolidated_lot') }}" style="position: relative; top: 2px;">Add New Consolidated Lot</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                        <table id="wrcTable" class="table table-head-fixed table-hover text-nowrap data-table">
                            <thead>
                                <tr>
                                    <th class="p-2">Sr.No.</th>
                                    <th class="p-2">Lot Number</th>
                                    <th class="p-2">Company Name</th>
                                    <th class="p-2">Brand Name</th>
                                    <th class="p-2">Shoot check</th>
                                    <th class="p-2">Creative Graphics Check</th>
                                    <th class="p-2">Cat Log Check</th>
                                    <th class="p-2">Editing Check</th>
                                    <th class="p-2">Shoot Data</th>
                                    <th class="p-2">Creative Graphics Data</th>
                                    <th class="p-2">Cat Log Data</th>
                                    <th class="p-2">Editing Data</th>
                                    <th class="p-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ConsolidatedLot as $key => $val)
                                <tr>
                                    <td class="p-sm-2 p-1">{{$key+1}}</td>
                                    <td id="lotNum" class="p-sm-2 p-1">{{$val->lot_number}}</td>
                                    <td id="lotNum" class="p-sm-2 p-1">{{$val->company_name}}</td>
                                    <td id="lotNum" class="p-sm-2 p-1">{{$val->brand_name}}</td>
                                    <td class="p-sm-2 p-1">
                                        <?php if($val->shoot == 1){ ?>
                                           <i class="fa fa-check" style="font-size:20px;color:#49e649;"></i>
                                        <?php }else{ ?>
                                            --
                                        <?php } ?>
                                    </td>
                                    <td class="p-sm-2 p-1">
                                        <?php if($val->creative_graphic == 1){ ?>
                                           <i class="fa fa-check" style="font-size:20px;color:#49e649;"></i>
                                        <?php }else{ ?>
                                            --
                                        <?php } ?>
                                    </td>
                                    <td class="p-sm-2 p-1">
                                        <?php if($val->cataloging == 1){ ?>
                                           <i class="fa fa-check" style="font-size:20px;color:#49e649;"></i>
                                        <?php }else{ ?>
                                            --
                                        <?php } ?>
                                    </td>
                                    <td class="p-sm-2 p-1">
                                        <?php if($val->editor_lot_check == 1){ ?>
                                           <i class="fa fa-check" style="font-size:20px;color:#49e649;"></i>
                                        <?php }else{ ?>
                                            --
                                        <?php } ?>
                                    </td>
                                    <td  class="p-sm-2 p-1">{{$val->shoot_form_data == 1 ? 'Submitted' : '--'}}</td>
                                    <td  class="p-sm-2 p-1">{{$val->creative_graphic_form_data == 1 ? 'Submitted' : '--'}}</td>
                                    <td  class="p-sm-2 p-1">{{$val->cataloging_form_data == 1 ? 'Submitted' : '--'}}</td>
                                    <td  class="p-sm-2 p-1">{{$val->editor_lot_form_data == 1 ? 'Submitted' : '--'}}</td>
                                    <td class="p-sm-2 p-1">
                                        <div class="btn-group-vertical">
                                            <?php if(($val->shoot == $val->shoot_form_data) && ($val->creative_graphic == $val->creative_graphic_form_data) && ($val->cataloging == $val->cataloging_form_data) && ($val->editor_lot_check == $val->editor_lot_form_data)){ ?>
                                            <button  disabled class="btn btn-warning px-1 py-1 btn-xs mt-1" href="{{('/Consolidated-Lot/'.$val->id) }}">Done</button>
                                            <?php }else{ ?>
                                                <a class="btn btn-warning px-1 py-1 btn-xs mt-1" href="{{('/Consolidated-Lot/'.$val->id) }}">Continue</a>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
    </div>
</div>

<!-- End of Table -->

<!-- DataTable Plugins Path -->

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<!-- End of DataTable Plugins Path -->

<script>
    $('#wrcTable').DataTable({
        dom: 'lBfrtip',
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "buttons": ["copy", "csv", "excel", "pdf"]
    }).buttons().container().insertAfter('#masterData_wrapper .dataTables_length');
</script>
<script>
    setTimeout(function(){
        document.getElementById('msg_div').style.display = "none";
    },3000)
</script>
@endsection