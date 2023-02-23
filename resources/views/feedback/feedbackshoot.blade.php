@extends('layouts.admin')
@section('title')
Inwarding Approval
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card card-transparent">
                    <div class="card-header">
                        <h3 class="card-title">Customer Feedback</h3>
                    </div>
                    <div class="card-body">
                        <div class="custom-feedback-panel">
                            <form action="" method="post" class="feedback-panel-form" id="Create_feed">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-4 col-12">
                                        <div class="form-group">
                                            <label class="control-label required">Company Name</label>
                                            <select class="company custom-select form-control-border select2" id="companyselect" name="user_id"  aria-hidden="true" style="width: 100%;">
                                                @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->Company}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-12">
                                        <div class="form-group">
                                            <label class="control-label required">Brand Name</label>
                                            <select class="custom-select form-control-border select2" id="brands" name="brand_id"  aria-hidden="true" style="width: 100%;">
                                               
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-12">
                                        <div class="form-group">
                                            <label class="control-label required">Type Of Services</label>
                                            <select class="custom-select form-control-border" id="servicesSelect" name="type_of_service"  aria-hidden="true">
                                                <option value="None" selected>Select Type Of Services</option>
                                                <option value="Shoot">Shoot</option>
                                                <option value="Creative-Graphics" disabled>Creative Graphics</option>
                                                <option value="Catalogue" disabled>Catalogue</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label required">Name</label>
                                            <input type="text" class="form-control" name="name" id="FName" placeholder="Type Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label required">Email Address</label>
                                            <input type="email" class="form-control" name="email" id="emailAddress" placeholder="Type Email Address">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-12">
                                        <div class="custom-fedpanel-btn">
                                            <a href="javascript:;" onclick="saveFeed()" class="btn btn-warning" id="feeddbackPanelBTN">
                                                Request Feedback
                                            </a>
                                        </div>
                                    </div>  
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="application/javascript"  src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script type="application/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<script type="text/javascript">
    

 function saveFeed(){
    $.ajax({
      url: "/save-feed",
      method: 'POST',  
      dataType: "json",
      data:  $('#Create_feed').serialize(),
      success: function(data) {

      }

  });
}
</script>
    @endsection