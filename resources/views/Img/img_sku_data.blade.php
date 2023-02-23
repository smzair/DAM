   <div class="col-xl-4 col-lg-12 col-sm-4 col-12">
    <div class="card card-transparent">
        <div class="card-body">
            <span class="count-no">
                {{$countarticle}}
            </span>
            <span class="count-text">
                Total Article
            </span>
        </div>
    </div>
</div>
<div class="col-xl-4 col-lg-6 col-sm-4 col-12">
    <div class="card card-transparent">
        <div class="card-body">
            <span class="count-no">
             {{$countskuFoundAc}}
         </span>
         <span class="count-text">
            Accepted
            <span class="text-success">
                <i class="fas fa-check-circle"></i>
            </span>
        </span>
    </div>
</div>
</div>
<div class="col-xl-4 col-lg-6 col-sm-4 col-12">
    <div class="card card-transparent">
        <div class="card-body">
            <span id="reject" class="count-no">
                {{$countskuFoundRe}}
            </span>
            <span class="count-text">

                <span class="text-danger">
                    <i class="fas fa-times-circle"></i>
                </span>
            </span>
        </div>
    </div>
</div>
<div class="revised-list card card-transparent">

    @if ($foldersnotfound == 0)
    <h5 class="not-uploaded-folder-info">
        <span class="success-folder">
            All folders matched Skus successfully
        </span></h5>
        @else
        <h5 class="not-uploaded-folder-info">
            <span class="error-folder">
                Folders didn't matched Sku: <b></b>
            </span>
        </h5>
        <ol>
            @foreach($skuNotFound as $skusnot)
            <li><span class="revised-span">{{$skusnot}}</span></li>
            @endforeach
        </ol>
        @endif

    </div>





























