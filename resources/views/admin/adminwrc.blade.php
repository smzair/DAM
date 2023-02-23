<tr id="dynamic_wrc_{{$lotId}}" style="display: block; background-color: rgba(12 15 25 / 20%);">
  <td colspan="8" class="">
      <div style="border-top: 1px solid rgb(222, 226, 230);">
        <?php if(count($wrcs) == 0) { ?>
        <h3 style="position: relative;" class="text-uppercase pt-3 mb-3">
          No Wrc Found
          <i class="far fa-times-circle" style="position: absolute; font-size: 24px; right: 58px; top: 30px; cursor: pointer;" onclick="removeWrcRow({{$lotId}})"></i>
        </h3>
      <?php } else { ?>
        <h3 style="font-size:36px; font-weight: 300; position: relative;" class="text-uppercase pt-3 mb-3">
          All WRC's
          <i class="far fa-times-circle" style="position: absolute; font-size: 24px; right: 58px; top: 30px; cursor: pointer;" onclick="removeWrcRow({{$lotId}})"></i>
        </h3>
        <table class="table table-hover text-nowrap text-center mb-0 slide-tt">
          <thead>
            <tr class="wrc-tt">
              <th>Id</th>
              <!-- <th>Status</th> -->
              <th>WRC Number</th>
              <th>Product Category</th>
              <th>Type Of Shoot</th>
              <th>Type Of Clothing</th>
              <th>Gender</th>
              <th>Adaptations</th>
           
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($wrcs as $index => $wrc)
            <tr id="wrc_row_{{$wrc->id}}">
              <td>{{$index+1}}</td>
            <!--   <td>
                <div class="bg-color mb-1 d-none" data-toggle="tooltip" data-placement="top" title="" style="width: 100%; height: 10px" data-original-title="View All Lot Status"></div>
                <form method="post" name="selectform" action="myform" id="formcollapse" class="colform d-none">
                  <select id="mySelect" class="custom-select yellowText" onselect="do()" style="width: 100%;">
                    <option class="white" value="Status" selected="">Status</option>
                    <option class="yellow" value="Inworded">Inworded</option>
                    <option class="orange" value="Inwording Completed">Inwording Completed</option>
                    <option class="gray" value="Ready For Shoot">Ready For Shoot</option>
                    <option class="voilet" value="Shoot Done">Shoot Done</option>
                    <option class="black" value="Ready For QC">Ready For QC</option>
                    <option class="blue" value="Ready For Submission">Ready For Submission</option>
                    <option class="green" value="Approved">Approved</option>
                    <option class="red" value="Rejected">Rejected</option>
                  </select>
                  <div class="sel-btn d-block mt-2">
                    <button type="button" class="btn btn-xs btn-success st-btn">Submit</button>
                  </div>
                </form>
                <span class="badge d-inline-block rounded-1 p-lg-2 p-md-2 p-sm-2 p-2 px-lg-3 px-md-4 align-middle" style="background: #FFFF00; position: relative; top: -1; cursor: default;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Inwarding">Inwarding</span>
              </td>
 -->
              <td>{{$wrc->wrc_id}}</td>
              <td>{{$wrc->product_category}}</td>
              <td>{{$wrc->type_of_shoot}}</td>
              <td>{{$wrc->type_of_clothing}}</td>
              <td>{{$wrc->gender}}</td>
              <td>
                <ol class="list-unstyled mb-0">
                  <li>{{$wrc->adaptation_1}}</li>
                  <li>{{$wrc->adaptation_2}}</li>
                  <li>{{$wrc->adaptation_3}}</li>
                  <li>{{$wrc->adaptation_4}}</li>
                </ol>
              </td>
                            <td>
                <a href="javascript:void(0)" onclick="allsku(this)" data-id="{{$wrc->id}}"class="btn btn-warning border-0">View All SKU</a>
              </td>
            </tr>
            @endforeach

          </tbody>
        </table>
      <?php } ?>
      </div>
    </td>
  </tr>