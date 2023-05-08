@extends('layouts.DamNewMain')
@section('title')
Clients - User list
@endsection

@section('main_content')

@php
  // dd($users);

@endphp
  <div class="row" style="margin-top:24px ;">
    <div class="col-12 d-flex justify-content-between">
      <h4 class="headingF">
        Manage user
      </h4>
      <a href="{{route('add_Client_User_New')}}" type="button" class="btn border user-btn" style="height: auto;">+ Add new user</a>
    </div>
    <div class="col-12">
      <p class="underheadingF">
        You can edit the user rights & add a new user here
      </p>
    </div>
  </div>

  @if (count($users) > 0)
    <div class="row">
      <div class="col-12">
        <div class="table-responsive ">
          <table class="table table-borderless mt-4">
            <thead style="background: #EBEBEB;">
              <tr class="rounded-3">
                <th scope="col" class="table-head">SN.</th>
                <th scope="col" class="table-head">Name</th>
                <th scope="col" class="table-head">Email</th>
                <th scope="col" class="table-head">Phone no.</th>
                <th scope="col" class="table-head">Address</th>
                <th scope="col" class="table-head">Action</th>
                <th scope="col" class="table-head"></th>
              </tr>
            </thead>

            <tbody>
              @foreach ($users as $key => $row)
              @php
                  // dd($row);
              @endphp
                <tr class=" ">
                  <th scope="row" class="table-col">{{$key+1}}</th>
                  <td class=" table-col">{{$row['name']}}</td>
                  <td class=" table-col">{{$row['email']}}</td>
                  <td class=" table-col">{{$row['phone']}}</td>
                  <td class=" table-col">{{$row['Address']}}</td>
                  <td class="table-col "><button class="table-col border ">Give permission</button></td>
                  <td class=" table-col"><svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M14 5.5C14 4.4 13.1 3.5 12 3.5C10.9 3.5 10 4.4 10 5.5C10 6.6 10.9 7.5 12 7.5C13.1 7.5 14 6.6 14 5.5ZM14 19.5C14 18.4 13.1 17.5 12 17.5C10.9 17.5 10 18.4 10 19.5C10 20.6 10.9 21.5 12 21.5C13.1 21.5 14 20.6 14 19.5ZM14 12.5C14 11.4 13.1 10.5 12 10.5C10.9 10.5 10 11.4 10 12.5C10 13.6 10.9 14.5 12 14.5C13.1 14.5 14 13.6 14 12.5Z"
                        fill="#9F9F9F" />
                    </svg>
                  </td>
                  <tr>
                    <td colspan="3" class=" gap-2">
                      {{-- <p class="table-desc"> Onboard date: 27-04-2023  | Permissions: Shoot&nbsp;&nbsp; | Password: Dam@odn2023</p> --}}
                      <p class="table-desc">Onboard date: {{dateFormet_dmy($row['created_at'])}} | Permissions : nbsp;&nbsp; | Password : nbsp;&nbsp; </p>
                    </td>
                  </tr>
                </tr>
              @endforeach              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @else
    <div class="row" style="margin-top: 122px;">
      <div class="text-center">
        <svg width="121" height="120" viewBox="0 0 121 120" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect x="0.5" width="120" height="120" fill="#9F9F9F" />
          <line x1="18.8536" y1="17.6464" x2="102.854" y2="101.646" stroke="#D1D1D1" />
          <line x1="18.1464" y1="101.646" x2="102.146" y2="17.6465" stroke="#D1D1D1" />
        </svg>
      </div>
      <div class="text-center">
        <p class="underheadingF mt-4">
          It's looks like you didn't created any user yet.
        </p>
      </div>
      <div class="text-center">
        <a href="{{route('add_Client_User_New')}}" type="button" class="btn border btn-lg create-user-btn">+ Create user</a>
      </div>
    </div>
  @endif
@endsection
