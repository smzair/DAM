<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  

<!-- <style type="text/css">
    .data-all-table .card.card-transparent .card-header {
        border-bottom: 0 !important;
        text-align: center;
    }

    .data-all-table .table-responsive > .table-bordered {
        border: 1px solid #dee2e6;
    }

    .data-all-table .table thead th {
        border: 1px solid #dee2e6 !important;
        border-bottom: 2px solid #dee2e6 !important;
    }

    .data-all-table .card.card-transparent .card-header h3.table-card-title {
        margin: 0;
        font-size: 1.1rem;
    }

    .light-dsh-mode .data-all-table .table-responsive > .table-bordered {
        border: 1px solid #000;
    }

    .light-dsh-mode .data-all-table .table thead th {
        border: 1px solid #000 !important;
        border-bottom: 2px solid #000 !important;
    }

    .light-dsh-mode .data-all-table .table-bordered td {
        border-color: #000 !important;
    }
    .data-all-table .table {
        font-size: 10px;
    }

    tr.snd-rw th {
        vertical-align: middle;
    }

    .pending-count-wrapper .info-box.dm-info-box.pen-count-box h1 {
    font-size: 1.6rem;
}

.pending-count-wrapper .info-box.dm-info-box.pen-count-box h3 {
    font-size: 0.7rem;
    white-space: nowrap;
}

.info-box.dm-info-box.pen-count-box:hover {
    transform: none;
}
</style> -->

<style>

table tr th {
    border: 1px solid gray;
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

    <div class="container-fluid mt-2">
        <p>Hi Team,<br>
        Here is the Daily Usage Reports as of {{dateFormat($reportdata['date'])}}</p>
                <div class="row">
            <div class="col-12">
                <div class="data-all-table">
                    <div class="card card-transparent">
                        <div class="card-header">
                         </div>
                         <div class="card-body p-0">
                             <table class="table table-bordered">
                                 <thead>
                                     <tr class="frs-rw">
                                         <th colspan="9"></th>
                                         <th colspan="6" style="text-align: center;">SKU</th>
                                     </tr>
                                     <tr class="snd-rw">
                                         <th>Departments</th>
                                         <th>New Brand</th>
                                         <th width="10px">Brands Added</th>
                                         <th>Commercial Creation</th>
                                         <th>Lot Creation</th>
                                         <th>WRC Creation</th>
                                         <th>Article Acceptance</th>
                                         <th>SKU Inwarding</th>
                                         <th>New Plan</th>
                                         <th>Shoot Planning</th>
                                         <th>Raw Image Upload</th>
                                         <th>Image Allocation</th>
                                         <th>Edited uploads</th>
                                         <th>QC</th>
                                         <!-- <th>Submission</th> -->
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <tr>
                                         <td>Commercial</td>
                                         <td>{{$reportdata['brand']}}</td>
                                         <td width="10px">{{$reportdata['brandtouser']}}</td>
                                         <td>{{$reportdata['com']}}</td>
                                         <td>{{$reportdata['lots']}}</td>
                                         <td>{{$reportdata['wrc']}}</td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>

                                     </tr>
                                     <tr>
                                         <td>AM</td>
                                         <td></td>
                                         <td width="10px"></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td>{{$reportdata['acceptance']}}</td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>

                                     </tr>
                                     <tr>
                                         <td>Inwarding</td>
                                         <td></td>
                                         <td width="10px"></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td>{{$reportdata['skus']}}</td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>

                                     </tr>
                                     <tr>
                                         <td>Operations</td>
                                         <td></td>
                                         <td width="10px"></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td>{{$reportdata['plan']}}</td>
                                         <td>{{$reportdata['planwrc']}}</td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>

                                     </tr>
                                     <tr>
                                         <td>Studio</td>
                                         <td></td>
                                         <td width="10px"></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td>{{$reportdata['rawimg']}}</td>
                                         <td></td>
                                         <td></td>
                                         <td></td>

                                     </tr>
                                     <tr>
                                         <td>Editing</td>
                                         <td></td>
                                         <td width="10px"></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td>{{$reportdata['editorallocated']}}</td>
                                         <td>{{$reportdata['editorSubmission']}}</td>
                                         <td>{{$reportdata['qc']}}</td>

                                     </tr>
                             <!--
                                      -->
                                 </tbody>
                             </table>
                         </div>

                     </div>
                 </div>

                </div>
            </div>
        </div>

        <h4> All the pending counts in the system till today</h4>
        <div class="pending-count-wrapper">
            <div class="container-fluid">
                    <div class="card-body p-0">
                             <table class="table table-bordered">
                                 <thead>
                                 <tr class="snd-rw">
                                         <th>Untagged Brands</th>
                                         <th>Idle Commercials</th>
                                         <th>LOTs Without WRC</th>
                                         <th>WRCs Without Inwarding</th>
                                         <th>Idle Plans</th>
                                         <th>SKUs Pending To Be Planned</th>
                                         <th>Planned SKUs Without Raw Images</th>
                                         <th>SKUs Awaiting Allocation</th>
                                         <th>Allocated SKUs Without Raw Images</th>
                                         <th>SKUs Pending For QC</th>
                                         </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                         <td>{{$reportdata['brands']}}</td>
                                         <td>{{$reportdata['Commercials']}}</td>
                                         <td>{{$reportdata['Lots']}}</td>
                                         <td>{{$reportdata['Wrcs']}}</td>
                                         <td>{{$reportdata['pendingplan']}}</td>
                                         <td>{{$reportdata['pendingsku']}}</td>
                                         <td>{{$reportdata['uploadrawpending']}}</td>
                                         <td>{{$reportdata['pendallocation']}}</td>
                                         <td>{{$reportdata['pendingfromediting']}}</td>
                                         <td>{{$reportdata['qcpending']}}</td>
                                    </tr>
                                 </tbody>
                             </table>

            </div>
        </div>
</br>

            <p>Thank You</p>
        </div>

    </div>
</br>
</br>
</body>
<footer> <div> <p style="text-align:center ;font-size:9px;"  >@noreply, Do not reply to this email, it's system-generated
</p> </div> 
</footer>
</html>
