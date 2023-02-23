<html>
    <head>
        <style>
            table {
                width: 80%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: lightgray;
            }
        </style>
    </head>
    <body>
        <div>
            {{-- creative lot create email template --}}
            @if($creation_type == 'Lot')
                <table>
                    <thead>
                        <tr>
                            <th>LOT Number</th>
                            <th>Brand Name</th>
                            {{-- <th>Ready For Wrc Creation</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$notification_data->lot_number}}</td>
                            <td>{{$notification_data->brand_name}}</td>
                            {{-- <td>Yes</td> --}}
                        </tr>
                    </tbody>
                </table>                                                        
            @endif

            {{-- creative Wrc create email template --}}
            @if($creation_type == 'Wrc')
                <table>
                    <thead>
                        <tr>
                            <th>Wrc Number</th>
                            <th>Order Quantity</th>
                            <th>Sku Counts</th>
                            {{-- <th>Ready For Allocation</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$notification_data['wrc_number']}}</td>
                            <td>{{$notification_data['order_qty']}}</td>
                            <td>{{$notification_data['sku_count']}}</td>
                            {{-- <td>Yes</td> --}}
                        </tr>
                    </tbody>
                </table>
            @endif

            {{-- creative Wrc allocation create email template --}}
            @if($creation_type == 'WrcAllocation')
                <table>
                    <thead>
                        <tr>
                            <th>Wrc Number</th>
                            <th>Batch No</th>
                            <th>Allocated Count</th>
                            {{-- <th>Allocated And Ready For Tasking</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$notification_data->wrc_number}}</td>
                            <td>{{$notification_data->batch_no == 0 ? 'None' : $notification_data->batch_no}}</td>
                            <td>{{$notification_data->allocated_count}}</td>
                            {{-- <td>Yes</td> --}}
                        </tr>
                    </tbody>
                </table>
            @endif

             {{-- complete task in upload  email template (tasking) --}}
            @if ($creation_type == 'completeTaskInUpload')
                <table>
                    <thead>
                        <tr>
                            <th>Wrc Number</th>
                            <th>Batch No</th>
                            <th>Uploaded Link</th>
                            <th>Uploaded by</th>
                            {{-- <th>Tasking Done and ready for qc</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$notification_data->wrc_number}}</td>
                            <td>{{$notification_data->batch_no == 0 ? 'None' : $notification_data->batch_no}}</td>
                            <td>{{$notification_data->uploaded_detail}}</td>
                            <td>{{$notification_data->uploaded_by_user_name}}</td>
                            {{-- <td>Yes</td> --}}
                        </tr>
                    </tbody>
                </table>
            @endif

            {{--Qc Done and ready for submission email template --}}
            @if ($creation_type == 'Qc')
                <table>
                    <thead>
                        <tr>
                            <th>Wrc Number</th>
                            <th>Batch No</th>
                            <th>Qc Status</th>
                            {{-- <th>Qc Done and ready for submission</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$notification_data->wrc_number}}</td>
                            <td>{{$notification_data->batch_no}}</td>
                            <td>{{$notification_data->qc_status}}</td>
                            {{-- <td>Yes</td> --}}
                        </tr>
                    </tbody>
                </table>
            @endif

            {{-- Catlog Lot  create email template --}}
            @if ($creation_type == 'CatlogLot')
                <table>
                    <thead>
                        <tr>
                            <th>Lot Number</th>
                            <th>Brand Name</th>
                            {{-- <th>Ready For Catlog Wrc Creation</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$notification_data->lot_number}}</td>
                            <td>{{$notification_data->brand_name}}</td>
                            {{-- <td>Yes</td> --}}
                        </tr>
                    </tbody>
                </table>
            @endif

            {{-- creative Wrc create email template --}}
            @if($creation_type == 'CatlogWrc')
                <table>
                    <thead>
                        <tr>
                            <th>Wrc Number</th>
                            <th>Quantity</th>
                            {{-- <th>Sku Counts</th> --}}
                            {{-- <th>Ready For Allocation</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$notification_data['wrc_number']}}</td>
                            <td>{{$notification_data['sku_qty']}}</td>
                            {{-- <td>{{$notification_data['sku_count']}}</td> --}}
                            {{-- <td>Yes</td> --}}
                        </tr>
                    </tbody>
                </table>
            @endif

            {{-- creative Wrc allocation create email template --}}
            @if($creation_type == 'WrcAllocationCatlog')
                <table>
                    <thead>
                        <tr>
                            <th>Wrc Number</th>
                            <th>Batch No</th>
                            <th>Allocated Count</th>
                            {{-- <th>Allocated And Ready For Tasking</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$notification_data->wrc_number}}</td>
                            <td>{{$notification_data->batch_no == 0 ? 'None' : $notification_data->batch_no}}</td>
                            <td>{{$notification_data->allocated_count}}</td>
                            {{-- <td>Yes</td> --}}
                        </tr>
                    </tbody>
                </table>
            @endif

             {{-- complete task in upload  email template (tasking) catlog--}}
            @if ($creation_type == 'completeTaskInUploadCatlogFinalLink')
                <table>
                    <thead>
                        <tr>
                            <th>Wrc Number</th>
                            <th>Batch No</th>
                            <th>Uploaded Link</th>
                            <th>Uploaded by</th>
                            {{-- <th>Tasking Done and ready for qc</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$notification_data->wrc_number}}</td>
                            <td>{{$notification_data->batch_no == 0 ? 'None' : $notification_data->batch_no}}</td>
                            <td>{{$notification_data->uploaded_detail}}</td>
                            <td>{{$notification_data->uploaded_by_user_name}}</td>
                            {{-- <td>Yes</td> --}}
                        </tr>
                    </tbody>
                </table>
            @endif
             {{-- complete task in upload  email template (tasking) catlog--}}
             @if ($creation_type == 'completeTaskInUploadCatlogMarketPlace')
             <table>
                 <thead>
                     <tr>
                         <th>Wrc Number</th>
                         <th>Batch No</th>
                         <th>Uploaded by</th>
                         <th>Marketplace</th>
                         <th>Approved Count</th>
                         <th>Rejected Count</th>
                         <th>Date</th>
                         {{-- <th>Tasking Done and ready for qc</th> --}}
                     </tr>
                 </thead>
                 <tbody>
                    
                    @foreach ($notification_data->data_array as $data_array)
                    @php
                        $marketplaces = DB::table('marketplaces')->where('id',$data_array['marketPlace_id'])->first(['marketPlace_name']);
                        $marketPlace_name = $marketplaces != null ? $marketplaces->marketPlace_name : "";
                    @endphp
                    <tr>
                        <td>{{$notification_data->wrc_number}}</td>
                        <td>{{$notification_data->batch_no == 0 ? 'None' : $notification_data->batch_no}}</td>
                        <td>{{$notification_data->uploaded_by_user_name}}</td>
                        <td>{{$marketPlace_name}}</td>
                        <td>{{$data_array['approved_Count']}}</td>
                        <td>{{$data_array['rejected_Count']}}</td>
                        <td>{{$data_array['upload_date']}}</td>
                        {{-- <td>Yes</td> --}}
                    </tr>
                    @endforeach
                    <tr><td colspan="7">Order Qty :- {{$notification_data->order_qty}}</td></tr>
                     
                 </tbody>
             </table>
        @endif

        {{--Qc Done and ready for submission email template --}}
        @if ($creation_type == 'QcCatlog')
         <table>
             <thead>
                 <tr>
                     <th>Wrc Number</th>
                     <th>Batch No</th>
                     <th>Qc Status</th>
                     {{-- <th>Qc Done and ready for submission</th> --}}
                 </tr>
             </thead>
             <tbody>
                 <tr>
                     <td>{{$notification_data->wrc_number}}</td>
                     <td>{{$notification_data->batch_no}}</td>
                     <td>{{$notification_data->qc_status}}</td>
                     {{-- <td>Yes</td> --}}
                 </tr>
             </tbody>
         </table>
        @endif

        {{-- creative lot create email template --}}
        @if($creation_type == 'LotEditor')
            <table>
                <thead>
                    <tr>
                        <th>LOT Number</th>
                        <th>Brand Name</th>
                        {{-- <th>Ready For Wrc Creation</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$notification_data->lot_number}}</td>
                        <td>{{$notification_data->brand_name}}</td>
                        {{-- <td>Yes</td> --}}
                    </tr>
                </tbody>
            </table>                                                        
        @endif

        {{-- creative Wrc create email template --}}
        @if($creation_type == 'WrcEditor')
            <table>
                <thead>
                    <tr>
                        <th>Wrc Number</th>
                        <th>Quantity</th>
                        {{-- <th>Ready For Allocation</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$notification_data['wrc_number']}}</td>
                        <td>{{$notification_data['imgQty']}}</td>
                        {{-- <td>Yes</td> --}}
                    </tr>
                </tbody>
            </table>
        @endif

        {{-- creative Wrc allocation create email template --}}
        @if($creation_type == 'WrcAllocationEditor')
            <table>
                <thead>
                    <tr>
                        <th>Wrc Number</th>
                        <th>Allocated Count</th>
                        {{-- <th>Allocated And Ready For Tasking</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$notification_data->wrc_number}}</td>
                        <td>{{$notification_data->allocated_count}}</td>
                        {{-- <td>Yes</td> --}}
                    </tr>
                </tbody>
            </table>
        @endif

         {{-- complete task in upload  email template (tasking) Editing--}}
        @if ($creation_type == 'completeTaskInUploadEditingFinalLink')
            <table>
                <thead>
                    <tr>
                        <th>Wrc Number</th>
                        <th>Uploaded Link</th>
                        <th>Uploaded by</th>
                        {{-- <th>Tasking Done and ready for qc</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$notification_data->wrc_number}}</td>
                        <td>{{$notification_data->uploaded_detail}}</td>
                        <td>{{$notification_data->uploaded_by_user_name}}</td>
                        {{-- <td>Yes</td> --}}
                    </tr>
                </tbody>
            </table>
        @endif

        {{-- creative lot create email template --}}
        @if($creation_type == 'LotShoot')
            <table>
                <thead>
                    <tr>
                        <th>LOT Number</th>
                        <th>Brand Name</th>
                        {{-- <th>Ready For Wrc Creation</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$notification_data->lot_number}}</td>
                        <td>{{$notification_data->brand_name}}</td>
                        {{-- <td>Yes</td> --}}
                    </tr>
                </tbody>
            </table>                                                        
            @endif

            {{-- creative Wrc create email template --}}
            @if($creation_type == 'WrcShoot')
                <table>
                    <thead>
                        <tr>
                            <th>Wrc Number</th>
                            {{-- <th>Order Quantity</th> --}}
                            <th>Sku Counts</th>{{-- doubt --}}
                            {{-- <th>Ready For Allocation</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$notification_data['wrc_id']}}</td>
                            <td>--</td>
                            {{-- <td>{{$notification_data['order_qty']}}</td> --}}
                            {{-- <td>{{$notification_data['sku_count']}}</td> --}}
                            {{-- <td>Yes</td> --}}
                        </tr>
                    </tbody>
                </table>
            @endif

            {{-- shoot plan info  --}}
            @if($creation_type == 'ShootPlanInfo')
                <table>
                    <thead>
                        <tr>
                            <th>Wrc Number</th>
                            <th>Plan Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>--</td>
                            <td>--</td>
                        </tr>
                    </tbody>
                </table>
            @endif

             {{-- shoot raw images info template--}}
             @if($creation_type == 'Lot')
             <table>
                 <thead>
                     <tr>
                         <th>Wrc Number</th>
                         <th>Approve count</th>
                         <th>Rejection count</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td>{{$notification_data->wrc_number}}</td>
                         <td>{{$notification_data->approve_count}}</td>
                         <td>{{$notification_data->rejection_count}}</td>
                     </tr>
                 </tbody>
             </table>                                                        
         @endif


        </div>
    </body>
</html>
