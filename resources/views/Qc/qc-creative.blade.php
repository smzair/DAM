@extends('layouts.admin')

@section('title')

Creative Qc Panel

@endsection
@section('content')

<style>
    input[type="checkbox"]{
  width: 25px; /*Desired width*/
  height: 21px; /*Desired height*/
  margin-top: 1px;
  cursor: pointer;
}
</style>

<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

<div class="container-fluid mt-5 plan-shoot">
    <div class="row">
        <div class="col-12">
            @if (Session::has('success'))
            <div class="alert alert-success" id="sub_msg_div" role="alert">
                {{ Session::get('success') }}
            </div>
            {{ Session::forget('success') }}
            @endif
            @if (Session::has('error'))
            <div class="alert alert-danger" id="sub_msg_div" role="alert">
                {{ Session::get('error') }}
            </div>
            {{ Session::forget('error') }}
            @endif
        <div class="" id="msg_div" style="display: none" role="alert">
            <p id='msg_p'></p>
        </div>
            <div class="card card-transparent">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: 2rem;">QC Approval - Creative</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
                    <table id="qaTableCrt" class="table table-head-fixed text-wrap data-table">
                        <thead>
                            <tr>
                                <th class="align-middle">WRC Number</th>
                                <th class="align-middle">Brand Name</th>
                                 <th class="align-middle">Type Of Service</th>
                                {{-- <th class="align-middle">User List</th> --}}
                                <th class="align-middle">Order Qty</th>
                                <th class="align-middle">Sku Qty</th>
                                <th class="align-middle">Creative Link</th>
                                <th class="align-middle">Copy Link</th>
                                <th class="align-middle">QC Copy Status</th>
                                <th class="align-middle">Qc Overall Status</th>
                                <th class="align-middle">Action</th>
                                {{-- <th class="align-middle">Commented</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($QcList as $key => $qc)
                            <tr>
                                <td>{{$qc['wrc_number']}}</td>
                                {{-- <td id="wrc_id{{$key}}" style="display: none;">{{$qc['wrc_id']}}</td>
                                <td style="display: none">{{$qc['allocation_id']}}</td> --}}
                                <td id="wrc_id{{$key}}" data-wrc_id = "{{$qc['wrc_id']}}" data-allocation_id = "{{$qc['allocation_id']}}" >{{$qc['brands_name']}}</td>
                                 <td>{{$qc['type_of_service']}}</td>

                                {{-- <td>
                                    <ul class="info-list">
                                      @foreach ((explode(',',$qc['name_list'])) as $name_list_data)
                                        <a href="javascript:;" class="cpy-textVal" id="creativetextVal">
                                            {{$name_list_data}}
                                            <span><i class="fas fa-copy"></i></span>
                                        </a><br>
                                      @endforeach
                                    </ul>
                                </td> --}}

                                <?php 
                                if($qc['client_bucket'] == 'Retainer'){ ?>
                                    <td id="order_qty{{$key}}">{{$qc['batch_order_qty'] != null ? $qc['batch_order_qty'] : 0}}</td>
                                    <td id="sku_count{{$key}}">{{$qc['batch_sku_count'] != null ? $qc['batch_sku_count'] : 0}}</td>
                                <?php }else { ?>
                                    <td id="order_qty{{$key}}">{{$qc['order_qty'] != null ? $qc['order_qty'] : 0}}</td>
                                    <td id="sku_count{{$key}}">{{$qc['sku_count'] != null ? $qc['sku_count'] : 0}}</td>
                                <?php  } ?>
                                {{-- <td>
                                    <ul class="info-list">
                                      @foreach ((explode(',',$qc['creative_link_list'])) as $creative_link_data)
                                        <a href="javascript:;" class="cpy-textVal" id="creativetextVal">
                                            {{$creative_link_data}}
                                            <span><i class="fas fa-copy"></i></span>
                                        </a><br>
                                      @endforeach
                                    </ul>
                                </td>

                                <td>
                                    <ul class="info-list">
                                      @foreach ((explode(',',$qc['copy_link_list'])) as $copy_link_data)
                                        <a href="javascript:;" class="cpy-textVal" id="creativetextVal">
                                            {{$copy_link_data}}
                                            <span><i class="fas fa-copy"></i></span>
                                        </a><br>
                                      @endforeach
                                    </ul>
                                </td> --}}
                                <td style="width:200px"><a href="{{$qc['creative_link']}}" class="cpy-textVal" target="_blank">{{$qc['creative_link']}} <span><i class="fas fa-copy"></i></span></a></td>
                                <td style="width:200px"><a href="{{$qc['copy_link']}}" class="cpy-textVal" target="_blank">{{$qc['copy_link']}} <span><i class="fas fa-copy"></i></span></a></td>



                                <td >
                                    <?php if($qc['alloacte_to_copy_writer'] == 1){ ?>
                                        <?php if($qc['cw_qc_status'] == 0){ ?>
                                            <div class="d-inline-block mt-1">
                                                <input type="checkbox"  data-toggle="toggle" data-on="Submitted" data-off="Pending" data-onstyle="success" data-offstyle="warning" data-size="sm" data-width="100" class="toggle-class"  onclick='CwCompleteQcApproval(<?php echo $key;?>)' >
                                                <button type="" style="border-radius: 4px" class="button btn-warning Pending" onclick='CwCompleteQcApproval(<?php echo $key;?>)' name="Pending">Pending</button>
                                            </div>
                                        <?php } ?>

                                        <?php if($qc['cw_qc_status'] == 1){ ?>
                                            <div class="d-inline-block mt-1">
                                                <input type="checkbox"  checked disabled data-toggle="toggle" data-on="Submitted" data-off="Pending" data-onstyle="success" data-offstyle="warning" data-size="sm" data-width="100" class="toggle-class"  onclick='CwPendingQcApproval(<?php echo $key;?>)' >
                                                <button type="" onclick='CwPendingQcApproval(<?php echo $key;?>)' style="border-radius: 4px" class="button btn-success Completed" name="Completed">Completed</button>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php if($qc['alloacte_to_copy_writer'] == 0){ ?>
                                        <span> Not allocated to CW</span>
                                    <?php } ?>

                                </td>

                                <td >
                                    <?php if($qc['qc_status'] == 0){ ?>
                                    <div class="d-inline-block mt-1">
                                        <input type="checkbox"  data-toggle="toggle" data-on="Submitted" data-off="Pending" data-onstyle="success" data-offstyle="warning" data-size="sm" data-width="100" class="toggle-class"  onclick='completeQcApproval(<?php echo $key;?>)' >
                                        <button type="" style="border-radius: 4px" class="button btn-warning Pending" onclick='completeQcApproval(<?php echo $key;?>)' name="Pending">Pending</button>
                                        {{-- <input data-id="{{$sku['sku_id']}}" type="checkbox" checked data-toggle="toggle" data-on="Submitted" data-off="Pending" data-onstyle="success" data-offstyle="warning" data-size="sm" data-width="100" class="toggle-class"   {{ $sku['qc'] ? 'checked' : '' }}> --}}
                                    </div>
                                    <?php } ?>

                                    <?php if($qc['qc_status'] == 1){ ?>
                                        <div class="d-inline-block mt-1">
                                            <input type="checkbox"  checked disabled data-toggle="toggle" data-on="Submitted" data-off="Pending" data-onstyle="success" data-offstyle="warning" data-size="sm" data-width="100" class="toggle-class"  onclick='pendingQcApproval(<?php echo $key;?>)' >
                                            <button type="" onclick='pendingQcApproval(<?php echo $key;?>)' style="border-radius: 4px" class="button btn-success Completed" name="Completed">Completed</button>
                                            {{-- <input data-id="{{$sku['sku_id']}}" type="checkbox" checked data-toggle="toggle" data-on="Submitted" data-off="Pending" data-onstyle="success" data-offstyle="warning" data-size="sm" data-width="100" class="toggle-class"   {{ $sku['qc'] ? 'checked' : '' }}> --}}
                                        </div>
                                        <?php } ?>

                                </td>

                                <td>
                                    <?php if($qc['qc_status'] == 0){ ?>
                                    <div class="d-inline-block mt-1">
                                        <a class="btn btn-default py-1 mt-1" data-toggle="modal" data-target="#creativeReworkModal"  onclick='setdata(<?php echo $key;?>)'><i class="fas fa-comment mr-1"></i>Rework</a>
                                    </div>
                                    <?php } ?>
                                    <?php if($qc['qc_status'] == 1){ ?>
                                        <div class="d-inline-block mt-1">
                                            <button  disabled class="btn btn-default py-1 mt-1" data-toggle="modal" data-target="#creativeReworkModal"  onclick='setdata(<?php echo $key;?>)'><i class="fas fa-comment mr-1"></i>Rework</button>
                                        </div>
                                        <?php } ?>
                                </td>
                                {{-- <td>
                                    <div class="d-inline-block mt-1">
                                        <a href="javascript:;" class="btn btn-default py-1 mt-1" data-toggle="modal" data-target="#creativeCommnentModal"><i class="fas fa-comment mr-1"></i>Comment</a>
                                    </div>
                                </td> --}}
                            </tr>  
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="creativeReworkModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h4 class="modal-title">Comments</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   
                    <form method="POST" action="{{ route('CREATIVE_REWORK_STORE') }}" onsubmit="return validateForm(event)">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="wrc_id" class="wrc_id" value="" />
                            <input type="hidden" name="allocation_id" class="allocation_id" value="" />
                            <label class="control-label required">Category</label>
                            <div class="group-inner">
                                <div class="radio-col">

                                    <span class="checkVal">
                                        Creative
                                    </span>
                                    <input type="radio" name="creativeCheck" onclick="getUser()" id="creativeCheck" class="radio-check" value="1">

                                    <span class="checkVal">
                                        Copy
                                    </span>
                                    <input type="radio" name="creativeCheck" onclick="getUser()" id="copyCheck" class="radio-check" value="0">
                                </div>
                            </div>
                        </div>
                        <label class="control-label required">Select User</label>
                        <div class="form-group">
                            <select name="creative_cw_gd_user" id="creative_cw_gd_user" >
                                <option value="0" data-creative_allocation_id="0" data-is_rework="0" > -- Select User -- </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Add a comment</label>
                            <textarea class="form-control" rows="4" name="commentsec" id="commentsec" placeholder="Enter your comment..."></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-warning" >Rework</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="creativeCommnentModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h4 class="modal-title">Comments</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   
                    <form method="POST" action="comment-form">
                        @csrf
                        <div class="form-group">
                            <label class="control-label required">Category</label>
                            <div class="group-inner">
                                <div class="radio-col">
                                    <span class="checkVal">
                                        Creative
                                    </span>
                                    <input type="radio" name="crCheck" id="check1" class="radio-check">
                                    <span class="checkVal">
                                        Copy
                                    </span>
                                    <input type="radio" name="crCheck" id="check2" class="radio-check">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Add a comment</label>
                            <textarea class="form-control" rows="4" name="commentsec" id="commentsec" placeholder="Enter your comment..."></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-warning">Comment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<script>
    $(document).on('click', '.cpy-textVal', function () {
        var ValC = $(this).text().trim();

        var nwArray = [[`${ValC}`]];

        navigator.clipboard.writeText(nwArray).then(() => {
            $('.copy-msg').fadeIn(250);
            setTimeout(function () {
                $('.copy-msg').fadeOut(250);
            }, 1000);
        })
        .catch((err) => {
            alert("Error in copying text: ", err);
        });
    });

    $('#qaTableCrt').DataTable({
        dom: 'lBfrtip',
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "buttons": ["copy", "csv", "excel", "pdf"]
    }).buttons().container().insertAfter('#masterData_wrapper .dataTables_length');

</script>

 <!-- get dynamic data in modal -->
<script>
    function setdata(id){
        console.log('first', id)
         // set wrc id
        const wrc_id_td = "wrc_id"+id;
        const wrc_id =  $("#"+wrc_id_td).data("wrc_id")
        document.querySelector('.wrc_id').value = wrc_id;
        console.log('wrc_id_check', wrc_id)
    }
</script>


<script>
    function completeQcApproval(id){
        var button = document.getElementsByClassName("Pending")[0];
        var button_action = button.name;

        console.log('button_action', button_action)
         // set wrc id
        const wrc_id_td = "wrc_id"+id;
        const wrc_id = $("#"+wrc_id_td).data("wrc_id")
        console.log('complete Qc Approval_wrc_id', wrc_id)
        var check_completed_wrc = 0;
        $.ajax({
            url: "{{ url('check_completed_wrc')}}",
            type: "POST",
            dataType: 'json',
            data: {
                wrc_id,
                button_action,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                check_completed_wrc = res;
                if(res == 0){
                    alert('First, complete all tasks for all users');
                    window.location.reload();
                }
                if(res == 1){
                    alert('Qc Status Completed Successfully');
                    window.location.reload();
                }
              console.log('check_completed_wrc', res)
            }
        });
    }
</script>

<script>
    function pendingQcApproval(id){
        var button = document.getElementsByClassName("Completed")[0];
        var button_action = button.name;

        console.log('button_action', button_action)
         // set wrc id
        const wrc_id_td = "wrc_id"+id;
        const wrc_id = $("#"+wrc_id_td).data("wrc_id");
        console.log('complete Qc Approval_wrc_id', wrc_id)
        var check_completed_wrc = 0;
        $.ajax({
            url: "{{ url('check_completed_wrc')}}",
            type: "POST",
            dataType: 'json',
            data: {
                wrc_id,
                button_action,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                check_completed_wrc = res;
                if(res == 0){
                    alert('First, complete all tasks for all users');
                    window.location.reload();
                }
                if(res == 1){
                    alert('Qc Status Pending Successfully');
                    window.location.reload();
                }
              console.log('check_completed_wrc', res)
            }
        });
    }
</script>

<script>
    function CwCompleteQcApproval(id){
        var button = document.getElementsByClassName("Pending")[0];
        var button_action = button.name;

        console.log('button_action', button_action)
         // set wrc id
        const wrc_id_td = "wrc_id"+id;
        const wrc_id = $("#"+wrc_id_td).data("wrc_id")
        console.log('complete Qc Approval_wrc_id', wrc_id)
        var check_completed_wrc = 0;
        $.ajax({
            url: "{{ url('cw_check_completed_wrc')}}",
            type: "POST",
            dataType: 'json',
            data: {
                wrc_id,
                button_action,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                check_completed_wrc = res;
                if(res == 0){
                    alert('First, complete all tasks for CW users ');
                    window.location.reload();
                }
                if(res == 1){
                    alert('QC for Copy completed successfully for this WRC');
                    window.location.reload();
                }
              console.log('check_completed_wrc', res)
            }
        });
    }
</script>

<script>
    function CwPendingQcApproval(id){
        var button = document.getElementsByClassName("Completed")[0];
        var button_action = button.name;

        console.log('button_action', button_action)
         // set wrc id
        const wrc_id_td = "wrc_id"+id;
        const wrc_id = $("#"+wrc_id_td).data("wrc_id");
        console.log('complete Qc Approval_wrc_id', wrc_id)
        var check_completed_wrc = 0;
        $.ajax({
            url: "{{ url('cw_check_completed_wrc')}}",
            type: "POST",
            dataType: 'json',
            data: {
                wrc_id,
                button_action,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                check_completed_wrc = res;
                if(res == 0){
                    alert('First, complete all tasks for CW users');
                    window.location.reload();
                }
                if(res == 1){
                    alert('CW users Qc Status Pending Successfully');
                    window.location.reload();
                }
              console.log('check_completed_wrc', res)
            }
        });
    }
</script>

<script>
    async function getUser(){
        wrc_id = document.querySelector('.wrc_id').value;
        creative_check = document.getElementById("creativeCheck").checked;
        copy_check = document.getElementById("copyCheck").checked
        var user_role = '';
        if(creative_check){
           var user_role = 'GD';
        }
        if(copy_check){
            var user_role = 'CW';
        }

        filter_wrc_id = wrc_id;
        filter_user_role = user_role;
        let options = `<option value="0" data-creative_allocation_id="0" data-is_rework="0" > -- Select User -- </option>`;
         await $.ajax({
            url: "{{ url('get-user-for-rework')}}",
            type: "POST",
            dataType: 'json',
            data: {
                filter_wrc_id,
                filter_user_role,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
              console.log('dropdown_arr', res)
              res.map(user => {
                    console.log(user)
                    options += `<option value="${user.id}" data-creative_allocation_id="${user.creative_allocation_id}" data-is_rework="${user.is_rework}" > ${user.name} </option>`;
                })
            }
        });
        setTimeout(function(){
         document.getElementById('creative_cw_gd_user').innerHTML = options;
        },100)
    }
</script>
<!-- msg div script -->
<script>
    setTimeout(function(){
        document.getElementById('sub_msg_div').style.display = "none";
    },3000)
</script>


<!-- validateForm script -->
<script>
     function validateForm(e) {

        const creativeCheck =  document.getElementById("creativeCheck").checked;
        const copyCheck =  document.getElementById("copyCheck").checked;
        const creative_cw_gd_user =  document.getElementById("creative_cw_gd_user").value;
        const wrc_id = document.querySelector('.wrc_id').value;
        const is_rework = $("#creative_cw_gd_user").find(':selected').data('is_rework');
        
        console.log('is_rework', is_rework)

        if(!copyCheck && !creativeCheck){
            alert('please select atleast one category');
            return false;
        }

        if(creative_cw_gd_user == 0){
            alert('please select atleast one user');
            return false;
        }

        if(is_rework == 1){
            alert('please select another user because rework is already started');
            return false;
        }

        return true;
        
    }
</script>


@endsection