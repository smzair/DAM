<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="createUserLabel">Edit User
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;
    </span> </button>
  </div>
  <div class="modal-body">
    <form action="" id="Edit_User">
      @csrf
      <div class="form-group d-none" >
        <label class="control-label required">Select Role</label>
        <select class="custom-select" id="role-selc">

          @foreach($roles as $role)
          <option>{{$role->name}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <input type="hidden" name="id" value="{{$data->id}}">
        
        <label class="control-label required" > Name </label>
        
        <input type="text" name="name" placeholder="Name" value="{{$data->name}}"class="form-control"> 
      </div>
        <div class="form-group">
          <label class="control-label requiredu" > Email </label>
          <input type="text" name="email" placeholder="Email" value="{{$data->email}}" class="form-control"> </div>
          <div class="form-group">
            <label class="control-label required requiredu"> Employee ID </label>
            <input type="text" name="client_id" placeholder="Employee Id" value="{{$data->client_id}}" class="form-control"> </div>
            <div class="form-group">
              <label class="control-label required"> Address </label>
              <input type="text" name="Address" placeholder="Address" value="{{$data->Address}}" class="form-control"> </div>
              <div class="form-group">
                <label class="control-label required"> Phone Number </label>
                <input type="text" name="phone" placeholder="Phone Number" value="{{$data->phone}}" class="form-control"> </div>
              </form>
            </div>

            <div class="modal-footer justify-content-between">
             <button type="button" class="btn btn-danger" data-dismiss="modal">Close </button>
             <a href="javaScript:void(0)"class="btn btn-warning" onclick="EUser()">Save User</a>
           </div>