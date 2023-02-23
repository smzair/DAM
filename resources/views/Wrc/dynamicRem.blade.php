
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <textarea class="form-control" name="rejection_reason" id="RejreasonInput" cols="20" rows="5" placeholder="Enter your reason"></textarea>
              </div>
            </div>

            <input type="hidden" name="wrc_id" value="{{$wrc}}">
            <input type="hidden" name="reject" value="{{$reject}}">
            <div class="col-12">
                <button type="submit" class="btn btn-warning" onclick="updateComment()" id="reasonSubmit">Submit</button>
            </div>
          </div>
      