<div class="col-sm-6 col-12">
    <div class="card card-transparent text-center" style="border-radius:20px; height: calc(100% - 1rem);">
        <div class="card-body py-5 wrc-dt-no">

            <span class="d-inline-block">WRC No - </span>  <span class="text-bold d-inline-block">{{$wrcNumber}}</span>
            <p style="
            display: block;
            width: 100%;
            " >To be Generated</p>
            
        </div>
    </div>
</div>
<div class="col-sm-6 col-12">
    <div class="card card-transparent text-center" style="border-radius:20px;">
        <div class="card-header text-left">
            <!-- <div class="wrcNo float-sm-right mb-2 mb-sm-0">Wrc No - <span class="text-bold d-inline-block">WRC-45677</span></div> -->
            <div class="wrcList float-sm-left float-none card-title"> {{$lot}} Contains {{count($wrcs)}} WRC</div>
        </div>
        <div class="card-body p-0">
            <ul class="list-group wrc-flex-list">
                @foreach($wrcs as $wrc)
                <li class="list-group-item wrc-flex-list-item"><span><b>{{$wrc->wrc_id}}</b></span> &nbsp 
                    @if($wrc->flat_shot == 0)
                    <button type="button" class="btn btn-success swalDefaultSuccess" data-wrc_id="{{$wrc->id}}" onclick="flatShot(this)">  Create Flat Shot WRC</button>
                    @endif
                   <!---- @if($wrc->extra_mood_shot = 0)
                    <button type="button" class="btn btn-success swalDefaultSuccess" data-wrc_id="{{$wrc->id}}" onclick="moodShot(this)">Create Extra Mood Shot</button>
                    @endif   ---> 
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>