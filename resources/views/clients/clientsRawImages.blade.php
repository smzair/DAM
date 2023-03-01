@extends('layouts.admin')
@section('title')
Raw Images
@endsection

@section('content')
<div class="container">
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
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-transparent card-info mt-3">
                <div class="card-header">
                    <h3 class="card-title">Raw Images</h3>
                </div>
                <div class="row">
                    @foreach($lotData as $object)
                        <div class="col-md-2">
                            <div class=" justify-content-between align-content-center">
                                <div class="text-center">
                                    <a ondblclick="navigateToLink('client-raw-images-mgmt/{{$object->id}}')"><img style="cursor: pointer" class=" justify-content-between align-content-center" src="https://img.icons8.com/color/100/000000/folder-invoices.png" width="50" /></a>
                                    <div class="ml-2">
                                        <span class="mb-1 font-weight-bold" style="font-size
                                        : 12px ; color:white">{{ $object->lot_id }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function navigateToLink(link) {
      window.open(link, '_blank');
    }
    </script>
    
    
@endsection