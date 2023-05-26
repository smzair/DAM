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
      <h4 class="headingF ps-2">
        Manage user
      </h4>
      <div class="text-center mt-4">
        <a href="{{route('add_Client_User_New')}}" type="button" class="btn rounded-0 border btn-lg create-user-btn">+ Add user</a>
      </div>
    </div>
    <div class="col-12">
      <p class="underheadingF ps-2 mt-3">
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
      <!--<div class="text-center">-->
        
      <!--</div>-->
      <div class="text-center">
           <svg width="94" height="104" viewBox="0 0 94 104" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <rect width="94" height="104" fill="url(#pattern0)"/>
            <rect x="61" y="21" width="4" height="5" fill="url(#pattern1)"/>
            <rect x="76" y="21" width="4" height="5" fill="url(#pattern2)"/>
            <defs>
            <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
            <use xlink:href="#image0_2_6" transform="matrix(0.0111111 0 0 0.0100427 0 -0.00213675)"/>
            </pattern>
            <pattern id="pattern1" patternContentUnits="objectBoundingBox" width="1" height="1">
            <use xlink:href="#image1_2_6" transform="scale(0.25 0.2)"/>
            </pattern>
            <pattern id="pattern2" patternContentUnits="objectBoundingBox" width="1" height="1">
            <use xlink:href="#image2_2_6" transform="scale(0.25 0.2)"/>
            </pattern>
            <image id="image0_2_6" width="90" height="100" xlink:href="data:image/png;base64,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"/>
            <image id="image1_2_6" width="4" height="5" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAFCAYAAABirU3bAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAABESURBVHgBVYixDcAgDATtJH1WgE08EhvYG8BIXoWOEjbgkSjgpJfujwmoamLmAC2fmQkk0+ahm3+FfoTxunsTkYhTMZvKMwxW2nFe6wAAAABJRU5ErkJggg=="/>
            <image id="image2_2_6" width="4" height="5" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAFCAYAAABirU3bAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAABDSURBVHgBVYtBDQAhDAS35AScBByCg9YCjpAACsBJ2b4Im+xjMhkxswygishS1fYF8MXdQTkT4cddTni3I7Ew/GDSDwMnD/uPBjZDAAAAAElFTkSuQmCC"/>
            </defs>
            </svg>
          <p class="no-hooman-text mt-4">
             No Hooman detected
        </p>
        <p class="underheadingF">
          It's looks like you didn't created any user yet.
        </p>
      </div>
      <div class="text-center mt-4">
        {{-- <a href="{{route('add_Client_User_New')}}" type="button" class="btn rounded-0 border btn-lg create-user-btn">+ Add user</a> --}}
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
