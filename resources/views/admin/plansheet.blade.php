<div class="row mb-3">
  <div class="col-sm-6">
    <div class="info-dt">
      <span class="text-normal">No of WRC: 1</span>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="info-dt">
      <span class="text-normal">Allocated Target:{{count($skusCodes)}}</span>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="form-group">
      <label>WRC Number</label>
      <select multiple class="form-control select2" style="width: 100%" disabled>
        <option selected="">{{$wrc_id}}</option>
      </select>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">
      <label>Allocated Target</label>
      <select multiple class="form-control select2"  style="width: 100%"disabled>
      @foreach($skusCodes as $skusCode)
        <option selected="">{{$skusCode}}</option>
        @endforeach
      </select>
    </div>
  </div>
</div>
 <div>
            @foreach($nullIds as $codes)
<li>{{$codes}}</li>
    @endforeach
        </div>
@foreach($skusIds as $skuId)
<input type="hidden" name="selected_skus[]" value="{{$skuId}}">
@endforeach