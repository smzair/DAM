@extends('layouts.admin')

@section('title')
Add Brand
@endsection

@section('content')



    <title>Add New Brand</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	


<!--     <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css"> -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!--     <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> -->

   


    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- <div class="info-p"> <p style="font-size:12px;"><i class="fas fa-info-circle mr-1"></i>Please Note: Brand Short Name can contain maximum 4 characters </p></div> -->
                <div class="card card-transparent card-warning mt-5">
					

                    <div class="card-header">
                        <h3 class="card-title">Add a New Brand</h3>
                        <a href="{{('/getAllbrands') }}" class="btn btn-sm  bg-warning float-right">Click Here to View All Brands</a>
                    </div>
                    <div class="card-body"> 
                        <form method="POST" action="{{route('brands.add')}}">
							@csrf
                            <div class="row">
                                
                                <div class="col-lg-9 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label required">Brand</label>
                                        <input type="text" class="form-control" id="name" name="name" required placeholder="Brand">
                                    </div>
                                </div>
                         
                     
							<div class="col-lg-3 col-sm-6">
								<div class="form-group">
									<label class="control-label required">Brand Short Name</label>
									<input type="text" class="form-control" name="short_name" required placeholder="Brand Short Name">
								</div>
							</div>
						
				           </div>
                            <div class="row">
                         
                            <div>
                                    <button type="submit" class="btn btn-warning ">Add Brand</button>
                                </div>
								
							</div>
                            
                        </form>
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
            <li><b>Brand short name can contain maximum 4 characters</b></li>
        </ul>
    </div>
  </div>


   
@endsection
