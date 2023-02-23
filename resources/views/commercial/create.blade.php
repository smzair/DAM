@extends('layouts.admin')
@section('title')
Create New Commercial
@endsection
@section('content')


<style type="text/css">
    .colp-form2:not(.outer-form) .close {
        display: none;
    }

    .custom-two-check {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    width: 100%;
    color: #fff;
    font-weight: 400;
    margin-top: 10px;
    margin-bottom: 10px;
}

.custom-two-check .custom-control.custom-checkbox {
    margin-right: 20px;
    flex: 0 0 auto;
}

.custom-two-check .custom-control.custom-checkbox:last-child {
    margin-right: 0;
}

.custom-two-check .custom-control-label {
    cursor: pointer;
}
</style>


<p class="text-center text-success">{{session()->pull('message')}}</p>
<div class="container">
    <div class="row mt-5">

    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-transparent card-info mt-3">
                <div class="card-header">
                    <h3 class="card-title">Add Commercial</h3>
                </div>
                <div class="card-body"> 
                    <form metod="POST" action="" id="comform">
                        @csrf
                          @if ($id != 0)
                                        <input type="hidden" name="id" value="{{$com->id}}">
                                        @else
                                         <input type="hidden" name="id" value="">
                            
                          
                          
                            @endif
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label required">Select Company Name</label>

                                    <select class="custom-select company form-control-border select2 " name="user_id" aria-hidden="true" style="width: 100%;">
                                        @if ($id != 0)
                                        <option value="{{$com->user_id}}" selected >{{$com->Company}}</option>
                                        @else
                                        <option selected>Select Company Name</option>
                                        @endif
                                        
                                        @foreach ($users as $user)
                                        <option  value="{{$user->id}}" data-client_id="{{$user->client_id}}">{{$user->Company}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label required">Select Brand</label>
                                    <select class="custom-select form-control-border" name="brand_id" id="brands"> 
                                       @if ($id != 0)
                                       <option value="{{$com->brand_id}}" selected >{{$com->Company}}</option>
                                       @else
                                       <option selected>Select Brands</option>
                                       @endif
                                   </select>
                               </div>
                           </div>
                           <div class="col-sm-4">
                            <div class="form-group">
                                <label>Client Id</label>
                                @if ($id != 0)
                                <input type="text" class="form-control form-control-border" id="client_id" name="client_id" placeholder="Client Id" value="{{$com->client_id}}" readonly>
                                @else
                                <input type="text" class="form-control form-control-border" id="client_id" name="client_id" placeholder="Client Id" readonly>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 colp-form" id="affrm">
                            <div class="row">
                                <div class="col-sm-12 mt-4">
                                  <h5 class="mb-5 font-weight-bold">
                                      Enter New Commercial info
                                  </h5>
                              </div>
                               <p class="text-warning" >Select any of these if included in commerical</p>
                              <div class="custom-two-check">
                        
                    <div class="custom-control  mt--5 custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="flat_shot" id="customCheckbox1" value="1">
                        <label for="customCheckbox1" class="custom-control-label">Flat Shoot</label>
                    </div>
                   <!--- <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="extra_mood_shot"  id="customCheckbox2" value="1">

                        <label for="customCheckbox2" class="custom-control-label">Extra Mood Shoot</label>
                    </div>-->
                </div>
              
                              <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label required">Product Category</label>
                                            <select class="custom-select select2 select2bs4 form-control-border reset " placeholder="Product Category" name="product_category" aria-hidden="true" style="width: 100%;">

                                                @if ($id != 0)
                                                <option value="{{$com->product_category}}" selected >{{$com->product_category}}</option>
                                                @else
                                                <option value=""selected disabled>SProduct Category</option>
                                                @endif
                                                @foreach($getProductList as $index => $getProduct)
                                                <option value="{{$index}}">{{$getProduct}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label required">Type Of Shoot</label>
                                            <select class="custom-select form-control-border reset" placeholder="Type Of Shoot" name="type_of_shoot">
                                               @if ($id != 0)
                                               <option value="{{$com->type_of_shoot}}" selected >{{$com->type_of_shoot}}</option>
                                               @else
                                               <option value=""selected disabled>Select Type Of Shoot</option>
                                               @endif

                                               @foreach($typeOfShootList as $index => $typeofShoot)
                                               <option value="{{$index}}">{{$typeofShoot}}</option>
                                               @endforeach
                                           </select>
                                       </div>
                                   </div>
                                   <div class="col-lg-3 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label required">Type Of Clothing</label>
                                        <select class="custom-select form-control-border reset" name="type_of_clothing">
                                            @if ($id != 0)
                                            <option value="{{$com->type_of_clothing}}" selected >{{$com->type_of_clothing}}</option>
                                            @else
                                            <option value="None"  selected disabled >Select Type Of Clothing</option>
                                            @endif

                                            <option value="Not Applicable">Not Applicable</option> 
                                            <option value="Bottomwear">Bottomwear</option>
                                            <option value="Topwear">Topwear</option>
                                            <option value="Mix">Mix</option>
                                            <option value="Sets">Sets</option>
                                        </select>
                                        <has-error :form="form" field="type_of_clothing"></has-error>

                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label required">Gender</label>
                                        <select class="custom-select form-control-border reset"  name="gender">
                                            @if ($id != 0)
                                            <option value="{{$com->gender}}" selected >{{$com->gender}}</option>
                                            @else
                                            <option value="Gender" selected disabled >Select Gender</option> 
                                            @endif

                                            <option value="Not Applicable">Not Applicable</option>                                                       
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Kidswear" >Kidswear</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label required">Primary Adaptation</label>
                                        <select class="custom-select  form-control-border reset" placeholder="Adaptation 1"name="adaptation_1"> 
                                            @if ($id != 0)
                                            <option value="{{$com->adaptation_1}}" selected >{{$com->adaptation_1}}</option>
                                            @else
                                            <option value="" selected >Select Primary Adaptation </option>
                                            @endif

                                            @foreach($getAdaptationsList as $index => $Adaptations)
                                            <option value="{{$index}}">{{$Adaptations}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label >Adaptation 1</label>
                                        <select class="custom-select  form-control-border reset" placeholder="Adaptation 1" name="adaptation_2">


                                            @if ($id != 0)
                                            <option value="{{$com->adaptation_2}}" selected >{{$com->adaptation_2}}</option>
                                            @else
                                            <option value="" selected >Select Adaptation 1 </option>
                                            @endif 

                                            @foreach($getAdaptationsList as $index => $getAdaptations)
                                            <option value="{{$index}}">{{$getAdaptations}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label >Adaptation 2</label>
                                        <select class="custom-select form-control-border reset" placeholder="Adaptation 2"name="adaptation_3">
                                            @if ($id != 0)
                                            <option value="{{$com->adaptation_3}}" selected >{{$com->adaptation_3}}</option>
                                            @else
                                            <option value="" selected >Select Adaptation 2 </option>
                                            @endif 
                                            @foreach($getAdaptationsList as $index => $getAdaptations)
                                            <option value="{{$index}}">{{$getAdaptations}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>Adaptation 3</label>
                                        <select class="custom-select form-control-border reset" placeholder="Adaptation 3" name="adaptation_4">
                                            @if ($id != 0)
                                            <option value="{{$com->adaptation_4}}" selected >{{$com->adaptation_4}}</option>
                                            @else
                                            <option value="" selected >Select Adaptation 3 </option>
                                            @endif
                                            @foreach($getAdaptationsList as $index => $getAdaptations)
                                            <option value="{{$index}}">{{$getAdaptations}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>Adaptation 4</label>
                                        <select class="custom-select form-control-border reset" placeholder="Adaptation 4"name="adaptation_5">
                                         @if ($id != 0)
                                         <option value="{{$com->adaptation_5}}" selected >{{$com->adaptation_5}}</option>
                                         @else
                                         <option value="" selected >Select Adaptation 4</option>
                                         @endif
                                         @foreach($getAdaptationsList as $index => $getAdaptations)
                                         <option value="{{$index}}">{{$getAdaptations}}</option>
                                         @endforeach
                                     </select>
                                 </div>
                             </div>

                            


                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label required">Commercial Value/SKU</label>
                                    @if ($id != 0)
                                    <input type="text" class="form-control form-control-border reset" id="commercialvalue" name="commercial_value_per_sku" value="{{$com->commercial_value_per_sku}}" placeholder="Commercial Value">
                                    @else
                                    <input type="text" class="form-control form-control-border reset" id="commercialvalue" name="commercial_value_per_sku" placeholder="Commercial Value">
                                    @endif
                                </div>

                            </div>

                            
                            <div class="col-lg-4 col-md-4 col-sm-6  " style="margin-top:30px">
                                

                                 @if ($id != 0)
                                    <button type="button" class="btn btn-success swalDefaultSuccess" onclick="saveEComForm(0)">Update</button>
                                
                                    @else
                                    <button type="button" class="btn btn-success swalDefaultSuccess" onclick="saveComForm(0)">Save</button>
                                <button type="button" class="btn btn-info ml-4 wrc-btn" onclick="saveComForm(1)">Save & Add Another </button>
                                    @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
</div>
</div>
</div></div>

<div class="fix-infor-wrapper">
    <a href="javascript:;" class="information-pp-btn" id="info-popbtn">
      <i class="fas fa-info ic-infor"></i>
      <i class="fas fa-times cl-infor"></i>
  </a>
  <div class="infor-content">
    <ul class="info-ll-list">
        <li><b>In order to make a new commercial, please select the company name and the brand name.</b></li>
        <li><b>In order to make more than one commercial, please click on the ‘save and add another’ button.</b></li>
    </ul>
</div>
</div>

@endsection 