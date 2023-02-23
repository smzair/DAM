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

     
@if($data['list'] != null)
    <div class="container-fluid mt-2">
        <p>Hi Team,<br>
       Please find todays shoot status till the time</p>
        <div class="row">
            <div class="col-12">
                <div class="data-all-table">
                    <div class="card card-transparent">
                        <div class="card-header">
                        </div>
                        <div class="card-body p-0">
                           <table class="table table-bordered ">
                               <thead> 
                                <tr class="snd-rw">               
                                   <th>WRC Number</th>
                                   <th>Brand</th>
                                   <th>SKU Codes</th>
                                   <th class="text-nowrap" > SKU Count</th>
                               </tr>
                                @foreach($data['list'] as $wrc)
                           </thead>
                           <tbody>
                            <tr style="text-align:center">
                                <td>{{$wrc['wrcid']}}</td>
                                <td>{{$wrc['brand']}}</td>
                                  <td>@foreach($wrc['sku']['sku_codes'] as $codes)
                             {{$codes}}, @endforeach</td>
                             <td>{{$wrc['sku_count']}}
                              </td> 
                            </tr>
                                 @endforeach
                      <tr> 
                      <!--<td>     </td>-->
                      <!--          <td>  </td>-->
                      <!--            <td style="text-align:right"><strong> TOTAL Uploaded SKU's </strong></td>-->
                      <!--       <td >{{$data['totalcount']}}-->
                      <!--        </td> </tr>-->
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
        There is No Raw images & SKUs uploded in the System</p>
<br/>
<p>Thank You<br/>
Odnconnect</p>

@endif


</body>
<footer> <div style="text-align:center;" > <p>Do not reply to this email its a system genrated report</p> </div> 
</footer>
</html>
