@extends('layouts.admin')
@section('title')
Master sheet
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<div class="wrc-cc-content table-responsive" >
    <table class="table table-head-fixed edt-table text-nowrap m-0" id="masterData">
        <thead>
          <tr>
                <th class="align-middle">Sr</th>
                <th class="align-middle">Company</th>
                          <th class="align-middle">Brand Name</th>
                <th class="align-middle">Sample Inward Date</th>
                <th class="align-middle">LOT No</th>
                <th class="align-middle">LOT Inward Quantity</th>
                <th class="align-middle">WRC No</th>
                <th class="align-middle">WRC Count</th>
                <th class="align-middle">WRC Inward Quantity</th>
                <th class="align-middle">Client ID</th>
                <th class="align-middle">Location</th>
                <th class="align-middle">Vertical Type</th>
                <th class="align-middle">Client Bucket</th>
                <th class="align-middle">Shoot Hand Over Date</th>
                <th class="align-middle">Gender</th>
                <th class="align-middle">Spoc Email</th>
                <th class="align-middle">Type Of Shoot</th>
                <th class="align-middle">Category</th>
                <th class="align-middle">Type Of Clothing</th>
                <th class="align-middle">Shoot Guideline</th>
                <th class="align-middle">Adaptation 1</th>
                <th class="align-middle">Adaptation 2</th>
                <th class="align-middle">Adaptation 3</th>
                <th class="align-middle">Adaptation 4</th>
                <th class="align-middle">PPT Approval Date</th>
                <th class="align-middle">Model Approval Date</th>
                <th class="align-middle">Inward Sheet Date</th>
                <th class="align-middle">Special Approval Date</th>
                <th class="align-middle">Model Available Date</th>
                <th class="align-middle">Lot size</th>
                <th class="align-middle">TAT Start Date</th>
                <th class="align-middle">TAT End Date</th>
                <th class="align-middle">TAT Status</th>
                <th class="align-middle">Planning Date</th>
                <th class="align-middle">Shoot Month</th>
                <th class="align-middle">Shoot Date</th>
                <th class="align-middle">Internal Rejections</th>
                <th class="align-middle">Editing/QC Rejections</th>
                <th class="align-middle">Client Rejection</th>
                 <th class="align-middle">SKU shoot pending</th>
                <th class="align-middle">SKU shoot done</th>
                <th class="align-middle">Submission Date</th>
                <th class="align-middle">Submission Qty</th>
                <th class="align-middle">Shift</th>
                <th class="align-middle">Studio</th>
                <th class="align-middle">Model</th>
                <th class="align-middle">Agency</th>
                <th class="align-middle">Photographer</th>
                <th class="align-middle">Makeup</th>
                <th class="align-middle">Stylist</th>
                <th class="align-middle">Assistant</th>
                 <th class="align-middle">Invoice Number</th>
                <th class="align-middle">Photographer Commercial</th>
                <th class="align-middle">Makeup Commercial</th>
                <th class="align-middle">Stylist Commercial</th>
                <th class="align-middle">Assistant Commercial</th>
                <th class="align-middle">Per SKU Commercial</th>
                <th class="align-middle">Total Commercial</th>
            </tr>
        </thead>
        <tbody>
          @foreach($wrcInfo as  $wrc)
          <tr>
            <td class="align-middle td-data index-tddata">{{$sr++}}</td>
            <td class="align-middle td-data">{{$wrc['Company']}}</td>
               <td class="align-middle td-data">{{$wrc['name']}}</td>
            <td class="align-middle td-data">{{dateFormat($wrc['inward_at'])}}</td>
            <td class="align-middle td-data">{{$wrc['lot_id']}}</td>
        <td class="align-middle td-data">{{$wrc['inwardLot_sku_count']}}</td>
            <td class="align-middle td-data">{{$wrc['wrc_id']}}</td>
            <td class="align-middle td-data">{{$wrc['wrc_count']}}</td>
        <td class="align-middle td-data">{{$wrc['inwardwrc_sku_count']}}</td>
            <td class="align-middle td-data">{{$wrc['client_id']}}</td>
            <td class="align-middle td-data">{{$wrc['Location']}}</td>
            <td class="align-middle td-data">{{$wrc['verticalType']}}</td>
            <td class="align-middle td-data">{{$wrc['clientBucket']}}</td>
            <td class="align-middle td-data">{{$wrc['shoothandoverDate']}}</td>
            <td class="align-middle td-data">{{$wrc['gender']}}</td>
            <td class="align-middle td-data">{{$wrc['am_email']}} </td>
            <td class="align-middle td-data">{{$wrc['type_of_shoot']}}</td>
        <td class="align-middle td-data">{{$wrc['product_category']}}</td>
            <td class="align-middle td-data">{{$wrc['type_of_clothing']}}</td>
            <td class="align-middle td-data">{{$wrc['adaptation_1']}}</td>
            <td class="align-middle td-data">{{$wrc['adaptation_2']}}</td>
            <td class="align-middle td-data">{{$wrc['adaptation_3']}}</td>
            <td class="align-middle td-data">{{$wrc['adaptation_4']}}</td>
            <td class="align-middle td-data">{{$wrc['adaptation_5']}}</td>
            <td class="align-middle td-data">{{$wrc['ppt_approval']}}</td>
            <td class="align-middle td-data">{{$wrc['model_approval']}}</td>
            <td class="align-middle td-data">{{$wrc['inward_sheet']}}</td>
            <td class="align-middle td-data">{{$wrc['special_approval']}}</td>
            <td class="align-middle td-data">{{$wrc['model_available']}}</td>
            <td class="align-middle td-data">{{($wrc['Lot_size'])}}</td>
            <td class="align-middle td-data">{{($wrc['TAT_start_date'])}}</td>
            <td class="align-middle td-data">{{($wrc['TAT_end_date'])}}</td>
                <td class="align-middle td-data">{{($wrc['TAT_status'])}}</td>
            <td class="align-middle td-data">{{($wrc['planning_date'])}}</td>
            @if($wrc['shoot_date'] == "Not Planned")
            <td class="align-middle td-data">{{ $wrc['shoot_date']}}</td>
            @else
            <td class="align-middle td-data">{{ \Carbon\Carbon::parse($wrc['shoot_date'])->format('F') }}</td>
            @endif    
            <td class="align-middle td-data">{{$wrc['shoot_date']}}</td>
            <td class="align-middle td-data">{{$wrc['reject_count']}}</td>
            <td class="align-middle td-data">0</td>
            @if($wrc['clientar'] == 1)
            <td class="align-middle td-data">Approved</td>            
            @elseif($wrc['clientar'] == 0)
            <td class="align-middle td-data">Rejected</td>            
    @else
    <td class="align-middle td-data">Not Updated</td>         
    @endif   
    <td class="align-middle td-data">{{$wrc['shootpending']}}</td>
    <td class="align-middle td-data">{{$wrc['shootdone']}}</td>
    @if($wrc['submission_date'] != "")
    <td class="align-middle td-data">{{$wrc['submission_date']}}</td>
    @else
     <td class="align-middle td-data">No Infromation</td>
     @endif  
   <td class="align-middle td-data">{{$wrc['submission_count']}}</td>
            <td class="align-middle td-data">{{$wrc['shoot_hour']}}</td>
            <td class="align-middle td-data">{{$wrc['studio']}}</td>
            <td class="align-middle td-data">{{$wrc['model']}}</td>
            <td class="align-middle td-data">{{$wrc['agency']}}</td>
            <td class="align-middle td-data">{{$wrc['photographer']}}</td>
            <td class="align-middle td-data">{{$wrc['makeupartist']}}</td>
            <td class="align-middle td-data">{{$wrc['stylist']}}</td>
            <td class="align-middle td-data">{{$wrc['assistant']}}</td>
            <td class="align-middle td-data">{{$wrc['invoice_no']}}</td>
            <td class="align-middle td-data">{{$wrc['photographer_charges']}}</td>
            <td class="align-middle td-data">{{$wrc['stylist_charges']}}</td>
            <td class="align-middle td-data">{{$wrc['makeup_charges']}}</td>
            <td class="align-middle td-data">{{$wrc['assistant_charges']}}</td>
             <td class="align-middle td-data">{{$wrc['com']/$wrc['inwardwrc_sku_count']}}</td>
            <td class="align-middle td-data">{{$wrc['com']}}</td>
             
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
@endsection