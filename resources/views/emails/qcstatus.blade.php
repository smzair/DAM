<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

        table tr th {
            border: 1px solid gray;
            text-align: center;
        }

        table tr td {
            border: 1px solid gray;
        }

        .pen-count-box .info-box-content h1,
        .pen-count-box .info-box-content h3 {
            display: inline-block;
            vertical-align: middle;
            font-size: 20px;
        }

        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
        }

    </style>
</head>
<body>

     
@if($data['SubmissionList'] != null)
    <div class="container-fluid mt-2">
        <p>Hi Team,<br>
       Please find todays QC completion status till the time</p>
        <div class="row">
            <div class="col-12">
                <div class="data-all-table">
                    <div class="card card-transparent">
                        <div class="card-header">
                        </div>
                        <div class="card-body p-0">
                           <table class="table table-bordered">
                               <thead> 
                              
                                <tr class="snd-rw">
                                      <th>Brand Name</th>   
                                 <th>LOT Number</th>               
                                   <th>WRC Number</th>
                                     <th>Type of products</th>
                                      <th>Total QC Done SKU Codes</th>
                                         <th>Submission Status</th>
                               </tr>
                           </thead>
                           <tbody>
  @foreach($data['SubmissionList'] as $list)
                            <tr style="text-align:center">
                                 <td> {{$list['brand']}} </td>
                                  <td> {{$list['lot_id']}} </td>
                                <td> {{$list['wrc_id']}} </td>
                                  <td> {{$list['product_category']}} </td>  
                                  <td> {{$list['sku_count']}} </td>
                                  @if($list['approved_sku'] == $list['sku_count'] )
                                  <td> Ready for Complete Submission </td>
                                  @else
                                 <td> Ready for Partial Submission </td>
                                  @endif
                                  
                                  </tr>
                        
                      @endforeach
                  </tbody>
              </table>
          </div>

      </div>
  </div>
<p>Thank You<br/>
Odnconnect</p>
</div>
</div>
</div>

@else
 <p>Hi Team,<br>
    There is No QC Done against WRCs uploded in the System till the time.</p>
<br/>
<p>Thank You<br/>
Odnconnect</p>

@endif


</body>
<footer> <div style="text-align:center;" > <p>Do not reply to this email its a system genrated report</p> </div> 
</footer>
</html>
