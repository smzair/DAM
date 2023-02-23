<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Catalog Wrc Master Sheet</title>
    <style>
        .td_class{
            padding: 0px 10px;
        }
        .td_class1{
            /* padding: 0px 20px; */
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                 <thead>
                    <tr>
                        <th class="td_class">S. No.</th>
                        <th class="td_class">Lot No</th>
                        <th class="td_class">WRC</th>
                        <th class="td_class">Batch Number</th>
                        <th class="td_class">Company Name</th>
                        <th class="td_class">Brand</th>
                        <th class="td_class">Marketplace</th>
                        <th class="td_class">ODN SPOC</th>
                        <th class="td_class">Kind of Service</th>
                        <th class="td_class">Inward SKU Count</th>
                        <th class="td_class">Inward Style Count</th>
                        <th class="td_class">Request Type</th>
                        <th class="td_class">Request Rcvd Date</th>
                        <th class="td_class">Raw Images Rcvd Date</th>
                        <th class="td_class">Login Shared Date</th>
                        <th class="td_class">Content Master Rcvd Date</th>
                        <th class="td_class">Images Rcvd Date (As per Guidelines)</th>
                        <th class="td_class">Missing Info Notified Date</th>
                        <th class="td_class">Missing Info Rcvd Date</th>
                        <th class="td_class">TAT Commited (No of Days)</th>
                        <th class="td_class">TAT Start Date</th>
                        <th class="td_class">TAT Start Month</th>
                        <th class="td_class">TAT End Date</th>
                        <th class="td_class">Details Confirmation Date From Cataloging Team</th>
                        <th class="td_class">Content Writing Source</th>
                        <th class="td_class">Content Writing Date - Sent</th>
                        <th class="td_class">Content Writing Date - Received</th>
                        <th class="td_class">Cataloger Remarks</th>
                        <th class="td_class">SKU Count - Submission</th>
                        <th class="td_class">Style Count - Submission</th>
                        <th class="td_class">Upload Date (Submission)</th>
                        <th class="td_class">Remarks</th>
                        <th class="td_class">Catalog Live Date</th>
                        <th class="td_class">FTA</th>
                        <th class="td_class">Invoice Status</th>
                        <th class="td_class">Invoice No</th>
                        <th class="td_class">TAT Ageing</th>
                        <th class="td_class">TAT Status</th>
                        <th class="td_class">Submission Month</th>
                    </tr>
                </thead>
                {{-- <tbody style="display: none;"> --}}
                <tbody >

                    @php
                        function date_dMY($date)
                        {
                            return date('d-M-Y', strtotime($date));
                        }
                        $marketPlace_arr_list = getMarketPlace();

                        $modeOfDelivary_arr = modeOfDelivary();
                        $market_place_name_list = array_column($marketPlace_arr_list, 'marketPlace_name', 'id');

                        $wrc_skus_wrc_id_arr = array_column($wrc_skus_CountList, 'wrc_id');
                        $wrc_skus_batch_no_arr = array_column($wrc_skus_CountList, 'batch_no');

                        $MarketplaceCredentials_commercial_id_arr = array_column($commercial_wise_MarketplaceCredentials_list, 'commercial_id');
                        $Credentials_marketplace_id_arr = array_column($commercial_wise_MarketplaceCredentials_list, 'marketplace_id');
                        $Credentials_updated_at_arr = array_column($commercial_wise_MarketplaceCredentials_list, 'updated_at');
                        $sn = 1;
                    @endphp
                    @foreach ($CatalogWrcMasterList as $row_key => $row)
                        @php
                            $market_place_id_arr = explode(',',$row['market_place']);
                            $reqReceviedDate = $row['reqReceviedDate'] != '' && $row['reqReceviedDate'] != '0000-00-00' ?  date_dMY($row['reqReceviedDate']) : '' ;
                            $rawimgReceviedDate = $row['rawimgReceviedDate'] != '' && $row['rawimgReceviedDate'] != '0000-00-00' ?  date_dMY($row['rawimgReceviedDate']) : '' ;
                            $img_recevied_date = $row['img_recevied_date'] != '' && $row['img_recevied_date'] != '0000-00-00' ?  date_dMY($row['img_recevied_date']) : '' ;
                            $missing_info_notify_date = $row['missing_info_notify_date'] != '' && $row['missing_info_notify_date'] != '0000-00-00' ?  date_dMY($row['missing_info_notify_date']) : '' ;
                            $missing_info_recived_date = $row['missing_info_recived_date'] != '' && $row['missing_info_recived_date'] != '0000-00-00' ?  date_dMY($row['missing_info_recived_date']) : '' ;
                            $confirmation_date = $row['confirmation_date'] != '' && $row['confirmation_date'] != '0000-00-00' ?  date_dMY($row['confirmation_date']) : '' ;

                            $rework_count = 0;
                            $fta_is = '';
                            $rework_count_list = $row['rework_count_list'];
                            $rework_count_arr = explode(',',$rework_count_list);

                            foreach ($rework_count_arr as $key => $rework_count_val) {
                                if($rework_count_val > 0){
                                    $rework_count += 1;
                                }
                            }
                            if($row['rework_count'] == ''){
                                $fta_is = '';
                            }else{
                                $fta_is = $rework_count > 0 ? 'NFTA' : 'FTA';
                            }
                            $submission_id =$row['submission_id'];
                            $submission_date =$row['submission_date'];

                            $am_emailIs = $row['am_email'] != '' ? explode('@',$row['am_email'])[0] : '';
                            
                            $submission_date_is = $submission_date != '' && $submission_date != null && $submission_date != '0000-00-00' ? date_dMY($submission_date) : '' ;
                            $submission_month = $submission_date != '' && $submission_date != null && $submission_date != '0000-00-00' ? date('F' , strtotime($submission_date)) : 'Not Submitted' ;
                            
                            $work_initiate_date = $row['work_initiate_date'];
                            $work_committed_date =$row['work_committed_date'];

                            $work_initiate_date_is = $work_initiate_date != '' && $work_initiate_date != null && $work_initiate_date != '0000-00-00' ? $work_initiate_date : '' ;
                            $work_committed_date_is = $work_committed_date != '' && $work_committed_date != null && $work_committed_date != '0000-00-00' ? $work_committed_date : '' ;
                            
                            if($work_initiate_date_is != ''){
                                $date1=date_create(date('Y-m-d'));
                                $date2=date_create($work_initiate_date_is);
                                $diff=date_diff($date1,$date2);
                                $tatAgeing = $diff->format("%a");
                                $tatStartDate = date_dMY($work_initiate_date_is);
                            }else{
                                $tatAgeing = '-';
                                $tatStartDate = "Not started";
                            }

                            if($work_committed_date_is != ''){
                                $tatEndDate = date_dMY($work_committed_date_is);
                            }else{
                                $tatEndDate = "Not Ended";
                            }

                            $wrc_id = $row['wrc_id'];
                            $batch_no = $row['batch_no'];
                            $batch_no_is = $batch_no > 0 ? $batch_no :'None';

                            $sku_wrc_id_arr = array_intersect($wrc_skus_wrc_id_arr,array($wrc_id));

                            foreach ($sku_wrc_id_arr as $key => $value) {
                                if($wrc_skus_batch_no_arr[$key] == $batch_no){
                                    $style_count =  $wrc_skus_CountList[$key]['style_count'];
                                    break;
                                }
                            }
                            // Style Count - Submission , SKU Count - Submission   ,TAT Status
                            $sku_qty = $row['sku_qty'];
                            if($submission_id > 0){
                                $Submission_skuQty =  $sku_qty;
                                $Submission_style_count =  $style_count;
                                $tat_status = "";
                                if($work_committed_date_is != '' && $submission_date_is != ''){
                                    if(date('Y-m-d', strtotime($work_committed_date_is)) < date('Y-m-d', strtotime($submission_date_is)) ){
                                        $tat_status = "TAT Breached";
                                    }else{
                                        $tat_status = "Within TAT";
                                    }
                                }
                            }else{
                                $Submission_style_count = $Submission_skuQty =  "-";
                                $tat_status = '-' ;
                            }

                            $modeOfDelivary = $row['modeOfDelivary'];
                            $modeOfDelivary_Is = $modeOfDelivary_arr[$modeOfDelivary];

                            if($modeOfDelivary_Is = 'Uploading'){
                                $commercial_id =$row['commercial_id'];
                                $comm_id_arr = array_intersect($MarketplaceCredentials_commercial_id_arr,array($commercial_id));
                            }
                            
                            if($work_initiate_date_is != '' && $work_committed_date_is != ''){
                                $date1=date_create($work_initiate_date_is);
                                $date2=date_create($work_committed_date_is);
                                $diff=date_diff($date1,$date2);
                                $TAT_CommitedDays = $diff->format("%a");
                            }else{
                                $TAT_CommitedDays = ''; 
                            }

                            $tatStartMonth = $work_initiate_date != '' && $work_initiate_date != null && $work_initiate_date != '0000-00-00' ? date('F' , strtotime($work_initiate_date)) : '-' ;

                            $loginSharedDate = "";
                        @endphp
                        @foreach ($market_place_id_arr as $key => $id_val)
                            @php
                                foreach ($comm_id_arr as $comm_id_key => $comm_id) {
                                    if($id_val == $Credentials_marketplace_id_arr[$comm_id_key]){
                                        $loginSharedDateIs = $Credentials_updated_at_arr[$comm_id_key];
                                        $loginSharedDate = date_dMY($loginSharedDateIs);
                                        break;
                                    }
                                }
                            @endphp
                            <tr>
                                <td class="td_class1">{{ $sn++}}</td>
                                <td class="td_class1">{{ $row['lot_number']}}</td>
                                <td class="td_class1">{{ $row['wrc_number']}}</td>
                                <td class="td_class1">{{ $batch_no_is}}</td>
                                <td class="td_class1">{{ $row['Company']}}</td>
                                <td class="td_class1">{{ $row['brand_name']}}</td>
                                <td class="td_class1">{{ $market_place_name_list[$id_val] }}</td> {{-- Marketplace --}}
                                <td class="td_class1">{{ $am_emailIs}}</td>
                                <td class="td_class1">{{ $row['kind_of_service']}}</td>
                                <td class="td_class1">{{ $sku_qty}}</td> {{-- Inward SKU Count --}}
                                <td class="td_class1">{{ $style_count }}</td> {{-- Inward Style Count --}}
                                <td class="td_class1">{{ $row['requestType']}}</td>
                                <td class="td_class1">{{ $reqReceviedDate}}</td>
                                <td class="td_class1">{{ $rawimgReceviedDate}}</td>
                                <td class="td_class1">{{$loginSharedDate}}</td>  {{-- Login Shared Date --}}
                                <td class="td_class1">{{date('d-M-Y' , strtotime($row['wrc_created_at']))}}</td>  {{-- Content Master Rcvd Date --}}
                                <td class="td_class1">{{ $img_recevied_date}}</td> {{-- Images Rcvd Date (As per Guidelines) --}}
                                <td class="td_class1">{{ $missing_info_notify_date}}</td> {{-- Missing Info Notified Date --}}
                                <td class="td_class1">{{ $missing_info_recived_date}}</td> {{-- Missing Info Rcvd Date --}}
                                <td class="td_class1">{{$TAT_CommitedDays}}</td> {{-- TAT Commited (No of Days) --}}
                                <td class="td_class1">{{$tatStartDate}}</td> {{-- TAT Start Date --}}
                                <td class="td_class1">{{$tatStartMonth}}</td>  {{-- TAT Start Month --}}
                                <td class="td_class1">{{$tatEndDate}}</td>  {{-- TAT End Date --}}
                                <td class="td_class1">{{$confirmation_date}}</td> {{-- // Details Confirmation Date From Cataloging Team --}}
                                <td class="td_class1"></td>  {{-- Content Writing Source --}}
                                <td class="td_class1"></td>  {{-- Content Writing Date - Sent --}}
                                <td class="td_class1"></td>  {{-- Content Writing Date - Received --}}
                                <td class="td_class1"></td>  {{-- Cataloger Remarks --}}
                                <td class="td_class1">{{$Submission_skuQty}}</td>  {{-- SKU Count Submission --}}
                                <td class="td_class1">{{$Submission_style_count}}</td>  {{-- Style Count Submission --}}
                                <td class="td_class1">{{$submission_date_is != '' ? $submission_date_is : 'Not Submitted'}}</td>  {{-- Upload Date (Submission) --}}
                                <td class="td_class1"></td> {{-- Remarks --}}
                                <td class="td_class1"></td>  {{-- Catalog Live Date --}}
                                <td class="td_class1">{{ $fta_is}}</td>
                                <td class="td_class1"></td>  {{-- Invoice Status --}}
                                <td class="td_class1"></td>  {{-- Invoice No --}}
                                <td class="td_class1">{{$tatAgeing}}</td>  {{-- TAT Ageing --}}
                                <td class="td_class1">{{$tat_status}}</td>  {{-- TAT Status --}}
                                <td class="td_class1">{{$submission_month}}</td> {{-- Submission Month --}}
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
               
        </div>
    </div>
</body>
</html>