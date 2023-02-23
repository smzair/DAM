@extends('layouts.admin')

@section('title')

Allocation Details (For Creatives)

@endsection
@section('content')
<!-- New Allocation Details - Person Allocating (For Creative) -->
<style type="text/css">
      .custom-new-form-group {
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-between;
    }

    .group-inner.select-wrapper {
        flex: 1 1 auto;
        max-width: 80%;
    }

    .group-inner.input-wrapper {
        flex: 0 0 auto;
        max-width: 20%;
        padding-left: 10px;
    }

    .custom-info {
        width: 100%;
        display: block;
        margin-top: 16px;
    }

    .custom-info p {
        margin: 0;
    }

    .info-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: block;
    }

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

    table {
      /* border: 0.5px solid rgb(242, 228, 228); */
      table-layout: fixed;
      
    }

    th,
    td {
      border-bottom: 0.5px solid rgb(239, 221, 221);
      width: 100px;
      overflow: hidden;
    }

</style>
<div class="container-fluid mt-5">
    <div class="row m-0">
      <div class="col-12  py-4" style="border-radius: 15px; box-shadow: rgb(100 100 111 / 20%) 0px 7px 29px 0px;">
        <div class="row m-0">
          <div class="col-xl-4 col-md-4 col-sm-4 col-12 editor-list-grp ">
            <div class="card m-0 card card-transparent" style="border-radius: 10px; box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px;">
              <div class="card-body p-0">
                <div class="editor-links">
                  <h3 class="">Select Name To View Allocations Details</h3>
                  <ul class="nav flex-column" style="margin-bottom: 10px;">
                    @foreach($allocationList['resData'] as $editorId => $allo)
                    <li class="nav-item">
                      <a style="color: white" id="editorname1" class="nav-link" href=".{{$allo['user_id']}}" data-toggle="tab">
                        {{$allo['name']}}
                     </a>
                   </li>
                   @endforeach
                 </ul>
               </div>
             </div>
           </div>
         </div>
         <div class="col-xl-8 col-md-8 col-sm-8 col-12 editor-table-grp" style="overflow: overlay;" >
          <div class="editor-dtl card m-0 card card-transparent">
            <div class="edit-upld-info">
              <h3 class="">Allocations Details</h3>
            </div>
            <div class="edit-upld-pop " style="padding: 1px" >
              <table class="table mb-0" >
                <tr>
                  <th class="align-middle border-top-0">User Id</th>
                  <th class="align-middle border-top-0" >Lot Number</th>
                  <th class="align-middle border-top-0" >Wrc Number</th>
                  <th class="align-middle border-top-0" >Allocated Qty</th>
                  <th class="align-middle border-top-0" >Order Qty</th>
                  <th class="align-middle border-top-0" >Sku Qty</th>
                  <th class="align-middle border-top-0" >Number of Batches</th>
                  <th class="align-middle border-top-0" >Allocation Date</th>
                </tr> 
              </table>
              <div class="table-responsive p-0 editor-table-list tab-content" style="max-height: 350px; height: 100%;">
               
                @foreach($allocationList['resDataManyUser'] as $editorId => $allo)
                <table class="table   mb-0 tab-pane {{$allo['user_id']}}" >
                  <thead>
                     
                    <tr style="">
                      <th class="">{{$allo['user_id']}}</th>
                      <th class="" >{{$allo['lot_number']}}</th>
                      <th class="" >{{$allo['wrc_number']}}</th>
                      <th class="" >{{$allo['allocated_qty']}}</th>
                      <th class="" >{{$allo['order_qty']}}</th>
                      <th class="" >{{$allo['sku_count']}}</th>
                      <th class="" >{{$allo['batch_no'] == 0 ? 'None' : $allo['batch_no']}}</th>
                      <th class="" >{{dateFormat($allo['created_at'])}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $sr = 1; ?>
                    
                  </tbody>
                </table>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection