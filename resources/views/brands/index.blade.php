@extends('layouts.admin')

@section('title')
All Brands
@endsection

@section('content')



    <title>All Brands</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	


<!--     <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css"> -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!--     <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> -->

   


    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-transparent card-warning mt-5">
          
                    <div class="card-header">
                        <h3 class="card-title">All Brands</h3>
                        <a href="{{('/savebrands') }}" class="btn btn-sm  bg-warning align-right float-right">Click Here to Add a New Brand</a>
                    </div>
                  
                  <div class="card-body align-center table-responsive pr-3 pl-3">

                    

                <table class="table  table-hover text-nowrap">
                  <thead>
                    <tr >
                      <th>#</th>
                      <th>Name</th>
                       <th>Date Posted</th>
                     
                      <th>Action</th>
                  
                    </tr>
                  </thead>
                  <tbody>
                      @forelse ($brands as $item)
                    <tr>
                      <td>{{$item->id}}</td>
                      <td>{{$item->name}}</td>
                      <td>{{$item->created_at}}</td>
                      <td>
                         <a   href="{{('/delete/brand/'.$item->id) }}" class="btn btn-sm  bg-danger">Delete This Brand</a>

                      </td>
                     </tr>
                     @empty
                     <tr>No Result Found</tr>
                     @endforelse
                  </tbody>
                </table>
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
      <ul class="info-ll-list">
        <li><b>Only those brands can be deleted which do not have any link with the client.</b></li>
      </ul>
    </div>
  </div>

   
@endsection
