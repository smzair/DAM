<div class="row mb-3">
  <div class="col-sm-4">
    <div class="info-dt">
      <span class="text-normal">WRC Number:</span>
      
      <span class="text-bold">{{$wrc_id}}</span>

    </div>
  </div>
  <div class="col-sm-4">
    <div class="info-dt">
      <span class="text-normal">SKU Count:</span>
      <span class="text-bold">{{count($final['sku_code'])}}</span>
    </div>
  </div>
  

  <div class="col-sm-4">
    <div class="form-group">
      <label>Selected LOT</label>
      <select multiple class="form-control" name="lot-selected" id="lot-selected" disabled>
       
        <option>{{$lots}}</option>
      
      </select>
    </div>
  </div>
      @foreach($final['sku_code'] as $id)
      <input type="hidden" value="{{$id}}" name="sku_id[]">
      @endforeach
   

  </div>
</div>