<input type="hidden" name="wrc_id" value="{{$wrcNumber}}">
<div class="col-sm-4">
    <div class="form-group">
        <label>Product Type</label>
        <input type="text" class="form-control form-control-border reset" id="product_type" name="product_type" readonly value="{{$comInfo->product_category}}"  />
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label>Type Of Shoot</label>
        <input type="text" class="form-control form-control-border reset" id="shoot_type" name="shoot_type" readonly value="{{$comInfo->type_of_shoot}}">
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label>Gender</label>
        <input type="text" class="form-control form-control-border reset" id="gender" name="gender" readonly value="{{$comInfo->gender}}">
    </div>
</div>

<div class="col-sm-4">
    <div class="form-group">
        <label>Type Of Clothing</label>
        <input type="text" class="form-control form-control-border reset" id="clothing_type" name="clothing_type" readonly value="{{$comInfo->type_of_clothing}}">
    </div>
</div>

<div class="col-sm-4">
    <div class="form-group">
        <label>Adaptation 1</label>
        <input type="text"  class="form-control form-control-border reset" id="adapation_1" name="adapation_1" readonly value="{{$comInfo->adaptation_1}}">
    </div>
</div>

<div class="col-sm-4">
    <div class="form-group">
        <label>Adaptation 2</label>
        <input  type="text" class="form-control form-control-border reset" id="adapation_2" name="adapation_2" readonly value="{{$comInfo->adaptation_2}}">
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label>Adaptation 3</label>
        <input type="text" class="form-control form-control-border reset" id="adapation_3" name="adapation_3" readonly value="{{$comInfo->adaptation_3}}">
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label>Adaptation 4</label>
        <input  type="text" class="form-control form-control-border reset" id="adapation_4" name="adapation_4" readonly value="{{$comInfo->adaptation_4}}">
    </div>
</div>

