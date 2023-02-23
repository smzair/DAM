<style>

    .no-border-table * {
        border: 0;
    }

    .no-border-table {
        margin: 0;
    }

</style>  

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card-body table-responsive p-0">
                <table class="table text-nowrap">
                  <thead>
                    <tr>
                      <th>Heads</th>
                      <th>Opening Balance</th>
                      <th>Monday</th>
                      <th>Tuesday</th>
                      <th>Wednesday</th>
                      <th>Thursday</th>
                      <th>Friday</th>
                      <th>Saturday</th>
                  </tr>
                  <tr>
                    <td>Departments</td>
                    <td colspan="7" style="text-align: center">Account Management</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                  <td>
                   <table class="table no-border-table">
                       <tbody>
                           <tr><td>Total LOT's in system</td></tr>
                           <tr><td>Total WRCs</td></tr>
                           <tr><td>Total WRCs submitted</td></tr>
                           <tr><td>Last WRCs submitted on</td></tr>
                       </tbody>
                   </table>
               </td>
               <td>
                <table class="table no-border-table">
                    <tbody>
                        <tr>
                          <td>5</td>
                      </tr>
                      <tr>
                          <td>7</td>
                      </tr>
                      <tr>
                          <td>7</td>
                      </tr>
                      <tr>
                          <td>7</td>
                      </tr>
                  </tbody>
              </table>
          </td>
          <!-- Loop Start with this td  -->

          @foreach($data['wrcdata'] as $wrcdata)
          <td>
              <table class="table no-border-table">
                <tbody>
                   
                    <tr>
                        <td>{{$wrcdata->lotexist}}

                            @if($wrcdata->compareLots > 0)
                            <a href="odnconnect.odndigital.com/repLot/{{dateFormat($wrcdata->created_at)}}"> <span style="color:green">{{$wrcdata->compareLots}} &#8593; </span></a>
                            @else
                            <a href="odnconnect.odndigital.com/repLot/{{dateFormat($wrcdata->created_at)}}"> <span style="color:red"> {{$wrcdata->compareLots}} &#8595;</span> </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>{{$wrcdata->wrcexist}}

                            @if($wrcdata->comparewrcs > 0)
                            <a href="odnconnect.odndigital.com/repWrc/{{$wrcdata->created_at}}"> <span style="color:green"> {{$wrcdata->comparewrcs}} &#8593;</span>
                                @else
                                <a href="odnconnect.odndigital.com/repWrc/{{$wrcdata->created_at}}"> <span style="color:red"> {{$wrcdata->comparewrcs}} &#8595;</span> 
                                    @endif

                                </td>
                            </tr>
                            <tr>
                                <td>{{$wrcdata->submission}}
                                    @if($wrcdata->comparesubmission > 0)
                                    <a href="odnconnect.odndigital.com/comparesubmission/{{$wrcdata->created_at}}"><span style="color:green">{{$wrcdata->comparesubmission}} &#8593; </span></a> 
                                    @else
                                    <a href="odnconnect.odndigital.com/comparesubmission/{{$wrcdata->created_at}}"><span style="color:red">{{$wrcdata->comparesubmission}} &#8595;</span> </a>
                                    @endif

                                </td>

                            </tr>
                            <tr>
                                <td>{{dateFormat($wrcdata->sdate)}} </td>
                            </tr>
                        </tbody>
                    </table>
                </td>@endforeach
            </tr>



            <tr>
                <td>Departments</td>
                <td colspan="7" style="text-align: center">Opeartions</td>
            </tr>
            <tr>
                <td>
                   <table class="table no-border-table">
                       <tbody>
                        <tr><td>SKUs planned</td></tr>
                        <tr><td>SKUs not planned</td></tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table class="table no-border-table">
                    <tbody>
                        <tr>
                          <td>5</td>
                      </tr>
                      <tr>
                          <td>7</td>
                      </tr>
                  </tbody>
              </table>
          </td>
          <!-- Loop Start With This TD -->
          @foreach($data['wrcdata'] as $wrcdata)

          <td>
            <table class="table no-border-table">
                <tbody>
                  
                    <tr>
                        <td>{{$wrcdata->plannedskus}}

                            @if($wrcdata->compareplannedskus > 0)
                            <a href="odnconnect.odndigital.com/plannedSku/{{$wrcdata->created_at}}"> <span style="color:green">&#8593;{{$wrcdata->compareplannedskus}}</span> </a>
                            @else
                            <a href="odnconnect.odndigital.com/plannedSku/{{$wrcdata->created_at}}"> <span style="color:red">&#8595; {{$wrcdata->compareplannedskus}}</span> </a>
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <td>{{$wrcdata->pendingsku}}

                            @if($wrcdata->comparependingsku < 0)
                            <a href="odnconnect.odndigital.com/planpendingSku/{{$wrcdata->created_at}}"> <span style="color:green">&#8593;{{$wrcdata->comparependingsku}}</span> </a>
                            @else
                            <a href="odnconnect.odndigital.com/planpendingSku/{{$wrcdata->created_at}}"> <span style="color:red">&#8595;{{$wrcdata->comparependingsku}}
                            </span> </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>@endforeach
    </tr>
    <tr>
        <td>Departments</td>
        <td colspan="7" style="text-align: center">Studio</td>
    </tr>
    <tr>
       <td>
        <table class="table no-border-table">
           <tbody>
            <tr><td>Planned SKUs shoot not done</td></tr>
            <tr><td>SKUs shoot done</td></tr>
        </tbody>
    </table>
</td>
<td>
  <table class="table no-border-table">
    <tbody>
        <tr>
          <td>5</td>
      </tr>
      <tr>
          <td>7</td>
      </tr>
  </tbody>
</table>
</td>
<!-- Loop Start With This TD -->
@foreach($data['wrcdata'] as $wrcdata)
<td>
    <table class="table no-border-table">
        <tbody>
            
            <tr>
                <td>{{$wrcdata->uploadrawpending}}
                    @if($wrcdata->compareuploadrawpending < 0)
                    <a href="odnconnect.odndigital.com/uploadrawpending/{{$wrcdata->created_at}}"><span style="color:green">&#8593;{{$wrcdata->compareuploadrawpending}}</span> </a>
                    @else
                    <a href="odnconnect.odndigital.com/uploadrawpending/{{$wrcdata->created_at}}"><span style="color:red">&#8595; {{$wrcdata->compareuploadrawpending}}</span> </a>
                    @endif
                </td>
            </tr>
            <tr>
                <td>{{$wrcdata->shootdone}}
                    @if($wrcdata->compareshootdone > 0)
                    <a href="odnconnect.odndigital.com/shootdone/{{$wrcdata->created_at}}"><span style="color:green">&#8593; {{$wrcdata->compareshootdone}}</span> </a>
                    @else
                    <a href="odnconnect.odndigital.com/shootdone/{{$wrcdata->created_at}}"><span style="color:red">&#8595; {{$wrcdata->compareshootdone}}</span> </a>
                    @endif

                </td>@endforeach
            </tr>
        </tbody>
    </table>
</tr>
<tr>
    <td>Departments</td>
    <td colspan="7" style="text-align: center">Editing</td>
</tr>
<tr>
   <td>
    <table class="table no-border-table">
       <tbody>
        <tr><td>Images pending for allocation</td></tr>
        <tr><td>Images editing done</td></tr>
        <tr><td>SKU's pending for qc</td></tr>
    </tbody>
</table>
</td>
<td>
    <table class="table no-border-table">
        <tbody>
            <tr>
              <td>5</td>
          </tr>
          <tr>
              <td>7</td>
          </tr>
          <tr>
              <td>7</td>
          </tr>
      </tbody>
  </table>
</td>
<!-- Loop Start With This TD -->
@foreach($data['wrcdata'] as $wrcdata)
<td>
    <table class="table no-border-table">
        <tbody>
          
            <tr>
                <td>{{$wrcdata->pendallocation}}

                    @if($wrcdata->comparependallocation < 0)
                    <a href="odnconnect.odndigital.com/pendingallo/{{$wrcdata->created_at}}"><span style="color:green">&#8593; {{$wrcdata->comparependallocation}}</span> </a>
                    @else
                    <a href="odnconnect.odndigital.com/pendingallo/{{$wrcdata->created_at}}"><span style="color:red">&#8595; {{$wrcdata->comparependallocation}}</span> </a>
                    @endif
                </td>
            </tr>
            <tr>
                <td>{{$wrcdata->editingcomplete}} 
                    @if($wrcdata->compareeditingcomplete > 0)
                    <a href="odnconnect.odndigital.com/editingcomplete/{{$wrcdata->created_at}}"><span style="color:green">{{$wrcdata->compareeditingcomplete}} &#8593;</span> </a>
                    @else
                    <a href="odnconnect.odndigital.com/editingcomplete/{{$wrcdata->created_at}}"><span style="color:red">{{$wrcdata->compareeditingcomplete}} &#8595;</span> </a>
                    @endif
                </td>
            </tr>

            <tr>
                <td>{{$wrcdata->qcpending}}
                    @if($wrcdata->compareqcpending < 0)
                    <a href="odnconnect.odndigital.com/compareqcpending/{{$wrcdata->created_at}}"><span style="color:green">{{$wrcdata->compareqcpending}} &#8593;</span></a>
                    @else
                    <a href="odnconnect.odndigital.com/compareqcpending/{{$wrcdata->created_at}}"><span style="color:red">{{$wrcdata->compareqcpending}} &#8595;</span></a>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</td>@endforeach
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>