@extends('layouts.admin')

@section('title')
Edit Permission
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
<div class="card card-primary card-transparent">
    <div class="card-header">
        <h3 class="card-title">Edit Permission</h3>
        <div class="card-tools">
            <a href="{{ route('permission.index') }}" class="btn btn-danger"><i class="fas fa-shield-alt"></i> See All Permission</a>
        </div>
    </div>
    <form method="POST" action="">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Permission Name</label>
                <input type="text" name="name"  id="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name') }}" required placeholder="Permission Name">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Permission</button>
        </div>
    </form>
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