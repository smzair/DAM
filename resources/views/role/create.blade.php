


@extends('layouts.admin')
@section('pageName')
Create Roles
@endsection

@section('content')
<div class="container ccr-role mt-5">
    <div class="row">
        <div class="col-12">
<div class="card card-primary card-transparent">
    <div class="card-header">
        <h3 class="card-title">Add New Role</h3>
        <div class="card-tools">
            <a href="{{ route('role.index') }}" class="btn btn-danger"><i class="fas fa-shield-alt"></i> See All Roles</a>
        </div>
    </div>
    <div class="card-body">

  <form method="POST" action="">
    <div class="form-group">
      <label class="control-label required">Enter New Role</label>
      <input class="form-control" type="text" id="input" name="input" required placeholder="Role name">
    </div>
    <div class="ss-submit-btn">
      <button type="submit" class="btn btn-warning">Submit</button>
    </div>
  </form>



</div>
</div>
</div>
</div>
</div>

<div class="fix-infor-wrapper">
  <a href="javascript:;" class="information-pp-btn" id="info-popbtn">
    <i class="fas fa-info ic-infor"></i>
    <i class="fas fa-times cl-infor"></i>
  </a>
  <div class="infor-content">
    <p>Check Your Data Form Dashboard</p>
  </div>
</div>

@endsection