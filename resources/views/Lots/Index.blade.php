@extends('layouts.admin')
@section('title')
View All LOTs
@endsection
@section('content')


<title>LOTs</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css" >
    .table td {
        border: 0 !important;
    }

    .lot-list li {
        cursor: pointer;
    }

    .bg-color {
        background: #ccc;
        position: relative;
        top:6px;
    }

    .bg-color.inworded {
        background:#FFFF00;
    }
    .bg-color.inwording.completed {
        background:#FF8000;
    }
    .bg-color.ready.for.shoot {
        background:#606060;
    }
    .bg-color.shoot.done {
        background:#4C0099;
    }
    .bg-color.ready.for.qc {
        background:#000000;
    }
    .bg-color.ready.for.submission {
        background:#0066CC;
    }
    .bg-color.approved {
        background:#00CC00;
    }
    .bg-color.rejected {
        background:#FF0000;
    }

    select{
        background:#ffffff
    }


</style>


<div class="lot-table mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-transparent">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <h3 class="card-title text-black text-bold">
                                    <span class="d-inline-block align-middle">
                                        All LOTs
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
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="card-tools float-md-right float-sm-none ml-md-0 mr-0 ml-sm-0 mt-sm-1 float-none ml-xs-0 mt-2">
                                    <a href="{{route ('Lots.create')}}" class="btn btn-xs float-left align-middle mt-0 mr-2 p-1 mb-2 mb-sm-1" style="position: relative; top: 2px;">Create a new LOT</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                        <table class="table table-head-fixed table-hover text-nowrap text-center" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                   <!--  <th>Status</th> -->
                                    <th>LOT Numbers</th>
                                    <th>Brand</th>
                                    <th>Company Name</th>
                                    <th>Client Id</th>
                                    <th>Date Posts</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lots as $lot)
                                <tr>
                                    <td>{{$lot->id}}</td>
                                    <!-- <td>
                                      <span class="badge d-inline-block rounded-1 p-lg-2 p-md-2 p-sm-2 p-2 px-lg-5 px-md-4 align-middle" data-toggle="tooltip" data-placement="top" title="{{$lot->id}}" style="background: #FFFF00;">Inwarding</span>
                                    </td> -->
                                    <td>{{$lot->lot_id}}</td>
                                    <td>{{$lot->name}}</td>
                                    <td>{{$lot->Company}}</td>
                                    <td>{{$lot->client_id}}</td>
                                    <td>{{dateFormat($lot->created_at)}}<br><b>{{timeFormat($lot->created_at)}}</b></td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <button type="button" class="btn btn-primary px-1 py-1 btn-xs" data-client_id="{{$lot->client_id}}"  data-created_at="{{dateFormat($lot->created_at)}} {{timeFormat($lot->created_at)}}"  data-Company="{{$lot->Company}}" data-lot_id = "{{$lot->lot_id}}" data-name = "{{$lot->name}}" onclick="viewlots(this)">View</button>
                                            <a class="btn btn-warning px-1 py-1 btn-xs mt-1" href="{{('/createlots/'.$lot->id) }}">Edit Lot</a>

                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="modal fade" id="lot-info-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header py-2">
                                <h4 class="modal-title">LOT Details</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <dl class="row mb-0">
                                    <dt class="col-6 mb-3">Client Id</dt>
                                    <dd class="col-6" id="modal_client_id"></dd>
                                    <dt class="col-6 mb-3">LOT Number</dt>
                                    <dd class="col-6" id="modal_lot_id"></dd>
                                    <dt class="col-6 mb-3">Brands</dt>
                                    <dd class="col-6"id="modal_name"></dd>
                                    <dt class="col-6 mb-3">Date</dt>
                                    <dd class="col-6" id="modal_created_at"></dd>

                                </dl>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
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
            <li><b>To view an existing LOT, please click on the ‘view’ button in the action section.</b></li>
            <li><b>In case you want to update a LOT, please click on the ‘edit’ button.</b></li>
        </ul>
    </div>
</div>

<script type="application/javascript" src="plugins/jquery/jquery.min.js"></script>
<script type="application/javascript" src="plugins/jquery-ui/jquery-ui.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>


<script type="application/javascript">


    $('.swalDefaultSuccess').click(function() {
    Toast.fire({
    icon: 'success',
    title: 'Thank you for your support. Your Customer Id 345678'
    });
    });

    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    });

    var prevVal;
    $(".yellowText").on("change",function(){
    var val = $(this).find('option:selected').text();
    $(this).parent().prev('.bg-color').removeClass(`${prevVal}`).addClass(`${val}`);
    prevVal = val;
    });

    $('.st-btn').click(function(){
    $(this).parents('.colform').slideUp(500);
    // $(this).parents('.colform').prev('.bg-color').animate({ top: '6px' });
    });

    $('.bg-color').click(function(){
    $(this).next('.colform').slideDown(500);
    });

    function viewlots(obj){
    var lot_id = $(obj).data('lot_id');
    var name = $(obj).data('name');
    var client_id = $(obj).data('client_id');
    var Company = $(obj).data('Company');
    var created_at = $(obj).data('created_at');
    $('#modal_lot_id').text(lot_id);
    $('#modal_client_id').text(client_id);
    $('#modal_name').text(name);

    $('#modal_created_at').text(created_at);


    $('#lot-info-modal').modal();

    }


</script>


<script type="text/javascript">

$(".wrcid").change(function(){
if($(this).val()==="GO"){
$.confirm({
    title: 'Confirmation Required',
    content: '' +
    '<form action="" class="formName">' +
    '<div class="form-group">' +
    '<label>Inorder to generate this LOT you need to comfirm that Catalouge sheet has been recived from client</label>' +
    '<input type="text" placeholder="Type CONFIRM to continue" class="name form-control" required />' +
    '</div>' +
    '</form>',
    buttons: {
        formSubmit: {
            text: 'Proceed',
            btnClass: 'btn-warning',
            action: function () {
                var name = this.$content.find('.name').val().toLowerCase();
                if(name != 'confirm'){
                    $.alert('Please type CONFIRM in the text box to continue');
                    return false;
                }
                $.alert('Thank you for the confirmation');
            }
        },
        cancel: function () {
          $("option:selected").prop("selected", false);
        },
    },
    onContentReady: function () {
        // bind to events
        var jc = this;
        this.$content.find('form').on('submit', function (e) {
            // if the user submits the form by pressing enter in the field.
            e.preventDefault();
            jc.$$formSubmit.trigger('click'); // reference the button and click it
        });
    }
});
}
else {

}
});


</body>

@endsection