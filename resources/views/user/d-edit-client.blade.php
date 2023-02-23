              <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Edit Client
                  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> 
                </button>
              </div>
              <div class="modal-body">
                <form action="" id="editClient_form">
                  @csrf
                  <div class="form-group">
                    <label class="control-label required">Select Role</label>
                    <select class="custom-select" id="role-selc">
                        <option selected>Client</option>
                    </select>
                  </div>
                  <input type="hidden" name="id" value="{{$data->id}}">
                  <div class="form-group">
                    <label class="control-label required"> Select Assigned AM</label>
                    <select class="custom-select" name="am_email" value="{{$data->am_email}}" id="am-selc">
                      <option value="{{$data->am_email}}">{{$data->am_email}}</option>
                       @foreach($am as $ams)
                        <option value="{{$ams->email}}">{{$ams->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label required"> Name </label>
                    <input type="text" name="name" value="{{$data->name}}" placeholder="Name" class="form-control" onkeypress ="return isAlphabet(event)"> </div>
                  <div class="form-group">
                    <label class="control-label requiredu"> Email </label>
                    <input type="text" name="email" value="{{$data->email}}" placeholder="Email" class="form-control"> 
                  </div>
                    <div class="form-group">
                    <label class="control-label required"> Client Id </label>
                    <input type="text" name="client_id" value="{{$data->client_id}}"  placeholder="Client Id" onkeypress="return isAlphaNumeric(event)"class="form-control"> 
                   </div>
                  <div class="form-group">
                    <label class="control-label required requiredu">Payment Terms</label>
                    <select class="custom-select form-control"   name="payment_term">
                      <option value="{{$data->payment_term}}" >{{$data->payment_term}}</option>
                        <option>100% Advance Before Bulk Submission</option>
                        <option>50 % Advance & Remaining Before Bulk Submission</option>
                        <option>Monthly Payments - No Advance</option>
                        <option>50% Advance Remaining After 15 days of Invoice</option>
                        <option>Post Bulk Images & Invoice Submission</option>
                        <option>Post Receipt of Hard Copy At Client Level</option>
                      </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label required"> Address </label>
                    <input type="text" name="Address" value="{{$data->Address}}" placeholder="Address" maxlength="500" class="form-control"> </div>
                  <div class="form-group">
                    <label class="control-label requiredu"> GST Number </label>
                    <input type="text" name="Gst_number" value="{{$data->Gst_number}}" placeholder="Gst number" maxlength="15" onkeypress="return isAlphaNumeric(event)" class="form-control"> </div>
                  <div class="form-group">
                    <label class="control-label required"> Phone Number </label>
                    <input type="text" name="phone" value="{{$data->phone}}" placeholder="Phone Number" maxlength="10" onkeypress="return isNumeric(event)" class="form-control"> </div>
                  <div class="form-group">
                    <label class="control-label required"> Company Name </label>
                    <input type="text" name="Company"value="{{$data->Company}}"  placeholder="Company Name" class="form-control"> </div>
                  <div class="form-group">
                    <label class="control-label requiredu"> Company Short Name </label>
                    <input type="text" name="c_short" value="{{$data->c_short}}" placeholder="Any Two Prefix" maxlength="4" required class="form-control"> </div>
                  <div class="form-group">
                    <label class="control-label required">Brand</label>
                    <select class="custom-select form-control" name="brand[]"  value="{{$data->brands_name}}"  multiple>
                      <option value="{{$data->brand_ids}}" >{{$data->brands_name}}</option>
                       @foreach($brand as $brnd)
                        <option value="{{$brnd->id}}">{{$brnd->name}}</option>
                        @endforeach
                    </select>
                  </div>
                </form>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close </button>
                 <a href="javaScript:void(0)"class="btn btn-warning" onclick="EClient()">Save User</a>
              </div>