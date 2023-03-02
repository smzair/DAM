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
                      </div>
                    <h6 class="card-title"></h6>
                </div>
                <div class="card-body " >
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
                              {{-- <th>Action </th> --}}
                              <th>Onboard Date </th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($users as $index => $user)
                            <tr>
                                <td width="5%" class="pl-3">{{$index+1}} </td>
                                <td>{{$user->name }} </td>
                                <td> @foreach ($user->roles as $role) {{ $role->name  }} @endforeach</td>
                                
                                <td>{{$user->client_id}} </td>
                                <td>{{$user->email}} </td>
                                <td>{{$user->Address}} </td>
                                <td>{{$user->phone}} </td>
                                {{-- <td>
                                <a class="btn btn-warning px-1 py-1 btn-xs mt-1" href="{{ route('editClientUser', ['id'=>$user->id]) }}"  data-id="{{$user->id}}">Edit</a>
                                </td> --}}
                                <td> {{$user->created_at}} </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
		</div><!-- /.container-fluid -->
	</div>

    <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createUserModalLabel">Create User
                </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;
                  </span> </button>
            </div>
          </div>
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
		function semple(){
			console.log('first')
		}
	</script>

    
<script>
    function navigateToLink(link) {
      window.open(link, '_blank');
    }
</script>
@endsection