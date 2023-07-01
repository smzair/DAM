@extends('layouts.admin')

@section('title')
Editing -Ready for Submission
@endsection
@section('content')

<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<style type="text/css">
    .info-list > li {
        display: block;
        width: 100%;
        position: relative;
    }

    .info-list > li:not(:last-child) {
        margin-bottom: 4px;
    }

    .info-list > li > span, .info-list > li > a {
        display: inline-block;
    }

    .info-list > li > a:hover, .info-list > li > a:focus {
        text-decoration: underline !important;
    }

    .date, .time {
        display: block;
        width: 100%;
    }

    .time {
        font-weight: 700;
    }

    .allocation-wrc-modal .modal-body {
        padding: 1rem 1.2rem;
    }

    .alloc-action-btn.inactive {
        pointer-events: none;
        opacity: 0.5;
    }

    .card.card-transparent .table td .task-start-button .btn {
        background-color: #FBF702 !important;
        color: #000 !important;
        border-color: transparent;
        width: 100%;
    }

    .card.card-transparent .table td .task-start-button .btn:hover, 
    .card.card-transparent .table td .task-start-button .btn:focus {
        background-color: #ba8b00 !important;
    }

    .alloc-action-btn {
        display: block;
    }

    .alloc-action-btn:first-of-type {
        margin-bottom: 10px;
    }

    .msg_box{
            margin: 0.1em 0;
            background: #d3cdcdfc;
            padding: 0.4em;
        }


        .switch {
            position: relative; 
            display: inline-block;
            min-width: 60px;
            min-height: 34px;
        }
        
        .switch input { 
            opacity: 0; 
            min-width: 60px;
            min-height: 34px;
        }
        
       .switch .btn_success{
            background-color: #00ff00 !important;
            background: transparent;
            border: 1px solid  #00ff00;
            border-radius: 10%;
            color: #000;
        }

        .switch .btn_pending{
            background-color: #d1ff00 !important;
            /* background: transparent; */
            border: 1px solid #d1ff00; 
            border-radius: 10%;
        }

        .pointer{
            cursor: pointer;
            /* list-style:disc outside none;
            display:list-item;  */
            
        }

        .pointer span{
            list-style-type: circle;
        }
        .head_row{
            align-items: center;
            padding: 0 5px;
            align-items: center;
            padding: 10px;
            border: 1px solid;
        }

          .head_row .col-4 , .head_row .col-6 , .head_row .col-9{
            /* border: 1px solid #666; */
        }
</style>
<div class="container-fluid mt-5 plan-shoot">
    <div class="row">
        <div class="col-12">
            <div class="card card-transparent">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: 2rem;">Editing - Ready For Submission</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
                    <table id="qaTableCat" class="table table-head-fixed text-nowrap data-table">
                        <thead>
                            <tr>
                                <th class="align-middle text-center">ID</th>
                                <th class="align-middle text-center">Lot Number</th>
                                <th class="align-middle text-center">Company Name</th>
                                <th class="align-middle text-center">Brand Name</th>
                                <th class="align-middle text-center">WRC Number</th>
                                <th class="align-middle text-center">Wrc Created At</th>
                                <th class="align-middle text-center">Total Tentative Image Count</th>
                                <th class="align-middle text-center">Total Uploaded Count</th>
                                <th class="align-middle text-center">Total Allocated Qty</th>
                                <th class="align-middle text-center">Download Uploaded Image</th>
                                <th class="align-middle text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // pre($Editing_Wrc_list_ready_for_Submission);
                            @endphp
                            @foreach($Editing_Wrc_list_ready_for_Submission as $row)
                                @php
                                    $wrc_id = $row['wrc_id'];
                                    $proforma_item = $row['proforma_item'];
                                    $btn_disable = "disabled";
                                    $reworkbtn_disable = "";
                                    $submit_check_disable = "disabled"; // checked 
                                    $submit_check_is_checked = ""; //
                                   
                                    $wrc_id_is = ""; 
                                    $company = $row['company'];
                                    $imgQty = $row['imgQty'];
                                    $uploaded_img_qty = $row['uploaded_img_qty'];
                                    $brands_name = $row['brands_name'];
                                    $lot_number = $row['lot_number'];
                                    $wrc_number = $row['wrc_number'];
                                    $wrc_created_at =  $row['wrc_created_at'] != '0000-00-00 00:00:00' ? date('d-m-Y h:i A',strtotime($row['wrc_created_at'])) : '';
                                    
                                    $editor_allocated_qty = $row['editor_allocated_qty'];
                                    $final_link_list = $row['final_link_list'];
                                    $user_roles = $row['user_roles'];
                                    $allo_users_id = $row['allo_users_id'];
                                    $allocated_users_name = $row['allocated_users_name'];
                                    $editor_allocation_ids = $row['editor_allocation_ids'];

                                    $editor_allocation_id_arr = explode(',', $editor_allocation_ids);
                                    $allocated_users_name_arr = explode(',', $allocated_users_name);
                                    $final_link_list_arr = explode(',', $final_link_list);
                                    $editor_allocation_id_arr = explode(',', $editor_allocation_ids);
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $wrc_id }}</td>
                                    <td class="text-center">{{ $lot_number }}</td>
                                    <td class="text-center">{{ $company }}</td>
                                    <td class="text-center">{{ $brands_name .$wrc_id_is }}</td>
                                    <td class="text-center">{{ $wrc_number }}</td>
                                    <td class="text-center">{{ $wrc_created_at }}</td>
                                    <td class="text-center">{{ $imgQty }}</td>
                                    <td class="text-center">{{ $uploaded_img_qty }}</td>
                                    <td class="text-center">{{ $editor_allocated_qty }}</td>

                                    <td>

                                        @foreach ($final_link_list_arr as $pos => $link)
                                            @if ($link != '')
                                                @php
                                                $allocation_id = $editor_allocation_ids[$pos];
                                                $allocated_users_name_is = $allocated_users_name_arr[$pos];
                                                @endphp
                                                <p>
                                                    <a title="Download {{$allocated_users_name_is}} Uploaded Files" href="{{route('Editing_User_Edited_Image_Download', [base64_encode($allocation_id)])}}">Download </a>
                                                </p>
                                            @endif
                                        
                                        @endforeach
                                    </td>

                                    <td>
                                        <div class="d-inline-block mt-1">
                                            <p class="d-none" id="data_id_{{ $wrc_id }}" 
                                            data-wrc_id="{{ $wrc_id }}" 
                                            data-proforma_item="{{ $proforma_item }}" 
                                            data-company="{{ $company }}"  
                                            data-brands_name="{{ $brands_name }}"  
                                            data-lot_number="{{ $lot_number }}"  
                                            data-wrc_number="{{ $wrc_number }}"  
                                            data-imgqty="{{ $imgQty }}"  
                                            data-uploaded_img_qty="{{ $uploaded_img_qty }}"  
                                            data-final_link_list="{{ $final_link_list }}"  
                                            data-allo_users_id="{{ $allo_users_id }}"  
                                            data-allocated_users_name="{{ $allocated_users_name }}"  
                                            data-editor_allocation_ids="{{ $editor_allocation_ids }}"  
                                            data-user_roles="{{ $user_roles }}"  
                                            data-editor_allocated_qty="{{ $editor_allocated_qty }}" 
                                            > </p>

                                            <button data-company="{{ $wrc_id }}" onclick="setdata('{{ $wrc_id }}')" class="btn btn-default py-1 mt-1" data-toggle="modal" data-target="#editorCommnentModal">
                                                To Submit
                                            </button>
                                        </div>
                                    </td>
                                </tr>  
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal section --}}
    <div class="modal fade" id="editorCommnentModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h4 class="modal-title">Ready For Submission</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="comment-form">
                        <div class="row">
                            <div class="col-4 form-group">
                                <label for="wrc_number">Wrc number</label>
                                <p id="wrc_number"></p>
                            </div>
                            <div class="col-4 form-group">
                                <label for="company">Company</label>
                                <p id="company">Company</p>
                            </div>
                            <div class="col-4 form-group">
                                <label for="brand_name">Brand</label>
                                <p id="brand_name"></p>
                            </div>
                            
                        </div>
                        {{-- row 3 --}}
                        <div class="row">
                            <div class="col-4 form-group">
                                <label for="tot_sku">Total Tentative Image Count</label>
                                <p id="tot_sku"></p>
                            </div>

                            <div class="col-4 form-group">
                                <label for="uploaded_img_qty">Total Uploaded Count</label>
                                <p id="uploaded_img_qty"></p>
                            </div>

                            <div class="col-4">
                                <label for="editor_allocated_qty_is">Allocated to Editor</label>
                                <p id="editor_allocated_qty_is"></p>
                            </div>
                        </div>

                        {{-- link row --}}
                        <div class="row px-3" id="link_row">
                            <div class="col-12">
                                <div class="row px-3">
                                    <div class="col-12" style="background: #eee; color:#232323 ">
                                        <div class="row head_row d-none "  >
                                            <div class="col-3">
                                                <p class="m-0">Link To Editor</p>
                                            </div>
                                            <div class="col-9" id="link_to_cata_logure">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="wrc_id" id="wrc_id">
                            <input type="hidden" name="editor_allocation_ids" id="editor_allocation_ids">
                            <button id="submit_wrc" onclick="save_data()" type="button" class="btn btn-warning">Submit WRC</button>
                            <p id="copy_msg" class="msg_box d-none" style="color: #145514 ; font-weight: 500;font-size: 1.1rem;">Link Copied</p>
                        </div>
                        <div id="msg_div" style="display: none;">
                            <p class="msg_box" id="msg_box"></p>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button id="raise_btn" data-proforma_item="" data-wrc_id=""  onclick="Raise(this)"> RAISE FOR INVOICE </button>
                            </div>
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

    $('#qaTableCat').DataTable({
        dom: 'lBfrtip',
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "buttons": ["copy", "csv", "excel", "pdf"]
    }).buttons().container().insertAfter('#masterData_wrapper .dataTables_length');

</script>

{{-- script for setdata into modal  --}}
<script>
    async function setdata(val){
        $("#link_row").addClass("d-none");
        const data_id = "data_id_"+val; 
        const allocation_ids = editor_allocation_ids = $("#"+data_id).data("editor_allocation_ids")+""
        const wrc_id = $("#"+data_id).data("wrc_id")
        
        document.getElementById('editor_allocation_ids').value = editor_allocation_ids
        document.getElementById('wrc_id').value = val

        const proforma_item = $("#"+data_id).data("proforma_item")
        var element = document.getElementById("raise_btn");
        element.setAttribute("data-proforma_item", proforma_item);
        element.setAttribute("data-wrc_id", wrc_id);
        
        console.log('element', element)
        console.log('proforma_item', proforma_item)

        const wrc_number = $("#"+data_id).data("wrc_number")
        const brand_name = $("#"+data_id).data("brands_name")
        const lot_number = $("#"+data_id).data("lot_number")
        const company = $("#"+data_id).data("company")
        const tot_sku = $("#"+data_id).data("imgqty") 
        const uploaded_img_qty = $("#"+data_id).data("uploaded_img_qty") 
        
        const final_link_list = $("#"+data_id).data("final_link_list")
        const allo_users_id = $("#"+data_id).data("allo_users_id")
        const allocated_users_name = $("#"+data_id).data("allocated_users_name")
        const user_roles = $("#"+data_id).data("user_roles")+''

        const alloacte_to_copy_writer = $("#"+data_id).data("alloacte_to_copy_writer")
        const editor_allocated_qty = $("#"+data_id).data("editor_allocated_qty")
        const cp_allocated_qty = $("#"+data_id).data("cp_allocated_qty")

        const final_link_list_arr = final_link_list.split(',')
        const user_roles_arr = user_roles.split(',')
        const allocated_users_arr = allocated_users_name.split(',')
        const editor_allocation_id_arr = editor_allocation_ids.split(',')
        // debugger

        document.getElementById("wrc_number").innerHTML = wrc_number;
        document.getElementById("brand_name").innerHTML = brand_name;
        document.getElementById("company").innerHTML = company;
        document.getElementById("tot_sku").innerHTML = tot_sku;
        document.getElementById("uploaded_img_qty").innerHTML = uploaded_img_qty;
        document.getElementById("editor_allocated_qty_is").innerHTML = editor_allocated_qty;

        $("#link_row").removeClass("d-none");
        let editor_li = "";
        final_link_list_arr.forEach((link , index) => {
            if(link != ''){
                const user_roles_is = user_roles_arr[index];
                const allocated_users_is = allocated_users_arr[index];
                const editor_allocation_id_is = editor_allocation_id_arr[index];

                console.log(editor_allocation_id_is)
                // editor_li += `<p class="pointer m-0"> <a title="uploaded by ${allocated_users_arr[index]}" id="p_${editor_allocation_id_is}">${link}  </a> <i class="fa fa-copy" id="i_p_${editor_allocation_id_is}" onclick="copyToClipboard('p_${editor_allocation_id_is}')"></i></p>`

                // editor_li += `<p class="pointer m-0"> <a title="uploaded by ${allocated_users_arr[index]}" href="{{route('Editing_User_Edited_Image_Download', [base64_encode('${editor_allocation_id_is}')])}}" id="p_${editor_allocation_id_is}">Download  ${allocated_users_arr[index]} File</a> <i class="fa fa-copy" id="i_p_${editor_allocation_id_is}" onclick="copyToClipboard('p_${editor_allocation_id_is}')"></i></p>`

            }
        });
        document.getElementById("link_to_cata_logure").innerHTML = editor_li;

        // submit btn validation
        let btn_disable = false;
        if((tot_sku > editor_allocated_qty)){
            btn_disable = true;
            $("#submit_wrc").attr("title", "Wrc quantity and allocated quantity not same");
        }
        console.log({tot_sku , editor_allocated_qty, btn_disable} ,tot_sku > editor_allocated_qty )

        $("#submit_wrc").attr("disabled", true);
        if(btn_disable == false){
             $("#submit_wrc").removeAttr("title");
             $("#submit_wrc").removeAttr("disabled");
        }
    }
</script>

{{-- script for copy to --}}
<script>
    function copyToClipboard(id_is) {
        const element = document.getElementById(id_is);
        const val_is = element.innerHTML;
        navigator.clipboard.writeText(val_is);
        $("#copy_msg").removeClass("d-none");
        setTimeout(() => {
            $("#copy_msg").addClass("d-none");
        }, 1500)
    }
</script>



{{-- script for save data to rewrok   --}}
<script>
    async function save_data(){
        const wrc_id = document.querySelector("#wrc_id").value  
        const editor_allocation_ids = document.querySelector("#editor_allocation_ids").value  
        console.warn({wrc_id})
        // return

        // if(editor_allocation_id == 0 || editor_allocation_id ==''){
        //     alert('User Was Not Selected ');
        //     $("#editor_copy_user").focus();
        //     return
        // }
        await $.ajax({
            url: "{{ url('Editing-comp-submission')}}",
            type: "POST",
            dataType: 'json',
            data: {
                wrc_id,
                editor_allocation_ids,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                console.log(res)
                if(res.status == 1){
                    $("#msg_box").css("color", "green");
                }else if(res.status == 2){
                    $("#msg_box").css("color", "Blue");
                    
                }else if(res.status == 3){
                    $("#msg_box").css("color", "Blue");
                    
                }else if(res.status == 4){
                    $("#msg_box").css("color", "Blue");
                }else{
                    $("#msg_box").css("color", "red");
                }

                document.querySelector("#msg_box").innerHTML = res.massage
                $("#msg_div").css("display", "Block");
            }
        });
        setTimeout( () => {
            $("#msg_div").css("display", "none");
            $('#msg_box').html("");
        }, 3000);
    }
</script>

<!-- Raise script -->
<script>
    async function Raise(obj) {
        var wrc_id = $(obj).data('wrc_id');
        var pt = $(obj).data('proforma_item');
        var ser = '4';
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        await $.ajax({
            url: "{{ url('raise-for-inovice')}}",
            type: "POST",
            dataType: 'html',
            data: {
                wrc_id: wrc_id, 
                pt:pt,
                ser:ser,
                _token: '{{ csrf_token() }}'
            },
            success: function(htmlData) {
                console.log('htmlData', htmlData)
                window.location.reload();
            }
        });
      
    }
</script>
@endsection