
@extends('layouts.admin')
@section('title')
Daily Usage Report
@endsection
@section('content')

<style type="text/css">
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
</style>
<div class="container-fluid mt-2">
   
        <div class="row">
            <div class="col-12">
                <div class="data-all-table">
                    <div class="card card-transparent">
                        <div class="card-header">
                            <h3 class="table-card-title">Date - {{dateFormat($date)}} </h3>
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
                                        <td>{{$brand}}</td>
                                        <td width="10px">{{$brandtouser}}</td>
                                        <td>{{$com}}</td>
                                        <td>{{$lots}}</td>
                                        <td>{{$wrc}}</td>
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
                                        <td>{{$acceptance}}</td>
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
                                        <td>{{$skus}}</td>
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
                                        <td>{{$plan}}</td>
                                        <td>{{$planwrc}}</td>
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
                                        <td>{{$rawimg}}</td>
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
                                        <td>{{$editorallocated}}</td>
                                        <td>{{$editorSubmission}}</td>
                                        <td>{{$qc}}</td>
                                        
                                    </tr>
                                   
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection