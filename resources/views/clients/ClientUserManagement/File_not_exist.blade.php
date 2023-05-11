@extends('layouts.DamNewMain')
@section('title')
Home
@endsection

@section('main_content')
<div class="row" style="margin-top: 150px;">
  <div class="text-center">
    <svg width="121" height="120" viewBox="0 0 121 120" fill="none" xmlns="http://www.w3.org/2000/svg">
      <rect x="0.5" width="120" height="120" fill="#9F9F9F" />
      <line x1="18.8536" y1="17.6464" x2="102.854" y2="101.646" stroke="#D1D1D1" />
      <line x1="18.1464" y1="101.646" x2="102.146" y2="17.6465" stroke="#D1D1D1" />
    </svg>
  </div>
  <div class="text-center">
    <p class="underheadingF mt-4" style="color: #f84646">{{$massage}}</p>
  </div>
</div>
@endsection
