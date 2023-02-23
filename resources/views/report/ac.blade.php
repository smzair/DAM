<html>
<body>

    <div class="wrc-cc-content table-responsive" >
        <table class="table table-head-fixed edt-table text-nowrap m-0" id="masterData">
            <thead>
                <tr>
                    <th class="align-middle">Company Name</th>
                    <th class="align-middle">Brand Name</th>
                    <th class="align-middle">Spoc</th>
                    <th class="align-middle">Type of service</th>
                   <th class="align-middle">verticle Type</th>
                    <th class="align-middle">Inward Date</th>   
                    <th class="align-middle">Month</th>   
                    <th class="align-middle">Wrc Number</th>
                    <th class="align-middle">Payment terms</th>
                    <th class="align-middle">Invoice No.</th>
                    <th class="align-middle">Invoice (Per SKU value)</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($wrcdata as $data)
                <tr>
            <td class="align-middle td-data">{{$data->Company}}</td>
            <td class="align-middle td-data">{{$data->name}}</td>
            <td class="align-middle td-data">{{$data->am_email}}</td>
            <td class="align-middle td-data">{{$data->s_type}}</td>
            <td class="align-middle td-data">{{$data->verticleType}}</td>
           <td class="align-middle td-data">{{dateFormat($data->created_at)}}</td>
            <td class="align-middle td-data">{{ \Carbon\Carbon::parse($data->created_at)->format('F') }}</td>
            <td class="align-middle td-data">{{$data->wrc_id}}</td>
            <td class="align-middle td-data">{{$data->payment_term}}</td>
            <td class="align-middle td-data">{{$data->Invoice_no}}</td>
            <td class="align-middle td-data">{{$data->commercial_value_per_sku}}</td>           
                     </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </body>
    </html>