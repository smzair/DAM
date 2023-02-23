@extends('layouts.admin')

@section('title')
Create Wrc

<!--- if condition to be applied for update details of the page-->
@endsection
@section('content')
<!-- New WRC Creation (For Catalogue) -->
<div class="container">
    <div class="row mt-5">
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-transparent card-info mt-3">
                <div class="card-header bg-warning">
                    <h3 class="card-title">Create New WRC</h3>
                    <a href="javascript:;" class="btn btn-warning upld-action-btn float-right d-none" id="uploadActionBTN" data-toggle="modal" data-target="#skuUploaderModal">
                        Click to open
                    </a>
                </div>
                <div class="card-body"> 
                    <form method="POST" action=""  id="wrcform" >
                        @csrf
                        <div class="row">
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                  

                                    <label class="control-label required">Company Name</label>
                                    <select class="custom-select form-control-border select2 com " id="wrc_com" name="user_id"  aria-hidden="true" style="width: 100%;">
                                        <option value="None" selected>Select Company Name</option>
                                        @foreach ($users as $userc)
                                        <option value="{{$userc->id}}">{{$userc->Company}}</option>

                                        
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Brand Name</label>
                                    <select class="custom-select form-control-border brand " name="brand_id"  id="wrc_brands">
                                        <option selected>Select Brand</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label required">LOT Number</label>
                                    <select class="custom-select form-control-border " name="lot_id" id="wrc_lots">
                                        <option selected>Select LOT Number</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Work Bucket</label>
                                    <select class="custom-select form-control-border " name="commercial_id" id="product_category">
                                        <option value="null" selected disabled>Select WorkBucket</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Image Receive Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="imgReceviedDate" id="imgReceviedDate" placeholder="Select Date As Per Guidelines" data-toggle="datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Missing Info Notify Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="mInfoNotifyDate" id="mInfoNotifyDate" placeholder="Select Missing Info Notify Date" data-toggle="datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Missing Info Received Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="mInfoRecivedDate" id="mInfoRecivedDate" placeholder="Select Missing Info Received Date" data-toggle="datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Details Confirmation Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="confirmationDate" id="confirmationDate" placeholder="Enter Details Confirmation from Team" data-toggle="datepicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-12">
                                <div class="cc-title">
                                    <h5>Guidelines</h5>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="required">Work Brief</label>
                                    <input type="text" class="form-control" name="workBrief" id="workBrief" placeholder="Add Link">
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="required">Guidelines</label>
                                    <input type="text" class="form-control" name="guidelines" id="guidelines" placeholder="Add Link">
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="required">Add Document</label>
                                    <input type="text" class="form-control" name="document1" id="document1" placeholder="Add Link">
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <div class="form-group">
                                    <label class="required">Add Document</label>
                                    <input type="text" class="form-control" name="document2" id="document2" placeholder="Add Link">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-success btn-xl btn-warning mb-2" onclick="saveWrcForm(0)">Create New WRC</button>
                               <p class="text-success" id="msg" style="display: none">
                               WRC Submitted Succesfully</p>  
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of New WRC Creation (For Catalogue) -->
@endsection
