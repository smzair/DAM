@extends('layouts.DamNewMain')
@section('title')
Clients - User list
@endsection

@section('main_content')
  <style>
    input[type="checkbox"] {
      padding-right: 10px;
    }
  </style>

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
      <div id="msg_div">
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
              {{ Session::get('success') }}
            </div>
        @endif

        @if (Session::has('warning'))
            <div class="alert alert-warning" role="alert">
                {{ Session::get('warning') }}
            </div>
        @endif

        @if (Session::has('false'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('false') }}
            </div>
        @endif
      </div>
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
                <tr class=" ">
                  <th scope="row" class="table-col">{{$key+1}}</th>
                  <td class=" table-col">{{$row['name']}}</td>
                  <td class=" table-col">{{$row['email']}}</td>
                  <td class=" table-col">{{$row['phone']}}</td>
                  <td class=" table-col">{{$row['Address']}}</td>
                  <td class="table-col ">
                    <p class="d-none"  id="your_assets_permissions{{$row['id']}}" >{{$row['your_assets_permissions']}} </p>
                    <p class="d-none"  id="file_manager_permissions{{$row['id']}}" >{{$row['file_manager_permissions']}} </p>
                            
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="set_data_into_model({{$row['id']}})" >
                      Give permission
                     </button>
                  </td>
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
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{route('sub_users_access_permission_new')}}" method="post">
        @csrf

        <div class="modal-content">
          <div class="modal-header d-flex justify-content-center">
            <h5 class="modal-title" id="exampleModalLabel">Give Permissions</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <h5>Section</h5>
              <div class="col-sm-12 mb-3 permition_section mt-4" id="your_assets_row" >
                <div  id="your_assets_section">
                  {{-- <input type="checkbox" name="your_assets" id="your_assets" checked> --}}
                  <label for="your_assets">Your Assets</label>  
                </div>
                <div class="" id="your_assets_services">
                  <input type="checkbox" name="ya_shoot" id="ya_shoot"><label for="ya_shoot">Shoot</label>
                  <input type="checkbox" name="ya_Creative" id="ya_Creative"><label for="ya_Creative">Creative</label>
                  <input type="checkbox" name="ya_Cataloging" id="ya_Cataloging"><label for="ya_Cataloging">Cataloging</label>
                  <input type="checkbox" name="ya_Editing" id="ya_Editing"><label for="ya_Editing">Editing</label>
                </div>
              </div>

              <div class="col-sm-12 mb-3 permition_section mt-4" id="file_manager_row">
                <div  id="file_manager_section">
                  {{-- <input type="checkbox" name="file_manager" id="file_manager" checked> --}}
                  <label for="file_manager">File Manager</label>  
                </div>
                <div class="" id="file_manager_services">
                  <input type="checkbox" name="fm_shoot" id="fm_shoot"><label for="fm_shoot">Shoot</label>
                  <input type="checkbox" name="fm_Creative" id="fm_Creative"><label for="fm_Creative">Creative</label>
                  <input type="checkbox" name="fm_Cataloging" id="fm_Cataloging"><label for="fm_Cataloging">Cataloging</label>
                  <input type="checkbox" name="fm_Editing" id="fm_Editing"><label for="fm_Editing">Editing</label>
                </div>
              </div>
            </div>
              
          </div>
          <div class="modal-footer">
            <input type="hidden" name="user_id" id="user_id" value="">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('js_scripts')
	<script>
		async function set_data_into_model(user_id){
      console.log('user_id', user_id)
      let your_assets_permissions = $("#your_assets_permissions"+user_id).text()
      let file_manager_permissions = $("#file_manager_permissions"+user_id).text()

      your_assets_permissions = JSON.parse(your_assets_permissions);
      file_manager_permissions = JSON.parse(file_manager_permissions);
      
      $("#user_id").val(user_id)

      for(let service in your_assets_permissions){
        console.log('service', service, your_assets_permissions[service])
        if(your_assets_permissions[service] == true){
          $('#ya_'+service).prop('checked', true);
        }else{
          $('#ya_'+service).prop('checked', false);
        }
      }

      for(let service in file_manager_permissions){
        console.log('service', service, file_manager_permissions[service])
        if(file_manager_permissions[service] == true){
          $('#fm_'+service).prop('checked', true);
        }else{
          $('#fm_'+service).prop('checked', false);
        }
      }
		}
	</script>

  <script>
    $(document).ready(function() {
        setTimeout(() => {
            $('#msg_div').attr("style", "display:none")
        }, 3500);
    });
  </script> 
<script>
    function navigateToLink(link) {
      window.open(link, '_blank');
    }
</script>
@endsection
