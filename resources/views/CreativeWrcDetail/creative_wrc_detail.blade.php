
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<div class="wrc-cc-content table-responsive" >
    <table class="table table-head-fixed edt-table text-nowrap m-0" id="">
        <thead>
            <tr>
                <th>Lot No</th>
                <th>WRC</th>
                <th>Batch No</th>
                <th>Client ID</th>
                <th>Company</th>
                <th>Client Bucket</th>
                <th>SPOC</th>
                <th>Project Name</th>
                <th>Kind of Work</th>
                <th>Work Initiate Date</th>
                <th>Committed Date</th>
                <th>Task Type</th>
                <th>Order QTY</th>
                <th>Sku Counts</th>
                <th>Number Delivered</th>
                <th>Submission Date</th>
                <th>Invoice Number</th>
                <th>Payment received on</th>
                <th>Per Qty Rate</th>
                <th>Total Value</th>
                <th>Month</th>
                <th>FTA</th>
                <th>TAT Status</th>
                <th>Ageing</th>
                <th>Lot Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($getCreativeWrcDetails as $data)
                <tr>
                    <td class="align-middle td-data">{{$data['lot_number']}}</td>
                    <td class="align-middle td-data">{{$data['wrc_number']}}</td>
                    <td class="align-middle td-data">{{$data['batch_no']}}</td>
                    <td class="align-middle td-data">{{$data['user_id']}}</td>
                    <td class="align-middle td-data">{{$data['Company_name']}}</td>
                    <td class="align-middle td-data">{{$data['client_bucket']}}</td>
                    <td class="align-middle td-data">{{$data['am_email']}}</td>
                    <td class="align-middle td-data">{{$data['project_name']}}</td>
                    <td class="align-middle td-data">{{$data['kind_of_work']}}</td>
                    <td class="align-middle td-data">{{$data['work_initiate_date']}}</td>
                    <td class="align-middle td-data">{{$data['work_committed_date']}}</td>
                    <td class="align-middle td-data">{{$data['client_bucket']}}</td>
                    <td class="align-middle td-data">{{$data['order_qty']}}</td>
                    <td class="align-middle td-data">{{$data['sku_count']}}</td>
                    <td class="align-middle td-data">{{$data['sku_order_qty']}}</td>
                    <td class="align-middle td-data">{{$data['submission_date']}}</td>
                    <td class="align-middle td-data">-----</td>
                    <td class="align-middle td-data">-----</td>
                    <td class="align-middle td-data">{{$data['per_qty_value']}}</td>
                    <td class="align-middle td-data">{{ ($data['sku_count'] > 0 ? $data['sku_count'] :  $data['order_qty'] ) * $data['per_qty_value']}}</td>
                    <td class="align-middle td-data">{{dateFormat($data['created_at'])}}</td>
                    <td class="align-middle td-data">{{$data['fta']}}</td>
                    <td class="align-middle td-data">{{$data['tat_status']}}</td>
                    <td class="align-middle td-data">{{$data['ageing']}}</td>
                    <td class="align-middle td-data">{{$data['lot_status']}}</td>
                  
                   
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

 <script src="https://code.jquery.com/jquery-3.5.1.js" type="application/javascript" ></script>
 <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="application/javascript" ></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js" type="application/javascript" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript" ></script>
      <script  src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js" type="text/javascript"></script>
<script type="text/javascript">
   $(document).ready(function() {
    $('#masterData').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );
} );

</script>