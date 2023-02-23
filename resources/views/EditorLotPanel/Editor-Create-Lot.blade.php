@extends('layouts.admin')
@section('title')
    Editing Create
@endsection
@section('content')
    <div class="container-fluid">
        <!-- New Create Lot (For Editing) -->

        <div class="container-lg container-fluid my-5 lot-create-updateversion">
            @if (Session::has('success'))
                <div class="alert alert-success" id="msg_div" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            <div class="row lotNoShowHide" style="padding-bottom: 2rem">
                <div class="col-12">
                    <div class="card card-transparent m-0" style="flex-direction:row;">
                        <h5 style="float: left;padding:2%">Editing Lot Number :- </h5>
                        <h5 class="lotNo" style="float: right;padding-top:2%">{{ $EditorLots->lot_number }}</h5>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-12">

                    <div class="card card-transparent m-0">
                        <div class="card-header bg-warning">
                            <h4 class="card-title">Create New Lot</h4>
                            <div
                                class="card-tools float-md-right float-sm-none ml-md-0 mr-0 ml-sm-0 mt-sm-1 float-none ml-xs-0 mt-2">
                                <a href="{{ route('get_editor_lot_data') }}"
                                    class="btn btn-xs float-left align-middle mt-0 mr-2 py-1 px-2 mb-2 mb-sm-1"
                                    style="position: relative; top: 2px;">Editing Lot List</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- New Create Lot -->
                            <form method="POST" id="form" action="{{ route($EditorLots->route) }}"
                                onsubmit="return validateForm(event)">
                                <div class="row custom-select-row">
                                    @csrf
                                    <!-- Company Name -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label required">Company Name</label>
                                            <input type="hidden" name="id" value="{{ $EditorLots->id }}">
                                            <input type="hidden" name="c_short" id="c_short" value="">
                                            <input type="hidden" name="short_name" id="short_name" value="">
                                            <select class="custom-select form-control-border  com " id="user_id"
                                                name="user_id" aria-hidden="true" style="width: 100%;">

                                                <option value="" selected>Select Company Name</option>
                                                @foreach ($users_data as $user)
                                                    <option value="{{ $user->id }}" data-c_short="{{ $user->c_short }}">
                                                        {{ $user->Company . ' (' . $user->name . ')' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <script>
                                                document.querySelector("#user_id").value = "{{ $EditorLots->user_id }}"
                                            </script>
                                            <p class="input_err" style="color: red; display: none;" id="user_id_err"></p>
                                            @error('user_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Brand Name -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label required">Brand Name</label>
                                            <select class="form-control" id="brand_id" name="brand_id"
                                                data-placeholder="Select Company">
                                                <option value="">Please Select</option>
                                            </select>
                                            <script>
                                                document.querySelector("#brand_id").value = "{{ $EditorLots->brand_id }}"
                                            </script>
                                            <p class="input_err" style="color: red; display: none;" id="brand_id_err"></p>
                                            @error('brand_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Project Type -->
                                    <div class="col-sm-4 col-12">
                                        <div class="form-group">
                                            <label class="control-label required">Request Name</label>
                                            <input type="text" class="form-control" name="request_name"
                                                value="{{ $EditorLots->request_name }}" id="request_name"
                                                placeholder="Enter Request Name">
                                            <p class="input_err" style="color: red; display: none;" id="request_name_err">
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row custom-select-row">
                                        <div class="col-sm-12 mb-3">
                                            <button type="submit"
                                                class="btn btn-sm btn-warning md-2">{{ $EditorLots->button_name }}</button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- End of New Create Lot (For Editing) -->

    <script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

    <script type="application/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <script type="application/javascript" src="{{asset('plugins/datepicker-in-bootstrap-modal/js/datepicker.js')}}"></script>

    <script src="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/js/plugins/mdb-file-upload.min.js"></script>

    <script type="text/javascript">
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            zIndex: 2048,
            format: 'yyyy-mm-dd'
        });
    </script>

    <!-- script for setting short_name -->

    <script>
        $("#brand_id").change(function() {
            const short_name = $("#brand_id").find(':selected').data('short_name');
            $("#short_name").val(short_name);
        });
    </script>

    @if (isset($EditorLots->id))
        <script defer>
            setTimeout(() => {
                $("#user_id").change();
                document.querySelector("#brand_id").value = "<?= $EditorLots->brand_id ?>"
            }, 3000)
        </script>
    @endif
    <!-- Select Brand Name -->
    <script>
        $(document).ready(function() {

            $("#user_id").change(function() {

                const user_id_is = $("#user_id").val();
                const c_short = $("#user_id").find(':selected').data('c_short');
                $("#c_short").val(c_short);


                let options = `<option value="" data-short_name="" > -- Select Brand Name -- </option>`;
                $.ajax({
                    url: "{{ url('get-brand') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        user_id: user_id_is,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        console.log(res)
                        res.map(brands => {
                            options +=
                                ` <option value="${brands.brand_id}" data-short_name="${brands.short_name}"> ${brands.name}</option>`;
                        })
                        console.log(options)
                        document.getElementById("brand_id").innerHTML = options;

                    }
                });
                setTimeout(() => {
                    document.querySelector("#brand_id").value = "<?= $EditorLots->brand_id ?>"
                }, 1000)
            });
        })
    </script>

    <!-- validateForm script -->
    <script>
        function validateForm(event) {
            // event.preventDefault() // this will stop the form from submitting
            $(".input_err").css("display", "none");
            $(".input_err").html("");

            const check_user_id = $('#user_id').val();
            const check_brand_id = $('#brand_id').val();
            const check_request_name = $('#request_name').val();

            let user_id_is_Valid = true;
            let brand_id_Valid = true;
            let request_name_Valid = true;

            if (check_request_name === '') {
                $("#request_name_err").html("Request Name is required");
                document.getElementById("request_name_err").style.display = "block";
                request_name_Valid = false;
            }

            if (check_user_id === '') {
                $("#user_id_err").html("Company Name is required");
                document.getElementById("user_id_err").style.display = "block";
                user_id_is_Valid = false;
            }

            if (check_brand_id === '') {
                $("#brand_id_err").html("Brand Name is required");
                document.getElementById("brand_id_err").style.display = "block";
                brand_id_Valid = false;
            }

            if (user_id_is_Valid && brand_id_Valid && request_name_Valid) {
                return true
            } else {
                return false
            }

        }
    </script>
    <!-- msg div script -->
    <script>
        setTimeout(function() {
            document.getElementById('msg_div').style.display = "none";
        }, 3000)
    </script>

    <!-- lot no div script -->
    <script>
        const lotNoId = document.querySelector('.lotNo').innerHTML;
        if (lotNoId == 0) {
            $(".lotNoShowHide").css("display", "none");
        }
    </script>
@endsection
