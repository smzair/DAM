@extends('layouts.DamNewMain')
@section('title')
Clients - Create New user
@endsection

@section('main_content')
<div class="row">
  <div class="col-12">
    <a class="btn btn-light border-0 back-btn" href="{{ url()->previous() }}" role="button"><svg width="22" height="14"
        viewBox="0 0 22 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6.69628 1.5L1 7L6.69628 12.5M21 7H1.15953" stroke="#9F9F9F" stroke-width="1.5"
          stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
      &nbsp; back</a>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <p class="create-user-txt">Create User</p>
  </div>
  <div class="row">
    <div class="col-lg-5 col-md-5 col-sm-12">
      <select class="form-select form-select-lg rounded-0 mb-3 select2 user-form" aria-label=".form-select-lg example" multiple>
        <option value="0">Choose brand</option>
        @foreach ($brands as $row)
          <option value="{{$row['brand_id']}}">{{$row['name']}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-12 ">
      <input class="form-control form-control-lg rounded-0 mb-3 user-form" type="text" placeholder="Enter name"
        aria-label=".form-control-lg example">
    </div>
    <div class="col-lg-5 col-md-5 col-sm-12">
      <input class="form-control form-control-lg rounded-0 mb-3 user-form" type="text" placeholder="Enter email"
        aria-label=".form-control-lg example">
    </div>
    <div class="col-lg-5 col-md-5 col-sm-12">
      <input class="form-control form-control-lg rounded-0 mb-3 user-form" type="text"
        placeholder="Enter phone no." aria-label=".form-control-lg example">
    </div>
    <div class="col-lg-10 col-md-10  col-sm-12">
      <input class="form-control form-control-lg rounded-0 mb-3 user-form" type="text" placeholder="Address"
        aria-label=".form-control-lg example">
    </div>

    <div class="col-12">
      <p class="mandatory">* All fields are mandatory</p>
    </div>
    <div class="col-10 mt-4">
      <div class="d-lg-flex d-md-flex justify-content-between">
        <button type="button" class="btn border user-btn">+ Create user</button>
        {{-- <div style="line-height: 0%;">
          <p class="default-pass">Default password</p>
          <p class="odn-sign">Dam@odn2023
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="32" height="32" rx="16" fill="#9F9F9F" />
              <rect x="8" y="8" width="16" height="16" fill="#B8B8B8" />
              <line x1="10.1718" y1="9.46481" x2="22.39" y2="21.683" stroke="#D1D1D1" />
              <line x1="9.46468" y1="21.6836" x2="21.6829" y2="9.46537" stroke="#D1D1D1" />
            </svg>
          </p>
        </div> --}}
      </div>
    </div>
    
  </div>
</div>
@endsection

