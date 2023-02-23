@extends('layouts.admin')

@section('title')
User-Management / Permissions
@endsection

@section('content')
<div class="col-12">
            <div class="card card-transparent">
              <div class="card-header">
                <h3 class="card-title">Permissions</h3>
               
                


                <div class="card-tools">
             

                <a href="{{route('permission.create')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Create New Permission </a>
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body align-center table-responsive pr-3 pl-3">
                <table class="table  table-hover text-nowrap">
                  <thead>
                    <tr >
                      <th>ID</th>
                      <th>Name</th>
                      <th>Date Posted</th>
                      <th>Action</th>
                  
                    </tr>
                  </thead>
                  <tbody>
                      @forelse ($permission as $item)
                    <tr>
                      <td>{{$item->id}}</td>
                      <td>{{$item->name}}</td>
                      <td>{{$item->created_at}}</td>
                      <td>
                        
                         <a href="{{('delete/permissions/'.$item->id) }}" class="btn btn-sm btn-info bg-danger">Delete Permission</a>
                         <a href="{{ route('permission.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit Permission</a>


                      </td>
                     </tr>
                     @empty
                     <tr>No Result Found</tr>
                     @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
