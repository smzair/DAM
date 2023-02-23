<div class="row mb-3">
  <div class="col-sm-6">
    <div class="info-dt">
      <span class="text-normal">No of WRC:</span>
      <span class="text-bold">{{count($wrcs)}}</span>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="info-dt">
      <span class="text-normal">Allocated Target:</span>
      <span class="text-bold">{{count($skusCode)}}</span>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="form-group">
      <label>Number of WRCs</label>
      <select multiple class="form-control select2" style="width: 100%" disabled>
        @foreach($wrcs as $wrc)
        <option selected="">{{$wrc}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">
      <label>Allocated Target</label>
      <select multiple class="form-control select2"  style="width: 100%"disabled>
        @foreach($skusCode as $sku )
        <option selected="">{{$sku}}</option>
        @endforeach
      </select>
    </div>
  </div>
</div>

@foreach($skusId as $id )
<input type="hidden" name="selected_skus[]" value="{{$id}}">
@endforeach