
@extends('layouts.admin')

@section('title')
Allocations Details 
@endsection
@section('content')

<style type="text/css">
 .editor-links {
    max-height: 350px;
    height: auto;
    overflow-y: auto;
  }

  .editor-links ul li a {
    color: #000;
    font-weight: 700;
  }

  .editor-links ul li a:hover {
    background-color: #ececec;
  }

  .editor-links ul li a.active {
    background-color: #ececec;
  }

  .edit-upld-pop {
    width: 100%;
    height: 100%;
  }

  .editor-dtl {
    position: relative;
    height: 100%;
    border-radius: 10px;
    box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px;
  }

  .edit-upld-info {
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    width: 100%;
    left: 0;
    height: 100%;
    top: 0;
    transition: all 0.2s ease-in-out;
  }

  .edit-upld-info h2 {
    color: #ccc;
    /* letter-spacing: 2px; */
    font-weight: bold;
    text-align: center;
    font-size: 22px;
    letter-spacing: 1px;
  }

  .edit-upld-open .edit-upld-info {
    display: none;
  }

  .edt-sku-list {
    position: absolute;
    z-index: 9;
    min-width: 200px;
    right: 70%;
    border-radius: 14px;
  }

  .dropdown-toggle.open-sk:after {
  transform: rotate(
  -180deg
  );
  }

  .editor-list-grp .card, .editor-dtl {
      background: rgb(211 214 221 / 25%);
      box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px !important;
      border-radius: 14px !important;
      border-top: 2px solid #fbf702 !important;
      padding-bottom: 20px !important;
  }

  @media (max-width: 767px) {
    /* .editor-dtl {
      border: none !important;
    } */

    .edit-upld-open .edit-upld-info {
      display: none;
    }
  }

  @media (max-width: 575px) {
    .editor-table-grp {
        margin-top: 30px;
    }

    .editor-dtl {
        min-height: 350px;
    }
  }

</style>



<style>

  .editor-links {
    max-height: 350px;
    height: auto;
    overflow-y: auto;
  }

  .editor-links ul li a {
    color: #fff;
    font-weight: 700;
  }

  .editor-links ul li a:hover {
    background-color: rgba(16 18 27 / 40%);
  }

  .editor-links ul li a.active {
    background-color: rgba(16 18 27 / 40%);
  }

  .light-dsh-mode .editor-links ul li a {
    color: #000;
  }

  .light-dsh-mode .editor-links ul li a:hover {
    background-color: rgba(16 18 27 / 20%);
  }

  .light-dsh-mode .editor-links ul li a.active {
    background-color: rgba(16 18 27 / 20%);
  }

  .edit-upld-pop {
    width: 100%;
    height: 100%;
  }

  .editor-dtl {
    position: relative;
    height: 100%;
    border-radius: 10px;
    box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px;
  }

  .edit-upld-info {
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    width: 100%;
    left: 0;
    height: 100%;
    top: 0;
    transition: all 0.2s ease-in-out;
  }

  .edit-upld-info h2 {
    color: #ccc;
    /* letter-spacing: 2px; */
    font-weight: bold;
    text-align: center;
    font-size: 22px;
    letter-spacing: 1px;
  }

  .edit-upld-open .edit-upld-info {
    display: none;
  }

  .edt-sku-list {
    position: absolute;
    z-index: 9;
    min-width: 200px;
    right: 70%;
  }

  .dropdown-toggle.open-sk:after {
  transform: rotate(
  -180deg
  );
  }

  .edt-sku-list li.list-group-item {
    background-color: #21242d;
    color: #f9fafb;
    font-size: 12px;
    transition: all 0.4s ease-in-out;
    cursor: pointer;
  }

  .edt-sku-list li.list-group-item:hover {
    background-color: rgb(42 46 60);
  }

  @media (max-width: 767px) {
    /* .editor-dtl {
      border: none !important;
    } */

    .edit-upld-open .edit-upld-info {
      display: none;
    }
  }

  @media (max-width: 575px) {
    .editor-table-grp {
        margin-top: 30px;
    }

    .editor-dtl {
        min-height: 350px;
    }
  }

</style>

<body>

  <div class="container-fluid mt-5">
    <div class="row m-0">
      <div class="col-12 card card-transparent py-4" style="border-radius: 15px; box-shadow: rgb(100 100 111 / 20%) 0px 7px 29px 0px;">
        <div class="row m-0">
          <div class="col-xl-4 col-md-4 col-sm-4 col-12 editor-list-grp">
            <div class="card m-0" style="border-radius: 10px; box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px;">
              <div class="card-body p-0">
                <div class="editor-links">
                  <h4 class="text-center p-2 my-4 text-uppercase" style="font-size: 2rem;">Editors</h4>
                  <ul class="nav flex-column" style="margin-bottom: 10px;">
                    @foreach($allocationList as $editorId => $allo)
                    <li class="nav-item">
                      <a id="editorname1" class="nav-link" href="#{{$editorId}}" data-toggle="tab">
                        {{$allo['editor']}}
                     </a>
                   </li>
                   @endforeach
                 </ul>
               </div>
             </div>
           </div>
         </div>
         <div class="col-xl-8 col-md-8 col-sm-8 col-12 editor-table-grp">
          <div class="editor-dtl card m-0">
            <div class="edit-upld-info">
              <h2>Select Editor To View Allocations Details</h2>
            </div>
            <div class="edit-upld-pop">
              <div class="table-responsive p-0 editor-table-list tab-content" style="max-height: 350px; height: 100%;">
                @foreach($allocationList as $editorId => $allo)
                <table class="table text-nowrap mb-0 tab-pane" id="{{$editorId}}">
                  <thead>
                    <tr>
                      <th class="align-middle border-top-0" width="1%">#</th>
                      <th class="align-middle border-top-0">LOT Number</th>
                      <th class="align-middle border-top-0">WRC Count</th>
                      <th class="align-middle border-top-0">SKU Count</th>
                      <th class="align-middle border-top-0">Images Count</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $sr = 1; ?>
                    @foreach($allo['lot_info'] as $lotInfo)
                    <tr>
                      <td class="align-middle" width="1%">{{$sr++}}</td>
                      <td class="align-middle">{{$lotInfo['lot_id']}}</td>
                      <td class="align-middle position-relative">
                        <span class="dropdown-toggle d-inline-block ed-wrc-cnt" style="cursor: pointer;">{{count($lotInfo['wrc_info'])}}</span>
                        <ol class="list-group mt-2 edt-sku-list" style="display: none;">
                          @foreach($lotInfo['wrc_info'] as $wrcInfo)
                          <li class="list-group-item">{{$wrcInfo['wrc_id']}}</li>
                          @endforeach
                        </ol>
                      </td>
                      <td class="align-middle position-relative">
                        <span class="dropdown-toggle d-inline-block ed-wrc-cnt" style="cursor: pointer;">{{count($lotInfo['all_skus'])}}</span>
                        <ol class="list-group mt-2 edt-sku-list" style="display: none;">
                          @foreach($lotInfo['wrc_info'] as $wrcInfo)
                          @foreach($wrcInfo['sku_info'] as $skuInfo)
                            <li class="list-group-item">{{$wrcInfo['wrc_id']}} => {{$skuInfo['sku_id']}}</li>
                          @endforeach
                          @endforeach
                        </ol>
                      </td>
                      <td class="align-middle">{{count($lotInfo['all_files'])}}</td>
                    </tr>
                    @endforeach
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
</div>

<div class="fix-infor-wrapper">
    <a href="javascript:;" class="information-pp-btn" id="info-popbtn">
      <i class="fas fa-info ic-infor"></i>
      <i class="fas fa-times cl-infor"></i>
    </a>
    <div class="infor-content">
      <ul class="info-ll-list">
        <li><b>To view allocated information, select the editor for allocation history.</b></li>
      </ul>
    </div>
  </div>


  <script type="application/javascript" src="plugins/jquery/jquery.min.js"></script>

  <script>
    $(document).on('click', '.editor-links .nav-link', function () {
      $('body').addClass('edit-upld-open');
    });

    $(document).on('click', '.ed-wrc-cnt', function () {
        $(this).next('ol').fadeToggle(0);
        $(this).toggleClass('open-sk');
        $(this).parent('td').parent('tr').siblings('tr').find('.edt-sku-list').fadeOut(0);
        $(this).parent('td').parent('tr').siblings('tr').find('.ed-wrc-cnt').removeClass('open-sk');
        $(this).parent('td').siblings('td').find('.edt-sku-list').fadeOut(0);
        $(this).parent('td').siblings('td').find('.ed-wrc-cnt').removeClass('open-sk');
    });

  </script>



@endsection