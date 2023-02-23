@extends('layouts.admin')
@section('title')
View All
@endsection
@section('content')

<div class="lot-table mt-5">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-transparent">
          <div class="card-header">
            <div class="row">
              <div class="col-lg-7 col-md-6 col-sm-12">
                <h3 class="card-title text-black text-bold">
                  <span class="d-inline-block align-middle">
                    View All
                  </span>
                  <span class="mr-2 ml-1 d-inline-block" style="position: relative; top: 1px;">|</span>
                </h3>
                <div class="card-tools float-left">
                  <ul class="list-unstyled m-0 mt-lg-0 mt-md-1 lot-list">
                    <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Inworded">
                      <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #FFFF00;"></span>
                    </li>
                    <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Inwording Completed">
                      <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #FF8000;"></span>
                    </li>
                    <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Ready For Shoot">
                      <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #606060;"></span>
                    </li>
                    <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Shoot Done">
                      <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #4C0099;"></span>
                    </li>
                    <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Ready For QC">
                      <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #000000;"></span>
                    </li>
                    <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Ready For Submission">
                      <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #0066CC;"></span>
                    </li>
                    <li class="list-inline-item mr-lg-3 mr-md-1" data-toggle="tooltip" data-placement="top" title="Approved">
                      <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #00CC00;"></span>
                    </li>
                    <li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="Rejected">
                      <span class="badge d-inline-block rounded-circle p-lg-1 p-md-1 p-sm-1 p-1" style="background: #FF0000;"></span>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-5 col-md-6 col-sm-12">
                <div class="card-tools float-md-right float-sm-none ml-md-0 mr-0 ml-sm-0 mt-sm-1 float-none ml-xs-0 mt-1">
                  <a href="{{route ('Lots.create')}}" class="btn btn-xs float-left align-middle mt-0 mr-2 p-1 mb-2 mb-sm-1" style="position: relative; top: 2px;">Create A New LOT</a>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap text-center">
              <thead>
                <tr>
                  <th>Id</th>
                  <!-- <th>Status</th> -->
                  <th>LOT Numbers</th>
                  <th>Am Email</th>
                  <th>Brand</th>
                  <th>Company Name</th>
                  <th>Client Id</th>
                  <th>Date Posted</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody> 
                @foreach($lots as $index => $lot)
                <tr id="lot_row_{{$lot->id}}">
                  <td>{{$index+1}}</td>
                 <!--  <td>
                    <div class="bg-color mb-1 Inworded d-none" style="width: 100%; height: 10px"></div>
                    <form method="post" name="selectform" action="myform" id="formcollapse" class="colform d-none">
                      <select id="mySelect" class="custom-select yellowText" onSelect="do()" style="width: 100%;">
                        <option class="white" value="" disabled>Status</option>
                        <option class="yellow" value="inworded" selected>Inworded</option>
                        <option class="orange" value="inwording_completed">Inwording Completed</option>
                        <option class="gray" value="ready_for_shoot">Ready For Shoot</option>
                        <option class="voilet" value="shoot_done">Shoot Done</option>
                        <option class="black" value="ready_for_qc">Ready For QC</option>
                        <option class="blue" value="ready_for_submission">Ready For Submission</option>
                        <option class="green" value="approved">Approved</option>
                        <option class="red" value="rejected">Rejected</option>
                      </select>
                      <div class="sel-btn d-none mt-2">
                        <button type="button" class="btn btn-xs btn-success st-btn">Submit</button>
                      </div>
                    </form>
                    <span class="badge d-inline-block rounded-1 p-lg-2 p-md-2 p-sm-2 p-2 px-lg-5 px-md-4 align-middle" style="background: #FFFF00; position: relative; top: -1; cursor: default;" data-toggle="tooltip" data-placement="top" title="Inwarding">Inwarding</span>
                  </td> -->
                  <td>{{$lot->lot_id}}</td>
                  <td>{{$lot->am_email}}</td>
                  <td>{{$lot->name}}</td>
                  <td>{{$lot->Company}}</td>
                  <td>{{$lot->client_id}}</td>
                  <td>{{dateFormat($lot->created_at)}}<br><b>{{timeFormat($lot->created_at)}}</b></td>
                  <td>
                    <a href="javascript:void(0)" data-id = "{{$lot->id}}" onclick="allwrc(this)" class="btn btn-warning border-0 ">View All WRC</a>
                  </td>
                </tr> 
                @endforeach


              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>


</div>
<!-- /.card-body -->
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
        <li><b>This nested table contains all the details regarding the LOT number and SKU associated with each WRC.</b></li>
      </ul>
    </div>
  </div>

@endsection