@extends('layouts.admin')

@section('title')
Marketplace Credentials
@endsection
@section('content')


<div class="lot-table mt-1">
    <div class="container-fluid">

        <div class="row mb-3">
            <div class="col-12">
                <div class="card card-transparent" >
                    <form action="" method="POST">
                        <div class="row p-2">
                            @php
                                $getUserCompanyData = getUserCompanyData();
                            @endphp
                            <div class="col-3 form-group">
                                <label class="control-label" style="width: 100%;" for="user_id">Company Name</label>
                                <select class="custom-select form-control-border" name="user_id" id="user_id">
                                    <option value="0" selected>Select Company Name</option>
                                        @foreach ($getUserCompanyData as $user)
                                            @php
                                                $company_name = ucfirst($user->Company)." (".ucfirst($user->c_short).")"
                                            @endphp
                                            <option  value="{{$user->id}}" data-client_id="{{$user->client_id}}" data-company="{{$company_name}}"  data-c_short="{{$user->c_short}}">{{$company_name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-3 form-group">
                                <label class="control-label">Brand Name</label>
                                <select class="custom-select form-control-border" name="brand_id"  id="brand_id" onchange="marketplace_c_list()">
                                    <option value = "0">-- Select Brand Name --</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-transparent">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-7 col-md-6 col-sm-12">
                                <h3 class="card-title text-black text-bold">
                                    <span class="d-inline-block align-middle">
                                        All Marketplace Credentials
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
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <div class="card-body table-responsive p-0"  style="max-height: 700px; height: 100%;">
                        <table id="" class="table table-head-fixed table-hover text-nowrap">
                            <thead>
                            <tr class="wrc-tt">
                                <th class="p-2">Marketplace</th>
                                <th class="p-2">Link</th>
                                <th class="p-2">Username</th>
                                <th class="p-2">Password</th>
                                <th class="p-2">Commercial Id</th>
                            </tr>
                            </thead>
                             @php
                                // $marketPlace = getMarketPlace();
                                // pre($marketPlace);
                            @endphp
                            <tbody id="marketPlace_body">
                                {{-- @foreach($marketPlace as $index => $row)
                                <tr class="row-tt">
                                    <td class="p-sm-2 p-1">{{$row['marketPlace_name']}}</td>
                                    <td class="p-sm-2 p-1">{{$row['link']}}</td>
                                    <td class="p-sm-2 p-1">{{$row['username']}}</td>
                                    <td class="p-sm-2 p-1">{{$row['password']}}</td>
                                </tr>
                                @endforeach --}}
                            </tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
    </div>
</div>

<!-- End of Table -->

<!-- DataTable Plugins Path -->

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<!-- End of DataTable Plugins Path -->

<!-- Data Table Calling Function -->

<script>
  $('#wrcTableCat').DataTable({
        dom: 'lBfrtip',
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "buttons": ["copy", "csv", "excel", "pdf"]
  }).buttons().container().insertAfter('#masterData_wrapper .dataTables_length');
</script>

<script type="application/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>



<!-- Get Brand List -->
<script>
    $(document).ready(function() {
        $("#user_id").change(async function() {
            const user_id_is = $("#user_id").val();
            const c_short = $("#user_id").find(':selected').data('c_short');
            $("#c_short").val(c_short);
            let options = `<option value="" data-short_name=""  > -- Select Brand Name -- </option>`;
            await $.ajax({
                url: "{{ url('get-catlog-brand') }}",
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
                            ` <option value="${brands.brand_id}" data-short_name="${brands.short_name}" > ${brands.name}</option>`;
                    })
                    document.getElementById("brand_id").innerHTML = options;
                }
            });
            // marketplace_c_list();
        });
    })
</script>

{{-- Marketplace Credentials list --}}
<script>

    async function marketplace_c_list(){

        const user_id_is = $("#user_id").val();
        const brand_id_is = $("#brand_id").val();
        let tr_list = '';
        await $.ajax({
            url: "{{ url('get-marketplace_c_list') }}",
            type: "POST",
            dataType: 'json',
            data: {
                user_id : user_id_is,
                brand_id : brand_id_is,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                // console.log(res)
                if(res.status == 1){
                    const data_arr = res.data
                    // console.log(data_arr)
                    // const filtered = data_arr.filter(arr =>{
                    //     const marketPlace_name = arr['marketPlace_name']
                    //     const credentials_id = arr['credentials_id'] == null ? '' : arr['credentials_id'];
                    //     const link = arr['link'] == null ? '' : arr['link'];
                    //     const username = arr['username'] == null ? '' : arr['username'];
                    //     const password = arr['password'] == null ? '' : arr['password'];
                    // })
                    const shown_data = []
                    data_arr.map((arr , index) => {
                        const marketPlace_name = arr['marketPlace_name']
                        const credentials_id = arr['credentials_id'] == null ? '' : arr['credentials_id'];
                        const commercial_id = arr['commercial_id'] == null ? '' : arr['commercial_id'];
                        const link = arr['link'] == null ? '' : arr['link'];
                        const username = arr['username'] == null ? '' : arr['username'];
                        const password = arr['password'] == null ? '' : arr['password'];
                        
                        const f_arr = shown_data.filter(data => 
                            data.marketPlace_name === marketPlace_name
                            &&
                            data.link === link
                            &&
                            data.username === username
                            &&
                            data.password === password
                            &&
                            data.commercial_id !== commercial_id
                        )

                        console.log( "index " +index +" f_arr.length ",f_arr.length)
                        console.log({f_arr})
                        if(f_arr.length === 0){
                            shown_data.push({
                                marketPlace_name,
                                credentials_id,
                                link,
                                username,
                                password,
                                commercial_id,
                            })
                            tr_list += `<tr class="row-tt">
                                <td class="p-sm-2 p-1">${marketPlace_name}</td>
                                <td class="p-sm-2 p-1">${link}</td>
                                <td class="p-sm-2 p-1">${username}</td>
                                <td class="p-sm-2 p-1">${password}</td>
                                <td class="p-sm-2 p-1">${commercial_id}</td>
                            </tr>`;
                        }
                        console.log(shown_data)

                    })


                }else{
                    alert(res.massage);
                }
                // res.map(brands => {
                //     options +=
                //         ` <option value="${brands.brand_id}" data-short_name="${brands.short_name}" > ${brands.name}</option>`;
                // })
                // console.log(tr_list)
                document.getElementById("marketPlace_body").innerHTML = tr_list;
            }
        });
    }
    
</script>
@endsection