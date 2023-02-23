@extends('layouts.admin')
@section('title')
User Logs
@endsection
@section('content')



<div class="container mt-5">
    <div class="row m-0">
        <div class="col-12">
            <div class="card card-transparent" style="border-radius: 15px; box-shadow: rgb(100 100 111 / 20%) 0px 7px 29px 0px;">
                <div class="card-header py-3">
                    <h3 class="card-title text-left float-none text-uppercase" style="font-size: 1.5rem;">User Logs</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th width="7%">Id</th>
                                <th>Performed By</th>
                                <th>Action</th>
                                <th>Destination</th>
                                <th>Description</th>
                                <th>Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lastActivity as $index => $activity)
                            <tr>
                                <td width="7%">{{$index + $start}}</td>
                                <td>{{$activity->name}}</td>
                                <td>{{$activity->description}}</td>
                                <td>
                                    <?php 
                                    $subjectTypeArr = explode('\\', $activity->subject_type);
                                    echo $subjectTypeArr[count($subjectTypeArr) -1];
                                    ?>                                    
                                </td>
                                <td>description List</td>
                                <td>{{dateformat($activity->created_at)}} <br><b>{{timeformat($activity->created_at)}}</b></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {!! $lastActivity->appends(Request::all())->links() !!}
        </div>
    </div>
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