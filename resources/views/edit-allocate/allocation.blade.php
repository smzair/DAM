
@extends('layouts.admin')

@section('title')
Raw Images Allocation
@endsection
@section('content')  
<style type="text/css">
    
/* New Allocation View */

.show-wrc-alloc-btn .wrc-toggle-check {
    display: block!important;
}

.show-sku-alloc-btn .sku-toggle-check {
    display: block!important;
}

.allocation-wrc-main .mailbox-controls {
    margin-right: 20px;
}

.modal-content .btn.sku-toggle-check {
    margin: 0 !important;
}

.allocation-sku-main .modal-header {
    display: block;
}

.allocation-sku-main .modal-header h4.modal-title {
    float: left;
}

.sku-alloc-modal:after {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: #000;
    opacity: 0.8;
    content: "";
    z-index: -1;
}

.image-list {
    max-width: 270px;
    overflow: auto;
}

.image-list > li > a {
    width: 35px;
    height: 35px;
    overflow: hidden;
}

.image-list > li > a img.img-fluid {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-right: inset;
}

.lot-details-wrapper {
    position: fixed;
    left: 270px;
    right: 0;
    width: calc(100% - 270px);
    z-index: 9;
    top: auto;
    bottom: -100%;
    padding: 0;
    margin: 0;
    transition: all 0.6s ease-in;
    height: calc(100% - 65px);
}

.lot-details-wrapper .card.card-transparent.wrapper-transparent {
    margin-bottom: 0 !important;
    border-radius: 0 !important;
    height: 100vh;
    overflow-y: auto;
}

.lot-details-wrapper.open-alloc {
    bottom: 0;
}

.lot-details-wrapper .close {
    cursor: pointer;
}

.lot-details-wrapper .card-title {
    font-size: 0.9rem;
}

.sidebar-mini.sidebar-collapse .lot-details-wrapper {
    left: 4.6rem;
    width: calc(100% - 4.6rem);
}
 .loader{
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 999;
        background: rgba(255,255,255,0.8) center no-repeat;
    }
    .loader img{
        position: absolute;
        top: 40%;
        left: 46%;
        width: 90px;
    }
    .loader a{
        position: absolute;
        top: 40%;
        left: 45%;
        color: #fff !important;
        font-size: 50px;
        font-weight: 400;
    }
</style>
<div class="loader" style="display: none;">
    <img src="{{asset('dist/img/2021-03-22.gif')}}" alt="loader">
</div>
<div class="container-fluid mt-5 plan-shoot new-allocation-table-main">
    <div class="row">
        <div class="col-12">
            <div class="card card-transparent">
                <div class="card-header">
                    <h3 class="card-title">Raw Images Allocation</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="max-height: 700px; height: 100%;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th class="align-middle">LOT Numbers</th>
                                <th class="align-middle">Company Name</th>
                                <th class="align-middle">Brand Name</th>
                                  <th class="align-middle">Inward Count</th>
                                  <th class="align-middle">Approved SKU Count</th>
                                <th class="align-middle">Inward Date</th>

                                <th class="align-middle">WRC Count</th>

                                <th class="align-middle" width="150px">View WRC to Allocate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allocationList as $lotinfo)
                            <tr>
                                <td>{{$lotinfo['lot_id']}}</td>
                                <td>{{$lotinfo['Company']}}</td>
                                <td>{{$lotinfo['name']}}</td>
                                <td>{{$lotinfo['inward_count']}}</td>
                                   <td>{{$lotinfo['aprvd_count']}}</td>
                                <td>{{$lotinfo['allocated_count']}}</td>
                                <td>{{count($lotinfo['wrcs'])}}</td>
                                <td class="view-slide" data-lotid="{{$lotinfo['lotid']}}" width="150px">
                                <i class="fa fa-plus"  style="width:50px; cursor: pointer;"></i>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
<div class="lot-details-wrapper" id="wrcalo">
 
</div>


<!-- WRC Modal Allocation -->
<div class="modal fade wrc-alloc-modal" id="allocation">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h4 class="modal-title">Shoot Allocation WRC</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="plan-form" id="allo" method="POST" action="">
                    @csrf
                    <div id="allo-dynamic"></div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="required">Allocated Editor</label>
                                <select class="custom-select form-control select2 select2bs4 select2-hidden-accessible" name="user_id" aria-hidden="true"
                                style="width: 100%;">
                                    <option selected> Select Editor </option>
                                    @foreach($users as $user)
                                    <option value='{{$user->id}}'>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a class="btn" style="background: #fbf702;" href="javascript:void(0)" onclick="saveallo()">Allocate</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SKU Modal Allocation -->
<div class="modal fade sku-alloc-modal" id="SKUallocation">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h4 class="modal-title">Shoot Allocation SKU</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="plan-form" id="allo" method="POST" action="">
                    @csrf
                    <div id="allo-dynamic"></div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="required">Allocated Editor</label>
                                <select class="custom-select form-control select2 select2bs4 select2-hidden-accessible" name="user_id" aria-hidden="true"
                                style="width: 100%;">
                                    <option selected> Select Editor </option>
                                    @foreach($users as $user)
                                    <option value='{{$user->id}}'>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a class="btn" style="background: #fbf702;" href="javascript:void(0)" onclick="saveallo()">Allocate</a>
                        </div>
                    </div>
                </form>
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
            <li><b>In order to allocate images, select the desired and then click on the table head.</b></li>
            <li><b>You can either allocate the entire LOT or an individual WRC or SKU to editor.</b></li>
        </ul>
    </div>
</div>


<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script type="application/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<script type="text/javascript">

$(document).on('click', '.view-slide', function () {
        $(this).children('.fa').addClass('fa-minus').removeClass('fa-plus');
        $('.lot-details-wrapper').addClass('open-alloc');
        var lot_id = $(this).data('lotid');
        $(".loader").show();
        $.ajax({
 
        url: "/wrcAllo",
        method: 'GET',
        dataType: "html",
        data: {lot_id: lot_id},
        success: function (htmlData) {
              $(".loader").hide();
            $('#wrcalo').html(htmlData); }
       });
    });
    $(document).on('click', '.lot-details-wrapper .close', function () {
        $('.view-slide').children('.fa').removeClass('fa-minus').addClass('fa-plus');
        $('.lot-details-wrapper').removeClass('open-alloc');
    });



    // Checkbox class add and remove

    // function toggleAllocateWRCBtn(){
    //     var checked_countWRC = 0;
    //     var wrc_id = $(obj).data('wrcid');
    //     $('.check-wrc').each(function(){
    //         if($(this).prop('checked')){
    //             checked_countWRC++;
    //         }
    //         alert('checked');
    //     });
    //     $('.allocation-wrc-main').removeClass('show-wrc-alloc-btn');
    //     if(checked_countWRC > 0){
    //         $('.allocation-wrc-main').addClass('show-wrc-alloc-btn');
    //     }
    // }

    // $(".check-wrc").click(function () {
    //     toggleAllocateWRCBtn();
    // });

    function toggleAllocateSKUBtn(){
        var checked_countSKU = 0;
        $('.check-sku').each(function(){
            if($(this).prop('checked')){
                checked_countSKU++;
            }
        });
        $('.allocation-sku-main').removeClass('show-sku-alloc-btn');
        if(checked_countSKU > 0){
            $('.allocation-sku-main').addClass('show-sku-alloc-btn');
        }
    }

    $(".check-sku").click(function () {
        toggleAllocateSKUBtn();
    });

    function showallo(){
        var lots=[];
        $('.checkall:checked').each(function(){
            lots.push($(this).data('lot_id'));
        });

        var wrcs = [];
        $('.check-wrc:checked').each(function(){
            wrcs.push($(this).data('wrc_id'));
        });

        var uploadraw=[];
        var uploadraw_ids=[];
        var skus_code = [];
        
        $('.check-sku:checked').each(function(){   
         var  sku_code = $(this).data('sku_code');  
         var  wrc_id = $(this).data('wrc_id');
         skus_code.push(sku_code);


         $('img.' + wrc_id + '_' + sku_code).each(function(){
            var id = $(this).parent('a').find('input').val();
            uploadraw_ids.push(id);
            uploadraw.push($(this).attr('src'));
        })
     });

        showLoader();
        $.ajax({
            url: "/allocation-ajax",
            method: 'GET',
            dataType: "html",
            data: {lots: lots, wrcs : wrcs, skus_code : skus_code, uploadraw:uploadraw, uploadraw_ids : uploadraw_ids},
            success: function(htmlData) {
                $('#allo-dynamic').html(htmlData);
                select2();
                $('#allocation').modal();
                hideLoader();
            } 

        });    
    }

    function saveallo(){
        $.ajax({
            url: "/save-allo",
            method: 'POST',
            dataType: "text",
            data:$('#allo').serialize(),
            success: function(data) {

           alert('WRC allocated successfully')


            }
        });
    } 
</script>
 

<script type="text/javascript">

    function toggleAllocateWRCBtn(){
        var checked_countWRC = 0;
        var wrc_id = $(obj).data('wrcid');
        $('.check-wrc').each(function(){
            if($(this).prop('checked')){
                checked_countWRC++;
            }
            
        });
        $('.allocation-wrc-main').removeClass('show-wrc-alloc-btn');
        if(checked_countWRC > 0){
            $('.allocation-wrc-main').addClass('show-wrc-alloc-btn');
        }
    }

    $(".check-wrc").click(function () {
        toggleAllocateWRCBtn();
    });

</script>

@endsection