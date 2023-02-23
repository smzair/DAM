
<link rel="stylesheet" href="{{asset('plugins/sort-table-plugin/dist/excel-bootstrap-table-filter-style.css')}}">
<style type="text/css">
  .text-title{
    text-align: center;
    font-size: 20px;
}
.custom-wrc-table.card.card-transparent {
    display: block !important;
    margin-bottom: 20px;
    box-shadow: none !important;
    background: transparent !important;
    backdrop-filter: none !important;
    border-radius: 8px !important;
    border: 1px solid #adaeb0;
    margin-top: 20px;
}

</style>

@if($sheet == 1)

<style>
    /* SKU Upload List Summary CSS */

    .summary-title {
        display: block;
        width: 100%;
        margin-bottom: 20px;
        text-align: center;
    }

    .left-col-card .card.card-transparent .card-header, 
    .left-col-card .card.card-transparent .card-body {
        text-align: center;
    }

    .left-col-card .card.card-transparent .card-header h5 {
        margin: 0;
    }

    .left-col-card .card.card-transparent .card-body h1 {
        margin: 0;
    }

    .right-col-card .card.card-transparent .card-header h5 {
        margin: 0;
    }

    .right-col-card .card.card-transparent .card-body h1 {
        margin: 0;
    }

    .right-col-card {
        height: 100%;
    }

    .right-col-card .card.card-transparent {
        height: 100%;
        margin: 0;
    }

    .right-col-card .card.card-transparent .card-inner {
        height: 100%;
    }

    .right-col-card .card.card-transparent .card-inner .card-body {
        min-height: 240px;
        height: 100%;
        overflow-y: auto;
        max-height: 240px;
    }

    .left-col-card.not-found-sku-card .card.card-transparent {
        margin: 0;
    }

    .code-list {
        display: block;
        width: 100%;
        position: relative;
    }

    .code-list > ol {
        margin-bottom: 0;
        padding-left: 18px;
        display: block;
        font-size: 18px;
        color: #fff;
    }

    .code-list > ol > li {
        position: relative;
    }

    .code-list > ol > li:not(:last-of-type) {
        margin-bottom: 10px;
    }

    .code-list > ol > li > span {
        display: inline-block;
    }

    .light-dsh-mode .code-list > ol {
        color: #000;
    }

    @media (max-width: 575px) {
        .left-col-card .card.card-transparent .card-header, 
        .left-col-card .card.card-transparent .card-body {
            text-align: left;
        }
    }

    /* End of SKU Upload List Summary CSS */
</style>


<!-- SKU Upload List Summary HTML  -->

<div class="custom-sku-list-summary">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card card-transparent">
                    <div class="card-inner">
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="summary-title">
                                            <h4>SKU List Upload Summary</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="left-col-card found-sku-card">
                                            <div class="card card-transparent">
                                                <div class="card-inner">
                                                    <div class="card-header">
                                                        <h5>SKU Found Count</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="count-no">
                                                            <h1 id="foundCount">{{count($skuFound)}}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="left-col-card not-found-sku-card">
                                            <div class="card card-transparent">
                                                <div class="card-inner">
                                                    <div class="card-header">
                                                        <h5>SKU Found and Matched with Commercial</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="count-no">
                                                            <h1 id="notfoundCount">{{count($skuFoundmatched)}}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="left-col-card not-found-sku-card">
                                            <div class="card card-transparent">
                                                <div class="card-inner">
                                                    <div class="card-header">
                                                        <h5>SKU Found and Do not Matched with Commercial</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="count-no">
                                                            <h1 id="notfoundCount">{{count($skuFoundnotmatched)}}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="left-col-card not-found-sku-card">
                                            <div class="card card-transparent">
                                                <div class="card-inner">
                                                    <div class="card-header">
                                                        <h5>SKU Not Found Count</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="count-no">
                                                            <h1 id="notfoundCount">{{count($notfound)}}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-12 mt-3 mt-md-0">
                                        @if (count($notfound) != 0)
                                        <div class="right-col-card not-found-sku-card-details">
                                            <div class="card card-transparent">
                                                <div class="card-inner">
                                                    <div class="card-header">
                                                        <h5>SKU Code Not Found</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="code-list">
                                                            <ol>
                                                                @foreach($notfound as $nf)
                                                                <li><span id="code1">{{$nf}}</span></li>
                                                                @endforeach
                                                            </ol>
                                                            <br> <br> 
                                                            @if (count($skuFoundnotmatched) != 0)

                                                            <h5>SKU Code Found but Not matched commercial</h5>
                                                            <ol>
                                                                @foreach($skuFoundnotmatched as $nmf)
                                                                <li><span id="code1">{{$nmf['sku_code']}}</span></li>
                                                                @endforeach
                                                            </ol>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<div class="custom-wrc-table card card-transparent">
    <div class="wrc-tb-title card-header px-2">
        <h5 class="card-title" style="font-size: 13px;">
            <span class="d-inline-block">Article Count:</span>
            <span class="d-inline-block text-bold">{{count($skus)}}</span>
            <span class="d-inline-block">SKUs Pending in this LOT:</span>
            <span class="d-inline-block text-bold">{{$pendingSkus}}</span>
        </h5>
        <h3 class="text-title">Inwarded SKUs</h3>
    </div>
    @if(count($skus) > 0)
    <div class="wrc-cc-content table-responsive" id="wrctableData">
        <table class="table edt-table  text-nowrap m-0" id="wrctable">
            <thead>
                <tr>
                    <th class="align-middle">Id</th>
                    <th class="align-middle">Sku Code</th>
                    <th class="align-middle">Gender</th>
                    <th class="align-middle">Category</th>
                    <th class="align-middle">Type of clothing</th>

                </tr>
            </thead>
            <tbody>

                @foreach($skus as $sku)

                <tr>
                    <td class="align-middle td-data index-tddata">{{$sr++}}</td>
                    <td class="align-middle td-data">{{$sku['sku_code']}}
                        <input type="hidden" name="sku_id[]" value="{{$sku['id']}}">
                    </td>
                    <td class="align-middle td-data">{{$sku['gender']}}</td>
                    <td class="align-middle td-data">{{$sku['category']}}</td>
                    <td class="align-middle td-data">{{$sku['type_of_clothing']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <h2 class="text-center text-danger" >No record Found</h2>
    @endif
</div>


<script type="application/javascript" src="{{asset('plugins/sort-table-plugin/dist/excel-bootstrap-table-filter-bundle.js')}}"></script>
<script type="text/javascript">
  $('#wrctable').excelTableFilter();
</script>