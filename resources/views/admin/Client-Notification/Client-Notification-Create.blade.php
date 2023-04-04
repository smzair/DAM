@extends('layouts.admin')

@section('title')
Client Notification Create
@endsection
@section('content')
<link rel="stylesheet" href="{{asset('plugins/datepicker-in-bootstrap-modal/css/datepicker.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<!-- New WRC Creation (For Catalogue) -->
<div class="container">
    <style>
        @media (min-width: 992px){
            .modal-lg, .modal-xl{
                max-width: 900px;
            }
        }
         .msg_box{
            margin: 0.1em 0;
            background: #928c8cfc;
            padding: 0.3em;
        }
    </style>

    {{-- form row  --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-transparent card-info mt-3">
                <div class="card-header bg-warning">
                    <div class="row">
                        <div class="col-lg-10 col-md-9 col-sm-12">
                            <h3 class="card-title">Clients Notification</h3>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-12">
                            <div class="card-tools float-md-right float-sm-none ml-md-0 mr-0 ml-sm-0 mt-sm-1 float-none ml-xs-0 mt-2">
                              <a href="{{ route('ClientNotificationList') }}" class="btn btn-xs float-left align-middle mt-0 mr-2 py-1 px-2 mb-2 mb-sm-1" style="position: relative; top: 2px;">Notifications List</a>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="card-body"> 
                    {{-- @if (Session::has('success'))
                        <div class="alert alert-success" id="msg_div" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if (Session::has('false') || Session::has('error') )
                        <div class="alert alert-false" role="alert">
                            {{ Session::get('false') }}
                        </div>
                    @endif --}}

                    @php
                        $formRoute = 'SaveClientNotification';
                        $btn_Name = 'Create Notification';
                        if($data->id > 0){
                            $btn_Name = 'Update Notification';
                            $formRoute = 'UpdateClientNotification';
                        }

                        $UserCompanyData = getUserCompanyData();
                    @endphp

                    <form method="POST" onsubmit="return validateForm(event)" action="{{route($formRoute)}}"  id = "ClientNotificationForm">
                        @csrf
                        <div class="row">
                             <!-- Company Name -->
                             <div class="col-sm-4 col-12">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="{{$data->id}}"> 

                                    <label class="control-label required">Company</label>
                                    <select class="custom-select select2 form-control-border" id="user_id" name="user_id"  aria-hidden="true" style="width: 100%;">
                                        <option value="0" selected>Select Company</option>
                                        @foreach ($UserCompanyData as $user)
                                                <option value="{{ $user->id }}" data-c_short="{{ $user->c_short }}">
                                                    {{ $user->Company ." (" . $user->name.")" }}
                                                </option>
                                        @endforeach
                                    </select>
                                    <script>
                                        document.querySelector("#user_id").value = "{{$data->user_id }}"
                                    </script>
                                    <p class="input_err" style="color: red; display: none;" id="service_err"></p>
                                </div>
                            </div>
                            
                            <!-- Brand List -->
                            <div class="col-sm-4 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Brand</label>
                                    <select class="custom-select select2 form-control-border " name="brand_id" id="brand_id" >
                                        <option value = "0"> -- Select Brand Name -- </option>
                                    </select>
                                    <p class="input_err" style="color: red; display: none;" id="lot_id_err"></p>
                                </div>
                            </div>

                            <div class="col-sm-4 col-12">
                                <div class="form-group">
                                    <label class="control-label required">Subject</label>
                                    <input class="custom-input form-control" type="text" name="subject" id="subject" placeholder="Notification Subject" value="{{$data->subject}}" >
                                    <p class="input_err" style="color: red; display: none;" id="lot_id_err"></p>
                                </div>
                            </div>
                        </div>

                        <div class="row" >
                            <div class="col-sm-12">
                                <label class="control-label required">Discription</label>
                                <textarea name="discription" id="discription" style="width: 100%" rows="5">{{$data->discription}}</textarea>
                            </div>
                            <div class="col-sm-12 float-right mt-3">
                                <div class="d-none" id="btn_row">
                                    <button type="submit" class="btn btn-success btn-xl btn-warning mb-2" >{{$btn_Name}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>


<script>
    const user_id_val_is = "{{ $data->user_id }}";
    const saved_brand_id_is = brand_id_val = "<?= $data->brand_id ?>";
</script>



<!-- Get Brand List -->
<script>
    $(document).ready(function() {
        $("#user_id").change(async function() {
            const user_id_is = $("#user_id").val();
            let options = `<option value="0" > -- Select Brand Name -- </option>`;
            await $.ajax({
                url: "{{ url('get-brand') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    user_id: user_id_is,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    res.map(brands => {
                        options +=
                            ` <option value="${brands.brand_id}"> ${brands.name}</option>`;
                    })
                }
            });
            document.getElementById("brand_id").innerHTML = options;
            select2();
            if(saved_brand_id_is > 0 && user_id_val_is === user_id_is){
                document.getElementById("brand_id").value = saved_brand_id_is;
            }
            $("#brand_id").trigger("change");
        });
    })
</script>

<script>
    $(document).ready(function() {
        $("#brand_id, #subject, #discription").change(async function() {
            set_btn_action();
        });
    })
</script>

<script>
    function set_btn_action(){
        const user_id = +$("#user_id").val();
        const brand_id = +$("#brand_id").val();
        const subject = $("#subject").val();
        const discription = $("#discription").val();
        console.log({user_id, brand_id ,subject, discription})
        if(user_id == 0 || brand_id == 0 || subject.trim() == ''|| discription.trim() == ''){
           $('#btn_row').addClass('d-none')
        }else{
            $('#btn_row').removeClass('d-none')
        }
    }
</script>

{{-- setting data into form --}}
<script>
    $(document).ready(function() {
        if (user_id_val_is > 0) {
            // $("#user_id").val(user_id_val_is);
            setTimeout(() => {
                $("#user_id").trigger("change");
                console.log('user_id_val_is', user_id_val_is)
            }, 500);
        }
    });
</script>

@endsection
