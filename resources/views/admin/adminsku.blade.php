 <tr id="dynamic_sku_{{$wrcId}}" style="display: none; background-color: rgba(12 15 25 / 20%);">
 <td colspan="12" class="">
    <div class="" id="demo" style="border-top: 1px solid rgb(222, 226, 230);">
       <?php if(count($skus) == 0) { ?>
        <h3 style="position: relative;" class="text-uppercase pt-3 mb-3">
          No Sku Found
          <i class="far fa-times-circle" style="position: absolute; font-size: 24px; right: 58px; top: 30px; cursor: pointer;" onclick="removeSkuRow({{$wrcId}})"></i>
        </h3>
      <?php } else { ?>
      <h3 style="font-size:36px; font-weight: 300; position: relative;" class="text-uppercase pt-3 mb-3">
      <?php echo (count($skus))  ?> Skus Available in this Wrc 
        <i class="far fa-times-circle" style="position: absolute; font-size: 24px; right: 58px; top: 30px; cursor: pointer;" onclick="removeSkuRow({{$wrcId}})"></i>
      </h3>
      <table class="table table-hover text-nowrap text-center mb-0 slide-tt">

          <thead>
            <tr class="sku-tt">
              <th>Id</th>
              <th>SKU Code</th>
              <th>Brands</th>
              <th>Gender</th>
              <th>Category</th>
              <th>Sub-Category</th>
            </tr>
          </thead>
          <tbody> 
            @foreach($skus as $index => $sku)
            <tr class="sku-tt">
                  <td>{{$index+1}}</td>
              <td>{{$sku->sku_code}}</td>
              <td>{{$sku->brand}}</td>
              <td>{{$sku->gender}}</td>
              <td>{{$sku->category}}</td>
              <td>{{$sku->subcategory}}</td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
      <?php } ?>
  </td>
</tr>

