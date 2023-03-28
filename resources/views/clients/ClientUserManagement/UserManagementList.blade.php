@extends('layouts.ClientMain')
@section('title')
  User Mangement
@endsection
@section('css_links')
	<link rel="stylesheet" href="">	
  <style>
    .form-group .input_err{
        margin: 0.1em 0;
        color: red;
        background: #999;
        display: block;
        padding: 0.3em;
    }

    .list-group{
        width: 400px !important;

    }

    .list-group-item{
        margin-top:10px;
        margin-bottom:10px;
        border-radius: none; 
        background: #20b9932e;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }


    .list-group-item:hover{
        /* transform: scaleX(1.1); */
    }
    .list-group-item:hover .check {
        opacity: 1;

    }
    .about span{
        font-size: 12px;
        margin-right: 10px;

    }
  </style>

  <style>
    .modal-body label{
      padding: 0 8px;
    }

    .permition_section{
      padding: 5px 15px;
      border: 1px solid #333;
      box-shadow: 3px 4px 5px 2px #545473cc; 
    }
  </style>
@endsection

@section('main_content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper dashboard-content-wrapper">

	<!-- Navbar -->
    @include('clients.top_bar.top-head')
    <!-- /.navbar -->

	<!-- Main content -->


    <div class="content custom-dashboard-content">
		<div class="container-fluid">
      <div class="card card card-transparent card-info mt-3"  style="max-height: 700px; height: 100%;">
          <div class="card-header">
              <div class="row">
                  <div class="col-lg-10 col-10">
                    <h6 class="card-title text-bold"><i class="fas fa-users mr-1"></i> User Mangement</h6>
                  </div>
                  <div class="col-lg-2 col-2">
                    <div class="card-tools float-right" style="float: right;">
                      @if ($dam_enable == 1)
                        <a class="btn btn-xs btn-warning align-middle mt-0 mr-2 p-1 mb-1 mb-1" href="{{ route('addClientUser')}}">Add New</a>
                      @endif
                    </div>
                  </div>
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
                </div>
              <h6 class="card-title"></h6>
          </div>
          <div class="card-body" style="position: relative; overflow-y: scroll" >
              <table class="table table-responsive p-0">
                  <thead>
                      <tr style="font-size: 14px;">
                        <th width="5%" class="pl-3"># </th>
                        <th>Name </th>
                        <th>Role </th>
                        <th>Employee id </th>
                        <th>Email </th>
                        <th>Address </th>
                        <th>Phone No </th>
                        <th>Onboard Date </th>
                        <th>Action </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($users as $key => $user)
                      <tr>
                          <td width="5%" class="pl-3">{{$key+1}} </td>
                          <td>{{$user->name }} </td>
                          <td> 
                            @foreach ($user->roles as $role) {{ $role->name  }} @endforeach
                          </td>
                          <td>{{$user->client_id}} </td>
                          <td>{{$user->email}} </td>
                          <td>{{$user->Address}} </td>
                          <td>{{$user->phone}} </td>
                          <td> {{$user->created_at}} </td>
                          <td>
                            <p class="d-none"  id="your_assets_permissions{{$user->id}}" >{{$user->your_assets_permissions}} </p>
                            <p class="d-none"  id="file_manager_permissions{{$user->id}}" >{{$user->file_manager_permissions}} </p>
                            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" onclick="set_data_into_model({{$user->id}})" data-bs-target="#exampleModal">
                              Give Permission
                            </button>
                          </td>
                      </tr>
                      @endforeach
                  </tbody>

              </table>
          </div>
      </div>
		</div><!-- /.container-fluid -->
	</div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form action="{{route('sub_users_access_permission')}}" method="post">
          @csrf;
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel" style="margin-bottom: 5px">Give Permission</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- modal-body --}}
            <div class="modal-body" style="padding:10px 30px">
              <div class="row">
                <h5>Section</h5>
                <div class="col-sm-12 mb-3 permition_section" id="your_assets_row" >
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

                <div class="col-sm-12 mb-3 permition_section" id="file_manager_row">
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
            {{-- modal-footer --}}
            <div class="modal-footer">
              <input type="hidden" name="user_id" id="user_id" value="">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
	<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
@endsection

{{-- Other Js pluging   --}}
@section('js_links')
  <script type="text/javascript" src=""></script>
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